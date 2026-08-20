@extends('layouts.app')

@section('content')
<style>
    /* Modern Dashboard Styling */
    .dashboard-wrapper {
        padding: 10px;
        background-color: #f8f9fc;
        min-height: calc(100vh - 100px);
        margin: -20px;
        padding: 30px;
    }

    .modern-header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 35px;
        background: #fff;
        padding: 20px 30px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }

    .modern-title {
        margin: 0;
        font-size: 24px;
        font-weight: 800;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .modern-title i {
        color: #3498db;
        font-size: 28px;
        background: -webkit-linear-gradient(135deg, #3498db, #2ecc71);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .modern-filter {
        background: #f8f9fc;
        border: 1px solid #edf2f9;
        padding: 10px 20px;
        border-radius: 30px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #555;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.01);
    }
    
    .modern-filter:hover {
        border-color: #3498db;
        background: #fff;
        box-shadow: 0 4px 10px rgba(52, 152, 219, 0.1);
    }

    .modern-filter select {
        background: transparent;
        border: none;
        outline: none;
        color: #2c3e50;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        padding-right: 10px;
    }

    .cabang-section {
        margin-bottom: 45px;
    }

    .modern-cabang-title {
        font-size: 22px;
        color: #1a237e;
        font-weight: 800;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .modern-cabang-title::before {
        content: '';
        width: 6px;
        height: 28px;
        background: linear-gradient(to bottom, #3498db, #2ecc71);
        border-radius: 4px;
        display: inline-block;
    }

    .cards-row {
        display: flex;
        gap: 25px;
        flex-wrap: wrap;
    }

    .service-card {
        flex: 1;
        min-width: 320px;
        background: #fff;
        border-radius: 20px;
        padding: 25px;
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
        transform: translateY(-8px);
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

<div class="dashboard-wrapper">
    <div class="modern-header-section">
        <h2 class="modern-title">
            <i class="fas fa-chart-pie"></i>
            Monitoring Service Cabang
        </h2>
        
        <form method="GET" action="{{ route('service.service-ac.monitoring') }}" style="margin: 0;">
            <div class="modern-filter">
                <i class="far fa-calendar-alt text-primary" style="color: #3498db;"></i>
                <span>Filter Bulan:</span>
                <select name="periode" onchange="this.form.submit()">
                    @foreach($availableDates as $date)
                        <option value="{{ $date['value'] }}" {{ $currentFilter == $date['value'] ? 'selected' : '' }}>
                            {{ $date['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    @foreach($dataCabang as $cabang => $data)
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
                        <span class="stat-num">{{ $data['spooring']['target'] ?? 0 }}</span>
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
                        <span class="stat-num">{{ $data['ac']['target'] ?? 0 }}</span>
                        <span class="stat-text">Target</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
