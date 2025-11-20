<?php

namespace App\Http\Controllers;

use App\Models\FoundItem;
use Illuminate\Http\Request;

class FoundItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = FoundItem::latest()->get();
        return view('found.index',compact('items'));
    }

 
    public function create()
    {
    return view('found.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'item_name' => 'required',
            'category' => 'required',
            'location_found' => 'required',
            'date_found' => 'required|date',
            'finder_name' => 'required',
            'finder_contact' => 'required',
            'photo' => 'image'
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->photo->store('found_photos', 'public');
        }
         FoundItem::create($data);
        
          return redirect()->route('found.index')->with('success', 'Found item listed.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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