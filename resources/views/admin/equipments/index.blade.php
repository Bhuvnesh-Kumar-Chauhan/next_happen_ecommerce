@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => __('Accessories')])
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
                                <h2 class="section-title mt-0">{{ __('View Accessories') }}</h2>
                            </div>
                            <div class="col-lg-4 text-right">
                              
                                <a href="{{ route('equipments.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> {{ __('Add New Accessories') }}
                                </a>

                                <a href="{{ route('equipments-type.index') }}" class="btn btn-primary">
                                    {{ __('Accessories Type') }}
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="report_table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Accessories Type') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Offered Price') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        @if (Gate::check('equipment_edit') || Gate::check('equipment_delete'))
                                            <th>{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($equipments as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $equipment_types->find($item->equipment_type_id)->name ?? '-' }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->offered_price }}</td>
                                            <td>
                                                @if($item->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            
                                            <td>
                                                 <a href="{{ route('equipments.edit', $item->id) }}" class="btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                 <form action="{{ route('equipments.destroy', $item->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-icon" onclick="return confirm('Are you sure you want to delete this equipment?')">
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
