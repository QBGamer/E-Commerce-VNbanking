@extends('controlpanel.layouts.app', ['title' => 'Products'])

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Manage Products</h2>
            {{-- <p class="text-sm text-gray-500">{{ count($products) }} products in catalog</p> --}}
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

    {{-- Filter bar --}}
    <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-5">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex flex-wrap gap-2">
                @php
                    $isAll = !request()->query('stock') && !request()->query('status');
                    $isActive = request()->query('status') === 'active';
                    $isLow = request()->query('stock') === 'low';
                    $isOut = request()->query('status') === 'inactive';
                    $chip = fn ($active) => $active
                        ? 'bg-indigo-600 text-white'
                        : 'border border-gray-300 bg-white text-gray-600 hover:border-indigo-300';
                @endphp
                <a href="{{ route('controlpanel.products') }}" class="rounded-full px-4 py-2 text-sm font-medium {{ $chip($isAll) }}">All</a>
                <a href="{{ $queryUrl(['status' => 'active']) }}" class="rounded-full px-4 py-2 text-sm font-medium {{ $chip($isActive) }}">Active</a>
                <a href="{{ $queryUrl(['stock' => 'low']) }}" class="rounded-full px-4 py-2 text-sm font-medium {{ $chip($isLow) }}">Low Stock</a>
                <a href="{{ $queryUrl(['status' => 'inactive']) }}" class="rounded-full px-4 py-2 text-sm font-medium {{ $chip($isOut) }}">Out of Stock</a>
            </div>
            <p class="text-sm text-gray-500" id="product-count">
                @if (count($products))
                    Showing <span class="font-semibold text-gray-800">{{ count($products) }}</span> of {{ $total }} products
                @else
                    No results
                @endif
            </p>
        </div>

        <form method="GET" action="{{ route('controlpanel.products') }}" class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-6">
            {{-- Product --}}
            <div class="sm:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Product</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name or sku..." class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" />
            </div>
            {{-- Category --}}
            <div class="sm:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Category</label>
                <select name="category" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    <option value="">All categories</option>
                    @foreach ($categories as $key => $label)
                        <option value="{{ $key }}" @selected($category === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Price --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Min price</label>
                <input type="number" name="price_min" min="0" step="0.01" value="{{ $price_min }}" placeholder="0" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" />
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Max price</label>
                <input type="number" name="price_max" min="0" step="0.01" value="{{ $price_max }}" placeholder="Any" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" />
            </div>
            {{-- Stock --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Stock</label>
                <select name="stock" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    <option value="">Any</option>
                    <option value="low" @selected($stock === 'low')>Low (1&ndash;10)</option>
                    <option value="out" @selected($stock === 'out')>Out of stock</option>
                </select>
            </div>
            {{-- Status --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    <option value="">Any</option>
                    <option value="active" @selected($status === 'active')>Active</option>
                    <option value="inactive" @selected($status === 'inactive')>Inactive</option>
                </select>
            </div>
            {{-- Actions --}}
            <div class="flex flex-wrap items-end gap-2 sm:col-span-2 lg:col-span-2">
                <x-button type="submit">Apply Filters</x-button>
                <a href="{{ route('controlpanel.products') }}" class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">Reset</a>
            </div>
        </form>
    </div>
    @if ($products->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $products->appends(collect(request()->query())->filter(fn ($v) => $v !== null && $v !== '')->all())->links() }}
        </div>
    @endif

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
                    @forelse ($products as $product)
                        <tr class="hover:bg-gray-50" id="product-{{ $product['id'] }}">
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="h-10 w-10 rounded-lg border border-gray-100 object-cover" />
                                    <div>
                                        <span class="block font-medium text-gray-800">{{ $product['name'] }}</span>
                                        <span class="block font-xs text-gray-500">{{ $product['sku'] }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">{{ $product['category']['name'] }}</span>
                            </td>
                            <td class="px-6 py-3.5 font-medium text-gray-900">${{ number_format($product['price'], 2) }}</td>
                            <td class="px-6 py-3.5">
                                <span class="font-medium {{ $product['stock'] === 0 ? 'text-red-600' : ($product['stock'] <= 10 ? 'text-amber-600' : 'text-gray-700') }}">
                                    {{ $product['stock'] === 0 ? 'Out of stock' : $product['stock'] }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5">
                                @if ($product['status'] !== 'active')
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
                                    <button @click='openModal("product-delete", { id: @json($product["id"]), name: @json($product["name"]) })' type="button" class="rounded-lg p-2 text-gray-400 hover:bg-red-50 hover:text-red-600" title="Delete">
                                        <x-icons name="trash" class="w-4.5 h-4.5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                No products match your filters. Try adjusting or resetting them.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($products->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $products->appends(collect(request()->query())->filter(fn ($v) => $v !== null && $v !== '')->all())->links() }}
        </div>
    @endif
    <x-modal id="product-delete" title="Delete product">
        <p class="text-sm leading-relaxed text-gray-600">
            Are you sure you want to delete
            <span class="font-semibold text-gray-900" x-text="payload?.name ?? ''"></span>
            from the catalog? This action cannot be undone.
        </p>
        <x-slot:footer>
            <x-button variant="outline" x-on:click="close()">Cancel</x-button>
            <x-button variant="danger" x-on:click="removeProduct(payload.id); close()">Delete</x-button>
        </x-slot:footer>
    </x-modal>
    <script>
        function removeProduct(id) {
            fetch("{{ route('products.destroy', ':id') }}".replace(':id', id), {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            })
            .then(response => {
                if (response.status === 200) {
                    Alpine.store('toasts').notify('Product removed successfully.', 'success');
                    document.getElementById('product-' + id).remove();
                    document.getElementById('product-count').innerHTML = `Showing <span class="font-semibold text-gray-800">${document.querySelectorAll('tbody tr').length}</span> of {{ $total }} products`;
                    // location.reload();
                    return response.json();
                }else {
                    throw new Error('Failed to delete product.');
                }
            })
            // .then(data => {
            //     console.log('Success:', data);
            // })
            .catch(error => {
                // console.error('Error:', error);
                Alpine.store('toasts').notify('An error occurred while deleting the product.', 'error');
                // alert('An error occurred while deleting the product.');
            });
            }
    </script>
    {{-- Inventory summary --}}
    {{-- <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
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
    </div> --}}
@endsection
