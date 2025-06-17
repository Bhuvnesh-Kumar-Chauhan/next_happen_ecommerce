@extends('master')

@section('content')

<style>
.custom-file, .custom-file-label, .custom-select, .custom-file-label:after, .form-control[type="color"], select.form-control:not([size]):not([multiple]) {
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
            min-height: 120px;
            padding: 10px;
            border: 1px dashed #ccc;
            border-radius: 4px;
        }

        .media-preview-item {
            position: relative;
            width: 120px;
            height: 120px;
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
            width: 24px;
            height: 24px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 0;
            font-size: 14px;
            line-height: 1;
            z-index: 10;
        }

        #upload-button {
            margin: 0;
            padding: 8px 15px;
            order: 999; /* Always keep at the end */
        }
    </style>
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Edit Event'),
            'headerData' => __('Event'),
            'url' => 'events',
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title"> {{ __('Edit Event') }}</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" class="event-form" action="{{ route('events.update', [$event->id]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <!--<div class="col-lg-6">-->
                                    <!--    <div class="form-group center">-->
                                    <!--        <label>{{ __('Image') }}</label>-->
                                    <!--        <div id="image-preview" class="image-preview"-->
                                    <!--            style="background-image: url({{ url('images/upload/' . $event->image) }})">-->
                                    <!--            <label for="image-upload" id="image-label"> <i-->
                                    <!--                    class="fas fa-plus"></i></label>-->
                                    <!--            <input type="file" name="image" id="image-upload" />-->
                                    <!--        </div>-->
                                    <!--        @error('image')-->
                                    <!--            <div class="invalid-feedback block">{{ $message }}</div>-->
                                    <!--        @enderror-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group center">
                                            <label>{{ __('Images/Videos') }}</label>
                                            <div id="media-preview" class="media-preview-container">
                                                @php
                                                    $existingMedia = [];
                                    
                                                    if (is_array($event->image)) {
                                                        $existingMedia = $event->image;
                                                    } elseif (is_string($event->image)) {
                                                        $decoded = json_decode($event->image, true);
                                                        if (json_last_error() === JSON_ERROR_NONE) {
                                                            $existingMedia = $decoded;
                                                        } else {
                                                            $existingMedia = [$event->image];
                                                        }
                                                    }
                                                @endphp
                                    
                                                @foreach($existingMedia as $index => $filePath)
                                                    <div class="media-preview-item" data-index="{{ $index }}" data-type="existing">
                                                        @if(Str::endsWith($filePath, ['.jpg', '.jpeg', '.png', '.gif', '.webp', '.JPG', '.JPEG', '.PNG', '.GIF', '.WEBP']))
                                                            <img src="{{ asset($filePath) }}" alt="Image">
                                                        @else
                                                            <video controls>
                                                                <source src="{{ asset($filePath) }}" type="video/mp4">
                                                            </video>
                                                        @endif
                                                        <button type="button" class="remove-media" data-path="{{ $filePath }}">&times;</button>
                                                        <input type="hidden" name="image[]" value="{{ $filePath }}">
                                                    </div>
                                                @endforeach
                                    
                                                <!-- File input -->
                                                <input type="file" name="image[]" id="media-upload" multiple accept="image/*,video/*" style="display: none;" />
                                                <button type="button" id="upload-button" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Add Files
                                                </button>
                                            </div>
                                    
                                            <!-- Hidden container for removed files -->
                                            <div id="removed-fields-container"></div>
                                    
                                            @error('image')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Name') }}</label>
                                            <input type="text" name="name" value="{{ $event->name }}"
                                                placeholder="{{ __('Name') }}"
                                                class="form-control @error('name')? is-invalid @enderror">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Category') }}</label>
                                            <select name="category_id" id="category_id" class="form-control ">
                                                <option value="">{{ __('Select Category') }}</option>
                                                @foreach ($category as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == $event->category_id ? 'Selected' : '' }}>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="subcategory_id">{{ __('Subcategory') }}</label>
                                            <select id="subcategory_id" name="subcategory_id" class="form-control" 
                                                {{ $event->category_id ? '' : 'disabled' }}>
                                                <option value="">{{ __('Select Subcategory') }}</option>
                                                @foreach($subcategory as $sub)
                                                    <option value="{{ $sub->id }}" 
                                                        {{ $sub->id == old('subcategory_id', $event->subcategory_id) ? 'selected' : '' }}>
                                                        {{ $sub->name }}</option>
                                                @endforeach
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
                                                value="{{ $event->start_time }}"
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
                                                value="{{ $event->end_time }}" placeholder="{{ __('Choose End time') }}"
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
                                                <select name="user_id" class="form-control select2" id="org-for-event">
                                                    <option value="">{{ __('Choose Organizer') }}</option>
                                                    @foreach ($users as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $item->id == $event->user_id ? 'Selected' : '' }}>
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
                                            <select name="label_id" required class="form-control select2" id="label-for-event">
                                                <option value="">{{ __('Choose Label') }}</option>
                                                @foreach ($labels as $label)
                                                    <option value="{{ $label->id }}" 
                                                        {{ (old('label_id', $event->label_id ?? '') == $label->id) ? 'selected' : '' }}>
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
                                <div class="scanner {{ $event->type == 'online' ? 'hide' : 'demo' }}">
                                    <div class="form-group">
                                        <label>{{ __('Scanner') }} {{ __('(Requierd)') }}</label>
                                        <select name="scanner_id[]" class="form-control scanner_id select2 selectpicker"
                                            multiple data-live-search="true">
                                            <option value="" disabled>{{ __('Choose Scanner') }}</option>
                                            @foreach ($scanner as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (str_contains($event->scanner_id, $item->id)) @if (preg_match("/\b$item->id\b/", $event->scanner_id))
                                                            selected @endif
                                                    @endif
                                                    >
                                                    {{ $item->first_name . ' ' . $item->last_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('scanner_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Maximum people will join in this event') }}</label>
                                            <input type="number" name="people" id="people"
                                                value="{{ $event->people }}"
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
                                                <option value="1" {{ $event->status == '1' ? 'selected' : '' }}>
                                                    {{ __('Active') }}</option>
                                                <option value="0" {{ $event->status == '0' ? 'Selected' : '' }}>
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
                                            <input type="text" name="tags" value="{{ $event->tags }}"
                                                class="form-control inputtags @error('tags')? is-invalid @enderror">
                                            @error('tags')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('URL') }}</label>
                                            <input type="text" name="urls" value="{{ $event->urls }}"
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
                                    <textarea name="description" Placeholder="{{ __('Description') }}"
                                        class="textarea_editor @error('description')? is-invalid @enderror">
                                {{ $event->description }}
                            </textarea>
                                    @error('description')
                                        <div class="invalid-feedback block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <h6 class="text-muted mt-4 mb-4">{{ __('Location Detail') }}</h6>
                                <div class="form-group">
                                    <div class="selectgroup">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="type"
                                                {{ $event->type == 'offline' ? 'checked' : '' }} checked value="offline"
                                                class="selectgroup-input" checked="">
                                            <span class="selectgroup-button">{{ __('Venue') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" {{ $event->type == 'online' ? 'checked' : '' }}
                                                name="type" value="online" class="selectgroup-input">
                                            <span class="selectgroup-button">{{ __('Online Event') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="location-detail {{ $event->type == 'online' ? 'hide' : '' }}">
                                    <div class="form-group">
                                        <label>{{ __('Event Address') }}</label>
                                        <input type="text" name="address" id="address"
                                            value="{{ $event->address }}" placeholder="{{ __('Event Address') }}"
                                            class="form-control @error('address')? is-invalid @enderror">
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{ __('Latitude') }}</label>
                                                <input type="text" name="lat" id="lat"
                                                    value="{{ $event->lat }}" placeholder="{{ __('Latitude') }}"
                                                    class="form-control @error('lat')? is-invalid @enderror">
                                                @error('lat')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{ __('Longitude') }}</label>
                                                <input type="text" name="lang" id="lang"
                                                    value="{{ $event->lang }}" placeholder="{{ __('Longitude') }}"
                                                    class="form-control @error('lang')? is-invalid @enderror">
                                                @error('lang')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="url {{ $event->type == 'offline' ? 'hide' : '' }}">
                                    <div class="form-group">
                                        <label>{{ __('Event url') }}</label>
                                        <input type="link" value="{{ $event->url }}" name="url" id="url"
                                            placeholder="{{ __('Event url') }}"
                                            class="form-control @error('url')? is-invalid @enderror">
                                        @error('url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit"
                                        class="btn btn-primary demo-button">{{ __('Submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
       document.addEventListener('DOMContentLoaded', function () {
            const categoryElement = document.getElementById('category_id');
            const subcategoryElement = document.getElementById('subcategory_id');
            const selectedCategoryId = categoryElement.value;
            
            if (selectedCategoryId) {
                fetchSubcategories(selectedCategoryId);
            }

            categoryElement.addEventListener('change', function () {
                const categoryId = this.value;
                fetchSubcategories(categoryId);
            });

            function fetchSubcategories(categoryId) {
                // Clear previous options and disable subcategory dropdown
                subcategoryElement.innerHTML = '<option value="">Select Subcategory</option>';
                subcategoryElement.disabled = true;

                if (categoryId) {
                    fetch(`/subcategories/${categoryId}`)
                        .then(response => response.json())
                        .then(data => {
                            // Populate subcategory options dynamically
                            data.forEach(subcategory => {
                                const option = document.createElement('option');
                                option.value = subcategory.id;
                                option.textContent = subcategory.name;
                                subcategoryElement.appendChild(option);
                            });

                            // Enable the subcategory dropdown
                            subcategoryElement.disabled = false;
                            // Optionally, select the subcategory based on existing value (event->subcategory_id)
                            if ("{{ $event->subcategory_id }}") {
                                subcategoryElement.value = "{{ $event->subcategory_id }}";
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching subcategories:', error);
                        });
                }
            }
        });

    </script>
    

    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const fileInput = document.getElementById('media-upload');
        const previewContainer = document.getElementById('media-preview');
        const removedFieldsContainer = document.getElementById('removed-fields-container');

        document.getElementById('upload-button').addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function () {
            Array.from(this.files).forEach((file, index) => {
                const preview = document.createElement('div');
                preview.className = 'media-preview-item';
                preview.dataset.type = 'new';

                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    preview.appendChild(img);
                } else {
                    const video = document.createElement('video');
                    video.src = URL.createObjectURL(file);
                    video.controls = true;
                    preview.appendChild(video);
                }

                const removeBtn = document.createElement('button');
                removeBtn.className = 'remove-media';
                removeBtn.innerHTML = '&times;';
                removeBtn.onclick = () => preview.remove();
                preview.appendChild(removeBtn);

                preview.appendChild(fileInput.cloneNode());
                previewContainer.insertBefore(preview, document.getElementById('upload-button'));
            });

            this.value = '';
        });

        previewContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-media')) {
                const item = e.target.closest('.media-preview-item');
                const path = e.target.dataset.path;
                if (item.dataset.type === 'existing') {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'removed_media[]';
                    input.value = path;
                    removedFieldsContainer.appendChild(input);
                    item.remove();
                }
            }
        });
    });
</script>

    @php
        $gmapkey = App\Models\Setting::find(1)->map_key;
    @endphp
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ $gmapkey }}&libraries=places">
    </script>

    <script>
        google.maps.event.addDomListener(window, 'load', initialize);

        function initialize() {
            var input = document.getElementById('address');
            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                $('#lat').val(place.geometry['location'].lat());
                $('#lang').val(place.geometry['location'].lng());
            });
        }
    </script>
    <style>
        .modal-backdrop {
            display: none;
        }
    </style>
@endsection
