<?php

namespace App\Api;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class GeoApi extends BaseApi
{
    private function isPrivateIp(string $ip): bool
    {
        $addresses = [
            '10.0.0.0|10.255.255.255', // single class A network
            '172.16.0.0|172.31.255.255', // 16 contiguous class B network
            '192.168.0.0|192.168.255.255', // 256 contiguous class C network
            '169.254.0.0|169.254.255.255', // Link-local address also refered to as Automatic Private IP Addressing
            '127.0.0.0|127.255.255.255' // localhost
        ];

        $longIp = ip2long($ip);
        if ($longIp != -1) {
            foreach ($addresses as $address) {
                [$start, $end] = explode('|', $address);

                // IF IS PRIVATE
                if ($longIp >= ip2long($start) && $longIp <= ip2long($end)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getCountryData(string $ip): ?array
    {
        if ($this->isPrivateIp($ip)) {
            $ip = '8.8.8.8';
        }
        try {
            $response = $this->client->request(
                'GET',
                $this->apiUrl,
                [
                    'query' => [
                        'apiKey' => $this->apiKey,
                        'ip' => $ip
                    ]
                ]
            );
            return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        } catch (GuzzleException|JsonException) {
            return null;
        }
    }
}