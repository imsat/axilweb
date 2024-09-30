<?php

namespace Modules\PreOrder\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Modules\PreOrder\Interfaces\PreOrderInterface;
use Modules\PreOrder\Interfaces\ProductInterface;
use Modules\PreOrder\Services\PreOrderService;
use Modules\PreOrder\Services\ProductService;

class PreOrderServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register your module services here
        $this->app->bind(ProductInterface::class, ProductService::class);
        $this->app->bind(PreOrderInterface::class, PreOrderService::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'preorder');
        $this->loadViewsFrom(__DIR__ . '/../Views', 'preorder');

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
