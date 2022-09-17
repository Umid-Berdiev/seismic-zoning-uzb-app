<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoilMobilePhosphorusPointer extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'value',
        'mobile_phosphorus',
        'area'
    ];
}
