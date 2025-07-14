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
</style>


    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Add Event'),
            'headerData' => __('Event'),
            'url' => 'events',
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title"> {{ __('Add Event') }}</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" class="event-form" action="{{ url('events') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!--<div class="col-lg-6">-->
                                    <!--    <div class="form-group center">-->
                                    <!--        <label>{{ __('Image') }}</label>-->
                                    <!--        <div id="image-preview" class="image-preview">-->
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
                                                <input type="file" name="image[]" id="media-upload" multiple accept="image/*,video/*" style="display: none;" />
                                                <button type="button" id="upload-button" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Add Files
                                                </button>
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
                                            <label>{{ __('Name') }}</label>
                                            <input type="text" name="name" value="{{ old('name') }}"
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
                                                @foreach($category as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="subcategory_id">{{ __('Subcategory') }}</label>
                                            <select id="subcategory_id" name="subcategory_id" class="form-control" disabled>
                                                <option value="">{{ __('Select Subcategory') }}</option>
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
                                                value="{{ old('start_time') }}"
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
                                                value="{{ old('end_time') }}" placeholder="{{ __('Choose End time') }}"
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
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Label') }}</label>
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
                                
                                
                                <div class="scanner">
                                    <div class="form-group">
                                        <label>{{ __('Scanner') }} {{ __('(Required)')}} {{__('(Choose Multiple if required.)')}}</label>
                                        <select name="scanner_id[]" class="form-control scanner_id select2 selectpicker" multiple data-live-search="true">
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
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Maximum people will join in this event') }}</label>
                                            <input type="number" min='1' name="people" id="people"
                                                value="{{ old('people') }}"
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
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Tags') }}</label>
                                            <input type="text" name="tags" value="{{ old('tags') }}"
                                                class="form-control inputtags @error('tags')? is-invalid @enderror">
                                            @error('tags')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('URL') }}</label>
                                            <input type="text" name="urls" value="{{ old('urls') }}"
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
                                {{ old('description') }}
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
                                                {{ old('type') == 'online' ? '' : 'checked' }} checked value="offline"
                                                class="selectgroup-input" checked="">
                                            <span class="selectgroup-button">{{ __('Venue') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" {{ old('type') == 'online' ? 'checked' : '' }}
                                                name="type" value="online" class="selectgroup-input">
                                            <span class="selectgroup-button">{{ __('Online Event') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="location-detail {{ old('type') == 'online' ? 'hide' : '' }}">
                                    <div class="form-group">
                                        <label>{{ __('Event Address') }}</label>
                                        <input type="text" name="address" id="address"
                                            placeholder="{{ __('Event Address') }}"
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
                                                    value="{{ old('lat') }}" placeholder="{{ __('Latitude') }}"
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
                                                    value="{{ old('lang') }}" placeholder="{{ __('Longitude') }}"
                                                    class="form-control @error('lang')? is-invalid @enderror">
                                                @error('lang')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="url hide  {{ old('type') == 'online' ? 'block' : '' }}">
                                    <div class="form-group">
                                        <label>{{ __('Event url') }}</label>
                                        <input type="link" name="url" id="url"
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
        <style>
            .modal-backdrop {
               display: none;
            }
        </style>
    </section>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoryElement = document.getElementById('category_id');
            const subcategoryElement = document.getElementById('subcategory_id');

            categoryElement.addEventListener('change', function () {
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
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('media-upload');
        const uploadButton = document.getElementById('upload-button');
        const previewContainer = document.getElementById('media-preview');

        let allFiles = [];

        uploadButton.addEventListener('click', function () {
            fileInput.click();
        });

        fileInput.addEventListener('change', function (event) {
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
            document.querySelectorAll('.media-preview-item').forEach(el => el.remove());

            allFiles.forEach((file, index) => {
                const previewElement = document.createElement('div');
                previewElement.className = 'media-preview-item';

                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    previewElement.appendChild(img);
                } else if (file.type.startsWith('video/')) {
                    const video = document.createElement('video');
                    video.src = URL.createObjectURL(file);
                    video.controls = true;
                    previewElement.appendChild(video);
                }

                const removeBtn = document.createElement('button');
                removeBtn.className = 'remove-media';
                removeBtn.innerHTML = '&times;';
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
    });
</script>



    @php
        $gmapkey = App\Models\Setting::find(1)->map_key;
    @endphp
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{$gmapkey}}&libraries=places">
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
@endsection
