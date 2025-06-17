@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => 'Add Celebrity'])

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('celebrities.store') }}" method="POST">
                    @csrf

                    @include('admin.celebrities.form', ['celebrity' => null])

                    <button class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
