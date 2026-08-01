{{-- <div class="page-header">
    <div>
        <h1 class="page-title">{{ $pageTitle ?? 'Rekapitulasi Piutang' }}</h1>
        <p class="page-subtitle">{{ $pageSubtitle ?? 'Kelola data saldo awal, mutasi, rekonsiliasi GL, dan saldo akhir konsumen secara instan.' }}</p>
    </div>
    <div class="server-time">
        <span class="dot"></span>
        <span>Waktu Server: {{ now()->setTimezone('Asia/Jakarta')->format('d M Y \\p\\u\\k\\u\\l H.i') }} WIB</span>
    </div>
</div>

<div class="toolbar">
    <div class="search-wrapper">
        <input type="text" class="search-input" placeholder="Cari konsumen, no. bukti, plat/no. polisi, polis..." id="searchInput">
        <span class="search-shortcut">Ctrl+K</span>
    </div>
    <div class="toolbar-right">
        <span class="toolbar-label">Tampilkan:</span>
        <select class="toolbar-select" id="rowsPerPage">
            <option value="50">50 Baris</option>
            <option value="100">100 Baris</option>
            <option value="200">200 Baris</option>
        </select>
        @if(optional(Auth::user())->is_admin)
            <button class="btn-primary" onclick="openModal()" id="btnTambahData">Tambah Data</button>
        @endif
    </div>
</div>

<div class="table-container">
    <div class="table-scroll">
        <table class="data-table" id="piutangTable">
            <thead>
                <tr>
                    <th rowspan="2">NO</th>
                    <th rowspan="2">NO SPK</th>
                    <th rowspan="2">TGL. BUKTI</th>
                    <th rowspan="2">NO. BUKTI</th>
                    <th rowspan="2">SPK</th>
                    <th rowspan="2">SALDO AWAL</th>
                    <th colspan="2" style="text-align:center; border-bottom:1px solid var(--border-color);">MUTASI</th>
                    <th rowspan="2">TGL. BUKTI</th>
                    <th rowspan="2" class="hl">NO. BUKTI</th>
                    <th rowspan="2">SALDO AKHIR</th>
                    <th rowspan="2">KETERANGAN</th>
                    <th rowspan="2">NO POLISI</th>
                    <th rowspan="2">NO POLIS</th>
                    <th rowspan="2">SPK</th>
                    <th rowspan="2">AKSI</th>
                </tr>
                <tr>
                    <th>DEBET</th>
                    <th>KREDIT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>testing</td>
                    <td>21 May 2026</td>
                    <td>1234</td>
                    <td class="text-bold">1.200.000</td>
                    <td class="text-green">2.000</td>
                    <td class="text-cyan">2.000</td>
                    <td>20 May 2026</td>
                    <td>ndjnrc</td>
                    <td class="text-bold">1.200.000</td>
                    <td class="text-red">foufumf</td>
                    <td class="text-green">djrr+fur</td>
                    <td class="text-purple">uLFrbF</td>
                    <td class="text-orange">no. FAbrif</td>
                    <td>
                        <div style="display:flex;gap:4px;">
                            <button class="action-btn edit" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>
                            <button class="action-btn delete" title="Hapus"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>testing</td>
                    <td>21 May 2026</td>
                    <td>1234</td>
                    <td class="text-bold">1.200.000</td>
                    <td class="text-green">2.000</td>
                    <td class="text-cyan">2.000</td>
                    <td>20 May 2026</td>
                    <td>ndjnrc</td>
                    <td class="text-bold">1.200.000</td>
                    <td class="text-amber">foufumf</td>
                    <td class="text-purple">ujrr+fur</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <div style="display:flex;gap:4px;">
                            <button class="action-btn edit" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>
                            <button class="action-btn delete" title="Hapus"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>testing</td>
                    <td>21 May 2026</td>
                    <td>1234</td>
                    <td class="text-bold">1.200.000</td>
                    <td class="text-green">2.000</td>
                    <td class="text-cyan">2.000</td>
                    <td>20 May 2026</td>
                    <td>ndjnrc</td>
                    <td class="text-bold">1.200.000</td>
                    <td class="text-pink">foufumf</td>
                    <td class="text-orange">djrr+fur</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <div style="display:flex;gap:4px;">
                            <button class="action-btn edit" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>
                            <button class="action-btn delete" title="Hapus"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>testing</td>
                    <td>21 May 2026</td>
                    <td>1234</td>
                    <td class="text-bold">1.200.000</td>
                    <td class="text-green">2.000</td>
                    <td class="text-cyan">2.000</td>
                    <td>20 May 2026</td>
                    <td>wwwwwwwwwwwwwwwwwww</td>
                    <td class="text-bold">1.200.000</td>
                    <td class="text-blue">foufumf</td>
                    <td class="text-red">djrr+fur</td>
                    <td class="text-amber">uLfrbf</td>
                    <td class="text-cyan">no. FAbrif</td>
                    <td>
                        <div style="display:flex;gap:4px;">
                            <button class="action-btn edit" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>
                            <button class="action-btn delete" title="Hapus"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                        </div>
                    </td>
                </tr>

                <tr class="row-total">
                    <td colspan="4"><strong>TOTAL</strong></td>
                    <td class="text-bold">4.800.000</td>
                    <td class="text-green text-bold">8.000</td>
                    <td class="text-cyan text-bold">8.000</td>
                    <td colspan="2"></td>
                    <td class="text-bold">4.800.000</td>
                    <td colspan="5"></td>
                </tr>

                <tr class="row-gl">
                    <td colspan="4"><strong>GL</strong></td>
                    <td class="text-bold">4.800.000</td>
                    <td class="text-green text-bold">8.000</td>
                    <td class="text-cyan text-bold">8.000</td>
                    <td>–</td>
                    <td></td>
                    <td class="text-bold">4.800.000</td>
                    <td colspan="5"></td>
                </tr>

                <tr class="row-selisih">
                    <td colspan="4"><strong>SELISIH</strong></td>
                    <td>–</td>
                    <td>–</td>
                    <td>–</td>
                    <td>–</td>
                    <td></td>
                    <td>–</td>
                    <td colspan="5"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal-overlay" id="createModal">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title">Tambah Data Piutang</h2>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="createForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">No SPK</label>
                        <input type="text" name="no_spk" class="form-input" placeholder="No SPK" id="inputNoSpk">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tgl. Bukti</label>
                        <input type="date" class="form-input" id="inputTglBukti">
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. Bukti</label>
                        <input type="text" class="form-input" placeholder="Nomor bukti" id="inputNoBukti">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Saldo Awal</label>
                        <input type="text" name="saldo_awal" class="form-input" placeholder="0" id="inputSaldoAwal">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kategori SPK</label>
                        <select name="spk_type" class="form-select" id="inputSpkType">
                            <option value="">Pilih Jenis SPK</option>
                            <option value="ASURANSI">ASURANSI</option>
                            <option value="REGULER">REGULER</option>
                            <option value="INTERNAL">INTERNAL</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Debet</label>
                        <input type="text" class="form-input" placeholder="0" id="inputDebet">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kredit</label>
                        <input type="text" class="form-input" placeholder="0" id="inputKredit">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tgl. Bukti (Rekonsiliasi)</label>
                        <input type="date" class="form-input" id="inputTglBukti2">
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. Bukti (Rekonsiliasi)</label>
                        <input type="text" class="form-input" placeholder="Nomor bukti" id="inputNoBukti2">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keterangan</label>
                        <input type="text" class="form-input" placeholder="Keterangan" id="inputKeterangan">
                    </div>
                    <div class="form-group">
                        <label class="form-label">No Polisi</label>
                        <input type="text" class="form-input" placeholder="Nomor polisi" id="inputNoPolisi">
                    </div>
                    <div class="form-group">
                        <label class="form-label">No Polis</label>
                        <input type="text" class="form-input" placeholder="Nomor polis" id="inputNoPolis">
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">Saldo Akhir</label>
                        <input type="text" class="form-input" placeholder="Saldo Akhir" id="inputNomorSpk">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn-secondary" onclick="closeModal()">Batal</button>
            <button class="btn-primary" onclick="submitForm()">Simpan</button>
        </div>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('createModal').classList.add('show');
    }
    function closeModal() {
        document.getElementById('createModal').classList.remove('show');
    }
    function submitForm() {
        alert('Data berhasil disimpan!');
        closeModal();
    }

    document.getElementById('createModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'k') {
            e.preventDefault();
            document.getElementById('searchInput').focus();
        }
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script> --}}
