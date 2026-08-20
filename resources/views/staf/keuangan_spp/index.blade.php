@extends('layouts.app')

@section('title', 'Keuangan/SPP')

@section('content')
    <x-search-form placeholder="Cari nama mahasiswa atau semester..." :q="$q" />

    <div class="bg-white rounded-xl border overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Nama Mahasiswa</th>
                    <th class="px-4 py-3">Semester</th>
                    <th class="px-4 py-3">Nominal</th>
                    <th class="px-4 py-3">Status Pembayaran</th>
                    <th class="px-4 py-3">Tanggal Bayar</th>
                    <th class="px-4 py-3">Metode</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($keuanganSpps as $spp)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $spp->nama_mahasiswa }}</td>
                        <td class="px-4 py-3">{{ $spp->semester }}</td>
                        <td class="px-4 py-3">Rp {{ number_format($spp->nominal, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            <span @class([
                                'px-2 py-0.5 rounded-full text-xs capitalize',
                                'bg-green-100 text-green-700' => $spp->status_pembayaran === 'lunas',
                                'bg-red-100 text-red-700' => $spp->status_pembayaran === 'belum_lunas',
                                'bg-yellow-100 text-yellow-700' => $spp->status_pembayaran === 'cicilan',
                            ])>{{ str_replace('_', ' ', $spp->status_pembayaran) }}</span>
                        </td>
                        <td class="px-4 py-3">{{ $spp->tanggal_bayar?->format('d M Y') ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $spp->metode_pembayaran ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada data pembayaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $keuanganSpps->links() }}</div>
@endsection
