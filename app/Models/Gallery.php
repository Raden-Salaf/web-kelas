<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'photo_path', 'caption', 'student_name',
        'nim', 'type', 'album', 'uploaded_by'
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Accessor: URL lengkap foto (dari storage)
    public function getPhotoUrlAttribute(): string
    {
        return asset('storage/' . $this->photo_path);
    }
}