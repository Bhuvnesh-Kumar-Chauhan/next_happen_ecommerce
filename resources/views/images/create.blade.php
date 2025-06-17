@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Upload New Image</h1>
    
    <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Upload</button>
        <a href="{{ route('images.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection