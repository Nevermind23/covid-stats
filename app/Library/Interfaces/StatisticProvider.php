<?php

namespace App\Library\Interfaces;

interface StatisticProvider
{
    public function getStatisticByCountries(string $code): array;
}
