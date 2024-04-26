<?php

namespace App\Services;

use GuzzleHttp\Client;

/**
 * Handles currency exchange rate retrieval with API key authentication.
 */
class ExchangeService
{
    private $client;
    private $apiUrl;
    private $apiKey;

    /**
     * Constructor for ExchangeService.
     *
     * @param Client $client HTTP client for making requests.
     * @param string $apiUrl API URL for the exchange rate service.
     * @param string $apiKey API key for authenticating with the exchange rate service.
     */
    public function __construct(Client $client, string $apiUrl, string $apiKey)
    {
        $this->client = $client;
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * Retrieves the exchange rate for a given currency.
     *
     * @param string $currency The currency code to retrieve the rate for.
     * @return float The exchange rate.
     */
    public function getRate(string $currency): float
    {
        // Include the API key in the request as a query parameter
        $response = $this->client->get($this->apiUrl, [
            'query' => [
                'access_key' => $this->apiKey, // Assumed parameter name, adjust as needed
                'symbols' => $currency
            ]
        ]);
        $rates = json_decode($response->getBody()->getContents(), true);
        return $rates['rates'][$currency] ?? 0;
    }
}
