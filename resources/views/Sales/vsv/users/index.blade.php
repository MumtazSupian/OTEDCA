@extends('layouts.app')

@section('title', 'Daftar User')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Memperkecil Pagination agar tidak raksasa */
    .pagination svg { width: 15px !important; height: 15px !important; }
    .pagination nav div:first-child { display: none !important; } /* Sembunyikan teks "Showing X to Y" */
    .pagination nav { display: flex; justify-content: center; gap: 5px; }
    .pagination span, .pagination a { 
        padding: 5px 10px !important; 
        font-size: 11px !important; 
        border-radius: 5px !important;
        text-decoration: none !important;
    }
</style>

<div style="padding: 30px 20px; display: flex; flex-direction: column; align-items: center; min-height: 100vh; background-color: #0f172a; font-family: 'Inter', sans-serif;">

    {{-- HEADER (Sesuai Gambar 2) --}}
    <div style="text-align: center; margin-bottom: 25px;">
        <h2 style="font-weight:800; color:#1e293b; font-weight:800; letter-spacing:1px; text-transform:uppercase; margin:0; font-size: 22px;">
            MANAGEMENT USER
        </h2>
        <div style="width: 45px; height: 3px; background: #319795; margin: 8px auto; border-radius: 10px;"></div>
        <p style="color: #64748b; font-size: 13px; opacity: 0.8;">Kelola dan organisir akun pengguna sistem berdasarkan cabang</p>
    </div>

    {{-- KONTINER TABEL --}}
    <div style="background: white; width: 100%; max-width: 950px; padding: 20px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 style="margin: 0; color: #2d3748; font-weight: 700; font-size: 16px;">Daftar Pengguna</h3>
            <a href="{{ route('users.create') }}" 
               style="text-decoration: none; background: #319795; color: #1e293b; font-weight:800; padding: 7px 14px; border-radius: 6px; font-weight: 600; font-size: 12px; display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-plus"></i> Tambah User
            </a>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 2px solid #edf2f7;">
                        <th style="padding: 12px; text-align: left; color: #4a5568; font-weight: 700;">NAMA</th>
                        <th style="padding: 12px; text-align: left; color: #4a5568; font-weight: 700;">EMAIL</th>
                        <th style="padding: 12px; text-align: left; color: #4a5568; font-weight: 700;">CABANG</th>
                        <th style="padding: 12px; text-align: center; color: #4a5568; font-weight: 700;">ROLE</th>
                        <th style="padding: 12px; text-align: center; color: #4a5568; font-weight: 700;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Diurutkan berdasarkan Cabang --}}
                    @foreach($users->sortBy('cabang') as $user)
                        <tr style="border-bottom: 1px solid #edf2f7; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='white'">
                            <td style="padding: 10px 12px; font-weight: 600; color: #2d3748;">{{ $user->name }}</td>
                            <td style="padding: 10px 12px; color: #718096; font-size: 12px;">{{ $user->email }}</td>
                            <td style="padding: 10px 12px;">
                                <span style="background: #e6fffa; color: #2c7a7b; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; border: 1px solid #b2f5ea;">
                                    <i class="fas fa-map-marker-alt" style="font-size: 10px;"></i> {{ strtoupper($user->cabang) }}
                                </span>
                            </td>
                            <td style="padding: 10px 12px; text-align: center;">
                                <span style="background: #ebf8ff; color: #2b6cb0; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 800; border: 1px solid #bee3f8;">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>
                            <td style="padding: 10px 12px; text-align: center;">
                                <div style="display: flex; justify-content: center; gap: 8px;">
                                    <a href="{{ route('users.edit', $user->id) }}" style="color: #d69e2e;" title="Edit"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="margin:0;">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this)" style="background:none; border:none; color:#e53e3e; cursor:pointer; padding:0;"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PAGINATION RAPI & KECIL --}}
        <div class="pagination" style="margin-top: 20px;">
            {{ $users->links() }}
        </div>
    </div>
</div>

<script>
    function confirmDelete(btn) {
        Swal.fire({
            title: 'Hapus User?',
            text: "Data tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e53e3e',
            cancelButtonColor: '#718096',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) btn.closest('form').submit();
        });
    }
</script>
@endsection