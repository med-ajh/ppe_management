<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // Display a listing of the items.
    public function index(Request $request)
    {
        $search = $request->input('search');
        $items = Item::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10);

        return view('items.index', compact('items'));
    }

    // Show the form for creating a new item.
    public function create()
    {
        return view('items.create');
    }

    // Store a newly created item in storage.
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'size' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $item = new Item();
        $item->name = $request->name;
        $item->status = $request->status;
        $item->description = $request->description;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
            $item->image = $imagePath;
        }

        $item->save();

        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    // Display the specified item.
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    // Show the form for editing the specified item.
    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    // Update the specified item in storage.
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'size' => 'string|max:255|nullable',
            'status' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $item->name = $request->name;
        $item->status = $request->status;
        $item->description = $request->description;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
            $item->image = $imagePath;
        }

        $item->save();

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    // Remove the specified item from storage.
    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }
}
