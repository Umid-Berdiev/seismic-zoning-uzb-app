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
        'geom'
    ];

    protected $postgisFields = [
        'geom'
    ];

    protected $postgisTypes = [
        'geom' => [
            'geomtype' => 'geometry',
            'srid' => 4326
        ]
    ];
}
