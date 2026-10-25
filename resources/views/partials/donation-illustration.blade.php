@switch($type)
    @case('flood')
        <svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="m8 29 24-19 24 19"/><path d="M15 25v17h17"/><path d="M25 42v-9h8"/>
            <path d="M8 49c5-4 9 4 14 0s9 4 14 0 9 4 14 0 7 1 10 1"/>
        </svg>
        @break
    @case('kit')
        <svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M17 21h30a5 5 0 0 1 5 5v25a5 5 0 0 1-5 5H17a5 5 0 0 1-5-5V26a5 5 0 0 1 5-5Z"/>
            <path d="M24 21v-5a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v5M32 29v15M24.5 36.5h15"/>
        </svg>
        @break
    @default
        <svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="m7 50 18-27 10 14 7-10 15 23H7Z"/><path d="m25 23 5-7 8 11M16 50l8-11 8 11"/>
            <path d="M45 18v7M41.5 21.5h7"/>
        </svg>
@endswitch
