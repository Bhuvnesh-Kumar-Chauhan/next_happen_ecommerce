@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => 'Influencers'])

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4 mt-2">
                            <div class="col-lg-8">
                                <h2 class="section-title">View Influencers</h2>
                            </div>
                            <div class="col-lg-4 text-right">
                                @can('influencer_create')
                                    <a href="{{ route('influencers.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Add New Influencer
                                    </a>
                                @endcan
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="report_table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Audience</th>
                                        <th>Platform</th>
                                        <th>Followers</th>
                                        <th>Category</th>
                                        <th>Service Type</th>
                                        <th>Status</th>
                                        @if (Gate::check('influencer_edit') || Gate::check('influencer_delete'))
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($influencers as $influencer)
                                    <tr>
                                        <td>{{ $influencer->name }}</td>
                                        <td>{{ $influencer->audience }}</td>
                                        <td>{{ $influencer->platform }}</td>
                                        <td>{{ number_format($influencer->followers_count) }}</td>
                                        <td>{{ $influencer->category }}</td>
                                        <td>{{ $influencer->service->name ?? '-' }}</td>
                                        <td>
                                            @if($influencer->status)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        @if (Gate::check('influencer_edit') || Gate::check('influencer_delete'))
                                            <td>
                                                @can('influencer_edit')
                                                    <a href="{{ route('influencers.edit', $influencer->id) }}" class="btn-icon"><i class="fas fa-edit"></i></a>
                                                @endcan
                                                @can('influencer_delete')
                                                    <form action="{{ route('influencers.destroy', $influencer->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-icon" onclick="return confirm('Are you sure to delete this influencer?')">
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
