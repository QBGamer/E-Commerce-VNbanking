@extends('admin.layouts.app', ['title' => 'Settings'])

@section('content')
    <div x-data="settingsPanel()">
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="space-y-6 xl:col-span-2">
                {{-- Store information --}}
                <section class="rounded-2xl border border-gray-200 bg-white p-6">
                    <h2 class="text-lg font-bold text-gray-900">Store Information</h2>
                    <p class="text-sm text-gray-500">Update your store name, logo and contact details.</p>

                    <div class="mt-6 flex items-center gap-4">
                        <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-600 text-white">
                            <x-icons name="shopping-bag" class="w-8 h-8" />
                        </span>
                        <div>
                            <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                <x-icons name="image" class="w-4 h-4" /> Upload Logo
                            </button>
                            <p class="mt-1 text-xs text-gray-400">PNG or JPG, up to 2MB</p>
                        </div>
                    </div>

                    <form class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <x-form-input name="store_name" label="Store name" :value="$storeInfo['name']" required />
                        <x-form-input name="tagline" label="Tagline" :value="$storeInfo['tagline']" />
                        <x-form-input name="email" label="Support email" type="email" icon="mail" :value="$storeInfo['email']" required />
                        <x-form-input name="phone" label="Phone" icon="phone" :value="$storeInfo['phone']" required />
                        <div class="sm:col-span-2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700">Store address</label>
                            <textarea rows="2" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ $storeInfo['address'] }}</textarea>
                        </div>
                        <div class="sm:col-span-2">
                            <x-button type="submit" icon="check">Save Changes</x-button>
                        </div>
                    </form>
                </section>

                {{-- Payment methods --}}
                <section class="rounded-2xl border border-gray-200 bg-white p-6">
                    <h2 class="text-lg font-bold text-gray-900">Payment Methods</h2>
                    <p class="text-sm text-gray-500">Enable the payment gateways customers can use at checkout.</p>

                    <ul class="mt-5 divide-y divide-gray-100">
                        @php
                            $payments = [
                                ['key' => 'card', 'label' => 'Credit / Debit Card', 'desc' => 'Visa, Mastercard, JCB via Stripe gateway', 'icon' => 'credit-card'],
                                ['key' => 'vnpay', 'label' => 'VNPay QR', 'desc' => 'Local bank transfer for Vietnamese banks', 'icon' => 'shield-check'],
                                ['key' => 'paypal', 'label' => 'PayPal', 'desc' => 'Standard PayPal checkout flow', 'icon' => 'check-circle'],
                                ['key' => 'cod', 'label' => 'Cash on Delivery', 'desc' => 'Collect payment when order is delivered', 'icon' => 'dollar-sign'],
                                ['key' => 'momo', 'label' => 'MoMo Wallet', 'desc' => 'Vietnamese e-wallet integration', 'icon' => 'zap'],
                            ];
                        @endphp
                        @foreach ($payments as $method)
                            <li class="flex items-center gap-4 py-4">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-500">
                                    <x-icons :name="$method['icon']" class="w-5 h-5" />
                                </span>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-800">{{ $method['label'] }}</p>
                                    <p class="text-xs text-gray-400">{{ $method['desc'] }}</p>
                                </div>
                                <button type="button" @click="togglePayment('{{ $method['key'] }}')"
                                    class="relative h-6 w-11 rounded-full transition-colors"
                                    :class="payments['{{ $method['key'] }}'] ? 'bg-indigo-600' : 'bg-gray-300'"
                                    role="switch" :aria-checked="payments['{{ $method['key'] }}']">
                                    <span class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-all"
                                        :class="payments['{{ $method['key'] }}'] ? 'left-[1.375rem]' : 'left-0.5'"></span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </section>

                {{-- Shipping methods --}}
                <section class="rounded-2xl border border-gray-200 bg-white p-6">
                    <h2 class="text-lg font-bold text-gray-900">Shipping Methods</h2>
                    <p class="text-sm text-gray-500">Configure delivery options and their fees.</p>

                    <ul class="mt-5 divide-y divide-gray-100">
                        @php
                            $shipping = [
                                ['key' => 'standard', 'label' => 'Standard (3-5 business days)', 'fee' => 9.99],
                                ['key' => 'express', 'label' => 'Express (1-2 business days)', 'fee' => 19.99],
                                ['key' => 'free', 'label' => 'Free (orders over $50)', 'fee' => 0],
                                ['key' => 'pickup', 'label' => 'Store Pickup', 'fee' => 0],
                            ];
                        @endphp
                        @foreach ($shipping as $method)
                            <li class="flex items-center gap-4 py-4">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-500">
                                    <x-icons name="truck" class="w-5 h-5" />
                                </span>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-800">{{ $method['label'] }}</p>
                                    <p class="text-xs text-gray-400">{{ $method['fee'] == 0 ? 'Free' : '$' . number_format($method['fee'], 2) }} per order</p>
                                </div>
                                <button type="button" @click="toggleShipping('{{ $method['key'] }}')"
                                    class="relative h-6 w-11 rounded-full transition-colors"
                                    :class="shipping['{{ $method['key'] }}'] ? 'bg-indigo-600' : 'bg-gray-300'"
                                    role="switch" :aria-checked="shipping['{{ $method['key'] }}']">
                                    <span class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-all"
                                        :class="shipping['{{ $method['key'] }}'] ? 'left-[1.375rem]' : 'left-0.5'"></span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </section>
            </div>

            {{-- Side column --}}
            <div class="space-y-6">
                {{-- Staff accounts --}}
                <section class="rounded-2xl border border-gray-200 bg-white">
                    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                        <h2 class="font-bold text-gray-900">Staff & Admin Accounts</h2>
                        <x-button size="sm" icon="plus" @click="showStaffForm = !showStaffForm">Add</x-button>
                    </div>

                    <div x-cloak x-show="showStaffForm" class="border-b border-gray-100 p-4">
                        <form class="grid grid-cols-1 gap-3">
                            <x-form-input name="s_name" label="Full name" placeholder="Staff name" />
                            <x-form-input name="s_email" label="Email" type="email" placeholder="staff@shophub.demo" />
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700">Role</label>
                                <select name="s_role" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                    <option>Staff</option>
                                    <option>Manager</option>
                                    <option>Admin</option>
                                </select>
                            </div>
                            <x-button type="submit" size="sm" icon="check">Send Invitation</x-button>
                        </form>
                    </div>

                    <ul class="divide-y divide-gray-100">
                        @php
                            $staff = [
                                ['name' => 'Admin Demo', 'email' => 'admin@shophub.demo', 'role' => 'Admin', 'color' => 'bg-indigo-600'],
                                ['name' => 'Minh Nguyen', 'email' => 'minh@shophub.demo', 'role' => 'Manager', 'color' => 'bg-emerald-600'],
                                ['name' => 'Lin Tran', 'email' => 'lin@shophub.demo', 'role' => 'Staff', 'color' => 'bg-amber-500'],
                                ['name' => 'Kim Vo', 'email' => 'kim@shophub.demo', 'role' => 'Staff', 'color' => 'bg-blue-600'],
                            ];
                        @endphp
                        @foreach ($staff as $member)
                            <li class="flex items-center gap-3 px-6 py-3.5">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-sm font-bold text-white {{ $member['color'] }}">
                                    {{ collect(explode(' ', $member['name']))->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-gray-800">{{ $member['name'] }}</p>
                                    <p class="truncate text-xs text-gray-400">{{ $member['email'] }}</p>
                                </div>
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $member['role'] === 'Admin' ? 'bg-indigo-100 text-indigo-700' : ($member['role'] === 'Manager' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600') }}">
                                    {{ $member['role'] }}
                                </span>
                                <form action="#" class="flex">
                                    <button type="button" class="rounded-lg p-2 text-gray-400 hover:bg-red-50 hover:text-red-600" title="Remove">
                                        <x-icons name="trash" class="w-4 h-4" />
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </section>

                {{-- Quick settings --}}
                <section class="rounded-2xl border border-gray-200 bg-white p-6 space-y-5">
                    <div>
                        <h2 class="font-bold text-gray-900">General Preferences</h2>
                    </div>
                    @php
                        $prefs = [
                            ['key' => 'low_stock_alert', 'label' => 'Low stock email alerts', 'desc' => 'Notify when stock drops below 10 units'],
                            ['key' => 'auto_return', 'label' => 'Auto-approve returns', 'desc' => 'Approve return requests automatically'],
                            ['key' => 'new_order_notify', 'label' => 'New order notifications', 'desc' => 'Email staff when a new order is placed'],
                        ];
                    @endphp
                    <div class="space-y-4">
                        @foreach ($prefs as $pref)
                            <label class="flex cursor-pointer items-start gap-3">
                                <input type="checkbox" x-model="prefs['{{ $pref['key'] }}']" class="mt-0.5 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                <span>
                                    <span class="block text-sm font-medium text-gray-800">{{ $pref['label'] }}</span>
                                    <span class="block text-xs text-gray-400">{{ $pref['desc'] }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </section>

                {{-- Danger zone --}}
                <section class="rounded-2xl border border-red-200 bg-red-50/50 p-6">
                    <h2 class="font-bold text-red-700">Danger Zone</h2>
                    <p class="mt-1 text-sm text-red-600/80">Irreversible actions that affect your entire store.</p>
                    <div class="mt-4 flex flex-col gap-2">
                        <x-button variant="outline" size="md" icon="refresh" class="!border-red-300 !text-red-700 hover:!bg-red-50">
                            Reset Demo Data
                        </x-button>
                        <x-button variant="danger" size="md" icon="trash">
                            Delete Store
                        </x-button>
                    </div>
                </section>
            </div>
        </div>
    </div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('settingsPanel', () => ({
                payments: { card: true, vnpay: true, paypal: true, cod: true, momo: false },
                shipping: { standard: true, express: true, free: true, pickup: false },
                prefs: { low_stock_alert: true, auto_return: false, new_order_notify: true },
                showStaffForm: false,

                togglePayment(key) {
                    this.payments[key] = !this.payments[key];
                },
                toggleShipping(key) {
                    this.shipping[key] = !this.shipping[key];
                },
            }));
        });
    </script>
@endpush
@endsection