<?php

use Mockery as m;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Middleware;
use Illuminate\Contracts\Cache\Factory as Cache;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use SimpleSoftwareIO\Packagist\Manager;

abstract class ManagerSetup extends TestCase
{
    /**
     * Creates a Manager class with a mocked out Guzzle Client.
     *
     * @return Manager
     */
    public function createMockManager()
    {
        $cache = m::mock(Cache::class);

        $mockRequest = new MockHandler([
            new Response(200, [], json_encode($this->getResponse())),
        ]);

        $mockClient = new Client(['handler' => $mockRequest]);

        return new Manager($mockClient, $cache, ['cacheLength' => 0]);
    }

    /**
     * Creates a Manager class without a Mocked out Guzzle Client.
     *
     * @return Manager
     */
    public function createManager()
    {
        $cache = m::mock(Cache::class);

        $this->history = [];
        $stack = HandlerStack::create();
        $stack->push(Middleware::history($this->history));
        $client = new Client(['handler' => $stack]);

        return new Manager($client, $cache, ['cacheLength' => 0]);
    }

    /**
     * Builds up a mock response for Guzzle.
     *
     * @return array
     */
    protected function getResponse()
    {
        return [];
    }

    /**
     * Tears down the Unit Tests.
     */
    public function tearDown()
    {
        m::close();
    }
}
