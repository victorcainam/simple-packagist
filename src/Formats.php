<?php

namespace SimpleSoftwareIO\Packagist;

trait Formats
{
    /**
     * Formats the results using the configuration.
     *
     * @param $value
     * @return mixed
     */
    protected function format($value)
    {
        if (! $this->manager->getConfig('formatting.enable')) {
            return $value;
        }

        if (is_array($value)) {
            array_walk_recursive($value, [$this, 'transform']);

            return $value;
        }

        return $this->transform($value);
    }

    /**
     * Transforms a value into the correct format.
     *
     * @param $value
     */
    protected function transform(&$value)
    {
        if (is_int($value)) {
            $value = $this->format_number($value);
        }
    }

    /**
     * Formats a number using the configuration.
     *
     * @param $number
     * @return string
     */
    protected function format_number($number)
    {
        return number_format($number,
            $this->manager->getConfig('formatting.decimals'),
            $this->manager->getConfig('formatting.dec_point'),
            $this->manager->getConfig('formatting.thousands_sep')
        );
    }
}