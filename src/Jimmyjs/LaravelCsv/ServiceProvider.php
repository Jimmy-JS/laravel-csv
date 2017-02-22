<?php

namespace Jimmyjs\LaravelCsv;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->singleton('laravel-csv', function ($app) {
            return new CsvLaravelWrapper($app);
        });

        $this->registerAliases();
	}

	protected function registerAliases()
	{
	    if (class_exists('Illuminate\Foundation\AliasLoader')) {
	        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
	        $loader->alias('CSV', \Jimmyjs\LaravelCsv\Facade::class);
	    }
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}
