@extends('layouts.app')

@section('title', 'Master BP Prospect - OTE DCA')

@section('content')
<div class="master-bp-container">
    {{-- 1. HEADER SECTION --}}
    <div class="page-header-row">
        <div class="header-text-group">
            <h1 class="page-title">Master BP Prospect</h1>
            <p class="page-subtitle">Pengaturan SLA, target CPUS, dan rotasi SA BP</p>
        </div>
    </div>

    {{-- 2. TAB NAVIGATION --}}
    <div class="tab-nav-bar">
        <button type="button" class="tab-btn {{ ($activeTab ?? 'sla') == 'sla' ? 'active' : '' }}" onclick="switchTab('sla')">
            <span>Pengaturan SLA</span>
        </button>
        <button type="button" class="tab-btn {{ ($activeTab ?? '') == 'cpus' ? 'active' : '' }}" onclick="switchTab('cpus')">
            <span>Target CPUS</span>
        </button>
        <button type="button" class="tab-btn {{ ($activeTab ?? '') == 'rotasi' ? 'active' : '' }}" onclick="switchTab('rotasi')">
            <span>Rotasi SA BP</span>
        </button>
    </div>

    {{-- 3. TAB 1: PENGATURAN SLA --}}
    <div class="tab-content-panel" id="tabPanelSla" style="display: {{ ($activeTab ?? 'sla') == 'sla' ? 'block' : 'none' }};">
        <form method="POST" action="javascript:void(0)" onsubmit="saveSlaSettings()">
            @csrf
            
            {{-- Section 1: Service Level Agreement (SLA) --}}
            <div class="settings-card">
                <div class="settings-header">
                    <h3 class="settings-title">Service Level Agreement (SLA)</h3>
                    <p class="settings-subtitle">Konfigurasi batas waktu follow-up yang berlaku untuk semua SA BP.</p>
                </div>
                <div class="settings-grid-2">
                    <div class="settings-item">
                        <label class="form-label">Batas Hari Kontak Pertama</label>
                        <div class="input-with-suffix">
                            <input type="number" name="batas_kontak_pertama" value="{{ $slaSettings['batas_kontak_pertama'] ?? 3 }}" class="input-form-control" min="1">
                            <span class="suffix-text">hari</span>
                        </div>
                        <span class="field-hint">Prospect harus dihubungi dalam N hari sejak dibuat</span>
                    </div>
                    <div class="settings-item">
                        <label class="form-label">Interval Follow-Up (hari)</label>
                        <div class="input-with-suffix">
                            <input type="number" name="interval_fu" value="{{ $slaSettings['interval_fu'] ?? 7 }}" class="input-form-control" min="1">
                            <span class="suffix-text">hari</span>
                        </div>
                        <span class="field-hint">Jarak maksimum antar follow-up berikutnya</span>
                    </div>
                </div>
            </div>

            {{-- Section 2: Deteksi Unit Entry --}}
            <div class="settings-card">
                <div class="settings-header">
                    <h3 class="settings-title">Deteksi Unit Entry</h3>
                    <p class="settings-subtitle">Outlet ID yang dipakai untuk mendeteksi apakah prospect sudah masuk unit (unit entry).</p>
                </div>
                <div class="settings-grid-2">
                    <div class="settings-item">
                        <label class="form-label">Outlet ID BP untuk deteksi unit entry</label>
                        <input type="text" name="outlet_id_bp" value="{{ $slaSettings['outlet_id_bp'] ?? '' }}" class="input-form-control font-mono" placeholder="Contoh: 001">
                        <span class="field-hint">Kosongkan jika tidak digunakan</span>
                    </div>
                </div>
            </div>

            {{-- Section 3: Follow-up Asuransi BP --}}
            <div class="settings-card">
                <div class="settings-header">
                    <h3 class="settings-title">Follow-up Asuransi BP</h3>
                    <p class="settings-subtitle">Konfigurasi batas hari untuk mendeteksi kendaraan COMP aktif yang masuk zona follow-up asuransi.</p>
                </div>
                <div class="settings-grid-2">
                    <div class="settings-item">
                        <label class="form-label">Batas Hari Follow-up Asuransi BP</label>
                        <div class="input-with-suffix">
                            <input type="number" name="batas_fu_asuransi" value="{{ $slaSettings['batas_fu_asuransi'] ?? 60 }}" class="input-form-control" min="1">
                            <span class="suffix-text">hari</span>
                        </div>
                        <span class="field-hint">Kendaraan COMP aktif dengan sisa &le; nilai ini masuk zona follow-up asuransi</span>
                    </div>
                </div>
            </div>

            {{-- Submit SLA Settings --}}
            <div class="settings-action-bar">
                <button type="submit" class="btn-save-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    <span>Simpan Pengaturan</span>
                </button>
            </div>
        </form>
    </div>

    {{-- 4. TAB 2: TARGET CPUS --}}
    <div class="tab-content-panel" id="tabPanelCpus" style="display: {{ ($activeTab ?? '') == 'cpus' ? 'block' : 'none' }};">
        <form method="POST" action="javascript:void(0)" onsubmit="saveTargetCpus()">
            @csrf

            <div class="cpus-top-bar">
                <div class="year-select-group">
                    <label class="year-label">Tahun:</label>
                    <select name="tahun" class="select-year-control" onchange="changeYear(this.value)">
                        <option value="2024" {{ ($tahun ?? '') == '2024' ? 'selected' : '' }}>2024</option>
                        <option value="2025" {{ ($tahun ?? '') == '2025' ? 'selected' : '' }}>2025</option>
                        <option value="2026" {{ ($tahun ?? '2026') == '2026' ? 'selected' : '' }}>2026</option>
                        <option value="2027" {{ ($tahun ?? '') == '2027' ? 'selected' : '' }}>2027</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn-save-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        <span>Simpan Target</span>
                    </button>
                </div>
            </div>

            <div class="table-card-wrapper">
                <div class="table-responsive">
                    <table class="master-table cpus-table">
                        <thead>
                            <tr>
                                <th style="width: 200px;">Bulan</th>
                                <th>Target CPUS</th>
                                <th style="width: 250px;">Target Leads (CPUS &times; 8%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($months as $index => $m)
                            <tr>
                                <td class="font-bold">{{ $m }}</td>
                                <td>
                                    <input type="number" name="target_cpus[{{ $m }}]" value="{{ $targetCpus[$m] ?? 0 }}" class="input-cpus-control" min="0" oninput="calculateLeads(this, 'leads_val_{{ $index }}')">
                                </td>
                                <td>
                                    <span class="leads-calc-text" id="leads_val_{{ $index }}">{{ round(($targetCpus[$m] ?? 0) * 0.08) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>

    {{-- 5. TAB 3: ROTASI SA BP --}}
    <div class="tab-content-panel" id="tabPanelRotasi" style="display: {{ ($activeTab ?? '') == 'rotasi' ? 'block' : 'none' }};">
        <div class="rotasi-header-block">
            <p class="rotasi-subtitle">Atur urutan dan status aktif SA BP yang bertugas menerima prospek baru. Gunakan tombol panah untuk mengubah urutan, lalu klik Simpan Urutan.</p>
        </div>

        <div class="rotasi-action-row">
            <div class="rotasi-add-group">
                <select id="selectAddSa" class="select-control" style="width: 280px;">
                    @foreach($availableSaList as $sa)
                        <option value="{{ $sa }}">{{ $sa }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn-add-rotasi" onclick="addSaToRotasi()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Tambah ke Rotasi</span>
                </button>
            </div>
            <div>
                <button type="button" class="btn-save-primary" onclick="saveRotasiOrder()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    <span>Simpan Urutan</span>
                </button>
            </div>
        </div>

        <div class="table-card-wrapper">
            <div class="table-responsive">
                <table class="master-table">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Urutan</th>
                            <th>Nama SA BP</th>
                            <th style="width: 140px;">Status</th>
                            <th style="width: 120px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rotasiSaList as $index => $sa)
                        <tr>
                            <td class="font-bold">{{ $sa['urutan'] ?? ($index + 1) }}</td>
                            <td class="font-bold">{{ $sa['nama'] }}</td>
                            <td>
                                <span class="badge-status-aktif">{{ $sa['status'] ?? 'Aktif' }}</span>
                            </td>
                            <td style="text-align: center;">
                                <div class="action-btn-group">
                                    <button type="button" class="btn-icon-action" title="Geser ke Atas" onclick="moveUp({{ $index }})">🔼</button>
                                    <button type="button" class="btn-icon-action" title="Geser ke Bawah" onclick="moveDown({{ $index }})">🔽</button>
                                    <button type="button" class="btn-icon-action btn-icon-delete" title="Hapus dari Rotasi" onclick="deleteRotasi('{{ $sa['nama'] }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                            <line x1="9" y1="9" x2="15" y2="15"></line>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="empty-state-row">
                                <div class="empty-state-content">
                                    <div class="empty-icon-circle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                    </div>
                                    <p class="empty-text">Belum ada SA BP terdaftar</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Global Container */
    .master-bp-container {
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

    /* Tab Navigation */
    .tab-nav-bar {
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 2px solid #f1f5f9;
        margin-bottom: 24px;
    }
    .tab-btn {
        background: transparent;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 10px 18px;
        font-size: 13.5px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        margin-bottom: -2px;
        transition: all 0.2s ease;
    }
    .tab-btn:hover {
        color: #dc2626;
    }
    .tab-btn.active {
        color: #dc2626;
        border-bottom-color: #dc2626;
        font-weight: 800;
    }

    /* Tab 1: Settings Cards */
    .settings-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 20px 24px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        margin-bottom: 20px;
    }
    .settings-header {
        margin-bottom: 16px;
    }
    .settings-title {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
    }
    .settings-subtitle {
        font-size: 12px;
        color: #64748b;
        margin: 0;
    }
    .settings-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px 24px;
    }
    @media (max-width: 768px) {
        .settings-grid-2 { grid-template-columns: 1fr; }
    }
    .settings-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .form-label {
        font-size: 12px;
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
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .input-form-control:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
    }
    .input-with-suffix {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-with-suffix input {
        padding-right: 50px;
    }
    .suffix-text {
        position: absolute;
        right: 12px;
        font-size: 12px;
        color: #94a3b8;
        font-weight: 600;
        pointer-events: none;
    }
    .field-hint {
        font-size: 11px;
        color: #94a3b8;
    }
    .settings-action-bar {
        display: flex;
        justify-content: flex-start;
        margin-top: 10px;
    }
    .btn-save-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 20px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.25);
        transition: all 0.2s ease;
    }
    .btn-save-primary:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: translateY(-1px);
    }

    /* Tab 2: Target CPUS */
    .cpus-top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .year-select-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .year-label {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
    }
    .select-year-control {
        height: 36px;
        padding: 4px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        outline: none;
    }
    .input-cpus-control {
        width: 100%;
        max-width: 320px;
        height: 34px;
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        color: #1e293b;
        outline: none;
        transition: border-color 0.2s;
    }
    .input-cpus-control:focus {
        border-color: #dc2626;
    }
    .leads-calc-text {
        font-weight: 700;
        color: #dc2626;
        font-size: 13px;
    }

    /* Tab 3: Rotasi SA */
    .rotasi-header-block {
        margin-bottom: 16px;
    }
    .rotasi-subtitle {
        font-size: 12.5px;
        color: #64748b;
        margin: 0;
    }
    .rotasi-action-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .rotasi-add-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .select-control {
        height: 36px;
        padding: 4px 10px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        outline: none;
    }
    .btn-add-rotasi {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-add-rotasi:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }

    /* Table General */
    .table-card-wrapper {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }
    .master-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12.5px;
    }
    .master-table thead th {
        background: #ffffff;
        color: #475569;
        font-weight: 700;
        font-size: 12px;
        padding: 12px 16px;
        border-bottom: 1.5px solid #e2e8f0;
        white-space: nowrap;
    }
    .master-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .master-table tbody tr:hover {
        background-color: #f8fafc;
    }
    .master-table tbody td {
        padding: 10px 16px;
        color: #334155;
        vertical-align: middle;
    }
    .font-bold { font-weight: 700; }
    .font-mono { font-family: 'JetBrains Mono', monospace; font-size: 12px; }

    .badge-status-aktif {
        background: #dcfce7;
        color: #15803d;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 5px;
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
        color: #64748b;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-icon-delete:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fecaca;
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
        gap: 8px;
    }
    .empty-icon-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #f8fafc;
    }
    .empty-text {
        font-size: 13px;
        font-weight: 600;
        color: #94a3b8;
        margin: 0;
    }
</style>

<script>
    function switchTab(tabName) {
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content-panel').forEach(panel => panel.style.display = 'none');

        if (tabName === 'sla') {
            document.querySelectorAll('.tab-btn')[0].classList.add('active');
            document.getElementById('tabPanelSla').style.display = 'block';
        } else if (tabName === 'cpus') {
            document.querySelectorAll('.tab-btn')[1].classList.add('active');
            document.getElementById('tabPanelCpus').style.display = 'block';
        } else if (tabName === 'rotasi') {
            document.querySelectorAll('.tab-btn')[2].classList.add('active');
            document.getElementById('tabPanelRotasi').style.display = 'block';
        }
    }

    function calculateLeads(input, targetSpanId) {
        const val = parseFloat(input.value) || 0;
        const leads = Math.round(val * 0.08);
        document.getElementById(targetSpanId).textContent = leads;
    }

    function saveSlaSettings() {
        alert('Pengaturan SLA berhasil disimpan.');
    }

    function saveTargetCpus() {
        alert('Target CPUS berhasil disimpan.');
    }

    function changeYear(val) {
        alert('Memuat target CPUS tahun ' + val);
    }

    function addSaToRotasi() {
        const sa = document.getElementById('selectAddSa').value;
        alert('Menambahkan SA ' + sa + ' ke rotasi...');
    }

    function saveRotasiOrder() {
        alert('Urutan rotasi SA BP berhasil disimpan.');
    }

    function moveUp(index) {
        alert('Geser SA urutan ke-' + (index + 1) + ' ke atas.');
    }

    function moveDown(index) {
        alert('Geser SA urutan ke-' + (index + 1) + ' ke bawah.');
    }

    function deleteRotasi(nama) {
        if (confirm('Hapus ' + nama + ' dari rotasi SA?')) {
            alert(nama + ' dihapus dari rotasi.');
        }
    }
</script>
@endsection
