@extends('admin.layouts.app')

@section('title', 'Vehicle Options')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Vehicle Options</h4>
        <p class="text-muted mb-0">Manage dropdown options for vehicles (body types, features, etc.)</p>
    </div>
    <div class="d-flex gap-2">
        <form action="{{ route('admin.vehicle-options.seed-defaults') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-light" onclick="return confirm('This will add missing default options. Continue?')">
                <i class="bi bi-arrow-repeat"></i> Seed Defaults
            </button>
        </form>
        <a href="{{ route('admin.vehicle-options.create', ['type' => $currentType]) }}" class="btn btn-light">
            <i class="bi bi-plus-lg"></i> Add Option
        </a>
    </div>
</div>

{{-- Type Tabs --}}
<div class="table-card mb-4">
    <div class="d-flex flex-wrap gap-2 p-3 border-bottom" style="border-color: #2a2a2a !important;">
        @foreach($types as $typeKey => $typeLabel)
            <a href="{{ route('admin.vehicle-options.index', ['type' => $typeKey]) }}" 
               class="btn btn-sm {{ $currentType === $typeKey ? 'btn-light' : 'btn-outline-light' }}">
                {{ $typeLabel }}
                <span class="badge {{ $currentType === $typeKey ? 'bg-dark' : 'bg-secondary' }} ms-1">
                    {{ \App\Models\VehicleOption::where('type', $typeKey)->count() }}
                </span>
            </a>
        @endforeach
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: #1a4a1a; border-color: #2a6a2a; color: #7fff7f;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter: invert(1);"></button>
    </div>
@endif

<div class="table-card">
    <table class="table">
        <thead>
            <tr>
                <th style="width: 60px;">Order</th>
                <th>Key</th>
                <th>Display Label</th>
                <th style="width: 100px;">Status</th>
                <th style="width: 150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($options as $option)
                <tr>
                    <td>{{ $option->sort_order }}</td>
                    <td><code style="color: #aaa; background: #0a0a0a; padding: 2px 6px; border-radius: 4px;">{{ $option->key }}</code></td>
                    <td>{{ $option->label }}</td>
                    <td>
                        @if($option->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.vehicle-options.edit', $option) }}" class="btn btn-sm btn-outline-light">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.vehicle-options.destroy', $option) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this option?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        No options found for this type. 
                        <a href="{{ route('admin.vehicle-options.create', ['type' => $currentType]) }}" class="text-light">Add one</a> or 
                        <form action="{{ route('admin.vehicle-options.seed-defaults') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 text-light" style="vertical-align: baseline;">seed defaults</button>
                        </form>.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
