<?php

namespace nez\EuroinvestorClient;

use Nbj\Str;
use Carbon\Carbon;
use InvalidArgumentException;

abstract class ReadOnlyPropertyContainer
{
    /**
     * Storage for all property data
     *
     * @var array
     */
    protected array $properties;

    /**
     * List of properties that should be cast to date classes
     *
     * @var array
     */
    protected array $dates = [];

    /**
     * PropertyContainer constructor.
     *
     * @param array $properties
     * @param bool $disallowEmpty
     */
    public function __construct(array $properties, bool $disallowEmpty = true)
    {
        if ($disallowEmpty && empty($properties)) {
            throw new InvalidArgumentException(sprintf('%s data cannot be empty!', __CLASS__));
        }

        $this->properties = $properties;
    }

    /**
     * Magic method for accessing read-only properties
     *
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        $method = sprintf('get%sProperty', Str::toPascal($name));

        if (method_exists($this, $method)) {
            return $this->$method;
        }

        if ( ! isset($this->properties[$name])) {
            throw new InvalidArgumentException(sprintf("%s: Have no property named '%s'", __CLASS__, $name));
        }

        $property = $this->properties[$name];

        if (collect($this->dates)->contains($name)) {
            return Carbon::parse($property);
        }

        return $property;
    }
}
