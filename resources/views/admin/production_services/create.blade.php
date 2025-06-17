@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => 'Add Production Service'])

    <div class="section-body">
        <form action="{{ route('production-services.store') }}" method="POST">
            @csrf

            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="service_id">Service</label>
                        <select name="service_id" id="service_id" class="form-control">
                            <option value="">Select Service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><input type="checkbox" name="video_coverage" value="1"> Video Coverage</label>
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox" name="livestream_setup" value="1"> Livestream Setup</label>
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox" name="photography" value="1"> Photography</label>
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox" name="post_event_editing" value="1"> Post-event Editing</label>
                    </div>

                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
