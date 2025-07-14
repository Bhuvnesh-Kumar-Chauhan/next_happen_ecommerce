@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', ['title' => __('Add Fabrication')])

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {{--  --}}
                            <form action="{{ route('fabrication.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="card-body">
                                        <div class="form-group">
                                            <label>{{ __('Type') }}</label>
                                            <select class="form-control" name="fabrication_type" required>
                                                <option value="">{{ __('Select Type') }}</option>
                                                <option value="Fabric Backdrops">{{ __('Fabric Backdrops') }}</option>
                                                <option value="Table Cloths">{{ __('Table Cloths') }}</option>
                                                <option value="Drapes ">{{ __('Drapes') }}</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>{{ __('Name') }}</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>{{ __('Description') }}</label>
                                            <textarea name="description" class="form-control" rows="3"></textarea>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>{{ __('Images') }}</label>
                                            <input type="file" name="images" class="form-control-file" accept="image/*">
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Status') }}</label>
                                            <select class="form-control" name="status">
                                                <option value="active">{{ __('Active') }}</option>
                                                <option value="in-active">{{ __('In-Active') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                
                                
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                    <a href="{{ route('fabrication.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

