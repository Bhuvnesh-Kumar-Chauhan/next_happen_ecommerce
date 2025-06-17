<div class="form-group">
    <label>Service</label>
    <select name="service_id" class="form-control" required>
        <option value="">-- Select Service --</option>
        @foreach($services as $service)
            <option value="{{ $service->id }}" {{ old('service_id', optional($celebrity)->service_id) == $service->id ? 'selected' : '' }}>
                {{ $service->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Name</label>
    <input type="text" name="name" value="{{ old('name', optional($celebrity)->name) }}" class="form-control" required>
</div>

<div class="form-group">
    <label>Category</label>
    <select name="category" class="form-control" required>
        <option value="Actor" {{ old('category', optional($celebrity)->category) == 'Actor' ? 'selected' : '' }}>Actor</option>
        <option value="Singer" {{ old('category', optional($celebrity)->category) == 'Singer' ? 'selected' : '' }}>Singer</option>
        <option value="Reality Star" {{ old('category', optional($celebrity)->category) == 'Reality Star' ? 'selected' : '' }}>Reality Star</option>
    </select>
</div>

<div class="form-group">
    <label>Audience</label>
    <select name="audience" class="form-control" required>
        <option value="Bollywood" {{ old('audience', optional($celebrity)->audience) == 'Bollywood' ? 'selected' : '' }}>Bollywood</option>
        <option value="Regional" {{ old('audience', optional($celebrity)->audience) == 'Regional' ? 'selected' : '' }}>Regional</option>
        <option value="Business" {{ old('audience', optional($celebrity)->audience) == 'Business' ? 'selected' : '' }}>Business</option>
    </select>
</div>

<div class="form-group">
    <label>Rate Card (INR)</label>
    <input type="number" step="0.01" name="rate_card" value="{{ old('rate_card', optional($celebrity)->rate_card) }}" class="form-control">
</div>

<div class="form-group">
    <label>Available From</label>
    <input type="date" name="available_from" value="{{ old('available_from', optional($celebrity)->available_from) }}" class="form-control">
</div>

<div class="form-group">
    <label>Available To</label>
    <input type="date" name="available_to" value="{{ old('available_to', optional($celebrity)->available_to) }}" class="form-control">
</div>

<div class="form-group">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="1" {{ old('status', optional($celebrity)->status) == 1 ? 'selected' : '' }}>Active</option>
        <option value="0" {{ old('status', optional($celebrity)->status) == 0 ? 'selected' : '' }}>Inactive</option>
    </select>
</div>
