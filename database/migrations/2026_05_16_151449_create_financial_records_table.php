<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_records', function (Blueprint $table) {
            $table->id();
 
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
 
            // income = pemasukan, expense = pengeluaran
            $table->enum('type', ['income', 'expense']);
 
            // personal = keuangan pribadi, business = keuangan bisnis
            $table->enum('category', ['personal', 'business'])
                  ->default('personal');
 
            // Gunakan decimal untuk keuangan — JANGAN float (presisi floating point)
            // 15 digit total, 2 digit desimal = hingga 999 triliun
            $table->decimal('amount', 15, 2);
 
            $table->string('description');
 
            // Tanggal transaksi — dipisah dari created_at
            // karena user mungkin input transaksi yang terjadi di masa lalu
            $table->date('recorded_at');
 
            $table->timestamps();
 
            // === INDEXING ===
            // Query tren per bulan sangat umum
            $table->index(['user_id', 'recorded_at']);
            // Filter by type + category
            $table->index(['user_id', 'type', 'category']);
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('financial_records');
    }
};