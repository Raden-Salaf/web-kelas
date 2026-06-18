<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// =====================================================================
// MIGRATION: schedules (Jadwal Mata Kuliah)
// ---------------------------------------------------------------------
// Menyimpan jadwal kuliah per hari dalam seminggu.
// Contoh: Senin -> Algoritma -> 08:00-10:00 -> Ruang A201
//
// KONSEP: enum('day', [...]) membatasi input hanya hari valid.
// Ini lebih aman daripada string bebas yang bisa typo.
// =====================================================================

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->enum('day', [
                'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
            ]);                                         // Hari kuliah
            $table->string('subject');                  // Nama mata kuliah
            $table->string('lecturer')->nullable();     // Nama dosen
            $table->time('start_time');                 // Jam mulai
            $table->time('end_time');                   // Jam selesai
            $table->string('room')->nullable();         // Ruangan
            $table->string('color')->default('#3B82F6'); // Warna badge (hex code)
            $table->integer('order')->default(0);       // Urutan tampil jika banyak di hari sama
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};