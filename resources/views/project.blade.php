@extends('layouts.app')
@section('title', $project['title'])
@section('file', 'projects / '.strtolower($project['title']).'.case')
@section('content')
@php
    $slugs = array_keys($profile['projects']);
    $index = array_search($selectedSlug, $slugs, true);
    $previous = $slugs[($index - 1 + count($slugs)) % count($slugs)];
    $next = $slugs[($index + 1) % count($slugs)];
@endphp
<header class="page-heading"><a class="text-link back-link" href="{{ route('projects.index') }}">← Back to projects</a><p class="eyebrow">{{ $project['category'] }}</p><h1>{{ $project['title'] }}<em>.</em></h1><p>{{ $project['summary'] }}</p></header>
<div class="page-content">
    <div class="window project-preview-window reveal" data-closable-window>
        <div class="window-bar"><span>project-preview.png</span><span class="window-controls"><button type="button" data-window-minimize aria-label="Minimize project preview">−</button><button type="button" data-window-maximize aria-label="Expand project preview">□</button><button type="button" data-window-close aria-label="Close project preview">×</button></span></div>
        <div class="project-slides">
            <a class="slide-arrow slide-prev" href="{{ route('projects.show', $previous) }}" aria-label="Previous project: {{ $profile['projects'][$previous]['title'] }}">←</a>
            <div class="slide-stage">@if($project['image'])<img class="wide-image" src="{{ asset('images/projects/'.$project['image']) }}" alt="{{ $project['title'] }} product preview" width="900" height="600">@else<div class="project-placeholder"><span aria-hidden="true">▰</span><strong>{{ $project['title'] }}.app</strong><small>archived project file</small></div>@endif</div>
            <a class="slide-arrow slide-next" href="{{ route('projects.show', $next) }}" aria-label="Next project: {{ $profile['projects'][$next]['title'] }}">→</a>
        </div>
        <div class="slide-caption"><span>{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }} / {{ str_pad((string) count($slugs), 2, '0', STR_PAD_LEFT) }}</span><span>Use the arrows to browse projects</span></div>
    </div>
    <div class="window-closed-message" data-window-closed-message hidden><span>project-preview.png was closed.</span><button class="text-link" type="button" data-window-restore>Restore window ↗</button></div>
    <div class="detail-meta"><div><strong>MY ROLE</strong>{{ $project['role'] }}</div><div><strong>PERIOD</strong>{{ $project['year'] }}</div><div><strong>FOCUS</strong>{{ $project['category'] }}</div></div>
    <div class="content-grid project-story"><article class="panel reveal"><p class="eyebrow">THE PROJECT</p><h2>What we were building</h2><p>{{ $project['description'] }}</p><p class="project-highlight">✦ {{ $project['highlight'] }}</p></article><article class="panel reveal"><p class="eyebrow">WHAT I DID</p><h2>My part in it</h2><ul class="plain-list">@foreach($project['responsibilities'] as $responsibility)<li>{{ $responsibility }}</li>@endforeach</ul></article></div>
    <nav class="project-pagination" aria-label="Project navigation"><a href="{{ route('projects.show', $previous) }}">← {{ $profile['projects'][$previous]['title'] }}</a><a href="{{ route('projects.show', $next) }}">{{ $profile['projects'][$next]['title'] }} →</a></nav>
</div>
@endsection
