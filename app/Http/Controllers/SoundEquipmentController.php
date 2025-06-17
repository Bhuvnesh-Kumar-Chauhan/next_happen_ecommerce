<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\SoundEquipment;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class SoundEquipmentController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sound_equipment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $soundEquipments = SoundEquipment::with('service')->get();
        return view('admin.sound_equipment.index', compact('soundEquipments'));
    }

    public function create()
    {
        abort_if(Gate::denies('sound_equipment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $services = Service::all();
        return view('admin.sound_equipment.create', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'mixer' => 'boolean',
            'woofers' => 'boolean',
            'line_array' => 'boolean',
            'monitor_speakers' => 'boolean',
            'microphones' => 'boolean',
            'wireless_mics' => 'boolean',
            'amplifiers' => 'boolean',
            'equalizers' => 'boolean',
            'setup_area_size' => 'nullable|string',
        ]);

        SoundEquipment::create($data);

        return redirect()->route('sound-equipment.index')->with('status', 'Sound Equipment created successfully.');
    }

    public function edit(SoundEquipment $soundEquipment)
    {
        abort_if(Gate::denies('sound_equipment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $services = Service::all();
        return view('admin.sound_equipment.edit', compact('soundEquipment', 'services'));
    }

    public function update(Request $request, SoundEquipment $soundEquipment)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'mixer' => 'boolean',
            'woofers' => 'boolean',
            'line_array' => 'boolean',
            'monitor_speakers' => 'boolean',
            'microphones' => 'boolean',
            'wireless_mics' => 'boolean',
            'amplifiers' => 'boolean',
            'equalizers' => 'boolean',
            'setup_area_size' => 'nullable|string',
        ]);

        $soundEquipment->update($data);

        return redirect()->route('sound-equipment.index')->with('status', 'Sound Equipment updated successfully.');
    }

    public function destroy(SoundEquipment $soundEquipment)
    {
        $soundEquipment->delete();
        return redirect()->route('sound-equipment.index')->with('status', 'Deleted successfully.');
    }
}
