@extends('layouts.app')

@section('title', 'Tambah Actual Source DO Inquiry')

@section('content')
<div style="padding: 40px 20px; display: flex; flex-direction: column; align-items: center; min-height: 100vh;">
    
    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="font-weight: 800; color: #1e293b !important; text-transform: uppercase; margin: 0;">
            TAMBAH ACTUAL SOURCE DO INQUIRY
        </h2>
        <div style="width: 50px; height: 4px; background: #dc2626; margin: 10px auto; border-radius: 10px;"></div>
        <p style="color: #64748b; font-size: 14px;">Input data aktual delivery order berdasarkan sumber inquiry</p>
    </div>

    <div style="background: white; width: 100%; box-sizing: border-box; max-width: 800px; padding: 35px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
        
        <form id="actualSourceForm" action="{{ route('current.actual-source-do-inquary.store') }}" method="POST">
            @csrf
            
            @if(session('error'))
                <div style="background: #fed7d7; color: #c53030; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-size: 14px;">
                    {{ session('error') }}
                </div>
            @endif

            <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 12px; text-transform: uppercase;">Source Inquiry</label>
                    <select name="source_inquary" required style="width: 100%; box-sizing: border-box; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #4a5568; outline: none;">
                        <option value="" disabled selected>Pilih Source</option>
                        @foreach (['Call In (dari Iklan)', 'Canvasing', 'Data Base', 'Digital Hyperlocal', 'Digital Non Hyperlocal', 'Exhibition', 'Media Digital', 'Media Elektronik', 'Mediator', 'Referensi', 'Referensi Customer', 'Showroom Activity', 'Showroom Walk-in', 'Website Dealer'] as $src)
                            <option value="{{ $src }}">{{ $src }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 12px; text-transform: uppercase;">Tahun</label>
                    <input type="number" name="tahun" value="{{ date('Y') }}" required 
                        style="width: 100%; box-sizing: border-box; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #4a5568; outline: none;">
                </div>
            </div>

            <div style="margin: 25px 0; border-bottom: 2px dashed #edf2f7;"></div>
            
            <p style="text-align:center; color: #718096; font-size: 13px; margin-bottom: 15px;">
                Menginput data untuk Cabang: <strong style="color: #2d3748;">{{ Auth::user()->cabang ?: (Auth::user()->name ?: "Pusat") }}</strong>
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
                    <div style="background: #f0f9ff; padding: 10px; border-radius: 12px; border: 1px solid #bee3f8; text-align: center;">
                        <label style="display: block; font-weight: 700; color: #2b6cb0; margin-bottom: 8px; font-size: 13px;">{{ $label }}</label>
                        <input type="number" name="{{ $key }}" min="0" value="0" 
                            style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #90cdf4; border-radius: 8px; font-size: 14px; text-align: center; color: #2d3748; outline: none;">
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 35px; display: flex; gap: 15px;">
                <a href="{{ route('current.actual-source-do-inquary.index') }}"
                    style="flex: 1; padding: 14px; background: #edf2f7; color: #4a5568; text-align: center; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 14px; transition: 0.3s;">
                    Batal
                </a>
                <button <button type="submit"
                    style="flex: 2; padding: 14px; background: #1a202c; color: #ffffff !important; font-weight: 800; border: none; border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.2); transition: 0.3s; background: #dc2626; color: #ffffff !important; font-weight: 800;">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('actualSourceForm').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Simpan Data?',
            text: "Pastikan data source inquiry dan angka per bulan sudah benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1a202c',
            cancelButtonColor: '#edf2f7',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Cek Kembali',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>
@endsection