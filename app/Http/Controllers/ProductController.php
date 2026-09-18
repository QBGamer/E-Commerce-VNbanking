<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products  = Product::with('category')->where('status', 'active')->get();
        $categories = Category::orderBy('name', 'asc')->pluck('name', 'slug');

        //search logic
        $category = $request->query('category');
        $validCategory = is_string($category) && $categories->has($category) ? $category : null;
        $q    = trim((string) $request->query('query', ''));
        $sort = $request->query('sort_by', 'featured');

        $products = $products->filter(function ($p) use ($validCategory, $q, $request) {
            if ($validCategory && $p->category->slug != $validCategory) return false;
            if ($q !== '' && !str_contains(strtolower($p->name), strtolower($q))) return false;
            if ($request->filled('price_min') && $p->price < (float) $request->query('price_min')) return false;
            if ($request->filled('price_max') && $p->price > (float) $request->query('price_max')) return false;
            return true;
        });

        if ($category && !$validCategory) {
            $products = collect();
        }

        $products = match ($sort) {
            'price_asc'  => $products->sortBy('price'),
            'price_desc' => $products->sortByDesc('price'),
            'name_asc'   => $products->sortBy('name'),
            'name_desc'  => $products->sortByDesc('name'),
            default      => $products,
        };

        return view('products.index', [
            'products'   => $products,
            'categories' => $categories,
            'category'   => $category,
            'query'      => $q,
            'sort'       => $sort,
        ]);
    }
}
