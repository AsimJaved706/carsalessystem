<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LakeAutos - Quality Used Cars at Affordable Prices. Browse our inventory of pre-owned vehicles.">
    <title>@yield('title', 'LakeAutos - Quality Used Cars')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0f172a;
            --primary-light: #1e293b;
            --accent: #3b82f6;
            --accent-hover: #2563eb;
            --accent-glow: rgba(59, 130, 246, 0.3);
            --success: #10b981;
            --gold: #f59e0b;
            --surface: #f8fafc;
            --text: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --card-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1);
            --card-shadow-hover: 0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background: var(--surface);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Navbar ── */
        .navbar-custom {
            background: var(--primary);
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(20px);
        }
        .navbar-custom .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: #fff;
            letter-spacing: -0.5px;
        }
        .navbar-custom .navbar-brand span {
            color: var(--accent);
        }
        .navbar-custom .nav-link {
            color: rgba(255,255,255,0.75);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.08);
        }

        /* ── Hero Banner ── */
        .hero-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
        }
        .hero-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, var(--accent-glow) 0%, transparent 70%);
            border-radius: 50%;
        }
        .hero-banner::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(16,185,129,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        .hero-banner h1 {
            font-size: 3.2rem;
            font-weight: 900;
            color: #fff;
            line-height: 1.1;
            letter-spacing: -1px;
        }
        .hero-banner p {
            color: rgba(255,255,255,0.7);
            font-size: 1.2rem;
            max-width: 500px;
        }
        .hero-banner .btn-hero {
            background: var(--accent);
            color: #fff;
            padding: 0.85rem 2.2rem;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            font-size: 1rem;
            transition: all 0.3s;
            box-shadow: 0 4px 15px var(--accent-glow);
        }
        .hero-banner .btn-hero:hover {
            background: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--accent-glow);
        }

        /* ── Car Cards ── */
        .section-title {
            font-weight: 800;
            font-size: 2rem;
            letter-spacing: -0.5px;
            color: var(--text);
        }
        .car-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border);
            box-shadow: var(--card-shadow);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .car-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--card-shadow-hover);
            border-color: var(--accent);
        }
        .car-card .card-img-wrapper {
            aspect-ratio: 16 / 10;
            overflow: hidden;
            position: relative;
            background: #e2e8f0;
        }
        .car-card .card-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s;
        }
        .car-card:hover .card-img-wrapper img {
            transform: scale(1.05);
        }
        .car-card .status-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: var(--success);
            color: #fff;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .car-card .status-badge.sold {
            background: #ef4444;
        }
        .car-card .card-body {
            padding: 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .car-card .card-title {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: var(--text);
        }
        .car-card .car-price {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--accent);
            margin-bottom: 0.5rem;
        }
        .car-card .car-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }
        .car-card .car-meta i {
            margin-right: 4px;
        }
        .car-card .btn-view {
            margin-top: auto;
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            text-align: center;
            text-decoration: none;
        }
        .car-card .btn-view:hover {
            background: var(--accent);
            color: #fff;
        }

        /* ── Vehicle Detail ── */
        .vehicle-gallery {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
        }
        .vehicle-gallery .main-image {
            width: 100%;
            aspect-ratio: 16/10;
            object-fit: cover;
            border-radius: 16px;
        }
        .vehicle-gallery .thumbnails {
            display: flex;
            gap: 0.75rem;
            margin-top: 0.75rem;
        }
        .vehicle-gallery .thumb {
            width: 100px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.2s;
            opacity: 0.7;
        }
        .vehicle-gallery .thumb:hover,
        .vehicle-gallery .thumb.active {
            border-color: var(--accent);
            opacity: 1;
        }
        .detail-info {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid var(--border);
            box-shadow: var(--card-shadow);
        }
        .detail-info .vehicle-title {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }
        .detail-info .vehicle-price {
            font-size: 2rem;
            font-weight: 800;
            color: var(--accent);
        }
        .detail-specs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin: 1.5rem 0;
        }
        .detail-specs .spec-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: var(--surface);
            border-radius: 10px;
        }
        .detail-specs .spec-item i {
            font-size: 1.2rem;
            color: var(--accent);
        }
        .detail-specs .spec-label {
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        .detail-specs .spec-value {
            font-weight: 600;
        }

        /* ── Inquiry Form ── */
        .inquiry-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid var(--border);
            box-shadow: var(--card-shadow);
        }
        .inquiry-card h3 {
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid var(--border);
            padding: 0.7rem 1rem;
            transition: all 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }
        .btn-submit {
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
            width: 100%;
        }
        .btn-submit:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px var(--accent-glow);
            color: #fff;
        }

        /* ── Footer ── */
        .footer {
            background: var(--primary);
            color: rgba(255,255,255,0.7);
            padding: 3rem 0 1.5rem;
            margin-top: auto;
        }
        .footer h5 {
            font-weight: 700;
            color: #fff;
            margin-bottom: 1rem;
        }
        .footer a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer a:hover {
            color: var(--accent);
        }
        .footer .footer-brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
        }
        .footer .footer-brand span {
            color: var(--accent);
        }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 1.5rem;
            margin-top: 2rem;
            font-size: 0.85rem;
        }

        /* ── Contact Page ── */
        .contact-info-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid var(--border);
            box-shadow: var(--card-shadow);
            text-align: center;
            transition: all 0.3s;
        }
        .contact-info-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }
        .contact-info-card i {
            font-size: 2.5rem;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        /* ── Alert Styles ── */
        .alert-custom {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
        }

        /* ── Animations ── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-in {
            animation: fadeInUp 0.5s ease forwards;
        }
        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
    </style>
    @yield('styles')
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-car-front-fill me-2"></i>Lake<span>Autos</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list text-white fs-4"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house-fill me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                            <i class="bi bi-telephone-fill me-1"></i> Contact
                        </a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Admin
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container mt-3">
        <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="footer-brand mb-3">
                        <i class="bi bi-car-front-fill me-2"></i>Lake<span>Autos</span>
                    </div>
                    <p>Your trusted source for quality used cars at affordable prices. We offer a wide selection of pre-owned vehicles.</p>
                </div>
                <div class="col-lg-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}"><i class="bi bi-chevron-right me-1"></i> Home</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}"><i class="bi bi-chevron-right me-1"></i> Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5>Contact Info</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i> XXX-XXX-XXXX</li>
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i> info@lakeautos.com</li>
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> Your Address Here</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom text-center">
                <p class="mb-0">&copy; {{ date('Y') }} LakeAutos. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
