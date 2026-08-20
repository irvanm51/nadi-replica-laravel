<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id', 'nama_mahasiswa', 'mata_kuliah', 'nilai_tugas', 'nilai_uts', 'nilai_uas', 'nilai_akhir',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
