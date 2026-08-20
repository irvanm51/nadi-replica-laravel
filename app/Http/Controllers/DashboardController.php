<?php

namespace App\Http\Controllers;

use App\Models\BimbinganSkripsi;
use App\Models\JadwalMengajar;
use App\Models\KeuanganSpp;
use App\Models\LaporanAkademik;
use App\Models\Mahasiswa;
use App\Models\Nilai;
use App\Models\Presensi;
use App\Models\SuratDokumen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): RedirectResponse
    {
        $user = Auth::guard('api')->user();

        return redirect()->route($user->role === 'staf' ? 'staf.dashboard' : 'dosen.dashboard');
    }

    public function staf(): View
    {
        return view('dashboard.staf', [
            'totalMahasiswa' => Mahasiswa::count(),
            'totalSurat' => SuratDokumen::count(),
            'totalSpp' => KeuanganSpp::count(),
            'totalLaporan' => LaporanAkademik::count(),
        ]);
    }

    public function dosen(): View
    {
        return view('dashboard.dosen', [
            'totalJadwal' => JadwalMengajar::count(),
            'totalNilai' => Nilai::count(),
            'totalPresensi' => Presensi::count(),
            'totalBimbingan' => BimbinganSkripsi::count(),
        ]);
    }
}
