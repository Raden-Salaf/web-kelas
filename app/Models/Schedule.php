<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'day', 'subject', 'lecturer',
        'start_time', 'end_time', 'room', 'color', 'order'
    ];

    // Urutan hari untuk sorting (Senin pertama)
    public static $dayOrder = [
        'Senin' => 1, 'Selasa' => 2, 'Rabu' => 3,
        'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6
    ];

    // Scope: ambil jadwal hari ini berdasarkan nama hari Indonesia
    public function scopeToday($query)
    {
        $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        $dayId = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $today = $dayId[now()->dayOfWeek];
        return $query->where('day', $today)->orderBy('start_time');
    }

    // Scope: ambil per hari tertentu
    public function scopeForDay($query, string $day)
    {
        return $query->where('day', $day)->orderBy('start_time');
    }
}