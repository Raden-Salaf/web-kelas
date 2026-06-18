<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// ============================================================
// MODEL: User
// ------------------------------------------------------------
// Karena User dipakai untuk LOGIN, dia extend 'Authenticatable'
// bukan Model biasa. Ini yang memberi kemampuan session, auth, dll.
//
// $fillable = kolom yang boleh diisi via mass assignment
//   (misal: User::create([...]))
// $hidden   = kolom yang TIDAK ditampilkan saat to JSON/array
//   (penting! password jangan bocor ke frontend)
// ============================================================

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'nim', 'email', 'password', 'role', 'photo', 'whatsapp'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed', // Otomatis hash saat disimpan (Laravel 10+)
    ];

    // Relasi: seorang admin bisa punya banyak homework yang dia buat
    public function homeworks()
    {
        return $this->hasMany(Homework::class, 'created_by');
    }

    // Helper method: cek apakah user ini admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}