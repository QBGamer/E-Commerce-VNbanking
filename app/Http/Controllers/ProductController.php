<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name', 'asc')->pluck('name', 'slug');

        $category = $request->query('category');
        $validCategory = is_string($category) && $categories->has($category) ? $category : null;
        $q    = trim((string) $request->query('query', ''));
        $sort = $request->query('sort_by', 'featured');

        $query = Product::with('category')->where('status', 'active');

        if ($validCategory) {
            $query->whereHas('category', fn ($c) => $c->where('slug', $validCategory));
        } elseif ($category) {
            $query->whereRaw('1 = 0');
        }

        if ($q !== '') {
            $query->where('name', 'like', '%' . $q . '%');
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->query('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->query('price_max'));
        }

        $query->when(true, fn ($q2) => match ($sort) {
            'price_asc'  => $q2->orderBy('price', 'asc'),
            'price_desc' => $q2->orderBy('price', 'desc'),
            'name_asc'   => $q2->orderBy('name', 'asc'),
            'name_desc'  => $q2->orderBy('name', 'desc'),
            default      => $q2->orderBy('created_at', 'desc'),   // featured or any other value
        });

        $products = $query->simplePaginate(8);   // ← N product,(SimplePaginator)
        // $products = $query->paginate(2);         // ← N product,(LengthAwarePaginator)

        return view('products.index', [
            'products'   => $products,
            'categories' => $categories,
            'category'   => $category,
            'query'      => $q,
            'sort'       => $sort,
        ]);
    }

    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();
        $categories = Category::orderBy('name', 'asc')->pluck('name', 'slug');
        $relatedProducts = Product::where('status', 'active')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();
        if (count($relatedProducts) < 4) {
            $additionalProducts = Product::where('status', 'active')
                ->where('id', '!=', $product->id)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->inRandomOrder()
                ->take(4 - count($relatedProducts))
                ->get();
            $relatedProducts = $relatedProducts->merge($additionalProducts);
        }

        return view('products.detail', [
            'product'    => $product,
            'categories' => $categories,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
