<?php

namespace App\Http\Controllers\Staf;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->string('q')->trim()->toString();

        $mahasiswas = Mahasiswa::query()
            ->when($q, fn ($query) => $query->where('nama', 'like', "%{$q}%")
                ->orWhere('nim', 'like', "%{$q}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('staf.mahasiswa.index', compact('mahasiswas', 'q'));
    }
}
