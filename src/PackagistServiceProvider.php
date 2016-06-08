<?php

namespace SimpleSoftwareIO\Packagist;

use Illuminate\Support\ServiceProvider;

class PackagistServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('packagist', function () {
            return new Packagist();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['packagist'];
    }

}
