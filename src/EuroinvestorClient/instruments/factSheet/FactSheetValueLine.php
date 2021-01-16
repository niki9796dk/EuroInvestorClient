<?php

namespace nez\EuroinvestorClient\instruments\factSheet;

use Carbon\Carbon;
use nez\EuroinvestorClient\ReadOnlyPropertyContainer;

/**
 * Class FactSheetValueLine
 *
 * @property-read Carbon $asOfDate
 * @property-read mixed|null $currency
 * @property-read string $formattedValue
 * @property-read mixed|null $postfix
 * @property-read int $value
 *
 * @package nez\EuroinvestorClient\instruments\factSheet
 */
class FactSheetValueLine extends ReadOnlyPropertyContainer
{
    protected array $dates = ['asOfDate'];
}
