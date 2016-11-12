<?php

namespace SimpleSoftwareIO\Packagist;

use GuzzleHttp\Client;
use Illuminate\Cache\CacheManager as Cache;
use Illuminate\Support\Collection;

class Package extends Request
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
     * The default cache length.
     *
     * @var integer
     */
    protected $cacheLength;

    /**
     * The package's vendor.
     *
     * @var string
     */
    protected $vendor;

    /**
     * The package name.
     *
     * @var string
     */
    protected $package;

    /**
     * The API endpoint.
     *
     * @var string
     */
    protected $endPoint = 'https://packagist.org/packages';

    /**
     * Package constructor.
     *
     * @param Client $client
     * @param Cache $cache
     * @param $cacheLength
     * @param string $vendor
     * @param string $package
     */
    public function __construct(Client $client, Cache $cache, $cacheLength, $vendor, $package)
    {
        $this->client = $client;
        $this->cache = $cache;
        $this->cacheLength = $cacheLength;
        $this->vendor = $vendor;
        $this->package = $package;
    }

    /**
     * Fires the API request.
     *
     * @return Collection
     */
    public function get()
    {
        return new Collection($this->request()['package']);
    }

    /**
     * Constructs the API endpoint.
     *
     * @return string
     */
    protected function endPoint()
    {
        return "{$this->endPoint}/{$this->vendor}/{$this->package}.json";
    }

    /**
     * Returns a collection containing the downloads.
     *
     * @param null|string $version
     * @return Collection
     */
    public function downloads($version = null)
    {
        $downloads = new Downloads($this->client, $this->cache, $this->cacheLength, $this->vendor, $this->package);

        if ( ! empty($version)) return $downloads->get()['versions'][$version];

        return $downloads->get();
    }

    /**
     * Used to retrieve different statistics about a package.
     *
     * @param string $name
     * @param array $version
     * @return mixed
     */
    public function __call($name, array $version)
    {
        if ( ! empty($version)) return $this->get()['versions'][$version[0]][$name];

        return $this->get()[$name];
    }
}