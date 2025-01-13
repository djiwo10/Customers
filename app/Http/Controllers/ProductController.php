<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\http\Controllers\ProductController;
use App\Models\Product;

class ProductController extends Controller
{
    // Tambahkan metode index
    public function index()
    {
        return Product::all(); // Mengambil semua data dari tabel 'products'
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            ]);
            $product = Product::create($validated);
            return response()->json($product, 201);            
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            ]);
            $product = Product::findOrFail($id);
            $product->update($validated);
            return response()->json($product);
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted
        successfully']);
    }
}