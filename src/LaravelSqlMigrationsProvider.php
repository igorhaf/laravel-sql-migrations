<?php

namespace Igorhaf\LaravelSqlMigrations;

use Illuminate\Support\ServiceProvider;

class LaravelSqlMigrationsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Include the package classmap autoloader
        if (\File::exists(__DIR__ . '/../vendor/autoload.php')) {
            include __DIR__ . '/../vendor/autoload.php';
        }


        // Publish configurations to config/vendor/vendor-name/package-name
        // Config::get('vendor.yk.laravel-package-example')
        $this->publishes([
            __DIR__.'/config' => config_path(),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Igorhaf\LaravelSqlMigrations\Console\Commands\SqlFresh::class,
                \Igorhaf\LaravelSqlMigrations\Console\Commands\SqlMigrate::class,
                \Igorhaf\LaravelSqlMigrations\Console\Commands\SqlMigration::class,
            ]);
        }

    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Merge configurations
         * Config::get('packages.Yk.LaravelPackageExample')
         */
        $this->mergeConfigFrom(
            __DIR__.'/config/sqlmigrations.php', 'sqlmigrations'
        );
    }
}
