<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerkProduk extends Model
{
    protected $table = 'merk_produk';

    // UUID Configuration
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['nama_merk'];

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
        return $this->hasMany(Produk::class, 'merk_id');
    }
}
