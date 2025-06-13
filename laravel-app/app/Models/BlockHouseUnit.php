<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlockHouseUnit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'block_name',
        'latitude',
        'longitude',
    ];

    protected function casts()
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function houseUnits()
    {
        return $this->hasMany(HouseUnit::class);
    }
}
