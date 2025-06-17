@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Edit SubCategory'),
            'headerData' => __('SubCategory'),
            'url' => 'subcategory',
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title">{{ __('Edit SubCategory') }}</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('subcategory.update', $subcategory->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <!-- Image Field -->
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>{{ __('Image') }} ({{ __('Ratio : 2:1') }})</label>
                                            <div id="image-preview" class="image-preview" style="background-image: url({{ url('images/upload/' . $subcategory->image) }})">
                                                <label for="image-upload" id="image-label"> <i class="fas fa-plus"></i></label>
                                                <input type="file" name="image" id="image-upload" class="form-control @error('image') is-invalid @enderror" />
                                            </div>
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Name and Category Fields -->
                                    <div class="col-lg-9">
                                        <!-- Subcategory Name -->
                                        <div class="form-group">
                                            <label>{{ __('Name') }}</label>
                                            <input type="text" name="name" placeholder="{{ __('SubCategory Name') }}" value="{{ old('name', $subcategory->name) }}"
                                                class="form-control @error('name') is-invalid @enderror">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Parent Category Dropdown -->
                                        <div class="form-group">
                                            <label>{{ __('Parent Category') }}</label>
                                            <select name="category_id" class="form-control select2 @error('category_id') is-invalid @enderror" required>
                                                <option value="">{{ __('Select Category') }}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Status Dropdown -->
                                        <div class="form-group">
                                            <label>{{ __('Status') }}</label>
                                            <select name="status" class="form-control select2 @error('status') is-invalid @enderror">
                                                <option value="1" {{ old('status', $subcategory->status) == '1' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                                <option value="0" {{ old('status', $subcategory->status) == '0' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
