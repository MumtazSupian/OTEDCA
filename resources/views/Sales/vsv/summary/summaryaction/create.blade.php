@extends('layouts.app')

@section('title', 'Tambah Action Perbaikan')

@section('content')
    <div style="padding: 40px 20px; display: flex; flex-direction: column; align-items: center; min-height: 100vh;">

        {{-- HEADER --}}
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="font-weight:800; color:#1e293b; font-weight:800; letter-spacing:1px; text-transform:uppercase; margin:0;">
                ➕ TAMBAH ACTION PLAN PERBAIKAN
            </h2>
            <div style="width: 50px; height: 4px; background: #dc2626; margin: 10px auto; border-radius: 10px;"></div>
            <p style="color: #64748b; font-size: 14px;">Input data kondisi saat ini dan rencana tindakan perbaikan
                operasional</p>
            <p style="text-align:center; color: #718096; font-size: 12px; margin-bottom: 15px;">
                Menginput data untuk Cabang: <strong style="color: #2d3748;">{{ Auth::user()->cabang }}</strong>
            </p>
        </div>
        {{-- CARD FORM --}}
        <div
            style="background: white; width: 100%; max-width: 750px; padding: 35px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">

            <form id="createActionForm" action="{{ route('summary.summaryaction.store') }}" method="POST">
                @csrf

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                    {{-- Operasional --}}
                    <div>

                        <label
                            style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 13px; text-transform: uppercase;">
                            Kategori Operasional
                        </label>
                        <select name="operasional" required
                            style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #4a5568; outline: none; transition: 0.3s; cursor: pointer;">
                            <option value="">-- Pilih Operasional --</option>
                            <option value="Jumlah Sales Force by Grading">Jumlah Sales Force by Grading</option>
                            <option value="Jumlah Inquiry by Type">Jumlah Inquiry by Type</option>
                            <option value="Jumlah Activity by Type">Jumlah Activity by Type</option>
                            <option value="Source Of Inquiry">Source Of Inquiry</option>
                            <option value="Issue">Issue</option>
                            <option value="Usulan">Usulan</option>
                        </select>
                    </div>

                    {{-- Do / Don't --}}
                    <div>
                        <label
                            style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 13px; text-transform: uppercase;">
                            Status (Do / Don't)
                        </label>
                        <select name="do_dont"
                            style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #4a5568; outline: none; transition: 0.3s; cursor: pointer;">
                            <option value="">-- Pilih Status --</option>
                            <option value="V">✔ Do</option>
                            <option value="X">✖ Don't</option>
                        </select>
                    </div>
                </div>

                {{-- Kondisi Yang Ada --}}
                <div style="margin-bottom: 20px;">
                    <label
                        style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 13px; text-transform: uppercase;">
                        📌 Kondisi Yang Ada
                    </label>
                    <textarea name="kondisi_yang_ada" rows="4"
                        style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #4a5568; outline: none; transition: 0.3s; resize: none;"
                        placeholder="Tuliskan kondisi yang ada saat ini..."></textarea>
                </div>

                {{-- Action Perbaikan --}}
                <div style="margin-bottom: 10px;">
                    <label
                        style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 13px; text-transform: uppercase;">
                        🛠️ Action Perbaikan
                    </label>
                    <textarea name="action_perbaikan" rows="4"
                        style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #4a5568; outline: none; transition: 0.3s; resize: none;"
                        placeholder="Tuliskan tindakan perbaikan yang diusulkan..."></textarea>
                </div>

                {{-- Form Actions --}}
                <div style="margin-top: 35px; display: flex; gap: 15px;">
                    <a href="{{ route('summary.summaryaction.index') }}"
                        style="flex: 1; padding: 14px; background: #edf2f7; color: #4a5568; text-align: center; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 14px; transition: 0.3s;"
                        onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#edf2f7'">
                        Batal
                    </a>
                    <button type="submit"
                        style="flex: 2; padding: 14px; background:#dc2626; color:#ffffff; color: #1e293b; font-weight:800; border: none; border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 12px rgba(30, 136, 229, 0.3);"
                        onmouseover="this.style.background='#1565c0'; this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.background='#1e88e5'; this.style.transform='translateY(0)'">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Library SweetAlert2 untuk validasi error (jika ada) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan!',
                text: 'Pastikan semua field telah diisi dengan benar.',
                confirmButtonColor: '#1e88e5',
                customClass: {
                    popup: 'rounded-4'
                }
            });
        @endif
    </script>

    <style>
        textarea:focus,
        select:focus {
            border-color: #3182ce !important;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        }
    </style>
@endsection
