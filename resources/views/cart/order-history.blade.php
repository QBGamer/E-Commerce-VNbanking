@extends('layouts.app', ['title' => 'Order History'])

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-1 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
            <x-icons name="chevron-right" class="w-4 h-4" />
            <a href="{{ route('account') }}" class="hover:text-indigo-600">My Account</a>
            <x-icons name="chevron-right" class="w-4 h-4" />
            <span class="font-medium text-gray-900">Order History</span>
        </nav>
        <h1 class="mt-2 text-2xl font-bold text-gray-900">Order History</h1>
        <p class="mt-1 text-sm text-gray-500">Track, review and reorder your past purchases.</p>

        <div class="mt-6 space-y-4">
            @foreach ($orders as $order)
                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white" x-data="{ open: false }">
                    <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-bold text-indigo-600">{{ $order['id'] }}</span>
                                @php
                                    $statusColor = match ($order['status']) {
                                        'Delivered' => 'bg-emerald-100 text-emerald-700',
                                        'Shipped' => 'bg-blue-100 text-blue-700',
                                        'Processing' => 'bg-amber-100 text-amber-700',
                                        'Cancelled' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusColor }}">{{ $order['status'] }}</span>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Placed on {{ \Carbon\Carbon::parse($order['date'])->format('F d, Y') }} · {{ $order['items'] }} item{{ $order['items'] > 1 ? 's' : '' }} · {{ $order['payment'] }}
                            </p>
                        </div>
                        <div class="flex items-center gap-4">
                            <p class="text-lg font-bold text-gray-900">${{ number_format($order['total'], 2) }}</p>
                            <button type="button" @click="open = !open"
                                class="inline-flex items-center gap-1 rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                <span x-text="open ? 'Hide' : 'View'"></span> Details
                                <span :class="open ? 'rotate-180' : ''" class="inline-flex transition-transform">
                                    <x-icons name="chevron-down" class="w-4 h-4" />
                                </span>
                            </button>
                        </div>
                    </div>

                    <div x-show="open" x-cloak>
                        <div class="border-t border-gray-100 p-5">
                            <h3 class="text-sm font-semibold text-gray-900">Items in this order</h3>
                            <ul class="mt-3 space-y-3">
                                @foreach (array_slice($products, $loop->index % 3, $order['items']) as $item)
                                    <li class="flex items-center gap-3">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="h-12 w-12 rounded-lg border border-gray-100 object-cover" />
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-800">{{ $item['name'] }}</p>
                                            <p class="text-xs text-gray-400">SKU: {{ $item['id'] }}</p>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-900">${{ number_format($item['price'], 2) }}</p>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="mt-5 flex flex-col gap-2 border-t border-gray-100 pt-4 sm:flex-row sm:justify-end">
                                <x-button variant="outline" size="sm" icon="truck" href="#">
                                    Track Order
                                </x-button>
                                <x-button variant="outline" size="sm" icon="receipt" href="#">
                                    View Invoice
                                </x-button>
                                <x-button size="sm" icon="refresh" href="{{ route('cart.index') }}">
                                    Buy Again
                                </x-button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection