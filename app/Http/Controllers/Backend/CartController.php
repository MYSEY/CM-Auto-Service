<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found']);
        }

        $cart = Session::get('cart', []);
        $cart[$product->id] = [
            'name' => $product->name ?? $product->category->name,
            'price' => $product->price ?? 0,
            'quantity' => ($cart[$product->id]['quantity'] ?? 0) + 1
        ];
        Session::put('cart', $cart);

        // Calculate total price & item count
        $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));
        $count = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'status' => 'success',
            'message' => 'Added to cart successfully',
            'count' => $count,
            'total' => $total,
        ]);
    }
}
