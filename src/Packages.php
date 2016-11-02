<?php

namespace SimpleSoftwareIO\Packagist;

use GuzzleHttp\Client;
use Illuminate\Cache\CacheManager as Cache;
use Illuminate\Support\Collection;

class Packages extends Request
{
    use MakeRequest;

    /**
     * The Guzzle Http Client.
     *
     * @GuzzleHttp\Client
     */
    protected $client;

    /**
     * The Laravel Cache facade.
     *
     * @var Cache
     */
    protected $cache;

    /**
     * Packagist constructor.
     *
     * @param Client $client
     * @param Cache $cache

    /**
     * The API endpoint.
     *
     * @var string
     */
    protected $endPoint = 'https://packagist.org/packages/list.json';

    /**
     * Constructs the Packages object.
     *
     * Packages constructor.
     * @param Client $client
     * @param Cache $cache
     * @param array $params
     */
    public function __construct(Client $client, Cache $cache, array $params)
    {
        $this->client = $client;
        $this->cache = $cache;
        $this->params = $params;
    }

    /**
     * Fires off the API request.
     *
     * @return Collection
     */
    public function get()
    {
        $response = $this->request();

        $packages = new Collection($response['packageNames']);
        $packages = $packages->map(function ($package) {
            return $this->package($package);
        });

        return $packages;
    }

    /**
     * Friendly helper to fire API request.
     *
     * @return Collection
     */
    public function packages()
    {
        return $this->get();
    }

    /**
     * Creates the Package objects.
     *
     * @param $package
     * @return Package
     */
    public function package($package)
    {
        $split = explode('/', $package);

        return new Package($this->client, $this->cache, $split[0], $split[1]);
    }

    /**
     * Genereates the API endpoint.
     *
     * @return string
     */
    protected function endPoint()
    {
        return $this->endPoint;
    }
}