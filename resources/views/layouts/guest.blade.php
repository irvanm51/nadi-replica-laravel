<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Login') - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        <div class="relative hidden lg:flex flex-col justify-center px-16 overflow-hidden bg-gradient-to-br from-nadi-blue to-nadi-purple text-white">
            <div class="absolute -top-16 -left-16 w-72 h-72 rounded-full bg-white/10"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-white/10 translate-x-1/3 translate-y-1/3"></div>

            <div class="relative z-10">
                <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2 1 7l11 5 9-4.09V17h2V7L12 2Zm0 7.18L4.24 6 12 2.82 19.76 6 12 9.18ZM5 12.18v4.7c0 1.1 3.13 3.12 7 3.12s7-2.02 7-3.12v-4.7l-7 3.18-7-3.18Z"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold tracking-tight">NADI</h1>
                <p class="mt-2 tracking-widest text-blue-100 text-sm">NARASI AKADEMIK DATA TERINTEGRATIF</p>

                <div class="mt-10 flex flex-col gap-4">
                    <div class="flex items-center gap-3 bg-white/10 rounded-lg px-4 py-3 backdrop-blur">
                        <span class="w-9 h-9 rounded-lg bg-white/15 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/>
                            </svg>
                        </span>
                        <span>Keamanan data terjamin</span>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 rounded-lg px-4 py-3 backdrop-blur">
                        <span class="w-9 h-9 rounded-lg bg-white/15 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 2 3 14h7l-1 8 10-12h-7l1-8Z"/>
                            </svg>
                        </span>
                        <span>Akses cepat &amp; responsif</span>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 rounded-lg px-4 py-3 backdrop-blur">
                        <span class="w-9 h-9 rounded-lg bg-white/15 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 15l4-5 3 3 5-7"/>
                            </svg>
                        </span>
                        <span>Monitoring real-time</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col justify-center px-8 sm:px-16 lg:px-24 bg-white">
            @yield('content')

            <p class="mt-10 text-xs text-gray-400 text-center">&copy; {{ date('Y') }} NADI - Institut Teknologi Tangerang Selatan</p>
        </div>
    </div>
</body>
</html>
