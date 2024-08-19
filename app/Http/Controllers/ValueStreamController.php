<?php

namespace App\Http\Controllers;

use App\Models\ValueStream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValueStreamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        $valueStreams = ValueStream::all();
        return view('valueStreams.index', compact('valueStreams'));
    }

    public function create()
    {
        return view('valueStreams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ValueStream::create($request->all());

        return redirect()->route('valueStreams.index')
                         ->with('success', 'Value Stream created successfully.');
    }

    public function show(ValueStream $valueStream)
    {
        return view('valueStreams.show', compact('valueStream'));
    }

    public function edit(ValueStream $valueStream)
    {
        return view('valueStreams.edit', compact('valueStream'));
    }

    public function update(Request $request, ValueStream $valueStream)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $valueStream->update($request->all());

        return redirect()->route('valueStreams.index')
                         ->with('success', 'Value Stream updated successfully.');
    }

    public function destroy(ValueStream $valueStream)
    {
        $valueStream->delete();

        return redirect()->route('valueStreams.index')
                         ->with('success', 'Value Stream deleted successfully.');
    }
}
