<?php

namespace App\Library;

use App\Library\Interfaces\ApiResponse;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JsonSerializable;

class JsonApiResponse implements ApiResponse
{
    public function send(array|JsonSerializable|Arrayable $response, int $statusCode = 200): JsonResponse
    {
        if ($response instanceof AnonymousResourceCollection) {
            return $response->response()->setStatusCode($statusCode);
        }

        return response()->json($response, $statusCode);
    }
}
