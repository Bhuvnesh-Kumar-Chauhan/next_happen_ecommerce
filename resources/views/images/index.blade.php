@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Images</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('images.create') }}" class="btn btn-primary mb-3">Upload New Image</a>

        <div class="row">
            @foreach ($images as $image)

                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ $image['url'] }}" class="card-img-top" alt="Image">
                        <div class="card-body">
                            <p class="card-text">
                                <small>Size: {{ round($image['size'] / 1024, 2) }} KB</small><br>
                                <small>Uploaded: {{ $image['last_modified']->format('Y-m-d H:i:s') }}</small>
                            </p>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('images.show', ['path' => $image['path']]) }}" class="btn btn-sm btn-info">View</a>
                                <div>
                                    <a href="{{ route('images.edit', ['path' => $image['path']]) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('images.destroy', ['path' => $image['path']]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
