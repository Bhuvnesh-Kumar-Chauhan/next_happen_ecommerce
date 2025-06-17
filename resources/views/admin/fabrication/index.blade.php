@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Fabrications'),
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
                                    <h2 class="section-title mt-0"> {{ __('View Fabrications') }}</h2>
                                </div>
                                <div class="col-lg-4 text-right">
                                    @can('fabrication_create')
                                        <button class="btn btn-primary add-button">
                                            <a href="{{ route('fabrications.create') }}">
                                                <i class="fas fa-plus"></i> {{ __('Add New Fabrication') }}
                                            </a>
                                        </button>
                                    @endcan
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="report_table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Title') }}</th>
                                            <th>{{ __('Category') }}</th>
                                            <th>{{ __('Details') }}</th>
                                            <th>{{ __('Size') }}</th>
                                            <th>{{ __('Service Type') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            @if (Gate::check('fabrication_edit') || Gate::check('fabrication_delete'))
                                                <th>{{ __('Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fabrications as $fabrication)
                                            <tr>
                                                <td>{{ $fabrication->title }}</td>
                                                <td>{{ $fabrication->category }}</td>
                                                <td>{{ $fabrication->details }}</td>
                                                <td>
                                                    {{ $fabrication->length }}ft x {{ $fabrication->width }}ft
                                                </td>
                                                <td>{{ $fabrication->service->name ?? '-' }}</td>
                                                <td>
                                                    @if($fabrication->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                @if (Gate::check('fabrication_edit') || Gate::check('fabrication_delete'))
                                                    <td>
                                                        @can('fabrication_edit')
                                                            <a href="{{ route('fabrications.edit', $fabrication->id) }}" class="btn-icon">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        @endcan
                                                        @can('fabrication_delete')
                                                            <form action="{{ route('fabrications.destroy', $fabrication->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn-icon" onclick="return confirm('Are you sure you want to delete this fabrication item?')">
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
