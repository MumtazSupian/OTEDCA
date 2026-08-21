@extends('layouts.app')

@section('title', 'Dashboard Leads')

@section('content')
<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<div style="width: 100%; box-sizing: border-box; overflow-x: hidden; padding: 20px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background: #ecf0f5; min-height: 100vh;">
    
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; font-size: 24px; color: #333; font-weight: normal;">Dashboard <small style="font-size: 15px; color: #777;">control panel</small></h2>
        <div style="font-size: 12px; color: #777;">
            <i class="fas fa-home"></i> > Dashboard
        </div>
    </div>

    <!-- Filter Data -->
    <div style="margin-bottom: 20px; font-family: 'Inter', sans-serif;">
        <div style="font-weight: 700; color: #1e3a5f; margin-bottom: 10px; font-size: 14px;">Filter Data :</div>
        <form method="GET" action="{{ route('sales.leads.dashboard') }}" style="display: flex; gap: 10px; align-items: center; margin-bottom: 20px; font-size: 13px;">
            <label>Bulan</label>
            <select name="bulan" style="padding: 5px; border: 1px solid #ccc; border-radius: 3px;">
                <option value="semua" {{ $bulan == 'semua' ? 'selected' : '' }}>-- Semua Bulan --</option>
                @for($i=1; $i<=12; $i++)
                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $bulan == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                @endfor
            </select>
            <label>Tahun</label>
            <select name="tahun" style="padding: 5px; border: 1px solid #ccc; border-radius: 3px;">
                <option value="semua" {{ $tahun == 'semua' ? 'selected' : '' }}>-- Semua Tahun --</option>
                @for($y=date('Y')-2; $y<=date('Y'); $y++)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <input type="hidden" name="periode_tren" value="{{ request('periode_tren', 'tahun_ini') }}">
            <button type="submit" style="background: #3c8dbc; color: white; border: none; padding: 5px 15px; border-radius: 3px; cursor: pointer;"><i class="fas fa-filter"></i> Terapkan</button>
            <a href="{{ route('sales.leads.dashboard') }}" style="background: #f4f4f4; color: #444; border: 1px solid #ddd; padding: 5px 15px; border-radius: 3px; cursor: pointer; text-decoration: none;">Reset</a>
        </form>
    </div>

    <!-- 4 Cards -->
    <div style="display: flex; gap: 20px; margin-bottom: 20px;">
        @php
            $cabangs = [
                ['name' => 'CIAWI', 'total' => $totalCiawi],
                ['name' => 'CIANJUR', 'total' => $totalCianjur],
                ['name' => 'CINERE', 'total' => $totalCinere],
                ['name' => 'JATIASIH', 'total' => $totalJatiasih],
                ['name' => 'CIPANAS', 'total' => $totalCipanas]
            ];
        @endphp

        @foreach($cabangs as $c)
        <div style="flex: 1; background: #fff; display: flex; border-radius: 2px; box-shadow: 0 1px 1px rgba(0,0,0,0.1);">
            <div style="background: #dd4b39; color: #fff; width: 80px; display: flex; justify-content: center; align-items: center; font-size: 35px; border-radius: 2px 0 0 2px;">
                <i class="fab fa-whatsapp"></i>
            </div>
            <div style="padding: 10px 15px; flex: 1;">
                <span style="display: block; font-size: 12px; color: #777; text-transform: uppercase;">{{ $c['name'] }}</span>
                <span style="display: block; font-size: 20px; font-weight: bold; color: #333; margin-top: 5px;">{{ $c['total'] }}</span>
            </div>
        </div>
        @endforeach
    </div>

    <div style="background: #fff; padding: 20px; border-top: 3px solid #d2d6de; box-shadow: 0 1px 1px rgba(0,0,0,0.1); margin-bottom: 20px;">
        <!-- Monthly Leads Header -->
        <h3 style="margin-top: 0; font-size: 14px; font-weight: normal; border-bottom: 1px solid #f4f4f4; padding-bottom: 10px;">Monthly Leads</h3>
        
        <div style="text-align: center; margin: 20px 0;">
            <div style="font-weight: bold; color: #333; font-size: 14px;">Total Leads</div>
            <div style="font-weight: bold; color: #333; font-size: 16px; margin-bottom: 10px;">{{ $totalLeads }}</div>
            <div style="font-weight: bold; color: #333; font-size: 14px;">No Report {{ $noReportCount }}</div>
        </div>

        <!-- Budget Pemakaian -->
        <h4 style="font-size: 13px; font-weight: bold; margin-bottom: 10px;">Budget Pemakaian :</h4>
        <table style="width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 30px;">
            <thead>
                <tr style="border-bottom: 2px solid #f4f4f4;">
                    <th style="padding: 10px; text-align: left; width: 5%;">#</th>
                    <th style="padding: 10px; text-align: left;">Sumber</th>
                    <th style="padding: 10px; text-align: left;">Budget</th>
                </tr>
            </thead>
            <tbody>
                @php $totalBudget = 0; @endphp
                @foreach($budgets as $index => $b)
                <tr style="border-bottom: 1px solid #f4f4f4; background-color: {{ $index % 2 == 0 ? '#f9f9f9' : '#fff' }};">
                    <td style="padding: 8px 10px;">{{ $index + 1 }}</td>
                    <td style="padding: 8px 10px; text-transform: uppercase;">{{ $b->sumber->nama_sumber ?? 'UNKNOWN' }}</td>
                    <td style="padding: 8px 10px;">{{ number_format($b->budget, 0, ',', '.') }}</td>
                </tr>
                @php $totalBudget += $b->budget; @endphp
                @endforeach
                <tr style="border-bottom: 1px solid #f4f4f4; background-color: #fff; font-weight: bold;">
                    <td colspan="2" style="padding: 10px;">TOTAL</td>
                    <td style="padding: 10px;">{{ number_format($totalBudget, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Result Leads -->
        <h4 style="font-size: 13px; font-weight: bold; margin-bottom: 10px;">Result Leads :</h4>
        <table style="width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 30px;">
            <thead>
                <tr style="border-bottom: 2px solid #f4f4f4;">
                    <th style="padding: 10px; text-align: left;">Sumber</th>
                    <th style="padding: 10px; text-align: left;">Keterangan</th>
                    <th style="padding: 10px; text-align: center;">Leads</th>
                    <th style="padding: 10px; text-align: center;">No Report</th>
                    <th style="padding: 10px; text-align: center;">Prospect</th>
                    <th style="padding: 10px; text-align: center;">SPK</th>
                    <th style="padding: 10px; text-align: center;">DO</th>
                    <th style="padding: 10px; text-align: center;">LOST</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $tL = 0; $tNR = 0; $tP = 0; $tS = 0; $tD = 0; $tLo = 0;
                @endphp
                @foreach($resultLeads as $index => $rl)
                <tr style="border-bottom: 1px solid #f4f4f4; background-color: {{ $index % 2 == 0 ? '#f9f9f9' : '#fff' }};">
                    <td style="padding: 8px 10px;">{{ $rl['sumber'] }}</td>
                    <td style="padding: 8px 10px;">{{ $rl['keterangan'] }}</td>
                    <td style="padding: 8px 10px; text-align: center;">{{ $rl['leads'] }}</td>
                    <td style="padding: 8px 10px; text-align: center;">{{ $rl['no_report'] }}</td>
                    <td style="padding: 8px 10px; text-align: center;">{{ $rl['prospect'] }}</td>
                    <td style="padding: 8px 10px; text-align: center;">{{ $rl['spk'] }}</td>
                    <td style="padding: 8px 10px; text-align: center;">{{ $rl['do'] }}</td>
                    <td style="padding: 8px 10px; text-align: center;">{{ $rl['lost'] }}</td>
                </tr>
                @php
                    $tL += $rl['leads']; $tNR += $rl['no_report']; $tP += $rl['prospect'];
                    $tS += $rl['spk']; $tD += $rl['do']; $tLo += $rl['lost'];
                @endphp
                @endforeach
                <tr style="border-bottom: 1px solid #f4f4f4; background-color: #fff; font-weight: bold;">
                    <td colspan="2" style="padding: 10px; text-align: center;">TOTAL</td>
                    <td style="padding: 10px; text-align: center;">{{ $tL }}</td>
                    <td style="padding: 10px; text-align: center;">{{ $tNR }}</td>
                    <td style="padding: 10px; text-align: center;">{{ $tP }}</td>
                    <td style="padding: 10px; text-align: center; color: red;">{{ $tS }}</td>
                    <td style="padding: 10px; text-align: center; color: blue;">{{ $tD }}</td>
                    <td style="padding: 10px; text-align: center;">{{ $tLo }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Result SPK & DO -->
        <h4 style="font-size: 13px; font-weight: bold; margin-bottom: 10px;">Result SPK & DO :</h4>
        <div style="overflow-x: auto; margin-bottom: 30px;">
            <table style="width: 100%; border-collapse: collapse; font-size: 12px; white-space: nowrap;">
                <thead>
                    <tr style="border-bottom: 2px solid #f4f4f4;">
                        <th style="padding: 10px; text-align: left;">#</th>
                        <th style="padding: 10px; text-align: left;">Nama</th>
                        <th style="padding: 10px; text-align: left;">No.HP</th>
                        <th style="padding: 10px; text-align: left;">Tanggal</th>
                        <th style="padding: 10px; text-align: left;">Sumber</th>
                        <th style="padding: 10px; text-align: left;">Unit</th>
                        <th style="padding: 10px; text-align: left;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($spkDoLeads as $index => $sd)
                    <tr style="border-bottom: 1px solid #f4f4f4; background-color: {{ $index % 2 == 0 ? '#f9f9f9' : '#fff' }};">
                        <td style="padding: 8px 10px;">{{ $index + 1 }}</td>
                        <td style="padding: 8px 10px;">{{ $sd->nama }}</td>
                        <td style="padding: 8px 10px;">{{ $sd->no_hp }}</td>
                        <td style="padding: 8px 10px;">{{ date('d/m/Y', strtotime($sd->tanggal)) }}</td>
                        <td style="padding: 8px 10px; text-transform: uppercase;">{{ $sd->sumber->nama_sumber ?? '' }}</td>
                        <td style="padding: 8px 10px; text-transform: uppercase;">{{ $sd->unit->nama_unit ?? '' }}</td>
                        <td style="padding: 8px 10px; text-transform: uppercase;">{{ $sd->status->nama_status ?? '' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding: 15px; text-align: center; color: #777;">Belum ada SPK/DO.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tabel Konversi -->
        <h4 style="font-size: 13px; font-weight: normal; margin-bottom: 10px;">Tabel Konversi Leads ke SPK & DO</h4>
        <div style="text-align: center; font-weight: bold; font-size: 12px; margin-bottom: 10px;">Periode: {{ isset($periodeTren) ? ($periodeTren == 'tahun_ini' ? 'TAHUN INI' : ($periodeTren == 'tahun_lalu' ? 'TAHUN LALU' : 'CUSTOM')) : 'SEMUA DATA' }}</div>
        <table style="width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 30px;">
            <thead>
                <tr style="border-bottom: 2px solid #f4f4f4;">
                    <th style="padding: 10px; text-align: left;">Status</th>
                    <th style="padding: 10px; text-align: left;">Jumlah</th>
                    <th style="padding: 10px; text-align: left;">Konversi dari Leads (%)</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom: 1px solid #f4f4f4; background-color: #f9f9f9; font-weight: bold;">
                    <td style="padding: 8px 10px;">Total Leads</td>
                    <td style="padding: 8px 10px;">{{ $totalLeads }}</td>
                    <td style="padding: 8px 10px;">-</td>
                </tr>
                <tr style="border-bottom: 1px solid #f4f4f4;">
                    <td style="padding: 8px 10px;">SPK</td>
                    <td style="padding: 8px 10px;">{{ $tS }}</td>
                    <td style="padding: 8px 10px;">{{ $totalLeads > 0 ? number_format(($tS / $totalLeads) * 100, 2) : 0 }}%</td>
                </tr>
                <tr style="border-bottom: 1px solid #f4f4f4; background-color: #f9f9f9;">
                    <td style="padding: 8px 10px;">DO</td>
                    <td style="padding: 8px 10px;">{{ $tD }}</td>
                    <td style="padding: 8px 10px;">{{ $totalLeads > 0 ? number_format(($tD / $totalLeads) * 100, 2) : 0 }}%</td>
                </tr>
            </tbody>
        </table>

        <!-- Charts Row 1 -->
        <div style="display: flex; gap: 20px; margin-bottom: 30px;">
            <!-- Status Chart -->
            <div style="flex: 1; background: #fff; border: 1px solid #eee;">
                <div style="text-align: center; padding: 10px; border-bottom: 1px solid #eee;">
                    <div style="font-size: 12px; font-weight: bold;">Leads Status</div>
                    <div style="font-size: 11px; font-weight: bold; text-transform: uppercase;">Semua Periode</div>
                </div>
                <div style="padding: 15px;">
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>
            <!-- Source Chart -->
            <div style="flex: 1; background: #fff; border: 1px solid #eee;">
                <div style="text-align: center; padding: 10px; border-bottom: 1px solid #eee;">
                    <div style="font-size: 12px; font-weight: bold;">Leads Source</div>
                    <div style="font-size: 11px; font-weight: bold; text-transform: uppercase;">Semua Periode</div>
                </div>
                <div style="padding: 15px; display: flex; justify-content: center;">
                    <div style="width: 70%;">
                        <canvas id="sourceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div style="margin-bottom: 30px; border: 1px solid #eee; padding: 20px; background: #fff;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">
                <div style="font-size: 14px;">Monthly Leads <br><small style="color:#777;">Count Of unit</small></div>
                <div style="cursor: pointer;"><i class="fas fa-minus"></i> &nbsp; <i class="fas fa-times"></i></div>
            </div>
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="font-size: 12px; font-weight: bold;">SEMUA PERIODE</div>
                <div style="font-size: 11px;">Perbandingan Jumlah Unit per Model</div>
            </div>
            <canvas id="unitChart" height="100"></canvas>
        </div>

        <!-- Trend Filters -->
        <div style="background: #f4f4f4; padding: 10px; border: 1px solid #ddd; margin-bottom: 20px;">
            <div style="font-weight: 700; color: #1e3a5f; margin-bottom: 8px; font-size: 14px;">Filter Data Grafik Tren:</div>
            <form method="GET" action="{{ route('sales.leads.dashboard') }}" style="margin: 0;">
                <input type="hidden" name="bulan" value="{{ $bulan }}">
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                <div style="margin-top: 5px; display: flex; align-items: center; gap: 10px;">
                    <select name="periode_tren" id="periode_tren_global" onchange="toggleCustomDate(this, 'global')" style="padding: 6px 12px; border: 1px solid #3c8dbc; border-radius: 4px; background-color: white; color: #555; font-size: 13px; cursor: pointer; min-width: 180px;">
                        <option value="tahun_ini" {{ request('periode_tren', 'tahun_ini') == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                        <option value="tahun_lalu" {{ request('periode_tren') == 'tahun_lalu' ? 'selected' : '' }}>Tahun Lalu</option>
                        <option value="custom" {{ request('periode_tren') == 'custom' ? 'selected' : '' }}>Custom Period</option>
                    </select>
                    
                    <div id="custom_date_wrapper_global" style="display: {{ request('periode_tren') == 'custom' ? 'flex' : 'none' }}; align-items: center; gap: 10px;">
                        <input type="text" name="custom_date" id="custom_date_global" class="daterange-picker" value="{{ request('custom_date') }}" style="padding: 6px 12px; border: 1px solid #3c8dbc; border-radius: 4px; width: 220px;" placeholder="DD/MM/YYYY - DD/MM/YYYY" {{ request('periode_tren') == 'custom' ? 'required' : '' }} disabled>
                        <button type="submit" style="background: #3c8dbc; color: white; border: none; padding: 6px 15px; border-radius: 4px; cursor: pointer;">Terapkan</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Charts Row 3 -->
        <div style="margin-bottom: 20px; border: 1px solid #eee; background: #fff;">
            <div style="font-size: 13px; font-weight: normal; padding: 10px 15px; border-bottom: 1px solid #eee;">Grafik Tren Leads</div>
            <div style="padding: 15px;">
                <canvas id="trendLeadsChart" height="70"></canvas>
            </div>
        </div>

        <!-- Charts Row 4 -->
        <div style="margin-bottom: 30px; border: 1px solid #eee; background: #fff;">
            <div style="font-size: 13px; font-weight: normal; padding: 10px 15px; border-bottom: 1px solid #eee;">Grafik Tren Sumber Leads</div>
            <div style="padding: 15px;">
                <canvas id="trendSumberChart" height="80"></canvas>
            </div>
        </div>

        <!-- Tabel Summary Leads per Sumber -->
        <h4 style="font-size: 13px; font-weight: normal; margin-bottom: 10px;">Tabel Summary Leads per Sumber</h4>
        <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
            <thead>
                <tr style="border-bottom: 2px solid #f4f4f4;">
                    <th style="padding: 10px; text-align: left; width: 5%;">#</th>
                    <th style="padding: 10px; text-align: left;">Sumber Leads</th>
                    <th style="padding: 10px; text-align: left;">Total Leads</th>
                    <th style="padding: 10px; text-align: right;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($chartSourceLabels as $index => $source)
                <tr style="border-bottom: 1px solid #f4f4f4; background-color: {{ $index % 2 == 0 ? '#f9f9f9' : '#fff' }};">
                    <td style="padding: 8px 10px;">{{ $index + 1 }}</td>
                    <td style="padding: 8px 10px; text-transform: uppercase;">{{ $source }}</td>
                    <td style="padding: 8px 10px;">{{ $chartSourceData[$index] }}</td>
                    <td style="padding: 8px 10px; text-align: right;">
                        @php
                            $sumSource = array_sum($chartSourceData);
                            $percentage = $sumSource > 0 ? ($chartSourceData[$index] / $sumSource) * 100 : 0;
                        @endphp
                        <span style="color: {{ $percentage > 0 ? '#00a65a' : '#777' }}; font-weight: bold;">
                            {{ number_format($percentage, 2, ',', '.') }}%
                        </span>
                    </td>
                </tr>
                @endforeach
                <tr style="border-bottom: 1px solid #f4f4f4; background-color: #fff; font-weight: bold;">
                    <td colspan="2" style="padding: 10px;">TOTAL</td>
                    <td style="padding: 10px;">{{ array_sum($chartSourceData) }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

    </div>

    <hr style="margin: 40px 0; border: 1px solid #d2d6de;">

    @foreach($branches as $branch)
        @php
            $bData = $branchData[$branch];
        @endphp

        <div style="margin-top: 40px; margin-bottom: 40px; padding-top: 20px;">
            <!-- Header Branch -->
            <div style="background: #fff; padding: 15px; border-bottom: 2px solid #eee; margin-bottom: 20px;">
                <h3 style="margin: 0; font-size: 18px; color: #3c8dbc; text-transform: capitalize;">{{ $branch }} Monthly Leads</h3>
                
                <div style="text-align: center; margin-top: 15px;">
                    <div style="font-weight: bold; font-size: 14px; color: #333;">Total Leads</div>
                    <div style="font-weight: bold; font-size: 20px; color: #333;">{{ $bData['totalLeads'] }}</div>
                    <div style="font-weight: bold; font-size: 13px; color: #777;">No Report {{ $bData['noReportCount'] }}</div>
                </div>
            </div>

            <!-- Charts Row 1: Status & Source -->
            <div style="display: flex; flex-wrap: wrap; margin-left: -10px; margin-right: -10px; margin-bottom: 20px; align-items: stretch;">
                <!-- Status Chart -->
                <div style="width: 50%; padding: 0 10px; box-sizing: border-box;">
                    <div style="background: #fff; border: 1px solid #eee; height: 100%; display: flex; flex-direction: column;">
                        <div style="text-align: center; padding: 10px; border-bottom: 1px solid #eee;">
                            <div style="font-size: 12px; font-weight: bold;">Leads Status</div>
                            <div style="font-size: 11px; font-weight: bold; text-transform: uppercase;">Semua Periode</div>
                        </div>
                        <div style="padding: 15px; flex: 1;">
                            <canvas id="statusChart_{{ $branch }}" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Source Chart -->
                <div style="width: 50%; padding: 0 10px; box-sizing: border-box;">
                    <div style="background: #fff; border: 1px solid #eee; height: 100%; display: flex; flex-direction: column;">
                        <div style="text-align: center; padding: 10px; border-bottom: 1px solid #eee;">
                            <div style="font-size: 12px; font-weight: bold;">Leads Source</div>
                            <div style="font-size: 11px; font-weight: bold; text-transform: uppercase;">Semua Periode</div>
                        </div>
                        <div style="padding: 15px; flex: 1; display: flex; justify-content: center; align-items: center;">
                            <div style="width: 70%;">
                                <canvas id="sourceChart_{{ $branch }}"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 2: Unit -->
            <div style="background: #fff; border: 1px solid #eee; margin-bottom: 20px;">
                <div style="padding: 10px 15px; border-bottom: 1px solid #eee;">
                    <div style="font-size: 13px; font-weight: normal; text-transform: capitalize;">{{ $branch }} Monthly</div>
                    <div style="font-size: 11px; color: #777;">Count Of Unit</div>
                </div>
                <div style="font-size: 11px; font-weight: bold; text-align: center; padding-top: 10px; text-transform: uppercase;">Semua Periode</div>
                <div style="padding: 15px;">
                    <canvas id="unitChart_{{ $branch }}" height="80"></canvas>
                </div>
            </div>

            <!-- Trend Section Title -->
            <div style="text-align: center; margin-top: 40px; margin-bottom: 20px;">
                <h3 style="margin: 0; font-size: 20px; font-weight: normal; color: #444;">Analisis Tren Cabang {{ ucfirst($branch) }}</h3>
            </div>

            <!-- Trend Filter Form -->
            <div style="background: #f4f4f4; padding: 10px; border: 1px solid #ddd; margin-bottom: 20px;">
                <div style="font-weight: 700; color: #1e3a5f; margin-bottom: 8px; font-size: 14px;">Filter Data Grafik Tren ({{ ucfirst($branch) }}):</div>
                <form method="GET" action="{{ route('sales.leads.dashboard') }}#branch_{{ $branch }}" style="margin: 0;">
                    <input type="hidden" name="bulan" value="{{ $bulan }}">
                    <input type="hidden" name="tahun" value="{{ $tahun }}">
                    <div style="margin-top: 5px; display: flex; align-items: center; gap: 10px;">
                        <select name="periode_tren" id="periode_tren_{{ $branch }}" onchange="toggleCustomDate(this, '{{ $branch }}')" style="padding: 6px 12px; border: 1px solid #3c8dbc; border-radius: 4px; background-color: white; color: #555; font-size: 13px; cursor: pointer; min-width: 180px;">
                            <option value="tahun_ini" {{ request('periode_tren', 'tahun_ini') == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                            <option value="tahun_lalu" {{ request('periode_tren') == 'tahun_lalu' ? 'selected' : '' }}>Tahun Lalu</option>
                            <option value="custom" {{ request('periode_tren') == 'custom' ? 'selected' : '' }}>Custom Period</option>
                        </select>
                        
                        <div id="custom_date_wrapper_{{ $branch }}" style="display: {{ request('periode_tren') == 'custom' ? 'flex' : 'none' }}; align-items: center; gap: 10px;">
                            <input type="text" name="custom_date" id="custom_date_{{ $branch }}" class="daterange-picker" value="{{ request('custom_date') }}" style="padding: 6px 12px; border: 1px solid #3c8dbc; border-radius: 4px; width: 220px;" placeholder="DD/MM/YYYY - DD/MM/YYYY" {{ request('periode_tren') == 'custom' ? 'required' : '' }} disabled>
                            <button type="submit" style="background: #3c8dbc; color: white; border: none; padding: 6px 15px; border-radius: 4px; cursor: pointer;">Terapkan</button>
                        </div>
                    </div>
                </form>
            </div>
            <a name="branch_{{ $branch }}"></a>

            <!-- Charts Row 3: Trend Leads -->
            <div style="margin-bottom: 20px; border: 1px solid #eee; background: #fff;">
                <div style="font-size: 13px; font-weight: normal; padding: 10px 15px; border-bottom: 1px solid #eee;">Grafik Tren Total Leads ({{ ucfirst($branch) }})</div>
                <div style="padding: 15px;">
                    <canvas id="trendLeadsChart_{{ $branch }}" height="70"></canvas>
                </div>
            </div>

            <!-- Charts Row 4: Trend Sumber Leads -->
            <div style="margin-bottom: 30px; border: 1px solid #eee; background: #fff;">
                <div style="font-size: 13px; font-weight: normal; padding: 10px 15px; border-bottom: 1px solid #eee;">Grafik Tren Sumber Leads ({{ ucfirst($branch) }})</div>
                <div style="padding: 15px;">
                    <canvas id="trendSumberChart_{{ $branch }}" height="80"></canvas>
                </div>
            </div>

            <!-- Tabel Summary Leads per Sumber -->
            <div style="background: #fff; border: 1px solid #eee; margin-bottom: 20px;">
                <div style="font-size: 13px; font-weight: normal; padding: 10px 15px; border-bottom: 1px solid #eee;">Tabel Summary Leads per Sumber ({{ ucfirst($branch) }})</div>
                <div style="padding: 15px; overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                        <thead>
                            <tr style="border-bottom: 2px solid #f4f4f4;">
                                <th style="padding: 10px; text-align: left; width: 5%;">#</th>
                                <th style="padding: 10px; text-align: left;">Sumber Leads</th>
                                <th style="padding: 10px; text-align: left;">Total Leads</th>
                                <th style="padding: 10px; text-align: left;">Perubahan (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($chartSourceLabels as $index => $source)
                            <tr style="border-bottom: 1px solid #f4f4f4; background-color: {{ $index % 2 == 0 ? '#f9f9f9' : '#fff' }};">
                                <td style="padding: 8px 10px;">{{ $index + 1 }}</td>
                                <td style="padding: 8px 10px; text-transform: uppercase;">{{ $source }}</td>
                                <td style="padding: 8px 10px;">{{ $bData['chartSourceData'][$index] }}</td>
                                <td style="padding: 8px 10px;">
                                    @php
                                        $bSumSource = array_sum($bData['chartSourceData']);
                                        $bPercentage = $bSumSource > 0 ? ($bData['chartSourceData'][$index] / $bSumSource) * 100 : 0;
                                    @endphp
                                    <span style="color: {{ $bPercentage > 0 ? '#00a65a' : '#777' }}; font-weight: bold;">
                                        {{ number_format($bPercentage, 2, ',', '.') }}%
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                            <tr style="border-bottom: 1px solid #f4f4f4; background-color: #fff; font-weight: bold;">
                                <td colspan="2" style="padding: 10px;">TOTAL</td>
                                <td style="padding: 10px;">{{ array_sum($bData['chartSourceData']) }}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Konversi Leads ke SPK & DO -->
            <div style="background: #fff; border: 1px solid #eee; margin-bottom: 40px;">
                <div style="font-size: 13px; font-weight: normal; padding: 10px 15px; border-bottom: 1px solid #eee;">Result SPK & DO Cabang {{ ucfirst($branch) }} <div style="float:right;">Periode: SEMUA DATA</div></div>
                <div style="padding: 15px; overflow-x: auto;">
                    <div style="text-align: center; font-size: 14px; margin-bottom: 15px;">Tabel Konversi Leads ke SPK & DO ({{ ucfirst($branch) }}) <br> <span style="font-size: 12px; font-weight:bold;">Periode: SEMUA DATA</span></div>
                    <table style="width: 100%; border-collapse: collapse; font-size: 12px; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid #f4f4f4;">
                                <th style="padding: 10px; font-weight: bold; width: 40%;">Status</th>
                                <th style="padding: 10px; font-weight: bold; width: 30%;">Jumlah</th>
                                <th style="padding: 10px; font-weight: bold;">Konversi dari Leads (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-bottom: 1px solid #eee; background-color: #f9f9f9;">
                                <td style="padding: 10px; font-weight: bold;">Total Leads</td>
                                <td style="padding: 10px;">{{ $bData['totalLeads'] }}</td>
                                <td style="padding: 10px;">-</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 10px;">SPK</td>
                                @php
                                    $spkCount = $bData['chartStatusData'][2]; // Index 2 is SPK
                                    $spkConv = $bData['totalLeads'] > 0 ? number_format(($spkCount / $bData['totalLeads']) * 100, 2) : 0;
                                @endphp
                                <td style="padding: 10px;">{{ $spkCount }}</td>
                                <td style="padding: 10px;">{{ $spkConv }}%</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #eee; background-color: #f9f9f9;">
                                <td style="padding: 10px;">DO</td>
                                @php
                                    $doCount = $bData['chartStatusData'][3]; // Index 3 is DO
                                    $doConv = $bData['totalLeads'] > 0 ? number_format(($doCount / $bData['totalLeads']) * 100, 2) : 0;
                                @endphp
                                <td style="padding: 10px;">{{ $doCount }}</td>
                                <td style="padding: 10px;">{{ $doConv }}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    @endforeach
</div>

<script>
$(function() {
    $('.daterange-picker').daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY',
            cancelLabel: 'Batal',
            applyLabel: 'Terapkan',
            daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
            monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        }
    });

    $('.daterange-picker').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });

    $('.daterange-picker').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
    
    // Enable input if custom is already selected
    $('.daterange-picker').each(function() {
        if ($(this).closest('div').parent().find('select[name="periode_tren"]').val() === 'custom' || $(this).is(':visible')) {
            $(this).prop('disabled', false);
        }
    });
});

function toggleCustomDate(select, idSuffix) {
    if (select.value === 'custom') {
        document.getElementById('custom_date_wrapper_' + idSuffix).style.display = 'flex';
        document.getElementById('custom_date_' + idSuffix).disabled = false;
        document.getElementById('custom_date_' + idSuffix).required = true;
    } else {
        document.getElementById('custom_date_wrapper_' + idSuffix).style.display = 'none';
        document.getElementById('custom_date_' + idSuffix).disabled = true;
        document.getElementById('custom_date_' + idSuffix).required = false;
        select.form.submit();
    }
}
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Colors
    const statusColors = ['#999999', '#00c0ef', '#f39c12', '#00a65a', '#f56954'];
    const sourceColors = ['#4285F4', '#34A853', '#FBBC05', '#EA4335', '#8E24AA'];
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    // ============================================
    // GLOBAL CHARTS
    // ============================================
    // Status Chart (Bar)
    new Chart(document.getElementById('statusChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartStatusLabels) !!},
            datasets: [{
                label: 'Jumlah Leads',
                data: {!! json_encode($chartStatusData) !!},
                backgroundColor: statusColors,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { 
                x: { grid: { display: false } },
                y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#eee' } } 
            }
        }
    });

    // Source Chart (Donut)
    new Chart(document.getElementById('sourceChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($chartSourceLabels) !!},
            datasets: [{
                data: {!! json_encode($chartSourceData) !!},
                backgroundColor: sourceColors,
                borderWidth: 1,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: { 
                legend: { position: 'top', labels: { boxWidth: 20, font: { size: 11 } } } 
            },
            cutout: '55%',
            scales: {
                x: { grid: { display: false }, ticks: { display: false } },
                y: { beginAtZero: true, grid: { color: '#eee' }, ticks: { display: false } }
            }
        }
    });

    // Unit Chart (Line)
    new Chart(document.getElementById('unitChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($chartUnitLabels) !!},
            datasets: [{
                label: '# Unit',
                data: {!! json_encode($chartUnitData) !!},
                borderColor: '#555',
                borderWidth: 1.5,
                pointRadius: 3,
                pointBackgroundColor: ['#8E24AA', '#00c0ef', '#00a65a', '#f39c12', '#3c8dbc', '#8E24AA', '#00a65a', '#f39c12', '#00a65a', '#f39c12'],
                pointBorderColor: 'transparent',
                fill: false,
                tension: 0
            }]
        },
        options: {
            responsive: true,
            plugins: { 
                legend: { 
                    position: 'top', 
                    labels: { 
                        boxWidth: 25, 
                        font: { size: 11 },
                        generateLabels: function(chart) {
                            return [{
                                text: '# Unit',
                                fillStyle: '#eee',
                                strokeStyle: '#555',
                                lineWidth: 1
                            }];
                        }
                    } 
                } 
            },
            scales: { 
                x: { grid: { color: '#eee' } },
                y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#eee' } } 
            }
        }
    });

    // Trend Leads Chart (Area)

    new Chart(document.getElementById('trendLeadsChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Total Leads per Bulan',
                data: {!! json_encode($monthlyTrend) !!},
                borderColor: '#4285F4',
                backgroundColor: 'rgba(66, 133, 244, 0.2)',
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4285F4',
                pointBorderWidth: 2,
                fill: true,
                tension: 0
            }]
        },
        options: {
            responsive: true,
            plugins: { 
                legend: { 
                    position: 'top', 
                    labels: { 
                        boxWidth: 20, 
                        font: { size: 11 },
                        generateLabels: function(chart) {
                            return [{
                                text: 'Total Leads per Bulan',
                                fillStyle: 'rgba(66, 133, 244, 0.5)',
                                strokeStyle: '#4285F4',
                                lineWidth: 2
                            }];
                        }
                    } 
                } 
            },
            scales: { 
                x: { grid: { color: '#eee' } },
                y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#eee' } } 
            }
        }
    });

    // Trend Sumber Chart (Line - multiple datasets)
    new Chart(document.getElementById('trendSumberChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'FB/IG CABANG',
                    data: {!! json_encode($monthlyTrend) !!}, // Placeholder
                    borderColor: '#4285F4',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4285F4',
                    pointBorderWidth: 1.5,
                    fill: false,
                    tension: 0
                },
                {
                    label: 'FB/IG OFFICIAL',
                    data: {!! json_encode(array_map(function($v) { return $v * 0.5; }, $monthlyTrend)) !!}, // Placeholder
                    borderColor: '#34A853',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#34A853',
                    pointBorderWidth: 1.5,
                    fill: false,
                    tension: 0
                },
                {
                    label: 'GMB',
                    data: {!! json_encode(array_map(function($v) { return $v * 0.2; }, $monthlyTrend)) !!}, // Placeholder
                    borderColor: '#FBBC05',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#FBBC05',
                    pointBorderWidth: 1.5,
                    fill: false,
                    tension: 0
                },
                {
                    label: 'WEB',
                    data: {!! json_encode(array_map(function($v) { return $v * 0.8; }, $monthlyTrend)) !!}, // Placeholder
                    borderColor: '#EA4335',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#EA4335',
                    pointBorderWidth: 1.5,
                    fill: false,
                    tension: 0
                },
                {
                    label: 'WEB ORGANIK',
                    data: {!! json_encode(array_map(function($v) { return $v * 0.3; }, $monthlyTrend)) !!}, // Placeholder
                    borderColor: '#8E24AA',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#8E24AA',
                    pointBorderWidth: 1.5,
                    fill: false,
                    tension: 0
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { 
                legend: { 
                    position: 'top', 
                    labels: { 
                        boxWidth: 25, 
                        font: { size: 10 },
                        usePointStyle: false
                    } 
                } 
            },
            scales: { 
                x: { grid: { color: '#eee' } },
                y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#eee' } } 
            }
        }
    });


    // ============================================
    // BRANCH CHARTS
    // ============================================
    const branches = {!! json_encode($branches) !!};
    const branchData = {!! json_encode($branchData) !!};
    const chartStatusLabels = {!! json_encode($chartStatusLabels) !!};
    const chartSourceLabels = {!! json_encode($chartSourceLabels) !!};
    const chartUnitLabels = {!! json_encode($chartUnitLabels) !!};

    branches.forEach(function(branch) {
        const bData = branchData[branch];

        // Status Chart (Bar)
        new Chart(document.getElementById('statusChart_' + branch), {
            type: 'bar',
            data: {
                labels: chartStatusLabels,
                datasets: [{
                    label: 'Jumlah Leads',
                    data: bData.chartStatusData,
                    backgroundColor: ['#999999', '#00a65a', '#f39c12', '#00c0ef', '#f56954'],
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { 
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#eee' } } 
                }
            }
        });

        // Source Chart (Donut)
        new Chart(document.getElementById('sourceChart_' + branch), {
            type: 'doughnut',
            data: {
                labels: chartSourceLabels,
                datasets: [{
                    data: bData.chartSourceData,
                    backgroundColor: sourceColors,
                    borderWidth: 1,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: { 
                    legend: { position: 'top', labels: { boxWidth: 20, font: { size: 11 } } } 
                },
                cutout: '55%',
                scales: {
                    x: { grid: { display: false }, ticks: { display: false } },
                    y: { beginAtZero: true, grid: { color: '#eee' }, ticks: { display: false } }
                }
            }
        });

        // Unit Chart (Line)
        new Chart(document.getElementById('unitChart_' + branch), {
            type: 'line',
            data: {
                labels: chartUnitLabels,
                datasets: [{
                    label: '# Unit',
                    data: bData.chartUnitData,
                    borderColor: '#555',
                    borderWidth: 1.5,
                    pointRadius: 3,
                    pointBackgroundColor: ['#8E24AA', '#00c0ef', '#00a65a', '#f39c12', '#3c8dbc', '#8E24AA', '#00a65a', '#f39c12', '#00a65a', '#f39c12'],
                    pointBorderColor: 'transparent',
                    fill: false,
                    tension: 0
                }]
            },
            options: {
                responsive: true,
                plugins: { 
                    legend: { 
                        position: 'top', 
                        labels: { 
                            boxWidth: 25, 
                            font: { size: 11 },
                            generateLabels: function(chart) {
                                return [{
                                    text: '# Unit',
                                    fillStyle: '#eee',
                                    strokeStyle: '#555',
                                    lineWidth: 1
                                }];
                            }
                        } 
                    } 
                },
                scales: { 
                    x: { grid: { color: '#eee' } },
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#eee' } } 
                }
            }
        });

        // Trend Leads Chart (Area)
        new Chart(document.getElementById('trendLeadsChart_' + branch), {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Total Leads per Bulan',
                    data: bData.monthlyTrend,
                    borderColor: '#ff92b4',
                    backgroundColor: 'rgba(255, 146, 180, 0.4)',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#ff92b4',
                    pointBorderWidth: 2,
                    fill: true,
                    tension: 0
                }]
            },
            options: {
                responsive: true,
                plugins: { 
                    legend: { 
                        position: 'top', 
                        labels: { 
                            boxWidth: 20, 
                            font: { size: 11 },
                            generateLabels: function(chart) {
                                return [{
                                    text: 'Total Leads per Bulan (' + branch + ')',
                                    fillStyle: 'rgba(255, 146, 180, 0.4)',
                                    strokeStyle: '#ff92b4',
                                    lineWidth: 2
                                }];
                            }
                        } 
                    } 
                },
                scales: { 
                    x: { grid: { color: '#eee' } },
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#eee' } } 
                }
            }
        });

        // Trend Sumber Chart
        let trendSourceDatasets = [];
        chartSourceLabels.forEach((label, index) => {
            trendSourceDatasets.push({
                label: label,
                data: bData.trendSourceData[label],
                borderColor: sourceColors[index],
                borderWidth: 2,
                pointRadius: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: sourceColors[index],
                pointBorderWidth: 1.5,
                fill: false,
                tension: 0
            });
        });

        new Chart(document.getElementById('trendSumberChart_' + branch), {
            type: 'line',
            data: {
                labels: months,
                datasets: trendSourceDatasets
            },
            options: {
                responsive: true,
                plugins: { 
                    legend: { 
                        position: 'top', 
                        labels: { 
                            boxWidth: 25, 
                            font: { size: 10 },
                            usePointStyle: false
                        } 
                    } 
                },
                scales: { 
                    x: { grid: { color: '#eee' } },
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#eee' } } 
                }
            }
        });
    });
});
</script>
@endsection
