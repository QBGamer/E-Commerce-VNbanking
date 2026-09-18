<footer class="border-t border-gray-200 bg-gray-50">
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4">
            <div class="space-y-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-white">
                        <x-icons name="shopping-bag" class="w-5 h-5" />
                    </span>
                    <span class="text-xl font-extrabold tracking-tight text-gray-900">Shop<span class="text-indigo-600">Hub</span></span>
                </a>
                <p class="text-sm leading-relaxed text-gray-500">
                    {{ $storeInfo['tagline'] ?? 'Everything you need, delivered.' }}
                </p>
                <div class="flex items-center gap-2">
                    <a href="#" class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-gray-500 shadow-sm transition-colors hover:bg-indigo-600 hover:text-white" aria-label="Facebook">
                        <x-icons name="facebook" class="w-4.5 h-4.5" />
                    </a>
                    <a href="#" class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-gray-500 shadow-sm transition-colors hover:bg-indigo-600 hover:text-white" aria-label="Twitter">
                        <x-icons name="twitter" class="w-4.5 h-4.5" />
                    </a>
                    <a href="#" class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-gray-500 shadow-sm transition-colors hover:bg-indigo-600 hover:text-white" aria-label="Instagram">
                        <x-icons name="instagram" class="w-4.5 h-4.5" />
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-900">Quick Links</h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600">Home</a></li>
                    <li><a href="" class="text-gray-500 hover:text-indigo-600">Shop All</a></li>
                    <li><a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-indigo-600">Shopping Cart</a></li>
                    <li><a href="{{ route('order-history') }}" class="text-gray-500 hover:text-indigo-600">Order History</a></li>
                    <li><a href="{{ route('account') }}" class="text-gray-500 hover:text-indigo-600">My Account</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-900">Categories</h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    @foreach ($categories as $slug => $label)
                        <li>
                            <a href="{{ route('products.index', ['category' => $slug]) }}" class="text-gray-500 hover:text-indigo-600">{{ $label }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-900">Contact</h3>
                <ul class="mt-4 space-y-3 text-sm text-gray-500">
                    <li class="flex items-start gap-3">
                        <x-icons name="map-pin" class="mt-0.5 w-4.5 h-4.5 shrink-0 text-gray-400" />
                        <span>{{ $storeInfo['address'] ?? '' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <x-icons name="phone" class="w-4.5 h-4.5 shrink-0 text-gray-400" />
                        <a href="tel:{{ $storeInfo['phone'] ?? '' }}" class="hover:text-indigo-600">{{ $storeInfo['phone'] ?? '' }}</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <x-icons name="mail" class="w-4.5 h-4.5 shrink-0 text-gray-400" />
                        <a href="mailto:{{ $storeInfo['email'] ?? '' }}" class="hover:text-indigo-600">{{ $storeInfo['email'] ?? '' }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-center gap-4 border-t border-gray-200 pt-6 sm:flex-row">
            <p class="text-xs text-gray-400">
                &copy; {{ date('Y') }} {{ $storeInfo['name'] ?? 'ShopHub' }}. All rights reserved.
            </p>
        </div>
    </div>
</footer>
