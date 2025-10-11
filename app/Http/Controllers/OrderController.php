<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders=Order::latest()->get();
        return view('pos.order.index',compact('orders'));
    }

    public function show($id)
{
    try {

        $order = Order::with('items.product')->findOrFail($id);

        // Render a partial view with order details
        $html = view('pos.order.partials.order-details', compact('order'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error loading order details: ' . $e->getMessage()
        ], 500);
    }
}


}
