<?php

namespace SimpleSoftwareIO\Packagist;

use GuzzleHttp\Client;
use Illuminate\Contracts\Cache\Factory as Cache;

class Manager
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
     * Holds the config array.
     *
     * @var array
     */
    protected $config;

    /**
     * Manager constructor.
     *
     * @param Client $client
     * @param Cache $cache
     * @param array $config
     */
    public function __construct(Client $client, Cache $cache, array $config = [])
    {
        $this->client = $client;
        $this->cache = $cache;
        $this->config = $config;
    }

    /**
     * Returns the Guzzle HTTP Client.
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Returns the Laravel Cache Manager.
     *
     * @return Cache
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * Returns the requested configuration variable.
     *
     * @param $key
     * @return mixed
     */
    public function getConfig($key)
    {
        if (! isset($this->config[$key])) {
            return;
        }

        return $this->config[$key];
    }
}
