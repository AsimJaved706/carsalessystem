@extends('admin.layouts.app')

@section('page-title', 'Edit: ' . $vehicle->full_title)

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.vehicles.update', $vehicle) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="make" class="form-label fw-semibold">Make <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('make') is-invalid @enderror"
                           id="make" name="make" value="{{ old('make', $vehicle->make) }}" required>
                    @error('make')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="model" class="form-label fw-semibold">Model <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('model') is-invalid @enderror"
                           id="model" name="model" value="{{ old('model', $vehicle->model) }}" required>
                    @error('model')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="year" class="form-label fw-semibold">Year <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('year') is-invalid @enderror"
                           id="year" name="year" value="{{ old('year', $vehicle->year) }}" required min="1900" max="{{ date('Y') + 1 }}">
                    @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="price" class="form-label fw-semibold">Price ($) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                           id="price" name="price" value="{{ old('price', $vehicle->price) }}" required min="0" step="0.01">
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="mileage" class="form-label fw-semibold">Mileage <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('mileage') is-invalid @enderror"
                           id="mileage" name="mileage" value="{{ old('mileage', $vehicle->mileage) }}" required min="0">
                    @error('mileage')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="vin" class="form-label fw-semibold">VIN</label>
                    <input type="text" class="form-control @error('vin') is-invalid @enderror"
                           id="vin" name="vin" value="{{ old('vin', $vehicle->vin) }}" maxlength="17">
                    @error('vin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="available" {{ old('status', $vehicle->status) === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="sold" {{ old('status', $vehicle->status) === 'sold' ? 'selected' : '' }}>Sold</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description" name="description" rows="4">{{ old('description', $vehicle->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Existing Images --}}
                @if($vehicle->images->isNotEmpty())
                <div class="col-12">
                    <label class="form-label fw-semibold">Current Images</label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach($vehicle->images as $image)
                        <div class="position-relative" style="width: 120px;">
                            <img src="{{ asset($image->image_path) }}" alt="" class="rounded-3 w-100" style="height: 80px; object-fit: cover;">
                            <div class="form-check mt-1">
                                <input class="form-check-input" type="checkbox" name="delete_images[]" value="{{ $image->id }}" id="del_{{ $image->id }}">
                                <label class="form-check-label text-danger" for="del_{{ $image->id }}" style="font-size: 0.75rem;">Delete</label>
                            </div>
                            @if($image->is_primary)
                                <span class="badge bg-primary" style="font-size: 0.65rem; position: absolute; top: 4px; left: 4px;">Primary</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="col-12">
                    <label for="images" class="form-label fw-semibold">Add More Images</label>
                    <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                           id="images" name="images[]" multiple accept="image/*">
                    @error('images.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <hr>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-check-lg me-1"></i> Update Vehicle
                        </button>
                        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
