<x-mail::message>
# Laporan Data Cabang Mingguan

Berikut adalah ringkasan laporan data cabang untuk minggu ini. Detail tabel konsumen lengkap sudah kami lampirkan dalam bentuk file PDF pada email ini.

@foreach($branchData as $branch => $data)
## Cabang: {{ strtoupper($branch ?: 'Tidak Diketahui') }}
- **Total Data Konsumen:** {{ $data->count() }}
- **Total Saldo Awal:** Rp {{ number_format($data->sum('saldo_awal'), 0, ',', '.') }}
- **Total Debet:** Rp {{ number_format($data->sum('debet'), 0, ',', '.') }}
- **Total Kredit:** Rp {{ number_format($data->sum('kredit'), 0, ',', '.') }}
- **Total Saldo Akhir:** Rp {{ number_format($data->sum('saldo_akhir'), 0, ',', '.') }}

---
@endforeach

Terima kasih,<br>
AR Suzuki Duta Cendana
</x-mail::message>