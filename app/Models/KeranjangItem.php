<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeranjangItem extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'keranjang_items';

    protected $fillable = [
        'user_id',
        'produk_id',
        'jumlah',
        'harga_saat_ditambah',
    ];

    protected $casts = [
        'harga_saat_ditambah' => 'decimal:2',
        'jumlah' => 'integer',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }

    // Accessor untuk total harga item ini
    public function getTotalHargaAttribute(): float
    {
        return $this->jumlah * $this->harga_saat_ditambah;
    }

    // Scope untuk mendapatkan keranjang user tertentu
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}