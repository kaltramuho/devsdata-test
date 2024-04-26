<?php

namespace App\Services;

use GuzzleHttp\Client;

/**
 * Handles BIN (Bank Identification Number) information retrieval.
 */
class BinService
{
    private $client;
    private $apiUrl;

    /**
     * @param Client $client HTTP client for making requests.
     * @param string $apiUrl API URL for the BIN lookup service.
     */
    public function __construct(Client $client, string $apiUrl)
    {
        $this->client = $client;
        $this->apiUrl = $apiUrl;
    }

    /**
     * Retrieves the country code associated with a given BIN.
     * @param string $bin The BIN to look up.
     * @return string Country code associated with the BIN.
     */
    public function getCountryCode(string $bin): string
    {
        $response = $this->client->get($this->apiUrl . $bin);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result['country']['alpha2'];
    }
}
