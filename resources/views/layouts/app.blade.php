<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f6b8cf" data-theme-color>
    <meta name="description" content="Angela Vania Sugiyono's pink retro portfolio: projects, experiences, achievements, and a very long playlist.">
    <title>@yield('title', 'Home') · AngelaOS</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <script>try{if(localStorage.getItem('angelaos-theme')==='terminal')document.documentElement.dataset.theme='terminal'}catch(error){}</script>
    <link rel="stylesheet" href="{{ asset('css/angela.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
    <script defer src="{{ asset('js/angela.js') }}"></script>
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>
<div class="scroll-progress" aria-hidden="true"></div>
<div class="theme-boot" data-theme-boot hidden aria-live="polite">
    <div class="theme-boot-window" role="status">
        <span>&gt; loading angelaOS.theme</span>
        <span>&gt; switching palette...</span>
        <strong data-theme-boot-status>&gt; midnight mode ready_</strong>
    </div>
</div>
<div class="desktop">
    <header class="system-bar">
        <a class="brand" href="{{ route('home') }}"><span class="brand-mark" aria-hidden="true">✿</span> Angela<span class="brand-os">OS</span></a>
        <span class="system-tab">a little personal space <span aria-hidden="true">♡</span></span>
        <button class="theme-toggle" type="button" data-theme-toggle aria-pressed="false" aria-label="Switch to midnight terminal"><span data-theme-icon aria-hidden="true">&gt;_</span><span data-theme-label>Midnight</span></button>
        <span class="system-caption">DESIGNED WITH CURIOSITY</span>
        <a class="header-contact" href="{{ route('contact') }}">say hello <span aria-hidden="true">↗</span></a>
    </header>
    <div class="desktop-body">
        <div class="workspace">
            <div class="address-bar"><span aria-hidden="true">⌘</span> angela / <span>@yield('file', 'home.desktop')</span><span class="address-end">PERSONAL EDITION · 2026</span></div>
            <main id="main" tabindex="-1">@yield('content')</main>
            <footer class="site-footer">
                <a class="footer-signature" href="{{ route('home') }}">Angela <span aria-hidden="true">✿</span></a>
                <span>© {{ date('Y') }} {{ $profile['short_name'] }} · Made with a curious mind.</span>
                <button type="button" data-motion-toggle hidden aria-pressed="true">Motion: on</button>
            </footer>
        </div>
        <aside class="dock-rail">
            <nav class="dock" aria-label="Main navigation">
                @php
                    $items = [
                        ['label' => 'Home', 'icon' => 'home', 'url' => route('home'), 'active' => request()->routeIs('home')],
                        ['label' => 'About', 'icon' => 'user', 'url' => route('mahasiswa.show', $profile['nrp']), 'active' => request()->routeIs('mahasiswa.*', 'dashboard.*', 'collection', 'resume', 'contact')],
                        ['label' => 'Projects', 'icon' => 'folder', 'url' => route('projects.index'), 'active' => request()->routeIs('projects.*')],
                        ['label' => 'Calculator', 'icon' => 'calculator', 'url' => route('calculator.index'), 'active' => request()->routeIs('calculator.*')],
                    ];
                @endphp
                @foreach($items as $item)
                    <a class="dock-item {{ $item['active'] ? 'is-active' : '' }}" href="{{ $item['url'] }}" @if($item['active']) aria-current="page" @endif>
                        <span class="dock-icon">@include('partials.icon', ['icon' => $item['icon']])</span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
                <span class="dock-note" aria-hidden="true">your next<br>little discovery ↓</span>
            </nav>
        </aside>
    </div>
</div>
</body>
</html>
