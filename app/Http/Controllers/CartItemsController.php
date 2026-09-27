<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItems;

class CartItemsController extends Controller
{
    //show
    //add
    //remove
    //update
    //delete

    public function index()
    {
        $cartItems = CartItems::with('product')->where('user_id', auth()->id())->get();
        return view('cart.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItems::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItems::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json(['message' => 'Product added to cart successfully.'], 200);
    }

    public function update(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItems::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        $cartItems = CartItems::with('product')->where('user_id', auth()->id())->get();
        $subtotal = $cartItems->sum(fn ($i) => $i->product->price * $i->quantity);
        $total = $subtotal; // Assuming no additional fees for simplicity

        return response()->json([
            'message' => 'Cart item updated successfully.',
            'subtotal' => number_format($subtotal, 2),
            'total' => number_format($total, 2),
            'count' => $cartItems->count(),
        ], 200);
    }

    public function destroy($id)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $cartItem = CartItems::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $cartItem->delete();

        $cartItems = CartItems::with('product')->where('user_id', auth()->id())->get();
        $subtotal = $cartItems->sum(fn ($i) => $i->product->price * $i->quantity);
        $total = $subtotal; // Assuming no additional fees for simplicity

        return response()->json([
            'message' => 'Cart item deleted successfully.',
            'subtotal' => number_format($subtotal, 2),
            'total' => number_format($total, 2),
            'count' => $cartItems->count(),
        ], 200);
    }
}
