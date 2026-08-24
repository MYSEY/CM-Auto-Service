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
    public function index()
    {
        $cart = Session::get('cart', []);
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $shipping = 0;
        $total = $subtotal + $shipping;

        $company = Company::first();
        $category = ProductCategory::with('subCategory')->get();
        $productType = ProductType::all();

        return view('frontends.cart', compact('cart', 'subtotal', 'shipping', 'total', 'company', 'category', 'productType'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::with(['category', 'subCategory', 'proEngine'])->find($request->id);
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found']);
        }

        $name = trim(($product->name ?? '') ?: implode(' ', array_filter([
            $product->category?->name,
            $product->subCategory?->name,
            $product->year,
            $product->proEngine?->name,
            $product->proEngine?->part_number,
            $product->number
        ])));

        if (empty($name)) {
            $name = 'Product #' . $product->id;
        }

        $cart = Session::get('cart', []);
        $cart[$product->id] = [
            'id' => $product->id,
            'name' => $name,
            'price' => (float) ($product->price ?? 0),
            'image' => $product->product_photo,
            'quantity' => ($cart[$product->id]['quantity'] ?? 0) + 1
        ];
        Session::put('cart', $cart);

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
        $product = Product::with(['category', 'subCategory', 'proEngine'])->find($request->id);
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found']);
        }

        $name = trim(($product->name ?? '') ?: implode(' ', array_filter([
            $product->category?->name,
            $product->subCategory?->name,
            $product->year,
            $product->proEngine?->name,
            $product->proEngine?->part_number,
            $product->number
        ])));

        if (empty($name)) {
            $name = 'Product #' . $product->id;
        }

        $quantity = max(1, (int) ($request->qty ?? 1));
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = ($cart[$product->id]['quantity'] ?? 0) + $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $name,
                'price' => (float) ($product->price ?? 0),
                'image' => $product->product_photo,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        $totalQty = array_sum(array_column($cart, 'quantity'));
        $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        return response()->json([
            'status' => 'success',
            'count' => $totalQty,
            'total' => $totalPrice,
        ]);
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->product_id;
        $quantity = max(1, (int) $request->quantity);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        $totalQty = array_sum(array_column($cart, 'quantity'));
        $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        return response()->json([
            'status' => 'success',
            'count' => $totalQty,
            'total' => $totalPrice,
            'item_total' => isset($cart[$productId]) ? $cart[$productId]['price'] * $quantity : 0,
        ]);
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        $totalQty = array_sum(array_column($cart, 'quantity'));
        $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        return response()->json([
            'status' => 'success',
            'count' => $totalQty,
            'total' => $totalPrice,
        ]);
    }

    public function clear()
    {
        Session::forget('cart');
        return response()->json(['status' => 'success', 'message' => 'Cart cleared']);
    }

    public function loadMiniCart()
    {
        $cart = session('cart', []);
        $totalQty = array_sum(array_column($cart, 'quantity'));
        $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        $html = view('frontends.partials.mini_cart', compact('cart', 'totalQty', 'totalPrice'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $totalQty,
            'total' => $totalPrice,
        ]);
    }
}