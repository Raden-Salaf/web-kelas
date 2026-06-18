<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

// ============================================================
// MODEL: Homework
// ------------------------------------------------------------
// KONSEP ACCESSOR: kita bisa buat method get[Nama]Attribute()
// untuk mengubah cara data ditampilkan tanpa ubah data asli di DB.
//
// Contoh: $hw->status_label => otomatis hitung dari due_date
// ============================================================

class Homework extends Model
{

    protected $table = "homeworks";

    protected $fillable = [
        'title', 'subject', 'description',
        'due_date', 'due_time', 'priority', 'is_done', 'created_by'
    ];

    protected $casts = [
        'due_date' => 'date',   // Otomatis jadi Carbon object
        'is_done'  => 'boolean',
    ];

    // Relasi balik ke User (siapa yang buat tugas ini)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessor: apakah tugas ini sudah lewat deadline?
    public function getIsOverdueAttribute(): bool
    {
        return !$this->is_done && $this->due_date->isPast();
    }

    // Accessor: berapa hari lagi deadlinenya?
    public function getDaysLeftAttribute(): int
    {
        return (int) now()->diffInDays($this->due_date, false);
    }

    // Scope: ambil tugas yang deadline-nya hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('due_date', today());
    }

    // Scope: ambil tugas yang belum selesai dan belum lewat
    public function scopeUpcoming($query)
    {
        return $query->where('is_done', false)
                     ->whereDate('due_date', '>=', today())
                     ->orderBy('due_date');
    }
}