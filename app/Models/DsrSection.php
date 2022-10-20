<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DsrSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'soatos',
        'details'
    ];

    /**
     * Get all of the regions for the DsrSection
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function regions()
    {
        // $region_soatos = explode(',', $this->soatos);
        // $regions = Region::whereIn('soato', $region_soatos)->get('id', 'name_uz', 'soato');
        // return $regions;
        return $this->belongsToMany(Region::class, 'region_section', 'region_id', 'section_id');
    }
}
