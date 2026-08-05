@extends('layouts.app')

@section('title', 'Edit Evaluasi Wiraniaga')

@section('content')
    <div style="padding: 40px 20px; min-height: 100vh;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="font-weight:800; color:#1e293b; font-weight:800; letter-spacing:1px; text-transform:uppercase; margin-bottom:5px;">
                ✏️ EDIT DATA EVALUASI
            </h2>
            <p style="color: #64748b;">Perbarui informasi kinerja untuk <strong>{{ $row->nama_sales }}</strong></p>
            <p style="text-align:center; color: #718096; font-size: 12px; margin-bottom: 15px;">
                Menginput data untuk Cabang: <strong style="color: #2d3748;">{{ Auth::user()->cabang }}</strong>
            </p>
        </div>

        <div style="background:#fff; max-width: 900px; margin: 0 auto; padding:30px; border-radius:14px; box-shadow:0 10px 30px rgba(0,0,0,0.2);">

            <form method="POST" action="{{ route('evaluasi.update', $row->id) }}">
                @csrf
                @method('PUT')

                <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                    <div>
                        <label style="display:block; font-weight:700; color:#333; margin-bottom:8px; font-size:13px;">SALES HEAD</label>
                        <input type="text" name="nama_sales_head" required value="{{ $row->nama_sales_head }}"
                            style="width:100%; box-sizing: border-box; padding:10px; border:1px solid #ccc; border-radius:6px; outline:none;"
                            placeholder="Nama Sales Head...">
                    </div>

                    <div>
                        <label style="display:block; font-weight:700; color:#333; margin-bottom:8px; font-size:13px;">NAMA SALES</label>
                        <input type="text" name="nama_sales" required value="{{ $row->nama_sales }}"
                            style="width:100%; box-sizing: border-box; padding:10px; border:1px solid #ccc; border-radius:6px; outline:none;"
                            placeholder="Nama Sales...">
                    </div>

                    <div>
                        <label style="display:block; font-weight:700; color:#333; margin-bottom:8px; font-size:13px;">TANGGAL MASUK</label>
                        <input type="date" name="tanggal_masuk" required value="{{ $row->tanggal_masuk }}"
                            style="width:100%; box-sizing: border-box; padding:10px; border:1px solid #ccc; border-radius:6px; outline:none;">
                    </div>

                    <div>
                        <label style="display:block; font-weight:700; color:#333; margin-bottom:8px; font-size:13px;">TANGGAL EVALUASI</label>
                        <input type="date" name="tanggal_evaluasi" required value="{{ $row->tanggal_evaluasi }}"
                            style="width:100%; box-sizing: border-box; padding:10px; border:1px solid #ccc; border-radius:6px; outline:none;">
                    </div>

                    {{-- BAGIAN GRADING OTOMATIS --}}
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:700; color:#333; margin-bottom:8px; font-size:13px;">
                            GRADING PERFORMA (Otomatis)
                        </label>
                        <input type="text" id="grading_display" name="grading" readonly
                            style="width:100%; box-sizing: border-box; padding:15px; border:none; border-radius:8px; font-weight: 800; text-align: center; text-transform: uppercase; font-size: 16px; transition: all 0.3s ease;"
                            value="{{ $row->grading }}">
                        <small style="color: #666; font-style: italic; display: block; margin-top: 5px;">
                            *Peringkat dihitung berdasarkan performa 3 bulan awal atau kenaikan di 3 bulan terakhir.
                        </small>
                    </div>
                </div>

                <hr style="border:0; border-top:1px solid #eee; margin:30px 0;">

                <h3 style="font-size:15px; font-weight:800; color:#991b1b; margin-bottom:20px; display:flex; align-items:center; gap:8px;">
                    📊 PERBARUI NILAI BULANAN
                </h3>

                <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  grid-template-columns: repeat(6, 1fr); gap: 10px; margin-bottom: 30px;">
                    @foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun'] as $m)
                        <div style="text-align: center;">
                            <label style="display:block; font-weight:700; color:#555; margin-bottom:5px; font-size:11px;">{{ strtoupper($m) }}</label>
                            <input type="number" name="{{ $m }}" value="{{ $row->$m }}" min="0"
                                class="input-bulan"
                                style="width:100%; box-sizing: border-box; padding:8px; border:1px solid #ddd; border-radius:6px; text-align:center; font-weight:600; color:#991b1b;">
                        </div>
                    @endforeach
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display:block; font-weight:700; color:#333; margin-bottom:8px; font-size:13px;">HASIL EVALUASI</label>
                    <textarea name="evaluasi" rows="3" placeholder="Tulis catatan evaluasi..."
                        style="width:100%; box-sizing: border-box; padding:10px; border:1px solid #ccc; border-radius:6px; outline:none; resize: none;">{{ $row->evaluasi }}</textarea>
                </div>

                <div style="margin-bottom: 35px; width: 50%;">
                    <label style="display:block; font-weight:700; color:#333; margin-bottom:8px; font-size:13px;">TANGGAL KELUAR</label>
                    <input type="date" name="tanggal_keluar" value="{{ $row->tanggal_keluar }}"
                        style="width:100%; box-sizing: border-box; padding:10px; border:1px solid #ccc; border-radius:6px; outline:none;">
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #eee; padding-top: 20px;">
                    <a href="{{ route('evaluasi.index') }}" style="text-decoration:none; color:#666; font-weight:600; font-size:14px;">← Batal</a>
                    <button type="submit" style="background:#fb8c00; color:#1e293b; font-weight:800; border:none; padding:12px 35px; border-radius:8px; font-weight:700; cursor:pointer; font-size:14px; transition:0.3s; box-shadow:0 4px 10px rgba(251,140,0,0.3);">
                        💾 SIMPAN PERUBAHAN
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT PERHITUNGAN DINAMIS --}}
    <script>
        document.querySelectorAll('.input-bulan').forEach(input => {
            input.addEventListener('input', updateGrading);
        });

        window.onload = updateGrading;

        function updateGrading() {
            const months = [
                parseFloat(document.querySelector('input[name="jan"]').value) || 0,
                parseFloat(document.querySelector('input[name="feb"]').value) || 0,
                parseFloat(document.querySelector('input[name="mar"]').value) || 0,
                parseFloat(document.querySelector('input[name="apr"]').value) || 0,
                parseFloat(document.querySelector('input[name="mei"]').value) || 0,
                parseFloat(document.querySelector('input[name="jun"]').value) || 0
            ];

            const total6Bulan = months.reduce((a, b) => a + b, 0);

            // 1. CARI INDEX BULAN PERTAMA AKTIF
            let firstIdx = months.findIndex(val => val > 0);
            if (firstIdx === -1) firstIdx = 0;

            // 2. LOGIKA WINDOW 3 BULAN AWAL
            const data3Awal = months.slice(firstIdx, firstIdx + 3);
            const total3Awal = data3Awal.reduce((a, b) => a + b, 0);
            const avg3Awal = total3Awal / data3Awal.length;

            // 3. LOGIKA 3 BULAN TERAKHIR (APR-JUN) - UNTUK MENDETEKSI KENAIKAN SAAT EDIT
            const data3Akhir = months.slice(3, 6);
            const total3Akhir = data3Akhir.reduce((a, b) => a + b, 0);
            const avg3Akhir = total3Akhir / 3;

            // Rata-rata 6 bulan (sejak aktif)
            const avg6 = total6Bulan / (6 - firstIdx);

            let gradeText = "TRAINEE -> EVALUASI";
            let bgColor = "#f44336"; // Merah

            // 4. HIERARKI PENENTUAN GRADING (Sinkron dengan Controller)
            if (avg6 >= 5 && total6Bulan >= 31) {
                gradeText = "PLATINUM";
                bgColor = "#1a237e";
            } else if (avg6 >= 4 && total6Bulan >= 25) {
                gradeText = "GOLD -> KADAR PLATINUM";
                bgColor = "#ff9800";
            }
            // KUNCI PERBAIKAN: Cek rata-rata awal >= 2 ATAU rata-rata 3 bulan terakhir >= 2
            else if (avg3Awal >= 2 || total3Awal >= 7 || avg3Akhir >= 2 || total3Akhir >= 6) {
                gradeText = "SILVER -> KADAR GOLD";
                bgColor = "#78909c";
            }
            else if (avg3Awal >= 1) {
                gradeText = "TRAINEE -> KADAR SILVER";
                bgColor = "#4caf50";
            }

            // 5. UPDATE TAMPILAN
            const display = document.getElementById('grading_display');
            if (display) {
                display.value = gradeText;
                display.style.backgroundColor = bgColor;
                display.style.color = "#ffffff";
            }
        }
    </script>
@endsection
