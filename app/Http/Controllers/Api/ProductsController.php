<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;

class ProductsController extends Controller
{
    public function get(Product $product)
    {
        return $product;
    }
}
