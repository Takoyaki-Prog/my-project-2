<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\BookingStatusEnum;
use App\Enums\HouseUnitStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\BookingListResource;
use App\Http\Resources\Api\V1\BookingResource;
use App\Models\Booking;
use App\Models\HouseUnit;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $data = Booking::where('customer_id', $userId)
            ->with(['houseUnit.houseType'])
            ->latest()
            ->get()
            ->toResourceCollection(BookingListResource::class);

        return response()
            ->json([
                'success' => true,
                'message' => 'Get all bookings',
                'data' => $data,
            ]);
    }

    public function store(Request $request, HouseUnit $houseUnit)
    {
        $booking = Booking::create([
            'cost' => 500_000,
            'payment_deadline' => now()->addDay(),
            'status' => BookingStatusEnum::AKTIF,
            'house_unit_id' => $houseUnit->id,
            'customer_id' => $request->user()->id,
        ]);

        $houseUnit->update(['status' => HouseUnitStatusEnum::DIBOOKING]);

        return response()
            ->json([
                'success' => true,
                'message' => 'Booking berhasil',
                'bookingId' => $booking->id,
            ], 201);
    }

    public function show(Booking $booking)
    {
        $data = $booking->load(['houseUnit.houseType', 'houseUnit.marketing', 'houseUnit.blockHouseUnit'])
            ->toResource(BookingResource::class);

        return response()
            ->json([
                'success' => true,
                'message' => 'Mengambil detail booking',
                'data' => $data,
            ]);
    }

    public function getBookingId(Request $request, HouseUnit $houseUnit)
    {
        $bookingId = Booking::where([
            'house_unit_id' => $houseUnit->id,
            'customer_id' => $request->user()->id,
            'status' => BookingStatusEnum::AKTIF,
        ])->first('id');

        return response()
            ->json([
                'bookingId' => $bookingId->id,
            ]);
    }
}
