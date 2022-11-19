<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;

class Ball extends Model
{
    // use HasFactory;

    use PostgisTrait;

    protected $fillable = [
        'soato',
        'level',
        'geom',
        'accuracy'
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
     * The districts that belong to the Zone
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function districts(): BelongsToMany
    {
        return $this
            ->belongsToMany(District::class, 'area_layer', 'layer_id', 'area_soato', 'id', 'soato')
            ->wherePivot('layer_type', 'ball');
    }
}
