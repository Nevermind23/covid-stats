<?php

namespace App\Providers;

use App\Library\Interfaces\ApiProvider;
use App\Library\Interfaces\ApiResponse;
use App\Library\Interfaces\CountryProvider;
use App\Library\JsonApiProvider;
use App\Library\JsonApiResponse;
use App\Library\Sources\Devtest\DevtestClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ApiProvider::class, JsonApiProvider::class);
        $this->app->bind(CountryProvider::class, DevtestClient::class);
        $this->app->bind(ApiResponse::class, JsonApiResponse::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
