@extends('admin.layouts.app')

@section('page-title', 'Add Vehicle')

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="make" class="form-label fw-semibold">Make <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('make') is-invalid @enderror"
                           id="make" name="make" value="{{ old('make') }}" required placeholder="e.g. Toyota">
                    @error('make')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="model" class="form-label fw-semibold">Model <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('model') is-invalid @enderror"
                           id="model" name="model" value="{{ old('model') }}" required placeholder="e.g. Corolla">
                    @error('model')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="year" class="form-label fw-semibold">Year <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('year') is-invalid @enderror"
                           id="year" name="year" value="{{ old('year', date('Y')) }}" required min="1900" max="{{ date('Y') + 1 }}">
                    @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="price" class="form-label fw-semibold">Price ($) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                           id="price" name="price" value="{{ old('price') }}" required min="0" step="0.01" placeholder="12500">
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="mileage" class="form-label fw-semibold">Mileage <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('mileage') is-invalid @enderror"
                           id="mileage" name="mileage" value="{{ old('mileage') }}" required min="0" placeholder="45000">
                    @error('mileage')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="vin" class="form-label fw-semibold">VIN</label>
                    <input type="text" class="form-control @error('vin') is-invalid @enderror"
                           id="vin" name="vin" value="{{ old('vin') }}" maxlength="17" placeholder="Optional">
                    @error('vin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="sold" {{ old('status') === 'sold' ? 'selected' : '' }}>Sold</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description" name="description" rows="4" placeholder="Vehicle description...">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label for="images" class="form-label fw-semibold">Vehicle Images</label>
                    <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                           id="images" name="images[]" multiple accept="image/*">
                    <small class="text-muted">Upload multiple images. First image will be the primary photo.</small>
                    @error('images.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <hr>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-plus-lg me-1"></i> Add Vehicle
                        </button>
                        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
