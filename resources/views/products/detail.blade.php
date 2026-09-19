@extends('layouts.app', ['title' => 'Product'])

@php
    $isSoldOut = ($product['stock'] ?? 1) <= 0;
@endphp
@section('content')
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-1 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
            <x-icons name="chevron-right" class="w-4 h-4" />
            <a href="{{ route('products.index') }}" class="hover:text-indigo-600">Shop</a>
            <x-icons name="chevron-right" class="w-4 h-4" />
            <a href="{{ route('products.index', ['category' => $product['category']['slug']]) }}" class="hover:text-indigo-600">{{ $product['category']['name'] }}</a>
            <x-icons name="chevron-right" class="w-4 h-4" />
            <span class="truncate font-medium text-gray-900">{{ $product['name'] }}</span>
        </nav>

        <div class="mt-6 grid grid-cols-1 gap-10 lg:grid-cols-2" x-data="{ qty: 1 }">
            {{-- Image --}}
            <div class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white">
                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="aspect-square w-full object-cover" />
                @if (!empty($product['badge']))
                    <span class="absolute left-4 top-4 rounded-full bg-red-600 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-white">
                        {{ $product['badge'] }}
                    </span>
                @endif
            </div>

            {{-- Info --}}
            <div class="flex flex-col">
                <p class="text-sm font-medium uppercase tracking-wide text-gray-400">{{ $product['category_name'] }}</p>
                <h1 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">{{ $product['name'] }}</h1>

                <div class="mt-5 flex items-end gap-3">
                    <p class="text-4xl font-extrabold text-gray-900">${{ number_format($product['price'], 2) }}</p>
                    @if (!empty($product['old_price']))
                        <p class="pb-1 text-lg text-gray-400 line-through">${{ number_format($product['old_price'], 2) }}</p>
                        <span class="mb-1.5 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-600">
                            Save {{ round((1 - $product['price'] / $product['old_price']) * 100) }}%
                        </span>
                    @endif
                </div>

                <p class="mt-5 leading-relaxed text-gray-600">{{ $product['description'] }}</p>

                <div class="mt-5 flex items-center gap-2 text-sm">
                    @if ($isSoldOut)
                        <span class="flex items-center gap-1.5 text-red-600">
                            <x-icons name="x-circle" class="w-4 h-4" /> Out of stock
                        </span>
                    @elseif ($product['stock'] <= 10)
                        <span class="flex items-center gap-1.5 text-amber-600">
                            <x-icons name="alert-triangle" class="w-4 h-4" /> Only {{ $product['stock'] }} left in stock
                        </span>
                    @else
                        <span class="flex items-center gap-1.5 text-emerald-600">
                            <x-icons name="check-circle" class="w-4 h-4" /> In stock
                        </span>
                    @endif
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <div class="flex items-center rounded-lg border border-gray-300 bg-white">
                        <button type="button" class="flex h-12 w-12 items-center justify-center text-gray-500 hover:text-gray-900" @click="qty = Math.max(1, qty - 1)" aria-label="Decrease quantity">
                            <x-icons name="minus" class="w-4 h-4" />
                        </button>
                        <span class="w-10 text-center text-sm font-bold text-gray-900" x-text="qty">1</span>
                        <button type="button" class="flex h-12 w-12 items-center justify-center text-gray-500 hover:text-gray-900" @click="qty = qty + 1" aria-label="Increase quantity">
                            <x-icons name="plus" class="w-4 h-4" />
                        </button>
                    </div>
                    <x-button :disabled="$isSoldOut" href="{{ route('cart.index') }}" icon="cart" class="flex-1 !py-3">
                        Add to Cart
                    </x-button>
                    <button type="button" class="inline-flex h-12 w-12 items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-500 transition-colors hover:border-red-200 hover:bg-red-50 hover:text-red-600" aria-label="Add to wishlist">
                        <x-icons name="heart" class="w-5 h-5" />
                    </button>
                </div>

                {{-- <div class="mt-8 space-y-3 rounded-2xl border border-gray-200 bg-white p-5 text-sm">
                    <div class="flex items-center gap-3 text-gray-600">
                        <x-icons name="truck" class="w-5 h-5 text-indigo-600" />
                        <span><strong class="text-gray-800">Free shipping</strong> on orders over $50</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-600">
                        <x-icons name="refresh" class="w-5 h-5 text-indigo-600" />
                        <span><strong class="text-gray-800">30-day returns</strong> if you change your mind</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-600">
                        <x-icons name="shield-check" class="w-5 h-5 text-indigo-600" />
                        <span><strong class="text-gray-800">Secure checkout</strong> with encrypted payment</span>
                    </div>
                </div> --}}
            </div>
        </div>

        {{-- relatedProducts --}}
        @if (count($relatedProducts) > 0)
            <div class="mt-16">
                <div class="flex items-center justify-between gap-4">
                    <h2 class="text-xl font-bold text-gray-900">You may also like</h2>
                    <a href="{{ route('products.index', ['category' => $product['category']['slug']]) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                        View all <x-icons name="arrow-right" class="w-4 h-4" />
                    </a>
                </div>
                <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                    @foreach ($relatedProducts as $item)
                        <x-product-card :product="$item" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
