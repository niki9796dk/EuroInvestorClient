<?php

namespace nez\EuroinvestorClient\instruments\factSheet;

use nez\EuroinvestorClient\ReadOnlyPropertyContainer;

/**
 * Class Dividend
 *
 * @property-read FactSheetValueLine[] $payoutRatio
 * @property-read FactSheetValueLine[] $trailingdividendyield
 * @property-read FactSheetValueLine[] $dividendPerShare
 * @property-read FactSheetValueLine[] $exDividendDate
 * @property-read FactSheetValueLine[] $dividendDate
 *
 * @package nez\EuroinvestorClient\instruments\factSheet
 */
class Dividend extends FactSheetValueCollection
{

}
