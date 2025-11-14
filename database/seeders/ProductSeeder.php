<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'nama_produk' => 'Meja Kayu Jati',
                'jenis_kayu' => 'Jati',
                'gambar' => 'meja_jati.jpg',
                'deskripsi' => 'Meja elegan berbahan kayu jati solid dengan finishing halus dan desain minimalis.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Kursi Tamu Kayu Mahoni',
                'jenis_kayu' => 'Mahoni',
                'gambar' => 'kursi_mahoni.jpg',
                'deskripsi' => 'Kursi tamu dari kayu mahoni berkualitas tinggi, cocok untuk ruang tamu bergaya klasik.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Lemari Pakaian Kayu Pinus',
                'jenis_kayu' => 'Pinus',
                'gambar' => 'lemari_pinus.jpg',
                'deskripsi' => 'Lemari pakaian dua pintu berbahan kayu pinus ringan dengan warna natural.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Rak Buku Kayu Sonokeling',
                'jenis_kayu' => 'Sonokeling',
                'gambar' => 'rak_sonokeling.jpg',
                'deskripsi' => 'Rak buku dengan corak khas kayu sonokeling, kuat dan tahan lama.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Meja Belajar Kayu Akasia',
                'jenis_kayu' => 'Akasia',
                'gambar' => 'meja_akasia.jpg',
                'deskripsi' => 'Meja belajar simpel dan ringan dari kayu akasia, cocok untuk ruangan modern.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
