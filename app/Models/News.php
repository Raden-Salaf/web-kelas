<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'title', 'slug', 'body', 'cover_image',
        'category', 'status', 'author_id', 'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Auto-generate slug dari title saat disimpan
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($news) {
            $news->slug = Str::slug($news->title) . '-' . time();
        });
    }

    // Scope: hanya berita yang sudah published
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}