@extends('layouts.app')

@section('title', ucfirst($cabang) . ' Leads')

@section('content')
<div style="width: 100%; box-sizing: border-box; overflow-x: hidden; padding: 20px;">
    
    <!-- Breadcrumb & Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #d2d6de; padding-bottom: 10px; margin-bottom: 20px;">
        <h2 style="margin: 0; font-size: 24px; font-weight: 500; color: #333;">{{ ucfirst($cabang) }} <span style="font-size: 16px; color: #777;">Leads</span></h2>
        <div style="font-size: 12px; color: #777;">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 4px;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            > {{ ucfirst($cabang) }}
        </div>
    </div>

    <!-- Data Panel -->
    <div style="background: #fff; border: 1px solid #ddd; border-radius: 4px; border-top: 3px solid #d2d6de; box-shadow: 0 1px 1px rgba(0,0,0,0.1);">
        
        <div style="padding: 10px 15px; border-bottom: 1px solid #f4f4f4; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 16px; color: #444; font-weight: normal;">Data Leads</h3>
            <a href="{{ url('/sales/leads/' . $cabang . '/leads/create') }}" style="background: #3c8dbc; color: #fff; padding: 6px 12px; text-decoration: none; border-radius: 3px; font-size: 12px; font-weight: bold;">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>

        <div style="padding: 15px;">
            @if(session('success'))
            <div style="background-color: #dff0d8; color: #3c763d; padding: 10px; border: 1px solid #d6e9c6; border-radius: 3px; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
            @endif

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <div>
                    <button onclick="tableExport.copy(this)" style="background: #fff; border: 1px solid #ccc; padding: 5px 10px; border-radius: 3px; cursor: pointer; color: #333; font-size: 12px;">Copy</button>
                    <button onclick="tableExport.excel(this)" style="background: #fff; border: 1px solid #ccc; padding: 5px 10px; border-radius: 3px; cursor: pointer; color: #333; font-size: 12px;">Excel</button>
                    <button onclick="tableExport.pdf(this)" style="background: #fff; border: 1px solid #ccc; padding: 5px 10px; border-radius: 3px; cursor: pointer; color: #333; font-size: 12px;">PDF</button>
                    <button onclick="tableExport.print(this)" style="background: #fff; border: 1px solid #ccc; padding: 5px 10px; border-radius: 3px; cursor: pointer; color: #333; font-size: 12px;">Print</button>
                </div>
                <div style="font-size: 13px;">
                    Search: <input type="text" id="searchInput" onkeyup="searchTable()" style="padding: 5px; border: 1px solid #ccc; border-radius: 3px; outline: none;">
                </div>
            </div>

            <div style="overflow-x: auto;">
                <table id="leadsTable" style="width: 100%; border-collapse: collapse; font-size: 12px; text-align: left; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                    <thead>
                        <tr style="border-bottom: 2px solid #f4f4f4; background-color: #fff;">
                            <th style="padding: 10px; font-weight: bold; color: #333; border: 1px solid #f4f4f4; width: 3%;"># <i class="fas fa-sort" style="color:#ccc; font-size:10px; float:right; margin-top:2px;"></i></th>
                            <th style="padding: 10px; font-weight: bold; color: #333; border: 1px solid #f4f4f4; width: 12%;">Actions <i class="fas fa-sort" style="color:#ccc; font-size:10px; float:right; margin-top:2px;"></i></th>
                            <th style="padding: 10px; font-weight: bold; color: #333; border: 1px solid #f4f4f4;">No.HP <i class="fas fa-sort" style="color:#ccc; font-size:10px; float:right; margin-top:2px;"></i></th>
                            <th style="padding: 10px; font-weight: bold; color: #333; border: 1px solid #f4f4f4;">Status <i class="fas fa-sort" style="color:#ccc; font-size:10px; float:right; margin-top:2px;"></i></th>
                            <th style="padding: 10px; font-weight: bold; color: #333; border: 1px solid #f4f4f4;">SPV <i class="fas fa-sort" style="color:#ccc; font-size:10px; float:right; margin-top:2px;"></i></th>
                            <th style="padding: 10px; font-weight: bold; color: #333; border: 1px solid #f4f4f4;">Sales <i class="fas fa-sort" style="color:#ccc; font-size:10px; float:right; margin-top:2px;"></i></th>
                            <th style="padding: 10px; font-weight: bold; color: #333; border: 1px solid #f4f4f4;">Nama <i class="fas fa-sort" style="color:#ccc; font-size:10px; float:right; margin-top:2px;"></i></th>
                            <th style="padding: 10px; font-weight: bold; color: #333; border: 1px solid #f4f4f4;">Tanggal <i class="fas fa-sort" style="color:#ccc; font-size:10px; float:right; margin-top:2px;"></i></th>
                            <th style="padding: 10px; font-weight: bold; color: #333; border: 1px solid #f4f4f4;">Sumber <i class="fas fa-sort" style="color:#ccc; font-size:10px; float:right; margin-top:2px;"></i></th>
                            <th style="padding: 10px; font-weight: bold; color: #333; border: 1px solid #f4f4f4;">Unit <i class="fas fa-sort" style="color:#ccc; font-size:10px; float:right; margin-top:2px;"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $index => $lead)
                        <tr style="border-bottom: 1px solid #f4f4f4; background-color: {{ $index % 2 == 0 ? '#f9f9f9' : '#fff' }};">
                            <td style="padding: 10px; border: 1px solid #f4f4f4;">{{ $index + 1 }}.</td>
                            <td style="padding: 10px; border: 1px solid #f4f4f4; white-space: nowrap;">
                                <a href="{{ url('/sales/leads/' . $cabang . '/leads/' . $lead->id . '/edit') }}" style="background: #3c8dbc; color: #fff; padding: 3px 8px; text-decoration: none; border-radius: 3px; font-size: 11px; display: inline-block; margin-right: 3px;">
                                    <i class="fas fa-pencil-alt" style="margin-right: 2px;"></i> Update
                                </a>
                                <form action="{{ url('/sales/leads/' . $cabang . '/leads/' . $lead->id) }}" method="POST" style="display:inline-block; margin: 0; padding: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?');" style="background: #dd4b39; color: #fff; border: none; padding: 3px 8px; border-radius: 3px; font-size: 11px; cursor: pointer;">
                                        <i class="fas fa-trash" style="margin-right: 2px;"></i> Delete
                                    </button>
                                </form>
                            </td>
                            <td style="padding: 10px; border: 1px solid #f4f4f4;">{{ $lead->no_hp }}</td>
                            <td style="padding: 10px; border: 1px solid #f4f4f4; text-transform: uppercase;">{{ $lead->status->nama_status ?? 'NO REPORT' }}</td>
                            <td style="padding: 10px; border: 1px solid #f4f4f4; text-transform: uppercase;">{{ $lead->spv->nama ?? '' }}</td>
                            <td style="padding: 10px; border: 1px solid #f4f4f4; text-transform: uppercase;">{{ $lead->sales->nama ?? '' }}</td>
                            <td style="padding: 10px; border: 1px solid #f4f4f4; text-transform: uppercase;">{{ $lead->nama ?? 'NO REPORT' }}</td>
                            <td style="padding: 10px; border: 1px solid #f4f4f4;">{{ $lead->tanggal }}</td>
                            <td style="padding: 10px; border: 1px solid #f4f4f4; text-transform: uppercase;">{{ $lead->sumber->nama_sumber ?? 'NO REPORT' }}</td>
                            <td style="padding: 10px; border: 1px solid #f4f4f4; text-transform: uppercase;">{{ $lead->unit->nama_unit ?? 'NO REPORT' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" style="padding: 15px; text-align: center; color: #777;">Belum ada data Leads.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 15px; font-size: 13px; color: #333; display: flex; justify-content: space-between; align-items: center;">
                <div>Showing 1 to {{ count($leads) }} of {{ count($leads) }} entries</div>
                <div style="display: flex;">
                    <span style="padding: 5px 10px; border: 1px solid #ddd; background: #fff; color: #777; cursor: not-allowed; border-top-left-radius: 4px; border-bottom-left-radius: 4px;">Previous</span>
                    <span style="padding: 5px 10px; border: 1px solid #3c8dbc; background: #3c8dbc; color: #fff;">1</span>
                    <span style="padding: 5px 10px; border: 1px solid #ddd; border-left: none; background: #fff; color: #333; cursor: pointer; border-top-right-radius: 4px; border-bottom-right-radius: 4px;">Next</span>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function searchTable() {
    var input = document.getElementById('searchInput').value.toLowerCase();
    var table = document.getElementById('leadsTable');
    var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (var i = 0; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName('td');
        var found = false;
        for (var j = 0; j < cells.length; j++) {
            if (cells[j].textContent.toLowerCase().indexOf(input) > -1) {
                found = true;
                break;
            }
        }
        rows[i].style.display = found ? '' : 'none';
    }
}
</script>
@endsection
