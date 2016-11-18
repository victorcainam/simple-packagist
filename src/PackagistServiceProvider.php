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
        $this->mergeConfigFrom(
            __DIR__.'/config/packagist.php', 'packagist'
        );

        $manager = new Manager(new Client, $this->app['cache'], $this->app->config['packagist']);

        $this->app->singleton('packagist', function () use ($manager) {
            return new Packagist($manager);
        });
    }

    /**
     * Boots the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/packagist.php' => config_path('packagist.php'),
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Packagist::class];
    }
}
