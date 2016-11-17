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
        $manager = new Manager(new Client, $this->app['cache'], [
            'cacheLength' => $this->app['config']->has('packagist.cache.length') ? $app['config']['packagist.cache.length'] : 60,
            'numberFormatting' => $this->app['config']->has('packagist.formatting.enabled') ? $app['config']['packagist.formatting.enabled'] : true,
            'numberDecimals' => $this->app['config']->has('packagist.formatting.decimals') ? $app['config']['packagist.formatting.decimals'] : 0,
            'numberDecimalPoints' => $this->app['config']->has('packagist.formatting.decimal_points') ? $app['config']['packagist.formatting.decimal_points'] : '.',
            'numberDecimalSeparator' => $this->app['config']->has('packagist.formatting.decimal_separator') ? $app['config']['packagist.formatting.decimal_separator'] : ',',
        ]);

        $this->app->singleton('packagist', function () use ($manager) {
            return new Packagist($manager);
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
