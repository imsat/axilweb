<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerModuleServiceProviders();
    }

    public function boot(): void
    {
        $this->loadModuleRoutes();
    }

    protected function registerModuleServiceProviders(): void
    {
        foreach (File::directories(base_path('modules')) as $moduleDirectory) {
            $providerFiles = File::glob($moduleDirectory . '/Providers/*.php');

            foreach ($providerFiles as $providerFile) {
                $this->registerServiceProvider($moduleDirectory, $providerFile);
            }
        }
    }

    protected function registerServiceProvider(string $moduleDirectory, string $providerFile): void
    {
        $moduleName = basename($moduleDirectory);
        $providerName = basename($providerFile, '.php');
        $className = "Modules\\{$moduleName}\\Providers\\{$providerName}";

        if (class_exists($className)) {
            $this->app->register($className);
        }
    }

    protected function loadModuleRoutes()
    {
        foreach (File::directories(base_path('modules')) as $moduleDirectory) {
            $apiRoutePath = $moduleDirectory . '/Routes/api.php';
            $webRoutePath = $moduleDirectory . '/Routes/web.php';
            // Check if the API route file exists and set up the API routes first
            if (file_exists($apiRoutePath)) {
                Route::middleware('api')
                    ->prefix('api')
                    ->group($apiRoutePath);
            }

            // Check if the Web route file exists and set up the Web routes last
            if (file_exists($webRoutePath)) {
                Route::middleware('web')
                    ->group($webRoutePath);
            }
        }
    }
}
