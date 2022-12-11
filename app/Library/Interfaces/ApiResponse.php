<?php

namespace App\Library\Interfaces;

interface ApiResponse
{
    public function send(array $response): mixed;
}
