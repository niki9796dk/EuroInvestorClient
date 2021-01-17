<?php

namespace nez\EuroinvestorClient\instruments\factSheet;

use nez\EuroinvestorClient\ReadOnlyPropertyContainer;

/**
 * Class Balance
 *
 * @property-read FactSheetValueLine[] $totalAssets
 * @property-read FactSheetValueLine[] $totalEquity
 * @property-read FactSheetValueLine[] $totalLiabilities
 * @property-read FactSheetValueLine[] $totalDebtEquityRatio
 * @property-read FactSheetValueLine[] $assetsTurnover
 * @property-read FactSheetValueLine[] $commonEquityToAssets
 *
 * @package nez\EuroinvestorClient\instruments\factSheet
 */
class Balance extends FactSheetValueCollection
{

}
