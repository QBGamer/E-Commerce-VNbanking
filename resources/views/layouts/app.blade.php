<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $title ?? 'ShopHub' }}@if (!empty($title)) · {{ $storeInfo['name'] ?? 'ShopHub' }} @endif</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-gray-50 font-sans text-gray-900 antialiased">
    <x-navbar :categories="$categories" :cart-count="3" />

    <main class="flex-1">
        @yield('content')
    </main>

    <x-footer :store-info="$storeInfo" :categories="$categories" />

    @stack('scripts')
</body>
</html>