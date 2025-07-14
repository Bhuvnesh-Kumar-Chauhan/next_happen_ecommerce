@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Edit Event Talent '),
        ])
        
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('event-talent.update',$eventTalent->id )}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="name">{{ __('Talent Category') }}</label>
                                    <select name="talent_category" id="talent_category" class="form-control" required>  
                                        <option value="">select Category</option>
                                        @foreach($talent_cat as $category)
                                            <option value="{{ $category->id }}" {{ (isset($eventTalent->talent_category) && $eventTalent->talent_category == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="name">{{ __('Talent Name') }}</label>
                                    <div class="input-group">
                                        <select name="talent_id" id="talent_id" class="form-control" required>  
                                            <option value="">select</option>
                                            <!-- Options will be loaded via AJAX -->
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="viewCalendarBtn" onclick="showCalendar()" disabled>
                                                <i class="fas fa-calendar-alt"></i> View Availability Calendar
                                            </button>
                                        </div>
                                    </div>
                                    <small id="availability_status" class="form-text text-danger d-none"></small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="event_date">{{ __('Event Date') }}</label>
                                    <input type="date" id="event_date" name="event_date" class="form-control" required
                                    value="{{ $eventTalent->event_date}}" onchange="checkAvailability()">
                                </div>

                               <div class="form-group">
                                    <label for="is_active">{{ __('Is Active?') }}</label>
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $eventTalent->is_active == 1 ? 'checked' : '' }}>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Availability Modal -->
    <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="calendarModalLabel">Talent Availability Calendar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="venueCalendar"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    
    <script>
    $(document).ready(function() {
       $('#talent_category').change(function() {
        var categoryId = $(this).val();
        var selectedTalentId = '<?php echo $eventTalent->talent_id ?? ""; ?>'; // Get the pre-selected talent ID
        
        if(categoryId) {
            $.ajax({
                url: '/get-talents/' + categoryId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#talent_id').empty();
                    $('#talent_id').append('<option value="">select</option>');
                    
                    $.each(data, function(key, value) {
                        // Check if this option should be selected
                        var selected = (key == selectedTalentId) ? 'selected="selected"' : '';
                        $('#talent_id').append('<option value="'+ key +'" '+ selected +'>'+ value +'</option>');
                    });
                    
                    $('#availability_status').addClass('d-none');
                    $('#viewCalendarBtn').prop('disabled', true);
                    
                    // If we have a selected talent, trigger the change event
                    if(selectedTalentId) {
                        $('#talent_id').trigger('change');
                    }
                }
            });
        } else {
            $('#talent_id').empty();
            $('#talent_id').append('<option value="">select</option>');
            $('#availability_status').addClass('d-none');
            $('#viewCalendarBtn').prop('disabled', true);
        }
    });

// Trigger the change event on page load if category is already selected
$(document).ready(function() {
    if($('#talent_category').val()) {
        $('#talent_category').trigger('change');
    }
});

        $('#talent_id').change(function() {
            var talentId = $(this).val();
            if(talentId) {
                checkAvailability();
                $('#viewCalendarBtn').prop('disabled', false);
            } else {
                $('#availability_status').addClass('d-none');
                $('#viewCalendarBtn').prop('disabled', true);
            }
        });
    });

    function checkAvailability() {
        var talentId = $('#talent_id').val();
        var eventDate = $('#event_date').val();
        
        if(talentId && eventDate) {
            $.ajax({
                url: '/check-talent-availability',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    talent_id: talentId,
                    date: eventDate
                },
                dataType: 'json',
                success: function(response) {
                    var statusElement = $('#availability_status');
                    statusElement.removeClass('d-none');
                    
                    if(response.available) {
                        statusElement.removeClass('text-danger');
                        statusElement.addClass('text-success');
                        statusElement.text('Talent is available on this date');
                    } else {
                        statusElement.removeClass('text-success');
                        statusElement.addClass('text-danger');
                        statusElement.text('Talent is not available on this date');
                    }
                }
            });
        }
    }

    function showCalendar() {
    const talentId = $('#talent_id').val();
    if (!talentId) return;
    
    $('#calendarModal').modal('show');
    
    // Initialize or refresh calendar when modal is shown
    $('#calendarModal').on('shown.bs.modal', function() {
        const calendarEl = document.getElementById('venueCalendar');
        
        // Clear previous calendar if it exists
        if (calendarEl._fullCalendar) {
            calendarEl._fullCalendar.destroy();
        }
        
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: {
                url: `/get-talent-availability-calendar/${talentId}`,
                method: 'GET',
                failure: function() {
                    alert('There was an error fetching availability data');
                }
            },
            eventContent: function(arg) {
                // Customize how events are displayed
                let availabilityText = arg.event.title;
                let dotColor = arg.event.extendedProps.is_available ? 'green' : 'red';
                
                return {
                    html: `<div style="display: flex; align-items: center;">
                        <span style="color: ${dotColor}; font-size: 1.5em;">•</span>
                        <span style="margin-left: 5px;">${availabilityText}</span>
                    </div>`
                };
            },
            eventDidMount: function(arg) {
                // Add tooltip
                arg.el.setAttribute('title', arg.event.title + ' on ' + arg.event.start.toLocaleDateString());
            }
        });
        
        calendar.render();
        calendarEl._fullCalendar = calendar; // Store reference
    });
}

    </script>
@endsection