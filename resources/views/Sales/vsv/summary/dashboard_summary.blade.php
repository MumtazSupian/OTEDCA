@extends('layouts.app')

@section('content')
    <div
        style="padding: 40px 20px; min-height: calc(100vh - 100px); display: flex; flex-direction: column; align-items: center;">

        <div style="text-align: center; margin-bottom: 40px;">
            <h1
                style="color: #1e293b; font-size: 24px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; margin: 0;">
                📊 Dashboard Summary
            </h1>
            <div style="width: 60px; height: 4px; background: #dc2626; margin: 10px auto; border-radius: 10px;"></div>
            <p style="color: #64748b; font-size: 14px; margin-top: 5px;">Pilih modul yang ingin kamu kelola</p>
        </div>

        <div
            style="
        display: flex; 
        justify-content: center; 
        align-items: stretch;
        gap: 25px; 
        width: 100%; 
        max-width: 800px;
        flex-wrap: wrap;
    ">

            <div class="activity-card">
                <div class="icon-box">📋</div>
                <h3>Summary</h3>
                <p>Kelola data summary activity, rencana perbaikan, dan evaluasi pelaksanaan.</p>
                <a href="{{ route('summary.summary.index') }}" class="activity-btn">Masuk</a>
            </div>

            <div class="activity-card">
                <div class="icon-box">⚡</div>
                <h3>Action Plan</h3>
                <p>Kelola action plan dan tindak lanjut dari summary activity.</p>
                <a href="{{ route('summary.summaryaction.index') }}" class="activity-btn">Masuk</a>
            </div>

        </div>
    </div>

    <style>
        .activity-card {
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
            flex: 1 1 300px;
            max-width: 340px;
        }

        .activity-card:hover {
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

        .activity-card h3 {
            color: #1e293b;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .activity-card p {
            color: #64748b;
            font-size: 12px;
            line-height: 1.4;
            margin-bottom: 20px;
            flex-grow: 1;
        }

        .activity-btn {
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

        .activity-btn:hover {
            background: #b91c1c;
            color: #ffffff !important;
        }
    </style>
@endsection
