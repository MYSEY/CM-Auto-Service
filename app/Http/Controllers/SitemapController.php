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
        $products = Product::select('id', 'name', 'slug', 'updated_at')->get();

        return Response::view('sitemap', [
            'products' => $products,
        ])->header('Content-Type', 'text/xml');
    }
}
