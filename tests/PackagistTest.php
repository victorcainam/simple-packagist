<?php

use Mockery as m;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;
use SimpleSoftwareIO\Packagist\Manager;
use SimpleSoftwareIO\Packagist\Package;
use Illuminate\Contracts\Cache\Factory as Cache;

class PackagistTest extends TestCase
{
    public function setUp()
    {
        $this->client = m::mock(Client::class);
        $this->cache = m::mock(Cache::class);

        $manager = new Manager($this->client, $this->cache, ['cache' => ['enable' => true]]);

        $this->packagist = new SimpleSoftwareIO\Packagist\Packagist($manager);
    }

    public function tearDown()
    {
        m::close();
    }

    public function test_it_generates_a_new_package_class()
    {
        $package = $this->packagist->package('simplesoftwareio', 'simple-packagist');

        $this->assertInstanceOf(Package::class, $package);
    }

    public function test_it_generates_a_new_collection_when_a_package_is_retreived()
    {
        $this->cache->shouldReceive('remember')->once();

        $package = $this->packagist->package('simplesoftwareio', 'simple-packagist')->get();

        $this->assertInstanceOf(Collection::class, $package);
    }

    public function test_it_generates_a_new_collection_when_downloads_are_retreived()
    {
        $this->cache->shouldReceive('remember')->once();

        $downloads = $this->packagist->package('simplesoftwareio', 'simple-packagist')->downloads();

        $this->assertInstanceOf(Collection::class, $downloads);
    }

    public function test_it_generates_a_collection_when_all_pacakge_are_retreived()
    {
        $this->cache->shouldReceive('remember')->once();

        $packages = $this->packagist->all();

        $this->assertInstanceOf(Collection::class, $packages);
    }

    public function test_it_generates_a_collection_when_a_vendor_is_retreived()
    {
        $this->cache->shouldReceive('remember')->once();

        $packages = $this->packagist->vendor('simplesoftwareio');

        $this->assertInstanceOf(Collection::class, $packages);
    }

    public function test_it_generates_a_collection_when_a_type_is_retreived()
    {
        $this->cache->shouldReceive('remember')->once();

        $packages = $this->packagist->type('composer');

        $this->assertInstanceOf(Collection::class, $packages);
    }
}
