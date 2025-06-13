<?php

namespace Database\Seeders;

use App\Models\HouseType;
use App\Models\HouseTypeGallery;
use Illuminate\Database\Seeder;

class HouseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HouseType::insert([
            [
                'house_type_image' => 'gambar-tipe-rumah/tipe-30-60.webp',
                'house_type_name' => 'Type 30/60',
                'summary' => 'Hunian minimalis dengan luas bangunan 30 m² dan tanah 60 m². Cocok untuk keluarga kecil atau pasangan baru menikah, dengan desain efisien dan fungsional.',
                'price' => 165_000_000,
            ],
            [
                'house_type_image' => 'gambar-tipe-rumah/tipe-34-60.webp',
                'house_type_name' => 'Type 34/60',
                'summary' => 'Rumah dengan luas bangunan 34 m² di atas lahan 60 m². Menawarkan ruang yang sedikit lebih lega, ideal untuk kebutuhan tempat tinggal yang nyaman dan terjangkau.',
                'price' => 180_000_000,
            ],
        ]);

        $houseTypeIds = HouseType::all('id');

        foreach ($houseTypeIds as $id) {
            $id->facilities()->attach([1, 2, 3, 4]);
        }

        HouseTypeGallery::insert([
            // House Type ID 1
            [
                'house_type_gallery_image' => 'galeri-tipe-rumah/tampak-depan.jpg',
                'house_type_gallery_name' => 'Tampak depan',
                'description' => 'Desain fasad rumah yang modern dan elegan dengan sentuhan minimalis, menciptakan kesan pertama yang menarik.',
                'house_type_id' => 1,
            ],
            [
                'house_type_gallery_image' => 'galeri-tipe-rumah/ruang-tamu.jpg',
                'house_type_gallery_name' => 'Ruang tamu',
                'description' => 'Ruang tamu yang terang dan luas, ideal untuk berkumpul dan menerima tamu dengan suasana yang nyaman.',
                'house_type_id' => 1,
            ],
            [
                'house_type_gallery_image' => 'galeri-tipe-rumah/ruang-keluarga.jpg',
                'house_type_gallery_name' => 'Ruang keluarga',
                'description' => 'Area keluarga yang hangat dan fungsional, cocok untuk bersantai bersama orang tercinta.',
                'house_type_id' => 1,
            ],
            [
                'house_type_gallery_image' => 'galeri-tipe-rumah/ruang-dapur.jpg',
                'house_type_gallery_name' => 'Ruang dapur',
                'description' => 'Dapur bersih dan rapi dengan perlengkapan modern, mendukung aktivitas memasak yang menyenangkan.',
                'house_type_id' => 1,
            ],
            [
                'house_type_gallery_image' => 'galeri-tipe-rumah/kamar-tidur.jpg',
                'house_type_gallery_name' => 'Kamar tidur',
                'description' => 'Kamar tidur utama dengan pencahayaan alami dan desain yang menenangkan untuk kualitas istirahat yang maksimal.',
                'house_type_id' => 1,
            ],
            [
                'house_type_gallery_image' => 'galeri-tipe-rumah/kamar-mandi.jpg',
                'house_type_gallery_name' => 'Kamar mandi',
                'description' => 'Kamar mandi modern dan bersih, dilengkapi dengan fasilitas lengkap untuk kenyamanan penghuni.',
                'house_type_id' => 1,
            ],

            // House Type ID 2
            [
                'house_type_gallery_image' => 'galeri-tipe-rumah/tampak-depan.jpg',
                'house_type_gallery_name' => 'Tampak depan',
                'description' => 'Tampilan depan rumah yang memikat dengan konsep tropis yang cocok untuk iklim Indonesia.',
                'house_type_id' => 2,
            ],
            [
                'house_type_gallery_image' => 'galeri-tipe-rumah/ruang-tamu.jpg',
                'house_type_gallery_name' => 'Ruang tamu',
                'description' => 'Ruang tamu dengan tata letak terbuka yang memberikan kesan lapang dan nyaman.',
                'house_type_id' => 2,
            ],
            [
                'house_type_gallery_image' => 'galeri-tipe-rumah/ruang-keluarga.jpg',
                'house_type_gallery_name' => 'Ruang keluarga',
                'description' => 'Ruang keluarga dengan suasana hangat dan furniture fungsional, tempat sempurna untuk berkumpul.',
                'house_type_id' => 2,
            ],
            [
                'house_type_gallery_image' => 'galeri-tipe-rumah/ruang-dapur.jpg',
                'house_type_gallery_name' => 'Ruang dapur',
                'description' => 'Dapur dirancang dengan efisiensi tinggi dan mudah dijangkau dari area lainnya di rumah.',
                'house_type_id' => 2,
            ],
            [
                'house_type_gallery_image' => 'galeri-tipe-rumah/kamar-tidur.jpg',
                'house_type_gallery_name' => 'Kamar tidur',
                'description' => 'Kamar tidur dirancang untuk memberikan kenyamanan maksimal dengan desain yang elegan.',
                'house_type_id' => 2,
            ],
            [
                'house_type_gallery_image' => 'galeri-tipe-rumah/kamar-mandi.jpg',
                'house_type_gallery_name' => 'Kamar mandi',
                'description' => 'Kamar mandi fungsional dengan desain minimalis dan fasilitas yang lengkap.',
                'house_type_id' => 2,
            ],
        ]);
    }
}
