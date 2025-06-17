<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Influencer;
use App\Models\Service;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
class InfluencerController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('influencer_access'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $influencers = Influencer::all();
        return view('admin.influencers.index', compact('influencers'));
    }

    public function create()
    {
        abort_if(Gate::denies('influencer_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $services = Service::all();
        return view('admin.influencers.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'audience' => 'required|string',
            'platform' => 'required|string',
            'followers_count' => 'required|integer',
            'rate_card' => 'nullable|string',
            'service_id' => 'nullable|exists:services,id',
            'status' => 'required|boolean',
        ]);

        Influencer::create($request->all());

        return redirect()->route('influencers.index')->with('status', 'Influencer created successfully.');
    }

    public function edit($id)
    {
        abort_if(Gate::denies('influencer_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $influencer = Influencer::findOrFail($id);
        $services = Service::all();
        return view('admin.influencers.edit', compact('influencer', 'services'));
    }

    public function update(Request $request, $id)
    {
        $influencer = Influencer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'audience' => 'required|string',
            'platform' => 'required|string',
            'followers_count' => 'required|integer',
            'rate_card' => 'nullable|string',
            'service_id' => 'nullable|exists:services,id',
            'status' => 'required|boolean',
        ]);

        $influencer->update($request->all());

        return redirect()->route('influencers.index')->with('status', 'Influencer updated successfully.');
    }

    public function destroy($id)
    {
        $influencer = Influencer::findOrFail($id);
        $influencer->delete();

        return redirect()->route('influencers.index')->with('status', 'Influencer deleted successfully.');
    }
}

