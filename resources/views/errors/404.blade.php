@extends('layouts.app')
@section('title', 'Page not found')
@section('file', 'file-not-found')
@section('content')
<section class="error-page"><div class="window error-window"><div class="window-bar"><span>system-message.txt</span><span aria-hidden="true">- □ ×</span></div><div class="error-content"><span class="error-code" aria-hidden="true">404</span><h1>This file<br><em>went wandering.</em></h1><p>The page or profile you were looking for is nowhere on this desktop. Let’s head somewhere familiar.</p><a class="button primary" href="{{ route('home') }}">Back to Home ↗</a></div></div></section>
@endsection
