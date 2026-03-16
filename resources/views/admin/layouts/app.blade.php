<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - LakeAutos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --sidebar-w: 260px;
            --accent: #3b82f6;
            --accent-hover: #2563eb;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
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
        }
        .sidebar .brand {
            color: #fff;
            font-weight: 800;
            font-size: 1.3rem;
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar .brand span { color: var(--accent); }
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
            background: var(--accent);
            color: #fff;
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
            background: #fff;
            padding: 1rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .top-bar h4 { font-weight: 700; margin: 0; }
        .content-area { padding: 2rem; }

        /* Stats Cards */
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
        }
        .stat-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transform: translateY(-2px);
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
        }
        .stat-card .stat-label {
            font-size: 0.85rem;
            color: #64748b;
        }

        /* Table */
        .table-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        .table-card .table { margin: 0; }
        .table-card .table th {
            background: #f8fafc;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 1rem;
        }
        .table-card .table td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
        }

        .form-card {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            border: 1px solid #e2e8f0;
        }
        .form-control, .form-select, .form-control:focus, .form-select:focus {
            border-radius: 8px;
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
            <i class="bi bi-car-front-fill me-2"></i>Lake<span>Autos</span>
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
