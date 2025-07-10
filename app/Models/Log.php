<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'user_name',
        'model_name',
        'changed_fields',
        'procurement_project',
        'lot_description',
    ];


}
