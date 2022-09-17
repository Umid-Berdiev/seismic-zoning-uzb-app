<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroundwaterDataLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'comment',
    ];
}
