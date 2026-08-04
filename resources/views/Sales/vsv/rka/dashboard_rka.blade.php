@extends('layouts.app')

@section('content')
<div style="padding: 40px 20px; min-height: calc(100vh - 100px); display: flex; flex-direction: column; align-items: center;">
    
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="color: #1e293b; font-size: 24px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; margin: 0;">
            Dashboard Target (RKA)
        </h1>
        <div style="width: 60px; height: 4px; background: #dc2626; margin: 10px auto; border-radius: 10px;"></div>
        <p style="color: #64748b; font-size: 14px; margin-top: 5px;">Pilih modul untuk mengelola rencana kerja anggaran.</p>
    </div>

    <div style="
        display: flex; 
        justify-content: center; 
        align-items: stretch;
        gap: 25px; 
        width: 100%; 
        max-width: 1000px;
        flex-wrap: wrap;
    ">
        
        <div class="rka-card">
            <div class="icon-box">🚗</div>
            <h3>Target DO Unit</h3>
            <p>Rencana penjualan unit mobil bulanan.</p>
            <a href="{{ route('target.do_unit') }}" class="rka-btn">Kelola</a>
        </div>

        <div class="rka-card">
            <div class="icon-box">👥</div>
            <h3>Target Salesforce</h3>
            <p>Grading dan performa salesforce.</p>
            <a href="{{ route('target.salesforce') }}" class="rka-btn">Kelola</a>
        </div>

        <div class="rka-card">
            <div class="icon-box">📊</div>
            <h3>Target DO by SOI</h3>
            <p>Analisis DO berdasarkan sumber prospek.</p>
            <a href="{{ route('target.do_by_soi') }}" class="rka-btn">Kelola</a>
        </div>

    </div>
</div>

<style>
    .rka-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 28px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        box-shadow: 0 4px 14px rgba(0,0,0,0.05);
        transition: all 0.25s ease;
        flex: 1 1 270px;
        max-width: 300px;
    }

    .rka-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 24px rgba(220,38,38,0.12);
        border-color: #dc2626;
    }

    .icon-box {
        font-size: 28px;
        background: #fee2e2;
        width: 58px;
        height: 58px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }

    .rka-card h3 {
        color: #1e293b;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .rka-card p {
        color: #64748b;
        font-size: 12px;
        line-height: 1.4;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    .rka-btn {
        background: #dc2626;
        color: #ffffff !important;
        padding: 10px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        font-size: 13px;
        width: 100%;
        transition: 0.25s ease;
        display: inline-block;
    }

    .rka-btn:hover {
        background: #b91c1c;
        color: #ffffff !important;
    }
</style>
@endsection