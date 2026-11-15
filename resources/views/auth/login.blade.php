@extends('layouts.app', ['title' => 'Sign In'])

@section('content')
<div class="flex min-h-[80vh] items-center justify-center px-4 py-16">
    <div class="w-full max-w-md">
        <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
            <div class="mb-6 text-center">
                <span class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-600 text-white">
                    <x-icons name="user" class="w-7 h-7" />
                </span>
                <h1 class="text-2xl font-bold text-gray-900">Welcome back</h1>
                <p class="mt-1 text-sm text-gray-500">Sign in to your account to continue</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 flex items-start gap-2 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <x-icons name="alert-triangle" class="w-4 h-4 mt-0.5 shrink-0" />
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <x-form-input name="email" label="Email address" type="email" icon="mail" placeholder="you@example.com" autocomplete="email" :value="old('email')" required />
                <x-form-input name="password" label="Password" type="password" icon="lock" placeholder="••••••••" autocomplete="current-password" toggle-password required />

                <div class="flex items-center justify-between">
                    <label class="flex cursor-pointer items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                        Remember me
                    </label>
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:underline">Forgot password?</a>
                </div>

                <x-button type="submit" icon="arrow-right" icon-position="right" class="w-full">
                    Sign In
                </x-button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-500">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:underline">Create one</a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            @if ($errors->any())
                Alpine.store('toasts').notify(@js($errors->first()), 'error');
            @endif
        });
    </script> --}}
@endpush
