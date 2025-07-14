<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\EventEquipment;

class EventEquipmentController extends Controller
{
    public function index($id)
    {
        $event = Event::find($id);
        $equipments = Equipment::all();
        $event_equipments = EventEquipment::all();
        $equipmentTypes = EquipmentType::all();
        return view('admin.event_equipment.index', compact('event', 'equipments','event_equipments','equipmentTypes'));

    }
    public function create($id)
    {
        $event = Event::find($id);
        $equipments = Equipment::all();
         $equipmentTypes = EquipmentType::all();
        return view('admin.event_equipment.create', compact('event','equipments','equipmentTypes'));
    }

    

    public function getEquipmentByType($equipment_type_id)
    {
        $equipment = Equipment::where('equipment_type_id', $equipment_type_id)
                        ->pluck('name', 'id');
        
        return response()->json($equipment);
    }


     public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required',
            'equipment_type_id' => 'required',
            'equipment_id' => 'required',
            'quantity' => 'nullable|integer|min:1',
            'event_date' => 'required|date',
            'length' => 'nullable|required_if:equipment_type_id,<fabrication-type-id>|numeric',
            'width' => 'nullable|required_if:equipment_type_id,<fabrication-type-id>|numeric',
            'unit' => 'nullable|required_if:equipment_type_id,<fabrication-type-id>|in:cm,m,ft',
            'is_active' => 'sometimes|boolean',
        ]);

        $eventEquipment = EventEquipment::create([
            'event_id' => $request->event_id,
            'equipment_type_id' => $request->equipment_type_id,
            'equipment_id' => $request->equipment_id,
            'quantity' => $request->quantity,
            'event_date' => $request->event_date,
            'length' => $request->length,
            'width' => $request->width,
            'unit' => $request->unit,
            'is_active' => $request->is_active ?? true,
        ]);
        
        return redirect()
            ->route('event-equipment.index', ['id' => $request->event_id])
            ->with('success', 'Event Equipment Created successfully!');
    }

     public function edit($id)
    {
        $equipments = Equipment::all();
        $event_equipments = EventEquipment::find($id);
        $equipmentTypes = EquipmentType::all();
        return view('admin.event_equipment.edit', compact('equipments','event_equipments','equipmentTypes'));
    }
    
    public function destroy($id)
    {
        $Event_equipment = EventEquipment::findOrFail($id);
        $Event_equipment->delete();
        return redirect()->route('event-equipment.index', ['id' => $Event_equipment->event_id])
            ->with('success', 'Event Equipment deleted successfully!');
    }

     public function update(Request $request, $id)
    {
        $request->validate([
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'equipment_id' => 'required|exists:equipment,id',
            'quantity' => 'nullable|integer|min:1',
            'event_date' => 'required|date',
            'length' => 'nullable|required_if:equipment_type_id,'.config('fabrication.type_id').'|numeric|min:0.1',
            'width' => 'nullable|required_if:equipment_type_id,'.config('fabrication.type_id').'|numeric|min:0.1',
            'unit' => 'nullable|required_if:equipment_type_id,'.config('fabrication.type_id').'|in:cm,m,ft',
            'is_active' => 'sometimes|boolean',
        ]);

        $equipment_event = EventEquipment::findOrFail($id);
        
        $updated = $equipment_event->update([
            'equipment_type_id' => $request->equipment_type_id,
            'equipment_id' => $request->equipment_id,
            'quantity' => $request->quantity,
            'event_date' => $request->event_date,
            'length' => $request->length,
            'width' => $request->width,
            'unit' => $request->unit,
            'is_active' => $request->has('is_active') ? $request->is_active : $equipment_event->is_active,
        ]);

        return redirect()->route('event-equipment.index', ['id' => $equipment_event->event_id])
            ->with('success', 'Event Equipment updated successfully!');
    }

    
}
