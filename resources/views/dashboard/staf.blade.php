@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border p-5">
            <p class="text-sm text-gray-500">Total Mahasiswa</p>
            <p class="mt-1 text-2xl font-bold text-gray-800">{{ $totalMahasiswa }}</p>
        </div>
        <div class="bg-white rounded-xl border p-5">
            <p class="text-sm text-gray-500">Surat &amp; Dokumen</p>
            <p class="mt-1 text-2xl font-bold text-gray-800">{{ $totalSurat }}</p>
        </div>
        <div class="bg-white rounded-xl border p-5">
            <p class="text-sm text-gray-500">Data Keuangan/SPP</p>
            <p class="mt-1 text-2xl font-bold text-gray-800">{{ $totalSpp }}</p>
        </div>
        <div class="bg-white rounded-xl border p-5">
            <p class="text-sm text-gray-500">Laporan Akademik</p>
            <p class="mt-1 text-2xl font-bold text-gray-800">{{ $totalLaporan }}</p>
        </div>
    </div>

    <div class="mt-6 bg-white rounded-xl border p-6 text-sm text-gray-500">
        Selamat datang di dashboard staf NADI. Gunakan menu di samping untuk mengelola data mahasiswa, surat &amp; dokumen, keuangan/SPP, dan laporan akademik.
    </div>
@endsection
