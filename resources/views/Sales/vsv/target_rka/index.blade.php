@extends('layouts.app')

@section('content')
    <div style="padding: 20px; max-width: 1450px; margin: 0 auto; font-family:'Segoe UI', sans-serif;">

        {{-- JUDUL HALAMAN --}}
        <h2
            style="text-align:center; font-weight:800; color:#1e293b; font-weight:800; letter-spacing:0.5px; text-transform:uppercase; margin-bottom:5px;">
            {{ $pageTitle ?? 'TARGET SALESFORCE' }}
        </h2>
        <p style="text-align:center; color: #64748b; margin-bottom:20px; font-size: 14px;">
            Kelola dan pantau target berkala berdasarkan periode bulan, tahun, cabang, dan sales head.
        </p>

        <div style="display:flex; justify-content:flex-start; align-items:center; margin-bottom:15px;">
            <a href="{{ url('/rka/dashboard') }}"
                style="padding: 8px 16px; background: #ffffff; color: #1e293b !important; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 12px; border: 1.5px solid #cbd5e1; box-shadow: 0 2px 6px rgba(0,0,0,0.04); transition: 0.25s;">
                ← Dashboard RKA
            </a>
        </div>

        {{-- CARD FILTER PENCARIAN --}}
        <div
            style="background:#fff; padding:20px; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.3); margin-bottom:15px;">
            <form action="" method="GET">
                <div
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)) 110px; gap: 15px; align-items: end;">

                    {{-- Filter Bulan --}}
                    <div>
                        <label
                            style="display:block; font-weight:700; font-size:11px; color:#4a5568; margin-bottom:5px; text-transform:uppercase;">Bulan</label>
                        <select name="month"
                            style="width:100%; padding:8px; border:1px solid #cbd5e0; border-radius:6px; font-size:12px; background:#fff;">
                            @php
                                $monthsList = [
                                    1 => 'January',
                                    2 => 'February',
                                    3 => 'March',
                                    4 => 'April',
                                    5 => 'May',
                                    6 => 'June',
                                    7 => 'July',
                                    8 => 'August',
                                    9 => 'September',
                                    10 => 'October',
                                    11 => 'November',
                                    12 => 'December',
                                ];
                            @endphp
                            @foreach ($monthsList as $mNum => $mName)
                                <option value="{{ $mNum }}" {{ ($selectedMonth ?? date('n')) == $mNum ? 'selected' : '' }}>
                                    {{ $mName }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Tahun --}}
                    <div>
                        <label
                            style="display:block; font-weight:700; font-size:11px; color:#4a5568; margin-bottom:5px; text-transform:uppercase;">Tahun</label>
                        <select name="year"
                            style="width:100%; padding:8px; border:1px solid #cbd5e0; border-radius:6px; font-size:12px; background:#fff;">
                            @for ($y = 2024; $y <= 2028; $y++)
                                <option value="{{ $y }}"
                                    {{ ($selectedYear ?? date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    {{-- Filter BranchCode (Sesuai Kolom Database) --}}
                    <div>
                        <label
                            style="display:block; font-weight:700; font-size:11px; color:#4a5568; margin-bottom:5px; text-transform:uppercase;">Branch
                            Code</label>
                        <div style="display:flex;">
                            <input type="text" name="BranchCode" id="branch_code_input" value="{{ $BranchCode ?? '' }}"
                                placeholder="Semua Cabang"
                                style="width:100%; padding:7px 10px; border:1px solid #cbd5e0; border-radius:6px 0 0 6px; font-size:12px; outline:none;">
                            <button type="button" id="btnOpenBranchModal"
                                style="padding:7px 12px; background:#edf2f7; border:1px solid #cbd5e0; border-left:none; border-radius:0 6px 6px 0; cursor:pointer;">🔍</button>
                        </div>
                    </div>

                    {{-- Filter SpvEmployeeID (Sesuai Kolom Database) --}}
                    <div>
                        <label
                            style="display:block; font-weight:700; font-size:11px; color:#4a5568; margin-bottom:5px; text-transform:uppercase;">Sales
                            Head ID</label>
                        <div style="display:flex;">
                            <input type="text" name="SpvEmployeeID" id="spv_id_input" value="{{ $SpvEmployeeID ?? '' }}" placeholder="Pilih Branch dulu..."
                                style="width:100%; padding:7px 10px; border:1px solid #cbd5e0; border-radius:6px 0 0 6px; font-size:12px; outline:none; background:#f0f0f0;" readonly>
                            <button type="button" id="btnOpenSpvModal" disabled
                                style="padding:7px 12px; background:#d4d4d4; border:1px solid #cbd5e0; border-left:none; border-radius:0 6px 6px 0; cursor:not-allowed; opacity:0.6;">🔍</button>
                        </div>
                        <small id="spvHelpText" style="color:#a0aec0; font-size:10px;">⬆ Pilih Branch Code terlebih dahulu</small>
                    </div>

                    {{-- Tombol Submit Filter --}}
                    <div>
                        <button type="submit"
                            style="width:100%; padding:8px 15px; background:#dc2626; color:#ffff; font-weight:800; border:none; border-radius:6px; font-weight:700; font-size:12px; cursor:pointer; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                            Filter
                        </button>
                    </div>

                </div>
            </form>
        </div>

        {{-- KOTAK RINGKASAN TOTAL MINGGUAN DI ATAS --}}
        @if (isset($summary))
            <div
                style="background:#fff; padding:12px 20px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.15); margin-bottom:15px; font-size:12px; font-weight:600; color:#2d3748; display:flex; gap: 30px; align-items: center; flex-wrap: wrap;">
                <span style="color:#e53e3e; font-weight:800;">TOTAL :</span>
                @foreach (['w1' => 'WEEK-1', 'w2' => 'WEEK-2', 'w3' => 'WEEK-3', 'w4' => 'WEEK-4', 'w5' => 'WEEK-5'] as $key => $label)
                    <div style="display:flex; gap:8px;">
                        <span style="color:#4a5568;">{{ $label }}:</span>
                        <span>DO: {{ $summary[$key]['do'] ?? 0 }}</span>
                        <span style="color:#64748b;">|</span>
                        <span>SPK: {{ $summary[$key]['spk'] ?? 0 }}</span>
                        <span style="color:#64748b;">|</span>
                        <span>INQ: {{ $summary[$key]['inq'] ?? 0 }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div
                style="background:#fff; padding:12px 20px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.15); margin-bottom:15px; font-size:12px; font-weight:600; color:#2d3748; display:flex; gap: 30px; align-items: center; flex-wrap: wrap;">
                <span style="color:#e53e3e; font-weight:800;">TOTAL :</span>
                @foreach (['w1' => 'WEEK-1', 'w2' => 'WEEK-2', 'w3' => 'WEEK-3', 'w4' => 'WEEK-4', 'w5' => 'WEEK-5'] as $key => $label)
                    <div style="display:flex; gap:8px;">
                        <span style="color:#4a5568;">{{ $label }}:</span>
                        <span>DO: 0</span>
                        <span style="color:#64748b;">|</span>
                        <span>SPK: 0</span>
                        <span style="color:#64748b;">|</span>
                        <span>INQ: 0</span>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- TABEL UTAMA MATRIX TARGET MINGGUAN --}}
        <div
            style="background:#fff; padding:15px; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.3); overflow-x:auto;">
            <table width="100%" cellpadding="0" cellspacing="0"
                style="width:100%; border-collapse:collapse; font-family:'Segoe UI',sans-serif; font-size:11px; text-align:center; border: 1px solid #cbd5e1;">

                @php
                    $monthsArr = [
                        1 => 'JANUARY',
                        2 => 'FEBRUARY',
                        3 => 'MARCH',
                        4 => 'APRIL',
                        5 => 'MAY',
                        6 => 'JUNE',
                        7 => 'JULY',
                        8 => 'AUGUST',
                        9 => 'SEPTEMBER',
                        10 => 'OCTOBER',
                        11 => 'NOVEMBER',
                        12 => 'DECEMBER',
                    ];
                    $mName = $monthsArr[$selectedMonth ?? date('n')] ?? 'JULY';
                    $yNum = $selectedYear ?? date('Y');
                    $currentMonthLabel = $mName . '-' . $yNum;
                @endphp

                <thead style="background:#fee2e2; color:#991b1b;">
                    <tr style="border-bottom: 1px solid #f87171;">
                        <th rowspan="3"
                            style="border: 1px solid #cbd5e1; padding: 12px; text-align: left; padding-left: 12px; vertical-align: middle; min-width: 200px;">
                            {{ $tableHeaderLabel ?? 'By Salesman' }}
                        </th>
                        <th colspan="15"
                            style="border: 1px solid #cbd5e1; padding:8px; background:#fee2e2; font-weight:800; color:#1a202c; font-size:12px;">
                            {{ $currentMonthLabel }}
                        </th>
                        <th colspan="3" rowspan="2"
                            style="border: 1px solid #cbd5e1; padding:8px; background:#fee2e2; vertical-align:middle; font-weight:700;">
                            TOTAL
                        </th>
                    </tr>

                    <tr style="border-bottom: 1px solid #f87171; background:#fee2e2;">
                        <th colspan="3" style="border: 1px solid #cbd5e1; padding:6px; background:#fef2f2;">WEEK-1</th>
                        <th colspan="3" style="border: 1px solid #cbd5e1; padding:6px; background:#fef2f2;">WEEK-2</th>
                        <th colspan="3" style="border: 1px solid #cbd5e1; padding:6px; background:#fef2f2;">WEEK-3</th>
                        <th colspan="3" style="border: 1px solid #cbd5e1; padding:6px; background:#fef2f2;">WEEK-4</th>
                        <th colspan="3" style="border: 1px solid #cbd5e1; padding:6px; background:#fef2f2;">WEEK-5</th>
                    </tr>

                    <tr style="border-bottom: 2px solid #f87171; background:#fee2e2;">
                        @for ($i = 1; $i <= 5; $i++)
                            <th style="border: 1px solid #cbd5e1; padding:6px; width:35px; font-size:10px;">DO</th>
                            <th style="border: 1px solid #cbd5e1; padding:6px; width:35px; font-size:10px;">SPK</th>
                            <th style="border: 1px solid #cbd5e1; padding:6px; width:35px; font-size:10px;">INQ</th>
                        @endfor
                        <th style="border: 1px solid #cbd5e1; padding:6px; width:40px; font-size:10px;">DO</th>
                        <th style="border: 1px solid #cbd5e1; padding:6px; width:40px; font-size:10px;">SPK</th>
                        <th style="border: 1px solid #cbd5e1; padding:6px; width:40px; font-size:10px;">INQ</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($dataMatrix ?? [] as $row)
                        @php
                            $totalDo =
                                ($row->DO_Week1 ?? 0) +
                                ($row->DO_Week2 ?? 0) +
                                ($row->DO_Week3 ?? 0) +
                                ($row->DO_Week4 ?? 0) +
                                ($row->DO_Week5 ?? 0);
                            $totalSpk =
                                ($row->SPK_Week1 ?? 0) +
                                ($row->SPK_Week2 ?? 0) +
                                ($row->SPK_Week3 ?? 0) +
                                ($row->SPK_Week4 ?? 0) +
                                ($row->SPK_Week5 ?? 0);
                            $totalInq =
                                ($row->INQ_Week1 ?? 0) +
                                ($row->INQ_Week2 ?? 0) +
                                ($row->INQ_Week3 ?? 0) +
                                ($row->INQ_Week4 ?? 0) +
                                ($row->INQ_Week5 ?? 0);
                        @endphp
                        <tr
                            style="background:{{ $loop->iteration % 2 == 0 ? '#f7faff' : '#ffffff' }}; border-bottom: 1px solid var(--border-color, #e2e8f0);">
                            <td
                                style="border: 1px solid #cbd5e1; font-weight:600; text-align:left; padding-left:12px; padding-top:8px; padding-bottom:8px;">
                                {{ $row->DetailName ?? '-' }}
                            </td>
                            @for ($i = 1; $i <= 5; $i++)
                                <td style="border: 1px solid #cbd5e1;">{{ $row->{"DO_Week{$i}"} ?? 0 }}</td>
                                <td style="border: 1px solid #cbd5e1;">{{ $row->{"SPK_Week{$i}"} ?? 0 }}</td>
                                <td style="border: 1px solid #cbd5e1;">{{ $row->{"INQ_Week{$i}"} ?? 0 }}</td>
                            @endfor
                            <td style="border: 1px solid #cbd5e1; font-weight:700; background:#ebf8ff;">{{ $totalDo }}</td>
                            <td style="border: 1px solid #cbd5e1; font-weight:700; background:#ebf8ff;">{{ $totalSpk }}</td>
                            <td style="border: 1px solid #cbd5e1; font-weight:700; background:#ebf8ff;">{{ $totalInq }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="19"
                                style="padding: 25px; text-align: center; color: #718096; border: 1px solid #cbd5e1;">
                                Belum ada data target untuk periode dan filter yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    {{-- CUSTOM MODAL POP-UP BRANCH --}}
    <div id="customBranchModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
        <div style="background:#fff; width:400px; max-width:90%; border-radius:8px; box-shadow:0 4px 20px rgba(0,0,0,0.2); overflow:hidden;">
            <div style="padding:15px 20px; background:#f7fafc; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center;">
                <h5 style="margin:0; font-weight:700; font-size:15px; color:#2d3748;">Pilih Branch / Cabang</h5>
                <button type="button" id="btnCloseBranchModal" style="background:none; border:none; font-size:18px; cursor:pointer; color:#a0aec0;">&times;</button>
            </div>
            <div style="padding:20px;">
                <p style="color: #4a5568; font-size: 13px; margin-top:0;">Silakan masukkan atau pilih data berdasarkan <b>BranchCode</b>.</p>
                <input type="text" id="searchBranchInput" placeholder="Cari BranchCode..." style="width:100%; padding:8px 12px; border:1px solid #cbd5e0; border-radius:6px; font-size:13px; margin-bottom:12px; outline:none;">
                <div style="max-height: 200px; overflow-y: auto;" id="branchListContainer">
                    @forelse($branches ?? [] as $bCode)
                        @php $bName = $branchesData[$bCode] ?? ''; @endphp
                        <div class="branch-item" style="padding:8px; border-bottom:1px solid #eee; cursor:pointer; font-size:13px;" onclick="selectBranch('{{ $bCode }}')">
                            {{ $bCode }} - {{ $bName }}
                        </div>
                    @empty
                        <p style="text-align:center; color:#a0aec0; font-size:13px; margin:20px 0;">Belum ada data BranchCode terhubung.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- CUSTOM MODAL POP-UP SALES HEAD --}}
    <div id="customSpvModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
        <div style="background:#fff; width:400px; max-width:90%; border-radius:8px; box-shadow:0 4px 20px rgba(0,0,0,0.2); overflow:hidden;">
            <div style="padding:15px 20px; background:#f7fafc; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center;">
                <h5 style="margin:0; font-weight:700; font-size:15px; color:#2d3748;">Pilih Sales Head ID</h5>
                <button type="button" id="btnCloseSpvModal" style="background:none; border:none; font-size:18px; cursor:pointer; color:#a0aec0;">&times;</button>
            </div>
            <div style="padding:20px;">
                <p style="color: #4a5568; font-size: 13px; margin-top:0;">Silakan masukkan atau pilih data berdasarkan <b>SpvEmployeeID</b>.</p>
                <input type="text" id="searchSpvInput" placeholder="Cari SpvEmployeeID..." style="width:100%; padding:8px 12px; border:1px solid #cbd5e0; border-radius:6px; font-size:13px; margin-bottom:12px; outline:none;">
                <div style="max-height: 200px; overflow-y: auto;" id="spvListContainer">
                    @forelse($spvs ?? [] as $sCode)
                        @php $sName = $spvsData[$sCode] ?? ''; @endphp
                        <div class="spv-item" data-spv="{{ $sCode }}" style="padding:8px; border-bottom:1px solid #eee; cursor:pointer; font-size:13px;" onclick="selectSpv('{{ $sCode }}')">
                            {{ $sCode }} - {{ $sName }}
                        </div>
                    @empty
                        <p style="text-align:center; color:#a0aec0; font-size:13px; margin:20px 0;">Belum ada data SpvEmployeeID terhubung.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simpan data pemetaan Branch -> SPV dan master Branch dari Controller
        const branchSpvMap = @json($branchSpvMap ?? []);
        const branchesData = @json($branchesData ?? []);

        document.addEventListener('DOMContentLoaded', function() {
            // Elemen-elemen
            const branchModal = document.getElementById('customBranchModal');
            const btnOpenBranch = document.getElementById('btnOpenBranchModal');
            const btnCloseBranch = document.getElementById('btnCloseBranchModal');
            const spvModal = document.getElementById('customSpvModal');
            const btnOpenSpv = document.getElementById('btnOpenSpvModal');
            const btnCloseSpv = document.getElementById('btnCloseSpvModal');
            const spvInput = document.getElementById('spv_id_input');
            const spvHelpText = document.getElementById('spvHelpText');
            const branchInput = document.getElementById('branch_code_input');

            // === Branch Modal ===
            if (btnOpenBranch && branchModal) {
                btnOpenBranch.addEventListener('click', function() {
                    branchModal.style.display = 'flex';
                });
            }
            if (btnCloseBranch && branchModal) {
                btnCloseBranch.addEventListener('click', function() {
                    branchModal.style.display = 'none';
                });
            }

            // === SPV Modal (hanya bisa dibuka kalau Branch sudah dipilih) ===
            if (btnOpenSpv && spvModal) {
                btnOpenSpv.addEventListener('click', function() {
                    if (!this.disabled) {
                        spvModal.style.display = 'flex';
                    }
                });
            }
            if (btnCloseSpv && spvModal) {
                btnCloseSpv.addEventListener('click', function() {
                    spvModal.style.display = 'none';
                });
            }

            // Tutup modal jika mengklik area gelap
            window.addEventListener('click', function(event) {
                if (event.target === branchModal) branchModal.style.display = 'none';
                if (event.target === spvModal) spvModal.style.display = 'none';
            });

            // Live search di modal Branch
            const searchBranchInput = document.getElementById('searchBranchInput');
            if (searchBranchInput) {
                searchBranchInput.addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    document.querySelectorAll('.branch-item').forEach(item => {
                        item.style.display = item.innerText.toLowerCase().includes(filter) ? '' : 'none';
                    });
                });
            }

            // Live search di modal SPV (hanya cari yang visible/allowed)
            const searchSpvInput = document.getElementById('searchSpvInput');
            if (searchSpvInput) {
                searchSpvInput.addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    document.querySelectorAll('.spv-item').forEach(item => {
                        if (item.classList.contains('hidden-by-branch')) return;
                        item.style.display = item.innerText.toLowerCase().includes(filter) ? '' : 'none';
                    });
                });
            }

            // Listener jika user mengetik langsung di input Branch Code
            if (branchInput) {
                branchInput.addEventListener('input', function() {
                    const val = this.value.trim();
                    if (val !== '') {
                        enableSpvButton();
                        filterSpvList(val);
                    } else {
                        disableSpvButton();
                    }
                });
            }

            // Kalau halaman load dengan Branch sudah terisi (dari filter sebelumnya), aktifkan SPV
            if (branchInput && branchInput.value.trim() !== '') {
                enableSpvButton();
                filterSpvList(branchInput.value.trim());
            }
        });

        function enableSpvButton() {
            const btn = document.getElementById('btnOpenSpvModal');
            const input = document.getElementById('spv_id_input');
            const helpText = document.getElementById('spvHelpText');
            if (btn) {
                btn.disabled = false;
                btn.style.cursor = 'pointer';
                btn.style.opacity = '1';
                btn.style.background = '#edf2f7';
            }
            if (input) {
                input.readOnly = false;
                input.style.background = '#fff';
                input.placeholder = 'Semua Sales Head';
            }
            if (helpText) helpText.style.display = 'none';
        }

        function disableSpvButton() {
            const btn = document.getElementById('btnOpenSpvModal');
            const input = document.getElementById('spv_id_input');
            const helpText = document.getElementById('spvHelpText');
            if (btn) {
                btn.disabled = true;
                btn.style.cursor = 'not-allowed';
                btn.style.opacity = '0.6';
                btn.style.background = '#d4d4d4';
            }
            if (input) {
                input.readOnly = true;
                input.style.background = '#f0f0f0';
                input.value = '';
                input.placeholder = 'Pilih Branch dulu...';
            }
            if (helpText) helpText.style.display = '';
        }

        function getResolvedBranchCodes(inputVal) {
            if (!inputVal) return [];
            const term = inputVal.trim().toLowerCase();
            const results = [];
            // 1. Direct match di branchSpvMap
            if (branchSpvMap[inputVal.trim()]) {
                results.push(inputVal.trim());
            }
            // 2. Cari di master branchesData (code atau name)
            for (const [code, name] of Object.entries(branchesData)) {
                if (code.toLowerCase().includes(term) || (name && name.toLowerCase().includes(term))) {
                    if (!results.includes(code)) {
                        results.push(code);
                    }
                }
            }
            return results;
        }

        function filterSpvList(branchCodeOrName) {
            const resolvedCodes = getResolvedBranchCodes(branchCodeOrName);
            let allowedSpvs = [];
            if (resolvedCodes.length > 0) {
                resolvedCodes.forEach(code => {
                    if (branchSpvMap[code]) {
                        allowedSpvs = allowedSpvs.concat(branchSpvMap[code]);
                    }
                });
            } else if (branchSpvMap[branchCodeOrName]) {
                allowedSpvs = branchSpvMap[branchCodeOrName];
            }

            document.querySelectorAll('.spv-item').forEach(item => {
                const spvCode = item.getAttribute('data-spv');
                if (allowedSpvs.includes(spvCode)) {
                    item.style.display = '';
                    item.classList.remove('hidden-by-branch');
                } else {
                    item.style.display = 'none';
                    item.classList.add('hidden-by-branch');
                }
            });
        }

        function selectBranch(code) {
            document.getElementById('branch_code_input').value = code;
            document.getElementById('customBranchModal').style.display = 'none';

            // Reset SPV karena Branch berubah
            document.getElementById('spv_id_input').value = '';
            const searchSpvInput = document.getElementById('searchSpvInput');
            if (searchSpvInput) searchSpvInput.value = '';

            // Aktifkan tombol SPV
            enableSpvButton();

            // Filter isi modal SPV sesuai Branch yang dipilih
            filterSpvList(code);
        }

        function selectSpv(code) {
            document.getElementById('spv_id_input').value = code;
            document.getElementById('customSpvModal').style.display = 'none';
        }
    </script>
@endsection