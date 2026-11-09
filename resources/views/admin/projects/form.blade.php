@extends('adminlte::page')

@include('admin.partials.shell')

@section('title', $project->exists ? 'Edit Proyek' : 'Tambah Proyek')

@section('content_header')
    @include('admin.partials.heading', [
        'path' => $project->exists ? 'admin / projects / edit' : 'admin / projects / new',
        'eyebrow' => 'PROJECT FILE',
        'title' => $project->exists ? 'Edit' : 'Tambah',
        'accent' => 'proyek.',
    ])
@endsection

@section('content')
    <section class="window">
        <div class="window-bar"><span>{{ $project->exists ? 'edit_project.txt' : 'new_project.txt' }}</span><span class="window-controls" aria-hidden="true">— □ ×</span></div>
        <div class="window-body">
            @include('admin.partials.errors')

            <form method="POST" enctype="multipart/form-data"
                action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}">
                @csrf
                @if ($project->exists)
                    @method('PUT')
                @endif

                <x-adminlte-input name="title" label="Judul" :value="old('title', $project->title)" required />
                <x-adminlte-input name="slug" label="Slug URL (boleh kosong, otomatis dari judul)" :value="old('slug', $project->slug)" />

                <x-adminlte-select name="category" label="Kategori" required>
                    @foreach (\App\Models\Project::CATEGORIES as $category)
                        <option value="{{ $category }}" @selected(old('category', $project->category) === $category)>{{ $category }}</option>
                    @endforeach
                </x-adminlte-select>

                <x-adminlte-input name="role" label="Peran" :value="old('role', $project->role)" required />
                <x-adminlte-input name="year" label="Tahun" :value="old('year', $project->year)" required />
                <x-adminlte-textarea name="summary" label="Ringkasan" rows="2" required>{{ old('summary', $project->summary) }}</x-adminlte-textarea>
                <x-adminlte-textarea name="description" label="Deskripsi" rows="4" required>{{ old('description', $project->description) }}</x-adminlte-textarea>
                <x-adminlte-textarea name="responsibilities" label="Tanggung jawab (satu per baris)" rows="4" required>{{ old('responsibilities', implode("\n", $project->responsibilities ?? [])) }}</x-adminlte-textarea>
                <x-adminlte-input name="highlight" label="Highlight" :value="old('highlight', $project->highlight)" required />
                <x-adminlte-input name="image" type="file" accept=".jpg,.jpeg,.png,.webp" label="Gambar (JPG, PNG, atau WEBP, maks 4 MB, boleh kosong)" />
                @if ($project->image)
                    <p class="admin-file-note">Gambar saat ini: {{ $project->image }}. Kosongkan kalau tidak diganti.</p>
                @endif

                <x-adminlte-select name="is_active" label="Status" required>
                    <option value="1" @selected(old('is_active', $project->is_active ?? true) == 1)>Aktif (tampil di situs publik)</option>
                    <option value="0" @selected(old('is_active', $project->is_active ?? true) == 0)>Arsip (disembunyikan)</option>
                </x-adminlte-select>

                <button class="btn btn-primary">Simpan</button>
                <a class="btn" href="{{ route('admin.projects.index') }}">Batal</a>
            </form>
        </div>
    </section>
@endsection
