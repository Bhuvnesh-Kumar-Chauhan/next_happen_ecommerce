@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Venues'),
        ])
    <style>
        button, .button-class, .icon-wrapper {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            }
            div, td, span {
            border: none !important;
            }
        .btn-icon {
            border: none; 
            outline: none;  
            background-color: transparent; 
        }

        .dropdown-toggle {
            width: 30px;
            height: 30px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropdown-item {
            font-size: 0.85rem;
            padding: 0.35rem 1rem;
        }

        .dropdown-item i {
            width: 18px;
            text-align: center;
        }
       
    </style>
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
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4 mt-2">
                                <div class="col-lg-8">
                                    <h2 class="section-title mt-0"> {{ __('View Venues') }}</h2>
                                </div>
                                <div class="col-lg-4 text-right">
                                    @can('venue_create')
                                        <button class="btn btn-primary add-button">
                                            <a href="{{ route('venues.create') }}">
                                                <i class="fas fa-plus"></i> {{ __('Add New Venue') }}
                                            </a>
                                        </button>
                                    @endcan
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="report_table">
                                    <thead>
                                        <tr>
                                            <th >{{ __('Name') }}</th>
                                            
                                            <th>{{ __('Location') }}</th>
                                            <th>{{ __('Capacity') }}</th>
                                            <th>{{ __('Venue Type') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Offer Price') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            @if (Gate::check('venue_edit') || Gate::check('venue_delete'))
                                                <th>{{ __('Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($venues as $venue)
                                            <tr>
                                                
                                                <td >{{ $venue->name }}</td>
                                                <td>{{ $venue->location }}</td>
                                                <td>{{ $venue->capacity }}</td>
                                                <td>{{ $venue->venue_type }}</td>
                                                <td>{{ $venue->price }}</td>
                                                <td>{{ $venue->offer_price }}</td>
                                                <td>
                                                    @if($venue->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                @if (Gate::check('venue_edit') || Gate::check('venue_delete') || Gate::check('venue_availability'))
                                                    <td class="text-center">
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-light rounded-circle" type="button" id="venueActions-{{ $venue->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="venueActions-{{ $venue->id }}">
                                                                @can('venue_edit')
                                                                    <a class="dropdown-item" href="{{ route('venues.edit', $venue->id) }}">
                                                                        <i class="fas fa-edit mr-2 text-primary"></i> Edit
                                                                    </a>
                                                                    
                                                                    <a class="dropdown-item upload-images-btn" href="{{ route('venues.images', $venue->id) }}">
                                                                            <i class="fas fa-images mr-2 text-warning"></i> Add Images
                                                                        </a>
                                                                @endcan
                                                                
                                                                @can('venue_availability')
                                                                    <a class="dropdown-item set-availability-btn" href="#" data-venue-id="{{ $venue->id }}" data-toggle="modal" data-target="#setAvailabilityModal">
                                                                        <i class="fas fa-calendar-plus mr-2 text-info"></i> Set Availability
                                                                    </a>
                                                                    <a class="dropdown-item show-calendar-btn" href="#" data-venue-id="{{ $venue->id }}" data-toggle="modal" data-target="#showCalendarModal">
                                                                        <i class="fas fa-calendar-alt mr-2 text-success"></i> View Calendar
                                                                    </a>
                                                                @endcan
                                                                
                                                                @can('venue_delete')
                                                                    <div class="dropdown-divider"></div>
                                                                    <form action="{{ route('venues.destroy', $venue->id) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this venue?')">
                                                                            <i class="fas fa-trash mr-2"></i> Delete
                                                                        </button>
                                                                    </form>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Set Availability Modal --}}
    <div class="modal fade" id="setAvailabilityModal" tabindex="-1" role="dialog" aria-labelledby="setAvailabilityModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="setAvailabilityModalLabel">Set Venue Availability</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('venues.setAvailability') }}" method="POST">
                    
                        @csrf
                        <input type="hidden" name="venue_id" id="modalVenueId">
                       
                        <!-- Range Date Fields -->
                        <div class="form-group">
                            <label for="startDate">From Date</label>
                            <input type="date" class="form-control" id="startDate" name="start_date" min="<?php echo date('Y-m-d'); ?>" required>
                            
                            <label for="endDate" style="margin-top: 10px;">To Date</label>
                            <input type="date" class="form-control" id="endDate" name="end_date" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="isAvailable">Availability Status</label>
                            <select class="form-control" id="isAvailable" name="is_available" required>
                                <option value="1">Available</option>
                                <option value="0">Not Available</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveAvailability">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Set minimum dates to today (but keep fields blank)
            const today = new Date().toISOString().split('T')[0];
            $('#startDate, #endDate').attr('min', today).val('');

            // Ensure end date is not before start date
            $('#startDate').change(function() {
                const startDate = $(this).val();
                $('#endDate').attr('min', startDate);
                
                // If end date is now invalid, clear it
                if ($('#endDate').val() && $('#endDate').val() < startDate) {
                    $('#endDate').val('');
                }
            });

            $('.set-availability-btn').on('click', function () {
                const venueId = $(this).data('venue-id');
                $('#modalVenueId').val(venueId);
                
                // Reset dates to blank when modal opens
                $('#startDate, #endDate').val('').attr('min', today);
            });

            $('#saveAvailability').on('click', function () {
                $('form').submit();
            });
        });
    </script>
    <style>
        #availabilityCalendar {
        height: 490px;
    }
    </style>
<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />



    <!-- Show Calendar Modal -->
    <div class="modal fade" id="showCalendarModal" tabindex="-1" role="dialog" aria-labelledby="showCalendarModalLabel">
    <div class="modal-dialog modal-md" role="document" style="max-width: 600px;"> <!-- Changed from modal-lg to modal-sm -->
        <div class="modal-content" > <!-- Added rounded corners -->
            <div class="modal-header py-2" style="background-color: #f8f9fa;"> <!-- Smaller padding and light background -->
                <h5 class="modal-title" id="showCalendarModalLabel" style="font-size: 1rem;">📅 Venue Availability</h5> <!-- Smaller text and added emoji -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size: 1.2rem;">&times;</span> <!-- Smaller close button -->
                </button>
            </div>
            <div class="modal-body p-2"> <!-- Reduced padding -->
                <div id="availabilityCalendar" style="height: 250px;"></div> <!-- Reduced height -->
            </div>
            <div class="modal-footer py-2"> <!-- Smaller padding -->
                <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">Close</button> <!-- Smaller button -->
            </div>
        </div>
    </div>
</div>

    <!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
    $(document).ready(function () {
    $('.show-calendar-btn').on('click', function () {
    const venueId = $(this).data('venue-id');

    $('#showCalendarModal').on('shown.bs.modal', function () {
        const calendarEl = document.getElementById('availabilityCalendar');

        // Destroy previous calendar if it exists
        if (calendarEl.innerHTML !== '') {
            calendarEl.innerHTML = '';
        }

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: `/venues/${venueId}/availability-calendar`,
        });

        calendar.render();
    });
});
});
</script>
@endsection

