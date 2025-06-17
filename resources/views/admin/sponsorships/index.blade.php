@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => __('Sponsorships')])

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
                                <h2 class="section-title mt-0">{{ __('View Sponsorships') }}</h2>
                            </div>
                            <div class="col-lg-4 text-right">
                                @can('sponsorship_create')
                                    <button class="btn btn-primary add-button">
                                        <a href="{{ route('sponsorships.create') }}">
                                            <i class="fas fa-plus"></i> {{ __('Add Sponsorship') }}
                                        </a>
                                    </button>
                                @endcan
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table" id="report_table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Event Name') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Service') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Proposal') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        @if(Gate::check('sponsorship_edit') || Gate::check('sponsorship_delete'))
                                            <th>{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sponsorships as $item)
                                        <tr>
                                            <td>{{ $item->event_name }}</td>
                                            <td>{{ $item->event_type }}</td>
                                            <td>{{ $item->service->name ?? '-' }}</td>
                                            <td>{{ $item->event_date }}</td>
                                            <td>
                                                @if($item->proposal_file)
                                                    <a href="{{ asset('storage/' . $item->proposal_file) }}" target="_blank">View</a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->status)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            @if(Gate::check('sponsorship_edit') || Gate::check('sponsorship_delete'))
                                                <td>
                                                    @can('sponsorship_edit')
                                                        <a href="{{ route('sponsorships.edit', $item->id) }}" class="btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('sponsorship_delete')
                                                        <form action="{{ route('sponsorships.destroy', $item->id) }}" method="POST" class="d-inline">
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
