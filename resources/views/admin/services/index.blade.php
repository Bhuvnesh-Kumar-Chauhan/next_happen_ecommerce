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
         <style>
        button, .button-class, .icon-wrapper {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            }
            div, td, span {
            border: none !important;
            }
        .btn-icon {
            border: none; 
            outline: none;  
            background-color: transparent; 
        }
       
    </style>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
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
                                        <button class="btn btn-primary add-button"><a href="{{ route('services.create') }}"><i
                                           class="fas fa-plus"></i> {{ __('Add New Service') }}</a>
                                        </button>
                                    @endcan

                                     <button class="btn btn-primary add-button"><a href="{{ route('services-category.index') }}">
                                         {{ __('Service Category') }}</a>
                                        </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="report_table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Service Category') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Offered Price') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            @if (Gate::check('service_edit') || Gate::check('service_delete'))
                                                <th>{{ __('Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($services as $item)
                                            <tr>
                                                <td>{{ $item->name ?? "" }}</td>
                                                <td>{{ $item->category->name ?? "" }}</td>
                                                <td>{{ $item->price ?? "" }}</td>
                                                <td>{{ $item->offered_price ?? "" }}</td>
                                                <td>
                                                    @if($item->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('services.edit', $item->id) }}"
                                                        class="btn-icon"><i class="fas fa-edit"></i></a>

                                                    <form action="{{ route('services.destroy', $item->id) }}" method="POST" style=" display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-icon" onclick="return confirm('Are you sure you want to delete this service ?')">
                                                            <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                      
                                                    </td>
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
