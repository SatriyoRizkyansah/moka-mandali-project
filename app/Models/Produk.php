<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    // UUID Configuration
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'kategori_id',
        'merk_id',
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'foto',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_id');
    }

    public function merk()
    {
        return $this->belongsTo(MerkProduk::class, 'merk_id');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'produk_id');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'produk_id');
    }

    /**
     * Photos relation (multiple photos stored in produk_photos)
     */
    public function photos()
    {
        return $this->hasMany(ProdukPhoto::class, 'produk_id', 'id')->orderBy('sort_order');
    }

    /**
     * Primary photo relation convenience (is_primary = true)
     */
    public function primaryPhoto()
    {
        return $this->hasOne(ProdukPhoto::class, 'produk_id', 'id')->where('is_primary', true);
    }

    /**
     * Get the primary photo path or fallback to the old 'foto' column
     */
    public function getPrimaryPhotoAttribute()
    {
        $photo = $this->photos()->where('is_primary', true)->first();
        if ($photo) {
            return $photo->path;
        }

        // fallback to old foto column if exists
        return $this->attributes['foto'] ?? null;
    }

    /**
     * Convenience: return an array of photo paths. Prefer produk_photos, else fallback to single foto
     */
    public function getPhotosArrayAttribute()
    {
        $photos = $this->photos()->get()->pluck('path')->toArray();
        if (!empty($photos)) {
            return $photos;
        }

        if (!empty($this->attributes['foto'])) {
            return [$this->attributes['foto']];
        }

        return [];
    }
}
