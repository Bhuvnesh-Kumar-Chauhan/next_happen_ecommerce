<div class="form-group">
    <label>Event Name</label>
    <input type="text" name="event_name" class="form-control" value="{{ old('event_name', $sponsorship->event_name ?? '') }}" required>
</div>

<div class="form-group">
    <label>Event Type</label>
    <input type="text" name="event_type" class="form-control" value="{{ old('event_type', $sponsorship->event_type ?? '') }}" required>
</div>

<div class="form-group">
    <label>Service</label>
    <select name="service_id" class="form-control">
        <option value="">Select Service</option>
        @foreach($services as $service)
            <option value="{{ $service->id }}" {{ old('service_id', $sponsorship->service_id ?? '') == $service->id ? 'selected' : '' }}>
                {{ $service->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Event Date</label>
    <input type="date" name="event_date" class="form-control" value="{{ old('event_date', $sponsorship->event_date ?? '') }}">
</div>

<div class="form-group">
    <label>Location</label>
    <input type="text" name="location" class="form-control" value="{{ old('location', $sponsorship->location ?? '') }}">
</div>

<div class="form-group">
    <label>Description</label>
    <textarea name="event_description" class="form-control">{{ old('event_description', $sponsorship->event_description ?? '') }}</textarea>
</div>

<div class="form-group">
    <label>Matched Sponsor</label>
    <select name="matched_sponsor_id" class="form-control">
        <option value="">Select Sponsor</option>
        @foreach($sponsors as $sponsor)
            <option value="{{ $sponsor->id }}" {{ old('matched_sponsor_id', $sponsorship->matched_sponsor_id ?? '') == $sponsor->id ? 'selected' : '' }}>
                {{ $sponsor->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Message</label>
    <textarea name="message" class="form-control">{{ old('message', $sponsorship->message ?? '') }}</textarea>
</div>

<div class="form-group">
    <label>Proposal File</label>
    <input type="file" name="proposal_file" class="form-control">
    @if (!empty($sponsorship->proposal_file))
        <a href="{{ asset('storage/' . $sponsorship->proposal_file) }}" target="_blank">View Existing</a>
    @endif
</div>

<div class="form-group">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="1" {{ (old('status', $sponsorship->status ?? 1) == 1) ? 'selected' : '' }}>Active</option>
        <option value="0" {{ (old('status', $sponsorship->status ?? 1) == 0) ? 'selected' : '' }}>Inactive</option>
    </select>
</div>
