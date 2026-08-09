<?php

namespace App\Http\Controllers\Pwa;

use App\Models\Company;
use App\Models\Engine;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PwaController extends Controller
{
    private function getWishlistCount()
    {
        $sessionId = session()->getId();
        $userId = auth()->id();
        return Wishlist::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->count();
    }

    public function splash()
    {
        return view('pwa.splash');
    }

    public function home(Request $request)
    {
        $query = Product::with(['category', 'subCategory', 'productType', 'proEngine']);

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%$keyword%")
                    ->orWhere('description', 'LIKE', "%$keyword%")
                    ->orWhere('number', 'LIKE', "%$keyword%")
                    ->orWhereHas('category', fn($c) => $c->where('name', 'LIKE', "%$keyword%"))
                    ->orWhereHas('subCategory', fn($s) => $s->where('name', 'LIKE', "%$keyword%"))
                    ->orWhereHas('proEngine', fn($e) => $e->where('name', 'LIKE', "%$keyword%"));
            });
        }

        $products = $query->orderByRaw("CASE WHEN product_type_id = 1 THEN 0 ELSE 1 END")
            ->orderByRaw("CAST(SUBSTRING(number, 3) AS UNSIGNED) ASC")
            ->paginate(24);

        if ($request->ajax()) {
            $html = view('pwa.partials.product_grid', ['products' => $products])->render();
            return response()->json(['html' => $html]);
        }

        $company = Company::first();
        $productType = ProductType::all();
        $wishlistCount = $this->getWishlistCount();

        return view('pwa.home_pwa', compact('company', 'productType', 'products', 'wishlistCount'));
    }

    public function search(Request $request)
    {
        $query = Product::with(['category', 'subCategory', 'productType', 'proEngine']);

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%$keyword%")
                    ->orWhere('description', 'LIKE', "%$keyword%")
                    ->orWhere('number', 'LIKE', "%$keyword%")
                    ->orWhereHas('category', fn($c) => $c->where('name', 'LIKE', "%$keyword%"))
                    ->orWhereHas('subCategory', fn($s) => $s->where('name', 'LIKE', "%$keyword%"))
                    ->orWhereHas('proEngine', fn($e) => $e->where('name', 'LIKE', "%$keyword%"));
            });
        }

        if ($request->filled('type')) {
            $query->where('product_type_id', $request->type);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->orderByRaw("CAST(SUBSTRING(number, 3) AS UNSIGNED) ASC")
            ->paginate(24);

        if ($request->ajax()) {
            $html = view('pwa.partials.product_grid', compact('products'))->render();
            return response()->json(['html' => $html]);
        }

        $company = Company::first();
        $productType = ProductType::all();
        $wishlistCount = $this->getWishlistCount();
        return view('pwa.home_pwa', compact('company', 'productType', 'products', 'wishlistCount'));
    }

    public function productDetail($id)
    {
        $product = Product::with(['productImage', 'productType', 'category', 'subCategory', 'proEngine'])
            ->findOrFail($id);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(8)
            ->get();

        $company = Company::first();
        $productType = ProductType::all();
        $wishlistCount = $this->getWishlistCount();

        return view('pwa.product_detail', compact('product', 'relatedProducts', 'company', 'productType', 'wishlistCount'));
    }

    public function cart()
    {
        $cart = Session::get('cart', []);
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        $company = Company::first();
        $productType = ProductType::all();
        $wishlistCount = $this->getWishlistCount();

        return view('pwa.cart', compact('cart', 'subtotal', 'company', 'productType', 'wishlistCount'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found']);
        }

        $cart = Session::get('cart', []);
        $cart[$product->id] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->product_photo,
            'quantity' => ($cart[$product->id]['quantity'] ?? 0) + 1,
        ];
        Session::put('cart', $cart);

        $count = array_sum(array_column($cart, 'quantity'));
        $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));

        return response()->json(['status' => 'success', 'count' => $count, 'total' => $total]);
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = max(1, (int) $request->quantity);
            session()->put('cart', $cart);
        }

        $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));
        $count = array_sum(array_column($cart, 'quantity'));

        return response()->json(['status' => 'success', 'count' => $count, 'total' => $total]);
    }

    public function removeCart(Request $request)
    {
        $cart = session()->get('cart', []);
        unset($cart[$request->product_id]);
        session()->put('cart', $cart);

        $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));
        $count = array_sum(array_column($cart, 'quantity'));

        return response()->json(['status' => 'success', 'count' => $count, 'total' => $total]);
    }

    public function wishlist()
    {
        $company = Company::first();
        $productType = ProductType::all();
        $sessionId = session()->getId();
        $userId = auth()->id();

        $wishlistItems = Wishlist::with('product.category', 'product.subCategory', 'product.proEngine')
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->get();

        $wishlistCount = $wishlistItems->count();

        return view('pwa.wishlist', compact('company', 'productType', 'wishlistItems', 'wishlistCount'));
    }

    public function contact()
    {
        $company = Company::first();
        $productType = ProductType::all();
        $wishlistCount = $this->getWishlistCount();

        return view('pwa.contact', compact('company', 'productType', 'wishlistCount'));
    }

    public function account()
    {
        if (!auth()->check()) {
            return redirect()->route('pwa.home');
        }

        $user = auth()->user();
        $company = Company::first();
        $productType = ProductType::all();
        $wishlistCount = $this->getWishlistCount();

        return view('pwa.account', compact('user', 'company', 'productType', 'wishlistCount'));
    }

    public function profile()
    {
        if (!auth()->check()) {
            return redirect()->route('pwa.home');
        }

        $user = auth()->user();
        $company = Company::first();
        $productType = ProductType::all();
        $wishlistCount = $this->getWishlistCount();

        return view('pwa.profile', compact('user', 'company', 'productType', 'wishlistCount'));
    }

    public function profileUpdate(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $emailExists = User::where('email', $request->email)->where('id', '!=', $user->id)->first();
        if ($emailExists) {
            return response()->json(['status' => 'error', 'message' => 'Email already taken.']);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json(['status' => 'success']);
    }

    public function profilePassword(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['status' => 'error', 'message' => 'Current password is incorrect.']);
        }

        $request->validate([
            'new_password' => 'required|string|min:6',
        ]);

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['status' => 'success']);
    }
}