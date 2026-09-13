@extends('admin.layouts.app', ['title' => 'Dashboard'])

@section('content')
    @php
        $stats = [
            ['label' => 'Revenue Today', 'value' => '$2,347', 'delta' => '+12.4% vs yesterday', 'icon' => 'dollar-sign', 'color' => 'bg-indigo-100 text-indigo-600', 'up' => true],
            ['label' => 'Revenue This Month', 'value' => '$48,920', 'delta' => '+8.1% vs last month', 'icon' => 'trending-up', 'color' => 'bg-emerald-100 text-emerald-600', 'up' => true],
            ['label' => 'New Orders', 'value' => '37', 'delta' => '+5 today', 'icon' => 'receipt', 'color' => 'bg-amber-100 text-amber-600', 'up' => true],
            ['label' => 'Low Stock Items', 'value' => '4', 'delta' => '2 products sold out', 'icon' => 'alert-triangle', 'color' => 'bg-red-100 text-red-600', 'up' => false],
        ];

        $lowStock = collect($products)->where('stock', '<=', 10)->take(4)->all();
        $pending = collect($adminOrders)->filter(fn($o) => in_array($o['status'], ['Pending', 'Processing', 'Shipped']))->count();
    @endphp

    {{-- Stat cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <div class="rounded-2xl border border-gray-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl {{ $stat['color'] }}">
                        <x-icons :name="$stat['icon']" class="w-5 h-5" />
                    </span>
                    @if ($stat['up'])
                        <span class="flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-600">
                            <x-icons name="trending-up" class="w-3.5 h-3.5" />
                        </span>
                    @endif
                </div>
                <p class="mt-4 text-2xl font-extrabold text-gray-900">{{ $stat['value'] }}</p>
                <p class="text-sm text-gray-500">{{ $stat['label'] }}</p>
                <p class="mt-1 text-xs text-gray-400">{{ $stat['delta'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
        {{-- Recent orders --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white xl:col-span-2">
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <h2 class="font-semibold text-gray-900">Recent Orders</h2>
                <a href="{{ route('admin.orders') }}" class="text-sm font-semibold text-indigo-600 hover:underline">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-400">
                        <tr>
                            <th class="px-6 py-3 font-medium">Order ID</th>
                            <th class="px-6 py-3 font-medium">Customer</th>
                            <th class="px-6 py-3 font-medium">Date</th>
                            <th class="px-6 py-3 font-medium">Total</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach (array_slice($adminOrders, 0, 5) as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3.5 font-semibold text-indigo-600">{{ $order['id'] }}</td>
                                <td class="px-6 py-3.5 text-gray-700">{{ $order['customer'] }}</td>
                                <td class="px-6 py-3.5 text-gray-500">{{ $order['date'] }}</td>
                                <td class="px-6 py-3.5 font-medium text-gray-900">${{ number_format($order['total'], 2) }}</td>
                                <td class="px-6 py-3.5">
                                    @php
                                        $statusColor = match ($order['status']) {
                                            'Pending' => 'bg-amber-100 text-amber-700',
                                            'Processing' => 'bg-blue-100 text-blue-700',
                                            'Shipped' => 'bg-violet-100 text-violet-700',
                                            'Delivered' => 'bg-emerald-100 text-emerald-700',
                                            'Cancelled' => 'bg-red-100 text-red-700',
                                            default => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusColor }}">{{ $order['status'] }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Low stock --}}
        <div class="rounded-2xl border border-gray-200 bg-white">
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <h2 class="font-semibold text-gray-900">Low Stock Products</h2>
                <a href="{{ route('admin.products') }}" class="text-sm font-semibold text-indigo-600 hover:underline">Manage</a>
            </div>
            <ul class="divide-y divide-gray-100">
                @foreach ($lowStock as $product)
                    <li class="flex items-center gap-3 px-6 py-3.5">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="h-10 w-10 rounded-lg border border-gray-100 object-cover" />
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-gray-800">{{ $product['name'] }}</p>
                            <p class="text-xs text-gray-400">{{ $product['category_name'] }}</p>
                        </div>
                        <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $product['stock'] === 0 ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $product['stock'] === 0 ? 'Out of stock' : $product['stock'] . ' left' }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Revenue + pending orders --}}
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="rounded-2xl border border-gray-200 bg-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-gray-900">Revenue Overview</h2>
                    <p class="text-xs text-gray-400">Last 7 days</p>
                </div>
                <span class="rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-600">+8.1%</span>
            </div>
            <div class="mt-6 flex h-40 items-end gap-2">
                @foreach ([45, 70, 52, 88, 63, 95, 78] as $i => $height)
                    <div class="flex flex-1 flex-col items-center gap-2">
                        <div class="w-full rounded-t-lg bg-indigo-600/80" style="height: {{ $height }}%"></div>
                        <span class="text-[10px] text-gray-400">{{ ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'][$i] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-6">
            <h2 class="font-semibold text-gray-900">Orders to Fulfill</h2>
            <p class="text-xs text-gray-400">{{ $pending }} orders need attention</p>
            <div class="mt-6 space-y-4">
                @foreach (collect($adminOrders)->filter(fn($o) => in_array($o['status'], ['Pending', 'Processing', 'Shipped']))->take(3) as $order)
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 text-gray-500">
                            <x-icons name="package" class="w-5 h-5" />
                        </span>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">{{ $order['id'] }} · {{ $order['customer'] }}</p>
                            <p class="text-xs text-gray-400">${{ number_format($order['total'], 2) }} · {{ $order['status'] }}</p>
                        </div>
                        <x-button size="sm" variant="outline" href="{{ route('admin.orders') }}">View</x-button>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-6">
            <h2 class="font-semibold text-gray-900">Top Products</h2>
            <p class="text-xs text-gray-400">By units sold this month</p>
            <ul class="mt-6 space-y-4">
                @foreach ([['Vitamin C Serum', '$4,850', 92], ['Wireless Headphones', '$3,120', 62], ['Mechanical Keyboard', '$2,890', 48], ['Ceramic Cookware Set', '$1,950', 31]] as $top)
                    <li>
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-medium text-gray-700">{{ $top[0] }}</span>
                            <span class="text-xs text-gray-400">{{ $top[2] }} sold</span>
                        </div>
                        <div class="mt-1.5 h-2 overflow-hidden rounded-full bg-gray-100">
                            <div class="h-full rounded-full bg-indigo-600" style="width: {{ $top[2] }}%"></div>
                        </div>
                        <p class="mt-1 text-right text-xs font-semibold text-gray-600">{{ $top[1] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection