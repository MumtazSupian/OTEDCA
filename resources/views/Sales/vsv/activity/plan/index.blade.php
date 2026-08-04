@extends('layouts.app')
@section('title', 'Marketing Activity Plan')
@section('content')
    <div style="padding: 20px;">
        <h2 style="text-align:center; font-weight:800; color:#1e293b; font-weight:800; letter-spacing:0.5px; text-transform:uppercase; margin-bottom:20px;">
            ACTIVITY PLAN
        </h2>

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; padding: 0 10px;">
            <div style="display:flex; gap:10px; align-items:center;">
                <a href="{{ url('/activity/dashboard') }}"
                    style="padding: 8px 15px; background:#ffffff; color:#1e293b !important; border:1.5px solid #cbd5e1; font-weight:700; font-weight:800; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 12px; border: 1px solid rgba(255,255,255,0.2); transition: 0.3s;">
                    ← Dashboard
                </a>
                <a href="{{ route('activity.plan.index') }}"
                    style="padding: 8px 15px; background:#ffffff; color:#1e293b !important; border:1.5px solid #cbd5e1; font-weight:700; font-weight:800; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 12px; border: 1px solid rgba(255,255,255,0.1); transition: 0.3s;">
                    🔄 Refresh
                </a>
                <a href="{{ route('activity.plan.pdf') }}"
                    style="padding: 8px 15px; background: #dc2626; color: #ffffff !important; font-weight:800; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 12px; margin-left: 5px;">
                    📄 Export PDF
                </a>
                <a href="{{ route('activity.plan.excel') }}"
                    style="padding: 8px 15px; background: #16a34a; color: #ffffff !important; font-weight:800; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 12px; border: 1px solid #2f855a; transition: 0.3s; margin-left: 5px;">
                    📊 Excel
                </a>
            </div>

            <a href="{{ route('activity.plan.create') }}"
                style="padding: 8px 18px; background: #dc2626; color: #ffffff !important; font-weight:800; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 12px; box-shadow: 0 4px 12px rgba(49, 130, 206, 0.3); transition: 0.3s;">
                + TAMBAH DATA
            </a>
        </div>

        <div style="background:#fff; padding:15px; border-radius:14px; box-shadow:0 6px 20px rgba(0,0,0,0.15);">
            <table style="width:100%; border-collapse:collapse; font-family:'Segoe UI',sans-serif; font-size:9px; text-align:center; border: 1px solid #cbd5e1;">
                <thead style="background:#fee2e2; color:#991b1b; font-weight: bold;">
                    <tr style="border-bottom: 2px solid #f87171;">
                        <th rowspan="2" style="border: 1px solid #cbd5e1;">NO</th>
                        <th rowspan="2" style="border: 1px solid #cbd5e1;">CABANG</th>
                        <th rowspan="2" style="border: 1px solid #cbd5e1;">JENIS<br>ACTIVITY</th>
                        <th rowspan="2" style="border: 1px solid #cbd5e1;">ACTIVITY</th>
                        <th rowspan="2" style="border: 1px solid #cbd5e1;">PLATFORM/LOKASI</th>
                        <th colspan="2" style="border: 1px solid #cbd5e1;">UPLOAD KONTEN/DISPLAY</th>
                        <th colspan="2" style="border: 1px solid #cbd5e1;">WAKTU PELAKSANAAN</th>
                        <th rowspan="2" style="border: 1px solid #cbd5e1;">PIC</th>
                        <th rowspan="2" style="border: 1px solid #cbd5e1;">JML SALES<br>PER SHIFT</th>
                        <th colspan="3" style="border: 1px solid #cbd5e1;">TARGET</th>
                        <th colspan="4" style="border: 1px solid #cbd5e1;">ACTUAL</th>
                        <th rowspan="2" style="border: 1px solid #cbd5e1;">TOTAL COST</th>
                        <th rowspan="2" style="border: 1px solid #cbd5e1;">COST/P</th>
                        <th rowspan="2" style="border: 1px solid #cbd5e1;">COST/SPK</th>
                        <th rowspan="2" style="border: 1px solid #cbd5e1;">COST/DO</th>
                        <th rowspan="2" style="border: 1px solid #cbd5e1;">KETERANGAN</th>
                        <th rowspan="2" style="border: 1px solid #cbd5e1;">AKSI</th>
                    </tr>
                    <tr style="border-bottom: 2px solid #f87171;">
                        <th style="border: 1px solid #cbd5e1;">Jenis Unit</th>
                        <th style="border: 1px solid #cbd5e1;">Type Unit</th>
                        <th style="border: 1px solid #cbd5e1;">Tanggal</th>
                        <th style="border: 1px solid #cbd5e1;">Jam</th>
                        <th style="border: 1px solid #cbd5e1;">P</th>
                        <th style="border: 1px solid #cbd5e1;">HP</th>
                        <th style="border: 1px solid #cbd5e1;">SPK</th>
                        <th style="border: 1px solid #cbd5e1;">P</th>
                        <th style="border: 1px solid #cbd5e1;">HP</th>
                        <th style="border: 1px solid #cbd5e1;">SPK</th>
                        <th style="border: 1px solid #cbd5e1;">DO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr style="background:#fff; border-bottom: 1px solid #000;">
                            <td style="border: 1px solid #cbd5e1; padding: 5px 2px;">{{ $loop->iteration }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $item->cabang }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $item->jenis_activity }}</td>
                            <td style="border: 1px solid #cbd5e1; text-align: left; padding: 2px;">{{ $item->activity }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $item->platform_lokasi }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $item->jenis_unit }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $item->type_unit }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/y') }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ \Carbon\Carbon::parse($item->jam)->format('H:i') }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $item->pic }}</td>
                            <td style="border: 1px solid #cbd5e1; font-weight: bold;">{{ $item->jml_sales_shift }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $item->target_p }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $item->target_hp }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $item->target_spk }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $item->actual_p }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $item->actual_hp }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $item->actual_spk }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $item->actual_do }}</td>
                            <td style="border: 1px solid #cbd5e1;">Rp{{ number_format($item->total_cost, 0, ',', '.') }}</td>
                            <td style="border: 1px solid #cbd5e1;">Rp{{ number_format($item->cost_p, 0, ',', '.') }}</td>
                            <td style="border: 1px solid #cbd5e1;">Rp{{ number_format($item->cost_spk, 0, ',', '.') }}</td>
                            <td style="border: 1px solid #cbd5e1;">Rp{{ number_format($item->cost_do, 0, ',', '.') }}</td>
                            <td style="border: 1px solid #cbd5e1; text-align: left; padding: 2px;">{{ $item->keterangan }}</td>
                            <td style="border: 1px solid #cbd5e1; padding: 5px;">
                                <a href="{{ route('activity.plan.edit', $item->id) }}" style="background: #dc2626;  padding: 2px 5px; border-radius: 4px; font-size: 10px; text-decoration:none; font-weight:700; margin-right:2px; text-transform: uppercase;">EDIT</a>
                                <form action="{{ route('activity.plan.destroy', $item->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $item->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $item->id }}')" style="background:#fff5f5; color:#e53e3e; border:1px solid #feb2b2; padding: 2px 5px; border-radius:4px; font-size: 10px; cursor:pointer; font-weight:700; text-transform: uppercase;">HAPUS</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="background:#fef2f2; color:#7f1d1d; font-weight:800; font-weight:bold;">
                    <tr style="border-top: 2px solid #000;">
                        <td colspan="10" style="border: 1px solid #cbd5e1; padding: 5px;">GRAND TOTAL</td>
                        <td style="border: 1px solid #cbd5e1;">{{ $data->sum('jml_sales_shift') }}</td>
                        <td style="border: 1px solid #cbd5e1;">{{ $data->sum('target_p') }}</td>
                        <td style="border: 1px solid #cbd5e1;">{{ $data->sum('target_hp') }}</td>
                        <td style="border: 1px solid #cbd5e1;">{{ $data->sum('target_spk') }}</td>
                        <td style="border: 1px solid #cbd5e1;">{{ $data->sum('actual_p') }}</td>
                        <td style="border: 1px solid #cbd5e1;">{{ $data->sum('actual_hp') }}</td>
                        <td style="border: 1px solid #cbd5e1;">{{ $data->sum('actual_spk') }}</td>
                        <td style="border: 1px solid #cbd5e1;">{{ $data->sum('actual_do') }}</td>
                        <td style="border: 1px solid #cbd5e1;">Rp{{ number_format($data->sum('total_cost'), 0, ',', '.') }}</td>
                        <td style="border: 1px solid #cbd5e1;">Rp{{ $data->sum('actual_p') > 0 ? number_format($data->sum('total_cost') / $data->sum('actual_p'), 0, ',', '.') : '0' }}</td>
                        <td style="border: 1px solid #cbd5e1;">Rp{{ $data->sum('actual_spk') > 0 ? number_format($data->sum('total_cost') / $data->sum('actual_spk'), 0, ',', '.') : '0' }}</td>
                        <td style="border: 1px solid #cbd5e1;">Rp{{ $data->sum('actual_do') > 0 ? number_format($data->sum('total_cost') / $data->sum('actual_do'), 0, ',', '.') : '0' }}</td>
                        <td style="border: 1px solid #cbd5e1;">-</td>
                        <td style="border: 1px solid #cbd5e1;">-</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3182ce',
                cancelButtonColor: '#e53e3e',
                confirmButtonText: 'YA, HAPUS',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endsection
