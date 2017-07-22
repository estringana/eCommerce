<?php

namespace Tests\Feature;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Teapot\StatusCode\Http;
use Tests\TestCase;

class ProductsCanBeRequestedTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function itShouldReturn200WhenVisitingAnExistingProduct()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create();
        $this->get('/api/products/' . $product->id)
            ->assertStatus(Http::OK);
    }

    /** @test */
    public function itShouldReturnNotFoundIfProductNotInDB()
    {
        $notExistingProductId = 12345;
        $this->get('/api/products/' . $notExistingProductId)
            ->assertStatus(Http::NOT_FOUND);
    }

    /** @test */
    public function itShouldReturnAProductWithNameAndDescription()
    {
        $product = factory(Product::class)->create();
        $response = $this->json('GET', '/api/products/' . $product->id);

        $response->assertStatus(Http::OK)
            ->assertJson([
                Product::FIELD_NAME => $product->name,
                Product::FIELD_DESCRIPTION => $product->description,
            ]);
    }
}
