<?php
namespace App\Http\Controllers;

use App\Models\ProductionService;
use App\Models\Service;  
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;


class ProductionServiceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('production_service_access'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $services = ProductionService::latest()->get();
        return view('admin.production_services.index', compact('services'));
    }

    public function create()
    {
        abort_if(Gate::denies('production_service_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $services = Service::all();  // Get all services for selection
        return view('admin.production_services.create', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',  // Validation for service_id
            'video_coverage' => 'nullable|boolean',
            'livestream_setup' => 'nullable|boolean',
            'photography' => 'nullable|boolean',
            'post_event_editing' => 'nullable|boolean',
            'notes' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        ProductionService::create($data);
        return redirect()->route('production-services.index')->with('status', 'Production service created successfully.');
    }

    public function edit(ProductionService $production_service)
    {
        abort_if(Gate::denies('production_service_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $services = Service::all(); 
        return view('admin.production_services.edit', compact('production_service', 'services'));
    }

    public function update(Request $request, ProductionService $production_service)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'video_coverage' => 'nullable|boolean',
            'livestream_setup' => 'nullable|boolean',
            'photography' => 'nullable|boolean',
            'post_event_editing' => 'nullable|boolean',
            'notes' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $production_service->update($data);
        return redirect()->route('production-services.index')->with('status', 'Production service updated successfully.');
    }

    public function destroy(ProductionService $production_service)
    {
        $production_service->delete();
        return redirect()->route('production-services.index')->with('status', 'Production service deleted.');
    }
}
