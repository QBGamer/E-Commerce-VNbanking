<?php

namespace App\Http\Controllers\ControlPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CPProductController extends Controller
{
    //CURD
    public function index(Request $request)
    {
        // ?q= &category= &price_min= &price_max= &stock= &status=
        $categories = Category::orderBy('name', 'asc')->pluck('name', 'slug');

        $category = $request->query('category');
        $validCategory = is_string($category) && $categories->has($category) ? $category : null;
        $q    = trim((string) $request->query('q', ''));
        $stock = $request->query('stock');
        $status = $request->query('status');
        $p_min = $request->query('price_min');
        $p_max = $request->query('price_max');
        $query = Product::with('category');

        if ($validCategory) $query->whereHas('category', fn ($c) => $c->where('slug', $validCategory));
        elseif ($category) $query->whereRaw('1 = 0');

        if ($q !== '') $query->where('name', 'like', '%' . $q . '%');

        if ($stock === 'low') $query->where('stock', '<=', 10);
        elseif ($stock === 'out') $query->where('stock', '=', 0);

        if ($request->filled('status'))  $query->where('status', $request->query('status'));
        if ($request->filled('price_min'))  $query->where('price', '>=', (float) $request->query('price_min'));
        if ($request->filled('price_max'))  $query->where('price', '<=', (float) $request->query('price_max'));

        $products = $query->paginate(20);

        $filters = $request->only(['q', 'category', 'price_min', 'price_max', 'stock', 'status']);
        $queryUrl = function (array $overrides = []) use ($filters) {
            $params = array_filter(array_merge($filters, $overrides), fn ($v) => $v !== null && $v !== '');
            return count($params) ? '?' . http_build_query($params) : '';
        };
        return view('controlpanel.products', [
            'products'   => $products,
            'categories' => $categories,
            'category'   => $category,
            'query'      => $q,
            'stock'      => $stock,
            'status'     => $status,
            'price_min'  => $p_min,
            'price_max'  => $p_max,
            'queryUrl' => $queryUrl,
            'total' => count(Product::all()),
        ]);
    }
}
