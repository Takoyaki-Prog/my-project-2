<?php

use App\Enums\HouseUnitStatusEnum;
use App\Models\BlockHouseUnit;
use App\Models\HouseType;
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
        Schema::create('house_units', function (Blueprint $table) {
            $table->id();
            $table->string('house_unit_image');
            $table->string('house_unit_name');
            $table->string('status')->default(HouseUnitStatusEnum::TERSEDIA);
            $table->foreignIdFor(BlockHouseUnit::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(HouseType::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'marketing_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_units');
    }
};
