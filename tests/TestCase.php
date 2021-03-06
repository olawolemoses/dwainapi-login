<?php

namespace Dwaincore\Authmgt\Tests;

use Dwaincore\Authmgt\AuthmgtServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;

use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Dwaincore\\Authmgt\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        Route::authmgt('authentication');
    }

    protected function getPackageProviders($app)
    {
        return [
            AuthmgtServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        /*
        include_once __DIR__.'/../database/migrations/create_authmgt_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
