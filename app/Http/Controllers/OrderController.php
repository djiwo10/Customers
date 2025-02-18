<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User; // Perbaiki namespace User jika diperlukan
use App\Models\Customer; // Pastikan model Customer ada

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['product', 'customer'])->get();
        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'total_price' => 'required|numeric',
        ]);

        $order = Order::create([
            'customer_id' => $request->customer_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
        ]);

        return response()->json([
            'id' => $order->id, // Tambahkan ID dalam response
            'customer_id' => $order->customer_id,
            'product_id' => $order->product_id,
            'quantity' => $order->quantity,
            'total_price' => $order->total_price,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['product', 'customer'])->findOrFail($id);
        return response()->json($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'total_price' => 'required|numeric',
        ]);

        $order = Order::findOrFail($id);
        $order->update($validated);

        return response()->json([
            'id' => $order->id, // Pastikan ID tetap ada
            'customer_id' => $order->customer_id,
            'product_id' => $order->product_id,
            'quantity' => $order->quantity,
            'total_price' => $order->total_price,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}