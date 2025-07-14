<?php

namespace App\Http\Controllers;

use App\Models\Talent;
use App\Models\TalentCategory;
use App\Models\TalentAvailability;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TalentController extends Controller
{
    public function index()
    {
        $talents = Talent::all();
        $talent_cat = TalentCategory::all();
        return view('admin.talent.index', compact('talents', 'talent_cat'));
    }

    public function create()
    {
        $talent_cat = TalentCategory::all();
        return view('admin.talent.create',compact('talent_cat'));

    }
    public function store(Request $request)
    {
            $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('talents')->where(function ($query) use ($request) {
                    return $query->where('talent_category_id', $request->talent_category_id);
                })
            ],
            'talent_category_id' => 'required|exists:talent_categories,id',
            'rate' => 'required|numeric|min:0',
            'offered_rate' => 'required|numeric|min:0|lte:rate',
            'talent_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audience_type' => 'nullable|string|in:bollywood,regional,business',
            'is_active' => 'sometimes|boolean'
        ], [
            'name.unique' => 'This talent name already exists for the selected category. Please choose a different name or category.',
            'offered_rate.lte' => 'Offered rate must be less than or equal to regular rate.',
        ]);

       if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }
        $validated = $validator->validated();

        if ($request->hasFile('talent_image')) {
            $image = $request->file('talent_image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            
            $path = $image->storeAs('talent_images', $imageName, 'public');
            
            $validated['talent_image'] = $path;
        }

        $talent = Talent::create($validated);

        return redirect()
            ->route('talent.index')
            ->with('success', 'Talent Created Successfully!');
    }

    public function show(Talent $talent)
    {
        return response()->json([
            'success' => true,
            'data' => $talent->load('category')
        ]);
    }

    public function edit(Talent $talent)
    {
        $talent_cat = TalentCategory::all();
        return view('admin.talent.edit', compact('talent', 'talent_cat'));
    }
    public function update(Request $request, Talent $talent)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('talents')
                    ->where(function ($query) use ($request) {
                        return $query->where('talent_category_id', $request->talent_category_id);
                    })
                    ->ignore($talent->id) // Make sure this is outside the where() closure
            ],
            'talent_category_id' => 'required|exists:talent_categories,id',
            'rate' => 'required|numeric|min:0',
            'offered_rate' => 'required|numeric|min:0|lte:rate',
            'talent_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audience_type' => 'nullable|string|in:bollywood,regional,business',
            'is_active' => 'sometimes|boolean'
        ], [
            'name.unique' => 'This talent name already exists for the selected category. Please choose a different name or change the category.',
            'offered_rate.lte' => 'Offered rate must be less than or equal to the regular rate.',
        ]);

        // Handle image upload
        if ($request->hasFile('talent_image')) {
            // Delete old image if it exists
            if ($talent->talent_image) {
                $oldImagePath = storage_path('app/public/' . $talent->talent_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Store new image
            $image = $request->file('talent_image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $path = $image->storeAs('talent_images', $imageName, 'public');
            $validated['talent_image'] = $path;
        }

        $talent->update($validated);
        
        return redirect()
            ->route('talent.index')
            ->with('success', 'Talent updated successfully!');
    }

    public function destroy(Talent $talent)
    {
        $talent->delete();

        return redirect()->route('talent.index')->with('success', 'Talent deleted successfully!');
    }

    public function setAvailability(Request $request)
    {
        $request->validate([
            'talent_id' => 'required|exists:talents,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_available' => 'required|boolean',
        ]);
        $talentId = $request->talent_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $isAvailable = $request->is_available;
        
        $dates = [];
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            TalentAvailability::updateOrCreate(
                [
                    'talent_id' => $talentId,
                    'date' => $currentDate,
                ],
                [
                    'is_available' => $isAvailable,
                ]
            );

            $dates[] = $currentDate;
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }
        
        return redirect()->route('talent.index')
    ->with('success', 'Availability set successfully for ' . count($dates) . ' dates.');
    }

    public function getAvailabilityCalendar($talentId)
    {
        $today = now()->format('Y-m-d');

        $data = TalentAvailability::where('talent_id', $talentId)
            ->where('date', '>=', $today) // Only future dates
            ->get()
                    ->map(function ($item) {
                        return [
                            'title' => $item->is_available ? 'Available' : 'Not Available',
                            'start' => $item->date,
                            'color' => $item->is_available ? '#28a745' : '#dc3545',
                        ];
                    });        

        return response()->json($data->values()->all());
    }

   
}