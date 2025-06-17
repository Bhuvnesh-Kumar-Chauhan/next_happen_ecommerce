@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Manage Disclaimer'),
            'headerData' => __('Event'),
            'url' => 'events/' . $event->id,
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
                                    <h2 class="section-title mt-0"> {{ __('View Disclaimer') }}</h2>
                                </div>
                                <div class="col-lg-4 text-right">
                                    @can('ticket_create')
                                        <button class="btn btn-primary add-button"><a
                                                href="{{ url($event->id . '/disclaimer/create') }}"><i class="fas fa-plus"></i>
                                                {{ __('Add New') }}</a></button>
                                    @endcan
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="report_table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Disclaimer') }}</th>
                                            @if (Gate::check('ticket_edit') || Gate::check('ticket_delete'))
                                                <th>{{ __('Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($disclaimers as $item)
                                            <tr>
                                                <td></td>
                                                <th> {{ isset($item->event) ? $item->event->name : '---' }}</th>
                                                <td> {{ isset($item->disclaimer) ? strip_tags($item->disclaimer) : '---' }}</td>
                                                @if (Gate::check('ticket_edit') || Gate::check('ticket_delete'))
                                                    <td>
                                                        @can('ticket_edit')
                                                            <a href="{{ url('disclaimer/edit/' . $item->id) }}" class="btn-icon"><i
                                                                    class="fas fa-edit"></i></a>
                                                        @endcan
                                                        @can('ticket_delete')
                                                            <a href="#"
                                                                onclick="deleteData('disclaimer','{{ $item->id }}');"
                                                                class="btn-icon"><i
                                                                    class="fas fa-trash-alt text-danger"></i></a>
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
