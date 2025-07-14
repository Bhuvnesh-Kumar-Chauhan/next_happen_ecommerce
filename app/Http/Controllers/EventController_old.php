<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Venue;
use App\Models\Talent;
use App\Models\Services;
use App\Models\Category;
use App\Models\EventVenue;
use App\Models\EventService;
use App\Models\Ticket;
use App\Models\VenueAvailability;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Equipment;
use App\Http\Controllers\AppHelper;
use App\Models\User;
use App\Models\AppUser;
use App\Models\SubCategory;
use App\Models\Banner;
use App\Models\Coupon;
use App\Models\label;
use Carbon\Carbon;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    public function index(Request $request)
    {
        
        abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (Auth::user()->hasRole('admin')) {
            $timezone = Setting::find(1)->timezone;
            $date = Carbon::now($timezone);
            $events = Event::with(['category:id,name','label','subcategory'])->where([['is_deleted', 0], ['event_status', 'Pending']])->orderBy('id', 'DESC');
            
            // $events = Event::with(['category:id,name'],'subcategory')
            //     ->where([['is_deleted', 0], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d H:i:s')]]);
            $chip = array();
            if ($request->has('type') && $request->type != null) {
                $chip['type'] = $request->type;
                $events = $events->where('type', $request->type);
            }
            if ($request->has('category') && $request->category != null) {
                $chip['category'] = Category::find($request->category)->name;
                $events = $events->where('category_id', $request->category);
            }
            if ($request->has('duration') && $request->duration != null) {
                $chip['date'] = $request->duration;
                if ($request->duration == 'Today') {
                    $temp = Carbon::now($timezone)->format('Y-m-d');
                    $events = $events->whereBetween('start_time', [$temp . ' 00:00:00', $temp . ' 23:59:59']);
                } else if ($request->duration == 'Tomorrow') {
                    $temp = Carbon::tomorrow($timezone)->format('Y-m-d');
                    $events = $events->whereBetween('start_time', [$temp . ' 00:00:00', $temp . ' 23:59:59']);
                } else if ($request->duration == 'ThisWeek') {
                    $now = Carbon::now($timezone);
                    $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i:s');
                    $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i:s');
                    $events = $events->whereBetween('start_time', [$weekStartDate, $weekEndDate]);
                } else if ($request->duration == 'date') {
                    if (isset($request->date)) {
                        $temp = Carbon::parse($request->date)->format('Y-m-d H:i:s');
                        $events = $events->whereBetween('start_time', [$request->date . ' 00:00:00', $request->date . ' 23:59:59']);
                    }
                }
            }
            $events = $events->orderBy('start_time', 'ASC')->get();
            
            
        } elseif (Auth::user()->hasRole('Organizer')) {
            $timezone = Setting::find(1)->timezone;
            $date = Carbon::now($timezone);
            $events = Event::with(['category:id,name','label','subcategory'])
                ->where([['status', 1], ['user_id', Auth::user()->id], ['is_deleted', 0], ['event_status', 'Pending']]);
            // $events = Event::with(['category:id,name'], 'subcategory')
            //     ->where([['status', 1], ['user_id', Auth::user()->id], ['is_deleted', 0], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d H:i:s')]]);
            $chip = array();
            if ($request->has('type') && $request->type != null) {
                $chip['type'] = $request->type;
                $events = $events->where('type', $request->type);
            }
            if ($request->has('category') && $request->category != null) {
                $chip['category'] = Category::find($request->category)->name;
                $events = $events->where('category_id', $request->category);
            }
            if ($request->has('duration') && $request->duration != null) {
                $chip['date'] = $request->duration;
                if ($request->duration == 'Today') {
                    $temp = Carbon::now($timezone)->format('Y-m-d');
                    $events = $events->whereBetween('start_time', [$temp . ' 00:00:00', $temp . ' 23:59:59']);
                } else if ($request->duration == 'Tomorrow') {
                    $temp = Carbon::tomorrow($timezone)->format('Y-m-d');
                    $events = $events->whereBetween('start_time', [$temp . ' 00:00:00', $temp . ' 23:59:59']);
                } else if ($request->duration == 'ThisWeek') {
                    $now = Carbon::now($timezone);
                    $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i:s');
                    $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i:s');
                    $events = $events->whereBetween('start_time', [$weekStartDate, $weekEndDate]);
                } else if ($request->duration == 'date') {
                    if (isset($request->date)) {
                        $temp = Carbon::parse($request->date)->format('Y-m-d H:i:s');
                        $events = $events->whereBetween('start_time', [$request->date . ' 00:00:00', $request->date . ' 23:59:59']);
                    }
                }
            }
            $events = $events->orderBy('start_time', 'ASC')->get();

        }

        return view('admin.event.index', compact('events'));
    }

    public function create()
    {
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $labels = label::all();
        $category = Category::where('status', 1)->orderBy('id', 'DESC')->with('subcategories')->get();
        $users = User::role('Organizer')->orderBy('id', 'DESC')->get();
        if (Auth::user()->hasRole('admin')) {
            $scanner = User::role('scanner')->orderBy('id', 'DESC')->get();
        } else if (Auth::user()->hasRole('Organizer')) {
            $scanner = User::role('scanner')->where('org_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        }
        return view('admin.event.create', compact('category', 'users', 'scanner','labels'));
    }


    // Controller method
    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }

    // public function store(Request $request)
    // {
    //     // Log request data for debugging
    //     \Log::info($request->all());

    //     // Validate request data
    //     $validator = \Validator::make($request->all(), [
    //         'name' => 'bail|required',
    //         'image' => 'bail|required|mimes:jpeg,png,jpg,gif,webp|max:20480',
    //         'start_time' => 'bail|required',
    //         'end_time' => 'bail|required',
    //         'category_id' => 'bail|required',
    //         'type' => 'bail|required',
    //         'address' => 'bail|required_if:type,offline',
    //         'lat' => 'bail|required_if:type,offline',
    //         'lang' => 'bail|required_if:type,offline',
    //         'scanner_id' => 'bail|required_if:type,offline|array|min:1',
    //         'scanner_id.*' => 'exists:users,id',
    //         'status' => 'bail|required',
    //         'url' => 'bail|required_if:type,online',
    //         'description' => 'bail|required',
    //         'people' => 'bail|required',
    //         'label' => 'bail|required',
    //     ], [
    //         'scanner_id.required_if' => 'The scanner field is required when the type is offline.',
    //         'scanner_id.array' => 'The scanner field must be an array.',
    //         'scanner_id.min' => 'You must select at least one scanner.',
    //         'scanner_id.*.exists' => 'The selected scanner is invalid.',
    //     ]);

    //     if ($validator->fails()) {
    //         \Log::error($validator->errors());
    //         return back()->withErrors($validator)->withInput();
    //     }

    //     $data = $request->all();

    //     if ($request->type == 'offline') {
    //         if (isset($request->scanner_id) && is_array($request->scanner_id)) {
    //             $data['scanner_id'] = implode(',', $request->scanner_id);
    //         } else {
    //             $data['scanner_id'] = '';
    //         }
    //     }

    //     $data['security'] = 1;

    //     if ($request->hasFile('image')) {
    //         $data['image'] = (new AppHelper)->saveImage($request);
    //     }

    //     if (!Auth::user()->hasRole('admin')) {
    //         $data['user_id'] = Auth::user()->id;
    //     }

    //     Event::create($data);
    //     return redirect()->route('events.index')->withStatus(__('Event has been added successfully.'));
    // }
    
    
    
    public function store(Request $request)
    {
        // Validate request data
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required|array|min:1|max:5',
            'image.*' => 'mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi|max:5120',
            'start_time' => 'required',
            'end_time' => 'required',
            'category_id' => 'required',
            'type' => 'required',
            'address' => 'required_if:type,offline',
            'lat' => 'required_if:type,offline',
            'lang' => 'required_if:type,offline',
            'scanner_id' => 'required_if:type,offline|array|min:1',
            'scanner_id.*' => 'exists:users,id',
            'status' => 'required',
            'url' => 'required_if:type,online',
            'description' => 'required',
            'people' => 'required',
            'label_id' => 'required',
        ], [
            'image.required' => 'At least one media file is required.',
            'image.array' => 'Media must be an array of files.',
            'image.min' => 'At least one media file is required.',
            'image.*.mimes' => 'Only jpeg, png, jpg, gif, webp, mp4, mov, avi files are allowed.',
            'image.*.max' => 'Each file must be less than 5MB.',
            'scanner_id.required_if' => 'The scanner field is required when the type is offline.',
            'scanner_id.array' => 'The scanner field must be an array.',
            'scanner_id.min' => 'You must select at least one scanner.',
            'scanner_id.*.exists' => 'The selected scanner is invalid.',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        $data = $request->except('image', 'scanner_id');
    
        // Handle scanner IDs for offline events
        if ($request->type == 'offline') {
            $data['scanner_id'] = $request->scanner_id ? implode(',', $request->scanner_id) : '';
        }
    
        // Handle multiple image uploads
        if ($request->hasFile('image')) {
            $imagePaths = [];
            foreach ($request->file('image') as $file) {
                $imagePaths[] = (new AppHelper)->saveFile($file);
            }
            $data['image'] = json_encode($imagePaths);
        }
    
        $data['urls'] = $request->urls;
        // Set user ID if not admin
        if (!Auth::user()->hasRole('admin')) {
            $data['user_id'] = Auth::user()->id;
        }
    
        // Create event
        Event::create($data);
    
        return redirect()->route('events.index')->with('status', __('Event has been added successfully.'));
    }


    public function show($event)
    {
        $event = Event::with(['category', 'organization'])->find($event);
        $event->ticket = Ticket::where([['event_id', $event->id], ['is_deleted', 0]])->orderBy('id', 'DESC')->get();
        (new AppHelper)->eventStatusChange();
        $event->sales = Order::with(['customer:id,first_name', 'ticket:id,name'])->where('event_id', $event->id)->orderBy('id', 'DESC')->get();
        foreach ($event->ticket as $value) {
            $value->used_ticket = Order::where('ticket_id', $value->id)->sum('quantity');
        }
        return view('admin.event.view', compact('event'));
    }

    public function edit(Event $event)
    {
        abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category = Category::where('status', 1)->orderBy('id', 'DESC')->with('subcategories')->get();
        $labels = label::all();
        $users = User::role('Organizer')->orderBy('id', 'DESC')->get();
        if (Auth::user()->hasRole('admin')) {
            $scanner = User::role('scanner')->orderBy('id', 'DESC')->get();
        } else if (Auth::user()->hasRole('Organizer')) {
            $scanner = User::role('scanner')->where('org_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        }
        $subcategory = Subcategory::where('id', $event->subcategory_id)->get();
        return view('admin.event.edit', compact('event', 'category', 'users', 'scanner','subcategory','labels'));
    }

    // public function update(Request $request, Event $event)
    // {

    //     $request->validate([
    //         'name' => 'bail|required',
    //         'start_time' => 'bail|required',
    //         'end_time' => 'bail|required',
    //         'category_id' => 'bail|required',
    //         'type' => 'bail|required',
    //         'address' => 'bail|required_if:type,offline',
    //         'lat' => 'bail|required_if:type,offline',
    //         'lang' => 'bail|required_if:type,offline',
    //         'status' => 'bail|required',
    //         'url' => 'bail|required_if:type,online',
    //         'description' => 'bail|required',
    //         'scanner_id' => 'bail|required_if:type,offline',
    //         'people' => 'bail|required',
    //         'label' => 'bail|required',
    //     ]);
    //     $data = $request->all();
    //     if ($request->type == 'offline') {
    //         $data['scanner_id'] = implode(',', $request->scanner_id);
    //     }
    //     if ($request->hasFile('image')) {
    //         (new AppHelper)->deleteFile($event->image);
    //         $data['image'] = (new AppHelper)->saveImage($request);
    //     }
    //     $event = Event::find($event->id)->update($data);
    //     return redirect()->route('events.index')->withStatus(__('Event has updated successfully.'));
    // }
    
    
    public function update(Request $request, Event $event)
    {

        $request->validate([
            'name' => 'bail|required',
            'start_time' => 'bail|required',
            'end_time' => 'bail|required',
            'category_id' => 'bail|required',
            'type' => 'bail|required',
            'address' => 'bail|required_if:type,offline',
            'lat' => 'bail|required_if:type,offline',
            'lang' => 'bail|required_if:type,offline',
            'status' => 'bail|required',
            'url' => 'bail|required_if:type,online',
            'description' => 'bail|required',
            'scanner_id' => 'bail|required_if:type,offline',
            'people' => 'bail|required',
            'label_id' => 'bail|required',
        ]);
    
        $data = $request->all();
    
        if ($request->type === 'offline') {
            $data['scanner_id'] = implode(',', $request->scanner_id);
        }
    
        // Load existing media
        $existingMedia = [];
    
        if (is_array($event->image)) {
            $existingMedia = $event->image;
        } elseif (is_string($event->image)) {
            $decoded = json_decode($event->image, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $existingMedia = $decoded;
            } elseif (!empty($event->image)) {
                $existingMedia = [$event->image];
            }
        }
    
        // Remove any media paths marked for deletion
        $removedMedia = $request->input('removed_media', []);
        if (!is_array($removedMedia)) {
            $removedMedia = [];
        }
    
        $existingMedia = array_filter($existingMedia, function ($path) use ($removedMedia) {
            return !in_array($path, $removedMedia);
        });
    
        // Upload and append new media
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $path = (new AppHelper)->saveFile($file); // your saveFile method handles images/videos
                $existingMedia[] = $path;
            }
        }
    
        // Update the event
        $data['image'] = json_encode(array_values($existingMedia)); // save cleaned-up array
        $event->update($data);
    
        return redirect()->route('events.index')->withStatus(__('Event has been updated successfully.'));
    }



    public function destroy(Event $event)
    {
        try {
            Event::find($event->id)->update(['is_deleted' => 1, 'event_status' => 'Deleted']);
            $ticket = Ticket::where('event_id', $event->id)->update(['is_deleted' => 1]);
            $banner = Banner::where('event_id', $event->id)->update(['status' => 0]);
            $coupon = Coupon::where('event_id', $event->id)->update(['status' => 0]);
            return true;
        } catch (Throwable $th) {
            return response('Data is Connected with other Data', 400);
        }
    }

    public function getMonthEvent(Request $request)
    {
        (new AppHelper)->eventStatusChange();
        $day = Carbon::parse($request->year . '-' . $request->month . '-01')->daysInMonth;
        if (Auth::user()->hasRole('Organizer')) {
            $data = Event::whereBetween('start_time', [$request->year . "-" . $request->month . "-01 12:00", $request->year . "-" . $request->month . "-" . $day . "  23:59"])
                ->where([['status', 1], ['is_deleted', 0], ['user_id', Auth::user()->id]])
                ->orderBy('id', 'DESC')
                ->get();
        }
        if (Auth::user()->hasRole('admin')) {
            $data = Event::whereBetween('start_time', [$request->year . "-" . $request->month . "-01 12:00", $request->year . "-" . $request->month . "-" . $day . " 23:59"])
                ->where([['status', 1], ['is_deleted', 0]])->orderBy('id', 'DESC')->get();
        }
        foreach ($data as $value) {
            $value->tickets = Ticket::where([['event_id', $value->id], ['is_deleted', 0]])->sum('quantity');
            $value->sold_ticket = Order::where('event_id', $value->id)->sum('quantity');
            $value->day = $value->start_time->format('D');
            $value->date = $value->start_time->format('d');
            $value->average = $value->tickets == 0 ? 0 : $value->sold_ticket * 100 / $value->tickets;
        }
        return response()->json(['data' => $data, 'success' => true], 200);
    }

    public function eventGallery($id)
    {
        $data = Event::find($id);
        return view('admin.event.gallery', compact('data'));
    }

    public function addEventGallery(Request $request)
    {
        $event = array_filter(explode(',', Event::find($request->id)->gallery));
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $name = uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            array_push($event, $name);
            Event::find($request->id)->update(['gallery' => implode(',', $event)]);
        }
        return true;
    }

    public function removeEventImage($image, $id)
    {

        $gallery = array_filter(explode(',', Event::find($id)->gallery));
        if (count(array_keys($gallery, $image)) > 0) {
            if (($key = array_search($image, $gallery)) !== false) {
                unset($gallery[$key]);
            }
        }
        $aa = implode(',', $gallery);
        $data = Event::find($id);
        $data->gallery = $aa;
        $data->update();
        return redirect()->back();
    }

    public function venueEvent_create($id)
    {
        $event = Event::find($id);
        $venues  = Venue::all();
        $venueAvailability  = VenueAvailability::all();
        $eventVenue = EventVenue::where('event_id', $id)->first();
        return view('admin.event.venue_create', compact('event','venues','venueAvailability','eventVenue'));
    }
    
    
    

     public function EventVenue_create(Request $request)
    {
        $request->validate([
            'event_id' => 'bail|required', 
            'venue_id' => 'bail|required', 
            'event_date' => 'bail|required', 
            'booking_date' => 'bail|required', 
            'is_active' => 'sometimes|boolean'
        ]);

        $eventVenue = EventVenue::where('event_id', $request->event_id)->first();

        if ($eventVenue) {
            $eventVenue->update($request->all());
            $message = 'Event Venue Updated Successfully!';
        } else {
            // Create new record
            EventVenue::create($request->all());
            $message = 'Event Venue Assigned Successfully!';
        }
        
       return redirect()
        ->route('event.venue', ['id' => $request->event_id])
        ->with('success', $message);
    }

    
}
