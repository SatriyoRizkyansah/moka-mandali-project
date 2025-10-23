<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProdukPhoto extends Model
{
    protected $table = 'produk_photos';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'produk_id',
        'path',
        'is_primary',
        'sort_order',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (! $model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
