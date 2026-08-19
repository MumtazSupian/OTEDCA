<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/dca.png') }}" type="image/jpeg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- CUSTOM LIGHT THEME WITH RED ACCENTS --}}
    <style>
        :root {
            --bg-main: #f4f5f7;        /* Putih keabu-abuan/tidak silau */
            --bg-card: #ffffff;        /* Putih bersih untuk card/tabel */
            --text-main: #1e293b;      /* Teks utama gelap */
            --text-muted: #64748b;     /* Teks sekunder kelabu */
            --accent-red: #dc2626;     /* Primary red accent */
            --accent-red-light: #fee2e2; /* Light red for hover/highlight */
            --border-color: #e2e8f0;   /* Garis pembatas tipis */
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            margin: 0;
        }

        .app-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
        }

        /* Sidebar Putih Bergaris Merah Kanan */
        .sidebar {
            overflow-y: auto;
            max-height: 100vh;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 100;
            box-sizing: border-box;
            background-color: var(--bg-card);
            border-right: 2px solid var(--accent-red);
        }

        .sidebar-brand {
            padding: 16px 12px;
            gap: 8px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
        }
        .brand-name {
            font-size: 13px !important;
            color: var(--text-main) !important;
        }
        .brand-subtitle {
            font-size: 10px !important;
            color: var(--text-muted) !important;
        }

        .sidebar-nav {
            padding: 12px 8px;
        }
        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            font-size: 13px;
            color: var(--text-main);
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 4px;
            transition: all 0.2s;
        }
        .sidebar-nav .nav-link:hover {
            background-color: var(--bg-main);
            color: var(--accent-red);
        }
        .sidebar-nav .nav-link.active {
            background-color: var(--accent-red);
            color: #ffffff !important;
        }
        .sidebar-nav .nav-link.active svg {
            stroke: #ffffff !important;
        }

        /* Nav Submenu */
        .nav-submenu {
            padding-left: 16px;
        }
        .nav-sublink {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            font-size: 12px;
            color: var(--text-muted);
            text-decoration: none;
        }
        .nav-sublink:hover {
            color: var(--accent-red);
        }
        .nav-sublink.active {
            color: var(--accent-red);
            font-weight: 600;
        }

        /* Area Konten Utama */
        .main-content {
            flex: 1;
            margin-left: 200px;
            width: calc(100% - 200px);
            min-width: 0;
            box-sizing: border-box;
            padding: 24px;
            position: relative;
        }

        .page-title {
            color: var(--text-main);
            font-weight: 700;
        }
        .page-subtitle {
            color: var(--text-muted);
        }

        /* Tombol Utama Bertema Merah */
        .btn-primary {
            background-color: var(--accent-red);
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-primary:hover {
            background-color: #b91c1c;
        }

        /* Input Pencarian */
        .search-wrapper {
            position: relative;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            display: flex;
            align-items: center;
            padding: 0 12px;
        }
        .search-input {
            background: transparent;
            border: none;
            color: var(--text-main);
            padding: 8px 0;
            outline: none;
            width: 250px;
        }

        @media (max-width: 991px) {
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 16px;
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
    <div class="app-wrapper">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon" style="width: 28px; height: 28px; flex-shrink: 0;">
                    <img src="{{ asset('assets/suzuki-icon.jpeg') }}" alt="Suzuki Logo"
                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                </div>
                <div style="min-width: 0;">
                    <span class="brand-name" style="display: block; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">OTE DCA</span>
                    <span class="brand-subtitle" style="display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"></span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" id="nav-dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span>Dashboard</span>
                </a>

                @if(auth()->check() && auth()->user()->branch === 'bp')
                <a href="{{ url('/bp') }}" class="nav-link {{ request()->is('bp*') ? 'active' : '' }}" id="nav-bp">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <span>BP</span>
                </a>
                @endif

                @if(auth()->check() && in_array(auth()->user()->branch, ['cinere', 'jatiasih', 'cianjur', 'ciawi']))
                <div class="nav-group {{ request()->is('gr/*') ? 'open' : '' }}" id="grMenu">
                    <button class="nav-link nav-toggle" onclick="toggleSubmenu('grMenu')" style="width: 100.2%; text-align: left; background: none; border: none; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg>
                        <span>GR</span>
                    </button>
                    <div class="nav-submenu">
                        @if(auth()->user()->branch === 'cinere')
                        <a href="{{ url('/gr/cinere') }}" class="nav-sublink {{ request()->is('gr/cinere*') ? 'active' : '' }}">CINERE</a>
                        @endif
                        @if(auth()->user()->branch === 'jatiasih')
                        <a href="{{ url('/gr/jatiasih') }}" class="nav-sublink {{ request()->is('gr/jatiasih*') ? 'active' : '' }}">JATIASIH</a>
                        @endif
                        @if(auth()->user()->branch === 'cianjur')
                        <a href="{{ url('/gr/cianjur') }}" class="nav-sublink {{ request()->is('gr/cianjur*') ? 'active' : '' }}">CIANJUR</a>
                        @endif
                        @if(auth()->user()->branch === 'ciawi')
                        <a href="{{ url('/gr/ciawi') }}" class="nav-sublink {{ request()->is('gr/ciawi*') ? 'active' : '' }}">CIAWI</a>
                        @endif
                    </div>
                </div>
                @endif

                @if(auth()->check() && (strtolower(auth()->user()->email) === 'adminarstock@gmail.com' || (auth()->user()->is_admin && auth()->user()->is_admin_stock)))
                    @php
                        $isVsvActive = request()->is('sales/vsv*') || request()->is('target*') || request()->is('actual*') || request()->is('rka*') || request()->is('leasing*') || request()->is('activity*') || request()->is('current*') || request()->is('evaluasi*') || request()->is('summary*');
                        $isSalesActive = request()->is('admin/stocks*') || request()->is('admin/units*') || request()->is('admin/warnas*') || request()->is('admin/varians*') || request()->is('admin/in-units*') || request()->is('admin/gudangs*') || request()->is('admin/cabangs*') || request()->is('sales/*') || $isVsvActive;
                        $isStockGroupActive = request()->is('admin/stocks*') || request()->is('admin/units*') || request()->is('admin/warnas*') || request()->is('admin/varians*') || request()->is('admin/in-units*') || request()->is('admin/gudangs*') || request()->is('admin/cabangs*') || request()->is('sales/dashboard');
                        $isUnitGroupActive = request()->is('admin/units*') || request()->is('admin/warnas*') || request()->is('admin/varians*');
                        $isFinanceActive = request()->is('admin/users*') || request()->is('admin/asuransi*') || request()->is('admin/perusahaan*') || request()->is('finance/*');
                        $isArGroupActive = request()->is('admin/users*') || request()->is('admin/asuransi*') || request()->is('admin/perusahaan*') || request()->is('finance/*');
                    @endphp

                    <!-- SALES (menu beranak) -->
                    <div class="nav-group {{ $isSalesActive ? 'open' : '' }}" id="salesMenu">
                        <button class="nav-link nav-toggle" onclick="toggleSubmenu('salesMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                            <span>SALES</span>
                            <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-left: auto;">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="nav-submenu">
                            <!-- LEADS (menu beranak) -->
                            <div class="nav-group {{ request()->is('sales/leads*') ? 'open' : '' }}" id="leadsMenu">
                                <button class="nav-link nav-toggle nav-sublink-toggle" onclick="toggleSubmenu('leadsMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 6px 12px; font-size: 12px;">
                                    <span>LEADS</span>
                                    <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-left: auto;">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>
                                <div class="nav-submenu">
                                    <!-- Dashboard LEADS -->
                                    <a href="{{ url('/sales/leads/dashboard') }}" class="nav-sublink {{ request()->is('sales/leads/dashboard*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="M12 2v2M12 20v2M2 12h2M20 12h2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        Dashboard
                                    </a>

                                    <!-- Cabang Ciawi (menu beranak) -->
                                    <div class="nav-group {{ request()->is('sales/leads/ciawi*') ? 'open' : '' }}" id="ciawiMenu">
                                        <button class="nav-link nav-toggle nav-sublink-toggle" onclick="toggleSubmenu('ciawiMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 6px 12px; font-size: 12px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                            </svg>
                                            <span>Cabang Ciawi</span>
                                            <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-left: auto;">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </button>
                                        <div class="nav-submenu">
                                            <a href="{{ url('/sales/leads/ciawi/leads') }}" class="nav-sublink {{ request()->is('sales/leads/ciawi/leads*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                Ciawi
                                            </a>
                                            <a href="{{ url('/sales/leads/ciawi/spv') }}" class="nav-sublink {{ request()->is('sales/leads/ciawi/spv*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                SPV
                                            </a>
                                            <a href="{{ url('/sales/leads/ciawi/sales') }}" class="nav-sublink {{ request()->is('sales/leads/ciawi/sales*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                Sales
                                            </a>
                                            <a href="{{ url('/sales/leads/ciawi/adm') }}" class="nav-sublink {{ request()->is('sales/leads/ciawi/adm*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                ADM
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Cabang Cianjur (menu beranak) -->
                                    <div class="nav-group {{ request()->is('sales/leads/cianjur*') ? 'open' : '' }}" id="cianjurMenu">
                                        <button class="nav-link nav-toggle nav-sublink-toggle" onclick="toggleSubmenu('cianjurMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 6px 12px; font-size: 12px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                            </svg>
                                            <span>Cabang Cianjur</span>
                                            <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-left: auto;">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </button>
                                        <div class="nav-submenu">
                                            <a href="{{ url('/sales/leads/cianjur/leads') }}" class="nav-sublink {{ request()->is('sales/leads/cianjur/leads*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                Cianjur
                                            </a>
                                            <a href="{{ url('/sales/leads/cianjur/spv') }}" class="nav-sublink {{ request()->is('sales/leads/cianjur/spv*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                SPV
                                            </a>
                                            <a href="{{ url('/sales/leads/cianjur/sales') }}" class="nav-sublink {{ request()->is('sales/leads/cianjur/sales*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                Sales
                                            </a>
                                            <a href="{{ url('/sales/leads/cianjur/adm') }}" class="nav-sublink {{ request()->is('sales/leads/cianjur/adm*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                ADM
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Cabang Cinere (menu beranak) -->
                                    <div class="nav-group {{ request()->is('sales/leads/cinere*') ? 'open' : '' }}" id="cinereMenu">
                                        <button class="nav-link nav-toggle nav-sublink-toggle" onclick="toggleSubmenu('cinereMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 6px 12px; font-size: 12px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                            </svg>
                                            <span>Cabang Cinere</span>
                                            <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-left: auto;">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </button>
                                        <div class="nav-submenu">
                                            <a href="{{ url('/sales/leads/cinere/leads') }}" class="nav-sublink {{ request()->is('sales/leads/cinere/leads*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                Cinere
                                            </a>
                                            <a href="{{ url('/sales/leads/cinere/spv') }}" class="nav-sublink {{ request()->is('sales/leads/cinere/spv*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                SPV
                                            </a>
                                            <a href="{{ url('/sales/leads/cinere/sales') }}" class="nav-sublink {{ request()->is('sales/leads/cinere/sales*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                Sales
                                            </a>
                                            <a href="{{ url('/sales/leads/cinere/adm') }}" class="nav-sublink {{ request()->is('sales/leads/cinere/adm*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                ADM
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Cabang Jatiasih (menu beranak) -->
                                    <div class="nav-group {{ request()->is('sales/leads/jatiasih*') ? 'open' : '' }}" id="jatiasihMenu">
                                        <button class="nav-link nav-toggle nav-sublink-toggle" onclick="toggleSubmenu('jatiasihMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 6px 12px; font-size: 12px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                            </svg>
                                            <span>Cabang Jatiasih</span>
                                            <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-left: auto;">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </button>
                                        <div class="nav-submenu">
                                            <a href="{{ url('/sales/leads/jatiasih/leads') }}" class="nav-sublink {{ request()->is('sales/leads/jatiasih/leads*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                Jatiasih
                                            </a>
                                            <a href="{{ url('/sales/leads/jatiasih/spv') }}" class="nav-sublink {{ request()->is('sales/leads/jatiasih/spv*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                SPV
                                            </a>
                                            <a href="{{ url('/sales/leads/jatiasih/sales') }}" class="nav-sublink {{ request()->is('sales/leads/jatiasih/sales*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                Sales
                                            </a>
                                            <a href="{{ url('/sales/leads/jatiasih/adm') }}" class="nav-sublink {{ request()->is('sales/leads/jatiasih/adm*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                ADM
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Cabang Cipanas (menu beranak) -->
                                    <div class="nav-group {{ request()->is('sales/leads/cipanas*') ? 'open' : '' }}" id="cipanasMenu">
                                        <button class="nav-link nav-toggle nav-sublink-toggle" onclick="toggleSubmenu('cipanasMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 6px 12px; font-size: 12px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                            </svg>
                                            <span>Cabang Cipanas</span>
                                            <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-left: auto;">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </button>
                                        <div class="nav-submenu">
                                            <a href="{{ url('/sales/leads/cipanas/leads') }}" class="nav-sublink {{ request()->is('sales/leads/cipanas/leads*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                Cipanas
                                            </a>
                                            <a href="{{ url('/sales/leads/cipanas/spv') }}" class="nav-sublink {{ request()->is('sales/leads/cipanas/spv*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                SPV
                                            </a>
                                            <a href="{{ url('/sales/leads/cipanas/sales') }}" class="nav-sublink {{ request()->is('sales/leads/cipanas/sales*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                Sales
                                            </a>
                                            <a href="{{ url('/sales/leads/cipanas/adm') }}" class="nav-sublink {{ request()->is('sales/leads/cipanas/adm*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                ADM
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Unit, GMB, Sumber, dll (Di Luar Cabang, tapi di dalam LEADS) -->
                                    <a href="{{ url('/sales/leads/unit') }}" class="nav-sublink {{ request()->is('sales/leads/unit*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <rect x="3" y="9" width="18" height="11" rx="2" ry="2"></rect>
                                            <path d="M4 9l2-5h12l2 5"></path>
                                            <circle cx="7.5" cy="16.5" r="1.5"></circle>
                                            <circle cx="16.5" cy="16.5" r="1.5"></circle>
                                        </svg>
                                        Unit
                                    </a>
                                    <a href="{{ url('/sales/leads/sumber') }}" class="nav-sublink {{ request()->is('sales/leads/sumber*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"></path>
                                        </svg>
                                        Sumber
                                    </a>
                                    <a href="{{ url('/sales/leads/budget') }}" class="nav-sublink {{ request()->is('sales/leads/budget*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <rect x="2" y="6" width="20" height="12" rx="2" ry="2"></rect>
                                            <circle cx="12" cy="12" r="2"></circle>
                                            <path d="M6 12h.01M18 12h.01"></path>
                                        </svg>
                                        Budget
                                    </a>
                                    <a href="{{ url('/sales/leads/status') }}" class="nav-sublink {{ request()->is('sales/leads/status*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <polyline points="23 4 23 10 17 10"></polyline>
                                            <polyline points="1 20 1 14 7 14"></polyline>
                                            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                                        </svg>
                                        Status
                                    </a>
                                    <a href="{{ url('/sales/leads/respon') }}" class="nav-sublink {{ request()->is('sales/leads/respon*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <polyline points="9 14 4 9 9 4"></polyline>
                                            <path d="M20 20v-7a4 4 0 0 0-4-4H4"></path>
                                        </svg>
                                        Respon
                                    </a>
                                    <a href="{{ url('/sales/leads/user') }}" class="nav-sublink {{ request()->is('sales/leads/user*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                        User
                                    </a>
                                </div>
                            </div>

                            <!-- VSV (menu beranak) -->
                            <div class="nav-group {{ request()->is('dashboard*') || request()->is('target*') || request()->is('actual*') || request()->is('rka*') || request()->is('leasing*') || request()->is('activity*') || request()->is('current*') || request()->is('evaluasi*') || request()->is('summary*') ? 'open' : '' }}" id="vsvMenu">
                                <button class="nav-link nav-toggle nav-sublink-toggle" onclick="toggleSubmenu('vsvMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 6px 12px; font-size: 12px;">
                                    <span>VSV</span>
                                    <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-left: auto;">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>
                                <div class="nav-submenu">
                                    <a href="{{ url('/sales/vsv/dashboard/v1') }}" class="nav-sublink {{ request()->is('sales/vsv/dashboard/v1') ? 'active' : '' }}">Dashboard V1</a>
                                    <a href="{{ url('/sales/vsv/dashboard/v2') }}" class="nav-sublink {{ request()->is('sales/vsv/dashboard/v2') || request()->is('dashboard') ? 'active' : '' }}">Dashboard V2</a>
                                    <a href="{{ url('/rka/dashboard') }}" class="nav-sublink {{ request()->is('rka*') ? 'active' : '' }}">RKA</a>
                                    <a href="{{ url('/leasing/dashboard') }}" class="nav-sublink {{ request()->is('leasing*') ? 'active' : '' }}">Leasing</a>
                                    <a href="{{ url('/activity/dashboard') }}" class="nav-sublink {{ request()->is('activity*') ? 'active' : '' }}">Activity</a>
                                    <a href="{{ url('/current/dashboard') }}" class="nav-sublink {{ request()->is('current*') ? 'active' : '' }}">Current</a>
                                    <a href="{{ url('/evaluasi/dashboard') }}" class="nav-sublink {{ request()->is('evaluasi*') ? 'active' : '' }}">Evaluasi</a>
                                    <a href="{{ url('/summary/dashboard') }}" class="nav-sublink {{ request()->is('summary*') ? 'active' : '' }}">Summary</a>
                                </div>
                            </div>

                            <!-- STOCK (menu beranak) -->
                            <div class="nav-group {{ $isStockGroupActive ? 'open' : '' }}" id="salesStockMenu">
                                <button class="nav-link nav-toggle nav-sublink-toggle" onclick="toggleSubmenu('salesStockMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 6px 12px; font-size: 12px;">
                                    <span>STOCK</span>
                                    <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-left: auto;">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>
                                <div class="nav-submenu">
                                    <a href="{{ url('/sales/dashboard') }}" class="nav-sublink {{ request()->is('sales/dashboard') ? 'active' : '' }}">Dashboard Stock</a>
                                    <a href="{{ url('/admin/stocks') }}" class="nav-sublink {{ request()->is('admin/stocks') ? 'active' : '' }}">Stock</a>
                                    <a href="{{ url('/admin/stocks/report') }}" class="nav-sublink {{ request()->is('admin/stocks/report') ? 'active' : '' }}">Report Stock</a>
                                    
                                    <!-- Unit (menu beranak inside STOCK) -->
                                    <div class="nav-group {{ $isUnitGroupActive ? 'open' : '' }}" id="salesUnitMenu">
                                        <button class="nav-link nav-toggle nav-sublink-toggle" onclick="toggleSubmenu('salesUnitMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 6px 12px; font-size: 12px;">
                                            <span>Unit</span>
                                            <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-left: auto;">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </button>
                                        <div class="nav-submenu">
                                            <a href="{{ url('/admin/units') }}" class="nav-sublink {{ request()->is('admin/units*') ? 'active' : '' }}">Unit</a>
                                            <a href="{{ url('/admin/warnas') }}" class="nav-sublink {{ request()->is('admin/warnas*') ? 'active' : '' }}">Warna</a>
                                            <a href="{{ url('/admin/varians') }}" class="nav-sublink {{ request()->is('admin/varians*') ? 'active' : '' }}">Varian</a>
                                        </div>
                                    </div>

                                    <a href="{{ url('/admin/in-units') }}" class="nav-sublink {{ request()->is('admin/in-units*') ? 'active' : '' }}">IN UNIT</a>
                                    <a href="{{ url('/admin/gudangs') }}" class="nav-sublink {{ request()->is('admin/gudangs*') ? 'active' : '' }}">Gudang</a>
                                    <a href="{{ url('/admin/cabangs') }}" class="nav-sublink {{ request()->is('admin/cabangs*') ? 'active' : '' }}">Cabang</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FINANCE (menu beranak) -->
                    <div class="nav-group {{ $isFinanceActive ? 'open' : '' }}" id="financeMenu">
                        <button class="nav-link nav-toggle" onclick="toggleSubmenu('financeMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                            <span>FINANCE</span>
                            <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-left: auto;">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="nav-submenu">
                            <!-- AR (menu beranak) -->
                            <div class="nav-group {{ $isArGroupActive ? 'open' : '' }}" id="financeArMenu">
                                <button class="nav-link nav-toggle nav-sublink-toggle" onclick="toggleSubmenu('financeArMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 6px 12px; font-size: 12px;">
                                    <span>AR</span>
                                    <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-left: auto;">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>
                                <div class="nav-submenu">
                                    <a href="{{ url('/finance/dashboard') }}" class="nav-sublink {{ request()->is('finance/dashboard') ? 'active' : '' }}">Dashboard AR</a>
                                    <a href="{{ url('/admin/users') }}" class="nav-sublink {{ request()->is('admin/users*') ? 'active' : '' }}">Users</a>
                                    <a href="{{ url('/admin/asuransi') }}" class="nav-sublink {{ request()->is('admin/asuransi*') ? 'active' : '' }}">Asuransi</a>
                                    <a href="{{ url('/admin/perusahaan') }}" class="nav-sublink {{ request()->is('admin/perusahaan*') ? 'active' : '' }}">Perusahaan</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SERVICE (menu beranak) -->
                    <div class="nav-group {{ request()->is('service/*') ? 'open' : '' }}" id="serviceMenu">
                        <button class="nav-link nav-toggle" onclick="toggleSubmenu('serviceMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                            </svg>
                            <span>SERVICE</span>
                            <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-left: auto;">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="nav-submenu">
                            <span class="nav-sublink" style="opacity: 0.5; font-style: italic; cursor: default;">(kosong)</span>
                        </div>
                    </div>

                    <!-- SPAREPART (menu beranak) -->
                    <div class="nav-group {{ request()->is('sparepart/*') ? 'open' : '' }}" id="sparepartMenu">
                        <button class="nav-link nav-toggle" onclick="toggleSubmenu('sparepartMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                            </svg>
                            <span>SPAREPART</span>
                            <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-left: auto;">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="nav-submenu">
                            <span class="nav-sublink" style="opacity: 0.5; font-style: italic; cursor: default;">(kosong)</span>
                        </div>
                    </div>
                @else
                    @if(auth()->check() && auth()->user()->is_admin)
                    <div class="nav-group {{ request()->is('admin/*') && !request()->is('admin/stocks*') && !request()->is('admin/units*') && !request()->is('admin/warnas*') && !request()->is('admin/in-units*') ? 'open' : '' }}" id="adminMenu">
                        <button class="nav-link nav-toggle" onclick="toggleSubmenu('adminMenu')" style="width: 100.2%; text-align: left; background: none; border: none; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                                <path d="M12 2l3 7h7l-5.5 4 2 7L12 16l-6.5 4 2-7L2 9h7z"></path>
                            </svg>
                            <span>AR</span>
                        </button>
                        <div class="nav-submenu">
                            <a href="{{ url('/admin/users') }}" class="nav-sublink {{ request()->is('admin/users*') ? 'active' : '' }}">Users</a>
                            <a href="{{ url('/admin/asuransi') }}" class="nav-sublink {{ request()->is('admin/asuransi*') ? 'active' : '' }}">Asuransi</a>
                            <a href="{{ url('/admin/perusahaan') }}" class="nav-sublink {{ request()->is('admin/perusahaan*') ? 'active' : '' }}">Perusahaan</a>
                        </div>
                    </div>
                    @endif

                    @if(auth()->check() && auth()->user()->is_admin_stock)
                        @php
                            // Cek apakah yang login adalah Admin IN UNIT Jatiasih/Cinere
                            $isRestrictedBranch = in_array(strtolower(auth()->user()->branch ?? ''), ['inunit_jatiasih', 'inunit_cinere']);
                        @endphp

                        
                        @if(!$isRestrictedBranch)
                        <!-- Stock Dropdown -->
                        <div class="nav-group {{ request()->is('admin/stocks*') ? 'open' : '' }}" id="stockMenu">
                            <button class="nav-link nav-toggle" onclick="toggleSubmenu('stockMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                                <span>Stock</span>
                            </button>
                            <div class="nav-submenu">
                                <a href="{{ url('/admin/stocks') }}" class="nav-sublink {{ request()->is('admin/stocks') ? 'active' : '' }}">Stock</a>
                                <a href="{{ url('/admin/stocks/report') }}" class="nav-sublink {{ request()->is('admin/stocks/report') ? 'active' : '' }}">Report Stock</a>
                            </div>
                        </div>

                        
                        <!-- Unit Dropdown -->
                        <div class="nav-group {{ request()->is('admin/units*') || request()->is('admin/varians*') || request()->is('admin/warnas*') ? 'open' : '' }}" id="unitMenu">
                            <button class="nav-link nav-toggle" onclick="toggleSubmenu('unitMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                                    <path d="M12 2l3 7h7l-5.5 4 2 7L12 16l-6.5 4 2-7L2 9h7z"></path>
                                </svg>
                                <span>Unit</span>
                            </button>
                            <div class="nav-submenu">
                                <a href="{{ url('/admin/units') }}" class="nav-sublink {{ request()->is('admin/units*') ? 'active' : '' }}">Unit</a>
                                <a href="{{ url('/admin/varians') }}" class="nav-sublink {{ request()->is('admin/varians*') ? 'active' : '' }}">Varian</a>
                                <a href="{{ url('/admin/warnas') }}" class="nav-sublink {{ request()->is('admin/warnas*') ? 'active' : '' }}">Warna</a>
                            </div>
                        </div>
                        @endif

                        <!-- IN UNIT Link (SELALU TAMPIL UNTUK SEMUA ADMIN STOCK) -->
                        <div class="nav-group {{ request()->is('admin/in-units*') ? 'open' : '' }}" id="inUnitMenu">
                            <a href="{{ url('/admin/in-units') }}" class="nav-link {{ request()->is('admin/in-units*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                                    <path d="M12 2l3 7h7l-5.5 4 2 7L12 16l-6.5 4 2-7L2 9h7z"></path>
                                </svg>
                                <span>IN UNIT</span>
                            </a>
                        </div>

                        {{-- JIKA BUKAN CABANG (Admin Biasa), Tampilkan Gudang & Cabang --}}
                        @if(!$isRestrictedBranch)
                        <!-- Gudang Link -->
                        <div class="nav-group {{ request()->is('admin/gudangs*') ? 'open' : '' }}" id="gudangMenu">
                            <a href="{{ url('/admin/gudangs') }}" class="nav-link {{ request()->is('admin/gudangs*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                                    <path d="M12 2l3 7h7l-5.5 4 2 7L12 16l-6.5 4 2-7L2 9h7z"></path>
                                </svg>
                                <span>Gudang</span>
                            </a>
                        </div>

                        <!-- Cabang Link -->
                        <div class="nav-group {{ request()->is('admin/cabangs*') ? 'open' : '' }}" id="cabangMenu">
                            <a href="{{ url('/admin/cabangs') }}" class="nav-link {{ request()->is('admin/cabangs*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                                    <path d="M12 2l3 7h7l-5.5 4 2 7L12 16l-6.5 4 2-7L2 9h7z"></path>
                                </svg>
                                <span>Cabang</span>
                            </a>
                        </div>
                        @endif
                    @endif
                @endif


                @auth
                <div style="margin-top: 24px; padding-top: 12px; border-top: 1px solid var(--border-color);">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; color: var(--accent-red);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            <span>Logout ({{ strtoupper(auth()->user()->branch) }})</span>
                        </button>
                    </form>
                </div>
                @endauth
            </nav>
        </aside>

        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSubmenu(id) {
            const group = document.getElementById(id);
            group.classList.toggle('open');
        }
        function openModal() {
            document.getElementById('createModal').style.display = 'flex';
        }
        function closeModal() {
            document.getElementById('createModal').style.display = 'none';
        }
        document.addEventListener('DOMContentLoaded', function () {
            const uppercaseFields = document.querySelectorAll('input[type=text], input[type=search], input[type=tel], input[type=url], textarea');
            uppercaseFields.forEach(function (field) {
                field.style.textTransform = 'uppercase';
                field.addEventListener('input', function () {
                    const cursorPosition = field.selectionStart;
                    field.value = field.value.toUpperCase();
                    field.setSelectionRange(cursorPosition, cursorPosition);
                });
            });
            document.querySelectorAll('form').forEach(function (form) {
                form.addEventListener('submit', function () {
                    form.querySelectorAll('input[type=text], input[type=search], input[type=tel], input[type=url], textarea').forEach(function (field) {
                        field.value = field.value.toUpperCase();
                    });
                });
            });

            // Generic Table Search Filter
            const searchInputs = document.querySelectorAll('input[type="text"]');
            searchInputs.forEach(function(input) {
                const parentNode = input.parentElement;
                if (parentNode && parentNode.textContent.includes('Search')) {
                    input.addEventListener('keyup', function() {
                        let filter = this.value.toUpperCase();
                        let container = this.closest('div[style*="padding: 15px"]');
                        if(container) {
                            let tbody = container.querySelector('tbody');
                            if (tbody) {
                                let tr = tbody.getElementsByTagName('tr');
                                let visibleCount = 0;
                                let noDataRow = null;
                                
                                for (let i = 0; i < tr.length; i++) {
                                    // Check if it's a "No data" or "Belum ada data" row
                                    if (tr[i].cells.length === 1 && tr[i].cells[0].colSpan > 1) {
                                        noDataRow = tr[i];
                                        continue; 
                                    }
                                    
                                    let txtValue = tr[i].textContent || tr[i].innerText;
                                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                        tr[i].style.display = "";
                                        visibleCount++;
                                    } else {
                                        tr[i].style.display = "none";
                                    }
                                }
                                
                                // Handle the "No data" row visibility
                                if (noDataRow) {
                                    if (visibleCount === 0 && filter !== "") {
                                        noDataRow.style.display = "";
                                        noDataRow.cells[0].innerHTML = "Data tidak ditemukan.";
                                    } else if (visibleCount === 0 && filter === "") {
                                        noDataRow.style.display = "";
                                    } else {
                                        noDataRow.style.display = "none";
                                    }
                                } else if (visibleCount === 0 && filter !== "") {
                                    // create a temporary empty row if it doesn't exist
                                    let emptyRow = document.getElementById('tempEmptyRow');
                                    if (!emptyRow) {
                                        let cols = tbody.parentElement.querySelector('thead tr').cells.length;
                                        tbody.insertAdjacentHTML('beforeend', '<tr id="tempEmptyRow"><td colspan="'+cols+'" style="padding: 15px; text-align: center; color: #777;">Data tidak ditemukan.</td></tr>');
                                    } else {
                                        emptyRow.style.display = "";
                                    }
                                } else {
                                    let emptyRow = document.getElementById('tempEmptyRow');
                                    if (emptyRow) emptyRow.style.display = "none";
                                }
                            }
                        }
                    });
                }
            });
        });
    </script>
    <script src="{{ asset('js/table-export.js') }}"></script>
    <script src="{{ asset('js/custom-alerts.js') }}"></script>
</body>
</html>
