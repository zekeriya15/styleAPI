<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:create,' . Product::class)->only('store');
        $this->middleware('can:update,product')->only('update');
        $this->middleware('can:delete,product')->only('destroy');
    }


    public function index () {
        $products = Product::all();

        $products->map(function ($product) {
            $product->image_url = Storage::url($product->image);
        });

        return response()->json($products);
    }

    public function show (Product $product) {
        $product->image_url = Storage::url($product->image);

        return response()->json($product);
    }

    public function store (Request $request) {
        $validatedProduct = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string|max:255',
            'size' => 'required|string|max:10',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        $validatedProduct['image'] = $imagePath;
        $product = Product::create($validatedProduct);

        return response()->json(['message' => 'Product added successfully', 'id' => $product->id]);
    }

    public function update (Request $request, Product $product) {
        $validatedProduct = $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string|max:255',
            'size' => 'required|string|max:10',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        // keep old image if not updating
        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            // delete old image
            Storage::disk('public')->delete($product->image);
            // store new image
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $validatedProduct['image'] = $imagePath;
        $product->update($validatedProduct);

        return response()->json(['message' => 'Product updates successfully'], 200);
    }

    public function destroy (Product $product) {
        Storage::disk('public')->delete($product->image);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
