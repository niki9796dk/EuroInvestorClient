<?php

namespace nez\EuroinvestorClient\instruments\factSheet;

use nez\EuroinvestorClient\ReadOnlyPropertyContainer;

/**
 * Class Profibility
 *
 * @property-read FactSheetValueLine[] $grossMargin
 * @property-read FactSheetValueLine[] $operationMargin
 * @property-read FactSheetValueLine[] $netMargin
 * @property-read FactSheetValueLine[] $grossProfit
 * @property-read FactSheetValueLine[] $netIncome
 * @property-read FactSheetValueLine[] $totalRevenue
 * @property-read FactSheetValueLine[] $operatingIncome
 *
 * @package nez\EuroinvestorClient\instruments\factSheet
 */
class Profibility extends FactSheetValueCollection
{

}
