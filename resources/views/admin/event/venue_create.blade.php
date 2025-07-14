@extends('master')

@section('content')
    <section class="section">
        <style>
            .step-progress {
                display: flex;
                justify-content: space-between;
                margin-bottom: 30px;
                position: relative;
            }

            .step-progress:before {
                content: '';
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
                height: 2px;
                background: #e0e0e0;
                transform: translateY(-50%);
                z-index: 1;
            }

            .step-progress-item {
                position: relative;
                z-index: 2;
                text-align: center;
                width: 20%;
            }

            .step-progress-number {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: #e0e0e0;
                color: #666;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 10px;
                font-weight: bold;
            }

            .step-progress-item.active .step-progress-number {
                background: #4361ee;
                color: white;
            }

            .step-progress-item.completed .step-progress-number {
                background: #4cc550;
                color: white;
            }

            .step-progress-title {
                font-size: 14px;
                color: #666;
            }

            .step-progress-item.active .step-progress-title {
                color: #4361ee;
                font-weight: bold;
            }

            .step-progress-item.completed .step-progress-title {
                color: #4cc550;
                font-weight: bold;
            }
        </style>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">

        <div class="section-body">
            <div class="card row">
                <div class="alert alert-success step-completion-message" style="display: none;">
                    <i class="fas fa-check-circle mr-2"></i> Step completed successfully! You can now proceed to the next
                    step.
                </div>
                <div class="col-lg-8 mt-3">
                    <div class="step-progress">
                        <div class="step-progress-item completed">
                            <div class="step-progress-number">1</div>
                            <div class="step-progress-title">Event Details</div>
                        </div>
                        <div class="step-progress-item active">
                            <div class="step-progress-number">2</div>
                            <div class="step-progress-title">Venue</div>
                        </div>
                        <div class="step-progress-item">
                            <div class="step-progress-number">3</div>
                            <div class="step-progress-title">Fabrication</div>
                        </div>
                        <div class="step-progress-item">
                            <div class="step-progress-number">4</div>
                            <div class="step-progress-title">Accessories</div>
                        </div>
                        <div class="step-progress-item">
                            <div class="step-progress-number">5</div>
                            <div class="step-progress-title">Final Submission</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert"
                                aria-label="Close"><span>&times;</span></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert"
                                aria-label="Close"><span>&times;</span></button>
                        </div>
                    @endif

                    <div class="card">
                        <h5 class="ml-5 mt-3">Venue Details</h5>
                        <hr>
                        <div class="card-body">
                            <form
                                action="<?php if(!empty($data)) { echo route('event-venue.update', is_array($data) ? $data['id'] : $data->id); } else { echo route('event-venue.create'); } ?>"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (!empty($data))
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                @endif

                                <input type="hidden" name="event_id" value="{{ $event->id }}">

                                <div class="form-group">
                                    <label for="venue_id">{{ __('Venue Name') }}</label>
                                    <div class="input-group">
                                        <select name="venue_id" id="venue_id" class="form-control select2"
                                            onchange="checkAvailability()">
                                            <option value="">Select</option>
                                            @foreach ($venues as $venue)
                                                @php
                                                    $eventDate = Carbon\Carbon::parse($event->start_time)->startOfDay();
                                                    $isAvailable = $venueAvailability
                                                        ->where('venue_id', $venue->id)
                                                        ->first(
                                                            fn($availability) => Carbon\Carbon::parse(
                                                                $availability->date,
                                                            )->isSameDay($eventDate) && $availability->is_available,
                                                        );
                                                @endphp
                                                <option value="{{ $venue->id }}"
                                                    data-available="{{ $isAvailable ? '1' : '0' }}"
                                                    {{ old('venue_id', $data->venue_id ?? '') == $venue->id ? 'selected' : '' }}>
                                                    {{ $venue->name }}
                                                    {{ $isAvailable ? '(Available)' : '(Not Available)' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="viewCalendarBtn"
                                                onclick="showCalendar()" disabled>
                                                <i class="fas fa-calendar-alt"></i> View Availability Calendar
                                            </button>
                                        </div>
                                    </div>
                                    <small id="availabilityStatus" class="form-text text-muted"></small>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Venue Images') }}</label>
                                    <div id="venueImages" class="row">
                                        @if (!empty($data) && !empty($data->venue_id))
                                            @php
                                                $selectedVenue = $venues->firstWhere('id', $data->venue_id);
                                                $venueImages = $selectedVenue->images ?? null;
                                            @endphp
                                            @if ($venueImages && is_array(json_decode($venueImages, true)))
                                                @foreach (json_decode($venueImages, true) as $image)
                                                    <div class="col-md-4 mb-3">
                                                        <img src="{{ asset('storage/' . $image) }}"
                                                            class="img-fluid rounded" alt="Venue Image">
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="col-12 text-center">
                                                    <p class="text-muted">No images available for this venue</p>
                                                </div>
                                            @endif
                                        @else
                                            <div class="col-12 text-center">
                                                <p class="text-muted">Select a venue to view images</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="event_date">{{ __('Event Date') }}</label>
                                    <input type="date" id="event_date" name="event_date" class="form-control"
                                        value="{{ old('event_date', !empty($data) ? \Carbon\Carbon::parse($data->event_date)->format('Y-m-d') : \Carbon\Carbon::parse($event->start_time)->format('Y-m-d')) }}"
                                        onchange="updateAvailability()" required>
                                </div>

                                <div class="form-group text-left">
                                    <a href="{{ url()->previous() }}" class="btn btn-primary mr-2">
                                        <i class="fas fa-arrow-left"></i> {{ __('Previous') }}
                                    </a>
                                </div>

                                <div class="form-group text-right">
                                    <button type="submit" name="action" value="next" class="btn btn-primary">
                                        {{ __('Next') }} <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Calendar Modal -->
    <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Venue Availability Calendar</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div id="venueCalendar" style="height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#venue_id').select2();

            @if (!empty($data->venue_id))
                setTimeout(() => {
                    $('#venue_id').val('{{ $data->venue_id }}').trigger('change');
                    document.getElementById('viewCalendarBtn').disabled = false;

                    const selectedOption = $('#venue_id option:selected');
                    const isAvailable = selectedOption.data('available') === 1;
                    const statusElement = document.getElementById('availabilityStatus');

                    if (isAvailable) {
                        statusElement.textContent = 'This venue is available on the selected date';
                        statusElement.className = 'form-text text-success';
                    } else {
                        statusElement.textContent = 'This venue is NOT available on the selected date';
                        statusElement.className = 'form-text text-danger';
                    }
                }, 100);
            @endif
        });

        function checkAvailability() {
            const venueSelect = document.getElementById('venue_id');
            const selectedOption = venueSelect.options[venueSelect.selectedIndex];
            const isAvailable = selectedOption && selectedOption.getAttribute('data-available') === '1';
            const statusElement = document.getElementById('availabilityStatus');
            const calendarBtn = document.getElementById('viewCalendarBtn');

            if (!venueSelect.value) {
                statusElement.textContent = '';
                calendarBtn.disabled = true;
                $('#venueImages').html(
                    '<div class="col-12 text-center"><p class="text-muted">Select a venue to view images</p></div>');
                return;
            }

            calendarBtn.disabled = false;
            statusElement.textContent = isAvailable ? 'This venue is available on the selected date' :
                'This venue is NOT available on the selected date';
            statusElement.className = isAvailable ? 'form-text text-success' : 'form-text text-danger';

            loadVenueImages(venueSelect.value);
        }

        function loadVenueImages(venueId) {
            if (!venueId) {
                $('#venueImages').html(
                    '<div class="col-12 text-center"><p class="text-muted">Select a venue to view images</p></div>');
                return;
            }

            $.ajax({
                url: '/get-venue-images/' + venueId,
                type: 'GET',
                success: function(response) {
                    if (response.images && response.images.length > 0) {
                        let html = '';
                        response.images.forEach(image => {
                            html += `<div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="${image.image_url}" class="card-img-top" style="height:200px; object-fit:cover;" alt="Venue Image">
                        </div>
                    </div>`;
                        });
                        $('#venueImages').html(html);
                    } else {
                        $('#venueImages').html(
                            '<div class="col-12 text-center"><p class="text-muted">No images available for this venue</p></div>'
                        );
                    }
                },
                error: () => $('#venueImages').html(
                    '<div class="col-12 text-center"><p class="text-danger">Error loading images</p></div>')
            });
        }

        function updateAvailability() {
            checkAvailability();
        }

        function showCalendar() {
            const venueId = document.getElementById('venue_id').value;
            if (!venueId) return;

            $('#calendarModal').modal('show');
            $('#calendarModal').on('shown.bs.modal', function() {
                const calendarEl = document.getElementById('venueCalendar');
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
                    eventClick(info) {
                        alert(
                            `Event: ${info.event.title}\nStatus: ${info.event.extendedProps.is_available ? 'Available' : 'Not Available'}\nDate: ${info.event.start.toLocaleDateString()}`
                            );
                    }
                });

                calendar.render();
                calendarEl._fullCalendar = calendar;
            });
        }
    </script>
@endsection
