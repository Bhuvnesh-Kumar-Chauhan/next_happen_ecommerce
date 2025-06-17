@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Image</h1>
    
    <div class="card mb-3">
        <img src="{{ $url }}" class="card-img-top mb-3" alt="Current Image">
        <div class="card-body">
            <form action="{{ route('images.update', $path) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="image">Replace with new image</label>
                    <input type="file" class="form-control-file" id="image" name="image" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('images.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection