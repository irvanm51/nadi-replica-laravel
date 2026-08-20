<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAkademik extends Model
{
    use HasFactory;

    protected $table = 'laporan_akademiks';

    protected $fillable = [
        'jenis_laporan', 'program_studi', 'periode', 'jumlah_mahasiswa', 'rata_rata_ipk', 'status',
    ];
}
