@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => 'Add Sponsor'])

    <div class="section-body">
        <form action="{{ route('sponsors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.sponsors.form')
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</section>
@endsection
