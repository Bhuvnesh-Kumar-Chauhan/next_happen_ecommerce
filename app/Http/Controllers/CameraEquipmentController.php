<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CameraEquipment;
use App\Models\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class CameraEquipmentController extends Controller {
    public function index() {
        abort_if(Gate::denies('camera_equipment_access'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $cameraEquipments = CameraEquipment::with('service')->latest()->get();
        return view('admin.camera_equipment.index', compact('cameraEquipments'));
    }

    public function create() {
        abort_if(Gate::denies('camera_equipment_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $services = Service::all();
        return view('admin.camera_equipment.create', compact('services'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'details' => 'nullable|string',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'service_id' => 'nullable|exists:services,id',
            'is_active' => 'boolean',
        ]);

        CameraEquipment::create($request->all());
        return redirect()->route('camera-equipments.index')->with('status', 'Camera Equipment created successfully.');
    }

    public function edit($id) {
        abort_if(Gate::denies('camera_equipment_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $cameraEquipment = CameraEquipment::findOrFail($id);
        $services = Service::all();
        return view('admin.camera_equipment.edit', compact('cameraEquipment', 'services'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'details' => 'nullable|string',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'service_id' => 'nullable|exists:services,id',
            'is_active' => 'boolean',
        ]);

        $cameraEquipment = CameraEquipment::findOrFail($id);
        $cameraEquipment->update($request->all());
        return redirect()->route('camera-equipments.index')->with('status', 'Camera Equipment updated successfully.');
    }

    public function destroy($id) {
        CameraEquipment::destroy($id);
        return redirect()->route('camera-equipments.index')->with('status', 'Camera Equipment deleted successfully.');
    }
}