@extends('layouts.app')

@section('title', 'LakeAutos - Quality Used Cars at Affordable Prices')

@section('content')
    {{-- Hero Banner --}}
    <section class="hero-banner">
        <div class="container position-relative" style="z-index: 1;">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="animate-in">Quality Used Cars<br>at <span style="color: var(--accent);">Affordable Prices</span></h1>
                    <p class="mt-3 animate-in animate-delay-1">Browse our handpicked selection of reliable, pre-owned vehicles. Every car is inspected and ready for the road.</p>
                    <a href="#inventory" class="btn btn-hero mt-3 animate-in animate-delay-2">
                        <i class="bi bi-grid-3x3-gap-fill me-2"></i>View Inventory
                    </a>
                </div>
                <div class="col-lg-5 d-none d-lg-block text-center">
                    <div style="font-size: 8rem; opacity: 0.15; color: white;">
                        <i class="bi bi-car-front-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Bar --}}
    <section class="py-4" style="background: #fff; border-bottom: 1px solid var(--border);">
        <div class="container">
            <div class="row text-center g-3">
                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <i class="bi bi-shield-check fs-2 text-primary"></i>
                        <div class="text-start">
                            <div class="fw-bold">Inspected Vehicles</div>
                            <small class="text-muted">Every car quality checked</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <i class="bi bi-currency-dollar fs-2 text-primary"></i>
                        <div class="text-start">
                            <div class="fw-bold">Best Prices</div>
                            <small class="text-muted">Competitive market rates</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <i class="bi bi-headset fs-2 text-primary"></i>
                        <div class="text-start">
                            <div class="fw-bold">Full Support</div>
                            <small class="text-muted">From inquiry to purchase</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Car Grid --}}
    <section id="inventory" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Our Inventory</h2>
                <p class="text-muted">Browse {{ $vehicles->count() }} available vehicles</p>
            </div>

            @if($vehicles->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-car-front fs-1 text-muted"></i>
                    <p class="text-muted mt-3">No vehicles available at the moment. Check back soon!</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach($vehicles as $vehicle)
                    <div class="col-md-6 col-lg-4">
                        <div class="car-card">
                            <div class="card-img-wrapper">
                                @if($vehicle->primaryImage)
                                    <img src="{{ asset($vehicle->primaryImage->image_path) }}" alt="{{ $vehicle->full_title }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                        <i class="bi bi-car-front fs-1 text-muted"></i>
                                    </div>
                                @endif
                                <span class="status-badge {{ $vehicle->status }}">{{ $vehicle->status }}</span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $vehicle->full_title }}</h5>
                                <div class="car-price">{{ $vehicle->formatted_price }}</div>
                                <div class="car-meta">
                                    <span><i class="bi bi-speedometer2"></i> {{ $vehicle->formatted_mileage }}</span>
                                    <span><i class="bi bi-calendar3"></i> {{ $vehicle->year }}</span>
                                </div>
                                <a href="{{ route('vehicles.show', $vehicle) }}" class="btn-view">
                                    <i class="bi bi-eye me-1"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
