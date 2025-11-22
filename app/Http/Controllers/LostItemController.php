<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use Illuminate\Http\Request;

class LostItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = LostItem::latest()->get();
        return view('lost.index', compact('items'));
    }

    public function create()
    {
        return view('lost.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'item_name' => 'required',
            'category' => 'required',
            'location_lost' => 'required',
            'date_lost' => 'required|date',
            'photo' => 'image',
            
        ]);

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = time() . '.' . $image->getClientOriginalName();
            $image->move(public_path('lost_items'), $imageName);
            $data['photo'] = 'lost_items/' . $imageName;
        }
        LostItem::create($data);
        return redirect()->route('lost.index')->with('success', 'Lost item reported');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = LostItem::findOrFail($id);
        return view('lost.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}