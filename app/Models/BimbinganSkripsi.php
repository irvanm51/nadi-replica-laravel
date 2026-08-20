<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BimbinganSkripsi extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id', 'nama_mahasiswa', 'judul_skripsi', 'tanggal_bimbingan', 'bimbingan_ke', 'status', 'catatan',
    ];

    protected function casts(): array
    {
        return ['tanggal_bimbingan' => 'date'];
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
