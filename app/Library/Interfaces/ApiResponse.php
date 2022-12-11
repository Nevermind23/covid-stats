<?php

namespace App\Library\Interfaces;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

interface ApiResponse
{
    public function send(array|JsonSerializable|Arrayable $response): mixed;
}
