@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Talent'),
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
        /* Compact dropdown styles */
            .dropdown-toggle {
                width: 28px;
                height: 28px;
                padding: 0;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: 1px solid #e0e0e0;
            }

            .dropdown-menu {
                min-width: 180px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                border: none;
            }

            .dropdown-item {
                padding: 0.4rem 1rem;
                font-size: 0.85rem;
                display: flex;
                align-items: center;
            }

            .dropdown-item i {
                width: 18px;
                text-align: center;
                margin-right: 8px;
            }

            .dropdown-divider {
                margin: 0.3rem 0;
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
                                    <h2 class="section-title mt-0"> {{ __('View Talent') }}</h2>
                                </div>
                                <div class="col-lg-4 text-right">
                                   
                                        <button class="btn btn-primary add-button">
                                            <a href="{{ route('talent.create') }}">
                                                <i class="fas fa-plus"></i> {{ __('Add New Talent') }}
                                            </a>
                                        </button>
                                         <button class="btn btn-primary add-button">
                                            <a href="{{ route('talent-category.index') }}">
                                                {{ __('Talent Category') }}
                                            </a>
                                        </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="report_table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Talent Image') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Talent Category') }}</th>
                                            <th>{{ __('Rate') }}</th>
                                            <th>{{ __('Offered Rate') }}</th>
                                            <th>{{ __('Audience Type') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            @if (Gate::check('venue_edit') || Gate::check('venue_delete'))
                                                <th>{{ __('Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($talents as $talent)
                                            <tr>
                                                <td>
                                                    @if($talent->talent_image)
                                                        <img src="{{ asset('storage/'.$talent->talent_image) }}" alt="Talent Image"  style="width: 80px; height: 80px; object-fit: cover;">
                                                    @endif
                                                </td>
                                                <td>{{ $talent->name }}</td>
                                                <td>{{ $talent->category->name }}</td>
                                                <td>{{ $talent->rate }}</td>
                                                <td>{{ $talent->offered_rate }}</td>
                                                <td>{{ $talent->audience_type }}</td>
                                                <td>
                                                    @if($talent->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-light rounded-circle" type="button" id="talentActions-{{ $talent->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="talentActions-{{ $talent->id }}">
                                                            <!-- Edit -->
                                                            <a class="dropdown-item" href="{{ route('talent.edit', $talent->id) }}">
                                                                <i class="fas fa-edit mr-2 text-primary"></i> Edit
                                                            </a>
                                                            
                                                            <!-- Set Availability -->
                                                            <a class="dropdown-item set-availability-btn" href="#" data-talent-id="{{ $talent->id }}" data-toggle="modal" data-target="#setAvailabilityModal">
                                                                <i class="fas fa-calendar-plus mr-2 text-info"></i> Set Availability
                                                            </a>
                                                            
                                                            <!-- View Calendar -->
                                                            <a class="dropdown-item show-calendar-btn" href="#" data-talent-id="{{ $talent->id }}" data-toggle="modal" data-target="#showCalendarModal">
                                                                <i class="fas fa-calendar-alt mr-2 text-success"></i> View Calendar
                                                            </a>
                                                            
                                                            <!-- Delete -->
                                                            <div class="dropdown-divider"></div>
                                                            <form action="{{ route('talent.destroy', $talent->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this talent?')">
                                                                    <i class="fas fa-trash mr-2"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                         
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
<!-- Set Availability Modal -->
    <div class="modal fade" id="setAvailabilityModal" tabindex="-1" role="dialog" aria-labelledby="setAvailabilityModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="setAvailabilityModalLabel">Set Talent Availability</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('talent.setAvailability') }}" method="POST">
                    
                        @csrf
                        <input type="hidden" name="talent_id" id="modalTalentId">

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
            const talentId = $(this).data('talent-id');
            $('#modalTalentId').val(talentId);

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
    <div class="modal-dialog modal-md" role="document" style="max-width: 600px;">
        <div class="modal-content" style=" border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
            <div class="modal-header" style="border-bottom: none; padding: 15px 20px 0 20px;">
                <h5 class="modal-title" style="font-size: 1.1rem; color: #6c5ce7; font-weight: 600;">
                    <i class="fas fa-calendar-alt mr-2"></i>Talent Availability
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 0 10px;">
                    <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 10px 20px 20px 20px;">
                <div id="availabilityCalendar" style="height: 400px;"></div>
            </div>
            <div class="modal-footer" style="border-top: none; padding: 0 20px 15px 20px; justify-content: center;">
                <button type="button" class="btn btn-sm btn-outline-primary" data-dismiss="modal" 
                        style="border-radius: 20px; padding: 5px 20px; border-width: 2px;">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

    <!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
    $(document).ready(function () {
    $('.show-calendar-btn').on('click', function () {
    const talentId = $(this).data('talent-id');

    $('#showCalendarModal').on('shown.bs.modal', function () {
        const calendarEl = document.getElementById('availabilityCalendar');

        // Destroy previous calendar if it exists
        if (calendarEl.innerHTML !== '') {
            calendarEl.innerHTML = '';
        }

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: `/talent/${talentId}/availability-calendar`,
        });

        calendar.render();
    });
});
});
</script>

@endsection
