<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
 
            // Foreign key ke users — cascade delete artinya:
            // jika user dihapus, semua task-nya ikut terhapus otomatis.
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
 
            $table->string('title');
            $table->text('description')->nullable();
 
            // Enum untuk status task
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])
                  ->default('pending');
 
            // Enum untuk prioritas
            $table->enum('priority', ['low', 'medium', 'high'])
                  ->default('medium');
 
            $table->date('due_date')->nullable();
 
            $table->timestamps();
 
            // === INDEXING ===
            // user_id + status sering difilter bersamaan di dashboard
            $table->index(['user_id', 'status']);
            // user_id + due_date untuk query kalender
            $table->index(['user_id', 'due_date']);
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
