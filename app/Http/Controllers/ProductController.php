<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Display all products
    public function index()
    {
        $products = Product::all();
        return view('layouts.shop', compact('products'));
    }

    // Add a product to the cart
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name'     => $product->nama,
                'price'    => $product->price,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    // View cart
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('layouts.cart', compact('cart'));
    }

    // Update quantity in cart
    public function updateCart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');

            if (isset($cart[$request->id])) {
                $cart[$request->id]["quantity"] = $request->quantity;
                session()->put('cart', $cart);
            }

            return redirect()->back()->with('success', 'Cart updated successfully!');
        }

        return redirect()->back()->with('error', 'Invalid cart update request.');
    }

    // Remove product from cart
    public function removeFromCart(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');

            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }

            return redirect()->back()->with('success', 'Product removed successfully!');
        }

        return redirect()->back()->with('error', 'Invalid remove request.');
    }
}
