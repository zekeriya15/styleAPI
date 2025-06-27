<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index () {
        $products = Product::all();

        $products->map(function ($product) {
            $product->image_url = Storage::url($product->image);
        });

        return response()->json($products);
    }

    public function show (Product $product) {

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
}
