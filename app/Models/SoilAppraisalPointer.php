<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoilAppraisalPointer extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'value',
        'ball_range',
        'area'
    ];
}
