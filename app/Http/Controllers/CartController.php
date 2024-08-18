<?php
// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
    public function show()
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->with('items.item') // Eager load items with their associated item model
                    ->first();

        if (!$cart) {
            return response()->json(['items' => []]);
        }

        return response()->json(['items' => $cart->items]);
    }

    public function confirmRequests(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->with('items') // Eager load items
                    ->first();

        if ($cart) {
            if ($cart->items()->count() > 0) {
                // Update the cart status and clear the items
                $cart->status = 'pending'; // Or 'pending' if you don't want to change the status
                $cart->save();

                // Clear the cart items
                $cart->items()->delete();

                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => 'Cart is empty'], 400);
            }
        }

        return response()->json(['error' => 'Cart not found'], 404);
    }
}




?>
