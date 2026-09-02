@extends('layouts.app')

@section('title', 'Duplicate Review - Database Konsumen')

@section('content')
<div class="duplicate-review-container">
    {{-- 1. HEADER SECTION --}}
    <div class="page-header-row">
        <div class="header-text-group">
            <h1 class="page-title">Duplicate Review</h1>
            <p class="page-subtitle">Review pasangan konsumen yang terdeteksi duplikat</p>
        </div>
        <div class="header-action-group">
            <button type="button" class="btn-guide-system" onclick="openSystemGuide()">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
                <span>Cara Kerja Sistem</span>
            </button>
        </div>
    </div>

    {{-- 2. KETERANGAN SUMBER DATA BANNER --}}
    <div class="legend-card">
        <div class="legend-header">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #475569;">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            <span>Keterangan Sumber Data:</span>
        </div>
        <div class="legend-items">
            <div class="legend-item">
                <span class="badge-source badge-src-penjualan">Hanya Penjualan</span>
                <span class="legend-desc">Ada di data penjualan, belum pernah service</span>
            </div>
            <div class="legend-item">
                <span class="badge-source badge-src-service">Hanya Service</span>
                <span class="legend-desc">Ada di riwayat service, tidak ada di data penjualan</span>
            </div>
            <div class="legend-item">
                <span class="badge-source badge-src-both">Penjualan & Service</span>
                <span class="legend-desc">Ada di data penjualan dan riwayat service</span>
            </div>
            <div class="legend-item">
                <span class="badge-source badge-src-database">Hanya Database</span>
                <span class="legend-desc">Tidak ada di penjualan maupun service (master database saja)</span>
            </div>
        </div>
    </div>

    {{-- 3. FILTER & SEARCH CARD --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('customer.duplicate_review') }}" id="filterForm">
            <div class="filter-grid">
                {{-- Status --}}
                <div class="filter-item">
                    <label class="filter-label">Status</label>
                    <select name="status" class="select-control">
                        <option value="Pending" {{ ($status ?? 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ ($status ?? '') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Dismissed" {{ ($status ?? '') == 'Dismissed' ? 'selected' : '' }}>Dismissed</option>
                        <option value="Auto Resolved" {{ ($status ?? '') == 'Auto Resolved' ? 'selected' : '' }}>Auto Resolved</option>
                        <option value="Superseded" {{ ($status ?? '') == 'Superseded' ? 'selected' : '' }}>Superseded</option>
                    </select>
                </div>

                {{-- Confidence --}}
                <div class="filter-item">
                    <label class="filter-label">Confidence</label>
                    <select name="confidence" class="select-control">
                        <option value="Semua" {{ ($confidence ?? 'Semua') == 'Semua' ? 'selected' : '' }}>Semua</option>
                        <option value="High" {{ ($confidence ?? '') == 'High' ? 'selected' : '' }}>High (≥80)</option>
                        <option value="Medium" {{ ($confidence ?? '') == 'Medium' ? 'selected' : '' }}>Medium (50–79)</option>
                        <option value="Low" {{ ($confidence ?? '') == 'Low' ? 'selected' : '' }}>Low (<50)</option>
                    </select>
                </div>

                {{-- Sumber Data --}}
                <div class="filter-item">
                    <label class="filter-label">Sumber Data</label>
                    <select name="sumber_data" class="select-control">
                        <option value="Semua Sumber" {{ ($sumberData ?? 'Semua Sumber') == 'Semua Sumber' ? 'selected' : '' }}>Semua Sumber</option>
                        <option value="Penjualan" {{ ($sumberData ?? '') == 'Penjualan' ? 'selected' : '' }}>Penjualan</option>
                        <option value="Hanya Penjualan" {{ ($sumberData ?? '') == 'Hanya Penjualan' ? 'selected' : '' }}>Hanya Penjualan</option>
                        <option value="Hanya Service" {{ ($sumberData ?? '') == 'Hanya Service' ? 'selected' : '' }}>Hanya Service</option>
                        <option value="Penjualan & Service" {{ ($sumberData ?? '') == 'Penjualan & Service' ? 'selected' : '' }}>Penjualan & Service</option>
                        <option value="Hanya Database" {{ ($sumberData ?? '') == 'Hanya Database' ? 'selected' : '' }}>Hanya Database</option>
                    </select>
                </div>

                {{-- Button Cari --}}
                <div class="filter-item filter-btn-box">
                    <button type="submit" class="btn-search-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <span>Cari</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- 4. SUBTOOLBAR --}}
    <div class="subtoolbar-row">
        <div class="pending-count-badge">
            <span>{{ count($samplePairs) }} pasang pending</span>
        </div>
        <div class="select-all-box">
            <label class="checkbox-label">
                <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)">
                <span>Pilih semua di halaman ini ({{ count($samplePairs) }})</span>
            </label>
        </div>
    </div>

    {{-- 5. DUPLICATE PAIR COMPARISON CARDS --}}
    <div class="duplicate-pairs-stack">
        @forelse($samplePairs as $pair)
        <div class="pair-card-wrapper" id="pairCard-{{ $pair['id'] }}">
            {{-- Pair Header Bar --}}
            <div class="pair-header-bar">
                <div class="pair-header-left">
                    <input type="checkbox" class="pair-checkbox" id="pairCheck-{{ $pair['id'] }}" onchange="onPairCheckboxChange({{ $pair['id'] }})">
                    <span class="badge-rule">{{ $pair['rule_code'] }}</span>
                    <span class="badge-match-type">{{ $pair['match_type'] }}</span>
                </div>
                <div class="pair-header-right">
                    <span class="badge-score">Score {{ $pair['score'] }} — {{ $pair['confidence_level'] }}</span>
                    <span class="badge-status-pending">{{ $pair['status'] }}</span>
                </div>
            </div>

            {{-- Hint Selection Banner --}}
            <div class="selection-hint-banner">
                <span>Klik kartu untuk memilih <strong>data yang akan dipakai</strong> sebagai data utama.</span>
            </div>

            {{-- Comparison Split Layout --}}
            <div class="comparison-grid">
                {{-- KARTU KIRI (DATA A) --}}
                <div class="candidate-card candidate-left" id="cardA-{{ $pair['id'] }}" onclick="selectCandidate({{ $pair['id'] }}, 'left')">
                    <div class="candidate-header">
                        <span class="candidate-name">{{ $pair['data_left']['nama'] }}</span>
                        <span class="select-indicator" id="indicatorA-{{ $pair['id'] }}">Klik untuk pilih</span>
                    </div>

                    <table class="candidate-spec-table">
                        <tbody>
                            <tr>
                                <td class="spec-lbl">Tipe</td>
                                <td class="spec-val">{{ $pair['data_left']['tipe'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Sumber</td>
                                <td class="spec-val">
                                    @if($pair['data_left']['sumber'] != '-')
                                        <span class="badge-source badge-src-penjualan">{{ $pair['data_left']['sumber'] }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">NIK</td>
                                <td class="spec-val font-mono">{{ $pair['data_left']['nik'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Gender</td>
                                <td class="spec-val">{{ $pair['data_left']['gender'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Tgl Lahir</td>
                                <td class="spec-val font-mono">{{ $pair['data_left']['tgl_lahir'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">HP</td>
                                <td class="spec-val font-mono">{{ $pair['data_left']['hp'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Email</td>
                                <td class="spec-val">{{ $pair['data_left']['email'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Alamat</td>
                                <td class="spec-val">{{ $pair['data_left']['alamat'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Kendaraan</td>
                                <td class="spec-val">{{ $pair['data_left']['kendaraan'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Transaksi</td>
                                <td class="spec-val font-mono">{{ $pair['data_left']['transaksi'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Service</td>
                                <td class="spec-val font-mono">{{ $pair['data_left']['service'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Diperbarui</td>
                                <td class="spec-val font-mono">{{ $pair['data_left']['diperbarui'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Kelengkapan</td>
                                <td class="spec-val font-bold">{{ $pair['data_left']['kelengkapan'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- VS SEPARATOR --}}
                <div class="vs-divider">
                    <span class="vs-circle">VS</span>
                </div>

                {{-- KARTU KANAN (DATA B) --}}
                <div class="candidate-card candidate-right" id="cardB-{{ $pair['id'] }}" onclick="selectCandidate({{ $pair['id'] }}, 'right')">
                    <div class="candidate-header">
                        <span class="candidate-name">{{ $pair['data_right']['nama'] }}</span>
                        <span class="select-indicator" id="indicatorB-{{ $pair['id'] }}">Klik untuk pilih</span>
                    </div>

                    <table class="candidate-spec-table">
                        <tbody>
                            <tr>
                                <td class="spec-lbl">Tipe</td>
                                <td class="spec-val">{{ $pair['data_right']['tipe'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Sumber</td>
                                <td class="spec-val">
                                    @if($pair['data_right']['sumber'] != '-')
                                        <span class="badge-source badge-src-service">{{ $pair['data_right']['sumber'] }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">NIK</td>
                                <td class="spec-val font-mono">{{ $pair['data_right']['nik'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Gender</td>
                                <td class="spec-val">{{ $pair['data_right']['gender'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Tgl Lahir</td>
                                <td class="spec-val font-mono">{{ $pair['data_right']['tgl_lahir'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">HP</td>
                                <td class="spec-val font-mono">{{ $pair['data_right']['hp'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Email</td>
                                <td class="spec-val">{{ $pair['data_right']['email'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Alamat</td>
                                <td class="spec-val">{{ $pair['data_right']['alamat'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Kendaraan</td>
                                <td class="spec-val">{{ $pair['data_right']['kendaraan'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Transaksi</td>
                                <td class="spec-val font-mono">{{ $pair['data_right']['transaksi'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Service</td>
                                <td class="spec-val font-mono">{{ $pair['data_right']['service'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Diperbarui</td>
                                <td class="spec-val font-mono">{{ $pair['data_right']['diperbarui'] }}</td>
                            </tr>
                            <tr>
                                <td class="spec-lbl">Kelengkapan</td>
                                <td class="spec-val font-bold">{{ $pair['data_right']['kelengkapan'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Action Buttons Footer --}}
            <div class="pair-actions-footer">
                <button type="button" class="btn-action-confirm" onclick="confirmMerge({{ $pair['id'] }})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span>Konfirmasi</span>
                </button>
                <button type="button" class="btn-action-dismiss" onclick="dismissPair({{ $pair['id'] }})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    <span>Dismiss</span>
                </button>
                <button type="button" class="btn-action-note" onclick="addNote({{ $pair['id'] }})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9"></path>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                    </svg>
                    <span>Catat</span>
                </button>
            </div>
        </div>
        @empty
        <div class="empty-pairs-card">
            <p style="color: #94a3b8; font-size: 14px; margin: 0;">Tidak ada pasangan data duplikat yang perlu direview.</p>
        </div>
        @endforelse
    </div>

    {{-- FLOATING BOTTOM ACTION BAR --}}
    <div class="floating-action-bar" id="floatingActionBar" style="display: none;">
        <div class="floating-bar-content">
            <div class="floating-bar-left">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 11 12 14 22 4"></polyline>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                </svg>
                <span id="floatingCountText">1 pasang dipilih</span>
            </div>
            <div class="floating-bar-actions">
                <button type="button" class="btn-floating-confirm" onclick="confirmAllSelected()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span>Konfirmasi Semua</span>
                </button>
                <button type="button" class="btn-floating-dismiss" onclick="dismissAllSelected()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    <span>Dismiss Semua</span>
                </button>
                <button type="button" class="btn-floating-close" onclick="hideFloatingBar()">&times;</button>
            </div>
        </div>
    </div>

    {{-- MODAL 1: CARA KERJA SISTEM DETEKSI DUPLIKAT --}}
    <div class="modal-backdrop" id="modalSystemGuide">
        <div class="modal-dialog modal-guide-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Cara Kerja Sistem Deteksi Duplikat</h3>
                <button type="button" class="btn-modal-close" onclick="closeSystemGuide()">&times;</button>
            </div>
            <div class="modal-body modal-guide-body">
                {{-- 1. Bagaimana Sistem Bekerja --}}
                <div class="guide-section">
                    <div class="guide-section-title">
                        <span class="guide-icon">⚙️</span>
                        <h4>Bagaimana Sistem Bekerja</h4>
                    </div>
                    <p class="guide-text">
                        Sistem secara otomatis memindai seluruh data konsumen setiap kali sinkronisasi dijalankan. Setiap pasangan yang terdeteksi mirip diberi <strong>skor kepercayaan (0–100)</strong> berdasarkan sinyal yang cocok. Pasangan dengan bukti kuat langsung diselesaikan otomatis (<em>auto-resolved</em>); sisanya masuk antrian <em>pending</em> untuk diputuskan oleh pengguna.
                    </p>
                    <div class="guide-definitions">
                        <div class="def-row">
                            <span class="def-term">Data Utama</span>
                            <span class="def-desc">Record yang dipilih sebagai sumber kebenaran. Kendaraan, WO, dan SPK tetap terhubung ke semua record — tidak ada yang dihapus.</span>
                        </div>
                        <div class="def-row">
                            <span class="def-term">Data Sekunder</span>
                            <span class="def-desc">Record duplikat. Tetap ada di database, ditandai sebagai anggota cluster. Bisa di-revert kapan saja.</span>
                        </div>
                        <div class="def-row">
                            <span class="def-term">Cluster</span>
                            <span class="def-desc">Grup konsumen yang saling terhubung secara transitif. Satu konsumen bisa punya banyak anggota.</span>
                        </div>
                    </div>
                </div>

                <hr class="guide-divider">

                {{-- 2. Skor Kepercayaan --}}
                <div class="guide-section">
                    <div class="guide-section-title">
                        <span class="guide-icon">📊</span>
                        <h4>Skor Kepercayaan</h4>
                    </div>
                    <div class="score-levels-list">
                        <div class="score-level-item">
                            <span class="badge-score-pill score-high">High ≥ 80</span>
                            <span class="score-desc">Sangat yakin duplikat. Biasanya auto-resolved oleh sistem.</span>
                        </div>
                        <div class="score-level-item">
                            <span class="badge-score-pill score-medium">Medium 50–79</span>
                            <span class="score-desc">Indikasi kuat, tapi ada perbedaan di satu atau dua field. Perlu konfirmasi.</span>
                        </div>
                        <div class="score-level-item">
                            <span class="badge-score-pill score-low">Low &lt; 50</span>
                            <span class="score-desc">Sinyal lemah. Kemungkinan bukan duplikat — periksa dengan teliti sebelum konfirmasi.</span>
                        </div>
                    </div>
                </div>

                <hr class="guide-divider">

                {{-- 3. Sinyal Pencocokan --}}
                <div class="guide-section">
                    <div class="guide-section-title">
                        <span class="guide-icon">🏷️</span>
                        <h4>Sinyal Pencocokan</h4>
                    </div>
                    <div class="signals-grid">
                        <div class="signal-item">
                            <span class="badge-signal signal-red">NIK sama</span>
                            <span class="signal-desc">NIK / KTP identik — bukti identitas terkuat. Perhatikan: NIK kadang salah input oleh SA/sales.</span>
                        </div>
                        <div class="signal-item">
                            <span class="badge-signal signal-red">SuzukiID</span>
                            <span class="signal-desc">Suzuki Customer ID sama — unik per individu di sistem Suzuki.</span>
                        </div>
                        <div class="signal-item">
                            <span class="badge-signal signal-red">Nama+Alamat</span>
                            <span class="signal-desc">Nama dan alamat persis/sangat mirip — kombinasi kuat.</span>
                        </div>
                        <div class="signal-item">
                            <span class="badge-signal signal-red">Nama+TglLahir</span>
                            <span class="signal-desc">Nama dan tanggal lahir sama — indikator kuat untuk personal.</span>
                        </div>
                        <div class="signal-item">
                            <span class="badge-signal signal-yellow">HP sama</span>
                            <span class="signal-desc">Nomor HP identik — penguat saja, bukan bukti tunggal (bisa berubah).</span>
                        </div>
                        <div class="signal-item">
                            <span class="badge-signal signal-yellow">Email sama</span>
                            <span class="signal-desc">Email identik — penguat saja, jarang diisi dengan benar di DMS.</span>
                        </div>
                    </div>
                </div>

                <hr class="guide-divider">

                {{-- 4. Daftar Aturan Deteksi --}}
                <div class="guide-section">
                    <div class="guide-section-title">
                        <span class="guide-icon">📋</span>
                        <h4>Daftar Aturan Deteksi</h4>
                    </div>

                    {{-- Table 1: Diselesaikan Otomatis --}}
                    <div class="rule-table-box table-auto-resolve">
                        <div class="rule-table-header header-green">
                            <span class="rule-status-icon">⚡</span>
                            <span>Diselesaikan Otomatis (tidak perlu tindakan)</span>
                        </div>
                        <table class="rule-table">
                            <thead>
                                <tr>
                                    <th style="width: 70px;">RULE</th>
                                    <th style="width: 40%;">KONDISI</th>
                                    <th>ALASAN AMAN OTOMATIS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge-rule-sm">R1</span></td>
                                    <td>NIK + Nama + Alamat sama</td>
                                    <td>Tiga bukti identitas sekaligus — hampir pasti orang sama</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R2</span></td>
                                    <td>NIK + Nama persis sama</td>
                                    <td>Identitas unik + nama identik</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R2a</span></td>
                                    <td>NIK + Nama mirip + Tgl Lahir sama</td>
                                    <td>NIK + tgl lahir = identitas kuat, perbedaan nama toleransi typo</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R2b</span></td>
                                    <td>NIK + Nama mirip</td>
                                    <td>NIK unik, perbedaan nama dalam batas wajar typo/gelar</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R3a</span></td>
                                    <td>NIK + Alamat + HP + Tgl Lahir sama (nama panggilan)</td>
                                    <td>4 poin bukti independen</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R5</span></td>
                                    <td>Nama + Alamat persis sama</td>
                                    <td>Kombinasi nama-alamat sangat spesifik</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R5c</span></td>
                                    <td>Nama + Alamat + HP sama, meski NIK berbeda</td>
                                    <td>3 sinyal mengalahkan kemungkinan NIK salah input</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R7</span></td>
                                    <td>HP + Nama persis sama</td>
                                    <td>Nama identik mengunci keunikan HP</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R8</span></td>
                                    <td>Email + Nama persis sama</td>
                                    <td>Email unik per orang bila nama juga cocok</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R9</span></td>
                                    <td>Suzuki ID + Nama sama</td>
                                    <td>Suzuki ID diassign sistem Suzuki, bukan input manual</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R11</span></td>
                                    <td>Perusahaan — nama + alamat/NPWP/SuzukiID cocok</td>
                                    <td>Identitas perusahaan lengkap</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R12a</span></td>
                                    <td>Perusahaan — nama spesifik + kota sama, NPWP tidak konflik</td>
                                    <td>Nama perusahaan unik + lokasi sama</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R-CL</span></td>
                                    <td>Anggota cluster transitif</td>
                                    <td>Sudah terhubung ke master melalui rantai pasangan yang dikonfirmasi</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Table 2: Perlu Ditinjau Pengguna --}}
                    <div class="rule-table-box table-need-review">
                        <div class="rule-table-header header-yellow">
                            <span class="rule-status-icon">👁️</span>
                            <span>Perlu Ditinjau Pengguna</span>
                        </div>
                        <table class="rule-table">
                            <thead>
                                <tr>
                                    <th style="width: 70px;">RULE</th>
                                    <th style="width: 40%;">KONDISI</th>
                                    <th>MENGAPA PERLU DITINJAU</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge-rule-sm">R3</span></td>
                                    <td>NIK + Alamat sama, Nama beda</td>
                                    <td>NIK mungkin salah input oleh SA — periksa apakah nama bisa dicocokkan</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R5b</span></td>
                                    <td>Nama + Alamat sama, NIK / Tgl Lahir konflik</td>
                                    <td>Mungkin anggota keluarga serumah, atau salah satu NIK salah</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R6</span></td>
                                    <td>Nama + Tgl Lahir sama</td>
                                    <td>Nama umum + tgl lahir bisa kebetulan cocok — perlu cek HP/alamat</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R6b</span></td>
                                    <td>Nama + Tgl Lahir sama, NIK konflik</td>
                                    <td>Dua bukti tapi NIK berlawanan — kemungkinan orang berbeda atau NIK keliru</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R7b</span></td>
                                    <td>HP + Nama mirip, ada sinyal konflik</td>
                                    <td>Nomor HP bisa berganti tangan — verifikasi dari sinyal lain</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R10</span></td>
                                    <td>Suzuki ID sama, Nama beda</td>
                                    <td>Suzuki ID bisa salah salin antar record — nama jadi penentu</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-rule-sm">R12</span></td>
                                    <td>Nama perusahaan sama, Alamat beda</td>
                                    <td>Bisa kantor pusat vs cabang — konfirmasi dari NPWP atau kontak</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Table 3: Ditolak Otomatis --}}
                    <div class="rule-table-box table-rejected">
                        <div class="rule-table-header header-gray">
                            <span class="rule-status-icon">ⓧ</span>
                            <span>Ditolak Otomatis (bukan duplikat)</span>
                        </div>
                        <table class="rule-table">
                            <thead>
                                <tr>
                                    <th style="width: 70px;">RULE</th>
                                    <th style="width: 40%;">KONDISI</th>
                                    <th>ALASAN DITOLAK</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge-rule-sm">D1</span></td>
                                    <td>Gender dari nama berbeda + NIK atau tahun lahir konflik keras</td>
                                    <td>Kombinasi ini menandakan dua orang yang berbeda — misalnya BUDI (L) vs BUDI (P) dengan NIK/tahun berbeda</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr class="guide-divider">

                {{-- 5. Panduan Mengambil Keputusan --}}
                <div class="guide-section">
                    <h4 style="font-size: 14px; font-weight: 800; color: #0f172a; margin-bottom: 12px;">Panduan Mengambil Keputusan</h4>
                    <div class="decision-cards-grid">
                        <div class="decision-card decision-confirm">
                            <div class="decision-title title-red">
                                <span>✓</span>
                                <span>Konfirmasi Duplikat</span>
                            </div>
                            <ul class="decision-list">
                                <li>Pilih <strong>Data Utama</strong> — klik kartu yang datanya lebih lengkap dan terpercaya</li>
                                <li>Sistem otomatis memilih data terbaru bila NIK sama</li>
                                <li>Klik <strong>Konfirmasi</strong> — data sekunder digabungkan ke master</li>
                            </ul>
                        </div>
                        <div class="decision-card decision-dismiss">
                            <div class="decision-title title-gray">
                                <span>✕</span>
                                <span>Dismiss (Bukan Duplikat)</span>
                            </div>
                            <ul class="decision-list">
                                <li>Gunakan bila setelah diperiksa ternyata dua orang berbeda</li>
                                <li>Pasangan tidak muncul lagi di review</li>
                                <li>Bisa di-<strong>Revert</strong> kembali ke pending bila ternyata salah</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- 6. Tips Banner --}}
                <div class="guide-tip-banner">
                    <span class="tip-icon">💡</span>
                    <span><strong>Tips:</strong> Bila tidak yakin, tambahkan catatan via tombol <em>Catat</em> dan biarkan pending. Tidak ada data yang dihapus permanen — semua keputusan bisa dibatalkan melalui tombol <em>Revert</em>.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-guide-close" onclick="closeSystemGuide()">Tutup</button>
            </div>
        </div>
    </div>

    {{-- MODAL 2: TAMBAH CATATAN --}}
    <div class="modal-backdrop" id="modalAddNote">
        <div class="modal-dialog modal-note-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Catatan</h3>
                <button type="button" class="btn-modal-close" onclick="closeAddNote()">&times;</button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <input type="hidden" id="noteTargetPairId" value="">
                <textarea class="note-textarea" id="noteInputText" placeholder="Catatan (opsional)..." rows="4"></textarea>
            </div>
            <div class="modal-footer modal-note-footer">
                <button type="button" class="btn-note-cancel" onclick="closeAddNote()">Batal</button>
                <button type="button" class="btn-note-save" onclick="saveNote()">Simpan Catatan</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Global Container */
    .duplicate-review-container {
        padding: 24px 28px 40px 28px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: #1e293b;
        box-sizing: border-box;
    }

    /* Header */
    .page-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .page-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.3px;
    }
    .page-subtitle {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }
    .btn-guide-system {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-guide-system:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    /* Keterangan Sumber Data Banner */
    .legend-card {
        background: #ffffff;
        border-radius: 10px;
        padding: 14px 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 4px rgba(15, 23, 42, 0.02);
        margin-bottom: 18px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .legend-header {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
    }
    .legend-items {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }
    .legend-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11.5px;
    }
    .badge-source {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 5px;
        white-space: nowrap;
    }
    .badge-src-penjualan { background: #e0f2fe; color: #0369a1; }
    .badge-src-service   { background: #ffedd5; color: #c2410c; }
    .badge-src-both      { background: #dcfce7; color: #15803d; }
    .badge-src-database  { background: #f1f5f9; color: #475569; }
    .legend-desc {
        color: #64748b;
    }

    /* Filter Card */
    .filter-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 16px 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        margin-bottom: 20px;
    }
    .filter-grid {
        display: flex;
        align-items: flex-end;
        gap: 14px;
        flex-wrap: wrap;
    }
    .filter-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1 1 160px;
    }
    .filter-label {
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
    }
    .select-control {
        width: 100%;
        height: 38px;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        color: #1e293b;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
    }
    .select-control:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
    }
    .filter-btn-box {
        flex: 0 0 auto;
    }
    .btn-search-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        height: 38px;
        padding: 0 20px;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25);
        transition: all 0.2s ease;
    }
    .btn-search-primary:hover {
        background: linear-gradient(135deg, #b91c1c, #991b1b);
        transform: translateY(-1px);
    }

    /* Subtoolbar */
    .subtoolbar-row {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 14px;
        flex-wrap: wrap;
    }
    .pending-count-badge {
        font-size: 12px;
        font-weight: 700;
        background: #fef08a;
        color: #854d0e;
        padding: 4px 10px;
        border-radius: 6px;
    }
    .checkbox-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        color: #475569;
        cursor: pointer;
    }

    /* Comparison Card */
    .pair-card-wrapper {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        margin-bottom: 24px;
        overflow: hidden;
    }
    .pair-header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 18px;
        background: #fafaf9;
        border-bottom: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 8px;
    }
    .pair-header-left, .pair-header-right {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .pair-checkbox {
        width: 16px;
        height: 16px;
        accent-color: #10b981;
        cursor: pointer;
    }
    .badge-rule {
        font-size: 11px;
        font-weight: 800;
        background: #0f172a;
        color: #ffffff;
        padding: 2px 7px;
        border-radius: 4px;
        font-family: 'JetBrains Mono', monospace;
    }
    .badge-match-type {
        font-size: 11px;
        font-weight: 700;
        background: #ffe4e6;
        color: #e11d48;
        padding: 2px 8px;
        border-radius: 4px;
    }
    .badge-score {
        font-size: 11.5px;
        font-weight: 700;
        background: #ffedd5;
        color: #c2410c;
        padding: 2px 8px;
        border-radius: 4px;
    }
    .badge-status-pending {
        font-size: 11.5px;
        font-weight: 700;
        background: #fef3c7;
        color: #b45309;
        padding: 2px 8px;
        border-radius: 4px;
    }

    .selection-hint-banner {
        padding: 8px 18px;
        background: #eff6ff;
        border-bottom: 1px solid #dbeafe;
        font-size: 12px;
        color: #1d4ed8;
    }

    /* Comparison Grid */
    .comparison-grid {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        gap: 16px;
        padding: 18px;
        align-items: stretch;
    }
    @media (max-width: 860px) {
        .comparison-grid {
            grid-template-columns: 1fr;
        }
        .vs-divider {
            margin: 8px auto !important;
        }
    }

    .candidate-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
    }
    .candidate-card:hover {
        border-color: #cbd5e1;
    }
    /* State: Selected as Data Utama (Green Border) */
    .candidate-selected {
        border: 2px solid #22c55e !important;
        background: #ffffff !important;
        box-shadow: 0 4px 14px rgba(34, 197, 94, 0.12);
        opacity: 1 !important;
    }
    /* State: Secondary / Muted */
    .candidate-secondary {
        border: 1.5px solid #e2e8f0 !important;
        opacity: 0.45 !important;
        background: #fafafa !important;
        transition: opacity 0.2s ease;
    }
    .candidate-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 10px;
    }
    .candidate-name {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
    }
    .select-indicator {
        font-size: 11.5px;
        color: #94a3b8;
        font-weight: 600;
    }

    .candidate-spec-table {
        width: 100%;
        font-size: 12px;
        border-collapse: collapse;
    }
    .candidate-spec-table tr {
        border-bottom: 1px solid #f8fafc;
    }
    .candidate-spec-table td {
        padding: 6px 4px;
        vertical-align: middle;
    }
    .spec-lbl {
        color: #64748b;
        font-weight: 600;
        width: 90px;
    }
    .spec-val {
        color: #1e293b;
        text-align: right;
    }
    .font-mono {
        font-family: 'JetBrains Mono', monospace;
    }
    .font-bold {
        font-weight: 800;
    }

    /* VS Divider */
    .vs-divider {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .vs-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: #f1f5f9;
        color: #64748b;
        border-radius: 50%;
        font-weight: 800;
        font-size: 11px;
        border: 1px solid #cbd5e1;
    }

    /* Actions Footer */
    .pair-actions-footer {
        padding: 12px 18px;
        background: #fafaf9;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .btn-action-confirm {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        background: #f87171;
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-action-confirm:hover {
        background: #ef4444;
    }
    .btn-action-dismiss {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        background: transparent;
        color: #64748b;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-action-dismiss:hover {
        background: #f1f5f9;
        color: #334155;
    }
    .btn-action-note {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        background: transparent;
        color: #0284c7;
        border: 1px solid #bae6fd;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-action-note:hover {
        background: #e0f2fe;
    }

    .empty-pairs-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 50px 20px;
        text-align: center;
    }

    /* Floating Action Bar */
    .floating-action-bar {
        position: fixed;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        background: #1e293b;
        border-radius: 12px;
        padding: 8px 14px;
        box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
        border: 1px solid #334155;
        animation: floatSlideUp 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes floatSlideUp {
        from { opacity: 0; transform: translate(-50%, 15px); }
        to { opacity: 1; transform: translate(-50%, 0); }
    }
    .floating-bar-content {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .floating-bar-left {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #f8fafc;
        font-size: 13px;
        font-weight: 700;
    }
    .floating-bar-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-floating-confirm {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-floating-confirm:hover {
        background: linear-gradient(135deg, #b91c1c, #991b1b);
    }
    .btn-floating-dismiss {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        background: transparent;
        color: #cbd5e1;
        border: 1px solid #475569;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-floating-dismiss:hover {
        background: #334155;
        color: #ffffff;
    }
    .btn-floating-close {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
        padding: 0 4px;
        line-height: 1;
    }
    .btn-floating-close:hover {
        color: #f8fafc;
    }

    /* Modal Backdrop & Dialog */
    .modal-backdrop {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
    }
    .modal-dialog {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: modalFadeSlide 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        max-width: 100%;
        box-sizing: border-box;
    }
    @keyframes modalFadeSlide {
        from { opacity: 0; transform: translateY(12px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 24px;
        border-bottom: 1px solid #e2e8f0;
    }
    .modal-title {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .btn-modal-close {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        font-size: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        transition: all 0.15s ease;
    }
    .btn-modal-close:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fecaca;
    }

    /* Modal Guide Specific */
    .modal-guide-dialog {
        width: 900px;
        max-height: 88vh;
    }
    .modal-guide-body {
        padding: 24px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .guide-section {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .guide-section-title {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .guide-section-title h4 {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .guide-icon {
        font-size: 16px;
    }
    .guide-text {
        font-size: 12.5px;
        line-height: 1.6;
        color: #475569;
        margin: 0;
    }
    .guide-definitions {
        display: flex;
        flex-direction: column;
        gap: 8px;
        background: #f8fafc;
        padding: 12px 16px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    .def-row {
        display: flex;
        gap: 16px;
        font-size: 12px;
    }
    .def-term {
        font-weight: 700;
        color: #1e293b;
        min-width: 110px;
    }
    .def-desc {
        color: #64748b;
        line-height: 1.45;
    }
    .guide-divider {
        border: none;
        border-top: 1px solid #f1f5f9;
        margin: 4px 0;
    }

    /* Score Levels */
    .score-levels-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .score-level-item {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 12px;
    }
    .badge-score-pill {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 6px;
        min-width: 100px;
        text-align: center;
    }
    .score-high   { background: #fee2e2; color: #b91c1c; }
    .score-medium { background: #ffedd5; color: #c2410c; }
    .score-low    { background: #f1f5f9; color: #64748b; }
    .score-desc {
        color: #475569;
    }

    /* Signals Grid */
    .signals-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    @media (max-width: 700px) {
        .signals-grid { grid-template-columns: 1fr; }
    }
    .signal-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 12px;
        background: #f8fafc;
        padding: 10px 12px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    .badge-signal {
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 4px;
        white-space: nowrap;
    }
    .signal-red    { background: #ffe4e6; color: #e11d48; }
    .signal-yellow { background: #fef3c7; color: #b45309; }
    .signal-desc {
        color: #475569;
        line-height: 1.4;
    }

    /* Rule Tables */
    .rule-table-box {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        margin-bottom: 12px;
    }
    .rule-table-header {
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .header-green  { background: #dcfce7; color: #166534; border-bottom: 1px solid #bbf7d0; }
    .header-yellow { background: #fef3c7; color: #92400e; border-bottom: 1px solid #fde68a; }
    .header-gray   { background: #f1f5f9; color: #475569; border-bottom: 1px solid #e2e8f0; }

    .rule-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    .rule-table thead th {
        background: #fafafa;
        color: #64748b;
        font-weight: 700;
        text-align: left;
        padding: 8px 12px;
        border-bottom: 1px solid #e2e8f0;
    }
    .rule-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
    }
    .rule-table tbody td {
        padding: 8px 12px;
        color: #334155;
    }
    .badge-rule-sm {
        font-size: 10px;
        font-weight: 800;
        background: #fee2e2;
        color: #e11d48;
        padding: 1px 5px;
        border-radius: 3px;
        font-family: 'JetBrains Mono', monospace;
    }

    /* Decision Cards */
    .decision-cards-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }
    @media (max-width: 700px) {
        .decision-cards-grid { grid-template-columns: 1fr; }
    }
    .decision-card {
        border-radius: 10px;
        padding: 14px 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .decision-confirm {
        border: 1.5px solid #fecaca;
        background: #fff5f5;
    }
    .decision-dismiss {
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
    }
    .decision-title {
        font-size: 13px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .title-red  { color: #dc2626; }
    .title-gray { color: #475569; }
    .decision-list {
        margin: 0;
        padding-left: 18px;
        font-size: 12px;
        color: #475569;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    /* Tip Banner */
    .guide-tip-banner {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        font-size: 12px;
        color: #1e40af;
        line-height: 1.45;
    }

    .modal-footer {
        padding: 14px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
    }
    .btn-guide-close {
        padding: 7px 18px;
        background: #e2e8f0;
        color: #334155;
        border: none;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-guide-close:hover {
        background: #cbd5e1;
    }

    /* Modal Note Specific */
    .modal-note-dialog {
        width: 440px;
    }
    .note-textarea {
        width: 100%;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 12px 14px;
        font-size: 13px;
        font-family: inherit;
        color: #1e293b;
        box-sizing: border-box;
        outline: none;
        resize: vertical;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .note-textarea:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
    }
    .modal-note-footer {
        gap: 8px;
    }
    .btn-note-cancel {
        padding: 7px 16px;
        background: transparent;
        color: #64748b;
        border: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        border-radius: 6px;
    }
    .btn-note-cancel:hover {
        background: #f1f5f9;
    }
    .btn-note-save {
        padding: 7px 18px;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25);
        transition: all 0.15s ease;
    }
    .btn-note-save:hover {
        background: linear-gradient(135deg, #b91c1c, #991b1b);
    }
</style>

<script>
    // Selected states
    const selectedPairs = {};

    function selectCandidate(pairId, side) {
        const cardA = document.getElementById('cardA-' + pairId);
        const cardB = document.getElementById('cardB-' + pairId);
        const indA = document.getElementById('indicatorA-' + pairId);
        const indB = document.getElementById('indicatorB-' + pairId);
        const pairCheckbox = document.getElementById('pairCheck-' + pairId);

        const defaultHtml = 'Klik untuk pilih';

        const primaryHtml = `
            <span style="color: #16a34a; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <span>Data Utama</span>
            </span>
        `;

        const secondaryHtml = `
            <span style="color: #ef4444; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
                <span>Sekunder</span>
            </span>
        `;

        // Check if user clicked the already selected Data Utama card -> TOGGLE OFF / RESET
        const isLeftAlreadySelected = (side === 'left' && cardA && cardA.classList.contains('candidate-selected'));
        const isRightAlreadySelected = (side === 'right' && cardB && cardB.classList.contains('candidate-selected'));

        if (isLeftAlreadySelected || isRightAlreadySelected) {
            if (cardA) cardA.classList.remove('candidate-selected', 'candidate-secondary');
            if (cardB) cardB.classList.remove('candidate-selected', 'candidate-secondary');
            if (indA) indA.innerHTML = defaultHtml;
            if (indB) indB.innerHTML = defaultHtml;
            if (pairCheckbox) pairCheckbox.checked = false;
            delete selectedPairs[pairId];
            updateFloatingBar();
            return;
        }

        if (side === 'left') {
            if (cardA) {
                cardA.classList.add('candidate-selected');
                cardA.classList.remove('candidate-secondary');
            }
            if (cardB) {
                cardB.classList.add('candidate-secondary');
                cardB.classList.remove('candidate-selected');
            }
            if (indA) indA.innerHTML = primaryHtml;
            if (indB) indB.innerHTML = secondaryHtml;
        } else {
            if (cardB) {
                cardB.classList.add('candidate-selected');
                cardB.classList.remove('candidate-secondary');
            }
            if (cardA) {
                cardA.classList.add('candidate-secondary');
                cardA.classList.remove('candidate-selected');
            }
            if (indB) indB.innerHTML = primaryHtml;
            if (indA) indA.innerHTML = secondaryHtml;
        }

        // Auto-check pair checkbox
        if (pairCheckbox) {
            pairCheckbox.checked = true;
            selectedPairs[pairId] = true;
        }
        updateFloatingBar();
    }

    function onPairCheckboxChange(pairId) {
        const checkbox = document.getElementById('pairCheck-' + pairId);
        const cardA = document.getElementById('cardA-' + pairId);
        const cardB = document.getElementById('cardB-' + pairId);
        const indA = document.getElementById('indicatorA-' + pairId);
        const indB = document.getElementById('indicatorB-' + pairId);

        if (checkbox && checkbox.checked) {
            selectedPairs[pairId] = true;
            if (cardA && !cardA.classList.contains('candidate-selected') && cardB && !cardB.classList.contains('candidate-selected')) {
                selectCandidate(pairId, 'left');
                return;
            }
        } else {
            delete selectedPairs[pairId];
            if (cardA) cardA.classList.remove('candidate-selected', 'candidate-secondary');
            if (cardB) cardB.classList.remove('candidate-selected', 'candidate-secondary');
            if (indA) indA.innerHTML = 'Klik untuk pilih';
            if (indB) indB.innerHTML = 'Klik untuk pilih';
        }
        updateFloatingBar();
    }

    function toggleSelectAll(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.pair-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = masterCheckbox.checked;
            const pairId = cb.id.replace('pairCheck-', '');
            const cardA = document.getElementById('cardA-' + pairId);
            const cardB = document.getElementById('cardB-' + pairId);
            const indA = document.getElementById('indicatorA-' + pairId);
            const indB = document.getElementById('indicatorB-' + pairId);

            if (masterCheckbox.checked) {
                selectedPairs[pairId] = true;
                if (cardA && !cardA.classList.contains('candidate-selected') && cardB && !cardB.classList.contains('candidate-selected')) {
                    selectCandidate(pairId, 'left');
                }
            } else {
                delete selectedPairs[pairId];
                if (cardA) cardA.classList.remove('candidate-selected', 'candidate-secondary');
                if (cardB) cardB.classList.remove('candidate-selected', 'candidate-secondary');
                if (indA) indA.innerHTML = 'Klik untuk pilih';
                if (indB) indB.innerHTML = 'Klik untuk pilih';
            }
        });
        updateFloatingBar();
    }

    function updateFloatingBar() {
        const count = Object.keys(selectedPairs).length;
        const floatingBar = document.getElementById('floatingActionBar');
        const countText = document.getElementById('floatingCountText');
        
        if (count > 0) {
            if (countText) countText.textContent = count + ' pasang dipilih';
            if (floatingBar) floatingBar.style.display = 'block';
        } else {
            if (floatingBar) floatingBar.style.display = 'none';
        }
    }

    function hideFloatingBar() {
        const floatingBar = document.getElementById('floatingActionBar');
        if (floatingBar) floatingBar.style.display = 'none';
    }

    function confirmAllSelected() {
        const count = Object.keys(selectedPairs).length;
        alert('Konfirmasi ' + count + ' pasang data duplikat terpilih.');
    }

    function dismissAllSelected() {
        const count = Object.keys(selectedPairs).length;
        alert('Dismiss ' + count + ' pasang data duplikat terpilih.');
    }

    function confirmMerge(pairId) {
        alert('Fitur konfirmasi penggabungan duplikat #' + pairId + ' sedang disiapkan...');
    }

    function dismissPair(pairId) {
        alert('Data duplikat #' + pairId + ' di-dismiss.');
    }

    // Modal Cara Kerja Sistem
    function openSystemGuide() {
        const modal = document.getElementById('modalSystemGuide');
        if (modal) {
            modal.style.display = 'flex';
        }
    }
    function closeSystemGuide() {
        const modal = document.getElementById('modalSystemGuide');
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // Modal Tambah Catatan
    function addNote(pairId) {
        const targetInput = document.getElementById('noteTargetPairId');
        const textInput = document.getElementById('noteInputText');
        const modal = document.getElementById('modalAddNote');
        
        if (targetInput) targetInput.value = pairId;
        if (textInput) textInput.value = '';
        if (modal) modal.style.display = 'flex';
    }
    function closeAddNote() {
        const modal = document.getElementById('modalAddNote');
        if (modal) {
            modal.style.display = 'none';
        }
    }
    function saveNote() {
        const pairId = document.getElementById('noteTargetPairId').value;
        const text = document.getElementById('noteInputText').value;
        alert('Catatan berhasil disimpan untuk data #' + pairId + (text ? ': "' + text + '"' : ''));
        closeAddNote();
    }

    // Close on outside click
    window.addEventListener('click', function(event) {
        const guideModal = document.getElementById('modalSystemGuide');
        const noteModal = document.getElementById('modalAddNote');
        if (event.target === guideModal) {
            closeSystemGuide();
        }
        if (event.target === noteModal) {
            closeAddNote();
        }
    });
</script>
@endsection
