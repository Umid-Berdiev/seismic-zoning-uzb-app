<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoilSalinityPointer extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'value',
        'degree',
        'area'
    ];
}
