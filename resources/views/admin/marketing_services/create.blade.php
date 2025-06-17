@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => __('Add Marketing Service')])

    <div class="section-body">
        <form action="{{ route('marketing-services.store') }}" method="POST">
            @csrf

            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Service</label>
                        <select name="service_id" class="form-control">
                            <option value="">Select Service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @foreach(['social_media_campaigns' => 'Social Media Campaigns', 'influencer_shoutouts' => 'Influencer Shoutouts', 'email_campaigns' => 'Email Campaigns', 'whatsapp_promotions' => 'WhatsApp Promotions'] as $field => $label)
                        <div class="form-group">
                            <label>{{ $label }}</label>
                            <select name="{{ $field }}" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    @endforeach

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
