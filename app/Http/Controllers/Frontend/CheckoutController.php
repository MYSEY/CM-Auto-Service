<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Company;
use App\Models\ProductType;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $shipping = 0;
        $total = $subtotal + $shipping;

        $company = Company::first();
        $category = ProductCategory::with('subCategory')->get();
        $productType = ProductType::all();

        return view('frontends.checkout', compact('cart', 'subtotal', 'shipping', 'total', 'company', 'category', 'productType'));
    }

    public function placeOrder(Request $request)
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
        ]);

        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $shipping = 0;
        $total = $subtotal + $shipping;

        $order = Order::create([
            'order_date' => now()->toDateString(),
            'status' => 'pending',
            'created_by' => auth()->id(),
        ]);

        foreach ($cart as $productId => $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'sub_total' => $item['price'] * $item['quantity'],
            ]);
        }

        Session::forget('cart');

        return redirect()->route('account.orders')->with('success', 'Order placed successfully! Order #' . $order->id);
    }
}