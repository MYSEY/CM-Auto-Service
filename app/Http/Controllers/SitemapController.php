<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 1)->get();
        $categories = ProductCategory::all();

        return Response::view('sitemap', [
            'products' => $products,
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml');
    }
}
