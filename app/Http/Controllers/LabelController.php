<?php

namespace App\Http\Controllers;

use App\Models\label;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('label_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $labels = label::OrderBy('id','DESC')->get();
        return view('admin.labels.index', compact('labels'));
    }

    public function create()
    {
        abort_if(Gate::denies('label_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.labels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
        ]);
        $data = $request->all();

        label::create( $data);
        return redirect()->route('label.index')->withStatus(__('Label has added successfully.'));
    }

    public function edit(label $label)
    {
        abort_if(Gate::denies('label_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.labels.edit', compact( 'label'));
    }

    public function update(Request $request, label $label)
    {

        $request->validate([
            'name' => 'bail|required',
        ]);
        $data = $request->all();
        
        label::find($label->id)->update( $data);
        return redirect()->route('label.index')->withStatus(__('Label has updated successfully.'));
    }

    public function destroy($id)
    {
        $label = label::findOrFail($id);
    
        $label->delete();
    
        return redirect()->route('label.index')->with('success', 'Labeldeleted successfully.');
    }
    

}
