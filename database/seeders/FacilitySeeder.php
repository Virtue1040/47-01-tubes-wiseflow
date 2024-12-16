<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = array(
            // Fasilitas Interior
            array(
                'facility_name' => 'Kamar Tidur Deluxe',
                'facility_type' => 'Interior',
                'facility_desc' => 'Kamar tidur dengan ukuran luas, kasur king-size, dan meja kerja.',
                'facility_image' => 'kamar_tidur_deluxe.jpg',
            ),
            array(
                'facility_name' => 'Kamar Mandi Dalam',
                'facility_type' => 'Interior',
                'facility_desc' => 'Kamar mandi dalam dengan air panas dan bathtub.',
                'facility_image' => 'kamar_mandi_dalam.jpg',
            ),
            array(
                'facility_name' => 'Ruang Kerja Pribadi',
                'facility_type' => 'Interior',
                'facility_desc' => 'Ruang kerja dengan meja ergonomis dan rak buku.',
                'facility_image' => 'ruang_kerja_pribadi.jpg',
            ),
            array(
                'facility_name' => 'Walk-in Closet',
                'facility_type' => 'Interior',
                'facility_desc' => 'Lemari pakaian besar dengan ruang penyimpanan tambahan.',
                'facility_image' => 'walk_in_closet.jpg',
            ),
            array(
                'facility_name' => 'Home Theater',
                'facility_type' => 'Interior',
                'facility_desc' => 'Ruangan dengan layar besar, sound system, dan sofa nyaman.',
                'facility_image' => 'home_theater.jpg',
            ),
            array(
                'facility_name' => 'Pantry',
                'facility_type' => 'Interior',
                'facility_desc' => 'Pantry dengan kulkas kecil, dispenser air, dan microwave.',
                'facility_image' => 'pantry.jpg',
            ),
        
            // Fasilitas Eksterior
            array(
                'facility_name' => 'Kolam Renang Infinity',
                'facility_type' => 'Eksterior',
                'facility_desc' => 'Kolam renang dengan pemandangan tanpa batas.',
                'facility_image' => 'kolam_renang_infinity.jpg',
            ),
            array(
                'facility_name' => 'Area Hijau',
                'facility_type' => 'Eksterior',
                'facility_desc' => 'Area hijau dengan taman bunga dan pohon rindang.',
                'facility_image' => 'area_hijau.jpg',
            ),
            array(
                'facility_name' => 'Lapangan Basket',
                'facility_type' => 'Eksterior',
                'facility_desc' => 'Lapangan basket dengan standar internasional.',
                'facility_image' => 'lapangan_basket.jpg',
            ),
            array(
                'facility_name' => 'Lapangan Tenis',
                'facility_type' => 'Eksterior',
                'facility_desc' => 'Lapangan tenis outdoor dengan pencahayaan malam.',
                'facility_image' => 'lapangan_tenis.jpg',
            ),
            array(
                'facility_name' => 'Gazebo',
                'facility_type' => 'Eksterior',
                'facility_desc' => 'Gazebo untuk bersantai atau acara kecil di taman.',
                'facility_image' => 'gazebo.jpg',
            ),
            array(
                'facility_name' => 'Tempat Parkir Sepeda',
                'facility_type' => 'Eksterior',
                'facility_desc' => 'Area parkir khusus untuk sepeda.',
                'facility_image' => 'tempat_parkir_sepeda.jpg',
            ),
        
            // Fasilitas Teknologi
            array(
                'facility_name' => 'Smart Home System',
                'facility_type' => 'Teknologi',
                'facility_desc' => 'Sistem kontrol rumah pintar untuk pencahayaan, AC, dan keamanan.',
                'facility_image' => 'smart_home_system.jpg',
            ),
            array(
                'facility_name' => 'WiFi Cepat',
                'facility_type' => 'Teknologi',
                'facility_desc' => 'WiFi dengan kecepatan tinggi hingga 1 Gbps.',
                'facility_image' => 'wifi_cepat.jpg',
            ),
            array(
                'facility_name' => 'Panel Surya',
                'facility_type' => 'Teknologi',
                'facility_desc' => 'Panel surya untuk mendukung energi ramah lingkungan.',
                'facility_image' => 'panel_surya.jpg',
            ),
            array(
                'facility_name' => 'Lift Pintar',
                'facility_type' => 'Teknologi',
                'facility_desc' => 'Lift yang dapat diakses melalui aplikasi.',
                'facility_image' => 'lift_pintar.jpg',
            ),
        
            // Fasilitas Umum
            array(
                'facility_name' => 'Kantin',
                'facility_type' => 'Umum',
                'facility_desc' => 'Kantin dengan berbagai pilihan makanan dan minuman.',
                'facility_image' => 'kantin.jpg',
            ),
            array(
                'facility_name' => 'Co-working Space',
                'facility_type' => 'Umum',
                'facility_desc' => 'Ruang kerja bersama dengan fasilitas lengkap.',
                'facility_image' => 'co_working_space.jpg',
            ),
            array(
                'facility_name' => 'Ruang Serbaguna',
                'facility_type' => 'Umum',
                'facility_desc' => 'Ruang besar untuk acara pertemuan atau kegiatan komunitas.',
                'facility_image' => 'ruang_serbaguna.jpg',
            ),
            array(
                'facility_name' => 'Laundry Koin',
                'facility_type' => 'Umum',
                'facility_desc' => 'Fasilitas laundry mandiri dengan mesin cuci otomatis.',
                'facility_image' => 'laundry_koin.jpg',
            ),
            array(
                'facility_name' => 'Minimarket 24 Jam',
                'facility_type' => 'Umum',
                'facility_desc' => 'Minimarket yang buka 24 jam untuk kebutuhan harian.',
                'facility_image' => 'minimarket_24_jam.jpg',
            ),
        
            // Fasilitas Tambahan
            array(
                'facility_name' => 'Spa dan Sauna',
                'facility_type' => 'Tambahan',
                'facility_desc' => 'Fasilitas spa lengkap dengan sauna dan pijat refleksi.',
                'facility_image' => 'spa_sauna.jpg',
            ),
            array(
                'facility_name' => 'Ruangan Musik',
                'facility_type' => 'Tambahan',
                'facility_desc' => 'Ruang musik dengan peredam suara dan alat musik dasar.',
                'facility_image' => 'ruangan_musik.jpg',
            ),
            array(
                'facility_name' => 'Perpustakaan Mini',
                'facility_type' => 'Tambahan',
                'facility_desc' => 'Ruang baca dengan koleksi buku dan sofa nyaman.',
                'facility_image' => 'perpustakaan_mini.jpg',
            ),
            array(
                'facility_name' => 'ATM Center',
                'facility_type' => 'Tambahan',
                'facility_desc' => 'Pusat ATM dari berbagai bank.',
                'facility_image' => 'atm_center.jpg',
            ),
            array(
                'facility_name' => 'Ruang Game',
                'facility_type' => 'Tambahan',
                'facility_desc' => 'Area dengan konsol game, meja biliar, dan ping pong.',
                'facility_image' => 'ruang_game.jpg',
            ),
        );

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}
