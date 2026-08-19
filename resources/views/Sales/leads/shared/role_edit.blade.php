@extends('layouts.app')

@section('title', 'Edit ' . strtoupper($role) . ' ' . ucfirst($cabang))

@section('content')
<div style="width: 100%; box-sizing: border-box; overflow-x: hidden; padding: 20px;">
    
    <!-- Breadcrumb & Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #d2d6de; padding-bottom: 10px; margin-bottom: 20px;">
        <h2 style="margin: 0; font-size: 24px; font-weight: 500; color: #333;">{{ strtoupper($role) }} <span style="font-size: 16px; color: #777;">Sales Force {{ ucfirst($cabang) }}</span></h2>
        <div style="font-size: 12px; color: #777;">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 4px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> 
            > SH {{ ucfirst($cabang) }}
        </div>
    </div>

    <!-- Main Panel -->
    <div style="background: #fff; border: 1px solid #ddd; border-radius: 4px; border-top: 3px solid #d2d6de; box-shadow: 0 1px 1px rgba(0,0,0,0.1);">
        
        <div style="padding: 10px 15px; border-bottom: 1px solid #f4f4f4; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 16px; color: #444; font-weight: normal;">Edit {{ strtoupper($role) }}</h3>
            <a href="{{ url('/sales/leads/' . $cabang . '/' . $role) }}" style="background: #f39c12; color: #fff; padding: 6px 12px; text-decoration: none; border-radius: 3px; font-size: 12px; font-weight: bold;">
                <i class="fas fa-undo"></i> Back
            </a>
        </div>

        <form action="{{ url('/sales/leads/' . $cabang . '/' . $role . '/' . $user->id) }}" method="POST" style="padding: 30px; max-width: 600px; margin: 0 auto;">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px; color: #333;">Nama *</label>
                <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 0; box-sizing: border-box;" required>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px; color: #333;">Deskripsi</label>
                <input type="text" name="deskripsi" value="{{ old('deskripsi', $user->deskripsi) }}" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 0; box-sizing: border-box;">
            </div>

            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" style="background: #00a65a; color: #fff; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; font-size: 14px; display: inline-flex; align-items: center;">
                    <i class="fas fa-paper-plane" style="margin-right: 5px;"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
