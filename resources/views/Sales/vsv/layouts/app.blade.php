<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Suzuki Dealer Dashboard')</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/img/suzuki-icon.jpeg') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('assets/img/suzuki-icon.jpeg') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #001f3f 0%, #003d7a 100%);
            overflow-x: hidden;
        }

        /* Layout */
        .layout {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #002855 0%, #001840 100%);
            color: #1e293b; font-weight:800;
            padding: 0;
            position: sticky; 
            top: 0;
            height: 100vh; 
            overflow-y: auto; 
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.5);
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #0066cc, #00a8ff, #0066cc);
        }

        .logo {
            background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
            padding: 30px 25px;
            text-align: center;
            border-bottom: 2px solid rgba(255, 255, 255, 0.15);
            position: relative;
            overflow: hidden;
        }

        .logo::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        }

        .logo-icon {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 900;
            margin-bottom: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            color: #0066cc;
            letter-spacing: -1px;
            position: relative;
            z-index: 1;
        }

        .logo h2 {
            font-size: 26px;
            font-weight: 800;
            color: #1e293b; font-weight:800;
            letter-spacing: 2px;
            position: relative;
            z-index: 1;
        }

        .logo-tagline {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.8);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 8px;
        }

        .menu-section {
            padding: 25px 20px;
        }

        .menu-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #6b8caf;
            margin: 25px 0 12px 15px;
            font-weight: 700;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 18px;
            margin-bottom: 8px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 15px;
            color: #a8c5e6;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .sidebar a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(180deg, #0066cc, #00a8ff);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .sidebar a:hover {
            background: rgba(0, 102, 204, 0.15);
            color: #ffffff;
            transform: translateX(5px);
        }

        .sidebar a:hover::before {
            transform: scaleY(1);
        }

        .sidebar a.active {
            background: linear-gradient(135deg, rgba(0, 102, 204, 0.3) 0%, rgba(0, 82, 163, 0.3) 100%);
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);
        }

        .sidebar a.active::before {
            transform: scaleY(1);
        }

        .menu-icon {
            font-size: 22px;
            width: 26px;
            text-align: center;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        /* Content */
        .content {
            flex: 1;
            background: linear-gradient(135deg, #001428 0%, #002855 100%);
            position: relative;
        }

        .content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: repeating-linear-gradient(90deg, transparent, transparent 2px, rgba(0, 102, 204, 0.03) 2px, rgba(0, 102, 204, 0.03) 4px), repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0, 102, 204, 0.03) 2px, rgba(0, 102, 204, 0.03) 4px);
            pointer-events: none;
        }

        .header {
            background: rgba(0, 40, 85, 0.7);
            backdrop-filter: blur(15px);
            border-bottom: 2px solid rgba(0, 102, 204, 0.3);
            padding: 30px 40px;
            position: sticky;
            top: 0;
            z-index: 10;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 34px;
            background: linear-gradient(135deg, #ffffff 0%, #b3d9ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .header-badge {
            background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
            color: #1e293b; font-weight:800;
            padding: 0 5px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: bold;
            box-shadow: 0 4px 12px rgba(0, 102, 204, 0.4);
        }

        .header p {
            font-size: 15px;
            color: #64748b;
        }

        .main-content {
            padding: 40px;
            position: relative;
            z-index: 1;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
            animation: fadeInUp 0.6s ease;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(10px);
            border-radius: 18px;
            padding: 28px;
            border: 1px solid rgba(0, 102, 204, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #0066cc, #00a8ff, #0066cc);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(0, 102, 204, 0.1) 0%, transparent 70%);
            transition: opacity 0.4s ease;
            opacity: 0;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 102, 204, 0.3);
            border-color: rgba(0, 168, 255, 0.4);
            background: rgba(255, 255, 255, 0.08);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-card:hover::after {
            opacity: 1;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 18px;
            box-shadow: 0 8px 20px rgba(0, 102, 204, 0.4);
            position: relative;
            z-index: 1;
        }

        .stat-label {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .stat-value {
            font-size: 32px;
            color: #ffffff;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .stat-trend {
            margin-top: 10px;
            font-size: 13px;
            color: #4ade80;
            font-weight: 600;
        }

        /* Welcome Card */
        .welcome-card {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 45px;
            border: 1px solid rgba(0, 102, 204, 0.2);
            max-width: 900px;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.6s ease 0.2s backwards;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -20%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(0, 102, 204, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .welcome-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
        }

        .welcome-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            box-shadow: 0 8px 20px rgba(0, 102, 204, 0.4);
        }

        .welcome-card h3 {
            font-size: 28px;
            color: #ffffff;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        .welcome-card p {
            font-size: 16px;
            color: #64748b;
            line-height: 1.8;
            position: relative;
            z-index: 1;
        }

        .welcome-card b {
            color: #00a8ff;
            font-weight: 700;
        }

        /* Quick Actions */
        .quick-actions {
            margin-top: 45px;
            position: relative;
            z-index: 1;
        }

        .quick-actions h3 {
            font-size: 22px;
            color: #ffffff;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px 22px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(0, 102, 204, 0.2);
            border-radius: 16px;
            text-decoration: none;
            color: #ffffff;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 15px;
            font-weight: 600;
            position: relative;
            overflow: hidden;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 168, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .action-btn:hover::before {
            left: 100%;
        }

        .action-btn:hover {
            background: rgba(0, 102, 204, 0.15);
            border-color: rgba(0, 168, 255, 0.4);
            transform: translateX(8px);
            box-shadow: 0 8px 20px rgba(0, 102, 204, 0.3);
        }

        .action-btn-icon {
            font-size: 26px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 240px;
            }
        }

        @media (max-width: 768px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .sidebar::before {
                width: 100%;
                height: 4px;
            }

            .header h1 {
                font-size: 26px;
            }

            .main-content {
                padding: 25px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .welcome-card {
                padding: 30px;
            }

            .activity-page {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(12px);
                border-radius: 20px;
                padding: 25px;
                border: 1px solid rgba(0, 168, 255, 0.25);
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.35);
                margin-top: 20px;
            }

            /* WADAH PUTIH (Seperti yang kamu mau) */
            .table-container {
                background-color: #1e293b; font-weight:800;
                border-radius: 15px;
                padding: 10px;
                margin-top: 15px;
                overflow: hidden;
            }

            .table-responsive {
                width: 100%;
                overflow-x: auto;
                border-radius: 10px;
            }

            /* STYLE TABEL IDENTIK ACTIVITY */
            .custom-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 12px;
                color: #003366;
                background-color: #1e293b; font-weight:800;
            }

            .custom-table thead th {
                background-color: #f8faff;
                color: #0056b3;
                text-align: center;
                font-weight: bold;
                padding: 12px 8px;
                border: 1px solid #dee2e6;
                white-space: nowrap;
            }

            .custom-table tbody td {
                padding: 10px 8px;
                border: 1px solid #eef2f7;
                color: #333;
                vertical-align: middle;
            }

            /* FOOTER BIRU TUA */
            .grand-total {
                background-color: #003366 !important;
                color: white !important;
            }

            .grand-total td {
                color: white !important;
                font-weight: bold;
                text-transform: uppercase;
            }

            /* TOMBOL AKSI MINIMALIS */
            .btn-action {
                text-decoration: none;
                font-weight: bold;
                font-size: 11px;
                padding: 2px 5px;
            }
        }
    
        /* Global Form Fixes */
        *, *::before, *::after {
            box-sizing: border-box !important;
        }
        input, select, textarea, button {
            box-sizing: border-box !important;
            max-width: 100% !important;
        }
        div {
            box-sizing: border-box;
        }
        .form-card-container {
            width: 100% !important;
            max-width: 1000px !important;
            box-sizing: border-box !important;
            padding: 35px !important;
            overflow: hidden !important;
        }
            select, input, textarea {
            min-width: 0 !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }
        .form-card-container, form {
            box-sizing: border-box !important;
            max-width: 100% !important;
        }
    </style>
</head>

<body>
    <div class="layout">
        <div class="sidebar">
            <div class="logo" style="text-align: center; padding: 20px 0;">
                <img src="{{ asset('assets/img/suzuki-icon.jpeg') }}" alt="Suzuki Logo"
                    style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; background-color: #1e293b; font-weight:800; box-shadow: 0 4px 8px rgba(0,0,0,0.2); border: 3px solid #fff;">
                <h2 style="color: #1e293b; font-weight:800; margin: 0; font-size: 24px; font-weight: 800; letter-spacing: 1px;">SUZUKI</h2>
                <div class="logo-tagline" style="color: rgba(255,255,255,0.7); font-size: 14px;">Dealer Management</div>
            </div>
            <div class="menu-section">
                <div class="menu-label">Main Menu</div>
                <a href="{{ url('dashboard/v1') }}" class="{{ request()->is('dashboard') || request()->is('dashboard/v1') ? 'active' : '' }}">
                    <span class="menu-icon">🏠</span> <span>Dashboard V1</span>
                </a>
                <a href="{{ url('dashboard/v2') }}" class="{{ request()->is('dashboard/v2') ? 'active' : '' }}">
                    <span class="menu-icon">📈</span> <span>Dashboard V2</span>
                </a>
                <a href="{{ url('rka/dashboard') }}">
                    <span class="menu-icon">📊</span> <span>RKA</span>
                </a>
                <a href="{{ url('current/dashboard') }}">
                    <span class="menu-icon">📊</span> <span>Current</span>
                </a>
                <a href="{{ url('leasing/dashboard') }}">
                    <span class="menu-icon">📊</span> <span>Leasing</span>
                </a>
                <div class="menu-label">Performance</div>
                <a href="{{ route('evaluasi.index') }}">
                    <span class="menu-icon">⭐</span> <span>Evaluasi Wiraniaga</span>
                </a>
                <a href="{{ url('activity/dashboard') }}">
                    <span class="menu-icon">📅</span> <span>Activity</span>
                </a>
                <a href="{{ url('summary/dashboard') }}">
                    <span class="menu-icon">📋</span> <span>Summary</span>
                </a>
                @if(Auth::user() && in_array(strtolower(Auth::user()->role ?? ''), ['admin', 'admin dca', 'om', 'om dca']))
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <span class="menu-icon">👥</span> <span>Tambah User</span>
                    </a>
                @endif
            </div>
        </div>

        <div class="content">
            <div class="header">
                <div class="header-top">
                    <div>
                        <h1>Suzuki Authorized</h1>
                        <p>Sistem Manajemen Dealer</p>
                    </div>
                    <div class="header-badge">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit"
                                style="background: none; border: none; color: #1e293b; font-weight:800; font-weight: bold; cursor: pointer; padding: 10px; display: flex; align-items: center; gap: 8px;">
                                <span>
                                    <i class="fas fa-user-circle" style="font-size: 16px;"></i> 
                                    {{ Auth::user()?->name ?? 'User' }} 
                                    <small style="font-weight: normal; opacity: 0.9;">({{ Auth::user()?->role ?? '' }})</small>
                                </span>
                                <span style="border-left: 1px solid rgba(255,255,255,0.3); height: 15px; margin: 0 5px;"></span>
                                <span style="color: #ffdf; font-weight: bold;">
                                    <i class="fas fa-sign-out-alt"></i> LOGOUT
                                </span>
                                
                            </button>
                        </form>
                    </div>

                </div>
            </div>

            @yield('content')
        </div>
    </div>
</body>

</html>
