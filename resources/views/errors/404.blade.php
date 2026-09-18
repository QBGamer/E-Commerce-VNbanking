@extends('layouts.app', ['title' => 'Page Not Found'])

@section('content')
    <div class="mx-auto flex min-h-[70vh] max-w-2xl flex-col items-center justify-center px-4 py-16 text-center">
        <div class="flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-indigo-600">
            <x-icons name="search" class="w-4 h-4" /> Error 404
        </div>

        <p class="mt-6 text-7xl font-extrabold tracking-tight text-gray-900 sm:text-8xl">404</p>
        <p class="mt-2 text-xl font-semibold text-gray-800 sm:text-2xl">Page not found</p>
        <p class="mt-3 max-w-md text-sm leading-relaxed text-gray-500 sm:text-base">
            Sorry, the page you are looking for doesn't exist or has been moved.
        </p>

        <div class="mt-8 w-full max-w-md">
            <form action="{{ route('products.index') }}" class="relative">
                <input
                    type="text"
                    name="query"
                    placeholder="Search for products instead..."
                    class="w-full rounded-full border border-gray-300 bg-white py-3 pl-11 pr-4 text-sm text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                />
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                    <x-icons name="search" class="w-5 h-5" />
                </span>
            </form>
        </div>

        <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
            <x-button href="{{ route('home') }}" icon="arrow-left">
                Back to Home
            </x-button>
            <x-button href="{{ route('products.index') }}" variant="outline" icon="box">
                Browse Products
            </x-button>
        </div>
    </div>
@endsection
