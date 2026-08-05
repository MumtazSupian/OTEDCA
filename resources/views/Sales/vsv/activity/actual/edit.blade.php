@extends('layouts.app')
@section('content')
    <div style="padding: 40px 20px; display: flex; flex-direction: column; align-items: center; min-height: 100vh;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: #1e293b; font-weight:800; margin: 0; font-weight: 800; letter-spacing: 1px; text-transform: uppercase;">EDIT ACTIVITY ACTUAL</h2>
            <div style="width: 50px; height: 4px; background: #e53e3e; margin: 10px auto; border-radius: 10px;"></div>
            <p style="color: #64748b; margin: 5px 0 0 0; font-size: 14px;">Perbarui data rencana dan realisasi aktivitas</p>
            <br>
            <p style="text-align:center; color: #475569; font-weight: 600; font-size: 13px; margin-bottom: 15px;">
                Mengupdate data untuk Cabang: <strong style="color: #dc2626; font-weight: 800;">{{ Auth::user()->cabang }}</strong>
            </p>
        </div>

        <div style="background: #ffffff; border-radius: 20px; padding: 30px; color: #333; box-shadow: 0 15px 35px rgba(0,0,0,0.15); width: 100%; max-width: 900px; box-sizing: border-box; overflow: hidden;">
            <form id="formEditActivity" action="{{ route('activity.actual.update', $activity->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  gap: 30px;">
                    <div style="display: flex; gap: 30px; width: 100%; box-sizing: border-box; box-sizing: border-box;">
                        <div style="flex: 1; min-width: 0; max-width: 100%; box-sizing: border-box; min-width: 0; box-sizing: border-box;">
                            <label style="display: block; margin-bottom: 10px; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">Jenis Activity</label>
                            <select name="jenis_activity" required style="min-width: 0; max-width: 100%; box-sizing: border-box; width: 100%; box-sizing: border-box; padding: 14px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 10px;">
                                <option value="Offline" {{ $activity->jenis_activity == 'Offline' ? 'selected' : '' }}>Offline</option>
                                <option value="Online" {{ $activity->jenis_activity == 'Online' ? 'selected' : '' }}>Online</option>
                            </select>
                        </div>
                        <div style="flex: 1; min-width: 0; max-width: 100%; box-sizing: border-box; min-width: 0; box-sizing: border-box;">
                            <label style="display: block; margin-bottom: 10px; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">Activity</label>
                            <select name="activity" required style="min-width: 0; max-width: 100%; box-sizing: border-box; width: 100%; box-sizing: border-box; padding: 14px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 10px;">
                                @foreach(['D_MARKETING', 'EXHIBITION', 'MOVING_EXHIBITION', 'SHOWROOM_EVENT', 'GROUP_PRESENTATION', 'EVENT_TEST_DRIVE', 'OPEN_TABLE', 'CETAK_FLYER'] as $act)
                                    <option value="{{ $act }}" {{ $activity->activity == $act ? 'selected' : '' }}>{{ str_replace('_', ' ', $act) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label style="display: block; margin-bottom: 10px; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">Platform / Lokasi</label>
                        <input type="text" name="platform_lokasi" value="{{ $activity->platform_lokasi }}" required style="width: 100%; box-sizing: border-box; padding: 14px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 10px;">
                    </div>

                    <div style="background: #f0f9ff; padding: 25px; border-radius: 15px; border: 1px solid #bee3f8;">
                        <h3 style="color: #dc2626; margin-top: 0; font-size: 14px; margin-bottom: 20px; font-weight: 800; border-bottom: 2px solid #bee3f8; padding-bottom: 10px; display: inline-block; text-transform: uppercase;">DISPLAY UNIT</h3>
                        <div style="display: flex; gap: 30px; width: 100%; box-sizing: border-box; box-sizing: border-box;">
                            <div style="flex: 1; min-width: 0; max-width: 100%; box-sizing: border-box; min-width: 0; box-sizing: border-box;">
                                <label style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; color: #4a5568;">Jenis Unit</label>
                                <select id="jenis_unit" name="jenis_unit" required style="min-width: 0; max-width: 100%; box-sizing: border-box; width: 100%; box-sizing: border-box; padding: 12px; background: white; border: 1px solid #cbd5e0; border-radius: 8px;">
                                    <option value="Commercial" {{ $activity->jenis_unit == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                    <option value="Passenger" {{ $activity->jenis_unit == 'Passenger' ? 'selected' : '' }}>Passenger</option>
                                </select>
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 100%; box-sizing: border-box; min-width: 0; box-sizing: border-box;">
                                <label style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; color: #4a5568;">Type Unit</label>
                                <select id="type_unit" name="type_unit" required style="min-width: 0; max-width: 100%; box-sizing: border-box; width: 100%; box-sizing: border-box; padding: 12px; background: white; border: 1px solid #cbd5e0; border-radius: 8px;"></select>
                            </div>
                        </div>
                    </div>

                    <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 30px;">
                        <div>
                            <label style="display: block; margin-bottom: 10px; color: #2d3748; font-weight: 700; font-size: 13px;">TANGGAL</label>
                            <input type="date" name="tanggal" value="{{ $activity->tanggal }}" required style="width: 100%; box-sizing: border-box; padding: 12px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 10px; color: #2d3748; font-weight: 700; font-size: 13px;">JAM</label>
                            <input type="time" name="jam" value="{{ \Carbon\Carbon::parse($activity->jam)->format('H:i') }}" required style="width: 100%; box-sizing: border-box; padding: 12px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 10px; color: #2d3748; font-weight: 700; font-size: 13px;">SALES / SHIFT</label>
                            <input type="number" name="jml_sales_shift" value="{{ $activity->jml_sales_shift }}" required style="width: 100%; box-sizing: border-box; padding: 12px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 8px;">
                        </div>
                    </div>

                    <div>
                        <label style="display: block; margin-bottom: 10px; color: #2d3748; font-weight: 700; font-size: 13px;">PIC KEGIATAN</label>
                        <input type="text" name="pic" value="{{ $activity->pic }}" required style="width: 100%; box-sizing: border-box; padding: 14px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 10px;">
                    </div>

                    <div style="background: #fff5f5; padding: 25px; border-radius: 15px; border: 1px solid #fed7d7;">
                        <h3 style="color: #c53030; font-size: 14px; margin-bottom: 20px; font-weight: 800; border-bottom: 2px solid #fed7d7; padding-bottom: 10px; display: inline-block; text-transform: uppercase;">TARGET & ACTUAL (UPDATE HASIL)</h3>
                        <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                            <div><span style="font-size: 11px; font-weight: 800; color: #c53030;">TARGET P</span><input type="number" name="target_p" value="{{ $activity->target_p }}" style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #feb2b2; border-radius: 8px; margin-top: 5px;"></div>
                            <div><span style="font-size: 11px; font-weight: 800; color: #c53030;">TARGET HP</span><input type="number" name="target_hp" value="{{ $activity->target_hp }}" style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #feb2b2; border-radius: 8px; margin-top: 5px;"></div>
                            <div><span style="font-size: 11px; font-weight: 800; color: #c53030;">TARGET SPK</span><input type="number" name="target_spk" value="{{ $activity->target_spk }}" style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #feb2b2; border-radius: 8px; margin-top: 5px;"></div>
                        </div>
                        <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  grid-template-columns: repeat(4, 1fr); gap: 15px;">
                            <input type="number" name="actual_p" value="{{ $activity->actual_p }}" placeholder="Actual P" style="padding: 12px; border: 1px solid #cbd5e0; border-radius: 8px;">
                            <input type="number" name="actual_hp" value="{{ $activity->actual_hp }}" placeholder="Actual HP" style="padding: 12px; border: 1px solid #cbd5e0; border-radius: 8px;">
                            <input type="number" name="actual_spk" value="{{ $activity->actual_spk }}" placeholder="Actual SPK" style="padding: 12px; border: 1px solid #cbd5e0; border-radius: 8px;">
                            <input type="number" name="actual_do" value="{{ $activity->actual_do }}" placeholder="Actual DO" style="padding: 12px; border: 1px solid #cbd5e0; border-radius: 8px;">
                        </div>
                    </div>

                    <div style="display: flex; gap: 30px; width: 100%; box-sizing: border-box; box-sizing: border-box;">
                        <div style="flex: 1; min-width: 0; max-width: 100%; box-sizing: border-box; min-width: 0; box-sizing: border-box;">
                            <label style="display: block; margin-bottom: 10px; color: #2d3748; font-weight: 700; font-size: 13px;">TOTAL COST (Rp)</label>
                            <input type="number" name="total_cost" value="{{ $activity->total_cost }}" required style="width: 100%; box-sizing: border-box; padding: 14px; background: #fffaf0; border: 2px solid #feebc8; border-radius: 10px;">
                        </div>
                        <div style="flex: 2;">
                            <label style="display: block; margin-bottom: 10px; color: #2d3748; font-weight: 700; font-size: 13px;">KETERANGAN</label>
                            <textarea name="keterangan" rows="2" style="width: 100%; box-sizing: border-box; padding: 14px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 10px; font-family: inherit;">{{ $activity->keterangan }}</textarea>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 10px; border-top: 2px solid #f7fafc; padding-top: 30px;">
                        <a href="{{ route('activity.actual.index') }}" style="padding: 14px 30px; background: #e2e8f0; color: #4a5568; border-radius: 10px; text-decoration: none; font-weight: 700;">BATAL</a>
                        <button type="button" onclick="confirmUpdate()" style="padding: 14px 45px; background: #1a202c; color: #1e293b; font-weight:800; border-radius: 10px; border: none; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">UPDATE AKTIVITAS</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmUpdate() {
            const form = document.getElementById('formEditActivity');
            if(!form.checkValidity()){
                form.reportValidity();
                return;
            }

            Swal.fire({
                title: 'Update Data?',
                text: "Pastikan perubahan sudah benar paman!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1a202c',
                cancelButtonColor: '#e53e3e',
                confirmButtonText: 'Ya, Update!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const jenisSelect = document.getElementById('jenis_unit');
            const typeSelect = document.getElementById('type_unit');
            const typeUnits = {
                Commercial: ['CARRY_PU', 'CARRY_BOX', 'CARRY_BV', 'CARRY_MOKO', 'CARRY_AMBULANCE', 'CARRY_TOWING'],
                Passenger: ['APV_MB', 'APV_AMBULANCE', 'ERTIGA', 'ERTIGA_HYBRID', 'XL7', 'XL7_HYBRID', 'S_PRESSO', 'IGNIS', 'BALENO', 'GRAND_VITARA', 'JIMNY']
            };

            function updateTypeUnit() {
                const selectedJenis = jenisSelect.value;
                const options = typeUnits[selectedJenis] || [];
                const currentType = "{{ $activity->type_unit }}";
                
                typeSelect.innerHTML = '';
                options.forEach(type => {
                    const opt = document.createElement('option');
                    opt.value = type;
                    opt.textContent = type.replace(/_/g, ' ');
                    if(type === currentType) opt.selected = true;
                    typeSelect.appendChild(opt);
                });
            }

            updateTypeUnit();
            jenisSelect.addEventListener('change', updateTypeUnit);
        });
    </script>
@endsection