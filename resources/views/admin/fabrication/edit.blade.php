@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', ['title' => __('Edit Fabrication')])

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Edit Fabrication') }}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('fabrications.update', $fabrication->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @include('admin.fabrication.form', ['fabrication' => $fabrication])
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                    <a href="{{ route('fabrications.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
