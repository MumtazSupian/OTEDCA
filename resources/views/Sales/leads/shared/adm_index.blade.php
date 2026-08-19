@extends('layouts.app')

@section('title', 'Admin Leads In ' . ucfirst($cabang))

@section('content')
<div style="width: 100%; box-sizing: border-box; overflow-x: hidden; padding: 20px;">
    
    <!-- Breadcrumb & Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #d2d6de; padding-bottom: 10px; margin-bottom: 20px;">
        <h2 style="margin: 0; font-size: 24px; font-weight: 500; color: #333;">Admin Leads In {{ ucfirst($cabang) }} <span style="font-size: 16px; color: #777;">Leads In</span></h2>
        <div style="font-size: 12px; color: #777;">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 4px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> 
            > Admin
        </div>
    </div>

    <!-- Data Panel -->
    <div style="background: #fff; border: 1px solid #ddd; border-radius: 4px; border-top: 3px solid #d2d6de; box-shadow: 0 1px 1px rgba(0,0,0,0.1);">
        
        <div style="padding: 10px 15px; border-bottom: 1px solid #f4f4f4; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 16px; color: #444; font-weight: normal;">Data Leads</h3>
            <a href="{{ url('/sales/leads/' . $cabang . '/adm/create') }}" style="background: #3c8dbc; color: #fff; padding: 6px 12px; text-decoration: none; border-radius: 3px; font-size: 12px; font-weight: bold;">
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
                    Search: <input type="text" style="padding: 5px; border: 1px solid #ccc; border-radius: 3px; outline: none;">
                </div>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 12px; text-align: left; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                    <thead>
                        <tr style="border-bottom: 2px solid #f4f4f4; background-color: #fff;">
                            <th style="padding: 10px; font-weight: bold; color: #333; border: 1px solid #f4f4f4; width: 5%;"># <i class="fas fa-sort" style="color:#ccc; font-size:10px; float:right; margin-top:2px;"></i></th>
                            <th style="padding: 10px; font-weight: bold; color: #333; border: 1px solid #f4f4f4;">No.HP <i class="fas fa-sort" style="color:#ccc; font-size:10px; float:right; margin-top:2px;"></i></th>
                            <th style="padding: 10px; font-weight: bold; color: #333; border: 1px solid #f4f4f4;">Tanggal <i class="fas fa-sort" style="color:#ccc; font-size:10px; float:right; margin-top:2px;"></i></th>
                            <th style="padding: 10px; font-weight: bold; color: #333; border: 1px solid #f4f4f4; text-align: center; width: 15%;">Actions <i class="fas fa-sort" style="color:#ccc; font-size:10px; float:right; margin-top:2px;"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $index => $lead)
                        <tr style="border-bottom: 1px solid #f4f4f4; background-color: {{ $index % 2 == 0 ? '#f9f9f9' : '#fff' }};">
                            <td style="padding: 10px; border: 1px solid #f4f4f4;">{{ $index + 1 }}.</td>
                            <td style="padding: 10px; border: 1px solid #f4f4f4;">{{ $lead->no_hp }}</td>
                            <td style="padding: 10px; border: 1px solid #f4f4f4;">{{ $lead->tanggal }}</td>
                            <td style="padding: 10px; border: 1px solid #f4f4f4; text-align: center; white-space: nowrap;">
                                <a href="{{ url('/sales/leads/' . $cabang . '/adm/' . $lead->id . '/edit') }}" style="background: #3c8dbc; color: #fff; padding: 4px 6px; text-decoration: none; border-radius: 3px; font-size: 11px; display: inline-block;">
                                    <i class="fas fa-pencil-alt"></i> Update
                                </a>
                                <form action="{{ url('/sales/leads/' . $cabang . '/adm/' . $lead->id) }}" method="POST" style="display:inline-block; margin: 0; padding: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?');" style="color: #dd4b39; background: transparent; border: none; padding: 4px; font-size: 14px; cursor: pointer;">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding: 15px; text-align: center; color: #777;">Belum ada data Leads.</td>
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
@endsection
