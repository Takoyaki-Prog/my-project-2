<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'facility_image',
        'facility_name',
        'description',
    ];

    public function houseTypes()
    {
        return $this->belongsToMany(HouseType::class);
    }
}
