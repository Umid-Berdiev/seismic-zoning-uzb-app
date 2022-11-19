<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OsrSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'accuracy',
        'soato',
        'details'
    ];
}
