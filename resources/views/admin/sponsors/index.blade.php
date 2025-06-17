@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => __('Sponsors')])

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
                                <h2 class="section-title mt-0">{{ __('View Sponsors') }}</h2>
                            </div>
                            <div class="col-lg-4 text-right">
                                @can('sponsor_create')
                                    <button class="btn btn-primary add-button">
                                        <a href="{{ route('sponsors.create') }}">
                                            <i class="fas fa-plus"></i> {{ __('Add Sponsor') }}
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
                                        <th>{{ __('Company') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Interest Area') }}</th>
                                        <th>{{ __('Logo') }}</th>
                                        @if (Gate::check('sponsor_edit') || Gate::check('sponsor_delete'))
                                            <th>{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sponsors as $sponsor)
                                        <tr>
                                            <td>{{ $sponsor->name }}</td>
                                            <td>{{ $sponsor->company_name }}</td>
                                            <td>{{ $sponsor->email }}</td>
                                            <td>{{ $sponsor->interest_area }}</td>
                                            <td>
                                                @if($sponsor->logo)
                                                    <img src="{{ asset('storage/' . $sponsor->logo) }}" height="40">
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            @if (Gate::check('sponsor_edit') || Gate::check('sponsor_delete'))
                                                <td>
                                                    @can('sponsor_edit')
                                                        <a href="{{ route('sponsors.edit', $sponsor->id) }}" class="btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('sponsor_delete')
                                                        <form action="{{ route('sponsors.destroy', $sponsor->id) }}" method="POST" class="d-inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn-icon" onclick="return confirm('Delete this sponsor?')">
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
