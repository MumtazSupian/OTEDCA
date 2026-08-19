@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
    * { box-sizing: border-box; }

    body {
        background-color: var(--bg-main, #f4f5f7) !important;
        color: #ffffff;
        font-family: 'Inter', 'Segoe UI', sans-serif;
    }

    /* ===== WRAPPER ===== */
    .page-wrapper {
        max-width: 860px;
        margin: 0 auto;
        padding: 24px 16px;
    }

    /* ===== HEADER ===== */
    .page-header-wrap {
        text-align: center;
        margin-bottom: 16px;
    }
    .page-header-icon { font-size: 1.6rem; filter: drop-shadow(0 0 8px rgba(220,38,38,0.3)); }
    .page-header-title {
        color: #1e293b; font-weight: 800; font-size: 1.4rem; letter-spacing: 2px;
        text-transform: uppercase; text-shadow: none; margin: 0;
    }
    .page-header-subtitle { color: #64748b; font-size: 0.8rem; margin: 3px 0 0 0; }

    /* ===== DASHBOARD BUTTON ===== */
    .btn-dashboard {
        display: inline-flex; align-items: center; gap: 5px; padding: 6px 14px;
        border-radius: 7px; font-size: 0.78rem; font-weight: 600; border: 1.5px solid #e2e8f0;
        cursor: pointer; transition: all 0.2s ease; text-decoration: none;
        background: #1e293b; color: #475569;
    }
    .btn-dashboard:hover { background: #fee2e2; color: #991b1b; transform: translateY(-1px); }

    /* ===== FILTER CARD ===== */
    .filter-card {
        background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px;
        padding: 16px 20px; margin-bottom: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }
    .filter-row { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    .filter-row:last-of-type { margin-bottom: 0; }
    .filter-label {
        color: #475569; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.4px;
        text-transform: uppercase; white-space: nowrap; min-width: 130px;
    }
    .input-with-icon { position: relative; flex: 1; }
    .input-with-icon input {
        width: 100%; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 7px;
        color: #0f172a; padding: 7px 32px 7px 11px; font-size: 0.8rem;
        transition: border-color 0.2s, box-shadow 0.2s; outline: none; font-family: 'Inter', sans-serif;
    }
    .input-with-icon input:focus { border-color: #dc2626; box-shadow: 0 0 0 2px rgba(220,38,38,0.15); }
    .input-with-icon input::placeholder { color: #94a3b8; font-weight: 500; }
    
    .input-icon-btn {
        position: absolute; right: 7px; top: 50%; transform: translateY(-50%);
        background: #dc2626; border: none; border-radius: 4px; color: #fff;
        width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;
        cursor: pointer; font-size: 0.6rem; transition: background 0.2s; z-index: 2; pointer-events: auto;
    }
    .input-icon-btn:hover { background: #b91c1c; }
    .input-icon-btn.locked { background: #e2e8f0; color: #64748b; cursor: default; pointer-events: none; }
    
    .date-range-wrapper { display: flex; align-items: center; gap: 8px; flex: 1; }
    .input-date-wrap { flex: 1; }
    .input-date-wrap input[type="date"] {
        width: 100%; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 7px;
        color: #0f172a; padding: 7px 11px; font-size: 0.8rem; outline: none;
        font-family: 'Inter', sans-serif; transition: border-color 0.2s, box-shadow 0.2s;
    }
    .input-date-wrap input[type="date"]:focus { border-color: #dc2626; box-shadow: 0 0 0 2px rgba(220,38,38,0.15); }
    .date-sep { color: #475569; font-size: 0.75rem; white-space: nowrap; }
    
    .name-display {
        flex: 1; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 7px;
        color: #0f172a; padding: 7px 11px; font-size: 0.8rem; font-family: 'Inter', sans-serif; 
        font-weight: 600; display: flex; align-items: center; min-height: 33px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    
    .btn-cari {
        background: #dc2626; color: #ffffff !important; font-weight:800; border: none;
        border-radius: 7px; padding: 7px 22px; font-size: 0.8rem;
        cursor: pointer; transition: all 0.2s ease; display: inline-flex; align-items: center;
        gap: 5px; margin-top: 12px; font-family: 'Inter', sans-serif;
    }
    .btn-cari:hover { background: #b91c1c; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(220,38,38,0.3); }

    /* ===== TABLE CARD ===== */
    .table-card {
        background: #ffffff; border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e2e8f0;
    }
    .table-custom { margin-bottom: 0; color: #1e293b; width: 100%; border-collapse: collapse; }
    .table-custom thead tr th {
        background: #fee2e2 !important;
        color: #991b1b; font-weight: 700; text-transform: uppercase; font-size: 0.7rem;
        padding: 11px 16px; border-bottom: 2px solid #f87171; vertical-align: middle;
        letter-spacing: 0.5px; position: sticky; top: 0; z-index: 10;
    }
    .table-custom tbody tr td {
        padding: 10px 16px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;
        font-size: 0.83rem; color: #334155;
    }
    .table-custom tbody tr:hover { background-color: #eff6ff; }
    .table-custom tbody tr:last-child td { border-bottom: none; }
    .td-type { font-weight: 600; color: #1e293b; }
    .td-num { text-align: center; }
    .badge-inquiry {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1e3a8a;
        border-radius: 16px; padding: 3px 14px; font-size: 0.78rem; font-weight: 700;
        display: inline-block; min-width: 40px; text-align: center;
    }
    .tfoot-row td {
        background: #fef2f2 !important;
        color: #991b1b; font-weight: 800; font-size: 0.82rem;
        padding: 11px 16px; border-top: 2px solid #f87171;
    }
    .empty-state { text-align: center; padding: 50px 20px; color: #94a3b8; }
    .empty-state-icon { font-size: 2.8rem; display: block; margin-bottom: 10px; }
    .empty-state p { font-size: 0.85rem; margin: 0; }
    .table-scroll-wrapper { max-height: 460px; overflow-y: auto; overflow-x: auto; }
    .table-scroll-wrapper::-webkit-scrollbar { width: 5px; height: 5px; }
    .table-scroll-wrapper::-webkit-scrollbar-track { background: #f1f5f9; }
    .table-scroll-wrapper::-webkit-scrollbar-thumb { background: #f87171; border-radius: 4px; }
    .table-scroll-wrapper::-webkit-scrollbar-thumb:hover { background: #b91c1c; }

    /* ===== CUSTOM MODAL POP-UP OVERLAY MATCHING OFFICE SYSTEM ===== */
    .custom-modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100vw; height: 100vh;
        background: rgba(15, 23, 42, 0.6);
        z-index: 99999;
        align-items: center; justify-content: center;
        backdrop-filter: blur(3px);
    }
    .custom-modal-overlay.active {
        display: flex;
    }
    .modal-content-custom {
        background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        width: 650px; max-width: 95%; overflow: hidden;
    }
    .modal-header-custom {
        border-bottom: 1px solid #e2e8f0; padding: 14px 20px; background: #ffffff;
        display: flex; align-items: center; justify-content: space-between;
    }
    .modal-title-custom { font-size: 1.05rem; font-weight: 700; color: #334155; margin: 0; }
    .modal-close-btn {
        background: none; border: none; color: #94a3b8; font-size: 1.4rem; font-weight:400;
        cursor: pointer; transition: color 0.2s; padding:0; outline:none;
    }
    .modal-close-btn:hover { color: #dc2626; }
    
    .modal-search-box {
        padding: 15px 20px; background: #ffffff; border-bottom: 1px solid #e2e8f0;
    }
    .modal-search-box input {
        width: 100%; border: 1px solid #cbd5e1; border-radius: 6px;
        padding: 10px 12px; font-size: 0.85rem; outline: none; transition: border-color 0.2s;
    }
    .modal-search-box input:focus { border-color: #3b82f6; }
    
    /* MODAL TABLE SPECIFIC */
    .modal-table-container { max-height: 350px; overflow-y: auto; padding: 0 20px 20px 20px; }
    .modal-table-container::-webkit-scrollbar { width: 6px; }
    .modal-table-container::-webkit-scrollbar-track { background: #f1f5f9; }
    .modal-table-container::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    
    .modal-table {
        width: 100%; border-collapse: collapse; font-size: 0.8rem; color: #1e293b; margin-top: 10px;
    }
    .modal-table thead th {
        background: #fee2e2; color: #991b1b; text-align: left; padding: 12px 16px;
        border: 1px solid #fca5a5; font-weight: 700; position: sticky; top: 0; z-index: 5;
    }
    .modal-table tbody tr {
        cursor: pointer; transition: background 0.15s;
    }
    .modal-table tbody tr:hover { background: #fef2f2; }
    .modal-table tbody td { 
        padding: 12px 16px; vertical-align: middle; border: 1px solid #e2e8f0; 
    }
    .modal-td-id { color: #334155; width: 25%; font-family: monospace; font-size: 0.75rem;}
    .modal-td-name { color: #334155; width: 55%; font-weight: 500; text-transform: uppercase; }
    .modal-td-role { font-weight: 700; color: #1e293b; width: 20%; }
</style>

<div class="page-wrapper">

    <div class="page-header-wrap">
        <div class="page-header-icon">📈</div>
        <h1 class="page-header-title">{{ $pageTitle ?? 'Actual Inquiry By Type' }}</h1>
        <p class="page-header-subtitle">{{ $subTitle ?? 'Monitoring data aktual Inquiry berdasarkan tipe kendaraan' }}</p>
    </div>

    <div style="margin: 14px 0 14px 0;">
        <a href="{{ url('/current/dashboard') }}" class="btn-dashboard">← Dashboard</a>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ url()->current() }}">
            <input type="hidden" name="BranchCode" id="hidden_branch_code" value="{{ request('BranchCode', $BranchCode ?? '') }}">
            <input type="hidden" name="SpvEmployeeID" id="hidden_spv_id" value="{{ request('SpvEmployeeID', $SpvEmployeeID ?? '') }}">
            
            <div class="filter-row">
                <span class="filter-label">DATE (FROM – TO)</span>
                <div class="date-range-wrapper">
                    <div class="input-date-wrap">
                        <input type="date" name="from_date" value="{{ $fromDate ?? date('Y-m-d') }}">
                    </div>
                    <span class="date-sep">→</span>
                    <div class="input-date-wrap">
                        <input type="date" name="to_date" value="{{ $toDate ?? date('Y-m-d') }}">
                    </div>
                </div>
            </div>
            
            {{-- CABANG / BRANCH MANAGER --}}
            <div class="filter-row">
                <span class="filter-label">CABANG (BRANCH)</span>
                <div class="input-with-icon">
                    <input type="text" id="bm_display_input" placeholder="PILIH CABANG..." value="{{ $BranchCode ?? request('BranchCode') }}" readonly style="background:#ffffff; color:#0f172a; font-weight:600; cursor:pointer;" @if(empty($isLockedBranch)) onclick="openBmModal()" @endif>
                    @if(empty($isLockedBranch))
                        <button type="button" class="input-icon-btn" onclick="openBmModal()">🔍</button>
                    @else
                        <span class="input-icon-btn locked">🔒</span>
                    @endif
                </div>
                <div class="name-display" id="branch_manager_name_display">
                    {{ !empty($branchManagerName) ? $branchManagerName : (!empty($selectedBranchName) ? $selectedBranchName : 'Pilih Cabang') }}
                </div>
            </div>

            {{-- SALES HEAD --}}
            <div class="filter-row">
                <span class="filter-label">SALES HEAD</span>
                <div class="input-with-icon">
                    <input type="text" id="spv_display_input" placeholder="PILIH SALES HEAD..." value="{{ $SpvEmployeeID ?? request('SpvEmployeeID') }}" readonly style="background:#ffffff; color:#0f172a; font-weight:600; cursor:pointer;" @if(empty($isLockedSpv)) onclick="openSpvModal()" @endif>
                    @if(empty($isLockedSpv))
                        <button type="button" id="btnOpenSpvModal" class="input-icon-btn" onclick="openSpvModal()" {{ empty($BranchCode) && empty(request('BranchCode')) ? 'disabled style="opacity:0.6; cursor:not-allowed;"' : '' }}>🔍</button>
                    @else
                        <span class="input-icon-btn locked">🔒</span>
                    @endif
                </div>
                <div class="name-display" id="sales_head_name_display">
                    {{ !empty($salesHeadName) ? $salesHeadName : (!empty($selectedSpvName) ? $selectedSpvName : 'Pilih Sales Head...') }}
                </div>
            </div>

            {{-- SALESMAN --}}
            <div class="filter-row">
                <span class="filter-label">SALESMAN</span>
                <div class="input-with-icon">
                    <!-- Sesuai permintaan, Salesman adalah input text biasa tanpa tombol search -->
                    <input type="text" id="salesman_input" name="salesman" placeholder="SALESMAN ID / NAME" value="{{ request('salesman') }}" style="background:#ffffff;">
                </div>
                <div class="name-display">Salesman (Opsional)</div>
            </div>
            
            <button type="submit" class="btn-cari">🔍 Cari</button>
        </form>
    </div>

    <div class="table-card">
        <div class="table-scroll-wrapper">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width:70%;">Tipe Kendaraan</th>
                        <th class="text-center" style="width:30%;">Total Inquiry</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $grandTotalInquiry = 0; 
                    @endphp
                    @forelse($data as $row)
                        @php
                            $inquiryVal = $row->total_inquiry ?? $row->total_prospect ?? $row->total_new ?? ($row->total_spk ?? 0);
                            $grandTotalInquiry += $inquiryVal;
                        @endphp
                        <tr>
                            <td class="td-type">{{ $row->TipeKendaraan }}</td>
                            <td class="td-num"><span class="badge-inquiry">{{ number_format($inquiryVal) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">
                                <div class="empty-state">
                                    <span class="empty-state-icon">📭</span>
                                    <p>Data tidak ditemukan untuk periode tanggal ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(isset($data) && $data->count() > 0)
                <tfoot>
                    <tr class="tfoot-row">
                        <td style="text-align:right; font-weight:800;">TOTAL KESELURUHAN</td>
                        <td class="text-center">{{ number_format($grandTotalInquiry) }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

</div>

    {{-- CUSTOM MODAL POP-UP BRANCH MANAGER --}}
    @if(empty($isLockedBranch))
    <div id="customBmModal" class="custom-modal-overlay">
        <div class="modal-content-custom">
            <div class="modal-header-custom">
                <h5 class="modal-title-custom">
                    {{ (isset($bmsMap) && count($bmsMap) > 0) ? 'Branch Manager' : 'Branch / Outlet' }}
                </h5>
                <button type="button" class="modal-close-btn" onclick="closeBmModal()">✕</button>
            </div>
            <div class="modal-search-box">
                <input type="text" id="bmSearchInput" placeholder="Cari {{ (isset($bmsMap) && count($bmsMap) > 0) ? 'Branch Manager' : 'Branch / Outlet' }}..." onkeyup="filterBmList()">
            </div>
            <div class="modal-table-container">
                <table class="modal-table">
                    <thead>
                        <tr>
                            <th style="width:25%;">ID</th>
                            <th style="width:55%;">{{ (isset($bmsMap) && count($bmsMap) > 0) ? 'Branch Manager' : 'Branch / Manager' }}</th>
                            <th style="width:20%;">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody id="bmTableBody">
                        @if(isset($bmsMap) && count($bmsMap) > 0)
                            @foreach($bmsMap as $bmId => $bmInfo)
                                <tr class="bm-item" onclick="selectBm('{{ $bmId }}', '{{ addslashes($bmInfo['Name'] ?? '') }}')">
                                    <td class="modal-td-id">{{ $bmId }}</td>
                                    <td class="modal-td-name">{{ $bmInfo['Name'] ?? '-' }}</td>
                                    <td class="modal-td-role">{{ $bmInfo['Jabatan'] ?? 'BM' }}</td>
                                </tr>
                            @endforeach
                        @elseif(isset($branchesMap) && count($branchesMap) > 0)
                            @foreach($branchesMap as $code => $name)
                                <tr class="bm-item" onclick="selectBm('{{ $code }}', '{{ addslashes($name ?? '') }}')">
                                    <td class="modal-td-id">{{ $code }}</td>
                                    <td class="modal-td-name">{{ $name ?? '-' }}</td>
                                    <td class="modal-td-role">CABANG</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" style="text-align:center; padding:15px; color:#64748b;">Data tidak tersedia</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- CUSTOM MODAL POP-UP SALES HEAD --}}
    @if(empty($isLockedSpv))
    <div id="customSpvModal" class="custom-modal-overlay">
        <div class="modal-content-custom">
            <div class="modal-header-custom">
                <h5 class="modal-title-custom">Sales Head</h5>
                <button type="button" class="modal-close-btn" onclick="closeSpvModal()">✕</button>
            </div>
            <div class="modal-search-box">
                <input type="text" id="spvSearchInput" placeholder="Cari Sales Head..." onkeyup="filterSpvList()">
            </div>
            <div class="modal-table-container">
                <table class="modal-table">
                    <thead>
                        <tr>
                            <th style="width:25%;">ID</th>
                            <th style="width:55%;">Nama Sales Head</th>
                            <th style="width:20%;">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody id="spvTableBody">
                        @if(isset($spvsMap) && count($spvsMap) > 0)
                            @foreach($spvsMap as $id => $info)
                                <tr class="spv-item" data-branch="{{ $info['BranchCode'] ?? '' }}" onclick="selectSpv('{{ $id }}', '{{ addslashes($info['Name'] ?? '') }}')">
                                    <td class="modal-td-id">{{ $id }}</td>
                                    <td class="modal-td-name">{{ $info['Name'] ?? '-' }}</td>
                                    <td class="modal-td-role">{{ $info['Jabatan'] ?? 'SH' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" style="text-align:center; padding:15px; color:#64748b;">Data tidak tersedia</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <script>
        const isLockedBranch = {{ !empty($isLockedBranch) ? 'true' : 'false' }};
        const isLockedSpv = {{ !empty($isLockedSpv) ? 'true' : 'false' }};
        const bmBranchMap = @json($bmBranchMap ?? []);
        const branchSpvMap = @json($branchSpvMap ?? []);
        
        document.addEventListener('DOMContentLoaded', function() {
            const bmModal = document.getElementById('customBmModal');
            const spvModal = document.getElementById('customSpvModal');
            
            const bmInput = document.getElementById('hidden_branch_code');
            const spvInput = document.getElementById('hidden_spv_id');
            
            // Close modals when clicking outside
            window.addEventListener('click', function(e) {
                if(bmModal && e.target === bmModal) bmModal.classList.remove('active');
                if(spvModal && e.target === spvModal) spvModal.classList.remove('active');
            });
            
            // Initial filter check
            if(bmInput && bmInput.value) {
                filterSpvs(bmInput.value);
            }
        });

        // ================= BRANCH / OUTLET =================
        function openBmModal() {
            if (!isLockedBranch) {
                document.getElementById('customBmModal').classList.add('active');
            }
        }
        function closeBmModal() {
            document.getElementById('customBmModal').classList.remove('active');
        }
        function filterBmList() {
            let q = document.getElementById('bmSearchInput').value.toLowerCase();
            document.querySelectorAll('.bm-item').forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(q) ? '' : 'none';
            });
        }
        function selectBm(id, name) {
            document.getElementById('hidden_branch_code').value = id;
            document.getElementById('bm_display_input').value = id ? id : '';
            document.getElementById('branch_manager_name_display').innerText = name ? name : 'Pilih Cabang';
            
            // Reset SPV & Salesman
            document.getElementById('hidden_spv_id').value = '';
            document.getElementById('spv_display_input').value = '';
            document.getElementById('sales_head_name_display').innerText = 'Pilih Sales Head...';
            
            document.getElementById('salesman_input').value = '';
            
            filterSpvs(id);
            closeBmModal();
        }

        // ================= SALES HEAD =================
        function openSpvModal() {
            if (!isLockedSpv) {
                let spvBtn = document.getElementById('btnOpenSpvModal');
                if (spvBtn && spvBtn.disabled) return;
                
                let currentBranch = document.getElementById('hidden_branch_code').value;
                filterSpvs(currentBranch);
                document.getElementById('customSpvModal').classList.add('active');
            }
        }
        function closeSpvModal() {
            document.getElementById('customSpvModal').classList.remove('active');
        }
        function filterSpvList() {
            let q = document.getElementById('spvSearchInput').value.toLowerCase();
            let currentBranch = document.getElementById('hidden_branch_code').value;
            let actualBranchCode = bmBranchMap[currentBranch] || currentBranch;

            document.querySelectorAll('.spv-item').forEach(row => {
                let text = row.innerText.toLowerCase();
                let itemBranch = row.getAttribute('data-branch');
                let matchesBranch = (!actualBranchCode || itemBranch === actualBranchCode);
                let matchesSearch = text.includes(q);
                
                row.style.display = (matchesBranch && matchesSearch) ? '' : 'none';
            });
        }
        function filterSpvs(bmId) {
            const branchCode = bmBranchMap[bmId] || bmId;
            
            document.querySelectorAll('.spv-item').forEach(row => {
                const spvBranch = row.getAttribute('data-branch');
                // Logika: Jika branchCode tidak ada atau branch dari SPV sesuai
                if (!branchCode || spvBranch === branchCode) {
                    row.style.display = '';
                    row.classList.remove('hidden-by-bm');
                } else {
                    row.style.display = 'none';
                    row.classList.add('hidden-by-bm');
                }
            });
            
            const spvBtn = document.getElementById('btnOpenSpvModal');
            if(spvBtn && !isLockedSpv) {
                spvBtn.disabled = false;
                spvBtn.style.opacity = '1';
                spvBtn.style.cursor = 'pointer';
            }
        }
        function selectSpv(id, name) {
            document.getElementById('hidden_spv_id').value = id;
            document.getElementById('spv_display_input').value = id ? id : '';
            document.getElementById('sales_head_name_display').innerText = name ? name : 'Pilih Sales Head...';
            
            // Reset Salesman
            document.getElementById('salesman_input').value = '';
            
            closeSpvModal();
        }
    </script>
@endsection