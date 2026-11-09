@extends('adminlte::page')

@include('admin.partials.shell')

@section('title', 'Dashboard Admin')

@section('content_header')
    @include('admin.partials.heading', ['path' => 'admin / dashboard', 'eyebrow' => 'MY BACK OFFICE', 'title' => 'Ruang kendali,', 'accent' => 'siap jalan.'])
@endsection

@section('content')
    <p class="admin-session">
        &gt; session: <b>{{ auth()->user()->name }}</b> · role: <b>{{ auth()->user()->getRoleNames()->implode(', ') }}</b>
        @role('Staf') · akses terbatas, Staf tidak dapat menghapus data @endrole
    </p>

    <div class="row">
        <div class="col-md-4">
            <x-adminlte-small-box :title="$totalProjects" text="Total Proyek" icon="bi bi-folder" theme="primary"
                :url="route('admin.projects.index')" url-text="Kelola proyek" />
        </div>
        <div class="col-md-4">
            <x-adminlte-small-box :title="$totalAchievements" text="Total Prestasi" icon="bi bi-award" theme="success"
                :url="route('admin.achievements.index')" url-text="Kelola prestasi" />
        </div>
        <div class="col-md-4">
            <x-adminlte-small-box :title="$totalUsers" text="Total Pengguna" icon="bi bi-people" theme="warning" />
        </div>
    </div>

    <div class="admin-grid">
        <section class="window">
            <div class="window-bar"><span>recent.log</span><span class="window-controls" aria-hidden="true">— □ ×</span></div>
            <div class="window-body">
                <h2 class="visually-hidden">Proyek terbaru</h2>
                <ul class="recent-list">
                    @forelse ($recentProjects as $project)
                        <li>
                            <div>
                                <strong>{{ $project->title }}</strong>
                                <small>{{ $project->role }} · {{ $project->year }}</small>
                            </div>
                            <span class="badge {{ $project->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $project->is_active ? 'Aktif' : 'Arsip' }}</span>
                        </li>
                    @empty
                        <li>Belum ada proyek.</li>
                    @endforelse
                </ul>
            </div>
        </section>

        <section class="window">
            <div class="window-bar"><span>shortcuts.exe</span><span class="window-controls" aria-hidden="true">— □ ×</span></div>
            <div class="window-body admin-quick">
                <h2 class="visually-hidden">Aksi cepat</h2>
                @can('tambah-proyek')
                    <a class="btn btn-primary" href="{{ route('admin.projects.create') }}">Tambah proyek ↗</a>
                @endcan
                <a class="btn" href="{{ route('admin.projects.index') }}">Kelola proyek ↗</a>
                <a class="btn" href="{{ route('admin.achievements.index') }}">Kelola prestasi ↗</a>
                <a class="btn" href="{{ route('home') }}">Lihat situs publik ↗</a>
                <img src="{{ asset('images/mascot/pixel-cat.png') }}" alt="">
            </div>
        </section>
    </div>
@endsection
