<?php

namespace App\Library\Sources\Devtest;

use App\Library\Interfaces\StatisticProcessor;
use App\Models\Country;
use App\Models\Statistic;

class DevtestProcessor implements StatisticProcessor
{
    public function processStatistics(array $data, ?Country $country = null): void
    {
        $country ??= Country::where('code', $data['code'])->first();

        if (is_null($country)) {
            return;
        }

        $createData = [
            'country_id' => $country->id,
        ];

        //Specifying updated_at manually in case all values are equal
        //to update it and trigger corresponding functionality
        $updateData = [
            'confirmed' => $data['confirmed'],
            'recovered' => $data['recovered'],
            'death' => $data['deaths'],
            'updated_at' => now()
        ];

        Statistic::updateOrCreate($createData, $updateData);
    }
}
