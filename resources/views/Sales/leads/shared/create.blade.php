@extends('layouts.app')

@section('title', 'Tambah Leads')

@section('content')
<div style="width: 100%; box-sizing: border-box; overflow-x: hidden; padding: 20px;">
    
    <!-- Breadcrumb & Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f39c12; padding-bottom: 10px; margin-bottom: 20px;">
        <div>
            <h1 style="margin: 0; font-size: 24px; color: #333;">Tambah Leads</h1>
        </div>
        <a href="{{ url('/sales/leads/' . $cabang . '/' . ($role === 'leads' ? 'leads' : $role)) }}" style="background: #f39c12; color: #fff; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center;">
            <i class="fas fa-undo" style="margin-right: 5px;"></i> Kembali
        </a>
    </div>

    <!-- Main Panel -->
    @if ($errors->any())
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Peringatan',
                    text: "{{ $errors->first() }}",
                    confirmButtonColor: '#00a65a'
                });
            });
        </script>
    @endif
    <div style="background: #fff; border: 1px solid #ddd; border-radius: 4px; border-top: 3px solid #d2d6de; box-shadow: 0 1px 1px rgba(0,0,0,0.1);">
        <form action="{{ url('/sales/leads/' . $cabang . '/' . ($role === 'leads' ? 'leads' : $role) . '/store') }}" method="POST" enctype="multipart/form-data" style="padding: 20px;">
            @csrf
            
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                <!-- Kiri -->
                <div style="width: 48%; box-sizing: border-box;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px;">No HP*</label>
                        <input type="text" name="no_hp" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 0; box-sizing: border-box;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px;">Tanggal Leads*</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 0; box-sizing: border-box;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px;">Nama Customer*</label>
                        <input type="text" name="nama" class="form-control" placeholder="Input Nama Customer" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 0; box-sizing: border-box;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px;">Alamat*</label>
                        <input type="text" name="alamat" class="form-control" placeholder="Input Kecamatan" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 0; box-sizing: border-box;" required>
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px;">Sumber*</label>
                        <select name="sumber_id" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 0; box-sizing: border-box;" required>
                            <option value="">- Pilih -</option>
                            @foreach($sumbers as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_sumber }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px;">Unit*</label>
                        <select name="unit_id" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 0; box-sizing: border-box;" required>
                            <option value="">- Pilih -</option>
                            @foreach($units as $u)
                                <option value="{{ $u->id }}">{{ $u->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px;">Respon*</label>
                        <select name="respon_id" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 0; box-sizing: border-box;" required>
                            <option value="">- Pilih -</option>
                            @foreach($respons as $r)
                                <option value="{{ $r->id }}">{{ $r->nama_respon }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Kanan -->
                <div style="width: 48%; box-sizing: border-box;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px;">Status*</label>
                        <select name="status_id" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 0; box-sizing: border-box;" required>
                            <option value="">- Pilih -</option>
                            @foreach($statuses as $st)
                                <option value="{{ $st->id }}">{{ $st->nama_status }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    @if($role !== 'sales' && $role !== 'spv')
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px;">SPV*</label>
                        <select name="spv_id" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 0; box-sizing: border-box;" required>
                            <option value="">- Pilih -</option>
                            @foreach($spvs as $spv)
                                <option value="{{ $spv->id }}">{{ $spv->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    
                    @if($role !== 'sales')
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px;">Sales*</label>
                        <input type="hidden" name="sales_id" id="sales_id_input" required>
                        <div style="display: flex;">
                            <input type="text" id="sales_name_display" class="form-control" placeholder="" readonly style="flex: 1; padding: 8px; border: 1px solid #ccc; border-right: none; border-radius: 0; box-sizing: border-box; background: #eee; cursor: pointer;" onclick="openSalesModal()">
                            <button type="button" onclick="openSalesModal()" style="background: #3c8dbc; color: #fff; border: 1px solid #3c8dbc; padding: 8px 12px; cursor: pointer; border-radius: 0;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    @endif
                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px;">Update 1*</label>
                        <input type="text" name="update_1" class="form-control" placeholder="Input Update Leads" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 0; box-sizing: border-box;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px;">Update 2</label>
                        <input type="text" name="update_2" class="form-control" placeholder="Input Update Leads" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 0; box-sizing: border-box;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px;">Update 3</label>
                        <input type="text" name="update_3" class="form-control" placeholder="Input Update Leads" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 0; box-sizing: border-box;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px;">Bukti Screenshot</label>
                        <div style="border: 1px solid #ccc; padding: 8px; background: #fff; box-sizing: border-box;">
                            <input type="file" name="bukti_screenshot" style="width: 100%; box-sizing: border-box;">
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: center; gap: 10px; margin-top: 30px;">
                <button type="submit" style="background: #00a65a; color: #fff; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; font-size: 14px; display: inline-flex; align-items: center;">
                    <i class="fas fa-paper-plane" style="margin-right: 5px;"></i> Save
                </button>
                <button type="reset" style="background: #f4f4f4; color: #444; border: 1px solid #ddd; padding: 8px 20px; border-radius: 4px; cursor: pointer; font-size: 14px;">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Sales Force Modal -->
@if($role !== 'sales')
<div id="salesModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:#fff; border-radius:4px; width:500px; max-height:80vh; display:flex; flex-direction:column; box-shadow:0 5px 15px rgba(0,0,0,0.3);">
        <!-- Header -->
        <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 15px; border-bottom:1px solid #e5e5e5;">
            <h4 style="margin:0; font-size:16px; color:#333;">Sales Force</h4>
            <button onclick="closeSalesModal()" style="background:none; border:none; font-size:20px; cursor:pointer; color:#999; line-height:1;">&times;</button>
        </div>
        <!-- Controls -->
        <div style="padding:10px 15px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #e5e5e5;">
            <div style="font-size:13px;">
                Show <select id="salesPerPage" onchange="renderSalesTable()" style="padding:3px 5px; border:1px solid #ccc; border-radius:3px;">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select> entries
            </div>
            <div style="font-size:13px;">
                Search: <input type="text" id="salesSearchInput" oninput="renderSalesTable()" style="padding:4px 8px; border:1px solid #ccc; border-radius:3px; outline:none;">
            </div>
        </div>
        <!-- Table -->
        <div style="overflow-y:auto; flex:1; max-height:400px;">
            <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr style="background:#f9f9f9; border-bottom:2px solid #ddd;">
                        <th style="padding:10px 15px; text-align:left; font-weight:bold; color:#333;">Nama <i class="fas fa-sort" style="color:#ccc; font-size:10px;"></i></th>
                        <th style="padding:10px 15px; text-align:right; font-weight:bold; color:#333;">Action <i class="fas fa-sort" style="color:#ccc; font-size:10px;"></i></th>
                    </tr>
                </thead>
                <tbody id="salesTableBody">
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div id="salesPagination" style="padding:10px 15px; border-top:1px solid #e5e5e5; display:flex; justify-content:space-between; align-items:center; font-size:12px; color:#333;">
        </div>
    </div>
</div>

<script>
    // Sales data from server
    var allSales = @json($salesList->map(function($s) { return ['id' => $s->id, 'nama' => $s->nama]; }));
    var salesCurrentPage = 1;

    function openSalesModal() {
        document.getElementById('salesModal').style.display = 'flex';
        document.getElementById('salesSearchInput').value = '';
        salesCurrentPage = 1;
        renderSalesTable();
    }

    function closeSalesModal() {
        document.getElementById('salesModal').style.display = 'none';
    }

    function selectSales(id, nama) {
        document.getElementById('sales_id_input').value = id;
        document.getElementById('sales_name_display').value = nama;
        closeSalesModal();
    }

    function renderSalesTable() {
        var search = document.getElementById('salesSearchInput').value.toLowerCase();
        var perPage = parseInt(document.getElementById('salesPerPage').value);
        
        // Filter
        var filtered = allSales.filter(function(s) {
            return s.nama.toLowerCase().indexOf(search) !== -1;
        });

        // Pagination
        var totalPages = Math.ceil(filtered.length / perPage) || 1;
        if (salesCurrentPage > totalPages) salesCurrentPage = 1;
        var start = (salesCurrentPage - 1) * perPage;
        var pageData = filtered.slice(start, start + perPage);

        // Render rows
        var tbody = document.getElementById('salesTableBody');
        var html = '';
        if (pageData.length === 0) {
            html = '<tr><td colspan="2" style="padding:15px; text-align:center; color:#777;">Data tidak ditemukan</td></tr>';
        } else {
            pageData.forEach(function(s, i) {
                var bg = (i % 2 === 0) ? '#fff' : '#f9f9f9';
                html += '<tr style="border-bottom:1px solid #eee; background:' + bg + ';">';
                html += '<td style="padding:10px 15px; text-transform:uppercase;">' + s.nama + '</td>';
                html += '<td style="padding:10px 15px; text-align:right;">';
                html += '<button type="button" onclick="selectSales(' + s.id + ', \'' + s.nama.replace(/'/g, "\\'") + '\')" style="background:#3c8dbc; color:#fff; border:none; padding:4px 12px; border-radius:3px; cursor:pointer; font-size:12px;">Pilih</button>';
                html += '</td></tr>';
            });
        }
        tbody.innerHTML = html;

        // Render pagination
        var paginationDiv = document.getElementById('salesPagination');
        var showFrom = filtered.length > 0 ? start + 1 : 0;
        var showTo = Math.min(start + perPage, filtered.length);
        var pHtml = '<div>Showing ' + showFrom + ' to ' + showTo + ' of ' + filtered.length + ' entries</div>';
        pHtml += '<div style="display:flex; gap:0;">';
        pHtml += '<span onclick="salesGoPage(' + (salesCurrentPage - 1) + ')" style="padding:4px 10px; border:1px solid #ddd; background:#fff; color:' + (salesCurrentPage === 1 ? '#999' : '#333') + '; cursor:' + (salesCurrentPage === 1 ? 'not-allowed' : 'pointer') + '; border-radius:3px 0 0 3px; font-size:12px;">Previous</span>';
        for (var p = 1; p <= Math.min(totalPages, 9); p++) {
            if (p === salesCurrentPage) {
                pHtml += '<span style="padding:4px 10px; border:1px solid #3c8dbc; background:#3c8dbc; color:#fff; font-size:12px;">' + p + '</span>';
            } else {
                pHtml += '<span onclick="salesGoPage(' + p + ')" style="padding:4px 10px; border:1px solid #ddd; background:#fff; color:#333; cursor:pointer; font-size:12px;">' + p + '</span>';
            }
        }
        if (totalPages > 9) {
            pHtml += '<span style="padding:4px 10px; border:1px solid #ddd; background:#fff; color:#333; font-size:12px;">...</span>';
            pHtml += '<span onclick="salesGoPage(' + totalPages + ')" style="padding:4px 10px; border:1px solid #ddd; background:#fff; color:#333; cursor:pointer; font-size:12px;">' + totalPages + '</span>';
        }
        pHtml += '<span onclick="salesGoPage(' + (salesCurrentPage + 1) + ')" style="padding:4px 10px; border:1px solid #ddd; background:#fff; color:' + (salesCurrentPage === totalPages ? '#999' : '#333') + '; cursor:' + (salesCurrentPage === totalPages ? 'not-allowed' : 'pointer') + '; border-radius:0 3px 3px 0; font-size:12px;">Next</span>';
        pHtml += '</div>';
        paginationDiv.innerHTML = pHtml;
    }

    function salesGoPage(page) {
        var perPage = parseInt(document.getElementById('salesPerPage').value);
        var search = document.getElementById('salesSearchInput').value.toLowerCase();
        var filtered = allSales.filter(function(s) { return s.nama.toLowerCase().indexOf(search) !== -1; });
        var totalPages = Math.ceil(filtered.length / perPage) || 1;
        if (page < 1 || page > totalPages) return;
        salesCurrentPage = page;
        renderSalesTable();
    }

    // Close modal when clicking outside
    document.getElementById('salesModal').addEventListener('click', function(e) {
        if (e.target === this) closeSalesModal();
    });
</script>
@endif
@endsection

