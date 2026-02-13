<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Order::select(
                'orders.*',
            );
            // 🔍 global search filter
            if ($request->name) {
                $query->where('name', 'like', "%{$request->name}%");
            }
            if ($request->telephone) {
                $query->where('telephone', 'like', "%{$request->telephone}%");
            }
            if ($request->email) {
                $query->where('email', 'like', "%{$request->email}%");
            }
            if ($request->total_price) {
                $query->where('total_price', 'like', "%{$request->total_price}%");
            }
            if ($request->total_qty) {
                $query->where('total_qty', 'like', "%{$request->total_qty}%");
            }
            if ($request->total_discount) {
                $query->where('total_discount', 'like', "%{$request->total_discount}%");
            }
            if ($request->order_date) {
                $query->where('order_date', 'like', "%{$request->order_date}%");
            }

            $recordsTotal = Order::count();
            $recordsFiltered = $query->count();
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));
            $data = $query->skip($start)->take($limit)->get();
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data,
            ]);
        }
        return view('backend.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('backend.orders.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
