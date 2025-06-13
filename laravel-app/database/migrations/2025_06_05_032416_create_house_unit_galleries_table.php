<?php

use App\Models\HouseUnit;
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
        Schema::create('house_unit_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('house_unit_gallery_image');
            $table->string('house_unit_gallery_name');
            $table->text('description');
            $table->foreignIdFor(HouseUnit::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_unit_galleries');
    }
};
