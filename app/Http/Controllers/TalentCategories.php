<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TalentCategory;

class TalentCategories extends Controller
{
   public function index()
    {
        $talent_cat = TalentCategory::all();
        return view('admin.talentCategory.index',compact('talent_cat'));

    }

     public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|unique:talent_categories,name', // Add unique validation
        ]);

        $talent_cat = TalentCategory::create($request->all());
        
        return redirect()
            ->route('talent-category.index')
            ->with('success', 'Talent Category created successfully!');
    }

    public function destroy(TalentCategory $category)
    {
        $category->delete();

        return redirect()->route('talent-category.index')->with('success', 'Talent Category deleted successfully!');
    }

    //  public function update(Request $request, TalentCategory $category)
    // {
    //     $request->validate([
    //         'name' => 'bail|required|unique:talent_categories,name,' . $category->id,
    //     ]);
    //     $category = TalentCategory::find($category->id)->update($request->all());
    //     return redirect()->route('talent-category.index')->withStatus(__('Talent Category updated successfully.'));
    // }

    public function update(Request $request, TalentCategory $category)
    {
        $request->validate([
            'name' => 'bail|required|unique:talent_categories,name,' . $category->id,
        ]);
        
        try {
            $category->update($request->all());
            return response()->json([
                'success' => true,
                'message' => __('Talent Category updated successfully.')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to update talent category.')
            ], 500);
        }
    }
}
