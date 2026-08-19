@extends('layouts.app')

@section('title', 'Edit ADM ' . ucfirst($cabang))

@section('content')
<div style="width: 100%; box-sizing: border-box; overflow-x: hidden; padding: 20px;">
    
    <!-- Breadcrumb & Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #d2d6de; padding-bottom: 10px; margin-bottom: 20px;">
        <h2 style="margin: 0; font-size: 24px; font-weight: 500; color: #333;">ADM <span style="font-size: 16px; color: #777;">Sales Force {{ ucfirst($cabang) }}</span></h2>
    </div>

    <!-- Main Panel -->
    <div style="background: #fff; border: 1px solid #ddd; border-radius: 4px; border-top: 3px solid #d2d6de; box-shadow: 0 1px 1px rgba(0,0,0,0.1);">
        
        <div style="padding: 10px 15px; border-bottom: 1px solid #f4f4f4; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 16px; color: #444; font-weight: normal;">Edit ADM</h3>
            <a href="{{ url('/sales/leads/' . $cabang . '/adm') }}" style="background: #f39c12; color: #fff; padding: 6px 12px; text-decoration: none; border-radius: 3px; font-size: 12px; font-weight: bold;">
                <i class="fas fa-undo"></i> Back
            </a>
        </div>

        <form action="{{ url('/sales/leads/' . $cabang . '/adm/' . $lead->id) }}" method="POST" style="padding: 30px; max-width: 600px; margin: 0 auto;">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px; color: #333;">No. HP *</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $lead->no_hp) }}" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 0; box-sizing: border-box;" required>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px; color: #333;">Tanggal *</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $lead->tanggal) }}" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 0; box-sizing: border-box;" required>
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
