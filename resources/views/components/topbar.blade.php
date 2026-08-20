@php
    $user = auth('api')->user();
@endphp

<header class="h-16 bg-white border-b flex items-center justify-between px-6">
    <h1 class="text-lg font-semibold text-gray-800">{{ $slot }}</h1>

    <div class="flex items-center gap-4">
        <div class="text-right">
            <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
            <span class="inline-block text-xs px-2 py-0.5 rounded-full bg-nadi-blue/10 text-nadi-blue capitalize">{{ $user->role }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500" aria-label="Logout">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>
                </svg>
            </button>
        </form>
    </div>
</header>
