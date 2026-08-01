@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Operation Transformation Excellent DCA</p>
        </div>
        <div class="server-time">
            <span class="dot"></span>
            <span>Waktu Server: {{ now()->setTimezone('Asia/Jakarta')->format('d M Y \\p\\u\\k\\u\\l H.i') }} WIB</span>
        </div>
    </div>

    @if(auth()->check() && auth()->user()->is_admin)
    {{-- Summary Cards --}}
    <div class="dashboard-grid">
        {{-- Total Piutang --}}
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(59,130,246,.15); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-calculator" style="color: #3b82f6; font-size: 1.5rem;"></i>
            </div>
            <div class="stat-value" style="color:#3b82f6;">Rp {{ number_format($totalPiutang ?? 0, 0, ',', '.') }}</div>
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
    @endif

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

    @if(auth()->check() && auth()->user()->is_admin)
        {{-- Quick Links --}}
        <div class="table-container" style="padding:24px;">
            <h2 style="font-size:16px;font-weight:600;margin-bottom:16px;">Akses Cepat</h2>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;">
                <a href="{{ url('/bp') }}"
                    style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:var(--bg-primary);border:1px solid var(--border-color);border-radius:10px;text-decoration:none;color:var(--text-primary);transition:all .2s;">
                    <div
                        style="width:36px;height:36px;background:rgba(59,130,246,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="#3b82f6" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:13px;">BP</div>
                        <div style="font-size:11px;color:var(--text-muted);">Bukti Piutang</div>
                    </div>
                </a>
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
            </div>
        </div>

        {{-- BP Insurance Totals --}}
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

        @if(auth()->check() && auth()->user()->is_admin_stock)
        {{-- Visual Divider --}}
        <!-- <hr style="margin: 40px 0 10px 0; border: none; border-top: 2px dashed #cbd5e1;"> -->

        {{-- Stock Summaries --}}
        <h2 style="font-size:18px;font-weight:600;margin:16px 0 16px;">Data Kendaraan Stock</h2>
        <div class="dashboard-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background:rgba(59,130,246,.15); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-car" style="color: #3b82f6; font-size: 1.5rem;"></i>
                </div>
                <div class="stat-value" style="color:#3b82f6;">{{ $totalStock ?? 0 }}</div>
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
                <div class="stat-label">Stock Sold</div>
            </div>
        </div>

        <div style="margin-top: 28px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                <div>
                    <h2 style="font-size:18px;font-weight:700;color:#0f172a;margin:0 0 4px;">Jenis Mobil (Stock)</h2>
                    <p style="margin:0;color:#64748b;font-size:13px;">Ringkasan jumlah stock berdasarkan nama/jenis mobil.</p>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(360px, 1fr)); gap:24px;">
                @forelse($stockByMobil ?? [] as $mobil)
                @php
                    // Pengaturan Warna
                    $gradients = [
                        'NEW CARRY'     => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                        'APV'           => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                        'ERTIGA-HYBRID' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                        'NEW XL-7'      => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)', 
                        'GRAND-VITARA'  => 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
                        'JIMMY'         => 'linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%)',
                        'FRONX'         => 'linear-gradient(135deg, #fccb90 0%, #d57eeb 100%)',
                        'S-PRESSO'      => 'linear-gradient(135deg, #f6d365 0%, #fda085 100%)',
                    ];
                    $grad = $gradients[$mobil->nama_mobil] ?? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';

                    // Pengaturan Gambar (Menyesuaikan dengan nama file di VS Code kamu)
                    $images = [
                        'NEW CARRY'     => 'Suzuki-Carry.png',
                        'APV'           => 'Suzuki-Apv.png',
                        'ERTIGA-HYBRID' => 'Suzuki-Ertiga-Hybrid.png',
                        'NEW XL-7'      => 'XL7_Hybrid.png',                                    
                        'GRAND-VITARA'  => 'Grand-Vitara.png',
                        'JIMMY'         => 'Jimmy.png',
                        'FRONX'         => 'suzuki-fronx.png',
                        'S-PRESSO'      => 'Suzuki-Spresso.png',
                    ];
                    // Ambil nama file dari array, kalau tidak ketemu jadikan null
                    $imgFile = $images[$mobil->nama_mobil] ?? null;
                @endphp
                <div style="
                    background:#ffffff;
                    border-radius:20px;
                    overflow:hidden;
                    box-shadow: 0 4px 24px rgba(0,0,0,0.08), 0 1px 4px rgba(0,0,0,0.04);
                    transition: transform 0.25s ease, box-shadow 0.25s ease;
                    position:relative;
                " onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 24px rgba(0,0,0,0.08)';">

                    {{-- Header gradient with image --}}
                    <div style="height:180px; background:{{ $grad }}; position:relative; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                        {{-- decorative circles --}}
                        <div style="position:absolute;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,0.1);top:-30px;right:-30px;"></div>
                        <div style="position:absolute;width:80px;height:80px;border-radius:50%;background:rgba(255,255,255,0.08);bottom:-20px;left:-20px;"></div>

                        {{-- total badge --}}
                        <div style="position:absolute;top:12px;right:14px;background:rgba(255,255,255,0.25);backdrop-filter:blur(8px);border-radius:20px;padding:4px 12px;font-size:12px;font-weight:700;color:#fff;border:1px solid rgba(255,255,255,0.4); z-index: 10;">
                            {{ $mobil->total }} Unit
                        </div>

                        @if($imgFile)
                            <img src="{{ asset('assets/' . $imgFile) }}"
                                 alt="{{ $mobil->nama_mobil }}"
                                 style="max-height:130px; max-width:85%; object-fit:contain; filter:drop-shadow(0 8px 20px rgba(0,0,0,0.3));"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div style="display:none; flex-direction:column; align-items:center; color:rgba(255,255,255,0.8);">
                                <i class="fas fa-car" style="font-size:3rem; margin-bottom:6px;"></i>
                            </div>
                        @else
                            <div style="display:flex; flex-direction:column; align-items:center; color:rgba(255,255,255,0.8);">
                                <i class="fas fa-car" style="font-size:3rem; margin-bottom:6px;"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Body --}}
                    <div style="padding:18px 20px 20px;">
                        <h3 style="font-size:16px;font-weight:700;color:#0f172a;margin:0 0 14px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            {{ $mobil->nama_mobil }}
                        </h3>

                        {{-- Varian --}}
                        <div style="margin-bottom:10px;">
                            <div style="font-size:11px;font-weight:600;color:#94a3b8;letter-spacing:0.06em;text-transform:uppercase;margin-bottom:4px;">Varian</div>
                            @if(count($mobil->varian_counts) > 0)
                                <div style="display:flex;flex-wrap:wrap;gap:4px;">
                                    @foreach($mobil->varian_counts as $v => $count)
                                        <span style="background:#f1f5f9;color:#475569;font-size:11px;font-weight:500;padding:3px 8px;border-radius:6px;border:1px solid #e2e8f0;">
                                            {{ $v }} ({{ $count }})
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span style="color:#94a3b8;font-size:12px;">-</span>
                            @endif
                        </div>

                        {{-- Warna --}}
                        <div>
                            <div style="font-size:11px;font-weight:600;color:#94a3b8;letter-spacing:0.06em;text-transform:uppercase;margin-bottom:4px;">Warna</div>
                            @if(count($mobil->warna_counts) > 0)
                                <div style="display:flex;flex-wrap:wrap;gap:4px;">
                                    @foreach($mobil->warna_counts as $w => $count)
                                        <span style="background:#f1f5f9;color:#475569;font-size:11px;font-weight:500;padding:3px 8px;border-radius:6px;border:1px solid #e2e8f0;">
                                            {{ $w }} ({{ $count }})
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span style="color:#94a3b8;font-size:12px;">-</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                    <div style="grid-column:1/-1;text-align:center;padding:60px 24px;background:#f8fafc;border-radius:16px;border:2px dashed #e2e8f0;">
                        <i class="fas fa-car" style="font-size:2.5rem;color:#cbd5e1;margin-bottom:12px;display:block;"></i>
                        <div style="color:#94a3b8;font-size:15px;">Belum ada data stock mobil.</div>
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    @if(!empty($selectedBranch))
        <!-- <div class="table-container" style="padding:24px; margin-top:24px;">
            <div style="display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;align-items:center;margin-bottom:16px;">
                <h2 style="font-size:16px;font-weight:600;">
                    Data Cabang {{ strtoupper($selectedBranch === 'bp' ? 'BP' : 'GR ' . ucfirst($selectedBranch)) }}
                </h2>
                <a href="{{ url('/dashboard') }}"
                    style="display:inline-flex;align-items:center;gap:8px;padding:10px 14px;background:transparent;color:#ef4444;border:1px solid #ef4444;border-radius:8px;text-decoration:none;font-size:13px;">Kembali</a>
            </div>
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;min-width:860px;">
                    <thead>
                        <tr style="background:#f3f4f6;">
                            <th
                                style="text-align:left;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">
                                Cabang</th>
                            <th
                                style="text-align:left;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">
                                No SPK</th>
                            <th
                                style="text-align:left;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">
                                No. Bukti</th>
                            <th
                                style="text-align:left;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">
                                Tgl Bukti</th>
                            <th
                                style="text-align:right;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">
                                Debet</th>
                            <th
                                style="text-align:right;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">
                                Kredit</th>
                            <th
                                style="text-align:right;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">
                                Saldo Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($selectedRecords as $record)
                            <tr style="border-bottom:1px solid #e5e7eb;">
                                <td style="padding:12px 10px;font-size:13px;color:#111827;">
                                    {{ $record->branch === 'bp' ? 'BP' : 'GR ' . ucfirst($record->branch) }}</td>
                                <td style="padding:12px 10px;font-size:13px;color:#111827;">{{ $record->no_spk ?? $record->nama_konsumen }}</td>
                                <td style="padding:12px 10px;font-size:13px;color:#111827;">{{ $record->no_bukti }}</td>
                                <td style="padding:12px 10px;font-size:13px;color:#111827;">
                                    {{ optional($record->tgl_bukti)->format('d M Y') }}</td>
                                <td style="padding:12px 10px;font-size:13px;color:#111827;text-align:right;">Rp
                                    {{ number_format($record->debet ?? 0, 0, ',', '.') }}</td>
                                <td style="padding:12px 10px;font-size:13px;color:#111827;text-align:right;">Rp
                                    {{ number_format($record->kredit ?? 0, 0, ',', '.') }}</td>
                                <td style="padding:12px 10px;font-size:13px;color:#111827;text-align:right;">Rp
                                    {{ number_format($record->saldo_akhir ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding:14px 10px;text-align:center;color:#6b7280;">Belum ada data piutang untuk ditampilkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div> -->
    @endif
@endsection
