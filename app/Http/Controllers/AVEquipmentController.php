<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AVEquipment;
use App\Models\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class AVEquipmentController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('av_equipment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $avEquipments = AVEquipment::with('service')->get();
        return view('admin.av_equipments.index', compact('avEquipments'));
    }

    public function create()
    {
        abort_if(Gate::denies('av_equipment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $services = Service::all();
        return view('admin.av_equipments.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        AVEquipment::create($request->all());

        return redirect()->route('av_equipments.index')->with('status', 'AV Equipment created successfully!');
    }

    public function edit($id)
    {
        abort_if(Gate::denies('av_equipment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $avEquipment = AVEquipment::findOrFail($id);
        $services = Service::all();
        return view('admin.av_equipments.edit', compact('avEquipment', 'services'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        $avEquipment = AVEquipment::findOrFail($id);
        $avEquipment->update($request->all());

        return redirect()->route('av_equipments.index')->with('status', 'AV Equipment updated successfully!');
    }

    public function destroy($id)
    {
        AVEquipment::destroy($id);
        return redirect()->route('av_equipments.index')->with('status', 'AV Equipment deleted successfully!');
    }
}
