<?php

namespace SimpleSoftwareIO\Packagist;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

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

    public function __construct(Client $client, Cache $cache)
    {
        $this->client = $client;
        $this->cache = $cache;
    }

    public function vendor($vendor)
    {
        if (is_string($vendor)) $vendor = ['vendor' => $vendor];

        return new Packages($this->client, $this->cache, $vendor);
    }

    public function search(array $params)
    {
        return new Search($this->client, $this->cache, $params);
    }
}
