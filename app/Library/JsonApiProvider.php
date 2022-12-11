<?php

namespace App\Library;

use App\Library\Interfaces\ApiProvider;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class JsonApiProvider implements ApiProvider
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get(string $url, array $headers = []): array
    {
        $response = $this->client->get($url,[
            'headers' => $headers
        ]);

        return $this->toArray($response);
    }

    public function post(string $url, array $params, array $headers = []): array
    {
        $response = $this->client->post($url, [
            'json' => $params,
            'headers' => $headers
        ]);

        return $this->toArray($response);
    }

    private function toArray(ResponseInterface $response): array {
        return json_decode($response->getBody(), true);
    }
}
