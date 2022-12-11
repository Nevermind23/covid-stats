<?php

namespace App\Library;

use App\Library\Interfaces\ApiResponse;
use Illuminate\Http\JsonResponse;

class JsonApiResponse implements ApiResponse
{
    public function send(array $response, int $statusCode = 200): JsonResponse
    {
        return response()->json($response, $statusCode);
    }
}
