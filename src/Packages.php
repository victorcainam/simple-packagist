<?php

namespace SimpleSoftwareIO\Packagist;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Packages implements Request
{
    use MakeRequest;

    protected $endPoint = 'https://packagist.org/packages/list.json';

    public function __construct(Client $client, Cache $cache, array $params)
    {
        $this->client = $client;
        $this->cache = $cache;
        $this->params = $params;
    }

    public function get()
    {
        return $this->request();
    }

    public function packages()
    {
        return $this->get()->packageNames;
    }

    public function package($package)
    {
        return new Package($this->client, $this->cache, $package);
    }
}