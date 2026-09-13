<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $title ?? 'Dashboard' }} · {{ $storeInfo['name'] ?? 'ShopHub' }} Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-100 font-sans text-gray-900 antialiased" x-data="{ sidebarOpen: false }">
    {{-- Mobile overlay --}}
    <div x-cloak x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 z-40 bg-gray-900/50 lg:hidden"></div>

    <div class="flex h-full overflow-hidden">
        @include('admin.layouts.sidebar')

        <div class="flex min-w-0 flex-1 flex-col">
            @include('admin.layouts.header')

            <main class="flex-1 overflow-y-auto">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>