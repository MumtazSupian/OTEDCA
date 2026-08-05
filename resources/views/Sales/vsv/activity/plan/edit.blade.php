@extends('layouts.app')
@section('content')
    <div style="padding: 40px 20px; display: flex; flex-direction: column; align-items: center; min-height: 100vh;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: #1e293b; font-weight:800; margin: 0; font-weight: 800; letter-spacing: 1px; text-transform: uppercase;">EDIT ACTIVITY PLAN</h2>
            <div style="width: 50px; height: 4px; background: #dc2626; margin: 10px auto; border-radius: 10px;"></div>
            <p style="color: #64748b; margin: 5px 0 0 0; font-size: 14px;">Sesuaikan kembali rencana aktivitas paman</p>
        </div>

        <div style="background: #ffffff; border-radius: 20px; padding: 30px; color: #333; box-shadow: 0 15px 35px rgba(0,0,0,0.15); width: 100%; max-width: 900px; box-sizing: border-box; overflow: hidden;">
            <form id="formEditPlan" action="{{ route('activity.plan.update', $plan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  gap: 30px;">
                    <div style="display: flex; gap: 30px; width: 100%; box-sizing: border-box; box-sizing: border-box;">
                        <div style="flex: 1; min-width: 0; max-width: 100%; box-sizing: border-box; min-width: 0; box-sizing: border-box;">
                            <label style="display: block; margin-bottom: 10px; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">Jenis Activity</label>
                            <select name="jenis_activity" required style="min-width: 0; max-width: 100%; box-sizing: border-box; width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #cbd5e0; border-radius: 8px;">
                                <option value="Offline" {{ old('jenis_activity', $plan->jenis_activity) == 'Offline' ? 'selected' : '' }}>Offline</option>
                                <option value="Online" {{ old('jenis_activity', $plan->jenis_activity) == 'Online' ? 'selected' : '' }}>Online</option>
                            </select>
                        </div>
                        <div style="flex: 1; min-width: 0; max-width: 100%; box-sizing: border-box; min-width: 0; box-sizing: border-box;">
                            <label style="display: block; margin-bottom: 10px; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">Activity</label>
                            <select name="activity" required style="min-width: 0; max-width: 100%; box-sizing: border-box; width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #cbd5e0; border-radius: 8px;">
                                @foreach(['D_MARKETING', 'EXHIBITION', 'MOVING_EXHIBITION', 'SHOWROOM_EVENT', 'GROUP_PRESENTATION', 'EVENT_TEST_DRIVE', 'OPEN_TABLE', 'CETAK_FLYER'] as $act)
                                    <option value="{{ $act }}" {{ old('activity', $plan->activity) == $act ? 'selected' : '' }}>{{ str_replace('_', ' ', $act) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label style="display: block; margin-bottom: 10px; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">Platform / Lokasi</label>
                        <input type="text" name="platform_lokasi" required value="{{ old('platform_lokasi', $plan->platform_lokasi) }}" style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #cbd5e0; border-radius: 8px;" placeholder="Masukkan lokasi atau platform">
                    </div>

                    <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 30px;">
                        <div>
                            <label style="display: block; margin-bottom: 10px; color: #2d3748; font-weight: 700; font-size: 13px;">TANGGAL RENCANA</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', $plan->tanggal) }}" required style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #cbd5e0; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 10px; color: #2d3748; font-weight: 700; font-size: 13px;">ESTIMASI BIAYA (Rp)</label>
                            <input type="number" name="total_cost" value="{{ old('total_cost', $plan->total_cost) }}" required style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #cbd5e0; border-radius: 8px;">
                        </div>
                    </div>

                    <div style="background: #f0f9ff; padding: 25px; border-radius: 15px; border: 1px solid #bee3f8;">
                        <h3 style="color: #dc2626; font-size: 14px; margin-bottom: 20px; font-weight: 800; text-transform: uppercase;">TARGET RENCANA</h3>
                        <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  grid-template-columns: repeat(3, 1fr); gap: 20px;">
                            <div><span style="font-size: 11px; font-weight: 800; color: #2b6cb0;">TARGET P</span><input type="number" name="target_p" value="{{ old('target_p', $plan->target_p) }}" required style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #90cdf4; border-radius: 8px; margin-top: 5px;"></div>
                            <div><span style="font-size: 11px; font-weight: 800; color: #2b6cb0;">TARGET HP</span><input type="number" name="target_hp" value="{{ old('target_hp', $plan->target_hp) }}" required style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #90cdf4; border-radius: 8px; margin-top: 5px;"></div>
                            <div><span style="font-size: 11px; font-weight: 800; color: #2b6cb0;">TARGET SPK</span><input type="number" name="target_spk" value="{{ old('target_spk', $plan->target_spk) }}" required style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #90cdf4; border-radius: 8px; margin-top: 5px;"></div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 10px; border-top: 2px solid #f7fafc; padding-top: 30px;">
                        <a href="{{ route('activity.plan.index') }}" style="padding: 14px 30px; background: #e2e8f0; color: #4a5568; border-radius: 10px; text-decoration: none; font-weight: 700;">BATAL</a>
                        <button type="button" onclick="confirmUpdate()" style="padding: 14px 45px; background: #1a202c; color: #1e293b; font-weight:800; border-radius: 10px; border: none; font-weight: 700; cursor: pointer;">UPDATE RENCANA</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmUpdate() {
            const form = document.getElementById('formEditPlan');
            
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            Swal.fire({
                title: 'Update Rencana?',
                text: "Data rencana aktivitas akan diperbarui paman!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#1a202c',
                cancelButtonColor: '#e53e3e',
                confirmButtonText: 'Ya, Update!',
                cancelButtonText: 'Cek Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
@endsection