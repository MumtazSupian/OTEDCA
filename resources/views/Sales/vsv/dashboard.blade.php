@extends('layouts.app')

@section('title', 'Main Dashboard')

@section('content')
    <div style="padding: 10px; color: var(--text-main);">

        {{-- HEADER & FILTER --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 2px solid var(--accent-red); padding-bottom: 15px;">
            <h2 style="font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin: 0; color: var(--text-main);">
                DASHBOARD PERFORMANCE
            </h2>

            <form action="{{ url()->current() }}" method="GET" id="filterForm" style="display: flex; align-items: center; gap: 10px;">
                <label style="font-weight: bold; font-size: 14px;">PERIODE DATA:</label>
                <select name="filter_bulan" onchange="document.getElementById('filterForm').submit()"
                    style="padding: 8px 15px; border-radius: 5px; border: none; font-weight: bold; color: #001f3f; cursor: pointer; outline: none;">
                    @foreach ($bulan_list as $angka => $nama)
                        <option value="{{ $nama }}" {{ $bulan == $nama ? 'selected' : '' }}>
                            {{ strtoupper($nama) }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        @foreach($all_branch_data as $nama_cabang => $data)

            {{-- JUDUL CABANG --}}
            <div style="margin-top: 40px; margin-bottom: 20px; border-bottom: 3px solid #dc2626; padding-bottom: 10px;">
                <h2 style="color: #ffff; font-weight:800; background-color: #dc2626; padding: 10px 20px; border-radius: 5px; display: inline-block; font-weight: bold; text-transform: uppercase;">
                    <i class="fas fa-building"></i> DATA CABANG: {{ $nama_cabang }}
                </h2>
            </div>

            {{-- 1. TABLE SALES PERFORMANCE --}}
            <div style="background: white; border-radius: 8px; padding: 15px; margin-bottom: 25px; overflow-x: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.3);">
                <h4 style="color: #dc2626; margin-bottom: 10px; font-weight: bold;">
                    📊 SALES PERFORMANCE (N) {{ strtoupper($bulan) }} 2026
                </h4>
                <table style="width:100%; border-collapse: collapse; color: black; font-size: 11px; text-align: center;">
                    <thead style="background: #fee2e2; color: #991b1b;">
                        <tr>
                            <th rowspan="2" style="border: 1px solid #cbd5e1; padding: 10px; width: 150px;">MODEL</th>
                            <th colspan="4" style="border: 1px solid #cbd5e1;">Bulan Berjalan ({{ strtoupper($bulan) }})</th>
                            <th colspan="3" style="border: 1px solid #cbd5e1;">RASIO</th>
                            <th colspan="3" style="border: 1px solid #cbd5e1;">KPI Year-To-Date (YTD)</th>
                            <th colspan="2" style="border: 1px solid #cbd5e1;">SALES PLAN (N+1)</th>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #cbd5e1;">TRG RKA</th>
                            <th style="border: 1px solid #cbd5e1;">ACT DO</th>
                            <th style="border: 1px solid #cbd5e1;">ACT SPK</th>
                            <th style="border: 1px solid #cbd5e1;">ACT INQ</th>
                            <th style="border: 1px solid #cbd5e1;">INQ to DO</th>
                            <th style="border: 1px solid #cbd5e1;">INQ to SPK</th>
                            <th style="border: 1px solid #cbd5e1;">SPK to DO</th>
                            <th style="border: 1px solid #cbd5e1;">TRG RKA</th>
                            <th style="border: 1px solid #cbd5e1;">ACT DO</th>
                            <th style="border: 1px solid #cbd5e1;">+/-</th>
                            <th style="border: 1px solid #cbd5e1;">RKA</th>
                            <th style="border: 1px solid #cbd5e1;">ADJ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['performance'] as $item)
                        @if(strtoupper($item->mobil_type) !== 'BALENO')
                            <tr>
                                <td style="border: 1px solid #cbd5e1; background: #ffff00; font-weight: bold; text-align: left; padding: 5px;">
                                    {{ $item->mobil_type }}
                                </td>
                                <td style="border: 1px solid #cbd5e1; font-weight: bold;">{{ $item->$bulan }}</td>
                                <td style="border: 1px solid #cbd5e1;">{{ $item->act_do }}</td>
                                <td style="border: 1px solid #cbd5e1;">{{ $item->act_spk }}</td>
                                <td style="border: 1px solid #cbd5e1;">{{ $item->act_inq }}</td>

                               {{-- KOLOM RASIO --}}
                                @php
                                    $inq = $item->act_inq ?? 0;
                                    $spk = $item->act_spk ?? 0;
                                    $do  = $item->act_do ?? 0;
                                    
                                    $ratio_inq_do  = $inq > 0 ? ($do / $inq) * 100 : 0;
                                    $ratio_inq_spk = $inq > 0 ? ($spk / $inq) * 100 : 0;
                                    $ratio_spk_do  = $spk > 0 ? ($do / $spk) * 100 : 0;
                                @endphp

                                <td style="border: 1px solid #cbd5e1; background: #fdf5e6; font-weight: bold;">
                                    {{ number_format($ratio_inq_do, 1) }}%
                                </td>
                                <td style="border: 1px solid #cbd5e1;">
                                    {{ number_format($ratio_inq_spk, 1) }}%
                                </td>
                                <td style="border: 1px solid #cbd5e1;">
                                    {{ number_format($ratio_spk_do, 1) }}%
                                </td>

                                <td style="border: 1px solid #cbd5e1; background: #f0f0f0;">{{ $item->ytd_target }}</td>
                                <td style="border: 1px solid #cbd5e1;">{{ $item->ytd_act_do }}</td>
                                <td style="border: 1px solid #cbd5e1;">{{ $item->ytd_act_do - $item->ytd_target }}</td>
                                <td style="border: 1px solid #cbd5e1;">{{ $item->plan_rka_next }}</td>
                                <td style="border: 1px solid #cbd5e1;"></td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot style="background: #00b0f0; font-weight: bold;">
                        <tr>
                            <td style="border: 1px solid #cbd5e1; text-align: left; padding: 5px;">GRAND TOTAL</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $data['performance']->sum($bulan) }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $data['performance']->sum('act_do') }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $data['performance']->sum('act_spk') }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $data['performance']->sum('act_inq') }}</td>
                            <td colspan="3" style="border: 1px solid #cbd5e1;">AVG RATIO CALCULATED</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $data['performance']->sum('ytd_target') }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $data['performance']->sum('ytd_act_do') }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $data['performance']->sum('ytd_act_do') - $data['performance']->sum('ytd_target') }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $data['performance']->sum('plan_rka_next') }}</td>
                            <td style="border: 1px solid #cbd5e1;">0</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div style="margin-top: 20px;">
                {{-- 2. TABLE PERFORMANCE SOI --}}
                <div style="background: white; border-radius: 8px; padding: 15px; margin-bottom: 25px; overflow-x: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.3); width: 100%;">
                    <h4 style="color: #dc2626; margin-bottom: 10px; font-weight: bold;">🔍 PERFORMANCE SOI ({{ strtoupper($bulan) }})</h4>
                    <table style="width:100%; border-collapse: collapse; color: black; font-size: 11px; text-align: center;">
                        <thead style="background: #fee2e2; color: #991b1b;">
                            <tr>
                                <th style="border: 1px solid #cbd5e1; padding: 10px; text-align: left; padding-left: 10px; width: 300px;">SOURCE OF INQUIRY</th>
                                <th style="border: 1px solid #cbd5e1; padding: 10px;">TRG INQ</th>
                                <th style="border: 1px solid #cbd5e1; padding: 10px;">ACT INQ</th>
                                <th style="border: 1px solid #cbd5e1; padding: 10px;">TRG DO</th>
                                <th style="border: 1px solid #cbd5e1; padding: 10px;">ACT DO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['soi_performance_data'] as $item)
                                <tr>
                                    <td style="border: 1px solid #cbd5e1; text-align: left; background: #ffff00; font-weight: bold; padding: 6px 10px;">{{ $item->source_name }}</td>
                                    <td style="border: 1px solid #cbd5e1; padding: 6px;">{{ $item->trg_inq }}</td>
                                    <td style="border: 1px solid #cbd5e1; padding: 6px;">{{ $item->act_inq }}</td>
                                    <td style="border: 1px solid #cbd5e1; padding: 6px;">{{ $item->trg_do }}</td>
                                    <td style="border: 1px solid #cbd5e1; padding: 6px;">{{ $item->act_do }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="background: #00b0f0; font-weight: bold;">
                            <tr>
                                <td style="border: 1px solid #cbd5e1; text-align: left; padding: 6px 10px;">GRAND TOTAL</td>
                                <td style="border: 1px solid #cbd5e1; padding: 6px;">{{ $data['soi_performance_data']->sum('trg_inq') }}</td>
                                <td style="border: 1px solid #cbd5e1; padding: 6px;">{{ $data['soi_performance_data']->sum('act_inq') }}</td>
                                <td style="border: 1px solid #cbd5e1; padding: 6px;">{{ $data['soi_performance_data']->sum('trg_do') }}</td>
                                <td style="border: 1px solid #cbd5e1; padding: 6px;">{{ $data['soi_performance_data']->sum('act_do') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- 3. TABLE SALES FORCE PERFORMANCE (DIKOMEN/DIHAPUS SESUAI PERMINTAAN USER) --}}
                {{-- 
                <div style="background: white; border-radius: 8px; padding: 15px; overflow-x: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.3); height: fit-content; align-self: flex-start;">
                    <h4 style="color: #dc2626; margin-bottom: 10px; font-weight: bold;">👥 SALES FORCE PERFORMANCE ({{ strtoupper($bulan) }})</h4>
                    <table style="width:100%; border-collapse: collapse; color: black; font-size: 10px; text-align: center;">
                        <thead style="background: #fee2e2; color: #991b1b;">
                            <tr>
                                <th rowspan="2" style="border: 1px solid #cbd5e1; padding: 5px;">GRADING</th>
                                <th colspan="3" style="border: 1px solid #cbd5e1;">Bulan Berjalan (N)</th>
                                <th colspan="3" style="border: 1px solid #cbd5e1;">KAPASITAS JUAL</th>
                            </tr>
                            <tr>
                                <th style="border: 1px solid #cbd5e1;">TRG SF</th>
                                <th style="border: 1px solid #cbd5e1;">ACT SF</th>
                                <th style="border: 1px solid #cbd5e1;">ACT DO</th>
                                <th style="border: 1px solid #cbd5e1;">TRG</th>
                                <th style="border: 1px solid #cbd5e1;">ACT</th>
                                <th style="border: 1px solid #cbd5e1;">GAP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['salesforce'] as $item)
                                <tr>
                                    <td style="border: 1px solid #cbd5e1; text-align: left; background: #ffff00; font-weight: bold; padding: 4px;">{{ $item->grading }}</td>
                                    <td style="border: 1px solid #cbd5e1;">{{ $item->trg_sf ?? 0 }}</td>
                                    <td style="border: 1px solid #cbd5e1;">{{ $item->act_sf }}</td>
                                    <td style="border: 1px solid #cbd5e1;">{{ $item->act_do }}</td>
                                    <td style="border: 1px solid #cbd5e1;">0</td>
                                    <td style="border: 1px solid #cbd5e1;">0</td>
                                    <td style="border: 1px solid #cbd5e1;">0</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="background: #00b0f0; font-weight: bold;">
                            <tr>
                                <td style="border: 1px solid #cbd5e1; text-align: left; padding: 4px;">GRAND TOTAL</td>
                                <td style="border: 1px solid #cbd5e1;">{{ $data['salesforce']->sum('trg_sf') }}</td>
                                <td style="border: 1px solid #cbd5e1;">{{ $data['salesforce']->sum('act_sf') }}</td>
                                <td style="border: 1px solid #cbd5e1;">{{ $data['salesforce']->sum('act_do') }}</td>
                                <td style="border: 1px solid #cbd5e1;">0</td>
                                <td style="border: 1px solid #cbd5e1;">0</td>
                                <td style="border: 1px solid #cbd5e1;">0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                --}}

                {{-- 4. TABLE PERFORMANCE LEASING (DIKOMEN/DIHAPUS SESUAI PERMINTAAN USER) --}}
                {{-- 
                <div style="background: white; border-radius: 8px; padding: 15px; margin-top: 25px; overflow-x: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.3); grid-column: span 2;">
                    <h4 style="color: #dc2626; margin-bottom: 10px; font-weight: bold;">💳 PERFORMANCE LEASING ({{ strtoupper($bulan) }})</h4>
                    <table style="width:100%; border-collapse: collapse; color: black; font-size: 10px; text-align: center;">
                        <thead style="background: #fee2e2; color: #991b1b;">
                            <tr>
                                <th rowspan="2" style="border: 1px solid #cbd5e1; padding: 8px;">LEASING</th>
                                <th colspan="3" style="border: 1px solid #cbd5e1;">Bulan Berjalan ({{ strtoupper($bulan) }})</th>
                                <th colspan="3" style="border: 1px solid #cbd5e1;">Year To Date (YTD)</th>
                                <th rowspan="2" style="border: 1px solid #cbd5e1;">Credit Share</th>
                            </tr>
                            <tr>
                                <th style="border: 1px solid #cbd5e1;">PO</th>
                                <th style="border: 1px solid #cbd5e1;">REJECT</th>
                                <th style="border: 1px solid #cbd5e1;">APL IN</th>
                                <th style="border: 1px solid #cbd5e1;">PO</th>
                                <th style="border: 1px solid #cbd5e1;">REJECT</th>
                                <th style="border: 1px solid #cbd5e1;">APL IN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalYtdAll = $data['leasing_performance']->sum('ytd_po'); @endphp
                            @foreach ($data['leasing_performance'] as $l)
                                <tr>
                                    <td style="border: 1px solid #cbd5e1; text-align: left; background: #ffff00; font-weight: bold; padding: 4px;">{{ $l->nama }}</td>
                                    <td style="border: 1px solid #cbd5e1;">{{ $l->po }}</td>
                                    <td style="border: 1px solid #cbd5e1;">{{ $l->reject }}</td>
                                    <td style="border: 1px solid #cbd5e1;">{{ $l->aplin }}</td>
                                    <td style="border: 1px solid #cbd5e1; background: #f0f0f0;">{{ $l->ytd_po }}</td>
                                    <td style="border: 1px solid #cbd5e1; background: #f0f0f0;">{{ $l->ytd_reject }}</td>
                                    <td style="border: 1px solid #cbd5e1; background: #f0f0f0;">{{ $l->ytd_aplin }}</td>
                                    <td style="border: 1px solid #cbd5e1; font-weight: bold;">
                                        {{ $totalYtdAll > 0 ? round(($l->ytd_po / $totalYtdAll) * 100, 1) : 0 }}%
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="background: #00b0f0; font-weight: bold;">
                            <tr>
                                <td style="border: 1px solid #cbd5e1; text-align: left; padding: 4px;">GRAND TOTAL</td>
                                <td style="border: 1px solid #cbd5e1;">{{ $data['leasing_performance']->sum('po') }}</td>
                                <td style="border: 1px solid #cbd5e1;">{{ $data['leasing_performance']->sum('reject') }}</td>
                                <td style="border: 1px solid #cbd5e1;">{{ $data['leasing_performance']->sum('aplin') }}</td>
                                <td style="border: 1px solid #cbd5e1;">{{ $data['leasing_performance']->sum('ytd_po') }}</td>
                                <td style="border: 1px solid #cbd5e1;">{{ $data['leasing_performance']->sum('ytd_reject') }}</td>
                                <td style="border: 1px solid #cbd5e1;">{{ $data['leasing_performance']->sum('ytd_aplin') }}</td>
                                <td style="border: 1px solid #cbd5e1;">100%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                --}}
            </div>

        @endforeach 

    </div>
@endsection