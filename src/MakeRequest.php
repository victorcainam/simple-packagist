<?php

namespace SimpleSoftwareIO\Packagist;

trait MakeRequest
{
    protected function request()
    {
        $response = $this->client->get($this->endPoint, [
            'query' => $this->params
        ]);

        return json_decode($response->getBody());
    }
}