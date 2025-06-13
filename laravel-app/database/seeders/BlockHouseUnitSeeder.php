<?php

namespace Database\Seeders;

use App\Models\BlockHouseUnit;
use Illuminate\Database\Seeder;

class BlockHouseUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blocks = range('A', 'N'); // Blok A sampai N

        foreach ($blocks as $char) {
            BlockHouseUnit::create([
                'block_name' => 'Blok '.$char,
                'latitude' => -6.9 + mt_rand(-100, 100) / 1000, // nilai acak
                'longitude' => 107.6 + mt_rand(-100, 100) / 1000,
            ]);
        }
    }
}
