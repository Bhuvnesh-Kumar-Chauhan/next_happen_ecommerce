<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class ServiceController extends Controller
{
    public function index()
    {
        $services = Services::all();
        $ServiceCategories = ServiceCategory::all();
        return view('admin.services.index', compact('services', 'ServiceCategories'));
    }

    public function create()
    {
        $ServiceCategories = ServiceCategory::all();
        return view('admin.services.create', compact('ServiceCategories'));
    }

   public function store(Request $request)
    {
        $validated = $request->validate([
          
            'name' => [
                'bail',
                'required',
                Rule::unique('services')->where(function ($query) use ($request) {
                    return $query->where('service_category_id', $request->service_category_id);
                })
            ],
            'service_category_id' => 'bail|required|exists:service_categories,id',
            'price' => 'bail|required|numeric|min:0',
            'offered_price' => 'required|numeric|min:0|lte:price',
            'is_active' => 'sometimes|boolean'
        ],
            [
            'name.unique' => 'This Service name already exists for the selected Service Category. Please choose a different name or change the Service Category.',
            'offered_price.lte' => 'Offered price must be less than or equal to regular price.',
            'service_category_id.exists' => 'The selected Service category is invalid.'
        ]);

        $service = Services::create($validated);
        return redirect()
            ->route('services.index')
            ->with('success', 'Service Created Successfully!');
    }

   public function edit(Services $service)
    {
        $ServiceCategories = ServiceCategory::all();
        return view('admin.services.edit', compact('service', 'ServiceCategories'));
    }

    public function update(Request $request, Services $service)
    {
       $validated = $request->validate([
          
            'name' => [
                'bail',
                'required',
                Rule::unique('services')->where(function ($query) use ($request) {
                    return $query->where('service_category_id', $request->service_category_id);
                })
                ->ignore($service->id)
            ],
            'service_category_id' => 'bail|required|exists:service_categories,id',
            'price' => 'bail|required|numeric|min:0',
            'offered_price' => 'required|numeric|min:0|lte:price',
            'is_active' => 'sometimes|boolean'
            ],
                [
                'name.unique' => 'This Service name already exists for the selected Service Category. Please choose a different name or change the Service Category.',
                'offered_price.lte' => 'Offered price must be less than or equal to regular price.',
                'service_category_id.exists' => 'The selected Service category is invalid.'
            ]);

       $service->update($validated);
       return redirect()
            ->route('services.index')
            ->with('success', 'Service Updated Successfully!');

    }

     public function destroy(Services $service)
    {
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully!');
    }
    
    
}