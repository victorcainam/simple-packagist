<?php

namespace SimpleSoftwareIO\Packagist;

trait MakeRequest
{
    /**
     * The namespace to store everything under within the cache.
     *
     * @var string
     */
    protected $namespace = 'simple-packagist';

    /**
     * Makes the API request.
     *
     * @return mixed
     */
    protected function request()
    {
        $params = isset($this->params) ? $this->params : null;

        if (! $this->manager->getConfig('cache.enable')) {
            return $this->fetch($params);
        }

        $key = $this->create_key($this->endPoint(), $params);

        return $this->manager->getCache()->remember($key, $this->manager->getConfig('cache.length'), function () use ($params) {
            return $this->fetch($params);
        });
    }

    /**
     * Performs the Guzzle request to the endpoint with the params.
     *
     * @param $params
     * @return mixed
     */
    protected function fetch($params)
    {
        $response = $this->manager->getClient()->get($this->endPoint(), [
            'query' => $params,
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Returns a cache key.
     *
     * @param $endPoint
     * @param $params
     * @return string
     */
    protected function create_key($endPoint, $params)
    {
        $params = serialize($params);

        return $this->namespace.':'.sha1($endPoint.$params);
    }
}
