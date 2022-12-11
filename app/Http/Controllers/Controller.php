<?php

namespace App\Http\Controllers;

use App\Library\Interfaces\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected ApiResponse $apiResponse;

    public function __construct(ApiResponse $response)
    {
        $this->apiResponse = $response;
    }
}
