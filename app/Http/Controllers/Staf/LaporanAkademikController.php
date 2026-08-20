<?php

namespace App\Http\Controllers\Staf;

use App\Http\Controllers\Controller;
use App\Models\LaporanAkademik;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanAkademikController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->string('q')->trim()->toString();

        $laporanAkademiks = LaporanAkademik::query()
            ->when($q, fn ($query) => $query->where('jenis_laporan', 'like', "%{$q}%")
                ->orWhere('program_studi', 'like', "%{$q}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('staf.laporan_akademik.index', compact('laporanAkademiks', 'q'));
    }
}
