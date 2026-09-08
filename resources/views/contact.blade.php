@extends('layouts.app')
@section('title', 'Contact')
@section('file', 'hello.mail')
@section('content')
<header class="page-heading"><p class="eyebrow">A CONVERSATION STARTS WITH HELLO</p><h1>Let’s <em>connect.</em></h1><p>Untuk bertukar ide, membahas proyek, atau sekadar menyapa.</p></header>
<div class="page-content"><div class="window contact-window"><div class="window-bar"><span>new-conversation.mail</span><span aria-hidden="true">− □ ×</span></div><div class="toolbox-content"><p class="eyebrow">TO: ANGELA VANIA SUGIYONO</p><h2>My inbox is a<br><em>good place to start.</em></h2><a class="contact-email inline-link" href="mailto:{{ $profile['contact']['email'] }}">{{ $profile['contact']['email'] }}</a><p>{{ $profile['location'] }}</p><div class="button-row"><a class="button secondary" href="{{ $profile['contact']['linkedin'] }}" target="_blank" rel="noopener noreferrer">LinkedIn ↗</a><a class="button secondary" href="{{ $profile['contact']['github'] }}" target="_blank" rel="noopener noreferrer">GitHub ↗</a></div></div></div></div>
@endsection
