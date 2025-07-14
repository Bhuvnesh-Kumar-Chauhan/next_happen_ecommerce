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
                            <form action="{{ route('services.store') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="name">{{ __('Service Name') }}</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="service_category_id">{{ __('Service Category') }}</label>
                                    <select name="service_category_id" id="service_category_id" class="form-control @error('service_category_id') is-invalid @enderror" required>
                                        <option value="">-- Select Service Category --</option>
                                        @foreach ($ServiceCategories as $category)
                                            <option value="{{ $category->id }}" {{ old('service_category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('service_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price">{{ __('Price') }}</label>
                                            <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror" required value="{{ old('price') }}">
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="offered_price">{{ __('Offered Price') }}</label>
                                            <input type="number" id="offered_price" name="offered_price" class="form-control @error('offered_price') is-invalid @enderror" required value="{{ old('offered_price') }}">
                                            @error('offered_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="is_active">{{ __('Is Active?') }}</label>
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Save Service') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection