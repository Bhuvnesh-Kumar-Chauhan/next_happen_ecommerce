<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;

class ServiceCategoryController extends Controller
{
   public function index()
    {
        $serviceCategories = ServiceCategory::all();
        return view('admin.serviceCategory.index', compact('serviceCategories'));
    }
     public function store(Request $request)
    {
        $request->validate([
             'name' => 'bail|required|unique:service_categories,name',
        ]);
        $serviceCategory = ServiceCategory::create($request->all());
        return redirect()
            ->route('services-category.index')
            ->with('success', 'Service Category created successfully!');
    }

    public function destroy(ServiceCategory $category)
    {
        $category->delete();

        return redirect()->route('services-category.index')->with('success', 'Service Category deleted successfully!');
    }

     public function update(Request $request, ServiceCategory $category)
    {
        $request->validate([
            'name' => 'bail|required|unique:service_categories,name,'.$category->id,
        ]);

            try {
               $category->update($request->all());
                return response()->json([
                    'success' => true,
                    'message' => __('Service Category updated successfully.')
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => __('Failed to update service category.')
                ], 500);
            }

        
    }
}
