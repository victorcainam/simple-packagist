<?php

use GuzzleHttp\Client;
use Illuminate\Contracts\Cache\Factory as Cache;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class ManagerTest extends TestCase
{
    public function setUp()
    {
        $client = m::mock(Client::class);
        $cache = m::mock(Cache::class);

        $config = [
            'cacheLength' => 60,
        ];

        $this->manager = new SimpleSoftwareIO\Packagist\Manager($client, $cache, $config);
    }

    public function tearDown()
    {
        m::close();
    }

    public function test_a_client_is_returned()
    {
        $cache = $this->manager->getClient();

        $this->assertInstanceOf(Client::class, $cache);
    }

    public function test_a_cache_is_returned()
    {
        $cache = $this->manager->getCache();

        $this->assertInstanceOf(Cache::class, $cache);
    }

    public function test_the_proper_config_variable_is_returned()
    {
        $cacheLength = $this->manager->getConfig('cacheLength');

        $this->assertEquals(60, $cacheLength);
    }

    public function test_it_returns_null_when_a_config_variable_does_not_exist()
    {
        $this->assertNull($this->manager->getConfig('foo'));
    }
}
