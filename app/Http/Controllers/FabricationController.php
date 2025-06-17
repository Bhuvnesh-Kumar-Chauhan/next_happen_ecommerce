<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fabrication;
use App\Models\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class FabricationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('fabrication_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $fabrications = Fabrication::with('service')->latest()->get();
        return view('admin.fabrication.index', compact('fabrications'));
    }

    public function create()
    {
        abort_if(Gate::denies('fabrication_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $services = Service::all();
        return view('admin.fabrication.create', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'stage_with_grey_carpet' => 'nullable|string',
            'stage_skirting' => 'nullable|string',
            'console_masking' => 'nullable|string',
            'standees' => 'nullable|string',
            'selfie_point' => 'nullable|string',
            'digital_podium_with_mic' => 'nullable|string',
            'stairs' => 'nullable|string',
            'side_flex' => 'nullable|string',
            'main_flex' => 'nullable|string',
            'led_letters' => 'nullable|string',
            'length_in_feet' => 'nullable|numeric',
            'width_in_feet' => 'nullable|numeric',
        ]);

        Fabrication::create($data);

        return redirect()->route('fabrication.index')->with('status', 'Fabrication added successfully!');
    }

    public function show(Fabrication $fabrication)
    {
        return view('admin.fabrication.show', compact('service'));
    }
    public function edit(Fabrication $fabrication)
    {
        abort_if(Gate::denies('fabrication_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $services = Service::all();
        return view('admin.fabrication.edit', compact('fabrication', 'services'));
    }

    public function update(Request $request, Fabrication $fabrication)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'stage_with_grey_carpet' => 'nullable|string',
            'stage_skirting' => 'nullable|string',
            'console_masking' => 'nullable|string',
            'standees' => 'nullable|string',
            'selfie_point' => 'nullable|string',
            'digital_podium_with_mic' => 'nullable|string',
            'stairs' => 'nullable|string',
            'side_flex' => 'nullable|string',
            'main_flex' => 'nullable|string',
            'led_letters' => 'nullable|string',
            'length_in_feet' => 'nullable|numeric',
            'width_in_feet' => 'nullable|numeric',
        ]);

        $fabrication->update($data);

        return redirect()->route('fabrication.index')->with('status', 'Fabrication updated successfully!');
    }

    public function destroy(Fabrication $fabrication)
    {
        $fabrication->delete();
        return redirect()->route('fabrication.index')->with('status', 'Fabrication deleted successfully!');
    }
}
