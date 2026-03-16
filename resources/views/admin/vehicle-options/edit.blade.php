@extends('admin.layouts.app')

@section('title', 'Edit Vehicle Option')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Edit Vehicle Option</h4>
        <p class="text-muted mb-0">Update {{ $option->label }}</p>
    </div>
    <a href="{{ route('admin.vehicle-options.index', ['type' => $option->type]) }}" class="btn btn-outline-light">
        <i class="bi bi-arrow-left"></i> Back to Options
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger" style="background: #4a1a1a; border-color: #6a2a2a; color: #ff7f7f;">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-card">
    <form action="{{ route('admin.vehicle-options.update', $option) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Option Type <span class="text-danger">*</span></label>
                <select name="type" class="form-select" required>
                    @foreach($types as $typeKey => $typeLabel)
                        <option value="{{ $typeKey }}" {{ $option->type === $typeKey ? 'selected' : '' }}>
                            {{ $typeLabel }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">Which category does this option belong to?</small>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $option->sort_order) }}" min="0">
                <small class="text-muted">Lower numbers appear first</small>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Key <span class="text-danger">*</span></label>
                <input type="text" name="key" class="form-control" value="{{ old('key', $option->key) }}" required 
                       pattern="[a-z0-9_]+" title="Lowercase letters, numbers, and underscores only"
                       placeholder="e.g., heated_seats">
                <small class="text-muted">Internal identifier (lowercase, underscores, no spaces)</small>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Display Label <span class="text-danger">*</span></label>
                <input type="text" name="label" class="form-control" value="{{ old('label', $option->label) }}" required
                       placeholder="e.g., Heated Seats">
                <small class="text-muted">What users will see in dropdowns</small>
            </div>
        </div>

        <div class="mb-4">
            <div class="form-check">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" 
                       {{ $option->is_active ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">
                    Active <small class="text-muted">(Show in dropdowns)</small>
                </label>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-light">
                <i class="bi bi-check-lg"></i> Update Option
            </button>
            <a href="{{ route('admin.vehicle-options.index', ['type' => $option->type]) }}" class="btn btn-outline-light">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
