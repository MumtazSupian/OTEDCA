@extends('layouts.app')

@section('title', 'Edit Actual Salesforces')

@section('content')
    <div style="padding: 40px 20px; display: flex; flex-direction: column; align-items: center; min-height: 100vh;">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="font-weight: 800; color: #1e293b !important; text-transform: uppercase; margin: 0;">
                ✏️ EDIT ACTUAL SALESFORCES
            </h2>
            <div style="width: 50px; height: 4px; background: #dc2626; margin: 10px auto; border-radius: 10px;"></div>
            <p style="color: #64748b; font-size: 14px;">Perbarui data aktual untuk grading <strong style="color: #ffffff !important; font-weight: 800;">{{ $actualSalesforce->grading }}</strong></p>
        </div>

        <div style="background: white; width: 100%; box-sizing: border-box; max-width: 800px; padding: 35px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
            <form id="editForm" action="{{ route('current.actual-salesforces.update', $actualSalesforce->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-weight: 700; color: #a0aec0; margin-bottom: 8px; font-size: 12px; text-transform: uppercase;">Grading Sales</label>
                        <input type="text" value="{{ $actualSalesforce->grading }}" disabled 
                            style="width: 100%; box-sizing: border-box; padding: 12px; background: #edf2f7; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #718096; cursor: not-allowed; font-weight: bold;">
                        <input type="hidden" name="grading" value="{{ $actualSalesforce->grading }}">
                    </div>

                    <div>
                        <label style="display: block; font-weight: 700; color: #a0aec0; margin-bottom: 8px; font-size: 12px; text-transform: uppercase;">Tahun</label>
                        <input type="text" value="{{ $actualSalesforce->tahun }}" disabled 
                            style="width: 100%; box-sizing: border-box; padding: 12px; background: #edf2f7; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #718096; cursor: not-allowed; font-weight: bold;">
                        <input type="hidden" name="tahun" value="{{ $actualSalesforce->tahun }}">
                    </div>
                </div>

                <div style="margin: 25px 0; border-bottom: 2px dashed #edf2f7;"></div>
                
                <p style="text-align:center; color: #718096; font-size: 13px; margin-bottom: 10px;">
                    Mengupdate data untuk Cabang: <strong style="color: #2d3748;">{{ $actualSalesforce->cabang }}</strong>
                </p>

                <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  grid-template-columns: repeat(4, 1fr); gap: 15px;">
                    @php
                        $months = [
                            'jan' => 'JAN', 'feb' => 'FEB', 'mar' => 'MAR', 'apr' => 'APR',
                            'mei' => 'MEI', 'jun' => 'JUN', 'jul' => 'JUL', 'agu' => 'AGU',
                            'sep' => 'SEP', 'okt' => 'OKT', 'nov' => 'NOV', 'des' => 'DES'
                        ];
                    @endphp

                    @foreach($months as $key => $label)
                        <div style="background: #f7fafc; padding: 10px; border-radius: 12px; border: 1px solid #e2e8f0; text-align: center;">
                            <label style="display: block; font-weight: 700; color: #dc2626; margin-bottom: 8px; font-size: 13px;">{{ $label }}</label>
                            <input type="number" name="{{ $key }}" value="{{ $actualSalesforce->$key }}" min="0" 
                                style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #cbd5e0; border-radius: 8px; font-size: 14px; text-align: center; color: #2d3748; background: white; outline: none;">
                        </div>
                    @endforeach
                </div>

                <div style="margin-top: 35px; display: flex; gap: 15px;">
                    <a href="{{ route('current.actual-salesforces.index') }}"
                        style="flex: 1; padding: 14px; background: #edf2f7; color: #4a5568; text-align: center; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 14px; transition: 0.3s;">
                        Batal
                    </a>
                    <button type="button" onclick="confirmUpdate()"
                        style="flex: 2; padding: 14px; background: #2d3748; color: #ffffff !important; font-weight: 800; border: none; border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
                        Update Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SweetAlert2 Library --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmUpdate() {
            Swal.fire({
                title: 'Update Data?',
                text: "Simpan perubahan angka aktual ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2d3748',
                cancelButtonColor: '#e53e3e',
                confirmButtonText: 'Ya, Update!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: { popup: 'rounded-4' }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memperbarui...',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                    document.getElementById('editForm').submit();
                }
            });
        }
    </script>
@endsection