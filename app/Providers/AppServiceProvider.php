<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
//call by jalaj for state list for all forms
use Illuminate\Support\Facades\View;
use App\Models\LgdStateDistricts;
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
        //
        // Share states list with multiple views
        View::composer(['industry.register', 'insurance.register', 'auth.register'], function ($view) {
            $states = LgdStateDistricts::select('state_code', 'state_name')
                ->groupBy('state_code', 'state_name')
                ->orderBy('state_name')
                ->get();

            $view->with('states', $states);
        });
    }
}
