<?php

namespace App\Client;

use GuzzleHttp\Client;

class ApiClient
{
    private Client $client;
    private string $apiKey;
    private string $baseUrl;

    public function __construct(string $apiKey, string $baseUrl)
    {
        $this->client = new Client();
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
    }

    public function getProcessList(string $tribunal): array
    {
        $url = $this->prepareUrl($tribunal);
        try {
            $response = $this->client->request('GET', $url, [
                'headers' => [
                    'Authorization' => $this->apiKey
                ]
            ]);

            $data = $response->getBody()->getContents();

            return json_decode($data, true);
        } catch (\Exception $e) {
            throw new \Exception('Erro ao buscar dados da API: ' . $e->getMessage());
        }
    }

    private function prepareUrl(string $tribunal): string
    {
        return $this->baseUrl . $tribunal . '/_search';
    }
}