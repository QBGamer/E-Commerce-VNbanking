@extends('admin.layouts.app', ['title' => 'Products'])

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Manage Products</h2>
            <p class="text-sm text-gray-500">{{ count($products) }} products in catalog</p>
        </div>
        <x-button icon="plus" x-data x-on:click="document.getElementById('add-form').classList.toggle('hidden')">
            Add Product
        </x-button>
    </div>

    {{-- Add / edit form --}}
    <div id="add-form" x-cloak class="mt-6 hidden rounded-2xl border border-gray-200 bg-white p-6">
        <h3 class="font-semibold text-gray-900">Add New Product</h3>
        <form class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <x-form-input name="p_name" label="Product name" placeholder="e.g. Wireless Mouse" required />
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Category</label>
                <select name="p_category" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    @foreach ($categories as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <x-form-input name="p_price" label="Price (USD)" type="number" step="0.01" placeholder="49.99" required />
            <x-form-input name="p_stock" label="Stock quantity" type="number" placeholder="50" />
            <x-form-input name="p_image" label="Image URL" placeholder="https://..." />
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Status</label>
                <select name="p_status" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    <option>Active</option>
                    <option>Draft</option>
                </select>
            </div>
            <div class="sm:col-span-2 lg:col-span-3">
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Description</label>
                <textarea name="p_desc" rows="3" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" placeholder="Short product description..."></textarea>
            </div>
            <div class="flex gap-3 sm:col-span-2 lg:col-span-3">
                <x-button type="submit" icon="check">Save Product</x-button>
                <x-button variant="outline" x-on:click="document.getElementById('add-form').classList.add('hidden')">Cancel</x-button>
            </div>
        </form>
    </div>

    {{-- Filter tabs --}}
    <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap gap-2">
            <button type="button" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-medium text-white">All</button>
            <button type="button" class="rounded-full border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:border-indigo-300">Active</button>
            <button type="button" class="rounded-full border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:border-indigo-300">Low Stock</button>
            <button type="button" class="rounded-full border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:border-indigo-300">Out of Stock</button>
        </div>
        <form action="#" class="relative">
            <input type="text" placeholder="Search products..." class="w-full rounded-lg border border-gray-200 bg-white py-2 pl-10 pr-4 text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 sm:w-64" />
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <x-icons name="search" class="w-4.5 h-4.5" />
            </span>
        </form>
    </div>

    {{-- Table --}}
    <div class="mt-4 overflow-hidden rounded-2xl border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-400">
                    <tr>
                        <th class="px-6 py-3 font-medium">Product</th>
                        <th class="px-6 py-3 font-medium">Category</th>
                        <th class="px-6 py-3 font-medium">Price</th>
                        <th class="px-6 py-3 font-medium">Stock</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 text-right font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="h-10 w-10 rounded-lg border border-gray-100 object-cover" />
                                    <span class="font-medium text-gray-800">{{ $product['name'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">{{ $product['category_name'] }}</span>
                            </td>
                            <td class="px-6 py-3.5 font-medium text-gray-900">${{ number_format($product['price'], 2) }}</td>
                            <td class="px-6 py-3.5">
                                <span class="font-medium {{ $product['stock'] === 0 ? 'text-red-600' : ($product['stock'] <= 10 ? 'text-amber-600' : 'text-gray-700') }}">
                                    {{ $product['stock'] === 0 ? 'Out of stock' : $product['stock'] }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5">
                                @if ($product['stock'] === 0)
                                    <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">Inactive</span>
                                @else
                                    <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">Active</span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="" class="rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-700" title="View">
                                        <x-icons name="eye" class="w-4.5 h-4.5" />
                                    </a>
                                    <button type="button" class="rounded-lg p-2 text-gray-400 hover:bg-indigo-50 hover:text-indigo-600" title="Edit">
                                        <x-icons name="edit" class="w-4.5 h-4.5" />
                                    </button>
                                    <button type="button" class="rounded-lg p-2 text-gray-400 hover:bg-red-50 hover:text-red-600" title="Delete">
                                        <x-icons name="trash" class="w-4.5 h-4.5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Inventory summary --}}
    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        @php
            $totalStock = array_sum(array_column($products, 'stock'));
            $low = collect($products)->where('stock', '<=', 10)->where('stock', '>', 0)->count();
        @endphp
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5">
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600"><x-icons name="box" class="w-5 h-5" /></span>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ count($products) }}</p>
                <p class="text-xs text-gray-500">Products in catalog</p>
            </div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5">
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600"><x-icons name="package" class="w-5 h-5" /></span>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $totalStock }}</p>
                <p class="text-xs text-gray-500">Total units in stock</p>
            </div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5">
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-600"><x-icons name="alert-triangle" class="w-5 h-5" /></span>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $low }}</p>
                <p class="text-xs text-gray-500">Low stock alerts</p>
            </div>
        </div>
    </div>
@endsection
