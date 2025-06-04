<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProcurementProject;

class TrackingController extends Controller
{


    
    // NEW 
    public function newpr(Request $request)
    {
        $in = $request->validate([
            'procurement_project' => ['required', 'min:5'],
            'lot_description' => ['required', 'min:1'],
            'abc_per_lot' => ['required', 'min:1'],
            'end_user' => ['required', 'min:3', 'max:50'],
            'total_abc' => ['required', 'min:3', 'max:50'],
        ]);

        $in['status'] = 'Pending';

        $in['lot_description'] = json_encode($in['lot_description']);
        $in['abc_per_lot'] = json_encode($in['abc_per_lot']);

        ProcurementProject::create($in);

        return redirect('/tracking')->with('success', 'Procurement project created successfully!');


    }


    // VIEW 
    public function records(Request $request)
    {
        $projects =  ProcurementProject::orderBy('created_at', 'desc')->get();

        $selectedProject = null;
        if ($request->has('selected_id')) {
            $selectedProject = ProcurementProject::find($request->selected_id);
        }

        $editProject = null;
        if ($request->has('edit_id')) {  
            $editProject = ProcurementProject::find($request->edit_id);
        }

        // $project = null;
        // if ($request->has('edit_id')) {
        //     $project = ProcurementProject::find($request->edit_id); 
        // }


        // dd($request->edit_id, $editProject);

        return view('pages.tracking', compact('projects', 'selectedProject', 'editProject', ));
    }






    // UPDATE
    public function update(Request $request, $id)
    {
        $procurementProject = ProcurementProject::findOrFail($id);

        $validated = $request->validate([
            'status' => 'nullable|string', 
            'procurement_project' => 'nullable|string',
            'lot_description' => 'nullable|array|min:1', 
            'abc_per_lot' => 'nullable|array|min:1', 
            'total_abc' => 'nullable|numeric|min:0', 
            'end_user' => 'nullable|string', 
            'pr_number' => 'nullable|string',
            'approved_app' => 'nullable|string',
            'date_received_from_planning' => 'nullable|date',
            'date_received_by_twg' => 'nullable|date',
            'twg' => 'nullable|string',
            'date_forwarded_to_budget' => 'nullable|date',
            'approved_pr_received' => 'nullable|date',
            'philgeps_posting_date' => 'nullable|date',
            'rfq_itb_number' => 'nullable|string',
            'bid_opening' => 'nullable|date',
            'sq_number' => 'nullable|string',
            'bac_res_number' => 'nullable|string',
            'date_of_bac_res_completely_signed' => 'nullable|date',
            'noa_number' => 'nullable|string',
            'canvasser' => 'nullable|string',
            'name_of_supplier' => 'nullable|string',
            'contract_price' => 'nullable|numeric|min:0',
            'date_forwarded_to_gss' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

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




    public function dashboard()
    {
        $totalCount = ProcurementProject::count(); 
        return view('pages.dashboard', compact('totalCount'));
    }
}
