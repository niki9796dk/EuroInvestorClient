<?php

namespace nez\EuroinvestorClient\instruments;

use JsonException;
use nez\EuroinvestorClient\Endpoints;
use GuzzleHttp\Exception\GuzzleException;
use nez\EuroinvestorClient\ReadOnlyPropertyContainer;

/**
 * Class Peer
 *
 * @property-read mixed|null $earningsPerShare
 * @property-read int $instrumentId
 * @property-read float $last
 * @property-read string $name
 * @property-read float $oneWeek
 * @property-read float $oneYear
 * @property-read float $priceEarnings
 * @property-read int $type
 *
 * @package nez\EuroinvestorClient\instruments
 */
class Peer extends ReadOnlyPropertyContainer
{
    /**
     * Method for fetching the associated instrument
     *
     * @return Instrument
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function toInstrument(): Instrument
    {
        return new Instrument(Endpoints::instruments($this->instrumentId)[0]);
    }
}
