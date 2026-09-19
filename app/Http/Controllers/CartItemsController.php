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
}
