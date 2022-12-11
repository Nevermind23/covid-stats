<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatisticResource;
use App\Models\Country;
use App\Models\Statistic;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Lang;

class StatisticController extends Controller
{
    public function index()
    {
        $statistics = Statistic::latest()->paginate(config('basic.pagination'));

        return $this->apiResponse->send(StatisticResource::collection($statistics));
    }

    public function show(string $code)
    {
        $country = Country::where('code', $code)->firstOrFail();

        if (is_null($country->statistic)) {
            return $this->apiResponse->send([
                'message' => Lang::get('messages.country_statistics_unavailable')
            ], 404);
        }

        return $this->apiResponse->send([
            'data' => new StatisticResource($country->statistic)
        ]);
    }
}
