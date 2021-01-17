<?php

namespace nez\EuroinvestorClient\instruments\factSheet;

use nez\EuroinvestorClient\ReadOnlyPropertyContainer;

/**
 * Class CashFlow
 *
 * @property-read FactSheetValueLine[] $capitalExpenditure
 * @property-read FactSheetValueLine[] $operatingCashFlow
 * @property-read FactSheetValueLine[] $changesInCash
 * @property-read FactSheetValueLine[] $freeCashFlow
 * @property-read FactSheetValueLine[] $fcfPerShare
 * @property-read FactSheetValueLine[] $fcfNetIncomeRatio
 *
 * @package nez\EuroinvestorClient\instruments\factSheet
 */
class CashFlow extends FactSheetValueCollection
{

}
