@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => 'Add Influencer'])

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('influencers.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Name*</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Audience*</label>
                        <select name="audience" class="form-control" required>
                            <option value="Bollywood">Bollywood</option>
                            <option value="Regional">Regional</option>
                            <option value="Business">Business</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Platform*</label>
                        <input type="text" name="platform" class="form-control" required placeholder="e.g. Instagram">
                    </div>

                    <div class="form-group">
                        <label>Followers Count*</label>
                        <input type="number" name="followers_count" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" name="category" class="form-control" value="Social Influencer">
                    </div>

                    <div class="form-group">
                        <label>Rate Card (text or link)</label>
                        <input type="text" name="rate_card" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Service Type</label>
                        <select name="service_id" class="form-control">
                            <option value="">-- Select Service --</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('influencers.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
