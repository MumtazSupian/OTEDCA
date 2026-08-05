@extends('layouts.app')

@section('title', 'Edit Summary Operasional')

@section('content')
    <div style="padding: 40px 20px; display: flex; flex-direction: column; align-items: center; min-height: 100vh;">

        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="font-weight:800; color:#1e293b; font-weight:800; letter-spacing:1px; text-transform:uppercase; margin:0;">
                ✏️ EDIT SUMMARY OPERASIONAL
            </h2>
            <div style="width: 50px; height: 4px; background: #dc2626; margin: 10px auto; border-radius: 10px;"></div>
            <p style="color: #64748b; font-size: 14px;">Perbarui data rencana dan aktual perbaikan operasional</p>
            <p style="text-align:center; color: #718096; font-size: 12px; margin-bottom: 15px;">
                Menginput data untuk Cabang: <strong style="color: #2d3748;">{{ Auth::user()->cabang }}</strong>
            </p>
        </div>

        <div
            style="background: white; width: 100%; box-sizing: border-box; max-width: 750px; padding: 35px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">

            <form id="editForm" action="{{ route('summary.summary.update', $summary->id) }}" method="POST">
                @csrf
                @method('PUT')

                @php
                    $ops = [
                        'Jumlah Sales Force by Grading',
                        'Jumlah Inquiry by Type',
                        'Jumlah Activity by Type',
                        'Source Of Inquiry',
                        'Issue',
                        'Usulan',
                    ];
                @endphp

                <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                    {{-- Operasional --}}
                    <div>
                        <label
                            style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 13px; text-transform: uppercase;">
                            Kategori Operasional
                        </label>
                        <select name="operasional"
                            style="width: 100%; box-sizing: border-box; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #4a5568; outline: none; transition: 0.3s; cursor: pointer;">
                            @foreach ($ops as $op)
                                <option value="{{ $op }}" {{ $summary->operasional == $op ? 'selected' : '' }}>
                                    {{ $op }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Do / Don't --}}
                    <div>
                        <label
                            style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 13px; text-transform: uppercase;">
                            Status (Do / Don't)
                        </label>
                        <select name="do_dont"
                            style="width: 100%; box-sizing: border-box; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #4a5568; outline: none; transition: 0.3s; cursor: pointer;">
                            <option value="">-- Pilih Status --</option>
                            <option value="V" {{ $summary->do_dont == 'V' ? 'selected' : '' }}>✔ Do</option>
                            <option value="X" {{ $summary->do_dont == 'X' ? 'selected' : '' }}>✖ Don't</option>
                        </select>
                    </div>
                </div>

                {{-- Plan Perbaikan --}}
                <div style="margin-bottom: 20px;">
                    <label
                        style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 13px; text-transform: uppercase;">
                        📌 Plan Rencana Perbaikan
                    </label>
                    <textarea name="plan_perbaikan" rows="4"
                        style="width: 100%; box-sizing: border-box; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #4a5568; outline: none; transition: 0.3s; resize: none;"
                        placeholder="Tuliskan rencana perbaikan...">{{ $summary->plan_perbaikan }}</textarea>
                </div>

                {{-- Aktual Pelaksanaan --}}
                <div style="margin-bottom: 10px;">
                    <label
                        style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 13px; text-transform: uppercase;">
                        ✅ Aktual Pelaksanaan
                    </label>
                    <textarea name="aktual_perbaikan" rows="4"
                        style="width: 100%; box-sizing: border-box; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #4a5568; outline: none; transition: 0.3s; resize: none;"
                        placeholder="Tuliskan aktual pelaksanaan...">{{ $summary->aktual_perbaikan }}</textarea>
                </div>

                {{-- Form Actions --}}
                <div style="margin-top: 35px; display: flex; gap: 15px;">
                    <a href="{{ route('summary.summary.index') }}"
                        style="flex: 1; padding: 14px; background: #edf2f7; color: #4a5568; text-align: center; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 14px; transition: 0.3s;"
                        onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#edf2f7'">
                        Batal
                    </a>
                    <button type="button" onclick="confirmUpdate()"
                        style="flex: 2; padding: 14px; background:#dc2626; color: #dc2626; font-weight: 800; color: #1e293b; font-weight:800; border: none; border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 12px rgba(30, 136, 229, 0.3);"
                        onmouseover="this.style.background='#1565c0'; this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.background='#1e88e5'; this.style.transform='translateY(0)'">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Memasukkan Library SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // 1. Alert Validasi Error
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan!',
                text: 'Pastikan semua input data sudah benar.',
                confirmButtonColor: '#1e88e5',
                customClass: {
                    popup: 'rounded-4'
                }
            });
        @endif

        // 2. Fungsi Konfirmasi Sebelum Update
        function confirmUpdate() {
            Swal.fire({
                title: 'Simpan Perubahan?',
                text: "Data summary ini akan diperbarui.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1e88e5',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-4',
                    title: 'text-dark'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    document.getElementById('editForm').submit();
                }
            });
        }
    </script>

    <style>
        textarea:focus,
        select:focus {
            border-color: #3182ce !important;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        }
    </style>
@endsection
