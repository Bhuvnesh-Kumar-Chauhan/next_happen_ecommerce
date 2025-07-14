@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', ['title' => __('Edit Fabrication')])

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-body">
                            {{--  --}}
                            <form action="{{ route('fabrication.update', $fabrication->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>{{ __('Type') }}</label>
                                        <select class="form-control" name="fabrication_type" required>
                                            <option value="">{{ __('Select Type') }}</option>
                                            <option value="Fabric Backdrops" {{ $fabrication->fabrication_type == 'Fabric Backdrops' ? 'selected' : '' }}>{{ __('Fabric Backdrops') }}</option>
                                            <option value="Table Cloths" {{ $fabrication->fabrication_type == 'Table Cloths' ? 'selected' : '' }}>{{ __('Table Cloths') }}</option>
                                            <option value="Drapes" {{ $fabrication->fabrication_type == 'Drapes' ? 'selected' : '' }}>{{ __('Drapes') }}</option>
                                        </select>
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>{{ __('Name') }}</label>
                                        <input type="text" name="name" class="form-control" required value="{{ $fabrication->name }}">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>{{ __('Description') }}</label>
                                        <textarea name="description" class="form-control" rows="3">{{ $fabrication->description }}</textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>{{ __('Images') }}</label>
                                        <input type="file" name="images" class="form-control-file" accept="image/*">
                                       
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('Status') }}</label>
                                        <select class="form-control" name="status">
                                            <option value="active" {{ $fabrication->status == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                            <option value="in-active" {{ $fabrication->status == 'in-active' ? 'selected' : '' }}>{{ __('In-Active') }}</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
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