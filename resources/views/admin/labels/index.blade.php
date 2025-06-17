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
            'title' => __('Label'),
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
                                    <h2 class="section-title mt-0"> {{ __('Label Category') }}</h2>
                                </div>
                                <div class="col-lg-4 text-right">
                                    @can('label_create')
                                        <button class="btn btn-primary add-button"><a href="{{ url('label/create') }}"><i
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
                                            <th>{{ __('Status') }}</th>
                                            @if (Gate::check('label_edit') || Gate::check('label_delete'))
                                                <th>{{ __('Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($labels as $item)
                                            <tr>
                                                <td></td>
                                                
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    <h5><span
                                                            class="badge {{ $item->status == '1' ? 'badge-success' : 'badge-warning' }}  m-1">{{ $item->status == '1' ? 'Active' : 'Inactive' }}</span>
                                                    </h5>
                                                </td>
                                                @if (Gate::check('label_edit') || Gate::check('label_delete'))
                                                    <td>
                                                        @can('label_edit')
                                                            <a href="{{ route('label.edit', $item->id) }}"
                                                                class="btn-icon"><i class="fas fa-edit"></i></a>
                                                        @endcan
                                                        @can('label_delete')
                                                            <form action="{{ route('label.destroy', $item->id) }}" method="POST" style=" display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn-icon" onclick="return confirm('Are you sure you want to delete this label?')">
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
