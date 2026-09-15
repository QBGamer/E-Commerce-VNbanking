@extends('layouts.app', ['title' => 'Shop'])

@section('content')
@php
    $activeCategory = request('category');
    $query = trim(request('q') ?? '');
    $sort = request('sort', 'featured');

    $filtered = $products;
    if ($activeCategory && isset($categories[$activeCategory])) {
        $filtered = array_values(array_filter($filtered, fn($p) => $p['category'] === $activeCategory));
    }
    if ($query !== '') {
        $filtered = array_values(array_filter($filtered, fn($p) =>
            str_contains(strtolower($p['name']), strtolower($query)) ||
            str_contains(strtolower($p['category_name']), strtolower($query)) ||
            str_contains(strtolower($p['description']), strtolower($query))
        ));
    }

    usort($filtered, function ($a, $b) use ($sort) {
        if ($sort === 'price-low') return $a['price'] <=> $b['price'];
        if ($sort === 'price-high') return $b['price'] <=> $a['price'];
        if ($sort === 'rating') return $b['rating'] <=> $a['rating'];
    });

    $sortBase = route('products.index', ['category' => $activeCategory, 'q' => $query]) . (($activeCategory !== null || $query !== '') ? '&' : '?') . 'sort=';
@endphp

    <div class="border-b border-gray-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-1 text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
                <x-icons name="chevron-right" class="w-4 h-4" />
                <span class="font-medium text-gray-900">Shop</span>
            </nav>
            <h1 class="mt-2 text-2xl font-bold text-gray-900">
                @if ($query !== '')
                    Results for "{{ $query }}"
                @elseif ($activeCategory)
                    {{ $categories[$activeCategory] }}
                @else
                    All Products
                @endif
            </h1>
            <p class="mt-1 text-sm text-gray-500">{{ count($filtered) }} product{{ count($filtered) !== 1 ? 's' : '' }} found</p>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Category filter --}}
        <div class="flex gap-2 overflow-x-auto pb-1" x-data>
            <a href="{{ route('products.index', ['q' => $query]) }}"
                class="shrink-0 rounded-full px-4 py-2 text-sm font-medium transition-colors {{ !$activeCategory ? 'bg-indigo-600 text-white' : 'border border-gray-300 bg-white text-gray-700 hover:border-indigo-300' }}">
                All
            </a>
            @foreach ($categories as $key => $label)
                <a href="{{ route('products.index', ['category' => $key, 'q' => $query]) }}"
                    class="shrink-0 rounded-full px-4 py-2 text-sm font-medium transition-colors {{ $activeCategory === $key ? 'bg-indigo-600 text-white' : 'border border-gray-300 bg-white text-gray-700 hover:border-indigo-300' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Toolbar --}}
        <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <x-icons name="filter" class="w-4 h-4" />
                @if ($activeCategory)
                    <span>Category: <strong class="text-gray-800">{{ $categories[$activeCategory] }}</strong></span>
                    <a href="{{ route('products.index', ['q' => $query]) }}" class="text-indigo-600 hover:underline">Clear</a>
                @endif
            </div>

            <div class="flex items-center gap-2" x-data="{ sort: '{{ $sort }}' }">
                <label for="sort" class="text-sm text-gray-500">Sort by</label>
                <select
                    id="sort"
                    x-model="sort"
                    @change="window.location = '{{ $sortBase }}' + sort"
                    class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                >
                    <option value="featured">Featured</option>
                    <option value="popular">Most Popular</option>
                    <option value="rating">Highest Rated</option>
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                </select>
            </div>
        </div>

        {{-- Grid --}}
        @if (count($filtered) > 0)
            <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($filtered as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @else
            <div class="mt-16 flex flex-col items-center justify-center rounded-2xl border border-dashed border-gray-300 bg-white px-4 py-16 text-center">
                <span class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                    <x-icons name="search" class="w-8 h-8" />
                </span>
                <h2 class="mt-4 text-lg font-semibold text-gray-900">No products found</h2>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter.</p>
                <x-button href="{{ route('products.index') }}" variant="outline" class="mt-6">
                    Reset Filters
                </x-button>
            </div>
        @endif
    </div>
@endsection
