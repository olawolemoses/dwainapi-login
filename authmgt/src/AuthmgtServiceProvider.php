<?php

namespace Dwaincore\Authmgt;

use Dwaincore\Authmgt\Commands\AuthmgtCommand;
use Dwaincore\Authmgt\Http\Controllers\AuthenticateController;
use Dwaincore\Authmgt\Http\Controllers\HomeController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AuthmgtServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/authmgt.php' => config_path('authmgt.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/authmgt'),
            ], 'views');

            $migrationFileName = 'create_authmgt_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }

            $this->commands([
                AuthmgtCommand::class,
            ]);
        }

        $this->registerRoutes();

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'authmgt');


    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/authmgt.php', 'authmgt');
    }

    protected function registerRoutes()
    {
        Route::macro('authmgt', function ($prefix) {
            Route::prefix($prefix)->group(function () {
                Route::middleware(['auth:sanctum'])->group(function () {
                    Route::get('/home', '\\' . HomeController::class);
                });
                Route::post('/login', '\\' . AuthenticateController::class)->name('login');
            });
        });
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
