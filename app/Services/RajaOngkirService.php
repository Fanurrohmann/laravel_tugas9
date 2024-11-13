<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class RajaOngkirService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.rajaongkir.com/starter/',
            'headers' => [
                'key' => env('RAJAONGKIR_API_KEY'),
            ]
        ]);
    }

    public function getProvinces()
    {
        try {
            $response = $this->client->get('province');
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return ['error' => 'Failed to retrieve provinces: ' . $e->getMessage()];
        }
    }

    public function getCities($provinceId)
    {
        try {
            $response = $this->client->get("city?province={$provinceId}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return ['error' => 'Failed to retrieve cities: ' . $e->getMessage()];
        }
    }

    public function getShippingCost($origin, $destination, $weight, $courier)
    {
        try {
            $response = $this->client->post('cost', [
                'form_params' => [
                    'origin' => $origin,
                    'destination' => $destination,
                    'weight' => $weight,
                    'courier' => $courier,
                ]
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return ['error' => 'Failed to check shipping cost: ' . $e->getMessage()];
        }
    }
}
