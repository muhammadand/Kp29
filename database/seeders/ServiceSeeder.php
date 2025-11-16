<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;
use App\Models\ServiceItem;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // --- Category 1: Jasa Pemotongan Kayu ---
        $cutting = ServiceCategory::create([
            'name' => 'Jasa Pemotongan Kayu',
            'description' => 'Menyediakan layanan pemotongan kayu sesuai ukuran dan spesifikasi pesanan pelanggan menggunakan mesin pemotong modern untuk hasil yang presisi. Tarif per m³ sesuai tingkat kesulitan dan volume pemotongan.',
        ]);

        ServiceItem::create([
            'category_id' => $cutting->id,
            'name' => 'Tarif Pemotongan Kayu',
            'price' => 0, // harga fleksibel
            'unit' => 'm³',
        ]);

        // --- Category 2: Jasa Pengasahan Alat Potong ---
        $sharpening = ServiceCategory::create([
            'name' => 'Jasa Pengasahan Alat Potong',
            'description' => 'Layanan pengasahan alat pemotong kayu seperti pisau gergaji dan mata serut untuk menjaga ketajaman dan efisiensi alat kerja pelanggan.',
        ]);

        ServiceItem::create([
            'category_id' => $sharpening->id,
            'name' => 'Pengasahan',
            'price' => 200000,
            'unit' => 'titik baja',
        ]);

        ServiceItem::create([
            'category_id' => $sharpening->id,
            'name' => 'Pengelasan',
            'price' => 10000,
            'unit' => 'titik',
        ]);
    }
}
