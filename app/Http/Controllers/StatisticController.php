<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatisticResource;
use App\Models\Country;
use App\Models\Statistic;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StatisticController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $statistics = Statistic::latest()->paginate(config('basic.pagination'));

        return StatisticResource::collection($statistics);
    }

    public function show(string $code): StatisticResource
    {
        $country = Country::where('code', $code)->firstOrFail();

        return new StatisticResource($country->statistic);
    }
}
