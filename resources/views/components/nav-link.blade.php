@props(['href', 'active' => false])

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => 'flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition '
        . ($active
            ? 'bg-nadi-blue/10 text-nadi-blue'
            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900')]) }}
>
    {{ $slot }}
</a>
