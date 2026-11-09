<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PortfolioController
{
    public function home(): View
    {
        return view('home');
    }

    public function about(string $nrp): View
    {
        abort_unless($nrp === config('portfolio.nrp'), 404);

        return view('about');
    }

    public function projects(): View
    {
        return view('projects');
    }

    public function project(string $project): View
    {
        $record = Project::where('is_active', true)->where('slug', $project)->firstOrFail();

        return view('project', ['project' => $record, 'selectedSlug' => $project]);
    }

    public function dashboard(): View
    {
        return view('dashboard');
    }

    public function collection(): View
    {
        return view('collection');
    }

    public function contact(): View
    {
        return view('contact');
    }

    public function resume(): View
    {
        return view('resume');
    }

    public function downloadResume(): BinaryFileResponse
    {
        $path = storage_path('app/public/resume/Angela_Vania_Sugiyono_Resume_2026.pdf');
        abort_unless(is_file($path), 404);

        return response()->download($path, 'Angela_Vania_Sugiyono_Resume_2026.pdf');
    }
}
