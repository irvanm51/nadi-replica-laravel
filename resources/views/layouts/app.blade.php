@php
    $user = auth('api')->user();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <aside class="w-64 bg-white border-r flex flex-col">
            <div class="h-16 flex items-center gap-2 px-6 font-bold text-nadi-blue border-b">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2 1 7l11 5 9-4.09V17h2V7L12 2Zm0 7.18L4.24 6 12 2.82 19.76 6 12 9.18ZM5 12.18v4.7c0 1.1 3.13 3.12 7 3.12s7-2.02 7-3.12v-4.7l-7 3.18-7-3.18Z"/>
                </svg>
                NADI
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1">
                @if ($user->role === 'staf')
                    <x-nav-link :href="route('staf.dashboard')" :active="request()->routeIs('staf.dashboard')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12 12 3l9 9M5 10v10h14V10"/></svg>
                        Dashboard
                    </x-nav-link>
                    <x-nav-link :href="route('staf.mahasiswa.index')" :active="request()->routeIs('staf.mahasiswa.*')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87m5-3.13a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7-1a4 4 0 1 0 0-8m-15 8a4 4 0 1 1 0-8"/></svg>
                        Data Mahasiswa
                    </x-nav-link>
                    <x-nav-link :href="route('staf.surat-dokumen.index')" :active="request()->routeIs('staf.surat-dokumen.*')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6ZM14 2v6h6M9 13h6M9 17h6"/></svg>
                        Surat &amp; Dokumen
                    </x-nav-link>
                    <x-nav-link :href="route('staf.keuangan-spp.index')" :active="request()->routeIs('staf.keuangan-spp.*')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        Keuangan/SPP
                    </x-nav-link>
                    <x-nav-link :href="route('staf.laporan-akademik.index')" :active="request()->routeIs('staf.laporan-akademik.*')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 15l4-5 3 3 5-7"/></svg>
                        Laporan Akademik
                    </x-nav-link>
                @else
                    <x-nav-link :href="route('dosen.dashboard')" :active="request()->routeIs('dosen.dashboard')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12 12 3l9 9M5 10v10h14V10"/></svg>
                        Dashboard
                    </x-nav-link>
                    <x-nav-link :href="route('dosen.jadwal-mengajar.index')" :active="request()->routeIs('dosen.jadwal-mengajar.*')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path stroke-linecap="round" d="M16 2v4M8 2v4M3 10h18"/></svg>
                        Jadwal Mengajar
                    </x-nav-link>
                    <x-nav-link :href="route('dosen.nilai.index')" :active="request()->routeIs('dosen.nilai.*')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m17 3 4 4-11 11H6v-4L17 3Z"/></svg>
                        Input Nilai
                    </x-nav-link>
                    <x-nav-link :href="route('dosen.presensi.index')" :active="request()->routeIs('dosen.presensi.*')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 11l3 3L22 4M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        Presensi Mahasiswa
                    </x-nav-link>
                    <x-nav-link :href="route('dosen.bimbingan-skripsi.index')" :active="request()->routeIs('dosen.bimbingan-skripsi.*')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5A2.5 2.5 0 0 0 6.5 22H20V2H6.5A2.5 2.5 0 0 0 4 4.5v15Z"/></svg>
                        Bimbingan Skripsi
                    </x-nav-link>
                @endif
            </nav>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <x-topbar>@yield('title', 'Dashboard')</x-topbar>
            <main class="p-6 flex-1 overflow-x-auto">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
