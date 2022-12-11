<?php

namespace App\Console\Commands;

use App\Library\Interfaces\StatisticProcessor;
use App\Library\Interfaces\StatisticProvider;
use App\Models\Country;
use Illuminate\Console\Command;

class ProcessStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:statistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and update covid statistics for every country in the database';

    /**
     * Execute the console command.
     *
     * @param StatisticProvider $statisticProvider
     * @param StatisticProcessor $statisticProcessor
     * @return int
     */
    public function handle(
        StatisticProvider  $statisticProvider,
        StatisticProcessor $statisticProcessor
    ): int
    {
        $countries = Country::all();

        foreach ($countries as $country) {
            if ($country->updated_at->isToday() && $country->statistic()->exists()) {
                continue;
            }

            $data = $statisticProvider->getStatisticByCountries($country->code);
            $statisticProcessor->processStatistics($data);
        }

        return self::SUCCESS;
    }
}
