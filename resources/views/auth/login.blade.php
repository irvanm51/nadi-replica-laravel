@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <h2 class="text-3xl font-bold text-gray-900">Selamat Datang!</h2>
    <p class="mt-1 text-gray-500">Silakan masuk ke akun Anda</p>

    <form method="POST" action="{{ route('login.attempt') }}" class="mt-8 space-y-5">
        @csrf

        <div>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18v12H3V6Zm0 0 9 7 9-7"/>
                    </svg>
                </span>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Email"
                    required
                    autofocus
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-nadi-blue focus:border-transparent"
                >
            </div>
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2Zm10-10V7a4 4 0 1 0-8 0v4h8Z"/>
                    </svg>
                </span>
                <input
                    id="password-input"
                    type="password"
                    name="password"
                    placeholder="Password"
                    required
                    class="w-full pl-10 pr-11 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-nadi-blue focus:border-transparent"
                >
                <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2 text-gray-600">
                <input type="checkbox" name="remember" value="1" class="rounded border-gray-300 text-nadi-blue focus:ring-nadi-blue">
                Ingat saya
            </label>
            <a href="#" class="text-nadi-blue hover:underline">Lupa Password?</a>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Verifikasi Keamanan <span class="text-red-500">*</span>
            </label>
            <div class="flex items-center gap-3">
                <div id="captcha-box" class="flex-1">
                    @include('components.captcha-box')
                </div>
                <button
                    type="button"
                    id="captcha-refresh-btn"
                    class="w-10 h-10 shrink-0 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500"
                    aria-label="Refresh captcha"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h5M20 20v-5h-5M4.5 9a8 8 0 0 1 14-4.5L20 9M19.5 15a8 8 0 0 1-14 4.5L4 15"/>
                    </svg>
                </button>
            </div>
            <input
                type="text"
                inputmode="numeric"
                name="captcha_answer"
                placeholder="Masukkan jawaban"
                required
                class="mt-3 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-nadi-blue focus:border-transparent"
            >
            @error('captcha_answer')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="w-full flex items-center justify-center gap-2 py-3 rounded-lg text-white font-semibold bg-gradient-to-r from-nadi-blue to-nadi-purple hover:opacity-90 transition"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/>
            </svg>
            Masuk
        </button>
    </form>

    <script>
        document.getElementById('toggle-password').addEventListener('click', function () {
            const input = document.getElementById('password-input');
            input.type = input.type === 'password' ? 'text' : 'password';
        });

        document.getElementById('captcha-refresh-btn').addEventListener('click', async function () {
            const res = await fetch('{{ route('captcha.refresh') }}');
            document.getElementById('captcha-box').innerHTML = await res.text();
        });
    </script>
@endsection
