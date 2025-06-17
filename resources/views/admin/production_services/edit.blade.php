@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => 'Edit Production Service'])

    <div class="section-body">
        <form action="{{ route('production-services.update', $production_service->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="service_id">Service</label>
                        <select name="service_id" id="service_id" class="form-control">
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ $production_service->service_id == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><input type="checkbox" name="video_coverage" value="1" {{ $production_service->video_coverage ? 'checked' : '' }}> Video Coverage</label>
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox" name="livestream_setup" value="1" {{ $production_service->livestream_setup ? 'checked' : '' }}> Livestream Setup</label>
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox" name="photography" value="1" {{ $production_service->photography ? 'checked' : '' }}> Photography</label>
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox" name="post_event_editing" value="1" {{ $production_service->post_event_editing ? 'checked' : '' }}> Post-event Editing</label>
                    </div>

                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $production_service->notes) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ $production_service->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $production_service->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
