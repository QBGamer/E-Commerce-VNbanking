<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('status', 'active')->get();
        $products = $products->filter(function ($p) use ($request){
            if($request->filled('category') && $p->category->slug != $request->category) return false;
            if($request->filled('name') &&!str_contains(strtolower($p->name), strtolower($request->name))) return false;
            if($request->filled('price_min') && $p->price < $request->price_min) return false;
            if($request->filled('price_max') && $p->price > $request->price_max) return false;
            return true;
        });
        // return view('products.index', compact('products', 'request'));
        return view('products.index', [
            'products' => $products,
            'category' => $request->query('category'),
            'name' => $request->trim($request->query('name'), ''),
            'sort' => $request->query('sort_by', 'featured')
        ]);
    }
}
