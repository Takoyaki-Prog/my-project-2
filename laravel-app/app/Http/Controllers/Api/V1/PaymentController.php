<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function getSnapToken(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = uniqid();

        $payment = Payment::create([
            'amount' => (int) $request->amount,
            'midtrans_token' => $orderId,
            'status' => PaymentStatusEnum::BERHASIL,
            'booking_id' => $request->booking_id,
        ]);

        Booking::where('id', $request->booking_id)
            ->update([
                'status' => BookingStatusEnum::TERBAYAR,
                'metode_pembelian' => $request->metode_pembelian,
            ]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $request->amount,
            ],
            'customer_details' => [
                'first_name' => $request->user()->name,
                'email' => $request->user()->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json(['token' => $snapToken, 'paymentId' => $payment->id]);
    }

    public function show(Request $request, Payment $payment)
    {
        $data = $payment->load(['booking.houseUnit.houseType', 'booking.houseUnit.blockHouseUnit']);

        return response()
            ->json([
                'paymentId' => $data->id,
                'unitImageUrl' => asset(Storage::url($data->booking->houseUnit->house_unit_image)),
                'unitName' => $data->booking->houseUnit->house_unit_name,
                'hargaUnit' => $data->booking->houseUnit->houseType->price,
                'typeName' => $data->booking->houseUnit->houseType->house_type_name,
                'blockName' => $data->booking->houseUnit->blockHouseUnit->block_name,
                'tangggalBooking' => $data->booking->created_at,
                'biayaBooking' => $data->booking->cost,
                'idTransaksi' => $data->midtrans_token,
                'metodePembelian' => $data->booking->metode_pembelian,
            ]);
    }

    public function getPaymentId(Request $request, Booking $booking)
    {
        $paymentId = Payment::where([
            'booking_id' => $booking->id,
            'status' => PaymentStatusEnum::BERHASIL,
        ])->first('id');

        return response()
            ->json([
                'paymentId' => $paymentId->id,
            ]);
    }
}
