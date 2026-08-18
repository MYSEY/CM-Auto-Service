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

        // 3. Monthly Sales & Signups Analytics (Last 12 Months)
        $months = [];
        $salesData = [];
        $ordersData = [];
        $signupsData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $year = $date->year;
            $month = $date->month;
            $months[] = $date->format('M Y');

            // Sales revenue in month
            $sellSum = Sell::whereYear('sell_date', $year)
                ->whereMonth('sell_date', $month)
                ->sum('grand_total');

            $orderSum = Order::whereYear('order_date', $year)
                ->whereMonth('order_date', $month)
                ->sum('sub_total');

            $salesData[] = round($sellSum + $orderSum, 2);

            // Orders count in month
            $orderCount = Order::whereYear('order_date', $year)
                ->whereMonth('order_date', $month)
                ->count();
            $ordersData[] = $orderCount;

            // Customer signups in month
            $userCount = User::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();
            $signupsData[] = $userCount;
        }

        // 4. Product Type Distribution for Donut Chart
        $typeDistribution = ProductType::withCount('products')->get();
        $typeNames = $typeDistribution->pluck('name')->toArray();
        $typeCounts = $typeDistribution->pluck('products_count')->toArray();

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

