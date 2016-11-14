<?php

namespace SimpleSoftwareIO\Packagist;

use GuzzleHttp\Client;
use Illuminate\Contracts\Cache\Factory as Cache;

class Packagist
{
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
     * The amount of time to cache the results.
     *
     * @var integer
     */
    protected $cacheLength;

    /**
     * Packagist constructor.
     *
     * @param Client $client
     * @param Cache $cache
     */
    public function __construct(Client $client, Cache $cache, $cacheLength)
    {
        $this->client = $client;
        $this->cache = $cache;
        $this->cacheLength = $cacheLength;
    }

    /**
     * Gets all of the packages on Packagist.
     *
     * @return Packages
     */
    public function all()
    {
        return $this->packages();
    }

    /**
     * Gets all of the packages on Packagist for a vendor.
     *
     * @param $vendor
     * @return Collection
     */
    public function vendor($vendor)
    {
        return $this->packages(['vendor' => $vendor]);
    }

    /**
     * Searches Packagist for all packages of a type.
     *
     * @param $type
     * @return Collection
     */
    public function type($type)
    {
        return $this->packages(['type' => $type]);
    }

    /**
     * Gets all packages for the matching params.
     *
     * @param array $params
     * @return Packages
     */
    public function packages($params = [])
    {
        if (is_string($params)) $params = ['vendor' => $params];

        return (new Packages($this->client, $this->cache, $this->cacheLength, $params))->get();
    }

    /**
     * Gets the information for a package.
     *
     * @param $vendor
     * @param $package
     * @return Package
     */
    public function package($vendor, $package)
    {
        return new Package($this->client, $this->cache, $this->cacheLength, $vendor, $package);
    }
}
