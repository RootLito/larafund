<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\Models\ProcurementProject;

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
        View::composer('*', function ($view) {
            $today = Carbon::today();
            $inSevenDays = $today->copy()->addDays(7);

            $reminders = collect();

            foreach (ProcurementProject::all() as $project) {
                $dates = json_decode($project->post_qualification, true) ?: [];
                $lotDescriptions = json_decode($project->lot_description, true) ?: [];

                foreach ($dates as $index => $date) {
                    if ($date && Carbon::parse($date)->between($today, $inSevenDays)) {
                        $reminders->push(Carbon::parse($date));
                    }
                }
            }

            $view->with('upcomingCount', $reminders->count());
            $view->with('upcomingDates', $reminders->sort()->values());
        });
    }
}
