@extends('layouts.app', ['title' => 'My Account'])

@section('content')
@php
    $userInfo = [
        'name' => 'Jane Doe',
        'email' => 'jane.doe@example.com',
        'phone' => '+1 (555) 022-3344',
        'joined' => 'March 15, 2026',
    ];
@endphp

    <div class="border-b border-gray-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-1 text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
                <x-icons name="chevron-right" class="w-4 h-4" />
                <span class="font-medium text-gray-900">My Account</span>
            </nav>
            <div class="mt-4 flex items-center gap-4">
                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-600 text-xl font-bold text-white">JD</span>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Hi, {{ $userInfo['name'] }} 👋</h1>
                    <p class="text-sm text-gray-500">Member since {{ $userInfo['joined'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            {{-- Sidebar nav --}}
            <aside class="lg:col-span-1">
                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
                    <nav class="divide-y divide-gray-100 text-sm">
                        <a href="#profile" class="flex items-center gap-3 px-4 py-3.5 font-semibold text-indigo-600">
                            <x-icons name="user" class="w-5 h-5" /> Profile
                        </a>
                        <a href="{{ route('order-history') }}" class="flex items-center gap-3 px-4 py-3.5 text-gray-700 hover:bg-gray-50">
                            <x-icons name="package" class="w-5 h-5" /> Order History
                            <span class="ml-auto rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-600">4</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3.5 text-gray-700 hover:bg-gray-50">
                            <x-icons name="heart" class="w-5 h-5" /> Wishlist
                        </a>
                        <a href="#password" class="flex items-center gap-3 px-4 py-3.5 text-gray-700 hover:bg-gray-50">
                            <x-icons name="lock" class="w-5 h-5" /> Security
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3.5 text-red-600 hover:bg-red-50">
                            <x-icons name="logout" class="w-5 h-5" /> Sign Out
                        </a>
                    </nav>
                </div>

                <div class="mt-6 rounded-2xl border border-indigo-100 bg-indigo-50 p-5">
                    <div class="flex items-center gap-2 text-indigo-700">
                        <x-icons name="tag" class="w-5 h-5" />
                        <p class="font-semibold">Member benefits</p>
                    </div>
                    <ul class="mt-3 space-y-2 text-sm text-indigo-900/80">
                        <li>· Free shipping on orders over $50</li>
                        <li>· Early access to flash sales</li>
                        <li>· Points on every purchase</li>
                    </ul>
                </div>
            </aside>

            {{-- Main content --}}
            <div class="lg:col-span-2">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="rounded-2xl border border-gray-200 bg-white p-6">
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-gray-500">
                                <x-icons name="package" class="w-5 h-5" />
                            </span>
                            <div>
                                <p class="text-2xl font-bold text-gray-900">4</p>
                                <p class="text-xs text-gray-500">Total Orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-gray-200 bg-white p-6">
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                                <x-icons name="dollar-sign" class="w-5 h-5" />
                            </span>
                            <div>
                                <p class="text-2xl font-bold text-gray-900">$508.44</p>
                                <p class="text-xs text-gray-500">Lifetime Spend</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Recent orders --}}
                <div class="mt-6 overflow-hidden rounded-2xl border border-gray-200 bg-white">
                    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                        <h2 class="font-semibold text-gray-900">Recent Orders</h2>
                        <a href="{{ route('order-history') }}" class="text-sm font-semibold text-indigo-600 hover:underline">View all</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-400">
                                <tr>
                                    <th class="px-6 py-3 font-medium">Order</th>
                                    <th class="px-6 py-3 font-medium">Date</th>
                                    <th class="px-6 py-3 font-medium">Total</th>
                                    <th class="px-6 py-3 font-medium">Status</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach (array_slice($orders, 0, 3) as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-3.5 font-semibold text-indigo-600">{{ $order['id'] }}</td>
                                        <td class="px-6 py-3.5 text-gray-600">{{ \Carbon\Carbon::parse($order['date'])->format('M d, Y') }}</td>
                                        <td class="px-6 py-3.5 font-medium text-gray-900">${{ number_format($order['total'], 2) }}</td>
                                        <td class="px-6 py-3.5">
                                            @php
                                                $statusColor = match ($order['status']) {
                                                    'Delivered' => 'bg-emerald-100 text-emerald-700',
                                                    'Shipped' => 'bg-blue-100 text-blue-700',
                                                    'Processing' => 'bg-amber-100 text-amber-700',
                                                    'Cancelled' => 'bg-red-100 text-red-700',
                                                    default => 'bg-gray-100 text-gray-600',
                                                };
                                            @endphp
                                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusColor }}">{{ $order['status'] }}</span>
                                        </td>
                                        <td class="px-6 py-3.5 text-right">
                                            <a href="{{ route('order-history') }}" class="text-indigo-600 hover:text-indigo-800">
                                                <x-icons name="chevron-right" class="w-4 h-4" />
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Edit profile --}}
                <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-6" x-data="{ editing: false }">
                    <div class="flex items-center justify-between">
                        <h2 class="font-semibold text-gray-900">Profile Information</h2>
                        <x-button size="sm" variant="outline" icon="edit" @click="editing = !editing" x-text="editing ? 'Cancel' : 'Edit Profile'"></x-button>
                    </div>

                    <template x-if="!editing">
                        <dl class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="rounded-lg bg-gray-50 p-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Full name</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $userInfo['name'] }}</dd>
                            </div>
                            <div class="rounded-lg bg-gray-50 p-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Email address</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $userInfo['email'] }}</dd>
                            </div>
                            <div class="rounded-lg bg-gray-50 p-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Phone</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $userInfo['phone'] }}</dd>
                            </div>
                            <div class="rounded-lg bg-gray-50 p-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Member since</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $userInfo['joined'] }}</dd>
                            </div>
                        </dl>
                    </template>

                    <template x-if="editing">
                        <form class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-form-input name="name" label="Full name" :value="$userInfo['name']" required />
                            <x-form-input name="email" label="Email address" type="email" :value="$userInfo['email']" required />
                            <x-form-input name="phone" label="Phone" :value="$userInfo['phone']" />
                            <x-form-input name="birthday" label="Date of birth" type="date" value="1995-06-14" />
                            <div class="sm:col-span-2">
                                <x-button type="submit" icon="check" class="w-full sm:w-auto">Save Changes</x-button>
                            </div>
                        </form>
                    </template>
                </div>
            </div>
        </div>
    </div>
@endsection