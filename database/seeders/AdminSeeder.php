<?php

namespace Database\Seeders;
 
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
 
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Cek dulu supaya tidak duplikat saat re-seed
        User::firstOrCreate(
            ['email' => 'admin@personalmanager.test'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('Admin@1234'),
                'is_admin' => true,
            ]
        );
 
        $this->command->info('✅ Admin seeder berhasil dijalankan.');
        $this->command->info('   Email    : admin@personalmanager.test');
        $this->command->info('   Password : Admin@1234');
        $this->command->warn('   ⚠️  Ganti password ini setelah login pertama kali!');
    }
}