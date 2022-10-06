<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_uz',
        'name_ru',
        'admincenter_uz',
        'admincenter_ru',
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
    public function zones()
    {
        return $this
            ->belongsToMany(Zone::class, 'area_layer', 'area_soato', 'layer_id', 'soato', 'id')
            ->wherePivot('layer_type', 'zone');
    }
}
