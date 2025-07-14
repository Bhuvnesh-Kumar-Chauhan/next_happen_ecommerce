@extends('master')

@section('content')
    <section class="section">
        {{-- @include('admin.layout.breadcrumbs', [
            'title' => __('Event Fabrication (Step 3) '),
        ]) --}}
        <style>
            .fabric-option {
                border: 2px solid #e0e0e0;
                border-radius: 8px;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .fabric-option:hover {
                border-color: #0d6efd;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            input[type="radio"]:checked+.fabric-option {
                border-color: #0d6efd;
                background-color: #f8f9fa;
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
                        <div class="step-progress-item completed">
                            <div class="step-progress-number">2</div>
                            <div class="step-progress-title">Venue</div>
                        </div>
                        <div class="step-progress-item active">
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
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card">
                        <h5 class="ml-5 mt-3">Fabrication Details </h5>
                        <hr>
                        <div class="card-body">
                            <div class="form-step" id="step-3">
                                <form
                                    action="<?php if(!empty($data)) { echo route('event-fabrication.update', is_array($data) ? $data['id'] : $data->id); } else { echo route('event-fabrication.create'); } ?>"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @if (!empty($data))
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                    @endif

                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <div class="row">
                                        <!-- Fabric Type Selection with Images -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="d-block mb-3">{{ __('Select Fabric Type') }}</label>
                                                <div class="row">

                                                    @foreach ($fabric_type as $type)
                                                        <div class="col-md-3 col-6 mb-4">
                                                            <input type="radio" name="fabric_type"
                                                                id="fabric-{{ $type->id }}" value="{{ $type->id }}"
                                                                class="d-none"
                                                                {{ !empty($data) && $data->fabric_type == $type->id ? 'checked' : (old('fabric_type', session('fabric_type') ?? '') == $type->id ? 'checked' : ($loop->first ? 'checked' : '')) }}>
                                                            <label for="fabric-{{ $type->id }}"
                                                                class="card card-body p-2 text-center fabric-option h-100">
                                                                <div class="image-container mb-2"
                                                                    style="height: 120px; overflow: hidden;">
                                                                    <img src="{{ asset('storage/' . $type->images) }}"
                                                                        alt="{{ $type->name }}" class="img-fluid rounded"
                                                                        style="object-fit: cover; width: 100%; height: 100%;">
                                                                </div>
                                                                <h6 class="mb-1 fw-bold text-primary"
                                                                    style="font-size: 1rem;">{{ $type->name }}</h6>
                                                                <p class="mb-0 text-muted small"
                                                                    style="font-size: 0.8rem; line-height: 1.3;">
                                                                    {{ \Illuminate\Support\Str::limit($type->description, 60) }}
                                                                </p>
                                                            </label>
                                                        </div>
                                                    @endforeach

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
                                                    @foreach ($fabric_table_cloths as $table)
                                                        @php
                                                            $isChecked = (!empty($data) && $data->tablecloths == $table->id) || 
                                                                        (old('tablecloths', session('tablecloths') ?? '') == $table->id);
                                                        @endphp
                                                        <div class="col-md-2 col-4 mb-3">
                                                            <input type="radio" 
                                                                name="tablecloths"
                                                                id="tablecloth-{{ $table->id }}"
                                                                value="{{ $table->id }}" 
                                                                class="d-none"
                                                                @if($isChecked) checked @endif>
                                                            <label for="tablecloth-{{ $table->id }}"
                                                                class="card card-body p-1 text-center tablecloth-option 
                                                                @if($isChecked) selected @endif">
                                                                <img src="{{ asset('storage/' . $table->images) }}"
                                                                    alt="{{ $table->name }}"
                                                                    class="img-fluid rounded mb-1">
                                                                <small style="color: black">{{ $table->name }}</small>
                                                                <p class="mb-0 text-muted small"
                                                                style="font-size: 0.8rem; line-height: 1.3;">
                                                                    {{ \Illuminate\Support\Str::limit($table->description, 60) }}
                                                                </p>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @error('tablecloths')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <style>
                                            /* Tablecloth selection styling */
                                            .tablecloth-option {
                                                cursor: pointer;
                                                border: 2px solid transparent;
                                                transition: all 0.3s ease;
                                            }
                                            .tablecloth-option.selected,
                                            .tablecloth-option:hover {
                                                border-color: #007bff;
                                            }
                                            input[type="radio"]:checked + .tablecloth-option {
                                                border-color: #007bff;
                                                background-color: #f8f9fa;
                                            }
                                        </style>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const tableclothOptions = document.querySelectorAll('.tablecloth-option');
                                                
                                                // Initialize selected state
                                                document.querySelectorAll('input[name="tablecloths"]').forEach(radio => {
                                                    if (radio.checked) {
                                                        document.querySelector(`label[for="${radio.id}"]`).classList.add('selected');
                                                    }
                                                });
                                                
                                                // Handle click events
                                                tableclothOptions.forEach(option => {
                                                    option.addEventListener('click', function() {
                                                        // Remove selected class from all options
                                                        tableclothOptions.forEach(opt => {
                                                            opt.classList.remove('selected');
                                                        });
                                                        
                                                        // Add selected class to clicked option
                                                        this.classList.add('selected');
                                                        
                                                        // Update the corresponding radio button
                                                        const radioId = this.getAttribute('for');
                                                        document.getElementById(radioId).checked = true;
                                                    });
                                                });
                                            });
                                        </script>

                                        <!-- Drapes Selection -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="d-block mb-3">{{ __('Choose Drapes Style') }}</label>
                                                <div class="row">
                                                    @foreach ($fabric_drapes as $drapes)
                                                        <div class="col-md-3 col-6 mb-4">
                                                            <input type="radio" name="drapes_style"
                                                                id="drapes-{{ $drapes->id }}"
                                                                value="{{ $drapes->id }}" class="d-none"
                                                                {{ !empty($data) && $data->drapes_style == $drapes->id
                                                                    ? 'checked'
                                                                    : (old('drapes_style', session('drapes_style') ?? '') == $drapes->id
                                                                        ? 'checked'
                                                                        : ($loop->first
                                                                            ? 'checked'
                                                                            : '')) }}>
                                                            <label for="drapes-{{ $drapes->id }}"
                                                                class="card card-body p-2 text-center drapes-option
                                                                {{ !empty($data) && $data->drapes_style == $drapes->id
                                                                    ? 'selected'
                                                                    : (old('drapes_style', session('drapes_style') ?? '') == $drapes->id
                                                                        ? 'selected'
                                                                        : ($loop->first
                                                                            ? 'selected'
                                                                            : '')) }}">
                                                                <img src="{{ asset('storage/' . $drapes->images) }}"
                                                                    alt="{{ $drapes->name }}"
                                                                    class="img-fluid rounded mb-2">
                                                                <h6 class="mb-0">{{ $drapes->name }}</h6>
                                                                <p class="mb-0 text-muted small"
                                                                    style="font-size: 0.8rem; line-height: 1.3;">
                                                                    {{ \Illuminate\Support\Str::limit($drapes->description, 60) }}
                                                                </p>
                                                            </label>
                                                        </div>
                                                    @endforeach
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
                                                    <input type="color" name="fabric_color"
                                                        value="{{ !empty($data) ? $data->fabric_color : old('fabric_color', session('fabric_color') ?? '#3490dc') }}"
                                                        class="form-control @error('fabric_color') is-invalid @enderror"
                                                        style="height: 38px; padding: 3px;">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                style="color: {{ !empty($data) ? $data->fabric_color : old('fabric_color', session('fabric_color') ?? '#3490dc') }};"></i></span>
                                                    </div>
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
                                                <input type="number" name="fabric_quantity"
                                                    value="{{ !empty($data) ? $data->fabric_quantity : old('fabric_quantity', session('fabric_quantity') ?? '') }}"
                                                    class="form-control @error('fabric_quantity') is-invalid @enderror"
                                                    placeholder="Enter fabric quantity in yards" min="0"
                                                    step="0.01">
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
                                                    <input type="file" name="custom_fabric_image[]" id="custom-fabric"
                                                        class="custom-file-input @error('custom_fabric_image.*') is-invalid @enderror"
                                                        multiple>
                                                    <label class="custom-file-label" for="custom-fabric">Choose
                                                        files</label>
                                                </div>

                                                @if (!empty($data) && $data->custom_fabric_image)
                                                    <div class="mt-2">
                                                        <p>Previously uploaded images:</p>
                                                        @foreach (json_decode($data->custom_fabric_image) as $image)
                                                            <img src="{{ asset('storage/' . $image) }}"
                                                                alt="Custom Fabric" class="img-thumbnail mr-2"
                                                                style="max-height: 100px;">
                                                        @endforeach
                                                    </div>
                                                @elseif(session('custom_fabric_image'))
                                                    <div class="mt-2">
                                                        <p>Previously uploaded images:</p>
                                                        @foreach (json_decode(session('custom_fabric_image')) as $image)
                                                            <img src="{{ asset('storage/' . $image) }}"
                                                                alt="Custom Fabric" class="img-thumbnail mr-2"
                                                                style="max-height: 100px;">
                                                        @endforeach
                                                    </div>
                                                @endif

                                                <small class="form-text text-muted">Upload your own fabric designs (JPG,
                                                    PNG, max 5MB each)</small>
                                                @error('custom_fabric_image.*')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
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
                                        </div>
                                </form>
                            </div>

                            <style>
                                /* Custom styling for the image selection options */
                                .fabric-option,
                                .tablecloth-option,
                                .drapes-option {
                                    cursor: pointer;
                                    transition: all 0.3s;
                                    border: 2px solid transparent;
                                }

                                .fabric-option:hover,
                                .tablecloth-option:hover,
                                .drapes-option:hover {
                                    transform: translateY(-5px);
                                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                                }

                                input[type="radio"]:checked+.fabric-option,
                                input[type="radio"]:checked+.drapes-option {
                                    border-color: #4361ee;
                                    background-color: #f0f7ff;
                                }

                                input[type="checkbox"]:checked+.tablecloth-option {
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
                                    // Initialize with existing values if available
                                    const initialFabricType = document.querySelector('input[name="fabric_type"]:checked');
                                    const initialColor = document.querySelector('input[name="fabric_color"]').value;

                                    // Update preview on page load if values exist
                                    if (initialFabricType) {
                                        document.getElementById('preview-fabric-type').textContent =
                                            document.querySelector('label[for="' + initialFabricType.id + '"] h6').textContent;
                                    }

                                    if (initialColor) {
                                        document.getElementById('preview-fabric-color').textContent = initialColor;
                                        document.querySelector('.colorpicker .input-group-text i').style.color = initialColor;
                                    }

                                    // Update fabric preview when selections change
                                    document.querySelectorAll('input[name="fabric_type"]').forEach(radio => {
                                        radio.addEventListener('change', function() {
                                            document.getElementById('preview-fabric-type').textContent =
                                                document.querySelector('label[for="' + this.id + '"] h6').textContent;
                                            updateFabricPreviewImage();
                                        });
                                    });

                                    // Update color preview
                                    const colorInput = document.querySelector('input[name="fabric_color"]');
                                    colorInput.addEventListener('change', function() {
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

                                        // Show preview of existing images if available
                                        const existingImages = @json(!empty($data) && $data->custom_fabric_image
                                                ? json_decode($data->custom_fabric_image)
                                                : (session('custom_fabric_image')
                                                    ? json_decode(session('custom_fabric_image'))
                                                    : []));

                                        if (existingImages.length > 0) {
                                            const previewContainer = document.createElement('div');
                                            previewContainer.className = 'mt-2';
                                            previewContainer.innerHTML = '<p>Previously uploaded images:</p>';

                                            existingImages.forEach(image => {
                                                const img = document.createElement('img');
                                                img.src = '{{ asset('storage') }}/' + image;
                                                img.alt = 'Custom Fabric';
                                                img.className = 'img-thumbnail mr-2';
                                                img.style.maxHeight = '100px';
                                                previewContainer.appendChild(img);
                                            });

                                            const existingPreview = document.querySelector('.existing-images-preview');
                                            if (existingPreview) {
                                                existingPreview.replaceWith(previewContainer);
                                            } else {
                                                this.parentNode.insertBefore(previewContainer, this.nextSibling);
                                            }
                                            previewContainer.classList.add('existing-images-preview');
                                        }
                                    });

                                    function updateFabricPreviewImage() {
                                        const fabricType = document.querySelector('input[name="fabric_type"]:checked').value;
                                        const color = document.querySelector('input[name="fabric_color"]').value;

                                        // This is just a placeholder - you would generate or load appropriate images
                                        document.getElementById('fabric-preview-image').src =
                                            `https://via.placeholder.com/300x200/${color.substring(1)}/ffffff?text=${fabricType}`;
                                    }

                                    // Initialize color picker (if using jQuery colorpicker)
                                    if (typeof $ !== 'undefined') {
                                        $('[name="fabric_color"]').colorpicker({
                                            format: 'hex',
                                            component: '.input-group-append i',
                                        });
                                    }

                                    // Initialize preview on page load
                                    updateFabricPreviewImage();

                                    // Show existing images on page load if available
                                    const existingImages = @json(!empty($data) && $data->custom_fabric_image
                                            ? json_decode($data->custom_fabric_image)
                                            : (session('custom_fabric_image')
                                                ? json_decode(session('custom_fabric_image'))
                                                : []));

                                    if (existingImages.length > 0) {
                                        const previewContainer = document.createElement('div');
                                        previewContainer.className = 'mt-2 existing-images-preview';
                                        previewContainer.innerHTML = '<p>Previously uploaded images:</p>';

                                        existingImages.forEach(image => {
                                            const img = document.createElement('img');
                                            img.src = '{{ asset('storage') }}/' + image;
                                            img.alt = 'Custom Fabric';
                                            img.className = 'img-thumbnail mr-2';
                                            img.style.maxHeight = '100px';
                                            previewContainer.appendChild(img);
                                        });

                                        const customFile = document.querySelector('.custom-file');
                                        if (customFile) {
                                            customFile.parentNode.insertBefore(previewContainer, customFile.nextSibling);
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
