<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekeningBank extends Model
{
    protected $table = 'rekening_banks';

    // UUID Configuration
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik',
        'keterangan',
        'aktif',
        'urutan',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
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

    // Scope untuk rekening aktif
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    // Scope untuk sorting berdasarkan urutan
    public function scopeUrutan($query)
    {
        return $query->orderBy('urutan', 'asc')->orderBy('nama_bank', 'asc');
    }

    // Format nomor rekening untuk display
    public function getFormattedNomorRekeningAttribute()
    {
        $nomor = $this->nomor_rekening;
        // Format: xxxx-xxxx-xxxx-xxxx (jika panjang >= 12)
        if (strlen($nomor) >= 12) {
            return substr($nomor, 0, 4) . '-' . substr($nomor, 4, 4) . '-' . substr($nomor, 8, 4) . '-' . substr($nomor, 12);
        }
        return $nomor;
    }
}
