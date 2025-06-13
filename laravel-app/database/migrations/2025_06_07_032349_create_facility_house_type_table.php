<?php

use App\Models\Facility;
use App\Models\HouseType;
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
        Schema::create('facility_house_type', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Facility::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(HouseType::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_house_type');
    }
};
