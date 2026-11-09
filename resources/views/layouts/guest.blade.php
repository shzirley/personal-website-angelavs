<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#f6b8cf" data-theme-color>

        <title>Back office · AngelaOS</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @include('admin.partials.head')
    </head>
    <body>
        @include('admin.partials.boot')
        <div class="desktop auth-desktop">
            <header class="system-bar">
                <a class="brand" href="{{ route('home') }}"><span class="brand-mark" aria-hidden="true">✿</span> Angela<span class="brand-os">OS</span></a>
                <span class="system-tab">back office <span aria-hidden="true">♡</span></span>
                <button class="theme-toggle" type="button" data-theme-toggle aria-pressed="false" aria-label="Switch to midnight terminal"><span data-theme-icon aria-hidden="true">&gt;_</span><span data-theme-label>Midnight</span></button>
                <a class="header-contact" href="{{ route('home') }}">back to site <span aria-hidden="true">↗</span></a>
            </header>
            <div class="address-bar"><span aria-hidden="true">⌘</span> angela / <span>back office / auth</span><span class="address-end">PERSONAL EDITION · {{ date('Y') }}</span></div>
            <main id="main" class="auth-stage">
                <section class="window auth-window">
                    <div class="window-bar"><span>auth.exe</span><span class="window-controls" aria-hidden="true">— □ ×</span></div>
                    <div class="auth-body">{{ $slot }}</div>
                </section>
            </main>
        </div>
    </body>
</html>
