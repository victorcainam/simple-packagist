<?php

namespace SimpleSoftwareIO\Packagist;

class Package implements Request
{

    protected $endPoint = 'https://packagist.org/packages/list.json';

    public function get() {
        return $this->endPoint;
    }
}