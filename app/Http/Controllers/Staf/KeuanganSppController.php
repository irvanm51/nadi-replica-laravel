<?php

namespace App\Http\Controllers\Staf;

use App\Http\Controllers\Controller;
use App\Models\KeuanganSpp;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KeuanganSppController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->string('q')->trim()->toString();

        $keuanganSpps = KeuanganSpp::query()
            ->when($q, fn ($query) => $query->where('nama_mahasiswa', 'like', "%{$q}%")
                ->orWhere('semester', 'like', "%{$q}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('staf.keuangan_spp.index', compact('keuanganSpps', 'q'));
    }
}
