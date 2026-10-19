@extends('controlpanel.layouts.app', ['title' => 'Settings'])

@section('content')
    <div id="settings-root" x-data="settingsPanel()">
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="space-y-6 xl:col-span-2">
                {{-- Store information --}}
                <section class="rounded-2xl border border-gray-200 bg-white p-6">
                    <h2 class="text-lg font-bold text-gray-900">Store Information</h2>
                    <p class="text-sm text-gray-500">Update your store name, logo and contact details.</p>
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
                            <label class="mb-1.5 block text-sm font-medium text-gray-700">Icon</label>
                            <div class="flex items-center gap-4">
                                <img x-show="faviconPreviewSrc" :src="faviconPreviewSrc" class="h-10 w-10 shrink-0 rounded-lg border border-gray-200 object-cover" alt="Favicon preview">
                                <span x-show="!faviconPreviewSrc" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-dashed border-gray-300 bg-gray-50 text-gray-400">
                                    <x-icons name="image" class="w-5 h-5" />
                                </span>
                                <div>
                                    <input
                                        type="file"
                                        accept="image/png,image/jpeg,image/webp"
                                        @change="uploadFavicon($event.target)"
                                        class="block w-full text-sm text-gray-500 file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-indigo-600 hover:file:bg-indigo-100"
                                    >
                                    <p class="mt-1 text-xs text-gray-400">PNG, JPG or WebP &mdash; auto-converted to ICO (16/32/48/64/128/256px)</p>
                                </div>
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <x-button type="button" icon="check" @click="saveSettings">Save Changes</x-button>
                        </div>
                    </form>
                </section>

                {{-- Payment methods --}}
                {{-- <section class="rounded-2xl border border-gray-200 bg-white p-6">
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
                </section> --}}

                {{-- Shipping methods --}}
                {{-- <section class="rounded-2xl border border-gray-200 bg-white p-6">
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
                </section> --}}
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
                            <div x-data="{
                                    open: false, search: '', selected: '',
                                    options: @js(collect($users ?? [])->pluck('email')->values()),
                                    get filtered() {
                                        const q = this.search.trim().toLowerCase();
                                        return q ? this.options.filter(e => e.toLowerCase().includes(q)) : this.options;
                                    },
                                    toggle() { this.open = !this.open; if (this.open) this.$nextTick(() => this.$refs.searchInput?.focus()); },
                                    choose(email) { this.selected = email; this.open = false; this.search = ''; },
                                }">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700">Email</label>
                                <div class="relative" @click.outside="open = false" @keydown.escape="open = false">
                                    <button type="button" @click="toggle()"
                                        class="flex w-full items-center justify-between rounded-lg border border-gray-300 bg-white px-4 py-2 text-left text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                        <span :class="selected ? 'text-gray-900' : 'text-gray-400'" x-text="selected || 'Select a user email...'"></span>
                                        <x-icons name="chevron-down" class="w-4 h-4 text-gray-400" />
                                    </button>
                                    <div x-cloak x-show="open" x-transition.opacity.duration.100ms
                                        class="absolute z-20 mt-1 w-full overflow-hidden rounded-lg border border-gray-200 bg-white shadow-lg">
                                        <div class="relative border-b border-gray-100">
                                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                                <x-icons name="search" class="w-4 h-4" />
                                            </span>
                                            <input x-model="search" x-ref="searchInput" type="text" placeholder="Search email..."
                                                class="w-full border-0 py-2 pl-9 pr-3 text-sm focus:outline-none focus:ring-0">
                                        </div>
                                        <ul class="max-h-56 overflow-y-auto py-1">
                                            <template x-for="email in filtered" :key="email">
                                                <li>
                                                    <button type="button" @click="choose(email)"
                                                        class="block w-full truncate px-4 py-2 text-left text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700"
                                                        x-text="email"></button>
                                                </li>
                                            </template>
                                            <li x-show="filtered.length === 0" class="px-4 py-2 text-sm text-gray-400">No matches</li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="s_email" :value="selected">
                                </div>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700">Role</label>
                                <select name="s_role" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                    <option value="staff">Staff</option>
                                    <option value="manager">Manager</option>
                                    {{-- <option value="admin">Admin</option> --}}
                                </select>
                            </div>
                            <x-button type="button" size="sm" @click="submitRoleChange()" icon="check">Change Role</x-button>
                        </form>
                    </div>

                    <ul class="divide-y divide-gray-100">
                        <template x-for="user in users" :key="user.id">
                            <li class="flex items-center gap-3 px-6 py-3.5">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-sm font-bold text-white" :class="avatarClass(user.id)" x-text="initials(user.name)"></span>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-gray-800" x-text="user.name"></p>
                                    <p class="truncate text-xs text-gray-400" x-text="user.email"></p>
                                </div>
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold" :class="roleBadgeClass(user.role)" x-text="roleLabel(user.role)"></span>
                                <form action="#" class="flex">
                                    <button type="button" class="rounded-lg p-2 text-gray-400 hover:bg-red-50 hover:text-red-600" title="Remove" @click="roleChange(user.email)"    >
                                        <x-icons name="trash" class="w-4 h-4" />
                                    </button>
                                </form>
                            </li>
                        </template>
                        <li x-show="users.length === 0" class="px-6 py-8 text-center text-sm text-gray-400">No staff or admin accounts yet.</li>
                    </ul>
                </section>

                {{-- Quick settings --}}
                {{-- <section class="rounded-2xl border border-gray-200 bg-white p-6 space-y-5">
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
                </section> --}}

                {{-- Danger zone --}}
                {{-- <section class="rounded-2xl border border-red-200 bg-red-50/50 p-6">
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
                </section> --}}
            </div>
        </div>
    </div>

@push('scripts')
    <script>
        function canvasToPngBlob(img, size) {
            return new Promise(resolve => {
                const canvas = document.createElement('canvas');
                canvas.width = size;
                canvas.height = size;
                const ctx = canvas.getContext('2d');
                const dim = Math.min(img.width, img.height);
                const sx = (img.width - dim) / 2;
                const sy = (img.height - dim) / 2;
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = 'high';
                ctx.drawImage(img, sx, sy, dim, dim, 0, 0, size, size);
                canvas.toBlob(resolve, 'image/png');
            });
        }

        function imageToPngBlobs(file) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                img.onload = async () => resolve(await Promise.all([16, 32, 48, 64, 128, 256].map(size => canvasToPngBlob(img, size))));
                img.onerror = reject;
                img.src = URL.createObjectURL(file);
            });
        }

        async function saveSettings() {
            try {
                const fd = new FormData();
                fd.append('store_name', document.querySelector('[name="store_name"]').value);
                fd.append('tagline', document.querySelector('[name="tagline"]').value);
                fd.append('email', document.querySelector('[name="email"]').value);
                fd.append('phone', document.querySelector('[name="phone"]').value);
                fd.append('address', document.querySelector('textarea').value);
                const panel = Alpine.$data(document.querySelector('#settings-root'));
                if (panel.faviconPngs.length) {
                    panel.faviconPngs.forEach(png => fd.append('image[]', png, 'favicon.png'));
                }

                const response = await fetch("{{ route('controlpanel.settings.update') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: fd
                });
                const data = await response.json();
                if (!response.ok) {
                    const message = data.message || (data.errors ? Object.values(data.errors).flat().join(', ') : 'Failed to save store information.');
                    throw new Error(message);
                }
                Alpine.store('toasts').notify(data.message, 'success');
                document.title = 'Settings · ' + document.querySelector('[name="store_name"]').value + ' Control Panel';
                if (data.favicon_updated && data.url) {
                    panel.faviconPreviewSrc = data.url;
                    panel.faviconPngs = [];
                }
            } catch (error) {
                Alpine.store('toasts').notify(error.message, 'error');
            }
        }


        document.addEventListener('alpine:init', () => {
            Alpine.data('settingsPanel', () => ({
                faviconPngs: [],
                faviconPreviewSrc: @js($storeInfo['icon'] ?? null),
                users: @js(collect($users ?? [])->filter(fn ($u) => in_array($u->role, ['staff', 'manager', 'admin']))->map(fn ($u) => ['id' => $u->id, 'name' => $u->name, 'email' => $u->email, 'role' => $u->role])->values()),
                payments: { card: true, vnpay: true, paypal: true, cod: true, momo: false },
                shipping: { standard: true, express: true, free: true, pickup: false },
                prefs: { low_stock_alert: true, auto_return: false, new_order_notify: true },
                showStaffForm: false,

                initials(name) {
                    return (name || '').split(' ').filter(Boolean).map(w => w[0].toUpperCase()).join('').slice(0, 2);
                },
                avatarClass(id) {
                    const palette = ['bg-indigo-600', 'bg-emerald-600', 'bg-amber-500', 'bg-blue-600', 'bg-rose-500', 'bg-violet-600'];
                    return palette[(Number(id) || 0) % palette.length];
                },
                roleBadgeClass(role) {
                    return {
                        admin: 'bg-indigo-100 text-indigo-700',
                        manager: 'bg-emerald-100 text-emerald-700',
                        staff: 'bg-amber-100 text-amber-700',
                        customer: 'bg-gray-100 text-gray-600',
                    }[role] || 'bg-gray-100 text-gray-600';
                },
                roleLabel(role) {
                    return role ? role.charAt(0).toUpperCase() + role.slice(1) : '—';
                },
                submitRoleChange() {
                    const email = document.querySelector('[name="s_email"]').value;
                    const role = document.querySelector('[name="s_role"]').value;
                    return this.roleChange(email, role || null);
                },
                async roleChange(email, role = null) {
                    if (!email) {
                        Alpine.store('toasts').notify('Please select a user.', 'error');
                        return;
                    }
                    try {
                        const response = await fetch("{{ route('controlpanel.settings.role-change') }}", {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json' },
                            body: JSON.stringify({ email, role }),
                        });
                        const data = await response.json();
                        if (!response.ok) throw new Error(data.message || (data.errors ? Object.values(data.errors).flat().join(', ') : 'Failed to change user role.'));
                        if (role === null) {
                            this.users = this.users.filter(u => u.email !== email);      // gỡ khỏi staff -> customer
                        } else {
                            const index = this.users.findIndex(u => u.email === email);
                            if (index !== -1) this.users[index].role = data.user.role;
                            else this.users.push({ id: data.user.id, name: data.user.name, email: data.user.email, role: data.user.role });
                        }
                        Alpine.store('toasts').notify(data.message, 'success');
                    } catch (error) {
                        Alpine.store('toasts').notify(error.message, 'error');
                    }
                },
                async uploadFavicon(input) {
                    const file = input.files && input.files[0];
                    if (!file) return;
                    try {
                        const blobs = await imageToPngBlobs(file);
                        this.faviconPngs = blobs.filter(Boolean);
                        if (this.faviconPngs.length) {
                            this.faviconPreviewSrc = URL.createObjectURL(this.faviconPngs[0]);
                        }
                    } catch (error) {
                        Alpine.store('toasts').notify('Could not read the selected image.', 'error');
                    } finally {
                        input.value = '';
                    }
                },

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
