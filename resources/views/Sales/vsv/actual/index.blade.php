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
        color: #475569; font-size: 0.72rem; font-weight: 600; letter-spacing: 0.4px;
        text-transform: uppercase; white-space: nowrap; min-width: 110px;
    }
    .input-with-icon { position: relative; flex: 1; }
    .input-with-icon input {
        width: 100%; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 7px;
        color: #0f172a; padding: 7px 32px 7px 11px; font-size: 0.8rem;
        transition: border-color 0.2s, box-shadow 0.2s; outline: none; font-family: 'Inter', sans-serif;
    }
    .input-with-icon input:focus { border-color: #dc2626; box-shadow: 0 0 0 2px rgba(59,130,246,0.15); }
    .input-with-icon input::placeholder { color: #4a6080; }
    .input-icon-btn {
        position: absolute; right: 7px; top: 50%; transform: translateY(-50%);
        background: #dc2626; border: none; border-radius: 4px; color: #1e293b; font-weight:800;
        width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;
        cursor: pointer; font-size: 0.6rem; transition: background 0.2s;
    }
    .input-icon-btn:hover { background: #b91c1c; }
    .date-range-wrapper { display: flex; align-items: center; gap: 8px; flex: 1; }
    .input-date-wrap { flex: 1; }
    .input-date-wrap input[type="date"] {
        width: 100%; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 7px;
        color: #0f172a; padding: 7px 11px; font-size: 0.8rem; outline: none;
        font-family: 'Inter', sans-serif; transition: border-color 0.2s, box-shadow 0.2s;
    }
    .input-date-wrap input[type="date"]:focus { border-color: #dc2626; box-shadow: 0 0 0 2px rgba(59,130,246,0.15); }
    .input-date-wrap input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(0.6) sepia(1) saturate(3) hue-rotate(180deg); cursor: pointer;
    }
    .date-sep { color: #475569; font-size: 0.75rem; white-space: nowrap; }
    .name-display {
        flex: 1; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 7px;
        color: #0f172a; padding: 7px 11px; font-size: 0.8rem; font-family: 'Inter', sans-serif; font-weight: 500;
    }
    .btn-cari {
        background: #dc2626; color: #ffffff !important; font-weight:800; border: none;
        border-radius: 7px; padding: 7px 22px; font-size: 0.8rem; font-weight: 600;
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
        letter-spacing: 0.5px;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .table-custom tbody tr td {
        padding: 10px 16px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;
        font-size: 0.83rem; color: #334155;
    }
    .table-custom tbody tr:hover { background-color: #eff6ff; }
    .table-custom tbody tr:last-child td { border-bottom: none; }
    .td-type { font-weight: 600; color: #1e293b; }
    .td-num { text-align: center; }
    .badge-spk {
        background: #fee2e2; color: #991b1b;
        border-radius: 16px; padding: 3px 14px; font-size: 0.78rem; font-weight: 700;
        display: inline-block; min-width: 40px; text-align: center;
    }
    .badge-do {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #166534;
        border-radius: 16px; padding: 3px 14px; font-size: 0.78rem; font-weight: 700;
        display: inline-block; min-width: 40px; text-align: center;
    }
    .tfoot-row td {
        background: #fef2f2 !important;
        color: #991b1b; font-weight: 800; font-size: 0.82rem;
        padding: 11px 16px; border-top: 2px solid #f87171;
    }
    .empty-state { text-align: center; padding: 50px 20px; color: #475569; }
    .empty-state-icon { font-size: 2.8rem; display: block; margin-bottom: 10px; }
    .empty-state p { font-size: 0.85rem; margin: 0; }
    .table-scroll-wrapper { max-height: 460px; overflow-y: auto; overflow-x: auto; }
    .table-scroll-wrapper::-webkit-scrollbar { width: 5px; height: 5px; }
    .table-scroll-wrapper::-webkit-scrollbar-track { background: #f1f5f9; }
    .table-scroll-wrapper::-webkit-scrollbar-thumb { background: #f87171; border-radius: 4px; }
    .table-scroll-wrapper::-webkit-scrollbar-thumb:hover { background: #b91c1c; }
</style>

<div class="page-wrapper">

    <div class="page-header-wrap">
        <div class="page-header-icon">📈</div>
        <h1 class="page-header-title">{{ $pageTitle ?? 'Actual DO By Type' }}</h1>
        <p class="page-header-subtitle">{{ $subTitle ?? 'Monitoring data aktual Delivery Order berdasarkan tipe kendaraan' }}</p>
    </div>

    <div style="margin: 14px 0 14px 0;">
        <a href="{{ url('/current/dashboard') }}" class="btn-dashboard">← Dashboard</a>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ url()->current() }}">
            <div class="filter-row">
                <span class="filter-label">Date (From – To)</span>
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
            <div class="filter-row">
                <span class="filter-label">Cabang (Branch)</span>
                <div class="input-with-icon">
                    <input type="text" id="branch_manager_input" name="branch_manager" placeholder="Pilih Cabang..." value="{{ request('branch_manager') }}" readonly style="background:#f8fafc; color:#0f172a; font-weight:600; cursor:pointer;">
                    <button type="button" id="btnOpenBmModal" class="input-icon-btn">🔍</button>
                </div>
                <div class="name-display" id="branch_manager_name_display">{{ $branchManagerName ?? 'Pilih Cabang' }}</div>
            </div>
            <div class="filter-row">
                <span class="filter-label">Sales Head</span>
                <div class="input-with-icon">
                    <input type="text" id="sales_head_input" name="sales_head" placeholder="Pilih Branch Manager dulu..." value="{{ request('sales_head') }}" readonly style="background:#f8fafc; color:#0f172a; font-weight:600;">
                    <button type="button" id="btnOpenSpvModal" class="input-icon-btn" disabled style="opacity:0.6; cursor:not-allowed;">🔍</button>
                </div>
                <div class="name-display" id="sales_head_name_display">{{ $salesHeadName ?? 'Sales Head Name' }}</div>
            </div>
            <div class="filter-row">
                <span class="filter-label">Salesman</span>
                <div class="input-with-icon">
                    <input type="text" id="salesman_input" name="salesman" placeholder="Salesman ID / Name" value="{{ request('salesman') }}">
                    <button type="button" class="input-icon-btn" style="display:none;">🔍</button>
                </div>
                <div class="name-display">{{ request('salesman') ?: 'Salesman (Opsional)' }}</div>
            </div>
            <button type="submit" class="btn-cari">🔍 Cari</button>
        </form>
    </div>

    <div class="table-card">
        <div class="table-scroll-wrapper">
            <table class="table-custom">
                <thead>
                    @if(isset($viewType) && $viewType === 'spk')
                        <tr>
                            <th style="width:70%;">Tipe Kendaraan</th>
                            <th class="text-center" style="width:30%;">Total SPK</th>
                        </tr>
                    @else
                        <tr>
                            <th style="width:50%;">Tipe Kendaraan</th>
                            <th class="text-center" style="width:25%;">Total DO</th>
                            <th class="text-center" style="width:25%;">Total Delivery</th>
                        </tr>
                    @endif
                </thead>
                <tbody>
                    @php 
                        $grandTotalSpk = 0; 
                        $grandTotalDo = 0; 
                        $grandTotalDelivery = 0;
                    @endphp
                    @forelse($data as $row)
                        @php
                            $grandTotalSpk      += $row->total_spk      ?? 0;
                            $grandTotalDo       += $row->total_do       ?? 0;
                            $grandTotalDelivery += $row->total_delivery ?? 0;
                        @endphp
                        <tr>
                            <td class="td-type">{{ $row->TipeKendaraan }}</td>
                            @if(isset($viewType) && $viewType === 'spk')
                                <td class="td-num"><span class="badge-spk">{{ number_format($row->total_spk ?? 0) }}</span></td>
                            @else
                                <td class="td-num"><span class="badge-do">{{ number_format($row->total_do ?? 0) }}</span></td>
                                <td class="td-num"><span class="badge-do" style="background:#e0e7ff; color:#3730a3;">{{ number_format($row->total_delivery ?? 0) }}</span></td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ (isset($viewType) && $viewType === 'spk') ? 2 : 3 }}">
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
                        @if(isset($viewType) && $viewType === 'spk')
                            <td class="text-center">{{ number_format($grandTotalSpk) }}</td>
                        @else
                            <td class="text-center">{{ number_format($grandTotalDo) }}</td>
                            <td class="text-center">{{ number_format($grandTotalDelivery) }}</td>
                        @endif
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

</div>

    {{-- CUSTOM MODAL POP-UP BRANCH MANAGER --}}
    <div id="customBmModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
        <div style="background:#fff; width:600px; max-width:90%; border-radius:8px; box-shadow:0 4px 20px rgba(0,0,0,0.2); overflow:hidden;">
            <div style="padding:15px 20px; background:#f7fafc; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center;">
                <h5 style="margin:0; font-weight:700; font-size:15px; color:#2d3748;">Branch Manager</h5>
                <button type="button" id="btnCloseBmModal" style="background:none; border:none; font-size:18px; cursor:pointer; color:#a0aec0;">&times;</button>
            </div>
            <div style="padding:20px;">
                <input type="text" id="searchBmInput" placeholder="Cari Branch Manager..." style="width:100%; padding:8px 12px; border:1px solid #cbd5e0; border-radius:6px; font-size:13px; margin-bottom:12px; outline:none;">
                <div style="max-height: 250px; overflow-y: auto;">
                    <table style="width:100%; border-collapse:collapse; font-size:12px;">
                        <thead style="background:#fee2e2; color:#991b1b;">
                            <tr>
                                <th style="padding:8px; border:1px solid #90caf9; text-align:left; color:#1a1a2e;">ID</th>
                                <th style="padding:8px; border:1px solid #90caf9; text-align:left; color:#1a1a2e;">Branch Manager</th>
                                <th style="padding:8px; border:1px solid #90caf9; text-align:left; color:#1a1a2e;">Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bmsMap ?? [] as $bmId => $bmInfo)
                            <tr class="bm-item" style="cursor:pointer; border-bottom:1px solid #eee;" onclick="selectBm('{{ $bmId }}', '{{ addslashes($bmInfo['Name']) }}')">
                                <td style="padding:8px; border-left:1px solid #eee; border-right:1px solid #eee; color:#1a1a2e;">{{ $bmId }}</td>
                                <td style="padding:8px; border-right:1px solid #eee; color:#1a1a2e;">{{ $bmInfo['Name'] }}</td>
                                <td style="padding:8px; border-right:1px solid #eee; color:#1a1a2e; font-weight:700;">{{ $bmInfo['Jabatan'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" style="padding:8px; text-align:center;">Data tidak tersedia</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- CUSTOM MODAL POP-UP SALES HEAD --}}
    <div id="customSpvModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
        <div style="background:#fff; width:600px; max-width:90%; border-radius:8px; box-shadow:0 4px 20px rgba(0,0,0,0.2); overflow:hidden;">
            <div style="padding:15px 20px; background:#f7fafc; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center;">
                <h5 style="margin:0; font-weight:700; font-size:15px; color:#2d3748;">Sales Head</h5>
                <button type="button" id="btnCloseSpvModal" style="background:none; border:none; font-size:18px; cursor:pointer; color:#a0aec0;">&times;</button>
            </div>
            <div style="padding:20px;">
                <input type="text" id="searchSpvInput" placeholder="Cari Sales Head..." style="width:100%; padding:8px 12px; border:1px solid #cbd5e0; border-radius:6px; font-size:13px; margin-bottom:12px; outline:none;">
                <div style="max-height: 250px; overflow-y: auto;">
                    <table style="width:100%; border-collapse:collapse; font-size:12px;">
                        <thead style="background:#fee2e2; color:#991b1b;">
                            <tr>
                                <th style="padding:8px; border:1px solid #90caf9; text-align:left; color:#1a1a2e;">ID</th>
                                <th style="padding:8px; border:1px solid #90caf9; text-align:left; color:#1a1a2e;">Nama Sales Head</th>
                                <th style="padding:8px; border:1px solid #90caf9; text-align:left; color:#1a1a2e;">Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($spvsMap ?? [] as $spvId => $spvInfo)
                            <tr class="spv-item" data-branch="{{ $spvInfo['BranchCode'] }}" style="cursor:pointer; border-bottom:1px solid #eee;" onclick="selectSpv('{{ $spvId }}', '{{ addslashes($spvInfo['Name']) }}')">
                                <td style="padding:8px; border-left:1px solid #eee; border-right:1px solid #eee; color:#1a1a2e;">{{ $spvId }}</td>
                                <td style="padding:8px; border-right:1px solid #eee; color:#1a1a2e;">{{ $spvInfo['Name'] }}</td>
                                <td style="padding:8px; border-right:1px solid #eee; color:#1a1a2e; font-weight:700;">{{ $spvInfo['Jabatan'] ?? 'SH' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" style="padding:8px; text-align:center; color:#666;">Pilih Cabang dulu untuk menampilkan Sales Head</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const bmBranchMap = @json($bmBranchMap ?? []);
        const branchSpvMap = @json($branchSpvMap ?? []);
        
        document.addEventListener('DOMContentLoaded', function() {
            const bmModal = document.getElementById('customBmModal');
            const spvModal = document.getElementById('customSpvModal');
            
            const btnOpenBm = document.getElementById('btnOpenBmModal');
            const btnCloseBm = document.getElementById('btnCloseBmModal');
            const btnOpenSpv = document.getElementById('btnOpenSpvModal');
            const btnCloseSpv = document.getElementById('btnCloseSpvModal');
            
            const bmInput = document.getElementById('branch_manager_input');
            const spvInput = document.getElementById('sales_head_input');
            
            if (btnOpenBm) {
                btnOpenBm.addEventListener('click', function() { bmModal.style.display = 'flex'; });
            }
            if (btnCloseBm) {
                btnCloseBm.addEventListener('click', function() { bmModal.style.display = 'none'; });
            }
            
            if (btnOpenSpv) {
                btnOpenSpv.addEventListener('click', function() { 
                    if(!this.disabled) spvModal.style.display = 'flex'; 
                });
            }
            if (btnCloseSpv) {
                btnCloseSpv.addEventListener('click', function() { spvModal.style.display = 'none'; });
            }
            
            window.addEventListener('click', function(e) {
                if(e.target === bmModal) bmModal.style.display = 'none';
                if(e.target === spvModal) spvModal.style.display = 'none';
            });
            
            // Search functions
            const searchBm = document.getElementById('searchBmInput');
            if(searchBm) {
                searchBm.addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    document.querySelectorAll('.bm-item').forEach(row => {
                        row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
                    });
                });
            }
            
            const searchSpv = document.getElementById('searchSpvInput');
            if(searchSpv) {
                searchSpv.addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    document.querySelectorAll('.spv-item').forEach(row => {
                        if(row.classList.contains('hidden-by-bm')) return;
                        row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
                    });
                });
            }
            
            // Initial filter check
            if(bmInput && bmInput.value) {
                filterSpvs(bmInput.value);
            }
        });
        
        function filterSpvs(bmId) {
            const branchCode = bmBranchMap[bmId];
            
            document.querySelectorAll('.spv-item').forEach(row => {
                const spvBranch = row.getAttribute('data-branch');
                // Allow if spv is in the same branch as the BM
                if (branchCode && spvBranch === branchCode) {
                    row.style.display = '';
                    row.classList.remove('hidden-by-bm');
                } else {
                    row.style.display = 'none';
                    row.classList.add('hidden-by-bm');
                }
            });
            
            // Enable SPV button
            const spvBtn = document.getElementById('btnOpenSpvModal');
            if(spvBtn) {
                spvBtn.disabled = false;
                spvBtn.style.opacity = '1';
                spvBtn.style.cursor = 'pointer';
            }
            const spvInp = document.getElementById('sales_head_input');
            if(spvInp) {
                spvInp.placeholder = 'Pilih Sales Head...';
            }
        }
        
        function selectBm(id, name) {
            document.getElementById('branch_manager_input').value = id;
            document.getElementById('branch_manager_name_display').innerText = name;
            document.getElementById('customBmModal').style.display = 'none';
            
            // Reset SPV
            document.getElementById('sales_head_input').value = '';
            document.getElementById('sales_head_name_display').innerText = 'Sales Head Name';
            
            filterSpvs(id);
        }
        
        function selectSpv(id, name) {
            document.getElementById('sales_head_input').value = id;
            document.getElementById('sales_head_name_display').innerText = name;
            document.getElementById('customSpvModal').style.display = 'none';
        }
    </script>
@endsection
