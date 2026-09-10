@extends('layouts.app')
@section('title', 'Edit Target & Budget - Activity Actual')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');

    .target-matrix-wrapper {
        padding: 24px 16px;
        max-width: 1380px;
        margin: 0 auto;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .page-title {
        text-align: center;
        font-weight: 900;
        color: #0f172a;
        text-shadow: 0px 4px 15px rgba(220, 38, 38, 0.2);
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 4px;
        font-size: 1.6rem;
    }
    .page-subtitle {
        text-align: center;
        color: #64748b;
        margin-bottom: 22px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* CONTROL FILTER BAR */
    .control-card {
        background: #0f172a;
        padding: 16px 24px;
        border-radius: 14px;
        border: 1px solid #1e293b;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.25);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }
    .filter-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .filter-label {
        color: #94a3b8;
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .filter-select {
        background: #1e293b;
        color: #ffffff;
        border: 1.5px solid #475569;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 0.82rem;
        font-weight: 700;
        outline: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .filter-select:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.3);
    }

    .btn-back {
        padding: 8px 16px;
        background: #1e293b;
        color: #e2e8f0;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.8rem;
        border: 1px solid #334155;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-back:hover {
        background: #334155;
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* SECTION MATRIX CARDS */
    .matrix-section {
        background: #ffffff;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 10px 30px -5px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
        margin-bottom: 24px;
        overflow-x: auto;
    }

    .section-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
        padding: 6px 16px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
    }
    .section-badge-purple {
        background: #f5f3ff;
        border-color: #ddd6fe;
        color: #6d28d9;
    }

    .table-matrix {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.8rem;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        overflow: hidden;
    }
    .table-matrix th {
        background: #f8fafc;
        color: #1e293b;
        font-weight: 800;
        text-align: center;
        padding: 11px 12px;
        border-bottom: 1.5px solid #cbd5e1;
        border-right: 1px solid #e2e8f0;
        font-size: 0.76rem;
        letter-spacing: 0.5px;
    }
    .table-matrix th.th-highlight {
        background: #eff6ff;
        color: #1d4ed8;
        border-bottom: 2px solid #3b82f6;
    }
    .table-matrix th.th-highlight-purple {
        background: #f5f3ff;
        color: #6d28d9;
        border-bottom: 2px solid #8b5cf6;
    }

    .table-matrix td {
        padding: 9px 12px;
        border-bottom: 1px solid #e2e8f0;
        border-right: 1px solid #e2e8f0;
        vertical-align: middle;
    }
    .table-matrix tr:last-child td {
        border-bottom: none;
    }
    .table-matrix tr:nth-child(even) {
        background: #fbfcfd;
    }
    .table-matrix tr:hover {
        background: #f1f5f9;
    }

    .item-name {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: 0.3px;
    }

    /* INPUT STYLING */
    .input-matrix {
        width: 100%;
        min-width: 90px;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        padding: 7px 10px;
        font-size: 0.82rem;
        font-weight: 700;
        text-align: center;
        color: #0f172a;
        outline: none;
        transition: all 0.2s ease;
        font-family: inherit;
    }
    .input-matrix:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        background: #ffffff;
    }
    .input-matrix.input-budget {
        text-align: right;
        min-width: 135px;
        color: #6d28d9;
        font-weight: 800;
    }
    .input-matrix.input-budget:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.25);
    }
    .input-matrix.input-highlight {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    .per-spk-badge {
        display: inline-block;
        width: 100%;
        text-align: right;
        font-weight: 800;
        color: #6d28d9;
        font-size: 0.8rem;
        padding: 6px 10px;
        background: #f5f3ff;
        border-radius: 6px;
        border: 1px solid #ddd6fe;
    }

    /* SUBMIT BAR */
    .submit-bar {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin-top: 10px;
        margin-bottom: 40px;
    }
    .btn-save {
        padding: 12px 28px;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        font-weight: 800;
        font-size: 0.9rem;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.35);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-save:hover {
        background: linear-gradient(135deg, #b91c1c, #991b1b);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.45);
    }
</style>

<div class="target-matrix-wrapper">
    <h1 class="page-title">EDIT TARGET & BUDGET (ACTUAL)</h1>
    <p class="page-subtitle">Sesuaikan Target (INQ, SPK, DO) & Total Budget per Model serta Kategori Aktivitas</p>

    {{-- FILTER HEADER --}}
    <div class="control-card">
        <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
            <div class="filter-item">
                <span class="filter-label">📍 CABANG:</span>
                <select id="cabangSelector" class="filter-select" onchange="reloadTargetForm()">
                    @foreach(['Ciawi', 'Cianjur', 'Cinere', 'Jatiasih', 'Cipanas'] as $cb)
                        <option value="{{ $cb }}" {{ ($cabang == $cb) ? 'selected' : '' }}>Cabang {{ $cb }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-item">
                <span class="filter-label">📅 BULAN:</span>
                <select id="bulanSelector" class="filter-select" onchange="reloadTargetForm()">
                    @php
                        $months = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                    @endphp
                    @foreach($months as $mNum => $mName)
                        <option value="{{ $mNum }}" {{ ($currMonthNum == $mNum) ? 'selected' : '' }}>{{ $mName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-item">
                <span class="filter-label">🗓️ TAHUN:</span>
                <select id="tahunSelector" class="filter-select" onchange="reloadTargetForm()">
                    @foreach([2025, 2026, 2027] as $y)
                        <option value="{{ $y }}" {{ ($currYear == $y) ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <a href="{{ route('activity.actual.index', ['cabang' => $cabang, 'bulan' => $currMonthNum, 'tahun' => $currYear]) }}" class="btn-back">
                ← Kembali ke Summary
            </a>
        </div>
    </div>

    <form action="{{ route('activity.actual.store') }}" method="POST" id="formTargetMatrix">
        @csrf
        <input type="hidden" name="cabang" value="{{ $cabang }}">
        <input type="hidden" name="bulan" value="{{ $currMonthNum }}">
        <input type="hidden" name="tahun" value="{{ $currYear }}">

        {{-- ========================================================================= --}}
        {{-- SECTION 1: TARGET & BUDGET # BY TYPE (8 MODEL)                            --}}
        {{-- ========================================================================= --}}
        <div class="matrix-section">
            <div class="section-badge">
                🚗 TARGET & BUDGET # BY TYPE (8 MODEL UNIT)
            </div>

            <table class="table-matrix">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO</th>
                        <th style="text-align: left; min-width: 180px; padding-left: 16px;">MODEL UNIT</th>
                        <th class="{{ $targetFocus == 'qty' ? 'th-highlight' : '' }}" style="width: 120px;">QTY ACT</th>
                        <th class="{{ $targetFocus == 'inq' ? 'th-highlight' : '' }}" style="width: 130px;">TGT INQ</th>
                        <th class="{{ $targetFocus == 'spk' ? 'th-highlight' : '' }}" style="width: 130px;">TGT SPK</th>
                        <th class="{{ $targetFocus == 'do' ? 'th-highlight' : '' }}" style="width: 130px;">TGT DO</th>
                        <th class="{{ in_array($targetFocus, ['budget', 'perspk']) ? 'th-highlight-purple' : '' }}" style="width: 190px;">TOTAL BUDGET (Rp)</th>
                        <th style="width: 170px;">EST. COST / SPK</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($unitModels as $model)
                        @php
                            $rec = $existingByType[$model] ?? null;
                            $valQty    = $rec ? ($rec->jml_sales_shift > 0 ? $rec->jml_sales_shift : '') : '';
                            $valInq    = $rec ? $rec->target_p : '';
                            $valSpk    = $rec ? $rec->target_spk : '';
                            $valDo     = $rec ? $rec->target_do : '';
                            $valBudget = ($rec && $rec->total_cost > 0) ? number_format($rec->total_cost, 0, ',', '.') : '';
                        @endphp
                        <tr>
                            <td style="text-align: center; font-weight: 700; color: #64748b;">{{ $loop->iteration }}</td>
                            <td class="item-name">{{ $model }}</td>
                            
                            {{-- QTY ACTIVITIES --}}
                            <td>
                                <input type="number" 
                                       name="targets_type[{{ $model }}][jml_sales_shift]" 
                                       value="{{ $valQty }}" 
                                       placeholder="0" 
                                       min="0"
                                       class="input-matrix {{ $targetFocus == 'qty' ? 'input-highlight' : '' }}">
                            </td>

                            {{-- TGT INQ --}}
                            <td>
                                <input type="number" 
                                       name="targets_type[{{ $model }}][target_p]" 
                                       value="{{ $valInq }}" 
                                       placeholder="0" 
                                       min="0"
                                       class="input-matrix {{ $targetFocus == 'inq' ? 'input-highlight' : '' }}">
                            </td>

                            {{-- TGT SPK --}}
                            <td>
                                <input type="number" 
                                       name="targets_type[{{ $model }}][target_spk]" 
                                       value="{{ $valSpk }}" 
                                       placeholder="0" 
                                       min="0"
                                       id="type-spk-{{ $loop->index }}"
                                       oninput="calcPerSpk('type', {{ $loop->index }})"
                                       class="input-matrix {{ $targetFocus == 'spk' ? 'input-highlight' : '' }}">
                            </td>

                            {{-- TGT DO --}}
                            <td>
                                <input type="number" 
                                       name="targets_type[{{ $model }}][target_do]" 
                                       value="{{ $valDo }}" 
                                       placeholder="0" 
                                       min="0"
                                       class="input-matrix {{ $targetFocus == 'do' ? 'input-highlight' : '' }}">
                            </td>

                            {{-- TOTAL BUDGET --}}
                            <td>
                                <input type="text" 
                                       name="targets_type[{{ $model }}][total_cost]" 
                                       value="{{ $valBudget }}" 
                                       placeholder="0" 
                                       id="type-budget-{{ $loop->index }}"
                                       oninput="formatCurrency(this); calcPerSpk('type', {{ $loop->index }})"
                                       class="input-matrix input-budget {{ in_array($targetFocus, ['budget', 'perspk']) ? 'input-highlight' : '' }}">
                            </td>

                            {{-- ESTIMASI PER SPK --}}
                            <td>
                                <span class="per-spk-badge" id="type-perspk-{{ $loop->index }}">
                                    Rp -
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ========================================================================= --}}
        {{-- SECTION 2: TARGET & BUDGET # BY ACTIVITY (14 KATEGORI)                    --}}
        {{-- ========================================================================= --}}
        <div class="matrix-section">
            <div class="section-badge section-badge-purple">
                📢 TARGET & BUDGET # BY ACTIVITY (14 KATEGORI AKTIVITAS)
            </div>

            <table class="table-matrix">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO</th>
                        <th style="text-align: left; min-width: 180px; padding-left: 16px;">KATEGORI AKTIVITAS</th>
                        <th class="{{ $targetFocus == 'qty' ? 'th-highlight' : '' }}" style="width: 120px;">QTY ACT</th>
                        <th class="{{ $targetFocus == 'inq' ? 'th-highlight' : '' }}" style="width: 130px;">TGT INQ</th>
                        <th class="{{ $targetFocus == 'spk' ? 'th-highlight' : '' }}" style="width: 130px;">TGT SPK</th>
                        <th class="{{ $targetFocus == 'do' ? 'th-highlight' : '' }}" style="width: 130px;">TGT DO</th>
                        <th class="{{ in_array($targetFocus, ['budget', 'perspk']) ? 'th-highlight-purple' : '' }}" style="width: 190px;">TOTAL BUDGET (Rp)</th>
                        <th style="width: 170px;">EST. COST / SPK</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activityList as $act)
                        @php
                            $rec = $existingByAct[$act] ?? null;
                            $valQty    = $rec ? ($rec->jml_sales_shift > 0 ? $rec->jml_sales_shift : '') : '';
                            $valInq    = $rec ? $rec->target_p : '';
                            $valSpk    = $rec ? $rec->target_spk : '';
                            $valDo     = $rec ? $rec->target_do : '';
                            $valBudget = ($rec && $rec->total_cost > 0) ? number_format($rec->total_cost, 0, ',', '.') : '';
                        @endphp
                        <tr>
                            <td style="text-align: center; font-weight: 700; color: #64748b;">{{ $loop->iteration }}</td>
                            <td class="item-name">{{ $act }}</td>
                            
                            {{-- QTY ACTIVITIES --}}
                            <td>
                                <input type="number" 
                                       name="targets_act[{{ $act }}][jml_sales_shift]" 
                                       value="{{ $valQty }}" 
                                       placeholder="0" 
                                       min="0"
                                       class="input-matrix {{ $targetFocus == 'qty' ? 'input-highlight' : '' }}">
                            </td>

                            {{-- TGT INQ --}}
                            <td>
                                <input type="number" 
                                       name="targets_act[{{ $act }}][target_p]" 
                                       value="{{ $valInq }}" 
                                       placeholder="0" 
                                       min="0"
                                       class="input-matrix {{ $targetFocus == 'inq' ? 'input-highlight' : '' }}">
                            </td>

                            {{-- TGT SPK --}}
                            <td>
                                <input type="number" 
                                       name="targets_act[{{ $act }}][target_spk]" 
                                       value="{{ $valSpk }}" 
                                       placeholder="0" 
                                       min="0"
                                       id="act-spk-{{ $loop->index }}"
                                       oninput="calcPerSpk('act', {{ $loop->index }})"
                                       class="input-matrix {{ $targetFocus == 'spk' ? 'input-highlight' : '' }}">
                            </td>

                            {{-- TGT DO --}}
                            <td>
                                <input type="number" 
                                       name="targets_act[{{ $act }}][target_do]" 
                                       value="{{ $valDo }}" 
                                       placeholder="0" 
                                       min="0"
                                       class="input-matrix {{ $targetFocus == 'do' ? 'input-highlight' : '' }}">
                            </td>

                            {{-- TOTAL BUDGET --}}
                            <td>
                                <input type="text" 
                                       name="targets_act[{{ $act }}][total_cost]" 
                                       value="{{ $valBudget }}" 
                                       placeholder="0" 
                                       id="act-budget-{{ $loop->index }}"
                                       oninput="formatCurrency(this); calcPerSpk('act', {{ $loop->index }})"
                                       class="input-matrix input-budget {{ in_array($targetFocus, ['budget', 'perspk']) ? 'input-highlight' : '' }}">
                            </td>

                            {{-- ESTIMASI PER SPK --}}
                            <td>
                                <span class="per-spk-badge" id="act-perspk-{{ $loop->index }}">
                                    Rp -
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="submit-bar">
            <a href="{{ route('activity.actual.index', ['cabang' => $cabang, 'bulan' => $currMonthNum, 'tahun' => $currYear]) }}" class="btn-back">
                Batal
            </a>
            <button type="submit" class="btn-save">
                💾 SIMPAN TARGET & BUDGET
            </button>
        </div>
    </form>
</div>

<script>
    function reloadTargetForm() {
        var cabang = document.getElementById('cabangSelector').value;
        var bulan  = document.getElementById('bulanSelector').value;
        var tahun  = document.getElementById('tahunSelector').value;
        window.location.href = "{{ route('activity.actual.create') }}?cabang=" + encodeURIComponent(cabang) + "&bulan=" + bulan + "&tahun=" + tahun;
    }

    function formatCurrency(input) {
        var num = input.value.replace(/[^0-9]/g, '');
        if (num === '') {
            input.value = '';
            return;
        }
        input.value = new Intl.NumberFormat('id-ID').format(num);
    }

    function calcPerSpk(prefix, idx) {
        var spkElem = document.getElementById(prefix + '-spk-' + idx);
        var budgetElem = document.getElementById(prefix + '-budget-' + idx);
        var resElem = document.getElementById(prefix + '-perspk-' + idx);

        if (!spkElem || !budgetElem || !resElem) return;

        var spkVal = parseInt(spkElem.value) || 0;
        var budgetVal = parseFloat(budgetElem.value.replace(/\./g, '').replace(/,/g, '')) || 0;

        if (budgetVal > 0 && spkVal > 0) {
            var perSpk = Math.round(budgetVal / spkVal);
            resElem.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(perSpk);
        } else {
            resElem.innerText = 'Rp -';
        }
    }

    // Init auto-calculations on page load
    document.addEventListener('DOMContentLoaded', function() {
        for (var i = 0; i < 8; i++) {
            calcPerSpk('type', i);
        }
        for (var j = 0; j < 10; j++) {
            calcPerSpk('act', j);
        }
    });
</script>
@endsection