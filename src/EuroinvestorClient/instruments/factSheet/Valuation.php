<?php

namespace nez\EuroinvestorClient\instruments\factSheet;

use nez\EuroinvestorClient\ReadOnlyPropertyContainer;

/**
 * Class Valuation
 *
 * @property-read FactSheetValueLine[] $peRatio
 * @property-read FactSheetValueLine[] $psRatio
 * @property-read FactSheetValueLine[] $pbRatio
 * @property-read FactSheetValueLine[] $forwardPeRatio
 * @property-read FactSheetValueLine[] $pegRatio
 * @property-read FactSheetValueLine[] $evtoebitda
 * @property-read FactSheetValueLine[] $evtoRevenue
 * @property-read FactSheetValueLine[] $evtoebit
 * @property-read FactSheetValueLine[] $fcfNetIncomeRatio
 * @property-read FactSheetValueLine[] $basicEps
 * @property-read FactSheetValueLine[] $marketCap
 * @property-read FactSheetValueLine[] $enterpriseValue
 *
 * @package nez\EuroinvestorClient\instruments\factSheet
 */
class Valuation extends FactSheetValueCollection
{

}
