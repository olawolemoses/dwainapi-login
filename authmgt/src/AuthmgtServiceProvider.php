<?php

namespace Dwaincore\Authmgt;

use Dwaincore\Authmgt\Commands\AuthmgtCommand;
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

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'authmgt');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/authmgt.php', 'authmgt');
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
