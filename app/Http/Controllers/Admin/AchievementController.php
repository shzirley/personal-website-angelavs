<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class AchievementController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:lihat-prestasi', only: ['index']),
            new Middleware('permission:tambah-prestasi', only: ['create', 'store']),
            new Middleware('permission:edit-prestasi', only: ['edit', 'update']),
            new Middleware('permission:hapus-prestasi', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'year' => ['nullable', 'integer', 'between:1900,2100'],
        ]);
        $search = $filters['q'] ?? null;

        $achievements = Achievement::query()
            ->when(filled($search), fn ($query) => $query->where(
                fn ($sub) => $sub->where('title', 'like', "%{$search}%")
                    ->orWhere('event', 'like', "%{$search}%")
                    ->orWhere('organizer', 'like', "%{$search}%")
            ))
            ->when(filled($filters['year'] ?? null), fn ($query) => $query->where('year', $filters['year']))
            ->orderByDesc('year')
            ->orderBy('id')
            ->paginate(5)
            ->withQueryString();

        return view('admin.achievements.index', [
            'achievements' => $achievements,
            'years' => Achievement::distinct()->orderByDesc('year')->pluck('year'),
        ]);
    }

    public function create(): View
    {
        return view('admin.achievements.form', ['achievement' => new Achievement()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Achievement::create($this->validated($request));

        return redirect()->route('admin.achievements.index')->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function edit(Achievement $achievement): View
    {
        return view('admin.achievements.form', compact('achievement'));
    }

    public function update(Request $request, Achievement $achievement): RedirectResponse
    {
        $achievement->update($this->validated($request));

        return redirect()->route('admin.achievements.index')->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Achievement $achievement): RedirectResponse
    {
        $achievement->delete();

        return back()->with('success', 'Prestasi berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'year' => ['required', 'integer', 'between:1900,2100'],
            'title' => ['required', 'string', 'max:255'],
            'event' => ['required', 'string', 'max:255'],
            'organizer' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'document' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        // No new file on edit means keep the current one.
        foreach (['image' => 'images/achievements', 'document' => 'documents'] as $field => $directory) {
            unset($data[$field]);

            if ($request->hasFile($field)) {
                $data[$field] = $this->storePublicUpload($request->file($field), $directory);
            }
        }

        return $data;
    }
}
