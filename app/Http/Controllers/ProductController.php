<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

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
                'name' => $product->nama,
                'price' => $product->price,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    // View cart & user-specific order history
    public function cart()
    {
        $cart = session()->get('cart', []);

        // Only show orders placed by the current user
        $orders = DB::table('order_item')
            ->join('order', 'order_item.order_id', '=', 'order.order_id')
            ->join('users', 'order.users_id', '=', 'users.id')
            ->join('product', 'order_item.product_id', '=', 'product.product_id')
            ->where('users.id', Auth::id())
            ->select(
                'users.name as customer_name',
                'product.nama as product_name',
                'order_item.qty',
                'order_item.price',
                'order.date'
            )
            ->orderBy('order.date', 'desc')
            ->get();

        return view('layouts.cart', compact('cart', 'orders'));
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

    // Place an order and store in DB
    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        $user = Auth::user();
        $orderId = strtoupper(Str::random(5));

        // Insert order
        Order::create([
            'order_id' => $orderId,
            'users_id' => $user->id, // Match your DB schema (foreign key to users)
            'date' => now(),
        ]);

        // Insert order items
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $orderId,
                'product_id' => $productId,
                'qty' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('cart')->with('success', "Order $orderId placed successfully!");
    }
}
