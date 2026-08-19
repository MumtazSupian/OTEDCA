@extends('layouts.app')

@section('title', 'Evaluasi Wiraniaga')

@section('content')
    <div style="padding: 20px;">
        <h2
            style="text-align:center; font-weight:800; color:#1e293b; letter-spacing:0.5px; text-transform:uppercase; margin-bottom:5px;">
            📊 EVALUASI WIRANIAGA
        </h2>
        <p style="text-align:center; color: #64748b; margin-bottom:20px;">Monitoring kinerja wiraniaga secara periodik</p>
        
        <div style="display:flex; justify-content:flex-end; align-items:center; gap:8px; margin:0 auto 15px auto; width:98%;">
            {{-- Tombol Export Excel --}}
            <a href="{{ route('evaluasi.excel') }}"
                style="padding:8px 16px; background: #16a34a; color: #ffffff !important; border-radius:6px; font-size:13px; font-weight:600; text-decoration:none; box-shadow:0 2px 5px rgba(0,0,0,0.1); transition:0.3s;"
                onmouseover="this.style.background='#1b5e20'" onmouseout="this.style.background='#2e7d32'">
                📗 Export Excel
            </a>

            {{-- Tombol Export PDF --}}
            <a href="{{ route('evaluasi.pdf') }}"
                style="padding:8px 16px; background: #dc2626; color: #ffffff !important; border-radius:6px; font-size:13px; font-weight:600; text-decoration:none; box-shadow:0 2px 5px rgba(0,0,0,0.1); transition:0.3s;"
                onmouseover="this.style.background='#b71c1c'" onmouseout="this.style.background='#c62828'">
                📕 Export PDF
            </a>
        </div>
        
        <div style="display:flex; justify-content:flex-end; align-items:center; gap:8px; margin:0 auto 15px auto; width:98%;">
            <a href="{{ route('evaluasi.create') }}"
                style="padding:8px 16px; background: #dc2626; color: #ffffff !important; border-radius:6px; font-size:13px; font-weight:600; text-decoration:none; box-shadow:0 2px 5px rgba(0,0,0,0.1); transition:0.3s;"
                onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">
                + Tambah Data
            </a>
        </div>

        {{-- alert --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- Notif --}}
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2000,
                    customClass: {
                        popup: 'rounded-4'
                    }
                });
            </script>
        @endif

        <div style="background:#fff; padding:20px; border-radius:14px; box-shadow:0 6px 20px rgba(0,0,0,0.08); overflow-x:auto;">
            <table width="100%" cellpadding="8" cellspacing="0"
                style="width:100%; border-collapse:collapse; font-family:'Segoe UI',sans-serif; font-size:12px; text-align:center; border: 1px solid #cbd5e1;">
                <thead style="background:#fee2e2; color:#991b1b;">
                    <tr style="border-bottom:2px solid #f87171;">
                        <th style="border: 1px solid #cbd5e1;">NO</th>
                        <th style="border: 1px solid #cbd5e1; padding:8px;">CABANG</th>
                        <th style="border: 1px solid #cbd5e1;">SALES HEAD</th>
                        <th style="border: 1px solid #cbd5e1;">NAMA SALES</th>
                        <th style="border: 1px solid #cbd5e1;">TGL MASUK</th>
                        <th style="border: 1px solid #cbd5e1;">TGL EVALUASI</th>
                        <th style="border: 1px solid #cbd5e1;">GRADING</th>
                        <th style="border: 1px solid #cbd5e1;">JAN</th>
                        <th style="border: 1px solid #cbd5e1;">FEB</th>
                        <th style="border: 1px solid #cbd5e1;">MAR</th>
                        <th style="border: 1px solid #cbd5e1;">APR</th>
                        <th style="border: 1px solid #cbd5e1;">MEI</th>
                        <th style="border: 1px solid #cbd5e1;">JUN</th>
                        <th style="border: 1px solid #cbd5e1;">JUL</th>
                        <th style="border: 1px solid #cbd5e1;">AGU</th>
                        <th style="border: 1px solid #cbd5e1;">SEP</th>
                        <th style="border: 1px solid #cbd5e1;">OKT</th>
                        <th style="border: 1px solid #cbd5e1;">NOV</th>
                        <th style="border: 1px solid #cbd5e1;">DES</th>
                        <th style="border: 1px solid #cbd5e1;">TOTAL</th>
                        <th style="border: 1px solid #cbd5e1;">EVALUASI</th>
                        <th style="border: 1px solid #cbd5e1;">TGL KELUAR</th>
                        <th style="border: 1px solid #cbd5e1;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i => $d)
                        <tr style="background:{{ $loop->iteration % 2 == 0 ? '#f8fafc' : '#ffffff' }}; border-bottom: 1px solid var(--border-color, #e2e8f0);">
                            <td style="border: 1px solid #cbd5e1;">{{ $i + 1 }}</td>
                            <td style="border: 1px solid #cbd5e1; font-weight:bold; color:#dc2626;">{{ $d->cabang }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $d->nama_sales_head }}</td>
                            <td style="border: 1px solid #cbd5e1; font-weight:600;">{{ $d->nama_sales }}</td>
                            <td style="border: 1px solid #cbd5e1; white-space:nowrap;">{{ $d->tanggal_masuk }}</td>
                            <td style="border: 1px solid #cbd5e1; white-space:nowrap;">{{ $d->tanggal_evaluasi }}</td>

                            {{-- Kolom Grading: Mengambil langsung dari Database --}}
                            <td style="border: 1px solid #cbd5e1; text-align:center;">
                                @php
                                    // Logika warna berdasarkan teks grading dari database
                                    $color = '#f44336'; // Default Merah (Evaluasi)

                                    if ($d->grading == 'PLATINUM') {
                                        $color = '#1a237e'; // Biru Tua
                                    } elseif (str_contains($d->grading, 'KADAR PLATINUM')) {
                                        $color = '#ff9800'; // Oranye
                                    } elseif (str_contains($d->grading, 'KADAR GOLD')) {
                                        $color = '#78909c'; // Abu-abu kebiruan (Silver/Gold)
                                    } elseif (str_contains($d->grading, 'KADAR SILVER')) {
                                        $color = '#4caf50'; // Hijau
                                    }
                                @endphp

                                <span
                                    style="padding: 4px 8px; border-radius: 4px; color: #ffffff; font-weight: bold; font-size: 9px; background: {{ $color }}; white-space: nowrap; display: inline-block;">
                                    {{ $d->grading ?? 'TRAINEE->EVALUASI' }}
                                </span>
                            </td>

                            <td style="border: 1px solid #cbd5e1;">{{ $d->jan }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $d->feb }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $d->mar }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $d->apr }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $d->mei }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $d->jun }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $d->jul }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $d->agu }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $d->sep }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $d->okt }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $d->nov }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ $d->des }}</td>
                            <td style="border: 1px solid #cbd5e1; font-weight: 700;">{{ $d->total }}</td>
                            <td style="border: 1px solid #cbd5e1;">{{ Str::limit($d->evaluasi, 20) }}</td>
                            <td style="border: 1px solid #cbd5e1; white-space:nowrap;">{{ $d->tanggal_keluar }}</td>
                            <td style="border: 1px solid #cbd5e1; white-space:nowrap;">
                                {{-- Tombol Aksi --}}
                                <a href="{{ route('evaluasi.edit', $d->id) }}"
                                    style="color:#1976d2; font-weight:700; text-decoration:none; margin-right:8px;">Edit</a>
                                <form action="{{ route('evaluasi.destroy', $d->id) }}" method="POST"
                                    style="display:inline;" id="delete-form-{{ $d->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $d->id }}')"
                                        style="background:#e53935; color:#ffffff; border:none; padding:4px 8px; border-radius:4px; font-weight:600; font-size:11px; cursor:pointer; transition:0.2s;" onmouseover="this.style.background='#c62828'" onmouseout="this.style.background='#e53935'">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="background:#fef2f2; font-weight:bold; color:#991b1b;">
                    <tr>
                        <td colspan="19" style="border: 1px solid #cbd5e1; text-align: center; letter-spacing:1px;">GRAND TOTAL</td>
                        <td style="border: 1px solid #cbd5e1; background:#fee2e2;">{{ $grandTotal }}</td>
                        <td colspan="3" style="border: 1px solid #cbd5e1;">-</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Script Konfirmasi Hapus --}}
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e53935',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                background: '#ffffff',
                customClass: {
                    title: 'text-dark',
                    popup: 'rounded-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endsection