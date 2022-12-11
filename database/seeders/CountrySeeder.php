<?php

namespace Database\Seeders;

use App\Library\Interfaces\CountryProvider;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    private CountryProvider $countryProvider;

    public function __construct(CountryProvider $countryProvider)
    {
        $this->countryProvider = $countryProvider;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Country::exists()) {
            return;
        }

        $countries = $this->countryProvider->getCountries();

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}
