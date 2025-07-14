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
use App\Models\EquipmentType;
use App\Models\EventEquipment;
use App\Http\Controllers\AppHelper;
use App\Models\User;
use App\Models\Fabrication;
use App\Models\EventFabrication;
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
            $events = Event::with(['category:id,name', 'label', 'subcategory'])->where([['is_deleted', 0], ['event_status', 'Pending']])->orderBy('id', 'DESC');

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
            $venues = Venue::all();
            $venueAvailability = VenueAvailability::all();


        } elseif (Auth::user()->hasRole('Organizer')) {
            $timezone = Setting::find(1)->timezone;
            $date = Carbon::now($timezone);
            $events = Event::with(['category:id,name', 'label', 'subcategory'])
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
        $latestEvent = Event::latest('id')->first();
        $canAddNew = $latestEvent && $latestEvent->final_submit;

        return view('admin.event.index', compact('events', 'canAddNew'));
    }

    public function create()
    {

        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = session('current_event_id');

        if (!empty($data)) {
            $data = Event::where('id', $data)->first();

        } else {
            $data = [];
        }

        $labels = label::all();
        $category = Category::where('status', 1)->orderBy('id', 'DESC')->with('subcategories')->get();
        $users = User::role('Organizer')->orderBy('id', 'DESC')->get();
        $venues = Venue::all();
        $venueAvailability = VenueAvailability::all();
        if (Auth::user()->hasRole('admin')) {
            $scanner = User::role('scanner')->orderBy('id', 'DESC')->get();
        } else if (Auth::user()->hasRole('Organizer')) {
            $scanner = User::role('scanner')->where('org_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        }
        return view('admin.event.create', compact('category', 'users', 'scanner', 'labels', 'venues', 'venueAvailability', 'data'));
    }


    // Controller method
    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'nullable|array|max:5',
            'image.*' => 'mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi|max:5120',
            'start_time' => 'required',
            'end_time' => 'required',
            'category_id' => 'required',
            'address' => 'required_if:type,offline',
            'lat' => 'required_if:type,offline',
            'lang' => 'required_if:type,offline',
            'scanner_id' => 'required_if:type,offline|array|min:1',
            'scanner_id.*' => 'exists:users,id',
            'status' => 'required',
            'url' => 'required_if:type,online',
            'description' => 'required',
            'people' => 'required|integer|min:1',
            'label_id' => 'required|exists:labels,id',
        ], [
            'image.array' => 'Media must be an array of files.',
            'image.*.mimes' => 'Only jpeg, png, jpg, gif, webp, mp4, mov, avi files are allowed.',
            'image.*.max' => 'Each file must be less than 5MB.',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Prepare $data except media
        $data = $request->except('image', 'existing_media', 'deleted_media', 'scanner_id');

        if ($request->type == 'offline') {
            $data['scanner_id'] = $request->scanner_id ? implode(',', $request->scanner_id) : '';
        }

        // Merge kept existing media + newly uploaded media
        $finalMedia = [];

        // 1. Keep existing media (except the deleted ones)
        $existing = $request->input('existing_media', []);
        $deleted = $request->input('deleted_media', []);
        $finalMedia = array_diff($existing, $deleted); // only keep the remaining ones

        // 2. Handle new file uploads
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $finalMedia[] = (new AppHelper)->saveFile($file); // Save and push to array
            }
        }

        $data['image'] = json_encode($finalMedia);
        $data['urls'] = $request->urls;

        if (!Auth::user()->hasRole('admin')) {
            $data['user_id'] = Auth::user()->id;
        }

        if ($request->has('subcategory_id')) {
            $data['subcategory_id'] = $request->subcategory_id;
        } else {
            $data['subcategory_id'] = null;
        }

        $event = Event::create($data);

        session([
            'current_event_id' => $event->id,
            'step' => 'step_1'
        ]);

        return redirect()->route('event.venue', ['id' => $event->id])
            ->with('success', __('First Step of Creating an Event is Complete, Now Add the Venue.'));
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

        if (empty($event)) {
            $data = session('current_event_id');
            if (!empty($data)) {
                $data = Event::where('id', $data)->first();

            } else {
                $data = [];
            }
            $category = Category::where('status', 1)->orderBy('id', 'DESC')->with('subcategories')->get();
            $labels = label::all();
            $users = User::role('Organizer')->orderBy('id', 'DESC')->get();
            if (Auth::user()->hasRole('admin')) {
                $scanner = User::role('scanner')->orderBy('id', 'DESC')->get();
            } else if (Auth::user()->hasRole('Organizer')) {
                $scanner = User::role('scanner')->where('org_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
            }
            $subcategory = Subcategory::where('id', $event->subcategory_id)->get();
            return view('admin.event.create', compact('event', 'category', 'users', 'scanner', 'subcategory', 'labels', 'data'));

        } else {

            $data = $event->id;
            if (!empty($data)) {
                $data = Event::where('id', $data)->first();

            } else {
                $data = [];
            }
            $data = Event::where('id', $event->id)->first();
            $category = Category::where('status', 1)->orderBy('id', 'DESC')->with('subcategories')->get();
            $labels = label::all();
            $users = User::role('Organizer')->orderBy('id', 'DESC')->get();
            if (Auth::user()->hasRole('admin')) {
                $scanner = User::role('scanner')->orderBy('id', 'DESC')->get();
            } else if (Auth::user()->hasRole('Organizer')) {
                $scanner = User::role('scanner')->where('org_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
            }
            $subcategory = Subcategory::where('id', $event->subcategory_id)->get();
            return view('admin.event.create', compact('event', 'category', 'users', 'scanner', 'subcategory', 'labels', 'data'));

        }
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


    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'nullable|array|max:5',
            'image.*' => 'mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi|max:5120',
            'start_time' => 'required',
            'end_time' => 'required',
            'category_id' => 'required',
            'address' => 'required_if:type,offline',
            'lat' => 'required_if:type,offline',
            'lang' => 'required_if:type,offline',
            'scanner_id' => 'required_if:type,offline|array|min:1',
            'scanner_id.*' => 'exists:users,id',
            'status' => 'required',
            'url' => 'required_if:type,online',
            'description' => 'required',
            'people' => 'required|integer|min:1',
            'label_id' => 'required|exists:labels,id',
        ], [
            'image.array' => 'Media must be an array of files.',
            'image.*.mimes' => 'Only jpeg, png, jpg, gif, webp, mp4, mov, avi files are allowed.',
            'image.*.max' => 'Each file must be less than 5MB.',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except('image', 'existing_media', 'deleted_media', 'scanner_id');

        if ($request->type == 'offline') {
            $data['scanner_id'] = $request->scanner_id ? implode(',', $request->scanner_id) : '';
        }

        // Merge existing and new media files
        $existing = $request->input('existing_media', []);
        $deleted = $request->input('deleted_media', []);
        $finalMedia = array_diff($existing, $deleted);

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $finalMedia[] = (new AppHelper)->saveFile($file);
            }
        }

        $data['image'] = json_encode($finalMedia);
        $data['urls'] = $request->urls;

        if (!Auth::user()->hasRole('admin')) {
            $data['user_id'] = Auth::user()->id;
        }

        $event->update($data);

        session([
            'current_event_id' => $event->id,
            'step' => 'step_1'
        ]);

        return redirect()->route('event.venue', ['id' => $event->id])
            ->with('success', __('First Step of Creating an Event is Updated, Now Continue to the Venue.'));
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

        $venue = EventVenue::with('event')->where('id', $id)->first();
        if (!empty($venue)) {
            $data = $venue;
            $event = Event::find($venue->id);
            $venues = Venue::all();
            $venueAvailability = VenueAvailability::all();
            $eventVenue = EventVenue::where('event_id', $id)->first();
            return view('admin.event.venue_create', compact('event', 'venues', 'venueAvailability', 'eventVenue', 'data'));

        } else {
            $session_data = session()->get('current_venue_data');

            if (!empty($session_data)) {
                $data = EventVenue::with('event')->where('id', $session_data)->first();

            } else {
                $data = [];
            }
            $event = Event::find($id);
            $venues = Venue::all();
            $venueAvailability = VenueAvailability::all();
            $eventVenue = EventVenue::where('event_id', $id)->first();
            return view('admin.event.venue_create', compact('event', 'venues', 'venueAvailability', 'eventVenue', 'data'));
        }

    }
    public function EventVenue_create(Request $request)
    {
        $request->validate([
            'event_id' => 'bail|required',
            'event_date' => 'bail|required',
        ]);

        $data = $request->all();



        $event_venue = EventVenue::create([
            'event_id' => $request->event_id,
            'event_date' => $request->event_date,
            'venue_id' => $request->venue_id // optional field
        ]);

        session()->put('current_venue_data', $event_venue->id);


        return redirect()
            ->route('event.fabrication', ['id' => $request->event_id])
            ->with('success', 'This step is complete, now proceed with fabrication');
    }
    public function EventVenue_update(Request $request, $id)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'event_date' => 'required|date',
            'venue_id' => 'nullable|exists:venues,id', // venue_id is optional
        ]);

        $eventVenue = EventVenue::findOrFail($id);

        $eventVenue->update([
            'event_id' => $request->event_id,
            'event_date' => $request->event_date,
            'venue_id' => $request->venue_id,
        ]);

        session()->put('current_venue_data', $eventVenue->id);

        return redirect()
            ->route('event.fabrication', ['id' => $request->event_id])
            ->with('success', 'Venue updated successfully. Now proceed with fabrication.');
    }


    public function event_fabrication($id)
    {
        $fabrication = EventFabrication::where('event_id', $id)->first();
        if (!empty($fabrication)) {
            $data = $fabrication;
            $event = Event::find($id);
            $fabric_type = Fabrication::where('fabrication_type', 'Fabric Backdrops')->get();

            $fabric_table_cloths = Fabrication::where('fabrication_type', 'Table Cloths')->get();
            $fabric_drapes = Fabrication::where('fabrication_type', 'Drapes')->get();
            return view('admin.event.fabrication', compact('event', 'fabric_type', 'fabric_table_cloths', 'fabric_drapes', 'data'));
        } else {

            $fabrication_data = session()->get('current_fabrication_date');

            if (!empty($fabrication_data)) {
                $data = EventFabrication::where('id', $fabrication_data)->first();
            } else {
                $data = [];
            }
            $event = Event::find($id);
            $fabric_type = Fabrication::where('fabrication_type', 'Fabric Backdrops')->get();

            $fabric_table_cloths = Fabrication::where('fabrication_type', 'Table Cloths')->get();
            $fabric_drapes = Fabrication::where('fabrication_type', 'Drapes')->get();
            return view('admin.event.fabrication', compact('event', 'fabric_type', 'fabric_table_cloths', 'fabric_drapes', 'data'));
        }
    }
    public function Eventfabrication_create(Request $request)
    {
        $request->validate([
            'event_id' => 'bail|required',
            'custom_fabric_image.*' => 'image|mimes:jpeg,png,jpg|max:5120', // 5MB max for each image
        ]);

        $data = [
            'event_id' => $request->event_id,
            'fabric_type' => $request->fabric_type,
            'tablecloths' => $request->tablecloths,
            'drapes_style' => $request->drapes_style,
            'fabric_color' => $request->fabric_color,
            'fabric_quantity' => $request->fabric_quantity,
        ];


        if ($request->hasFile('custom_fabric_image')) {
            $imagePaths = [];
            foreach ($request->file('custom_fabric_image') as $image) {
                $path = $image->store('fabric_images', 'public');
                $imagePaths[] = $path;
            }
            $data['custom_fabric_image'] = json_encode($imagePaths);
        }



        $fabrication = EventFabrication::create($data);

        session()->put('current_fabrication_date', $fabrication->id);

        return redirect()
            ->route('event.accessories', ['id' => $request->event_id])
            ->with('success', 'This step is complete, now proceed with Accessories');
    }
    public function Eventfabrication_update(Request $request, $id)
    {
        $request->validate([
            'event_id' => 'bail|required',
            'custom_fabric_image.*' => 'image|mimes:jpeg,png,jpg|max:5120', // 5MB max per image
        ]);

        $fabrication = EventFabrication::findOrFail($id);

        $data = [
            'event_id' => $request->event_id,
            'fabric_type' => $request->fabric_type,
            'tablecloths' => $request->tablecloths,
            'drapes_style' => $request->drapes_style,
            'fabric_color' => $request->fabric_color,
            'fabric_quantity' => $request->fabric_quantity,
        ];

        $existingImages = json_decode($fabrication->custom_fabric_image, true) ?? [];

        // Upload new images (if any) and merge with existing
        if ($request->hasFile('custom_fabric_image')) {
            foreach ($request->file('custom_fabric_image') as $image) {
                $path = $image->store('fabric_images', 'public');
                $existingImages[] = $path;
            }
        }

        $data['custom_fabric_image'] = json_encode($existingImages);

        $fabrication->update($data);

        session()->put('current_fabrication_date', $fabrication->id);

        return redirect()
            ->route('event.accessories', ['id' => $request->event_id])
            ->with('success', 'Fabrication details updated successfully. Now proceed to Accessories.');
    }


    public function event_accessories($id)
    {

        $eventEquipment = EventEquipment::where('event_id', $id)->first();
        if (!empty($eventEquipment)) {
            $data = $eventEquipment;
            $event = Event::find($id);
            $equipment_types = EquipmentType::all();

            $soundSystems = Equipment::where(
                'equipment_type_id',
                EquipmentType::where('name', 'Sound Systems')->first()->id
            )
                ->get();

            $cameras = Equipment::where(
                'equipment_type_id',
                EquipmentType::where('name', 'Camera')->first()->id
            )
                ->get();

            $lighting = Equipment::where(
                'equipment_type_id',
                EquipmentType::where('name', 'Lighting')->first()->id
            )
                ->get();

            $audioVisual = Equipment::where(
                'equipment_type_id',
                EquipmentType::where('name', 'Audio-Visual')->first()->id
            )
                ->get();

            return view('admin.event.equipment', compact(
                'event',
                'equipment_types',
                'soundSystems',
                'cameras',
                'lighting',
                'audioVisual',
                'data'
            ));
        } else {
            $session_data = session()->get('current_accessories_date');
            if (!empty($session_data)) {
                $data = EventEquipment::where('id', $session_data)->first();
            } else {
                $data = [];
            }
            $event = Event::find($id);
            $equipment_types = EquipmentType::all();

            $soundSystems = Equipment::where(
                'equipment_type_id',
                EquipmentType::where('name', 'Sound Systems')->first()->id
            )
                ->get();

            $cameras = Equipment::where(
                'equipment_type_id',
                EquipmentType::where('name', 'Camera')->first()->id
            )
                ->get();

            $lighting = Equipment::where(
                'equipment_type_id',
                EquipmentType::where('name', 'Lighting')->first()->id
            )
                ->get();

            $audioVisual = Equipment::where(
                'equipment_type_id',
                EquipmentType::where('name', 'Audio-Visual')->first()->id
            )
                ->get();

            return view('admin.event.equipment', compact(
                'event',
                'equipment_types',
                'soundSystems',
                'cameras',
                'lighting',
                'audioVisual',
                'data'
            ));
        }

    }

    public function EventAccessories_create(Request $request)
    {
        $request->validate([
            'event_id' => 'bail|required'
        ]);

        $data = [
            'event_id' => $request->event_id,
            'camera_accessories' => $request->camera_accessories,
            'sound_system' => $request->sound_system,
            'lighting' => $request->lighting,
            'av_equipment' => $request->av_equipment,
            'additional_requirements' => $request->additional_requirements,
        ];

        $event_equipment = EventEquipment::create($data);

        session()->put('current_accessories_date', $event_equipment->id);

        return redirect()
            ->route('event.final_submit', ['id' => $request->event_id])
            ->with('success', 'Final Submission Step: This is your last opportunity to review all event details.');
    }

    public function EventAccessories_update(Request $request, $id)
    {
        $request->validate([
            'event_id' => 'bail|required'
        ]);

        $eventEquipment = EventEquipment::findOrFail($id);

        $data = [
            'event_id' => $request->event_id,
            'camera_accessories' => $request->camera_accessories,
            'sound_system' => $request->sound_system,
            'lighting' => $request->lighting,
            'av_equipment' => $request->av_equipment,
            'additional_requirements' => $request->additional_requirements,
        ];

        $eventEquipment->update($data);

        session()->put('current_accessories_date', $eventEquipment->id);

        return redirect()
            ->route('event.final_submit', ['id' => $request->event_id])
            ->with('success', 'Accessories updated successfully. Now proceed to Final Submission.');
    }


    public function event_final_submit($id)
    {
        $event = Event::with(['category', 'subcategory'])->findOrFail($id);
        $eventVenue = EventVenue::with(['venue'])
            ->where('event_id', $id)
            ->first();
        $eventFabrication = EventFabrication::with(['tablecloth', 'drapesStyle', 'fabricType'])
            ->where('event_id', $id)
            ->first();

        // Fabrication details
        $fabricDetails = [];
        if ($eventFabrication) {
            if ($eventFabrication->fabricType) {
                $fabricDetails['fabric_type'] = [
                    'name' => $eventFabrication->fabricType->name,
                    'description' => $eventFabrication->fabricType->description
                ];
            }
            if ($eventFabrication->tablecloth) {
                $fabricDetails['tablecloths'] = [
                    'name' => $eventFabrication->tablecloth->name,
                    'description' => $eventFabrication->tablecloth->description
                ];
            }
            if ($eventFabrication->drapesStyle) {
                $fabricDetails['drapes_style'] = [
                    'name' => $eventFabrication->drapesStyle->name,
                    'description' => $eventFabrication->drapesStyle->description
                ];
            }
        }

        // Equipment details
        $equipmentDetails = [];
        $eventEquipment = EventEquipment::with([
            'cameraAccessories',
            'soundSystem',
            'lightingEquipment',
            'avEquipment'
        ])->where('event_id', $id)->first();

        if ($eventEquipment) {
            if ($eventEquipment->cameraAccessories) {
                $equipmentDetails['camera_accessories'] = [
                    'name' => $eventEquipment->cameraAccessories->name,
                    'description' => $eventEquipment->cameraAccessories->description ?? ''
                ];
            }
            if ($eventEquipment->soundSystem) {
                $equipmentDetails['soundSystem'] = [
                    'name' => $eventEquipment->soundSystem->name,
                    'price' => $eventEquipment->soundSystem->price ?? ''
                ];
            }
            if ($eventEquipment->lightingEquipment) {

                $equipmentDetails['lighting'] = [
                    'name' => $eventEquipment->lightingEquipment->name,
                    'price' => $eventEquipment->lightingEquipment->price ?? ''
                ];
            }
            if ($eventEquipment->avEquipment) {
                $equipmentDetails['av_equipment'] = [
                    'name' => $eventEquipment->avEquipment->name,
                    'price' => $eventEquipment->avEquipment->price ?? ''
                ];
            }
            if ($eventEquipment->cameraAccessories) {
                $equipmentDetails['camera_accessories'] = [
                    'name' => $eventEquipment->cameraAccessories->name,
                    'price' => $eventEquipment->cameraAccessories->price ?? ''
                ];
            }
        }

        return view('admin.event.final_submit', compact(
            'event',
            'eventVenue',
            'eventFabrication',
            'eventEquipment',
            'fabricDetails',
            'equipmentDetails'
        ));
    }



    public function finalSubmit(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update(['final_submit' => true]);

        session()->forget([
            'current_event_id',
            'current_venue_data',
            'current_fabrication_date',
            'current_accessories_date'
        ]);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event has been successfully created and is now pending approval.');
    }


}
