@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Venue Gallery'),
            'headerData' => __('Venue'),
            'url' => 'venues',
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title"> {{ __('Venue Gallery') }}</h2>
                </div>
            </div>
                @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-lg-12 form-group">
                                    
                                    
                                    <!-- New Form for Image Upload -->
                                    <form action="{{ route('venue.image.store') }}" method="POST" enctype="multipart/form-data" id="galleryForm">
                                        @csrf
                                        <input type="hidden" name="venue_id" value="{{ $venue->id }}">
                                        
                                        <div class="form-group">
                                            <label for="gallery_images">{{ __('Upload Images') }}</label>
                                            <div class="custom-file">
                                                <input type="file" name="images[]" class="custom-file-input" id="gallery_images" multiple accept="image/*">
                                                <label class="custom-file-label" for="gallery_images">{{ __('Choose files') }}</label>
                                            </div>
                                            <small class="form-text text-muted">
                                                {{ __('You can upload multiple images at once. Maximum file size: 2MB each.') }}
                                            </small>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> {{ __('Save Images') }}
                                            </button>
                                            <a href="{{ route('venues.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left"></i> {{ __('Back') }}
                                            </a>
                                        </div>
                                    </form>


                                    <div class="image-gallery mt-5">
                                        <div class="row">
                                           @foreach ($images as $image)
                                                <div class="col-sm-2 col-6 mb-3">
                                                    <div class="gallery-item position-relative">
                                                        <img src="{{ asset('storage/venue_gallery/' . $image->image) }}" 
                                                            class="img-fluid rounded" 
                                                            alt="Gallery Image" style="width: 150px; height: 150px; object-fit: cover;">
                                                        <form action="{{ route('venue.image.destroy', $image->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-danger btn-sm position-absolute" 
                                                                    style="top: 5px; right: 5px; z-index: 10; "
                                                                    onclick="return confirm('Are you sure you want to delete this image?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

