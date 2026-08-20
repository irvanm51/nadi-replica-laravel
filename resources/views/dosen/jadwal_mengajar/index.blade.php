@extends('layouts.app')

@section('title', 'Jadwal Mengajar')

@section('content')
    <x-search-form placeholder="Cari mata kuliah atau kelas..." :q="$q" />

    <div class="bg-white rounded-xl border overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Mata Kuliah</th>
                    <th class="px-4 py-3">Kelas</th>
                    <th class="px-4 py-3">Hari</th>
                    <th class="px-4 py-3">Jam</th>
                    <th class="px-4 py-3">Ruangan</th>
                    <th class="px-4 py-3">SKS</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($jadwalMengajars as $jadwal)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $jadwal->mata_kuliah }}</td>
                        <td class="px-4 py-3">{{ $jadwal->kelas }}</td>
                        <td class="px-4 py-3">{{ $jadwal->hari }}</td>
                        <td class="px-4 py-3">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                        <td class="px-4 py-3">{{ $jadwal->ruangan }}</td>
                        <td class="px-4 py-3">{{ $jadwal->sks }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada jadwal mengajar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $jadwalMengajars->links() }}</div>
@endsection
