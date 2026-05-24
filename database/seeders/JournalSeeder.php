<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JournalSeeder extends Seeder
{
    public function run()
    {
        DB::table('journals')->insert([
            [
                'user_id' => 2,
                'title' => 'Refleksi Konsistensi & Buku Atomic Habits',
                'content' => 'Hari ini belajar bahwa perubahan 1% setiap hari jauh lebih bermakna daripada lompatan besar yang tidak konsisten. Memperbaiki rutinitas pagi setelah jogging agar sisa hari berjalan lebih produktif.',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'user_id' => 2,
                'title' => 'Problem Solving Desain Figma & Android Frame',
                'content' => 'Sempat stuck lama karena error komponen Section yang tidak mau menyatu di frame Android. Ternyata memang ada batasan nested dari Figma-nya sendiri. Solusinya di-rebuild manual tanpa nesting berlebih. Melelahkan tapi puas.',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'user_id' => 2,
                'title' => 'Filosofi: I Do It Anyways',
                'content' => 'Menulis catatan pengingat untuk diri sendiri. "I do it anyways" bukan sekadar kalimat biasa, tapi komitmen untuk tetap memilih jalan yang menantang dan sulit demi mendapatkan hasil akhir yang jauh lebih superior.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}