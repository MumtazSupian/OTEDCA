@extends('layouts.app')

@section('title', 'Dashboard(Stock)')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard(Stock)</h1>
            <p class="page-subtitle">Ringkasan Unit & Status Stock Kendaraan DCA</p>
        </div>
        <div class="server-time">
            <span class="dot"></span>
            <span>Waktu Server: {{ now()->setTimezone('Asia/Jakarta')->format('d M Y \\p\\u\\k\\u\\l H.i') }} WIB</span>
        </div>
    </div>

    {{-- Stock Summaries --}}
    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(59,130,246,.15); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-car" style="color: #dc2626; font-size: 1.5rem;"></i>
            </div>
            <div class="stat-value" style="color:#dc2626;">{{ $totalStock ?? 0 }}</div>
            <div class="stat-label">Total Stock</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(16,185,129,.15); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.5rem;"></i>
            </div>
            <div class="stat-value" style="color:#10b981;">{{ $stockByStatus['free'] ?? 0 }}</div>
            <div class="stat-label">Stock Free</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(239,68,68,.15); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-clock" style="color: #ef4444; font-size: 1.5rem;"></i>
            </div>
            <div class="stat-value" style="color:#ef4444;">{{ $stockByStatus['matching'] ?? 0 }}</div>
            <div class="stat-label">Stock Matching</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(139,92,246,.15); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-handshake" style="color: #8b5cf6; font-size: 1.5rem;"></i>
            </div>
            <div class="stat-value" style="color:#8b5cf6;">{{ $stockByStatus['sold'] ?? 0 }}</div>
            <div class="stat-label">Stock Sold (Bulan Ini)</div>
        </div>
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
            'S-PRESSO' => 'linear-gradient(135deg, #f59e0b, #fbbf24)',
            'ERTIGA-HYBRID' => 'linear-gradient(135deg, #0ea5e9, #38bdf8)',
        ];
    @endphp
    
    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(280px, 1fr));gap:20px;margin-top:20px;">
        @forelse($stockByMobil as $mobil)
            @php
                $bgGradient = $cardGradients[$mobil->nama_mobil] ?? 'linear-gradient(135deg, #9ca3af, #d1d5db)';
            @endphp
            <div style="background:#fff;border-radius:12px;box-shadow:0 4px 6px rgba(0,0,0,0.05);display:flex;flex-direction:column;border:1px solid #f3f4f6;overflow:hidden;">
                
                {{-- Card Header --}}
                <div style="position:relative;height:150px;background:{{ $bgGradient }};display:flex;justify-content:center;align-items:center;">
                    <!-- Decor Circles -->
                    <div style="position:absolute;width:150px;height:150px;background:rgba(255,255,255,0.1);border-radius:50%;bottom:-50px;left:-50px;"></div>
                    <div style="position:absolute;width:80px;height:80px;background:rgba(255,255,255,0.15);border-radius:50%;top:-20px;right:-20px;"></div>
                    
                    <!-- Unit Badge -->
                    <span style="position:absolute;top:12px;right:12px;background:rgba(255,255,255,0.3);color:#fff;font-size:11px;font-weight:700;padding:4px 10px;border-radius:20px;z-index:2;backdrop-filter:blur(4px);">
                        {{ $mobil->total }} Unit
                    </span>

                    <!-- Car Image -->
                    @if(!empty($mobil->image))
                        <img src="{{ asset('assets/' . $mobil->image) }}" alt="{{ $mobil->nama_mobil }}" style="max-height:110px;object-fit:contain;z-index:2;filter:drop-shadow(0 10px 8px rgba(0,0,0,0.3));">
                    @endif
                </div>

                {{-- Card Body --}}
                <div style="padding:16px;">
                    <h3 style="font-size:15px;font-weight:700;color:#1f2937;margin:0 0 16px 0;">{{ $mobil->nama_mobil }}</h3>
                    
                    @if(count($mobil->varian_counts) > 0)
                        <div style="margin-bottom:12px;">
                            <div style="font-size:10px;font-weight:700;color:#9ca3af;margin-bottom:6px;letter-spacing:0.5px;">VARIAN</div>
                            <div style="display:flex;flex-wrap:wrap;gap:6px;">
                                @foreach($mobil->varian_counts as $varian => $count)
                                    <span style="background:#f8fafc;color:#475569;font-size:9.5px;font-weight:600;padding:4px 8px;border-radius:4px;border:1px solid #e2e8f0;">
                                        {{ $varian }} ({{ $count }})
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    @if(count($mobil->warna_counts) > 0)
                        <div>
                            <div style="font-size:10px;font-weight:700;color:#9ca3af;margin-bottom:6px;letter-spacing:0.5px;">WARNA</div>
                            <div style="display:flex;flex-wrap:wrap;gap:6px;">
                                @foreach($mobil->warna_counts as $warna => $count)
                                    <span style="background:#f8fafc;color:#475569;font-size:9.5px;font-weight:600;padding:4px 8px;border-radius:4px;border:1px solid #e2e8f0;">
                                        {{ $warna }} ({{ $count }})
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                
            </div>
        @empty
            <div style="grid-column:1/-1;padding:24px;text-align:center;color:var(--text-muted);">
                Tidak ada data stok kendaraan.
            </div>
        @endforelse
    </div>
@endsection
