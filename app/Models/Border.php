<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;

class Border extends Model
{
    // use HasFactory;

    use PostgisTrait;

    protected $fillable = [
        'soato',
        'polygon'
    ];

    protected $postgisFields = [
        'line',
    ];

    protected $postgisTypes = [
        'line' => [
            'geomtype' => 'geometry',
            'srid' => 4326
        ],
    ];
}
