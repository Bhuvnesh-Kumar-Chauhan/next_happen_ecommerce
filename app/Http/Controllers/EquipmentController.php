<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EquipmentType;
use App\Models\Equipment;
use App\Models\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::all();
        $equipment_types = EquipmentType::all();
        return view('admin.equipments.index', compact('equipments', 'equipment_types'));
    }

    public function create()
    {
        $equipment_types = EquipmentType::all();
        return view('admin.equipments.create', compact('equipment_types'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'bail',
                'required',
                Rule::unique('equipment')->where(function ($query) use ($request) {
                    return $query->where('equipment_type_id', $request->equipment_type_id);
                })
            ],
            'equipment_type_id' => 'bail|required|exists:equipment_types,id',
            'price' => 'bail|required|numeric|min:0',
            'offered_price' => 'required|numeric|min:0|lte:price',
            'is_active' => 'sometimes|boolean'
        ], [
            'name.unique' => 'This equipment name already exists for the selected type. Please choose a different name or change the equipment type.',
            'offered_price.lte' => 'Offered price must be less than or equal to regular price.',
            'equipment_type_id.exists' => 'The selected equipment type is invalid.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        Equipment::create($validated);
        
        return redirect()
            ->route('equipments.index')
            ->with('success', 'Equipment Created Successfully!');
    }

   public function edit(Equipment $equipment)
    {
        $equipment_types = EquipmentType::all();
        return view('admin.equipments.edit', compact('equipment', 'equipment_types'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('equipment')
                    ->where(function ($query) use ($request) {
                        return $query->where('equipment_type_id', $request->equipment_type_id);
                    })
                    ->ignore($equipment->id)
            ],
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'price' => 'required|numeric|min:0',
            'offered_price' => 'required|numeric|min:0|lte:price',
            'is_active' => 'sometimes|boolean'
        ], [
            'name.unique' => 'This name already exists for the selected equipment type. Either change the name or select a different type.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the errors below.');
        }

        $equipment->update($validator->validated());

        return redirect()
            ->route('equipments.index')
            ->with('success', 'Equipment updated successfully!');
    }

     public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return redirect()->route('equipments.index')->with('success', 'Equipment deleted successfully!');
    }
}
