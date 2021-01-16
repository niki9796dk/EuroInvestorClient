<?php

namespace nez\EuroinvestorClient;

use JsonException;
use GuzzleHttp\Exception\GuzzleException;
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
        return new Instrument(Endpoints::instruments($id)[0]);
    }
}
