@extends('admin.layouts.app', ['title' => 'Coupons'])

@section('content')
    @php
        $typeColors = [
            'Percent' => 'bg-indigo-100 text-indigo-700',
            'Fixed' => 'bg-emerald-100 text-emerald-700',
            'Shipping' => 'bg-amber-100 text-amber-700',
        ];
    @endphp

    <div x-data="{ showForm: false, activeFilter: 'All' }">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Coupons & Discounts</h2>
                <p class="text-sm text-gray-500">{{ collect($coupons)->where('status', 'Active')->count() }} active coupons</p>
            </div>
            <x-button icon="plus" @click="showForm = !showForm">
                Create Coupon
            </x-button>
        </div>

        {{-- Create coupon form --}}
        <div x-cloak x-show="showForm" x-transition class="mt-6 rounded-2xl border border-gray-200 bg-white p-6">
            <h3 class="font-semibold text-gray-900">Create New Coupon</h3>
            <form class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <x-form-input name="code" label="Coupon code" placeholder="SUMMER25" required />
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Discount type</label>
                    <select name="type" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        <option value="percent">Percent (%)</option>
                        <option value="fixed">Fixed ($)</option>
                        <option value="shipping">Free shipping</option>
                    </select>
                </div>
                <x-form-input name="value" label="Value" type="number" placeholder="25" required />
                <x-form-input name="min" label="Minimum order ($)" type="number" placeholder="50" />
                <x-form-input name="uses" label="Usage limit" type="number" placeholder="100" />
                <x-form-input name="expires" label="Expires on" type="date" required />
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <x-button type="submit" icon="check" class="w-full">Save Coupon</x-button>
                    <x-button variant="outline" @click="showForm = false">Cancel</x-button>
                </div>
            </form>
        </div>

        {{-- Filters --}}
        <div class="mt-6 flex flex-wrap gap-2">
            @foreach (['All', 'Active', 'Expired'] as $status)
                <button type="button" @click="activeFilter = '{{ $status }}'"
                    :class="activeFilter === '{{ $status }}' ? 'bg-indigo-600 text-white' : 'border border-gray-300 bg-white text-gray-600 hover:border-indigo-300'"
                    class="rounded-full px-4 py-2 text-sm font-medium transition-colors">
                    {{ $status }}
                </button>
            @endforeach
        </div>

        {{-- Coupons list --}}
        <div class="mt-4 space-y-3">
            <template x-for="coupon in filteredCoupons" :key="coupon.code">
                <div class="rounded-2xl border border-gray-200 bg-white p-5">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center">
                        <div class="flex items-center gap-4">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl border-2 border-dashed border-indigo-300 bg-indigo-50 text-indigo-600">
                                <x-icons name="tag" class="w-6 h-6" />
                            </span>
                            <div>
                                <div class="flex items-center gap-2">
                                    <p class="text-lg font-bold tracking-tight text-gray-900" x-text="coupon.code"></p>
                                    <span class="rounded-md bg-gray-100 px-2 py-0.5 font-mono text-xs text-gray-500">COPY</span>
                                </div>
                                <p class="mt-0.5 text-sm text-gray-500">
                                    <span x-text="coupon.type + ': ' + (coupon.type === 'Percent' ? coupon.value + '% off' : coupon.type === 'Fixed' ? '$' + coupon.value + ' off' : 'Free shipping')"></span>
                                    <span x-text="' · Min order $' + coupon.min.toFixed(2)"></span>
                                </p>
                            </div>
                        </div>
                        <div class="grid flex-1 grid-cols-3 gap-2 text-center text-sm lg:max-w-md">
                            <div class="rounded-lg bg-gray-50 px-3 py-2">
                                <p class="text-base font-bold text-gray-900" x-text="coupon.uses.toLocaleString()"></p>
                                <p class="text-xs text-gray-500">Uses</p>
                            </div>
                            <div class="rounded-lg bg-gray-50 px-3 py-2">
                                <p class="text-sm font-semibold text-gray-700" x-text="coupon.expires"></p>
                                <p class="text-xs text-gray-500">Expires</p>
                            </div>
                            <div class="rounded-lg bg-gray-50 px-3 py-2">
                                <p class="text-sm font-semibold" x-text="coupon.status" :class="coupon.status === 'Active' ? 'text-emerald-600' : 'text-red-500'"></p>
                                <p class="text-xs text-gray-500">Status</p>
                            </div>
                        </div>
                        <div class="flex gap-1 lg:justify-end">
                            <button type="button" class="rounded-lg p-2 text-gray-400 hover:bg-indigo-50 hover:text-indigo-600" title="Edit">
                                <x-icons name="edit" class="w-4.5 h-4.5" />
                            </button>
                            <button type="button" class="rounded-lg p-2 text-gray-400 hover:bg-red-50 hover:text-red-600" title="Delete">
                                <x-icons name="trash" class="w-4.5 h-4.5" />
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="mt-6 rounded-2xl border border-indigo-100 bg-indigo-50 p-5">
            <div class="flex items-center gap-2 text-indigo-700">
                <x-icons name="info" class="w-5 h-5" />
                <p class="font-semibold">Tip</p>
            </div>
            <p class="mt-1 text-sm text-indigo-900/70">
                Coupons can be applied at checkout. Set a usage limit to prevent abuse, and schedule an expiry date to keep your store running smoothly.
            </p>
        </div>
    </div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('couponsPanel', () => ({
                coupons: @json($coupons),
                showForm: false,
                activeFilter: 'All',

                get filteredCoupons() {
                    if (this.activeFilter === 'All') return this.coupons;
                    return this.coupons.filter((c) => c.status === this.activeFilter);
                },
            }));
        });
    </script>
@endpush
@endsection