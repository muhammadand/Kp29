<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::updateOrCreate(
            ['username' => 'adminkp29'], // Username admin
            [
                'password' => Hash::make('admin1234') // Password admin
            ]
        );

        $this->command->info('✅ Admin default berhasil dibuat: username = admin | password = admin123');
    }
}
