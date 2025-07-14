@extends('master')

@section('content')
    <section class="section">
        {{-- @include('admin.layout.breadcrumbs', [
            'title' => __('Event Accessories (Step 4)'),
        ]) --}}

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
    .step-progress-item.active .step-progress-title{
        color: #4361ee;
        font-weight: bold; 
    }

    .step-progress-item.completed .step-progress-title {
         color: #4cc550;
        font-weight: bold;
    }
            </style>
        <div class="section-body">
            <div class="card row">
                <div class="alert alert-success step-completion-message" style="display: none;">
                    <i class="fas fa-check-circle mr-2"></i> Step completed successfully! You can now proceed to the next step.
                </div>
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
                        <div class="step-progress-item active">
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
                    <div class="card">
                         <h5 class="ml-5 mt-3">Accessories Details </h5>
                        <hr>
                        <div class="card-body">
                            <div class="form-step" id="step-4">
                                <form action="<?php if(!empty($data)) { echo route('event-accessorie.update', is_array($data) ? $data['id'] : $data->id); } else { echo route('event-accessorie.create'); } ?>" method="POST">
                                    @csrf
                                    @if(!empty($data))
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                    @endif

                                    <input type="hidden" name="event_id" value="{{ $event->id }}" required>

                                    <div class="row">
                                        <!-- Camera Equipment -->
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label>Camera </label>
                                                <select class="form-control" name="camera_accessories">
                                                    <option value="">Select Camera </option>
                                                    @foreach ($cameras as $camera)
                                                        <option value="{{ $camera->id }}" {{ old('camera_accessories', $data->camera_accessories ?? '') == $camera->id ? 'selected' : '' }}>
                                                            {{ $camera->name }} - ₹{{ $camera->price }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Sound Systems -->
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label>Sound Systems</label>
                                                <select class="form-control" name="sound_system">
                                                    <option value="">Select Sound System</option>
                                                    @foreach ($soundSystems as $sound)
                                                        <option value="{{ $sound->id }}" {{ old('sound_system', $data->sound_system ?? '') == $sound->id ? 'selected' : '' }}>
                                                            {{ $sound->name }} - ₹{{ $sound->price }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Lighting Equipment -->
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label>Lighting </label>
                                                <select class="form-control" name="lighting">
                                                    <option value="">Select Lighting</option>
                                                    @foreach ($lighting as $light)
                                                        <option value="{{ $light->id }}" {{ old('lighting', $data->lighting ?? '') == $light->id ? 'selected' : '' }}>
                                                            {{ $light->name }} - ₹{{ $light->price }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- AV Equipment -->
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label>AV </label>
                                                <select class="form-control" name="av_equipment">
                                                    <option value="">Select AV</option>
                                                    @foreach ($audioVisual as $av)
                                                        <option value="{{ $av->id }}" {{ old('av_equipment', $data->av_equipment ?? '') == $av->id ? 'selected' : '' }}>
                                                            {{ $av->name }} - ₹{{ $av->price }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Additional Requirements -->
                                        <div class="col-12 mb-4">
                                            <div class="form-group">
                                                <label>Additional Requirements</label>
                                                <textarea class="form-control" name="additional_requirements" rows="3" placeholder="Any special requirements for your equipment?">{{ old('additional_requirements', $data->additional_requirements ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
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
        </div>
    </section>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: calc(2.25rem + 2px);
        padding: 0.375rem 0.75rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: calc(2.25rem + 2px);
    }
    .form-group label {
        font-weight: 600;
        color: #34395e;
    }
    .form-control {
        border-radius: 0.25rem;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        width: '100%',
        placeholder: $(this).data('placeholder')
    });
});
</script>
@endsection