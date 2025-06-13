<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseTypeGallery extends Model
{
    protected $fillable = [
        'house_type_gallery_image',
        'house_type_gallery_name',
        'description',
        'house_type_id',
    ];

    public function houseType()
    {
        return $this->belongsTo(HouseType::class);
    }
}
