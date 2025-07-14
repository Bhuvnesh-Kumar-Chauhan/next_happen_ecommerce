<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TalentCategory;
use App\Models\Event;
use App\Models\Talent;
use App\Models\TalentAvailability;
use App\Models\EventTalent;

class EventTalentController extends Controller
{
    public function index($id)
    {
        $event = Event::find($id);
        $talent_cat = TalentCategory::all();
        $talents = Talent::all();
        $eventTalent = EventTalent::all();
        return view('admin.event_talent.index', compact('event','talents','talent_cat','eventTalent'));
    }

    public function create($id)
    {
        $event = Event::find($id);
        $talents = Talent::all();
        $talent_cat = TalentCategory::all();
        $talent_availability = TalentAvailability::all();
        return view('admin.event_talent.create', compact('event','talents','talent_cat','talent_availability'));
    }

    public function getTalentsByCategory($category_id)
    {
        $talents = Talent::where('talent_category_id', $category_id)
                        ->pluck('name', 'id');
        
        return response()->json($talents);
    }

    public function checkAvailability(Request $request)
    {
        $talentId = $request->talent_id;
        $date = $request->date;
        
        $isAvailable = TalentAvailability::where('talent_id', $talentId)
                        ->where('date', $date)
                        ->where('is_available', 1)
                        ->exists();
        
        return response()->json([
            'available' => $isAvailable
        ]);
    }

    public function getAvailabilityCalendar($talentId)
    {
        $today = now()->format('Y-m-d');
        
        $availability = TalentAvailability::where('talent_id', $talentId)
                        ->where('date', '>=', $today)
                        ->get()
                        ->map(function($item) {
                            return [
                                'title' => $item->is_available ? 'Available' : 'Not Available',
                                'start' => $item->date,
                                'allDay' => true,
                                'color' => $item->is_available ? '#378006' : '#ff0000',
                                'is_available' => $item->is_available
                            ];
                        });
        
        return response()->json($availability);
    }

     public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required',
            'talent_category' => 'bail|required',
            'talent_id' => 'bail|required',
            'event_date' => 'bail|required',
            'is_active' => 'sometimes|boolean',
        ]);

        $event_talent = EventTalent::create($request->all());
        
        return redirect()
            ->route('event-talent.index',['id' => $request->event_id])
            ->with('success', 'Event Talent Created successfully!');
    }

     public function edit($id)
    {
        $eventTalent = EventTalent::find($id);
        $talents = Talent::all();
        $talent_cat = TalentCategory::all();
        $talent_availability = TalentAvailability::all();
        return view('admin.event_talent.edit', compact('talents','talent_cat','talent_availability','eventTalent'));
    }
    
    public function destroy($id)
    {
        $talent_event = EventTalent::findOrFail($id);
        $talent_event->delete();
        return redirect()->route('event-talent.index', ['id' => $talent_event->event_id])
            ->with('success', 'Event Talent deleted successfully!');
    }

     public function update(Request $request, $id)
    {
        $request->validate([
            'talent_category' => 'bail|required',
            'talent_id' => 'bail|required',
            'event_date' => 'bail|required|date',
            'is_active' => 'nullable|boolean',
        ]);

        $talent_event = EventTalent::findOrFail($id);
        
        $updated = $talent_event->update($request->only([
            'talent_category',
            'talent_id',
            'event_date',
            'is_active'
        ]));

        return redirect()->route('event-talent.index', ['id' => $talent_event->event_id])
            ->with('success', 'Event Talent updated successfully!');
    }

    
}
