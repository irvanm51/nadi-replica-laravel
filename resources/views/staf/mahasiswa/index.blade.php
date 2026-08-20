@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
    <x-search-form placeholder="Cari nama atau NIM..." :q="$q" />

    <div class="bg-white rounded-xl border overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">NIM</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Program Studi</th>
                    <th class="px-4 py-3">Angkatan</th>
                    <th class="px-4 py-3">Semester</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($mahasiswas as $mhs)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $mhs->nim }}</td>
                        <td class="px-4 py-3">{{ $mhs->nama }}</td>
                        <td class="px-4 py-3">{{ $mhs->program_studi }}</td>
                        <td class="px-4 py-3">{{ $mhs->angkatan }}</td>
                        <td class="px-4 py-3">{{ $mhs->semester }}</td>
                        <td class="px-4 py-3">
                            <span @class([
                                'px-2 py-0.5 rounded-full text-xs capitalize',
                                'bg-green-100 text-green-700' => $mhs->status === 'aktif',
                                'bg-yellow-100 text-yellow-700' => $mhs->status === 'cuti',
                                'bg-blue-100 text-blue-700' => $mhs->status === 'lulus',
                                'bg-red-100 text-red-700' => $mhs->status === 'DO',
                            ])>{{ $mhs->status }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada data mahasiswa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $mahasiswas->links() }}</div>
@endsection
