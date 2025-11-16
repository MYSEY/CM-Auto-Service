<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Company;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
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
    public function addToCartDetail(Request $request)
    {
       $product = Product::find($request->id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ]);
        }
        $quantity = $request->qty ?? 1;
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = ($cart[$product->id]['quantity'] ?? 0) + $quantity;
        } else {
            $cart[$product->id] = [
                'id'       => $product->id,
                'price'    => $product->price,
                'quantity' => $quantity,
            ];
        }

        // Save session
        session()->put('cart', $cart);
        // Calculate totals
        $totalQty = array_sum(array_column($cart, 'quantity'));
        $totalPrice = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        return response()->json([
            'status' => 'success',
            'count'  => $totalQty,
            'total'  => $totalPrice,
        ]);
    }

   public function loadMiniCart()
    {
        // ១. ទាញយកទិន្នន័យ Cart (ឧទាហរណ៍ ដោយប្រើ Session ឬ Database)
        $cartItems = session('cart', []);

        // ២. បញ្ចូលទិន្នន័យទៅក្នុង View (ឧទាហរណ៍៖ mini_cart_view.blade.php)
        $miniCartHtml = view('path.to.mini_cart_view', compact('cartItems'))->render();

        // ៣. ត្រឡប់ទិន្នន័យជា JSON ទៅកាន់ AJAX
        return response()->json([
            'success' => true,
            'html' => $miniCartHtml, // HTML ដែលត្រូវបាន render រួច
            'count' => count($cartItems)
        ]);
    }
}
