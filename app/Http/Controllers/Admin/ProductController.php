<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;              // your Product model
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Show the products list page.
     */
    public function index()
    {
        // Fetch all products. You may paginate if many.
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'unit_price' => 'required|numeric|min:0',
            'ready'      => 'required|boolean',
            'image'      => 'required|image|max:2048',
            // 'sales' omitted: default 0 on creation
        ]);

        // Store image in 'storage/app/public/products', ensure 'php artisan storage:link' is done
        $path = $request->file('image')->store('products', 'public');

        $product = new Product();
        $product->name       = $validated['name'];
        $product->unit_price = $validated['unit_price'];
        $product->ready      = $validated['ready'];
        $product->image_url  = Storage::url($path); // e.g. '/storage/products/xxx.jpg'
        $product->sales      = 0;
        $product->save();

        Session::flash('success', 'Product added successfully.');
        return redirect()->route('admin.products.index');
    }

    /**
     * Update an existing product.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'unit_price' => 'required|numeric|min:0',
            'ready'      => 'required|boolean',
            'image'      => 'nullable|image|max:2048',
            'sales'      => 'required|integer|min:0',
        ]);

        // If a new image uploaded, delete old and store new
        if ($request->hasFile('image')) {
            // Delete old file if exists
            if ($product->image_url) {
                // Assuming image_url is like '/storage/products/xxx.jpg'
                $oldPath = str_replace('/storage/', '', $product->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image')->store('products', 'public');
            $product->image_url = Storage::url($path);
        }

        $product->name       = $validated['name'];
        $product->unit_price = $validated['unit_price'];
        $product->ready      = $validated['ready'];
        $product->sales      = $validated['sales'];
        $product->save();

        Session::flash('success', 'Product updated successfully.');
        return redirect()->route('admin.products.index');
    }
}
