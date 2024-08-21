<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\CartItem;
use App\Models\Department;
use App\Models\ValueStream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    // Show all items available for request
    public function index()
    {
        $items = Item::all();
        return view('requests.index', compact('items'));
    }

    // Store the request for an item in the cart
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|string|max:50',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => Auth::id(), 'status' => 'pending']);

        // Check if item with the same size already exists
        $existingItem = CartItem::where('cart_id', $cart->id)
                                ->where('item_id', $validatedData['item_id'])
                                ->where('size', $validatedData['size'])
                                ->first();

        if ($existingItem) {
            // If item with the same size already exists, update the quantity
            $existingItem->quantity += $validatedData['quantity'];
            $existingItem->save();
        } else {
            // Otherwise, create a new cart item entry
            CartItem::create([
                'cart_id' => $cart->id,
                'item_id' => $validatedData['item_id'],
                'quantity' => $validatedData['quantity'],
                'size' => $validatedData['size'],
            ]);
        }

        return redirect()->route('requests.index')->with('success', 'Item added to cart!');
    }

    public function followRequest()
    {
        $carts = Cart::where('user_id', Auth::id())
        ->where('status', '!=', 'pending')
        ->get();

        $valueStreams = ValueStream::all();
        $departments = Department::all();  // Fetch departments including their cost centers

        return view('requests.follow', [
            'carts' => $carts,
            'valueStreams' => $valueStreams,
            'departments' => $departments,
        ]);
    }

    // Show request history
    public function history()
    {
        $carts = Cart::where('user_id', Auth::id())
            ->where('status', 'Confirmed')
            ->get();

        return view('requests.history', compact('carts'));
    }

    // Show request progress
    public function showRequestProgress($cartId)
    {
        $cart = Cart::where('id', $cartId)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $approvalSteps = [
            'pending',
            'confirmed',
            'reviewed',
            'approved',
            'processed',
            'shipped',
            'delivered',
            'completed'
        ];

        $currentStep = array_search($cart->status, $approvalSteps);

        return view('requests.progress', [
            'cart' => $cart,
            'approvalSteps' => $approvalSteps,
            'currentStep' => $currentStep,
            'cartItems' => $cart->items
        ]);
    }

    // Show all requests for the admin
    public function adminIndex()
    {
        $carts = Cart::with('items')->get();
        return view('requests.admin.index', compact('carts'));
    }

    // Show details of a specific cart for the admin
    public function show($cartId)
    {
        $cart = Cart::where('id', $cartId)
                    ->with('items')
                    ->firstOrFail();

        return view('requests.admin.show', compact('cart'));
    }
}
