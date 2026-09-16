@props([
    'categories' => [],
    'cartCount' => 0,
    'user' => null,
])

<header class="sticky top-0 z-40 border-b border-gray-200 bg-white/90 backdrop-blur" x-data="{ mobileOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 lg:hidden"
                    @click="mobileOpen = !mobileOpen"
                    aria-label="Toggle menu"
                >
                    <x-icons name="menu" class="w-6 h-6" x-show="!mobileOpen" />
                    <x-icons name="x" class="w-6 h-6" x-show="mobileOpen" />
                </button>

                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-white">
                        <x-icons name="shopping-bag" class="w-5 h-5" />
                    </span>
                    <span class="hidden text-xl font-extrabold tracking-tight text-gray-900 sm:block">Shop<span class="text-indigo-600">Hub</span></span>
                </a>

                <nav class="ml-4 hidden items-center gap-1 lg:flex">
                    <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('home') ? 'text-indigo-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        Home
                    </a>
                    {{-- <a href="{{ route('products.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('products.*') ? 'text-indigo-600' : 'text-gray-700 hover:bg-gray-100' }}"> --}}
                    <a href="" class="rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('products.*') ? 'text-indigo-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        Shop
                    </a>
                </nav>
            </div>

            {{-- <form action="{{ route('products.index') }}" class="hidden max-w-xl flex-1 lg:block"> --}}
            <form action="" class="hidden max-w-xl flex-1 lg:block">
                <div class="relative">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Search products, categories..."
                        class="w-full rounded-full border border-gray-300 bg-gray-50 py-2.5 pl-11 pr-24 text-sm text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-200"
                        aria-label="Search"
                    />
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                        <x-icons name="search" class="w-5 h-5" />
                    </span>
                    <button type="submit" class="absolute inset-y-1 right-1 rounded-full bg-indigo-600 px-4 text-sm font-semibold text-white transition-colors hover:bg-indigo-700">
                        Search
                    </button>
                </div>
            </form>

            <div class="flex items-center gap-1">

                <a href="{{ route('cart.index') }}" class="relative inline-flex items-center justify-center rounded-lg p-2.5 text-gray-700 hover:bg-gray-100" aria-label="Cart">
                    <x-icons name="cart" class="w-6 h-6" />
                    @if ($cartCount > 0)
                        <span class="absolute -right-0.5 -top-0.5 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-indigo-600 px-1 text-[11px] font-bold text-white">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button
                        type="button"
                        class="inline-flex items-center justify-center gap-1.5 rounded-lg p-2.5 text-gray-700 hover:bg-gray-100"
                        @click="open = !open"
                        aria-label="Account"
                    >
                        <x-icons name="user" class="w-6 h-6" />
                        <span class="hidden sm:inline">{{ Auth::user()->name ?? 'Guest' }}</span>
                        <x-icons name="chevron-down" class="hidden w-4 h-4 text-gray-400 sm:block" x-show="!open" />
                        <x-icons name="chevron-up" class="hidden w-4 h-4 text-gray-400 sm:block" x-show="open" />
                    </button>

                    <div
                        x-show="open"
                        x-transition
                        x-cloak
                        class="absolute right-0 z-50 mt-2 w-56 origin-top-right rounded-xl border border-gray-200 bg-white py-1.5 shadow-xl"
                    >
                        @if (Auth::check())
                            <a href="{{ route('account') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <x-icons name="user" class="w-4 h-4 text-gray-400" /> My Account
                            </a>
                            <a href="{{ route('order-history') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <x-icons name="package" class="w-4 h-4 text-gray-400" /> Order History
                            </a>
                            <div class="my-1 border-t border-gray-100"></div>
                            <a href="{{ route('logout') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <x-icons name="logout" class="w-4 h-4 text-gray-400" /> Sign out
                            </a>
                            @if(Auth::user()->role=="admin" || Auth::user()->role=="manager" || Auth::user()->role=="staff")
                            <div class="my-1 border-t border-gray-100"></div>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-500 hover:bg-gray-50">
                                <x-icons name="dashboard" class="w-4 h-4 text-gray-400" /> Control Panel
                            </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <x-icons name="chevron-right" class="w-4 h-4 text-gray-400" /> Sign in
                            </a>
                            <a href="{{ route('register') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <x-icons name="user-plus" class="w-4 h-4 text-gray-400" /> Create account
                            </a>
                            <div class="my-1 border-t border-gray-100"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="border-t border-gray-100 px-4 py-3 lg:hidden">
        {{-- <form action="{{ route('products.index') }}" class="relative"> --}}
        <form action="" class="relative">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Search products, categories..."
                class="w-full rounded-full border border-gray-300 bg-gray-50 py-2.5 pl-11 pr-4 text-sm text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
            />
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                <x-icons name="search" class="w-5 h-5" />
            </span>
        </form>
    </div>

    <div x-cloak x-show="mobileOpen" x-transition class="border-t border-gray-100 bg-white lg:hidden">
        <div class="space-y-1 px-4 py-3">
            <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-800 hover:bg-gray-50">
                <x-icons name="home" class="w-5 h-5 text-gray-400" /> Home
            </a>
            <a href="" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-800 hover:bg-gray-50">
                <x-icons name="box" class="w-5 h-5 text-gray-400" /> Shop All Products
            </a>
            <a href="{{ route('cart.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-800 hover:bg-gray-50">
                <x-icons name="cart" class="w-5 h-5 text-gray-400" /> Cart
                @if ($cartCount > 0)
                    <span class="rounded-full bg-indigo-100 px-2 py-0.5 text-xs font-semibold text-indigo-700">{{ $cartCount }}</span>
                @endif
            </a>
            <p class="px-3 pt-3 text-xs font-medium uppercase tracking-wide text-gray-400">Categories</p>
            {{-- @foreach ($categories as $key => $label)
                <a href="{{ route('products.index', ['category' => $key]) }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                    <span class="h-1.5 w-1.5 rounded-full bg-indigo-400"></span> {{ $label }}
                </a>
            @endforeach --}}
        </div>
    </div>
</header>
