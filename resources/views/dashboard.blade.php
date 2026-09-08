@extends('layouts.app')
@section('title', 'Academic dashboard')
@section('file', 'academic / dashboard')
@section('content')
<header class="page-heading"><p class="eyebrow">MY ACADEMIC DESKTOP</p><h1>Learning, <em>in progress.</em></h1><p>{{ $profile['name'] }} · {{ $profile['nrp'] }} · {{ $profile['degree'] }}, ITS</p></header>
<div class="page-content stack"><div class="content-grid"><a class="panel dashboard-card reveal" href="{{ route('dashboard.mahasiswa.show', $profile['nrp']) }}">@include('partials.icon', ['icon' => 'user'])<h2>Academic profile ↗</h2><p>Identity, education, experiences, and the tools I keep within reach.</p></a><a class="panel dashboard-card reveal" href="{{ route('collection') }}">@include('partials.icon', ['icon' => 'folder'])<h2>Achievement archive ↗</h2><p>Eight competition milestones from 2023 to 2026, filed from newest to earliest.</p></a></div><div class="bottom-note"><span>Want a quick average for two semesters?</span><a class="button secondary" href="{{ route('calculator.index') }}">Open calculator ↗</a></div></div>
@endsection
