<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class SponsorController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sponsor_access'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $sponsors = Sponsor::latest()->get();
        return view('admin.sponsors.index', compact('sponsors'));
    }

    public function create()
    {
        abort_if(Gate::denies('sponsor_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        return view('admin.sponsors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'interest_area' => 'nullable|string|max:255',
            'about' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('sponsor_logos', 'public');
        }

        Sponsor::create($data);
        return redirect()->route('sponsors.index')->with('status', 'Sponsor created successfully.');
    }

    public function edit(Sponsor $sponsor)
    {
        abort_if(Gate::denies('sponsor_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        return view('admin.sponsors.edit', compact('sponsor'));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'interest_area' => 'nullable|string|max:255',
            'about' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('sponsor_logos', 'public');
        }

        $sponsor->update($data);
        return redirect()->route('sponsors.index')->with('status', 'Sponsor updated successfully.');
    }

    public function destroy(Sponsor $sponsor)
    {
        $sponsor->delete();
        return redirect()->route('sponsors.index')->with('status', 'Sponsor deleted successfully.');
    }
}
