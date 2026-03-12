<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sell;
use App\Models\SellDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    if ($request->ajax()) {

        $query = SellDetail::select(
            'sell_details.*',
            'sells.invoice_no',
            'sells.sell_date',
            'sells.status',
            'sells.customer_name',
            'sells.total_amount',
            'sells.grand_total',
            'sells.paid_amount',
            'sells.due_amount',
            'products.name as product_name',
            'product_types.name as product_type_name',
            'product_categories.name as category_name',
            'product_sub_categories.name as sub_category_name',
            'engines.name as engine_name',
            'engines.part_number'
        )
        ->leftJoin('sells', 'sells.id', '=', 'sell_details.sell_id')
        ->leftJoin('products', 'products.id', '=', 'sell_details.product_id')
        ->leftJoin('product_types', 'product_types.id', '=', 'products.product_type_id')
        ->leftJoin('product_categories', 'product_categories.id', '=', 'products.category_id')
        ->leftJoin('product_sub_categories', 'product_sub_categories.id', '=', 'products.sub_category_id')
        ->leftJoin('engines', 'engines.id', '=', 'products.engine_id');

        if ($request->name) {
            $query->where('products.name', 'like', "%{$request->name}%");
        }

        if ($request->sell_date) {
            $query->where('sells.sell_date', 'like', "%{$request->sell_date}%");
        }

        $recordsTotal = SellDetail::count();
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

    return view('backend.sell.index');
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('backend.sell.create', compact('products'));
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
                'quantity.*' => 'required|numeric',
                'price.*' => 'required|numeric'
            ]);

            $total = 0;

            foreach ($request->dataSell as $item) {
                $total += $item['sub_total'];
            }

            $sell = Sell::create([
                'customer_id' => $request->customer_id,
                'customer_name' => $request->customer_name, // ✅
                'invoice_no' => 'INV'.time(),
                'sell_date' => now(),
                'total_amount' => $total,
                'grand_total' => $total,
                'paid_amount' => $request->paid_amount ?? 0,
                'due_amount' => $total - ($request->paid_amount ?? 0),
                'status' => 'unpaid',
                'remark' => $request->remark,
                'created_by' => Auth::id(),
            ]);

            $details = [];

            foreach ($request->dataSell as $item) {

                $details[] = [
                    'sell_id' => $sell->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'sub_total' => $item['sub_total'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];

            }

            SellDetail::insert($details);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message'=> 'Sell saved successfully'
            ]);

        } catch (\Throwable $e) {

            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message'=> 'Something went wrong'
            ],500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $sell = Sell::findOrFail($id);

        $details = SellDetail::where('sell_id',$id)->get();

        $products = Product::all();

        return view('backend.sells.edit', compact(
            'sell',
            'details',
            'products'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        DB::beginTransaction();

        try {

            $sell = Sell::findOrFail($id);

            $total = 0;

            foreach ($request->dataSell as $item) {
                $total += $item['sub_total'];
            }

            $sell->update([
                'total_amount' => $total,
                'grand_total' => $total,
                'paid_amount' => $request->paid_amount,
                'due_amount' => $total - $request->paid_amount,
                'updated_by' => Auth::id()
            ]);

            SellDetail::where('sell_id',$id)->delete();

            $details = [];

            foreach ($request->dataSell as $item) {

                $details[] = [
                    'sell_id' => $sell->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'sub_total' => $item['sub_total'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];

            }

            SellDetail::insert($details);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message'=> 'Sell updated successfully'
            ]);

        } catch (\Throwable $e) {

            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message'=> 'Something went wrong'
            ],500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $sell = Sell::find($id); // Use find instead of findOrFail

            if (!$sell) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sell record not found.'
                ], 404);
            }

            // Delete related SellDetail records first
            SellDetail::where('sell_id', $sell->id)->delete();

            // Delete the sell
            $sell->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Sell deleted successfully.'
            ]);

        } catch (\Throwable $e) {
            \Log::error('Sell delete error: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong while deleting the record.'
            ], 500);
        }
    }

    public function changeStatus(Request $request)
    {

        DB::beginTransaction();

        $request->validate([
            'id' => 'required',
            'status' => 'required'
        ]);

        try {

            $sell = Sell::findOrFail($request->id);

            $sell->update([
                'status' => $request->status
            ]);

            DB::commit();

            return response()->json([
                'success'=>true,
                'message'=>'Sell status updated successfully'
            ]);

        } catch (\Throwable $e) {

            DB::rollback();

            return response()->json([
                'error'=>'Sell not found'
            ],500);
        }

    }

}
