<?php

namespace SimpleSoftwareIO\Packagist;

trait MakeRequest
{
    /**
     * Makes the API request.
     *
     * @return mixed
     */
    protected function request()
    {
        $params = isset($this->params) ? $this->params : null;

        $key = $this->create_key($this->endPoint(), $params);

        return $this->cache->remember($key, 10, function() use ($params) {
            $response = $this->client->get($this->endPoint(), [
                'query' => $params
            ]);

            return json_decode($response->getBody(), true);
        });
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

        return sha1($endPoint . $params);
    }
}