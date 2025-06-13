<?php

namespace App\Models;

use App\Enums\BookingStatusEnum;
use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cost',
        'payment_deadline',
        'status',
        'house_unit_id',
        'customer_id',
        'metode_pembelian',
    ];

    protected function casts()
    {
        return [
            'payment_deadline' => 'datetime',
            'status' => BookingStatusEnum::class,
        ];
    }

    public function houseUnit()
    {
        return $this->belongsTo(HouseUnit::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id')
            ->where('role', UserRoleEnum::CUSTOMER);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function document()
    {
        return $this->hasOne(Document::class);
    }
}
