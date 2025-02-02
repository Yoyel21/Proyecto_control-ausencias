<?php

namespace App\Providers;

use App\Enums\Hour;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Absence;
use App\Models\Department;
use Carbon\Carbon;

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

        View::composer('absences.index', function ($view) {
            $currentDate = request()->query('daily_date', Carbon::now()->toDateString());
            $currentHour = request()->query('daily_hour', '1manana');

            // Obtener todas las franjas horarias (opcional si las necesitas en la vista)
            $timeSlots = collect(range(8, 20))->map(function ($hour) {
                return sprintf('%02d:00', $hour);
            });

            // Obtener las ausencias diarias
            $dailyAbsences = Absence::where('date', $currentDate)
                ->where('hour', $currentHour)
                ->with('user', 'department')
                ->get();

            $view->with([
                'currentDate' => $currentDate,
                'currentHour' => $currentHour,
                'dailyAbsences' => $dailyAbsences,
                'timeSlots' => $timeSlots,
            ]);
        });

        View::composer('absences.index', function ($view) {
            $selectedDate = request()->query('weekly_date', Carbon::now()->toDateString());
            $selectedHour = request()->query('weekly_hour', '1manana'); 

            $weeklyAbsences = Absence::where('date', $selectedDate)
                ->where('hour', $selectedHour)
                ->with('user', 'department')
                ->get();

            $timeSlots = Hour::cases();

            $view->with([
                'selectedDate' => $selectedDate,
                'selectedHour' => $selectedHour,
                'weeklyAbsences' => $weeklyAbsences,
                'timeSlots' => $timeSlots,
            ]);
        });
    }
}
