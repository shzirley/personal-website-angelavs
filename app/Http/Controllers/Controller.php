<?php

namespace App\Http\Controllers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

abstract class Controller
{
    // shortcut: replaced or deleted uploads stay on disk because seeded files are tracked in git, add cleanup if storage matters.
    protected function storePublicUpload(UploadedFile $file, string $directory): string
    {
        // Random name plus content-based extension: the client's filename is never trusted.
        $name = Str::uuid().'.'.$file->extension();
        $file->move(public_path($directory), $name);

        return $name;
    }
}
