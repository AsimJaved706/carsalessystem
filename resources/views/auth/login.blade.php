<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Lake Auto Sales & Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 40%, #2a2a2a 60%, #0a0a0a 100%);
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -15%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            border-radius: 50%;
        }
        body::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.04) 0%, transparent 70%);
            border-radius: 50%;
        }
        .login-card {
            background: rgba(26,26,26,0.97);
            border: 1px solid #2a2a2a;
            border-radius: 20px;
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.5);
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
        }
        .login-brand {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-brand img {
            height: 80px;
            width: auto;
            margin-bottom: 0.75rem;
        }
        .login-brand p {
            color: #888;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #c0c0c0;
        }
        .form-control {
            border-radius: 10px;
            border: 1.5px solid #2a2a2a;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.2s;
            background: #0a0a0a;
            color: #e5e5e5;
        }
        .form-control:focus {
            border-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.15);
            background: #0a0a0a;
            color: #e5e5e5;
        }
        .form-control::placeholder {
            color: #666;
        }
        .btn-login {
            background: #ffffff;
            color: #0a0a0a;
            border: none;
            padding: 0.75rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background: #e0e0e0;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(255,255,255,0.2);
            color: #0a0a0a;
        }
        .form-check-label {
            font-size: 0.85rem;
            color: #888;
        }
        .form-check-input {
            background-color: #0a0a0a;
            border-color: #2a2a2a;
        }
        .form-check-input:checked {
            background-color: #ffffff;
            border-color: #ffffff;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #888;
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.2s;
        }
        .back-link:hover {
            color: #c0c0c0;
        }
        .input-icon {
            position: relative;
        }
        .input-icon i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 1rem;
        }
        .input-icon .form-control {
            padding-left: 2.5rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Lake Auto Sales & Services">
            <p>Admin Panel Login</p>
        </div>

        @if(session('status'))
            <div class="alert alert-success rounded-3 mb-3" style="font-size: 0.85rem;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-icon">
                    <i class="bi bi-envelope"></i>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="admin@lakeautosales.com">
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-icon">
                    <i class="bi bi-lock"></i>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password" required placeholder="••••••••">
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
            </button>
        </form>

        <a href="{{ route('home') }}" class="back-link">
            <i class="bi bi-arrow-left me-1"></i> Back to website
        </a>
    </div>
</body>
</html>
