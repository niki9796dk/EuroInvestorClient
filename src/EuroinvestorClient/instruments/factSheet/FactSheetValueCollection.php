<?php

namespace nez\EuroinvestorClient\instruments\factSheet;

use nez\EuroinvestorClient\ReadOnlyPropertyContainer;

/**
 * Class FactSheetValueCollection
 *
 * @package nez\EuroinvestorClient\instruments\factSheet
 */
abstract class FactSheetValueCollection extends ReadOnlyPropertyContainer
{
    /**
     * FactSheetValueCollection constructor.
     *
     * @param array $valueCollection
     */
    public function __construct(array $valueCollection)
    {
        $properties = collect($valueCollection)->keyBy(function (array $balanceDatum) {
            return $balanceDatum['dataName'];
        })->map(function (array $balanceDatum) {
            return $balanceDatum['values'];
        })->map(function (array $valueData) {
            return new FactSheetValueLine($valueData);
        })->all();

        parent::__construct($properties);
    }
}
