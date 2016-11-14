<?php

use Mockery as m;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Middleware;
use SimpleSoftwareIO\Packagist\Package;
use Illuminate\Contracts\Cache\Factory as Cache;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class PackageTest extends TestCase
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

        $this->package = new Package($client, $cache, 0, 'simplesoftwareio', 'simple-qrcode');
        $this->mockPackage = new Package($mockClient, $cache, 0, 'simplesoftwareio', 'simple-qrcode');
    }

    public function tearDown()
    {
        m::close();
    }

    public function packagistKeys()
    {
        return [
            ['name'],
            ['description'],
            ['time'],
            ['maintainers'],
            ['versions'],
            ['type'],
            ['repository'],
            ['github_stars'],
            ['github_watchers'],
            ['github_forks'],
            ['github_open_issues'],
            ['language'],
            ['dependents'],
            ['suggesters'],
            ['favers']
        ];
    }

    public function packagistVersionKeys()
    {
        return [
            ['name'],
            ['description'],
            ['keywords'],
            ['homepage'],
            ['version'],
            ['version_normalized'],
            ['license'],
            ['authors'],
            ['source'],
            ['dist'],
            ['type'],
            ['time'],
            ['autoload'],
            ['require'],
            ['require-dev']
        ];
    }

    public function getResponse()
    {
        return $response = [
            'package' => [
                'name' => "simplesoftwareio/simple-qrcode",
                'description' => "Simple QrCode is a QR code generator made for Laravel.",
                'time' => "2014-06-09T22:37:43+00:00",
                'maintainers' => [
                    'name' => 'SimplyCorey',
                    'name' => 'SimplyThomas'
                ],
                'versions' => [
                    'dev-master' => [
                        'name' => "simplesoftwareio/simple-qrcode",
                        'description' => "Simple QrCode is a QR code generator made for Laravel.",
                        'keywords' => [
                            'keyword1',
                            'keyword2'
                        ],
                        'homepage' => 'https://www.simplesoftware.io',
                        'version' => 'dev-masster',
                        'version_normalized' => '9999999-dev',
                        'license' => [
                            'MIT'
                        ],
                        'authors' => [
                            'name' => 'Simple Software LLC',
                            'email' => 'support@simplesoftware.io'
                        ],
                        'source' => [
                            'type' => 'git',
                            'url' => 'https://github.com/SimpleSoftwareIO/simple-qrcode.git',
                            'reference' => '49266b1c6aa94bd5ddcdaba74f7b3e6956a82c01'
                        ],
                        'dist' => [
                            'type' => 'zip',
                            'url' => 'https://api.github.com/repos/SimpleSoftwareIO/simple-qrcode/zipball/49266b1c6aa94bd5ddcdaba74f7b3e6956a82c01',
                            'reference' => '49266b1c6aa94bd5ddcdaba74f7b3e6956a82c01',
                            'shasum' => ''
                        ],
                        'type' => 'library',
                        'time' => '2016-10-18T00:27:02+00:00',
                        'autoload' => [
                            'psr-0' => [
                                'SimpleSoftwareIO\\QrCode\\' => 'src'
                            ]
                        ],
                        'require' => [
                            'php' => '>=5.4.0'
                        ],
                        'require-dev' => [
                            'phpunit/phpuit' => '~5'
                        ]
                    ]
                ],
                'type' => 'library',
                'repository' => 'https://github.com/SimpleSoftwareIO/simple-qrcode',
                'github_stars' => 1,
                'github_watchers' => 1,
                'github_forks' => 1,
                'github_open_issues' => 1,
                'language' => 'PHP',
                'dependents' => 5,
                'suggesters' => 0,
                'favers' => 1
            ]
        ];
    }

    /**
     * @dataProvider packagistKeys
     */
    public function test_package_returns_the_correct_values_for_magic_methods($key)
    {
        $this->assertEquals($this->mockPackage->$key(), $this->getResponse()['package'][$key]);
    }

    /**
     * @dataProvider packagistVersionKeys
     */
    public function test_package_returns_the_correct_values_for_versions_numbers($key)
    {
        $this->assertEquals($this->mockPackage->$key('dev-master'), $this->getResponse()['package']['versions']['dev-master'][$key]);
    }

    public function test_it_calls_the_correct_endpoint()
    {
        $this->package->get();

        $endpoint = strval($this->history[0]['request']->getUri());

        $this->assertEquals($endpoint, 'https://packagist.org/packages/simplesoftwareio/simple-qrcode.json');
    }

    /**
     * @dataProvider packagistKeys
     */
    public function test_packagist_has_the_correct_keys($key)
    {
        $collection = $this->package->get();

        $this->assertArrayHasKey($key, $collection);
    }

    /**
     * @dataProvider packagistVersionKeys
     */
    public function test_packagist_has_the_correct_keys_for_versions($key)
    {
        $collection = $this->package->get();

        $this->assertArrayHasKey($key, $collection['versions']['dev-master']);
    }
}