@extends('admin.layouts.app')

@section('page-title', 'Vehicles')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <p class="text-muted mb-0">{{ $vehicles->total() }} vehicles total</p>
        <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary rounded-pill">
            <i class="bi bi-plus-lg me-1"></i> Add Vehicle
        </a>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Vehicle</th>
                        <th>Year</th>
                        <th>Price</th>
                        <th>Mileage</th>
                        <th>Status</th>
                        <th>Inquiries</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicles as $vehicle)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @if($vehicle->primaryImage)
                                    <img src="{{ asset($vehicle->primaryImage->image_path) }}"
                                         alt="" style="width: 60px; height: 40px; object-fit: cover; border-radius: 6px;">
                                @else
                                    <div style="width: 60px; height: 40px; background: #e2e8f0; border-radius: 6px;"
                                         class="d-flex align-items-center justify-content-center">
                                        <i class="bi bi-car-front text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold">{{ $vehicle->make }} {{ $vehicle->model }}</div>
                                    @if($vehicle->vin)
                                    <small class="text-muted">{{ $vehicle->vin }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $vehicle->year }}</td>
                        <td class="fw-bold">{{ $vehicle->formatted_price }}</td>
                        <td>{{ $vehicle->formatted_mileage }}</td>
                        <td>
                            <span class="badge rounded-pill {{ $vehicle->status === 'sold' ? 'bg-danger' : 'bg-success' }}">
                                {{ ucfirst($vehicle->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-secondary rounded-pill">{{ $vehicle->inquiries_count }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn btn-sm btn-outline-primary btn-action">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.vehicles.toggle-status', $vehicle) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-{{ $vehicle->status === 'available' ? 'warning' : 'success' }} btn-action"
                                            title="{{ $vehicle->status === 'available' ? 'Mark Sold' : 'Mark Available' }}">
                                        <i class="bi bi-{{ $vehicle->status === 'available' ? 'tag' : 'check-circle' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this vehicle?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-action">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No vehicles yet. Add your first vehicle!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-center">
        {{ $vehicles->links() }}
    </div>
@endsection
