@extends('adminlte::page')

@include('admin.partials.shell')

@section('title', 'Kelola Prestasi')

@section('content_header')
    @include('admin.partials.heading', ['path' => 'admin / achievements', 'eyebrow' => 'LITTLE WINS', 'title' => 'Kelola', 'accent' => 'prestasi.'])
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="status">&gt; {{ session('success') }}</div>
    @endif

    <section class="window">
        <div class="window-bar"><span>achievements.db</span><span class="window-controls" aria-hidden="true">— □ ×</span></div>
        <div class="window-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-7">
                    <input type="search" name="q" class="form-control" placeholder="Cari capaian, ajang, atau penyelenggara..."
                        aria-label="Cari capaian, ajang, atau penyelenggara" value="{{ request('q') }}">
                </div>
                <div class="col-md-3">
                    <select name="year" class="form-select" aria-label="Filter tahun">
                        <option value="">Semua tahun</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}" @selected((string) request('year') === (string) $year)>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary flex-fill">Filter</button>
                    <a class="btn" href="{{ route('admin.achievements.index') }}">Reset</a>
                </div>
            </form>

            @can('tambah-prestasi')
                <a class="btn btn-success mb-3" href="{{ route('admin.achievements.create') }}">
                    <i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Prestasi
                </a>
            @endcan

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Ajang</th>
                            <th scope="col">Capaian</th>
                            <th scope="col">Penyelenggara</th>
                            <th scope="col">Tahun</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($achievements as $achievement)
                            <tr>
                                <td>{{ $achievement->event }}</td>
                                <td>{{ $achievement->title }}</td>
                                <td>{{ $achievement->organizer }}</td>
                                <td>{{ $achievement->year }}</td>
                                <td class="text-nowrap">
                                    @can('edit-prestasi')
                                        <a class="btn btn-sm btn-warning" href="{{ route('admin.achievements.edit', $achievement) }}">Edit</a>
                                    @endcan
                                    @can('hapus-prestasi')
                                        <form method="POST" action="{{ route('admin.achievements.destroy', $achievement) }}" class="d-inline"
                                            onsubmit="return confirm('Hapus prestasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada prestasi yang cocok.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $achievements->links('pagination::bootstrap-5') }}
        </div>
    </section>
@endsection
