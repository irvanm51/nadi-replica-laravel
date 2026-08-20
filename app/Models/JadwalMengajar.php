<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalMengajar extends Model
{
    use HasFactory;

    protected $fillable = [
        'dosen_id', 'mata_kuliah', 'kelas', 'hari', 'jam_mulai', 'jam_selesai', 'ruangan', 'sks',
    ];

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
}
