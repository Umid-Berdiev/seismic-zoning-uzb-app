<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoilMineralStructurePointer extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'value',
        'mechanical_structure',
        'area'
    ];
}
