@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'icon' => null,
    'iconPosition' => 'left',
    'disabled' => false,
])

@php
    $variants = [
        'primary' => 'bg-indigo-600 text-white hover:bg-indigo-700 focus-visible:ring-indigo-500',
        'secondary' => 'bg-gray-900 text-white hover:bg-gray-800 focus-visible:ring-gray-700',
        'outline' => 'border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 focus-visible:ring-gray-400',
        'ghost' => 'text-gray-600 hover:bg-gray-100 focus-visible:ring-gray-400',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus-visible:ring-red-500',
        'success' => 'bg-emerald-600 text-white hover:bg-emerald-700 focus-visible:ring-emerald-500',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $classes = 'inline-flex items-center justify-center gap-2 rounded-lg font-semibold transition-colors duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed '
        . ($variants[$variant] ?? $variants['primary']) . ' '
        . ($sizes[$size] ?? $sizes['md']);

    if ($disabled) {
        $attributes = $attributes->merge(['disabled' => '']);
    }
@endphp

@if ($href)
    <a href="{{ $href }}"
        @if ($disabled) aria-disabled="true" @endif
        {{ $attributes->merge(['class' => $classes . ($disabled ? ' pointer-events-none opacity-60' : '')]) }}>
        @if ($icon && $iconPosition === 'left')
            <x-icons :name="$icon" class="w-4 h-4" />
        @endif
        {{ $slot }}
        @if ($icon && $iconPosition === 'right')
            <x-icons :name="$icon" class="w-4 h-4" />
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon && $iconPosition === 'left')
            <x-icons :name="$icon" class="w-4 h-4" />
        @endif
        {{ $slot }}
        @if ($icon && $iconPosition === 'right')
            <x-icons :name="$icon" class="w-4 h-4" />
        @endif
    </button>
@endif