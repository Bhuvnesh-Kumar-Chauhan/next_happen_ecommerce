@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Add New Event Venue '),
        ])

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">

        <div class="section-body">
            <div class="row">
                <div class="col-12">

                     @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('event-venue.create') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                               
                                <input type="hidden" id="event_id" name="event_id" class="form-control" value="{{ $event->id }}" required>
                                
                                <div class="form-group">
                                    <label for="name">{{ __('Venue Name') }}</label>
                                    <div class="input-group">
                                        <select name="venue_id" id="venue_id" class="form-control select2" required onchange="checkAvailability()">  
                                            <option value="">select</option>
                                            @foreach($venues as $venue)
                                               @php
                                                $eventDate = Carbon\Carbon::parse($event->start_time)->startOfDay();
                                                $isAvailable = $venueAvailability->where('venue_id', $venue->id)
                                                    ->first(function ($availability) use ($eventDate) {
                                                        return Carbon\Carbon::parse($availability->date)->isSameDay($eventDate) 
                                                            && $availability->is_available;
                                                    });
                                            @endphp
                                                <option value="{{ $venue->id }}" data-available="{{ $isAvailable ? '1' : '0' }}"
                                                    @if(old('venue_id', $eventVenue->venue_id ?? null ) == $venue->id) selected @endif >
                                                    {{ $venue->name }} 
                                                    @if($isAvailable)
                                                        (Available)
                                                    @else
                                                        (Not Available)
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="viewCalendarBtn" onclick="showCalendar()" disabled>
                                                <i class="fas fa-calendar-alt"></i> View Availability Calendar
                                            </button>
                                        </div>
                                    </div>
                                    <small id="availabilityStatus" class="form-text text-muted"></small>
                                </div>

                                <div class="form-group ">
                                        <label for="event_date">{{ __('Event Date') }}</label>
                                        <input type="date" id="event_date" name="event_date" class="form-control" required
                                        value="{{ Carbon\Carbon::parse($event->start_time)->format('Y-m-d')}}" onchange="updateAvailability()">
                                </div>

                                <div class="form-group">
                                    <label for="capacity">{{ __('Booking Date') }}</label>
                                    <input type="date" id="booking_date" name="booking_date" class="form-control" required
                                    value="{{ $eventVenue->booking_date}}">
                                </div>

                                <div class="form-group">
                                    <label for="is_active">{{ __('Is Active?') }}</label>
                                    <input type="checkbox" name="is_active" id="is_active" value="1" checked value="{{ $eventVenue->is_active }}">
                                </div>
                                <a href="{{ route('events.index')}}"  class="btn btn-danger">{{ __('Back') }}</a>
                                
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Calendar Modal -->
    <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="calendarModalLabel">Venue Availability Calendar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="venueCalendar" style="height: 500px;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script>
    function checkAvailability() {
        const venueSelect = document.getElementById('venue_id');
        const selectedOption = venueSelect.options[venueSelect.selectedIndex];
        const isAvailable = selectedOption.getAttribute('data-available') === '1';
        const statusElement = document.getElementById('availabilityStatus');
        const viewCalendarBtn = document.getElementById('viewCalendarBtn');
        
        if (venueSelect.value === '') {
            statusElement.textContent = '';
            viewCalendarBtn.disabled = true;
            return;
        }
        
        viewCalendarBtn.disabled = false;
        
        if (isAvailable) {
            statusElement.textContent = 'This venue is available on the selected date';
            statusElement.className = 'form-text text-success';
        } else {
            statusElement.textContent = 'This venue is NOT available on the selected date';
            statusElement.className = 'form-text text-danger';
        }
    }
    
    function updateAvailability() {
        const eventDate = document.getElementById('event_date').value;
        checkAvailability();
    }
    
    function showCalendar() {
        const venueId = document.getElementById('venue_id').value;
        if (!venueId) return;
        
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
                events: `/venues/${venueId}/availability-calendar`,
                eventClick: function(info) {
                    alert('Event: ' + info.event.title + '\n' +
                          'Status: ' + (info.event.extendedProps.is_available ? 'Available' : 'Not Available') + '\n' +
                          'Date: ' + info.event.start.toLocaleDateString());
                }
            });
            
            calendar.render();
            calendarEl._fullCalendar = calendar; // Store reference
        });
    }
    
    // Initialize the small calendar in the form
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('availabilityCalendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: ''
            },
            height: 'auto',
            events: '/venue-availability-events',
            eventClick: function(info) {
                alert('Venue is ' + (info.event.extendedProps.is_available ? 'Available' : 'Not Available') + 
                      ' on ' + info.event.start.toLocaleDateString());
            }
        });
        calendar.render();
    });
    </script>
@endsection