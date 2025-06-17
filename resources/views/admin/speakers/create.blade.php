{{-- resources/views/admin/speakers/create.blade.php --}}

@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => __('Add New Speaker'),
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
                        <h4 class="section-title mt-0">{{ __('Add New Speaker') }}</h4>
                        <form action="{{ route('speakers.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="service_id">{{ __('Service Type') }}</label>
                                <select name="service_id" class="form-control" required>
                                    <option value="" disabled selected>{{ __('Select Service Type') }}</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="topic">{{ __('Topic') }}</label>
                                <input type="text" name="topic" id="topic" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="experience_years">{{ __('Experience Years') }}</label>
                                <input type="number" name="experience_years" id="experience_years" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="language">{{ __('Language') }}</label>
                                <input type="text" name="language" id="language" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="category">{{ __('Category') }}</label>
                                <input type="text" name="category" id="category" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="fee">{{ __('Fee') }}</label>
                                <input type="number" name="fee" id="fee" class="form-control" step="0.01">
                            </div>
                            <div class="form-group">
                                <label for="available_from">{{ __('Available From') }}</label>
                                <input type="date" name="available_from" id="available_from" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="available_to">{{ __('Available To') }}</label>
                                <input type="date" name="available_to" id="available_to" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="status">{{ __('Status') }}</label>
                                <select name="status" class="form-control">
                                    <option value="1" selected>{{ __('Active') }}</option>
                                    <option value="0">{{ __('Inactive') }}</option>
                                </select>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">{{ __('Save Speaker') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
