@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Add Service'),
            'headerData' => __('Service'),
            'url' => 'service',
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title"> {{ __('Add Service') }}</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="{{ url('service') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>{{ __('Name') }}</label>
                                            <input type="text" name="name" placeholder="{{ __('Name') }}"
                                                value="{{ old('name') }}"
                                                class="form-control @error('name')? is-invalid @enderror">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" 
                                                      class="form-control @error('description') is-invalid @enderror" 
                                                      rows="3">{{ old('description', $service->description ?? '') }}</textarea>
                                            @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="checkbox" name="is_active" id="is_active" 
                                                       class="form-check-input" 
                                                       {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">Active Service</label>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary demo-button">{{ __('Submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
