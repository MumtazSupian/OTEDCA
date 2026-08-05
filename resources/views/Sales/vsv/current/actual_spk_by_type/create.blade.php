@extends('layouts.app')

@section('content')
    <div style="padding: 40px 20px; display: flex; flex-direction: column; align-items: center; min-height: 100vh;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="font-weight:800; color:#1e293b; font-weight:800; letter-spacing:1px; text-transform:uppercase; margin:0;">
                TAMBAH ACTUAL SPK BY TYPE
            </h2>
            <div style="width: 50px; height: 4px; background: #dc2626; margin: 10px auto; border-radius: 10px;"></div>
            <p style="color: #64748b; font-size: 14px;">Input data aktual SPK berdasarkan tipe unit per bulan</p>
        </div>

        <div style="background: white; width: 100%; box-sizing: border-box; max-width: 800px; padding: 35px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
            
            <form id="actualSpkForm" action="{{ route('current.actual-spk-by-type.store') }}" method="POST" x-data="targetForm()">
                @csrf
                
                @if(session('error'))
                    <div style="background: #fed7d7; color: #c53030; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-size: 14px;">
                        {{ session('error') }}
                    </div>
                @endif

                <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 12px; text-transform: uppercase;">Kategori</label>
                        <select name="jenis_unit" x-model="selectedKategori" required style="width: 100%; box-sizing: border-box; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #4a5568;">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Commercial">Commercial</option>
                            <option value="Passenger">Passenger</option>
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 12px; text-transform: uppercase;">Tipe Unit</label>
                        <select name="type_unit" required style="width: 100%; box-sizing: border-box; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #4a5568;">
                            <option value="" disabled selected>Pilih Unit</option>
                            <template x-if="selectedKategori === 'Commercial'">
                                <template x-for="unit in commercial_units" :key="unit">
                                    <option :value="unit" x-text="unit"></option>
                                </template>
                            </template>
                            <template x-if="selectedKategori === 'Passenger'">
                                <template x-for="unit in passenger_units" :key="unit">
                                    <option :value="unit" x-text="unit"></option>
                                </template>
                            </template>
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 12px; text-transform: uppercase;">Tahun</label>
                        <input type="number" name="tahun" value="{{ date('Y') }}" required style="width: 100%; box-sizing: border-box; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #4a5568;">
                    </div>
                </div>

                <div style="margin: 25px 0; border-bottom: 2px dashed #edf2f7;"></div>
                
                <p style="text-align:center; color: #718096; font-size: 13px; margin-bottom: 10px;">
                    Menginput data untuk Cabang: <strong style="color: #2d3748;">{{ Auth::user()->cabang }}</strong>
                </p>

                <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  grid-template-columns: repeat(4, 1fr); gap: 15px;">
                    @php
                        $months = [
                            'jan' => 'JAN', 'feb' => 'FEB', 'mar' => 'MAR', 'apr' => 'APR',
                            'mei' => 'MEI', 'jun' => 'JUN', 'jul' => 'JUL', 'agu' => 'AGU',
                            'sep' => 'SEP', 'okt' => 'OKT', 'nov' => 'NOV', 'des' => 'DES'
                        ];
                    @endphp

                    @foreach($months as $key => $label)
                        <div style="background: #f0f9ff; padding: 10px; border-radius: 12px; border: 1px solid #bee3f8; text-align: center;">
                            <label style="display: block; font-weight: 700; color: #2b6cb0; margin-bottom: 8px; font-size: 13px;">{{ $label }}</label>
                            <input type="number" name="{{ $key }}" min="0" value="0" style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #90cdf4; border-radius: 8px; font-size: 14px; text-align: center; color: #2d3748;">
                        </div>
                    @endforeach
                </div>

                <div style="margin-top: 35px; display: flex; gap: 15px;">
                    <a href="{{ route('current.actual-spk-by-type.index') }}"
                        style="flex: 1; padding: 14px; background: #edf2f7; color: #4a5568; text-align: center; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 14px;">Batal</a>
                    <button type="submit"
                        style="flex: 2; padding: 14px; background: #1a202c; color: #1e293b; font-weight:800; border: none; border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        function targetForm() {
            return {
                selectedKategori: '',
                commercial_units: @json($commercial_units),
                passenger_units: @json($passenger_units),
            }
        }
    </script>
@endsection