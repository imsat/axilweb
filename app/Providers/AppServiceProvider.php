<?php

namespace App\Providers;

use App\Interfaces\PreOrderInterface;
use App\Interfaces\ProductInterface;
use App\Models\PreOrder;
use App\Policies\PreOrderPolicy;
use App\Services\PreOrderService;
use App\Services\ProductService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Service & interface bind
        $this->app->bind(ProductInterface::class, ProductService::class);
        $this->app->bind(PreOrderInterface::class, PreOrderService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate for viewing pre-orders (both admin and manager can view)
        Gate::define('view-preorders', function ($user) {
            return $user->role === 'admin' || $user->role === 'manager';
        });

        // Gate for other actions (only admin can create, update, delete)
        Gate::define('manage-preorders', function ($user) {
            return $user->role === 'admin';
        });

        // Rate limit all apis endpoint
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(40)->by($request->user()?->id ?: $request->ip());
        });

        // Custom rate limit for 10 per minute
        RateLimiter::for('form-submissions', function ($request) {
            return Limit::perMinute(10)->by($request->ip());
        });
    }
}
