@extends('adminlte::page')

@include('admin.partials.shell')

@section('title', $achievement->exists ? 'Edit Prestasi' : 'Tambah Prestasi')

@section('content_header')
    @include('admin.partials.heading', [
        'path' => $achievement->exists ? 'admin / achievements / edit' : 'admin / achievements / new',
        'eyebrow' => 'AWARD FILE',
        'title' => $achievement->exists ? 'Edit' : 'Tambah',
        'accent' => 'prestasi.',
    ])
@endsection

@section('content')
    <section class="window">
        <div class="window-bar"><span>{{ $achievement->exists ? 'edit_award.txt' : 'new_award.txt' }}</span><span class="window-controls" aria-hidden="true">— □ ×</span></div>
        <div class="window-body">
            @include('admin.partials.errors')

            <form method="POST" enctype="multipart/form-data"
                action="{{ $achievement->exists ? route('admin.achievements.update', $achievement) : route('admin.achievements.store') }}">
                @csrf
                @if ($achievement->exists)
                    @method('PUT')
                @endif

                <x-adminlte-input name="event" label="Ajang" :value="old('event', $achievement->event)" required />
                <x-adminlte-input name="title" label="Capaian (contoh: Finalist)" :value="old('title', $achievement->title)" required />
                <x-adminlte-input name="organizer" label="Penyelenggara" :value="old('organizer', $achievement->organizer)" required />
                <x-adminlte-input name="year" label="Tahun" type="number" min="1900" max="2100" :value="old('year', $achievement->year)" required />
                <x-adminlte-textarea name="description" label="Deskripsi" rows="3" required>{{ old('description', $achievement->description) }}</x-adminlte-textarea>
                <x-adminlte-input name="image" type="file" accept=".jpg,.jpeg,.png,.webp" label="Gambar (JPG, PNG, atau WEBP, maks 4 MB, boleh kosong)" />
                @if ($achievement->image)
                    <p class="admin-file-note">Gambar saat ini: {{ $achievement->image }}. Kosongkan kalau tidak diganti.</p>
                @endif
                <x-adminlte-input name="document" type="file" accept=".pdf" label="Sertifikat (PDF, maks 5 MB, boleh kosong)" />
                @if ($achievement->document)
                    <p class="admin-file-note">Sertifikat saat ini: {{ $achievement->document }}. Kosongkan kalau tidak diganti.</p>
                @endif

                <button class="btn btn-primary">Simpan</button>
                <a class="btn" href="{{ route('admin.achievements.index') }}">Batal</a>
            </form>
        </div>
    </section>
@endsection
