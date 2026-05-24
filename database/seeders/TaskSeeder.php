<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    public function run()
    {
        // Pastikan isi 'user_id' disesuaikan dengan id user Anda (misal: 1)
        DB::table('tasks')->insert([
            [
                'user_id' => 2,
                'title' => 'Analisis Manajemen Operasional',
                'description' => 'Menyusun laporan bab 1-3 berdasarkan hasil observasi struktur organisasi.',
                'status' => 'pending', // pending, in_progress, completed
                'priority' => 'high',  // low, medium, high
                'due_date' => Carbon::now()->addDays(3),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Desain Landing Page Aplikasi EdTech',
                'description' => 'Membuat prototype halaman utama dan modul self-learning menggunakan Figma.',
                'status' => 'in_progress',
                'priority' => 'high',
                'due_date' => Carbon::now()->addDays(5),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Revisi Pembagian Jobdesc Divisi Kreatif Konten',
                'description' => 'Finalisasi pembagian tugas untuk 70 anggota proyek Instagram Anti-Bullying.',
                'status' => 'completed',
                'priority' => 'medium',
                'due_date' => Carbon::now()->subDays(1),
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Materi Presentasi',
                'description' => 'Membuat slide presentasi tentang otomatisasi tata kelola kantor modern.',
                'status' => 'pending',
                'priority' => 'low',
                'due_date' => Carbon::now()->addDays(7),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}