<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index(){
        $products=Product::all();
        return view('pos.index', compact('products'));
    }

    public function addToCart(Request $request)
{

    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity'   => 'required|integer|min:1',
    ]);

    $product = Product::findOrFail($request->product_id);
    if ($request->quantity > $product->quantity) {
        return response()->json([
            'success' => false,
            'message' => "Only {$product->quantity} items are available in stock.",
        ], 422);
    }

    $cart = session('cart', []);



    $cart[$product->id] = [
        'name'          => $product->name,
        'price'         => $product->cost_price_per_unit,
        'available_qty' => max(0, $product->quantity - $request->quantity),
        'quantity'      => (int) $request->quantity,
        'total'         => $product->cost_price_per_unit * $request->quantity,
    ];


    session(['cart' => $cart]);
    session(['cart_total' => collect($cart)->sum('total')]);


    $html = view('pos.data-table',[
    'cart' => $cart,
    'grandTotal' => session('cart_total')], compact('cart'))->render();

    return response()->json([
        'success' => true,
        'message' => 'Product added to cart',
        'html'    => $html
    ]);
}


   public function store(Request $request)
{
    DB::beginTransaction();

    try {
        $cart = session('cart', []);
        $grand = session('cart_total', 0);

        if (empty($cart)) {

            return response()->json(['success' => false, 'message' => 'Cart is empty.'], 422);
        }


        $order = Order::create([
            'invoice_no'   => strtoupper(Str::random(8)),
            'total_amount' => $grand,
        ]);


        foreach ($cart as $productId => $item) {


            $product = Product::where('id', $productId)->lockForUpdate()->first();


            if (!$product || $product->quantity < $item['quantity']) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => "Not enough stock for: {$item['name']}"
                ], 422);
            }

            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $productId,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'total'      => $item['total'],
            ]);

            $product->decrement('quantity', $item['quantity']);
        }

        DB::commit();
        session()->forget(['cart','cart_total']);


        return $this->getLatestRecord('Order placed successfully!', true);

    } catch (Throwable $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
    }
}

public function destroy(Request $request)
{
    $cart = session('cart', []);


    if (! isset($cart[$request->product_id])) {
        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart'
        ]);
    }

    unset($cart[$request->product_id]);

    session(['cart' => $cart]);
    session(['cart_total' => collect($cart)->sum('total')]);


    return $this->getLatestRecord('Product removed successfully', true);
}

    private function getLatestRecord($message='Record Saved Successfuly', $success=true){

    $cart = session('cart', []);
    $cartTotal = collect($cart)->sum('total');
    $html = view('pos.data-table', compact('cart'))->render();
    return response()->json(['success' => $success, 'message' => $message, 'html' => $html, 'grandTotal'=>$cartTotal]);
    }
}
