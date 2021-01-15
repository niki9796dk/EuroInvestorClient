<?php

namespace nez\EuroinvestorClient\instrumentQuery;

use InvalidArgumentException;
use nez\EuroinvestorClient\enums\Endpoints;
use nez\EuroinvestorClient\instruments\Instrument;

/**
 * Class InstrumentQueryLine
 *
 * @property-read int $id               Instrument id
 * @property-read string $name          Instrument name     eg. Tesla, Inc.
 * @property-read string $symbol        Instrument symbol   eg. TSLA
 * @property-read string $isin          Instrument isin     eg. US88160R1014
 * @property-read int $volume           Instrument volume   eg. Number of shares traded in a given period (Often the past day)
 * @property-read string $exchangeCode  Code for the exchange the instrument is traded at
 *
 * @package nez\EuroinvestorClient\instrumentQuery
 */
class InstrumentQueryLine
{
    private array $data;

    /**
     * InstrumentQuery constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        if (empty($data)) {
            throw new InvalidArgumentException(sprintf('%s data cannot be empty!', __CLASS__));
        }

        $this->data = $data;
    }

    /**
     * Returns the associated instrument for the given query line
     *
     * @return Instrument
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function toInstrument(): Instrument
    {
        return new Instrument(json_decode(Endpoints::instruments($this->id)->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR)[0]);
    }

    /**
     * Magic method used to allow for read-only properties
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        // We are most likely to find the given property within the source array
        if (isset($this->data['_source'][$name])) {
            return $this->data['_source'][$name];
        }

        throw new InvalidArgumentException(sprintf("%s: Have no property named '%s'", __CLASS__, $name));
    }
}
