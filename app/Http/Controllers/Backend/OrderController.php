<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            $request->validate([
                'customer_name'              => 'required',
                'orderDetail'                => 'required|array|min:1',
                'orderDetail.*.product_id'   => 'required',
                'orderDetail.*.quantity'     => 'required|numeric|min:1',
                'orderDetail.*.price'        => 'required|numeric|min:0',
                'orderDetail.*.sub_total'    => 'required|numeric|min:0',
            ]);

            $totalQty = 0;
            $totalPrice = 0;
            foreach ($request->orderDetail as $item) {
                $totalQty += $item['quantity'];
                $totalPrice += $item['sub_total'];
            }

            $order = Order::create([
                'customer_name' => $request->customer_name,
                'telephone'     => $request->telephone,
                'email'         => $request->email,
                'order_date'    => $request->order_date,
                'total_qty'     => $totalQty,
                'total_price'   => $totalPrice,
                'status'        => 'requesting',
                'created_by'    => Auth::id(),
            ]);

            $details = [];
            foreach ($request->orderDetail as $item) {
                $details[] = [
                    'order_id'   => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                    'sub_total'  => $item['sub_total'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            OrderDetail::insert($details);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message'=> 'Order & details saved successfully'
            ]);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message'=> $e->getMessage()
            ], 500);
        }
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
