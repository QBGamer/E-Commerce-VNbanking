@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'error' => null,
    'icon' => null,
    'autocomplete' => null,
    'inputmode' => null,
    'togglePassword' => false,
])

@php
    $hasIcon = $icon !== null;
    $inputClasses = 'w-full rounded-lg border bg-white px-4 text-sm text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 transition-shadow '
        . ($hasIcon ? 'pl-11' : '')
        . ($togglePassword ? ' pr-16' : '')
        . ($error ? ' border-red-400 focus:ring-red-300' : ' border-gray-300 focus:border-indigo-500 focus:ring-indigo-200');
@endphp

<div @if ($togglePassword) x-data="{ showPassword: false }" @endif>
    @if ($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-gray-700">
            {{ $label }}@if ($required)<span class="ml-0.5 text-red-500">*</span>@endif
        </label>
    @endif

    <div class="relative">
        @if ($hasIcon)
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                <x-icons :name="$icon" class="w-5 h-5" />
            </div>
        @endif
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            @if ($togglePassword) :type="showPassword ? 'text' : 'password'" @endif
            value="{{ $type !== 'password' ? $value : '' }}"
            placeholder="{{ $placeholder }}"
            @if ($required) required @endif
            @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            @if ($inputmode) inputmode="{{ $inputmode }}" @endif
            {{ $attributes->merge(['class' => $inputClasses]) }}
        />
        @if ($togglePassword)
            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center gap-1 pr-3.5 text-xs font-semibold text-indigo-600 hover:underline">
                <span x-text="showPassword ? 'Hide' : 'Show'"></span>
            </button>
        @elseif (isset($slot) && trim($slot) !== '')
            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                {{ $slot }}
            </div>
        @endif
    </div>

    @if ($error)
        <p class="mt-1.5 flex items-center gap-1 text-xs text-red-600">
            <x-icons name="alert-triangle" class="w-3.5 h-3.5" />{{ $error }}
        </p>
    @endif
</div>