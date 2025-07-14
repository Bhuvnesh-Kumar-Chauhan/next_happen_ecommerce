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
                            <form action="{{ route('venues.update', $venue->id) }}" method="POST" enctype="multipart/form-data">
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

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ __('Price') }}</label>
                                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" required
                                            value="{{ $venue->price }}">
                                             @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ __('Offer Price') }}</label>
                                            <input type="number" name="offer_price" class="form-control @error('offer_price') is-invalid @enderror" required
                                            value="{{ $venue->offer_price }}">
                                            @error('offer_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                   <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="venue_type">{{ __('Venue Type') }}</label>
                                        <select name="venue_type" id="venue_type" class="form-control" required>
                                            <option value="indoor" {{ old('venue_type', $venue->venue_type) == 'indoor' ? 'selected' : '' }}>Indoor</option>
                                            <option value="outdoor" {{ old('venue_type', $venue->venue_type) == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                                            <option value="hybrid" {{ old('venue_type', $venue->venue_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                        </select>
                                    </div>
                                </div>
                                </div>

                              

                                <!-- Display existing video -->
                                @if($venue->video)
                                    <div class="form-group">
                                        <label>{{ __('Existing Video') }}</label>
                                        <div class="d-flex align-items-center">
                                            <video  controls style="max-width: 300px; max-height: 200px;">
                                                <source src="{{ asset('storage/' . $venue->video) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        
                                        </div>
                                    </div>
                                @endif

                                <!-- New Row for Video & Images -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('Upload New Video') }}</label>
                                            <input type="file" name="venue_video" class="form-control" accept="video/*">
                                        </div>
                                    </div>
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

    <script>
        function removeImage(button, imagePath) {
            // Add to removed images list
            const removedInput = document.getElementById('removed_images');
            let removed = removedInput.value ? JSON.parse(removedInput.value) : [];
            removed.push(imagePath);
            removedInput.value = JSON.stringify(removed);
            
            // Remove from UI
            button.parentElement.remove();
        }

        function removeVideo() {
            document.getElementById('remove_video').value = '1';
            document.querySelector('[onclick="removeVideo()"]').parentElement.querySelector('video').remove();
            document.querySelector('[onclick="removeVideo()"]').remove();
        }
    </script>
@endsection