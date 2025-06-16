<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ProcurementProject;
use Illuminate\Support\Facades\DB;

class TrackingController extends Controller
{
    
    // NEW 
    public function newpr(Request $request)
    {
        $in = $request->validate([
            'procurement_project' => ['required', 'min:5'],
            'mode_of_procurement' => ['required', 'min:5'],
            'custom_mode' => ['nullable', 'string', 'min:3'],
            'lot_description' => ['required', 'min:1'],
            'abc_per_lot' => ['required', 'min:1'],
            'end_user' => ['required', 'min:3', 'max:50'],
            'total_abc' => ['required', 'min:3', 'max:50'],
        ]);
        if ($in['mode_of_procurement'] === 'others' && !empty($in['custom_mode'])) {
            $in['mode_of_procurement'] = $in['custom_mode'];
        }
        unset($in['custom_mode']); 
        $in['status'] = 'Pending';
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
            'status' => 'nullable|string', 
            'procurement_project' => 'nullable|string',
            'mode_of_procurement' => 'nullable|string',
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
            'philgeps_posting_date' => 'nullable|array',
            'rfq_itb_number' => 'nullable|array',
            'bid_opening' => 'nullable|array',
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
            'lot_description',
            'abc_per_lot',
            'philgeps_posting_date',
            'rfq_itb_number',
            'bid_opening',
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
    public function delete($id)
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
            $statusCounts[] = ProcurementProject::where('status', $status)->count();
        }
        $totalCount = array_sum($statusCounts);
        $publicBiddingCount = ProcurementProject::where('mode_of_procurement', 'Public Bidding')->count();
        $directContractingCount = ProcurementProject::where('mode_of_procurement', 'Direct Contracting')->count();
        $smallValueProcurementCount = ProcurementProject::where('mode_of_procurement', 'Small Value Procurement')->count();
        $emergencyCasesCount = ProcurementProject::where('mode_of_procurement', 'Emergency Cases')->count();
        $totalAmount = ProcurementProject::sum('total_abc');
        $prAbove50kCount = ProcurementProject::where('total_abc', '>', 50000)->count();
        $prBelow50kCount = ProcurementProject::where('total_abc', '<=', 50000)->count();
        $othersCount = ProcurementProject::where(function ($query) {
            $query->whereNull('mode_of_procurement')
                ->orWhere('mode_of_procurement', '')
                ->orWhereNotIn('mode_of_procurement', [
                    'Public Bidding',
                    'Direct Contracting',
                    'Small Value Procurement',
                    'Emergency Cases',
                ]);
        })->count();
        $othersGrouped = ProcurementProject::select('mode_of_procurement', DB::raw('count(*) as total'))
            ->whereNotIn('mode_of_procurement', [
                    'Public Bidding',
                    'Direct Contracting',
                    'Small Value Procurement',
                    'Emergency Cases',
                ])
            ->whereNotNull('mode_of_procurement')
            ->where('mode_of_procurement', '<>', '')
            ->groupBy('mode_of_procurement')
            ->get();
        $endUserGrouped = ProcurementProject::select('end_user', DB::raw('SUM(total_abc) as total'))
        ->whereNotNull('end_user')
        ->where('end_user', '<>', '')
        ->groupBy('end_user')
        ->get();


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
        ]);



    }


    // CALENDAR
    public function calendar()
    {
        $events = ProcurementProject::all()
        ->filter(function ($project) {
            $dates = json_decode($project->bid_opening, true);
            return is_array($dates) && collect($dates)->contains(fn($d) => !is_null($d));
        })
        ->map(function ($project) {
            $bidOpening = json_decode($project->bid_opening, true);
            $validDate = collect($bidOpening)->first(fn($d) => !is_null($d));

            return [
                'title' => $project->procurement_project,
                'start' => $validDate,
                'extendedProps' => [
                    'end_user' => $project->end_user,
                    'total_abc' => $project->total_abc,
                    'bid_opening' => $validDate,
                ],
            ];
        })
        ->values(); 

        return view('pages.calendar', compact('events'));
    }
}
