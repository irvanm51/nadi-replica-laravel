<?php

namespace App\Http\Controllers\Staf;

use App\Http\Controllers\Controller;
use App\Models\SuratDokumen;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratDokumenController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->string('q')->trim()->toString();

        $suratDokumens = SuratDokumen::query()
            ->when($q, fn ($query) => $query->where('nama_pemohon', 'like', "%{$q}%")
                ->orWhere('nomor_surat', 'like', "%{$q}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('staf.surat_dokumen.index', compact('suratDokumens', 'q'));
    }
}
