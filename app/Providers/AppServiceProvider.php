<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Artisan::call('migrate');
        // Artisan::call('db:seed');

        view()->share('settings', Setting::select([
            'logo_header',
            'fave_icon',
            'logo_footer',
            'app_name',
            'governorate',
            'phones',
            'email',
            'address',
            'lat',
            'lng',
            'facebook',
            'twitter',
            'linkedin',
            'youtube',
        ])->first());

        Auth::macro('canAny', function (array $permissions) {
            $user = Auth::user();

            foreach ($permissions as $permission) {
                if ($user && $user->can($permission)) {
                    return true;
                }
            }

            return false;
        });

        // Add Blade directive for canAny
        Blade::directive('canany', function ($permissions) {
            return "<?php if(Auth::canAny($permissions)): ?>";
        });

        Blade::directive('endcanany', function () {
            return "<?php endif; ?>";
        });
    }
}
