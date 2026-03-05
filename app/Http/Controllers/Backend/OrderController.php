<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
                'products.name as product_name',
                'product_types.name as product_type_name',
                'product_categories.name as category_name',
                'product_sub_categories.name as sub_category_name',
                'engines.name as engine_name',
                'engines.part_number',
            )
            ->leftJoin('products', 'products.id', '=', 'orders.product_id')
            ->leftJoin('product_types', 'product_types.id', '=', 'products.product_type_id')
            ->leftJoin('product_categories', 'product_categories.id', '=', 'products.category_id')
            ->leftJoin('product_sub_categories', 'product_sub_categories.id', '=', 'products.sub_category_id')
            ->leftJoin('engines', 'engines.id', '=', 'products.engine_id')
            ;
            // 🔍 global search filter
            if ($request->name) {
                $query->where('products.name', 'like', "%{$request->name}%");
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
                'product_id.*' => 'required',
                'quantity.*'   => 'required|numeric',
                'price.*'      => 'required|numeric',
            ]);

            $order = [];
            foreach ($request->dataOrder as $item) {
                $order[] = [
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                    'sub_total'  => $item['sub_total'],
                    'order_date' => now(),
                    'status'     => 'requesting',
                    'created_by' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            Order::insert($order);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message'=> 'Order saved successfully'
            ]);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message'=> 'Something went wrong. Please try again.'
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
        $data = Order::findOrFail($id);
        $products = Product::all();
        return view('backend.orders.edit', compact('products', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'product_id.*' => 'required',
                'quantity.*'   => 'required|numeric',
                'price.*'      => 'required|numeric',
            ]);

            Order::where('id', $request->order_id)->update([
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
                'price'      => $request->price,
                'sub_total'  => $request->sub_total,
                'updated_by' => Auth::id(),
                'updated_at' => now(),
            ]);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message'=> 'Order updated successfully'
            ]);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message'=> 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Order::where('id', $id)->delete();
            return response()->json([
                'status' => 'success',
                'message'=> 'Order deleted successfully'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message'=> 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:orders,id',
            'status'   => 'required',
        ]);
        try {
            $order = Order::find($request->id);
            $order->status = $request->status;
            $order->save();
            Product::where('id', $order->product_id)->update([
                'low_stock_qty_warning' => $order->quantity
            ]);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message'=> 'Order status updated successfully'
            ]);
        } catch (\Throwable $exp) {
            DB::rollBack(); // ✅ Roll back only if transaction started
            return response()->json([
                'error'     => 'Order not found.',
                'exception' => $exp->getMessage()
            ], 500);
        }
    }
}
