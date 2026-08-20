@extends('layouts.app')

@section('title', 'Laporan Akademik')

@section('content')
    <x-search-form placeholder="Cari jenis laporan atau program studi..." :q="$q" />

    <div class="bg-white rounded-xl border overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Jenis Laporan</th>
                    <th class="px-4 py-3">Program Studi</th>
                    <th class="px-4 py-3">Periode</th>
                    <th class="px-4 py-3">Jumlah Mahasiswa</th>
                    <th class="px-4 py-3">Rata-rata IPK</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($laporanAkademiks as $laporan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $laporan->jenis_laporan }}</td>
                        <td class="px-4 py-3">{{ $laporan->program_studi }}</td>
                        <td class="px-4 py-3">{{ $laporan->periode }}</td>
                        <td class="px-4 py-3">{{ $laporan->jumlah_mahasiswa }}</td>
                        <td class="px-4 py-3">{{ $laporan->rata_rata_ipk ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span @class([
                                'px-2 py-0.5 rounded-full text-xs capitalize',
                                'bg-gray-100 text-gray-700' => $laporan->status === 'draft',
                                'bg-green-100 text-green-700' => $laporan->status === 'final',
                            ])>{{ $laporan->status }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada data laporan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $laporanAkademiks->links() }}</div>
@endsection
