@extends('master')

@section('content')
    <section class="section">
        <style>
            /* Progress Bar Styles */
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
                height: 3px;
                background: linear-gradient(90deg, #4cc550 80%, #e0e0e0 20%);
                transform: translateY(-50%);
                z-index: 1;
                border-radius: 10px;
            }

            .step-progress-item {
                position: relative;
                z-index: 2;
                text-align: center;
                width: 20%;
            }

            .step-progress-number {
                width: 45px;
                height: 45px;
                border-radius: 50%;
                background: #e0e0e0;
                color: #666;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 10px;
                font-weight: bold;
                font-size: 18px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }

            .step-progress-item.active .step-progress-number {
                background: #4361ee;
                color: white;
                transform: scale(1.1);
                box-shadow: 0 4px 8px rgba(67, 97, 238, 0.3);
            }

            .step-progress-item.completed .step-progress-number {
                background: #4cc550;
                color: white;
            }

            .step-progress-title {
                font-size: 14px;
                color: #666;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .step-progress-item.active .step-progress-title {
                color: #4361ee;
                font-weight: 600;
                font-size: 15px;
            }

            .step-progress-item.completed .step-progress-title {
                color: #4cc550;
                font-weight: 600;
            }

            /* Review Section Styles */
            .review-section {
                border-radius: 8px;
                margin-bottom: 5px;
                overflow: hidden;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                border: 1px solid #eaeaea;
            }

            .review-section-header {
                background-color: #f8f9fa;
                padding: 15px 20px;
                border-bottom: 1px solid #eaeaea;
                display: flex;
                justify-content: space-between;
                align-items: center;
                cursor: pointer;
            }

            .review-section-header h5 {
                margin: 0;
                color: #333;
                font-weight: 600;
            }

            .review-section-header i {
                transition: transform 0.3s ease;
            }

            .review-section-header.collapsed i {
                transform: rotate(180deg);
            }

            .review-section-body {
                padding: 20px;
                background-color: white;
            }

            .detail-row {
                display: flex;
                margin-bottom: 15px;
                padding-bottom: 15px;
                border-bottom: 1px dashed #eee;
            }

            .detail-row:last-child {
                margin-bottom: 0;
                padding-bottom: 0;
                border-bottom: none;
            }

            .detail-label {
                width: 200px;
                font-weight: 700;
                color: #040303;
            }

            .detail-value {
                flex: 1;
                color: #333;
            }

            .badge-custom {
                background-color: #e9f7ef;
                color: #28a745;
                padding: 5px 10px;
                border-radius: 4px;
                font-size: 13px;
                font-weight: 500;
            }

            /* Final Submission Card */
            .final-submission-card {
                border-left: 4px solid #4361ee;
                border-radius: 8px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                transition: transform 0.3s ease;
                margin-top: 30px;
            }

            .checklist-item {
                display: flex;
                align-items: center;
                margin-bottom: 12px;
            }

            .checklist-item i {
                color: #4cc550;
                margin-right: 10px;
                font-size: 18px;
            }

            .submit-btn {
                background: linear-gradient(135deg, #4361ee, #3a0ca3);
                border: none;
                padding: 12px 30px;
                font-size: 16px;
                font-weight: 600;
                letter-spacing: 0.5px;
                transition: all 0.3s ease;
            }

            .submit-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 12px rgba(67, 97, 238, 0.3);
            }

            .review-btn {
                background: white;
                border: 2px solid #4361ee;
                color: #4361ee;
                padding: 12px 30px;
                font-size: 16px;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .review-btn:hover {
                background: #f8f9fa;
            }

            /* Image Thumbnails */
            .image-thumbnail {
                width: 80px;
                height: 80px;
                object-fit: cover;
                border-radius: 4px;
                margin-right: 10px;
                margin-bottom: 10px;
                border: 1px solid #ddd;
                transition: transform 0.3s ease;
            }

            .image-thumbnail:hover {
                transform: scale(1.05);
                cursor: pointer;
            }

            /* New Sticky Footer Styles */
            .content-container {
                position: relative;
                min-height: calc(100vh - 180px);
                padding-bottom: 120px;
                /* Space for sticky footer */
            }

            .sticky-footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: white;
                padding: 20px;
                box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.05);
                border-top: 1px solid #eee;
                z-index: 1000;
                transition: all 0.3s ease;
            }

            .footer-content {
                max-width: 1140px;
                margin: 0 auto;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .confirmation-checkbox {
                display: flex;
                align-items: center;
                margin-right: 20px;
            }

            .confirmation-checkbox input {
                margin-right: 10px;
            }

            .button-group {
                display: flex;
                gap: 15px;
            }

            .scrollable-content {
                max-height: calc(100vh - 300px);
                overflow-y: auto;
                padding-right: 10px;
            }

            .scrollable-content::-webkit-scrollbar {
                width: 6px;
            }

            .scrollable-content::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            .scrollable-content::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 10px;
            }

            .scrollable-content::-webkit-scrollbar-thumb:hover {
                background: #a8a8a8;
            }
        </style>

        <div class="section-body">
            <div class="card row">
                <div class="col-lg-8 mt-3">
                    <div class="step-progress">
                        <div class="step-progress-item completed">
                            <div class="step-progress-number">1</div>
                            <div class="step-progress-title">Event Details</div>
                        </div>
                        <div class="step-progress-item completed">
                            <div class="step-progress-number">2</div>
                            <div class="step-progress-title">Venue</div>
                        </div>
                        <div class="step-progress-item completed">
                            <div class="step-progress-number">3</div>
                            <div class="step-progress-title">Fabrication</div>
                        </div>
                        <div class="step-progress-item completed">
                            <div class="step-progress-number">4</div>
                            <div class="step-progress-title">Accessories</div>
                        </div>
                        <div class="step-progress-item active">
                            <div class="step-progress-number">5</div>
                            <div class="step-progress-title">Final Submission</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-container">
                <div class="row">
                    <div class="col-12 scrollable-content">
                        <!-- Event Details Review -->
                        <div class="review-section">
                            <div class="review-section-header" data-toggle="collapse" data-target="#eventDetailsCollapse"
                                aria-expanded="true">
                                <h6> Event Details</h6>
                                <i class="fas fa-chevron-up"></i>
                            </div>
                            <div class="collapse show" id="eventDetailsCollapse">
                                <div class="review-section-body">
                                    <div class="detail-row">
                                        <div class="detail-label" style="color: black; weight:100px">Event Name</div>
                                        <div class="detail-value">{{ $event->name }}</div>
                                    </div>
                                    <div class="detail-row">
                                        <div class="detail-label" style="color: black;">Category / Subcategory</div>
                                        <div class="detail-value">
                                            {{ isset($event->category) ? $event->category->name : '---' }} /
                                            {{ isset($event->subcategory) ? $event->subcategory->name : '---' }} </div>
                                    </div>
                                    <div class="detail-row">
                                        <div class="detail-label" style="color: black;">Start Date & Time</div>
                                        <div class="detail-value">
                                            @if ($event->start_time)
                                                {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y, h:i A') }}
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                    <div class="detail-row">
                                        <div class="detail-label" style="color: black;">End Date & Time</div>
                                        <div class="detail-value">
                                            @if ($event->end_time)
                                                {{ \Carbon\Carbon::parse($event->end_time)->format('d M Y, h:i A') }}
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                    <div class="detail-row">
                                        <div class="detail-label" style="color: black;">Expected Attendees</div>
                                        <div class="detail-value">{{ $event->people }}</div>
                                    </div>
                                    <div class="detail-row">
                                        <div class="detail-label" style="color: black;">Event Description</div>
                                        <div class="detail-value">{{ $event->description }}</div>
                                    </div>

                                    <div class="detail-row">
                                        <div class="detail-label">Status</div>
                                        <div class="detail-value">
                                            <span class="badge-custom mr-2">{{ $event->event_status }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Venue Details Review -->
                        <div class="review-section">
                            <div class="review-section-header collapsed" data-toggle="collapse"
                                data-target="#venueDetailsCollapse" aria-expanded="false">
                                <h6> Venue Details</h6>
                                <i class="fas fa-chevron-up"></i>
                            </div>
                            <div class="collapse" id="venueDetailsCollapse">
                                <div class="review-section-body">
                                    <div class="detail-row">
                                        <div class="detail-label">Venue Name</div>
                                        <div class="detail-value">
                                            {{ $eventVenue->venue ? $eventVenue->venue->name : 'N/A' }}
                                        </div>
                                    </div>
                                    <div class="detail-row">
                                        <div class="detail-label">Address</div>
                                        <div class="detail-value">
                                            {{ $eventVenue->venue ? $eventVenue->venue->location : 'N/A' }}</div>
                                    </div>
                                    <div class="detail-row">
                                        <div class="detail-label">Venue Type</div>
                                        <div class="detail-value">
                                            {{ $eventVenue->venue ? $eventVenue->venue->venue_type : 'N/A' }}</div>
                                    </div>
                                    <div class="detail-row">
                                        <div class="detail-label">Price / Offer Price</div>
                                        <div class="detail-value">
                                            {{ $eventVenue->venue ? $eventVenue->venue->price : 'N/A' }}
                                            / {{ $eventVenue->venue ? $eventVenue->venue->offer_price : 'N/A' }}</div>
                                    </div>

                                    {{-- <div class="detail-row">
                                        <div class="detail-label">Special Requirements</div>
                                        <div class="detail-value">
                                            <span class="badge-custom mr-2">High Ceiling</span>
                                            <span class="badge-custom mr-2">Loading Dock Access</span>
                                            <span class="badge-custom">24/7 Security</span>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <!-- Fabrication Details Review -->
                        <div class="review-section">
                            <div class="review-section-header collapsed" data-toggle="collapse"
                                data-target="#fabricationDetailsCollapse" aria-expanded="false">
                                <h6>Fabrication Details</h6>
                                <i class="fas fa-chevron-up"></i>
                            </div>
                            <div class="collapse" id="fabricationDetailsCollapse">
                                <div class="review-section-body">
                                    @if (!empty($fabricDetails['fabric_type']))
                                        <h6 class="mb-3">Fabric Type</h6>
                                        <div class="detail-row">
                                            <div class="detail-label">Fabric Name</div>
                                            <div class="detail-value">{{ $fabricDetails['fabric_type']['name'] ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Fabric Description</div>
                                            <div class="detail-value">
                                                {{ $fabricDetails['fabric_type']['description'] ?? '-' }}</div>
                                        </div>
                                    @endif

                                    @if (!empty($fabricDetails['tablecloths']))
                                        <h6 class="mb-3 mt-4">Table Cloths</h6>
                                        <div class="detail-row">
                                            <div class="detail-label">Backdrop Dimensions</div>
                                            <div class="detail-value">{{ $fabricDetails['tablecloths']['name'] ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Backdrop Material</div>
                                            <div class="detail-value">
                                                {{ $fabricDetails['tablecloths']['description'] ?? '-' }}</div>
                                        </div>
                                    @endif

                                    @if (!empty($fabricDetails['drapes_style']))
                                        <h6 class="mb-3 mt-4">Drapes</h6>
                                        <div class="detail-row">
                                            <div class="detail-label">Registration Counters</div>
                                            <div class="detail-value">{{ $fabricDetails['drapes_style']['name'] ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Photo Booth</div>
                                            <div class="detail-value">
                                                {{ $fabricDetails['drapes_style']['description'] ?? '-' }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Accessories Details Review -->
                        <div class="review-section">
                            <div class="review-section-header collapsed" data-toggle="collapse"
                                data-target="#accessoriesDetailsCollapse" aria-expanded="false">
                                <h6>Accessories Details</h6>
                                <i class="fas fa-chevron-up"></i>
                            </div>
                            <div class="collapse" id="accessoriesDetailsCollapse">
                                <div class="review-section-body">

                                    @if (!empty($equipmentDetails['camera_accessories']))
                                        <h6 class="mb-3">Camera Accessories</h6>
                                        <div class="detail-row">
                                            <div class="detail-label">Accessory Name</div>
                                            <div class="detail-value">
                                                {{ $equipmentDetails['camera_accessories']['name'] ?? '-' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Price</div>
                                            <div class="detail-value">
                                                {{ $equipmentDetails['camera_accessories']['price'] ?? '-' }}</div>
                                        </div>
                                    @endif

                                    @if (!empty($equipmentDetails['lighting']))
                                        <h6 class="mb-3 mt-4">Lighting</h6>
                                        <div class="detail-row">
                                            <div class="detail-label">Lighting Equipment</div>
                                            <div class="detail-value">{{ $equipmentDetails['lighting']['name'] ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Price</div>
                                            <div class="detail-value">{{ $equipmentDetails['lighting']['price'] ?? '-' }}
                                            </div>
                                        </div>
                                    @endif

                                    @if (!empty($equipmentDetails['soundSystem']))
                                        <h6 class="mb-3 mt-4">Sound System</h6>
                                        <div class="detail-row">
                                            <div class="detail-label">Sound System</div>
                                            <div class="detail-value">
                                                {{ $equipmentDetails['soundSystem']['name'] ?? '-' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Price</div>
                                            <div class="detail-value">
                                                {{ $equipmentDetails['soundSystem']['price'] ?? '-' }}</div>
                                        </div>
                                    @endif

                                    @if (!empty($equipmentDetails['av_equipment']))
                                        <h6 class="mb-3 mt-4">Audio-Visual Equipment</h6>
                                        <div class="detail-row">
                                            <div class="detail-label">AV Equipment</div>
                                            <div class="detail-value">
                                                {{ $equipmentDetails['av_equipment']['name'] ?? '-' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Price</div>
                                            <div class="detail-value">
                                                {{ $equipmentDetails['av_equipment']['price'] ?? '-' }}</div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>


                        <!-- Final Confirmation Card -->
                        <div class="card final-submission-card">
                            <div class="card-body">
                                <h4 class="text-primary mb-4">Ready to Submit</h4>
                                <p class="text-muted">Please review all details carefully before final submission. </p>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="finalSubmissionForm" action="{{ route('events.finalsubmit', $event->id) }}" method="POST">
                    @csrf

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="confirmDetails"
                            onchange="this.form.querySelector('#finalSubmitBtn').disabled = !this.checked;">
                        <label class="form-check-label" for="confirmDetails">
                            I confirm that all event details are correct.
                        </label>
                    </div>

                    <div class="button-group">
                        <button type="button" class="review-btn btn btn-primary mr-2"
                            onclick="window.location.href='{{ url()->previous() }}'">
                            <i class="fas fa-arrow-left mr-2"></i> {{ __('Back to Edit') }}
                        </button>

                        <button type="submit" class="submit-btn btn btn-success text-white" id="finalSubmitBtn"
                            disabled>
                            <i class="fas fa-paper-plane mr-2"></i> Submit Event
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </section>
@endsection
