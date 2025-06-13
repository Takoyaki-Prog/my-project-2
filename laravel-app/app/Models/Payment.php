<?php

namespace App\Models;

use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'amount',
        'midtrans_token',
        'status',
        'booking_id',
    ];

    protected function casts()
    {
        return [
            'status' => PaymentStatusEnum::class,
        ];
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
