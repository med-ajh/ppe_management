<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ValueStream;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Display the cart and available options for the user
    public function index()
    {
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'pending'],
            ['status' => 'pending']
        );

        $cartItems = $cart->items;
        $valueStreams = ValueStream::all();
        $departments = Department::all();

        return view('cart.index', compact('cart', 'cartItems', 'valueStreams', 'departments'));
    }

    // Process the request and update the cart with additional information
    public function processRequest(Request $request)
    {
        $validatedData = $request->validate([
            'value_stream_id' => 'required|exists:value_streams,id',
            'department_id' => 'required|exists:departments,id',
            'cost_center' => 'required|string',
        ]);

        $cart = Cart::where('user_id', Auth::id())->where('status', 'pending')->firstOrFail();

        $cart->update([
            'value_stream_id' => $validatedData['value_stream_id'],
            'department_id' => $validatedData['department_id'],
            'cost_center' => $validatedData['cost_center'],
            'status' => 'confirmed', // or your desired status
        ]);

        return redirect()->route('requests.follow')->with('success', 'Request confirmed successfully!');
    }





    // Remove an item from the cart
    public function removeItem($cartItemId)
    {
        $cartItem = CartItem::where('id', $cartItemId)->firstOrFail();
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    // Edit an item in the cart
    public function editItem($itemId)
    {
        $cart = Cart::where('user_id', Auth::id())->where('status', 'pending')->firstOrFail();
        $cartItem = CartItem::where('cart_id', $cart->id)->where('item_id', $itemId)->firstOrFail();

        return view('cart.edit', compact('cartItem'));
    }

    // Update an item in the cart
    public function updateItem(Request $request, $itemId)
    {
        $validatedData = $request->validate([
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($itemId);

        $cartItem->update([
            'size' => $validatedData['size'],
            'quantity' => $validatedData['quantity'],
        ]);

        return redirect()->route('cart.index')->with('success', 'Item updated successfully.');
    }

    // Cancel the request and clear the cart
    public function cancelRequest()
    {
        $cart = Cart::where('user_id', Auth::id())->where('status', 'pending')->firstOrFail();
        $cart->items()->delete();

        return redirect()->route('requests.index')->with('success', 'Request cancelled and cart cleared.');
    }
}
