<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>OTE DCA</title>
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
                margin-left: 0 !important;
                width: 100% !important;
                padding: 14px 10px !important;
            }
            .sidebar {
                width: 260px !important;
                transform: translateX(-100%) !important;
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                z-index: 1050 !important;
                box-shadow: 4px 0 24px rgba(0,0,0,0.18) !important;
            }
            .sidebar.sidebar-open {
                transform: translateX(0) !important;
            }
        }

        /* Mobile Topbar */
        .mobile-topbar {
            display: none;
            position: sticky;
            top: 0;
            left: 0;
            right: 0;
            height: 54px;
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 0 16px;
            align-items: center;
            justify-content: space-between;
            z-index: 99;
            margin: -14px -10px 16px -10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
        }
        @media (max-width: 991px) {
            .mobile-topbar {
                display: flex !important;
            }
        }
        .mobile-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text-main);
            font-weight: 700;
            font-size: 15px;
        }
        .mobile-toggle-btn {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 8px 12px;
            cursor: pointer;
            color: var(--text-main);
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .mobile-toggle-btn:hover, .mobile-toggle-btn:active {
            background: var(--accent-red);
            color: #ffffff;
            border-color: var(--accent-red);
        }

        /* Sidebar Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(2px);
            z-index: 1040;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .sidebar-overlay.active {
            display: block !important;
            opacity: 1 !important;
        }
        .sidebar-close-btn {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            line-height: 1;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px 8px;
            margin-left: auto;
        }
        @media (max-width: 991px) {
            .sidebar-close-btn {
                display: block !important;
            }
        }
        .sidebar-close-btn:hover {
            color: var(--accent-red);
        }

        /* Global Universal Responsive Rules */
        html, body {
            overflow-x: hidden !important;
            max-width: 100vw !important;
            -webkit-text-size-adjust: 100%;
        }
        .app-wrapper {
            width: 100% !important;
            max-width: 100vw !important;
            overflow-x: hidden !important;
            box-sizing: border-box !important;
        }

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

        /* 1. Universal Table Scrolling for all pages */
        .table-container,
        .table-responsive,
        .table-scroll,
        div[style*="overflow-x: auto"],
        div[style*="overflow-x:auto"],
        div[style*="overflow-x: scroll"],
        div[style*="overflow-x:scroll"] {
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            display: block !important;
        }

        /* 2. Responsive Breakpoints */
        @media (max-width: 991px) {
            .page-header,
            .page-header-responsive,
            .modern-header-section {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 12px !important;
            }

            .toolbar,
            .toolbar-right,
            .toolbar-wrap,
            div[style*="justify-content: space-between"],
            div[style*="justify-content:space-between"],
            div[style*="justify-content: flex-end"],
            div[style*="justify-content:flex-end"] {
                flex-wrap: wrap !important;
                gap: 10px !important;
                width: 100% !important;
            }

            /* Universal Header Button Bars (VSV, Stock, AR, Leads, Service) */
            div[style*="display:flex; justify-content:space-between"],
            div[style*="display: flex; justify-content: space-between"],
            div[style*="display:flex;justify-content:space-between"] {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 12px !important;
            }

            div[style*="display:flex; gap:10px"],
            div[style*="display: flex; gap: 10px"],
            div[style*="display:flex; gap:12px"],
            div[style*="display: flex; gap: 12px"],
            div[style*="display:flex; gap:15px"],
            div[style*="display: flex; gap: 15px"] {
                flex-wrap: wrap !important;
                width: 100% !important;
            }

            div[style*="display:flex"] > a[style*="padding:"],
            div[style*="display: flex"] > a[style*="padding:"],
            div[style*="display:flex"] > button[style*="padding:"],
            div[style*="display: flex"] > button[style*="padding:"] {
                flex: 1 1 auto !important;
                text-align: center !important;
                box-sizing: border-box !important;
            }

            form[style*="display: flex"],
            form[style*="display:flex"] {
                flex-wrap: wrap !important;
                gap: 10px !important;
                width: 100% !important;
            }

            .search-wrapper,
            .search-input,
            input[type="text"],
            input[type="search"],
            select {
                max-width: 100% !important;
                width: 100% !important;
            }

            /* Responsive Submenu Cards (VSV RKA, Activity, Evaluasi, Summary) */
            .rka-card,
            div[style*="flex: 1 1 270px"],
            div[style*="flex: 1 1 280px"],
            div[style*="max-width: 1000px"] {
                width: 100% !important;
                max-width: 100% !important;
                flex: 1 1 100% !important;
            }

            /* Responsive Form Layouts (Service AC, Leads, Finance AR, Stock) */
            .form-row {
                flex-direction: column !important;
                gap: 12px !important;
            }
            .form-col {
                width: 100% !important;
                min-width: 100% !important;
                flex: 1 1 100% !important;
            }
            .form-card-container,
            .form-section {
                width: 100% !important;
                max-width: 100% !important;
                padding: 16px 12px !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            /* Tab Navigation (Service AC, Finance) */
            .tab-wrapper {
                width: 100% !important;
                margin: 10px 0 20px 0 !important;
            }
            .tab-header {
                width: 100% !important;
                flex-wrap: wrap !important;
                justify-content: center !important;
                gap: 6px !important;
                padding: 6px !important;
                border-radius: 16px !important;
            }
            .tab-item {
                padding: 8px 14px !important;
                font-size: 13px !important;
                border-radius: 12px !important;
            }
            .tab-content {
                padding: 12px 6px !important;
            }

            /* Inspection Grid (Service AC) */
            .inspection-grid {
                grid-template-columns: 1fr !important;
                gap: 12px !important;
            }

            /* Modal dialogs */
            #createModal > div,
            #editModal > div,
            .modal-content,
            div[style*="max-width: 600px"],
            div[style*="max-width: 800px"],
            div[style*="max-width: 900px"],
            div[style*="max-width: 1000px"] {
                width: 95% !important;
                max-width: 95% !important;
                max-height: 85vh !important;
                overflow-y: auto !important;
                padding: 16px !important;
                margin: 10px auto !important;
            }
        }

        @media (max-width: 576px) {
            .page-title {
                font-size: 1.15rem !important;
            }
            .page-subtitle {
                font-size: 0.8rem !important;
            }
            .btn-action-primary,
            .btn-action-danger,
            .btn-primary-top,
            .btn-search,
            .btn-submit {
                padding: 8px 14px !important;
                font-size: 0.82rem !important;
            }
        }
    </style>
</head>

<body>
    <div class="app-wrapper">
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobileSidebar()"></div>

        <aside class="sidebar" id="sidebar">
            <a href="{{ auth()->check() && (auth()->user()->role === 'ho_unit' || strtolower(auth()->user()->email ?? '') === 'dcahounit') ? url('/sales/dashboard') : url('/dashboard') }}" class="sidebar-brand" style="text-decoration: none; color: inherit;">
                <div class="brand-icon" style="width: 28px; height: 28px; flex-shrink: 0;">
                    <img src="{{ asset('assets/suzuki-icon.jpeg') }}" alt="Suzuki Logo"
                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                </div>
                <div style="min-width: 0;">
                    <span class="brand-name" style="display: block; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">OTE DCA</span>
                    <span class="brand-subtitle" style="display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"></span>
                </div>
                <button type="button" class="sidebar-close-btn" onclick="toggleMobileSidebar()" aria-label="Tutup Menu">&times;</button>
            </a>

            <nav class="sidebar-nav">
                @if(auth()->check() && auth()->user()->role !== 'ho_unit' && strtolower(auth()->user()->email ?? '') !== 'dcahounit')
                  <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" id="nav-dashboard">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                          <rect x="3" y="3" width="7" height="7"></rect>
                          <rect x="14" y="3" width="7" height="7"></rect>
                          <rect x="14" y="14" width="7" height="7"></rect>
                          <rect x="3" y="14" width="7" height="7"></rect>
                      </svg>
                      <span>Dashboard</span>
                  </a>
                @endif



                

                @if(auth()->user()->is_admin || auth()->user()->can_access_finance || auth()->user()->is_service || in_array(strtolower(auth()->user()->role ?? ''), ['om', 'bm_sh', 'adh', 'adh bp', 'adh_bp', 'ho_unit', 'service manager', 'service_manager', 'service advisor', 'service_advisor', 'service admin', 'service_admin']) || str_contains(strtolower(auth()->user()->role ?? ''), 'adh') || str_contains(strtolower(auth()->user()->role ?? ''), 'service') || str_contains(strtolower(auth()->user()->email ?? ''), 'adh') || str_contains(strtolower(auth()->user()->email ?? ''), 'sm') || str_contains(strtolower(auth()->user()->email ?? ''), 'sa'))
                    @php
                        $isVsvActive = request()->is('sales/vsv*') || request()->is('target*') || request()->is('actual*') || request()->is('rka*') || request()->is('leasing*') || request()->is('activity*') || request()->is('current*') || request()->is('evaluasi*') || request()->is('summary*');
                        $isSalesActive = request()->is('admin/stocks*') || request()->is('admin/units*') || request()->is('admin/warnas*') || request()->is('admin/varians*') || request()->is('admin/in-units*') || request()->is('admin/gudangs*') || request()->is('admin/cabangs*') || request()->is('sales/*') || $isVsvActive;
                        $isStockGroupActive = request()->is('admin/stocks*') || request()->is('admin/units*') || request()->is('admin/warnas*') || request()->is('admin/varians*') || request()->is('admin/in-units*') || request()->is('admin/gudangs*') || request()->is('admin/cabangs*') || request()->is('sales/dashboard');
                        $isUnitGroupActive = request()->is('admin/units*') || request()->is('admin/warnas*') || request()->is('admin/varians*');
                        $isFinanceActive = request()->is('admin/users*') || request()->is('admin/asuransi*') || request()->is('admin/perusahaan*') || request()->is('finance/*') || request()->is('gr/*') || request()->is('bp*');
                        $isArGroupActive = request()->is('admin/users*') || request()->is('admin/asuransi*') || request()->is('admin/perusahaan*') || request()->is('finance/*') || request()->is('gr/*') || request()->is('bp*');
                    @endphp

                    <!-- SALES (menu beranak) -->
                    @if((auth()->user()->is_admin || auth()->user()->is_admin_stock || in_array(strtolower(auth()->user()->role ?? ''), ['om', 'bm_sh', 'adh', 'adh bp', 'adh_bp', 'ho_unit']) || str_contains(strtolower(auth()->user()->role ?? ''), 'adh') || str_contains(strtolower(auth()->user()->email ?? ''), 'adh')) && !auth()->user()->is_service && !in_array(strtolower(auth()->user()->role ?? ''), ['service manager', 'service_manager', 'service advisor', 'service_advisor', 'service admin', 'service_admin']) && !str_contains(strtolower(auth()->user()->role ?? ''), 'service'))
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
                            <!-- DASHBOARD SALES (Custom) -->
                            @if(auth()->user()->role !== 'ho_unit' && strtolower(auth()->user()->email ?? '') !== 'dcahounit')
                              <a href="{{ url('/sales/dashboard_sales') }}" class="nav-sublink {{ request()->is('sales/dashboard_sales*') ? 'active' : '' }}">
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                      <rect x="3" y="3" width="7" height="7"></rect>
                                      <rect x="14" y="3" width="7" height="7"></rect>
                                      <rect x="14" y="14" width="7" height="7"></rect>
                                      <rect x="3" y="14" width="7" height="7"></rect>
                                  </svg>
                                  Dashboard Sales
                              </a>
                            @endif

                              <!-- LEADS (menu beranak) -->
                            @if((in_array(auth()->user()->role, ['om', 'bm_sh']) || auth()->user()->is_admin) && strtolower(auth()->user()->email ?? '') !== 'dcasr')
                            <div class="nav-group {{ request()->is('sales/leads*') ? 'open' : '' }}" id="leadsMenu">
                                <button class="nav-link nav-toggle nav-sublink-toggle" onclick="toggleSubmenu('leadsMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 6px 12px; font-size: 12px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="8.5" cy="7" r="4"></circle>
                                        <line x1="20" y1="8" x2="20" y2="14"></line>
                                        <line x1="23" y1="11" x2="17" y2="11"></line>
                                    </svg>
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

                            @endif
                            <!-- VSV (menu beranak) -->
                            @if((in_array(auth()->user()->role, ['om', 'bm_sh']) || auth()->user()->is_admin) && strtolower(auth()->user()->email ?? '') !== 'dcasr')
                            <div class="nav-group {{ $isVsvActive ? 'open' : '' }}" id="vsvMenu">
                                <button class="nav-link nav-toggle nav-sublink-toggle" onclick="toggleSubmenu('vsvMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 6px 12px; font-size: 12px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                        <path d="M18 20V10M12 20V4M6 20v-6"></path>
                                    </svg>
                                    <span>VSV</span>
                                    <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-left: auto;">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>
                                <div class="nav-submenu">
                                    <a href="{{ url('/sales/vsv/dashboard/v1') }}" class="nav-sublink {{ request()->is('sales/vsv/dashboard/v1*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                            <line x1="8" y1="21" x2="16" y2="21"></line>
                                            <line x1="12" y1="17" x2="12" y2="21"></line>
                                        </svg>
                                        Dashboard V1
                                    </a>
                                    <a href="{{ url('/sales/vsv/dashboard/v2') }}" class="nav-sublink {{ request()->is('sales/vsv/dashboard/v2*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                        </svg>
                                        Dashboard V2
                                    </a>
                                    <a href="{{ url('/sales/vsv/dashboard/v3') }}" class="nav-sublink {{ request()->is('sales/vsv/dashboard/v3*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="3" y1="9" x2="21" y2="9"></line>
                                            <line x1="9" y1="21" x2="9" y2="9"></line>
                                        </svg>
                                        Dashboard V3
                                    </a>
                                    <a href="{{ url('/rka/dashboard') }}" class="nav-sublink {{ request()->is('rka*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <circle cx="12" cy="12" r="6"></circle>
                                            <circle cx="12" cy="12" r="2"></circle>
                                        </svg>
                                        RKA
                                    </a>
                                    <a href="{{ url('/leasing/dashboard') }}" class="nav-sublink {{ request()->is('leasing*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                            <line x1="1" y1="10" x2="23" y2="10"></line>
                                        </svg>
                                        Leasing
                                    </a>
                                    <a href="{{ url('/activity/dashboard') }}" class="nav-sublink {{ request()->is('activity*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        Activity
                                    </a>
                                    <a href="{{ url('/current/dashboard') }}" class="nav-sublink {{ request()->is('current*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                            <polyline points="17 6 23 6 23 12"></polyline>
                                        </svg>
                                        Current
                                    </a>
                                    <a href="{{ url('/evaluasi/dashboard') }}" class="nav-sublink {{ request()->is('evaluasi*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <path d="M9 15l2 2 4-4"></path>
                                        </svg>
                                        Evaluasi
                                    </a>
                                    <a href="{{ url('/summary/dashboard') }}" class="nav-sublink {{ request()->is('summary*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                        </svg>
                                        Summary
                                    </a>
                                </div>
                            </div>
                            @endif
                            <!-- STOCK (menu beranak) -->
                            @if(strtolower(auth()->user()->email ?? '') !== 'dcasr')
                            <div class="nav-group {{ $isStockGroupActive ? 'open' : '' }}" id="salesStockMenu">
                                <button class="nav-link nav-toggle nav-sublink-toggle" onclick="toggleSubmenu('salesStockMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 6px 12px; font-size: 12px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                    </svg>
                                    <span>STOCK</span>
                                    <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-left: auto;">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>
                                <div class="nav-submenu">
                                      @if(auth()->user()->is_admin || auth()->user()->role === 'om' || auth()->user()->is_admin_stock || auth()->user()->role === 'ho_unit' || auth()->user()->role === 'bm_sh')
                                      <a href="{{ url('/sales/dashboard') }}" class="nav-sublink {{ request()->is('sales/dashboard') ? 'active' : '' }}">
                                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                              <rect x="3" y="3" width="7" height="7"></rect>
                                              <rect x="14" y="3" width="7" height="7"></rect>
                                              <rect x="14" y="14" width="7" height="7"></rect>
                                              <rect x="3" y="14" width="7" height="7"></rect>
                                          </svg>
                                          Dashboard Stock
                                      </a>
                                    <a href="{{ url('/admin/stocks') }}" class="nav-sublink {{ request()->is('admin/stocks') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                        </svg>
                                        Stock
                                    </a>
                                    @if(auth()->user()->role !== 'bm_sh')
                                      <a href="{{ url('/admin/stocks/report') }}" class="nav-sublink {{ request()->is('admin/stocks/report') ? 'active' : '' }}">
                                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                              <polyline points="14 2 14 8 20 8"></polyline>
                                              <line x1="16" y1="13" x2="8" y2="13"></line>
                                              <line x1="16" y1="17" x2="8" y2="17"></line>
                                          </svg>
                                          Report Stock
                                      </a>
                                      
                                      <!-- Unit (menu beranak inside STOCK) -->
                                      <div class="nav-group {{ $isUnitGroupActive ? 'open' : '' }}" id="salesUnitMenu">
                                          <button class="nav-link nav-toggle nav-sublink-toggle" onclick="toggleSubmenu('salesUnitMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 6px 12px; font-size: 12px;">
                                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                                  <rect x="3" y="9" width="18" height="11" rx="2" ry="2"></rect>
                                                  <path d="M4 9l2-5h12l2 5"></path>
                                                  <circle cx="7.5" cy="16.5" r="1.5"></circle>
                                                  <circle cx="16.5" cy="16.5" r="1.5"></circle>
                                              </svg>
                                              <span>Unit</span>
                                              <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-left: auto;">
                                                  <polyline points="6 9 12 15 18 9"></polyline>
                                              </svg>
                                          </button>
                                          <div class="nav-submenu">
                                              <a href="{{ url('/admin/units') }}" class="nav-sublink {{ request()->is('admin/units*') ? 'active' : '' }}">
                                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                  Unit
                                              </a>
                                              <a href="{{ url('/admin/warnas') }}" class="nav-sublink {{ request()->is('admin/warnas*') ? 'active' : '' }}">
                                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                  Warna
                                              </a>
                                              <a href="{{ url('/admin/varians') }}" class="nav-sublink {{ request()->is('admin/varians*') ? 'active' : '' }}">
                                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                  Varian
                                              </a>
                                            </div>
                                        </div>
                                      @endif
                                        @endif

                                    @if(auth()->user()->role !== 'bm_sh')
                                      <a href="{{ url('/admin/in-units') }}" class="nav-sublink {{ request()->is('admin/in-units*') ? 'active' : '' }}">
                                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                              <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9C2.1 11.2 2 11.6 2 12v4c0 .6.4 1 1 1h2"></path>
                                              <circle cx="7" cy="17" r="2"></circle>
                                              <path d="M9 17h6"></path>
                                              <circle cx="17" cy="17" r="2"></circle>
                                          </svg>
                                          IN UNIT
                                      </a>
                                      @endif
                                      @if(auth()->user()->is_admin || auth()->user()->role === 'om' || auth()->user()->is_admin_stock || auth()->user()->role === 'ho_unit')
                                    <a href="{{ url('/admin/gudangs') }}" class="nav-sublink {{ request()->is('admin/gudangs*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v4M12 14v4M16 14v4"></path>
                                        </svg>
                                        Gudang
                                    </a>
                                    <a href="{{ url('/admin/cabangs') }}" class="nav-sublink {{ request()->is('admin/cabangs*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        Cabang
                                    </a>
                                      @endif
                                </div>
                            </div>
                            @endif

                            <!-- FAKTUR -->
                            <a href="{{ route('sales.faktur.index') }}" class="nav-sublink {{ request()->is('sales/faktur*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                <span>FAKTUR</span>
                            </a>
                        </div>
                    </div>

                    @endif

                    <!-- FINANCE (menu beranak) -->
                    @if(auth()->user()->is_admin || auth()->user()->role === 'om' || auth()->user()->is_adh || auth()->user()->is_service || auth()->user()->branch === 'bp' || in_array(strtolower(auth()->user()->role ?? ''), ['om', 'adh', 'adh bp', 'adh_bp', 'service manager', 'service_manager', 'service advisor', 'service_advisor', 'service admin', 'service_admin']) || str_contains(strtolower(auth()->user()->role ?? ''), 'adh') || str_contains(strtolower(auth()->user()->role ?? ''), 'service') || str_contains(strtolower(auth()->user()->email ?? ''), 'adh') || str_contains(strtolower(auth()->user()->email ?? ''), 'sm') || str_contains(strtolower(auth()->user()->email ?? ''), 'sa'))
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
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                        <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                        <line x1="6" y1="8" x2="10" y2="8"></line>
                                        <line x1="6" y1="12" x2="18" y2="12"></line>
                                        <line x1="6" y1="16" x2="14" y2="16"></line>
                                    </svg>
                                    <span>AR</span>
                                    <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-left: auto;">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>
                                <div class="nav-submenu">
                                    <a href="{{ url('/finance/dashboard') }}" class="nav-sublink {{ request()->is('finance/dashboard') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <rect x="3" y="3" width="7" height="7"></rect>
                                            <rect x="14" y="3" width="7" height="7"></rect>
                                            <rect x="14" y="14" width="7" height="7"></rect>
                                            <rect x="3" y="14" width="7" height="7"></rect>
                                        </svg>
                                        Dashboard AR
                                    </a>

                                    @php
                                        $usr = auth()->user();
                                        $isAdhUser = $usr->is_adh || in_array(strtolower($usr->role ?? ''), ['adh', 'adh bp', 'adh_bp']) || str_contains(strtolower($usr->role ?? ''), 'adh');
                                        $isServiceUser = $usr->is_service || in_array(strtolower($usr->role ?? ''), ['service manager', 'service_manager', 'service advisor', 'service_advisor', 'service admin', 'service_admin']) || str_contains(strtolower($usr->role ?? ''), 'service');
                                        $isDcasr = strtolower($usr->email ?? '') === 'dcasr';
                                        $canSeeAllAr = (($usr->is_admin && !$isAdhUser && !$isServiceUser) || strtolower($usr->role ?? '') === 'om') && !$isDcasr;
                                        $userBranch = strtolower($usr->branch ?? '');
                                    @endphp

                                    {{-- Master Data: Users, Asuransi, Perusahaan HANYA untuk Superadmin / OM (Disembunyikan dari semua ADH, Service, dan DCASR) --}}
                                    @if($canSeeAllAr)
                                    <a href="{{ url('/admin/users') }}" class="nav-sublink {{ request()->is('admin/users*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                        Users
                                    </a>
                                    <a href="{{ url('/admin/asuransi') }}" class="nav-sublink {{ request()->is('admin/asuransi*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                        </svg>
                                        Asuransi
                                    </a>
                                    <a href="{{ url('/admin/perusahaan') }}" class="nav-sublink {{ request()->is('admin/perusahaan*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect>
                                            <line x1="9" y1="22" x2="9" y2="22.01"></line>
                                            <line x1="15" y1="22" x2="15" y2="22.01"></line>
                                            <line x1="9" y1="6" x2="9" y2="6.01"></line>
                                            <line x1="15" y1="6" x2="15" y2="6.01"></line>
                                            <line x1="9" y1="10" x2="9" y2="10.01"></line>
                                            <line x1="15" y1="10" x2="15" y2="10.01"></line>
                                            <line x1="9" y1="14" x2="9" y2="14.01"></line>
                                            <line x1="15" y1="14" x2="15" y2="14.01"></line>
                                            <line x1="9" y1="18" x2="9" y2="18.01"></line>
                                            <line x1="15" y1="18" x2="15" y2="18.01"></line>
                                        </svg>
                                        Perusahaan
                                    </a>
                                    @endif

                                    <!-- BP Menu inside AR: hanya untuk OM/Admin ATAU ADH BP (branch === 'bp') -->
                                    @if(($canSeeAllAr || $userBranch === 'bp') && !$isDcasr)
                                    <a href="{{ url('/bp') }}" class="nav-sublink {{ request()->is('bp*') ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9C2.1 11.2 2 11.6 2 12v4c0 .6.4 1 1 1h2"></path>
                                            <circle cx="7" cy="17" r="2"></circle>
                                            <path d="M9 17h6"></path>
                                            <circle cx="17" cy="17" r="2"></circle>
                                        </svg>
                                        BP
                                    </a>
                                    @endif
                                
                                    <!-- GR Menu inside AR: hanya untuk OM/Admin ATAU ADH GR (Cinere, Jatiasih, Cianjur, Ciawi) -->
                                    @if(($canSeeAllAr || in_array($userBranch, ['cinere', 'jatiasih', 'cianjur', 'ciawi'])) && !$isDcasr)
                                    <div class="nav-group {{ request()->is('gr/*') ? 'open' : '' }}" id="grMenu">
                                        <button class="nav-link nav-toggle nav-sublink-toggle" onclick="toggleSubmenu('grMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 6px 12px; font-size: 12px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                                            </svg>
                                            <span>GR</span>
                                            <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-left: auto;">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </button>
                                        <div class="nav-submenu">
                                            @if($canSeeAllAr || $userBranch === 'cinere')
                                            <a href="{{ url('/gr/cinere') }}" class="nav-sublink {{ request()->is('gr/cinere*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                CINERE
                                            </a>
                                            @endif
                                            @if($canSeeAllAr || $userBranch === 'jatiasih')
                                            <a href="{{ url('/gr/jatiasih') }}" class="nav-sublink {{ request()->is('gr/jatiasih*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                JATIASIH
                                            </a>
                                            @endif
                                            @if($canSeeAllAr || $userBranch === 'cianjur')
                                            <a href="{{ url('/gr/cianjur') }}" class="nav-sublink {{ request()->is('gr/cianjur*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                CIANJUR
                                            </a>
                                            @endif
                                            @if($canSeeAllAr || $userBranch === 'ciawi')
                                            <a href="{{ url('/gr/ciawi') }}" class="nav-sublink {{ request()->is('gr/ciawi*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle></svg>
                                                CIAWI
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @endif

                    <!-- SERVICE (menu beranak) -->
                    @if(auth()->user()->role !== 'ho_unit' && strtolower(auth()->user()->email ?? '') !== 'dcahounit')
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
                            <a href="{{ url('/service/service-ac/monitoring') }}" class="nav-sublink {{ request()->is('service/service-ac*') && !request()->is('service/service-ac/ac/*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 8px;">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"></path>
                                    <path d="M14 3v5h5M16 13H8M16 17H8M10 9H8"></path>
                                </svg>
                                Dashboard Service
                            </a>

                            <!-- MENU AC -->
                            <div class="nav-group {{ request()->is('service/service-ac/ac/*') ? 'open' : '' }}" id="menuAcDropdown">
                                <button class="nav-sublink nav-toggle" onclick="toggleSubmenu('menuAcDropdown')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                                    <i class="far fa-copy" style="margin-right: 8px; font-size: 14px; width: 14px; text-align: center;"></i>
                                    <span style="font-size: 13px;">MENU AC</span>
                                    <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-left: auto;">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>
                                <div class="nav-submenu">
                                    <a href="{{ route('service.service-ac.ac.post_check') }}" class="nav-sublink {{ request()->is('service/service-ac/ac/post-check') ? 'active' : '' }}" style="padding-left: 25px; white-space: nowrap;">
                                        <i class="far fa-circle" style="margin-right: 8px; font-size: 11px;"></i>
                                        POST CHECK AC
                                    </a>
                                    <a href="{{ route('service.service-ac.ac.pre_check') }}" class="nav-sublink {{ request()->is('service/service-ac/ac/pre-check') ? 'active' : '' }}" style="padding-left: 25px; white-space: nowrap;">
                                        <i class="far fa-circle" style="margin-right: 8px; font-size: 11px;"></i>
                                        PRE CHECK AC
                                    </a>
                                    <a href="{{ route('service.service-ac.ac.teknisi') }}" class="nav-sublink {{ request()->is('service/service-ac/ac/teknisi') ? 'active' : '' }}" style="padding-left: 25px; white-space: nowrap;">
                                        <i class="far fa-circle" style="margin-right: 8px; font-size: 11px;"></i>
                                        TEKNISI
                                    </a>
                                </div>
                            </div>
                            
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

                    <!-- ASURANSI (menu beranak) -->
                    <div class="nav-group {{ request()->is('asuransi/*') ? 'open' : '' }}" id="asuransiMenu">
                        <button class="nav-link nav-toggle" onclick="toggleSubmenu('asuransiMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                            <span>ASURANSI</span>
                            <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-left: auto;">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="nav-submenu">
                            <a href="{{ route('asuransi.dashboard') }}" class="nav-sublink {{ request()->is('asuransi/dashboard*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px; height:15px; flex-shrink: 0;">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <span>Dashboard Asuransi</span>
                            </a>
                            <a href="{{ route('asuransi.data') }}" class="nav-sublink {{ request()->is('asuransi/data*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px; height:15px; flex-shrink: 0;">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                                <span>Data Asuransi</span>
                            </a>
                            <a href="{{ route('asuransi.tanpa_asuransi') }}" class="nav-sublink {{ request()->is('asuransi/tanpa-asuransi*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px; height:15px; flex-shrink: 0;">
                                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                    <line x1="12" y1="9" x2="12" y2="13"></line>
                                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                </svg>
                                <span>Tanpa Asuransi</span>
                            </a>
                            <a href="{{ route('asuransi.master') }}" class="nav-sublink {{ request()->is('asuransi/master*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px; height:15px; flex-shrink: 0;">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>
                                <span>Master Asuransi</span>
                            </a>
                            <a href="{{ route('asuransi.follow_up') }}" class="nav-sublink {{ request()->is('asuransi/follow-up*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px; height:15px; flex-shrink: 0;">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <span>Follow-Up Asuransi</span>
                            </a>
                            <a href="{{ route('asuransi.monitoring_follow_up') }}" class="nav-sublink {{ request()->is('asuransi/monitoring-follow-up*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px; height:15px; flex-shrink: 0;">
                                    <line x1="18" y1="20" x2="18" y2="10"></line>
                                    <line x1="12" y1="20" x2="12" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="14"></line>
                                </svg>
                                <span>Monitoring Follow-Up</span>
                            </a>
                        </div>
                    </div>

                    <!-- BODY & PAINT (menu beranak) -->
                    <div class="nav-group {{ request()->is('body-paint/*') || request()->is('bp/*') ? 'open' : '' }}" id="bodyPaintMenu">
                        <button class="nav-link nav-toggle" onclick="toggleSubmenu('bodyPaintMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                                <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9C2.1 11.2 2 11.6 2 12v4c0 .6.4 1 1 1h2"></path>
                                <circle cx="7" cy="17" r="2"></circle>
                                <path d="M9 17h6"></path>
                                <circle cx="17" cy="17" r="2"></circle>
                            </svg>
                            <span>BODY & PAINT</span>
                            <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-left: auto;">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="nav-submenu">
                            <!-- Leads GRWAC (Sub-menu beranak) -->
                            <div class="nav-group {{ request()->is('body-paint/leads-grwac/*') ? 'open' : '' }}" id="leadsGrwacMenu">
                                <button class="nav-link nav-toggle nav-sublink-toggle" onclick="toggleSubmenu('leadsGrwacMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 6px 12px; font-size: 13px; display: flex; align-items: center; gap: 8px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px; height:15px; flex-shrink: 0;">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="3" y1="12" x2="21" y2="12"></line>
                                        <line x1="12" y1="3" x2="12" y2="21"></line>
                                    </svg>
                                    <span>Leads GRWAC</span>
                                    <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-left: auto;">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>
                                <div class="nav-submenu">
                                    <a href="{{ route('body_paint.leads.dashboard') }}" class="nav-sublink {{ request()->is('body-paint/leads-grwac/dashboard*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px; padding-left: 28px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; flex-shrink: 0;">
                                            <line x1="18" y1="20" x2="18" y2="10"></line>
                                            <line x1="12" y1="20" x2="12" y2="4"></line>
                                            <line x1="6" y1="20" x2="6" y2="14"></line>
                                        </svg>
                                        <span>Dashboard Leads BP</span>
                                    </a>
                                    <a href="{{ route('body_paint.leads.input_prospect') }}" class="nav-sublink {{ request()->is('body-paint/leads-grwac/input-prospect*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px; padding-left: 28px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; flex-shrink: 0;">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="8" x2="12" y2="16"></line>
                                            <line x1="8" y1="12" x2="16" y2="12"></line>
                                        </svg>
                                        <span>Input Prospect</span>
                                    </a>
                                    <a href="{{ route('body_paint.leads.daftar_prospect') }}" class="nav-sublink {{ request()->is('body-paint/leads-grwac/daftar-prospect*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px; padding-left: 28px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; flex-shrink: 0;">
                                            <line x1="8" y1="6" x2="21" y2="6"></line>
                                            <line x1="8" y1="12" x2="21" y2="12"></line>
                                            <line x1="8" y1="18" x2="21" y2="18"></line>
                                            <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                            <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                            <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                        </svg>
                                        <span>Daftar Prospect</span>
                                    </a>
                                    <a href="{{ route('body_paint.leads.prospek_saya') }}" class="nav-sublink {{ request()->is('body-paint/leads-grwac/prospek-saya*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px; padding-left: 28px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; flex-shrink: 0;">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span>Prospek Saya</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Monitoring Asuransi (Sub-menu beranak) -->
                            <div class="nav-group {{ request()->is('body-paint/monitoring-asuransi/*') ? 'open' : '' }}" id="monitoringAsuransiBpMenu">
                                <button class="nav-link nav-toggle nav-sublink-toggle" onclick="toggleSubmenu('monitoringAsuransiBpMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 6px 12px; font-size: 13px; display: flex; align-items: center; gap: 8px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px; height:15px; flex-shrink: 0;">
                                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9C2.1 11.2 2 11.6 2 12v4c0 .6.4 1 1 1h2"></path>
                                        <circle cx="7" cy="17" r="2"></circle>
                                        <path d="M9 17h6"></path>
                                        <circle cx="17" cy="17" r="2"></circle>
                                    </svg>
                                    <span>Monitoring Asuransi</span>
                                    <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px; margin-left: auto;">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>
                                <div class="nav-submenu">
                                    <a href="{{ route('body_paint.monitoring.dashboard') }}" class="nav-sublink {{ request()->is('body-paint/monitoring-asuransi/dashboard*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px; padding-left: 28px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; flex-shrink: 0;">
                                            <line x1="18" y1="20" x2="18" y2="10"></line>
                                            <line x1="12" y1="20" x2="12" y2="4"></line>
                                            <line x1="6" y1="20" x2="6" y2="14"></line>
                                        </svg>
                                        <span>Dashboard Asuransi</span>
                                    </a>
                                    <a href="{{ route('body_paint.monitoring.follow_up') }}" class="nav-sublink {{ request()->is('body-paint/monitoring-asuransi/monitoring-follow-up*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px; padding-left: 28px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; flex-shrink: 0;">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                        </svg>
                                        <span>Monitoring & Follow-up</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Master BP (Link) -->
                            <a href="{{ route('body_paint.master') }}" class="nav-sublink {{ request()->is('body-paint/master*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px; height:15px; flex-shrink: 0;">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>
                                <span>Master BP</span>
                            </a>
                        </div>
                    </div>

                    <!-- CUSTOMER DATABASE (menu beranak) -->
                    <div class="nav-group {{ request()->is('customer-database/*') || request()->is('customer/*') ? 'open' : '' }}" id="customerDatabaseMenu">
                        <button class="nav-link nav-toggle" onclick="toggleSubmenu('customerDatabaseMenu')" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                            </svg>
                            <span>CUSTOMER DATABASE</span>
                            <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-left: auto;">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="nav-submenu">
                            <a href="{{ route('customer.list') }}" class="nav-sublink {{ request()->is('customer/list*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px; height:15px; flex-shrink: 0;">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <span>Customer List</span>
                            </a>
                            <a href="{{ route('customer.vehicle_lookup') }}" class="nav-sublink {{ request()->is('customer/vehicle-lookup*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px; height:15px; flex-shrink: 0;">
                                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9C2.1 11.2 2 11.6 2 12v4c0 .6.4 1 1 1h2"></path>
                                    <circle cx="7" cy="17" r="2"></circle>
                                    <path d="M9 17h6"></path>
                                    <circle cx="17" cy="17" r="2"></circle>
                                </svg>
                                <span>Vehicle Lookup</span>
                            </a>
                            <a href="{{ route('customer.duplicate_review') }}" class="nav-sublink {{ request()->is('customer/duplicate-review*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px; height:15px; flex-shrink: 0;">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                                <span>Duplicate Review</span>
                            </a>
                            <a href="{{ route('customer.sync_log') }}" class="nav-sublink {{ request()->is('customer/sync-log*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px; height:15px; flex-shrink: 0;">
                                    <polyline points="23 4 23 10 17 10"></polyline>
                                    <polyline points="1 20 1 14 7 14"></polyline>
                                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                                </svg>
                                <span>Sync Log</span>
                            </a>
                        </div>
                    </div>
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
                            <span>Logout ({{ strtoupper(auth()->user()->email ?? auth()->user()->name) }})</span>
                        </button>
                    </form>
                </div>
                @endauth
            </nav>
        </aside>

        <main class="main-content">
            <div class="mobile-topbar">
                <a href="{{ auth()->check() && (auth()->user()->role === 'ho_unit' || strtolower(auth()->user()->email ?? '') === 'dcahounit') ? url('/sales/dashboard') : url('/dashboard') }}" class="mobile-brand">
                    <img src="{{ asset('assets/suzuki-icon.jpeg') }}" alt="Logo" style="width: 24px; height: 24px; border-radius: 4px; object-fit: cover;">
                    <span>OTE DCA</span>
                </a>
                <button type="button" class="mobile-toggle-btn" onclick="toggleMobileSidebar()" aria-label="Buka Menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            @yield('content')
        </main>
    </div>

    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if (sidebar && overlay) {
                sidebar.classList.toggle('sidebar-open');
                overlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('sidebar-open') ? 'hidden' : '';
            }
        }
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
