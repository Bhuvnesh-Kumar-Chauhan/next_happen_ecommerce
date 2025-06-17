@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => 'Edit Celebrity'])

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('celebrities.update', $celebrity->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('admin.celebrities.form', ['celebrity' => $celebrity])

                    <button class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
