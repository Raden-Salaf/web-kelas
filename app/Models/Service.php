<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title', 'description', 'icon', 'price_from',
        'whatsapp_number', 'whatsapp_message', 'image', 'is_active', 'order'
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'price_from' => 'decimal:2',
    ];

    // Generate link WhatsApp siap klik
    public function getWhatsappLinkAttribute(): string
    {
        $msg = urlencode($this->whatsapp_message ?? 'Halo, saya ingin order jasa ' . $this->title);
        return "https://wa.me/{$this->whatsapp_number}?text={$msg}";
    }

    // Scope: hanya jasa yang aktif, urutkan berdasarkan order
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}