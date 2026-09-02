@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
    /* RESPONSIVE CARDS GRID */
    .mobil-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    @media (max-width: 1200px) {
        .mobil-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
    }
    @media (max-width: 820px) {
        .mobil-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
    }
    @media (max-width: 480px) {
        .mobil-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
    }
    @media (max-width: 350px) {
        .mobil-grid {
            grid-template-columns: 1fr;
        }
    }

    .page-header-responsive {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }
    @media (max-width: 768px) {
        .page-header-responsive {
            flex-direction: column;
            gap: 12px;
        }
    }

    /* SERVICE AC STYLES */
    .cabang-section {
        margin-top: 20px;
        margin-bottom: 45px;
    }
    .modern-cabang-title {
        font-size: 20px;
        color: #1a237e;
        font-weight: 800;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .modern-cabang-title::before {
        content: '';
        width: 6px;
        height: 24px;
        background: linear-gradient(to bottom, #3498db, #2ecc71);
        border-radius: 4px;
        display: inline-block;
    }
    .cards-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }
    @media (max-width: 576px) {
        .cards-row {
            grid-template-columns: 1fr;
            gap: 15px;
        }
        .service-card {
            min-width: 0 !important;
            padding: 18px !important;
        }
    }
    .service-card {
        background: #fff;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.02);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .service-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
    }
    .service-card.modern-blue::after { background: #3498db; }
    .service-card.modern-orange::after { background: #f39c12; }
    .service-card.modern-green::after { background: #2ecc71; }
    .service-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    }
    .card-title-area {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        border-bottom: 1px solid #f0f4f8;
        padding-bottom: 15px;
    }
    .icon-wrap {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .modern-blue .icon-wrap { background: rgba(52, 152, 219, 0.1); color: #3498db; }
    .modern-orange .icon-wrap { background: rgba(243, 156, 18, 0.1); color: #f39c12; }
    .modern-green .icon-wrap { background: rgba(46, 204, 113, 0.1); color: #2ecc71; }
    .card-title-area h4 {
        margin: 0;
        font-size: 14px;
        font-weight: 700;
    }
    .modern-blue h4 { color: #3498db; }
    .modern-orange h4 { color: #f39c12; }
    .modern-green h4 { color: #2ecc71; }
    .stats-area {
        display: flex;
        justify-content: space-between;
        padding: 0 5px;
    }
    .stat-item {
        text-align: center;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .stat-num {
        font-size: 22px;
        font-weight: 800;
    }
    .modern-blue .stat-num { color: #2980b9; }
    .modern-orange .stat-num { color: #e67e22; }
    .modern-green .stat-num { color: #27ae60; }
    .stat-text {
        font-size: 11px;
        color: #7f8c8d;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
</style>

    <div class="page-header-responsive">
        <div>
            <h1 class="page-title" style="font-size: 1.5rem; margin: 0 0 6px 0;">Data SPK dan DO {{ $isPusat ? 'Semua Cabang' : ucfirst(strtolower($cabang)) }}</h1>
            <p class="page-subtitle" style="margin: 0 0 12px 0;">Operation Transformation Excellent DCA</p>
            {{-- Tambahan TOTAL SPK dan DO Keseluruhan --}}
            <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 5px;">
                <div style="background: #eff6ff; padding: 6px 12px; border-radius: 6px; border: 1px solid #bfdbfe; font-weight: bold; color: #1e40af; font-size: 13px;">
                    TOTAL SPK: {{ $sections[0]->totalSpk }}
                </div>
                <div style="background: #ecfdf5; padding: 6px 12px; border-radius: 6px; border: 1px solid #a7f3d0; font-weight: bold; color: #065f46; font-size: 13px;">
                    TOTAL DO: {{ $sections[0]->totalDo }}
                </div>
            </div>
        </div>
        <div class="server-time" style="align-self: flex-start; background: #ffffff; padding: 6px 12px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 12px; display: flex; align-items: center; gap: 8px;">
            <span class="dot" style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%; display: inline-block;"></span>
            <span>Waktu Server: {{ now()->setTimezone('Asia/Jakarta')->format('d M Y \\p\\u\\k\\u\\l H.i') }} WIB</span>
        </div>
    </div>

    {{-- Filter Bulan --}}
    <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
        <form action="{{ url('/dashboard') }}" method="GET" id="filterForm" style="display: flex; align-items: center; gap: 10px; background: white; padding: 10px 16px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); width: auto; max-width: 100%;">
            <label for="bulan" style="font-size: 13px; font-weight: 600; color: #475569; margin: 0; white-space: nowrap;">PERIODE DATA:</label>
            <select name="bulan" id="bulan" onchange="document.getElementById('filterForm').submit();" style="padding: 6px 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 13px; color: #1e293b; background-color: #f8fafc; cursor: pointer; outline: none; flex: 1;">
                @foreach($bulanMap as $num => $namaBulan)
                    <option value="{{ $namaBulan }}" {{ strtolower($selectedBulan) == strtolower($namaBulan) ? 'selected' : '' }}>
                        {{ strtoupper($namaBulan) }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- Mobil Cards Grid --}}
    @php
        $cardGradients = [
            'NEW CARRY' => 'linear-gradient(135deg, #6366f1, #a855f7)',
            'NEW XL-7' => 'linear-gradient(135deg, #10b981, #34d399)',
            'FRONX' => 'linear-gradient(135deg, #fbcfe8, #fecdd3)',
            'JIMMY' => 'linear-gradient(135deg, #d8b4fe, #f0abfc)',
            'GRAND-VITARA' => 'linear-gradient(135deg, #f87171, #fb923c)',
            'APV' => 'linear-gradient(135deg, #be123c, #fb7185)',
            'ERTIGA-HYBRID' => 'linear-gradient(135deg, #38bdf8, #818cf8)',
            'S-PRESSO' => 'linear-gradient(135deg, #fbbf24, #f59e0b)',
        ];
    @endphp

    @foreach($sections as $index => $section)
        @if($index > 0)
            {{-- Pembatas antar cabang khusus untuk admin --}}
            <hr style="margin: 40px 0; border: 0; border-top: 2px dashed #cbd5e1;">
            <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin: 0;">Data SPK dan DO {{ $section->title }}</h2>
                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                    <div style="background: #eff6ff; padding: 6px 12px; border-radius: 6px; border: 1px solid #bfdbfe; font-weight: bold; color: #1e40af; font-size: 12px;">
                        TOTAL SPK: {{ $section->totalSpk }}
                    </div>
                    <div style="background: #ecfdf5; padding: 6px 12px; border-radius: 6px; border: 1px solid #a7f3d0; font-weight: bold; color: #065f46; font-size: 12px;">
                        TOTAL DO: {{ $section->totalDo }}
                    </div>
                </div>
            </div>
        @endif

        <div class="mobil-grid">
            @forelse($section->mobilStats as $mobil)
                <div style="background:white;border-radius:16px;box-shadow:0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);overflow:hidden;transition:all 0.3s ease;display:flex;flex-direction:column;height:100%;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06)'">
                    
                    {{-- Header / Image Area --}}
                    <div style="height:120px;background:{{ $cardGradients[$mobil->nama_mobil] ?? 'linear-gradient(135deg, #94a3b8, #cbd5e1)' }};position:relative;display:flex;align-items:center;justify-content:center;padding:15px;overflow:hidden;">
                        <div style="position:absolute;top:0;left:0;right:0;bottom:0;background:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PC9zdmc+') repeat;z-index:1;"></div>
                        
                        <!-- Car Image -->
                        @if(!empty($mobil->image))
                            <img src="{{ asset('assets/' . $mobil->image) }}" alt="{{ $mobil->nama_mobil }}" style="max-height:90px;max-width:90%;object-fit:contain;z-index:2;filter:drop-shadow(0 8px 6px rgba(0,0,0,0.25));">
                        @else
                            <div style="display:flex; flex-direction:column; align-items:center; color:rgba(255,255,255,0.8); z-index:2;">
                                <i class="fas fa-car" style="font-size:2.5rem;"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Body --}}
                    <div style="padding:16px;">
                        <h3 style="font-size:15px;font-weight:700;color:#0f172a;margin:0 0 14px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; text-align:center;">
                            {{ $mobil->nama_mobil }}
                        </h3>

                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            {{-- Actual SPK --}}
                            <div>
                                <div style="font-size:11px;font-weight:700;color:#2563eb;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:6px;border-bottom:1px solid #e2e8f0;padding-bottom:4px;text-align:center;">SPK</div>
                                @if($mobil->total_spk > 0)
                                    <div style="display:flex;justify-content:center;align-items:center;background:#eff6ff;padding:8px;border-radius:6px;border:1px solid #bfdbfe;height:40px;">
                                        <span style="color:#1d4ed8;font-size:22px;font-weight:800;">{{ $mobil->total_spk }}</span>
                                    </div>
                                @else
                                    <div style="color:#94a3b8;font-size:18px;text-align:center;padding:8px 0;background:#f8fafc;border-radius:6px;border:1px dashed #e2e8f0;font-weight:600;height:40px;">0</div>
                                @endif
                            </div>

                            {{-- Actual DO --}}
                            <div>
                                <div style="font-size:11px;font-weight:700;color:#059669;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:6px;border-bottom:1px solid #e2e8f0;padding-bottom:4px;text-align:center;">DO</div>
                                @if($mobil->total_do > 0)
                                    <div style="display:flex;justify-content:center;align-items:center;background:#ecfdf5;padding:8px;border-radius:6px;border:1px solid #a7f3d0;height:40px;">
                                        <span style="color:#047857;font-size:22px;font-weight:800;">{{ $mobil->total_do }}</span>
                                    </div>
                                @else
                                    <div style="color:#94a3b8;font-size:18px;text-align:center;padding:8px 0;background:#f8fafc;border-radius:6px;border:1px dashed #e2e8f0;font-weight:600;height:40px;">0</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:60px 24px;background:#f8fafc;border-radius:16px;border:2px dashed #e2e8f0;">
                    <i class="fas fa-car" style="font-size:2.5rem;color:#cbd5e1;margin-bottom:12px;display:block;"></i>
                    <div style="color:#94a3b8;font-size:15px;">Belum ada data mobil.</div>
                </div>
            @endforelse
        </div>
    @endforeach

    <!-- MONITORING SERVICE CABANG -->
    <hr style="margin: 40px 0; border: 0; border-top: 2px dashed #cbd5e1;">
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <h2 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-chart-pie" style="color: #20c997;"></i> Monitoring Service Cabang
        </h2>
    </div>

    <style>
        .cabang-section {
            margin-bottom: 35px;
        }
        .modern-cabang-title {
            font-size: 18px;
            color: #1a237e;
            font-weight: 800;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .modern-cabang-title::before {
            content: '';
            width: 6px;
            height: 24px;
            background: linear-gradient(to bottom, #3498db, #2ecc71);
            border-radius: 4px;
            display: inline-block;
        }
        .cards-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        @media (max-width: 576px) {
            .cards-row {
                grid-template-columns: 1fr;
                gap: 14px;
            }
            .service-card {
                min-width: 0 !important;
                padding: 16px !important;
            }
        }
        .service-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.02);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .service-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
        }
        .service-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        }
        .card-title-area {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            border-bottom: 1px solid #f0f4f8;
            padding-bottom: 20px;
        }
        .icon-wrap {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }
        .card-title-area h4 {
            font-weight: 800;
            margin: 0;
            font-size: 16px;
            letter-spacing: 0.3px;
        }
        .stats-area {
            display: flex;
            justify-content: space-between;
        }
        .stat-item {
            text-align: center;
            flex: 1;
        }
        .stat-item:not(:last-child) {
            border-right: 1px dashed #e2e8f0;
        }
        .stat-num {
            display: block;
            font-size: 32px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 8px;
        }
        .stat-text {
            display: block;
            font-size: 12px;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
        }
        /* THEME: BLUE (ENTRY SERVICE) */
        .modern-blue::after { background: linear-gradient(to right, #1976d2, #64b5f6); }
        .modern-blue .icon-wrap { background: #e3f2fd; color: #1976d2; }
        .modern-blue h4 { color: #1565c0; }
        .modern-blue .stat-num { color: #1976d2; }

        /* THEME: ORANGE (SPOORING BALANCING) */
        .modern-orange::after { background: linear-gradient(to right, #f57c00, #ffb74d); }
        .modern-orange .icon-wrap { background: #fff3e0; color: #f57c00; }
        .modern-orange h4 { color: #e65100; }
        .modern-orange .stat-num { color: #f57c00; }

        /* THEME: GREEN (UNIT AC) */
        .modern-green::after { background: linear-gradient(to right, #388e3c, #81c784); }
        .modern-green .icon-wrap { background: #e8f5e9; color: #388e3c; }
        .modern-green h4 { color: #1b5e20; }
        .modern-green .stat-num { color: #388e3c; }
    </style>

    @foreach($dataCabangService as $cabang => $data)
    <div class="cabang-section">
        <div class="modern-cabang-title">{{ $cabang }}</div>
        
        <div class="cards-row">
            <!-- UNIT ENTRY SERVICE -->
            <div class="service-card modern-blue">
                <div class="card-title-area">
                    <div class="icon-wrap"><i class="fas fa-tools"></i></div>
                    <h4>UNIT ENTRY SERVICE</h4>
                </div>
                <div class="stats-area">
                    <div class="stat-item">
                        <span class="stat-num">{{ $data['entry']['bulan'] ?? 0 }}</span>
                        <span class="stat-text">Bulan</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">{{ $data['entry']['hari_ini'] ?? 0 }}</span>
                        <span class="stat-text">Hari Ini</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">{{ $data['entry']['target'] ?? 0 }}</span>
                        <span class="stat-text">Target</span>
                    </div>
                </div>
            </div>

            <!-- UNIT SPOORING BALANCING -->
            <div class="service-card modern-orange">
                <div class="card-title-area">
                    <div class="icon-wrap"><i class="fas fa-car-side"></i></div>
                    <h4>UNIT SPOORING BALANCING</h4>
                </div>
                <div class="stats-area">
                    <div class="stat-item">
                        <span class="stat-num">{{ $data['spooring']['bulan'] ?? 0 }}</span>
                        <span class="stat-text">Bulan</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">{{ $data['spooring']['hari_ini'] ?? 0 }}</span>
                        <span class="stat-text">Hari Ini</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">{{ $data['spooring']['target'] ?? 80 }}</span>
                        <span class="stat-text">Target</span>
                    </div>
                </div>
            </div>

            <!-- UNIT AC -->
            <div class="service-card modern-green">
                <div class="card-title-area">
                    <div class="icon-wrap"><i class="fas fa-snowflake"></i></div>
                    <h4>UNIT AC</h4>
                </div>
                <div class="stats-area">
                    <div class="stat-item">
                        <span class="stat-num">{{ $data['ac']['bulan'] ?? 0 }}</span>
                        <span class="stat-text">Bulan</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">{{ $data['ac']['hari_ini'] ?? 0 }}</span>
                        <span class="stat-text">Hari Ini</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">{{ $data['ac']['target'] ?? 80 }}</span>
                        <span class="stat-text">Target</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

@endsection