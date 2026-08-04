@extends('layouts.app')

@section('content')
    <div style="padding: 20px; max-width: 1300px; margin: 0 auto;">
        <h2 style="text-align:center; font-weight:800; color:#1e293b; font-weight:800; letter-spacing:0.5px; text-transform:uppercase; margin-bottom:5px;">
            📊 TARGET INQUIRIES
        </h2>
        <p style="text-align:center; color: #64748b; margin-bottom:20px; font-size: 14px;">Manajemen target prospek masuk per sumber inquiry</p>

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; padding: 0 10px;">
            <div style="display:flex; gap:10px; align-items:center;">
                <a href="{{ url('/rka/dashboard') }}"
                    style="padding: 8px 15px; background:#ffffff; color:#1e293b !important; border:1.5px solid #cbd5e1; font-weight:700; font-weight:800; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 12px; border: 1px solid rgba(255,255,255,0.2); transition: 0.3s;">
                    ← Dashboard
                </a>
                <a href="{{ route('rka.target-inquiries.index') }}"
                    style="padding: 8px 15px; background:#ffffff; color:#1e293b !important; border:1.5px solid #cbd5e1; font-weight:700; font-weight:800; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 12px; border: 1px solid rgba(255,255,255,0.1); transition: 0.3s;">
                    🔄 Refresh
                </a>
                <a href="{{ route('rka.target-inquiries.pdf') }}"
                    style="padding: 8px 15px; background: #dc2626; color: #ffffff !important; font-weight:800; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 12px; margin-left: 5px;">
                    📄 Export PDF
                </a>
                <a href="{{ route('rka.target-inquiries.excel') }}"
                    style="padding: 8px 15px; background: #16a34a; color: #ffffff !important; font-weight:800; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 12px; border: 1px solid #2f855a; transition: 0.3s; margin-left: 5px;">
                    📊 Excel
                </a>
            </div>

            <a href="{{ route('rka.target-inquiries.create') }}"
                style="padding: 8px 18px; background: #dc2626; color: #ffffff !important; font-weight:800; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 12px; box-shadow: 0 4px 12px rgba(49, 130, 206, 0.3); transition: 0.3s;">
                + TAMBAH DATA
            </a>
        </div>

        <div style="background:#fff; padding:15px; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.3); overflow-x:auto;">
            @php
                $months = ['jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nov','des'];
                $grandTotals = [];
                foreach ($months as $m) { $grandTotals[$m] = $data->sum($m); }
                $grandTotalAll = $data->sum('total');
            @endphp

            <table width="100%" cellpadding="0" cellspacing="0"
                style="width:100%; border-collapse:collapse; font-family:'Segoe UI',sans-serif; font-size:11px; text-align:center; border: 1px solid #cbd5e1;">
                <thead style="background:#f1f5f9; color:#991b1b;">
                    <tr style="border-bottom:2px solid #cbd5e0;">
                        <th style="border: 1px solid #cbd5e1; padding: 12px; text-align: left;">SOURCE INQUIRY</th>
                        <th style="border: 1px solid #cbd5e1; padding:8px;">CABANG</th>
                        
                        @if(Auth::user()->role !== 'SH')
                            <th style="border: 1px solid #cbd5e1; width: 100px;">NAMA PENGINPUT</th>
                        @endif

                        <th style="border: 1px solid #cbd5e1; width: 60px;">TAHUN</th>
                        @foreach ($months as $m)
                            <th style="border: 1px solid #cbd5e1; width: 45px;">{{ strtoupper($m) }}</th>
                        @endforeach
                        <th style="border: 1px solid #cbd5e1; background:#e2e8f0; width: 65px;">TOTAL</th>
                        <th style="border: 1px solid #cbd5e1; width: 110px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr style="background:{{ $loop->iteration % 2 == 0 ? '#f8fafc' : '#ffffff' }}; border-bottom: 1px solid var(--border-color, #e2e8f0);">
                            <td style="border: 1px solid #cbd5e1; font-weight:600; text-align:left; padding-left:12px;">{{ $row->source_inquiry }}</td>
                            <td style="border: 1px solid #cbd5e1; font-weight:bold; color:#dc2626;">{{ $row->cabang }}</td>
                            
                            @if(Auth::user()->role !== 'SH')
                                <td style="border: 1px solid #cbd5e1; font-style:italic;">
                                    {{ $row->user->name ?? 'Sistem' }}
                                </td>
                            @endif

                            <td style="border: 1px solid #cbd5e1;">{{ $row->tahun }}</td>
                            @foreach ($months as $m)
                                <td style="border: 1px solid #cbd5e1;">{{ number_format($row->$m, 0, ',', '.') }}</td>
                            @endforeach
                            <td style="border: 1px solid #cbd5e1; font-weight: 800; background:#f1f5f9;">{{ number_format($row->total, 0, ',', '.') }}</td>
                            <td style="border: 1px solid #cbd5e1; padding: 6px;">
                                <div style="display: flex; gap: 4px; justify-content: center;">
                                    <a href="{{ route('rka.target-inquiries.edit', $row->id) }}" 
                                       style="padding: 4px 8px; background: #dc2626; color: #ffffff !important; font-weight:800; text-decoration: none; border-radius: 4px; font-weight: 700; font-size: 10px;">
                                       EDIT
                                    </a>
                                    <form action="{{ route('rka.target-inquiries.destroy', $row->id) }}" 
                                          method="POST" 
                                          id="delete-form-{{ $row->id }}" 
                                          style="display:none;">
                                        @csrf @method('DELETE')
                                    </form>

                                    <button type="button" onclick="confirmDelete('{{ $row->id }}', '{{ $row->source_inquiry }}')"
                                            style="padding: 4px 8px; background: #fff5f5; color: #e53e3e; border: 1px solid #fed7d7; border-radius: 4px; font-weight: 700; font-size: 10px; cursor: pointer;">
                                        HAPUS
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="background:#fef2f2; color:#7f1d1d; font-weight:800; font-weight:bold;">
                    <tr>
                        <td colspan="{{ Auth::user()->role !== 'SH' ? 4 : 3 }}" style="border: 1px solid #cbd5e1; padding: 10px; text-align: center;">GRAND TOTAL</td>
                        @foreach ($months as $m)
                            <td style="border: 1px solid #cbd5e1;">{{ number_format($grandTotals[$m], 0, ',', '.') }}</td>
                        @endforeach
                        <td style="border: 1px solid #cbd5e1; background:#fef2f2; color:#991b1b;">{{ number_format($grandTotalAll, 0, ',', '.') }}</td>
                        <td style="border: 1px solid #cbd5e1;">-</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus Target ' + name + '?',
                text: "Data target inquiry ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'YA, HAPUS',
                confirmButtonColor: '#3182ce',
                cancelButtonText: 'Batal',
                cancelButtonColor: '#e53e3e', 
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endsection