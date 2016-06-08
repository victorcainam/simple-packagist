<?php

namespace SimpleSoftwareIO\Packagist\Facades;

use Illuminate\Support\Facades\Facade;

class Packagist extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'packagist'; }
}
