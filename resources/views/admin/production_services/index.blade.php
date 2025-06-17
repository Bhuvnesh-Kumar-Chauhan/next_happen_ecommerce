@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => __('Production Services')])

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @if(session('status'))
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
                                <h2 class="section-title mt-0">{{ __('View Production Services') }}</h2>
                            </div>
                            <div class="col-lg-4 text-right">
                                @can('production_service_create')
                                    <button class="btn btn-primary add-button">
                                        <a href="{{ route('production-services.create') }}">
                                            <i class="fas fa-plus"></i> {{ __('Add Production Service') }}
                                        </a>
                                    </button>
                                @endcan
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table" id="report_table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Service') }}</th>
                                        <th>{{ __('Video Coverage') }}</th>
                                        <th>{{ __('Livestream Setup') }}</th>
                                        <th>{{ __('Photography') }}</th>
                                        <th>{{ __('Post-event Editing') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        @if(Gate::check('production_service_edit') || Gate::check('production_service_delete'))
                                            <th>{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($services as $item)
                                        <tr>
                                            <td>{{ $item->service->name ?? 'N/A' }}</td>
                                            <td>{{ $item->video_coverage ? 'Yes' : 'No' }}</td>
                                            <td>{{ $item->livestream_setup ? 'Yes' : 'No' }}</td>
                                            <td>{{ $item->photography ? 'Yes' : 'No' }}</td>
                                            <td>{{ $item->post_event_editing ? 'Yes' : 'No' }}</td>
                                            <td>
                                                @if($item->status)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            @if(Gate::check('production_service_edit') || Gate::check('production_service_delete'))
                                                <td>
                                                    @can('production_service_edit')
                                                        <a href="{{ route('production-services.edit', $item->id) }}" class="btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('production_service_delete')
                                                        <form action="{{ route('production-services.destroy', $item->id) }}" method="POST" class="d-inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn-icon" onclick="return confirm('Delete this item?')">
                                                                <i class="fas fa-trash text-danger"></i>
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
