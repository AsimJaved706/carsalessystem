@extends('admin.layouts.app')

@section('page-title', 'Dashboard')

@section('content')
    {{-- Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4 col-lg">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-car-front"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['total_vehicles'] }}</div>
                        <div class="stat-label">Total Vehicles</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['available_vehicles'] }}</div>
                        <div class="stat-label">Available</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-tag"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['sold_vehicles'] }}</div>
                        <div class="stat-label">Sold</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-chat-dots"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['total_inquiries'] }}</div>
                        <div class="stat-label">Total Inquiries</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['unread_inquiries'] }}</div>
                        <div class="stat-label">Unread</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Inquiries --}}
    <div class="table-card">
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="fw-bold mb-0">Recent Inquiries</h6>
            <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">View All</a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Vehicle</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentInquiries as $inquiry)
                    <tr>
                        <td class="fw-semibold">{{ $inquiry->name }}</td>
                        <td>{{ $inquiry->vehicle->full_title ?? 'N/A' }}</td>
                        <td>{{ $inquiry->email }}</td>
                        <td>{{ $inquiry->created_at->diffForHumans() }}</td>
                        <td>
                            @if($inquiry->is_read)
                                <span class="badge bg-secondary rounded-pill">Read</span>
                            @else
                                <span class="badge bg-warning rounded-pill">New</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No inquiries yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
