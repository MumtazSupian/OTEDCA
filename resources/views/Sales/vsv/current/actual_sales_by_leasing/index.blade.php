@extends('layouts.app')

@section('title', 'Actual Sales By Leasing')

@section('content')
    <div style="padding: 20px;">
        <h2 style="text-align:center; font-weight:800; color:#1e293b; font-weight:800; letter-spacing:0.5px; text-transform:uppercase; margin-bottom:5px;">
            🏦 ACTUAL SALES BY LEASING
        </h2>
        <p style="text-align:center; color: #64748b; margin-bottom:20px;">Monitoring realisasi penjualan berdasarkan mitra leasing</p>

        <div style="display:flex; justify-content:space-between; align-items:center; gap:8px; margin:0 auto 15px auto; width:98%;">
            <div style="display: flex; gap: 10px;">
                <a href="{{ url('/current/dashboard') }}" style="padding:8px 16px; background:#ffffff; color:#1e293b !important; border:1.5px solid #cbd5e1; font-weight:700; border:1.5px solid #e2e8f0; color:#1e293b; font-weight:800; border-radius:6px; font-size:13px; font-weight:600; text-decoration:none; box-shadow:0 2px 5px rgba(0,0,0,0.1); transition:0.3s;" onmouseover="this.style.background='#5a6268'; this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#6c757d'; this.style.transform='translateY(0)'">
                    ⬅ Kembali
                </a>
                <a href="{{ route('current.actual-sales-by-leasing.index') }}" style="padding:8px 16px; background:#f8f9fa; color:#333; border: 1px solid #ddd; border-radius:6px; font-size:13px; font-weight:600; text-decoration:none; transition:0.3s; box-shadow:0 2px 5px rgba(0,0,0,0.05);" onmouseover="this.style.background='#e2e6ea'" onmouseout="this.style.background='#f8f9fa'">
                    🔄 Refresh
                </a>
                <a href="{{ route('current.actual-sales-by-leasing.pdf') }}" style="padding: 8px 15px; background: #dc2626; color: #ffffff !important; font-weight:800; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 12px; margin-left: 5px;">📄 Export PDF</a>
                <a href="{{ route('current.actual-sales-by-leasing.excel') }}" style="padding: 8px 15px; background: #16a34a; color: #ffffff !important; font-weight:800; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 12px; border: 1px solid #2f855a; transition: 0.3s; margin-left: 5px;">📊 Excel</a>
            </div>

            <a href="{{ route('current.actual-sales-by-leasing.create') }}" style="padding:8px 16px; background:#dc2626; color:#ffffff; color:#1e293b; font-weight:800; border-radius:6px; font-size:13px; font-weight:600; text-decoration:none; box-shadow:0 4px 10px rgba(30, 136, 229, 0.3); transition:0.3s;" onmouseover="this.style.background='#1565c0'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#1e88e5'; this.style.transform='translateY(0)'">
                + Tambah Data
            </a>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if (session('success'))
            <script>
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", showConfirmButton: false, timer: 2000, customClass: { popup: 'rounded-4' } });
            </script>
        @endif

        <div style="background:#fff; padding:20px; border-radius:14px; box-shadow:0 6px 20px rgba(0,0,0,0.08); overflow-x:auto;">
            @php
                $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
                $grandTotals = [];
                foreach ($months as $m) { $grandTotals[$m] = $data->sum($m); }
                $grandTotalAll = $data->sum('total');
            @endphp

            <table width="100%" cellpadding="8" cellspacing="0" style="width:100%; border-collapse:collapse; font-family:'Segoe UI',sans-serif; font-size:12px; text-align:center; border: 1px solid #cbd5e1;">
                <thead style="background:#fee2e2; color:#991b1b;">
                    <tr style="border-bottom: 2px solid #f87171;">
                        <th style="border: 1px solid #cbd5e1; padding: 12px;">LEASING NAME</th>

                        @if(Auth::user()->role !== 'SH')
                            <th style="border: 1px solid #cbd5e1; width: 100px;">NAMA PENGINPUT</th>
                        @endif

                        <th style="border: 1px solid #cbd5e1; padding:8px;">CABANG</th>
                        <th style="border: 1px solid #cbd5e1;">TAHUN</th>
                        @foreach ($months as $m)
                            <th style="border: 1px solid #cbd5e1;">{{ strtoupper($m) }}</th>
                        @endforeach
                        <th style="border: 1px solid #cbd5e1; background:#fee2e2;">TOTAL</th>
                        <th style="border: 1px solid #cbd5e1;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr style="background:{{ $loop->iteration % 2 == 0 ? '#f7f9fb' : '#ffffff' }}; border-bottom: 1px solid var(--border-color, #e2e8f0); transition: 0.2s;" onmouseover="this.style.background='#edf2f7'" onmouseout="this.style.background='{{ $loop->iteration % 2 == 0 ? '#f7f9fb' : '#ffffff' }}'">
                            <td style="border: 1px solid #cbd5e1; font-weight:700; text-align:left; padding-left:15px; color:#991b1b;">
                                {{ ucwords(str_replace('_', ' ', $row->leasing_name)) }}
                            </td>
                            @if(Auth::user()->role !== 'SH')
                                <td style="border: 1px solid #cbd5e1; font-style:italic;">
                                    {{ $row->user->name ?? 'Sistem' }}
                                </td>
                            @endif
                            <td style="border: 1px solid #cbd5e1; font-weight:bold; color:#dc2626;">{{ $row->cabang }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $row->tahun }}</td>

                            @foreach ($months as $m)
                                <td style="border: 1px solid #cbd5e1;">{{ number_format($row->$m, 0, ',', '.') }}</td>
                            @endforeach

                            <td style="border: 1px solid #cbd5e1; font-weight: 800; background:#f0f7ff;">
                                {{ number_format($row->total, 0, ',', '.') }}
                            </td>

                            <td style="border: 1px solid #cbd5e1; white-space:nowrap;">
                                <a href="{{ route('current.actual-sales-by-leasing.edit', $row->id) }}" style="color:#1976d2; font-weight:600; text-decoration:none; margin-right:8px; transition: 0.2s;" onmouseover="this.style.color='#0d47a1'; this.style.textDecoration='underline'">Edit</a>

                                <form action="{{ route('current.actual-sales-by-leasing.destroy', $row->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $row->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $row->id }}')" style="background:#e53935;  border:none; padding:5px 10px; border-radius:4px; font-size:11px; font-weight:600; cursor:pointer; transition:0.2s; box-shadow: 0 2px 4px rgba(229, 57, 53, 0.2);" onmouseover="this.style.background='#b71c1c'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#e53935'; this.style.transform='scale(1)'">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="background:#fef2f2; color:#7f1d1d; font-weight:800; font-weight:bold;">
                    <tr>
                        <td colspan="4" style="border: 1px solid #cbd5e1; text-align: center; letter-spacing:1px; padding: 12px;">GRAND TOTAL</td>
                        @foreach ($months as $m)
                            <td style="border: 1px solid #cbd5e1;">{{ number_format($grandTotals[$m], 0, ',', '.') }}</td>
                        @endforeach
                        <td style="border: 1px solid #cbd5e1; background:#1565c0;">{{ number_format($grandTotalAll, 0, ',', '.') }}</td>
                        <td style="border: 1px solid #cbd5e1;">-</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Data Leasing?', text: "Data ini tidak dapat dikembalikan setelah dihapus.", icon: 'warning', showCancelButton: true, confirmButtonColor: '#e53935', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal', reverseButtons: true, customClass: { popup: 'rounded-4' }
            }).then((result) => {
                if (result.isConfirmed) { document.getElementById('delete-form-' + id).submit(); }
            })
        }
    </script>
@endsection