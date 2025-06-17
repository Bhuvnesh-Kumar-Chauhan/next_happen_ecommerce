@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => 'Edit Sponsorship'])

    <div class="section-body">
        <form action="{{ route('sponsorships.update', $sponsorship->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.sponsorships.form', ['sponsorship' => $sponsorship])
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</section>
@endsection
