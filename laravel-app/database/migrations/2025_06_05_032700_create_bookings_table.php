<?php

use App\Enums\BookingStatusEnum;
use App\Models\HouseUnit;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('cost');
            $table->string('metode_pembelian')->nullable();
            $table->timestamp('payment_deadline')->nullable();
            $table->string('status')->default(BookingStatusEnum::AKTIF);
            $table->foreignIdFor(HouseUnit::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'customer_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
