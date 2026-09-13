<aside class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-gray-200 bg-white transition-transform duration-200 lg:static lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    <div class="flex h-16 items-center gap-2 border-b border-gray-100 px-5">
        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-white">
            <x-icons name="dashboard" class="w-5 h-5" />
        </span>
        <div class="leading-tight">
            <p class="text-sm font-extrabold text-gray-900">{{ $storeInfo['name'] ?? 'ShopHub' }}</p>
            <p class="text-[11px] font-medium text-indigo-600">Admin Panel</p>
        </div>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto p-3">
        @php
            $menu = [
                ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard'],
                ['route' => 'admin.products', 'label' => 'Products', 'icon' => 'box'],
                ['route' => 'admin.orders', 'label' => 'Orders', 'icon' => 'receipt'],
                ['route' => 'admin.customers', 'label' => 'Customers', 'icon' => 'users'],
                ['route' => 'admin.coupons', 'label' => 'Coupons', 'icon' => 'tag'],
                ['route' => 'admin.settings', 'label' => 'Settings', 'icon' => 'settings'],
            ];
        @endphp
        @foreach ($menu as $item)
            @php $active = request()->routeIs($item['route']); @endphp
            <a href="{{ route($item['route']) }}"
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors {{ $active ? 'bg-indigo-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <x-icons :name="$item['icon']" class="w-5 h-5 {{ $active ? 'text-white' : 'text-gray-400 group-hover:text-gray-600' }}" />
                {{ $item['label'] }}
                @if ($item['route'] === 'admin.orders')
                    <span class="ml-auto rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $active ? 'bg-white/20 text-white' : 'bg-amber-100 text-amber-700' }}">{{ count($adminOrders) }}</span>
                @endif
            </a>
        @endforeach
    </nav>

    <div class="border-t border-gray-100 p-3">
        <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100 hover:text-gray-900">
            <x-icons name="arrow-left" class="w-5 h-5 text-gray-400" />
            Back to Storefront
        </a>
        <div class="mt-2 flex items-center gap-3 rounded-xl bg-gray-50 px-3 py-2.5">
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-600 text-sm font-bold text-white">AD</span>
            <div class="min-w-0 leading-tight">
                <p class="truncate text-sm font-semibold text-gray-900">Admin Demo</p>
                <p class="truncate text-xs text-gray-400">admin@shophub.demo</p>
            </div>
        </div>
    </div>
</aside>