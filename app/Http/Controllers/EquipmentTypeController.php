<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EquipmentType;
use App\Models\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class EquipmentTypeController extends Controller {

    public function index() 
    {
        $equipmentTypes = EquipmentType::all();
        return view('admin.equipment_type.index', compact('equipmentTypes'));
    }

    // public function create() {
    //     abort_if(Gate::denies('equipment_type_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');
    //     $services = Service::all();
    //     return view('admin.equipment_type.create', compact('services'));
    // }

     public function store(Request $request)
    {
        $request->validate([
           'name' => 'bail|required|unique:equipment_types,name',
        ]);
        $equipmentType = EquipmentType::create($request->all());
        return redirect()
            ->route('equipments-type.index')
            ->with('success', 'Equipment Type created successfully!');
    }

    public function destroy(EquipmentType $type)
    {
        $type->delete();

        return redirect()->route('equipments-type.index')->with('success', 'Equipment Type deleted successfully!');
    }

     public function update(Request $request, EquipmentType $type)
    {
        $request->validate([
           'name' => 'bail|required|unique:equipment_types,name,'.$type->id,
        ]);

         try {
            $type->update($request->all());
            return response()->json([
                'success' => true,
                'message' => __('Equipment Type updated successfully.')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to update equipment type.')
            ], 500);
        }
       
    }
}