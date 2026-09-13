@extends('admin.layouts.app', ['title' => 'Orders'])

@section('content')
@php
    $statuses = ['All', 'Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'];

    $ordersWithItems = collect($adminOrders)->map(function ($order) use ($products) {
        $order['item_names'] = collect($products)->take($order['items'])->pluck('name')->all();
        return $order;
    })->all();
@endphp

    <div x-data="ordersPanel()">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Manage Orders</h2>
                <p class="text-sm text-gray-500">{{ count($adminOrders) }} orders</p>
            </div>
            <div class="flex items-center gap-2">
                <x-button variant="outline" size="md" icon="download">Export CSV</x-button>
                <x-button variant="outline" size="md" icon="print">Print</x-button>
            </div>
        </div>

        {{-- Status tabs --}}
        <div class="mt-6 flex flex-wrap gap-2">
            @foreach ($statuses as $status)
                <button type="button" @click="filter = '{{ $status }}'"
                    :class="filter === '{{ $status }}' ? 'bg-indigo-600 text-white' : 'border border-gray-300 bg-white text-gray-600 hover:border-indigo-300'"
                    class="rounded-full px-4 py-2 text-sm font-medium transition-colors">
                    {{ $status }}
                    <span class="ml-1 text-xs opacity-60">{{ $status === 'All' ? count($adminOrders) : collect($adminOrders)->where('status', $status)->count() }}</span>
                </button>
            @endforeach
        </div>

        {{-- Orders table --}}
        <div class="mt-4 overflow-hidden rounded-2xl border border-gray-200 bg-white">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-400">
                        <tr>
                            <th class="px-6 py-3 font-medium">Order ID</th>
                            <th class="px-6 py-3 font-medium">Customer</th>
                            <th class="px-6 py-3 font-medium">Date</th>
                            <th class="px-6 py-3 font-medium">Items</th>
                            <th class="px-6 py-3 font-medium">Total</th>
                            <th class="px-6 py-3 font-medium">Payment</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 text-right font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="(order, i) in filteredOrders" :key="order.id">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3.5 font-semibold text-indigo-600" x-text="order.id"></td>
                                <td class="px-6 py-3.5 text-gray-700" x-text="order.customer"></td>
                                <td class="px-6 py-3.5 text-gray-500" x-text="order.date"></td>
                                <td class="px-6 py-3.5 text-gray-600" x-text="order.items"></td>
                                <td class="px-6 py-3.5 font-medium text-gray-900" x-text="'$' + order.total.toFixed(2)"></td>
                                <td class="px-6 py-3.5 text-gray-500" x-text="order.payment"></td>
                                <td class="px-6 py-3.5">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold text-white"
                                        :class="{ 'bg-amber-500': order.status === 'Pending', 'bg-blue-500': order.status === 'Processing', 'bg-violet-500': order.status === 'Shipped', 'bg-emerald-500': order.status === 'Delivered', 'bg-red-500': order.status === 'Cancelled' }"
                                        x-text="order.status"></span>
                                </td>
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center justify-end gap-1">
                                        <button type="button" @click="openOrder(i)"
                                            class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold text-indigo-600 hover:bg-indigo-50">
                                            <x-icons name="eye" class="w-4 h-4" /> View
                                        </button>
                                        <button type="button" class="rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-700" title="Print invoice">
                                            <x-icons name="print" class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Detail modal --}}
        <template x-if="selected !== null">
            <div class="fixed inset-0 z-50 flex items-end justify-center sm:items-center">
                <div class="absolute inset-0 bg-gray-900/50" @click="selected = null"></div>
                <div class="relative z-10 max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-t-2xl bg-white sm:rounded-2xl">
                    <div class="sticky top-0 z-10 flex items-center justify-between border-b border-gray-100 bg-white px-6 py-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900" x-text="'Order ' + selected.id">Order Detail</h3>
                            <p class="text-xs text-gray-400" x-text="'Placed on ' + selected.date + ' · ' + selected.payment"></p>
                        </div>
                        <button type="button" @click="selected = null" class="rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-700">
                            <x-icons name="x" class="w-5 h-5" />
                        </button>
                    </div>

                    <div class="p-6">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-3">
                                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                                    <x-icons name="package" class="w-5 h-5" />
                                </span>
                                <div>
                                    <p class="font-semibold text-gray-900" x-text="selected.customer"></p>
                                    <p class="text-sm text-gray-400" x-text="selected.items + ' item(s)'"></p>
                                </div>
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-gray-400">Update status</label>
                                <div class="flex items-center gap-2">
                                    <select x-model="selected.status"
                                        class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                        <option>Pending</option>
                                        <option>Processing</option>
                                        <option>Shipped</option>
                                        <option>Delivered</option>
                                        <option>Cancelled</option>
                                    </select>
                                    <x-button type="button" size="sm" icon="check">Update</x-button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 rounded-xl border border-gray-100 bg-gray-50 p-4">
                            <h4 class="text-xs font-semibold uppercase tracking-wide text-gray-400">Shipping address</h4>
                            <p class="mt-2 text-sm text-gray-700">
                                <span class="font-semibold text-gray-800" x-text="selected.customer"></span><br />
                                123 Market Street, District 1<br />
                                Ho Chi Minh City, Vietnam 700000
                            </p>
                        </div>

                        <div class="mt-6">
                            <h4 class="text-xs font-semibold uppercase tracking-wide text-gray-400">Items</h4>
                            <ul class="mt-3 space-y-3">
                                <template x-for="(item, i) in selected.item_names" :key="i">
                                    <li class="flex items-center gap-3 text-sm">
                                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-400">
                                            <x-icons name="box" class="w-5 h-5" />
                                        </span>
                                        <span class="flex-1 text-gray-800" x-text="item"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>

                        <div class="mt-6 space-y-2 border-t border-gray-100 pt-4 text-sm">
                            <div class="flex justify-between text-gray-500">
                                <span>Subtotal</span>
                                <span x-text="'$' + (selected.total * 0.9).toFixed(2)"></span>
                            </div>
                            <div class="flex justify-between text-gray-500">
                                <span>Shipping</span>
                                <span class="font-medium text-emerald-600">Free</span>
                            </div>
                            <div class="flex justify-between pt-2 text-base font-bold text-gray-900">
                                <span>Total</span>
                                <span x-text="'$' + selected.total.toFixed(2)"></span>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col gap-2 sm:flex-row sm:justify-end">
                            <x-button variant="outline" icon="print">Print Invoice</x-button>
                            <x-button variant="outline" icon="mail">Email Customer</x-button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('ordersPanel', () => ({
                orders: @json($ordersWithItems),
                filter: 'All',
                selected: null,

                get filteredOrders() {
                    if (this.filter === 'All') return this.orders;
                    return this.orders.filter((o) => o.status === this.filter);
                },

                openOrder(index) {
                    const order = this.orders[this.orders.indexOf(this.filteredOrders[index])];
                    this.selected = order ? { ...order } : null;
                },
            }));
        });
    </script>
@endpush
@endsection