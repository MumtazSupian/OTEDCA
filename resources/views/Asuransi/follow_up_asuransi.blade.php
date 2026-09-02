@extends('layouts.app')

@section('title', 'Follow-Up Asuransi - OTE DCA')

@section('content')
<div class="followup-asuransi-container">
    {{-- 1. HEADER SECTION --}}
    <div class="page-header-row">
        <div class="header-text-group">
            <h1 class="page-title">Follow-Up Asuransi</h1>
            <p class="page-subtitle">Daftar kendaraan yang perlu ditindaklanjuti</p>
        </div>
    </div>

    {{-- 2. FILTER & ACTION CARD --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('asuransi.follow_up') }}" id="filterForm">
            <div class="filter-grid">
                {{-- Sales Filter --}}
                <div class="filter-item">
                    <select name="sales" class="select-control">
                        @foreach($salesList as $s)
                            <option value="{{ $s }}" {{ ($sales ?? 'Semua Sales') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Status Filter --}}
                <div class="filter-item">
                    <select name="status" class="select-control">
                        @foreach($statusList as $st)
                            <option value="{{ $st }}" {{ ($status ?? 'Semua Status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tipe Filter --}}
                <div class="filter-item">
                    <select name="tipe" class="select-control">
                        @foreach($tipeList as $tp)
                            <option value="{{ $tp }}" {{ ($tipe ?? 'Semua Tipe') == $tp ? 'selected' : '' }}>{{ $tp }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Overdue Checkbox --}}
                <div class="filter-item-checkbox">
                    <label class="checkbox-label">
                        <input type="checkbox" name="overdue" value="1" {{ !empty($overdue) ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()">
                        <span>Overdue saja</span>
                    </label>
                </div>

                {{-- Search Box --}}
                <div class="filter-item-search">
                    <div class="search-input-wrapper">
                        <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari VIN / konsumen / HP..." class="input-search-control">
                    </div>
                </div>

                {{-- Button Cari --}}
                <div class="filter-btn-box">
                    <button type="submit" class="btn-search-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <span>Cari</span>
                    </button>
                </div>
            </div>
        </form>

        {{-- Export Action Buttons --}}
        <div class="filter-export-row">
            <button type="button" class="btn-export-excel" onclick="alert('Export Excel follow-up sedang dipersiapkan...')">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="8" y1="13" x2="16" y2="13"></line>
                    <line x1="8" y1="17" x2="16" y2="17"></line>
                </svg>
                <span>Export Excel</span>
            </button>
            <button type="button" class="btn-export-pdf" onclick="alert('Export PDF follow-up sedang dipersiapkan...')">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <path d="M9 15h6"></path>
                    <path d="M9 11h6"></path>
                </svg>
                <span>Export PDF</span>
            </button>
        </div>
    </div>

    {{-- 3. TABLE SECTION --}}
    <div class="table-card-wrapper">
        {{-- Toolbar Subheader --}}
        <div class="table-subtoolbar">
            <div class="task-count-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="8" y1="6" x2="21" y2="6"></line>
                    <line x1="8" y1="12" x2="21" y2="12"></line>
                    <line x1="8" y1="18" x2="21" y2="18"></line>
                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                </svg>
                <span>{{ count($taskList) }} task</span>
            </div>
        </div>

        {{-- Responsive Table --}}
        <div class="table-responsive">
            <table class="followup-table">
                <thead>
                    <tr>
                        <th style="min-width: 130px;">Status</th>
                        <th style="min-width: 120px;">Tipe</th>
                        <th style="min-width: 170px;">VIN</th>
                        <th style="min-width: 180px;">Konsumen</th>
                        <th style="min-width: 150px;">Kendaraan</th>
                        <th style="min-width: 140px;">Asuransi Lama</th>
                        <th style="min-width: 120px;">Next F/U</th>
                        <th style="min-width: 100px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($taskList as $t)
                    <tr>
                        <td>
                            <span class="badge-status-followup">{{ $t['status'] ?? 'OPEN' }}</span>
                        </td>
                        <td>
                            <span class="badge-tipe-followup">{{ $t['tipe'] ?? '-' }}</span>
                        </td>
                        <td class="font-mono font-bold">{{ $t['vin'] }}</td>
                        <td>
                            <div class="cell-konsumen">
                                <span class="font-bold">{{ $t['konsumen'] ?? '-' }}</span>
                                @if(!empty($t['no_hp']))
                                    <span class="subtext-hp font-mono">{{ $t['no_hp'] }}</span>
                                @endif
                            </div>
                        </td>
                        <td>{{ $t['kendaraan'] ?? '-' }}</td>
                        <td>{{ $t['asuransi_lama'] ?? '-' }}</td>
                        <td>{{ $t['next_fu'] ?? '-' }}</td>
                        <td style="text-align: center;">
                            <div class="action-btn-group">
                                @if(!empty($t['no_hp']))
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $t['no_hp']) }}" target="_blank" class="btn-icon-action btn-icon-wa" title="Hubungi via WhatsApp">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                                        </svg>
                                    </a>
                                @endif
                                <button type="button" class="btn-icon-action btn-icon-edit" onclick="openModalFollowUp({{ json_encode($t) }})" title="Update Follow-Up">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="empty-state-row">
                            <div class="empty-state-content">
                                <div class="empty-icon-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                                        <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
                                    </svg>
                                </div>
                                <p class="empty-text">Tidak ada task follow-up</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 4. PAGINATION FOOTER --}}
        <div class="table-pagination-footer">
            <div class="pagination-controls">
                <button type="button" class="btn-page" title="Halaman Pertama">«</button>
                <button type="button" class="btn-page" title="Sebelumnya">‹</button>
                <button type="button" class="btn-page" title="Selanjutnya">›</button>
                <button type="button" class="btn-page" title="Halaman Terakhir">»</button>
            </div>

            <div class="pagination-rows-select">
                <select class="select-page-rows">
                    <option value="20">20 / halaman</option>
                    <option value="50" selected>50 / halaman</option>
                    <option value="100">100 / halaman</option>
                </select>
            </div>
        </div>
    </div>

    {{-- MODAL: UPDATE FOLLOW-UP --}}
    <div class="modal-backdrop" id="modalFollowUp">
        <div class="modal-dialog modal-followup-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Update Status Follow-Up</h3>
                <button type="button" class="btn-modal-close" onclick="closeModalFollowUp()">&times;</button>
            </div>
            <div class="modal-body modal-form-body">
                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">Nomor Rangka (VIN)</label>
                        <input type="text" id="modalVin" class="input-form-control font-mono" readonly style="background: #f8fafc;">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Konsumen</label>
                        <input type="text" id="modalKonsumen" class="input-form-control" readonly style="background: #f8fafc;">
                    </div>
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">Status Follow-Up</label>
                        <select id="modalStatus" class="input-form-control">
                            @foreach($statusList as $st)
                                @if($st !== 'Semua Status')
                                    <option value="{{ $st }}">{{ $st }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Next Follow-Up</label>
                        <input type="date" id="modalNextFu" class="input-form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Catatan Interaksi</label>
                    <textarea id="modalCatatan" class="input-form-control" rows="3" placeholder="Hasil komunikasi dengan konsumen..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-edit-cancel" onclick="closeModalFollowUp()">Batal</button>
                <button type="button" class="btn-edit-save" onclick="saveFollowUp()">Simpan Progres</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Global Container */
    .followup-asuransi-container {
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

    /* Filter Card */
    .filter-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 16px 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        margin-bottom: 20px;
    }
    .filter-grid {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }
    .filter-item {
        flex: 1 1 150px;
    }
    .select-control {
        width: 100%;
        height: 38px;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        color: #1e293b;
        box-sizing: border-box;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .select-control:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
    }
    .filter-item-checkbox {
        display: flex;
        align-items: center;
        flex: 0 0 auto;
        padding: 0 4px;
    }
    .checkbox-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
    }
    .filter-item-search {
        flex: 2 1 240px;
    }
    .input-search-control {
        width: 100%;
        height: 38px;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        color: #1e293b;
        box-sizing: border-box;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .input-search-control:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
    }
    .filter-btn-box {
        flex: 0 0 auto;
    }
    .btn-search-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        height: 38px;
        padding: 0 20px;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25);
        transition: all 0.2s ease;
    }
    .btn-search-primary:hover {
        background: linear-gradient(135deg, #b91c1c, #991b1b);
        transform: translateY(-1px);
    }

    /* Export Row */
    .filter-export-row {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        padding-top: 10px;
        border-top: 1px solid #f1f5f9;
    }
    .btn-export-excel {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        background: #10b981;
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-export-excel:hover {
        background: #059669;
    }
    .btn-export-pdf {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        background: #dc2626;
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-export-pdf:hover {
        background: #b91c1c;
    }

    /* Table Section */
    .table-card-wrapper {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }
    .table-subtoolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }
    .task-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
    }

    /* Table */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }
    .followup-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12.5px;
    }
    .followup-table thead th {
        background: #ffffff;
        color: #475569;
        font-weight: 700;
        font-size: 12px;
        padding: 12px 14px;
        border-bottom: 1.5px solid #e2e8f0;
        white-space: nowrap;
    }
    .followup-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .followup-table tbody tr:hover {
        background-color: #f8fafc;
    }
    .followup-table tbody td {
        padding: 12px 14px;
        color: #334155;
        vertical-align: middle;
    }

    .font-mono { font-family: 'JetBrains Mono', monospace; font-size: 12px; }
    .font-bold { font-weight: 700; }

    .cell-konsumen {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .subtext-hp {
        font-size: 11px;
        color: #64748b;
    }

    .badge-status-followup {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 5px;
        background: #eff6ff;
        color: #1d4ed8;
        display: inline-block;
    }
    .badge-tipe-followup {
        font-size: 11px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 4px;
        background: #f1f5f9;
        color: #475569;
        display: inline-block;
    }

    .action-btn-group {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-icon-action {
        width: 26px;
        height: 26px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
    }
    .btn-icon-wa {
        color: #16a34a;
        background: #f0fdf4;
        border-color: #bbf7d0;
    }
    .btn-icon-wa:hover {
        background: #dcfce7;
    }
    .btn-icon-edit {
        color: #2563eb;
        background: #eff6ff;
        border-color: #bfdbfe;
    }
    .btn-icon-edit:hover {
        background: #dbeafe;
    }

    /* Empty State */
    .empty-state-row {
        text-align: center;
        padding: 70px 20px !important;
    }
    .empty-state-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
    .empty-icon-box {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }
    .empty-text {
        font-size: 13.5px;
        font-weight: 600;
        color: #64748b;
        margin: 0;
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
    }
    .btn-page:hover {
        background: #f1f5f9;
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

    /* Modal */
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
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: modalFadeSlide 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        width: 500px;
        max-width: 100%;
    }
    @keyframes modalFadeSlide {
        from { opacity: 0; transform: translateY(12px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        border-bottom: 1px solid #e2e8f0;
    }
    .modal-title {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .btn-modal-close {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .modal-form-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .form-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    @media (max-width: 500px) {
        .form-row-2 { grid-template-columns: 1fr; }
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .form-label {
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
    }
    .input-form-control {
        width: 100%;
        height: 38px;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        color: #1e293b;
        box-sizing: border-box;
        outline: none;
    }
    .input-form-control:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
    }
    textarea.input-form-control {
        height: auto;
        resize: vertical;
    }
    .modal-footer {
        padding: 14px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    .btn-edit-cancel {
        padding: 7px 16px;
        background: transparent;
        color: #64748b;
        border: none;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-edit-save {
        padding: 7px 18px;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25);
    }
</style>

<script>
    function openModalFollowUp(item) {
        document.getElementById('modalVin').value = item.vin || '';
        document.getElementById('modalKonsumen').value = item.konsumen || '';
        document.getElementById('modalStatus').value = item.status || 'In Progress';
        document.getElementById('modalNextFu').value = item.next_fu || '';
        document.getElementById('modalCatatan').value = item.catatan || '';
        document.getElementById('modalFollowUp').style.display = 'flex';
    }
    function closeModalFollowUp() {
        document.getElementById('modalFollowUp').style.display = 'none';
    }
    function saveFollowUp() {
        const vin = document.getElementById('modalVin').value;
        alert('Progres follow-up untuk VIN ' + vin + ' berhasil disimpan.');
        closeModalFollowUp();
    }

    // Close on backdrop click
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('modalFollowUp');
        if (event.target === modal) {
            closeModalFollowUp();
        }
    });
</script>
@endsection
