<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Project;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalProjects' => Project::count(),
            'totalAchievements' => Achievement::count(),
            'totalUsers' => User::count(),
            'recentProjects' => Project::orderByDesc('is_active')->latest('id')->limit(5)->get(),
        ]);
    }
}
