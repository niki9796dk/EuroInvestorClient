<?php

namespace nez\EuroinvestorClient;

use JsonException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\GuzzleException;

class Endpoints
{
    private const SEARCH_INSTRUMENTS = "https://search.euroinvestor.dk/instruments?q=:query:";
    private const INSTRUMENTS = "https://api.euroinvestor.dk/instruments?ids=:instruments:";
    private const INSTRUMENT_FACTSHEET = "https://api.euroinvestor.dk/instruments/:instrument:/factsheet";
    private const INSTRUMENT_PEERS = "https://api.euroinvestor.dk/instruments/:instrument:/peers";

    private const CURRENCY_EXCHANGE_RATE = "https://api.euroinvestor.dk/exchange-rates/:currency:";

    private static Client $client;

    /**
     * Sends a request to the instrument search endpoint
     *
     * @param string $query
     *
     * @return array
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public static function searchInstruments(string $query): array
    {
        $response = self::getHttpClient()->get(self::mapEndpoint(self::SEARCH_INSTRUMENTS, [':query:' => $query]));

        return self::convertToDataArray($response);
    }

    /**
     * Sends a request to the instrument search endpoint
     *
     * @param int|string|array $ids
     *
     * @return array
     *
     * @throws GuzzleException|JsonException
     */
    public static function instruments($ids): array
    {
        if (is_array($ids)) {
            $ids = implode(',', $ids);
        }

        $response = self::getHttpClient()->get(self::mapEndpoint(self::INSTRUMENTS, [':instruments:' => $ids]));

        return self::convertToDataArray($response);
    }

    /**
     * Sends a request to the instrument peers endpoint
     *
     * @param int $instrumentId
     *
     * @return array
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public static function instrumentPeers(int $instrumentId): array
    {
        $response = self::getHttpClient()->get(self::mapEndpoint(self::INSTRUMENT_PEERS, [':instrument:' => $instrumentId]));

        return self::convertToDataArray($response);
    }

    /**
     * Sends a request to the instrument factsheet endpoint
     *
     * @param int $instrumentId
     *
     * @return array
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public static function instrumentFactsheet(int $instrumentId): array
    {
        $response = self::getHttpClient()->get(self::mapEndpoint(self::INSTRUMENT_FACTSHEET, [':instrument:' => $instrumentId]));

        return self::convertToDataArray($response);
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
     * @param ResponseInterface $response
     *
     * @return array
     * @throws JsonException
     */
    private static function convertToDataArray(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Sends a request to the instrument search endpoint
     *
     * @param string $currency
     *
     * @return array
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public static function currencyExchangeRate(string $currency): array
    {
        $response = self::getHttpClient()->get(self::mapEndpoint(self::CURRENCY_EXCHANGE_RATE, [':currency:' => strtoupper($currency)]));

        return self::convertToDataArray($response);
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
