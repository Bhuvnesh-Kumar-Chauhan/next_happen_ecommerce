<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Event;
use App\Models\Disclaimer;
use App\Models\Module;
use Auth;
use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class DisclaimerController extends Controller
{
    public function index($id, $name)
    {
        abort_if(Gate::denies('ticket_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $event = Event::find($id);
        $disclaimers = Disclaimer::where([['event_id', $id], ['is_deleted', 0]])->orderBy('id', 'DESC')->get();
        return view('admin.disclaimers.index', compact('disclaimers', 'event'));
    }

    public function create($id)
    {
        abort_if(Gate::denies('ticket_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $event = Event::find($id);
        return view('admin.disclaimers.create', compact('event'));
    }


    public function store(Request $request)
    {
        
        $request->validate([
            'disclaimer' => 'bail|required',
            
        ]);
        $data = $request->all();
        $event = Event::find($request->event_id);
        $data['user_id'] = $event->user_id;
        Disclaimer::create($data);

        return redirect($request->event_id . '/' . preg_replace('/\s+/', '-', $event->name) . '/disclaimer')->withStatus(__('Disclaimer has added successfully.'));
    }

    public function show(Disclaimer $disclaimers)
    {
    }

    public function edit($id)
    {
        abort_if(Gate::denies('ticket_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $disclaimers = Disclaimer::find($id);
        $event = Event::find($disclaimers->event_id);

        return view('admin.disclaimers.edit', compact('disclaimers', 'event'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'disclaimer' => 'bail|required',
            
        ]);
        $data = $request->all();
        $event = Event::find($request->event_id);
        Disclaimer::find($id)->update($data);
        return redirect($request->event_id . '/' . preg_replace('/\s+/', '-', $event->name) . '/disclaimer')->withStatus(__('Disclaimer has updated successfully.'));
    }

    public function destroy(Disclaimer $disclaimers)
    {
    }

    public function deleteDisclaimer($id)
    {
        try {
            $disclaimers = Disclaimer::find($id)->update(['is_deleted' => 1]);
            return true;
        } catch (Throwable $th) {
            return response('Data is Connected with other Data', 400);
        }
    }
}
