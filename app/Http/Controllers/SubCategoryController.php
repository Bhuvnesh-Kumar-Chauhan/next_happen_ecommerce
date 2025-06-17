<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('subcategory_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subcategories = SubCategory::with('category')->orderBy('id', 'DESC')->get();

        return view('admin.subcategory.index', compact('subcategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('subcategory_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::all();

        return view('admin.subcategory.create', compact('categories'));
    }

    public function store(Request $request)
    {


        $request->validate([
            'name' => 'bail|required|string|max:255',
            'category_id' => 'required|exists:category,id',
            'image' => 'bail|required|image|mimes:jpeg,png,jpg,gif|max:3048',
            'status' => 'required|in:0,1', 
        ]);

        $data = $request->all();

       
        if ($request->hasFile('image')) {
            $data['image'] = (new AppHelper)->saveImage($request);
        }

        SubCategory::create($data);

        return redirect()->route('subcategory.index')->withStatus(__('SubCategory has been added successfully.'));
    }

    public function edit(SubCategory $subcategory)
    {
        abort_if(Gate::denies('subcategory_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::all();

        return view('admin.subcategory.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, SubCategory $subcategory)
    {
        $request->validate([
            'name' => 'bail|required|string|max:255',
            'category_id' => 'required|exists:category,id', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3048', 
            'status' => 'required|in:0,1', 
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($subcategory->image) {
                (new AppHelper)->deleteFile($subcategory->image);
            }
            $data['image'] = (new AppHelper)->saveImage($request);
        }

        $subcategory->update($data);

        return redirect()->route('subcategory.index')->withStatus(__('SubCategory has been updated successfully.'));
    }

    public function destroy(SubCategory $subcategory)
    {
        abort_if(Gate::denies('subcategory_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($subcategory->image) {
            (new AppHelper)->deleteFile($subcategory->image); 
        }
        $subcategory->delete();

        return redirect()->route('subcategory.index')->with('success', 'SubCategory deleted successfully.');
    }
}
