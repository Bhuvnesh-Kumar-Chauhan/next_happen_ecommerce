{{-- resources/views/admin/speakers/index.blade.php --}}

@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => __('Speakers'),
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
                                <h2 class="section-title mt-0">{{ __('View Speakers') }}</h2>
                            </div>
                            <div class="col-lg-4 text-right">
                                @can('speaker_create')
                                    <button class="btn btn-primary add-button">
                                        <a href="{{ route('speakers.create') }}">
                                            <i class="fas fa-plus"></i> {{ __('Add New Speaker') }}
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
                                        <th>{{ __('Topic') }}</th>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Fee') }}</th>
                                        <th>{{ __('Service Type') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        @if (Gate::check('speaker_edit') || Gate::check('speaker_delete'))
                                            <th>{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($speakers as $speaker)
                                    <tr>
                                        <td>{{ $speaker->name }}</td>
                                        <td>{{ $speaker->topic }}</td>
                                        <td>{{ $speaker->category }}</td>
                                        <td>{{ $speaker->fee }}</td>
                                        <td>{{ $speaker->service->name ?? '-' }}</td>
                                        <td>
                                            @if($speaker->status)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        @if (Gate::check('speaker_edit') || Gate::check('speaker_delete'))
                                            <td>
                                                @can('speaker_edit')
                                                    <a href="{{ route('speakers.edit', $speaker->id) }}" class="btn-icon">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('speaker_delete')
                                                    <form action="{{ route('speakers.destroy', $speaker->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-icon" onclick="return confirm('Are you sure you want to delete this speaker?')">
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
