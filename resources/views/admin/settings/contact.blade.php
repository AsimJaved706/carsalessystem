@extends('admin.layouts.app')

@section('page-title', 'Contact Information')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="form-card">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-building me-2"></i>Business Information
                </h5>
                <p class="text-muted mb-4">Update your contact details. This information will be displayed on your website and email notifications.</p>

                <form action="{{ route('admin.settings.contact.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="contact_phone" class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="text" class="form-control @error('contact_phone') is-invalid @enderror"
                                       id="contact_phone" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" required
                                       placeholder="219-252-9183">
                            </div>
                            @error('contact_phone')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="contact_email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control @error('contact_email') is-invalid @enderror"
                                       id="contact_email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" required
                                       placeholder="info@lakeautosales.com">
                            </div>
                            @error('contact_email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label for="contact_address" class="form-label fw-semibold">Business Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" class="form-control @error('contact_address') is-invalid @enderror"
                                       id="contact_address" name="contact_address" value="{{ $settings['contact_address'] ?? '' }}" required
                                       placeholder="2746 Dekalb St, Lake Station IN 46505">
                            </div>
                            @error('contact_address')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label for="contact_hours" class="form-label fw-semibold">Business Hours</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                <input type="text" class="form-control @error('contact_hours') is-invalid @enderror"
                                       id="contact_hours" name="contact_hours" value="{{ $settings['contact_hours'] ?? '' }}"
                                       placeholder="Mon-Sat: 9AM-6PM, Sun: Closed">
                            </div>
                            @error('contact_hours')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12"><hr class="my-2"></div>

                        <div class="col-12">
                            <h6 class="fw-bold mb-3"><i class="bi bi-share me-2"></i>Social Media Links</h6>
                        </div>

                        <div class="col-md-6">
                            <label for="social_facebook" class="form-label fw-semibold">Facebook Page URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-facebook"></i></span>
                                <input type="url" class="form-control @error('social_facebook') is-invalid @enderror"
                                       id="social_facebook" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}"
                                       placeholder="https://facebook.com/lakeautosales">
                            </div>
                            @error('social_facebook')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="social_instagram" class="form-label fw-semibold">Instagram Page URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-instagram"></i></span>
                                <input type="url" class="form-control @error('social_instagram') is-invalid @enderror"
                                       id="social_instagram" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}"
                                       placeholder="https://instagram.com/lakeautosales">
                            </div>
                            @error('social_instagram')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <hr>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-check-lg me-1"></i> Save Information
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-card">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-eye me-2"></i>Preview
                </h5>
                <p class="text-muted mb-4">How your contact info appears on the website:</p>

                <div class="p-3 rounded-3" style="background: #0a0a0a;">
                    <div class="mb-3">
                        <small class="text-uppercase" style="color: #666; font-size: 0.7rem; letter-spacing: 1px;">Phone</small>
                        <div class="text-white">
                            <i class="bi bi-telephone me-2"></i>{{ $settings['contact_phone'] ?? '219-252-9183' }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-uppercase" style="color: #666; font-size: 0.7rem; letter-spacing: 1px;">Email</small>
                        <div class="text-white">
                            <i class="bi bi-envelope me-2"></i>{{ $settings['contact_email'] ?? 'Not set' }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-uppercase" style="color: #666; font-size: 0.7rem; letter-spacing: 1px;">Address</small>
                        <div class="text-white">
                            <i class="bi bi-geo-alt me-2"></i>{{ $settings['contact_address'] ?? '2746 Dekalb St, Lake Station IN 46505' }}
                        </div>
                    </div>
                    @if(!empty($settings['contact_hours']))
                    <div>
                        <small class="text-uppercase" style="color: #666; font-size: 0.7rem; letter-spacing: 1px;">Hours</small>
                        <div class="text-white">
                            <i class="bi bi-clock me-2"></i>{{ $settings['contact_hours'] }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
