@extends('layouts.app')

@section('title', 'Presensi Mahasiswa')

@section('content')
    <x-search-form placeholder="Cari nama mahasiswa atau mata kuliah..." :q="$q" />

    <div class="bg-white rounded-xl border overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Nama Mahasiswa</th>
                    <th class="px-4 py-3">Mata Kuliah</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($presensis as $presensi)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $presensi->nama_mahasiswa }}</td>
                        <td class="px-4 py-3">{{ $presensi->mata_kuliah }}</td>
                        <td class="px-4 py-3">{{ $presensi->tanggal->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <span @class([
                                'px-2 py-0.5 rounded-full text-xs capitalize',
                                'bg-green-100 text-green-700' => $presensi->status_kehadiran === 'hadir',
                                'bg-blue-100 text-blue-700' => $presensi->status_kehadiran === 'izin',
                                'bg-yellow-100 text-yellow-700' => $presensi->status_kehadiran === 'sakit',
                                'bg-red-100 text-red-700' => $presensi->status_kehadiran === 'alpa',
                            ])>{{ $presensi->status_kehadiran }}</span>
                        </td>
                        <td class="px-4 py-3">{{ $presensi->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada data presensi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $presensis->links() }}</div>
@endsection
