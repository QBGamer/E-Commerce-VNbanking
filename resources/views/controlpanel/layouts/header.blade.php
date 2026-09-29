<header class="flex h-16 shrink-0 items-center gap-3 border-b border-gray-200 bg-white px-4 sm:px-6">
    <button type="button" @click="sidebarOpen = !sidebarOpen" class="inline-flex items-center justify-center rounded-lg p-2 text-gray-500 hover:bg-gray-100 lg:hidden" aria-label="Toggle sidebar">
        <x-icons name="menu" class="w-6 h-6" />
    </button>

    <div class="min-w-0 flex-1">
        <h1 class="truncate text-base font-bold text-gray-900 lg:text-lg">{{ $title ?? 'Dashboard' }}</h1>
    </div>

    <form action="#" class="relative hidden md:block">
        <input type="text" placeholder="Search orders, customers..." class="w-64 rounded-lg border border-gray-200 bg-gray-50 py-2 pl-10 pr-4 text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-200" />
        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <x-icons name="search" class="w-4.5 h-4.5" />
        </span>
    </form>

    <div class="flex items-center gap-1">
        <button type="button" class="relative inline-flex items-center justify-center rounded-lg p-2 text-gray-500 hover:bg-gray-100" aria-label="Notifications">
            <x-icons name="bell" class="w-5.5 h-5.5" />
            <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-red-500"></span>
        </button>
        <a href="{{ route('home') }}" class="hidden items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 sm:inline-flex">
            <x-icons name="shopping-bag" class="w-5 h-5" />
            Storefront
        </a>
        <span class="mx-2 hidden h-6 w-px bg-gray-200 sm:block"></span>
        <div class="flex items-center gap-2.5">
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-600 text-sm font-bold text-white">AD</span>
            <div class="hidden leading-tight lg:block">
                <p class="text-sm font-semibold text-gray-900">Admin Demo</p>
                <p class="text-xs text-gray-400">Super Admin</p>
            </div>
        </div>
    </div>
</header>