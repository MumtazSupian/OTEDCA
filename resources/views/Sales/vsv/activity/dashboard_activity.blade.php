@extends('layouts.app')

@section('content')
    <div style="padding: 40px 20px; min-height: calc(100vh - 100px); display: flex; flex-direction: column; align-items: center; font-family: 'Inter', system-ui, -apple-system, sans-serif;">

        <div style="text-align: center; margin-bottom: 35px;">
            <h1 style="color: #0f172a; font-size: 28px; font-weight: 900; letter-spacing: 1.5px; text-transform: uppercase; margin: 0;">
                DASHBOARD ACTIVITY
            </h1>
            <div style="width: 50px; height: 4px; background: linear-gradient(90deg, #dc2626, #ef4444); margin: 12px auto; border-radius: 10px;"></div>
            <p style="color: #64748b; font-size: 14px; margin-top: 6px; max-width: 550px;">
                Kelola matriks perencanaan dan evaluasi realisasi aktivitas marketing dengan cepat, akurat, dan terintegrasi.
            </p>
        </div>

        <div style="
            display: flex; 
            justify-content: center; 
            align-items: stretch;
            gap: 28px; 
            width: 100%; 
            max-width: 850px;
            flex-wrap: wrap;
        ">

            {{-- KARTU 1: ACTIVITY ACTUAL --}}
            <div class="activity-card card-actual">
                <div class="icon-box icon-actual">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                </div>
                <h3>Activity Actual</h3>
                <p class="card-desc">
                    Evaluasi realisasi aktivitas marketing, pencapaian target (INQ, SPK, DO) terhadap data aktual ITS, serta analisis efisiensi biaya (Total Budget & Cost/SPK).
                </p>
                <div class="card-features">
                    <span>✓ Realisasi ITS Result</span>
                    <span>✓ Analisis Cost Efficiency</span>
                </div>
                <a href="{{ route('activity.actual.index') }}" class="activity-btn btn-actual">
                    Buka Activity Actual →
                </a>
            </div>

            {{-- KARTU 2: ACTIVITY PLAN --}}
            <div class="activity-card card-plan">
                <div class="icon-box icon-plan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <h3>Activity Plan</h3>
                <p class="card-desc">
                    Penyusunan rencana kegiatan marketing berkala, penetapan target unit & kategori aktivitas (INQ, SPK, DO), serta alokasi estimasi budget operasional.
                </p>
                <div class="card-features">
                    <span>✓ Perencanaan Target & Budget</span>
                    <span>✓ Monitoring Target Berjalan</span>
                </div>
                <a href="{{ route('activity.plan.index') }}" class="activity-btn btn-plan">
                    Buka Activity Plan →
                </a>
            </div>
        </div>
    </div>

    <style>
        .activity-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 32px 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04), 0 1px 3px rgba(0, 0, 0, 0.02);
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1.5px solid #e2e8f0;
            flex: 1 1 340px;
            max-width: 380px;
            position: relative;
        }

        .activity-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 32px rgba(15, 23, 42, 0.09);
        }

        .card-actual:hover {
            border-color: #dc2626;
        }

        .card-plan:hover {
            border-color: #2563eb;
        }

        .card-badge {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 9999px;
            margin-bottom: 18px;
            letter-spacing: 0.3px;
        }

        .badge-actual {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .badge-plan {
            background: #dbeafe;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .icon-box {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            transition: transform 0.25s ease;
        }

        .activity-card:hover .icon-box {
            transform: scale(1.08);
        }

        .icon-actual {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #dc2626;
        }

        .icon-plan {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #2563eb;
        }

        .activity-card h3 {
            color: #0f172a;
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 10px;
            letter-spacing: -0.2px;
        }

        .card-desc {
            color: #64748b;
            font-size: 13px;
            line-height: 1.55;
            margin-bottom: 18px;
            flex-grow: 1;
        }

        .card-features {
            display: flex;
            flex-direction: column;
            gap: 6px;
            width: 100%;
            margin-bottom: 24px;
            padding: 10px 14px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #f1f5f9;
        }

        .card-features span {
            font-size: 0.76rem;
            color: #475569;
            font-weight: 600;
            text-align: left;
        }

        .activity-btn {
            padding: 12px 18px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 800;
            font-size: 13.5px;
            width: 100%;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            letter-spacing: 0.3px;
        }

        .btn-actual {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
        }

        .btn-actual:hover {
            background: linear-gradient(135deg, #b91c1c, #991c1c);
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.35);
            transform: translateY(-1px);
        }

        .btn-plan {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .btn-plan:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
            transform: translateY(-1px);
        }
    </style>
@endsection
