<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Company;
use App\Models\ProductType;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $company = Company::first();
        $category = ProductCategory::with('subCategory')->get();
        $productType = ProductType::all();

        return view('frontends.account', compact('user', 'company', 'category', 'productType'));
    }

    public function orders()
    {
        $user = auth()->user();
        $orders = Order::with('details.product')
            ->where('created_by', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $company = Company::first();
        $category = ProductCategory::with('subCategory')->get();
        $productType = ProductType::all();

        return view('frontends.orders', compact('orders', 'user', 'company', 'category', 'productType'));
    }

    public function orderDetail($id)
    {
        $user = auth()->user();
        $order = Order::with('details.product')
            ->where('id', $id)
            ->where('created_by', $user->id)
            ->firstOrFail();

        $company = Company::first();
        $category = ProductCategory::with('subCategory')->get();
        $productType = ProductType::all();

        return view('frontends.order_detail', compact('order', 'user', 'company', 'category', 'productType'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $user = auth()->user();
        $user->update($validated);

        return redirect()->route('account.index')->with('success', 'Profile updated successfully');
    }
}