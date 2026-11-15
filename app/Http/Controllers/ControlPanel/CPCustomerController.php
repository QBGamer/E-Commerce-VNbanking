<?php

namespace App\Http\Controllers\ControlPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CPCustomerController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            's' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
        ]);

        $query = User::with('orders.products');

        if ($request->filled('s')) {
            $search = $request->s;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $customers = $query->get()
            ->map(fn (User $user) => $this->presentCustomer($user))
            ->values();

        if ($request->expectsJson()) {
            return response()->json(['customers' => $customers]);
        }

        return view('controlpanel.customers', ['customers' => $customers]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        $customer = User::findOrFail($id);

        if ($customer->id === auth()->id() && $request->status !== $customer->status) {
            return response()->json(['message' => 'You cannot update your own status.'], 403);
        }

        $customer->update($request->only(['name', 'phone', 'status']));
        $customer->load('orders.products');

        return response()->json([
            'message' => 'Customer updated successfully.',
            'customer' => $this->presentCustomer($customer),
        ]);
    }

    private function presentCustomer(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'status' => $user->status,
            'joined' => optional($user->created_at)->format('Y-m-d'),
            'spent' => round((float) $user->orders->sum('total'), 2),
            'orders' => $user->orders
                ->sortByDesc('created_at')
                ->values()
                ->map(fn ($order) => [
                    'order_number' => $order->order_number,
                    'date' => optional($order->created_at)->format('Y-m-d'),
                    'items' => (int) $order->products->sum('pivot.quantity'),
                    'total' => round((float) $order->total, 2),
                ])->all(),
        ];
    }
}
