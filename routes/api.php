<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\SanctumAuthController;
use App\Http\Controllers\StatisticController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('guest:sanctum')
    ->group(function () {
        Route::post('/login', [SanctumAuthController::class, 'login'])
            ->name('login');

        Route::post('/register', [SanctumAuthController::class, 'register'])
            ->name('register');
    });

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::post('/logout', [SanctumAuthController::class, 'logout'])
            ->name('logout');

        Route::get('/countries', [CountryController::class, 'index'])
            ->name('countries');

        Route::prefix('statistics')
            ->as('statistics.')
            ->group(function () {
                Route::get('/', [StatisticController::class, 'index'])
                    ->name('index');

                Route::get('/{code}', [StatisticController::class, 'show'])
                    ->where('code', '[A-Za-z]{2}')
                    ->name('show');
            });

    });
