<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Event;
use App\Models\TermsAndConditions;
use App\Models\Module;
use Auth;
use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class TermAndConditionController extends Controller
{
    public function index($id, $name)
    {
        abort_if(Gate::denies('ticket_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $event = Event::find($id);
        $termsandconditions = TermsAndConditions::where([['event_id', $id], ['is_deleted', 0]])->orderBy('id', 'DESC')->get();
        return view('admin.termsandconditions.index', compact('termsandconditions', 'event'));
    }

    public function create($id)
    {
        abort_if(Gate::denies('ticket_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $event = Event::find($id);
        return view('admin.termsandconditions.create', compact('event'));
    }


    public function store(Request $request)
    {
        
        $request->validate([
            'description' => 'bail|required',
            
        ]);
        $data = $request->all();
        $event = Event::find($request->event_id);
        $data['user_id'] = $event->user_id;
        TermsAndConditions::create($data);

        return redirect($request->event_id . '/' . preg_replace('/\s+/', '-', $event->name) . '/termsandconditions')->withStatus(__('Terms And Conditions has added successfully.'));
    }

    public function show(TermsAndConditions $termsandconditions)
    {
    }

    public function edit($id)
    {
        abort_if(Gate::denies('ticket_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $termsandconditions = TermsAndConditions::find($id);
        $event = Event::find($termsandconditions->event_id);

        return view('admin.termsandconditions.edit', compact('termsandconditions', 'event'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'bail|required',
            
        ]);
        $data = $request->all();
        $event = Event::find($request->event_id);
        TermsAndConditions::find($id)->update($data);
        return redirect($request->event_id . '/' . preg_replace('/\s+/', '-', $event->name) . '/termsandconditions')->withStatus(__('Terms And Conditions has updated successfully.'));
    }

    public function destroy(TermsAndConditions $termsandconditions)
    {
    }

    public function deleteTermsAndConditions($id)
    {
        try {
            $termsandconditions = TermsAndConditions::find($id)->update(['is_deleted' => 1]);
            return true;
        } catch (Throwable $th) {
            return response('Data is Connected with other Data', 400);
        }
    }
}
