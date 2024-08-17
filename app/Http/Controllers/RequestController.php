<?php
// app/Http/Controllers/RequestController.php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
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

        // Get or create a pending cart for the user
        $cart = Cart::firstOrCreate(['user_id' => Auth::id(), 'status' => 'pending']);

        // Check if the item already exists in the cart
        $existingItem = CartItem::where('cart_id', $cart->id)
                                ->where('item_id', $validatedData['item_id'])
                                ->first();

        if ($existingItem) {
            // Update the quantity if item already exists in the cart
            $existingItem->update([
                'quantity' => $existingItem->quantity + $validatedData['quantity'],
                'size' => $validatedData['size'],
            ]);
        } else {
            // Create a new cart item
            CartItem::create([
                'cart_id' => $cart->id,
                'item_id' => $validatedData['item_id'],
                'quantity' => $validatedData['quantity'],
                'size' => $validatedData['size'],
            ]);
        }

        return redirect()->route('requests.index')->with('success', 'Item added to cart!');
    }

    // Show the cart
    public function showCart()
    {
        $cart = Cart::where('user_id', Auth::id())->where('status', 'pending')->first();

        if (!$cart) {
            $cart = new Cart(); // Create an empty cart if none exists
        }

        return view('requests.cart', compact('cart'));
    }

    // Confirm and approve the cart
    public function approveCart()
    {
        $cart = Cart::where('user_id', Auth::id())->where('status', 'pending')->first();

        if (!$cart) {
            return redirect()->route('requests.cart')->with('error', 'No cart found. Please add items to your cart first.');
        }

        // Define the approval steps
        $approvalSteps = [
            'pending',
            'reviewed',
            'approved',
            'processed',
            'shipped',
            'delivered',
            'completed'
        ];

        // Get the current status index
        $currentStatusIndex = array_search($cart->status, $approvalSteps);

        // Check if we can advance to the next step
        if ($currentStatusIndex !== false && $currentStatusIndex < count($approvalSteps) - 1) {
            // Advance to the next step
            $cart->status = $approvalSteps[$currentStatusIndex + 1];
            $cart->save();

            // Redirect based on the new status
            return redirect()->route('requests.cart')->with('success', 'Cart status updated to: ' . ucfirst($cart->status));
        }

        return redirect()->route('requests.cart')->with('info', 'Cart has already reached the final approval step.');
    }

    // Remove an item from the cart
    public function removeItem(CartItem $cartItem)
    {
        $cartItem->delete();
        return redirect()->route('requests.cart')->with('success', 'Item removed from cart!');
    }

    // Show the edit form for a cart item
    public function editItem(CartItem $cartItem)
    {
        return view('requests.edit', compact('cartItem'));
    }

    // Update the cart item
    public function updateItem(Request $request, CartItem $cartItem)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
            'size' => 'required|string|max:50',
        ]);

        $cartItem->update($validatedData);

        return redirect()->route('requests.cart')->with('success', 'Item updated successfully!');
    }

    // Show all requests for the authenticated user
    public function followRequest()
    {
        $carts = Cart::where('user_id', Auth::id())
            ->where('status', '!=', 'completed') // Only show active requests
            ->get();

        return view('requests.follow', compact('carts'));
    }

    // Show the history of completed requests for the authenticated user
    public function history()
    {
        $carts = Cart::where('user_id', Auth::id())
            ->where('status', 'completed') // Only show completed requests
            ->get();

        return view('requests.history', compact('carts'));
    }

    // Show all requests with search and filter for admin
    public function requestHistory(Request $request)
    {
        $query = Cart::query();

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('id', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('user', function($q) use ($searchTerm) {
                      $q->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('email', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        // Filter functionality
        if ($request->has('status') && $request->input('status') != 'all') {
            $query->where('status', $request->input('status'));
        }

        // Pagination
        $carts = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('requests.admin.history', compact('carts'));
    }



    public function showRequestProgress($cartId)
    {
        // Retrieve the cart for the specific ID, ensure it's the user's cart
        $cart = Cart::where('id', $cartId)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        // Define the approval steps
        $approvalSteps = [
            'pending',
            'reviewed',
            'approved',
            'processed',
            'shipped',
            'delivered',
            'completed'
        ];

        // Find the current step in the approval process
        $currentStep = array_search($cart->status, $approvalSteps);

        // Retrieve items associated with the cart
        $cartItems = $cart->items;

        // Return the view with the progress information
        return view('requests.progress', compact('cart', 'approvalSteps', 'currentStep', 'cartItems'));
    }



    // Show all requests for the admin
    public function adminIndex()
    {
        $carts = Cart::with('items')->get(); // Load all carts with items
        return view('requests.admin.index', compact('carts'));
    }

    // Show detailed information about a specific request
    public function show($cartId)
    {
        $cart = Cart::where('id', $cartId)
                    ->with('items') // Eager load items
                    ->firstOrFail();

        return view('requests.admin.show', compact('cart'));
    }


    
}
