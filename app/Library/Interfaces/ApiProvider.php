<?php

namespace App\Library\Interfaces;

interface ApiProvider
{
    public function get(string $url, array $headers = []): array;

    public function post(string $url, array $params, array $headers = []): array;
}
