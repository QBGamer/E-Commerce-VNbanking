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

    <div x-data="toastContainer" aria-live="polite"
        class="pointer-events-none fixed bottom-5 right-5 z-[60] flex w-80 flex-col gap-2">
        <template x-for="t in items" :key="t.id">
            <div x-show="true" x-transition.origin.top.right x-transition.leave.duration.300ms
                :class="classes(t.type)"
                class="pointer-events-auto flex items-start gap-2 rounded-xl px-4 py-3 text-sm font-medium shadow-lg">
                <span x-text="icon(t.type)"></span>
                <span x-text="t.message" class="flex-1"></span>
                <button @click="dismiss(t.id)" class="ml-auto opacity-70 hover:opacity-100" aria-label="Close">✕</button>
            </div>
        </template>
    </div>
    @stack('scripts')
</body>
</html>
