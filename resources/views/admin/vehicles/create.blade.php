@extends('admin.layouts.app')

@section('page-title', 'Add Vehicle')

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Basic Information --}}
            <h6 class="fw-bold mb-3 text-white"><i class="bi bi-car-front me-2"></i>Basic Information</h6>
            <div class="row g-3 mb-4">
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
                    <label for="body_type" class="form-label fw-semibold">Body Type</label>
                    <select class="form-select @error('body_type') is-invalid @enderror" id="body_type" name="body_type">
                        <option value="">Select Body Type</option>
                        @foreach($options['body_type'] ?? [] as $key => $label)
                            <option value="{{ $key }}" {{ old('body_type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('body_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="condition" class="form-label fw-semibold">Condition</label>
                    <select class="form-select @error('condition') is-invalid @enderror" id="condition" name="condition">
                        <option value="new" {{ old('condition') === 'new' ? 'selected' : '' }}>New</option>
                        <option value="used" {{ old('condition', 'used') === 'used' ? 'selected' : '' }}>Used</option>
                        <option value="certified" {{ old('condition') === 'certified' ? 'selected' : '' }}>Certified Pre-Owned</option>
                    </select>
                    @error('condition')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="sold" {{ old('status') === 'sold' ? 'selected' : '' }}>Sold</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Pricing & Mileage --}}
            <h6 class="fw-bold mb-3 text-white"><i class="bi bi-currency-dollar me-2"></i>Pricing & Mileage</h6>
            <div class="row g-3 mb-4">
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
            </div>

            {{-- Technical Details --}}
            <h6 class="fw-bold mb-3 text-white"><i class="bi bi-gear me-2"></i>Technical Details</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <label for="transmission" class="form-label fw-semibold">Transmission</label>
                    <select class="form-select @error('transmission') is-invalid @enderror" id="transmission" name="transmission">
                        <option value="">Select</option>
                        @foreach($options['transmission'] ?? [] as $key => $label)
                            <option value="{{ $key }}" {{ old('transmission') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('transmission')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label for="fuel_type" class="form-label fw-semibold">Fuel Type</label>
                    <select class="form-select @error('fuel_type') is-invalid @enderror" id="fuel_type" name="fuel_type">
                        <option value="">Select</option>
                        @foreach($options['fuel_type'] ?? [] as $key => $label)
                            <option value="{{ $key }}" {{ old('fuel_type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('fuel_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label for="drivetrain" class="form-label fw-semibold">Drivetrain</label>
                    <select class="form-select @error('drivetrain') is-invalid @enderror" id="drivetrain" name="drivetrain">
                        <option value="">Select</option>
                        @foreach($options['drivetrain'] ?? [] as $key => $label)
                            <option value="{{ $key }}" {{ old('drivetrain') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('drivetrain')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label for="engine" class="form-label fw-semibold">Engine</label>
                    <input type="text" class="form-control @error('engine') is-invalid @enderror"
                           id="engine" name="engine" value="{{ old('engine') }}" placeholder="e.g. 2.5L 4-Cylinder">
                    @error('engine')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Appearance --}}
            <h6 class="fw-bold mb-3 text-white"><i class="bi bi-palette me-2"></i>Appearance</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label for="exterior_color" class="form-label fw-semibold">Exterior Color</label>
                    <input type="text" class="form-control @error('exterior_color') is-invalid @enderror"
                           id="exterior_color" name="exterior_color" value="{{ old('exterior_color') }}" placeholder="e.g. White">
                    @error('exterior_color')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="interior_color" class="form-label fw-semibold">Interior Color</label>
                    <input type="text" class="form-control @error('interior_color') is-invalid @enderror"
                           id="interior_color" name="interior_color" value="{{ old('interior_color') }}" placeholder="e.g. Black">
                    @error('interior_color')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="seating_capacity" class="form-label fw-semibold">Seating Capacity</label>
                    <input type="number" class="form-control @error('seating_capacity') is-invalid @enderror"
                           id="seating_capacity" name="seating_capacity" value="{{ old('seating_capacity') }}" min="1" max="15" placeholder="5">
                    @error('seating_capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Features --}}
            <h6 class="fw-bold mb-3 text-white"><i class="bi bi-check2-square me-2"></i>Features</h6>
            <div class="row g-2 mb-4">
                @foreach($options['feature'] ?? [] as $key => $label)
                    <div class="col-md-3 col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="features[]" 
                                   value="{{ $key }}" id="feature_{{ $key }}"
                                   {{ in_array($key, old('features', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="feature_{{ $key }}">{{ $label }}</label>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Description --}}
            <h6 class="fw-bold mb-3 text-white"><i class="bi bi-text-paragraph me-2"></i>Description</h6>
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description" name="description" rows="4" placeholder="Vehicle description...">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Images --}}
            <h6 class="fw-bold mb-3 text-white"><i class="bi bi-images me-2"></i>Images</h6>
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                           id="images" name="images[]" multiple accept="image/*">
                    <small class="text-muted">Upload multiple images. First image will be the primary photo.</small>
                    @error('images.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-plus-lg me-1"></i> Add Vehicle
                </button>
                <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
            </div>
        </form>
    </div>
@endsection
