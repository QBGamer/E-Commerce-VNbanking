<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $latestProducts = Product::where('status', 'active')->orderBy('created_at', 'desc')->take(4)->get();
        $randomProducts = Product::where('status', 'active')->inRandomOrder()->take(10)->get();
        $trendingProducts = Product::where('status', 'active')->whereIn('badge', ['Trending','Low Stock','Sale'])->orderBy('created_at', 'desc')->take(5)->get();
        $categories = Category::orderBy('name', 'asc')->take(10)->get();
        return view('home', compact('latestProducts', 'randomProducts', 'trendingProducts','categories'));
    }
}
