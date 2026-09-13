@extends('admin.layouts.app', ['title' => 'Customers'])

@section('content')
    <div x-data="customersPanel()">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Customers</h2>
                <p class="text-sm text-gray-500">{{ count($adminCustomers) }} registered customers</p>
            </div>
            <x-button icon="user-plus">Invite Customer</x-button>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600"><x-icons name="users" class="w-5 h-5" /></span>
                <div>
                    <p class="text-xl font-bold text-gray-900">{{ count($adminCustomers) }}</p>
                    <p class="text-xs text-gray-500">Total customers</p>
                </div>
            </div>
            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600"><x-icons name="trending-up" class="w-5 h-5" /></span>
                <div>
                    <p class="text-xl font-bold text-gray-900">{{ collect($adminCustomers)->where('status', 'Active')->count() }}</p>
                    <p class="text-xs text-gray-500">Active customers</p>
                </div>
            </div>
            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-600"><x-icons name="dollar-sign" class="w-5 h-5" /></span>
                <div>
                    <p class="text-xl font-bold text-gray-900">${{ number_format(collect($adminCustomers)->sum('spent'), 0) }}</p>
                    <p class="text-xs text-gray-500">Total lifetime value</p>
                </div>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-2xl border border-gray-200 bg-white">
            <div class="flex flex-col gap-3 border-b border-gray-100 p-4 sm:flex-row sm:items-center sm:justify-between">
                <form action="#" class="relative">
                    <input type="text" placeholder="Search customers..." class="w-full rounded-lg border border-gray-200 bg-white py-2 pl-10 pr-4 text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 sm:w-72" />
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <x-icons name="search" class="w-4.5 h-4.5" />
                    </span>
                </form>
                <select class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-600 focus:border-indigo-500 focus:outline-none">
                    <option>All statuses</option>
                    <option>Active</option>
                    <option>Inactive</option>
                </select>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-400">
                        <tr>
                            <th class="px-6 py-3 font-medium">Customer</th>
                            <th class="px-6 py-3 font-medium">Orders</th>
                            <th class="px-6 py-3 font-medium">Total Spent</th>
                            <th class="px-6 py-3 font-medium">Joined</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 text-right font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($adminCustomers as $index => $customer)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-600">
                                            {{ collect(explode(' ', $customer['name']))->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}
                                        </span>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $customer['name'] }}</p>
                                            <p class="text-xs text-gray-400">{{ $customer['email'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3.5 font-medium text-gray-700">{{ $customer['orders'] }}</td>
                                <td class="px-6 py-3.5 font-medium text-gray-900">${{ number_format($customer['spent'], 2) }}</td>
                                <td class="px-6 py-3.5 text-gray-500">{{ $customer['joined'] }}</td>
                                <td class="px-6 py-3.5">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $customer['status'] === 'Active' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $customer['status'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center justify-end gap-1">
                                        <button type="button" @click="selected = {{ $index }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold text-indigo-600 hover:bg-indigo-50">
                                            <x-icons name="eye" class="w-4 h-4" /> View
                                        </button>
                                        <button type="button" class="rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-700" title="Edit">
                                            <x-icons name="edit" class="w-4 h-4" />
                                        </button>
                                        <button type="button" class="rounded-lg p-2 text-gray-400 hover:bg-red-50 hover:text-red-600" title="Delete">
                                            <x-icons name="trash" class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Customer detail modal --}}
        <template x-if="selected !== null">
            <div class="fixed inset-0 z-50 flex items-end justify-center sm:items-center">
                <div class="absolute inset-0 bg-gray-900/50" @click="selected = null"></div>
                <div class="relative z-10 max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-t-2xl bg-white sm:rounded-2xl">
                    <div class="sticky top-0 z-10 flex items-center justify-between border-b border-gray-100 bg-white px-6 py-4">
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-full bg-indigo-600 font-bold text-white" x-text="selected.initials"></span>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900" x-text="selected.name"></h3>
                                <p class="text-xs text-gray-400" x-text="selected.email"></p>
                            </div>
                        </div>
                        <button type="button" @click="selected = null" class="rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-700">
                            <x-icons name="x" class="w-5 h-5" />
                        </button>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-3 gap-3">
                            <div class="rounded-xl bg-gray-50 p-4 text-center">
                                <p class="text-xl font-bold text-gray-900" x-text="selected.orders"></p>
                                <p class="text-xs text-gray-500">Orders</p>
                            </div>
                            <div class="rounded-xl bg-gray-50 p-4 text-center">
                                <p class="text-xl font-bold text-gray-900" x-text="'$' + selected.spent.toFixed(2)"></p>
                                <p class="text-xs text-gray-500">Total spent</p>
                            </div>
                            <div class="rounded-xl bg-gray-50 p-4 text-center">
                                <p class="text-xs text-gray-500">Member since</p>
                                <p class="mt-1 text-sm font-semibold text-gray-800" x-text="selected.joined"></p>
                            </div>
                        </div>

                        <h4 class="mt-6 text-xs font-semibold uppercase tracking-wide text-gray-400">Purchase history</h4>
                        <div class="mt-3 flex items-center gap-3 rounded-xl border border-gray-100 p-4">
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                                <x-icons name="receipt" class="w-5 h-5" />
                            </span>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-indigo-600">ORD-1082</p>
                                <p class="text-xs text-gray-400">Sep 12, 2026 · 3 items</p>
                            </div>
                            <p class="text-sm font-bold text-gray-900">$158.47</p>
                        </div>
                        <div class="mt-2 flex items-center gap-3 rounded-xl border border-gray-100 p-4">
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                                <x-icons name="receipt" class="w-5 h-5" />
                            </span>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-indigo-600">ORD-1075</p>
                                <p class="text-xs text-gray-400">Aug 30, 2026 · 2 items</p>
                            </div>
                            <p class="text-sm font-bold text-gray-900">$89.99</p>
                        </div>

                        <div class="mt-6 flex flex-col gap-2 sm:flex-row sm:justify-end">
                            <x-button variant="outline" icon="mail">Send Email</x-button>
                            <x-button icon="user-plus">Add as Staff</x-button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('customersPanel', () => ({
                customers: @json($adminCustomers),
                selected: null,
            }));
        });
    </script>
@endpush
@endsection