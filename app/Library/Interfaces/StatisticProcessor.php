<?php

namespace App\Library\Interfaces;

use App\Models\Country;

interface StatisticProcessor
{
    public function processStatistics(array $data, ?Country $country = null): void;
}
