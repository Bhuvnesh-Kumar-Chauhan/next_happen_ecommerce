@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => 'Edit Influencer'])

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('influencers.update', $influencer->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Name*</label>
                        <input type="text" name="name" value="{{ $influencer->name }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Audience*</label>
                        <select name="audience" class="form-control" required>
                            <option value="Bollywood" {{ $influencer->audience == 'Bollywood' ? 'selected' : '' }}>Bollywood</option>
                            <option value="Regional" {{ $influencer->audience == 'Regional' ? 'selected' : '' }}>Regional</option>
                            <option value="Business" {{ $influencer->audience == 'Business' ? 'selected' : '' }}>Business</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Platform*</label>
                        <input type="text" name="platform" value="{{ $influencer->platform }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Followers Count*</label>
                        <input type="number" name="followers_count" value="{{ $influencer->followers_count }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" name="category" value="{{ $influencer->category }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Rate Card</label>
                        <input type="text" name="rate_card" value="{{ $influencer->rate_card }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Service Type</label>
                        <select name="service_id" class="form-control">
                            <option value="">-- Select Service --</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" {{ $influencer->service_id == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ $influencer->status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$influencer->status ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('influencers.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
