<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\Statistic;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class StatisticApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private Collection $statistics;

    public function setUp(): void
    {
        parent::setUp();

        $this->statistics = Statistic::factory(10)->create();
    }

    public function test_get_statistics()
    {
        $this->actingAsUser();

        $response = $this->getJson(route('api.statistics.index'));
        $response->assertStatus(200);

        $this->assertArrayHasKey('data', $response);
        $this->assertCount($this->statistics->count(), $response['data']);

        foreach ($response['data'] as $statistic) {
            $this->assertArrayHasKey('id', $statistic);
            $this->assertIsNumeric($statistic['id']);
            $this->assertArrayHasKey('confirmed', $statistic);
            $this->assertIsNumeric($statistic['confirmed']);
            $this->assertArrayHasKey('recovered', $statistic);
            $this->assertIsNumeric($statistic['recovered']);
            $this->assertArrayHasKey('death', $statistic);
            $this->assertIsNumeric($statistic['death']);

            $this->assertArrayHasKey('country', $statistic);
        }

        $this->assertArrayHasKey('links', $response);
        $this->assertArrayHasKey('meta', $response);
    }

    public function test_get_statistics_authentication()
    {
        $response = $this->getJson(route('api.statistics.index'));
        $response->assertStatus(401);
    }

    public function test_get_statistic_by_country()
    {
        $this->actingAsUser();

        foreach ($this->statistics as $statistic) {
            $response = $this->getJson(route('api.statistics.show', $statistic->country->code));
            $response->assertStatus(200);

            $this->assertArrayHasKey('data', $response);
        }

    }

    public function test_get_statistic_by_country_authentication()
    {
        foreach ($this->statistics as $statistic) {
            $response = $this->getJson(route('api.statistics.show', $statistic->country->code));
            $response->assertStatus(401);
        }
    }

    public function test_get_statistic_by_country_without_country()
    {
        Country::truncate();
        $this->actingAsUser();

        foreach ($this->statistics as $statistic) {
            $response = $this->getJson(route('api.statistics.show', $statistic->country->code));
            $response->assertStatus(404);
        }
    }

    public function test_get_statistic_by_country_without_statistic()
    {
        Statistic::truncate();
        $this->actingAsUser();

        foreach ($this->statistics as $statistic) {
            $response = $this->getJson(route('api.statistics.show', $statistic->country->code));
            $response->assertStatus(404);
            $response->assertSeeText(Lang::get('messages.country_statistics_unavailable'));
            $this->assertArrayHasKey('message', $response);
        }

    }
}
