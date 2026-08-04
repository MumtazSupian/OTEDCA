@extends('layouts.app')

@section('content')
    <div style="padding: 20px 10px; min-height: calc(100vh - 100px); display: flex; flex-direction: column; align-items: center;">

        <div style="text-align: center; margin-bottom: 35px;">
            <h1 style="color: var(--text-main, #1e293b); font-size: 24px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; margin: 0;">
                📈 Dashboard Actual
            </h1>
            <div style="width: 60px; height: 4px; background: var(--accent-red, #dc2626); margin: 10px auto; border-radius: 10px;"></div>
            <p style="color: var(--text-muted, #64748b); font-size: 14px; margin-top: 5px;">Pilih data actual yang ingin kamu kelola.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; width: 100%; max-width: 1200px;">

            {{-- 1. Actual DO By Type --}}
            <div class="rka-card">
                <div class="icon-box">🚗</div>
                <h3>Actual DO By Type</h3>
                <p>Data aktual Delivery Order berdasarkan tipe mobil.</p>
                <a href="{{ route('actual.do_by_type') }}" class="rka-btn">Masuk</a>
            </div>

            {{-- 2. Actual SPK By Type --}}
            <div class="rka-card">
                <div class="icon-box">📝</div>
                <h3>Actual SPK By Type</h3>
                <p>Data aktual SPK berdasarkan tipe mobil.</p>
                <a href="{{ route('actual.spk_by_type') }}" class="rka-btn">Masuk</a>
            </div>

            {{-- 3. Actual Inquiry By Type --}}
            <div class="rka-card">
                <div class="icon-box">📞</div>
                <h3>Actual Inquiry By Type</h3>
                <p>Data aktual inquiry berdasarkan tipe kendaraan.</p>
                <a href="{{ route('actual.inquiry_by_type') }}" class="rka-btn">Masuk</a>
            </div>

            {{-- 4. Actual Source Inquiry --}}
            <div class="rka-card">
                <div class="icon-box">🔍</div>
                <h3>Actual Source Inquiry</h3>
                <p>Data aktual inquiry berdasarkan sumber inquiry.</p>
                <a href="{{ route('actual.source_inquiry') }}" class="rka-btn">Masuk</a>
            </div>

            {{-- 5. Actual Source DO Inquiry --}}
            <div class="rka-card">
                <div class="icon-box">📊</div>
                <h3>Actual Source DO Inquiry</h3>
                <p>Data aktual DO inquiry berdasarkan sumber inquiry.</p>
                <a href="{{ route('actual.source_do_inquiry') }}" class="rka-btn">Masuk</a>
            </div>

            {{-- 6. Actual Salesforces --}}
            <div class="rka-card">
                <div class="icon-box">👥</div>
                <h3>Actual Salesforces</h3>
                <p>Data aktual grading salesforce per bulan.</p>
                <a href="{{ route('actual.salesforces') }}" class="rka-btn">Masuk</a>
            </div>

            {{-- 7. Actual DO Salesforces --}}
            <div class="rka-card">
                <div class="icon-box">🤝</div>
                <h3>Actual DO Salesforces</h3>
                <p>Data aktual DO berdasarkan salesforce.</p>
                <a href="{{ route('actual.do_salesforces') }}" class="rka-btn">Masuk</a>
            </div>

            {{-- 8. Actual Sales By Leasing --}}
            <div class="rka-card">
                <div class="icon-box">🏦</div>
                <h3>Actual Sales By Leasing</h3>
                <p>Data aktual penjualan berdasarkan leasing.</p>
                <a href="{{ route('actual.sales_by_leasing') }}" class="rka-btn">Masuk</a>
            </div>

        </div>
    </div>

    <style>
        .rka-card {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 14px;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            transition: all 0.25s ease;
        }

        .rka-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(220, 38, 38, 0.12);
            border-color: var(--accent-red, #dc2626);
        }

        .icon-box {
            font-size: 28px;
            background: #fee2e2;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }

        .rka-card h3 {
            color: var(--text-main, #1e293b);
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .rka-card p {
            color: var(--text-muted, #64748b);
            font-size: 12px;
            line-height: 1.4;
            margin-bottom: 18px;
            flex-grow: 1;
        }

        .rka-btn {
            background: var(--accent-red, #dc2626);
            color: #ffffff !important;
            padding: 9px 14px;
            border-radius: 7px;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            width: 100%;
            transition: background 0.2s ease;
        }

        .rka-btn:hover {
            background: #b91c1c;
            color: #ffffff !important;
        }

        @media (max-width: 991px) {
            div[style*="grid-template-columns"] {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }
    </style>
@endsection