<?php

namespace SimpleSoftwareIO\Packagist;

use Illuminate\Support\Collection;

class Package extends Request
{
    use MakeRequest;

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
     * Package constructor.
     *
     * @param Manager $manager
     * @param string $package
     */
    public function __construct(Manager $manager, $vendor, $package)
    {
        $this->manager = $manager;
        $this->vendor = $vendor;
        $this->package = $package;
    }

    /**
     * Fires the API request.
     *
     * @return Collection
     */
    public function get()
    {
        return new Collection($this->request()['package']);
    }

    /**
     * Constructs the API endpoint.
     *
     * @return string
     */
    protected function endPoint()
    {
        return "{$this->endPoint}/{$this->vendor}/{$this->package}.json";
    }

    /**
     * Returns a collection containing the downloads.
     *
     * @param null|string $version
     * @return Collection
     */
    public function downloads($version = null)
    {
        $downloads = new Downloads($this->manager, $this->vendor, $this->package);

        if ( ! empty($version)) return $downloads->get()['versions'][$version];

        return $downloads->get();
    }

    /**
     * Used to retrieve different statistics about a package.
     *
     * @param string $name
     * @param array $version
     * @return mixed
     */
    public function __call($name, array $version)
    {
        if ( ! empty($version)) return $this->get()['versions'][$version[0]][$name];

        return $this->get()[$name];
    }
}