@extends('layouts.app')

@section('title', 'Tambah Leads ' . ucfirst($cabang))

@section('content')
<div style="width: 100%; box-sizing: border-box; overflow-x: hidden; padding: 20px;">
    
    <!-- Breadcrumb & Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #d2d6de; padding-bottom: 10px; margin-bottom: 20px;">
        <h2 style="margin: 0; font-size: 24px; font-weight: 500; color: #333;">{{ ucfirst($cabang) }} <span style="font-size: 16px; color: #777;">Leads IN</span></h2>
        <div style="font-size: 12px; color: #777;">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 4px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> 
            > {{ ucfirst($cabang) }}
        </div>
    </div>

    <!-- Main Panel -->
    <div style="background: #fff; border: 1px solid #ddd; border-radius: 4px; border-top: 3px solid #f39c12; box-shadow: 0 1px 1px rgba(0,0,0,0.1);">
        
        <div style="padding: 10px 15px; border-bottom: 1px solid #f4f4f4; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 18px; color: #444;">Tambah Leads</h3>
            <a href="{{ url('/sales/leads/' . $cabang . '/adm') }}" style="background: #f39c12; color: #fff; padding: 6px 12px; text-decoration: none; border-radius: 3px; font-size: 12px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 4px;"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <form action="{{ url('/sales/leads/' . $cabang . '/adm/store') }}" method="POST" style="padding: 20px;">
            @csrf
            
            <div style="max-width: 600px; margin: 0 auto;">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 13px;">No HP*</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="Input No. HP Customer" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 3px; box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 13px;">Tanggal Leads*</label>
                    <input type="date" name="tanggal" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 3px; box-sizing: border-box;">
                </div>
                
                <div style="margin-top: 20px;">
                    <button type="submit" style="background: #00a65a; border: 1px solid #008d4c; color: #fff; padding: 8px 16px; border-radius: 3px; font-size: 14px; cursor: pointer; margin-right: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 4px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        Save
                    </button>
                    <button type="reset" style="background: #f4f4f4; border: 1px solid #ddd; color: #444; padding: 8px 16px; border-radius: 3px; font-size: 14px; cursor: pointer;">
                        Reset
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
