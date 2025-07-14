@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Edit Accessories'),
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('equipments.update', $equipment->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">{{ __('Accessories Name') }}</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $equipment->name }}" required>
                                     @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                </div>

                                <div class="form-group">
                                    <label for="equipment_type_id">{{ __('Accessories Type') }}</label>
                                    <select name="equipment_type_id" id="equipment_type_id" class="form-control @error('equipment_type_id') is-invalid @enderror" required>  
                                        <option value="">-- Select Equipment Type --</option>
                                        @foreach ($equipment_types as $type)
                                            <option value="{{ $type->id }}" {{ $type->id == $equipment->equipment_type_id ? 'selected' : '' }}>{{ $type->name }}</option> 
                                        @endforeach
                                       
                                    </select>
                              </div>

                               
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price">{{ __('Price') }}</label>
                                            <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror" required value="{{ $equipment->price }}">
                                             @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                         <div class="form-group">
                                            <label for="offered_price">{{ __('Offered Price') }}</label>
                                            <input type="number" id="offered_price" name="offered_price" class="form-control @error('offered_price') is-invalid @enderror" required value="{{ $equipment->offered_price }}">
                                             @error('offered_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                     
                                </div>

                                

                                <div class="form-group">
                                    <label for="is_active">{{ __('Is Active?') }}</label>
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $equipment->is_active ? 'checked' : '' }}>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
