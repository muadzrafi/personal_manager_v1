<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
 
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
 
            $table->string('title');
 
            // longText untuk konten jurnal panjang (mendukung HTML dari rich text editor)
            $table->longText('content');
 
            // Mood tracking opsional
            $table->enum('mood', ['great', 'good', 'neutral', 'bad', 'terrible'])
                  ->nullable();
 
            $table->timestamps();
 
            // Index untuk query list jurnal per user (urut terbaru)
            $table->index(['user_id', 'created_at']);
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};