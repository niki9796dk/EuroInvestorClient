<?php

namespace nez\EuroinvestorClient\instruments\factSheet;

use Carbon\Carbon;
use nez\EuroinvestorClient\ReadOnlyPropertyContainer;

/**
 * Class AboutList
 *
 * @property-read string|null $boardChairmanName
 * @property-read string|null $ceoName
 * @property-read int $fiscalYearEnd
 * @property-read int $groupId
 * @property-read string $groupName
 * @property-read string|null $headquarterCountry
 * @property-read string|null $headquarterHomepage
 * @property-read int $industryId
 * @property-read string|null $industryName
 * @property-read string $longDescription
 * @property-read Carbon|null $periodEndingDate
 * @property-read int $sectorId
 * @property-read string $sectorName
 * @property-read int $totalEmployeeNumber
 *
 * @package nez\EuroinvestorClient\instruments\factSheet
 */
class AboutList extends ReadOnlyPropertyContainer
{
    protected array $dates = ['periodEndingDate'];
}
