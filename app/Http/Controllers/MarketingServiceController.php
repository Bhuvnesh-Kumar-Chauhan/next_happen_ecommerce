<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MarketingService;
use App\Models\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;


class MarketingServiceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('marketing_service_access'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $services = MarketingService::with('service')->get();
        return view('admin.marketing_services.index', compact('services'));
    }

    public function create()
    {
        abort_if(Gate::denies('marketing_service_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $services = Service::all();
        return view('admin.marketing_services.create', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'social_media_campaigns' => 'boolean',
            'influencer_shoutouts' => 'boolean',
            'email_campaigns' => 'boolean',
            'whatsapp_promotions' => 'boolean',
            'status' => 'boolean',
        ]);

        MarketingService::create($data);
        return redirect()->route('marketing-services.index')->with('status', 'Marketing service created successfully!');
    }

    public function edit(MarketingService $marketingService)
    {
        abort_if(Gate::denies('marketing_service_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $services = Service::all();
        return view('admin.marketing_services.edit', compact('marketingService', 'services'));
    }

    public function update(Request $request, MarketingService $marketingService)
    {
        $data = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'social_media_campaigns' => 'boolean',
            'influencer_shoutouts' => 'boolean',
            'email_campaigns' => 'boolean',
            'whatsapp_promotions' => 'boolean',
            'status' => 'boolean',
        ]);

        $marketingService->update($data);
        return redirect()->route('marketing-services.index')->with('status', 'Marketing service updated successfully!');
    }

    public function destroy(MarketingService $marketingService)
    {
        $marketingService->delete();
        return redirect()->route('marketing-services.index')->with('status', 'Marketing service deleted.');
    }
}

