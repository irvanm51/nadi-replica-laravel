@extends('layouts.app')

@section('title', 'Input Nilai')

@section('content')
    <x-search-form placeholder="Cari nama mahasiswa atau mata kuliah..." :q="$q" />

    <div class="bg-white rounded-xl border overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Nama Mahasiswa</th>
                    <th class="px-4 py-3">Mata Kuliah</th>
                    <th class="px-4 py-3">Tugas</th>
                    <th class="px-4 py-3">UTS</th>
                    <th class="px-4 py-3">UAS</th>
                    <th class="px-4 py-3">Nilai Akhir</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($nilais as $nilai)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $nilai->nama_mahasiswa }}</td>
                        <td class="px-4 py-3">{{ $nilai->mata_kuliah }}</td>
                        <td class="px-4 py-3">{{ $nilai->nilai_tugas }}</td>
                        <td class="px-4 py-3">{{ $nilai->nilai_uts }}</td>
                        <td class="px-4 py-3">{{ $nilai->nilai_uas }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs bg-nadi-blue/10 text-nadi-blue font-semibold">{{ $nilai->nilai_akhir }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada data nilai.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $nilais->links() }}</div>
@endsection
