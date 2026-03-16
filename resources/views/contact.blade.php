@extends('layouts.app')

@section('title', 'Contact Us - LakeAutos')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="section-title">Contact Us</h1>
            <p class="text-muted">Get in touch with our team</p>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="contact-info-card">
                    <i class="bi bi-telephone-fill d-block"></i>
                    <h5 class="fw-bold">Phone</h5>
                    <p class="text-muted mb-0">XXX-XXX-XXXX</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-info-card">
                    <i class="bi bi-envelope-fill d-block"></i>
                    <h5 class="fw-bold">Email</h5>
                    <p class="text-muted mb-0">info@lakeautos.com</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-info-card">
                    <i class="bi bi-geo-alt-fill d-block"></i>
                    <h5 class="fw-bold">Address</h5>
                    <p class="text-muted mb-0">Your Address Here</p>
                </div>
            </div>
        </div>

        <div class="row mt-5 justify-content-center">
            <div class="col-lg-8">
                <div class="inquiry-card">
                    <h3><i class="bi bi-chat-dots me-2"></i>Send us a message</h3>
                    <p class="text-muted">Have questions? We'd love to hear from you.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
