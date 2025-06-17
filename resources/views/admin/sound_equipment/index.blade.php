@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Sound Equipment'),
        ])

        <div class="section-body">
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
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4 mt-2">
                                <div class="col-lg-8">
                                    <h2 class="section-title mt-0"> {{ __('View Sound Equipment') }}</h2>
                                </div>
                                <div class="col-lg-4 text-right">
                                    @can('sound_equipment_create')
                                        <button class="btn btn-primary add-button">
                                            <a href="{{ route('sound-equipment.create') }}">
                                                <i class="fas fa-plus"></i> {{ __('Add New Equipment') }}
                                            </a>
                                        </button>
                                    @endcan
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table" id="report_table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Description') }}</th>
                                            <th>{{ __('Setup Area') }}</th>
                                            <th>{{ __('Service Type') }}</th>
                                            <th>{{ __('Included Equipment') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            @if (Gate::check('sound_equipment_edit') || Gate::check('sound_equipment_delete'))
                                                <th>{{ __('Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($soundEquipments as $equipment)
                                            <tr>
                                                <td>{{ $equipment->name }}</td>
                                                <td>{{ $equipment->description }}</td>
                                                <td>{{ $equipment->setup_area_size }}</td>
                                                <td>{{ $equipment->service->name ?? '-' }}</td>
                                                <td>
                                                    @php
                                                        $options = [];
                                                        if ($equipment->mixer) $options[] = 'Mixer';
                                                        if ($equipment->woofers) $options[] = 'Woofers';
                                                        if ($equipment->line_array) $options[] = 'Line Array';
                                                        if ($equipment->monitor_speakers) $options[] = 'Monitor Speakers';
                                                        if ($equipment->microphones) $options[] = 'Microphones';
                                                        if ($equipment->wireless_mics) $options[] = 'Wireless Mics';
                                                        if ($equipment->amplifiers) $options[] = 'Amplifiers';
                                                        if ($equipment->equalizers) $options[] = 'Equalizers';
                                                    @endphp
                                                    {{ implode(', ', $options) ?: '-' }}
                                                </td>
                                                <td>
                                                    @if($equipment->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </td>

                                                @if (Gate::check('sound_equipment_edit') || Gate::check('sound_equipment_delete'))
                                                    <td>
                                                        @can('sound_equipment_edit')
                                                            <a href="{{ route('sound-equipment.edit', $equipment->id) }}" class="btn-icon">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        @endcan
                                                        @can('sound_equipment_delete')
                                                            <form action="{{ route('sound-equipment.destroy', $equipment->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn-icon" onclick="return confirm('Are you sure you want to delete this item?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
