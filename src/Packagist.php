<?php

namespace SimpleSoftwareIO\Packagist;

use GuzzleHttp\Client;
use Illuminate\Cache\CacheManager as Cache;
use Illuminate\Support\Collection;

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
     * Packagist constructor.
     *
     * @param Client $client
     * @param Cache $cache
     */
    public function __construct(Client $client, Cache $cache)
    {
        $this->client = $client;
        $this->cache = $cache;
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

        return new Packages($this->client, $this->cache, $params);
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
        return new Package($this->client, $this->cache, $vendor, $package);
    }
}
