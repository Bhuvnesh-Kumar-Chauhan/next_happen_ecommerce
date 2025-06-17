{{-- resources/views/admin/celebrities/index.blade.php --}}

@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => __('Celebrities'),
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
                                <h2 class="section-title mt-0">{{ __('View Celebrities') }}</h2>
                            </div>
                            <div class="col-lg-4 text-right">
                                @can('celebrity_create')
                                    <button class="btn btn-primary add-button">
                                        <a href="{{ route('celebrities.create') }}">
                                            <i class="fas fa-plus"></i> {{ __('Add New Celebrity') }}
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
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Audience') }}</th>
                                        <th>{{ __('Rate Card') }}</th>
                                        <th>{{ __('Service Type') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        @if (Gate::check('celebrity_edit') || Gate::check('celebrity_delete'))
                                            <th>{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($celebrities as $celebrity)
                                    <tr>
                                        <td>{{ $celebrity->name }}</td>
                                        <td>{{ $celebrity->category }}</td>
                                        <td>{{ $celebrity->audience }}</td>
                                        <td>{{ $celebrity->rate_card }}</td>
                                        <td>{{ $celebrity->service->name ?? '-' }}</td>
                                        <td>
                                            @if($celebrity->status)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        @if (Gate::check('celebrity_edit') || Gate::check('celebrity_delete'))
                                            <td>
                                                @can('celebrity_edit')
                                                    <a href="{{ route('celebrities.edit', $celebrity->id) }}" class="btn-icon">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('celebrity_delete')
                                                    <form action="{{ route('celebrities.destroy', $celebrity->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-icon" onclick="return confirm('Are you sure you want to delete this celebrity?')">
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
