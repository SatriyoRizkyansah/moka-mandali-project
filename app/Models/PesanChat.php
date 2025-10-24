<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanChat extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pesan_chat';

    protected $fillable = [
        'pengguna_id', 
        'isi_pesan',
        'dari_admin',
        'dibaca_admin_pada',
        'dibaca_customer_pada'
    ];

    protected $casts = [
        'dari_admin' => 'boolean',
        'dibaca_admin_pada' => 'datetime',
        'dibaca_customer_pada' => 'datetime',
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function scopeUntukPengguna($query, $penggunaId)
    {
        return $query->where('pengguna_id', $penggunaId);
    }

    public function scopeBelumDibacaAdmin($query)
    {
        return $query->where('dari_admin', false)->whereNull('dibaca_admin_pada');
    }

    public function scopeBelumDibacaCustomer($query, $penggunaId)
    {
        return $query->where('dari_admin', true)
                    ->where('pengguna_id', $penggunaId)
                    ->whereNull('dibaca_customer_pada');
    }

    public function scopeUrutkanTerbaru($query)
    {
        return $query->orderBy('created_at', 'asc');
    }
}