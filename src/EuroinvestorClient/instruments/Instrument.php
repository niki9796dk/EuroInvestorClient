<?php

namespace nez\EuroinvestorClient\instruments;

use Carbon\Carbon;
use InvalidArgumentException;

/**
 * Class Instrument
 *
 * @property-read int $id                   The instruments id
 * @property-read int $instrumentType       The instruments type - This is used to differentiate between stocks and fonds and so on...
 * @property-read string $isin              The globally unique id for the instrument
 * @property-read float $ask                The lowest someone is currently willing to sell for
 * @property-read float $bid                The highest someone is currently willing to buy for
 * @property-read float $last               The current value of the instrument (The price of the lastest trade)
 * @property-read float $low                Today's lowest sale value
 * @property-read float $high               Today's highest sale value
 * @property-read float $open               The value of the instrument at the time of market opening today
 * @property-read float $previousClose      The value of the instrument at tge tune if market closing yesterday
 * @property-read float $change             The current change from yesterdays close to today's last sale in monetary value
 * @property-read float $changeInPercentage The current change from yesterdays close to today's last sale in percentages (-100% <=> +INF%)
 * @property-read string $name              The name of the instrument
 * @property-read string $longName          The name of the instrument, or a longer version if such exists
 * @property-read string $symbol            The shorthand symbol for the instrument
 * @property-read string|float $marketCap   The market cap of the instrument
 * @property-read int $numberOfStocks       Total number of stocks for the instrument
 * @property-read int $volume               Number of shares traded in a given period (Often the past day)
 * @property-read Carbon $updatedAt         The last time the instruments information were updated
 * @property-read array $exchange           The exchange the instrument is traded at
 * @property-read mixed $crypto             ??
 * @property-read mixed $msExchangeId       ??
 * @property-read mixed $msSecurityType     ??
 * @property-read mixed $msSymbol           ??
 *
 * @package nez\EuroinvestorClient\instruments
 */
class Instrument
{
    private array $instrumentData;

    /**
     * Instrument constructor.
     *
     * @param array $instrumentData
     */
    public function __construct(array $instrumentData)
    {
        if (empty($instrumentData)) {
            throw new InvalidArgumentException(sprintf('%s data cannot be empty! This is probably caused by accessing an invalid instrument id', __CLASS__));
        }

        $this->instrumentData = $instrumentData;
    }

    /**
     * Method for supporting read-only properties
     *
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        $dateFields = collect([
            'updatedAt'
        ]);

        if (isset($this->instrumentData[$name])) {
            $data = $this->instrumentData[$name];

            if ($dateFields->contains($name)) {
                $data = Carbon::parse($data);
            }

            return $data;
        }

        throw new InvalidArgumentException(sprintf("%s: Have no property named '%s'", __CLASS__, $name));
    }
}
