<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class VenueController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('venue_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $venues = Venue::with('service')->get();
        return view('admin.venues.index', compact('venues'));
    }

    public function create()
    {
        abort_if(Gate::denies('venue_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $services = Service::all();

        return view('admin.venues.create', compact('services'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'service_id' => 'required|exists:services,id',
            'indoor' => 'nullable|boolean',
            'outdoor' => 'nullable|boolean',
            'air_conditioned' => 'nullable|boolean',
            'parking_available' => 'nullable|boolean',
            'stage_available' => 'nullable|boolean',
            'audio_system_included' => 'nullable|boolean',
            'video_system_included' => 'nullable|boolean',
            'catering_services' => 'nullable|boolean',
            'venue_type' => 'nullable|string',
            'seating_style' => 'nullable|string',
            'booking_hours' => 'nullable|string',
            'pricing_per_hour' => 'nullable|numeric',
            'photos' => 'nullable|json',
            'contact_person' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'amenities' => 'nullable|json',
            'is_active' => 'nullable|boolean'
        ]);

        Venue::create($data);

        return redirect()->route('venues.index')->with('success', 'Venue created successfully!');
    }


    public function show(Venue $venue)
    {
        return view('admin.venues.show', compact('service'));
    }
  
    public function edit(Venue $venue)
    {

        abort_if(Gate::denies('venue_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $services = Service::all();

        return view('admin.venues.edit', compact('venue', 'services'));
    }

  
    public function update(Request $request, Venue $venue)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'service_id' => 'required|exists:services,id',
            'indoor' => 'nullable|boolean',
            'outdoor' => 'nullable|boolean',
            'air_conditioned' => 'nullable|boolean',
            'parking_available' => 'nullable|boolean',
            'stage_available' => 'nullable|boolean',
            'audio_system_included' => 'nullable|boolean',
            'video_system_included' => 'nullable|boolean',
            'catering_services' => 'nullable|boolean',
            'venue_type' => 'nullable|string',
            'seating_style' => 'nullable|string',
            'booking_hours' => 'nullable|string',
            'pricing_per_hour' => 'nullable|numeric',
            'photos' => 'nullable|json',
            'contact_person' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'amenities' => 'nullable|json',
            'is_active' => 'nullable|boolean'
        ]);

        $venue->update($data);

        return redirect()->route('venues.index')->with('success', 'Venue updated successfully!');
    }


    public function destroy(Venue $venue)
    {
        $venue->delete();

        return redirect()->route('venues.index')->with('success', 'Venue deleted successfully!');
    }
}
