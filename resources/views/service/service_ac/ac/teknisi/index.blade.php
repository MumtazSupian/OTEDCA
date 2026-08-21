@extends('layouts.app')

@section('content')
<style>
    .teknisi-wrapper {
        padding: 25px;
        background-color: #f4f6f9;
        min-height: calc(100vh - 120px);
    }
    .header-card {
        background: white;
        padding: 20px 25px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid rgba(0,0,0,0.02);
    }
    .header-card h3 {
        margin: 0;
        color: #1976d2;
        font-size: 20px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .header-card p {
        margin: 4px 0 0 0;
        font-size: 13px;
        color: #6c757d;
    }
    .btn-tambah {
        background: linear-gradient(135deg, #1976d2, #3498db);
        color: white;
        padding: 10px 24px;
        border: none;
        border-radius: 25px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(25, 118, 210, 0.25);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    .btn-tambah:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(25, 118, 210, 0.35);
        color: white;
    }
    .main-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        border: 1px solid rgba(0,0,0,0.02);
        overflow: hidden;
    }
    .card-filter-bar {
        padding: 18px 25px;
        border-bottom: 1px solid #f0f4f8;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fafbfc;
    }
    .search-box {
        position: relative;
        display: inline-flex;
        align-items: center;
    }
    .search-box input {
        padding: 8px 15px 8px 36px;
        border: 1px solid #dfe3e8;
        border-radius: 20px;
        font-size: 13px;
        width: 250px;
        background: white;
        transition: all 0.2s;
    }
    .search-box input:focus {
        outline: none;
        border-color: #1976d2;
        box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
        width: 300px;
    }
    .search-box i {
        position: absolute;
        left: 14px;
        color: #8c9ba5;
        font-size: 13px;
    }
    .table-teknisi {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .table-teknisi th {
        background: #f8f9fa;
        color: #495057;
        font-weight: 700;
        padding: 14px 20px;
        text-align: left;
        border-bottom: 2px solid #e9ecef;
    }
    .table-teknisi td {
        padding: 14px 20px;
        border-bottom: 1px solid #f0f4f8;
        color: #2c3e50;
        vertical-align: middle;
    }
    .table-teknisi tr:hover td {
        background-color: #fcfdfe;
    }
    .badge-no {
        background: #e3f2fd;
        color: #1976d2;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        display: inline-block;
    }
    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 13px;
        margin: 0 3px;
    }
    .action-edit {
        background: #fff3e0;
        color: #f57c00;
    }
    .action-edit:hover {
        background: #ffe0b2;
        transform: translateY(-2px);
    }
    .action-delete {
        background: #ffebee;
        color: #d32f2f;
    }
    .action-delete:hover {
        background: #ffcdd2;
        transform: translateY(-2px);
    }

    /* Modal Styles */
    .custom-modal-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1050;
        backdrop-filter: blur(2px);
    }
    .custom-modal-box {
        background: white;
        width: 90%;
        max-width: 480px;
        border-radius: 14px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.2);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: modalFadeIn 0.25s ease-out;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(-15px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .custom-modal-header {
        padding: 18px 25px;
        border-bottom: 1px solid #f0f4f8;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fafbfc;
    }
    .custom-modal-header h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .custom-modal-close {
        cursor: pointer;
        font-size: 22px;
        color: #8c9ba5;
        background: none;
        border: none;
        line-height: 1;
        transition: color 0.2s;
    }
    .custom-modal-close:hover {
        color: #dc3545;
    }
    .custom-modal-body {
        padding: 25px;
    }
    .custom-form-group {
        margin-bottom: 15px;
    }
    .custom-form-group label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #495057;
        margin-bottom: 8px;
    }
    .custom-form-control {
        width: 100%;
        padding: 11px 15px;
        border: 1px solid #dfe3e8;
        border-radius: 8px;
        font-size: 13px;
        background: #f8f9fa;
        color: #2c3e50;
        transition: all 0.2s;
        box-sizing: border-box;
    }
    .custom-form-control:focus {
        outline: none;
        border-color: #1976d2;
        background: white;
        box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
    }
    .custom-modal-footer {
        padding: 15px 25px;
        background: #fafbfc;
        border-top: 1px solid #f0f4f8;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    .btn-cancel {
        padding: 9px 18px;
        border-radius: 8px;
        border: 1px solid #dfe3e8;
        background: white;
        color: #6c757d;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-cancel:hover {
        background: #f8f9fa;
        color: #343a40;
    }
    .btn-save {
        padding: 9px 22px;
        border-radius: 8px;
        border: none;
        background: linear-gradient(135deg, #1976d2, #3498db);
        color: white;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        box-shadow: 0 3px 10px rgba(25, 118, 210, 0.25);
        transition: all 0.2s;
    }
    .btn-save:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 14px rgba(25, 118, 210, 0.35);
    }
</style>

<div class="teknisi-wrapper">
    <!-- Header Card -->
    <div class="header-card">
        <div>
            <h3><i class="fas fa-tools"></i> Data Master Teknisi</h3>
            <p>Kelola daftar teknisi untuk pemeriksaan Service AC</p>
        </div>
        <div>
            <button type="button" class="btn-tambah" onclick="openModalTambah()">
                <i class="fas fa-plus"></i> Tambah Teknisi
            </button>
        </div>
    </div>

    @if(session('success'))
    <div style="background: #e8f5e9; color: #2e7d32; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c8e6c9; font-size: 13px; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-check-circle" style="font-size: 16px;"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Table Card -->
    <div class="main-card">
        <div class="card-filter-bar">
            <div style="font-weight: 700; color: #495057; font-size: 14px;">
                Daftar Teknisi (<span id="totalTeknisi">{{ count($teknisis) }}</span>)
            </div>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" onkeyup="filterTeknisi()" placeholder="Cari nama teknisi...">
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="table-teknisi" id="teknisiTable">
                <thead>
                    <tr>
                        <th width="80" style="text-align: center;">No</th>
                        <th>Nama Teknisi</th>
                        <th width="150" style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teknisis as $index => $t)
                    <tr>
                        <td style="text-align: center;">
                            <span class="badge-no">{{ $index + 1 }}</span>
                        </td>
                        <td style="font-weight: 600; color: #2c3e50;" class="nama-teknisi">{{ $t->nama }}</td>
                        <td style="text-align: center;">
                            <button type="button" class="action-btn action-edit" onclick="openModalEdit({{ $t->id }}, '{{ addslashes($t->nama) }}')" title="Edit Teknisi">
                                <i class="fas fa-pen"></i>
                            </button>
                            <form action="{{ route('service.service-ac.ac.teknisi_destroy', $t->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus teknisi {{ addslashes($t->nama) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn action-delete" title="Hapus Teknisi">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="3" style="text-align: center; padding: 40px 20px; color: #8c9ba5;">
                            <i class="fas fa-user-slash" style="font-size: 32px; margin-bottom: 10px; display: block; color: #ced4da;"></i>
                            Belum ada data teknisi yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Teknisi -->
<div class="custom-modal-overlay" id="modalTambahTeknisi">
    <div class="custom-modal-box">
        <div class="custom-modal-header">
            <h4><i class="fas fa-user-plus" style="color: #1976d2;"></i> Tambah Teknisi Baru</h4>
            <button type="button" class="custom-modal-close" onclick="closeModalTambah()">&times;</button>
        </div>
        <form action="{{ route('service.service-ac.ac.teknisi_store') }}" method="POST">
            @csrf
            <div class="custom-modal-body">
                <div class="custom-form-group">
                    <label>Nama Teknisi <span style="color: #e53935;">*</span></label>
                    <input type="text" name="nama" class="custom-form-control" placeholder="Contoh: Budi Santoso" required autofocus>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModalTambah()">Batal</button>
                <button type="submit" class="btn-save"><i class="fas fa-save" style="margin-right: 5px;"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Teknisi -->
<div class="custom-modal-overlay" id="modalEditTeknisi">
    <div class="custom-modal-box">
        <div class="custom-modal-header">
            <h4><i class="fas fa-user-edit" style="color: #f57c00;"></i> Edit Data Teknisi</h4>
            <button type="button" class="custom-modal-close" onclick="closeModalEdit()">&times;</button>
        </div>
        <form id="formEditTeknisi" method="POST">
            @csrf
            @method('PUT')
            <div class="custom-modal-body">
                <div class="custom-form-group">
                    <label>Nama Teknisi <span style="color: #e53935;">*</span></label>
                    <input type="text" id="editNamaTeknisi" name="nama" class="custom-form-control" required>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModalEdit()">Batal</button>
                <button type="submit" class="btn-save" style="background: linear-gradient(135deg, #f57c00, #ff9800);"><i class="fas fa-save" style="margin-right: 5px;"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModalTambah() {
    document.getElementById('modalTambahTeknisi').style.display = 'flex';
}

function closeModalTambah() {
    document.getElementById('modalTambahTeknisi').style.display = 'none';
}

function openModalEdit(id, nama) {
    document.getElementById('editNamaTeknisi').value = nama;
    document.getElementById('formEditTeknisi').action = "{{ url('service/service-ac/ac/teknisi') }}/" + id;
    document.getElementById('modalEditTeknisi').style.display = 'flex';
}

function closeModalEdit() {
    document.getElementById('modalEditTeknisi').style.display = 'none';
}

function filterTeknisi() {
    const filter = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#teknisiTable tbody tr:not(#emptyRow)');
    
    rows.forEach(row => {
        const nameCell = row.querySelector('.nama-teknisi');
        if (nameCell) {
            const text = nameCell.textContent || nameCell.innerText;
            row.style.display = text.toLowerCase().includes(filter) ? '' : 'none';
        }
    });
}

// Close modals when clicking outside the box
window.onclick = function(event) {
    const modalTambah = document.getElementById('modalTambahTeknisi');
    const modalEdit = document.getElementById('modalEditTeknisi');
    if (event.target == modalTambah) {
        modalTambah.style.display = "none";
    }
    if (event.target == modalEdit) {
        modalEdit.style.display = "none";
    }
}
</script>
@endsection
