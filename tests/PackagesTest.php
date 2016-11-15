<?php

use Mockery as m;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Middleware;
use SimpleSoftwareIO\Packagist\Packages;
use Illuminate\Contracts\Cache\Factory as Cache;
use Illuminate\Support\Collection;

class PackagesTest extends TestCase
{
    public function setUp()
    {
        $this->history = [];
        $stack = HandlerStack::create();
        $stack->push(Middleware::history($this->history));

        $this->client = new Client(['handler' => $stack]);
        $this->cache = m::mock(Cache::class);
    }

    public function tearDown()
    {
        m::close();
    }

    public function test_it_calls_the_correct_endpoint()
    {
        $response = (new Packages($this->client, $this->cache, 0, []))->get();

        $endpoint = strval($this->history[0]['request']->getUri());

        $this->assertEquals('https://packagist.org/packages/list.json', $endpoint);
        $this->assertInstanceOf(Collection::class, $response);
    }

    public function test_it_filters_by_vendor()
    {
        $response = (new Packages($this->client, $this->cache, 0, ['vendor' => 'simplesoftwareio']))->get();

        $endpoint = strval($this->history[0]['request']->getUri());

        $this->assertEquals('https://packagist.org/packages/list.json?vendor=simplesoftwareio', $endpoint);
        $this->assertInstanceOf(Collection::class, $response);
    }

    public function test_it_filters_by_type()
    {
        $response = (new Packages($this->client, $this->cache, 0, ['type' => 'composer']))->get();

        $endpoint = strval($this->history[0]['request']->getUri());

        $this->assertEquals('https://packagist.org/packages/list.json?type=composer', $endpoint);
        $this->assertInstanceOf(Collection::class, $response);
    }
}