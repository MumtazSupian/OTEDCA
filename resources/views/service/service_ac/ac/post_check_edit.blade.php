@extends('layouts.app')

@section('content')
<style>
    /* Form Styles copied from post_check */
    .form-section {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-size: 11px;
        color: #555;
        font-weight: 600;
    }
    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 12px;
        background: white;
    }
    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
    }
    .form-col {
        flex: 1;
    }
    .section-title {
        color: #1565c0;
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 15px;
        border-left: 4px solid #1565c0;
        padding-left: 10px;
    }
    
    .photo-grid {
        display: flex; 
        flex-wrap: wrap; 
        gap: 15px; 
        margin-bottom: 20px;
    }
    .photo-box {
        border: 1px dashed #ccc; 
        padding: 10px; 
        border-radius: 8px; 
        width: 180px; 
        text-align: center; 
        position: relative;
        background: white;
    }
    .photo-box img {
        width: 100%; 
        height: 100px; 
        object-fit: contain; 
        margin-bottom: 10px;
    }
    .btn-delete-photo {
        position: absolute; 
        top: -8px; 
        right: -8px; 
        background: #f44336; 
        color: white; 
        border-radius: 50%; 
        width: 20px; 
        height: 20px; 
        line-height: 20px; 
        text-align: center; 
        font-size: 10px; 
        cursor: pointer;
        border: none;
    }
</style>

<div style="margin: -20px; margin-bottom: 20px;">
    <div style="background: white; padding: 15px 20px; border-bottom: 1px solid #eee;">
        <h3 style="margin: 0; color: #1565c0;"><i class="fas fa-edit"></i> Edit Data Pemeriksaan</h3>
    </div>
</div>

@if ($errors->any())
<div style="background: #f8d7da; color: #721c24; padding: 10px 15px; border-radius: 4px; margin-bottom: 20px; max-width: 900px; margin-left: auto; margin-right: auto;">
    <strong>Gagal menyimpan data!</strong>
    <ul style="margin: 5px 0 0 15px; padding: 0;">
        @foreach ($errors->all() as $error)
            <li style="font-size: 12px;">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('service.service-ac.ac.post_check_update', $data->id) }}" method="POST" enctype="multipart/form-data" class="form-section">
    @csrf
    @method('PUT')
    
    <div class="form-row">
        <div class="form-col">
            <div class="form-group">
                <label>Jenis Pemeriksaan</label>
                <select name="jenis_pemeriksaan" class="form-control">
                    <option value="POST CHECK" {{ $data->jenis_pemeriksaan == 'POST CHECK' ? 'selected' : '' }}>POST CHECK</option>
                </select>
            </div>
        </div>
        <div class="form-col">
            <div class="form-group">
                <label>No Polisi:</label>
                <input type="text" name="no_polisi" value="{{ $data->no_polisi }}" class="form-control">
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-col">
            <div class="form-group">
                <label>Cabang</label>
                <select id="cabang_select" name="cabang" class="form-control" onchange="updateDropdowns()">
                    <option value="">-- Pilih Cabang --</option>
                    @foreach($cabangs ?? ['CIAWI', 'CIANJUR', 'CINERE', 'JATIASIH'] as $cab)
                    <option value="{{ $cab }}" {{ $data->cabang == $cab ? 'selected' : '' }}>{{ $cab }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-col">
            <div class="form-group">
                <label>Teknisi Pemeriksa</label>
                <select id="teknisi_select" name="teknisi" class="form-control">
                    <option value="">-- Pilih Teknisi --</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-col">
            <div class="form-group" id="sa_group" style="display: block;">
                <label>Service Advisor (SA):</label>
                <select id="sa_select" name="sa" class="form-control">
                    <option value="">-- Pilih SA --</option>
                </select>
            </div>
        </div>
        <div class="form-col">
            <div class="form-group">
                <label>Hari, Tanggal:</label>
                <input type="date" name="tanggal" value="{{ $data->tanggal }}" class="form-control">
            </div>
        </div>
    </div>

    <div class="form-group" style="margin-bottom: 30px;">
        <label>Tipe Kendaraan:</label>
        <input type="text" name="tipe_kendaraan" value="{{ $data->tipe_kendaraan }}" class="form-control">
    </div>



    <!-- Form Post Check -->
    <div class="section-title" style="margin-top: 30px;">Form Post Check</div>
    <div class="form-row">
        <div class="form-col">
            <div class="form-group">
                <label>High Pressure</label>
                <input type="text" name="post_high_pressure" value="{{ $data->post_high_pressure }}" class="form-control">
            </div>
        </div>
        <div class="form-col">
            <div class="form-group">
                <label>Low Pressure</label>
                <input type="text" name="post_low_pressure" value="{{ $data->post_low_pressure }}" class="form-control">
            </div>
        </div>
        <div class="form-col">
            <div class="form-group">
                <label>Suhu Outlet</label>
                <input type="text" name="post_suhu_outlet" value="{{ $data->post_suhu_outlet }}" class="form-control">
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-col" style="max-width: 33.33%;">
            <div class="form-group">
                <label>Wind Speed:</label>
                <input type="text" name="post_wind_speed" value="{{ $data->post_wind_speed }}" class="form-control">
            </div>
        </div>
    </div>

    <!-- Tambahan Pemeriksaan -->
    <div class="section-title" style="margin-top: 30px;">Tambahan Pemeriksaan</div>
    <div class="form-group">
        <textarea name="catatan_tambahan" class="form-control" rows="3">{{ $data->catatan_tambahan }}</textarea>
    </div>

    <!-- Hasil Pekerjaan -->
    <div class="section-title" style="margin-top: 30px;">Hasil Pekerjaan</div>
    <div class="form-row">
        <div class="form-col">
            <div class="form-group">
                <label>Perawatan:</label>
                <select name="perawatan" class="form-control">
                    <option value="">-- Pilih Perawatan --</option>
                    @foreach($perawatans ?? ['Perawatan Ringan', 'Perawatan Sedang', 'Perawatan Berat', 'Tidak Ada Perawatan'] as $per)
                    <option value="{{ $per }}" {{ $data->perawatan == $per ? 'selected' : '' }}>{{ $per }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-col">
            <div class="form-group">
                <label>Penggantian:</label>
                <input type="text" name="penggantian" value="{{ $data->penggantian }}" class="form-control">
            </div>
        </div>
    </div>

    <!-- Upload Foto Kendaraan -->
    <div class="section-title" style="margin-top: 30px;">Upload Foto Kendaraan</div>
    <div class="form-group">
        
        <div class="photo-grid">
            @php
                $existingFotos = $data->foto_kendaraan ? json_decode($data->foto_kendaraan, true) : [];
                if (!is_array($existingFotos)) {
                    // For backwards compatibility with old single strings
                    $existingFotos = $data->foto_kendaraan ? [['path' => $data->foto_kendaraan, 'keterangan' => $data->keterangan_foto]] : [];
                }
            @endphp
            
            @foreach($existingFotos as $index => $foto)
            <div class="photo-box">
                <button type="button" class="btn-delete-photo" onclick="this.parentElement.remove();"><i class="fas fa-times">X</i></button>
                <img src="{{ asset(str_replace('public/', 'storage/', $foto['path'] ?? '')) }}" alt="Foto">
                <input type="text" name="existing_foto_keterangan[{{ $index }}]" value="{{ $foto['keterangan'] ?? 'KETERANGAN FOTO' }}" class="form-control" style="font-size: 10px; text-align: left;">
                <!-- Hidden input to keep track of this existing photo -->
                <input type="hidden" name="keep_foto[]" value="{{ $index }}">
            </div>
            @endforeach
        </div>

        <div id="photo-upload-container">
            <div class="photo-upload-row" style="border: 1px dashed #ccc; padding: 15px; border-radius: 8px; width: 250px; background: #fafafa; margin-top: 20px; margin-bottom: 15px;">
                <label style="color: #1565c0; font-size: 12px; margin-bottom: 10px; display: block;">Upload Foto Baru:</label>
                <input type="file" name="foto_kendaraan[]" class="form-control" style="border: 1px solid #ccc; padding: 5px; margin-bottom: 10px; background: white;">
                <input type="text" name="keterangan_foto[]" class="form-control" placeholder="KETERANGAN FOTO" style="border: 1px solid #ccc; padding: 8px; margin-bottom: 10px;">
                <p style="font-size: 11px; color: #d32f2f; margin: 0;">Maksimal 8MB (Semua jenis gambar)</p>
            </div>
        </div>
        
        <button type="button" id="btn-tambah-foto-edit" style="background: white; color: #1565c0; border: 1px solid #1565c0; border-radius: 4px; padding: 6px 15px; font-size: 11px; cursor: pointer; font-weight: 600;">+ Tambah Foto</button>

        <script>
            document.getElementById('btn-tambah-foto-edit').addEventListener('click', function() {
                const container = document.getElementById('photo-upload-container');
                const row = document.createElement('div');
                row.className = 'photo-upload-row';
                row.style = 'border: 1px dashed #ccc; padding: 15px; border-radius: 8px; width: 250px; background: #fafafa; margin-bottom: 15px; position: relative;';
                
                row.innerHTML = `
                    <button type="button" class="btn-remove-row" style="position: absolute; right: 10px; top: 10px; background: #f44336; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 10px; line-height: 1;">X</button>
                    <input type="file" name="foto_kendaraan[]" class="form-control" style="border: 1px solid #ccc; padding: 5px; margin-bottom: 10px; background: white;">
                    <input type="text" name="keterangan_foto[]" class="form-control" placeholder="KETERANGAN FOTO" style="border: 1px solid #ccc; padding: 8px; margin-bottom: 10px;">
                `;
                
                row.querySelector('.btn-remove-row').addEventListener('click', function() {
                    row.remove();
                });
                
                container.appendChild(row);
            });
        </script>
    </div>

    <div style="text-align: center; margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px;">
        <button type="submit" style="background: #1565c0; color: white; padding: 12px 40px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 14px;">SIMPAN PERUBAHAN</button>
        <a href="{{ route('service.service-ac.ac.post_check', ['tab' => 'list']) }}" style="display: inline-block; padding: 12px 40px; background: #eee; text-decoration: none; color: #333; border-radius: 6px; margin-left: 10px; font-weight: 600; font-size: 14px;">BATAL</a>
    </div>
</form>

<script>
const saData = @json($sas ?? []);
const teknisiData = @json($teknisis ?? []);
const currentCabang = "{{ $data->cabang }}";
const currentSa = "{{ $data->sa }}";
const currentTeknisi = "{{ $data->teknisi }}";

function updateDropdowns(initialLoad = false) {
    const cabang = document.getElementById('cabang_select').value;
    const saSelect = document.getElementById('sa_select');
    const teknisiSelect = document.getElementById('teknisi_select');
    
    saSelect.innerHTML = '<option value="">-- Pilih SA --</option>';
    teknisiSelect.innerHTML = '<option value="">-- Pilih Teknisi --</option>';
    
    if (cabang) {
        if (saData[cabang]) {
            saData[cabang].forEach(function(sa) {
                const option = document.createElement('option');
                option.value = sa;
                option.textContent = sa;
                if (initialLoad && sa === currentSa) {
                    option.selected = true;
                }
                saSelect.appendChild(option);
            });
        }
        
        if (teknisiData[cabang]) {
            teknisiData[cabang].forEach(function(teknisi) {
                const option = document.createElement('option');
                option.value = teknisi;
                option.textContent = teknisi;
                if (initialLoad && teknisi === currentTeknisi) {
                    option.selected = true;
                }
                teknisiSelect.appendChild(option);
            });
        }
    }
}

// Run on initial load to populate SA & Teknisi if Cabang is already selected
document.addEventListener('DOMContentLoaded', function() {
    updateDropdowns(true);
});
</script>
@endsection
