<?php

namespace SimpleSoftwareIO\Packagist;

abstract class Request
{
    abstract public function get();

    abstract protected function endPoint();
}