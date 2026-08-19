@extends('layouts.app')

@section('title', 'Sumber Leads Entry')

@section('content')
<div style="width: 100%; box-sizing: border-box; overflow-x: hidden; padding: 20px;">
    
    <!-- Breadcrumb & Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; font-size: 24px; font-weight: 500; color: #333;">Sumber Leads <span style="font-size: 16px; color: #777;">Sumber Entry</span></h2>
        <div style="font-size: 12px; color: #777;">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 4px;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg> 
            > Sumber
        </div>
    </div>

    <!-- Main Panel -->
    <div style="background: #fff; border: 1px solid #ddd; border-radius: 4px; border-top: 3px solid #f39c12; box-shadow: 0 1px 1px rgba(0,0,0,0.1);">
        
        <div style="padding: 10px 15px; border-bottom: 1px solid #f4f4f4; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 18px; color: #444;">Tambah Sumber</h3>
            <a href="{{ url('/sales/leads/sumber') }}" style="background: #f39c12; color: #fff; padding: 6px 12px; text-decoration: none; border-radius: 3px; font-size: 12px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 4px;"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <form action="{{ url('/sales/leads/sumber') }}" method="POST" style="padding: 20px;">
            @csrf
            
            <div style="max-width: 600px; margin: 0 auto;">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 13px;">Sumber Leads*</label>
                    <input type="text" name="nama_sumber" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 3px; box-sizing: border-box;" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 13px;">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 3px; box-sizing: border-box;">
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
