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


        /* Modal & Input Icon Styles */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1050;
        }
        .modal-box {
            background: white;
            width: 90%;
            max-width: 600px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .modal-header {
            padding: 15px 20px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
        }
        .modal-close {
            cursor: pointer;
            font-size: 22px;
            color: #adb5bd;
            background: none;
            border: none;
            line-height: 1;
        }
        .modal-close:hover {
            color: #dc3545;
        }
        .modal-body {
            padding: 20px;
            max-height: 70vh;
            overflow-y: auto;
        }
        .input-with-icon {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }
        .input-with-icon input {
            width: 100%;
            padding-right: 40px !important;
        }
        .input-with-icon i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #1976d2;
            cursor: pointer;
            font-size: 15px;
            transition: color 0.2s, transform 0.2s;
        }
        .input-with-icon i:hover {
            color: #0d47a1;
            transform: translateY(-50%) scale(1.15);
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
            <!-- Left Column -->
            <div class="form-col">
                <div class="form-group">
                    <label>Jenis Pemeriksaan</label>
                    <select name="jenis_pemeriksaan" class="form-control">
                        <option value="POST CHECK" {{ $data->jenis_pemeriksaan == 'POST CHECK' ? 'selected' : '' }}>POST CHECK</option>
                        <option value="PRE CHECK" {{ $data->jenis_pemeriksaan == 'PRE CHECK' ? 'selected' : '' }}>PRE CHECK</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>No SPK:</label>
                    <div class="input-with-icon">
                        <input type="text" id="no_spk" name="no_spk" class="form-control" placeholder="Masukkan No SPK" onchange="fetchSpkData()" value="{{ $data->no_spk }}">
                        <i class="fas fa-search" onclick="openSpkModal()" title="Cari SPK Bulan Ini"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label>Cabang</label>
                    <input type="text" id="cabang" name="cabang" class="form-control" readonly style="background-color: #e9ecef; cursor: not-allowed;" value="{{ $data->cabang }}">
                </div>
                <div class="form-group">
                    <label>Service Advisor (SA):</label>
                    <input type="text" id="sa" name="sa" class="form-control" readonly style="background-color: #e9ecef; cursor: not-allowed;" value="{{ $data->sa }}">
                </div>
            </div>

            <!-- Right Column -->
            <div class="form-col">
                <div class="form-group">
                    <label>No Polisi:</label>
                    <input type="text" id="no_polisi" name="no_polisi" class="form-control" readonly style="background-color: #e9ecef; cursor: not-allowed;" value="{{ $data->no_polisi }}">
                </div>
                <div class="form-group">
                    <label>Tipe Kendaraan:</label>
                    <input type="text" id="tipe_kendaraan" name="tipe_kendaraan" class="form-control" readonly style="background-color: #e9ecef; cursor: not-allowed;" value="{{ $data->tipe_kendaraan }}">
                </div>
                <div class="form-group">
                    <label>Teknisi Pemeriksa</label>
                    <select name="teknisi" id="teknisi" class="form-control">
                        <option value="">-- Pilih Teknisi --</option>
                        @foreach($teknisis as $tek)
                            @php $tekName = is_object($tek) ? $tek->nama : $tek; @endphp
                            <option value="{{ $tekName }}" {{ (old('teknisi', $data->teknisi) == $tekName) ? 'selected' : '' }}>{{ $tekName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Hari, Tanggal:</label>
                    <input type="date" id="tanggal" name="tanggal" class="form-control" readonly style="background-color: #e9ecef; cursor: not-allowed;" value="{{ $data->tanggal ? date('Y-m-d', strtotime($data->tanggal)) : '' }}">
                </div>
            </div>
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
                    @foreach($perawatans as $per)
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


<!-- Modal SPK -->
<div class="modal-overlay" id="spkModal">
    <div class="modal-box" style="max-width: 600px;">
        <div class="modal-header">
            <h4 style="margin:0; font-size:16px; font-weight:700; color:#2c3e50;"><i class="fas fa-file-invoice" style="color:#1976d2; margin-right:8px;"></i> Pilih No SPK (Bulan Ini)</h4>
            <button type="button" class="modal-close" onclick="closeSpkModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div style="margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; gap: 10px;">
                <div>
                    <label style="font-size:12px; font-weight:normal; color:#555;">Show 
                        <select id="spkLimit" onchange="renderSpkTable()" style="padding:4px 8px; border-radius:6px; border:1px solid #ced4da; font-size:12px;">
                            <option value="10">10</option><option value="25">25</option><option value="50">50</option>
                        </select> entries
                    </label>
                </div>
                <div>
                    <input type="text" id="spkSearch" class="form-control" style="display:inline-block; width:180px; padding:6px 12px; font-size:12px; border-radius:6px;" onkeyup="renderSpkTable()" placeholder="Cari No SPK...">
                </div>
            </div>
            <table style="width: 100%; border-collapse: collapse; font-size:13px;">
                <thead>
                    <tr style="border-bottom: 2px solid #e9ecef; background:#f8f9fa;">
                        <th style="padding: 12px 15px; text-align: left; color:#495057; font-weight:700;">No SPK</th>
                        <th style="padding: 12px 15px; text-align: center; width: 120px; color:#495057; font-weight:700;">Action</th>
                    </tr>
                </thead>
                <tbody id="spkTableBody">
                    <tr><td colspan="2" style="text-align: center; padding: 25px; color:#6c757d;">Memuat data dari server...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
let spkDataList = [];

function openSpkModal() {
    document.getElementById('spkModal').style.display = 'flex';
    document.getElementById('spkTableBody').innerHTML = '<tr><td colspan="2" style="text-align: center; padding: 25px; color:#6c757d;">Memuat data dari server...</td></tr>';
    
    fetch("{{ route('service.service-ac.ac.post_check_get_spk_list') }}")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                spkDataList = data.data;
                renderSpkTable();
            } else {
                document.getElementById('spkTableBody').innerHTML = '<tr><td colspan="2" style="text-align: center; padding: 25px; color: #dc3545;">' + data.message + '</td></tr>';
            }
        })
        .catch(error => {
            document.getElementById('spkTableBody').innerHTML = '<tr><td colspan="2" style="text-align: center; padding: 25px; color: #dc3545;">Terjadi kesalahan koneksi ke server</td></tr>';
        });
}

function closeSpkModal() {
    document.getElementById('spkModal').style.display = 'none';
}

function renderSpkTable() {
    let search = document.getElementById('spkSearch').value.toLowerCase();
    let limit = parseInt(document.getElementById('spkLimit').value);
    
    let filtered = spkDataList.filter(item => {
        return item.JobOrderNo && item.JobOrderNo.toLowerCase().includes(search);
    });
    
    let html = '';
    if (filtered.length === 0) {
        html = '<tr><td colspan="2" style="text-align: center; padding: 25px; color:#dc3545; font-size:12px;">Data SPK tidak ditemukan</td></tr>';
    } else {
        let count = 0;
        for (let item of filtered) {
            if (count >= limit) break;
            html += `
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 12px 15px; font-weight:600; color:#2c3e50;">${item.JobOrderNo}</td>
                    <td style="padding: 12px 15px; text-align: center;">
                        <button type="button" style="background: #1976d2; color: white; border: none; padding: 6px 18px; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 700; transition: all 0.2s;" onclick="pilihSpk('${item.JobOrderNo}')">Pilih</button>
                    </td>
                </tr>
            `;
            count++;
        }
    }
    document.getElementById('spkTableBody').innerHTML = html;
}

function pilihSpk(spk) {
    document.getElementById('no_spk').value = spk;
    closeSpkModal();
    fetchSpkData();
}

function fetchSpkData() {
    let spk = document.getElementById('no_spk').value;
    if (!spk) return;

    fetch("{{ route('service.service-ac.ac.post_check_get_spk_data') }}?no_spk=" + encodeURIComponent(spk))
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                if (document.getElementById('cabang')) document.getElementById('cabang').value = data.data.BranchCode || '';
                if (document.getElementById('sa')) document.getElementById('sa').value = data.data.EmployeeName || '';
                if (document.getElementById('no_polisi')) document.getElementById('no_polisi').value = data.data.PoliceRegNo || '';
                if (document.getElementById('tipe_kendaraan')) document.getElementById('tipe_kendaraan').value = data.data.BasicModel || '';
                if (document.getElementById('tanggal')) {
                    document.getElementById('tanggal').value = data.data.JobOrderDate || '';
                }
            } else {
                alert(data.message || 'SPK tidak ditemukan di database');
            }
        })
        .catch(error => {
            console.error('Error fetching SPK:', error);
            alert('Gagal mengambil data SPK dari server.');
        });
}
</script>


@endsection
