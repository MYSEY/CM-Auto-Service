<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductCategory;
use App\Models\Order;
use App\Models\Sell;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Product type with product count for top stat cards
        $productType = ProductType::withCount('products')->get();

        // 2. Summary KPI Metrics
        $totalSellRevenue = Sell::sum('grand_total');
        $totalOrderRevenue = Order::sum('sub_total');
        $totalRevenue = $totalSellRevenue + $totalOrderRevenue;

        $totalSellsCount = Sell::count();
        $totalOrdersCount = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::count();

        // 3. Monthly Sales & Signups Analytics (Last 12 Months) - Optimized Group Queries
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();

        $monthlySells = Sell::where('sell_date', '>=', $startDate)
            ->selectRaw("DATE_FORMAT(sell_date, '%Y-%m') as ym, SUM(grand_total) as total")
            ->groupBy('ym')
            ->pluck('total', 'ym');

        $monthlyOrders = Order::where('order_date', '>=', $startDate)
            ->selectRaw("DATE_FORMAT(order_date, '%Y-%m') as ym, SUM(sub_total) as total, COUNT(id) as count")
            ->groupBy('ym')
            ->get()
            ->keyBy('ym');

        $monthlyUsers = User::where('created_at', '>=', $startDate)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(id) as count")
            ->groupBy('ym')
            ->pluck('count', 'ym');

        $months = [];
        $salesData = [];
        $ordersData = [];
        $signupsData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $ymKey = $date->format('Y-m');
            $months[] = $date->format('M Y');

            $sellSum = (float) ($monthlySells[$ymKey] ?? 0);
            $orderObj = $monthlyOrders->get($ymKey);
            $orderSum = (float) ($orderObj ? $orderObj->total : 0);
            $orderCount = (int) ($orderObj ? $orderObj->count : 0);
            $userCount = (int) ($monthlyUsers[$ymKey] ?? 0);

            $salesData[] = round($sellSum + $orderSum, 2);
            $ordersData[] = $orderCount;
            $signupsData[] = $userCount;
        }

        // 4. Product Type Distribution for Donut Chart (Reusing $productType query)
        $typeNames = $productType->pluck('name')->toArray();
        $typeCounts = $productType->pluck('products_count')->toArray();

        // 5. Category Distribution
        $categoryDistribution = ProductCategory::withCount('products')->get();
        $categoryNames = $categoryDistribution->pluck('name')->toArray();
        $categoryCounts = $categoryDistribution->pluck('products_count')->toArray();

        // 6. Recent Transactions
        $recentSells = Sell::orderBy('id', 'desc')->take(5)->get();
        $recentOrders = Order::orderBy('id', 'desc')->take(5)->get();

        return view('backend.dashboard.index', compact(
            'productType',
            'totalRevenue',
            'totalSellRevenue',
            'totalOrderRevenue',
            'totalSellsCount',
            'totalOrdersCount',
            'totalProducts',
            'totalUsers',
            'months',
            'salesData',
            'ordersData',
            'signupsData',
            'typeNames',
            'typeCounts',
            'categoryNames',
            'categoryCounts',
            'recentSells',
            'recentOrders'
        ));
    }
}

