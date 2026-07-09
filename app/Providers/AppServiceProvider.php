<?php

namespace App\Providers;

use App\Models\AppProfile;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::useTailwind();

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Super admin lewat semua policy
        Gate::before(fn ($user) => $user->hasRole('super_admin') ? true : null);

        RateLimiter::for('api', fn (Request $r) =>
            Limit::perMinute(60)->by($r->user()?->id ?: $r->ip())
        );
        RateLimiter::for('login', fn (Request $r) =>
            Limit::perMinute(5)->by($r->ip())
        );

        // Branding (nama/logo/favicon/warna) dari AppProfile, dipakai di layout & welcome.
        View::composer(['layouts.app', 'welcome'], function ($view) {
            $view->with('appProfile', AppProfile::current());
        });
    }
}
