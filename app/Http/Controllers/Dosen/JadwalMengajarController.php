<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\JadwalMengajar;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalMengajarController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->string('q')->trim()->toString();

        $jadwalMengajars = JadwalMengajar::query()
            ->when($q, fn ($query) => $query->where('mata_kuliah', 'like', "%{$q}%")
                ->orWhere('kelas', 'like', "%{$q}%"))
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->paginate(15)
            ->withQueryString();

        return view('dosen.jadwal_mengajar.index', compact('jadwalMengajars', 'q'));
    }
}
