<?php

namespace App\Http\Controllers;


use App\Models\Speaker;
use App\Models\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class SpeakerController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('speaker_access'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $speakers = Speaker::with('service')->get();
        return view('admin.speakers.index', compact('speakers'));
    }

    public function create()
    {
        abort_if(Gate::denies('speaker_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $services = Service::all();
        return view('admin.speakers.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required',
            'topic' => 'nullable',
            'experience_years' => 'nullable|integer',
            'language' => 'nullable',
            'category' => 'nullable',
            'fee' => 'nullable|numeric',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date',
            'status' => 'required|boolean',
        ]);

        Speaker::create($request->all());

        return redirect()->route('speakers.index')->with('status', 'Speaker created successfully.');
    }

    public function edit(Speaker $speaker)
    {
        abort_if(Gate::denies('speaker_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $services = Service::all();
        return view('admin.speakers.edit', compact('speaker', 'services'));
    }

    public function update(Request $request, Speaker $speaker)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required',
            'topic' => 'nullable',
            'experience_years' => 'nullable|integer',
            'language' => 'nullable',
            'category' => 'nullable',
            'fee' => 'nullable|numeric',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date',
            'status' => 'required|boolean',
        ]);

        $speaker->update($request->all());

        return redirect()->route('speakers.index')->with('status', 'Speaker updated successfully.');
    }

    public function destroy(Speaker $speaker)
    {
        $speaker->delete();
        return redirect()->route('speakers.index')->with('status', 'Speaker deleted successfully.');
    }
}

