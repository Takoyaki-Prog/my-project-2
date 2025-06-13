<?php

namespace App\Models;

use App\Enums\HouseUnitStatusEnum;
use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseUnit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'house_unit_image',
        'house_unit_name',
        'status',
        'block_house_unit_id',
        'house_type_id',
        'marketing_id',
    ];

    protected function casts()
    {
        return [
            'status' => HouseUnitStatusEnum::class,
        ];
    }

    public function blockHouseUnit()
    {
        return $this->belongsTo(BlockHouseUnit::class);
    }

    public function houseType()
    {
        return $this->belongsTo(HouseType::class);
    }

    public function marketing()
    {
        return $this->belongsTo(User::class, 'marketing_id')
            ->where('role', UserRoleEnum::MARKETING);
    }

    public function houseUnitGalleries()
    {
        return $this->hasMany(HouseUnitGallery::class);
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
}
