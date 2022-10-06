<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;

class Zone extends Model
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

    /**
     * The areas that belong to the Ball
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function districts()
    {
        return $this
            ->belongsToMany(District::class, 'area_layer', 'layer_id', 'area_soato', 'id', 'soato')
            ->wherePivot('layer_type', 'zone');
    }
}
