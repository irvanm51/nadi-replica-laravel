@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border p-5">
            <p class="text-sm text-gray-500">Jadwal Mengajar</p>
            <p class="mt-1 text-2xl font-bold text-gray-800">{{ $totalJadwal }}</p>
        </div>
        <div class="bg-white rounded-xl border p-5">
            <p class="text-sm text-gray-500">Data Nilai</p>
            <p class="mt-1 text-2xl font-bold text-gray-800">{{ $totalNilai }}</p>
        </div>
        <div class="bg-white rounded-xl border p-5">
            <p class="text-sm text-gray-500">Presensi Mahasiswa</p>
            <p class="mt-1 text-2xl font-bold text-gray-800">{{ $totalPresensi }}</p>
        </div>
        <div class="bg-white rounded-xl border p-5">
            <p class="text-sm text-gray-500">Bimbingan Skripsi</p>
            <p class="mt-1 text-2xl font-bold text-gray-800">{{ $totalBimbingan }}</p>
        </div>
    </div>

    <div class="mt-6 bg-white rounded-xl border p-6 text-sm text-gray-500">
        Selamat datang di dashboard dosen NADI. Gunakan menu di samping untuk mengelola jadwal mengajar, nilai, presensi mahasiswa, dan bimbingan skripsi.
    </div>
@endsection
