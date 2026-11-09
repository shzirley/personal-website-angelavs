@extends('adminlte::page')

@include('admin.partials.shell')

@section('title', 'Kelola Proyek')

@section('content_header')
    @include('admin.partials.heading', ['path' => 'admin / projects', 'eyebrow' => 'PROJECT ARCHIVE', 'title' => 'Kelola', 'accent' => 'proyek.'])
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="status">&gt; {{ session('success') }}</div>
    @endif

    <section class="window">
        <div class="window-bar"><span>projects.db</span><span class="window-controls" aria-hidden="true">— □ ×</span></div>
        <div class="window-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-5">
                    <input type="search" name="q" class="form-control" placeholder="Cari judul atau peran..."
                        aria-label="Cari judul atau peran" value="{{ request('q') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select" aria-label="Filter kategori">
                        <option value="">Semua kategori</option>
                        @foreach (\App\Models\Project::CATEGORIES as $category)
                            <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select" aria-label="Filter status">
                        <option value="">Semua status</option>
                        <option value="1" @selected(request('status') === '1')>Aktif</option>
                        <option value="0" @selected(request('status') === '0')>Arsip</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary flex-fill">Filter</button>
                    <a class="btn" href="{{ route('admin.projects.index') }}">Reset</a>
                </div>
            </form>

            @can('tambah-proyek')
                <a class="btn btn-success mb-3" href="{{ route('admin.projects.create') }}">
                    <i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Proyek
                </a>
            @endcan

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Judul</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Peran</th>
                            <th scope="col">Tahun</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projects as $project)
                            <tr>
                                <td>{{ $project->title }}</td>
                                <td>{{ $project->category }}</td>
                                <td>{{ $project->role }}</td>
                                <td>{{ $project->year }}</td>
                                <td>
                                    <span class="badge {{ $project->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                                        {{ $project->is_active ? 'Aktif' : 'Arsip' }}
                                    </span>
                                </td>
                                <td class="text-nowrap">
                                    @can('edit-proyek')
                                        <a class="btn btn-sm btn-warning" href="{{ route('admin.projects.edit', $project) }}">Edit</a>
                                    @endcan
                                    @can('hapus-proyek')
                                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="d-inline"
                                            onsubmit="return confirm('Hapus proyek ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada proyek yang cocok.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $projects->links('pagination::bootstrap-5') }}
        </div>
    </section>
@endsection
