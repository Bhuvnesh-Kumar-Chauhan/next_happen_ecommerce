@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => 'Add Sponsorship'])

    <div class="section-body">
        <form action="{{ route('sponsorships.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.sponsorships.form')
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</section>
@endsection
