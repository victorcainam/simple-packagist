<?php

namespace SimpleSoftwareIO\Packagist;

use GuzzleHttp\Client;
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
        $this->app->singleton('packagist', function ($app) {

            $cacheLength = $app['config']->has('cache.packagist.length') ? $app['config']['cache.packagist.length'] : 60;

            return new Packagist(
                new Client,
                $app['cache'],
                $cacheLength
            );
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
