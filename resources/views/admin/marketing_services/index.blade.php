@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => __('Marketing Services')])

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
                                <h2 class="section-title mt-0">{{ __('View Marketing Services') }}</h2>
                            </div>
                            <div class="col-lg-4 text-right">
                                @can('marketing_service_create')
                                    <a href="{{ route('marketing-services.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> {{ __('Add Marketing Service') }}
                                    </a>
                                @endcan
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table" id="report_table">
                                <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th>Social Media</th>
                                        <th>Influencer</th>
                                        <th>Email</th>
                                        <th>WhatsApp</th>
                                        <th>Status</th>
                                        @if (Gate::check('marketing_service_edit') || Gate::check('marketing_service_delete'))
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($services as $item)
                                    <tr>
                                        <td>{{ $item->service->name ?? 'N/A' }}</td>
                                        <td>{{ $item->social_media_campaigns ? 'Yes' : 'No' }}</td>
                                        <td>{{ $item->influencer_shoutouts ? 'Yes' : 'No' }}</td>
                                        <td>{{ $item->email_campaigns ? 'Yes' : 'No' }}</td>
                                        <td>{{ $item->whatsapp_promotions ? 'Yes' : 'No' }}</td>
                                        <td>
                                            <span class="badge {{ $item->status ? 'badge-success' : 'badge-secondary' }}">
                                                {{ $item->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        @if (Gate::check('marketing_service_edit') || Gate::check('marketing_service_delete'))
                                        <td>
                                            @can('marketing_service_edit')
                                                <a href="{{ route('marketing-services.edit', $item->id) }}" class="btn-icon">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('marketing_service_delete')
                                                <form action="{{ route('marketing-services.destroy', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn-icon" onclick="return confirm('Are you sure?')">
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
