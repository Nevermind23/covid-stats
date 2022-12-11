<?php

namespace App\Library\Sources\Devtest;

use App\Library\Interfaces\ApiProvider;
use App\Library\Interfaces\CountryProvider;
use App\Library\Interfaces\StatisticProvider;

class DevtestClient implements StatisticProvider, CountryProvider
{
    private ApiProvider $apiProvider;

    public function __construct(ApiProvider $apiProvider)
    {
        $this->apiProvider = $apiProvider;
    }

    public function getCountries(): array
    {
        $url  = "https://devtest.ge/countries";

        return $this->apiProvider->get($url);
    }

    public function getStatisticByCountries(string $code): array
    {
        $url  = "https://devtest.ge/countries";

        return $this->apiProvider->post($url, [
            'code' => $code
        ]);
    }
}
