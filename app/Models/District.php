<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_uz',
        'name_ru',
        'admincenter_uz',
        'admincenter_ru',
    ];

    protected $casts = [
        'soato' => 'integer',
        'region_soato' => 'integer',
    ];


    /**
     * Get the region that owns the District
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_soato', 'soato');
    }

    /**
     * The zones that belong to the District
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function zones(): BelongsToMany
    {
        return $this
            ->belongsToMany(Zone::class, 'area_layer', 'area_soato', 'layer_id', 'soato', 'id')
            ->wherePivot('layer_type', 'zone');
    }

    /**
     * The balls that belong to the District
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function balls(): BelongsToMany
    {
        return $this
            ->belongsToMany(Ball::class, 'area_layer', 'area_soato', 'layer_id', 'soato', 'id')
            ->wherePivot('layer_type', 'ball');
    }
}
