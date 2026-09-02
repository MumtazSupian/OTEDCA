@extends('layouts.app')

@section('title', 'Dashboard Finance (AR)')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard Finance (AR)</h1>
            <p class="page-subtitle">Ringkasan Data Piutang & Asuransi Konsumen DCA</p>
        </div>
        <div class="server-time">
            <span class="dot"></span>
            <span>Waktu Server: {{ now()->setTimezone('Asia/Jakarta')->format('d M Y \\p\\u\\k\\u\\l H.i') }} WIB</span>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="dashboard-grid">
        {{-- Total Piutang --}}
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(59,130,246,.15); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-calculator" style="color: #dc2626; font-size: 1.5rem;"></i>
            </div>
            <div class="stat-value" style="color:#dc2626;">Rp {{ number_format($totalPiutang ?? 0, 0, ',', '.') }}</div>
            <div class="stat-label">Total Piutang</div>
        </div>

        {{-- Total Konsumen --}}
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(16,185,129,.15);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <div class="stat-value" style="color:#10b981;">{{ $totalKonsumen ?? 0 }}</div>
            <div class="stat-label">Total Konsumen</div>
        </div>

        {{-- Total Konsumen Asuransi --}}
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(249,115,22,.15);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2l7 4v6c0 5-4 9-7 11-3-2-7-6-7-11V6l7-4z" />
                    <path d="M12 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                </svg>
            </div>
            <div class="stat-value" style="color:#f97316;">{{ $totalAsuransi ?? 0 }}</div>
            <div class="stat-label">Total Konsumen Asuransi</div>
        </div>
    </div>

    @php
        $authUser = auth()->user();
        $isPusat = $authUser && ($authUser->is_admin || strtolower($authUser->role ?? '') === 'om');
        $userBranch = strtolower($authUser->branch ?? '');
    @endphp

    {{-- Quick Links --}}
    <div class="table-container" style="padding:24px; margin-top: 16px;">
        <h2 style="font-size:16px;font-weight:600;margin-bottom:16px;">Akses Cepat Cabang</h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;">
            @if($isPusat || $userBranch === 'bp')
            <a href="{{ url('/bp') }}"
                style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:var(--bg-primary);border:1px solid var(--border-color);border-radius:10px;text-decoration:none;color:var(--text-primary);transition:all .2s;">
                <div
                    style="width:36px;height:36px;background:rgba(59,130,246,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="#dc2626" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                </div>
                <div>
                    <div style="font-weight:600;font-size:13px;">BP</div>
                    <div style="font-size:11px;color:var(--text-muted);">Bukti Piutang</div>
                </div>
            </a>
            @endif

            @if($isPusat || $userBranch === 'cinere')
            <a href="{{ url('/gr/cinere') }}"
                style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:var(--bg-primary);border:1px solid var(--border-color);border-radius:10px;text-decoration:none;color:var(--text-primary);transition:all .2s;">
                <div
                    style="width:36px;height:36px;background:rgba(6,182,212,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="#06b6d4" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>
                <div>
                    <div style="font-weight:600;font-size:13px;">GR Cinere</div>
                    <div style="font-size:11px;color:var(--text-muted);">Cabang Cinere</div>
                </div>
            </a>
            @endif

            @if($isPusat || $userBranch === 'jatiasih')
            <a href="{{ url('/gr/jatiasih') }}"
                style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:var(--bg-primary);border:1px solid var(--border-color);border-radius:10px;text-decoration:none;color:var(--text-primary);transition:all .2s;">
                <div
                    style="width:36px;height:36px;background:rgba(16,185,129,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="#10b981" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>
                <div>
                    <div style="font-weight:600;font-size:13px;">GR Jatiasih</div>
                    <div style="font-size:11px;color:var(--text-muted);">Cabang Jatiasih</div>
                </div>
            </a>
            @endif

            @if($isPusat || $userBranch === 'cianjur')
            <a href="{{ url('/gr/cianjur') }}"
                style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:var(--bg-primary);border:1px solid var(--border-color);border-radius:10px;text-decoration:none;color:var(--text-primary);transition:all .2s;">
                <div style="width:36px;height:36px;background:rgba(20,184,166,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="#14b8a6" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>
                <div>
                    <div style="font-weight:600;font-size:13px;">GR Cianjur</div>
                    <div style="font-size:11px;color:var(--text-muted);">Cabang Cianjur</div>
                </div>
            </a>
            @endif

            @if($isPusat || $userBranch === 'ciawi')
            <a href="{{ url('/gr/ciawi') }}"
                style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:var(--bg-primary);border:1px solid var(--border-color);border-radius:10px;text-decoration:none;color:var(--text-primary);transition:all .2s;">
                <div
                    style="width:36px;height:36px;background:rgba(139,92,246,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="#8b5cf6" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>
                <div>
                    <div style="font-weight:600;font-size:13px;">GR Ciawi</div>
                    <div style="font-size:11px;color:var(--text-muted);">Cabang Ciawi</div>
                </div>
            </a>
            @endif
        </div>
    </div>

    @if (!empty($summaryBranches))
        <div class="table-container" style="padding:24px; margin-top: 16px;">
            <h2 style="font-size:16px;font-weight:600;margin-bottom:8px;">Ringkasan Cabang</h2>
            <p style="margin-bottom:16px;color:#6b7280;font-size:13px;">Klik "Detail" untuk melihat rincian tabel pada cabang yang dipilih.</p>
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;min-width:720px;">
                    <thead>
                        <tr style="background:#f9fafb;">
                            <th style="text-align:left;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">Cabang</th>
                            <th style="text-align:right;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">Jumlah Data</th>
                            <th style="text-align:right;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">Saldo Akhir</th>
                            <th style="text-align:right;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">Debet</th>
                            <th style="text-align:right;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">Kredit</th>
                            <th style="text-align:center;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($summaryBranches as $branch => $summary)
                            <tr style="border-bottom:1px solid #e5e7eb;">
                                <td style="padding:14px 10px;font-size:13px;color:#111827;">
                                    {{ strtoupper($branch === 'bp' ? 'BP' : 'GR ' . ucfirst($branch)) }}
                                </td>
                                <td style="padding:14px 10px;font-size:13px;color:#111827;text-align:right;">
                                    {{ $summary['count'] }}
                                </td>
                                <td style="padding:14px 10px;font-size:13px;color:#111827;text-align:right;">
                                    Rp {{ number_format($summary['saldo_akhir'] ?? 0, 0, ',', '.') }}
                                </td>
                                <td style="padding:14px 10px;font-size:13px;color:#111827;text-align:right;">
                                    Rp {{ number_format($summary['debet'] ?? 0, 0, ',', '.') }}
                                </td>
                                <td style="padding:14px 10px;font-size:13px;color:#111827;text-align:right;">
                                    Rp {{ number_format($summary['kredit'] ?? 0, 0, ',', '.') }}
                                </td>
                                <td style="padding:14px 10px;font-size:13px;color:var(--accent-red);text-align:center;">
                                    <a href="{{ $branch === 'bp' ? url('/bp') : url('/gr/' . $branch) }}" style="color:var(--accent-red);text-decoration:none;font-weight:600;">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- BP Insurance Totals (HANYA tampil untuk Superadmin/OM atau Cabang BP) --}}
    @if($isPusat || $userBranch === 'bp')
    <div class="table-container" style="padding:24px; margin-top:16px;">
        <h2 style="font-size:16px;font-weight:600;margin-bottom:8px;">Tabel Asuransi BP</h2>
        <p style="margin-bottom:16px;color:#6b7280;font-size:13px;">Ringkasan nama asuransi dan total konsumen yang menggunakan asuransi tersebut di cabang BP.</p>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;min-width:420px;">
                <thead>
                    <tr style="background:#f9fafb;">
                        <th style="text-align:left;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">Nama Asuransi</th>
                        <th style="text-align:right;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">Total Konsumen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bpInsuranceTotals as $insurance)
                        <tr style="border-bottom:1px solid #e5e7eb;">
                            <td style="padding:14px 10px;font-size:13px;color:#111827;">{{ $insurance->nama_asuransi }}</td>
                            <td style="padding:14px 10px;font-size:13px;color:#111827;text-align:right;">{{ $insurance->total }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="padding:16px 10px;text-align:center;color:#6b7280;">Tidak ada data asuransi BP.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endsection

