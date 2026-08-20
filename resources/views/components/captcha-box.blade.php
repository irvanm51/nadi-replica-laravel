@php
    $captchaQuestion = session('captcha_a') . ' + ' . session('captcha_b');
@endphp

<div id="captcha-visual" class="relative overflow-hidden rounded-lg bg-[#fdf1ee] border border-red-100 px-4 py-3 select-none">
    <svg width="0" height="0">
        <filter id="captcha-noise">
            <feTurbulence type="fractalNoise" baseFrequency="0.015 0.03" numOctaves="2" result="warp"/>
            <feDisplacementMap in="SourceGraphic" in2="warp" scale="6"/>
        </filter>
    </svg>
    <div class="captcha-lines"></div>
    <div class="relative flex justify-center" style="filter:url(#captcha-noise)">
        @foreach (str_split($captchaQuestion) as $ch)
            <span
                class="inline-block font-serif text-2xl text-red-700"
                style="transform: rotate({{ random_int(-10, 10) }}deg) translateY({{ random_int(-3, 3) }}px); text-shadow: 1px 1px 0 rgba(127,29,29,0.2);"
            >{{ $ch === ' ' ? "\u{00A0}" : $ch }}</span>
        @endforeach
    </div>
</div>
