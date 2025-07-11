<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Event;
use Throwable;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Carbon;

class BannerController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('banner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $banner = Banner::orderBy('id', 'DESC')->get();

        return view('admin.banner.index', compact('banner'));
    }

    public function create()
    {
        abort_if(Gate::denies('banner_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $timezone = Setting::find(1)->timezone;
        $date = Carbon::now($timezone);
        $events  = Event::where([['status', 1], ['is_deleted', 0], ['event_status', 'Pending']])
            ->orderBy('start_time', 'desc')->get();
        // $events  = Event::where([['status', 1], ['is_deleted', 0], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d H:i:s')]])
        //     ->orderBy('start_time', 'desc')->get();
        return view('admin.banner.create',compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'bail|required',
            'event_id' => 'bail|required',
            'image' => 'bail|required|mimes:jpeg,png,jpg,gif,webp|max:20480',
        ], [
            'title.required' => 'The title is required',
            'event_id.required' => 'The event ID is required',
            'image.required' => 'An image is required',
            'image.image' => 'The file must be an image',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif,webp',
            'image.max' => 'The image may not be greater than 20MB',
        ]);
    
        if($this->canCreateNewBanner()) {
            $data = $request->all();
            if ($request->hasFile('image')) {
                $data['image'] = (new AppHelper)->saveImage($request);
            }
            $banner = Banner::create($data);
            return redirect()->route('banner.index')->withStatus(__('Banner has been added successfully.'));
        } else {
            return redirect()->route('banner.index')->withStatus(__('Only 5 banners can be created.'));
        }
    }
    
    private function canCreateNewBanner()
    {
        $maxBanners = 5;
        return Banner::count() < $maxBanners;
    }


    public function edit(Banner $banner)
    {
        abort_if(Gate::denies('banner_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $timezone = Setting::find(1)->timezone;
        $date = Carbon::now($timezone);
        $events  = Event::where([['status', 1], ['is_deleted', 0], ['event_status', 'Pending']])
        ->orderBy('start_time', 'desc')->get();
        // $events  = Event::where([['status', 1], ['is_deleted', 0], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d H:i:s')]])
        // ->orderBy('start_time', 'desc')->get();
        return view('admin.banner.edit', compact('banner','events'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'bail|required',
            'event_id' => 'bail|required',
        ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'bail|required|image|mimes:jpeg,png,jpg,gif|max:20480',
            ]);
            (new AppHelper)->deleteFile($banner->image);
            $data['image'] = (new AppHelper)->saveImage($request);
        }
        $banner = Banner::find($banner->id)->update($data);
        return redirect()->route('banner.index')->withStatus(__('Banner has updated successfully.'));
    }

    public function destroy(Banner $banner)
    {
        try {
            (new AppHelper)->deleteFile($banner->image);
            $banner->delete();
            return true;
        } catch (Throwable $th) {
            return response('Data is Connected with other Data', 400);
        }
    }
}
