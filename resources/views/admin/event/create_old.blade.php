@extends('master')

@section('content')

<style>
.custom-file, .custom-file-label, .custom-select, .custom-file-label:after, .form-control[type="color"], select.form-control:not([size]):not([multiple]) {
    height: calc(2.25rem + 6px);
    width: 100%;
}
</style>
<style>
    .step-completion-message {
        animation: fadeInOut 3s ease-in-out;
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        display: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    @keyframes fadeInOut {
        0% { opacity: 0; transform: translateX(-50%) translateY(-20px); }
        10% { opacity: 1; transform: translateX(-50%) translateY(0); }
        90% { opacity: 1; transform: translateX(-50%) translateY(0); }
        100% { opacity: 0; transform: translateX(-50%) translateY(-20px); }
    }
    .media-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }

    #upload-button {
        margin: 0;
        padding: 8px 15px;
    }

    .media-preview-item {
        width: 100px;
        height: 100px;
        position: relative;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }

    .media-preview-item img,
    .media-preview-item video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .remove-media {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 20px;
        height: 20px;
        border: none;
        background: red;
        color: white;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        font-size: 14px;
        line-height: 1;
    }
    
    /* New styles for multi-step form */
    .form-step {
        display: none;
    }
    .form-step.active {
        display: block;
    }
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
    .step-progress-item.active .step-progress-title,
    .step-progress-item.completed .step-progress-title {
        color: #4361ee;
        font-weight: bold;
    }
    .form-navigation {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }
    .btn-next {
        margin-left: auto;
    }
</style>

    <section class="section">
        {{-- @include('admin.layout.breadcrumbs', [
            'title' => __('Create Event'),
            'headerData' => __('Event'),
            'url' => 'events',
        ]) --}}
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
        <div class="section-body">
            <div class="card row">
                <div class="alert alert-success step-completion-message" style="display: none;">
                    <i class="fas fa-check-circle mr-2"></i> Step completed successfully! You can now proceed to the next step.
                </div>
                <div class="col-lg-8 mt-3" >
                    <div class="step-progress">
                        <div class="step-progress-item active">
                            <div class="step-progress-number">1</div>
                            <div class="step-progress-title">Event Details</div>
                        </div>
                        <div class="step-progress-item">
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
                            <div class="step-progress-title">Confirm & Pay</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body"> 
                                <form method="post" class="event-form" action="{{ url('events') }}" enctype="multipart/form-data" onsubmit="return false;">
                                    @csrf
                                    
                                    <!-- Step 1: Event Details -->
                                    <div class="form-step active" id="step-1">
                                        <div class="card shadow-sm border-0">
                                                <h5 class="mb-0"> Event Details</h5>
                                                <hr>
                                           
                                            
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold text-primary">{{ __('Images/Videos') }}</label>
                                                            <div id="media-preview" class="media-preview-container border-dashed rounded-lg p-3 text-center">
                                                                <input type="file" name="image[]" id="media-upload" multiple accept="image/*,video/*" style="display: none;" />
                                                                <button type="button" id="upload-button" class="btn btn-outline-primary btn-lg">
                                                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i><br>
                                                                    <span>Click to upload</span><br>
                                                                    <small class="text-muted">Supports: JPG, PNG, MP4</small>
                                                                </button>
                                                                <div class="preview-grid mt-3 d-flex flex-wrap"></div>
                                                            </div>
                                                            @error('image')
                                                                <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                            @error('image.*')
                                                                <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold text-primary">{{ __('Event Name') }}</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                                                </div>
                                                                <input type="text" name="name" value="{{ old('name') }}"
                                                                    placeholder="{{ __('Enter event name') }}"
                                                                    class="form-control @error('name')? is-invalid @enderror">
                                                            </div>
                                                            @error('name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold text-primary" for="category_id">{{ __('Category') }}</label>
                                                                    <select id="category_id" name="category_id" class="form-control ">
                                                                        <option value="">Select Category</option>
                                                                        @foreach($category as $cat)
                                                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('category_id')
                                                                        <div class="invalid-feedback block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold text-primary" for="subcategory_id">{{ __('Subcategory') }}</label>
                                                                    <select id="subcategory_id" name="subcategory_id" class="form-control " >
                                                                        <option value="">{{ __('Select Subcategory') }}</option>
                                                                    </select>
                                                                    @error('subcategory_id')
                                                                        <div class="invalid-feedback block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr class="my-4">
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold text-primary">{{ __('Start Time') }}</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                                </div>
                                                                <input type="text" name="start_time" id="start_time"
                                                                    value="{{ old('start_time') }}"
                                                                    placeholder="{{ __('Choose Start time') }}"
                                                                    class="form-control date @error('start_time')? is-invalid @enderror">
                                                            </div>
                                                            @error('start_time')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold text-primary">{{ __('End Time') }}</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                                </div>
                                                                <input type="text" name="end_time" id="end_time"
                                                                    value="{{ old('end_time') }}" placeholder="{{ __('Choose End time') }}"
                                                                    class="form-control date @error('end_time')? is-invalid @enderror">
                                                            </div>
                                                            @error('end_time')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @if (Auth::user()->hasRole('admin'))
                                                        <div class="form-group">
                                                            <label class="font-weight-bold text-primary">{{ __('Organizer') }}</label>
                                                            <select name="user_id" required class="form-control select2" id="org-for-event">
                                                                <option value="">{{ __('Choose Organizer') }}</option>
                                                                @foreach ($users as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        {{ $item->id == old('user_id') ? 'Selected' : '' }}>
                                                                        {{ $item->first_name . ' ' . $item->last_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('user_id')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold text-primary">{{ __('Label') }}</label>
                                                            <select name="label_id" required class="form-control select2" id="label-for-event">
                                                                <option value="">{{ __('Choose Label') }}</option>
                                                                @foreach ($labels as $label)
                                                                    <option value="{{ $label->id }}" {{ old('label_id') == $label->id ? 'selected' : '' }}>
                                                                        {{ ucfirst(str_replace('_', ' ', $label->name)) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('label_id')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="font-weight-bold text-primary">{{ __('Scanner') }} <small class="text-muted">{{ __('(Required)')}} {{__('(Choose Multiple if required.)')}}</small></label>
                                                    <select name="scanner_id[]" class="form-control scanner_id select2" multiple data-live-search="true">
                                                        <option value="" disabled>{{ __('Choose Scanner') }}</option>
                                                        @foreach ($scanner as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ in_array($item->id, old('scanner_id', [])) ? 'selected' : '' }}>
                                                                {{ $item->first_name . ' ' . $item->last_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('scanner_id')
                                                        <div class="invalid-feedback block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold text-primary">{{ __('Maximum Capacity') }}</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                                                </div>
                                                                <input type="number" min='1' name="people" id="people"
                                                                    value="{{ old('people') }}"
                                                                    placeholder="{{ __('Maximum attendees') }}"
                                                                    class="form-control @error('people')? is-invalid @enderror">
                                                            </div>
                                                            @error('people')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold text-primary">{{ __('Status') }}</label>
                                                            <select name="status" class="form-control select2">
                                                                <option value="1">{{ __('Active') }}</option>
                                                                <option value="0">{{ __('Inactive') }}</option>
                                                            </select>
                                                            @error('status')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold text-primary">{{ __('Tags') }}</label>
                                                            <input type="text" name="tags" value="{{ old('tags') }}"
                                                                class="form-control inputtags @error('tags')? is-invalid @enderror" 
                                                                placeholder="Add tags (comma separated)">
                                                            @error('tags')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold text-primary">{{ __('Event URL') }}</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-link"></i></span>
                                                                </div>
                                                                <input type="text" name="urls" value="{{ old('urls') }}"
                                                                    placeholder="{{ __('https://example.com') }}"
                                                                    class="form-control @error('urls')? is-invalid @enderror">
                                                            </div>
                                                            @error('urls')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="font-weight-bold text-primary">{{ __('Description') }}</label>
                                                    <textarea name="description" placeholder="Enter detailed event description..."
                                                        class="form-control textarea_editor @error('description')? is-invalid @enderror" rows="5">
                                                        {{ old('description') }}
                                                    </textarea>
                                                    @error('description')
                                                        <div class="invalid-feedback block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="form-navigation mt-4 pt-3 border-top">
                                                    <button type="button" class="btn btn-primary btn-lg btn-next float-right">
                                                        Next <i class="fas fa-arrow-right ml-2"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <style>
                                    .border-dashed {
                                        border: 2px dashed #dee2e6;
                                        transition: all 0.3s;
                                    }
                                    .border-dashed:hover {
                                        border-color: #007bff;
                                        background-color: #f8f9fa;
                                    }
                                    .media-preview-container {
                                        min-height: 200px;
                                        display: flex;
                                        flex-direction: column;
                                        justify-content: center;
                                    }
                                    .preview-grid {
                                        gap: 10px;
                                    }
                                    .preview-grid .preview-item {
                                        width: 80px;
                                        height: 80px;
                                        border-radius: 5px;
                                        overflow: hidden;
                                        position: relative;
                                    }
                                    .preview-grid .preview-item video, 
                                    .preview-grid .preview-item img {
                                        width: 100%;
                                        height: 100%;
                                        object-fit: cover;
                                    }
                                    .preview-grid .remove-media {
                                        position: absolute;
                                        top: 2px;
                                        right: 2px;
                                        background: rgba(0,0,0,0.5);
                                        color: white;
                                        border: none;
                                        width: 20px;
                                        height: 20px;
                                        border-radius: 50%;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        font-size: 10px;
                                    }
                                    .card {
                                        border-radius: 10px;
                                        overflow: hidden;
                                    }
                                    .select2-container--default .select2-selection--multiple {
                                        min-height: 38px;
                                        border: 1px solid #ced4da;
                                    }
                                    .textarea_editor {
                                        min-height: 150px;
                                    }
                                </style>

                                <script>
                                // You'll need to add JavaScript for media preview functionality
                                document.addEventListener('DOMContentLoaded', function() {
                                    const mediaUpload = document.getElementById('media-upload');
                                    const uploadButton = document.getElementById('upload-button');
                                    const previewContainer = document.querySelector('.preview-grid');
                                    
                                    uploadButton.addEventListener('click', () => mediaUpload.click());
                                    
                                    mediaUpload.addEventListener('change', function() {
                                        previewContainer.innerHTML = '';
                                        Array.from(this.files).forEach(file => {
                                            const previewItem = document.createElement('div');
                                            previewItem.className = 'preview-item';
                                            
                                            if (file.type.startsWith('image/')) {
                                                const img = document.createElement('img');
                                                img.src = URL.createObjectURL(file);
                                                previewItem.appendChild(img);
                                            } else if (file.type.startsWith('video/')) {
                                                const video = document.createElement('video');
                                                video.src = URL.createObjectURL(file);
                                                video.controls = true;
                                                previewItem.appendChild(video);
                                            }
                                            
                                            const removeBtn = document.createElement('button');
                                            removeBtn.className = 'remove-media';
                                            removeBtn.innerHTML = '&times;';
                                            removeBtn.addEventListener('click', (e) => {
                                                e.preventDefault();
                                                previewItem.remove();
                                                // You might want to handle the file removal from the input here
                                            });
                                            
                                            previewItem.appendChild(removeBtn);
                                            previewContainer.appendChild(previewItem);
                                        });
                                    });
                                });
                                </script>

                           
                            <!-- Step 2: Venue Details -->
                                <div class="form-step" id="step-2">
                                    <h4 class="mb-4">Venue Details</h4>
                                    {{-- {{ route('event-venue.create') }} --}}
                                     <form action="" method="POST" enctype="multipart/form-data">
                                        @csrf
                                    
                                        {{-- <input type="hidden" id="event_id" name="event_id" class="form-control" value="{{ $event->id }}" required>  --}}
                                        
                                        <div class="form-group">
                                            <label for="name">{{ __('Venue Name') }}</label>
                                            <div class="input-group">
                                                <select name="venue_id" id="venue_id" class="form-control select2" required onchange="checkAvailability()">  
                                                    <option value="">select</option>
                                                    @foreach($venues as $venue)
                                                    @php
                                                       $eventDate = Carbon\Carbon::parse('2025-07-15 00:00:00')->startOfDay();
                                                        $isAvailable = $venueAvailability->where('venue_id', $venue->id)
                                                            ->first(function ($availability) use ($eventDate) {
                                                                return Carbon\Carbon::parse($availability->date)->isSameDay($eventDate) 
                                                                    && $availability->is_available;
                                                            });
                                                    @endphp
                                                        <option value="{{ $venue->id }}" data-available="{{ $isAvailable ? '1' : '0' }}">
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
                                                value="" onchange="updateAvailability()">
                                        </div>
                                    </form>
                                    
                                    <div class="form-navigation">
                                        <button type="button" class="btn btn-secondary btn-prev"><i class="fas fa-arrow-left"></i> Previous</button>
                                        <button type="button" class="btn btn-primary btn-next">Next <i class="fas fa-arrow-right"></i></button>
                                    </div>
                                </div>

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
                                
                                <!-- Step 3: Fabrication Details -->
                                <div class="form-step" id="step-3">
                                        <h4 class="mb-4">Fabrication Details</h4>
                                        
                                        <div class="row">
                                            <!-- Fabric Type Selection with Images -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="d-block mb-3">{{ __('Select Fabric Type') }}</label>
                                                    <div class="row">
                                                        <div class="col-md-2 col-4 mb-3" >
                                                            <input type="radio" name="fabric_type" id="fabric-velvet" value="velvet" class="d-none" checked>
                                                            <label for="fabric-velvet" class="card card-body p-1 text-center fabric-option h-100 d-flex flex-column justify-content-between">
                                                                <img src="{{asset('fabrication/vellat.jpeg')}}" alt="Velvet" class="img-fluid rounded mx-auto" >
                                                                <h6 class="mb-0 mt-1" style="font-size: 0.9rem;">Velvet</h6>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2 col-4 mb-3" >
                                                            <input type="radio" name="fabric_type" id="fabric-satin" value="satin" class="d-none">
                                                            <label for="fabric-satin" class="card card-body p-1 text-center fabric-option h-100 d-flex flex-column justify-content-between">
                                                                <img src="{{asset('fabrication/Satin.jpeg')}}" alt="Satin" class="img-fluid rounded mx-auto">
                                                                <h6 class="mb-0 mt-1" style="font-size: 0.9rem;">Satin</h6>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2 col-4 mb-3" >
                                                            <input type="radio" name="fabric_type" id="fabric-silk" value="silk" class="d-none">
                                                            <label for="fabric-silk" class="card card-body p-1 text-center fabric-option h-100 d-flex flex-column justify-content-between">
                                                                <img src="{{asset('fabrication/Silk.jpeg')}}" alt="Silk" class="img-fluid rounded mx-auto" >
                                                                <h6 class="mb-0 mt-1" style="font-size: 0.9rem;">Silk</h6>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2 col-4 mb-3" >
                                                            <input type="radio" name="fabric_type" id="fabric-linen" value="linen" class="d-none">
                                                            <label for="fabric-linen" class="card card-body p-1 text-center fabric-option h-100 d-flex flex-column justify-content-between">
                                                                <img src="{{asset('fabrication/organic-linen-fabric.jpg')}}" alt="Linen" class="img-fluid rounded mx-auto" >
                                                                <h6 class="mb-0 mt-1" style="font-size: 0.9rem;">Linen</h6>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @error('fabric_type')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <!-- Tablecloths Selection -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="d-block mb-3">{{ __('Choose Tablecloths') }}</label>
                                                    <div class="row">
                                                        <div class="col-md-2 col-4 mb-3">
                                                            <input type="checkbox" name="tablecloths[]" id="tablecloth-round" value="round" class="d-none">
                                                            <label for="tablecloth-round" class="card card-body p-1 text-center tablecloth-option">
                                                                <img src="{{asset('fabrication/Round.jpeg')}}"  alt="Round" class="img-fluid rounded mb-1">
                                                                <small>Round</small>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2 col-4 mb-3">
                                                            <input type="checkbox" name="tablecloths[]" id="tablecloth-rectangle" value="rectangle" class="d-none">
                                                            <label for="tablecloth-rectangle" class="card card-body p-1 text-center tablecloth-option">
                                                                <img src="{{asset('fabrication/Rectangle.jpeg')}}"  alt="Rectangle" class="img-fluid rounded mb-1">
                                                                <small>Rectangle</small>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2 col-4 mb-3">
                                                            <input type="checkbox" name="tablecloths[]" id="tablecloth-square" value="square" class="d-none">
                                                            <label for="tablecloth-square" class="card card-body p-1 text-center tablecloth-option">
                                                                <img src="{{asset('fabrication/Square.jpeg')}}"  alt="Square" class="img-fluid rounded mb-1">
                                                                <small>Square</small>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2 col-4 mb-3">
                                                            <input type="checkbox" name="tablecloths[]" id="tablecloth-oval" value="oval" class="d-none">
                                                            <label for="tablecloth-oval" class="card card-body p-1 text-center tablecloth-option">
                                                                <img src="{{asset('fabrication/Oval.jpeg')}}"  alt="Oval" class="img-fluid rounded mb-1">
                                                                <small>Oval</small>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @error('tablecloths')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <!-- Drapes Selection -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="d-block mb-3">{{ __('Choose Drapes Style') }}</label>
                                                    <div class="row">
                                                        <div class="col-md-3 col-6 mb-4">
                                                            <input type="radio" name="drapes_style" id="drapes-pinch" value="pinch_pleat" class="d-none" checked>
                                                            <label for="drapes-pinch" class="card card-body p-2 text-center drapes-option">
                                                                <img src="{{asset('fabrication/Pinch_Pleat.jpeg')}}" alt="Pinch Pleat" class="img-fluid rounded mb-2">
                                                                <h6 class="mb-0">Pinch Pleat</h6>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3 col-6 mb-4">
                                                            <input type="radio" name="drapes_style" id="drapes-grommet" value="grommet" class="d-none">
                                                            <label for="drapes-grommet" class="card card-body p-2 text-center drapes-option">
                                                                <img src="{{asset('fabrication/Grommet.jpeg')}}" alt="Grommet" class="img-fluid rounded mb-2">
                                                                <h6 class="mb-0">Grommet</h6>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3 col-6 mb-4">
                                                            <input type="radio" name="drapes_style" id="drapes-rod" value="rod_pocket" class="d-none">
                                                            <label for="drapes-rod" class="card card-body p-2 text-center drapes-option">
                                                                <img src="{{asset('fabrication/Rod_Pocket.jpeg')}}" alt="Rod Pocket" class="img-fluid rounded mb-2">
                                                                <h6 class="mb-0">Rod Pocket</h6>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3 col-6 mb-4">
                                                            <input type="radio" name="drapes_style" id="drapes-back" value="back_tab" class="d-none">
                                                            <label for="drapes-back" class="card card-body p-2 text-center drapes-option">
                                                                <img src="{{asset('fabrication/Back_tab.jpeg')}}" alt="Back Tab" class="img-fluid rounded mb-2">
                                                                <h6 class="mb-0">Back Tab</h6>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @error('drapes_style')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <!-- Fabric Color Picker -->
                                           <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ __('Fabric Color') }}</label>
                                                    <div class="input-group">
                                                        <input type="color" name="fabric_color" value="#3490dc" class="form-control" style="height: 38px; padding: 3px;">
                                                        
                                                    </div>
                                                    @error('fabric_color')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <script>
                                                document.querySelector('input[name="fabric_color"]').addEventListener('input', function() {
                                                    this.nextElementSibling.querySelector('i').style.color = this.value;
                                                });
                                                </script>
                                                
                                            
                                            <!-- Fabric Quantity -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ __('Fabric Quantity (in yards)') }}</label>
                                                    <input type="number" name="fabric_quantity" min="1" value="1" 
                                                        class="form-control @error('fabric_quantity')? is-invalid @enderror">
                                                    @error('fabric_quantity')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <!-- Custom Fabric Upload -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>{{ __('Upload Custom Fabric Design (Optional)') }}</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="custom_fabric" id="custom-fabric" class="custom-file-input">
                                                        <label class="custom-file-label" for="custom-fabric">Choose file</label>
                                                    </div>
                                                    <small class="form-text text-muted">Upload your own fabric design (JPG, PNG, max 5MB)</small>
                                                    @error('custom_fabric')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="form-navigation">
                                            <button type="button" class="btn btn-secondary btn-prev"><i class="fas fa-arrow-left"></i> Previous</button>
                                            <button type="button" class="btn btn-primary btn-next">Next <i class="fas fa-arrow-right"></i></button>
                                        </div>
                                </div>

                                    <style>
                                        /* Custom styling for the image selection options */
                                        .fabric-option, .tablecloth-option, .drapes-option {
                                            cursor: pointer;
                                            transition: all 0.3s;
                                            border: 2px solid transparent;
                                        }
                                        .fabric-option:hover, .tablecloth-option:hover, .drapes-option:hover {
                                            transform: translateY(-5px);
                                            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                                        }
                                        input[type="radio"]:checked + .fabric-option,
                                        input[type="radio"]:checked + .drapes-option {
                                            border-color: #4361ee;
                                            background-color: #f0f7ff;
                                        }
                                        input[type="checkbox"]:checked + .tablecloth-option {
                                            border-color: #4361ee;
                                            background-color: #f0f7ff;
                                        }
                                        .colorpicker .input-group-text {
                                            cursor: pointer;
                                        }
                                        #fabric-preview {
                                            min-height: 250px;
                                            display: flex;
                                            flex-direction: column;
                                            align-items: center;
                                            justify-content: center;
                                        }
                                    </style>

                                    <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        // Update fabric preview when selections change
                                        document.querySelectorAll('input[name="fabric_type"]').forEach(radio => {
                                            radio.addEventListener('change', function() {
                                                document.getElementById('preview-fabric-type').textContent = 
                                                    document.querySelector('label[for="' + this.id + '"] h6').textContent;
                                                updateFabricPreviewImage();
                                            });
                                        });
                                        
                                        // Update color preview
                                        document.querySelector('input[name="fabric_color"]').addEventListener('change', function() {
                                            document.getElementById('preview-fabric-color').textContent = this.value;
                                            document.querySelector('.colorpicker .input-group-text i').style.color = this.value;
                                            updateFabricPreviewImage();
                                        });
                                        
                                        // Handle file upload preview
                                        document.getElementById('custom-fabric').addEventListener('change', function(e) {
                                            if (this.files && this.files[0]) {
                                                const reader = new FileReader();
                                                reader.onload = function(event) {
                                                    document.getElementById('fabric-preview-image').src = event.target.result;
                                                }
                                                reader.readAsDataURL(this.files[0]);
                                            }
                                        });
                                        
                                        function updateFabricPreviewImage() {
                                            // In a real app, you would update the preview image based on selections
                                            const fabricType = document.querySelector('input[name="fabric_type"]:checked').value;
                                            const color = document.querySelector('input[name="fabric_color"]').value;
                                            // This is just a placeholder - you would generate or load appropriate images
                                            document.getElementById('fabric-preview-image').src = 
                                                `https://via.placeholder.com/300x200/${color.substring(1)}/ffffff?text=${fabricType}`;
                                        }
                                        
                                        // Initialize color picker
                                        $('[name="fabric_color"]').colorpicker({
                                            format: 'hex',
                                            component: '.input-group-append i',
                                        });
                                    });
                                    </script>
                                
                                <!-- Step 4: Accessories Details -->
                                <div class="form-step" id="step-4">
                                    <h4 class="mb-4">Accessories Details</h4>
                                    
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{ __('Lighting Requirements') }}</label>
                                                <select name="lighting" class="form-control">
                                                    <option value="basic">Basic Lighting</option>
                                                    <option value="professional">Professional Lighting</option>
                                                    <option value="custom">Custom Lighting</option>
                                                    <option value="none">None</option>
                                                </select>
                                                @error('lighting')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{ __('Sound System') }}</label>
                                                <select name="sound_system" class="form-control">
                                                    <option value="basic">Basic Sound System</option>
                                                    <option value="professional">Professional Sound System</option>
                                                    <option value="custom">Custom Sound System</option>
                                                    <option value="none">None</option>
                                                </select>
                                                @error('sound_system')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{ __('Seating Arrangement') }}</label>
                                                <select name="seating" class="form-control">
                                                    <option value="theater">Theater Style</option>
                                                    <option value="classroom">Classroom Style</option>
                                                    <option value="banquet">Banquet Style</option>
                                                    <option value="custom">Custom</option>
                                                    <option value="none">None</option>
                                                </select>
                                                @error('seating')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{ __('Other Equipment') }}</label>
                                                <input type="text" name="other_equipment" value="{{ old('other_equipment') }}"
                                                    placeholder="{{ __('Other Equipment') }}"
                                                    class="form-control @error('other_equipment')? is-invalid @enderror">
                                                @error('other_equipment')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>{{ __('Additional Notes') }}</label>
                                        <textarea name="accessories_notes" placeholder="Any additional notes for accessories"
                                            class="form-control @error('accessories_notes')? is-invalid @enderror">{{ old('accessories_notes') }}</textarea>
                                        @error('accessories_notes')
                                            <div class="invalid-feedback block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-navigation">
                                        <button type="button" class="btn btn-secondary btn-prev"><i class="fas fa-arrow-left"></i> Previous</button>
                                        <button type="button" class="btn btn-primary btn-next">Next <i class="fas fa-arrow-right"></i></button>
                                    </div>
                                </div>
                                
                                <!-- Step 5: Confirmation & Payment -->
                                <div class="form-step" id="step-5">
                                    <h4 class="mb-4">Review & Confirm</h4>
                                    
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h6>Event Details</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Event Name:</strong> <span id="review-name"></span></p>
                                                    <p><strong>Start Time:</strong> <span id="review-start-time"></span></p>
                                                    <p><strong>End Time:</strong> <span id="review-end-time"></span></p>
                                                    <p><strong>Description:</strong> <span id="review-description"></span></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Category:</strong> <span id="review-category"></span></p>
                                                    <p><strong>Subcategory:</strong> <span id="review-subcategory"></span></p>
                                                    <p><strong>Max People:</strong> <span id="review-people"></span></p>
                                                    <p><strong>Status:</strong> <span id="review-status"></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5>Venue Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Venue Name:</strong> <span id="review-venue-name"></span></p>
                                                    <p><strong>Venue Type:</strong> <span id="review-venue-type"></span></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Address:</strong> <span id="review-address"></span></p>
                                                    <p><strong>Capacity:</strong> <span id="review-capacity"></span></p>
                                                </div>
                                            </div>
                                            <p><strong>Venue Description:</strong> <span id="review-venue-description"></span></p>
                                        </div>
                                    </div>
                                    
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5>Fabrication Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Fabrication Type:</strong> <span id="review-fabrication-type"></span></p>
                                                    <p><strong>Dimensions:</strong> <span id="review-dimensions"></span></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Material:</strong> <span id="review-material"></span></p>
                                                    <p><strong>Special Requirements:</strong> <span id="review-special-requirements"></span></p>
                                                </div>
                                            </div>
                                            <p><strong>Fabrication Notes:</strong> <span id="review-fabrication-notes"></span></p>
                                        </div>
                                    </div>
                                    
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5>Accessories Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Lighting:</strong> <span id="review-lighting"></span></p>
                                                    <p><strong>Sound System:</strong> <span id="review-sound-system"></span></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Seating Arrangement:</strong> <span id="review-seating"></span></p>
                                                    <p><strong>Other Equipment:</strong> <span id="review-other-equipment"></span></p>
                                                </div>
                                            </div>
                                            <p><strong>Additional Notes:</strong> <span id="review-accessories-notes"></span></p>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="payment_method">{{ __('Payment Method') }}</label>
                                        <select name="payment_method" id="payment_method" class="form-control">
                                            <option value="credit_card">Credit Card</option>
                                            <option value="paypal">PayPal</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">terms and conditions</a>
                                        </label>
                                        @error('terms')
                                            <div class="invalid-feedback block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-navigation">
                                        <button type="button" class="btn btn-secondary btn-prev"><i class="fas fa-arrow-left"></i> Previous</button>
                                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Submit & Pay</button>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

  

    <script>
       document.addEventListener('DOMContentLoaded', function() {
    // =============================================
    // Media Upload Handling
    // =============================================
    const fileInput = document.getElementById('media-upload');
    const uploadButton = document.getElementById('upload-button');
    const previewContainer = document.getElementById('media-preview');
    const previewGrid = previewContainer.querySelector('.preview-grid');
    let allFiles = [];

    uploadButton.addEventListener('click', function() {
        fileInput.click();
    });

    fileInput.addEventListener('change', function(event) {
        const newFiles = Array.from(event.target.files);
        if ((allFiles.length + newFiles.length) > 5) {
            alert("You can only upload a maximum of 5 media files.");
            return;
        }
        allFiles = [...allFiles, ...newFiles];
        updateInputFiles();
        updatePreviews();
    });

    function updateInputFiles() {
        const dt = new DataTransfer();
        allFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
    }

    function updatePreviews() {
        previewGrid.innerHTML = '';

        allFiles.forEach((file, index) => {
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item';

            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                previewItem.appendChild(img);
            } else if (file.type.startsWith('video/')) {
                const video = document.createElement('video');
                video.src = URL.createObjectURL(file);
                video.controls = true;
                previewItem.appendChild(video);
            }

            const removeBtn = document.createElement('button');
            removeBtn.className = 'remove-media';
            removeBtn.innerHTML = '&times;';
            removeBtn.onclick = (e) => {
                e.preventDefault();
                allFiles.splice(index, 1);
                updateInputFiles();
                updatePreviews();
            };

            previewItem.appendChild(removeBtn);
            previewGrid.appendChild(previewItem);
        });

        // Show/hide upload button based on files count
        if (allFiles.length > 0) {
            uploadButton.style.display = 'none';
        } else {
            uploadButton.style.display = 'block';
        }
    }

    // =============================================
    // Category and Subcategory Handling
    // =============================================
    const categoryElement = document.getElementById('category_id');
    const subcategoryElement = document.getElementById('subcategory_id');

    if (categoryElement) {
        categoryElement.addEventListener('change', function() {
            const categoryId = this.value;
            
            subcategoryElement.innerHTML = '<option value="">Select Subcategory</option>';
            subcategoryElement.disabled = true;

            if (categoryId) {
                fetch(`/subcategories/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(subcategory => {
                        const option = document.createElement('option');
                        option.value = subcategory.id;
                        option.textContent = subcategory.name;
                        subcategoryElement.appendChild(option);
                    });
                    subcategoryElement.disabled = false;
                })
                .catch(error => {
                    console.error('Error fetching subcategories:', error);
                });
            }
        });
    }

    // =============================================
    // Venue Availability Calendar
    // =============================================
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

    // Initialize venue availability check
    if (document.getElementById('venue_id')) {
        document.getElementById('venue_id').addEventListener('change', checkAvailability);
        document.getElementById('event_date').addEventListener('change', checkAvailability);
        document.getElementById('viewCalendarBtn').addEventListener('click', showCalendar);
    }

    // =============================================
    // Multi-step Form Navigation
    // =============================================
    const formSteps = document.querySelectorAll('.form-step');
    const prevButtons = document.querySelectorAll('.btn-prev');
    const nextButtons = document.querySelectorAll('.btn-next');
    const progressItems = document.querySelectorAll('.step-progress-item');
    let currentStep = 0;
    
    // Show current step
    showStep(currentStep);
    
    // Next button click handler
   // Next button click handler
   // Next button click handler
    nextButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault(); // Prevent default form submission
            
            if (validateStep(currentStep)) {
                try {
                    const response = await saveStep(currentStep + 1); // +1 because steps are 1-based in backend
                    
                    // If this is step 1 and we got a successful response
                    if (currentStep === 0 && response.success) {
                        // Show completion message for step 1
                        const completionMsg = document.querySelector('.step-completion-message');
                        completionMsg.style.display = 'block';
                        
                        // Scroll to show the message
                        completionMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        
                        // Hide after 3 seconds
                        setTimeout(() => {
                            completionMsg.style.display = 'none';
                        }, 3000);
                        
                        // Move to next step
                        currentStep++;
                        showStep(currentStep);
                        updateProgress();
                    }
                    // For other steps, just proceed
                    else if (response.success) {
                        currentStep++;
                        showStep(currentStep);
                        updateProgress();
                    }
                } catch (error) {
                    console.error('Error saving step:', error);
                    alert('Error saving step: ' + error.message);
                }
            }
        });
    });
    
    // Previous button click handler
    prevButtons.forEach(button => {
        button.addEventListener('click', function() {
            currentStep--;
            showStep(currentStep);
            updateProgress();
        });
    });
    
    // Show specific step
    function showStep(stepIndex) {
        formSteps.forEach((step, index) => {
            step.classList.toggle('active', index === stepIndex);
            
            // Hide all completion messages when changing steps
            step.querySelectorAll('.step-completion-message').forEach(msg => {
                msg.style.display = 'none';
            });
        });
        
        // On last step, update review fields
        if (stepIndex === formSteps.length - 1) {
            updateReviewFields();
        }
    }

    // In the next button handler:
    if (currentStep === 0) {
        document.querySelector('#step-1 .step-completion-message').style.display = 'block';
    }
    
    // Update progress indicators
    function updateProgress() {
        progressItems.forEach((item, index) => {
            if (index < currentStep) {
                item.classList.add('completed');
                item.classList.remove('active');
            } else if (index === currentStep) {
                item.classList.add('active');
                item.classList.remove('completed');
            } else {
                item.classList.remove('active', 'completed');
            }
        });
    }
    
    // Validate current step before proceeding
    function validateStep(stepIndex) {
        let isValid = true;
        const currentStepElement = formSteps[stepIndex];
        const currentStepFields = currentStepElement.querySelectorAll('[name]');
        
        // Clear previous error messages
        currentStepElement.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        currentStepElement.querySelectorAll('.invalid-feedback').forEach(el => {
            el.remove();
        });
        
        // Validate required fields
        currentStepFields.forEach(field => {
            if (field.required && !field.value) {
                field.classList.add('is-invalid');
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = 'This field is required';
                field.parentNode.appendChild(errorDiv);
                isValid = false;
            }
        });
        
        // Special validation for step 2 (venue)
        if (stepIndex === 1) {
            const venueSelect = document.getElementById('venue_id');
            const selectedOption = venueSelect.options[venueSelect.selectedIndex];
            const isAvailable = selectedOption.getAttribute('data-available') === '1';
            
            if (!isAvailable) {
                alert('The selected venue is not available on the chosen date. Please select another venue or date.');
                isValid = false;
            }
        }
        
        if (!isValid) {
            currentStepElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        
        return isValid;
    }
    
    // Save step data to server
    async function saveStep(step) {
        const form = document.querySelector('.event-form');
        const formData = new FormData(form);
        formData.append('step', step);
        
        // Get event ID if it exists
        const eventId = document.getElementById('event-id') ? document.getElementById('event-id').value : null;
        if (eventId) {
            formData.append('event_id', eventId);
        }
        
        // Add all media files
        if (allFiles.length > 0 && step === 1) {
            allFiles.forEach(file => {
                formData.append('image[]', file);
            });
        }
        
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (!data.success) {
            // Handle validation errors
            if (data.errors) {
                for (const [field, errors] of Object.entries(data.errors)) {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = errors[0];
                        input.parentNode.appendChild(errorDiv);
                    }
                }
                throw new Error('Validation errors occurred');
            }
            throw new Error(data.message || 'Error saving step');
        }
        
        // Store event ID if this is step 1
        if (step === 1 && data.event_id) {
            if (!document.getElementById('event-id')) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.id = 'event-id';
                hiddenInput.name = 'event_id';
                hiddenInput.value = data.event_id;
                form.appendChild(hiddenInput);
            } else {
                document.getElementById('event-id').value = data.event_id;
            }
        }
        
        // Handle final step redirect
        if (step === 5 && data.redirect) {
            window.location.href = data.redirect;
        }
        
        return data;
    }
    
    // Update review fields on confirmation step
    function updateReviewFields() {
        // Event Details
        document.getElementById('review-name').textContent = document.querySelector('[name="name"]').value;
        document.getElementById('review-start-time').textContent = document.querySelector('[name="start_time"]').value;
        document.getElementById('review-end-time').textContent = document.querySelector('[name="end_time"]').value;
        document.getElementById('review-description').textContent = document.querySelector('[name="description"]').value;
        document.getElementById('review-category').textContent = document.querySelector('[name="category_id"] option:checked').text;
        document.getElementById('review-subcategory').textContent = document.querySelector('[name="subcategory_id"] option:checked').text;
        document.getElementById('review-people').textContent = document.querySelector('[name="people"]').value;
        document.getElementById('review-status').textContent = document.querySelector('[name="status"] option:checked').text;
        
        // Venue Details
        const venueSelect = document.getElementById('venue_id');
        if (venueSelect && venueSelect.options[venueSelect.selectedIndex]) {
            document.getElementById('review-venue-name').textContent = venueSelect.options[venueSelect.selectedIndex].text.split(' (')[0];
        }
        document.getElementById('review-event-date').textContent = document.getElementById('event_date').value;
        
        // Fabrication Details
        document.getElementById('review-fabric-type').textContent = document.querySelector('[name="fabric_type"]:checked') ? 
            document.querySelector('[name="fabric_type"]:checked').nextElementSibling.textContent.trim() : '';
        
        const tablecloths = Array.from(document.querySelectorAll('[name="tablecloths[]"]:checked'))
            .map(el => el.nextElementSibling.textContent.trim())
            .join(', ');
        document.getElementById('review-tablecloths').textContent = tablecloths || 'None';
        
        document.getElementById('review-drapes-style').textContent = document.querySelector('[name="drapes_style"]:checked') ?
            document.querySelector('[name="drapes_style"]:checked').nextElementSibling.textContent.trim() : '';
        
        document.getElementById('review-fabric-color').textContent = document.querySelector('[name="fabric_color"]').value;
        document.getElementById('review-fabric-quantity').textContent = document.querySelector('[name="fabric_quantity"]').value;
        
        // Accessories Details
        document.getElementById('review-lighting').textContent = document.querySelector('[name="lighting"] option:checked').text;
        document.getElementById('review-sound-system').textContent = document.querySelector('[name="sound_system"] option:checked').text;
        document.getElementById('review-seating').textContent = document.querySelector('[name="seating"] option:checked').text;
        document.getElementById('review-other-equipment').textContent = document.querySelector('[name="other_equipment"]').value || 'None';
        document.getElementById('review-accessories-notes').textContent = document.querySelector('[name="accessories_notes"]').value || 'None';
    }

    // =============================================
    // Fabrication Options Styling
    // =============================================
    document.querySelectorAll('.fabric-option, .tablecloth-option, .drapes-option').forEach(option => {
        option.addEventListener('click', function() {
            // For radio buttons
            if (this.previousElementSibling.type === 'radio') {
                document.querySelectorAll(`[name="${this.previousElementSibling.name}"] + label`).forEach(label => {
                    label.classList.remove('active');
                });
                this.classList.add('active');
                this.previousElementSibling.checked = true;
            }
            // For checkboxes
            else if (this.previousElementSibling.type === 'checkbox') {
                this.classList.toggle('active');
                this.previousElementSibling.checked = !this.previousElementSibling.checked;
            }
        });
    });

    // Initialize color picker
    if (document.querySelector('[name="fabric_color"]')) {
        document.querySelector('[name="fabric_color"]').addEventListener('input', function() {
            document.getElementById('fabric-color-preview').style.backgroundColor = this.value;
        });
    }
});


    </script>


    
@endsection