@extends('layouts.app')

@section('content')
<div style="padding: 40px 20px; min-height: calc(100vh - 100px); display: flex; flex-direction: column; align-items: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="color: #1e293b; font-size: 26px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; margin: 0;">
            DASHBOARD LEASING
        </h1>
        <div style="width: 60px; height: 4px; background: #dc2626; margin: 12px auto; border-radius: 10px;"></div>
        <p style="color: #64748b; font-size: 14px; margin-top: 5px;">Kelola data aktual transaksi leasing dengan cepat dan terorganisir.</p>
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
        
        <div class="leasing-card">
            <div class="icon-box">📩</div>
            <h3>Aktual Aplikasi In</h3>
            <p>Data aplikasi masuk dari berbagai leasing per bulan.</p>
            <a href="{{ route('leasing.aktual-aplikasi-in.index') }}" class="leasing-btn">Kelola Data</a>
        </div>

        <div class="leasing-card">
            <div class="icon-box">📝</div>
            <h3>Aktual PO</h3>
            <p>Data Purchase Order dari setiap leasing per bulan.</p>
            <a href="{{ route('leasing.aktual-po.index') }}" class="leasing-btn">Kelola Data</a>
        </div>

        <div class="leasing-card">
            <div class="icon-box">🚫</div>
            <h3>Aktual Reject</h3>
            <p>Data penolakan aplikasi dari berbagai leasing per bulan.</p>
            <a href="{{ route('leasing.aktual-reject.index') }}" class="leasing-btn">Kelola Data</a>
        </div>

    </div>
</div>

<style>
    .leasing-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 30px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        box-shadow: 0 4px 14px rgba(0,0,0,0.05);
        transition: all 0.25s ease;
        border: 1px solid #e2e8f0;
        flex: 1 1 270px;
        max-width: 300px;
    }

    .leasing-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 24px rgba(220, 38, 38, 0.12);
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

    .leasing-card h3 {
        color: #1e293b;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .leasing-card p {
        color: #64748b;
        font-size: 12px;
        line-height: 1.4;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    .leasing-btn {
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

    .leasing-btn:hover {
        background: #b91c1c;
        color: #ffffff !important;
    }
</style>
@endsection