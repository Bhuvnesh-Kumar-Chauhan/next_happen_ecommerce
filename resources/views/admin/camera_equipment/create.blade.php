@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => __('Add Camera Equipment'),
    ])

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('camera-equipments.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Type') }}</label>
                                <input type="text" name="type" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>{{ __('Lens Support') }}</label><br>
                                <input type="checkbox" name="lens_support" value="1">
                                <label>{{ __('Yes') }}</label>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Accessories') }}</label>
                                <textarea name="accessories" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Status') }}</label>
                                <select name="is_active" class="form-control">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Inactive') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
