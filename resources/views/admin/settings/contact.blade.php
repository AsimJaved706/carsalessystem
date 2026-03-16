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

                <form action="{{ route('admin.settings.contact.update') }}" method="POST" enctype="multipart/form-data">
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
                            <h6 class="fw-bold mb-3"><i class="bi bi-image me-2"></i>Branding</h6>
                        </div>

                        <div class="col-12">
                            <label for="site_logo" class="form-label fw-semibold">Website Logo</label>
                            <input type="file" class="form-control @error('site_logo') is-invalid @enderror"
                                   id="site_logo" name="site_logo" accept="image/*">
                            <small class="text-muted">Recommended PNG with transparent background. Max 5MB.</small>
                            @error('site_logo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label for="site_banner" class="form-label fw-semibold">Homepage Banner Image</label>
                            <input type="file" class="form-control @error('site_banner') is-invalid @enderror"
                                   id="site_banner" name="site_banner" accept="image/*">
                            <small class="text-muted">Recommended 1920x700 (or wider) image. Max 10MB.</small>
                            @error('site_banner')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <div class="p-3 rounded-3" style="background: #0a0a0a; border: 1px solid #2a2a2a;">
                                <small class="text-uppercase d-block mb-2" style="color: #666; font-size: 0.7rem; letter-spacing: 1px;">Current Logo</small>
                                <img src="{{ asset($settings['site_logo'] ?? 'images/logo.png') }}" alt="Current Logo" style="max-height: 72px; width: auto;">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="p-3 rounded-3" style="background: #0a0a0a; border: 1px solid #2a2a2a;">
                                <small class="text-uppercase d-block mb-2" style="color: #666; font-size: 0.7rem; letter-spacing: 1px;">Current Banner</small>
                                <img src="{{ asset($settings['site_banner'] ?? 'images/hero-banner.png') }}" alt="Current Banner" style="max-height: 110px; width: auto; max-width: 100%; border-radius: 8px;">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="header_logo_height" class="form-label fw-semibold">Header Logo Height (px)</label>
                            <input type="number" class="form-control @error('header_logo_height') is-invalid @enderror"
                                   id="header_logo_height" name="header_logo_height" min="30" max="140"
                                   value="{{ $settings['header_logo_height'] ?? 55 }}">
                            <small class="text-muted">Used in top navbar.</small>
                            @error('header_logo_height')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="banner_logo_width" class="form-label fw-semibold">Banner Logo Width (px)</label>
                            <input type="number" class="form-control @error('banner_logo_width') is-invalid @enderror"
                                   id="banner_logo_width" name="banner_logo_width" min="120" max="700"
                                   value="{{ $settings['banner_logo_width'] ?? 380 }}">
                            <small class="text-muted">Used in homepage hero banner.</small>
                            @error('banner_logo_width')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

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
