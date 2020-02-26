<?php

namespace Tests\Feature\http\controllers\api;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class productControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_create_product()
    {
        // Given
            $faker = Factory::create();
            // user is authenticated
        //When
            $response = $this->json('POST', '/api/products', [
                'name' => $name = $faker->company,
                'slug' => Str::slug($name),
                'price' => $price = mt_rand(10,100)
            ]);

            //post request create product
        //Then
            // product exists
            $response->assertJsonStructure([
                'id', 'name', 'slug', 'price', 'created_at'
            ])->assertJson([
                'name' => $name,
                'slug' => Str::slug($name),
                'price' => $price
            ])
                ->assertStatus(201);

            $this->assertDatabaseHas('products', [
                'name' => $name,
                'slug' => Str::slug($name),
                'price' => $price
            ]);

    }
}
