@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Edit Event Equipment'),
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('event-equipment.update', $event_equipments->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="name">{{ __('Equipment Type') }}</label>
                                    <select name="equipment_type_id" id="equipment_type" class="form-control" required>  
                                        <option value="">select</option>
                                        @foreach($equipmentTypes as $type)
                                            <option value="{{ $type->id }}" {{ (isset($event_equipments->equipment_type_id) && $event_equipments->equipment_type_id == $type->id) ? 'selected' : '' }}>{{ $type->name }}</option>
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
                                            <input type="number" id="quantity" name="quantity" class="form-control" value="{{ $event_equipments->quantity ?? '' }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="event_date">{{ __('Event Date') }}</label>
                                            <input type="date" id="event_date" name="event_date" class="form-control" required
                                            value="{{ $event_equipments->event_date ?? '' }}" >
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Dimensions Section (Conditionally Shown) -->
                                <div id="dimensions-section" style="display: {{ (isset($event_equipments->equipmentType) && 
                                strpos(strtolower($event_equipments->equipmentType->name ?? ''), 'fabrication') !== false ? 'block' : 'none') }};">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ __('Length') }}</label>
                                                <input type="text" id="length" name="length" class="form-control" value="{{ $event_equipments->length ?? '' }}">
                                                @error('length')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ __('Width') }}</label>
                                                <input type="text" id="width" name="width" class="form-control" value="{{ $event_equipments->width ?? '' }}">
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
                                                    <option value="cm" {{ (isset($event_equipments->unit) && $event_equipments->unit == "cm" ? 'selected' : '') }}>Centimeter (cm)</option>
                                                    <option value="m" {{ (isset($event_equipments->unit) && $event_equipments->unit == "m" ? 'selected' : '' )}}>Meter (m)</option>
                                                    <option value="ft" {{ (isset($event_equipments->unit) && $event_equipments->unit == "ft" ? 'selected' : '' )}}>Feet (ft)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="is_active">{{ __('Is Active?') }}</label>
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ isset($event_equipments->is_active) && $event_equipments->is_active == 1 ? 'checked' : '' }}>
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
        var selectedEquipmentId = '<?php echo isset($event_equipments->equipment_id) ? $event_equipments->equipment_id : ""; ?>';

        function toggleDimensionsSection(equipmentTypeName) {
            if (equipmentTypeName.includes('fabrication')) {
                $('#dimensions-section').show();
                $('#length, #width, #unit').attr('required', 'required');
            } else {
                $('#dimensions-section').hide();
                $('#length, #width, #unit').removeAttr('required');
            }
        }

        // Initial check on page load
        var initialTypeName = $('#equipment_type option:selected').text().toLowerCase();
        toggleDimensionsSection(initialTypeName);

        // Handle equipment type change
        $('#equipment_type').change(function() {
            var equipmentTypeId = $(this).val();
            var equipmentTypeName = $(this).find('option:selected').text().toLowerCase();

            $('#equipment_id').empty().append('<option value="">Loading...</option>');
            toggleDimensionsSection(equipmentTypeName);

            if (equipmentTypeId) {
                $.ajax({
                    url: '/get-equipment/' + equipmentTypeId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#equipment_id').empty().append('<option value="">select</option>');
                        $.each(data, function(key, value) {
                            $('#equipment_id').append(
                                $('<option>', {
                                    value: key,
                                    text: value,
                                    selected: key == selectedEquipmentId
                                })
                            );
                        });
                    },
                    error: function() {
                        $('#equipment_id').empty().append('<option value="">Error loading equipment</option>');
                    }
                });
            } else {
                $('#equipment_id').empty().append('<option value="">select</option>');
            }
        });

        // Trigger change manually if equipment type is already selected
        if ($('#equipment_type').val()) {
            $('#equipment_type').trigger('change');
        }
    });
</script>
@endsection