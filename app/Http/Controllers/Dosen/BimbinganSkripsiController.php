<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\BimbinganSkripsi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BimbinganSkripsiController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->string('q')->trim()->toString();

        $bimbinganSkripsis = BimbinganSkripsi::query()
            ->when($q, fn ($query) => $query->where('nama_mahasiswa', 'like', "%{$q}%")
                ->orWhere('judul_skripsi', 'like', "%{$q}%"))
            ->latest('tanggal_bimbingan')
            ->paginate(15)
            ->withQueryString();

        return view('dosen.bimbingan_skripsi.index', compact('bimbinganSkripsis', 'q'));
    }
}
