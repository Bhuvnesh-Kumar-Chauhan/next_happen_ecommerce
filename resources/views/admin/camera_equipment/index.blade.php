@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => __('Camera Equipments'),
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
                                <h2 class="section-title mt-0">{{ __('View Camera Equipments') }}</h2>
                            </div>
                            <div class="col-lg-4 text-right">
                                @can('camera_equipment_create')
                                    <button class="btn btn-primary add-button">
                                        <a href="{{ route('camera-equipments.create') }}">
                                            <i class="fas fa-plus"></i> {{ __('Add New Camera Equipment') }}
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
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Lens Support') }}</th>
                                        <th>{{ __('Accessories') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        @if (Gate::check('camera_equipment_edit') || Gate::check('camera_equipment_delete'))
                                            <th>{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cameraEquipments as $equipment)
                                        <tr>
                                            <td>{{ $equipment->name }}</td>
                                            <td>{{ $equipment->type }}</td>
                                            <td>{{ $equipment->lens_support ? 'Yes' : 'No' }}</td>
                                            <td>{{ $equipment->accessories }}</td>
                                            <td>
                                                @if($equipment->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            @if (Gate::check('av_equipment_edit') || Gate::check('av_equipment_delete'))
                                            <td>
                                                @can('camera_equipment_edit')
                                                    <a href="{{ route('camera-equipments.edit', $equipment->id) }}" class="btn-icon">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('camera_equipment_delete')
                                                    <form action="{{ route('camera-equipments.destroy', $equipment->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-icon" onclick="return confirm('Are you sure?')">
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
