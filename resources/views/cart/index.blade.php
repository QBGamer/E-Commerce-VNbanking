@extends('layouts.app', ['title' => 'Shopping Cart'])

@section('content')
@php
    $subtotal = array_reduce($cartItems, fn($carry, $item) => $carry + $item['product']['price'] * $item['qty'], 0);
    $shipping = $subtotal >= 50 ? 0 : 9.99;
    $total = $subtotal + $shipping;
@endphp

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-1 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
            <x-icons name="chevron-right" class="w-4 h-4" />
            <span class="font-medium text-gray-900">Shopping Cart</span>
        </nav>
        <h1 class="mt-2 text-2xl font-bold text-gray-900">Shopping Cart</h1>

        @if (count($cartItems))
            <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
                {{-- Items --}}
                <div class="lg:col-span-2">
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
                        <ul class="divide-y divide-gray-100">
                            @foreach ($cartItems as $index => $item)
                                <li class="flex gap-4 p-4 sm:p-5" x-data="{ qty: {{ $item['qty'] }} }">
                                    <a href="{{ route('products.detail', $item['product']['slug']) }}" class="block h-20 w-20 shrink-0 overflow-hidden rounded-xl border border-gray-200 sm:h-24 sm:w-24">
                                        <img src="{{ $item['product']['image'] }}" alt="{{ $item['product']['name'] }}" class="h-full w-full object-cover" />
                                    </a>
                                    <div class="flex flex-1 flex-col">
                                        <div class="flex items-start justify-between gap-2">
                                            <div>
                                                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">{{ $item['product']['category_name'] }}</p>
                                                <a href="{{ route('products.detail', $item['product']['slug']) }}" class="mt-0.5 text-sm font-semibold text-gray-900 hover:text-indigo-600">
                                                    {{ $item['product']['name'] }}
                                                </a>
                                                <p class="mt-1 text-sm text-gray-500">Unit: <span class="font-semibold text-gray-800">${{ number_format($item['product']['price'], 2) }}</span></p>
                                            </div>
                                            <button type="button" class="rounded-lg p-1.5 text-gray-400 transition-colors hover:bg-red-50 hover:text-red-600" aria-label="Remove item">
                                                <x-icons name="trash" class="w-5 h-5" />
                                            </button>
                                        </div>
                                        <div class="mt-auto flex items-center justify-between pt-3">
                                            <div class="flex items-center rounded-lg border border-gray-300">
                                                <button type="button" class="flex h-9 w-9 items-center justify-center text-gray-500 hover:text-gray-900" @click="qty = Math.max(1, qty - 1)" aria-label="Decrease">
                                                    <x-icons name="minus" class="w-3.5 h-3.5" />
                                                </button>
                                                <span class="w-8 text-center text-sm font-bold" x-text="qty"></span>
                                                <button type="button" class="flex h-9 w-9 items-center justify-center text-gray-500 hover:text-gray-900" @click="qty = qty + 1" aria-label="Increase">
                                                    <x-icons name="plus" class="w-3.5 h-3.5" />
                                                </button>
                                            </div>
                                            <p class="text-base font-bold text-gray-900" x-text="'$' + ({{ $item['product']['price'] }} * qty).toFixed(2)">
                                                ${{ number_format($item['product']['price'] * $item['qty'], 2) }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <x-button href="{{ route('products.index') }}" variant="outline" icon="arrow-left">
                            Continue Shopping
                        </x-button>
                        <div class="flex items-center gap-2">
                            <div class="relative flex-1 sm:w-72 sm:flex-none">
                                <input type="text" placeholder="Enter coupon code" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 pr-20 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" />
                                <button type="button" class="absolute inset-y-0 right-0 px-4 text-sm font-semibold text-indigo-600 hover:text-indigo-700">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Summary --}}
                <aside>
                    <div class="rounded-2xl border border-gray-200 bg-white p-6">
                        <h2 class="text-lg font-bold text-gray-900">Order Summary</h2>
                        <dl class="mt-5 space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Subtotal ({{ count($cartItems) }} items)</dt>
                                <dd class="font-semibold text-gray-900">${{ number_format($subtotal, 2) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Shipping</dt>
                                <dd class="font-semibold {{ $shipping == 0 ? 'text-emerald-600' : 'text-gray-900' }}">
                                    {{ $shipping == 0 ? 'Free' : '$' . number_format($shipping, 2) }}
                                </dd>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <dt class="text-gray-500">Discount</dt>
                                <dd class="font-semibold text-amber-600">-$10.00</dd>
                            </div>
                            <div class="flex justify-between border-t border-gray-100 pt-3 text-base">
                                <dt class="font-bold text-gray-900">Total</dt>
                                <dd class="font-bold text-indigo-600">${{ number_format($total - 10, 2) }}</dd>
                            </div>
                        </dl>
                        @if ($shipping == 0)
                            <p class="mt-4 flex items-center gap-1.5 rounded-lg bg-emerald-50 px-3 py-2 text-xs font-medium text-emerald-700">
                                <x-icons name="truck" class="w-4 h-4" /> Your order qualifies for free shipping!
                            </p>
                        @else
                            <p class="mt-4 flex items-center gap-1.5 rounded-lg bg-gray-50 px-3 py-2 text-xs text-gray-500">
                                <x-icons name="truck" class="w-4 h-4" /> Add ${{ number_format(50 - $subtotal, 2) }} more for free shipping
                            </p>
                        @endif
                        <x-button href="{{ route('checkout') }}" icon="arrow-right" icon-position="right" class="mt-5 w-full">
                            Proceed to Checkout
                        </x-button>
                        <a href="{{ route('products.index') }}" class="mt-3 text-center text-sm font-medium text-gray-500 hover:text-indigo-600 block">Or continue shopping</a>
                    </div>
                </aside>
            </div>
        @else
            <div class="mt-16 flex flex-col items-center justify-center rounded-2xl border border-dashed border-gray-300 bg-white px-4 py-20 text-center">
                <span class="flex h-20 w-20 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                    <x-icons name="cart" class="w-10 h-10" />
                </span>
                <h2 class="mt-5 text-xl font-semibold text-gray-900">Your cart is empty</h2>
                <p class="mt-1 text-sm text-gray-500">Browse our latest products and add something you love.</p>
                <x-button href="{{ route('products.index') }}" icon="arrow-right" icon-position="right" class="mt-6">
                    Start Shopping
                </x-button>
            </div>
        @endif
    </div>
@endsection