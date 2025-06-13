<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Facility::insert([
            [
                'facility_image' => 'gambar-fasilitas-unit-rumah/ruang-tamu.jpg',
                'facility_name' => 'Ruang Tamu',
                'description' => 'Ruang tamu yang luas dan nyaman, dilengkapi dengan pencahayaan alami serta sirkulasi udara yang baik untuk menerima tamu atau bersantai bersama keluarga.',
            ],
            [
                'facility_image' => 'gambar-fasilitas-unit-rumah/ruang-dapur.jpg',
                'facility_name' => 'Ruang Dapur',
                'description' => 'Dapur modern dengan konsep terbuka, dilengkapi dengan kitchen set berkualitas dan area memasak yang efisien untuk mendukung aktivitas harian.',
            ],
            [
                'facility_image' => 'gambar-fasilitas-unit-rumah/kamar-tidur.jpg',
                'facility_name' => 'Kamar Tidur',
                'description' => 'Kamar tidur yang nyaman dengan desain minimalis, menyediakan ruang istirahat yang tenang dan privasi maksimal bagi penghuni.',
            ],
            [
                'facility_image' => 'gambar-fasilitas-unit-rumah/kamar-mandi.jpg',
                'facility_name' => 'Kamar Mandi',
                'description' => 'Kamar mandi bersih dan fungsional dengan perlengkapan modern, menyediakan kenyamanan dan kemudahan dalam beraktivitas harian.',
            ],
        ]);

    }
}
