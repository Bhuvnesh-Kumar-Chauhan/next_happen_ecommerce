@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => __('AV Equipments')])

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
                                <h2 class="section-title mt-0">{{ __('View AV Equipments') }}</h2>
                            </div>
                            <div class="col-lg-4 text-right">
                                @can('av_equipment_create')
                                <a href="{{ route('av_equipments.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> {{ __('Add New AV Equipment') }}
                                </a>
                                @endcan
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="report_table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Model') }}</th>
                                        <th>{{ __('Size') }}</th>
                                        <th>{{ __('Quantity') }}</th>
                                        <th>{{ __('Service') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        @if (Gate::check('av_equipment_edit') || Gate::check('av_equipment_delete'))
                                            <th>{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($avEquipments as $item)
                                        <tr>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->type }}</td>
                                            <td>{{ $item->model }}</td>
                                            <td>{{ $item->length }}ft x {{ $item->width }}ft</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->service->name ?? '-' }}</td>
                                            <td>
                                                @if($item->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            @if (Gate::check('av_equipment_edit') || Gate::check('av_equipment_delete'))
                                            <td>
                                                @can('av_equipment_edit')
                                                <a href="{{ route('av_equipments.edit', $item->id) }}" class="btn-icon">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endcan

                                                @can('av_equipment_delete')
                                                <form action="{{ route('av_equipments.destroy', $item->id) }}" method="POST" style="display:inline;">
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
