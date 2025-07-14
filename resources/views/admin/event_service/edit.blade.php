@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Edit Event Services'),
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-12">  
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('event-service.update',$eventService->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="service_category">{{ __('Services Category') }}</label>
                                    <select name="service_category_id" id="service_category" class="form-control" required>  
                                        <option value="">Select Category</option>
                                        @foreach($service_category as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ (isset($eventService->service_category_id) && $eventService->service_category_id == $category->id) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="service_id">{{ __('Services Name') }}</label>
                                    <select name="service_id" id="service_id" class="form-control" required>  
                                        <option value="">Select Service</option>
                                        @if(isset($eventService->service_id) && $eventService->service)
                                            <option value="{{ $eventService->service_id }}" selected>
                                                {{ $eventService->service->name }}
                                            </option>
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="event_date">{{ __('Event Date') }}</label>
                                    <input type="date" id="event_date" name="event_date" class="form-control" required
                                    value="{{ $eventService->event_date}}">
                                </div>

                                <div class="form-group">
                                    <label for="is_active">{{ __('Is Active?') }}</label>
                                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                                    {{ isset($eventService->is_active) && $eventService->is_active == 1 ? 'checked' : '' }}>
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
        var selectedServiceId = '{{ isset($eventService->service_id) ? $eventService->service_id : "" }}';
        var selectedServiceName = '{{ isset($eventService->service) ? $eventService->service->name : "" }}';
        
        // Trigger change event if category is already selected
        if($('#service_category').val()) {
            loadServices($('#service_category').val(), selectedServiceId);
        }
        
        $('#service_category').change(function() {
            var categoryId = $(this).val();
            loadServices(categoryId, selectedServiceId);
        });
        
        function loadServices(categoryId, selectedId) {
            var serviceDropdown = $('#service_id');
            
            if(categoryId) {
                $.ajax({
                    url: '/get-service/' + categoryId,
                    type: 'GET',
                    success: function(response) {
                        var options = '<option value="">Select Service</option>';
                        
                        if(response && Object.keys(response).length > 0) {
                            $.each(response, function(key, value) {
                                options += '<option value="' + key + '" ' + 
                                    (key == selectedId ? 'selected' : '') + '>' + 
                                    value + '</option>';
                            });
                        } else {
                            options = '<option value="">No services found</option>';
                        }
                        
                        // If selected service exists in the new list, keep it selected
                        // Otherwise, add it at the top (useful when changing categories)
                        if(selectedId && response[selectedId]) {
                            options = '<option value="' + selectedId + '" selected>' + 
                                response[selectedId] + '</option>' + options;
                        } else if(selectedId && selectedServiceName) {
                            options = '<option value="' + selectedId + '" selected>' + 
                                selectedServiceName + '</option>' + options;
                        }
                        
                        serviceDropdown.html(options);
                    },
                    error: function() {
                        serviceDropdown.html('<option value="">Error loading services</option>');
                    }
                });
            } else {
                serviceDropdown.html('<option value="">Select Service</option>');
            }
        }
    });
    </script>
@endsection