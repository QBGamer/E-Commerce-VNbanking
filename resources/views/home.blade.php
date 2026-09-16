@extends('layouts.app', ['title' => 'Home'])

@section('content')
    {{-- Hero --}}
    <section class="bg-indigo-600">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 sm:py-20 lg:px-8">
            <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2">
                <div class="text-white">
                    <p class="mb-3 inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider">
                        <x-icons name="zap" class="w-3.5 h-3.5" /> New Season, New Deals
                    </p>
                    <h1 class="text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">
                        Upgrade your everyday essentials
                    </h1>
                    <p class="mt-4 max-w-md text-base text-indigo-100">
                        Discover thousands of products with fast delivery, easy returns and secure payment — all in one place.
                    </p>
                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        {{-- <x-button href="{{ route('products.index') }}" variant="secondary" size="lg" icon="arrow-right" icon-position="right">
                            Shop Now
                        </x-button>
                        <x-button href="{{ route('products.index', ['category' => 'electronics']) }}" variant="outline" size="lg" class="!border-white/30 !bg-transparent !text-white hover:!bg-white/10">
                            Browse Electronics
                        </x-button> --}}
                    </div>
                </div>
                <div class="hidden justify-center lg:flex">
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($latestProducts as $product)
                            <div class="overflow-hidden rounded-2xl bg-white p-3 shadow-lg">
                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="aspect-square w-full rounded-xl object-cover" />
                                <p class="mt-2 text-sm font-semibold text-gray-900">{{ $product['name'] }}</p>
                                <p class="text-xs font-medium text-indigo-600">${{ number_format($product['price'], 2) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Category chips --}}
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-bold text-gray-900">Shop by Category</h2>
            {{-- <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                View all <x-icons name="arrow-right" class="w-4 h-4" />
            </a> --}}
        </div>
        <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
            {{-- @foreach ($categories as $key => $label)
                <a href="{{ route('products.index', ['category' => $key]) }}"
                    class="group flex flex-col items-center gap-3 rounded-2xl border border-gray-200 bg-white p-5 text-center transition-all hover:border-indigo-200 hover:shadow-md">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 transition-colors group-hover:bg-indigo-600 group-hover:text-white">
                        <x-icons name="box" class="w-6 h-6" />
                    </span>
                    <span class="text-sm font-semibold text-gray-800">{{ $label }}</span>
                </a>
            @endforeach --}}
        </div>
    </section>

    {{-- Featured products --}}
    <section class="mx-auto max-w-7xl px-4 pb-14 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-bold text-gray-900">Featured Products</h2>
            {{-- <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                View all <x-icons name="arrow-right" class="w-4 h-4" />
            </a> --}}
        </div>
        <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            {{-- @foreach (array_slice($products, 0, 10) as $product)
                <x-product-card :product="$product" />
            @endforeach --}}
            @foreach ($randomProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>

    {{-- Promo banner --}}
    {{-- <section class="mx-auto max-w-7xl px-4 pb-14 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="flex items-center gap-4 rounded-2xl bg-gray-900 p-6 text-white">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white/10">
                    <x-icons name="truck" class="w-6 h-6" />
                </span>
                <div>
                    <p class="font-semibold">Free Shipping</p>
                    <p class="text-sm text-gray-300">On all orders over $50</p>
                </div>
            </div>
            <div class="flex items-center gap-4 rounded-2xl bg-indigo-600 p-6 text-white">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white/10">
                    <x-icons name="refresh" class="w-6 h-6" />
                </span>
                <div>
                    <p class="font-semibold">Easy Returns</p>
                    <p class="text-sm text-indigo-100">30-day money-back guarantee</p>
                </div>
            </div>
            <div class="flex items-center gap-4 rounded-2xl bg-emerald-600 p-6 text-white">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white/10">
                    <x-icons name="shield-check" class="w-6 h-6" />
                </span>
                <div>
                    <p class="font-semibold">Secure Payment</p>
                    <p class="text-sm text-emerald-100">Credit cards, PayPal & VNPay</p>
                </div>
            </div>
        </div>
    </section> --}}

    {{-- Trending --}}
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-4">
                <h2 class="text-xl font-bold text-gray-900">Trending Right Now</h2>
                {{-- <a href="{{ route('products.index', ['sort' => 'popular']) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                    See more <x-icons name="arrow-right" class="w-4 h-4" />
                </a> --}}
            </div>
            <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
                {{-- @foreach ([$products[6], $products[8], $products[0], $products[4], $products[7]] as $product)
                    <x-product-card :product="$product" />
                @endforeach --}}
                @foreach ($trendingProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>
@endsection
