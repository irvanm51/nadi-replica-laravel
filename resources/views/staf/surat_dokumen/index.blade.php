@extends('layouts.app')

@section('title', 'Surat & Dokumen')

@section('content')
    <x-search-form placeholder="Cari nomor surat atau nama pemohon..." :q="$q" />

    <div class="bg-white rounded-xl border overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Nomor Surat</th>
                    <th class="px-4 py-3">Jenis Surat</th>
                    <th class="px-4 py-3">Pemohon</th>
                    <th class="px-4 py-3">Tanggal Pengajuan</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($suratDokumens as $surat)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $surat->nomor_surat }}</td>
                        <td class="px-4 py-3">{{ $surat->jenis_surat }}</td>
                        <td class="px-4 py-3">{{ $surat->nama_pemohon }}</td>
                        <td class="px-4 py-3">{{ $surat->tanggal_pengajuan->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <span @class([
                                'px-2 py-0.5 rounded-full text-xs capitalize',
                                'bg-gray-100 text-gray-700' => $surat->status === 'diajukan',
                                'bg-yellow-100 text-yellow-700' => $surat->status === 'diproses',
                                'bg-green-100 text-green-700' => $surat->status === 'selesai',
                                'bg-red-100 text-red-700' => $surat->status === 'ditolak',
                            ])>{{ $surat->status }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada data surat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $suratDokumens->links() }}</div>
@endsection
