@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => isset($avEquipment) ? 'Edit AV Equipment' : 'Add AV Equipment'])

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST"
                            action="{{ isset($avEquipment) ? route('av_equipments.update', $avEquipment->id) : route('av_equipments.store') }}">
                            @csrf
                            @if(isset($avEquipment))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', $avEquipment->title ?? '') }}" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Type</label>
                                    <input type="text" name="type" class="form-control"
                                        value="{{ old('type', $avEquipment->type ?? '') }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Brand</label>
                                    <input type="text" name="brand" class="form-control"
                                        value="{{ old('brand', $avEquipment->brand ?? '') }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Model</label>
                                    <input type="text" name="model" class="form-control"
                                        value="{{ old('model', $avEquipment->model ?? '') }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="quantity" class="form-control"
                                        value="{{ old('quantity', $avEquipment->quantity ?? 1) }}" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Length (ft)</label>
                                    <input type="number" step="0.01" name="length" class="form-control"
                                        value="{{ old('length', $avEquipment->length ?? '') }}">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Width (ft)</label>
                                    <input type="number" step="0.01" name="width" class="form-control"
                                        value="{{ old('width', $avEquipment->width ?? '') }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Service</label>
                                    <select name="service_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ old('service_id', $avEquipment->service_id ?? '') == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Status</label>
                                    <select name="is_active" class="form-control">
                                        <option value="1" {{ (old('is_active', $avEquipment->is_active ?? 1) == 1) ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ (old('is_active', $avEquipment->is_active ?? 1) == 0) ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control">{{ old('description', $avEquipment->description ?? '') }}</textarea>
                                </div>

                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($avEquipment) ? 'Update' : 'Save' }}
                                    </button>
                                    <a href="{{ route('av_equipments.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
