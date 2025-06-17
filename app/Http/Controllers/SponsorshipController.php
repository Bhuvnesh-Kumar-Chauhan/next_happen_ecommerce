<?php

namespace App\Http\Controllers;

use App\Models\Sponsorship;
use App\Models\Service;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class SponsorshipController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sponsorship_access'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $sponsorships = Sponsorship::with('service', 'sponsor')->latest()->get();
        return view('admin.sponsorships.index', compact('sponsorships'));
    }

    public function create()
    {
        abort_if(Gate::denies('sponsorship_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $services = Service::all();
        $sponsors = Sponsor::all();
        return view('admin.sponsorships.create', compact('services', 'sponsors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'event_name' => 'required|string|max:255',
            'event_description' => 'nullable|string',
            'event_type' => 'required|string|max:100',
            'location' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'matched_sponsor_id' => 'nullable|exists:sponsors,id',
            'message' => 'nullable|string',
            'proposal_file' => 'nullable|file|mimes:pdf,docx,doc',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('proposal_file')) {
            $data['proposal_file'] = $request->file('proposal_file')->store('proposals', 'public');
        }

        Sponsorship::create($data);

        return redirect()->route('sponsorships.index')->with('status', 'Sponsorship added successfully.');
    }

    public function edit(Sponsorship $sponsorship)
    {
        abort_if(Gate::denies('sponsorship_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $services = Service::all();
        $sponsors = Sponsor::all();
        return view('admin.sponsorships.edit', compact('sponsorship', 'services', 'sponsors'));
    }

    public function update(Request $request, Sponsorship $sponsorship)
    {
        $data = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'event_name' => 'required|string|max:255',
            'event_description' => 'nullable|string',
            'event_type' => 'required|string|max:100',
            'location' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'matched_sponsor_id' => 'nullable|exists:sponsors,id',
            'message' => 'nullable|string',
            'proposal_file' => 'nullable|file|mimes:pdf,docx,doc',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('proposal_file')) {
            $data['proposal_file'] = $request->file('proposal_file')->store('proposals', 'public');
        }

        $sponsorship->update($data);

        return redirect()->route('sponsorships.index')->with('status', 'Sponsorship updated successfully.');
    }

    public function destroy(Sponsorship $sponsorship)
    {
        $sponsorship->delete();
        return redirect()->route('sponsorships.index')->with('status', 'Sponsorship deleted.');
    }
}
