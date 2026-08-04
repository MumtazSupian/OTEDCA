@extends('layouts.app')

@section('title', 'Dashboard Sales (Stock)')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard Sales (Stock)</h1>
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
    <h2 style="font-size:18px;font-weight:600;margin:24px 0 16px;">Ringkasan Stok Kendaraan per Model</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px;">
        @forelse($stockByMobil as $mobil)
            <div style="background:var(--bg-primary);border:1px solid var(--border-color);border-radius:12px;padding:16px;box-shadow:0 1px 3px rgba(0,0,0,0.05);display:flex;flex-direction:column;justify-content:space-between;">
                <div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                        <h3 style="font-size:15px;font-weight:700;color:var(--text-primary);margin:0;">{{ $mobil->nama_mobil }}</h3>
                        <span style="background:rgba(59,130,246,.1);color:#dc2626;font-size:12px;font-weight:700;padding:4px 10px;border-radius:20px;">
                            {{ $mobil->total }} Unit
                        </span>
                    </div>
                    @if(!empty($mobil->image))
                        <div style="text-align:center;margin:12px 0;">
                            <img src="{{ asset('assets/images/cars/' . $mobil->image) }}" alt="{{ $mobil->nama_mobil }}" style="max-height:100px;object-fit:contain;">
                        </div>
                    @endif
                    @if(count($mobil->varian_counts) > 0)
                        <div style="margin-top:10px;font-size:11px;color:var(--text-muted);">
                            <strong>Varian:</strong>
                            <ul style="margin:4px 0 0 16px;padding:0;">
                                @foreach($mobil->varian_counts as $varian => $count)
                                    <li>{{ $varian }}: <strong>{{ $count }}</strong></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(count($mobil->warna_counts) > 0)
                        <div style="margin-top:8px;font-size:11px;color:var(--text-muted);">
                            <strong>Warna:</strong>
                            <ul style="margin:4px 0 0 16px;padding:0;">
                                @foreach($mobil->warna_counts as $warna => $count)
                                    <li>{{ $warna }}: <strong>{{ $count }}</strong></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div style="margin-top:16px;padding-top:12px;border-top:1px solid var(--border-color);text-align:right;">
                    <a href="{{ url('/admin/stocks?nama_mobil=' . urlencode($mobil->nama_mobil)) }}" style="color:#dc2626;font-weight:600;font-size:12px;text-decoration:none;">Lihat Stok &rarr;</a>
                </div>
            </div>
        @empty
            <div style="grid-column:1/-1;padding:24px;text-align:center;color:var(--text-muted);">
                Tidak ada data stok kendaraan.
            </div>
        @endforelse
    </div>
@endsection
