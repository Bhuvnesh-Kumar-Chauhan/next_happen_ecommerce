@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => 'Edit Sponsor'])

    <div class="section-body">
        <form action="{{ route('sponsors.update', $sponsor->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('admin.sponsors.form', ['sponsor' => $sponsor])
            <button class="btn btn-primary">Update</button>
        </form>
    </div>
</section>
@endsection
