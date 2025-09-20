<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Project;
use App\Policies\ProjectPolicy;
use App\Services\CommonService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CommonService::class, function ($app) {
        return new CommonService();
    });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
            Paginator::defaultView('vendor.pagination.tailwind');

            Gate::policy(Project::class, ProjectPolicy::class);
    }
}
