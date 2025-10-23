<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merk extends Model
{
    protected $table = 'merk';

    protected $fillable = ['nama'];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'merk_id');
    }
}
