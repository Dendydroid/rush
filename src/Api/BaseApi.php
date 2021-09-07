<?php

namespace App\Api;

use GuzzleHttp\Client;

abstract class BaseApi
{
    protected Client $client;
    protected string $apiKey;
    protected string $apiUrl;

    public function __construct(Client $client, string $apiUrl, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
    }
}