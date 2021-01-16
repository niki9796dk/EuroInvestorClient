<?php

namespace nez\EuroinvestorClient\instruments;

use Carbon\Carbon;
use JsonException;
use BadMethodCallException;
use nez\EuroinvestorClient\Endpoints;
use GuzzleHttp\Exception\GuzzleException;
use nez\EuroinvestorClient\ReadOnlyPropertyContainer;
use nez\EuroinvestorClient\instruments\factSheet\FactSheet;

/**
 * Class Instrument
 *
 * @property-read int $id                   The instruments id
 * @property-read int $instrumentType       The instruments type - This is used to differentiate between stocks and fonds and so on...
 * @property-read string $isin              The globally unique id for the instrument
 * @property-read float $ask                The lowest someone is currently willing to sell for
 * @property-read float $bid                The highest someone is currently willing to buy for
 * @property-read float $last               The current value of the instrument (The price of the latest trade)
 * @property-read float $low                Today's lowest sale value
 * @property-read float $high               Today's highest sale value
 * @property-read float $open               The value of the instrument at the time of market opening today
 * @property-read float $previousClose      The value of the instrument at the time of market closing yesterday
 * @property-read float $change             The current change from yesterdays close to today's last sale in monetary value
 * @property-read float $changeInPercentage The current change from yesterdays close to today's last sale in percentages (-100% <=> +INF%)
 * @property-read string $name              The name of the instrument
 * @property-read string $longName          The name of the instrument, or a longer version if such exists
 * @property-read string $symbol            The shorthand symbol for the instrument
 * @property-read string|float $marketCap   The market cap of the instrument
 * @property-read int $numberOfStocks       Total number of stocks for the instrument
 * @property-read int $volume               Number of shares traded in a given period (Often the past day)
 * @property-read Carbon $updatedAt         The last time the instruments information were updated
 * @property-read Exchange $exchange        The exchange the instrument is traded at
 * @property-read FactSheet $factSheet      A factsheet for the instrument
 * @property-read mixed $crypto             ??
 * @property-read mixed $msExchangeId       ??
 * @property-read mixed $msSecurityType     ??
 * @property-read mixed $msSymbol           ??
 *
 * @package nez\EuroinvestorClient\instruments
 */
class Instrument extends ReadOnlyPropertyContainer
{
    /**
     * The instruments associated fact sheet.
     * The fact sheet is lazy loaded.
     *
     * @var FactSheet|null
     */
    private ?FactSheet $_factSheet;
    private bool $hasFactSheet;

    private Exchange $_exchange;

    /**
     * The instruments associated exchange.
     *
     * @var Exchange|null
     */
    private ?Exchange $exchange;

    /**
     * List of properties that should be cast to date classes
     *
     * @var array
     */
    protected array $dates = ['updatedAt'];

    /**
     * Property magic method for translation $this->factSheet into accessing this method
     *
     * @return FactSheet
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getFactSheetProperty(): FactSheet
    {
        return $this->getOrFailAndRemember($this->_factSheet, $this->hasFactSheet, function () {
            return new FactSheet(Endpoints::instrumentFactsheet($this->id));
        });
    }

    /**
     * Helper method for getting or failing with a remember state for external optional properties
     *
     * @param $property
     * @param $rememberProperty
     * @param callable $callable
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    private function getOrFailAndRemember(&$property, &$rememberProperty, callable $callable)
    {
        if ($rememberProperty === false) {
            throw new BadMethodCallException('This instrument have no associated fact sheet');
        }

        try {
            if ( ! isset($property)) {
                $property = $callable();
            }
        } catch (GuzzleException $exception) {
            if ($exception->getCode() == 404) {
                $rememberProperty = false;

                throw new BadMethodCallException('This instrument have no associated fact sheet');
            }

            throw $exception;
        }

        return $property;
    }

    /**
     * Property magic method for translation $this->exchange into accessing this method
     *
     * @return Exchange
     */
    public function getExchangeProperty(): Exchange
    {
        return $this->_exchange ?? $this->_exchange = new Exchange($this->properties['exchange']);
    }
}
