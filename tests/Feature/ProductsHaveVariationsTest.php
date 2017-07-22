<?php

namespace Tests\Feature;

use App\Color;
use App\Product;
use App\Repositories\ProductRepository;
use App\Size;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Teapot\StatusCode\Http;
use Tests\TestCase;

class ProductsHaveVariationsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function ProductShouldReturnVariationsOfColorsAndSizes()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();
        $size = factory(Size::class)->create();
        $color = factory(Color::class)->create();
        // @TODO Change plug colors here
        $productRepository = new ProductRepository();
        $productRepository->addVariationToProduct($product, $size, $color);

        $response = $this->json(
            'GET',
            sprintf('/api/products/%s/variations', $product->id)
        );

        $decoded = $response->json();
        $response->assertStatus(Http::OK);
        $this->assertCount(1, $decoded);
        $response->assertJsonFragment($color->toArray());
        $response->assertJsonFragment($size->toArray());

    }

    /** @test */
    public function ProductShouldReturnMoreThanOneVariationsOfColorsAndSizes()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();
        [$sizeOne, $sizeTwo] = factory(Size::class, 2)->create();
        [$colorOne, $colorTwo] = factory(Color::class, 2)->create();
        $productRepository = new ProductRepository();
        $productRepository->addVariationToProduct($product, $sizeOne, $colorOne);
        $productRepository->addVariationToProduct($product, $sizeOne, $colorTwo);
        $productRepository->addVariationToProduct($product, $sizeTwo, $colorOne);
        $productRepository->addVariationToProduct($product, $sizeTwo, $colorTwo);

        $response = $this->json(
            'GET',
            sprintf('/api/products/%s/variations', $product->id)
        );

        $decoded = $response->json();
        $response->assertStatus(Http::OK);
        $this->assertCount(4, $decoded);
    }

    /** @test */
    public function ItShouldReturnAnEmptyResponseWhenNoVariationsAssociated()
    {
        $product = factory(Product::class)->create();
        $response = $this->json(
            'GET',
            sprintf('/api/products/%s/variations', $product->id)
        );
        $response->assertStatus(Http::OK);
        $response->assertJson([]);
    }
}
