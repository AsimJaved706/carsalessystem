@extends('layouts.app')

@section('title', $vehicle->full_title . ' - Lake Auto Sales & Services')

@section('content')
<section class="py-5">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active">{{ $vehicle->full_title }}</li>
            </ol>
        </nav>

        <div class="row g-4">
            {{-- Image Gallery --}}
            <div class="col-lg-7">
                <div class="vehicle-gallery">
                    @if($vehicle->images->isNotEmpty())
                        @php
                            $orderedImages = $vehicle->images->sortByDesc('is_primary')->values();
                        @endphp

                        <div class="main-image-wrap">
                            <img src="{{ asset($orderedImages->first()->image_path) }}"
                                 alt="{{ $vehicle->full_title }}"
                                 class="main-image"
                                 id="mainImage">

                            @if($orderedImages->count() > 1)
                                <button type="button" class="gallery-nav prev" id="galleryPrev" aria-label="Previous image">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button type="button" class="gallery-nav next" id="galleryNext" aria-label="Next image">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            @endif
                        </div>

                        @if($orderedImages->count() > 1)
                        <div class="thumbnails">
                            @foreach($orderedImages as $index => $image)
                            <img src="{{ asset($image->image_path) }}"
                                 alt="Photo {{ $index + 1 }}"
                                 class="thumb {{ $index === 0 ? 'active' : '' }}"
                                 data-index="{{ $index }}"
                                 onclick="changeImageByIndex({{ $index }})">
                            @endforeach
                        </div>
                        @endif
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light rounded-4" style="aspect-ratio: 16/10;">
                            <i class="bi bi-car-front" style="font-size: 4rem; color: #ccc;"></i>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Vehicle Info --}}
            <div class="col-lg-5">
                <div class="detail-info">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <h1 class="vehicle-title">{{ $vehicle->full_title }}</h1>
                            <div class="vehicle-price">{{ $vehicle->formatted_price }}</div>
                        </div>
                        <span class="badge rounded-pill {{ $vehicle->status === 'sold' ? 'bg-danger' : 'bg-success' }} fs-6">
                            {{ ucfirst($vehicle->status) }}
                        </span>
                    </div>

                    <div class="detail-specs">
                        <div class="spec-item">
                            <i class="bi bi-speedometer2"></i>
                            <div>
                                <div class="spec-label">Mileage</div>
                                <div class="spec-value">{{ $vehicle->formatted_mileage }}</div>
                            </div>
                        </div>
                        <div class="spec-item">
                            <i class="bi bi-calendar3"></i>
                            <div>
                                <div class="spec-label">Year</div>
                                <div class="spec-value">{{ $vehicle->year }}</div>
                            </div>
                        </div>
                        <div class="spec-item">
                            <i class="bi bi-car-front"></i>
                            <div>
                                <div class="spec-label">Make</div>
                                <div class="spec-value">{{ $vehicle->make }}</div>
                            </div>
                        </div>
                        @if($vehicle->vin)
                        <div class="spec-item">
                            <i class="bi bi-upc-scan"></i>
                            <div>
                                <div class="spec-label">VIN</div>
                                <div class="spec-value" style="font-size: 0.75rem;">{{ $vehicle->vin }}</div>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($vehicle->description)
                    <div class="mt-3">
                        <h6 class="fw-bold text-muted text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Description</h6>
                        <p class="mb-0">{{ $vehicle->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Inquiry Form --}}
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto">
                <div class="inquiry-card">
                    <h3><i class="bi bi-chat-dots me-2"></i>Interested in this vehicle?</h3>
                    <p class="text-muted mb-4">Fill out the form below and we'll get back to you as soon as possible.</p>

                    <form action="{{ route('inquiries.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Your Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" required placeholder="John Doe">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}" required placeholder="john@example.com">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}" placeholder="(555) 123-4567">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('message') is-invalid @enderror"
                                          id="message" name="message" rows="4" required
                                          placeholder="I'm interested in this {{ $vehicle->full_title }}. Please contact me with more details.">{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-submit">
                                    <i class="bi bi-send me-2"></i>Send Inquiry
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    const galleryImages = @json($vehicle->images->sortByDesc('is_primary')->values()->pluck('image_path')->toArray());
    let currentImageIndex = 0;

    function updateGalleryImage(index) {
        if (!galleryImages.length) {
            return;
        }

        if (index < 0) {
            index = galleryImages.length - 1;
        }

        if (index >= galleryImages.length) {
            index = 0;
        }

        currentImageIndex = index;

        const mainImage = document.getElementById('mainImage');
        if (mainImage) {
            mainImage.src = `{{ asset('') }}${galleryImages[currentImageIndex]}`;
        }

        document.querySelectorAll('.thumb').forEach((thumb, idx) => {
            thumb.classList.toggle('active', idx === currentImageIndex);
        });
    }

    function changeImageByIndex(index) {
        updateGalleryImage(index);
    }

    function showPrevImage() {
        updateGalleryImage(currentImageIndex - 1);
    }

    function showNextImage() {
        updateGalleryImage(currentImageIndex + 1);
    }

    (function bindGalleryControls() {
        const prevBtn = document.getElementById('galleryPrev');
        const nextBtn = document.getElementById('galleryNext');
        const mainImage = document.getElementById('mainImage');

        if (prevBtn) {
            prevBtn.addEventListener('click', showPrevImage);
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', showNextImage);
        }

        if (mainImage && galleryImages.length > 1) {
            let startX = 0;
            let endX = 0;

            mainImage.addEventListener('touchstart', function (event) {
                startX = event.changedTouches[0].clientX;
            }, { passive: true });

            mainImage.addEventListener('touchend', function (event) {
                endX = event.changedTouches[0].clientX;
                const delta = endX - startX;
                const threshold = 40;

                if (Math.abs(delta) < threshold) {
                    return;
                }

                if (delta > 0) {
                    showPrevImage();
                } else {
                    showNextImage();
                }
            }, { passive: true });
        }
    })();
</script>
@endsection
