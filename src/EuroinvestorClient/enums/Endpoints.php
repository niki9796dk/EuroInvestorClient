<?php

namespace nez\EuroinvestorClient\enums;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\GuzzleException;

class Endpoints
{
    public const SEARCH_INSTRUMENTS = "https://search.euroinvestor.dk/instruments?q=:query:";
    public const INSTRUMENTS = "https://api.euroinvestor.dk/instruments?ids=:instruments:";
    public const INSTRUMENT_FACTSHEET = "https://api.euroinvestor.dk/instruments/:instrument:/factsheet";
    public const INSTRUMENT_PEERS = "https://api.euroinvestor.dk/instruments/:instrument:/peers";

    private static Client $client;

    /**
     * Sends a request to the instrument search endpoint
     *
     * @param string $query
     *
     * @return ResponseInterface
     *
     * @throws GuzzleException
     */
    public static function searchInstruments(string $query): ResponseInterface
    {
        return self::getHttpClient()->get(self::mapEndpoint(self::SEARCH_INSTRUMENTS, [':query:' => $query]));
    }

    /**
     * Sends a request to the instrument search endpoint
     *
     * @param int|string|array $ids
     *
     * @return ResponseInterface
     *
     * @throws GuzzleException
     */
    public static function instruments($ids): ResponseInterface
    {
        if (is_array($ids)) {
            $ids = implode(',', $ids);
        }

        return self::getHttpClient()->get(self::mapEndpoint(self::INSTRUMENTS, [':instruments:' => $ids]));
    }

    /**
     * Sends a request to the instrument peers endpoint
     *
     * @param int $instrumentId
     *
     * @return ResponseInterface
     *
     * @throws GuzzleException
     */
    public static function instrumentPeers(int $instrumentId): ResponseInterface
    {
        return self::getHttpClient()->get(self::mapEndpoint(self::INSTRUMENT_PEERS, [':instrument:' => $instrumentId]));
    }

    /**
     * Sends a request to the instrument factsheet endpoint
     *
     * @param int $instrumentId
     *
     * @return ResponseInterface
     *
     * @throws GuzzleException
     */
    public static function instrumentFactsheet(int $instrumentId): ResponseInterface
    {
        return self::getHttpClient()->get(self::mapEndpoint(self::INSTRUMENT_FACTSHEET, [':instrument:' => $instrumentId]));
    }

    /**
     * Helper method for searching and replacing placeholders with actual values
     *
     * @param string $endpoint
     * @param array $mappings
     *
     * @return string
     */
    private static function mapEndpoint(string $endpoint, array $mappings = []): string
    {
        return str_replace(array_keys($mappings), array_values($mappings), $endpoint);
    }

    /**
     * Returns an instance of the guzzle client
     *
     * @return Client
     */
    private static function getHttpClient(): Client
    {
        if ( ! isset(self::$client)) {
            self::$client = new Client([
                RequestOptions::VERIFY => false, // Ignore ssl certificates
            ]);
        }

        return self::$client;
    }
}
