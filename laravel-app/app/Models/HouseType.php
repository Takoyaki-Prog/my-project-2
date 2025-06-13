<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'house_type_image',
        'house_type_name',
        'summary',
        'price',
    ];

    public function facilities()
    {
        return $this->belongsToMany(Facility::class)
            ->withTimestamps();
    }

    public function houseUnits()
    {
        return $this->hasMany(HouseUnit::class);
    }

    public function houseTypeGalleries()
    {
        return $this->hasMany(HouseTypeGallery::class);
    }
}
