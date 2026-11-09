<?php

namespace App\Providers;

use App\Models\Achievement;
use App\Models\Project;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        View::share('profile', config('portfolio'));

        // Models support array access, so the public views keep their existing shape.
        View::composer(['home', 'projects', 'project', 'collection', 'resume'], function ($view): void {
            $view->with('profile', array_merge(config('portfolio'), [
                'projects' => Project::where('is_active', true)->orderBy('id')->get()->keyBy('slug')->all(),
                'achievements' => Achievement::orderByDesc('year')->orderBy('id')->get()->all(),
            ]));
        });
    }
}
