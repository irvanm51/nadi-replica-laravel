<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PresensiController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->string('q')->trim()->toString();

        $presensis = Presensi::query()
            ->when($q, fn ($query) => $query->where('nama_mahasiswa', 'like', "%{$q}%")
                ->orWhere('mata_kuliah', 'like', "%{$q}%"))
            ->latest('tanggal')
            ->paginate(15)
            ->withQueryString();

        return view('dosen.presensi.index', compact('presensis', 'q'));
    }
}
