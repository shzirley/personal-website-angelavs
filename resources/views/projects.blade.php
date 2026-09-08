@extends('layouts.app')
@section('title', 'Projects')
@section('file', 'projects/')
@section('content')
<header class="page-heading bubble-zone"><span class="float-bubble bubble-two" aria-hidden="true"></span><p class="eyebrow">MY WORK, ONE FOLDER AT A TIME</p><h1>Made with<br><em>purpose & curiosity.</em></h1><p>Projects where research, product thinking, and real people meet.</p></header>
<div class="page-content">
    @include('partials.projects')
    <div class="file-shelf reveal" aria-label="Project folder shortcuts"><a href="{{ route('projects.show', 'claritas') }}"><span aria-hidden="true">▰</span>claritas.health</a><a href="{{ route('projects.show', 'tappcom') }}"><span aria-hidden="true">▰</span>tappcom.mobile</a><a href="{{ route('projects.show', 'green-saldo') }}"><span aria-hidden="true">▰</span>green-saldo.app</a></div>
</div>
@endsection
