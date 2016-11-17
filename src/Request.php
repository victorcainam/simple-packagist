<?php

namespace SimpleSoftwareIO\Packagist;

abstract class Request
{
    /**
     * Fires off the API request.
     *
     * @return Collection
     */
    abstract public function get();

    /**
     * Genereates the API endpoint.
     *
     * @return string
     */
    abstract protected function endPoint();
}