@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Add New Venue'),
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('venues.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="name">{{ __('Venue Name') }}</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="location">{{ __('Location') }}</label>
                                    <input type="text" id="location" name="location" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="capacity">{{ __('Capacity') }}</label>
                                    <input type="number" id="capacity" name="capacity" class="form-control" required>
                                </div>

                                 

                                <!-- Existing Row -->
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ __('Price') }}</label>

                                            <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror" required value="{{ old('price') }}">
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ __('Offer Price') }}</label>
                                            <input type="number" id="offer_price" name="offer_price" class="form-control @error('offer_price') is-invalid @enderror" required value="{{ old('offer_price') }}">
                                            @error('offer_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="service_id">{{ __('Venue Type') }}</label>
                                            <select name="venue_type" id="venue_type" class="form-control" required>  
                                                <option value="indoor">Indoor</option>
                                                <option value="outdoor">Outdoor</option>
                                                <option value="hybrid">Hybrid</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- New Row for Video & Images -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('Upload Video') }}</label>
                                            <input type="file" name="venue_video" class="form-control" accept="video/*">
                                        </div>
                                    </div>

                                    
                                </div>

                                <div class="form-group">
                                    <label for="is_active">{{ __('Is Active?') }}</label>
                                    <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Save Venue') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
