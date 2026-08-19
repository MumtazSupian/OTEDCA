@extends('layouts.app')

@section('title', 'Unit Data')

@section('content')
<div style="width: 100%; box-sizing: border-box; overflow-x: hidden; padding: 20px;">
    
    <!-- Breadcrumb & Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; font-size: 24px; font-weight: 500; color: #333;">Unit <span style="font-size: 16px; color: #777;">Unit Data</span></h2>
        <div style="font-size: 12px; color: #777;">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 4px;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg> 
            > Unit
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #c3e6cb;">
        {{ session('success') }}
    </div>
    @endif

    <!-- Main Panel -->
    <div style="background: #fff; border: 1px solid #ddd; border-radius: 4px; border-top: 3px solid #3c8dbc; box-shadow: 0 1px 1px rgba(0,0,0,0.1);">
        
        <div style="padding: 10px 15px; border-bottom: 1px solid #f4f4f4; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 18px; color: #444;">Data Unit</h3>
            <a href="{{ url('/sales/leads/unit/create') }}" style="background: #3c8dbc; color: #fff; padding: 6px 12px; text-decoration: none; border-radius: 3px; font-size: 12px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 4px;"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                Tambah
            </a>
        </div>

        <div style="padding: 15px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <div>
                    <button onclick="tableExport.copy(this)" style="background: #f4f4f4; border: 1px solid #ddd; padding: 5px 10px; border-radius: 3px; cursor: pointer;">Copy</button>
                    <button onclick="tableExport.excel(this)" style="background: #f4f4f4; border: 1px solid #ddd; padding: 5px 10px; border-radius: 3px; cursor: pointer; margin-left: 5px;">Excel</button>
                    <button onclick="tableExport.pdf(this)" style="background: #f4f4f4; border: 1px solid #ddd; padding: 5px 10px; border-radius: 3px; cursor: pointer; margin-left: 5px;">PDF</button>
                    <button onclick="tableExport.print(this)" style="background: #f4f4f4; border: 1px solid #ddd; padding: 5px 10px; border-radius: 3px; cursor: pointer; margin-left: 5px;">Print</button>
                </div>
                <div>
                    Search: <input type="text" style="padding: 5px; border: 1px solid #ccc; border-radius: 3px;">
                </div>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <thead>
                        <tr style="background-color: #f9f9f9; border-bottom: 2px solid #ddd;">
                            <th style="padding: 10px; text-align: left; border: 1px solid #f4f4f4;">#</th>
                            <th style="padding: 10px; text-align: left; border: 1px solid #f4f4f4;">Nama</th>
                            <th style="padding: 10px; text-align: left; border: 1px solid #f4f4f4;">Deskripsi</th>
                            <th style="padding: 10px; text-align: center; border: 1px solid #f4f4f4;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($units as $index => $item)
                        <tr style="border-bottom: 1px solid #f4f4f4; background-color: {{ $index % 2 == 0 ? '#fff' : '#f9f9f9' }};">
                            <td style="padding: 10px; border: 1px solid #f4f4f4;">{{ $index + 1 }}.</td>
                            <td style="padding: 10px; border: 1px solid #f4f4f4;">{{ $item->nama_unit }}</td>
                            <td style="padding: 10px; border: 1px solid #f4f4f4;">{{ $item->deskripsi }}</td>
                            <td style="padding: 10px; text-align: center; border: 1px solid #f4f4f4;">
                                <div style="display: flex; justify-content: center; align-items: center; gap: 5px;">
                                    <a href="{{ url('/sales/leads/unit/' . $item->id . '/edit') }}" style="background: #3c8dbc; color: #fff; padding: 4px 8px; border-radius: 3px; text-decoration: none; font-size: 12px; ; display: inline-flex; align-items: center; justify-content: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; display: inline-flex; align-items: center; justify-content: center;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    Update
                                </a>
                                    <form action="{{ url('/sales/leads/unit/' . $item->id) }}" method="POST" style="margin: 0; padding: 0;" onsubmit="return confirm('Yakin ingin menghapus unit ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #dd4b39; color: #fff; padding: 4px 8px; border: none; border-radius: 3px; cursor: pointer; font-size: 12px; display: inline-flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        Delete
                                    </button>
                                </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding: 10px; text-align: center; border: 1px solid #f4f4f4; background-color: #f9f9f9;">No data available in table</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; font-size: 13px; color: #777;">
                <div>Showing 1 to {{ count($units) }} of {{ count($units) }} entries</div>
                <div style="display: flex; gap: 5px;">
                    <button style="border: 1px solid #ddd; background: #fff; padding: 5px 10px; border-radius: 3px; cursor: pointer; color: #aaa;" disabled>Previous</button>
                    <button style="border: 1px solid #ddd; background: #3c8dbc; padding: 5px 10px; border-radius: 3px; cursor: pointer; color: #fff;">1</button>
                    <button style="border: 1px solid #ddd; background: #fff; padding: 5px 10px; border-radius: 3px; cursor: pointer;">Next</button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
