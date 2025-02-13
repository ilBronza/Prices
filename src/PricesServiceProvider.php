<?php

namespace IlBronza\Prices;

use IlBronza\Prices\Models\Price;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class PricesServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
	    Relation::morphMap([
		    'Price' => Price::gpc(),
	    ]);


	    // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'ilbronza');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'ilbronza');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
	    $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'prices');

        if (app() instanceof \Illuminate\Foundation\Application)
            $this->loadRoutesFrom(__DIR__.'/routes/prices.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/prices.php', 'prices');

        // Register the service the package provides.
        $this->app->singleton('prices', function ($app) {
            return new Prices;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['prices'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/prices.php' => config_path('prices.php'),
        ], 'prices.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/ilbronza'),
        ], 'prices.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/ilbronza'),
        ], 'prices.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/ilbronza'),
        ], 'prices.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
