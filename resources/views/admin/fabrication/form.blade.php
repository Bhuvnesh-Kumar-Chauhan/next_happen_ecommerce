@php
    $fabrication = $fabrication ?? null;
@endphp

<div class="form-group">
    <label>{{ __('Title') }}</label>
    <input type="text" name="title" class="form-control" required value="{{ old('title', $fabrication->title ?? '') }}">
</div>

<div class="form-group">
    <label>{{ __('Category') }}</label>
    <input type="text" name="category" class="form-control" value="{{ old('category', $fabrication->category ?? '') }}">
</div>

<div class="form-group">
    <label>{{ __('Details') }}</label>
    <textarea name="details" class="form-control" rows="3">{{ old('details', $fabrication->details ?? '') }}</textarea>
</div>

<div class="form-group">
    <label>{{ __('Length (in feet)') }}</label>
    <input type="number" name="length" class="form-control" value="{{ old('length', $fabrication->length ?? '') }}">
</div>

<div class="form-group">
    <label>{{ __('Width (in feet)') }}</label>
    <input type="number" name="width" class="form-control" value="{{ old('width', $fabrication->width ?? '') }}">
</div>

<div class="form-group">
    <label>{{ __('Service Type') }}</label>
    <select name="service_id" class="form-control">
        <option value="">{{ __('Select Service') }}</option>
        @foreach ($services as $service)
            <option value="{{ $service->id }}"
                {{ old('service_id', $fabrication->service_id ?? '') == $service->id ? 'selected' : '' }}>
                {{ $service->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>{{ __('Is Active?') }}</label>
    <select name="is_active" class="form-control">
        <option value="1" {{ old('is_active', $fabrication->is_active ?? 1) == 1 ? 'selected' : '' }}>{{ __('Yes') }}</option>
        <option value="0" {{ old('is_active', $fabrication->is_active ?? 1) == 0 ? 'selected' : '' }}>{{ __('No') }}</option>
    </select>
</div>
