{{-- resources/views/admin/speakers/edit.blade.php --}}

@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => __('Edit Speaker'),
    ])

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="section-title mt-0">{{ __('Edit Speaker') }}</h4>
                        <form action="{{ route('speakers.update', $speaker->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="service_id">{{ __('Service Type') }}</label>
                                <select name="service_id" class="form-control" required>
                                    <option value="" disabled selected>{{ __('Select Service Type') }}</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ $speaker->service_id == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $speaker->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="topic">{{ __('Topic') }}</label>
                                <input type="text" name="topic" id="topic" class="form-control" value="{{ old('topic', $speaker->topic) }}">
                            </div>
                            <div class="form-group">
                                <label for="experience_years">{{ __('Experience Years') }}</label>
                                <input type="number" name="experience_years" id="experience_years" class="form-control" value="{{ old('experience_years', $speaker->experience_years) }}">
                            </div>
                            <div class="form-group">
                                <label for="language">{{ __('Language') }}</label>
                                <input type="text" name="language" id="language" class="form-control" value="{{ old('language', $speaker->language) }}">
                            </div>
                            <div class="form-group">
                                <label for="category">{{ __('Category') }}</label>
                                <input type="text" name="category" id="category" class="form-control" value="{{ old('category', $speaker->category) }}">
                            </div>
                            <div class="form-group">
                                <label for="fee">{{ __('Fee') }}</label>
                                <input type="number" name="fee" id="fee" class="form-control" value="{{ old('fee', $speaker->fee) }}" step="0.01">
                            </div>
                            <div class="form-group">
                                <label for="available_from">{{ __('Available From') }}</label>
                                <input type="date" name="available_from" id="available_from" class="form-control" value="{{ old('available_from', $speaker->available_from) }}">
                            </div>
                            <div class="form-group">
                                <label for="available_to">{{ __('Available To') }}</label>
                                <input type="date" name="available_to" id="available_to" class="form-control" value="{{ old('available_to', $speaker->available_to) }}">
                            </div>
                            <div class="form-group">
                                <label for="status">{{ __('Status') }}</label>
                                <select name="status" class="form-control">
                                    <option value="1" {{ $speaker->status == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="0" {{ $speaker->status == 0 ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                </select>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">{{ __('Update Speaker') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
