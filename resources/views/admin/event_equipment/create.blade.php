@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Add New Event Equipment'),
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('event-equipment.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" id="event_id" name="event_id" class="form-control" value="{{ $event->id }}" required>

                                <div class="form-group">
                                    <label for="name">{{ __('Equipment Type') }}</label>
                                    <select name="equipment_type_id" id="equipment_type" class="form-control" required>  
                                        <option value="">select</option>
                                        @foreach($equipmentTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="name">{{ __('Equipment Name') }}</label>
                                    <select name="equipment_id" id="equipment_id" class="form-control" required>  
                                        <option value="">select</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="quantity">{{ __('Quantity') }}</label>
                                                <input type="number" id="quantity" name="quantity" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                             <div class="form-group">
                                                <label for="event_date">{{ __('Event Date') }}</label>
                                                <input type="date" id="event_date" name="event_date" class="form-control" required
                                                value="{{ Carbon\Carbon::parse($event->start_time)->format('Y-m-d')}}" >
                                            </div>
                                        </div>
                                </div>
                                <!-- Dimensions Section (Hidden by Default) -->
                                <div id="dimensions-section" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ __('Length') }}</label>
                                                <input type="text" id="length" name="length" class="form-control">
                                                @error('length')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ __('Width') }}</label>
                                                <input type="text" id="width" name="width" class="form-control">
                                                @error('width')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="unit">{{ __('Unit') }}</label>
                                                <select name="unit" id="unit" class="form-control">
                                                    <option value="">select</option>
                                                    <option value="cm">Centimeter (cm)</option>
                                                    <option value="m">Meter (m)</option>
                                                    <option value="ft">Feet (ft)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="is_active">{{ __('Is Active?') }}</label>
                                    <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#equipment_type').change(function() {
                var equipmentTypeId = $(this).val();
                var equipmentTypeName = $(this).find('option:selected').text().toLowerCase();
                
                // Clear previous equipment options
                $('#equipment_id').empty().append('<option value="">select</option>');
                
                // Hide dimensions section by default
                $('#dimensions-section').hide();
                $('#length, #width, #unit').removeAttr('required');
                
                if (equipmentTypeId) {
                    $.ajax({
                        url: '/get-equipment/' + equipmentTypeId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#equipment_id').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                            
                            // Show dimensions section only if equipment type is "Fabrication"
                            if (equipmentTypeName.includes('fabrication')) {
                                $('#dimensions-section').show();
                                $('#length, #width, #unit').attr('required', 'required');
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection