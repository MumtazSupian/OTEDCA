@extends('layouts.app')

@section('content')
    <div style="padding: 40px 20px; display: flex; flex-direction: column; align-items: center; min-height: 100vh;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="font-weight:800; color:#1e293b; font-weight:800; letter-spacing:1px; text-transform:uppercase; margin:0;">
                EDIT TARGET DO BY SOI
            </h2>
            <div style="width: 50px; height: 4px; background: #dc2626; margin: 10px auto; border-radius: 10px;"></div>
            <p style="color: #64748b; font-size: 14px;">Perbarui data target bulanan</p>
        </div>

        <div style="background: white; width: 100%; max-width: 800px; padding: 35px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
            <form id="editSoiForm" action="{{ route('rka.target-do-by-soi.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 10px;">
                    <div>
                        <label style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 13px; text-transform: uppercase;">Source Inquiry</label>
                        <input type="text" value="{{ $data->source_inquiry }}" readonly 
                            style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #a0aec0; background-color: #f7fafc; cursor: not-allowed; font-weight: 600;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 13px; text-transform: uppercase;">Tahun</label>
                        <input type="number" value="{{ $data->tahun }}" readonly 
                            style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #a0aec0; background-color: #f7fafc; cursor: not-allowed; font-weight: 600;">
                    </div>
                </div>

                <div style="margin: 25px 0 15px 0; border-bottom: 2px dashed #edf2f7;"></div>
                <p style="text-align:center; color: #718096; font-size: 12px; margin-bottom: 15px;">
                    Menginput data untuk Cabang: <strong style="color: #2d3748;">{{ Auth::user()->cabang }}</strong>
                </p>

                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                    @foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'] as $m)
                        <div style="background: #f0f9ff; padding: 10px; border-radius: 12px; border: 1px solid #bee3f8;">
                            <label style="display: block; font-weight: 700; color: #2b6cb0; margin-bottom: 5px; font-size: 11px; text-align: center;">{{ strtoupper($m) }}</label>
                            <input type="number" name="{{ $m }}" value="{{ $data->$m }}" min="0" style="width: 100%; padding: 8px; border: 1px solid #90cdf4; border-radius: 8px; font-size: 14px; text-align: center;">
                        </div>
                    @endforeach
                </div>

                <div style="margin-top: 35px; display: flex; gap: 15px;">
                    <a href="{{ route('rka.target-do-by-soi.index') }}" style="flex: 1; padding: 14px; background: #edf2f7; color: #4a5568; text-align: center; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 14px;">Batal</a>
                    <button type="button" onclick="confirmUpdate()" style="flex: 2; padding: 14px; background: #2d3748; color: #1e293b; font-weight:800; border: none; border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">Update Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmUpdate() {
            const form = document.getElementById('editSoiForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            Swal.fire({
                title: 'Update Target?',
                text: "Simpan perubahan data target ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2d3748',
                cancelButtonColor: '#e53e3e',
                confirmButtonText: 'Ya, Update!',
                cancelButtonText: 'Batal'
            }).then((result) => { 
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
@endsection