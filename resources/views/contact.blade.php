@extends('layouts.app')

@section('title', 'Contact Us - Lake Auto Sales & Services')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="section-title">Contact Us</h1>
            <p style="color: #ccc;">Get in touch with our team</p>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="contact-info-card">
                    <i class="bi bi-telephone-fill d-block"></i>
                    <h5 class="fw-bold">Phone</h5>
                    <p class="mb-0" style="color: #ccc;">{{ $contact['phone'] }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-info-card">
                    <i class="bi bi-envelope-fill d-block"></i>
                    <h5 class="fw-bold">Email</h5>
                    <p class="mb-0" style="color: #ccc;">{{ $contact['email'] }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-info-card">
                    <i class="bi bi-geo-alt-fill d-block"></i>
                    <h5 class="fw-bold">Address</h5>
                    <p class="mb-0" style="color: #ccc;">{{ $contact['address'] }}</p>
                </div>
            </div>
        </div>

        @if($contact['hours'])
        <div class="row mt-4 justify-content-center">
            <div class="col-md-6 text-center">
                <div class="contact-info-card">
                    <i class="bi bi-clock-fill d-block"></i>
                    <h5 class="fw-bold">Business Hours</h5>
                    <p class="mb-0" style="color: #ccc;">{{ $contact['hours'] }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($contact['facebook'] || $contact['instagram'])
        <div class="row mt-4 justify-content-center">
            <div class="col-md-6 text-center">
                <h5 class="fw-bold mb-3">Follow Us</h5>
                <div class="d-flex gap-3 justify-content-center">
                    @if($contact['facebook'])
                    <a href="{{ $contact['facebook'] }}" target="_blank" class="btn btn-outline-light rounded-circle" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-facebook fs-4"></i>
                    </a>
                    @endif
                    @if($contact['instagram'])
                    <a href="{{ $contact['instagram'] }}" target="_blank" class="btn btn-outline-light rounded-circle" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-instagram fs-4"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <div class="row mt-5 justify-content-center">
            <div class="col-lg-8">
                <div class="inquiry-card">
                    <h3><i class="bi bi-chat-dots me-2"></i>Send us a message</h3>
                    <p style="color: #ccc;">Have questions? We'd love to hear from you.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
