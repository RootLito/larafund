<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementProject extends Model
{
     use HasFactory;

    protected $table = 'procurement_projects'; 

    protected $fillable = [
        'status',
        'procurement_project',
        'lot_description',
        'abc_per_lot',
        'total_abc',
        'end_user',
        'pr_number',
        'approved_app',
        'date_received_from_planning',
        'date_received_by_twg',
        'twg',
        'date_forwarded_to_budget',
        'approved_pr_received',
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

}
