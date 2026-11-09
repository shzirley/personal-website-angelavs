<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProjectController extends Controller implements HasMiddleware
{
    // Laravel 11+ replacement for $this->middleware() in the constructor.
    public static function middleware(): array
    {
        return [
            new Middleware('permission:lihat-proyek', only: ['index']),
            new Middleware('permission:tambah-proyek', only: ['create', 'store']),
            new Middleware('permission:edit-proyek', only: ['edit', 'update']),
            new Middleware('permission:hapus-proyek', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', Rule::in(Project::CATEGORIES)],
            'status' => ['nullable', Rule::in(['0', '1'])],
        ]);
        $search = $filters['q'] ?? null;

        // filled(), not truthiness: status "0" must still apply.
        $projects = Project::query()
            ->when(filled($search), fn ($query) => $query->where(
                fn ($sub) => $sub->where('title', 'like', "%{$search}%")->orWhere('role', 'like', "%{$search}%")
            ))
            ->when(filled($filters['category'] ?? null), fn ($query) => $query->where('category', $filters['category']))
            ->when(filled($filters['status'] ?? null), fn ($query) => $query->where('is_active', $filters['status']))
            ->orderByDesc('is_active')
            ->latest('id')
            ->paginate(5)
            ->withQueryString();

        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('admin.projects.form', ['project' => new Project()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Project::create($this->validated($request));

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil ditambahkan.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.form', compact('project'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $project->update($this->validated($request, $project));

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return back()->with('success', 'Proyek berhasil dihapus.');
    }

    private function validated(Request $request, ?Project $project = null): array
    {
        // Spaces in a typed slug become hyphens, and a blank slug comes from the title.
        $slug = $request->input('slug') ?: $request->input('title');
        $request->merge(['slug' => is_string($slug) ? Str::slug($slug) : '']);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'alpha_dash', 'max:255', Rule::unique('projects', 'slug')->ignore($project)],
            'category' => ['required', Rule::in(Project::CATEGORIES)],
            'role' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:20'],
            'summary' => ['required', 'string', 'max:2000'],
            'description' => ['required', 'string', 'max:5000'],
            'responsibilities' => ['required', 'string', 'max:5000'],
            'highlight' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active' => ['required', 'boolean'],
        ]);

        $lines = array_map('trim', preg_split('/\R/', $data['responsibilities']));
        $data['responsibilities'] = array_values(array_filter($lines));

        // No new file on edit means keep the current one.
        unset($data['image']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->storePublicUpload($request->file('image'), 'images/projects');
        }

        return $data;
    }
}
