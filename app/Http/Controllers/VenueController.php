<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\VenueAvailability;
use App\Models\Service;
use App\Models\VenueImages;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VenueController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('venue_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $venues = Venue::all();
        return view('admin.venues.index', compact('venues'));
    }

    public function create()
    {
        // $services = Service::all();
        return view('admin.venues.create');
    }


    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'location' => 'required|string|max:255',
    //         'capacity' => 'required|integer|min:1',
    //         'venue_type' => 'required|string|max:255',
    //         'price' => 'required|numeric|min:0',
    //         'offer_price' => 'required|numeric|min:0|lte:price',

    //         'video' => 'nullable|string', // Changed from json to string if storing URL
    //         'photos' => 'nullable|json', // Keep as json if storing array
    //         'is_active' => 'sometimes|boolean' // Changed from nullable to sometimes
    //     ]);

    //     // Additional validation to ensure offer_price is less than or equal to price
    //     if ($validatedData['offer_price'] > $validatedData['price']) {
    //         return back()->withErrors([
    //             'offer_price' => 'Offer price must be less than or equal to regular price'
    //         ])->withInput();
    //     }

    //     try {
    //         Venue::create($validatedData);
            
    //         return redirect()
    //             ->route('venues.index')
    //             ->with('success', 'Venue created successfully!');
                
    //     } catch (\Exception $e) {
    //         return back()
    //             ->withErrors(['error' => 'Failed to create venue. Please try again.'])
    //             ->withInput();
    //     }
    // }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'venue_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'offer_price' => 'required|numeric|min:0|lte:price',
            'venue_video' => 'nullable|file|mimes:mp4,mov,avi,flv,webm|max:20480',
            'is_active' => 'sometimes|boolean'
        ]);

        // Additional check for offer price
        if ($validatedData['offer_price'] > $validatedData['price']) {
            return back()->withErrors([
                'offer_price' => 'Offer price must be less than or equal to regular price'
            ])->withInput();
        }

        try {
            // Handle video upload
            if ($request->hasFile('venue_video')) {
                $video = $request->file('venue_video');
                $videoName = $video->getClientOriginalName(); // No timestamp prefix
                $videoPath = $video->storeAs('VenueVideo', $videoName, 'public');
                $validatedData['video'] = $videoPath; // DB column 'video'
            }


            Venue::create($validatedData);

            return redirect()
                ->route('venues.index')
                ->with('success', 'Venue created successfully!');
                
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Failed to create venue. ' . $e->getMessage()])
                ->withInput();
        }
    }


  
    public function edit(Venue $venue)
    {
        abort_if(Gate::denies('venue_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('admin.venues.edit', compact('venue'));
    }

  
    

    public function update(Request $request, Venue $venue)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'venue_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'offer_price' => 'required|numeric|min:0|lte:price',
            'is_active' => 'sometimes|boolean',
        ]);

        // Handle video
        if ($request->has('remove_video') && $request->remove_video == '1') {
            // Delete existing video
            if ($venue->video) {
                Storage::disk('public')->delete($venue->video);
            }
            $data['video'] = null;
        } elseif ($request->hasFile('venue_video')) {
            // Delete old video if exists
            if ($venue->video) {
                Storage::disk('public')->delete($venue->video);
            }
            // Store new video
            $video = $request->file('venue_video');
            $videoName = $video->getClientOriginalName(); // No timestamp prefix
            $videoPath = $video->storeAs('VenueVideo', $videoName, 'public');
            $data['video'] = $videoPath;
        } else {
            // Keep existing video if no changes
            $data['video'] = $venue->video;
        }

        $venue->update($data);

        return redirect()->route('venues.index')->with('success', 'Venue updated successfully!');
    }

    public function destroy(Venue $venue)
    {
        $venue->delete();

        return redirect()->route('venues.index')->with('success', 'Venue deleted successfully!');
    }


    // VenueAvailabilityController.php
   

    public function setAvailability(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_available' => 'required|boolean',
        ]);
        
        $venueId = $request->venue_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $isAvailable = $request->is_available;
        
        $dates = [];
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            VenueAvailability::updateOrCreate(
                [
                    'venue_id' => $venueId,
                    'date' => $currentDate,
                ],
                [
                    'is_available' => $isAvailable,
                ]
            );

            $dates[] = $currentDate;
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }
        
        return redirect()->route('venues.index')
    ->with('success', 'Availability set successfully for ' . count($dates) . ' dates.');
    }
    
   public function getAvailabilityCalendar($venueId)
    {
        $today = now()->format('Y-m-d');
        
        $data = VenueAvailability::where('venue_id', $venueId)
                    ->where('date', '>=', $today) // Only future dates
                    ->get()
                    ->map(function ($item) {
                        return [
                            'title' => $item->is_available ? 'Available' : 'Not Available',
                            'start' => $item->date,
                            'color' => $item->is_available ? '#28a745' : '#dc3545',
                        ];
                    });        

        return response()->json($data->values()->all());
    }

    public function images($id)
    {
        $venue = Venue::find($id);
        $images = VenueImages::where('venue_id', $id)->get();
        return view('admin.venues.images', compact('venue', 'images'));
    }

    public function storeImage(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Add unique identifier to filename
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/venue_gallery', $filename);

                VenueImages::create([
                    'venue_id' => $request->venue_id,
                    'image' => $filename
                ]);
            }
        }

        return redirect()
                ->route('venues.images', ['id' => $request->venue_id])
                ->with('success', 'Images uploaded successfully!');
    }

    public function destroyImage($id)
    {
        $image = VenueImages::findOrFail($id);
        Storage::delete('public/venue_gallery/' . $image->image);
        $image->delete();
        
        return redirect()->back()->with('success', 'Image deleted successfully');
    }

    public function getVenueImages($venue_id)
    {
        try {
            $images = VenueImages::where('venue_id', $venue_id)->get();
            
            $imageUrls = $images->map(function($image) {
                return [
                    'image_url' => asset('storage/venue_gallery/' . $image->image) // Adjust this based on your storage setup
                ];
            });
            
            return response()->json([
                'success' => true,
                'images' => $imageUrls
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading images'
            ], 500);
        }
    }
   
}
