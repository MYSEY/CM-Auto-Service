<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    public function index()
    {
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

        $company = \App\Models\Company::first();
        $category = \App\Models\ProductCategory::with('subCategory')->get();
        $productType = \App\Models\ProductType::all();

        return view('frontends.wishlist', compact('wishlistItems', 'company', 'category', 'productType'));
    }

    public function toggle(Request $request)
    {
        $productId = $request->product_id;
        $sessionId = session()->getId();
        $userId = auth()->id();

        $existing = Wishlist::where('product_id', $productId)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        if ($existing) {
            $existing->delete();
            $count = Wishlist::where(function ($query) use ($userId, $sessionId) {
                if ($userId) { $query->where('user_id', $userId); }
                else { $query->where('session_id', $sessionId); }
            })->count();
            return response()->json(['status' => 'removed', 'message' => 'Removed from wishlist', 'count' => $count]);
        }

        Wishlist::create([
            'user_id' => $userId,
            'session_id' => $userId ? null : $sessionId,
            'product_id' => $productId,
        ]);

        $count = Wishlist::where(function ($query) use ($userId, $sessionId) {
            if ($userId) { $query->where('user_id', $userId); }
            else { $query->where('session_id', $sessionId); }
        })->count();

        return response()->json(['status' => 'added', 'message' => 'Added to wishlist', 'count' => $count]);
    }

    public function remove(Request $request)
    {
        $sessionId = session()->getId();
        $userId = auth()->id();

        Wishlist::where('product_id', $request->product_id)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->delete();

        $count = Wishlist::where(function ($query) use ($userId, $sessionId) {
            if ($userId) { $query->where('user_id', $userId); }
            else { $query->where('session_id', $sessionId); }
        })->count();

        return response()->json(['status' => 'success', 'message' => 'Removed from wishlist', 'count' => $count]);
    }

    public function check(Request $request)
    {
        $sessionId = session()->getId();
        $userId = auth()->id();

        $exists = Wishlist::where('product_id', $request->product_id)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->exists();

        return response()->json(['in_wishlist' => $exists]);
    }
}