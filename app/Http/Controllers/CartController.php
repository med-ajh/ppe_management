<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Auth;

class CartController extends Controller
{
    // Add item to the cart
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string',
        ]);

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)
                    ->where('item_id', $validated['item_id'])
                    ->first();

        if ($cart) {
            // Update quantity if the item is already in the cart
            $cart->quantity += $validated['quantity'];
            $cart->size = $validated['size'];
            $cart->save();
        } else {
            // Create a new cart entry
            Cart::create([
                'user_id' => $user->id,
                'item_id' => $validated['item_id'],
                'quantity' => $validated['quantity'],
                'size' => $validated['size'],
            ]);
        }

        return redirect()->route('requests.create')->with('success', 'Item added to cart.');
    }
}
