<?php

namespace nez\EuroinvestorClient\instruments\factSheet;

use InvalidArgumentException;

/**
 * Class FactSheet
 *
 * @property-read array $aboutList
 * @property-read array $balance
 * @property-read array $cashFlow
 * @property-read array $dividend
 * @property-read array $operativePerformance
 * @property-read array $profibility
 * @property-read array $valuation
 *
 * @package nez\EuroinvestorClient\instruments
 */
class FactSheet
{
    private array $factSheetData;

    /**
     * InstrumentFactSheet constructor.
     *
     * @param array $factSheetData
     */
    public function __construct(array $factSheetData)
    {
        $this->factSheetData = $factSheetData;
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
        if (isset($this->factSheetData[$name])) {
            return $this->factSheetData[$name];
        }

        throw new InvalidArgumentException(sprintf("%s: Have no property named '%s'", __CLASS__, $name));
    }

}
