@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Venues'),
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
                                    <h2 class="section-title mt-0"> {{ __('View Venues') }}</h2>
                                </div>
                                <div class="col-lg-4 text-right">
                                    @can('venue_create')
                                        <button class="btn btn-primary add-button">
                                            <a href="{{ route('venues.create') }}">
                                                <i class="fas fa-plus"></i> {{ __('Add New Venue') }}
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
                                            <th>{{ __('Location') }}</th>
                                            <th>{{ __('Capacity') }}</th>
                                            <th>{{ __('Service Type') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            @if (Gate::check('venue_edit') || Gate::check('venue_delete'))
                                                <th>{{ __('Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($venues as $venue)
                                            <tr>
                                                <td>{{ $venue->name }}</td>
                                                <td>{{ $venue->location }}</td>
                                                <td>{{ $venue->capacity }}</td>
                                                <td>{{ $venue->service->name }}</td>
                                                <td>
                                                    @if($venue->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                @if (Gate::check('venue_edit') || Gate::check('venue_delete'))
                                                    <td>
                                                        @can('venue_edit')
                                                            <a href="{{ route('venues.edit', $venue->id) }}" class="btn-icon">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        @endcan
                                                        @can('venue_delete')
                                                            <form action="{{ route('venues.destroy', $venue->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn-icon" onclick="return confirm('Are you sure you want to delete this venue?')">
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
