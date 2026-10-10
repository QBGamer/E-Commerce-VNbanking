<?php

namespace App\Http\Controllers\ControlPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;

class CPProductController extends Controller
{
    public static function presentProduct(Product $product)
    {
        $product->loadMissing('category');

        return [
            'id'          => $product->id,
            'name'        => $product->name,
            'slug'        => $product->slug,
            'sku'         => $product->sku,
            'description' => $product->description,
            'price'       => (float) $product->price,
            'stock'       => (int) $product->stock,
            'status'      => $product->status,
            'images' => $product->images->map(fn($img) => [
                'id' => $img->id,
                'image' => $img->image,
                'position' => $img->position,
            ])->values()->toArray(),
            'badge'       => $product->badge,
            'category'    => [
                'id'   => $product->category?->id,
                'name' => $product->category?->name,
                'slug' => $product->category?->slug,
            ],
        ];
    }

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
        $query = Product::with(['category', 'images']);

        if ($validCategory) $query->whereHas('category', fn ($c) => $c->where('slug', $validCategory));
        elseif ($category) $query->whereRaw('1 = 0');

        if ($q !== '') $query->where('name', 'like', '%' . $q . '%')->orWhere('sku', 'like', '%' . $q . '%');;

        if ($stock === 'low') $query->where('stock', '<=', 10);
        elseif ($stock === 'out') $query->where('stock', '=', 0);

        if ($request->filled('status'))  $query->where('status', $request->query('status'));
        if ($request->filled('price_min'))  $query->where('price', '>=', (float) $request->query('price_min'));
        if ($request->filled('price_max'))  $query->where('price', '<=', (float) $request->query('price_max'));

        $products = $query->paginate(20);
        $rows = $products->getCollection()
            ->map(fn (Product $product) => static::presentProduct($product))
            ->values();

        $filters = $request->only(['q', 'category', 'price_min', 'price_max', 'stock', 'status']);
        $queryUrl = function (array $overrides = []) use ($filters) {
            $params = array_filter(array_merge($filters, $overrides), fn ($v) => $v !== null && $v !== '');
            return count($params) ? '?' . http_build_query($params) : '';
        };
        return view('controlpanel.products', [
            'products'   => $products,
            'rows'       => $rows,
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

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'status' => 'nullable|in:active,inactive',
            'slug' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:255',
            'badge' => 'nullable|string|max:50',
            'category' => 'required|exists:categories,slug',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category = Category::where('slug', $data['category'])->first();

        $product = new Product();
        $product->fill(Arr::except($data, ['category']));
        $product->category_id = $category->id;
        $product->description = $data['description'] ?? '';
        $product->save();

        return response()->json([
            'message' => 'Product created successfully.',
            'product' => $this->presentProduct($product),
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'status' => 'nullable|in:active,inactive',
            'slug' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:255',
            'badge' => 'nullable|string|max:50',
            'category' => 'required|exists:categories,slug',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category = Category::where('slug', $data['category'])->first();

        $product->fill(Arr::except($data, ['category']));
        $product->category_id = $category->id;
        $product->description = $data['description'] ?? '';
        $product->save();

        return response()->json([
            'message' => 'Product updated successfully.',
            'product' => $this->presentProduct($product),
        ]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
            unlink(public_path('images/products/' . $product->image));
        }
        $product->delete();
        return response()->json([
            'message' => $id . ': Product removed successfully.',
        ]);
    }
}
