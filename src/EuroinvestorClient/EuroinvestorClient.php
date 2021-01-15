<?php

namespace nez\EuroinvestorClient;

use JsonException;
use GuzzleHttp\Exception\GuzzleException;
use nez\EuroinvestorClient\enums\Endpoints;
use nez\EuroinvestorClient\instruments\Instrument;
use nez\EuroinvestorClient\instrumentQuery\InstrumentQuery;

class EuroinvestorClient
{
    /**
     * Queries euroinvestor for instruments that matches the given search query
     *
     * @param string $searchQuery
     *
     * @return InstrumentQuery
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function queryInstrumentsBy(string $searchQuery): InstrumentQuery
    {
        return InstrumentQuery::by($searchQuery);
    }

    /**
     * Fetches an instrument instance from the given instrument id
     *
     * @param int $id
     *
     * @return Instrument
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getInstrument(int $id): Instrument
    {
        return new Instrument(json_decode(Endpoints::instruments($id)->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR)[0]);
    }
}
