<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeuanganSpp extends Model
{
    use HasFactory;

    protected $table = 'keuangan_spps';

    protected $fillable = [
        'mahasiswa_id', 'nama_mahasiswa', 'semester', 'nominal', 'status_pembayaran', 'tanggal_bayar', 'metode_pembayaran',
    ];

    protected function casts(): array
    {
        return [
            'nominal' => 'decimal:2',
            'tanggal_bayar' => 'date',
        ];
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
