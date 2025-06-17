<style>
    .btn-icon {
    border: none; 
    outline: none;  
    background-color: transparent; 
}
</style>

@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Services'),
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
                                    <h2 class="section-title mt-0"> {{ __('View Services') }}</h2>
                                </div>
                                <div class="col-lg-4 text-right">
                                    @can('service_create')
                                        <button class="btn btn-primary add-button"><a href="{{ url('service/create') }}"><i
                                                    class="fas fa-plus"></i> {{ __('Add New') }}</a></button>
                                    @endcan
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="report_table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Description') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            @if (Gate::check('service_edit') || Gate::check('service_delete'))
                                                <th>{{ __('Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($services as $item)
                                            <tr>
                                                <td></td>
                                                <td>{{ $item->name }}</td>
                                              
                                                <td>{{ $item->description }}</td>
                                                <td>
                                                    @if($item->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                @if (Gate::check('service_edit') || Gate::check('service_delete'))
                                                    <td>
                                                        @can('service_edit')
                                                            <a href="{{ route('service.edit', $item->id) }}"
                                                                class="btn-icon"><i class="fas fa-edit"></i></a>
                                                        @endcan
                                                        @can('service_delete')
                                                            <form action="{{ route('service.destroy', $item->id) }}" method="POST" style=" display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn-icon" onclick="return confirm('Are you sure you want to delete this service ?')">
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
