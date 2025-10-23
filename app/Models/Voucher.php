<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'voucher';

    protected $fillable = [
        'user_id',
        'kode_voucher',
        'nominal',
        'status',
        'tanggal_kadaluarsa',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
