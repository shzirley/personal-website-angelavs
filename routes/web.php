<?php

use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\PortfolioController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'home'])->name('home');
Route::get('/mahasiswa/{nrp}', [PortfolioController::class, 'about'])->where('nrp', '[0-9]{10}')->name('mahasiswa.show');
Route::get('/about', fn () => redirect()->route('mahasiswa.show', ['nrp' => config('portfolio.nrp')]))->name('about');
Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects.index');
Route::get('/projects/{project}', [PortfolioController::class, 'project'])->name('projects.show');
Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator.index');
Route::get('/calculator/submit', [CalculatorController::class, 'submit'])->name('calculator.submit');
Route::get('/hitung-ipk/{ip1}/{ip2}', [CalculatorController::class, 'result'])->name('calculator.result');

Route::prefix('dashboard')->name('dashboard.')->group(function (): void {
    Route::get('/', [PortfolioController::class, 'dashboard'])->name('index');
    Route::get('/mahasiswa/{nrp}', [PortfolioController::class, 'about'])->where('nrp', '[0-9]{10}')->name('mahasiswa.show');
});

// Keep the original portfolio's secondary capabilities available.
Route::get('/collection', [PortfolioController::class, 'collection'])->name('collection');
Route::get('/contact', [PortfolioController::class, 'contact'])->name('contact');
Route::get('/resume', [PortfolioController::class, 'resume'])->name('resume');
Route::get('/resume/download', [PortfolioController::class, 'downloadResume'])->name('resume.download');
// Breeze redirects here after login, registration and email verification.
Route::get('/login-redirect', fn (Request $request) => redirect()->route(
    $request->user()->hasAnyRole(['Admin', 'Staf']) ? 'admin.dashboard' : 'home'
))->middleware('auth')->name('dashboard');

Route::post('/demo-login/{role}', function (Request $request, string $role) {
    abort_unless(app()->isLocal(), 404);
    Auth::login(User::where('email', "{$role}@angelaos.test")->firstOrFail());
    $request->session()->regenerate();

    return redirect()->route('dashboard');
})->middleware('guest')->whereIn('role', ['admin', 'staf'])->name('demo-login');

Route::middleware(['auth', 'verified', 'role:Admin|Staf'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('projects', ProjectController::class)->except('show');
    Route::resource('achievements', AchievementController::class)->except('show');
});

require __DIR__.'/auth.php';

Route::fallback(fn () => response()->view('errors.404', [], 404))->name('fallback');
