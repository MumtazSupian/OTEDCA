@extends('layouts.app')

@section('title', 'Action Plan Improvement')

@section('content')
    <div style="padding: 20px;">
        <h2
            style="text-align:center; font-weight:800; color:#1e293b; font-weight:800; letter-spacing:0.5px; text-transform:uppercase; margin-bottom:5px;">
            🛠️ ACTION PLAN IMPROVEMENT
        </h2>
        <p style="text-align:center; color: #64748b; margin-bottom:20px;">
            Kelola data operasional, kondisi saat ini, dan rencana tindakan perbaikan
        </p>

        <div
            style="display:flex; justify-content:space-between; align-items:center; gap:8px; margin:0 auto 15px auto; width:98%;">
            <div>
                <a href="{{ url('/summary/dashboard') }}"
                    style="padding:8px 16px; background:#ffffff; color:#1e293b !important; border:1.5px solid #cbd5e1; font-weight:700; border:1.5px solid #e2e8f0; color:#1e293b; font-weight:800; border-radius:6px; font-size:13px; font-weight:600; text-decoration:none; box-shadow:0 2px 5px rgba(0,0,0,0.1); transition:0.3s;"
                    onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#ffffff'">
                    ⬅ Kembali
                </a>
            </div>

            {{-- Grup Tombol Kanan --}}
            <div style="display:flex; gap:8px; align-items:center;">
                {{-- Tombol Excel --}}
                <a href="{{ route('summary.summary-action.excel') }}"
                    style="padding:8px 16px; background: #16a34a; color: #ffffff !important; font-weight:800; border-radius:6px; font-size:13px; font-weight:600; text-decoration:none; box-shadow:0 2px 5px rgba(0,0,0,0.1); transition:0.3s;"
                    onmouseover="this.style.background='#1b5e20'" onmouseout="this.style.background='#2e7d32'">
                    📗 Export Excel
                </a>

                {{-- Tombol PDF --}}
                <a href="{{ route('summary.summary-action.pdf') }}"
                    style="padding:8px 16px; background: #dc2626; color: #ffffff !important; font-weight:800; border-radius:6px; font-size:13px; font-weight:600; text-decoration:none; box-shadow:0 2px 5px rgba(0,0,0,0.1); transition:0.3s;"
                    onmouseover="this.style.background='#b71c1c'" onmouseout="this.style.background='#c62828'">
                    📕 Export PDF
                </a>

                {{-- Tombol Tambah --}}
                <a href="{{ route('summary.summaryaction.create') }}"
                    style="padding:8px 16px; background:#dc2626; color:#ffff; font-weight:800; border-radius:6px; font-size:13px; font-weight:600; text-decoration:none; box-shadow:0 2px 5px rgba(0,0,0,0.1); transition:0.3s;"
                    onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">
                    + Tambah Aksi
                </a>
            </div>
        </div>

        {{-- SweetAlert2 Library --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- Notifikasi Sukses --}}
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

        <div
            style="background:#fff; padding:20px; border-radius:14px; box-shadow:0 6px 20px rgba(0,0,0,0.08); overflow-x:auto;">
            <table width="100%" cellpadding="8" cellspacing="0"
                style="width:100%; border-collapse:collapse; font-family:'Segoe UI',sans-serif; font-size:13px; text-align:center; border: 1px solid #cbd5e1;">
                <thead style="background:#fee2e2; color:#991b1b;">
                    <tr style="border-bottom: 2px solid #f87171;">
                        <th style="border: 1px solid #cbd5e1; width: 20%;">OPERASIONAL</th>
                        <th style="border: 1px solid #cbd5e1; padding:8px;">CABANG</th>
                        <th style="border: 1px solid #cbd5e1;">KONDISI YANG ADA</th>
                        <th style="border: 1px solid #cbd5e1;">ACTION PERBAIKAN</th>
                        <th style="border: 1px solid #cbd5e1; width: 10%;">DO / DON'T</th>
                        <th style="border: 1px solid #cbd5e1; width: 12%;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($summary_actions as $s)
                        <tr
                            style="background:{{ $loop->iteration % 2 == 0 ? '#f7f9fb' : '#ffffff' }}; border-bottom: 1px solid var(--border-color, #e2e8f0);">
                            <td style="border: 1px solid #cbd5e1; font-weight:600; text-align:left; padding-left:15px;">
                                {{ $s->operasional }}
                            </td>
                            <td style="border: 1px solid #cbd5e1; font-weight:bold; color:#dc2626;">{{ $s->cabang }}</td>
                            <td style="border: 1px solid #cbd5e1; text-align:left;">{{ $s->kondisi_yang_ada }}</td>
                            <td style="border: 1px solid #cbd5e1; text-align:left;">{{ $s->action_perbaikan }}</td>
                            <td style="border: 1px solid #cbd5e1;">
                                @if ($s->do_dont == 'V')
                                    <span
                                        style="background:#198754;  padding:4px 10px; border-radius:20px; font-size:11px; font-weight:bold;">
                                        ✔ DO
                                    </span>
                                @elseif ($s->do_dont == 'X')
                                    <span
                                        style="background:#dc3545;  padding:4px 10px; border-radius:20px; font-size:11px; font-weight:bold;">
                                        ✖ DON'T
                                    </span>
                                @else
                                    <span style="color:#999;">-</span>
                                @endif
                            </td>
                            <td style="border: 1px solid #cbd5e1; white-space:nowrap;">
                                <a href="{{ route('summary.summaryaction.edit', $s->id) }}"
                                    style="color:#1976d2; font-weight:600; text-decoration:none; margin-right:8px; font-size:12px;">Edit</a>

                                <form action="{{ route('summary.summaryaction.destroy', $s->id) }}" method="POST"
                                    style="display:inline;" id="delete-form-{{ $s->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $s->id }}')"
                                        style="background:#e53935;  border:none; padding:4px 12px; border-radius:4px; font-size:11px; cursor:pointer; transition:0.2s;"
                                        onmouseover="this.style.background='#b71c1c'"
                                        onmouseout="this.style.background='#e53935'">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="border: 1px solid #cbd5e1; padding:30px; color:#999; font-style:italic;">
                                Data belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
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
                customClass: {
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
