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

        return redirect('/tracking')->with('success', 'Procurement project saved successfully!');


    }


    // VIEW 
    public function records(Request $request)
    {
        // $projects =  ProcurementProject::orderBy('created_at', 'desc')->get();

        $selectedProject = null;
        if ($request->has('selected_id')) {
            $selectedProject = ProcurementProject::find($request->selected_id);
        }

        $editProject = null;
        if ($request->has('edit_id')) {  
            $editProject = ProcurementProject::find($request->edit_id);
        }

        return view('pages.tracking', compact('selectedProject', 'editProject', ));
        // return view('pages.tracking', compact('projects', 'selectedProject', 'editProject', ));
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




    public function dashboard()
    {
        $totalCount = ProcurementProject::count(); 
        return view('pages.dashboard', compact('totalCount'));
    }




    
}
