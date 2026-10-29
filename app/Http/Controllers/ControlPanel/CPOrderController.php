<?php

namespace App\Http\Controllers\ConTrolPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class CPOrderController extends Controller
{
    public function index()
    {
        $orders_data = Order::with('user','products','products.images')->get();
        return view('controlpanel.orders', compact('orders_data'));
    }

    // public function update(Request $request, $id)
    // {
    //     $order = Order::findOrFail($id);
    //     $order->status = $request->input('status');
    //     $order->save();

    //     return redirect()->route('controlpanel.orders.index')->with('success', 'Order status updated successfully.');
    // }
}
