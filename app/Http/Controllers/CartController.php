<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Department;
use App\Models\ValueStream;

class CartController extends Controller
{
    // Method to show the cart where user can choose value stream and department
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->with('items.item') // Eager load items with their associated item model
                    ->first();

        $departments = Department::all();
        $valueStreams = ValueStream::all();

        return view('cart.index', compact('cart', 'departments', 'valueStreams'));
    }

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

    // Method to handle cart completion and choosing department and value stream
    public function complete(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->first();

        if ($cart) {
            $cart->department_id = $request->department_id;
            $cart->value_stream_id = $request->value_stream_id;
            $cart->cost_center = Department::find($request->department_id)->cost_center;
            $cart->status = 'completed'; // Mark the cart as completed
            $cart->save();

            return redirect()->route('carts.index')->with('success', 'Request completed successfully.');
        }

        return redirect()->back()->with('error', 'Cart not found.');
    }

    // Method to delete an item from the cart
    public function deleteItem($itemId)
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->first();

        if ($cart) {
            $cart->items()->where('item_id', $itemId)->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Cart not found'], 404);
    }
}
?>
