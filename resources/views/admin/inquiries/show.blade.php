@extends('admin.layouts.app')

@section('page-title', 'Inquiry Details')

@section('content')
    <div class="form-card">
        <div class="d-flex align-items-start justify-content-between mb-4">
            <div>
                <h5 class="fw-bold mb-1">{{ $inquiry->name }}</h5>
                <p class="text-muted mb-0">
                    <i class="bi bi-envelope me-1"></i> {{ $inquiry->email }}
                    @if($inquiry->phone)
                        <span class="ms-3"><i class="bi bi-telephone me-1"></i> {{ $inquiry->phone }}</span>
                    @endif
                </p>
            </div>
            <span class="badge bg-{{ $inquiry->is_read ? 'secondary' : 'warning' }} rounded-pill">
                {{ $inquiry->is_read ? 'Read' : 'New' }}
            </span>
        </div>

        <div class="p-3 rounded-3 mb-4" style="background: #1a1a1a; border: 1px solid #2a2a2a;">
            <small class="d-block mb-1" style="color: #888;">Vehicle</small>
            <strong class="text-white">{{ $inquiry->vehicle->full_title ?? 'N/A' }}</strong>
            @if($inquiry->vehicle)
                <span class="ms-2 text-primary">{{ $inquiry->vehicle->formatted_price }}</span>
            @endif
        </div>

        <div class="mb-4">
            <small class="d-block mb-1" style="color: #888;">Message</small>
            <p class="mb-0 text-white">{{ $inquiry->message }}</p>
        </div>

        <div style="font-size: 0.85rem; color: #aaa;">
            <i class="bi bi-clock me-1"></i> Received {{ $inquiry->created_at->format('M d, Y \a\t h:i A') }}
        </div>

        <hr>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
            <a href="mailto:{{ $inquiry->email }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-reply me-1"></i> Reply via Email
            </a>
            <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" class="ms-auto"
                  onsubmit="return confirm('Delete this inquiry?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>
@endsection
