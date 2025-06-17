@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Edit Venue'),
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('venues.update', $venue->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">{{ __('Venue Name') }}</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ $venue->name }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="location">{{ __('Location') }}</label>
                                    <input type="text" id="location" name="location" class="form-control" value="{{ $venue->location }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="capacity">{{ __('Capacity') }}</label>
                                    <input type="number" id="capacity" name="capacity" class="form-control" value="{{ $venue->capacity }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="service_id">{{ __('Service Type') }}</label>
                                    <select name="service_id" id="service_id" class="form-control" required>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}" {{ $venue->service_id == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="is_active">{{ __('Is Active?') }}</label>
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $venue->is_active ? 'checked' : '' }}>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Update Venue') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
