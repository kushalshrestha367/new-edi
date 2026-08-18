<div class="flex items-center px-1 space-x-3">
    <img src="/logo.png" class="h-10 w-10 object-contain shrink-0 me-3" />

    <span class="text-base font-bold transition-all duration-300 ease-in-out">
        {{-- {{ collect(explode(' ', config('app.name')))->map(fn($word) => strtoupper($word[0]))->join('') }} --}}
        @php
            $words = explode(' ', config('app.name'));
        @endphp
        {{ count($words) === 1 ? $words[0] : collect($words)->map(fn($word) => strtoupper($word[0]))->join('') }}
    </span>
</div>
