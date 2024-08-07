<?php

namespace App\Client;

use GuzzleHttp\Client;

class ApiClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function fetchData(string $url, string $apiKey): array
    {
        try {
            $response = $this->client->request('GET', $url, [
                'headers' => [
                    'Authorization' => $apiKey
                ]
            ]);

            $data = $response->getBody()->getContents();

            return json_decode($data, true);
        } catch (\Exception $e) {
            throw new \Exception('Erro ao buscar dados da API: ' . $e->getMessage());
        }
    }
}