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
}
