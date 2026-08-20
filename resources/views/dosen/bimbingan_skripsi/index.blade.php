@extends('layouts.app')

@section('title', 'Bimbingan Skripsi')

@section('content')
    <x-search-form placeholder="Cari nama mahasiswa atau judul skripsi..." :q="$q" />

    <div class="bg-white rounded-xl border overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Nama Mahasiswa</th>
                    <th class="px-4 py-3">Judul Skripsi</th>
                    <th class="px-4 py-3">Tanggal Bimbingan</th>
                    <th class="px-4 py-3">Bimbingan Ke</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($bimbinganSkripsis as $bimbingan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $bimbingan->nama_mahasiswa }}</td>
                        <td class="px-4 py-3">{{ $bimbingan->judul_skripsi }}</td>
                        <td class="px-4 py-3">{{ $bimbingan->tanggal_bimbingan->format('d M Y') }}</td>
                        <td class="px-4 py-3">{{ $bimbingan->bimbingan_ke }}</td>
                        <td class="px-4 py-3">
                            <span @class([
                                'px-2 py-0.5 rounded-full text-xs capitalize',
                                'bg-gray-100 text-gray-700' => $bimbingan->status === 'proses',
                                'bg-yellow-100 text-yellow-700' => $bimbingan->status === 'revisi',
                                'bg-blue-100 text-blue-700' => $bimbingan->status === 'acc_sidang',
                                'bg-green-100 text-green-700' => $bimbingan->status === 'selesai',
                            ])>{{ str_replace('_', ' ', $bimbingan->status) }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada data bimbingan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $bimbinganSkripsis->links() }}</div>
@endsection
