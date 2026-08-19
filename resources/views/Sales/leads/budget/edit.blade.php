@extends('layouts.app')

@section('title', 'Budget Edit')

@section('content')
<div style="width: 100%; box-sizing: border-box; overflow-x: hidden; padding: 20px;">
    
    <!-- Breadcrumb & Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; font-size: 24px; font-weight: 500; color: #333;">Budget <span style="font-size: 16px; color: #777;">Budget Edit</span></h2>
        <div style="font-size: 12px; color: #777;">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 4px;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg> 
            > Budget
        </div>
    </div>

    <!-- Main Panel -->
    <div style="background: #fff; border: 1px solid #ddd; border-radius: 4px; border-top: 3px solid #f39c12; box-shadow: 0 1px 1px rgba(0,0,0,0.1);">
        
        <div style="padding: 10px 15px; border-bottom: 1px solid #f4f4f4; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 18px; color: #444;">Edit Budget</h3>
            <a href="{{ url('/sales/leads/budget') }}" style="background: #f39c12; color: #fff; padding: 6px 12px; text-decoration: none; border-radius: 3px; font-size: 12px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 4px;"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <form action="{{ url('/sales/leads/budget/' . $budget->id) }}" method="POST" style="padding: 20px;">
            @csrf
            @method('PUT')
            
            <div style="max-width: 600px; margin: 0 auto;">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 13px;">Sumber</label>
                    <select name="sumber_id" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 3px; box-sizing: border-box;" required>
                        <option value="">-- Pilih Sumber --</option>
                        @foreach($sumbers as $sumber)
                            <option value="{{ $sumber->id }}" {{ $budget->sumber_id == $sumber->id ? 'selected' : '' }}>{{ $sumber->nama_sumber }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 13px;">Budget</label>
                    <input type="text" name="budget" id="budgetInput" value="{{ number_format((float) str_replace(['.', ','], '', $budget->budget), 0, ',', '.') }}" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 3px; box-sizing: border-box;" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 13px;">Bulan</label>
                    <input type="month" name="bulan" value="{{ $budget->bulan }}" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 3px; box-sizing: border-box;" required>
                </div>
                
                <div style="margin-top: 20px;">
                    <button type="submit" style="background: #00a65a; border: 1px solid #008d4c; color: #fff; padding: 8px 16px; border-radius: 3px; font-size: 14px; cursor: pointer; margin-right: 10px;">
                        Update
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    // Format rupiah saat mengetik di input Budget
    var budgetInput = document.getElementById('budgetInput');
    budgetInput.addEventListener('keyup', function(e) {
        budgetInput.value = formatRupiah(this.value);
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>
@endsection
