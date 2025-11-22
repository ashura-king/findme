<?php

namespace App\Http\Controllers;

use App\Models\FoundItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Add this import

class FoundItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = FoundItem::orderBy('created_at', 'desc')
            ->paginate(12);

        return view('found.index', compact('items'));
    }

    public function create()
    {
        return view('found.create');
    }

    public function store(Request $request)
    {
        // Debug: Check if request is received
        info('=== FOUND ITEM FORM SUBMISSION STARTED ===');
        info('Form data received:', $request->all());

        try {
            $validated = $request->validate([
                'item_name' => 'required|string|max:255',
                'category' => 'required|string|max:100',
                'location_found' => 'required|string|max:255',
                'date_found' => 'required|date',
                'description' => 'nullable|string',
                'finder_name' => 'required|string|max:255',
                'finder_contact' => 'required|string|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            info('Validation passed:', $validated);

            // Handle photo upload
            if ($request->hasFile('photo')) {
                info('Photo file detected:', ['name' => $request->file('photo')->getClientOriginalName()]);
                $validated['photo'] = $request->file('photo')->store('found-items', 'public');
                info('Photo stored at: ' . $validated['photo']);
            }

            // Set the status to match your ENUM
            $validated['status'] = 'unclaimed';
            
            info('Final data to save:', $validated);

            // Create the record
            $foundItem = FoundItem::create($validated);
            info('SUCCESS: Record created with ID: ' . $foundItem->id);

            return redirect()->route('found.index')
                ->with('success', 'Found item reported successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            info('VALIDATION ERROR: ', $e->errors());
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            info('ERROR in store method: ' . $e->getMessage());
            info('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Error saving item: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $item = FoundItem::findOrFail($id);
        return view('found.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = FoundItem::findOrFail($id);
        return view('found.edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = FoundItem::findOrFail($id);

        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location_found' => 'required|string|max:255',
            'date_found' => 'required|date',
            'finder_name' => 'required|string|max:255',
            'finder_contact' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string|in:unclaimed,claimed', // Fixed to match ENUM
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($item->photo) {
                Storage::disk('public')->delete($item->photo);
            }
            $validated['photo'] = $request->file('photo')->store('found-items', 'public');
        }

        $item->update($validated);

        return redirect()->route('found.show', $item->id)
            ->with('success', 'Found item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = FoundItem::findOrFail($id);
        
        if($item->photo){
            Storage::disk('public')->delete($item->photo);
        }
        $item->delete();
        
        return redirect()->route('found.index')->with('success','Found item deleted successfully');
    }
}