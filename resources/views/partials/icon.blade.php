<svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($icon)
        @case('home')<path d="m4 14 12-10 12 10M7 12v15h7v-8h5v8h6V12"/>@break
        @case('user')<rect x="5" y="4" width="22" height="25" rx="2"/><circle cx="16" cy="12" r="4"/><path d="M10 23c0-6 12-6 12 0M12 27h8"/>@break
        @case('folder')<path d="M3 10V6h10l3 4h13v17H3V10Z"/><path d="M3 13h26"/>@break
        @case('calculator')<rect x="6" y="3" width="20" height="26" rx="2"/><path d="M10 7h12v6H10zM10 18h2m4 0h1m4 0h1M10 23h2m4 0h1m4 0h1"/>@break
        @case('notepad')<path d="M7 4h18v25H7zM11 2v5m5-5v5m5-5v5M11 12h10m-10 5h10m-10 5h7"/>@break
        @case('award')<circle cx="16" cy="12" r="8"/><path d="m11 19-2 11 7-4 7 4-2-11M13 12l2 2 4-5"/>@break
        @case('youtube')<rect x="3" y="7" width="26" height="18" rx="5"/><path d="m13 12 8 4-8 4z"/>@break
        @case('music')<path d="M12 23V7l14-3v16M12 11l14-3"/><circle cx="8" cy="24" r="4"/><circle cx="22" cy="21" r="4"/>@break
    @endswitch
</svg>
