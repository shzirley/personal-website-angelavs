<?php

// Only the rules the admin forms use; anything else falls back to English.
return [
    'alpha_dash' => ':attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
    'between' => ['numeric' => ':attribute harus antara :min sampai :max.'],
    'boolean' => ':attribute tidak valid.',
    'file' => ':attribute harus berupa file.',
    'image' => ':attribute harus berupa gambar.',
    'in' => ':attribute tidak valid.',
    'integer' => ':attribute harus berupa angka.',
    'max' => [
        'string' => ':attribute maksimal :max karakter.',
        'file' => ':attribute maksimal :max KB.',
    ],
    'mimes' => ':attribute harus berformat: :values.',
    'required' => ':attribute wajib diisi.',
    'string' => ':attribute harus berupa teks.',
    'unique' => ':attribute sudah dipakai.',
    'uploaded' => ':attribute gagal diunggah.',
    'attributes' => [
        'title' => 'Judul',
        'slug' => 'Slug',
        'category' => 'Kategori',
        'role' => 'Peran',
        'year' => 'Tahun',
        'summary' => 'Ringkasan',
        'description' => 'Deskripsi',
        'responsibilities' => 'Tanggung jawab',
        'highlight' => 'Highlight',
        'image' => 'Gambar',
        'document' => 'Sertifikat',
        'event' => 'Ajang',
        'organizer' => 'Penyelenggara',
        'is_active' => 'Status',
    ],
];
