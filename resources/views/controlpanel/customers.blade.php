@extends('controlpanel.layouts.app', ['title' => 'Customers'])

@section('content')
    <div x-data="customersPanel()">
        @php
            echo $customers;
        @endphp
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Customers</h2>
                <p class="text-sm text-gray-500"><span x-text="totalCustomers"></span> registered customers</p>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600"><x-icons name="users" class="w-5 h-5" /></span>
                <div>
                    <p class="text-xl font-bold text-gray-900" x-text="totalCustomers"></p>
                    <p class="text-xs text-gray-500">Total customers</p>
                </div>
            </div>
            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600"><x-icons name="trending-up" class="w-5 h-5" /></span>
                <div>
                    <p class="text-xl font-bold text-gray-900" x-text="activeCustomers"></p>
                    <p class="text-xs text-gray-500">Active customers</p>
                </div>
            </div>
            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-600"><x-icons name="dollar-sign" class="w-5 h-5" /></span>
                <div>
                    <p class="text-xl font-bold text-gray-900" x-text="'$' + formatMoney(lifetimeValue)"></p>
                    <p class="text-xs text-gray-500">Total lifetime value</p>
                </div>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-2xl border border-gray-200 bg-white">
            <div class="flex flex-col gap-3 border-b border-gray-100 p-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="relative">
                    <input type="text" x-model="search" @input.debounce.300ms="fetchCustomers()" placeholder="Search customers..."
                        class="w-full rounded-lg border border-gray-200 bg-white py-2 pl-10 pr-4 text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 sm:w-72" />
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <x-icons name="search" class="w-4.5 h-4.5" />
                    </span>
                </div>
                <select x-model="statusFilter" @change="fetchCustomers()"
                    class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-600 focus:border-indigo-500 focus:outline-none">
                    <option value="">All statuses</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
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
                        <template x-if="loading">
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">Loading customers...</td>
                            </tr>
                        </template>
                        <template x-if="!loading && customers.length === 0">
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">No customers found.</td>
                            </tr>
                        </template>
                        <template x-for="customer in customers" :key="customer.id">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-600" x-text="initials(customer.name)"></span>
                                        <div>
                                            <p class="font-medium text-gray-800" x-text="customer.name"></p>
                                            <p class="text-xs text-gray-400" x-text="customer.email"></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3.5 font-medium text-gray-700" x-text="customer.orders.length"></td>
                                <td class="px-6 py-3.5 font-medium text-gray-900" x-text="'$' + formatMoney(customer.spent)"></td>
                                <td class="px-6 py-3.5 text-gray-500" x-text="customer.joined"></td>
                                <td class="px-6 py-3.5">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold" :class="statusBadgeClass(customer.status)" x-text="statusLabel(customer.status)"></span>
                                </td>
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center justify-end gap-1">
                                        <button type="button" @click="openCustomer(customer)"
                                            class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold text-indigo-600 hover:bg-indigo-50">
                                            <x-icons name="eye" class="w-4 h-4" /> View
                                        </button>
                                        <button type="button" @click="openCustomer(customer); startEdit()"
                                            class="rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-700" title="Edit">
                                            <x-icons name="edit" class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Customer detail modal --}}
        <template x-if="selected">
            <div class="fixed inset-0 z-50 flex items-end justify-center sm:items-center">
                <div class="absolute inset-0 bg-gray-900/50" @click="closeModal()"></div>
                <div class="relative z-10 max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-t-2xl bg-white sm:rounded-2xl">
                    <div class="sticky top-0 z-10 flex items-center justify-between border-b border-gray-100 bg-white px-6 py-4">
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-full bg-indigo-600 font-bold text-white" x-text="initials(selected.name)"></span>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900" x-text="selected.name"></h3>
                                <p class="text-xs text-gray-400" x-text="selected.email"></p>
                            </div>
                        </div>
                        <button type="button" @click="closeModal()" class="rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-700">
                            <x-icons name="x" class="w-5 h-5" />
                        </button>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-3 gap-3">
                            <div class="rounded-xl bg-gray-50 p-4 text-center">
                                <p class="text-xl font-bold text-gray-900" x-text="selected.orders.length"></p>
                                <p class="text-xs text-gray-500">Orders</p>
                            </div>
                            <div class="rounded-xl bg-gray-50 p-4 text-center">
                                <p class="text-xl font-bold text-gray-900" x-text="'$' + formatMoney(selected.spent)"></p>
                                <p class="text-xs text-gray-500">Total spent</p>
                            </div>
                            <div class="rounded-xl bg-gray-50 p-4 text-center">
                                <p class="text-xs text-gray-500">Member since</p>
                                <p class="mt-1 text-sm font-semibold text-gray-800" x-text="selected.joined"></p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <div class="flex items-center justify-between">
                                <h4 class="text-xs font-semibold uppercase tracking-wide text-gray-400">Contact details</h4>
                                <button type="button" x-show="!editMode" @click="startEdit()"
                                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:underline">
                                    <x-icons name="edit" class="w-3.5 h-3.5" /> Edit
                                </button>
                            </div>

                            <div x-show="!editMode" class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <div class="rounded-xl bg-gray-50 p-4">
                                    <p class="text-xs text-gray-500">Email</p>
                                    <p class="mt-1 break-all text-sm font-semibold text-gray-800" x-text="selected.email"></p>
                                </div>
                                <div class="rounded-xl bg-gray-50 p-4">
                                    <p class="text-xs text-gray-500">Phone</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-800" x-text="selected.phone || '—'"></p>
                                </div>
                            </div>

                            <div x-show="editMode" class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <label class="block">
                                    <span class="text-xs text-gray-500">Name</span>
                                    <input type="text" x-model="form.name"
                                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" />
                                </label>
                                <label class="block">
                                    <span class="text-xs text-gray-500">Phone</span>
                                    <input type="text" x-model="form.phone"
                                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" />
                                </label>
                                <div class="flex justify-end gap-2 sm:col-span-2">
                                    <button type="button" @click="cancelEdit()"
                                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</button>
                                    <button type="button" @click="saveEdit()"
                                        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Save</button>
                                </div>
                            </div>
                        </div>

                        <h4 class="mt-6 text-xs font-semibold uppercase tracking-wide text-gray-400">Purchase history</h4>
                        <template x-if="selected.orders.length === 0">
                            <p class="mt-3 rounded-xl border border-dashed border-gray-200 p-4 text-center text-sm text-gray-400">No orders yet.</p>
                        </template>
                        <template x-for="order in selected.orders" :key="order.order_number">
                            <div class="mt-2 flex items-center gap-3 rounded-xl border border-gray-100 p-4">
                                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                                    <x-icons name="receipt" class="w-5 h-5" />
                                </span>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="order.order_number"></p>
                                    <p class="text-xs text-gray-400" x-text="order.date + ' · ' + order.items + ' item' + (order.items === 1 ? '' : 's')"></p>
                                </div>
                                <p class="text-sm font-bold text-gray-900" x-text="'$' + formatMoney(order.total)"></p>
                            </div>
                        </template>

                        <div class="mt-6 flex flex-col gap-2 sm:flex-row sm:justify-end">
                            <a :href="'mailto:' + selected.email"
                                class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                <x-icons name="mail" class="w-4 h-4" /> Send Email
                            </a>
                            @if (auth()->user()->role === 'admin')
                                <button type="button" @click="addToStaff(selected)"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    <x-icons name="user-plus" class="w-4 h-4" /> Add as Staff
                                </button>
                            @endif
                            <button type="button" @click="toggleStatus(selected)"
                                class="inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm font-semibold text-white"
                                :class="selected.status === 'active' ? 'bg-red-600 hover:bg-red-700' : 'bg-emerald-600 hover:bg-emerald-700'">
                                <x-icons name="shield-check" class="w-4 h-4" />
                                <span x-text="selected.status === 'active' ? 'Deactivate' : 'Activate'"></span>
                            </button>
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
                customers: @js($customers),
                search: '',
                statusFilter: '',
                selected: null,
                editMode: false,
                form: { name: '', phone: '' },
                loading: false,
                request: null,

                get totalCustomers() {
                    return this.customers.length;
                },
                get activeCustomers() {
                    return this.customers.filter(c => c.status === 'active').length;
                },
                get lifetimeValue() {
                    return this.customers.reduce((sum, c) => sum + (Number(c.spent) || 0), 0);
                },

                initials(name) {
                    return (name || '').split(' ').filter(Boolean).map(w => w[0].toUpperCase()).join('').slice(0, 2);
                },
                formatMoney(value) {
                    return (Number(value) || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                },
                statusBadgeClass(status) {
                    return status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600';
                },
                statusLabel(status) {
                    return status ? status.charAt(0).toUpperCase() + status.slice(1) : '—';
                },

                async fetchCustomers() {
                    if (this.request) this.request.abort();
                    this.request = new AbortController();
                    this.loading = true;
                    try {
                        const params = new URLSearchParams();
                        if (this.search) params.set('s', this.search);
                        if (this.statusFilter) params.set('status', this.statusFilter);
                        const response = await fetch("{{ route('controlpanel.customers.index') }}?" + params.toString(), {
                            headers: { 'Accept': 'application/json' },
                            signal: this.request.signal,
                        });
                        const data = await response.json();
                        if (!response.ok) throw new Error(data.message || 'Failed to load customers.');
                        this.customers = data.customers;
                    } catch (error) {
                        if (error.name !== 'AbortError') Alpine.store('toasts').notify(error.message, 'error');
                    } finally {
                        this.loading = false;
                    }
                },

                openCustomer(customer) {
                    this.selected = { ...customer };
                    this.editMode = false;
                },
                closeModal() {
                    this.selected = null;
                    this.editMode = false;
                },
                startEdit() {
                    this.form = { name: this.selected.name, phone: this.selected.phone || '' };
                    this.editMode = true;
                },
                cancelEdit() {
                    this.editMode = false;
                },
                async saveEdit() {
                    await this.updateCustomer(this.selected, {
                        name: this.form.name,
                        phone: this.form.phone,
                        status: this.selected.status,
                    });
                    this.editMode = false;
                },
                async toggleStatus(customer) {
                    await this.updateCustomer(customer, {
                        name: customer.name,
                        phone: customer.phone || '',
                        status: customer.status === 'active' ? 'inactive' : 'active',
                    });
                },
                async updateCustomer(customer, payload) {
                    try {
                        const response = await fetch("{{ route('controlpanel.customers.update', ':id') }}".replace(':id', customer.id), {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json' },
                            body: JSON.stringify(payload),
                        });
                        const data = await response.json();
                        if (!response.ok) throw new Error(data.message || (data.errors ? Object.values(data.errors).flat().join(', ') : 'Failed to update customer.'));
                        this.replaceCustomer(data.customer);
                        Alpine.store('toasts').notify(data.message, 'success');
                    } catch (error) {
                        Alpine.store('toasts').notify(error.message, 'error');
                    }
                },
                replaceCustomer(updated) {
                    const index = this.customers.findIndex(c => c.id === updated.id);
                    if (index !== -1) this.customers.splice(index, 1, updated);
                    if (this.selected && this.selected.id === updated.id) this.selected = { ...updated };
                },
                async addToStaff(customer) {
                    try {
                        const response = await fetch("{{ route('controlpanel.settings.role-change') }}", {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json' },
                            body: JSON.stringify({ email: customer.email, role: 'staff' }),
                        });
                        const data = await response.json();
                        if (!response.ok) throw new Error(data.message || 'Failed to add customer as staff.');
                        this.customers = this.customers.filter(c => c.id !== customer.id);
                        this.closeModal();
                        Alpine.store('toasts').notify(data.message, 'success');
                    } catch (error) {
                        Alpine.store('toasts').notify(error.message, 'error');
                    }
                },
            }));
        });
    </script>
@endpush
@endsection
