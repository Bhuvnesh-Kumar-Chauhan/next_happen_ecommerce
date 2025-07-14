@extends('master')

@section('content')

    <style>
        .custom-file,
        .custom-file-label,
        .custom-select,
        .custom-file-label:after,
        .form-control[type="color"],
        select.form-control:not([size]):not([multiple]) {
            height: calc(2.25rem + 6px);
            width: 100%;
        }
    </style>
    <style>
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
    </style>


    <section class="section">
        {{-- @include('admin.layout.breadcrumbs', [
            'title' => __('Add Event (Step 1)'),
            'headerData' => __('Event'),
            'url' => 'events',
        ]) --}}

        <div class="section-body">
            <div class="card row">
                <div class="alert alert-success step-completion-message" style="display: none;">
                    <i class="fas fa-check-circle mr-2"></i> Step completed successfully! You can now proceed to the next
                    step.
                </div>
                <div class="col-lg-8 mt-3">
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
                            <div class="step-progress-title">Final Submission</div>
                        </div>
                    </div>
                </div>
            </div>

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
            <div class="row">

                <div class="col-12">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card">
                        <h5 class="ml-5 mt-3">Events Details </h5>
                        <hr>
                        <div class="card-body">
                            <form method="post" class="event-form"
                                action="<?php if(!empty($data)) { echo route('events.update', is_array($data) ? $data['id'] : $data->id); } else { echo route('events.store'); } ?>"
                                enctype="multipart/form-data">
                                @csrf

                                @if (!empty($data))
                                    @method('PUT')
                                @endif
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group text-left">
                                            <label
                                                class="font-weight-bold mb-2 text-primary">{{ __('Upload Images or Videos') }}</label>

                                            <div id="media-preview"
                                                class="media-preview-container border-dashed rounded-lg p-3 text-center">
                                                <input type="file" name="image[]" id="media-upload" multiple
                                                    accept="image/*,video/*" style="display: none;" />

                                                <button type="button" id="upload-button"
                                                    class="btn btn-outline-primary btn-lg">
                                                    <i class="fas fa-cloud-upload-alt mr-2"></i> Browse Files
                                                </button>
                                                <p class="text-muted mt-2 mb-0">Accepted formats: JPG, PNG, MP4, etc.</p>
                                                <div id="preview-thumbnails"
                                                    class="d-flex flex-wrap justify-content-left mt-3">
                                                    @php
                                                        $existingMedia = [];
                                                        if (!empty($data) && !empty($data->image)) {
                                                            $existingMedia = json_decode($data->image, true);
                                                        }
                                                    @endphp

                                                    @if (!empty($existingMedia))
                                                        @foreach ($existingMedia as $key => $media)
                                                            @php
                                                                $mediaPath = asset($media);
                                                                $extension = pathinfo($mediaPath, PATHINFO_EXTENSION);
                                                            @endphp
                                                            <div class="media-preview-item position-relative m-2">
                                                                @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                                    <img src="{{ $mediaPath }}" alt="Uploaded Image"
                                                                        width="120" height="80">
                                                                @elseif (in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                                                                    <video src="{{ $mediaPath }}" width="120"
                                                                        height="80" controls></video>
                                                                @endif

                                                                <button type="button"
                                                                    class="remove-media btn btn-sm btn-danger position-absolute"
                                                                    style="top: -10px; right: -10px;"
                                                                    onclick="removeExistingMedia(this, '{{ $media }}')">&times;</button>

                                                                <input type="hidden" name="existing_media[]"
                                                                    value="{{ $media }}">
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Name') }}</label>
                                            <input type="text" name="name"
                                                value="{{ !empty($data) ? $data->name : old('name') }}"
                                                placeholder="{{ __('Name') }}"
                                                class="form-control @error('name')? is-invalid @enderror">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="category_id">{{ __('Category') }}</label>
                                            <select id="category_id" name="category_id" class="form-control">
                                                <option value="">Select Category</option>
                                                @foreach ($category as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        {{ (!empty($data) && $data->category_id == $cat->id) || old('category_id') == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="subcategory_id">{{ __('Subcategory') }}</label>
                                            <select id="subcategory_id" name="subcategory_id" class="form-control"
                                                {{ empty($data) ? 'disabled' : '' }}>
                                                <option value="">{{ __('Select Subcategory') }}</option>
                                                @if (!empty($data) && $data->category)
                                                    @foreach ($data->category->subcategories as $subcategory)
                                                        <option value="{{ $subcategory->id }}"
                                                            {{ $data->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                                                            {{ $subcategory->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('subcategory_id')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Start Time') }}</label>
                                            <input type="text" name="start_time" id="start_time"
                                                value="{{ !empty($data) ? $data->start_time : old('start_time') }}"
                                                placeholder="{{ __('Choose Start time') }}"
                                                class="form-control date @error('start_time')? is-invalid @enderror">
                                            @error('start_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('End Time') }}</label>
                                            <input type="text" name="end_time" id="end_time"
                                                value="{{ !empty($data) ? $data->end_time : old('end_time') }}"
                                                placeholder="{{ __('Choose End time') }}"
                                                class="form-control date @error('end_time')? is-invalid @enderror">
                                            @error('end_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-6">
                                        @if (Auth::user()->hasRole('admin'))
                                            <div class="form-group">
                                                <label>{{ __('Organizer') }}</label>
                                                <select name="user_id" required class="form-control select2"
                                                    id="org-for-event">
                                                    <option value="">{{ __('Choose Organizer') }}</option>
                                                    @foreach ($users as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ (!empty($data) && $data->user_id == $item->id) || $item->id == old('user_id') ? 'Selected' : '' }}>
                                                            {{ $item->first_name . ' ' . $item->last_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('user_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Label') }}</label>
                                            <select name="label_id" required class="form-control select2"
                                                id="label-for-event">
                                                <option value="">{{ __('Choose Label') }}</option>
                                                @foreach ($labels as $label)
                                                    <option value="{{ $label->id }}"
                                                        {{ (!empty($data) && $data->label_id == $label->id) || old('label_id') == $label->id ? 'selected' : '' }}>
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

                                <div class="scanner">
                                    <div class="form-group">
                                        <label>{{ __('Scanner') }} {{ __('(Required)') }}
                                            {{ __('(Choose Multiple if required.)') }}</label>
                                        <select name="scanner_id[]" class="form-control scanner_id select2 selectpicker"
                                            multiple data-live-search="true">
                                            <option value="" disabled>{{ __('Choose Scanner') }}</option>
                                            @foreach ($scanner as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ !empty($data) || in_array($item->id, old('scanner_id', [])) ? 'selected' : '' }}>
                                                    {{ $item->first_name . ' ' . $item->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('scanner_id')
                                            <div class="invalid-feedback block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Maximum people will join in this event') }}</label>
                                            <input type="number" min='1' name="people" id="people"
                                                value="{{ !empty($data) ? $data->people : old('people') }}"
                                                placeholder="{{ __('Maximum people will join in this event') }}"
                                                class="form-control @error('people')? is-invalid @enderror">
                                            @error('people')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('status') }}</label>
                                            <select name="status" class="form-control select2">
                                                <option value="1"
                                                    {{ (!empty($data) && $data->status == 1) || old('status') == 1 ? 'selected' : '' }}>
                                                    {{ __('Active') }}</option>
                                                <option value="0"
                                                    {{ (!empty($data) && $data->status == 0) || old('status') == 0 ? 'selected' : '' }}>
                                                    {{ __('Inactive') }}</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Tags') }}</label>
                                            <input type="text" name="tags"
                                                value="{{ !empty($data) ? $data->tags : old('tags') }}"
                                                class="form-control inputtags @error('tags')? is-invalid @enderror">
                                            @error('tags')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('URL') }}</label>
                                            <input type="text" name="urls"
                                                value="{{ !empty($data) ? $data->urls : old('urls') }}"
                                                placeholder="{{ __('URL') }}"
                                                class="form-control @error('urls')? is-invalid @enderror">
                                            @error('urls')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Description') }}</label>
                                    <textarea name="description" Placeholder="Description"
                                        class="textarea_editor @error('description')? is-invalid @enderror">
            {{ !empty($data) ? $data->description : old('description') }}
        </textarea>
                                    @error('description')
                                        <div class="invalid-feedback block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="form-group">
                                    <button type="submit"
                                        class="btn btn-primary demo-button">{{ __('Submit') }}</button>
                                </div> --}}
                                <div class="form-group text-right">
                                    <button type="submit"
                                        class="btn btn-primary demo-button">{{ __('Next & Continue') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .modal-backdrop {
                display: none;
            }
        </style>
    </section>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryElement = document.getElementById('category_id');
            const subcategoryElement = document.getElementById('subcategory_id');

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
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('media-upload');
            const uploadButton = document.getElementById('upload-button');
            const previewContainer = document.getElementById('preview-thumbnails');

            let allFiles = [];

            uploadButton.addEventListener('click', function() {
                fileInput.click();
            });

            fileInput.addEventListener('change', function(event) {
                const newFiles = Array.from(event.target.files);

                const existingMediaCount = document.querySelectorAll('input[name="existing_media[]"]')
                    .length;
                const totalCount = existingMediaCount + allFiles.length + newFiles.length;

                if (totalCount > 5) {
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
                document.querySelectorAll('.media-preview-item.new').forEach(el => el.remove());

                allFiles.forEach((file, index) => {
                    const previewElement = document.createElement('div');
                    previewElement.className = 'media-preview-item new position-relative m-2';

                    if (file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = URL.createObjectURL(file);
                        img.width = 120;
                        img.height = 80;
                        previewElement.appendChild(img);
                    } else if (file.type.startsWith('video/')) {
                        const video = document.createElement('video');
                        video.src = URL.createObjectURL(file);
                        video.controls = true;
                        video.width = 120;
                        video.height = 80;
                        previewElement.appendChild(video);
                    }

                    const removeBtn = document.createElement('button');
                    removeBtn.className = 'remove-media btn btn-sm btn-danger position-absolute';
                    removeBtn.innerHTML = '&times;';
                    removeBtn.style.top = '-10px';
                    removeBtn.style.right = '-10px';
                    removeBtn.onclick = (e) => {
                        e.preventDefault();
                        removeFile(index);
                    };

                    previewElement.appendChild(removeBtn);
                    previewContainer.appendChild(previewElement);
                });
            }

            function removeFile(index) {
                allFiles.splice(index, 1);
                updateInputFiles();
                updatePreviews();
            }

            // Remove existing media
            window.removeExistingMedia = function(btn, mediaPath) {
                const wrapper = btn.closest('.media-preview-item');
                wrapper.remove();

                // Optionally append a hidden input to mark deletion
                const deletedInput = document.createElement('input');
                deletedInput.type = 'hidden';
                deletedInput.name = 'deleted_media[]';
                deletedInput.value = mediaPath;
                document.querySelector('form').appendChild(deletedInput);
            };
        });
    </script>

    <style>
        .media-preview-item img,
        .media-preview-item video {
            border-radius: 4px;
            object-fit: cover;
        }

        .remove-media {
            border: none;
            font-size: 16px;
            line-height: 1;
            cursor: pointer;
        }
    </style>

@endsection
