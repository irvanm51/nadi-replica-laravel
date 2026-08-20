<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NilaiController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->string('q')->trim()->toString();

        $nilais = Nilai::query()
            ->when($q, fn ($query) => $query->where('nama_mahasiswa', 'like', "%{$q}%")
                ->orWhere('mata_kuliah', 'like', "%{$q}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('dosen.nilai.index', compact('nilais', 'q'));
    }
}
