<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\TrackingController;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProcurementProject extends Model
{
     use HasFactory;

    protected $table = 'procurement_projects'; 

    protected $fillable = [
        'status',
        'procurement_project',
        'mode_of_procurement',
        'bid_status',
        'custom_mode',
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

    protected static function booted()
{
    static::updated(function ($project) {
        app(TrackingController::class)->captureUpdate($project);
    });
}

}
