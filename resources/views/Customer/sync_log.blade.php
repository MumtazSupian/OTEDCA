@extends('layouts.app')

@section('title', 'Sync Log - Riwayat Sinkronisasi')

@section('content')
<div class="synclog-container">
    {{-- HEADER SECTION --}}
    <div class="page-header-row">
        <div>
            <h1 class="page-title">Sync Log</h1>
            <p class="page-subtitle">Riwayat sinkronisasi data customer dari SDMS</p>
        </div>
    </div>

    @if(session('success'))
    <div class="sync-alert sync-alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="sync-alert sync-alert-error">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    {{-- METRIC CARDS STRIP --}}
    <div class="metrics-grid">
        {{-- Total Customer --}}
        <div class="metric-card">
            <div class="metric-lbl">Total Customer</div>
            <div class="metric-val">{{ number_format($metrics['total_customer'] ?? 0, 0, ',', '.') }}</div>
        </div>

        {{-- Sudah Verified --}}
        <div class="metric-card">
            <div class="metric-lbl">Sudah Verified</div>
            <div class="metric-val text-green">{{ number_format($metrics['sudah_verified'] ?? 0, 0, ',', '.') }}</div>
        </div>

        {{-- Duplikat Pending --}}
        <div class="metric-card">
            <div class="metric-lbl">Duplikat Pending</div>
            <div class="metric-val text-orange">{{ number_format($metrics['duplikat_pending'] ?? 0, 0, ',', '.') }}</div>
        </div>

        {{-- Sync Terakhir --}}
        <div class="metric-card card-sync-last">
            <div class="metric-lbl">Sync Terakhir</div>
            <div class="sync-last-row">
                <span class="sync-time-text">{{ $metrics['sync_terakhir'] ?? '-' }}</span>
            </div>
            @if(!empty($metrics['status_terakhir']))
                <div class="sync-status-badge-wrap">
                    <span class="badge-status-pill badge-completed">{{ $metrics['status_terakhir'] }}</span>
                </div>
            @endif
        </div>
    </div>

    {{-- SCHEDULED SYNC INFO CARD --}}
    <div class="schedule-banner-card">
        <div class="schedule-icon-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
        </div>
        <div class="schedule-text-info">
            <h4 class="schedule-title">{{ $syncSchedule['type'] ?? 'Sync Otomatis (Incremental)' }}</h4>
            <p class="schedule-desc">
                {{ $syncSchedule['schedule'] ?? 'Setiap hari pukul 00:00 WIB' }} • 
                Berikutnya: <strong>{{ $syncSchedule['next_run'] ?? '14 jam dari sekarang' }}</strong> • 
                Terakhir: <strong>{{ $syncSchedule['last_run'] ?? '-' }}</strong>
            </p>
        </div>
    </div>

    {{-- 4. TABLE SECTION --}}
    <div class="table-card-wrapper">
        {{-- Toolbar Subheader --}}
        <div class="table-subtoolbar">
            <div class="table-title-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <span>Riwayat Sync Run</span>
            </div>
            <div>
                <a href="{{ route('customer.sync_log') }}" class="btn-refresh-icon" title="Refresh Log">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 4 23 10 17 10"></polyline>
                        <polyline points="1 20 1 14 7 14"></polyline>
                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="sync-table">
                <thead>
                    <tr>
                        <th style="min-width: 100px;">Tipe</th>
                        <th style="min-width: 150px;">Mulai</th>
                        <th style="min-width: 150px;">Selesai</th>
                        <th style="min-width: 110px;">Status</th>
                        <th style="min-width: 130px;">Progress</th>
                        <th style="min-width: 100px;">Pair Baru</th>
                        <th style="min-width: 110px;">Auto Resolve</th>
                        <th style="min-width: 250px;">Error</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($syncLogs as $log)
                    @php
                        $logType = is_array($log) ? ($log['type'] ?? 'Incremental') : ($log->type ?? 'Incremental');
                        $logMulai = $log instanceof \App\Models\Customer\SyncLog ? ($log->mulai ? $log->mulai->format('d/m/Y, H.i') : '-') : ($log['mulai'] ?? '-');
                        $logSelesai = $log instanceof \App\Models\Customer\SyncLog ? ($log->selesai ? $log->selesai->format('d/m/Y, H.i') : '-') : ($log['selesai'] ?? '-');
                        $logStatus = is_array($log) ? ($log['status'] ?? 'completed') : ($log->status ?? 'completed');
                        $logProgress = is_array($log) ? ($log['progress'] ?? '-') : ($log->progress ?: '-');
                        $logPairBaru = is_array($log) ? ($log['pair_baru'] ?? '-') : ($log->pair_baru !== null ? $log->pair_baru : '-');
                        $logAutoResolve = is_array($log) ? ($log['auto_resolve'] ?? '-') : ($log->auto_resolve !== null ? $log->auto_resolve : '-');
                        $logError = is_array($log) ? ($log['error'] ?? null) : ($log->error ?: null);
                    @endphp
                    <tr>
                        <td>
                            <span class="badge-type {{ strtolower($logType) == 'full' ? 'badge-type-full' : 'badge-type-incremental' }}">
                                {{ $logType }}
                            </span>
                        </td>
                        <td>{{ $logMulai }}</td>
                        <td>{{ $logSelesai }}</td>
                        <td>
                            <span class="badge-status-pill {{ strtolower($logStatus) == 'completed' ? 'badge-completed' : 'badge-failed' }}">
                                {{ $logStatus }}
                            </span>
                        </td>
                        <td>{{ $logProgress }}</td>
                        <td>{{ $logPairBaru }}</td>
                        <td>{{ $logAutoResolve }}</td>
                        <td>
                            @if(!empty($logError) && $logError !== '-')
                                <a href="javascript:void(0)" class="error-cell-link" onclick="openErrorModal({{ json_encode($logError) }})">
                                    <span class="error-text-truncate">{{ $logError }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                        <polyline points="15 3 21 3 21 9"></polyline>
                                        <line x1="10" y1="14" x2="21" y2="3"></line>
                                    </svg>
                                </a>
                            @else
                                <span style="color: #cbd5e1;">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center" style="padding: 40px; color: #94a3b8; text-align: center;">
                            Belum ada riwayat sinkronisasi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 5. PAGINATION FOOTER --}}
        @if($syncLogs instanceof \Illuminate\Pagination\AbstractPaginator && $syncLogs->hasPages())
        <div class="table-pagination-footer">
            <div class="pagination-controls">
                {{-- First & Prev --}}
                @if($syncLogs->currentPage() > 1)
                    <a href="{{ $syncLogs->url(1) }}" class="btn-page" title="Halaman Pertama">«</a>
                    <a href="{{ $syncLogs->previousPageUrl() }}" class="btn-page" title="Sebelumnya">‹</a>
                @else
                    <button type="button" class="btn-page btn-disabled" disabled>«</button>
                    <button type="button" class="btn-page btn-disabled" disabled>‹</button>
                @endif

                {{-- Page Window --}}
                @php
                    $start = max(1, $syncLogs->currentPage() - 2);
                    $end = min($syncLogs->lastPage(), $syncLogs->currentPage() + 2);
                @endphp

                @for($p = $start; $p <= $end; $p++)
                    @if($p == $syncLogs->currentPage())
                        <button type="button" class="btn-page btn-page-active">{{ $p }}</button>
                    @else
                        <a href="{{ $syncLogs->url($p) }}" class="btn-page">{{ $p }}</a>
                    @endif
                @endfor

                {{-- Next & Last --}}
                @if($syncLogs->hasMorePages())
                    <a href="{{ $syncLogs->nextPageUrl() }}" class="btn-page" title="Selanjutnya">›</a>
                    <a href="{{ $syncLogs->url($syncLogs->lastPage()) }}" class="btn-page" title="Halaman Terakhir">»</a>
                @else
                    <button type="button" class="btn-page btn-disabled" disabled>›</button>
                    <button type="button" class="btn-page btn-disabled" disabled>»</button>
                @endif
            </div>

            <div class="pagination-rows-select">
                <select class="select-page-rows" onchange="location.href='{{ request()->fullUrlWithQuery(['per_page' => '___']) }}'.replace('___', this.value)">
                    <option value="20" {{ ($perPage ?? 20) == 20 ? 'selected' : '' }}>20 / halaman</option>
                    <option value="50" {{ ($perPage ?? 20) == 50 ? 'selected' : '' }}>50 / halaman</option>
                    <option value="100" {{ ($perPage ?? 20) == 100 ? 'selected' : '' }}>100 / halaman</option>
                </select>
            </div>
        </div>
        @else
        <div class="table-pagination-footer">
            <div class="pagination-controls">
                <button type="button" class="btn-page btn-disabled" disabled>«</button>
                <button type="button" class="btn-page btn-disabled" disabled>‹</button>
                <button type="button" class="btn-page btn-page-active">1</button>
                <button type="button" class="btn-page btn-disabled" disabled>›</button>
                <button type="button" class="btn-page btn-disabled" disabled>»</button>
            </div>

            <div class="pagination-rows-select">
                <select class="select-page-rows" onchange="location.href='{{ request()->fullUrlWithQuery(['per_page' => '___']) }}'.replace('___', this.value)">
                    <option value="20" {{ ($perPage ?? 20) == 20 ? 'selected' : '' }}>20 / halaman</option>
                    <option value="50" {{ ($perPage ?? 20) == 50 ? 'selected' : '' }}>50 / halaman</option>
                    <option value="100" {{ ($perPage ?? 20) == 100 ? 'selected' : '' }}>100 / halaman</option>
                </select>
            </div>
        </div>
        @endif
    </div>

    {{-- MODAL: DETAIL ERROR --}}
    <div class="modal-backdrop" id="modalErrorDetail">
        <div class="modal-dialog modal-error-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Detail Error</h3>
                <button type="button" class="btn-modal-close" onclick="closeErrorModal()">&times;</button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div class="error-box-display">
                    <p id="errorModalText" class="error-code-text">-</p>
                </div>
            </div>
            <div class="modal-footer modal-error-footer">
                <button type="button" class="btn-error-copy" onclick="copyErrorText()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                    </svg>
                    <span id="copyBtnText">Copy</span>
                </button>
                <button type="button" class="btn-error-close" onclick="closeErrorModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Global Container */
    .synclog-container {
        padding: 24px 28px 40px 28px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: #1e293b;
        box-sizing: border-box;
    }

    /* Header */
    .page-header-row {
        margin-bottom: 20px;
    }
    .page-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.3px;
    }
    .page-subtitle {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    /* Metrics Grid */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }
    .metric-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 16px 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 4px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.05);
    }
    .metric-lbl {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }
    .metric-val {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
    }
    .text-green {
        color: #15803d !important;
    }
    .text-orange {
        color: #d97706 !important;
    }
    .card-sync-last {
        position: relative;
    }
    .sync-last-row {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 2px;
    }
    .sync-status-badge-wrap {
        margin-top: 6px;
    }

    /* Schedule Info Card */
    .schedule-banner-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 16px 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 24px;
    }
    .schedule-icon-box {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #fef2f2;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .schedule-text-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .schedule-title {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .schedule-desc {
        font-size: 12px;
        color: #64748b;
        margin: 0;
    }

    /* Table Section */
    .table-card-wrapper {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }
    /* Alerts */
    .sync-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 20px;
        animation: modalFadeSlide 0.25s ease;
    }
    .sync-alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }
    .sync-alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    /* Trigger Sync Button */
    .btn-sync-trigger {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.2);
        transition: all 0.2s ease;
    }
    .btn-sync-trigger:hover {
        background: linear-gradient(135deg, #b91c1c, #991b1b);
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3);
    }
    .btn-sync-trigger:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    .table-subtoolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }
    .table-title-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
    }
    .btn-refresh-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 6px;
        color: #ef4444;
        background: #fee2e2;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-refresh-icon:hover {
        background: #fecaca;
        color: #dc2626;
    }

    /* Table */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }
    .sync-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12.5px;
    }
    .sync-table thead th {
        background: #ffffff;
        color: #475569;
        font-weight: 700;
        font-size: 12px;
        padding: 12px 14px;
        border-bottom: 1.5px solid #e2e8f0;
        white-space: nowrap;
    }
    .sync-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .sync-table tbody tr:hover {
        background-color: #f8fafc;
    }
    .sync-table tbody td {
        padding: 12px 14px;
        color: #334155;
        vertical-align: middle;
    }

    /* Badges */
    .badge-type {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 5px;
        display: inline-block;
    }
    .badge-type-incremental {
        background: #e0f2fe;
        color: #0369a1;
    }
    .badge-type-full {
        background: #ffedd5;
        color: #c2410c;
    }
    .badge-status-pill {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 5px;
        display: inline-block;
    }
    .badge-completed {
        background: #dcfce7;
        color: #15803d;
    }
    .badge-failed {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* Error Link Cell */
    .error-cell-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #dc2626;
        text-decoration: none;
        font-size: 12px;
        max-width: 320px;
        transition: color 0.15s;
    }
    .error-cell-link:hover {
        color: #991b1b;
        text-decoration: underline;
    }
    .error-text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Pagination */
    .table-pagination-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 18px;
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
        flex-wrap: wrap;
        gap: 12px;
    }
    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 4px;
        margin: 0 auto;
    }
    .btn-page {
        min-width: 30px;
        height: 30px;
        padding: 0 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #475569;
        font-size: 12.5px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-page:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }
    .btn-page-active {
        background: #dc2626 !important;
        border-color: #dc2626 !important;
        color: #ffffff !important;
        font-weight: 800;
    }
    .select-page-rows {
        height: 32px;
        padding: 4px 8px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        outline: none;
    }

    /* Modal Backdrop & Dialog */
    .modal-backdrop {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
    }
    .modal-dialog {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: modalFadeSlide 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        max-width: 100%;
        box-sizing: border-box;
    }
    @keyframes modalFadeSlide {
        from { opacity: 0; transform: translateY(12px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 22px;
        border-bottom: 1px solid #e2e8f0;
    }
    .modal-title {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .btn-modal-close {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        font-size: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        transition: all 0.15s ease;
    }
    .btn-modal-close:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fecaca;
    }

    /* Modal Error Specific */
    .modal-error-dialog {
        width: 540px;
    }
    .error-box-display {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px 18px;
    }
    .error-code-text {
        font-family: 'JetBrains Mono', 'Courier New', monospace;
        font-size: 12.5px;
        color: #b91c1c;
        line-height: 1.5;
        margin: 0;
        word-break: break-word;
    }
    .modal-error-footer {
        padding: 14px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    .btn-error-copy {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-error-copy:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }
    .btn-error-close {
        padding: 7px 20px;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25);
        transition: all 0.15s ease;
    }
    .btn-error-close:hover {
        background: linear-gradient(135deg, #b91c1c, #991b1b);
    }
</style>

<script>
    function openErrorModal(errorText) {
        document.getElementById('errorModalText').textContent = errorText;
        document.getElementById('copyBtnText').textContent = 'Copy';
        document.getElementById('modalErrorDetail').style.display = 'flex';
    }

    function closeErrorModal() {
        document.getElementById('modalErrorDetail').style.display = 'none';
    }

    function copyErrorText() {
        const text = document.getElementById('errorModalText').textContent;
        navigator.clipboard.writeText(text).then(function() {
            document.getElementById('copyBtnText').textContent = 'Tersalin!';
            setTimeout(function() {
                document.getElementById('copyBtnText').textContent = 'Copy';
            }, 2000);
        });
    }

    // Close on backdrop click
    window.addEventListener('click', function(event) {
        const errorModal = document.getElementById('modalErrorDetail');
        if (event.target === errorModal) {
            closeErrorModal();
        }
    });
</script>
@endsection
