<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Lake Auto Sales & Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0a0a0a;
            --sidebar-w: 260px;
            --accent: #ffffff;
            --accent-hover: #ffffff;
        }
        * { box-sizing: border-box; }
        
        /* Override Bootstrap's text-muted for dark theme */
        .text-muted {
            color: #aaa !important;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #111111;
            min-height: 100vh;
            color: #e5e5e5;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--sidebar-bg);
            padding: 1.5rem 0;
            overflow-y: auto;
            z-index: 1000;
            border-right: 1px solid #2a2a2a;
        }
        .sidebar .brand {
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            text-align: center;
        }
        .sidebar .brand img {
            height: 50px;
            width: auto;
        }
        .sidebar .nav-section {
            padding: 1rem 0.75rem;
        }
        .sidebar .nav-section-label {
            color: rgba(255,255,255,0.35);
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 0 0.75rem;
            margin-bottom: 0.5rem;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.65);
            padding: 0.6rem 0.75rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s;
            margin-bottom: 2px;
        }
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }
        .sidebar .nav-link.active {
            background: #ffffff;
            color: #0a0a0a;
        }
        .sidebar .nav-link .badge {
            margin-left: auto;
            font-size: 0.7rem;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
        }
        .top-bar {
            background: #1a1a1a;
            padding: 1rem 2rem;
            border-bottom: 1px solid #2a2a2a;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .top-bar h4 { font-weight: 700; margin: 0; color: #fff; }
        .content-area { padding: 2rem; }

        /* Stats Cards */
        .stat-card {
            background: #1a1a1a;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #2a2a2a;
            transition: all 0.2s;
        }
        .stat-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            transform: translateY(-2px);
            border-color: #c0c0c0;
        }
        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        .stat-card .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            line-height: 1;
            color: #fff;
        }
        .stat-card .stat-label {
            font-size: 0.85rem;
            color: #888;
        }

        /* Table */
        .table-card {
            background: #1a1a1a;
            border-radius: 12px;
            border: 1px solid #2a2a2a;
            overflow: hidden;
        }
        .table-card .table { margin: 0; color: #e5e5e5; background: transparent; }
        .table-card .table th {
            background: #0a0a0a;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #888;
            border-bottom: 1px solid #2a2a2a;
            padding: 0.75rem 1rem;
        }
        .table-card .table td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
            border-color: #2a2a2a;
            background: #1a1a1a;
            color: #e5e5e5;
        }
        .table-card .table tbody tr {
            background: #1a1a1a;
        }
        .table-card .table tbody tr:hover {
            background: #252525;
        }
        .table-card .table .text-muted {
            color: #aaa !important;
        }

        .form-card {
            background: #1a1a1a;
            border-radius: 12px;
            padding: 2rem;
            border: 1px solid #2a2a2a;
        }
        .form-control, .form-select {
            border-radius: 8px;
            background: #0a0a0a;
            border: 1px solid #2a2a2a;
            color: #e5e5e5;
        }
        .form-control:focus, .form-select:focus {
            border-color: #c0c0c0;
            box-shadow: 0 0 0 3px rgba(192,192,192,0.15);
            background: #0a0a0a;
            color: #e5e5e5;
        }
        .form-control::placeholder {
            color: #888;
        }
        .form-label {
            color: #e5e5e5;
        }

        .btn-action {
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="brand">
            <img src="{{ asset('images/logo.png') }}" alt="Lake Auto Sales & Services">
        </div>

        <div class="nav-section">
            <div class="nav-section-label">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-label">Inventory</div>
            <a href="{{ route('admin.vehicles.index') }}" class="nav-link {{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}">
                <i class="bi bi-car-front"></i> Vehicles
            </a>
            <a href="{{ route('admin.vehicles.create') }}" class="nav-link">
                <i class="bi bi-plus-circle"></i> Add Vehicle
            </a>
            <a href="{{ route('admin.vehicle-options.index') }}" class="nav-link {{ request()->routeIs('admin.vehicle-options.*') ? 'active' : '' }}">
                <i class="bi bi-sliders"></i> Vehicle Options
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-label">Customer</div>
            <a href="{{ route('admin.inquiries.index') }}" class="nav-link {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
                <i class="bi bi-chat-dots"></i> Inquiries
                @php $unread = \App\Models\Inquiry::where('is_read', false)->count(); @endphp
                @if($unread > 0)
                    <span class="badge bg-danger">{{ $unread }}</span>
                @endif
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-label">Settings</div>
            <a href="{{ route('admin.settings.smtp') }}" class="nav-link {{ request()->routeIs('admin.settings.smtp*') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i> Email / SMTP
            </a>
            <a href="{{ route('admin.settings.contact') }}" class="nav-link {{ request()->routeIs('admin.settings.contact*') ? 'active' : '' }}">
                <i class="bi bi-geo-alt"></i> Contact Info
            </a>
        </div>

        <div class="nav-section mt-auto" style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1rem;">
            <a href="{{ route('home') }}" class="nav-link">
                <i class="bi bi-box-arrow-up-right"></i> View Site
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link w-100 border-0 bg-transparent text-start">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="main-content">
        <div class="top-bar">
            <h4>@yield('page-title', 'Dashboard')</h4>
            <span class="text-muted">{{ Auth::user()->name }}</span>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="content-area pb-0">
            <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        @endif

        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
