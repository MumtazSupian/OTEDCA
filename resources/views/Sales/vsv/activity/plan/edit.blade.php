@extends('layouts.app')
@section('content')
    <div style="padding: 40px 20px; display: flex; flex-direction: column; align-items: center; min-height: 100vh;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="font-weight: 800; color: #1e293b !important; text-transform: uppercase; margin: 0;">EDIT ACTIVITY PLAN</h2>
            <div style="width: 50px; height: 4px; background: #dc2626; margin: 10px auto; border-radius: 10px;"></div>
            <p style="color: #64748b; margin: 5px 0 0 0; font-size: 14px;">Sesuaikan kembali seluruh rincian rencana aktivitas</p>
            <br>
            <p style="text-align:center; color: #475569; font-weight: 600; font-size: 13px; margin-bottom: 15px;">
                Mengedit data untuk Cabang: <strong style="color: #dc2626 !important; font-weight: 800;">{{ $plan->cabang ?: Auth::user()->cabang ?: "Pusat" }}</strong>
            </p>
        </div>

        <div style="background: #ffffff; border-radius: 20px; padding: 30px; color: #333; box-shadow: 0 15px 35px rgba(0,0,0,0.15); width: 100%; max-width: 900px; box-sizing: border-box; overflow: hidden;">
            <form id="formEditPlan" action="{{ route('activity.plan.update', $plan->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div style="display: grid; width: 100%; box-sizing: border-box; gap: 25px;">
                    
                    {{-- Jenis & Activity --}}
                    <div style="display: flex; gap: 20px; width: 100%; box-sizing: border-box;">
                        <div style="flex: 1; min-width: 0;">
                            <label style="display: block; margin-bottom: 8px; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">Jenis Activity</label>
                            <select name="jenis_activity" required style="width: 100%; padding: 12px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 10px; color: #2d3748; font-size: 14px;">
                                <option value="Offline" {{ old('jenis_activity', $plan->jenis_activity) == 'Offline' ? 'selected' : '' }}>Offline</option>
                                <option value="Online" {{ old('jenis_activity', $plan->jenis_activity) == 'Online' ? 'selected' : '' }}>Online</option>
                            </select>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <label style="display: block; margin-bottom: 8px; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">Activity</label>
                            <select name="activity" required style="width: 100%; padding: 12px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 10px; color: #2d3748; font-size: 14px;">
                                @foreach(['D_MARKETING', 'EXHIBITION', 'MOVING_EXHIBITION', 'SHOWROOM_EVENT', 'GROUP_PRESENTATION', 'EVENT_TEST_DRIVE', 'OPEN_TABLE', 'CETAK_FLYER'] as $act)
                                    <option value="{{ $act }}" {{ old('activity', $plan->activity) == $act ? 'selected' : '' }}>{{ str_replace('_', ' ', $act) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Platform / Lokasi --}}
                    <div>
                        <label style="display: block; margin-bottom: 8px; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">Platform / Lokasi</label>
                        <input type="text" name="platform_lokasi" value="{{ old('platform_lokasi', $plan->platform_lokasi) }}" required
                            style="width: 100%; box-sizing: border-box; padding: 12px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 10px;"
                            placeholder="Masukkan lokasi kegiatan atau platform online">
                    </div>

                    {{-- Display Unit --}}
                    <div style="background: #f0f9ff; padding: 20px; border-radius: 15px; border: 1px solid #bee3f8;">
                        <h3 style="color: #dc2626; margin-top: 0; font-size: 14px; margin-bottom: 15px; font-weight: 800; border-bottom: 2px solid #bee3f8; padding-bottom: 8px; display: inline-block; text-transform: uppercase;">DISPLAY UNIT</h3>
                        <div style="display: flex; gap: 20px; width: 100%; box-sizing: border-box;">
                            <div style="flex: 1; min-width: 0;">
                                <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 700; color: #4a5568;">Jenis Unit</label>
                                <select id="jenis_unit" name="jenis_unit" required style="width: 100%; padding: 10px; background: white; border: 1px solid #cbd5e0; border-radius: 8px;">
                                    <option value="Commercial" {{ old('jenis_unit', $plan->jenis_unit) == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                    <option value="Passenger" {{ old('jenis_unit', $plan->jenis_unit) == 'Passenger' ? 'selected' : '' }}>Passenger</option>
                                </select>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 700; color: #4a5568;">Type Unit</label>
                                <select id="type_unit" name="type_unit" required style="width: 100%; padding: 10px; background: white; border: 1px solid #cbd5e0; border-radius: 8px;"></select>
                            </div>
                        </div>
                    </div>

                    {{-- Tanggal, Jam, Sales/Shift --}}
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; color: #2d3748; font-weight: 700; font-size: 13px;">TANGGAL</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', $plan->tanggal) }}" required
                                style="width: 100%; box-sizing: border-box; padding: 10px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; color: #2d3748; font-weight: 700; font-size: 13px;">JAM</label>
                            <input type="time" name="jam" value="{{ old('jam', $plan->jam) }}" required
                                style="width: 100%; box-sizing: border-box; padding: 10px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; color: #2d3748; font-weight: 700; font-size: 13px;">SALES / SHIFT</label>
                            <input type="number" name="jml_sales_shift" value="{{ old('jml_sales_shift', $plan->jml_sales_shift) }}" required min="1"
                                style="width: 100%; box-sizing: border-box; padding: 10px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 8px;">
                        </div>
                    </div>

                    {{-- PIC Kegiatan --}}
                    <div>
                        <label style="display: block; margin-bottom: 8px; color: #2d3748; font-weight: 700; font-size: 13px;">PIC KEGIATAN</label>
                        <input type="text" name="pic" value="{{ old('pic', $plan->pic) }}" required
                            style="width: 100%; box-sizing: border-box; padding: 12px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 10px;"
                            placeholder="Masukkan nama penanggung jawab">
                    </div>

                    {{-- Target & Actual Grid --}}
                    <div style="background: #fff5f5; padding: 20px; border-radius: 15px; border: 1px solid #fed7d7;">
                        <h3 style="color: #c53030; font-size: 14px; margin-bottom: 15px; font-weight: 800; border-bottom: 2px solid #fed7d7; padding-bottom: 8px; display: inline-block; text-transform: uppercase;">TARGET & ACTUAL</h3>
                        
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 15px;">
                            <div>
                                <span style="font-size: 11px; font-weight: 800; color: #c53030;">TARGET P</span>
                                <input type="number" name="target_p" value="{{ old('target_p', $plan->target_p) }}" required min="0"
                                    style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #feb2b2; border-radius: 8px; margin-top: 4px;">
                            </div>
                            <div>
                                <span style="font-size: 11px; font-weight: 800; color: #c53030;">TARGET HP</span>
                                <input type="number" name="target_hp" value="{{ old('target_hp', $plan->target_hp) }}" required min="0"
                                    style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #feb2b2; border-radius: 8px; margin-top: 4px;">
                            </div>
                            <div>
                                <span style="font-size: 11px; font-weight: 800; color: #c53030;">TARGET SPK</span>
                                <input type="number" name="target_spk" value="{{ old('target_spk', $plan->target_spk) }}" required min="0"
                                    style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #feb2b2; border-radius: 8px; margin-top: 4px;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;">
                            <div>
                                <span style="font-size: 11px; font-weight: 700; color: #4a5568;">ACTUAL P</span>
                                <input type="number" name="actual_p" value="{{ old('actual_p', $plan->actual_p) }}" min="0"
                                    style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #cbd5e0; border-radius: 8px; background: white; margin-top: 4px;">
                            </div>
                            <div>
                                <span style="font-size: 11px; font-weight: 700; color: #4a5568;">ACTUAL HP</span>
                                <input type="number" name="actual_hp" value="{{ old('actual_hp', $plan->actual_hp) }}" min="0"
                                    style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #cbd5e0; border-radius: 8px; background: white; margin-top: 4px;">
                            </div>
                            <div>
                                <span style="font-size: 11px; font-weight: 700; color: #4a5568;">ACTUAL SPK</span>
                                <input type="number" name="actual_spk" value="{{ old('actual_spk', $plan->actual_spk) }}" min="0"
                                    style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #cbd5e0; border-radius: 8px; background: white; margin-top: 4px;">
                            </div>
                            <div>
                                <span style="font-size: 11px; font-weight: 700; color: #4a5568;">ACTUAL DO</span>
                                <input type="number" name="actual_do" value="{{ old('actual_do', $plan->actual_do) }}" min="0"
                                    style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #cbd5e0; border-radius: 8px; background: white; margin-top: 4px;">
                            </div>
                        </div>
                    </div>

                    {{-- Cost & Keterangan --}}
                    <div style="display: flex; gap: 20px; width: 100%; box-sizing: border-box;">
                        <div style="flex: 1; min-width: 0;">
                            <label style="display: block; margin-bottom: 8px; color: #2d3748; font-weight: 700; font-size: 13px;">TOTAL COST (Rp)</label>
                            <input type="number" name="total_cost" value="{{ old('total_cost', $plan->total_cost) }}" required
                                style="width: 100%; box-sizing: border-box; padding: 12px; background: #fffaf0; border: 2px solid #feebc8; border-radius: 10px;"
                                placeholder="0">
                        </div>
                        <div style="flex: 2;">
                            <label style="display: block; margin-bottom: 8px; color: #2d3748; font-weight: 700; font-size: 13px;">KETERANGAN</label>
                            <textarea name="keterangan" rows="2"
                                style="width: 100%; box-sizing: border-box; padding: 12px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 10px; font-family: inherit;"
                                placeholder="Keterangan tambahan...">{{ old('keterangan', $plan->keterangan) }}</textarea>
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 10px; border-top: 2px solid #f7fafc; padding-top: 25px;">
                        <a href="{{ route('activity.plan.index') }}"
                            style="padding: 14px 30px; background: #e2e8f0; color: #4a5568; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 14px;">BATAL</a>
                        <button type="button" onclick="confirmUpdatePlan()"
                            style="padding: 14px 45px; background: #dc2626; color: #ffffff !important; font-weight: 800; border-radius: 10px; border: none; font-size: 14px; cursor: pointer; box-shadow: 0 4px 14px rgba(220, 38, 38, 0.3); text-transform: uppercase;">
                            UPDATE RENCANA
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const unitOptions = {
                'Commercial': ['CARRY_PU', 'APV_BLIND_VAN'],
                'Passenger': ['S_PRESSO', 'BALENO', 'IGNIS', 'XL7', 'ALL_NEW_ERTIGA', 'GRAND_VITARA', 'JIMNY_3_DOOR', 'JIMNY_5_DOOR', 'FRONX']
            };

            const jenisSelect = document.getElementById('jenis_unit');
            const typeSelect = document.getElementById('type_unit');
            const selectedType = "{{ old('type_unit', $plan->type_unit) }}";

            function updateTypeOptions() {
                const jenis = jenisSelect.value;
                typeSelect.innerHTML = '';
                if (unitOptions[jenis]) {
                    unitOptions[jenis].forEach(function (unit) {
                        const option = document.createElement('option');
                        option.value = unit;
                        option.textContent = unit.replace(/_/g, ' ');
                        if (unit === selectedType) option.selected = true;
                        typeSelect.appendChild(option);
                    });
                }
            }

            jenisSelect.addEventListener('change', updateTypeOptions);
            updateTypeOptions();
        });

        function confirmUpdatePlan() {
            const form = document.getElementById('formEditPlan');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            Swal.fire({
                title: 'Update Activity Plan?',
                text: 'Pastikan data perubahan sudah benar.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Update!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
@endsection