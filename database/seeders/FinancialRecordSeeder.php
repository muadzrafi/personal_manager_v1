<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinancialRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Langsung dikunci ke ID 2 karena ID 1 digunakan khusus untuk akun Admin
        $userId = 2;

        $records = [];

        // Definisi template data untuk menghasilkan variasi yang realistis
        $personalIncomeTemplates = [
            ['category' => 'personal', 'title' => 'Uang Saku Bulanan', 'amount' => 1500000, 'desc' => 'Uang saku bulanan rutin dari orang tua.'],
            ['category' => 'personal', 'title' => 'Insentif Tambahan', 'amount' => 300000, 'desc' => 'Bonus pengerjaan tugas sampingan bantuan administrasi.'],
        ];

        $personalExpenseTemplates = [
            ['category' => 'personal', 'title' => 'Sesi Renang Mingguan', 'amount' => 35000, 'desc' => 'Tiket masuk kolam renang dan air minum.'],
            ['category' => 'personal', 'title' => 'Keperluan ATK & Cetak Tugas', 'amount' => 45000, 'desc' => 'Cetak makalah kuliah dan beli binder.'],
            ['category' => 'personal', 'title' => 'Buku Referensi Kuliah', 'amount' => 85000, 'desc' => 'Pembelian buku penunjang materi manajemen.'],
            ['category' => 'personal', 'title' => 'Bensin Harian', 'amount' => 50000, 'desc' => 'Isi bensin untuk mobilitas harian di Bandung.'],
            ['category' => 'personal', 'title' => 'Servis Ringan Motor', 'amount' => 120000, 'desc' => 'Ganti oli rutin berkala.'],
            ['category' => 'personal', 'title' => 'Konsumsi Kuliah Kelompok', 'amount' => 65000, 'desc' => 'Beli kopi dan camilan saat kerja kelompok malam.'],
        ];

        $businessIncomeTemplates = [
            ['category' => 'business', 'title' => 'Penjualan Keychain Resin', 'amount' => 450000, 'desc' => 'Pesanan gantungan kunci kustom dari komunitas lokal.'],
            ['category' => 'business', 'title' => 'Termin Proyek Web KANRI', 'amount' => 1500000, 'desc' => 'Pembayaran pengerjaan fitur modul manajemen project.'],
            ['category' => 'business', 'title' => 'Penjualan Bulk Order Merchandise', 'amount' => 600000, 'desc' => 'Pesanan kustom merchandise organisasi mahasiswa.'],
        ];

        $businessExpenseTemplates = [
            ['category' => 'business', 'title' => 'Restock Resin & Katalis', 'amount' => 185000, 'desc' => 'Pembelian bahan baku cairan resin bening transparan.'],
            ['category' => 'business', 'title' => 'Beli Cetakan Silikon Kustom', 'amount' => 95000, 'desc' => 'Cetakan silikon bentuk baru untuk variasi produk.'],
            ['category' => 'business', 'title' => 'Iklan Instagram Ads', 'amount' => 100000, 'desc' => 'Promosi campaign produk kustom menyasar target mahasiswa.'],
            ['category' => 'business', 'title' => 'Biaya Berlangganan Server/Hosting', 'amount' => 150000, 'desc' => 'Biaya bulanan VPS development pengerjaan aplikasi.'],
        ];

        // Loop untuk 3 bulan terakhir (Maret, April, Mei 2026)
        for ($monthsAgo = 2; $monthsAgo >= 0; $monthsAgo--) {
            $baseDate = Carbon::now()->subMonths($monthsAgo);
            
            // --- 1. WAJIB: Pemasukan Rutin Awal Bulan ---
            $records[] = [
                'user_id'     => $userId,
                'type'        => 'income',
                'category'    => 'personal',
                'amount'      => $personalIncomeTemplates[0]['amount'],
                'description' => '[PRIBADI] ' . $personalIncomeTemplates[0]['title'] . ' - ' . $personalIncomeTemplates[0]['desc'],
                'recorded_at' => $baseDate->copy()->startOfMonth()->addHours(9)->format('Y-m-d H:i:s'),
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            ];

            $records[] = [
                'user_id'     => $userId,
                'type'        => 'income',
                'category'    => 'business',
                'amount'      => $businessIncomeTemplates[1]['amount'],
                'description' => '[BISNIS] ' . $businessIncomeTemplates[1]['title'] . ' - ' . $businessIncomeTemplates[1]['desc'],
                'recorded_at' => $baseDate->copy()->startOfMonth()->addDays(2)->addHours(13)->format('Y-m-d H:i:s'),
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            ];

            // --- 2. ACAK: Generate Transaksi Tambahan ---
            $additionalCount = rand(5, 6); 

            for ($i = 0; $i < $additionalCount; $i++) {
                $pool = rand(1, 4);
                $transaction = [];
                $type = '';
                $category = '';

                if ($pool == 1) {
                    $tpl = $personalExpenseTemplates[array_rand($personalExpenseTemplates)];
                    $type = 'expense';
                    $category = $tpl['category'];
                    $transaction = $tpl;
                } elseif ($pool == 2) {
                    $tpl = $businessExpenseTemplates[array_rand($businessExpenseTemplates)];
                    $type = 'expense';
                    $category = $tpl['category'];
                    $transaction = $tpl;
                } elseif ($pool == 3) {
                    $tpl = $businessIncomeTemplates[array_rand($businessIncomeTemplates)];
                    $type = 'income';
                    $category = $tpl['category'];
                    $transaction = $tpl;
                } else {
                    $tpl = $personalIncomeTemplates[array_rand($personalIncomeTemplates)];
                    $type = 'income';
                    $category = $tpl['category'];
                    $transaction = $tpl;
                }

                $randomDay = rand(4, 28);
                $recordedAtRaw = $baseDate->copy()->day($randomDay)->addHours(rand(8, 20))->addMinutes(rand(0, 59));

                $variance = rand(-5, 5) * 1000;
                $finalAmount = max(10000, $transaction['amount'] + $variance);

                $prefix = ($category === 'business') ? '[BISNIS] ' : '[PRIBADI] ';

                $records[] = [
                    'user_id'     => $userId,
                    'type'        => $type,
                    'category'    => $category,
                    'amount'      => $finalAmount,
                    'description' => $prefix . $transaction['title'] . ' - ' . $transaction['desc'],
                    'recorded_at' => $recordedAtRaw->format('Y-m-d H:i:s'),
                    'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                ];
            }
        }

        // Urutkan secara kronologis langsung membandingkan string string tanggal menggunakan strtotime
        usort($records, function ($a, $b) {
            return strtotime($a['recorded_at']) <=> strtotime($b['recorded_at']);
        });

        // Jalankan insert massal ke database
        DB::table('financial_records')->insert($records);
    }
}