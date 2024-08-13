<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class RequestController extends Controller
{
    // Display all items for making a request
    public function create()
    {
        $items = Item::all();
        return view('requests.create', compact('items'));
    }

    // Display item details for selection
    public function showItemDetails($id)
    {
        $item = Item::findOrFail($id);
        return view('requests.item_details', compact('item'));
    }
}
