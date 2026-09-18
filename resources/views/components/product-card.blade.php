@props(['product' => []])

@php
    $isSoldOut = ($product['stock'] ?? 1) <= 0;
@endphp

<div class="group relative flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white transition-shadow duration-200 hover:shadow-lg">
    @if (!empty($product->badge))
        @php
            $badgeColors = [
                'Sale' => 'bg-red-600',
                'New' => 'bg-emerald-600',
                'Low Stock' => 'bg-amber-500',
                'Sold Out' => 'bg-gray-700',
                'Trending' => 'bg-indigo-600',
                'Hot' => 'bg-orange-600',
            ];
        @endphp
        <span class="absolute left-3 top-3 z-10 rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide text-white {{ $badgeColors[$product->badge] ?? 'bg-indigo-600' }}">
            {{ $product->badge }}
        </span>
    @endif

    {{-- <a href="{{ route('products.detail', $product['slug']) }}" class="relative aspect-square overflow-hidden bg-gray-100"> --}}
    <a href="" class="relative aspect-square overflow-hidden bg-gray-100">
        <img src="{{ $product->image }}" alt="{{ $product->name }}"
            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
            loading="lazy" />
        @if ($isSoldOut)
            <div class="absolute inset-0 flex items-center justify-center bg-white/60">
                <span class="rounded-lg bg-gray-900/90 px-4 py-2 text-sm font-semibold text-white">Sold Out</span>
            </div>
        @endif
    </a>

    <div class="flex flex-1 flex-col gap-2 p-4">
        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">{{ $product->category->name ?? '' }}</p>
        {{-- <a href="{{ route('products.detail', $product['slug']) }}" class="line-clamp-2 text-sm font-semibold text-gray-900 hover:text-indigo-600"> --}}
        <a href="" class="line-clamp-2 text-sm font-semibold text-gray-900 hover:text-indigo-600">
            {{ $product->name }}
        </a>

        <div class="mt-auto flex items-end justify-between gap-2 pt-2">
            <div>
                @if (!empty($product->old_price))
                    <p class="text-xs text-gray-400 line-through">${{ number_format($product->old_price, 2) }}</p>
                @endif
                <p class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</p>
            </div>
            {{-- <a href="{{ route('products.detail', $product['slug']) }}" --}}
            <a href=""
                class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-3 py-2 text-xs font-semibold text-white transition-colors hover:bg-indigo-700 {{ $isSoldOut ? 'pointer-events-none opacity-40' : '' }}">
                <x-icons name="cart" class="w-4 h-4" />
                Add
            </a>
        </div>
    </div>
</div>
