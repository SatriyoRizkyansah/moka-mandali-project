<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    protected $table = 'kategori_produk';

    // UUID Configuration
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['nama'];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}
