<?php

use Mockery as m;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Middleware;
use SimpleSoftwareIO\Packagist\Downloads;
use Illuminate\Contracts\Cache\Factory as Cache;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class DownloadsTest extends TestCase
{
    public function setUp()
    {
        $cache = m::mock(Cache::class);

        $mockRequest = new MockHandler([
            new Response(200, [], json_encode($this->getResponse()))
        ]);

        $mockClient = new Client(['handler' => $mockRequest]);

        $this->history = [];
        $stack = HandlerStack::create();
        $stack->push(Middleware::history($this->history));
        $client = new Client(['handler' => $stack]);

        $this->downloads = new Downloads($client, $cache, 0, 'simplesoftwareio', 'simple-qrcode');
        $this->mockDownloads = new Downloads($mockClient, $cache, 0, 'simplesoftwareio', 'simple-qrcode');
    }

    public function tearDown()
    {
        m::close();
    }

    public function packagistKeys()
    {
        return [
            ['total'],
            ['monthly'],
            ['daily']
        ];
    }

    public function getResponse()
    {
        return [
            'package' => [
                'downloads' => [
                    'total' => [
                        'total' => 1,
                        'monthly' => 1,
                        'daily' => 1,
                    ],
                    'versions' => [
                        'dev-master' => [
                            'total' => 1,
                            'monthly' => 1,
                            'daily' => 1
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @dataProvider packagistKeys
     */
    public function test_downloads_returns_the_correct_values($key)
    {
        $this->assertEquals($this->getResponse()['package']['downloads']['total'][$key], $this->mockDownloads->get()[$key]);
    }

    /**
     * @dataProvider packagistKeys
     */
    public function test_downloads_returns_the_correct_values_for_versions_numbers($key)
    {
        $this->assertEquals($this->getResponse()['package']['downloads']['versions']['dev-master'][$key], $this->mockDownloads->get('dev-master')[$key]);
    }

    public function test_it_calls_the_correct_endpoint()
    {
        $this->downloads->get();

        $endpoint = strval($this->history[0]['request']->getUri());

        $this->assertEquals('https://packagist.org/packages/simplesoftwareio/simple-qrcode/downloads.json', $endpoint);
    }

    /**
     * @dataProvider packagistKeys
     */
    public function test_packagist_has_the_correct_keys($key)
    {
        $collection = $this->downloads->get();

        $this->assertArrayHasKey($key, $collection);
    }

    /**
     * @dataProvider packagistKeys
     */
    public function test_packagist_has_the_correct_keys_for_versions($key)
    {
        $collection = $this->downloads->get();

        $this->assertArrayHasKey($key, $collection['versions']['dev-master']);
    }
}