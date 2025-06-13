<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseUnitGallery extends Model
{
    protected $fillable = [
        'house_unit_gallery_image',
        'house_unit_gallery_name',
        'description',
        'house_unit_id',
    ];

    public function houseUnit()
    {
        return $this->belongsTo(HouseUnit::class);
    }
}
