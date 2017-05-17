<?php

use Illuminate\Support\Collection;
use SimpleSoftwareIO\Packagist\Packages;

class PackagesTest extends ManagerSetup
{
    public function test_it_calls_the_correct_endpoint()
    {
        $response = (new Packages($this->createManager(), []))->get();

        $endpoint = strval($this->history[0]['request']->getUri());

        $this->assertEquals('https://packagist.org/packages/list.json', $endpoint);
        $this->assertInstanceOf(Collection::class, $response);
    }

    public function test_it_filters_by_vendor()
    {
        $response = (new Packages($this->createManager(), ['vendor' => 'simplesoftwareio']))->get();

        $endpoint = strval($this->history[0]['request']->getUri());

        $this->assertEquals('https://packagist.org/packages/list.json?vendor=simplesoftwareio', $endpoint);
        $this->assertInstanceOf(Collection::class, $response);
    }

    public function test_it_filters_by_type()
    {
        $response = (new Packages($this->createManager(), ['type' => 'composer']))->get();

        $endpoint = strval($this->history[0]['request']->getUri());

        $this->assertEquals('https://packagist.org/packages/list.json?type=composer', $endpoint);
        $this->assertInstanceOf(Collection::class, $response);
    }
}
