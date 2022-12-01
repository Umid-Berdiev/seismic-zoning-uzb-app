<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShapeImportLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'layer_id',
        'type',
        'zipfile_path',
    ];
}
