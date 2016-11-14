<?php

namespace SimpleSoftwareIO\Packagist;

use GuzzleHttp\Client;
use Illuminate\Contracts\Cache\Factory as Cache;
use Illuminate\Support\Collection;

class Downloads extends Request
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
     * Downloads constructor.
     *
     * @param Client $client
     * @param Cache $cache
     * @param $cacheLength
     * @param $vendor
     * @param $package
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
     * Fires off the API request.
     *
     * @return Collection
     */
    public function get()
    {
        $response = $this->request()['package']['downloads'];

        $collection = new Collection($response['total']);
        $collection = $collection->merge(['versions' => $response['versions']]);

        return $collection;
    }

    /**
     * Generates the API endpoint.
     *
     * @return string
     */
    protected function endPoint()
    {
        return "{$this->endPoint}/{$this->vendor}/{$this->package}/downloads.json";
    }

}