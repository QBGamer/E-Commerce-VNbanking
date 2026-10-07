<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\DemoData;

class ControlPanelController extends Controller
{
    public function products(Request $request)
    {
        $categories = DemoData::categories();
        $products = collect(DemoData::products());

        $q = trim((string) $request->query('q', ''));
        if ($q !== '') {
            $products = $products->filter(fn ($p) =>
                mb_stripos($p['name'], $q) !== false || mb_stripos($p['slug'], $q) !== false
            );
        }

        $category = $request->query('category');
        if (is_string($category) && $category !== '') {
            $products = array_key_exists($category, $categories)
                ? $products->where('category', $category)
                : collect();
        }

        if (is_numeric($request->query('price_min')) && $request->query('price_min') !== '') {
            $products = $products->where('price', '>=', (float) $request->query('price_min'));
        }
        if (is_numeric($request->query('price_max')) && $request->query('price_max') !== '') {
            $products = $products->where('price', '<=', (float) $request->query('price_max'));
        }

        switch ($request->query('stock')) {
            case 'out':
                $products = $products->filter(fn ($p) => $p['stock'] === 0);
                break;
            case 'low':
                $products = $products->filter(fn ($p) => $p['stock'] > 0 && $p['stock'] <= 10);
                break;
            case 'in':
                $products = $products->filter(fn ($p) => $p['stock'] > 0);
                break;
        }

        switch ($request->query('status')) {
            case 'active':
                $products = $products->filter(fn ($p) => $p['stock'] > 0);
                break;
            case 'inactive':
                $products = $products->filter(fn ($p) => $p['stock'] === 0);
                break;
        }

        $products = $products->values()->all();

        $filters = $request->only(['q', 'category', 'price_min', 'price_max', 'stock', 'status']);
        $queryUrl = function (array $overrides = []) use ($filters) {
            $params = array_filter(array_merge($filters, $overrides), fn ($v) => $v !== null && $v !== '');
            return count($params) ? '?' . http_build_query($params) : '';
        };

        return view('controlpanel.products', [
            'products' => $products,
            'categories' => $categories,
            'total' => count(DemoData::products()),
            'queryUrl' => $queryUrl,
        ]);
    }
}