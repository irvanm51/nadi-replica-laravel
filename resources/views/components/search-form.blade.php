@props(['placeholder' => 'Cari...', 'q' => ''])

<form method="GET" class="mb-4">
    <div class="relative max-w-sm">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.3-4.3"/>
            </svg>
        </span>
        <input
            type="text"
            name="q"
            value="{{ $q }}"
            placeholder="{{ $placeholder }}"
            class="w-full pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-nadi-blue focus:border-transparent"
        >
    </div>
</form>
