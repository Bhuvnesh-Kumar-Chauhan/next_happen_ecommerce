<?php

namespace App\Http\Controllers;

use App\Models\Celebrity;
use App\Models\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class CelebrityController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('celebrity_access'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $celebrities = Celebrity::with('service')->latest()->get();
        return view('admin.celebrities.index', compact('celebrities'));
    }

    public function create()
    {
        abort_if(Gate::denies('celebrity_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $services = Service::all();
        return view('admin.celebrities.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'category' => 'required|in:Actor,Singer,Reality Star',
            'audience' => 'required|in:Bollywood,Regional,Business',
            'rate_card' => 'nullable|numeric',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date',
            'status' => 'nullable|boolean',
        ]);

        Celebrity::create($request->all());

        return redirect()->route('celebrities.index')->with('status', 'Celebrity added successfully.');
    }

    public function edit(Celebrity $celebrity)
    {
        abort_if(Gate::denies('celebrity_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $services = Service::all();
        return view('admin.celebrities.edit', compact('celebrity', 'services'));
    }

    public function update(Request $request, Celebrity $celebrity)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'category' => 'required|in:Actor,Singer,Reality Star',
            'audience' => 'required|in:Bollywood,Regional,Business',
            'rate_card' => 'nullable|numeric',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date',
            'status' => 'nullable|boolean',
        ]);

        $celebrity->update($request->all());

        return redirect()->route('celebrities.index')->with('status', 'Celebrity updated successfully.');
    }

    public function destroy(Celebrity $celebrity)
    {
        $celebrity->delete();
        return redirect()->route('celebrities.index')->with('status', 'Celebrity deleted successfully.');
    }
}
