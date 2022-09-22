<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;

class Ball extends Model
{
    // use HasFactory;

    use PostgisTrait;

    protected $fillable = [
        'soato',
        'level',
        'polygon'
    ];

    protected $postgisFields = [
        'polygon'
    ];

    protected $postgisTypes = [
        'polygon' => [
            'geomtype' => 'geometry',
            'srid' => 4326
        ]
    ];
}
