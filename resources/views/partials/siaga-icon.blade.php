<svg width="{{ $size ?? 24 }}" height="{{ $size ?? 24 }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
    @switch($name)
        @case('home')
            <path d="m3 10 9-7 9 7"/><path d="M5 9v12h14V9"/><path d="M9 21v-7h6v7"/>
            @break
        @case('map')
            <path d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3V6Z"/><path d="M9 3v15M15 6v15"/>
            @break
        @case('report')
            <path d="M5 21V4"/><path d="M5 5c5-3 8 3 14 0v10c-6 3-9-3-14 0"/><path d="M9 20h10"/>
            @break
        @case('rain')
            <path d="M7 16.5a4.5 4.5 0 1 1 .8-8.9A5.5 5.5 0 0 1 18 9.5a3.5 3.5 0 0 1-.5 7"/><path d="m8 19-1 2m6-2-1 2m6-2-1 2"/>
            @break
        @case('mountain')
            <path d="m3 20 7-12 4 6 3-4 4 10H3Z"/><path d="m8 12 2 2 2-1"/>
            @break
        @case('shelter')
            <path d="m3 10 9-7 9 7"/><path d="M5 9v12h14V9M9 21v-7h6v7"/><path d="M12 7v3m-1.5-1.5h3"/>
            @break
        @case('search')
            <circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>
            @break
        @case('pin')
            <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/>
            @break
        @case('warning')
            <path d="m12 3 10 18H2L12 3Z"/><path d="M12 9v5m0 3h.01"/>
            @break
        @case('water')
            <path d="M3 8c3-3 5 3 8 0s5 3 8 0 3-1 3-1M3 14c3-3 5 3 8 0s5 3 8 0 3-1 3-1M3 20c3-3 5 3 8 0s5 3 8 0 3-1 3-1"/>
            @break
        @case('leaf')
            <path d="M20 4c-8 0-14 3-14 10a6 6 0 0 0 6 6c7 0 10-7 8-16Z"/><path d="M5 21c2-5 6-9 12-12"/>
            @break
        @case('list')
            <path d="M9 5h11M9 12h11M9 19h11"/><path d="M4 5h.01M4 12h.01M4 19h.01"/>
            @break
        @case('shield')
            <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11Z"/><path d="m9 12 2 2 4-4"/>
            @break
        @case('people')
            <circle cx="9" cy="8" r="3"/><path d="M3 20v-1a6 6 0 0 1 12 0v1H3Z"/><path d="M17 5a3 3 0 0 1 0 6m4 9v-1a6 6 0 0 0-4-5.7"/>
            @break
        @case('cloud')
            <path d="M7 18a5 5 0 1 1 .8-9.9A6 6 0 0 1 19 10a4 4 0 0 1 0 8H7Z"/>
            @break
        @default
            <circle cx="12" cy="12" r="9"/><path d="M12 11v5m0-8h.01"/>
    @endswitch
</svg>
