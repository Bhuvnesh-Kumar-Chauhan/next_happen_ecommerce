@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Image Details</h1>
    
    <div class="card mb-3">
        <img src="{{ $url }}" class="card-img-top" alt="Image">
        <div class="card-body">
            <form action="{{ route('images.destroy', $path) }}" method="POST">
                @csrf
                @method('DELETE')
                <a href="{{ route('images.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-danger float-right">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection