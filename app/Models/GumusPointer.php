<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GumusPointer extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'value',
        'humus_amount',
        'area'
    ];
}
