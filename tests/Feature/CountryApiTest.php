<?php

namespace Tests\Feature;

use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CountryApiTest extends TestCase
{
    use RefreshDatabase;

    private Collection $countries;

    public function setUp(): void
    {
        parent::setUp();

        $this->countries = Country::factory(10)->create();
    }

    public function test_get_all_countries()
    {
        $this->actingAsUser();

        $response = $this->getJson(route('api.countries'));
        $response->assertStatus(200);

        $this->assertArrayHasKey('data', $response);
        $this->assertCount($this->countries->count(), $response['data']);

        foreach ($response['data'] as $country) {
            $this->assertArrayHasKey('id', $country);
            $this->assertIsInt($country['id']);
            $this->assertArrayHasKey('name', $country);
            $this->assertIsArray($country['name']);
            $this->assertArrayHasKey('updated_at', $country);
        }
    }

    public function test_get_all_countries_authentication()
    {
        $response = $this->getJson(route('api.countries'));
        $response->assertStatus(401);
    }

}
