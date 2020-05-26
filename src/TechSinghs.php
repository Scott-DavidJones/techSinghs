<?php

namespace MobiMarket\TechSinghs;

use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use InvalidArgumentException;
use MobiMarket\TechSinghs\Requests\BaseRequest;
use MobiMarket\TechSinghs\Requests\BatchRequest;
use MobiMarket\TechSinghs\Requests\OrderRequest;
use Illuminate\Support\Facades\Log;
use stdClass;

class TechSinghs
{
    const API_BASE_URL          = 'https://api.techsinghs.com';
    const API_BATCH_ENDPOINT    = 'BatchOrders';
    const API_ORDERS_ENDPOINT   = 'orders';
    const API_ACCOUNT_ENDPOINT  = 'Users/me';
    const API_SERVICES_ENDPOINT = 'Services';

    private $guzzleClient;

    private $options = [
        'base_uri'      => self::API_BASE_URL,
        'timeout'       => 10.0,
        'http_errors'   => false,
    ];

    private $headers =  [
        'Content-Type'  => 'application/json',
        'Accept'        => 'application/json',
    ];

    private $apiKey;

    public function __construct(string $apiKey, float $timeout)
    {
        $this->apiKey               = $apiKey;
        $this->options['timeout']   = $timeout;
    }

    /**
     * returns a guzzle client. if one is not setup it creates a new one
     */
    public function getClient(): Client
    {
        if (null === $this->guzzleClient) {
            $this->guzzleClient = null;
            $this->guzzleClient = new Client($this->options);
            $this->headers['x-api-key'] = $this->apiKey;
        }

        return $this->guzzleClient;
    }
    /**
     * makes the actual post request to the API
     */
    public function makePostRequest(string $endPoint, BaseRequest $request): stdClass
    {
        if (!in_array($endPoint, [
            self::API_BATCH_ENDPOINT,
            self::API_ORDERS_ENDPOINT,
        ])) {
            throw new InvalidArgumentException("'{$endPoint}' is an invalid POST endpoint", 8903);
        }

        $response = $this->getClient()->post($endPoint, [
            'json'          => $request->toArray(),
            'headers'       => $this->headers,
        ]);

        return json_decode($response->getBody());
    }

    /**
     * makes the actual post request to the API
     */
    public function makeGetRequest(string $endPoint, string $batchId = null): stdClass
    {
        if (!in_array($endPoint, [
            self::API_BATCH_ENDPOINT,
            self::API_ACCOUNT_ENDPOINT,
            self::API_SERVICES_ENDPOINT,
        ])) {
            throw new InvalidArgumentException("'{$endPoint}' is an invalid GET endpoint", 8904);
        }

        if (null !== $batchId) {
            $endpoint .= "/{$batchId}";
        }
        $response = $this->getClient()->get($endPoint, [
            'headers'       => $this->headers,
        ]);

        return json_decode($response->getBody());
    }


    /**
     * Send a request for a single IMEI
     */
    public function checkSingleImei(string $imei): stdClass
    {
        $request = new OrderRequest;
        $request->setImei($imei);

        return $this->makePostRequest(self::API_ORDERS_ENDPOINT, $request);
    }
    /**
     * Initiates a batch request
     */
    public function initiateImeiBatch(array $imeis): stdClass
    {
        $request = new BatchRequest;
        $request->setImeiList($imeis);

        return $this->makePostRequest(self::API_BATCH_ENDPOINT, $request);
    }
    /**
     * sends a requets to check the batch status
     */
    public function getBatchResults(string $batchId): stdClass
    {
        return $this->makeGetRequest(self::API_BATCH_ENDPOINT, $batchId);
    }

    /**
     * gets account data
     */
    public function getAccountInfo(): stdClass
    {
        return $this->makeGetRequest(self::API_ACCOUNT_ENDPOINT);
    }

    /**
     * returns a list of all available services
     */
    public function getServices(): stdClass
    {
        return $this->makeGetRequest(self::API_SERVICES_ENDPOINT);
    }
}
