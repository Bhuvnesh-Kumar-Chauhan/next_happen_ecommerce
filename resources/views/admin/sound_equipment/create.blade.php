@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => __('Add Sound Equipment')])

    <div class="section-body">
        <form action="{{ route('sound-equipment.store') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="service_id">Service</label>
                            <select name="service_id" id="service_id" class="form-control" required>
                                <option value="">Select Service</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="d-block">Sound Equipment Options</label>
                            @foreach ([
                                'mixer' => 'Mixer',
                                'woofers' => 'Woofers',
                                'line_array' => 'Line Array',
                                'monitor_speakers' => 'Monitor Speakers',
                                'microphones' => 'Microphones',
                                'wireless_mics' => 'Wireless Mics',
                                'amplifiers' => 'Amplifiers',
                                'equalizers' => 'Equalizers'
                            ] as $key => $label)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="{{ $key }}" value="1" id="{{ $key }}">
                                    <label class="form-check-label" for="{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group col-md-6">
                            <label for="setup_area_size">Setup Area Size (e.g., 10x15 ft)</label>
                            <input type="text" name="setup_area_size" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Status</label>
                            <select name="is_active" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
