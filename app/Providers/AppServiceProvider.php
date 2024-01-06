<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $PATH = (config('app.env') !== 'local'? env('PRO_PUBLIC_PATH', 'public'): 'public');
        if($PATH !== 'public'){
            $this->app->bind('path.public', function()
            {
                    // return base_path('public_html');
                    return base_path($PATH);
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void
    // {
    //     //
    // }

    /**
     * Bootstrap any application services.
     */
    public function boot(UrlGenerator $url): void
    {
        if (env('APP_ENV') == 'production') {
            $url->forceScheme('https');
        }
    }
}
