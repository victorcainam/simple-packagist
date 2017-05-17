<?php

namespace SimpleSoftwareIO\Packagist;

use Illuminate\Support\Collection;

class Packages extends Request
{
    use MakeRequest;

    /**
     * The Packagist manager.
     *
     * @var Manager
     */
    protected $manager;

    /**
     * The search parameters.
     *
     * @var array
     */
    protected $params;

    /**
     * The API endpoint.
     *
     * @var string
     */
    protected $endPoint = 'https://packagist.org/packages/list.json';

    /**
     * Constructs the Packages object.
     *
     * Packages constructor.
     *
     * @param Manager $manager
     * @param array   $params
     */
    public function __construct(Manager $manager, array $params)
    {
        $this->manager = $manager;
        $this->params = $params;
    }

    /**
     * Fires off the API request.
     *
     * @return Collection
     */
    public function get()
    {
        $response = $this->request();

        $packages = new Collection($response['packageNames']);
        $packages = $packages->map(function ($package) {
            return $this->package($package);
        });

        return $packages;
    }

    /**
     * Friendly helper to fire API request.
     *
     * @return Collection
     */
    public function packages()
    {
        return $this->get();
    }

    /**
     * Creates the Package objects.
     *
     * @param $package
     *
     * @return Package
     */
    public function package($package)
    {
        $split = explode('/', $package);

        return new Package($this->manager, $split[0], $split[1]);
    }

    /**
     * Genereates the API endpoint.
     *
     * @return string
     */
    protected function endPoint()
    {
        return $this->endPoint;
    }
}
