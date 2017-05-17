<?php

namespace SimpleSoftwareIO\Packagist;

class Packagist
{
    /**
     * The Packagist manager.
     *
     * @var Manager
     */
    protected $manager;

    /**
     * Packagist constructor.
     *
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Gets all of the packages on Packagist.
     *
     * @return Packages
     */
    public function all()
    {
        return $this->packages();
    }

    /**
     * Gets all of the packages on Packagist for a vendor.
     *
     * @param $vendor
     *
     * @return Collection
     */
    public function vendor($vendor)
    {
        return $this->packages(['vendor' => $vendor]);
    }

    /**
     * Searches Packagist for all packages of a type.
     *
     * @param $type
     *
     * @return Collection
     */
    public function type($type)
    {
        return $this->packages(['type' => $type]);
    }

    /**
     * Gets all packages for the matching params.
     *
     * @param array $params
     *
     * @return Packages
     */
    public function packages($params = [])
    {
        if (is_string($params)) {
            $params = ['vendor' => $params];
        }

        return (new Packages($this->manager, $params))->get();
    }

    /**
     * Gets the information for a package.
     *
     * @param $vendor
     * @param $package
     *
     * @return Package
     */
    public function package($vendor, $package)
    {
        return new Package($this->manager, $vendor, $package);
    }
}
