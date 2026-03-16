@extends('layouts.app')

@section('title', 'Lake Auto Sales & Services - Quality Used Cars at Affordable Prices')

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
            </div>
        </div>
    </section>

    {{-- Stats Bar --}}
    <section class="py-4 stats-bar">
        <div class="container">
            <div class="row text-center g-3">
                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <i class="bi bi-shield-check fs-2 stat-icon"></i>
                        <div class="text-start">
                            <div class="fw-bold">Inspected Vehicles</div>
                            <small class="text-muted">Every car quality checked</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <i class="bi bi-currency-dollar fs-2 stat-icon"></i>
                        <div class="text-start">
                            <div class="fw-bold">Best Prices</div>
                            <small class="text-muted">Competitive market rates</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <i class="bi bi-headset fs-2 stat-icon"></i>
                        <div class="text-start">
                            <div class="fw-bold">Full Support</div>
                            <small class="text-muted">From inquiry to purchase</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Browse by Style --}}
    <section class="py-5" style="background: var(--surface-card);">
        <div class="container">
            <h3 class="section-title mb-4">Browse by Style</h3>
            <div class="row g-3">
                @php
                    $styleIcons = [
                        'suv' => 'bi-truck-front',
                        'sedan' => 'bi-car-front',
                        'truck' => 'bi-truck',
                        'van' => 'bi-bus-front',
                        'hatchback' => 'bi-car-front-fill',
                        'coupe' => 'bi-speedometer',
                    ];
                @endphp
                @foreach($bodyTypes as $key => $label)
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('home', ['body_type' => $key]) }}" 
                           class="style-card {{ ($filters['body_type'] ?? '') === $key ? 'active' : '' }}">
                            <i class="bi {{ $styleIcons[$key] ?? 'bi-car-front' }} style-icon"></i>
                            <span class="style-label">{{ $label }}</span>
                            @if(isset($bodyTypeCounts[$key]))
                                <span class="style-count">{{ $bodyTypeCounts[$key] }}</span>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Browse by Make --}}
    @if(count($makes) > 0)
    <section class="py-5">
        <div class="container">
            <h3 class="section-title mb-4">Browse by Make</h3>
            <div class="row g-2">
                @foreach($makes as $make)
                    <div class="col-6 col-md-3 col-lg-2">
                        <a href="{{ route('home', ['make' => $make]) }}" 
                           class="make-link {{ ($filters['make'] ?? '') === $make ? 'active' : '' }}">
                            {{ $make }}
                            @if(isset($makeCounts[$make]))
                                <span class="make-count">({{ $makeCounts[$make] }})</span>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Car Grid with Filters --}}
    <section id="inventory" class="py-5" style="background: var(--surface);">
        <div class="container">
            <div class="row">
                {{-- Sidebar Filters --}}
                <div class="col-lg-3 mb-4">
                    <div class="filter-sidebar">
                        <div class="filter-header">
                            <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filters</h5>
                            @if(count(array_filter($filters)) > 0)
                                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light">Clear All</a>
                            @endif
                        </div>

                        <form method="GET" action="{{ route('home') }}" id="filterForm">
                            {{-- Active Filters --}}
                            @if(count(array_filter($filters)) > 0)
                                <div class="filter-section">
                                    <div class="active-filters">
                                        @foreach($filters as $key => $value)
                                            @if($value)
                                                <span class="filter-tag">
                                                    {{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}
                                                    <a href="{{ route('home', array_merge($filters, [$key => null])) }}">
                                                        <i class="bi bi-x"></i>
                                                    </a>
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Price Range --}}
                            <div class="filter-section">
                                <div class="filter-title" data-bs-toggle="collapse" data-bs-target="#priceFilter">
                                    <span>Price Range</span>
                                    <i class="bi bi-chevron-down"></i>
                                </div>
                                <div class="collapse show" id="priceFilter">
                                    <div class="filter-content">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <label class="form-label small">Min</label>
                                                <input type="number" class="form-control form-control-sm" 
                                                       name="min_price" value="{{ $filters['min_price'] ?? '' }}"
                                                       placeholder="${{ number_format($priceRange['min']) }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label small">Max</label>
                                                <input type="number" class="form-control form-control-sm" 
                                                       name="max_price" value="{{ $filters['max_price'] ?? '' }}"
                                                       placeholder="${{ number_format($priceRange['max']) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Year Range --}}
                            <div class="filter-section">
                                <div class="filter-title" data-bs-toggle="collapse" data-bs-target="#yearFilter">
                                    <span>Year</span>
                                    <i class="bi bi-chevron-down"></i>
                                </div>
                                <div class="collapse show" id="yearFilter">
                                    <div class="filter-content">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <label class="form-label small">From</label>
                                                <input type="number" class="form-control form-control-sm" 
                                                       name="min_year" value="{{ $filters['min_year'] ?? '' }}"
                                                       placeholder="{{ $yearRange['min'] }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label small">To</label>
                                                <input type="number" class="form-control form-control-sm" 
                                                       name="max_year" value="{{ $filters['max_year'] ?? '' }}"
                                                       placeholder="{{ $yearRange['max'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Mileage --}}
                            <div class="filter-section">
                                <div class="filter-title" data-bs-toggle="collapse" data-bs-target="#mileageFilter">
                                    <span>Mileage</span>
                                    <i class="bi bi-chevron-down"></i>
                                </div>
                                <div class="collapse" id="mileageFilter">
                                    <div class="filter-content">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <label class="form-label small">Min</label>
                                                <input type="number" class="form-control form-control-sm" 
                                                       name="min_mileage" value="{{ $filters['min_mileage'] ?? '' }}"
                                                       placeholder="0">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label small">Max</label>
                                                <input type="number" class="form-control form-control-sm" 
                                                       name="max_mileage" value="{{ $filters['max_mileage'] ?? '' }}"
                                                       placeholder="200,000">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Body Type --}}
                            <div class="filter-section">
                                <div class="filter-title" data-bs-toggle="collapse" data-bs-target="#bodyTypeFilter">
                                    <span>Body Style</span>
                                    <i class="bi bi-chevron-down"></i>
                                </div>
                                <div class="collapse" id="bodyTypeFilter">
                                    <div class="filter-content">
                                        <select class="form-select form-select-sm" name="body_type">
                                            <option value="">All Body Types</option>
                                            @foreach($bodyTypes as $key => $label)
                                                <option value="{{ $key }}" {{ ($filters['body_type'] ?? '') === $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Transmission --}}
                            <div class="filter-section">
                                <div class="filter-title" data-bs-toggle="collapse" data-bs-target="#transFilter">
                                    <span>Transmission</span>
                                    <i class="bi bi-chevron-down"></i>
                                </div>
                                <div class="collapse" id="transFilter">
                                    <div class="filter-content">
                                        <select class="form-select form-select-sm" name="transmission">
                                            <option value="">All</option>
                                            @foreach($transmissions as $key => $label)
                                                <option value="{{ $key }}" {{ ($filters['transmission'] ?? '') === $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Fuel Type --}}
                            <div class="filter-section">
                                <div class="filter-title" data-bs-toggle="collapse" data-bs-target="#fuelFilter">
                                    <span>Fuel Type</span>
                                    <i class="bi bi-chevron-down"></i>
                                </div>
                                <div class="collapse" id="fuelFilter">
                                    <div class="filter-content">
                                        <select class="form-select form-select-sm" name="fuel_type">
                                            <option value="">All</option>
                                            @foreach($fuelTypes as $key => $label)
                                                <option value="{{ $key }}" {{ ($filters['fuel_type'] ?? '') === $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Drivetrain --}}
                            <div class="filter-section">
                                <div class="filter-title" data-bs-toggle="collapse" data-bs-target="#driveFilter">
                                    <span>Drivetrain</span>
                                    <i class="bi bi-chevron-down"></i>
                                </div>
                                <div class="collapse" id="driveFilter">
                                    <div class="filter-content">
                                        <select class="form-select form-select-sm" name="drivetrain">
                                            <option value="">All</option>
                                            @foreach($drivetrains as $key => $label)
                                                <option value="{{ $key }}" {{ ($filters['drivetrain'] ?? '') === $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-3 rounded-pill">
                                <i class="bi bi-search me-1"></i> Apply Filters
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Vehicle Grid --}}
                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="mb-1">Our Inventory</h4>
                            <p class="text-muted mb-0">{{ $vehicles->count() }} vehicles found</p>
                        </div>
                    </div>

                    @if($vehicles->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-car-front fs-1 text-muted"></i>
                            <p class="text-muted mt-3">No vehicles match your filters. Try adjusting your search criteria.</p>
                            <a href="{{ route('home') }}" class="btn btn-outline-light">Clear Filters</a>
                        </div>
                    @else
                        <div class="row g-4">
                            @foreach($vehicles as $vehicle)
                            <div class="col-md-6 col-xl-4">
                                <div class="car-card">
                                    <div class="card-img-wrapper">
                                        @php
                                            $orderedImages = $vehicle->images->sortByDesc('is_primary')->values();
                                            $carouselId = 'vehicleCarousel' . $vehicle->id;
                                        @endphp
                                        @if($orderedImages->isNotEmpty())
                                            @if($orderedImages->count() > 1)
                                                <div id="{{ $carouselId }}" class="carousel slide vehicle-carousel" data-bs-interval="false">
                                                    <div class="carousel-inner">
                                                        @foreach($orderedImages as $index => $image)
                                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                                <img src="{{ asset($image->image_path) }}" alt="{{ $vehicle->full_title }} - Image {{ $index + 1 }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="prev" aria-label="Previous image">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="next" aria-label="Next image">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                            @else
                                                <img src="{{ asset($orderedImages->first()->image_path) }}" alt="{{ $vehicle->full_title }}">
                                            @endif
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100" style="background: #222;">
                                                <i class="bi bi-car-front fs-1 text-muted"></i>
                                            </div>
                                        @endif
                                        <span class="status-badge {{ $vehicle->status }}">{{ $vehicle->status }}</span>
                                        @if($vehicle->body_type)
                                            <span class="body-type-badge">{{ $vehicle->body_type_label }}</span>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $vehicle->full_title }}</h5>
                                        <div class="car-price">{{ $vehicle->formatted_price }}</div>
                                        <div class="car-meta">
                                            <span><i class="bi bi-speedometer2"></i> {{ $vehicle->formatted_mileage }}</span>
                                            @if($vehicle->transmission)
                                                <span><i class="bi bi-gear"></i> {{ $vehicle->transmission_label }}</span>
                                            @endif
                                            @if($vehicle->fuel_type)
                                                <span><i class="bi bi-fuel-pump"></i> {{ $vehicle->fuel_type_label }}</span>
                                            @endif
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
            </div>
        </div>
    </section>
@endsection

@section('styles')
<style>
    /* Browse by Style */
    .style-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.5rem 1rem;
        background: var(--surface);
        border-radius: 12px;
        border: 1px solid var(--border);
        text-decoration: none;
        color: var(--text);
        transition: all 0.3s ease;
    }
    .style-card:hover, .style-card.active {
        background: var(--primary-light);
        border-color: var(--accent);
        transform: translateY(-2px);
    }
    .style-icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        opacity: 0.8;
    }
    .style-label {
        font-weight: 600;
        font-size: 0.9rem;
    }
    .style-count {
        font-size: 0.75rem;
        color: #888;
        margin-top: 0.25rem;
    }

    /* Browse by Make */
    .make-link {
        display: block;
        padding: 0.75rem 1rem;
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
        border-radius: 6px;
    }
    .make-link:hover, .make-link.active {
        background: rgba(59, 130, 246, 0.1);
        color: #60a5fa;
    }
    .make-count {
        color: #888;
        font-weight: 400;
    }

    /* Filter Sidebar */
    .filter-sidebar {
        background: var(--surface-card);
        border-radius: 12px;
        border: 1px solid var(--border);
        overflow: hidden;
        position: sticky;
        top: 100px;
    }
    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.25rem;
        background: var(--primary-light);
        border-bottom: 1px solid var(--border);
    }
    .filter-section {
        border-bottom: 1px solid var(--border);
    }
    .filter-section:last-of-type {
        border-bottom: none;
    }
    .filter-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.875rem 1.25rem;
        cursor: pointer;
        font-weight: 500;
        transition: background 0.2s;
    }
    .filter-title:hover {
        background: rgba(255,255,255,0.03);
    }
    .filter-content {
        padding: 0 1.25rem 1rem;
    }
    .active-filters {
        padding: 0.75rem 1.25rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .filter-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        background: rgba(59, 130, 246, 0.2);
        border-radius: 20px;
        font-size: 0.8rem;
        color: #60a5fa;
    }
    .filter-tag a {
        color: #60a5fa;
        text-decoration: none;
    }
    .filter-tag a:hover {
        color: #fff;
    }

    /* Body Type Badge */
    .body-type-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0,0,0,0.7);
        color: #fff;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .vehicle-carousel,
    .vehicle-carousel .carousel-inner,
    .vehicle-carousel .carousel-item {
        height: 100%;
    }

    .vehicle-carousel .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .vehicle-carousel .carousel-control-prev,
    .vehicle-carousel .carousel-control-next {
        width: 34px;
        height: 34px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.55);
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .vehicle-carousel .carousel-control-prev {
        left: 10px;
    }

    .vehicle-carousel .carousel-control-next {
        right: 10px;
    }

    .card-img-wrapper:hover .vehicle-carousel .carousel-control-prev,
    .card-img-wrapper:hover .vehicle-carousel .carousel-control-next {
        opacity: 1;
    }

    .vehicle-carousel .carousel-control-prev-icon,
    .vehicle-carousel .carousel-control-next-icon {
        width: 0.85rem;
        height: 0.85rem;
    }

    @media (max-width: 991.98px) {
        .vehicle-carousel .carousel-control-prev,
        .vehicle-carousel .carousel-control-next {
            opacity: 1;
        }
    }
</style>
@endsection
