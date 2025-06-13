<?php

namespace Database\Seeders;

use App\Enums\HouseUnitStatusEnum;
use App\Models\BlockHouseUnit;
use App\Models\HouseUnit;
use App\Models\HouseUnitGallery;
use Illuminate\Database\Seeder;

class HouseUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blocks = BlockHouseUnit::all(['id', 'block_name']);
        $setengahDataBlok = $blocks->count() / 2;
        $idTipeRumah = 1;

        foreach ($blocks as $index => $block) {
            for ($i = 1; $i <= 5; $i++) {
                HouseUnit::create([
                    'house_unit_image' => 'gambar-tipe-rumah/'.($idTipeRumah == 1 ? 'tipe-30-60.webp' : 'tipe-30-60.webp'),
                    'house_unit_name' => str_replace('Blok ', '', $block->block_name).'-'.$i,
                    'status' => HouseUnitStatusEnum::TERSEDIA,
                    'block_house_unit_id' => $block->id,
                    'house_type_id' => $idTipeRumah,
                    'marketing_id' => 2,
                ]);
            }

            if ($index > $setengahDataBlok) {
                $idTipeRumah = 2;
            }
        }

        $houseUnits = HouseUnit::all('id');

        foreach ($houseUnits as $unit) {
            HouseUnitGallery::insert([
                [
                    'house_unit_gallery_image' => 'galeri-tipe-rumah/tampak-depan.jpg',
                    'house_unit_gallery_name' => 'Tampak depan',
                    'description' => 'Tampilan fasad rumah yang elegan dengan desain minimalis modern, memberikan kesan pertama yang menarik dan bersih.',
                    'house_unit_id' => $unit->id,
                ],
                [
                    'house_unit_gallery_image' => 'galeri-tipe-rumah/ruang-tamu.jpg',
                    'house_unit_gallery_name' => 'Ruang tamu',
                    'description' => 'Ruang tamu yang nyaman dan terang, ideal untuk menerima tamu atau bersantai bersama keluarga.',
                    'house_unit_id' => $unit->id,
                ],
                [
                    'house_unit_gallery_image' => 'galeri-tipe-rumah/ruang-keluarga.jpg',
                    'house_unit_gallery_name' => 'Ruang keluarga',
                    'description' => 'Area keluarga yang hangat dan luas, tempat berkumpul sambil menikmati quality time dengan orang tercinta.',
                    'house_unit_id' => $unit->id,
                ],
                [
                    'house_unit_gallery_image' => 'galeri-tipe-rumah/ruang-dapur.jpg',
                    'house_unit_gallery_name' => 'Ruang dapur',
                    'description' => 'Dapur modern dengan tata letak efisien, dilengkapi ventilasi yang baik untuk kenyamanan memasak sehari-hari.',
                    'house_unit_id' => $unit->id,
                ],
                [
                    'house_unit_gallery_image' => 'galeri-tipe-rumah/kamar-tidur.jpg',
                    'house_unit_gallery_name' => 'Kamar tidur',
                    'description' => 'Kamar tidur utama yang tenang dan cozy, dirancang untuk memberikan kenyamanan istirahat maksimal.',
                    'house_unit_id' => $unit->id,
                ],
                [
                    'house_unit_gallery_image' => 'galeri-tipe-rumah/kamar-mandi.jpg',
                    'house_unit_gallery_name' => 'Kamar mandi',
                    'description' => 'Kamar mandi bersih dengan desain fungsional, dilengkapi fasilitas dasar yang mendukung aktivitas harian.',
                    'house_unit_id' => $unit->id,
                ],
            ]);
        }
    }
}
