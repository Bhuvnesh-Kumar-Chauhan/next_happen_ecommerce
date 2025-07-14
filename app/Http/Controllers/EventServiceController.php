<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\Event;
use App\Models\EventService;
use App\Models\Services;

class EventServiceController extends Controller
{
    public function index($id)
    {
        $event = Event::find($id);
        $services = Services::all();
        $service_category = ServiceCategory::all();
        $eventService = EventService::all();
        return view('admin.event_service.index', compact('event','service_category','services','eventService'));
    }

    public function create($id)
    {
        $event = Event::find($id);
        $services = Services::all();
        $service_category = ServiceCategory::all();
        
        return view('admin.event_service.create', compact('event','service_category'));
    }

   public function getServicesByCategory($id)
    {
        $services = Services::where('service_category_id', $id)->pluck('name', 'id');
        return response()->json($services);
    }


     public function store(Request $request)
    {
       $request->validate([
            'event_id' => 'bail|required', 
            'service_id' => 'bail|required',
            'service_category_id' => 'bail|required',
            'event_date' => 'bail|required',
            'is_active' => 'sometimes|boolean'
        ]);

        $event_service = EventService::create($request->all());
        
        return redirect()
            ->route('event-services.index',['id' => $request->event_id])
            ->with('success', 'Event Services Created successfully!');
    }

     public function edit($id)
    {
        $eventService = EventService::find($id);
        $services = Services::all();
        $service_category = ServiceCategory::all();
        return view('admin.event_service.edit', compact('eventService','services','service_category'));
    }
    
    public function destroy($id)
    {
        $service_event = EventService::findOrFail($id);
        $service_event->delete();
        return redirect()->route('event-services.index', ['id' => $service_event->event_id])
            ->with('success', 'Event Service deleted successfully!');
    }

     public function update(Request $request, $id)
    {
        $request->validate([
            'service_id' => 'bail|required',
            'service_category_id' => 'bail|required',
            'event_date' => 'bail|required',
            'is_active' => 'sometimes|boolean'
        ]);

        $service_event = EventService::findOrFail($id);
        
        $updated = $service_event->update($request->only([
            'service_category_id',
            'service_id',
            'event_date',
            'is_active'
        ]));

        return redirect()->route('event-services.index', ['id' => $service_event->event_id])
            ->with('success', 'Event Service updated successfully!');
    }

    
}
