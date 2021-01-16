<?php

namespace nez\EuroinvestorClient\instruments\factSheet;

use nez\EuroinvestorClient\ReadOnlyPropertyContainer;

/**
 * Class Balance
 *
 * @property-read FactSheetValueLine[] $TotalAssets
 * @property-read FactSheetValueLine[] $TotalEquity
 * @property-read FactSheetValueLine[] $TotalLiabilities
 * @property-read FactSheetValueLine[] $TotalDebtEquityRatio
 * @property-read FactSheetValueLine[] $AssetsTurnover
 * @property-read FactSheetValueLine[] $CommonEquityToAssets
 *
 * @package nez\EuroinvestorClient\instruments\factSheet
 */
class Balance extends FactSheetValueCollection
{

}
