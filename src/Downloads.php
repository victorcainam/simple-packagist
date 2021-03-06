<?php

namespace SimpleSoftwareIO\Packagist;

use Illuminate\Support\Collection;

class Downloads extends Request
{
    use Formats, MakeRequest;

    /**
     * The Packagist manager.
     *
     * @var Manager
     */
    protected $manager;

    /**
     * The package's vendor.
     *
     * @var string
     */
    protected $vendor;

    /**
     * The package name.
     *
     * @var string
     */
    protected $package;

    /**
     * The API endpoint.
     *
     * @var string
     */
    protected $endPoint = 'https://packagist.org/packages';

    /**
     * Downloads constructor.
     *
     * @param $manager
     * @param $vendor
     * @param $package
     */
    public function __construct(Manager $manager, $vendor, $package)
    {
        $this->manager = $manager;
        $this->vendor = $vendor;
        $this->package = $package;
    }

    /**
     * Fires off the API request.
     *
     * @return Collection
     */
    public function get()
    {
        $response = $this->format(
            $this->request()['package']['downloads']
        );

        $collection = new Collection($response['total']);
        $collection = $collection->merge(['versions' => $response['versions']]);

        return $collection;
    }

    /**
     * Generates the API endpoint.
     *
     * @return string
     */
    protected function endPoint()
    {
        return "{$this->endPoint}/{$this->vendor}/{$this->package}/downloads.json";
    }
}
