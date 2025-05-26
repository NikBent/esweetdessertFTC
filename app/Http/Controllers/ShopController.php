<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        // Static product image names (in public/images)
        $products = collect(range(1, 12))->map(function ($i) {
            return [
                'image' => "images/product{$i}.jpg",
                'alt' => "Product {$i}",
            ];
        });

        return view('pages.shop', compact('products'));
    }
}
