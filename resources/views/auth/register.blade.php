@extends('layouts.app', ['title' => 'Create Account'])

@section('content')
<div class="flex min-h-[80vh] items-center justify-center px-4 py-16">
    <div class="w-full max-w-lg">
        <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
            <div class="mb-6 text-center">
                <span class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-600 text-white">
                    <x-icons name="user-plus" class="w-7 h-7" />
                </span>
                <h1 class="text-2xl font-bold text-gray-900">Create your account</h1>
                <p class="mt-1 text-sm text-gray-500">Join ShopHub in less than a minute</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf
                <x-form-input name="name" label="Full name" icon="user" placeholder="Jane Doe" autocomplete="name" required />
                <x-form-input name="email" label="Email address" type="email" icon="mail" placeholder="you@example.com" autocomplete="email" required />
                <x-form-input name="password" label="Password" type="password" icon="lock" placeholder="At least 8 characters" autocomplete="new-password" toggle-password required />
                <x-form-input name="password_confirmation" label="Confirm password" type="password" icon="lock" placeholder="Re-enter your password" autocomplete="new-password" toggle-password required />

                <label class="flex cursor-pointer items-start gap-2 text-sm text-gray-600">
                    <input type="checkbox" required class="mt-0.5 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                    <span>
                        I agree to the <a href="#" class="font-medium text-indigo-600 hover:underline">Terms of Service</a> and
                        <a href="#" class="font-medium text-indigo-600 hover:underline">Privacy Policy</a>.
                    </span>
                </label>

                <x-button type="submit" icon="check" class="w-full">
                    Create Account
                </x-button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-500">
                Already have an account?
                <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:underline">Sign in</a>
            </p>
        </div>
    </div>
</div>
@endsection
