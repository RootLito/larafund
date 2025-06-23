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


        // \DB::enableQueryLog();
        // $procurementProject->update($validated);
        // dd(\DB::getQueryLog());


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

        $pendingProjectsDetails = ProcurementProject::select(
            'procurement_project',
            'pr_number',
            'date_received_from_planning',
            'date_received_by_twg',
            'approved_pr_received'
        )
            ->where('status', 'Pending')
            ->orderBy('created_at', 'desc')
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
            'pendingProjectsDetails' => $pendingProjectsDetails,
        ]);
    }


    public function calendar()
    {
        $events = collect();

        $projects = ProcurementProject::all();

        foreach ($projects as $project) {
            $getDates = fn($field) => collect(json_decode($project->$field ?? '[]', true))
                ->filter(fn($d) => !is_null($d) && $d !== '')
                ->values();

            foreach ($getDates('philgeps_advertisement') as $date) {
                $events->push([
                    'title' => $project->procurement_project,
                    'start' => $date,
                    'color' => '#3182ce',
                    'extendedProps' => [
                        'end_user' => $project->end_user,
                        'total_abc' => $project->total_abc,
                        'event_type' => 'PhilGEPS Advertisement',
                        'event_date' => $date,
                    ],
                ]);
            }

            foreach ($getDates('pre_bid_conference') as $date) {
                $events->push([
                    'title' => $project->procurement_project,
                    'start' => $date,
                    'color' => '#48bb78',
                    'extendedProps' => [
                        'end_user' => $project->end_user,
                        'total_abc' => $project->total_abc,
                        'event_type' => 'Pre-Bid Conference',
                        'event_date' => $date,
                    ],
                ]);
            }

            foreach ($getDates('bid_opening') as $date) {
                $events->push([
                    'title' => $project->procurement_project,
                    'start' => $date,
                    'color' => '#ecc94b',
                    'extendedProps' => [
                        'end_user' => $project->end_user,
                        'total_abc' => $project->total_abc,
                        'event_type' => 'Bid Opening',
                        'event_date' => $date,
                    ],
                ]);
            }

            foreach ($getDates('post_qualification') as $date) {
                $events->push([
                    'title' => $project->procurement_project,
                    'start' => $date,
                    'color' => '#f56565',
                    'extendedProps' => [
                        'end_user' => $project->end_user,
                        'total_abc' => $project->total_abc,
                        'event_type' => 'Post-Qua Report Presentation',
                        'event_date' => $date,
                    ],
                ]);
            }
        }

        return view('pages.calendar', ['events' => $events->values()]);
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








}
