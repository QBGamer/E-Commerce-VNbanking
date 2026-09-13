@extends('layouts.app', ['title' => 'Checkout'])

@section('content')
@php
    $subtotal = array_reduce($cartItems, fn($carry, $item) => $carry + $item['product']['price'] * $item['qty'], 0);
    $shipping = $subtotal >= 50 ? 0 : 9.99;
    $total = $subtotal + $shipping - 10;
@endphp

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-1 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
            <x-icons name="chevron-right" class="w-4 h-4" />
            <a href="{{ route('cart.index') }}" class="hover:text-indigo-600">Cart</a>
            <x-icons name="chevron-right" class="w-4 h-4" />
            <span class="font-medium text-gray-900">Checkout</span>
        </nav>
        <h1 class="mt-2 text-2xl font-bold text-gray-900">Checkout</h1>

        <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3" x-data="{ payment: 'cod' }">
            {{-- Form --}}
            <div class="space-y-6 lg:col-span-2">
                {{-- Contact & shipping --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-6">
                    <h2 class="flex items-center gap-2 text-lg font-bold text-gray-900">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-indigo-600 text-xs font-bold text-white">1</span>
                        Shipping Information
                    </h2>
                    <form class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <x-form-input name="full_name" label="Full name" icon="user" placeholder="Jane Doe" required />
                        <x-form-input name="email" label="Email address" type="email" icon="mail" placeholder="you@example.com" required />
                        <div class="sm:col-span-2">
                            <x-form-input name="address" label="Street address" icon="map-pin" placeholder="123 Market Street" required />
                        </div>
                        <x-form-input name="city" label="City" placeholder="Ho Chi Minh City" required />
                        <div class="grid grid-cols-2 gap-4">
                            <x-form-input name="zip" label="ZIP / Postal code" placeholder="700000" inputmode="numeric" />
                            <x-form-input name="country" label="Country" value="Vietnam" required />
                        </div>
                        <x-form-input name="phone" label="Phone" type="tel" icon="phone" placeholder="+84 912 345 678" required />
                        <label class="flex cursor-pointer items-center gap-2 self-end pb-3 text-sm text-gray-600">
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                            Save this address for next time
                        </label>
                    </form>
                </div>

                {{-- Payment --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-6">
                    <h2 class="flex items-center gap-2 text-lg font-bold text-gray-900">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-indigo-600 text-xs font-bold text-white">2</span>
                        Payment Method
                    </h2>
                    <div class="mt-5 space-y-3">
                        @php
                            $methods = [
                                ['key' => 'cod', 'label' => 'Cash on Delivery', 'desc' => 'Pay in cash when your order arrives', 'icon' => 'dollar-sign'],
                                ['key' => 'card', 'label' => 'Credit / Debit Card', 'desc' => 'Visa, Mastercard, JCB', 'icon' => 'credit-card'],
                                ['key' => 'vnpay', 'label' => 'VNPay', 'desc' => 'Pay instantly via local bank transfer', 'icon' => 'shield-check'],
                                ['key' => 'paypal', 'label' => 'PayPal', 'desc' => 'Pay with your PayPal balance', 'icon' => 'check-circle'],
                            ];
                        @endphp
                        @foreach ($methods as $method)
                            <label
                                class="flex cursor-pointer items-start gap-4 rounded-xl border p-4 transition-all {{ $method['key'] === 'cod' ? 'border-indigo-500 ring-2 ring-indigo-100' : 'border-gray-200 hover:border-indigo-300' }}"
                                :class="payment === '{{ $method['key'] }}' ? 'border-indigo-500 ring-2 ring-indigo-100' : 'border-gray-200'"
                            >
                                <input type="radio" name="payment_method" value="{{ $method['key'] }}" x-model="payment" class="mt-1 h-4 w-4 text-indigo-600 focus:ring-indigo-500" />
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-500">
                                    <x-icons :name="$method['icon']" class="w-5 h-5" />
                                </span>
                                <span>
                                    <span class="block text-sm font-semibold text-gray-900">{{ $method['label'] }}</span>
                                    <span class="block text-xs text-gray-500">{{ $method['desc'] }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Order summary --}}
            <aside>
                <div class="rounded-2xl border border-gray-200 bg-white p-6">
                    <h2 class="text-lg font-bold text-gray-900">Your Order</h2>
                    <ul class="mt-4 space-y-3">
                        @foreach ($cartItems as $item)
                            <li class="flex items-center gap-3">
                                <div class="relative shrink-0">
                                    <img src="{{ $item['product']['image'] }}" alt="{{ $item['product']['name'] }}" class="h-12 w-12 rounded-lg border border-gray-100 object-cover" />
                                    <span class="absolute -right-1.5 -top-1.5 flex h-5 w-5 items-center justify-center rounded-full bg-gray-900 text-[10px] font-bold text-white">{{ $item['qty'] }}</span>
                                </div>
                                <p class="flex-1 truncate text-sm font-medium text-gray-800">{{ $item['product']['name'] }}</p>
                                <p class="text-sm font-semibold text-gray-900">${{ number_format($item['product']['price'] * $item['qty'], 2) }}</p>
                            </li>
                        @endforeach
                    </ul>

                    <dl class="mt-5 space-y-3 border-t border-gray-100 pt-4 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Subtotal</dt>
                            <dd class="font-semibold">${{ number_format($subtotal, 2) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Shipping</dt>
                            <dd class="font-semibold">{{ $shipping == 0 ? 'Free' : '$' . number_format($shipping, 2) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Coupon (WELCOME10)</dt>
                            <dd class="font-semibold text-amber-600">-$10.00</dd>
                        </div>
                        <div class="flex justify-between border-t border-gray-100 pt-3 text-base">
                            <dt class="font-bold text-gray-900">Total</dt>
                            <dd class="font-bold text-indigo-600">${{ number_format($total, 2) }}</dd>
                        </div>
                    </dl>

                    <x-button type="submit" icon="shield-check" class="mt-5 w-full">
                        Place Order
                    </x-button>
                    <p class="mt-3 flex items-center justify-center gap-1.5 text-xs text-gray-400">
                        <x-icons name="lock" class="w-3.5 h-3.5" /> Secure encrypted checkout
                    </p>
                </div>
            </aside>
        </div>
    </div>
@endsection