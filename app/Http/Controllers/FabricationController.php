<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fabrication;
use App\Models\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class FabricationController extends Controller
{
    public function index()
    {
        $fabrications = Fabrication::all();
        return view('admin.fabrication.index',compact('fabrications'));
    }

    public function create()
    { 
        return view('admin.fabrication.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fabrication_type' => 'required',
            'name' => 'required',
            'description' => 'required',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Changed to single image
            'status' => 'nullable',
        ]);

        if ($request->hasFile('images')) {
            $path = $request->file('images')->store('fabrication_images', 'public');
            $data['images'] = $path; 
        }

        Fabrication::create($data);

        return redirect()->route('fabrication.index')->with('status', 'Fabrication added successfully!');
    }

    public function edit($id)
    {
         $fabrication = Fabrication::findOrFail($id);
        
        return view('admin.fabrication.edit', compact('fabrication'));
    }
   public function update(Request $request, Fabrication $fabrication)
    {
        $validated = $request->validate([
            'fabrication_type' => 'required',
            'name' => 'required',
            'description' => 'required',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable',
        ]);

        if ($request->hasFile('images')) {
            if ($fabrication->images) {
                $oldImagePath = storage_path('app/public/' . $fabrication->images);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            $image = $request->file('images');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $path = $image->storeAs('fabrication_images', $imageName, 'public');
            $validated['images'] = $path;
        }

        $fabrication->update($validated);
        
        return redirect()
            ->route('fabrication.index')
            ->with('success', 'Fabrication updated successfully!');
    }

    public function destroy(fabrication $fabrication)
    {
        $fabrication->delete();

        return redirect()->route('fabrication.index')->with('success', 'Fabrication deleted successfully!');
    }
}
