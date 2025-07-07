<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProcurementProject;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ProcurementTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public string $mode = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }




    public function render()
    {
        $projects = ProcurementProject::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('pr_number', 'like', "%{$this->search}%")
                        ->orWhere('procurement_project', 'like', "%{$this->search}%")
                        ->orWhere('end_user', 'like', "%{$this->search}%");
                });
            })
            ->when($this->status, function ($query) {
                if (is_array($this->status)) {
                    $query->where(function ($q) {
                        foreach ($this->status as $status) {
                            $q->orWhereJsonContains('status', $status);
                        }
                    });
                } else {
                    $query->whereJsonContains('status', $this->status);
                }
            })
            ->when($this->mode, function ($query) {
                if ($this->mode === 'others') {
                    $query->where(function ($q) {
                        $q->whereNull('mode_of_procurement')
                            ->orWhere('mode_of_procurement', '')
                            ->orWhere(function ($sub) {
                                $sub->whereRaw('NOT JSON_CONTAINS(mode_of_procurement, ?)', ['"Public Bidding"'])
                                    ->whereRaw('NOT JSON_CONTAINS(mode_of_procurement, ?)', ['"Direct Contracting"'])
                                    ->whereRaw('NOT JSON_CONTAINS(mode_of_procurement, ?)', ['"Small Value Procurement"'])
                                    ->whereRaw('NOT JSON_CONTAINS(mode_of_procurement, ?)', ['"Emergency Cases"']);
                            });
                    });
                } elseif ($this->mode === 'Public Bidding') {
                    $query->whereJsonContains('mode_of_procurement', 'Public Bidding')
                        ->whereRaw("
                NOT JSON_CONTAINS(mode_of_procurement, '\"Direct Contracting\"')
                AND NOT JSON_CONTAINS(mode_of_procurement, '\"Small Value Procurement\"')
                AND NOT JSON_CONTAINS(mode_of_procurement, '\"Emergency Cases\"')
            ");
                } else {
                    $query->whereJsonContains('mode_of_procurement', $this->mode);
                }
            })

            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->onEachSide(1);


            

        return view('livewire.procurement-table', compact('projects'));


    }




    public function export()
    {
        $projects = ProcurementProject::all();

        if ($projects->isEmpty()) {
            session()->flash('error', 'No data to export.');
            return;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'Status',
            'Procurement Project',
            'Mode of Procurement',
            'Lot Description',
            'ABC per Lot',
            'Total ABC',
            'End User',
            'PR Number',
            'Approved APP',
            'Date Received from Planning',
            'Date Received by TWG',
            'TWG',
            'Date Forwarded to Budget',
            'Approved PR Received',
            'PhilGEPS Advertisement',
            'PhilGEPS Posting Date',
            'RFQ/ITB Number',
            'Pre-Bid Conference',
            'Bid Opening',
            'Post-Qua Report Presentation',
            'SQ Number',
            'BAC Res Number',
            'Date of BAC Res. Completely Signed',
            'NOA Number',
            'Canvasser',
            'Name of Supplier',
            'Contract Price',
            'Date Forwarded to GSS',
            'Remarks',
        ];

        // Set headers
        $colIndex = 1;
        foreach ($headers as $header) {
            $cell = Coordinate::stringFromColumnIndex($colIndex) . '1';
            $sheet->setCellValue($cell, $header);
            $sheet->getStyle($cell)->getFont()->setBold(true);
            $sheet->getStyle($cell)->getAlignment()->setWrapText(true);
            $sheet->getStyle($cell)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('FFFACD');
            $colIndex++;
        }

        $arrayFields = [
            'lot_description',
            'abc_per_lot',
            'philgeps_advertisement',
            'philgeps_posting_date',
            'rfq_itb_number',
            'pre_bid_conference',
            'bid_opening',
            'post_qualification',
            'sq_number',
            'bac_res_number',
            'date_of_bac_res_completely_signed',
            'noa_number',
            'canvasser',
            'name_of_supplier',
            'contract_price',
            'date_forwarded_to_gss',
            'remarks',
        ];

        $startRow = 2;
        $currentRow = $startRow;

        foreach ($projects as $project) {
            // Decode array fields
            foreach ($arrayFields as $field) {
                $project[$field] = is_string($project[$field]) ? json_decode($project[$field], true) : ($project[$field] ?? []);
            }

            $rowCount = max(array_map(fn($f) => count($project[$f] ?? []), ['lot_description', 'abc_per_lot']));
            $rowCount = $rowCount ?: 1;

            // Compute total ABC if abc_per_lot exists
            $totalAbc = array_sum(array_map('floatval', $project['abc_per_lot'] ?? []));

            // Write static columns (merged if multi-rows)
            $staticFields = [
                'status',
                'procurement_project',
                'mode_of_procurement',
            ];

            $staticData = [
                $project->status,
                $project->procurement_project,
                $project->mode_of_procurement,
            ];

            $colIndex = 1;
            foreach ($staticData as $value) {
                $cell = Coordinate::stringFromColumnIndex($colIndex) . $currentRow;
                $sheet->setCellValue($cell, $value);
                if ($rowCount > 1) {
                    $sheet->mergeCells("{$cell}:" . Coordinate::stringFromColumnIndex($colIndex) . ($currentRow + $rowCount - 1));
                }
                $colIndex++;
            }

            for ($i = 0; $i < $rowCount; $i++) {
                $ld = $project['lot_description'][$i] ?? '';
                $abc = $project['abc_per_lot'][$i] ?? '';

                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex) . ($currentRow + $i), $ld);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex + 1) . ($currentRow + $i), $abc);
            }

            $totalAbcCol = Coordinate::stringFromColumnIndex($colIndex + 2);
            $sheet->setCellValue("{$totalAbcCol}{$currentRow}", $totalAbc);
            if ($rowCount > 1) {
                $sheet->mergeCells("{$totalAbcCol}{$currentRow}:{$totalAbcCol}" . ($currentRow + $rowCount - 1));
            }

            $colIndex += 3;

            $remainingStaticFields = [
                'end_user',
                'pr_number',
                'approved_app',
                'date_received_from_planning',
                'date_received_by_twg',
                'twg',
                'date_forwarded_to_budget',
                'approved_pr_received',
            ];

            foreach ($remainingStaticFields as $field) {
                $value = $project[$field] ?? '';
                $cell = Coordinate::stringFromColumnIndex($colIndex) . $currentRow;
                $sheet->setCellValue($cell, $value);
                if ($rowCount > 1) {
                    $sheet->mergeCells("{$cell}:" . Coordinate::stringFromColumnIndex($colIndex) . ($currentRow + $rowCount - 1));
                }
                $colIndex++;
            }

            for ($i = 0; $i < $rowCount; $i++) {
                $tempCol = $colIndex;
                foreach (array_slice($arrayFields, 2) as $field) {
                    $value = $project[$field][$i] ?? '';
                    $cell = Coordinate::stringFromColumnIndex($tempCol) . ($currentRow + $i);
                    $sheet->setCellValue($cell, $value);
                    $tempCol++;
                }
            }

            $currentRow += $rowCount;
        }

        for ($col = 1; $col <= count($headers); $col++) {
            $letter = Coordinate::stringFromColumnIndex($col);
            if ($letter === 'B') {
                $sheet->getColumnDimension($letter)->setWidth(30);
                $sheet->getStyle($letter)->getAlignment()->setWrapText(true);
            } else {
                $sheet->getColumnDimension($letter)->setAutoSize(true);
            }
        }

        $sheet->getStyle('A1:' . Coordinate::stringFromColumnIndex(count($headers)) . ($currentRow - 1))
            ->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        $sheet->freezePane('I2');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'BAC PR Tracking ' . now()->format('Y') . '.xlsx';
        $filePath = storage_path("app/{$fileName}");
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

}
