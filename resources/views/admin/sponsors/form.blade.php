<div class="card">
    <div class="card-body">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $sponsor->name ?? '') }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $sponsor->email ?? '') }}" class="form-control">
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $sponsor->phone ?? '') }}" class="form-control">
        </div>
        <div class="form-group">
            <label>Company</label>
            <input type="text" name="company_name" value="{{ old('company_name', $sponsor->company_name ?? '') }}" class="form-control">
        </div>
        <div class="form-group">
            <label>Website</label>
            <input type="url" name="website" value="{{ old('website', $sponsor->website ?? '') }}" class="form-control">
        </div>
        <div class="form-group">
            <label>Interest Area</label>
            <input type="text" name="interest_area" value="{{ old('interest_area', $sponsor->interest_area ?? '') }}" class="form-control">
        </div>
        <div class="form-group">
            <label>About</label>
            <textarea name="about" class="form-control">{{ old('about', $sponsor->about ?? '') }}</textarea>
        </div>
        <div class="form-group">
            <label>Logo</label>
            <input type="file" name="logo" class="form-control-file">
            @if(isset($sponsor) && $sponsor->logo)
                <img src="{{ asset('storage/' . $sponsor->logo) }}" height="50" class="mt-2">
            @endif
        </div>
    </div>
</div>
