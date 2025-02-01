<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Absence;
use App\Models\Department;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.DashboardLayout', function ($view) {
            $view->with([
                'totalUsuarios' => User::count(),
                'totalAusencias' => Absence::count(),
                'totalDepartamentos' => Department::count(),
            ]);
        });
    }
}
