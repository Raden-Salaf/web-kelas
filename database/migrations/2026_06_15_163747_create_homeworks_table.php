<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// =====================================================================
// MIGRATION: homeworks (Tugas / PR)
// ---------------------------------------------------------------------
// Menyimpan semua PR/tugas yang diinput oleh admin.
// Siswa bisa melihat tugas berdasarkan tanggal deadline.
//
// KONSEP: Relasi — setiap homework punya 'created_by' yang menunjuk
// ke user (admin) yang membuat. Ini adalah relasi "belongs to".
// =====================================================================

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homeworks', function (Blueprint $table) {
            $table->id();
            $table->string('title');                    // Judul tugas
            $table->string('subject');                  // Mata kuliah
            $table->text('description')->nullable();    // Deskripsi detail tugas
            $table->date('due_date');                   // Tanggal deadline
            $table->time('due_time')->nullable();       // Jam deadline (opsional)
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium'); // Prioritas
            $table->boolean('is_done')->default(false); // Status selesai
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->onDelete('cascade');               // Jika admin dihapus, tugas ikut terhapus
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homeworks');
    }
};