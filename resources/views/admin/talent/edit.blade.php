@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Edit Talent'),
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('talent.update', $talent->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">{{ __('Category Name') }}</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $talent->name }}" required>
                                     @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label for="talent_category_id">{{ __('Talent Category') }}</label>
                                    <select name="talent_category_id" id="talent_category_id" class="form-control @error('talent_category_id') is-invalid @enderror" required>  
                                        <option value="">-- Select Category --</option>
                                        @foreach ($talent_cat as $category)
                                            <option value="{{ $category->id}}" {{ $category->id == $talent->talent_category_id ? 'selected' : '' }}>{{ $category->name}}</option> 
                                        @endforeach
                                       
                                    </select>
                                     @error('talent_category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                              </div>

                               
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rate">{{ __('Rate') }}</label>
                                            <input type="number" id="rate" name="rate" class="form-control @error('rate') is-invalid @enderror" required
                                            value="{{ $talent->rate }}">
                                             @error('rate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                         <div class="form-group">
                                            <label for="offered_rate">{{ __('Offered Rate') }}</label>
                                            <input type="number" id="offered_rate" name="offered_rate" class="form-control @error('offered_rate') is-invalid @enderror" required
                                            value="{{ $talent->offered_rate }}">
                                             @error('offered_rate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="audience_type">{{ __('Audience Type') }}</label>
                                            <select name="audience_type" id="audience_type" class="form-control" required>  
                                              <option value="">-- Select Audience Type --</option>
                                                <option value="bollywood" {{ $talent->audience_type == 'bollywood' ? 'selected' : '' }}>Bollywood</option>
                                                <option value="regional" {{ $talent->audience_type == 'regional' ? 'selected' : '' }}>Regional</option>
                                                <option value="business" {{ $talent->audience_type == 'business' ? 'selected' : '' }}>Business</option>
                                            </select>
                                        </div>
                                    </div>

                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('Upload Image') }}</label>
                                            <input type="file" name="talent_image" class="form-control" accept="image/*">
                                        </div>
                                    </div>
                                </div>

                                

                                <div class="form-group">
                                    <label for="is_active">{{ __('Is Active?') }}</label>
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $talent->is_active ? 'checked' : '' }}>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Update Talent') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
