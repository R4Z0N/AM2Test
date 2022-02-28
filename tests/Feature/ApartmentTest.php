<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Apartment;
use App\Models\Category;

class ApartmentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_api_unauthorized()
    {
        $response = $this->getJson('/api/test');
        $response
            ->assertStatus(403);
    }

    public function test_search_apartments()
    {
        $apartment = Apartment::factory()->create();

        $response = $this->get('/api/apartments', [
            's' =>  $apartment->name,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'meta'  =>  [
                    'total' =>  1
                ],
            ]);
    }


    public function test_store_apartment()
    {
        $category = Category::factory()->create();

        $response = $this->post('/api/apartments', [
            'name'  =>  'Test apartment',
            'price' =>  10.00,
            'currency'  =>  'EUR',
            'category_id'   =>  $category->id
        ]);

        $response
            ->assertStatus(201);
    }

    public function test_update_apartment()
    {
        $apartment = Apartment::factory()->create();
        $category = Category::factory()->create();

        $response = $this->patch('/api/apartments/'.$apartment->id, [
            'name'  =>  'Test update apartment',
            'price' =>  10.00,
            'currency'  =>  'EUR',
            'category_id'   =>  $category->id
        ]);

        $response
            ->assertStatus(200);
    }

    public function test_delete_apartment()
    {
        $apartment = Apartment::factory()->create();

        $response = $this->delete('/api/apartments/'.$apartment->id);

        $response
            ->assertStatus(200);
    }
}
