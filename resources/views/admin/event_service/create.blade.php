@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Add New Event Services'),
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-12">  
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('event-services.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" id="event_id" name="event_id" class="form-control" value="{{ $event->id }}" required>
                                
                                <div class="form-group">
                                    <label for="service_category">{{ __('Services Category') }}</label>
                                    <select name="service_category_id" id="service_category" class="form-control" required>  
                                        <option value="">Select Category</option>
                                        @foreach($service_category as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="service_id">{{ __('Services Name') }}</label>
                                    <select name="service_id" id="service_id" class="form-control" required>  
                                        <option value="">Select Service</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="event_date">{{ __('Event Date') }}</label>
                                    <input type="date" id="event_date" name="event_date" class="form-control" required
                                    value="{{ Carbon\Carbon::parse($event->start_time)->format('Y-m-d')}}">
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
    $('#service_category').change(function() {
        var categoryId = $(this).val();
        var serviceDropdown = $('#service_id');
        
        // Reset dropdown
        serviceDropdown.html('<option value="">Loading...</option>');
        
        if(categoryId) {
            $.ajax({
                url: '/get-service/' + categoryId,
                type: 'GET',
                success: function(response) {
                    if(response && Object.keys(response).length > 0) {
                        var options = '<option value="">Select Service</option>';
                        $.each(response, function(key, value) {
                            options += '<option value="'+key+'">'+value+'</option>';
                        });
                        serviceDropdown.html(options);
                    } else {
                        serviceDropdown.html('<option value="">No services found</option>');
                    }
                },
                error: function() {
                    serviceDropdown.html('<option value="">Error loading services</option>');
                }
            });
        } else {
            serviceDropdown.html('<option value="">Select Service</option>');
        }
    });
});
</script>
@endsection


 