<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratDokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat', 'jenis_surat', 'mahasiswa_id', 'nama_pemohon', 'tanggal_pengajuan', 'status', 'keterangan',
    ];

    protected function casts(): array
    {
        return ['tanggal_pengajuan' => 'date'];
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
