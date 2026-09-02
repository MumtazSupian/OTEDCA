@extends('layouts.app')

@section('title', 'Tambah Teknisi')

@section('content')
<div style="width: 100%; box-sizing: border-box; overflow-x: hidden; padding: 20px;">
    
    <!-- Breadcrumb & Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #d2d6de; padding-bottom: 10px; margin-bottom: 20px;">
        <h2 style="margin: 0; font-size: 24px; font-weight: 500; color: #333;">Tambah <span style="font-size: 16px; color: #777;">Teknisi</span></h2>
        <div style="font-size: 12px; color: #777;">
            <i class="fas fa-users-cog" style="vertical-align: middle; margin-right: 4px;"></i>
            > Teknisi > Tambah
        </div>
    </div>

    <!-- Form Panel -->
    <div style="background: #fff; border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); max-width: 600px; margin: 0 auto; overflow: hidden;">
        
        <div style="padding: 20px 25px; border-bottom: 1px solid #f0f2f5; background: #f8fafc;">
            <h3 style="margin: 0; font-size: 16px; color: #334155; font-weight: 600;"><i class="fas fa-plus-circle" style="color: #3b82f6; margin-right: 8px;"></i>Form Tambah Teknisi Baru</h3>
        </div>

        <form action="{{ route('service.service-ac.ac.teknisi_store') }}" method="POST">
            @csrf
            <div style="padding: 25px;">
                
                @if ($errors->any())
                <div style="background-color: #fee2e2; color: #b91c1c; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; border-left: 4px solid #ef4444;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 13px;">Nama Teknisi <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="nama" required placeholder="Contoh: Budi Santoso" style="width: 100%; padding: 12px 15px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; box-sizing: border-box; background: #f8fafc; color: #334155; outline: none; transition: all 0.3s;" onfocus="this.style.borderColor='#3b82f6'; this.style.backgroundColor='#fff'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.backgroundColor='#f8fafc'; this.style.boxShadow='none';">
                </div>
                
            </div>
            <div style="border-top: 1px solid #f0f2f5; padding: 20px 25px; text-align: right; background: #fff;">
                <a href="{{ route('service.service-ac.ac.teknisi') }}" style="background: #f1f5f9; color: #64748b; border: none; padding: 10px 20px; border-radius: 30px; cursor: pointer; font-size: 13px; margin-right: 10px; text-decoration: none; display: inline-block; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#e2e8f0'" onmouseout="this.style.backgroundColor='#f1f5f9'">Batal</a>
                <button type="submit" style="background: linear-gradient(135deg, #3498db, #2980b9); color: #fff; border: none; padding: 10px 25px; border-radius: 30px; cursor: pointer; font-size: 13px; font-weight: 600; box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 15px rgba(52, 152, 219, 0.4)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 10px rgba(52, 152, 219, 0.3)';">Simpan Teknisi</button>
            </div>
        </form>
    </div>
</div>
@endsection
