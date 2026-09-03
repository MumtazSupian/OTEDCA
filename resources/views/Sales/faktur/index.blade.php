@extends('layouts.app')

@section('title', 'Data Faktur Polisi')

@section('content')
<style>
    .faktur-container {
        padding: 10px 0 30px 0;
    }

    .page-header-faktur {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
    }

    .page-header-faktur h1 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 4px 0;
    }

    .page-header-faktur p {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0;
    }

    .btn-create-faktur {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white !important;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13.5px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        transition: all 0.25s ease;
        text-decoration: none;
        border: none;
    }

    .btn-create-faktur:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
        color: white;
    }

    /* STATS CARDS */
    .stats-grid-faktur {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
        margin-bottom: 25px;
        max-width: 600px;
    }

    @media (max-width: 576px) {
        .stats-grid-faktur {
            grid-template-columns: 1fr;
        }
    }

    .stat-card-faktur {
        background: white;
        border-radius: 14px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .stat-card-faktur:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.06);
    }

    .stat-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-info .stat-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .stat-info .stat-value {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    /* FILTER CARD */
    .filter-card-faktur {
        background: white;
        border-radius: 14px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
        margin-bottom: 25px;
    }

    .filter-form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 14px;
        align-items: flex-end;
    }

    .form-group-faktur {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group-faktur label {
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin: 0;
    }

    .form-control-faktur {
        width: 100%;
        padding: 9px 12px;
        font-size: 13px;
        color: #1e293b;
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control-faktur:focus {
        border-color: #2563eb;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    /* TABLE CARD */
    .table-card-faktur {
        background: white;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .table-responsive-faktur {
        width: 100%;
        overflow-x: auto;
    }

    .custom-table-faktur {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .custom-table-faktur th {
        background: #f8fafc;
        padding: 14px 16px;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    .custom-table-faktur td {
        padding: 14px 16px;
        font-size: 13.5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .custom-table-faktur tbody tr:hover {
        background-color: #f8fafc;
    }

    .badge-unit {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.3px;
        background: #f1f5f9;
        color: #0f172a;
        border: 1px solid #e2e8f0;
    }

    .badge-qty {
        display: inline-block;
        min-width: 36px;
        text-align: center;
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 800;
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .action-btn-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-action-edit {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-action-edit:hover {
        background: #2563eb;
        color: white;
    }

    .btn-action-delete {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-action-delete:hover {
        background: #dc2626;
        color: white;
    }
</style>

<div class="faktur-container">
    {{-- Header --}}
    <div class="page-header-faktur">
        <div>
            <h1>Data Faktur Polisi</h1>
            <p>Kelola dan pantau input data Faktur Polisi kendaraan per model, cabang, dan bulan.</p>
        </div>
        <div>
            <a href="{{ route('sales.faktur.create') }}" class="btn-create-faktur">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah Data Faktur
            </a>
        </div>
    </div>

    {{-- Flash Alert --}}
    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; font-size: 13.5px; font-weight: 600;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px; color: #10b981;">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove();" style="background: none; border: none; font-size: 16px; cursor: pointer; color: #065f46;">&times;</button>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="stats-grid-faktur">
        <div class="stat-card-faktur">
            <div class="stat-icon-wrap" style="background: #eff6ff; color: #2563eb;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px;">
                    <rect x="1" y="3" width="15" height="13"></rect>
                    <polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon>
                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                </svg>
            </div>
            <div class="stat-info">
                <div class="stat-label">TOTAL FAKTUR</div>
                <div class="stat-value">{{ number_format($totalFakturAll) }}</div>
            </div>
        </div>

        <div class="stat-card-faktur">
            <div class="stat-icon-wrap" style="background: #f1f5f9; color: #475569;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px;">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
            </div>
            <div class="stat-info">
                <div class="stat-label">TOTAL DATA ENTRI</div>
                <div class="stat-value" style="color: #475569;">{{ number_format($totalRows) }}</div>
            </div>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="filter-card-faktur">
        <form action="{{ route('sales.faktur.index') }}" method="GET">
            <div class="filter-form-grid">
                {{-- Tahun --}}
                <div class="form-group-faktur">
                    <label for="tahun">TAHUN</label>
                    <select name="tahun" id="tahun" class="form-control-faktur">
                        @for($y = date('Y') + 1; $y >= 2023; $y--)
                            <option value="{{ $y }}" {{ $selectedTahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                {{-- Bulan --}}
                <div class="form-group-faktur">
                    <label for="bulan">BULAN</label>
                    <select name="bulan" id="bulan" class="form-control-faktur">
                        <option value="">Semua Bulan</option>
                        @foreach($bulanMap as $num => $b)
                            <option value="{{ $b }}" {{ $selectedBulan == $b ? 'selected' : '' }}>
                                {{ strtoupper($b) }} ({{ \App\Models\Sales\faktur\Faktur::BULAN_NAMA_LENGKAP[$b] ?? $b }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Cabang --}}
                @if($isPusat)
                <div class="form-group-faktur">
                    <label for="cabang">CABANG</label>
                    <select name="cabang" id="cabang" class="form-control-faktur">
                        <option value="">Semua Cabang</option>
                        @foreach($availableBranches as $cb)
                            <option value="{{ $cb }}" {{ $selectedCabang == $cb ? 'selected' : '' }}>{{ $cb }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                {{-- Tipe Kendaraan --}}
                <div class="form-group-faktur">
                    <label for="tipe_kendaraan">TIPE KENDARAAN</label>
                    <select name="tipe_kendaraan" id="tipe_kendaraan" class="form-control-faktur">
                        <option value="">Semua Tipe</option>
                        @foreach($tipeKendaraanList as $tipe)
                            <option value="{{ $tipe }}" {{ $selectedTipe == $tipe ? 'selected' : '' }}>{{ $tipe }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Search --}}
                <div class="form-group-faktur">
                    <label for="search">CARI</label>
                    <input type="text" name="search" id="search" value="{{ $search }}" placeholder="Ketik kata kunci..." class="form-control-faktur">
                </div>

                {{-- Action Buttons --}}
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn-create-faktur" style="padding: 9px 16px; border-radius: 8px; font-size: 13px;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        Filter
                    </button>
                    @if($selectedBulan || $selectedCabang || $selectedTipe || $search)
                        <a href="{{ route('sales.faktur.index') }}" style="display: inline-flex; align-items: center; justify-content: center; padding: 9px 12px; background: #f1f5f9; color: #475569; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600;">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- Data Table --}}
    <div class="table-card-faktur">
        <div class="table-responsive-faktur">
            <table class="custom-table-faktur">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO</th>
                        <th>TIPE KENDARAAN</th>
                        <th>PERIODE</th>
                        <th>CABANG</th>
                        <th style="text-align: center;">JUMLAH FAKTUR</th>
                        <th>KETERANGAN</th>
                        <th style="text-align: center; width: 100px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $index => $item)
                        <tr>
                            <td style="color: #94a3b8; font-weight: 600;">
                                {{ $items->firstItem() + $index }}
                            </td>
                            <td>
                                <span class="badge-unit">{{ $item->tipe_kendaraan }}</span>
                            </td>
                            <td>
                                <span style="font-weight: 700; color: #1e293b;">
                                    {{ strtoupper($item->bulan) }} {{ $item->tahun }}
                                </span>
                                <div style="font-size: 11px; color: #64748b;">
                                    {{ $item->nama_bulan }}
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #334155;">{{ $item->cabang }}</span>
                            </td>
                            <td style="text-align: center;">
                                <span class="badge-qty">{{ number_format($item->jumlah) }}</span>
                            </td>
                            <td style="color: #64748b; font-size: 12.5px;">
                                {{ $item->keterangan ?: '-' }}
                            </td>
                            <td style="text-align: center;">
                                <div class="action-btn-group" style="justify-content: center;">
                                    <a href="{{ route('sales.faktur.edit', $item->id) }}" class="btn-action-edit" title="Edit Data">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('sales.faktur.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data Faktur {{ $item->tipe_kendaraan }} periode {{ strtoupper($item->bulan) }} {{ $item->tahun }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-delete" title="Hapus Data">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px 20px;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 10px; color: #94a3b8;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="width: 48px; height: 48px; color: #cbd5e1;">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                    </svg>
                                    <span style="font-size: 14px; font-weight: 600;">Belum ada data Faktur yang diinput.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($items->hasPages())
            <div style="padding: 16px 20px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <div style="font-size: 13px; color: #64748b;">
                    Menampilkan {{ $items->firstItem() }} s/d {{ $items->lastItem() }} dari total {{ $items->total() }} data
                </div>
                <div>
                    {{ $items->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
