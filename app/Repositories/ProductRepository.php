<?php

namespace App\Repositories;

use App\Color;
use App\Product;
use App\Size;
use App\Variation;

class ProductRepository
{
    public function addVariationToProduct(Product $product, Size $size, Color $color)
    {
        $variation = new Variation();
        $variation->product()->associate($product);
        $variation->size()->associate($size);
        $variation->color()->associate($color);
        $variation->save();
    }
}
