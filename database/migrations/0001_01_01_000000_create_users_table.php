<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// =====================================================================
// MIGRATION: users
// ---------------------------------------------------------------------
// Tabel ini menyimpan semua akun — admin dan siswa.
// Kolom 'role' menentukan siapa yang bisa akses apa.
//
// KONSEP PENTING:
// Laravel migration = "resep" untuk membuat tabel.
// up()   = jalankan migration (buat tabel)
// down() = rollback migration (hapus tabel)
// =====================================================================

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();                          // Primary key (auto increment)
            $table->string('name');                // Nama lengkap
            $table->string('nim')->unique()->nullable(); // NIM mahasiswa (null untuk admin)
            $table->string('email')->unique();     // Email (untuk login)
            $table->string('password');            // Password (akan di-hash otomatis)
            $table->enum('role', ['admin', 'siswa'])->default('siswa'); // Role akses
            $table->string('photo')->nullable();   // Foto profil (opsional)
            $table->string('whatsapp')->nullable(); // No WA (opsional)
            $table->timestamps();                  // created_at & updated_at otomatis
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};