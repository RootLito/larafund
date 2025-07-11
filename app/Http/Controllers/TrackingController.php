<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\ProcurementProject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{

    // NEW 
    public function newpr(Request $request)
    {
        $in = $request->validate([
            'procurement_project' => ['required', 'min:5'],
            'mode_of_procurement' => ['required', 'min:1'],
            'custom_mode' => ['nullable', 'min:1'],
            'lot_description' => ['required', 'min:1'],
            'abc_per_lot' => ['required', 'min:1'],
            'end_user' => ['required', 'min:3', 'max:50'],
            'total_abc' => ['required', 'min:3', 'max:50'],
        ]);
        if ($in['mode_of_procurement'] === 'others' && !empty($in['custom_mode'])) {
            $in['mode_of_procurement'] = $in['custom_mode'];
        }
        unset($in['custom_mode']);
        $lotsCount = count($in['mode_of_procurement']);

        $statuses = array_fill(0, $lotsCount, 'Pending');

        $in['status'] = json_encode($statuses);
        $in['mode_of_procurement'] = json_encode($in['mode_of_procurement']);
        $in['lot_description'] = json_encode($in['lot_description']);
        $in['abc_per_lot'] = json_encode($in['abc_per_lot']);
        ProcurementProject::create($in);
        return redirect('/tracking')->with('success', 'Procurement project saved successfully!');
    }


    // VIEW 
    public function records(Request $request)
    {
        $selectedProject = null;
        if ($request->has('selected_id')) {
            $selectedProject = ProcurementProject::find($request->selected_id);
        }
        $editProject = null;
        if ($request->has('edit_id')) {
            $editProject = ProcurementProject::find($request->edit_id);
        }

        if ($selectedProject) {
            return view('pages.action.view', compact('selectedProject'));
        }

        if ($editProject) {
            return view('pages.action.edit', compact('editProject'));
        }

        return view('pages.tracking', compact('selectedProject', 'editProject', ));
    }







    // UPDATE
    public function update(Request $request, $id)
    {
        $procurementProject = ProcurementProject::findOrFail($id);

        $request->merge(array_map(function ($value) {
            return $value === '' ? null : $value;
        }, $request->all()));

        $validated = $request->validate([
            'status' => 'nullable|array',
            'mode_of_procurement' => 'nullable|array',
            'bid_status' => 'nullable|array',




            'procurement_project' => 'nullable|string',
            'lot_description' => 'nullable|array|min:1',
            'abc_per_lot' => 'nullable|array|min:1',
            'total_abc' => 'nullable|numeric',
            'end_user' => 'nullable|string',
            'pr_number' => 'nullable|string',
            'approved_app' => 'nullable|string',
            'date_received_from_planning' => 'nullable|date',
            'date_received_by_twg' => 'nullable|date',
            'twg' => 'nullable|string',
            'date_forwarded_to_budget' => 'nullable|date',
            'approved_pr_received' => 'nullable|date',

            'philgeps_advertisement' => 'nullable|array',
            'philgeps_posting_date' => 'nullable|array',
            'rfq_itb_number' => 'nullable|array',
            'pre_bid_conference' => 'nullable|array',
            'bid_opening' => 'nullable|array',
            'post_qualification' => 'nullable|array',

            'sq_number' => 'nullable|array',
            'bac_res_number' => 'nullable|array',
            'date_of_bac_res_completely_signed' => 'nullable|array',
            'noa_number' => 'nullable|array',
            'canvasser' => 'nullable|array',
            'name_of_supplier' => 'nullable|array',
            'contract_price' => 'nullable|array',
            'date_forwarded_to_gss' => 'nullable|array',
            'remarks' => 'nullable|array',
        ]);


        // JSON encode fields
        $fieldsToEncode = [
            'status',
            'mode_of_procurement',
            'bid_status',

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
        foreach ($fieldsToEncode as $field) {
            if (isset($validated[$field])) {
                $validated[$field] = json_encode($validated[$field]);
            }
        }
        $procurementProject->update($validated);
        return redirect('/tracking')->with('success', 'Procurement project updated successfully!');
    }



    // DELETE
    public function viewProject(Request $request)
    {
        if ($request->has('selected_id')) {
            $selectedProject = ProcurementProject::find($request->selected_id);
            return view('pages.action.view', compact('selectedProject'));
        }
        return redirect()->route('tracking')->with('error', 'Project not found.');
    }

    public function editProject(Request $request)
    {
        if ($request->has('edit_id')) {
            $editProject = ProcurementProject::find($request->edit_id);
            return view('pages.action.edit', compact('editProject'));
        }

        return redirect()->route('tracking')->with('error', 'Project not found.');
    }
    public function destroy($id)
    {
        $project = ProcurementProject::findOrFail($id);
        $project->delete();

        return redirect('/tracking')->with('success', 'Procurement project deleted successfully!');
    }








    // DASHBOARD
    public function dashboard()
    {
        $statuses = ['Pending', 'Completed', 'In Progress', 'Reimbursement', 'Cancelled'];
        $statusCounts = [];
        foreach ($statuses as $status) {
            $statusCounts[] = ProcurementProject::whereJsonContains('status', $status)->count();
        }

        $totalCount = ProcurementProject::count();

        $publicBiddingCount = ProcurementProject::whereJsonContains('mode_of_procurement', 'Public Bidding')->count();
        $directContractingCount = ProcurementProject::whereJsonContains('mode_of_procurement', 'Direct Contracting')->count();
        $smallValueProcurementCount = ProcurementProject::whereJsonContains('mode_of_procurement', 'Small Value Procurement')->count();
        $emergencyCasesCount = ProcurementProject::whereJsonContains('mode_of_procurement', 'Emergency Cases')->count();

        $totalAmount = ProcurementProject::sum('total_abc');

        $prAbove50kCount = ProcurementProject::where('total_abc', '>', 50000)->count();
        $prBelow50kCount = ProcurementProject::where('total_abc', '<=', 50000)->count();

        $othersCount = ProcurementProject::where(function ($query) {
            $query->whereNull('mode_of_procurement')
                ->orWhere('mode_of_procurement', '')
                ->orWhere(function ($subQuery) {
                    $subQuery->whereRaw('NOT JSON_CONTAINS(mode_of_procurement, ?)', ['"Public Bidding"'])
                        ->whereRaw('NOT JSON_CONTAINS(mode_of_procurement, ?)', ['"Direct Contracting"'])
                        ->whereRaw('NOT JSON_CONTAINS(mode_of_procurement, ?)', ['"Small Value Procurement"'])
                        ->whereRaw('NOT JSON_CONTAINS(mode_of_procurement, ?)', ['"Emergency Cases"']);
                });
        })->count();

        $othersGrouped = ProcurementProject::select('mode_of_procurement', DB::raw('count(*) as total'))
            ->whereNotNull('mode_of_procurement')
            ->where('mode_of_procurement', '<>', '')
            ->whereRaw('
        NOT JSON_CONTAINS(mode_of_procurement, ?)
        AND NOT JSON_CONTAINS(mode_of_procurement, ?)
        AND NOT JSON_CONTAINS(mode_of_procurement, ?)
        AND NOT JSON_CONTAINS(mode_of_procurement, ?)
    ', [
                '"Public Bidding"',
                '"Direct Contracting"',
                '"Small Value Procurement"',
                '"Emergency Cases"'
            ])
            ->groupBy('mode_of_procurement')
            ->get();


        $endUserGrouped = ProcurementProject::select('end_user', DB::raw('SUM(total_abc) as total'))
            ->whereNotNull('end_user')
            ->where('end_user', '<>', '')
            ->groupBy('end_user')
            ->get();

        $pendingProjectsDetails = ProcurementProject::select(
            'procurement_project',
            'pr_number',
            'date_received_from_planning',
            'date_received_by_twg',
            'approved_pr_received'
        )
            ->where('status', 'Pending')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($project) {
                $project->date_received_from_planning = json_decode($project->date_received_from_planning, true) ?: [];
                $project->date_received_by_twg = json_decode($project->date_received_by_twg, true) ?: [];
                $project->approved_pr_received = json_decode($project->approved_pr_received, true) ?: [];

                $project->date_received_from_planning_status = count($project->date_received_from_planning) > 0;
                $project->date_received_by_twg_status = count($project->date_received_by_twg) > 0;
                $project->approved_pr_received_status = count($project->approved_pr_received) > 0;

                return $project;
            });





        $pendingProjects = ProcurementProject::whereJsonContains('status', 'Pending')->get();
        $pendingProjectsDetails = $pendingProjects->map(function ($project) {
            return [
                'procurement_project' => $project->procurement_project,
                'pr_number' => $project->pr_number,
                'lot_description' => json_decode($project->lot_description, true) ?: [],
                'date_received_from_planning' => $project->date_received_from_planning,
                'date_received_by_twg' => $project->date_received_by_twg,
                'approved_pr_received' => $project->approved_pr_received,
            ];
        });



        return view('pages.dashboard', [
            'totalCount' => $totalCount,
            'statusLabels' => $statuses,
            'statusData' => $statusCounts,
            'publicBiddingCount' => $publicBiddingCount,
            'directContractingCount' => $directContractingCount,
            'smallValueProcurementCount' => $smallValueProcurementCount,
            'emergencyCasesCount' => $emergencyCasesCount,
            'othersCount' => $othersCount,
            'othersGrouped' => $othersGrouped,
            'totalAmount' => $totalAmount,
            'prAbove50kCount' => $prAbove50kCount,
            'prBelow50kCount' => $prBelow50kCount,
            'endUserGrouped' => $endUserGrouped,
            'pendingProjectsDetails' => $pendingProjectsDetails,
        ]);
    }

    public function reminders()
    {
        $today = Carbon::today();
        $inSevenDays = $today->copy()->addDays(7);
        $reminders = collect();
        foreach (ProcurementProject::all() as $project) {
            $dates = json_decode($project->post_qualification, true) ?: [];
            $lotDescriptions = json_decode($project->lot_description, true) ?: [];

            foreach ($dates as $index => $date) {
                if ($date && Carbon::parse($date)->between($today, $inSevenDays)) {
                    $reminders->push([
                        'id' => $project->id,
                        'project' => $project->procurement_project,
                        'date' => Carbon::parse($date)->format('F j, Y'),
                        'lot_description' => $lotDescriptions[$index] ?? 'No Description',
                    ]);
                }
            }
        }

        return view('pages.post-qua', [
            'upcomingReminders' => $reminders->sortBy('date')->values(),
        ]);
    }






    public function calendar()
    {
        $events = $this->getProcurementEvents();
        return view('pages.calendar', ['events' => $events]);
    }

    public function main()
    {
        $events = $this->getProcurementEvents();
        return view('main', ['events' => $events]);
    }

    private function getProcurementEvents()
    {
        $events = collect();
        $projects = ProcurementProject::all();

        foreach ($projects as $project) {
            $getDates = fn($field) => collect(json_decode($project->$field ?? '[]', true))
                ->filter(fn($d) => !is_null($d) && $d !== '')
                ->values();


            $bidStatuses = json_decode($project->bid_status ?? '[]', true);
            $remarks = json_decode($project->remarks ?? '[]', true);
            $lotDescriptions = json_decode($project->lot_description ?? '[]', true);

            $lots = [];
            $count = max(count($bidStatuses), count($remarks), count($lotDescriptions));
            for ($i = 0; $i < $count; $i++) {
                $lots[] = [
                    'lot_name' => $lotDescriptions[$i] ?? '',
                    'bid_status' => $bidStatuses[$i] ?? '',
                    'remarks' => $remarks[$i] ?? '',
                ];
            }




            foreach ([
                'philgeps_advertisement' => ['#3182ce', 'PhilGEPS Advertisement'],
                'pre_bid_conference' => ['#48bb78', 'Pre-Bid Conference'],
                'bid_opening' => ['#ecc94b', 'Bid Opening'],
                'post_qualification' => ['#f56565', 'Post-Qua Report Presentation']
            ] as $field => [$color, $eventType]) {
                foreach ($getDates($field) as $date) {
                    $events->push([
                        'title' => $project->procurement_project,
                        'start' => $date,
                        'color' => $color,
                        'extendedProps' => [
                            'end_user' => $project->end_user,
                            'total_abc' => $project->total_abc,
                            'event_type' => $eventType,
                            'event_date' => $date,
                            'lots' => $lots,
                        ],
                    ]);
                }
            }
        }

        return $events->values();
    }

    public function search(Request $request)
    {
        $query = ProcurementProject::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('pr_number', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('procurement_project', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('end_user', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('mode') && $request->mode != '') {
            $query->where('mode_of_procurement', $request->mode);
        }

        $projects = $query->latest()->paginate(10);

        return response()->json([
            'data' => $projects->items(),
            'links' => (string) $projects->links(),
        ]);
    }





    public function captureUpdate($project)
    {
        $userName = Auth::user()?->name ?? 'System';

        $changes = [];

        foreach ($project->getChanges() as $field => $newValue) {
            if ($field === 'updated_at')
                continue;

            $oldValue = $project->getOriginal($field);

            $oldDecoded = json_decode($oldValue, true);
            $newDecoded = json_decode($newValue, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                if ($oldDecoded === $newDecoded) {
                    continue;
                }
            } else {
                if (trim($oldValue) === trim($newValue)) {
                    continue;
                }
            }

            $changes[$field] = ['old' => $oldValue, 'new' => $newValue];
        }


        if (empty($changes)) {
            return;
        }

        $procurementProject = $project->procurement_project ?? '';
        if (isset($changes['procurement_project'])) {
            $procurementProject = $changes['procurement_project']['new'];
            unset($changes['procurement_project']);
        }

        $lotDescription = '';
        if (isset($changes['lot_description'])) {
            $decodedLots = json_decode($changes['lot_description']['new'], true);
            $lotDescription = is_array($decodedLots) ? implode(', ', $decodedLots) : $changes['lot_description']['new'];
            unset($changes['lot_description']);
        } elseif ($project->lot_description) {
            $decodedLots = is_array($project->lot_description)
                ? $project->lot_description
                : json_decode($project->lot_description, true);
            $lotDescription = is_array($decodedLots) ? implode(', ', $decodedLots) : '';
        }

        $changesText = "";
        foreach ($changes as $field => $vals) {
            $oldVal = $vals['old'];
            $newVal = $vals['new'];

            $decodedOld = json_decode($oldVal, true);
            $decodedNew = json_decode($newVal, true);

            $oldDisplay = is_array($decodedOld) ? implode(', ', $decodedOld) : (string) $oldVal;
            $newDisplay = is_array($decodedNew) ? implode(', ', $decodedNew) : (string) $newVal;

            $changesText .= "- $field: '$oldDisplay' → '$newDisplay'\n";
        }

        Log::create([
            'user_name' => $userName,
            'changed_fields' => trim($changesText),
            'procurement_project' => $procurementProject,
            'lot_description' => $lotDescription,
        ]);
    }


    public function filteredLogs(Request $request)
    {
        $filter = $request->input('filter_date', 'today');

        $logsQuery = Log::query();

        switch ($filter) {
            case 'today':
                $logsQuery->whereDate('created_at', now()->toDateString());
                break;
            case 'yesterday':
                $logsQuery->whereDate('created_at', now()->subDay()->toDateString());
                break;
            case 'last_week':
                $logsQuery->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
                break;
            case 'all':
            default:
                break;
        }

        $logs = $logsQuery->orderBy('created_at', 'desc')->paginate(5);

        return view('pages.logs', compact('logs', 'filter'));
    }


}
