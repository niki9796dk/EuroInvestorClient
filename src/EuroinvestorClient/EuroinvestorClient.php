<?php

namespace nez\EuroinvestorClient;

use JsonException;
use Illuminate\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;
use nez\EuroinvestorClient\instruments\Peer;
use nez\EuroinvestorClient\instruments\Instrument;
use nez\EuroinvestorClient\instrumentQuery\InstrumentQuery;
use nez\EuroinvestorClient\instruments\factSheet\FactSheet;

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

    /**
     * Returns a collection of peers for the given instrument
     *
     * @param int $instrumentId
     *
     * @return Peer[]|Collection
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getInstrumentPeers(int $instrumentId): Collection
    {
        return collect(Endpoints::instrumentPeers($instrumentId))
            ->map(function (array $peerData) {
                return new Peer($peerData);
            });
    }

    /**
     * Returns a collection of peers for the given instrument
     *
     * @param int $instrumentId
     *
     * @return FactSheet
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getInstrumentFactSheet(int $instrumentId): FactSheet
    {
        return new FactSheet(Endpoints::instrumentFactsheet($instrumentId));
    }
}
