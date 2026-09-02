-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Agu 2026 pada 10.49
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ote_dca`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `actual_activities`
--

CREATE TABLE `actual_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cabang` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jenis_activity` enum('Offline','Online') NOT NULL,
  `activity` enum('D_MARKETING','EXHIBITION','MOVING_EXHIBITION','SHOWROOM_EVENT','GROUP_PRESENTATION','EVENT_TEST_DRIVE','OPEN_TABLE','CETAK_FLYER') NOT NULL,
  `platform_lokasi` varchar(255) NOT NULL,
  `jenis_unit` enum('Commercial','Passenger') NOT NULL,
  `type_unit` enum('CARRY_PU','CARRY_BOX','CARRY_BV','CARRY_MOKO','CARRY_AMBULANCE','CARRY_TOWING','APV_MB','APV_AMBULANCE','ERTIGA','ERTIGA_HYBRID','XL7','XL7_HYBRID','S_PRESSO','IGNIS','e_VITARA','GRAND_VITARA','JIMNY','FRONX') NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `pic` varchar(255) NOT NULL,
  `jml_sales_shift` varchar(255) NOT NULL,
  `target_p` int(11) NOT NULL DEFAULT 0,
  `target_hp` int(11) NOT NULL DEFAULT 0,
  `target_spk` int(11) NOT NULL DEFAULT 0,
  `actual_p` int(11) NOT NULL DEFAULT 0,
  `actual_hp` int(11) NOT NULL DEFAULT 0,
  `actual_spk` int(11) NOT NULL DEFAULT 0,
  `actual_do` int(11) NOT NULL DEFAULT 0,
  `total_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `cost_p` decimal(15,2) NOT NULL DEFAULT 0.00,
  `cost_spk` decimal(15,2) NOT NULL DEFAULT 0.00,
  `cost_do` decimal(15,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `actual_do_by_type`
--

CREATE TABLE `actual_do_by_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis_unit` enum('Commercial','Passenger') NOT NULL,
  `type_unit` enum('NEW CARRY','APV BLIND VAN','ERTIGA','XL7','SPRESO','IGNIS','e-VITARA','GRAND VITARA','JIMNY 3D','JIMNY 5D','FRONX','BALENO') NOT NULL,
  `tahun` year(4) NOT NULL,
  `jan` int(11) NOT NULL DEFAULT 0,
  `feb` int(11) NOT NULL DEFAULT 0,
  `mar` int(11) NOT NULL DEFAULT 0,
  `apr` int(11) NOT NULL DEFAULT 0,
  `mei` int(11) NOT NULL DEFAULT 0,
  `jun` int(11) NOT NULL DEFAULT 0,
  `jul` int(11) NOT NULL DEFAULT 0,
  `agu` int(11) NOT NULL DEFAULT 0,
  `sep` int(11) NOT NULL DEFAULT 0,
  `okt` int(11) NOT NULL DEFAULT 0,
  `nov` int(11) NOT NULL DEFAULT 0,
  `des` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `actual_do_salesforces`
--

CREATE TABLE `actual_do_salesforces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grading` enum('PLATINUM','GOLD','SILVER','TRAINEE','FREELANCE') DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `jan` int(11) NOT NULL DEFAULT 0,
  `feb` int(11) NOT NULL DEFAULT 0,
  `mar` int(11) NOT NULL DEFAULT 0,
  `apr` int(11) NOT NULL DEFAULT 0,
  `mei` int(11) NOT NULL DEFAULT 0,
  `jun` int(11) NOT NULL DEFAULT 0,
  `jul` int(11) NOT NULL DEFAULT 0,
  `agu` int(11) NOT NULL DEFAULT 0,
  `sep` int(11) NOT NULL DEFAULT 0,
  `okt` int(11) NOT NULL DEFAULT 0,
  `nov` int(11) NOT NULL DEFAULT 0,
  `des` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `actual_inquary_by_type`
--

CREATE TABLE `actual_inquary_by_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis_unit` enum('Commercial','Passenger') NOT NULL,
  `type_unit` enum('NEW CARRY','APV BLIND VAN','ERTIGA','XL7','SPRESO','IGNIS','e-VITARA','GRAND VITARA','JIMNY 3D','JIMNY 5D','FRONX','BALENO') NOT NULL,
  `tahun` year(4) NOT NULL,
  `jan` int(11) NOT NULL DEFAULT 0,
  `feb` int(11) NOT NULL DEFAULT 0,
  `mar` int(11) NOT NULL DEFAULT 0,
  `apr` int(11) NOT NULL DEFAULT 0,
  `mei` int(11) NOT NULL DEFAULT 0,
  `jun` int(11) NOT NULL DEFAULT 0,
  `jul` int(11) NOT NULL DEFAULT 0,
  `agu` int(11) NOT NULL DEFAULT 0,
  `sep` int(11) NOT NULL DEFAULT 0,
  `okt` int(11) NOT NULL DEFAULT 0,
  `nov` int(11) NOT NULL DEFAULT 0,
  `des` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `actual_salesforces`
--

CREATE TABLE `actual_salesforces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grading` enum('PLATINUM','GOLD','SILVER','TRAINEE','FREELANCE') DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `jan` int(11) NOT NULL DEFAULT 0,
  `feb` int(11) NOT NULL DEFAULT 0,
  `mar` int(11) NOT NULL DEFAULT 0,
  `apr` int(11) NOT NULL DEFAULT 0,
  `mei` int(11) NOT NULL DEFAULT 0,
  `jun` int(11) NOT NULL DEFAULT 0,
  `jul` int(11) NOT NULL DEFAULT 0,
  `agu` int(11) NOT NULL DEFAULT 0,
  `sep` int(11) NOT NULL DEFAULT 0,
  `okt` int(11) NOT NULL DEFAULT 0,
  `nov` int(11) NOT NULL DEFAULT 0,
  `des` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `actual_sales_by_leasing`
--

CREATE TABLE `actual_sales_by_leasing` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leasing_name` enum('tunai','suzuki_finance','bca_finance','kbb_bca','mandiri_tunas_finance','kbb_mandiri','bsi','mandiri_utama_finance','indomobil_finance','adira_finance','bni_finance','maybank','oto_multiartha_finance','niaga_finance','clipan_finance','lain_lain') NOT NULL,
  `tahun` year(4) NOT NULL,
  `jan` int(11) NOT NULL DEFAULT 0,
  `feb` int(11) NOT NULL DEFAULT 0,
  `mar` int(11) NOT NULL DEFAULT 0,
  `apr` int(11) NOT NULL DEFAULT 0,
  `mei` int(11) NOT NULL DEFAULT 0,
  `jun` int(11) NOT NULL DEFAULT 0,
  `jul` int(11) NOT NULL DEFAULT 0,
  `agu` int(11) NOT NULL DEFAULT 0,
  `sep` int(11) NOT NULL DEFAULT 0,
  `okt` int(11) NOT NULL DEFAULT 0,
  `nov` int(11) NOT NULL DEFAULT 0,
  `des` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `actual_source_do_inquary`
--

CREATE TABLE `actual_source_do_inquary` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `source_inquary` enum('Call In (dari Iklan)','Canvasing','Data Base','Digital Hyperlocal','Digital Non Hyperlocal','Exhibition','Media Digital','Media Elektronik','Mediator','Referensi','Referensi Customer','Showroom Activity','Showroom Walk-in','Website Dealer') DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `jan` int(11) NOT NULL DEFAULT 0,
  `feb` int(11) NOT NULL DEFAULT 0,
  `mar` int(11) NOT NULL DEFAULT 0,
  `apr` int(11) NOT NULL DEFAULT 0,
  `mei` int(11) NOT NULL DEFAULT 0,
  `jun` int(11) NOT NULL DEFAULT 0,
  `jul` int(11) NOT NULL DEFAULT 0,
  `agu` int(11) NOT NULL DEFAULT 0,
  `sep` int(11) NOT NULL DEFAULT 0,
  `okt` int(11) NOT NULL DEFAULT 0,
  `nov` int(11) NOT NULL DEFAULT 0,
  `des` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `actual_source_inquary`
--

CREATE TABLE `actual_source_inquary` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `source_inquary` enum('Call In (dari Iklan)','Canvasing','Data Base','Digital Hyperlocal','Digital Non Hyperlocal','Exibition','Media Digital','Media Elektronik','Mediator','Referensi','Referensi Customer','Showroom Activity','Showroom Walk In','Website Dealer') DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `jan` int(11) NOT NULL DEFAULT 0,
  `feb` int(11) NOT NULL DEFAULT 0,
  `mar` int(11) NOT NULL DEFAULT 0,
  `apr` int(11) NOT NULL DEFAULT 0,
  `mei` int(11) NOT NULL DEFAULT 0,
  `jun` int(11) NOT NULL DEFAULT 0,
  `jul` int(11) NOT NULL DEFAULT 0,
  `agu` int(11) NOT NULL DEFAULT 0,
  `sep` int(11) NOT NULL DEFAULT 0,
  `okt` int(11) NOT NULL DEFAULT 0,
  `nov` int(11) NOT NULL DEFAULT 0,
  `des` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `actual_spk_by_type`
--

CREATE TABLE `actual_spk_by_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis_unit` enum('Commercial','Passenger') NOT NULL,
  `type_unit` enum('NEW CARRY','APV BLIND VAN','ERTIGA','XL7','SPRESO','IGNIS','e-VITARA','GRAND VITARA','JIMNY 3D','JIMNY 5D','FRONX','BALENO') NOT NULL,
  `tahun` year(4) NOT NULL,
  `jan` int(11) NOT NULL DEFAULT 0,
  `feb` int(11) NOT NULL DEFAULT 0,
  `mar` int(11) NOT NULL DEFAULT 0,
  `apr` int(11) NOT NULL DEFAULT 0,
  `mei` int(11) NOT NULL DEFAULT 0,
  `jun` int(11) NOT NULL DEFAULT 0,
  `jul` int(11) NOT NULL DEFAULT 0,
  `agu` int(11) NOT NULL DEFAULT 0,
  `sep` int(11) NOT NULL DEFAULT 0,
  `okt` int(11) NOT NULL DEFAULT 0,
  `nov` int(11) NOT NULL DEFAULT 0,
  `des` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `adm_leads`
--

CREATE TABLE `adm_leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `aktual_aplikasi_in`
--

CREATE TABLE `aktual_aplikasi_in` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leasing` enum('Suzuki Finance','BCA Finance','KKB BCA','Mandiri Tunas Finance','KKB MANDIRI','BSI','Mandiri Utama Finance','Indomobil Finance','Adira Finance','BNI Finance','MAYBANK','Oto Multiartha Finance','NIAGA Finance','Clipan Finance','Lain - Lain') DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `jan` int(11) NOT NULL DEFAULT 0,
  `feb` int(11) NOT NULL DEFAULT 0,
  `mar` int(11) NOT NULL DEFAULT 0,
  `apr` int(11) NOT NULL DEFAULT 0,
  `mei` int(11) NOT NULL DEFAULT 0,
  `jun` int(11) NOT NULL DEFAULT 0,
  `jul` int(11) NOT NULL DEFAULT 0,
  `agu` int(11) NOT NULL DEFAULT 0,
  `sep` int(11) NOT NULL DEFAULT 0,
  `okt` int(11) NOT NULL DEFAULT 0,
  `nov` int(11) NOT NULL DEFAULT 0,
  `des` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `aktual_po`
--

CREATE TABLE `aktual_po` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leasing` enum('Suzuki Finance','BCA Finance','KKB BCA','Mandiri Tunas Finance','KKB MANDIRI','BSI','Mandiri Utama Finance','Indomobil Finance','Adira Finance','BNI Finance','MAYBANK','Oto Multiartha Finance','NIAGA Finance','Clipan Finance','Lain - Lain') DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `jan` int(11) NOT NULL DEFAULT 0,
  `feb` int(11) NOT NULL DEFAULT 0,
  `mar` int(11) NOT NULL DEFAULT 0,
  `apr` int(11) NOT NULL DEFAULT 0,
  `mei` int(11) NOT NULL DEFAULT 0,
  `jun` int(11) NOT NULL DEFAULT 0,
  `jul` int(11) NOT NULL DEFAULT 0,
  `agu` int(11) NOT NULL DEFAULT 0,
  `sep` int(11) NOT NULL DEFAULT 0,
  `okt` int(11) NOT NULL DEFAULT 0,
  `nov` int(11) NOT NULL DEFAULT 0,
  `des` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `aktual_reject`
--

CREATE TABLE `aktual_reject` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leasing` enum('Suzuki Finance','BCA Finance','KKB BCA','Mandiri Tunas Finance','KKB MANDIRI','BSI','Mandiri Utama Finance','Indomobil Finance','Adira Finance','BNI Finance','MAYBANK','Oto Multiartha Finance','NIAGA Finance','Clipan Finance','Lain - Lain') DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `jan` int(11) NOT NULL DEFAULT 0,
  `feb` int(11) NOT NULL DEFAULT 0,
  `mar` int(11) NOT NULL DEFAULT 0,
  `apr` int(11) NOT NULL DEFAULT 0,
  `mei` int(11) NOT NULL DEFAULT 0,
  `jun` int(11) NOT NULL DEFAULT 0,
  `jul` int(11) NOT NULL DEFAULT 0,
  `agu` int(11) NOT NULL DEFAULT 0,
  `sep` int(11) NOT NULL DEFAULT 0,
  `okt` int(11) NOT NULL DEFAULT 0,
  `nov` int(11) NOT NULL DEFAULT 0,
  `des` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `asuransis`
--

CREATE TABLE `asuransis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `asuransis`
--

INSERT INTO `asuransis` (`id`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
(4, 'CENTRAL ASIA INSURANCE', NULL, '2026-06-05 03:30:42', '2026-06-05 03:30:42'),
(5, 'ACE INSURANCE', NULL, '2026-06-05 03:30:59', '2026-06-05 03:30:59'),
(6, 'PT BADAN ASURANSI CANDI UTAMA', NULL, '2026-06-05 03:31:14', '2026-06-05 03:31:14'),
(7, 'ANDIKA RAHARJA PUTERA INSURANCE', NULL, '2026-06-05 03:31:32', '2026-06-05 03:31:32'),
(8, 'ADIRA DINAMIKA INSURANCE', NULL, '2026-06-05 03:31:44', '2026-06-05 03:31:44'),
(9, 'ADIRA DINAMIKA INSURANCE', NULL, '2026-06-05 03:31:45', '2026-06-05 03:31:45'),
(10, 'AEGIS INDONESIA INSURANCE', NULL, '2026-06-05 03:31:59', '2026-06-05 03:31:59'),
(11, 'ARTHA GRAHA GENERAL INSURANCE', NULL, '2026-06-05 03:32:14', '2026-06-05 03:32:14'),
(12, 'KOOKMIN BEST INSURANCE INDONESIA / PT ASURANSI KOO', NULL, '2026-06-05 03:32:16', '2026-06-05 03:32:16'),
(13, 'AIOI INDONESIA INSURANCE', NULL, '2026-06-05 03:32:31', '2026-06-05 03:32:31'),
(14, 'KREDIT INDONESIA INSURANCE', NULL, '2026-06-05 03:32:33', '2026-06-05 03:32:33'),
(15, 'ALLIANZ INSURANCE', NULL, '2026-06-05 03:32:46', '2026-06-05 03:32:46'),
(16, 'KOREA BANK (KB) INSURANCE', NULL, '2026-06-05 03:32:56', '2026-06-05 03:33:09'),
(17, 'ASOKA MAS INSURANCE', NULL, '2026-06-05 03:32:58', '2026-06-05 03:32:58'),
(18, 'ASIA RELIANCE GENERAL INSURANCE', NULL, '2026-06-05 03:33:20', '2026-06-05 03:33:20'),
(19, 'KRESNA INSURANCE', NULL, '2026-06-05 03:33:28', '2026-06-05 03:33:28'),
(20, 'ASURANSI KRESNA MITRA', NULL, '2026-06-05 03:33:44', '2026-06-05 03:33:44'),
(21, 'KARYAMAS SENTRALINDO INSURANCE', NULL, '2026-06-05 03:34:03', '2026-06-05 03:34:03'),
(22, 'KSK INSURANCE', NULL, '2026-06-05 03:34:13', '2026-06-05 03:34:13'),
(23, 'PT LIPPO GENERAL INSURANCE', NULL, '2026-06-05 03:34:27', '2026-06-05 03:34:27'),
(24, 'ARTARINDO', NULL, '2026-06-05 03:34:34', '2026-06-05 03:34:34'),
(25, 'MAG INSURANCE', NULL, '2026-06-05 03:34:38', '2026-06-05 03:34:38'),
(26, 'ASURA INSURANCE', NULL, '2026-06-05 03:34:43', '2026-06-05 03:34:43'),
(27, 'MANULIFE INSURANCE', NULL, '2026-06-05 03:34:50', '2026-06-05 03:34:50'),
(28, 'ASTRA BUANA INSURANCE', NULL, '2026-06-05 03:34:54', '2026-06-05 03:34:54'),
(29, 'PT ASURANSI MAXIMUS GRAHA PERSADA', NULL, '2026-06-05 03:35:18', '2026-06-05 03:35:18'),
(30, 'MEGA INSURANCE', NULL, '2026-06-05 03:35:30', '2026-06-05 03:35:30'),
(31, 'MAIPARK INDONESIA INSURANCE', NULL, '2026-06-05 03:35:46', '2026-06-05 03:36:10'),
(32, 'ASTRA INSURACE', NULL, '2026-06-05 03:35:47', '2026-06-05 03:35:47'),
(33, 'AVRIST INSURANCE', NULL, '2026-06-05 03:36:00', '2026-06-05 03:36:00'),
(34, 'AVIVA INSURANCE', NULL, '2026-06-05 03:36:11', '2026-06-05 03:36:11'),
(35, 'AXA MANDIRI INSURANCE', NULL, '2026-06-05 03:36:23', '2026-06-05 03:36:23'),
(36, 'MITRA MAPARYA INSURANCE', NULL, '2026-06-05 03:36:30', '2026-06-05 03:36:30'),
(37, 'MNC INSURANCE', NULL, '2026-06-05 03:36:42', '2026-06-05 03:36:42'),
(38, 'BANGUN ASKARIDA INSURANCE', NULL, '2026-06-05 03:36:54', '2026-06-05 03:36:54'),
(39, 'MEGA PRATAMA INSURANCE', NULL, '2026-06-05 03:36:59', '2026-06-05 03:36:59'),
(40, 'MPM INSURANCE', NULL, '2026-06-05 03:37:13', '2026-06-05 03:37:13'),
(41, 'BHAKTI BAYANGKARA INSURANCE', NULL, '2026-06-05 03:37:14', '2026-06-05 03:37:14'),
(42, 'BCA INSURANCE', NULL, '2026-06-05 03:37:27', '2026-06-05 03:37:27'),
(43, 'MSIG INSURANCE', NULL, '2026-06-05 03:37:27', '2026-06-05 03:37:27'),
(44, 'BESS CENTRAL INSURANCE', NULL, '2026-06-05 03:37:38', '2026-06-05 03:37:38'),
(45, 'MITSUI SUMITOMO INDONESIA INSURANCE', NULL, '2026-06-05 03:38:36', '2026-06-05 03:38:36'),
(46, 'BINAGRIYA UPAKARA', NULL, '2026-06-05 03:38:43', '2026-06-05 03:38:43'),
(47, 'BUANA INDEPENDENT INSURANCE', NULL, '2026-06-05 03:38:57', '2026-06-05 03:38:57'),
(48, 'MALACCA TRUST WUWUNGAN INSURANCE', NULL, '2026-06-05 03:39:31', '2026-06-05 03:39:31'),
(49, 'ASURANSI ABDA / PT ASURANSI BINA DANA ARTA', NULL, '2026-06-05 03:39:40', '2026-06-05 03:39:40'),
(50, 'PURNA ARTANUGRAHA INSURANCE', NULL, '2026-06-05 03:39:47', '2026-06-05 03:39:47'),
(51, 'OONA INSURANCE', NULL, '2026-06-05 03:39:50', '2026-06-05 03:39:50'),
(52, 'BINA GRIYA UPAKARA INSURANCE', NULL, '2026-06-05 03:40:03', '2026-06-05 03:40:03'),
(53, 'PRUDENTIAL INSURANCE', NULL, '2026-06-05 03:40:08', '2026-06-05 03:40:08'),
(54, 'BATAVIA MITRATAMA INSURANCE', NULL, '2026-06-05 03:40:22', '2026-06-05 03:40:22'),
(55, 'BOSOWA PERISKOP INSURANCE', NULL, '2026-06-05 03:40:39', '2026-06-05 03:40:39'),
(56, 'PASIFIC INT\'L INDONESIA INSURANCE', NULL, '2026-06-05 03:40:40', '2026-06-05 03:40:40'),
(57, 'BERDIKARI INSURANCE', NULL, '2026-06-05 03:40:49', '2026-06-05 03:40:49'),
(58, 'PETROVE LAWRENCE REED (PLR) INSURANCE', NULL, '2026-06-05 03:41:03', '2026-06-05 03:41:03'),
(59, 'BERINGIN GENERAL AUTO INSURANCE', NULL, '2026-06-05 03:41:09', '2026-06-05 03:41:09'),
(60, 'PUTRA MANDIRI INSURANCE', NULL, '2026-06-05 03:41:32', '2026-06-05 03:41:32'),
(61, 'BERINGIN SEJAHTERA ARTA MAKMUR INSURANCE', NULL, '2026-06-05 03:41:32', '2026-06-05 03:41:32'),
(62, 'PT BRI INSURANCE', NULL, '2026-06-05 03:41:48', '2026-06-05 03:41:48'),
(63, 'PERMATA NIPPONKOA INSURANCE', NULL, '2026-06-05 03:41:49', '2026-06-05 03:41:49'),
(64, 'BINTANG INSURANCE', NULL, '2026-06-05 03:42:01', '2026-06-05 03:42:01'),
(65, 'PANIN INSURANCE', NULL, '2026-06-05 03:42:02', '2026-06-05 03:42:02'),
(66, 'BUMIDA INSURANCE', NULL, '2026-06-05 03:42:23', '2026-06-05 03:42:23'),
(67, 'PAN PACIFIC INSURANCE', NULL, '2026-06-05 03:42:34', '2026-06-05 03:42:34'),
(68, 'CENTRAL ASIA RAYA INSURANCE', NULL, '2026-06-05 03:42:41', '2026-06-05 03:42:41'),
(69, 'PRISMA INDONESIA INSURANCE', NULL, '2026-06-05 03:42:49', '2026-06-05 03:42:49'),
(70, 'PAROLAMAS INSURANCE', NULL, '2026-06-05 03:43:09', '2026-06-05 03:43:09'),
(71, 'CENTRIS INSURANCE', NULL, '2026-06-05 03:43:12', '2026-06-05 03:43:12'),
(72, 'PURI ASIH INSURANCE', NULL, '2026-06-05 03:43:25', '2026-06-05 03:43:25'),
(73, 'GHUBB GENERAL INSURANCE', NULL, '2026-06-05 03:43:28', '2026-06-05 03:43:28'),
(74, 'QBE POOL INSURANCE', NULL, '2026-06-05 03:43:40', '2026-06-05 03:43:40'),
(75, 'RAMA INSURANCE', NULL, '2026-06-05 03:43:52', '2026-06-05 03:43:52'),
(76, 'GHUBB SYARIAH INSURANCE', NULL, '2026-06-05 03:43:55', '2026-06-05 03:43:55'),
(77, 'RAYA INSURANCE', NULL, '2026-06-05 03:44:00', '2026-06-05 03:44:00'),
(78, 'CHINA INSURANCE', NULL, '2026-06-05 03:44:04', '2026-06-05 03:44:04'),
(79, 'RECAPITAL (REGUARD) INSURANCE', NULL, '2026-06-05 03:44:16', '2026-06-05 03:44:16'),
(80, 'CHARTIS INDONESIA INSURANCE', NULL, '2026-06-05 03:44:18', '2026-06-05 03:44:18'),
(81, 'CIGNA INSURANCE', NULL, '2026-06-05 03:44:32', '2026-06-05 03:44:32'),
(82, 'RELIANCE INDONESIA INSURANCE', NULL, '2026-06-05 03:44:37', '2026-06-05 03:44:37'),
(83, 'RAKSA PRATIKARA INSURANCE', NULL, '2026-06-05 03:44:55', '2026-06-05 03:44:55'),
(84, 'CITRA INTERNASIONAL UNDERWRITERS INSURANCE', NULL, '2026-06-05 03:44:58', '2026-06-05 03:44:58'),
(85, 'RAMAYANA INSURANCE', NULL, '2026-06-05 03:45:12', '2026-06-05 03:45:12'),
(86, 'COMMONWEALTH LIFE INSURANCE', NULL, '2026-06-05 03:45:17', '2026-06-05 03:45:17'),
(87, 'RAMA SATRIA WIBAWA INSURANCE', NULL, '2026-06-05 03:45:28', '2026-06-05 03:45:28'),
(88, 'CAKRAWALA PROTEKSI INDONESIA INSURANCE', NULL, '2026-06-05 03:45:39', '2026-06-05 03:45:39'),
(89, 'SAHABAT ARTHA PROTEKSI INSURANCE', NULL, '2026-06-05 03:45:45', '2026-06-05 03:45:45'),
(90, 'SOMPO INSURANCE INDONESIA INSURANCE', NULL, '2026-06-05 03:46:10', '2026-06-05 03:46:10'),
(91, 'PT. ASURANSI SIMAS INSURTECH', NULL, '2026-06-05 03:46:33', '2026-06-05 03:46:33'),
(92, 'SINARMAS INSURANCE', NULL, '2026-06-05 03:46:42', '2026-06-05 03:46:42'),
(93, 'CANDI UTAMA / PT. ASURANSI CANDI UTAMA', NULL, '2026-06-05 03:46:54', '2026-06-05 03:46:54'),
(94, 'SINARMAS NET INSURANCE', NULL, '2026-06-05 03:47:06', '2026-06-05 03:47:06'),
(95, 'DHARMA BANGSA INSURANCE', NULL, '2026-06-05 03:47:08', '2026-06-05 03:47:08'),
(96, 'DAYIN MITRA INSURANCE', NULL, '2026-06-05 03:47:19', '2026-06-05 03:47:19'),
(97, 'SINARMAS INSURTECH INSURANCE', NULL, '2026-06-05 03:47:26', '2026-06-05 03:47:26'),
(98, 'DANAMON INSURANCE', NULL, '2026-06-05 03:47:31', '2026-06-05 03:47:31'),
(99, 'EKSPORT INDONESIA INSURANCE', NULL, '2026-06-05 03:47:47', '2026-06-05 03:47:47'),
(100, 'STACO JASAPRATAMA INSURANCE', NULL, '2026-06-05 03:47:47', '2026-06-05 03:47:47'),
(101, 'SARANA LINDUNG UPAYA INSURANCE', NULL, '2026-06-05 03:48:06', '2026-06-05 03:48:06'),
(102, 'ASURANSI ETIQA', NULL, '2026-06-05 03:48:09', '2026-06-05 03:48:09'),
(103, 'STACO MANDIRI INSURANCE', NULL, '2026-06-05 03:48:18', '2026-06-05 03:48:18'),
(104, 'EKA LLOYD JAYA INSURANCE', NULL, '2026-06-05 03:48:27', '2026-06-05 03:48:27'),
(105, 'SONWELIS INSURANCE', NULL, '2026-06-05 03:48:40', '2026-06-05 03:48:40'),
(106, 'FAIRFAX INSURANCE', NULL, '2026-06-05 03:48:42', '2026-06-05 03:48:42'),
(107, 'SARIJAYA INSURANCE', NULL, '2026-06-05 03:49:01', '2026-06-05 03:49:01'),
(108, 'FADENT MAHKOTA SAHID INSURANCE', NULL, '2026-06-05 03:49:02', '2026-06-05 03:49:02'),
(109, 'ASURANSI UMUM SEAINSURE', NULL, '2026-06-05 03:49:24', '2026-06-05 03:49:24'),
(110, 'INDRAPURA / FPG INSURANCE', NULL, '2026-06-05 03:49:24', '2026-06-05 03:49:24'),
(111, 'SAMSUNG TUGU INSURANCE', NULL, '2026-06-05 03:49:34', '2026-06-05 03:49:34'),
(112, 'GARDA OTO INSURANCE', NULL, '2026-06-05 03:49:35', '2026-06-05 03:49:35'),
(113, 'ASURANSI SUNDAY', NULL, '2026-06-05 03:49:43', '2026-06-05 03:49:43'),
(114, 'HANJIN KORINDO INSURANCE', NULL, '2026-06-05 03:49:55', '2026-06-05 03:49:55'),
(115, 'TAP INSURANCE / PT ASURANSI UNTUK SEMUA (TAP)', NULL, '2026-06-05 03:50:06', '2026-06-05 03:50:06'),
(116, 'HIMLAYA PELINDUNG INSURANCE', NULL, '2026-06-05 03:50:16', '2026-06-05 03:50:16'),
(117, 'TOKIO MARINE INSURANCE', NULL, '2026-06-05 03:50:17', '2026-06-05 03:50:17'),
(118, 'HARTA AMAN PRATAMA', NULL, '2026-06-05 03:50:30', '2026-06-05 03:50:30'),
(119, 'TOTAL BERSAMA INSURANCE', NULL, '2026-06-05 03:50:33', '2026-06-05 03:50:33'),
(120, 'INTRA ASIA INSURANCE', NULL, '2026-06-05 03:50:41', '2026-06-05 03:50:41'),
(121, 'TOTAL LOS ONLY (TLO) INSURANCE', NULL, '2026-06-05 03:50:50', '2026-06-05 03:50:50'),
(122, 'JASINDO INSURANCE', NULL, '2026-06-05 03:50:52', '2026-06-05 03:50:52'),
(123, 'JASINDO SYARIAH', NULL, '2026-06-05 03:51:03', '2026-06-05 03:51:03'),
(124, 'PT ASURANSI TOTAL BERSAMA', NULL, '2026-06-05 03:51:08', '2026-06-05 03:51:08'),
(125, 'PT ASURANSI TOTAL BERSAMA', NULL, '2026-06-05 03:51:08', '2026-06-05 03:51:08'),
(126, 'JAMINDO GENERAL INSURANCE', NULL, '2026-06-05 03:51:17', '2026-06-05 03:51:17'),
(127, 'TRIPAKARTA INSURANCE', NULL, '2026-06-05 03:51:22', '2026-06-05 03:51:22'),
(128, 'JAYA PROTEKSI INSURANCE', NULL, '2026-06-05 03:51:30', '2026-06-05 03:51:30'),
(129, 'TUGU KRESNA PRATAMA INSURANCE', NULL, '2026-06-05 03:51:42', '2026-06-05 03:51:42'),
(130, 'JASA RAHARJA PUTRA INSURANCE', NULL, '2026-06-05 03:51:43', '2026-06-05 03:51:43'),
(131, 'JASA TANIA INSURANCE', NULL, '2026-06-05 03:51:52', '2026-06-05 03:51:52'),
(132, 'TUGU PRATAMA INDONESIA INSURANCE', NULL, '2026-06-05 03:51:56', '2026-06-05 03:51:56'),
(133, 'TAKAFUL UMUM INSURANCE', NULL, '2026-06-05 03:52:07', '2026-06-05 03:52:07'),
(134, 'ASURANSI UMUM MONEEINSURE', NULL, '2026-06-05 03:52:21', '2026-06-05 03:52:21'),
(135, 'VIDEI INSURANCE / PT. ASURANSI UMUM VIDEI', NULL, '2026-06-05 03:52:45', '2026-06-05 03:52:45'),
(136, 'WANAMEKAR HANDAYANI INSURANCE', NULL, '2026-06-05 03:53:00', '2026-06-05 03:53:00'),
(137, 'WAHANA TATA INSURANCE', NULL, '2026-06-05 03:53:10', '2026-06-05 03:53:10'),
(138, 'WUWUNGAN INSURANCE', NULL, '2026-06-05 03:53:20', '2026-06-05 03:53:20'),
(139, 'PT.ZURICH ASURANSI INDONESIA TBK', NULL, '2026-06-05 03:53:42', '2026-06-05 03:53:42'),
(140, 'ZURICH GENERAL TAKAFUL INDONESIA', NULL, '2026-06-05 03:54:28', '2026-06-05 03:54:28'),
(141, 'ZURICH INSURANCE', NULL, '2026-06-05 03:54:39', '2026-06-05 03:54:39'),
(142, 'ASURANSI ZURICH SYARIAH', NULL, '2026-06-05 03:55:25', '2026-06-05 03:55:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `budget_leads`
--

CREATE TABLE `budget_leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sumber_id` bigint(20) UNSIGNED NOT NULL,
  `budget` varchar(255) NOT NULL,
  `bulan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cabangs`
--

CREATE TABLE `cabangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cabangs`
--

INSERT INTO `cabangs` (`id`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'CIAWI', '2026-06-29 10:21:18', '2026-07-02 13:06:53', NULL),
(2, 'CIANJUR', '2026-06-29 10:21:18', '2026-07-02 13:06:48', NULL),
(3, 'CINERE', '2026-06-29 10:21:18', '2026-07-02 13:06:59', NULL),
(4, 'JATIASIH', '2026-06-29 10:21:18', '2026-07-02 13:07:08', NULL),
(5, 'HO', '2026-06-29 10:21:18', '2026-07-07 15:22:48', '2026-07-07 15:22:48'),
(6, 'CIPANAS', '2026-07-02 13:05:02', '2026-07-02 13:05:02', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-dash_v1_pure_so_lookup_v3_2026_7_pusat', 'a:7:{s:22:\"all_branch_review_data\";a:5:{s:5:\"Ciawi\";a:2:{s:10:\"reviewData\";a:9:{i:0;O:8:\"stdClass\":22:{s:5:\"model\";s:9:\"NEW CARRY\";s:8:\"inq_prev\";i:108;s:8:\"inq_curr\";i:58;s:8:\"inq_gwth\";d:-46.2962962962963;s:8:\"spk_prev\";i:14;s:8:\"spk_curr\";i:17;s:8:\"spk_gwth\";d:21.428571428571427;s:9:\"fp_r_prev\";i:14;s:9:\"fp_r_curr\";i:15;s:9:\"fp_r_gwth\";d:7.142857142857142;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:14;s:13:\"fp_total_curr\";i:15;s:13:\"fp_total_gwth\";d:7.142857142857142;s:15:\"sr_inq_spk_prev\";d:12.962962962962962;s:15:\"sr_inq_spk_curr\";d:29.310344827586203;s:15:\"sr_inq_spk_diff\";d:16.34738186462324;s:14:\"sr_spk_fp_prev\";i:100;s:14:\"sr_spk_fp_curr\";d:88.23529411764706;s:14:\"sr_spk_fp_diff\";d:-11.764705882352942;}i:1;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"XL7\";s:8:\"inq_prev\";i:65;s:8:\"inq_curr\";i:31;s:8:\"inq_gwth\";d:-52.307692307692314;s:8:\"spk_prev\";i:9;s:8:\"spk_curr\";i:9;s:8:\"spk_gwth\";i:0;s:9:\"fp_r_prev\";i:5;s:9:\"fp_r_curr\";i:5;s:9:\"fp_r_gwth\";i:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:5;s:13:\"fp_total_curr\";i:5;s:13:\"fp_total_gwth\";i:0;s:15:\"sr_inq_spk_prev\";d:13.846153846153847;s:15:\"sr_inq_spk_curr\";d:29.03225806451613;s:15:\"sr_inq_spk_diff\";d:15.186104218362285;s:14:\"sr_spk_fp_prev\";d:55.55555555555556;s:14:\"sr_spk_fp_curr\";d:55.55555555555556;s:14:\"sr_spk_fp_diff\";d:0;}i:2;O:8:\"stdClass\":22:{s:5:\"model\";s:5:\"FRONX\";s:8:\"inq_prev\";i:56;s:8:\"inq_curr\";i:25;s:8:\"inq_gwth\";d:-55.35714285714286;s:8:\"spk_prev\";i:6;s:8:\"spk_curr\";i:4;s:8:\"spk_gwth\";d:-33.33333333333333;s:9:\"fp_r_prev\";i:2;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";i:-100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:2;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";i:-100;s:15:\"sr_inq_spk_prev\";d:10.714285714285714;s:15:\"sr_inq_spk_curr\";d:16;s:15:\"sr_inq_spk_diff\";d:5.2857142857142865;s:14:\"sr_spk_fp_prev\";d:33.33333333333333;s:14:\"sr_spk_fp_curr\";i:0;s:14:\"sr_spk_fp_diff\";d:-33.33333333333333;}i:3;O:8:\"stdClass\":22:{s:5:\"model\";s:14:\"ALL NEW ERTIGA\";s:8:\"inq_prev\";i:7;s:8:\"inq_curr\";i:2;s:8:\"inq_gwth\";d:-71.42857142857143;s:8:\"spk_prev\";i:2;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";i:-100;s:9:\"fp_r_prev\";i:5;s:9:\"fp_r_curr\";i:3;s:9:\"fp_r_gwth\";d:-40;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:5;s:13:\"fp_total_curr\";i:3;s:13:\"fp_total_gwth\";d:-40;s:15:\"sr_inq_spk_prev\";d:28.57142857142857;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";d:-28.57142857142857;s:14:\"sr_spk_fp_prev\";d:250;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:-250;}i:4;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"APV\";s:8:\"inq_prev\";i:3;s:8:\"inq_curr\";i:2;s:8:\"inq_gwth\";d:-33.33333333333333;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:1;s:8:\"spk_gwth\";d:100;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:1;s:9:\"fp_r_gwth\";d:100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:1;s:13:\"fp_total_gwth\";d:100;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";d:50;s:15:\"sr_inq_spk_diff\";d:50;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";i:100;s:14:\"sr_spk_fp_diff\";d:100;}i:5;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"S-PRESSO\";s:8:\"inq_prev\";i:22;s:8:\"inq_curr\";i:11;s:8:\"inq_gwth\";d:-50;s:8:\"spk_prev\";i:2;s:8:\"spk_curr\";i:1;s:8:\"spk_gwth\";d:-50;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";d:9.090909090909092;s:15:\"sr_inq_spk_curr\";d:9.090909090909092;s:15:\"sr_inq_spk_diff\";d:0;s:14:\"sr_spk_fp_prev\";i:0;s:14:\"sr_spk_fp_curr\";i:0;s:14:\"sr_spk_fp_diff\";i:0;}i:6;O:8:\"stdClass\":22:{s:5:\"model\";s:12:\"GRAND VITARA\";s:8:\"inq_prev\";i:7;s:8:\"inq_curr\";i:2;s:8:\"inq_gwth\";d:-71.42857142857143;s:8:\"spk_prev\";i:1;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";i:-100;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";d:14.285714285714285;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";d:-14.285714285714285;s:14:\"sr_spk_fp_prev\";i:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:7;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 3D\";s:8:\"inq_prev\";i:1;s:8:\"inq_curr\";i:2;s:8:\"inq_gwth\";i:100;s:8:\"spk_prev\";i:2;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";i:-100;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:200;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:-200;s:14:\"sr_spk_fp_prev\";i:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:8;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 5D\";s:8:\"inq_prev\";i:22;s:8:\"inq_curr\";i:2;s:8:\"inq_gwth\";d:-90.9090909090909;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:3;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";i:-100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:3;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";i:-100;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}}s:12:\"summaryTotal\";O:8:\"stdClass\":21:{s:8:\"inq_prev\";i:291;s:8:\"inq_curr\";i:135;s:8:\"inq_gwth\";d:-53.608247422680414;s:8:\"spk_prev\";i:36;s:8:\"spk_curr\";i:32;s:8:\"spk_gwth\";d:-11.11111111111111;s:9:\"fp_r_prev\";i:29;s:9:\"fp_r_curr\";i:24;s:9:\"fp_r_gwth\";d:-17.24137931034483;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:29;s:13:\"fp_total_curr\";i:24;s:13:\"fp_total_gwth\";d:-17.24137931034483;s:15:\"sr_inq_spk_prev\";d:12.371134020618557;s:15:\"sr_inq_spk_curr\";d:23.703703703703706;s:15:\"sr_inq_spk_diff\";d:11.332569683085149;s:14:\"sr_spk_fp_prev\";d:80.55555555555556;s:14:\"sr_spk_fp_curr\";d:75;s:14:\"sr_spk_fp_diff\";d:-5.555555555555557;}}s:7:\"Cianjur\";a:2:{s:10:\"reviewData\";a:9:{i:0;O:8:\"stdClass\":22:{s:5:\"model\";s:9:\"NEW CARRY\";s:8:\"inq_prev\";i:586;s:8:\"inq_curr\";i:649;s:8:\"inq_gwth\";d:10.750853242320819;s:8:\"spk_prev\";i:47;s:8:\"spk_curr\";i:37;s:8:\"spk_gwth\";d:-21.27659574468085;s:9:\"fp_r_prev\";i:25;s:9:\"fp_r_curr\";i:26;s:9:\"fp_r_gwth\";d:4;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:25;s:13:\"fp_total_curr\";i:26;s:13:\"fp_total_gwth\";d:4;s:15:\"sr_inq_spk_prev\";d:8.020477815699659;s:15:\"sr_inq_spk_curr\";d:5.701078582434515;s:15:\"sr_inq_spk_diff\";d:-2.319399233265144;s:14:\"sr_spk_fp_prev\";d:53.191489361702125;s:14:\"sr_spk_fp_curr\";d:70.27027027027027;s:14:\"sr_spk_fp_diff\";d:17.07878090856815;}i:1;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"XL7\";s:8:\"inq_prev\";i:205;s:8:\"inq_curr\";i:209;s:8:\"inq_gwth\";d:1.951219512195122;s:8:\"spk_prev\";i:4;s:8:\"spk_curr\";i:7;s:8:\"spk_gwth\";d:75;s:9:\"fp_r_prev\";i:3;s:9:\"fp_r_curr\";i:3;s:9:\"fp_r_gwth\";i:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:3;s:13:\"fp_total_curr\";i:3;s:13:\"fp_total_gwth\";i:0;s:15:\"sr_inq_spk_prev\";d:1.951219512195122;s:15:\"sr_inq_spk_curr\";d:3.349282296650718;s:15:\"sr_inq_spk_diff\";d:1.398062784455596;s:14:\"sr_spk_fp_prev\";d:75;s:14:\"sr_spk_fp_curr\";d:42.857142857142854;s:14:\"sr_spk_fp_diff\";d:-32.142857142857146;}i:2;O:8:\"stdClass\":22:{s:5:\"model\";s:5:\"FRONX\";s:8:\"inq_prev\";i:211;s:8:\"inq_curr\";i:193;s:8:\"inq_gwth\";d:-8.530805687203792;s:8:\"spk_prev\";i:4;s:8:\"spk_curr\";i:3;s:8:\"spk_gwth\";d:-25;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:1;s:9:\"fp_r_gwth\";d:100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:1;s:13:\"fp_total_gwth\";d:100;s:15:\"sr_inq_spk_prev\";d:1.8957345971563981;s:15:\"sr_inq_spk_curr\";d:1.5544041450777202;s:15:\"sr_inq_spk_diff\";d:-0.34133045207867796;s:14:\"sr_spk_fp_prev\";i:0;s:14:\"sr_spk_fp_curr\";d:33.33333333333333;s:14:\"sr_spk_fp_diff\";d:33.33333333333333;}i:3;O:8:\"stdClass\":22:{s:5:\"model\";s:14:\"ALL NEW ERTIGA\";s:8:\"inq_prev\";i:13;s:8:\"inq_curr\";i:29;s:8:\"inq_gwth\";d:123.07692307692308;s:8:\"spk_prev\";i:1;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";i:-100;s:9:\"fp_r_prev\";i:4;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";i:-100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:4;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";i:-100;s:15:\"sr_inq_spk_prev\";d:7.6923076923076925;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";d:-7.6923076923076925;s:14:\"sr_spk_fp_prev\";i:400;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:-400;}i:4;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"APV\";s:8:\"inq_prev\";i:24;s:8:\"inq_curr\";i:15;s:8:\"inq_gwth\";d:-37.5;s:8:\"spk_prev\";i:8;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";i:-100;s:9:\"fp_r_prev\";i:4;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";i:-100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:4;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";i:-100;s:15:\"sr_inq_spk_prev\";d:33.33333333333333;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";d:-33.33333333333333;s:14:\"sr_spk_fp_prev\";d:50;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:-50;}i:5;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"S-PRESSO\";s:8:\"inq_prev\";i:36;s:8:\"inq_curr\";i:52;s:8:\"inq_gwth\";d:44.44444444444444;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:1;s:8:\"spk_gwth\";d:100;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";d:1.9230769230769231;s:15:\"sr_inq_spk_diff\";d:1.9230769230769231;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";i:0;s:14:\"sr_spk_fp_diff\";d:0;}i:6;O:8:\"stdClass\":22:{s:5:\"model\";s:12:\"GRAND VITARA\";s:8:\"inq_prev\";i:6;s:8:\"inq_curr\";i:12;s:8:\"inq_gwth\";i:100;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:7;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 3D\";s:8:\"inq_prev\";i:1;s:8:\"inq_curr\";i:4;s:8:\"inq_gwth\";i:300;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:8;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 5D\";s:8:\"inq_prev\";i:1;s:8:\"inq_curr\";i:5;s:8:\"inq_gwth\";i:400;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}}s:12:\"summaryTotal\";O:8:\"stdClass\":21:{s:8:\"inq_prev\";i:1083;s:8:\"inq_curr\";i:1168;s:8:\"inq_gwth\";d:7.848568790397045;s:8:\"spk_prev\";i:64;s:8:\"spk_curr\";i:48;s:8:\"spk_gwth\";d:-25;s:9:\"fp_r_prev\";i:36;s:9:\"fp_r_curr\";i:30;s:9:\"fp_r_gwth\";d:-16.666666666666664;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:36;s:13:\"fp_total_curr\";i:30;s:13:\"fp_total_gwth\";d:-16.666666666666664;s:15:\"sr_inq_spk_prev\";d:5.909510618651892;s:15:\"sr_inq_spk_curr\";d:4.10958904109589;s:15:\"sr_inq_spk_diff\";d:-1.7999215775560025;s:14:\"sr_spk_fp_prev\";d:56.25;s:14:\"sr_spk_fp_curr\";d:62.5;s:14:\"sr_spk_fp_diff\";d:6.25;}}s:6:\"Cinere\";a:2:{s:10:\"reviewData\";a:9:{i:0;O:8:\"stdClass\":22:{s:5:\"model\";s:9:\"NEW CARRY\";s:8:\"inq_prev\";i:113;s:8:\"inq_curr\";i:103;s:8:\"inq_gwth\";d:-8.849557522123893;s:8:\"spk_prev\";i:1;s:8:\"spk_curr\";i:1;s:8:\"spk_gwth\";i:0;s:9:\"fp_r_prev\";i:1;s:9:\"fp_r_curr\";i:1;s:9:\"fp_r_gwth\";i:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:1;s:13:\"fp_total_curr\";i:1;s:13:\"fp_total_gwth\";i:0;s:15:\"sr_inq_spk_prev\";d:0.8849557522123894;s:15:\"sr_inq_spk_curr\";d:0.9708737864077669;s:15:\"sr_inq_spk_diff\";d:0.08591803419537747;s:14:\"sr_spk_fp_prev\";i:100;s:14:\"sr_spk_fp_curr\";i:100;s:14:\"sr_spk_fp_diff\";i:0;}i:1;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"XL7\";s:8:\"inq_prev\";i:195;s:8:\"inq_curr\";i:164;s:8:\"inq_gwth\";d:-15.897435897435896;s:8:\"spk_prev\";i:3;s:8:\"spk_curr\";i:5;s:8:\"spk_gwth\";d:66.66666666666666;s:9:\"fp_r_prev\";i:4;s:9:\"fp_r_curr\";i:4;s:9:\"fp_r_gwth\";i:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:4;s:13:\"fp_total_curr\";i:4;s:13:\"fp_total_gwth\";i:0;s:15:\"sr_inq_spk_prev\";d:1.5384615384615385;s:15:\"sr_inq_spk_curr\";d:3.048780487804878;s:15:\"sr_inq_spk_diff\";d:1.5103189493433395;s:14:\"sr_spk_fp_prev\";d:133.33333333333331;s:14:\"sr_spk_fp_curr\";d:80;s:14:\"sr_spk_fp_diff\";d:-53.333333333333314;}i:2;O:8:\"stdClass\":22:{s:5:\"model\";s:5:\"FRONX\";s:8:\"inq_prev\";i:148;s:8:\"inq_curr\";i:109;s:8:\"inq_gwth\";d:-26.351351351351347;s:8:\"spk_prev\";i:4;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";i:-100;s:9:\"fp_r_prev\";i:1;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";i:-100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:1;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";i:-100;s:15:\"sr_inq_spk_prev\";d:2.7027027027027026;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";d:-2.7027027027027026;s:14:\"sr_spk_fp_prev\";d:25;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:-25;}i:3;O:8:\"stdClass\":22:{s:5:\"model\";s:14:\"ALL NEW ERTIGA\";s:8:\"inq_prev\";i:18;s:8:\"inq_curr\";i:23;s:8:\"inq_gwth\";d:27.77777777777778;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:3;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";i:-100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:3;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";i:-100;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:4;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"APV\";s:8:\"inq_prev\";i:15;s:8:\"inq_curr\";i:16;s:8:\"inq_gwth\";d:6.666666666666667;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:1;s:8:\"spk_gwth\";d:100;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:1;s:9:\"fp_r_gwth\";d:100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:1;s:13:\"fp_total_gwth\";d:100;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";d:6.25;s:15:\"sr_inq_spk_diff\";d:6.25;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";i:100;s:14:\"sr_spk_fp_diff\";d:100;}i:5;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"S-PRESSO\";s:8:\"inq_prev\";i:66;s:8:\"inq_curr\";i:58;s:8:\"inq_gwth\";d:-12.121212121212121;s:8:\"spk_prev\";i:1;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";i:-100;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";d:1.5151515151515151;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";d:-1.5151515151515151;s:14:\"sr_spk_fp_prev\";i:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:6;O:8:\"stdClass\":22:{s:5:\"model\";s:12:\"GRAND VITARA\";s:8:\"inq_prev\";i:37;s:8:\"inq_curr\";i:46;s:8:\"inq_gwth\";d:24.324324324324326;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:7;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 3D\";s:8:\"inq_prev\";i:6;s:8:\"inq_curr\";i:2;s:8:\"inq_gwth\";d:-66.66666666666666;s:8:\"spk_prev\";i:1;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";i:-100;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";d:16.666666666666664;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";d:-16.666666666666664;s:14:\"sr_spk_fp_prev\";i:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:8;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 5D\";s:8:\"inq_prev\";i:17;s:8:\"inq_curr\";i:24;s:8:\"inq_gwth\";d:41.17647058823529;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:1;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";i:-100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:1;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";i:-100;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}}s:12:\"summaryTotal\";O:8:\"stdClass\":21:{s:8:\"inq_prev\";i:615;s:8:\"inq_curr\";i:545;s:8:\"inq_gwth\";d:-11.38211382113821;s:8:\"spk_prev\";i:10;s:8:\"spk_curr\";i:7;s:8:\"spk_gwth\";d:-30;s:9:\"fp_r_prev\";i:10;s:9:\"fp_r_curr\";i:6;s:9:\"fp_r_gwth\";d:-40;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:10;s:13:\"fp_total_curr\";i:6;s:13:\"fp_total_gwth\";d:-40;s:15:\"sr_inq_spk_prev\";d:1.6260162601626018;s:15:\"sr_inq_spk_curr\";d:1.2844036697247707;s:15:\"sr_inq_spk_diff\";d:-0.3416125904378311;s:14:\"sr_spk_fp_prev\";i:100;s:14:\"sr_spk_fp_curr\";d:85.71428571428571;s:14:\"sr_spk_fp_diff\";d:-14.285714285714292;}}s:8:\"Jatiasih\";a:2:{s:10:\"reviewData\";a:9:{i:0;O:8:\"stdClass\":22:{s:5:\"model\";s:9:\"NEW CARRY\";s:8:\"inq_prev\";i:215;s:8:\"inq_curr\";i:485;s:8:\"inq_gwth\";d:125.5813953488372;s:8:\"spk_prev\";i:8;s:8:\"spk_curr\";i:1;s:8:\"spk_gwth\";d:-87.5;s:9:\"fp_r_prev\";i:7;s:9:\"fp_r_curr\";i:1;s:9:\"fp_r_gwth\";d:-85.71428571428571;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:7;s:13:\"fp_total_curr\";i:1;s:13:\"fp_total_gwth\";d:-85.71428571428571;s:15:\"sr_inq_spk_prev\";d:3.7209302325581395;s:15:\"sr_inq_spk_curr\";d:0.2061855670103093;s:15:\"sr_inq_spk_diff\";d:-3.51474466554783;s:14:\"sr_spk_fp_prev\";d:87.5;s:14:\"sr_spk_fp_curr\";i:100;s:14:\"sr_spk_fp_diff\";d:12.5;}i:1;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"XL7\";s:8:\"inq_prev\";i:201;s:8:\"inq_curr\";i:305;s:8:\"inq_gwth\";d:51.741293532338304;s:8:\"spk_prev\";i:1;s:8:\"spk_curr\";i:4;s:8:\"spk_gwth\";i:300;s:9:\"fp_r_prev\";i:3;s:9:\"fp_r_curr\";i:3;s:9:\"fp_r_gwth\";i:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:3;s:13:\"fp_total_curr\";i:3;s:13:\"fp_total_gwth\";i:0;s:15:\"sr_inq_spk_prev\";d:0.4975124378109453;s:15:\"sr_inq_spk_curr\";d:1.3114754098360655;s:15:\"sr_inq_spk_diff\";d:0.8139629720251202;s:14:\"sr_spk_fp_prev\";i:300;s:14:\"sr_spk_fp_curr\";d:75;s:14:\"sr_spk_fp_diff\";d:-225;}i:2;O:8:\"stdClass\":22:{s:5:\"model\";s:5:\"FRONX\";s:8:\"inq_prev\";i:188;s:8:\"inq_curr\";i:345;s:8:\"inq_gwth\";d:83.51063829787235;s:8:\"spk_prev\";i:3;s:8:\"spk_curr\";i:9;s:8:\"spk_gwth\";i:200;s:9:\"fp_r_prev\";i:2;s:9:\"fp_r_curr\";i:1;s:9:\"fp_r_gwth\";d:-50;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:2;s:13:\"fp_total_curr\";i:1;s:13:\"fp_total_gwth\";d:-50;s:15:\"sr_inq_spk_prev\";d:1.5957446808510638;s:15:\"sr_inq_spk_curr\";d:2.608695652173913;s:15:\"sr_inq_spk_diff\";d:1.0129509713228493;s:14:\"sr_spk_fp_prev\";d:66.66666666666666;s:14:\"sr_spk_fp_curr\";d:11.11111111111111;s:14:\"sr_spk_fp_diff\";d:-55.55555555555554;}i:3;O:8:\"stdClass\":22:{s:5:\"model\";s:14:\"ALL NEW ERTIGA\";s:8:\"inq_prev\";i:32;s:8:\"inq_curr\";i:55;s:8:\"inq_gwth\";d:71.875;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:3;s:9:\"fp_r_curr\";i:7;s:9:\"fp_r_gwth\";d:133.33333333333331;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:3;s:13:\"fp_total_curr\";i:7;s:13:\"fp_total_gwth\";d:133.33333333333331;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:4;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"APV\";s:8:\"inq_prev\";i:84;s:8:\"inq_curr\";i:48;s:8:\"inq_gwth\";d:-42.857142857142854;s:8:\"spk_prev\";i:1;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";i:-100;s:9:\"fp_r_prev\";i:1;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";i:-100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:1;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";i:-100;s:15:\"sr_inq_spk_prev\";d:1.1904761904761905;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";d:-1.1904761904761905;s:14:\"sr_spk_fp_prev\";i:100;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:-100;}i:5;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"S-PRESSO\";s:8:\"inq_prev\";i:72;s:8:\"inq_curr\";i:75;s:8:\"inq_gwth\";d:4.166666666666666;s:8:\"spk_prev\";i:3;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";i:-100;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";d:4.166666666666666;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";d:-4.166666666666666;s:14:\"sr_spk_fp_prev\";i:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:6;O:8:\"stdClass\":22:{s:5:\"model\";s:12:\"GRAND VITARA\";s:8:\"inq_prev\";i:54;s:8:\"inq_curr\";i:65;s:8:\"inq_gwth\";d:20.37037037037037;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:7;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 3D\";s:8:\"inq_prev\";i:4;s:8:\"inq_curr\";i:1;s:8:\"inq_gwth\";d:-75;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:8;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 5D\";s:8:\"inq_prev\";i:6;s:8:\"inq_curr\";i:14;s:8:\"inq_gwth\";d:133.33333333333331;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}}s:12:\"summaryTotal\";O:8:\"stdClass\":21:{s:8:\"inq_prev\";i:856;s:8:\"inq_curr\";i:1393;s:8:\"inq_gwth\";d:62.73364485981309;s:8:\"spk_prev\";i:16;s:8:\"spk_curr\";i:14;s:8:\"spk_gwth\";d:-12.5;s:9:\"fp_r_prev\";i:16;s:9:\"fp_r_curr\";i:12;s:9:\"fp_r_gwth\";d:-25;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:16;s:13:\"fp_total_curr\";i:12;s:13:\"fp_total_gwth\";d:-25;s:15:\"sr_inq_spk_prev\";d:1.8691588785046727;s:15:\"sr_inq_spk_curr\";d:1.0050251256281406;s:15:\"sr_inq_spk_diff\";d:-0.864133752876532;s:14:\"sr_spk_fp_prev\";i:100;s:14:\"sr_spk_fp_curr\";d:85.71428571428571;s:14:\"sr_spk_fp_diff\";d:-14.285714285714292;}}s:7:\"Cipanas\";a:2:{s:10:\"reviewData\";a:9:{i:0;O:8:\"stdClass\":22:{s:5:\"model\";s:9:\"NEW CARRY\";s:8:\"inq_prev\";i:58;s:8:\"inq_curr\";i:100;s:8:\"inq_gwth\";d:72.41379310344827;s:8:\"spk_prev\";i:6;s:8:\"spk_curr\";i:7;s:8:\"spk_gwth\";d:16.666666666666664;s:9:\"fp_r_prev\";i:1;s:9:\"fp_r_curr\";i:3;s:9:\"fp_r_gwth\";i:200;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:1;s:13:\"fp_total_curr\";i:3;s:13:\"fp_total_gwth\";i:200;s:15:\"sr_inq_spk_prev\";d:10.344827586206897;s:15:\"sr_inq_spk_curr\";d:7.000000000000001;s:15:\"sr_inq_spk_diff\";d:-3.344827586206896;s:14:\"sr_spk_fp_prev\";d:16.666666666666664;s:14:\"sr_spk_fp_curr\";d:42.857142857142854;s:14:\"sr_spk_fp_diff\";d:26.19047619047619;}i:1;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"XL7\";s:8:\"inq_prev\";i:28;s:8:\"inq_curr\";i:30;s:8:\"inq_gwth\";d:7.142857142857142;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:1;s:8:\"spk_gwth\";d:100;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:1;s:9:\"fp_r_gwth\";d:100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:1;s:13:\"fp_total_gwth\";d:100;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";d:3.3333333333333335;s:15:\"sr_inq_spk_diff\";d:3.3333333333333335;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";i:100;s:14:\"sr_spk_fp_diff\";d:100;}i:2;O:8:\"stdClass\":22:{s:5:\"model\";s:5:\"FRONX\";s:8:\"inq_prev\";i:25;s:8:\"inq_curr\";i:40;s:8:\"inq_gwth\";d:60;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:3;O:8:\"stdClass\":22:{s:5:\"model\";s:14:\"ALL NEW ERTIGA\";s:8:\"inq_prev\";i:0;s:8:\"inq_curr\";i:1;s:8:\"inq_gwth\";d:100;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";d:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";d:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:4;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"APV\";s:8:\"inq_prev\";i:0;s:8:\"inq_curr\";i:0;s:8:\"inq_gwth\";d:0;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";d:0;s:15:\"sr_inq_spk_curr\";d:0;s:15:\"sr_inq_spk_diff\";d:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:5;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"S-PRESSO\";s:8:\"inq_prev\";i:12;s:8:\"inq_curr\";i:7;s:8:\"inq_gwth\";d:-41.66666666666667;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:6;O:8:\"stdClass\":22:{s:5:\"model\";s:12:\"GRAND VITARA\";s:8:\"inq_prev\";i:0;s:8:\"inq_curr\";i:1;s:8:\"inq_gwth\";d:100;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";d:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";d:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:7;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 3D\";s:8:\"inq_prev\";i:0;s:8:\"inq_curr\";i:0;s:8:\"inq_gwth\";d:0;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";d:0;s:15:\"sr_inq_spk_curr\";d:0;s:15:\"sr_inq_spk_diff\";d:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:8;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 5D\";s:8:\"inq_prev\";i:0;s:8:\"inq_curr\";i:0;s:8:\"inq_gwth\";d:0;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";d:0;s:15:\"sr_inq_spk_curr\";d:0;s:15:\"sr_inq_spk_diff\";d:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}}s:12:\"summaryTotal\";O:8:\"stdClass\":21:{s:8:\"inq_prev\";i:123;s:8:\"inq_curr\";i:179;s:8:\"inq_gwth\";d:45.52845528455284;s:8:\"spk_prev\";i:6;s:8:\"spk_curr\";i:8;s:8:\"spk_gwth\";d:33.33333333333333;s:9:\"fp_r_prev\";i:1;s:9:\"fp_r_curr\";i:4;s:9:\"fp_r_gwth\";i:300;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:1;s:13:\"fp_total_curr\";i:4;s:13:\"fp_total_gwth\";i:300;s:15:\"sr_inq_spk_prev\";d:4.878048780487805;s:15:\"sr_inq_spk_curr\";d:4.4692737430167595;s:15:\"sr_inq_spk_diff\";d:-0.40877503747104527;s:14:\"sr_spk_fp_prev\";d:16.666666666666664;s:14:\"sr_spk_fp_curr\";d:50;s:14:\"sr_spk_fp_diff\";d:33.333333333333336;}}}s:8:\"fromDate\";s:10:\"2026-07-01\";s:6:\"toDate\";s:10:\"2026-07-31\";s:12:\"filter_bulan\";s:3:\"jul\";s:8:\"bulanMap\";a:12:{i:1;s:3:\"jan\";i:2;s:3:\"feb\";i:3;s:3:\"mar\";i:4;s:3:\"apr\";i:5;s:3:\"mei\";i:6;s:3:\"jun\";i:7;s:3:\"jul\";i:8;s:3:\"agu\";i:9;s:3:\"sep\";i:10;s:3:\"okt\";i:11;s:3:\"nov\";i:12;s:3:\"des\";}s:14:\"prevMonthLabel\";s:6:\"Jun-26\";s:14:\"currMonthLabel\";s:6:\"Jul-26\";}', 1787387587);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-dash_v1_pure_so_lookup_v3_2026_8_pusat', 'a:7:{s:22:\"all_branch_review_data\";a:5:{s:5:\"Ciawi\";a:2:{s:10:\"reviewData\";a:9:{i:0;O:8:\"stdClass\":22:{s:5:\"model\";s:9:\"NEW CARRY\";s:8:\"inq_prev\";i:58;s:8:\"inq_curr\";i:41;s:8:\"inq_gwth\";d:-29.310344827586203;s:8:\"spk_prev\";i:17;s:8:\"spk_curr\";i:12;s:8:\"spk_gwth\";d:-29.411764705882355;s:9:\"fp_r_prev\";i:15;s:9:\"fp_r_curr\";i:8;s:9:\"fp_r_gwth\";d:-46.666666666666664;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:15;s:13:\"fp_total_curr\";i:8;s:13:\"fp_total_gwth\";d:-46.666666666666664;s:15:\"sr_inq_spk_prev\";d:29.310344827586203;s:15:\"sr_inq_spk_curr\";d:29.268292682926827;s:15:\"sr_inq_spk_diff\";d:-0.04205214465937601;s:14:\"sr_spk_fp_prev\";d:88.23529411764706;s:14:\"sr_spk_fp_curr\";d:66.66666666666666;s:14:\"sr_spk_fp_diff\";d:-21.5686274509804;}i:1;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"XL7\";s:8:\"inq_prev\";i:31;s:8:\"inq_curr\";i:28;s:8:\"inq_gwth\";d:-9.67741935483871;s:8:\"spk_prev\";i:9;s:8:\"spk_curr\";i:6;s:8:\"spk_gwth\";d:-33.33333333333333;s:9:\"fp_r_prev\";i:5;s:9:\"fp_r_curr\";i:3;s:9:\"fp_r_gwth\";d:-40;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:5;s:13:\"fp_total_curr\";i:3;s:13:\"fp_total_gwth\";d:-40;s:15:\"sr_inq_spk_prev\";d:29.03225806451613;s:15:\"sr_inq_spk_curr\";d:21.428571428571427;s:15:\"sr_inq_spk_diff\";d:-7.603686635944705;s:14:\"sr_spk_fp_prev\";d:55.55555555555556;s:14:\"sr_spk_fp_curr\";d:50;s:14:\"sr_spk_fp_diff\";d:-5.555555555555557;}i:2;O:8:\"stdClass\":22:{s:5:\"model\";s:5:\"FRONX\";s:8:\"inq_prev\";i:25;s:8:\"inq_curr\";i:16;s:8:\"inq_gwth\";d:-36;s:8:\"spk_prev\";i:4;s:8:\"spk_curr\";i:5;s:8:\"spk_gwth\";d:25;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:1;s:9:\"fp_r_gwth\";d:100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:1;s:13:\"fp_total_gwth\";d:100;s:15:\"sr_inq_spk_prev\";d:16;s:15:\"sr_inq_spk_curr\";d:31.25;s:15:\"sr_inq_spk_diff\";d:15.25;s:14:\"sr_spk_fp_prev\";i:0;s:14:\"sr_spk_fp_curr\";d:20;s:14:\"sr_spk_fp_diff\";d:20;}i:3;O:8:\"stdClass\":22:{s:5:\"model\";s:14:\"ALL NEW ERTIGA\";s:8:\"inq_prev\";i:2;s:8:\"inq_curr\";i:2;s:8:\"inq_gwth\";i:0;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:3;s:9:\"fp_r_curr\";i:3;s:9:\"fp_r_gwth\";i:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:3;s:13:\"fp_total_curr\";i:3;s:13:\"fp_total_gwth\";i:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:4;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"APV\";s:8:\"inq_prev\";i:2;s:8:\"inq_curr\";i:1;s:8:\"inq_gwth\";d:-50;s:8:\"spk_prev\";i:1;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";i:-100;s:9:\"fp_r_prev\";i:1;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";i:-100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:1;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";i:-100;s:15:\"sr_inq_spk_prev\";d:50;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";d:-50;s:14:\"sr_spk_fp_prev\";i:100;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:-100;}i:5;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"S-PRESSO\";s:8:\"inq_prev\";i:11;s:8:\"inq_curr\";i:6;s:8:\"inq_gwth\";d:-45.45454545454545;s:8:\"spk_prev\";i:1;s:8:\"spk_curr\";i:1;s:8:\"spk_gwth\";i:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";d:9.090909090909092;s:15:\"sr_inq_spk_curr\";d:16.666666666666664;s:15:\"sr_inq_spk_diff\";d:7.575757575757573;s:14:\"sr_spk_fp_prev\";i:0;s:14:\"sr_spk_fp_curr\";i:0;s:14:\"sr_spk_fp_diff\";i:0;}i:6;O:8:\"stdClass\":22:{s:5:\"model\";s:12:\"GRAND VITARA\";s:8:\"inq_prev\";i:2;s:8:\"inq_curr\";i:3;s:8:\"inq_gwth\";d:50;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:7;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 3D\";s:8:\"inq_prev\";i:2;s:8:\"inq_curr\";i:1;s:8:\"inq_gwth\";d:-50;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:8;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 5D\";s:8:\"inq_prev\";i:2;s:8:\"inq_curr\";i:1;s:8:\"inq_gwth\";d:-50;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}}s:12:\"summaryTotal\";O:8:\"stdClass\":21:{s:8:\"inq_prev\";i:135;s:8:\"inq_curr\";i:99;s:8:\"inq_gwth\";d:-26.666666666666668;s:8:\"spk_prev\";i:32;s:8:\"spk_curr\";i:24;s:8:\"spk_gwth\";d:-25;s:9:\"fp_r_prev\";i:24;s:9:\"fp_r_curr\";i:15;s:9:\"fp_r_gwth\";d:-37.5;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:24;s:13:\"fp_total_curr\";i:15;s:13:\"fp_total_gwth\";d:-37.5;s:15:\"sr_inq_spk_prev\";d:23.703703703703706;s:15:\"sr_inq_spk_curr\";d:24.242424242424242;s:15:\"sr_inq_spk_diff\";d:0.5387205387205363;s:14:\"sr_spk_fp_prev\";d:75;s:14:\"sr_spk_fp_curr\";d:62.5;s:14:\"sr_spk_fp_diff\";d:-12.5;}}s:7:\"Cianjur\";a:2:{s:10:\"reviewData\";a:9:{i:0;O:8:\"stdClass\":22:{s:5:\"model\";s:9:\"NEW CARRY\";s:8:\"inq_prev\";i:649;s:8:\"inq_curr\";i:338;s:8:\"inq_gwth\";d:-47.919876733436055;s:8:\"spk_prev\";i:37;s:8:\"spk_curr\";i:20;s:8:\"spk_gwth\";d:-45.94594594594595;s:9:\"fp_r_prev\";i:26;s:9:\"fp_r_curr\";i:10;s:9:\"fp_r_gwth\";d:-61.53846153846154;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:26;s:13:\"fp_total_curr\";i:10;s:13:\"fp_total_gwth\";d:-61.53846153846154;s:15:\"sr_inq_spk_prev\";d:5.701078582434515;s:15:\"sr_inq_spk_curr\";d:5.9171597633136095;s:15:\"sr_inq_spk_diff\";d:0.21608118087909478;s:14:\"sr_spk_fp_prev\";d:70.27027027027027;s:14:\"sr_spk_fp_curr\";d:50;s:14:\"sr_spk_fp_diff\";d:-20.270270270270274;}i:1;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"XL7\";s:8:\"inq_prev\";i:209;s:8:\"inq_curr\";i:138;s:8:\"inq_gwth\";d:-33.97129186602871;s:8:\"spk_prev\";i:7;s:8:\"spk_curr\";i:4;s:8:\"spk_gwth\";d:-42.857142857142854;s:9:\"fp_r_prev\";i:3;s:9:\"fp_r_curr\";i:3;s:9:\"fp_r_gwth\";i:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:3;s:13:\"fp_total_curr\";i:3;s:13:\"fp_total_gwth\";i:0;s:15:\"sr_inq_spk_prev\";d:3.349282296650718;s:15:\"sr_inq_spk_curr\";d:2.898550724637681;s:15:\"sr_inq_spk_diff\";d:-0.4507315720130367;s:14:\"sr_spk_fp_prev\";d:42.857142857142854;s:14:\"sr_spk_fp_curr\";d:75;s:14:\"sr_spk_fp_diff\";d:32.142857142857146;}i:2;O:8:\"stdClass\":22:{s:5:\"model\";s:5:\"FRONX\";s:8:\"inq_prev\";i:193;s:8:\"inq_curr\";i:103;s:8:\"inq_gwth\";d:-46.63212435233161;s:8:\"spk_prev\";i:3;s:8:\"spk_curr\";i:4;s:8:\"spk_gwth\";d:33.33333333333333;s:9:\"fp_r_prev\";i:1;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";i:-100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:1;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";i:-100;s:15:\"sr_inq_spk_prev\";d:1.5544041450777202;s:15:\"sr_inq_spk_curr\";d:3.8834951456310676;s:15:\"sr_inq_spk_diff\";d:2.3290910005533476;s:14:\"sr_spk_fp_prev\";d:33.33333333333333;s:14:\"sr_spk_fp_curr\";i:0;s:14:\"sr_spk_fp_diff\";d:-33.33333333333333;}i:3;O:8:\"stdClass\":22:{s:5:\"model\";s:14:\"ALL NEW ERTIGA\";s:8:\"inq_prev\";i:29;s:8:\"inq_curr\";i:13;s:8:\"inq_gwth\";d:-55.172413793103445;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:1;s:9:\"fp_r_gwth\";d:100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:1;s:13:\"fp_total_gwth\";d:100;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:4;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"APV\";s:8:\"inq_prev\";i:15;s:8:\"inq_curr\";i:5;s:8:\"inq_gwth\";d:-66.66666666666666;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:2;s:8:\"spk_gwth\";d:100;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";d:40;s:15:\"sr_inq_spk_diff\";d:40;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";i:0;s:14:\"sr_spk_fp_diff\";d:0;}i:5;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"S-PRESSO\";s:8:\"inq_prev\";i:52;s:8:\"inq_curr\";i:16;s:8:\"inq_gwth\";d:-69.23076923076923;s:8:\"spk_prev\";i:1;s:8:\"spk_curr\";i:1;s:8:\"spk_gwth\";i:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";d:1.9230769230769231;s:15:\"sr_inq_spk_curr\";d:6.25;s:15:\"sr_inq_spk_diff\";d:4.326923076923077;s:14:\"sr_spk_fp_prev\";i:0;s:14:\"sr_spk_fp_curr\";i:0;s:14:\"sr_spk_fp_diff\";i:0;}i:6;O:8:\"stdClass\":22:{s:5:\"model\";s:12:\"GRAND VITARA\";s:8:\"inq_prev\";i:12;s:8:\"inq_curr\";i:6;s:8:\"inq_gwth\";d:-50;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:1;s:8:\"spk_gwth\";d:100;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";d:16.666666666666664;s:15:\"sr_inq_spk_diff\";d:16.666666666666664;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";i:0;s:14:\"sr_spk_fp_diff\";d:0;}i:7;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 3D\";s:8:\"inq_prev\";i:4;s:8:\"inq_curr\";i:1;s:8:\"inq_gwth\";d:-75;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:3;s:8:\"spk_gwth\";d:100;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:300;s:15:\"sr_inq_spk_diff\";i:300;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";i:0;s:14:\"sr_spk_fp_diff\";d:0;}i:8;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 5D\";s:8:\"inq_prev\";i:5;s:8:\"inq_curr\";i:6;s:8:\"inq_gwth\";d:20;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:2;s:9:\"fp_r_gwth\";d:100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:2;s:13:\"fp_total_gwth\";d:100;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}}s:12:\"summaryTotal\";O:8:\"stdClass\":21:{s:8:\"inq_prev\";i:1168;s:8:\"inq_curr\";i:626;s:8:\"inq_gwth\";d:-46.4041095890411;s:8:\"spk_prev\";i:48;s:8:\"spk_curr\";i:35;s:8:\"spk_gwth\";d:-27.083333333333332;s:9:\"fp_r_prev\";i:30;s:9:\"fp_r_curr\";i:16;s:9:\"fp_r_gwth\";d:-46.666666666666664;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:30;s:13:\"fp_total_curr\";i:16;s:13:\"fp_total_gwth\";d:-46.666666666666664;s:15:\"sr_inq_spk_prev\";d:4.10958904109589;s:15:\"sr_inq_spk_curr\";d:5.5910543130990416;s:15:\"sr_inq_spk_diff\";d:1.4814652720031516;s:14:\"sr_spk_fp_prev\";d:62.5;s:14:\"sr_spk_fp_curr\";d:45.714285714285715;s:14:\"sr_spk_fp_diff\";d:-16.785714285714285;}}s:6:\"Cinere\";a:2:{s:10:\"reviewData\";a:9:{i:0;O:8:\"stdClass\":22:{s:5:\"model\";s:9:\"NEW CARRY\";s:8:\"inq_prev\";i:103;s:8:\"inq_curr\";i:49;s:8:\"inq_gwth\";d:-52.42718446601942;s:8:\"spk_prev\";i:1;s:8:\"spk_curr\";i:3;s:8:\"spk_gwth\";i:200;s:9:\"fp_r_prev\";i:1;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";i:-100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:1;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";i:-100;s:15:\"sr_inq_spk_prev\";d:0.9708737864077669;s:15:\"sr_inq_spk_curr\";d:6.122448979591836;s:15:\"sr_inq_spk_diff\";d:5.15157519318407;s:14:\"sr_spk_fp_prev\";i:100;s:14:\"sr_spk_fp_curr\";i:0;s:14:\"sr_spk_fp_diff\";i:-100;}i:1;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"XL7\";s:8:\"inq_prev\";i:164;s:8:\"inq_curr\";i:60;s:8:\"inq_gwth\";d:-63.41463414634146;s:8:\"spk_prev\";i:5;s:8:\"spk_curr\";i:3;s:8:\"spk_gwth\";d:-40;s:9:\"fp_r_prev\";i:4;s:9:\"fp_r_curr\";i:2;s:9:\"fp_r_gwth\";d:-50;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:4;s:13:\"fp_total_curr\";i:2;s:13:\"fp_total_gwth\";d:-50;s:15:\"sr_inq_spk_prev\";d:3.048780487804878;s:15:\"sr_inq_spk_curr\";d:5;s:15:\"sr_inq_spk_diff\";d:1.951219512195122;s:14:\"sr_spk_fp_prev\";d:80;s:14:\"sr_spk_fp_curr\";d:66.66666666666666;s:14:\"sr_spk_fp_diff\";d:-13.333333333333343;}i:2;O:8:\"stdClass\":22:{s:5:\"model\";s:5:\"FRONX\";s:8:\"inq_prev\";i:109;s:8:\"inq_curr\";i:39;s:8:\"inq_gwth\";d:-64.22018348623854;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:3;O:8:\"stdClass\":22:{s:5:\"model\";s:14:\"ALL NEW ERTIGA\";s:8:\"inq_prev\";i:23;s:8:\"inq_curr\";i:15;s:8:\"inq_gwth\";d:-34.78260869565217;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:4;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"APV\";s:8:\"inq_prev\";i:16;s:8:\"inq_curr\";i:5;s:8:\"inq_gwth\";d:-68.75;s:8:\"spk_prev\";i:1;s:8:\"spk_curr\";i:1;s:8:\"spk_gwth\";i:0;s:9:\"fp_r_prev\";i:1;s:9:\"fp_r_curr\";i:1;s:9:\"fp_r_gwth\";i:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:1;s:13:\"fp_total_curr\";i:1;s:13:\"fp_total_gwth\";i:0;s:15:\"sr_inq_spk_prev\";d:6.25;s:15:\"sr_inq_spk_curr\";d:20;s:15:\"sr_inq_spk_diff\";d:13.75;s:14:\"sr_spk_fp_prev\";i:100;s:14:\"sr_spk_fp_curr\";i:100;s:14:\"sr_spk_fp_diff\";i:0;}i:5;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"S-PRESSO\";s:8:\"inq_prev\";i:58;s:8:\"inq_curr\";i:24;s:8:\"inq_gwth\";d:-58.620689655172406;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:6;O:8:\"stdClass\":22:{s:5:\"model\";s:12:\"GRAND VITARA\";s:8:\"inq_prev\";i:46;s:8:\"inq_curr\";i:18;s:8:\"inq_gwth\";d:-60.86956521739131;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:7;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 3D\";s:8:\"inq_prev\";i:2;s:8:\"inq_curr\";i:2;s:8:\"inq_gwth\";i:0;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:2;s:8:\"spk_gwth\";d:100;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:100;s:15:\"sr_inq_spk_diff\";i:100;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";i:0;s:14:\"sr_spk_fp_diff\";d:0;}i:8;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 5D\";s:8:\"inq_prev\";i:24;s:8:\"inq_curr\";i:6;s:8:\"inq_gwth\";d:-75;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:1;s:9:\"fp_r_gwth\";d:100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:1;s:13:\"fp_total_gwth\";d:100;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}}s:12:\"summaryTotal\";O:8:\"stdClass\":21:{s:8:\"inq_prev\";i:545;s:8:\"inq_curr\";i:218;s:8:\"inq_gwth\";d:-60;s:8:\"spk_prev\";i:7;s:8:\"spk_curr\";i:9;s:8:\"spk_gwth\";d:28.57142857142857;s:9:\"fp_r_prev\";i:6;s:9:\"fp_r_curr\";i:4;s:9:\"fp_r_gwth\";d:-33.33333333333333;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:6;s:13:\"fp_total_curr\";i:4;s:13:\"fp_total_gwth\";d:-33.33333333333333;s:15:\"sr_inq_spk_prev\";d:1.2844036697247707;s:15:\"sr_inq_spk_curr\";d:4.128440366972478;s:15:\"sr_inq_spk_diff\";d:2.8440366972477067;s:14:\"sr_spk_fp_prev\";d:85.71428571428571;s:14:\"sr_spk_fp_curr\";d:44.44444444444444;s:14:\"sr_spk_fp_diff\";d:-41.269841269841265;}}s:8:\"Jatiasih\";a:2:{s:10:\"reviewData\";a:9:{i:0;O:8:\"stdClass\":22:{s:5:\"model\";s:9:\"NEW CARRY\";s:8:\"inq_prev\";i:485;s:8:\"inq_curr\";i:252;s:8:\"inq_gwth\";d:-48.04123711340206;s:8:\"spk_prev\";i:1;s:8:\"spk_curr\";i:9;s:8:\"spk_gwth\";i:800;s:9:\"fp_r_prev\";i:1;s:9:\"fp_r_curr\";i:3;s:9:\"fp_r_gwth\";i:200;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:1;s:13:\"fp_total_curr\";i:3;s:13:\"fp_total_gwth\";i:200;s:15:\"sr_inq_spk_prev\";d:0.2061855670103093;s:15:\"sr_inq_spk_curr\";d:3.571428571428571;s:15:\"sr_inq_spk_diff\";d:3.3652430044182617;s:14:\"sr_spk_fp_prev\";i:100;s:14:\"sr_spk_fp_curr\";d:33.33333333333333;s:14:\"sr_spk_fp_diff\";d:-66.66666666666667;}i:1;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"XL7\";s:8:\"inq_prev\";i:305;s:8:\"inq_curr\";i:184;s:8:\"inq_gwth\";d:-39.67213114754099;s:8:\"spk_prev\";i:4;s:8:\"spk_curr\";i:3;s:8:\"spk_gwth\";d:-25;s:9:\"fp_r_prev\";i:3;s:9:\"fp_r_curr\";i:2;s:9:\"fp_r_gwth\";d:-33.33333333333333;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:3;s:13:\"fp_total_curr\";i:2;s:13:\"fp_total_gwth\";d:-33.33333333333333;s:15:\"sr_inq_spk_prev\";d:1.3114754098360655;s:15:\"sr_inq_spk_curr\";d:1.6304347826086956;s:15:\"sr_inq_spk_diff\";d:0.3189593727726301;s:14:\"sr_spk_fp_prev\";d:75;s:14:\"sr_spk_fp_curr\";d:66.66666666666666;s:14:\"sr_spk_fp_diff\";d:-8.333333333333343;}i:2;O:8:\"stdClass\":22:{s:5:\"model\";s:5:\"FRONX\";s:8:\"inq_prev\";i:345;s:8:\"inq_curr\";i:167;s:8:\"inq_gwth\";d:-51.59420289855072;s:8:\"spk_prev\";i:9;s:8:\"spk_curr\";i:3;s:8:\"spk_gwth\";d:-66.66666666666666;s:9:\"fp_r_prev\";i:1;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";i:-100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:1;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";i:-100;s:15:\"sr_inq_spk_prev\";d:2.608695652173913;s:15:\"sr_inq_spk_curr\";d:1.7964071856287425;s:15:\"sr_inq_spk_diff\";d:-0.8122884665451706;s:14:\"sr_spk_fp_prev\";d:11.11111111111111;s:14:\"sr_spk_fp_curr\";i:0;s:14:\"sr_spk_fp_diff\";d:-11.11111111111111;}i:3;O:8:\"stdClass\":22:{s:5:\"model\";s:14:\"ALL NEW ERTIGA\";s:8:\"inq_prev\";i:55;s:8:\"inq_curr\";i:22;s:8:\"inq_gwth\";d:-60;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:7;s:9:\"fp_r_curr\";i:2;s:9:\"fp_r_gwth\";d:-71.42857142857143;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:7;s:13:\"fp_total_curr\";i:2;s:13:\"fp_total_gwth\";d:-71.42857142857143;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:4;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"APV\";s:8:\"inq_prev\";i:48;s:8:\"inq_curr\";i:15;s:8:\"inq_gwth\";d:-68.75;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:5;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"S-PRESSO\";s:8:\"inq_prev\";i:75;s:8:\"inq_curr\";i:29;s:8:\"inq_gwth\";d:-61.33333333333333;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:6;O:8:\"stdClass\":22:{s:5:\"model\";s:12:\"GRAND VITARA\";s:8:\"inq_prev\";i:65;s:8:\"inq_curr\";i:33;s:8:\"inq_gwth\";d:-49.23076923076923;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:7;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 3D\";s:8:\"inq_prev\";i:1;s:8:\"inq_curr\";i:1;s:8:\"inq_gwth\";i:0;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:1;s:8:\"spk_gwth\";d:100;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:100;s:15:\"sr_inq_spk_diff\";i:100;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";i:0;s:14:\"sr_spk_fp_diff\";d:0;}i:8;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 5D\";s:8:\"inq_prev\";i:14;s:8:\"inq_curr\";i:17;s:8:\"inq_gwth\";d:21.428571428571427;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:1;s:9:\"fp_r_gwth\";d:100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:1;s:13:\"fp_total_gwth\";d:100;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}}s:12:\"summaryTotal\";O:8:\"stdClass\":21:{s:8:\"inq_prev\";i:1393;s:8:\"inq_curr\";i:720;s:8:\"inq_gwth\";d:-48.31299353912419;s:8:\"spk_prev\";i:14;s:8:\"spk_curr\";i:16;s:8:\"spk_gwth\";d:14.285714285714285;s:9:\"fp_r_prev\";i:12;s:9:\"fp_r_curr\";i:8;s:9:\"fp_r_gwth\";d:-33.33333333333333;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:12;s:13:\"fp_total_curr\";i:8;s:13:\"fp_total_gwth\";d:-33.33333333333333;s:15:\"sr_inq_spk_prev\";d:1.0050251256281406;s:15:\"sr_inq_spk_curr\";d:2.2222222222222223;s:15:\"sr_inq_spk_diff\";d:1.2171970965940817;s:14:\"sr_spk_fp_prev\";d:85.71428571428571;s:14:\"sr_spk_fp_curr\";d:50;s:14:\"sr_spk_fp_diff\";d:-35.71428571428571;}}s:7:\"Cipanas\";a:2:{s:10:\"reviewData\";a:9:{i:0;O:8:\"stdClass\":22:{s:5:\"model\";s:9:\"NEW CARRY\";s:8:\"inq_prev\";i:100;s:8:\"inq_curr\";i:92;s:8:\"inq_gwth\";d:-8;s:8:\"spk_prev\";i:7;s:8:\"spk_curr\";i:8;s:8:\"spk_gwth\";d:14.285714285714285;s:9:\"fp_r_prev\";i:3;s:9:\"fp_r_curr\";i:4;s:9:\"fp_r_gwth\";d:33.33333333333333;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:3;s:13:\"fp_total_curr\";i:4;s:13:\"fp_total_gwth\";d:33.33333333333333;s:15:\"sr_inq_spk_prev\";d:7.000000000000001;s:15:\"sr_inq_spk_curr\";d:8.695652173913043;s:15:\"sr_inq_spk_diff\";d:1.6956521739130421;s:14:\"sr_spk_fp_prev\";d:42.857142857142854;s:14:\"sr_spk_fp_curr\";d:50;s:14:\"sr_spk_fp_diff\";d:7.142857142857146;}i:1;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"XL7\";s:8:\"inq_prev\";i:30;s:8:\"inq_curr\";i:21;s:8:\"inq_gwth\";d:-30;s:8:\"spk_prev\";i:1;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";i:-100;s:9:\"fp_r_prev\";i:1;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";i:-100;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:1;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";i:-100;s:15:\"sr_inq_spk_prev\";d:3.3333333333333335;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";d:-3.3333333333333335;s:14:\"sr_spk_fp_prev\";i:100;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:-100;}i:2;O:8:\"stdClass\":22:{s:5:\"model\";s:5:\"FRONX\";s:8:\"inq_prev\";i:40;s:8:\"inq_curr\";i:23;s:8:\"inq_gwth\";d:-42.5;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:2;s:8:\"spk_gwth\";d:100;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";d:8.695652173913043;s:15:\"sr_inq_spk_diff\";d:8.695652173913043;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";i:0;s:14:\"sr_spk_fp_diff\";d:0;}i:3;O:8:\"stdClass\":22:{s:5:\"model\";s:14:\"ALL NEW ERTIGA\";s:8:\"inq_prev\";i:1;s:8:\"inq_curr\";i:1;s:8:\"inq_gwth\";i:0;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:4;O:8:\"stdClass\":22:{s:5:\"model\";s:3:\"APV\";s:8:\"inq_prev\";i:0;s:8:\"inq_curr\";i:1;s:8:\"inq_gwth\";d:100;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:1;s:8:\"spk_gwth\";d:100;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";d:0;s:15:\"sr_inq_spk_curr\";i:100;s:15:\"sr_inq_spk_diff\";d:100;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";i:0;s:14:\"sr_spk_fp_diff\";d:0;}i:5;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"S-PRESSO\";s:8:\"inq_prev\";i:7;s:8:\"inq_curr\";i:7;s:8:\"inq_gwth\";i:0;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:6;O:8:\"stdClass\":22:{s:5:\"model\";s:12:\"GRAND VITARA\";s:8:\"inq_prev\";i:1;s:8:\"inq_curr\";i:2;s:8:\"inq_gwth\";i:100;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";i:0;s:15:\"sr_inq_spk_curr\";i:0;s:15:\"sr_inq_spk_diff\";i:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:7;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 3D\";s:8:\"inq_prev\";i:0;s:8:\"inq_curr\";i:0;s:8:\"inq_gwth\";d:0;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";d:0;s:15:\"sr_inq_spk_curr\";d:0;s:15:\"sr_inq_spk_diff\";d:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}i:8;O:8:\"stdClass\":22:{s:5:\"model\";s:8:\"JIMNY 5D\";s:8:\"inq_prev\";i:0;s:8:\"inq_curr\";i:0;s:8:\"inq_gwth\";d:0;s:8:\"spk_prev\";i:0;s:8:\"spk_curr\";i:0;s:8:\"spk_gwth\";d:0;s:9:\"fp_r_prev\";i:0;s:9:\"fp_r_curr\";i:0;s:9:\"fp_r_gwth\";d:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:0;s:13:\"fp_total_curr\";i:0;s:13:\"fp_total_gwth\";d:0;s:15:\"sr_inq_spk_prev\";d:0;s:15:\"sr_inq_spk_curr\";d:0;s:15:\"sr_inq_spk_diff\";d:0;s:14:\"sr_spk_fp_prev\";d:0;s:14:\"sr_spk_fp_curr\";d:0;s:14:\"sr_spk_fp_diff\";d:0;}}s:12:\"summaryTotal\";O:8:\"stdClass\":21:{s:8:\"inq_prev\";i:179;s:8:\"inq_curr\";i:147;s:8:\"inq_gwth\";d:-17.877094972067038;s:8:\"spk_prev\";i:8;s:8:\"spk_curr\";i:11;s:8:\"spk_gwth\";d:37.5;s:9:\"fp_r_prev\";i:4;s:9:\"fp_r_curr\";i:4;s:9:\"fp_r_gwth\";i:0;s:9:\"fp_f_prev\";i:0;s:9:\"fp_f_curr\";i:0;s:9:\"fp_f_gwth\";d:0;s:13:\"fp_total_prev\";i:4;s:13:\"fp_total_curr\";i:4;s:13:\"fp_total_gwth\";i:0;s:15:\"sr_inq_spk_prev\";d:4.4692737430167595;s:15:\"sr_inq_spk_curr\";d:7.482993197278912;s:15:\"sr_inq_spk_diff\";d:3.0137194542621524;s:14:\"sr_spk_fp_prev\";d:50;s:14:\"sr_spk_fp_curr\";d:36.36363636363637;s:14:\"sr_spk_fp_diff\";d:-13.636363636363633;}}}s:8:\"fromDate\";s:10:\"2026-08-01\";s:6:\"toDate\";s:10:\"2026-08-31\";s:12:\"filter_bulan\";s:3:\"agu\";s:8:\"bulanMap\";a:12:{i:1;s:3:\"jan\";i:2;s:3:\"feb\";i:3;s:3:\"mar\";i:4;s:3:\"apr\";i:5;s:3:\"mei\";i:6;s:3:\"jun\";i:7;s:3:\"jul\";i:8;s:3:\"agu\";i:9;s:3:\"sep\";i:10;s:3:\"okt\";i:11;s:3:\"nov\";i:12;s:3:\"des\";}s:14:\"prevMonthLabel\";s:6:\"Jul-26\";s:14:\"currMonthLabel\";s:6:\"Agu-26\";}', 1787325408);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-dash_v2_pure_server_fix_ertiga_v15_2026_8_pusat', 'a:3:{s:15:\"all_branch_data\";a:5:{s:5:\"Ciawi\";a:4:{s:11:\"performance\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:12:{i:0;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:9:\"NEW CARRY\";s:3:\"agu\";i:16;s:6:\"act_do\";i:9;s:7:\"act_spk\";i:8;s:7:\"act_inq\";i:41;s:10:\"ytd_target\";i:120;s:10:\"ytd_act_do\";i:122;s:13:\"plan_rka_next\";i:4;}i:1;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:13:\"APV BLIND VAN\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:1;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:7;s:13:\"plan_rka_next\";i:0;}i:2;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:6:\"ERTIGA\";s:3:\"agu\";i:3;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:3;s:7:\"act_inq\";i:2;s:10:\"ytd_target\";i:13;s:10:\"ytd_act_do\";i:2;s:13:\"plan_rka_next\";i:2;}i:3;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:3:\"XL7\";s:3:\"agu\";i:8;s:6:\"act_do\";i:5;s:7:\"act_spk\";i:3;s:7:\"act_inq\";i:28;s:10:\"ytd_target\";i:89;s:10:\"ytd_act_do\";i:63;s:13:\"plan_rka_next\";i:4;}i:4;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:6:\"SPRESO\";s:3:\"agu\";i:1;s:6:\"act_do\";i:1;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:6;s:10:\"ytd_target\";i:11;s:10:\"ytd_act_do\";i:6;s:13:\"plan_rka_next\";i:0;}i:5;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:5:\"IGNIS\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:0;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:6;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:8:\"e-VITARA\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:0;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:7;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:12:\"GRAND VITARA\";s:3:\"agu\";i:1;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:3;s:10:\"ytd_target\";i:15;s:10:\"ytd_act_do\";i:6;s:13:\"plan_rka_next\";i:0;}i:8;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:8:\"JIMNY 3D\";s:3:\"agu\";i:2;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:1;s:10:\"ytd_target\";i:13;s:10:\"ytd_act_do\";i:4;s:13:\"plan_rka_next\";i:0;}i:9;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:8:\"JIMNY 5D\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:1;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:17;s:13:\"plan_rka_next\";i:0;}i:10;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:5:\"FRONX\";s:3:\"agu\";i:11;s:6:\"act_do\";i:2;s:7:\"act_spk\";i:1;s:7:\"act_inq\";i:16;s:10:\"ytd_target\";i:80;s:10:\"ytd_act_do\";i:37;s:13:\"plan_rka_next\";i:4;}i:11;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:6:\"BALENO\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:0;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:2;s:13:\"plan_rka_next\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:10:\"salesforce\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:5:{i:0;O:8:\"stdClass\":4:{s:7:\"grading\";s:9:\"FREELANCE\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:1;O:8:\"stdClass\":4:{s:7:\"grading\";s:7:\"TRAINEE\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:2;O:8:\"stdClass\":4:{s:7:\"grading\";s:6:\"SILVER\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:3;O:8:\"stdClass\":4:{s:7:\"grading\";s:4:\"GOLD\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:4;O:8:\"stdClass\":4:{s:7:\"grading\";s:8:\"PLATINUM\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:20:\"soi_performance_data\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:14:{i:0;O:8:\"stdClass\":5:{s:11:\"source_name\";s:20:\"Call In (dari Iklan)\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:5;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:1;}i:1;O:8:\"stdClass\":5:{s:11:\"source_name\";s:9:\"Canvasing\";s:7:\"trg_inq\";i:127;s:7:\"act_inq\";i:20;s:6:\"trg_do\";i:8;s:6:\"act_do\";i:1;}i:2;O:8:\"stdClass\":5:{s:11:\"source_name\";s:9:\"Data Base\";s:7:\"trg_inq\";i:222;s:7:\"act_inq\";i:26;s:6:\"trg_do\";i:15;s:6:\"act_do\";i:4;}i:3;O:8:\"stdClass\":5:{s:11:\"source_name\";s:18:\"Digital Hyperlocal\";s:7:\"trg_inq\";i:104;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:11;s:6:\"act_do\";i:0;}i:4;O:8:\"stdClass\":5:{s:11:\"source_name\";s:22:\"Digital Non Hyperlocal\";s:7:\"trg_inq\";i:59;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:5;s:6:\"act_do\";i:0;}i:5;O:8:\"stdClass\":5:{s:11:\"source_name\";s:10:\"Exhibition\";s:7:\"trg_inq\";i:55;s:7:\"act_inq\";i:5;s:6:\"trg_do\";i:9;s:6:\"act_do\";i:0;}i:6;O:8:\"stdClass\":5:{s:11:\"source_name\";s:13:\"Media Digital\";s:7:\"trg_inq\";i:104;s:7:\"act_inq\";i:23;s:6:\"trg_do\";i:11;s:6:\"act_do\";i:2;}i:7;O:8:\"stdClass\":5:{s:11:\"source_name\";s:16:\"Media Elektronik\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:8;O:8:\"stdClass\":5:{s:11:\"source_name\";s:8:\"Mediator\";s:7:\"trg_inq\";i:46;s:7:\"act_inq\";i:4;s:6:\"trg_do\";i:3;s:6:\"act_do\";i:2;}i:9;O:8:\"stdClass\":5:{s:11:\"source_name\";s:9:\"Referensi\";s:7:\"trg_inq\";i:99;s:7:\"act_inq\";i:10;s:6:\"trg_do\";i:8;s:6:\"act_do\";i:3;}i:10;O:8:\"stdClass\":5:{s:11:\"source_name\";s:18:\"Referensi Customer\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:10;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:3;}i:11;O:8:\"stdClass\":5:{s:11:\"source_name\";s:17:\"Showroom Activity\";s:7:\"trg_inq\";i:82;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:7;s:6:\"act_do\";i:0;}i:12;O:8:\"stdClass\":5:{s:11:\"source_name\";s:16:\"Showroom Walk-in\";s:7:\"trg_inq\";i:82;s:7:\"act_inq\";i:10;s:6:\"trg_do\";i:7;s:6:\"act_do\";i:1;}i:13;O:8:\"stdClass\":5:{s:11:\"source_name\";s:14:\"Website Dealer\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:6;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:19:\"leasing_performance\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:15:{i:0;O:8:\"stdClass\":7:{s:4:\"nama\";s:14:\"Suzuki Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:1;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"BCA Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:2;O:8:\"stdClass\":7:{s:4:\"nama\";s:7:\"KKB BCA\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:3;O:8:\"stdClass\":7:{s:4:\"nama\";s:21:\"Mandiri Tunas Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:4;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"KKB MANDIRI\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:5;O:8:\"stdClass\":7:{s:4:\"nama\";s:3:\"BSI\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:6;O:8:\"stdClass\":7:{s:4:\"nama\";s:21:\"Mandiri Utama Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:7;O:8:\"stdClass\":7:{s:4:\"nama\";s:17:\"Indomobil Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:8;O:8:\"stdClass\":7:{s:4:\"nama\";s:13:\"Adira Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:9;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"BNI Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:10;O:8:\"stdClass\":7:{s:4:\"nama\";s:7:\"MAYBANK\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:11;O:8:\"stdClass\":7:{s:4:\"nama\";s:22:\"Oto Multiartha Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:12;O:8:\"stdClass\":7:{s:4:\"nama\";s:13:\"NIAGA Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:13;O:8:\"stdClass\":7:{s:4:\"nama\";s:14:\"Clipan Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:14;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"Lain - Lain\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:7:\"Cianjur\";a:4:{s:11:\"performance\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:12:{i:0;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:9:\"NEW CARRY\";s:3:\"agu\";i:28;s:6:\"act_do\";i:10;s:7:\"act_spk\";i:25;s:7:\"act_inq\";i:335;s:10:\"ytd_target\";i:197;s:10:\"ytd_act_do\";i:183;s:13:\"plan_rka_next\";i:28;}i:1;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:13:\"APV BLIND VAN\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:5;s:10:\"ytd_target\";i:10;s:10:\"ytd_act_do\";i:14;s:13:\"plan_rka_next\";i:1;}i:2;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:6:\"ERTIGA\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:13;s:10:\"ytd_target\";i:1;s:10:\"ytd_act_do\";i:2;s:13:\"plan_rka_next\";i:0;}i:3;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:3:\"XL7\";s:3:\"agu\";i:6;s:6:\"act_do\";i:4;s:7:\"act_spk\";i:2;s:7:\"act_inq\";i:135;s:10:\"ytd_target\";i:46;s:10:\"ytd_act_do\";i:35;s:13:\"plan_rka_next\";i:3;}i:4;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:6:\"SPRESO\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:16;s:10:\"ytd_target\";i:2;s:10:\"ytd_act_do\";i:3;s:13:\"plan_rka_next\";i:0;}i:5;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:5:\"IGNIS\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:0;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:6;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:8:\"e-VITARA\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:0;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:7;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:12:\"GRAND VITARA\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:6;s:10:\"ytd_target\";i:4;s:10:\"ytd_act_do\";i:1;s:13:\"plan_rka_next\";i:0;}i:8;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:8:\"JIMNY 3D\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:1;s:10:\"ytd_target\";i:5;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:9;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:8:\"JIMNY 5D\";s:3:\"agu\";i:0;s:6:\"act_do\";i:2;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:6;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:3;s:13:\"plan_rka_next\";i:0;}i:10;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:5:\"FRONX\";s:3:\"agu\";i:6;s:6:\"act_do\";i:1;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:102;s:10:\"ytd_target\";i:47;s:10:\"ytd_act_do\";i:16;s:13:\"plan_rka_next\";i:6;}i:11;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:6:\"BALENO\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:0;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:10:\"salesforce\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:5:{i:0;O:8:\"stdClass\":4:{s:7:\"grading\";s:9:\"FREELANCE\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:1;O:8:\"stdClass\":4:{s:7:\"grading\";s:7:\"TRAINEE\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:2;O:8:\"stdClass\":4:{s:7:\"grading\";s:6:\"SILVER\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:3;O:8:\"stdClass\":4:{s:7:\"grading\";s:4:\"GOLD\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:4;O:8:\"stdClass\":4:{s:7:\"grading\";s:8:\"PLATINUM\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:20:\"soi_performance_data\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:14:{i:0;O:8:\"stdClass\":5:{s:11:\"source_name\";s:20:\"Call In (dari Iklan)\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:1;O:8:\"stdClass\":5:{s:11:\"source_name\";s:9:\"Canvasing\";s:7:\"trg_inq\";i:346;s:7:\"act_inq\";i:360;s:6:\"trg_do\";i:6;s:6:\"act_do\";i:0;}i:2;O:8:\"stdClass\":5:{s:11:\"source_name\";s:9:\"Data Base\";s:7:\"trg_inq\";i:347;s:7:\"act_inq\";i:133;s:6:\"trg_do\";i:18;s:6:\"act_do\";i:3;}i:3;O:8:\"stdClass\":5:{s:11:\"source_name\";s:18:\"Digital Hyperlocal\";s:7:\"trg_inq\";i:69;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:2;s:6:\"act_do\";i:0;}i:4;O:8:\"stdClass\":5:{s:11:\"source_name\";s:22:\"Digital Non Hyperlocal\";s:7:\"trg_inq\";i:69;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:2;s:6:\"act_do\";i:0;}i:5;O:8:\"stdClass\":5:{s:11:\"source_name\";s:10:\"Exhibition\";s:7:\"trg_inq\";i:98;s:7:\"act_inq\";i:45;s:6:\"trg_do\";i:4;s:6:\"act_do\";i:4;}i:6;O:8:\"stdClass\":5:{s:11:\"source_name\";s:13:\"Media Digital\";s:7:\"trg_inq\";i:69;s:7:\"act_inq\";i:32;s:6:\"trg_do\";i:2;s:6:\"act_do\";i:2;}i:7;O:8:\"stdClass\":5:{s:11:\"source_name\";s:16:\"Media Elektronik\";s:7:\"trg_inq\";i:31;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:8;O:8:\"stdClass\":5:{s:11:\"source_name\";s:8:\"Mediator\";s:7:\"trg_inq\";i:87;s:7:\"act_inq\";i:4;s:6:\"trg_do\";i:6;s:6:\"act_do\";i:1;}i:9;O:8:\"stdClass\":5:{s:11:\"source_name\";s:9:\"Referensi\";s:7:\"trg_inq\";i:118;s:7:\"act_inq\";i:33;s:6:\"trg_do\";i:8;s:6:\"act_do\";i:2;}i:10;O:8:\"stdClass\":5:{s:11:\"source_name\";s:18:\"Referensi Customer\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:33;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:2;}i:11;O:8:\"stdClass\":5:{s:11:\"source_name\";s:17:\"Showroom Activity\";s:7:\"trg_inq\";i:55;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:3;s:6:\"act_do\";i:0;}i:12;O:8:\"stdClass\":5:{s:11:\"source_name\";s:16:\"Showroom Walk-in\";s:7:\"trg_inq\";i:55;s:7:\"act_inq\";i:13;s:6:\"trg_do\";i:3;s:6:\"act_do\";i:1;}i:13;O:8:\"stdClass\":5:{s:11:\"source_name\";s:14:\"Website Dealer\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:12;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:2;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:19:\"leasing_performance\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:15:{i:0;O:8:\"stdClass\":7:{s:4:\"nama\";s:14:\"Suzuki Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:1;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"BCA Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:2;O:8:\"stdClass\":7:{s:4:\"nama\";s:7:\"KKB BCA\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:3;O:8:\"stdClass\":7:{s:4:\"nama\";s:21:\"Mandiri Tunas Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:4;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"KKB MANDIRI\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:5;O:8:\"stdClass\":7:{s:4:\"nama\";s:3:\"BSI\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:6;O:8:\"stdClass\":7:{s:4:\"nama\";s:21:\"Mandiri Utama Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:7;O:8:\"stdClass\":7:{s:4:\"nama\";s:17:\"Indomobil Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:8;O:8:\"stdClass\":7:{s:4:\"nama\";s:13:\"Adira Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:9;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"BNI Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:10;O:8:\"stdClass\":7:{s:4:\"nama\";s:7:\"MAYBANK\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:11;O:8:\"stdClass\":7:{s:4:\"nama\";s:22:\"Oto Multiartha Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:12;O:8:\"stdClass\":7:{s:4:\"nama\";s:13:\"NIAGA Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:13;O:8:\"stdClass\":7:{s:4:\"nama\";s:14:\"Clipan Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:14;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"Lain - Lain\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:6:\"Cinere\";a:4:{s:11:\"performance\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:12:{i:0;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:9:\"NEW CARRY\";s:3:\"agu\";i:1;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:1;s:7:\"act_inq\";i:47;s:10:\"ytd_target\";i:30;s:10:\"ytd_act_do\";i:27;s:13:\"plan_rka_next\";i:0;}i:1;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:13:\"APV BLIND VAN\";s:3:\"agu\";i:2;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:1;s:7:\"act_inq\";i:5;s:10:\"ytd_target\";i:2;s:10:\"ytd_act_do\";i:6;s:13:\"plan_rka_next\";i:0;}i:2;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:6:\"ERTIGA\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:15;s:10:\"ytd_target\";i:1;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:3;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:3:\"XL7\";s:3:\"agu\";i:2;s:6:\"act_do\";i:3;s:7:\"act_spk\";i:2;s:7:\"act_inq\";i:58;s:10:\"ytd_target\";i:48;s:10:\"ytd_act_do\";i:46;s:13:\"plan_rka_next\";i:0;}i:4;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:6:\"SPRESO\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:24;s:10:\"ytd_target\";i:5;s:10:\"ytd_act_do\";i:5;s:13:\"plan_rka_next\";i:0;}i:5;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:5:\"IGNIS\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:0;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:6;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:8:\"e-VITARA\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:0;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:7;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:12:\"GRAND VITARA\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:18;s:10:\"ytd_target\";i:5;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:8;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:8:\"JIMNY 3D\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:2;s:10:\"ytd_target\";i:1;s:10:\"ytd_act_do\";i:2;s:13:\"plan_rka_next\";i:0;}i:9;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:8:\"JIMNY 5D\";s:3:\"agu\";i:0;s:6:\"act_do\";i:1;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:6;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:4;s:13:\"plan_rka_next\";i:0;}i:10;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:5:\"FRONX\";s:3:\"agu\";i:1;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:39;s:10:\"ytd_target\";i:40;s:10:\"ytd_act_do\";i:13;s:13:\"plan_rka_next\";i:0;}i:11;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:6:\"BALENO\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:0;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:10:\"salesforce\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:5:{i:0;O:8:\"stdClass\":4:{s:7:\"grading\";s:9:\"FREELANCE\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:1;O:8:\"stdClass\":4:{s:7:\"grading\";s:7:\"TRAINEE\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:2;O:8:\"stdClass\":4:{s:7:\"grading\";s:6:\"SILVER\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:3;O:8:\"stdClass\":4:{s:7:\"grading\";s:4:\"GOLD\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:4;O:8:\"stdClass\":4:{s:7:\"grading\";s:8:\"PLATINUM\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:20:\"soi_performance_data\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:14:{i:0;O:8:\"stdClass\":5:{s:11:\"source_name\";s:20:\"Call In (dari Iklan)\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:1;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:1;O:8:\"stdClass\":5:{s:11:\"source_name\";s:9:\"Canvasing\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:58;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:2;O:8:\"stdClass\":5:{s:11:\"source_name\";s:9:\"Data Base\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:85;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:1;}i:3;O:8:\"stdClass\":5:{s:11:\"source_name\";s:18:\"Digital Hyperlocal\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:4;O:8:\"stdClass\":5:{s:11:\"source_name\";s:22:\"Digital Non Hyperlocal\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:5;O:8:\"stdClass\":5:{s:11:\"source_name\";s:10:\"Exhibition\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:6;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:1;}i:6;O:8:\"stdClass\":5:{s:11:\"source_name\";s:13:\"Media Digital\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:18;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:7;O:8:\"stdClass\":5:{s:11:\"source_name\";s:16:\"Media Elektronik\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:8;O:8:\"stdClass\":5:{s:11:\"source_name\";s:8:\"Mediator\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:12;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:9;O:8:\"stdClass\":5:{s:11:\"source_name\";s:9:\"Referensi\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:25;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:1;}i:10;O:8:\"stdClass\":5:{s:11:\"source_name\";s:18:\"Referensi Customer\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:25;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:1;}i:11;O:8:\"stdClass\":5:{s:11:\"source_name\";s:17:\"Showroom Activity\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:12;O:8:\"stdClass\":5:{s:11:\"source_name\";s:16:\"Showroom Walk-in\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:2;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:13;O:8:\"stdClass\":5:{s:11:\"source_name\";s:14:\"Website Dealer\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:5;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:19:\"leasing_performance\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:15:{i:0;O:8:\"stdClass\":7:{s:4:\"nama\";s:14:\"Suzuki Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:1;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"BCA Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:2;O:8:\"stdClass\":7:{s:4:\"nama\";s:7:\"KKB BCA\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:3;O:8:\"stdClass\":7:{s:4:\"nama\";s:21:\"Mandiri Tunas Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:4;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"KKB MANDIRI\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:5;O:8:\"stdClass\":7:{s:4:\"nama\";s:3:\"BSI\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:6;O:8:\"stdClass\":7:{s:4:\"nama\";s:21:\"Mandiri Utama Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:7;O:8:\"stdClass\":7:{s:4:\"nama\";s:17:\"Indomobil Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:8;O:8:\"stdClass\":7:{s:4:\"nama\";s:13:\"Adira Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:9;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"BNI Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:10;O:8:\"stdClass\":7:{s:4:\"nama\";s:7:\"MAYBANK\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:11;O:8:\"stdClass\":7:{s:4:\"nama\";s:22:\"Oto Multiartha Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:12;O:8:\"stdClass\":7:{s:4:\"nama\";s:13:\"NIAGA Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:13;O:8:\"stdClass\":7:{s:4:\"nama\";s:14:\"Clipan Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:14;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"Lain - Lain\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:8:\"Jatiasih\";a:4:{s:11:\"performance\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:12:{i:0;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:9:\"NEW CARRY\";s:3:\"agu\";i:8;s:6:\"act_do\";i:2;s:7:\"act_spk\";i:3;s:7:\"act_inq\";i:251;s:10:\"ytd_target\";i:55;s:10:\"ytd_act_do\";i:30;s:13:\"plan_rka_next\";i:2;}i:1;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:13:\"APV BLIND VAN\";s:3:\"agu\";i:1;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:15;s:10:\"ytd_target\";i:12;s:10:\"ytd_act_do\";i:4;s:13:\"plan_rka_next\";i:0;}i:2;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:6:\"ERTIGA\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:2;s:7:\"act_inq\";i:22;s:10:\"ytd_target\";i:8;s:10:\"ytd_act_do\";i:1;s:13:\"plan_rka_next\";i:0;}i:3;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:3:\"XL7\";s:3:\"agu\";i:9;s:6:\"act_do\";i:2;s:7:\"act_spk\";i:2;s:7:\"act_inq\";i:184;s:10:\"ytd_target\";i:100;s:10:\"ytd_act_do\";i:45;s:13:\"plan_rka_next\";i:5;}i:4;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:6:\"SPRESO\";s:3:\"agu\";i:1;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:29;s:10:\"ytd_target\";i:15;s:10:\"ytd_act_do\";i:4;s:13:\"plan_rka_next\";i:1;}i:5;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:5:\"IGNIS\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:0;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:6;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:8:\"e-VITARA\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:0;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:7;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:12:\"GRAND VITARA\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:33;s:10:\"ytd_target\";i:14;s:10:\"ytd_act_do\";i:3;s:13:\"plan_rka_next\";i:0;}i:8;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:8:\"JIMNY 3D\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:1;s:10:\"ytd_target\";i:5;s:10:\"ytd_act_do\";i:2;s:13:\"plan_rka_next\";i:0;}i:9;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:8:\"JIMNY 5D\";s:3:\"agu\";i:0;s:6:\"act_do\";i:1;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:17;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:6;s:13:\"plan_rka_next\";i:0;}i:10;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:5:\"FRONX\";s:3:\"agu\";i:6;s:6:\"act_do\";i:2;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:165;s:10:\"ytd_target\";i:70;s:10:\"ytd_act_do\";i:25;s:13:\"plan_rka_next\";i:3;}i:11;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:6:\"BALENO\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:0;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:10:\"salesforce\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:5:{i:0;O:8:\"stdClass\":4:{s:7:\"grading\";s:9:\"FREELANCE\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:1;O:8:\"stdClass\":4:{s:7:\"grading\";s:7:\"TRAINEE\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:2;O:8:\"stdClass\":4:{s:7:\"grading\";s:6:\"SILVER\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:3;O:8:\"stdClass\":4:{s:7:\"grading\";s:4:\"GOLD\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:4;O:8:\"stdClass\":4:{s:7:\"grading\";s:8:\"PLATINUM\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:20:\"soi_performance_data\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:14:{i:0;O:8:\"stdClass\":5:{s:11:\"source_name\";s:20:\"Call In (dari Iklan)\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:13;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:1;O:8:\"stdClass\":5:{s:11:\"source_name\";s:9:\"Canvasing\";s:7:\"trg_inq\";i:339;s:7:\"act_inq\";i:269;s:6:\"trg_do\";i:4;s:6:\"act_do\";i:0;}i:2;O:8:\"stdClass\":5:{s:11:\"source_name\";s:9:\"Data Base\";s:7:\"trg_inq\";i:255;s:7:\"act_inq\";i:167;s:6:\"trg_do\";i:20;s:6:\"act_do\";i:1;}i:3;O:8:\"stdClass\":5:{s:11:\"source_name\";s:18:\"Digital Hyperlocal\";s:7:\"trg_inq\";i:243;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:7;s:6:\"act_do\";i:0;}i:4;O:8:\"stdClass\":5:{s:11:\"source_name\";s:22:\"Digital Non Hyperlocal\";s:7:\"trg_inq\";i:243;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:6;s:6:\"act_do\";i:0;}i:5;O:8:\"stdClass\":5:{s:11:\"source_name\";s:10:\"Exhibition\";s:7:\"trg_inq\";i:283;s:7:\"act_inq\";i:52;s:6:\"trg_do\";i:9;s:6:\"act_do\";i:3;}i:6;O:8:\"stdClass\":5:{s:11:\"source_name\";s:13:\"Media Digital\";s:7:\"trg_inq\";i:243;s:7:\"act_inq\";i:92;s:6:\"trg_do\";i:7;s:6:\"act_do\";i:1;}i:7;O:8:\"stdClass\":5:{s:11:\"source_name\";s:16:\"Media Elektronik\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:8;O:8:\"stdClass\":5:{s:11:\"source_name\";s:8:\"Mediator\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:39;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:1;}i:9;O:8:\"stdClass\":5:{s:11:\"source_name\";s:9:\"Referensi\";s:7:\"trg_inq\";i:115;s:7:\"act_inq\";i:79;s:6:\"trg_do\";i:9;s:6:\"act_do\";i:0;}i:10;O:8:\"stdClass\":5:{s:11:\"source_name\";s:18:\"Referensi Customer\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:79;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:11;O:8:\"stdClass\":5:{s:11:\"source_name\";s:17:\"Showroom Activity\";s:7:\"trg_inq\";i:103;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:13;s:6:\"act_do\";i:0;}i:12;O:8:\"stdClass\":5:{s:11:\"source_name\";s:16:\"Showroom Walk-in\";s:7:\"trg_inq\";i:103;s:7:\"act_inq\";i:7;s:6:\"trg_do\";i:13;s:6:\"act_do\";i:1;}i:13;O:8:\"stdClass\":5:{s:11:\"source_name\";s:14:\"Website Dealer\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:3;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:19:\"leasing_performance\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:15:{i:0;O:8:\"stdClass\":7:{s:4:\"nama\";s:14:\"Suzuki Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:1;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"BCA Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:2;O:8:\"stdClass\":7:{s:4:\"nama\";s:7:\"KKB BCA\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:3;O:8:\"stdClass\":7:{s:4:\"nama\";s:21:\"Mandiri Tunas Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:4;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"KKB MANDIRI\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:5;O:8:\"stdClass\":7:{s:4:\"nama\";s:3:\"BSI\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:6;O:8:\"stdClass\":7:{s:4:\"nama\";s:21:\"Mandiri Utama Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:7;O:8:\"stdClass\":7:{s:4:\"nama\";s:17:\"Indomobil Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:8;O:8:\"stdClass\":7:{s:4:\"nama\";s:13:\"Adira Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:9;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"BNI Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:10;O:8:\"stdClass\":7:{s:4:\"nama\";s:7:\"MAYBANK\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:11;O:8:\"stdClass\":7:{s:4:\"nama\";s:22:\"Oto Multiartha Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:12;O:8:\"stdClass\":7:{s:4:\"nama\";s:13:\"NIAGA Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:13;O:8:\"stdClass\":7:{s:4:\"nama\";s:14:\"Clipan Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:14;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"Lain - Lain\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:7:\"Cipanas\";a:4:{s:11:\"performance\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:12:{i:0;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:9:\"NEW CARRY\";s:3:\"agu\";i:5;s:6:\"act_do\";i:4;s:7:\"act_spk\";i:9;s:7:\"act_inq\";i:92;s:10:\"ytd_target\";i:12;s:10:\"ytd_act_do\";i:12;s:13:\"plan_rka_next\";i:5;}i:1;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:13:\"APV BLIND VAN\";s:3:\"agu\";i:1;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:1;s:10:\"ytd_target\";i:1;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:2;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:6:\"ERTIGA\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:1;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:3;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:3:\"XL7\";s:3:\"agu\";i:1;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:21;s:10:\"ytd_target\";i:3;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:2;}i:4;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:6:\"SPRESO\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:7;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:5;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:5:\"IGNIS\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:0;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:6;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:8:\"e-VITARA\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:0;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:7;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:12:\"GRAND VITARA\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:2;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:8;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:8:\"JIMNY 3D\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:0;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}i:9;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:8:\"JIMNY 5D\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:0;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:1;s:13:\"plan_rka_next\";i:0;}i:10;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:5:\"FRONX\";s:3:\"agu\";i:1;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:23;s:10:\"ytd_target\";i:3;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:1;}i:11;O:8:\"stdClass\":8:{s:10:\"mobil_type\";s:6:\"BALENO\";s:3:\"agu\";i:0;s:6:\"act_do\";i:0;s:7:\"act_spk\";i:0;s:7:\"act_inq\";i:0;s:10:\"ytd_target\";i:0;s:10:\"ytd_act_do\";i:0;s:13:\"plan_rka_next\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:10:\"salesforce\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:5:{i:0;O:8:\"stdClass\":4:{s:7:\"grading\";s:9:\"FREELANCE\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:1;O:8:\"stdClass\":4:{s:7:\"grading\";s:7:\"TRAINEE\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:2;O:8:\"stdClass\":4:{s:7:\"grading\";s:6:\"SILVER\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:3;O:8:\"stdClass\":4:{s:7:\"grading\";s:4:\"GOLD\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}i:4;O:8:\"stdClass\":4:{s:7:\"grading\";s:8:\"PLATINUM\";s:6:\"trg_sf\";i:0;s:6:\"act_sf\";i:0;s:6:\"act_do\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:20:\"soi_performance_data\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:14:{i:0;O:8:\"stdClass\":5:{s:11:\"source_name\";s:20:\"Call In (dari Iklan)\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:1;O:8:\"stdClass\":5:{s:11:\"source_name\";s:9:\"Canvasing\";s:7:\"trg_inq\";i:67;s:7:\"act_inq\";i:97;s:6:\"trg_do\";i:3;s:6:\"act_do\";i:1;}i:2;O:8:\"stdClass\":5:{s:11:\"source_name\";s:9:\"Data Base\";s:7:\"trg_inq\";i:52;s:7:\"act_inq\";i:20;s:6:\"trg_do\";i:3;s:6:\"act_do\";i:1;}i:3;O:8:\"stdClass\":5:{s:11:\"source_name\";s:18:\"Digital Hyperlocal\";s:7:\"trg_inq\";i:8;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:2;s:6:\"act_do\";i:0;}i:4;O:8:\"stdClass\":5:{s:11:\"source_name\";s:22:\"Digital Non Hyperlocal\";s:7:\"trg_inq\";i:8;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:2;s:6:\"act_do\";i:0;}i:5;O:8:\"stdClass\":5:{s:11:\"source_name\";s:10:\"Exhibition\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:6;O:8:\"stdClass\":5:{s:11:\"source_name\";s:13:\"Media Digital\";s:7:\"trg_inq\";i:8;s:7:\"act_inq\";i:24;s:6:\"trg_do\";i:2;s:6:\"act_do\";i:1;}i:7;O:8:\"stdClass\":5:{s:11:\"source_name\";s:16:\"Media Elektronik\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:8;O:8:\"stdClass\":5:{s:11:\"source_name\";s:8:\"Mediator\";s:7:\"trg_inq\";i:10;s:7:\"act_inq\";i:5;s:6:\"trg_do\";i:1;s:6:\"act_do\";i:0;}i:9;O:8:\"stdClass\":5:{s:11:\"source_name\";s:9:\"Referensi\";s:7:\"trg_inq\";i:8;s:7:\"act_inq\";i:1;s:6:\"trg_do\";i:1;s:6:\"act_do\";i:0;}i:10;O:8:\"stdClass\":5:{s:11:\"source_name\";s:18:\"Referensi Customer\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:1;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}i:11;O:8:\"stdClass\":5:{s:11:\"source_name\";s:17:\"Showroom Activity\";s:7:\"trg_inq\";i:6;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:2;s:6:\"act_do\";i:0;}i:12;O:8:\"stdClass\":5:{s:11:\"source_name\";s:16:\"Showroom Walk-in\";s:7:\"trg_inq\";i:6;s:7:\"act_inq\";i:7;s:6:\"trg_do\";i:2;s:6:\"act_do\";i:1;}i:13;O:8:\"stdClass\":5:{s:11:\"source_name\";s:14:\"Website Dealer\";s:7:\"trg_inq\";i:0;s:7:\"act_inq\";i:0;s:6:\"trg_do\";i:0;s:6:\"act_do\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:19:\"leasing_performance\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:15:{i:0;O:8:\"stdClass\":7:{s:4:\"nama\";s:14:\"Suzuki Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:1;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"BCA Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:2;O:8:\"stdClass\":7:{s:4:\"nama\";s:7:\"KKB BCA\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:3;O:8:\"stdClass\":7:{s:4:\"nama\";s:21:\"Mandiri Tunas Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:4;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"KKB MANDIRI\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:5;O:8:\"stdClass\":7:{s:4:\"nama\";s:3:\"BSI\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:6;O:8:\"stdClass\":7:{s:4:\"nama\";s:21:\"Mandiri Utama Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:7;O:8:\"stdClass\":7:{s:4:\"nama\";s:17:\"Indomobil Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:8;O:8:\"stdClass\":7:{s:4:\"nama\";s:13:\"Adira Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:9;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"BNI Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:10;O:8:\"stdClass\":7:{s:4:\"nama\";s:7:\"MAYBANK\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:11;O:8:\"stdClass\":7:{s:4:\"nama\";s:22:\"Oto Multiartha Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:12;O:8:\"stdClass\":7:{s:4:\"nama\";s:13:\"NIAGA Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:13;O:8:\"stdClass\":7:{s:4:\"nama\";s:14:\"Clipan Finance\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}i:14;O:8:\"stdClass\":7:{s:4:\"nama\";s:11:\"Lain - Lain\";s:2:\"po\";i:0;s:6:\"reject\";i:0;s:5:\"aplin\";i:0;s:6:\"ytd_po\";i:0;s:10:\"ytd_reject\";i:0;s:9:\"ytd_aplin\";i:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}}s:5:\"bulan\";s:3:\"agu\";s:10:\"bulan_list\";a:12:{i:1;s:3:\"jan\";i:2;s:3:\"feb\";i:3;s:3:\"mar\";i:4;s:3:\"apr\";i:5;s:3:\"mei\";i:6;s:3:\"jun\";i:7;s:3:\"jul\";i:8;s:3:\"agu\";i:9;s:3:\"sep\";i:10;s:3:\"okt\";i:11;s:3:\"nov\";i:12;s:3:\"des\";}}', 1787302462);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dashboards`
--

CREATE TABLE `dashboards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cabang` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `trg_1` int(11) NOT NULL DEFAULT 0,
  `act_1` int(11) NOT NULL DEFAULT 0,
  `act_2` int(11) NOT NULL DEFAULT 0,
  `act_3` int(11) NOT NULL DEFAULT 0,
  `bulan` varchar(255) NOT NULL DEFAULT 'March 2026',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `evaluasi_wiraniaga`
--

CREATE TABLE `evaluasi_wiraniaga` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_sales_head` varchar(255) NOT NULL,
  `nama_sales` varchar(255) NOT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `tanggal_evaluasi` date DEFAULT NULL,
  `grading` varchar(255) DEFAULT NULL,
  `jan` int(11) NOT NULL DEFAULT 0,
  `feb` int(11) NOT NULL DEFAULT 0,
  `mar` int(11) NOT NULL DEFAULT 0,
  `apr` int(11) NOT NULL DEFAULT 0,
  `mei` int(11) NOT NULL DEFAULT 0,
  `jun` int(11) NOT NULL DEFAULT 0,
  `jul` int(11) NOT NULL DEFAULT 0,
  `agu` int(11) NOT NULL DEFAULT 0,
  `sep` int(11) NOT NULL DEFAULT 0,
  `okt` int(11) NOT NULL DEFAULT 0,
  `nov` int(11) NOT NULL DEFAULT 0,
  `des` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `evaluasi` text DEFAULT NULL,
  `tanggal_keluar` date DEFAULT NULL,
  `cabang` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gudangs`
--

CREATE TABLE `gudangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gudangs`
--

INSERT INTO `gudangs` (`id`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'CIAWI', '2026-06-29 10:21:18', '2026-07-02 13:07:21', NULL),
(2, 'CIANJUR', '2026-06-29 10:21:18', '2026-07-02 13:07:16', NULL),
(3, 'CINERE', '2026-06-29 10:21:18', '2026-07-02 13:07:30', NULL),
(4, 'JATIASIH', '2026-06-29 10:21:18', '2026-07-02 13:07:34', NULL),
(5, 'CIKARANG', '2026-06-29 10:21:18', '2026-07-02 13:07:25', NULL),
(6, 'TAMBUN', '2026-06-29 10:21:18', '2026-07-02 13:07:39', NULL),
(7, 'CIPANAS', '2026-07-02 13:04:40', '2026-07-02 13:04:40', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `in_units`
--

CREATE TABLE `in_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_driver` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `warna` varchar(255) DEFAULT NULL,
  `no_rangka` varchar(255) DEFAULT NULL,
  `no_mesin` varchar(255) DEFAULT NULL,
  `lokasi_pengambilan` varchar(255) DEFAULT NULL,
  `cabang_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cekits` varchar(255) DEFAULT NULL,
  `jam_kedatangan` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `in_units`
--

INSERT INTO `in_units` (`id`, `nama_driver`, `tanggal`, `type`, `warna`, `no_rangka`, `no_mesin`, `lokasi_pengambilan`, `cabang_id`, `cekits`, `jam_kedatangan`, `created_at`, `updated_at`) VALUES
(10, 'IDRIS', '2026-07-01', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '291816', '1773645', 'TAMBUN', 1, 'V', NULL, '2026-07-02 08:37:27', '2026-07-08 15:24:14'),
(11, 'IDRIS', '2026-07-01', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '290181', '1771241', 'TAMBUN', 1, 'V', NULL, '2026-07-02 08:38:38', '2026-07-08 15:24:07'),
(12, 'OMAN', '2026-07-01', 'NEW CARRY 05-PU FD AC PS 2026', 'REAL BLACK', '291618', '1773458', 'TAMBUN', 1, 'V', NULL, '2026-07-02 08:39:51', '2026-07-08 15:23:54'),
(13, 'OMAN', '2026-07-01', 'NEW CARRY 05-PU FD AC PS 2026', 'REAL BLACK', '291593', '1773139', 'TAMBUN', 1, 'V', NULL, '2026-07-02 10:17:06', '2026-07-08 15:24:00'),
(14, 'ASEP', '2026-07-01', 'NEW CARRY 05-PU FD AC PS 2026', 'REAL BLACK', '290627', '1772039', 'CINERE', 1, 'V', NULL, '2026-07-02 10:18:56', '2026-07-08 15:40:07'),
(15, 'WAHYU', '2026-07-01', 'NEW CARRY 05-PU WD 2026', 'REAL BLACK', '291377', '1773011', 'TAMBUN', 4, 'V', '17:25:00', '2026-07-02 10:19:45', '2026-07-09 11:44:05'),
(16, 'ASEP', '2026-07-02', 'FRONX HYBRID GX AT', 'MET.MAGMA GRAY 2', '112971', '1093794', 'CIKARANG', 4, 'V', '10:15:00', '2026-07-02 10:41:45', '2026-07-09 11:45:17'),
(17, 'ASEP', '2026-07-02', 'NEW XL-7 03 ALPHA MT HYBRID 2TONE 2026', 'DUMMY.SAVANA IVORY 2', '103340', '1768805', 'CIKARANG', 3, 'V', '18:11:00', '2026-07-02 10:44:02', '2026-07-10 09:27:27'),
(18, 'OMAN', '2026-07-02', 'AMBIL DAN ANTAR CAT INFO PA JOHNY', 'CIAWI-PANCA JAYA-DCM -CIAWI', NULL, NULL, 'CIAWI', 2, NULL, NULL, '2026-07-02 10:50:25', '2026-07-02 10:50:25'),
(19, 'IDRIS', '2026-07-02', 'KIR UNIT CIAWI', '-', NULL, NULL, 'CIAWI', 4, 'V', NULL, '2026-07-02 10:51:16', '2026-08-02 15:22:19'),
(20, 'ASEP', '2026-07-01', 'S-PRESSO 02 AT-2026', 'WHITE', '600243', '975299', 'TAMBUN', 3, 'V', NULL, '2026-07-02 10:52:17', '2026-07-08 15:40:22'),
(21, 'OMAN', '2026-07-03', 'S-PRESSO 02 AT-2026', 'WHITE', '600195', '975145', 'TAMBUN', 4, 'V', '11:15:00', '2026-07-03 11:14:43', '2026-07-09 11:38:31'),
(22, 'OMAN', '2026-07-03', 'APV FE GE PS DEL.VAN MT 2026 (BLINDVAN)', 'WHITE', '400755', '454727', 'TAMBUN', 1, 'V', NULL, '2026-07-03 11:15:41', '2026-07-08 15:41:13'),
(23, 'OMAN', '2026-07-03', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '291635', '1773451', 'TAMBUN', 1, 'V', NULL, '2026-07-03 11:16:48', '2026-07-09 11:24:32'),
(24, 'IDRIS', '2026-07-03', 'APV FE GE PS DEL.VAN MT 2026 (BLINDVAN)', 'WHITE', '400671', '454727', 'TAMBUN', 1, 'V', NULL, '2026-07-03 11:18:40', '2026-07-09 11:24:47'),
(25, 'IDRIS', '2026-07-03', 'NEW CARRY 05-PU FD AC PS 2026', 'WHITE', '291581', '1773555', 'TAMBUN', 1, 'V', NULL, '2026-07-03 11:19:43', '2026-07-09 11:24:58'),
(26, 'IDRIS', '2026-07-03', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '290160', '1771200', 'TAMBUN', 1, 'V', NULL, '2026-07-03 11:20:32', '2026-07-09 11:25:10'),
(27, 'OMAN', '2026-07-06', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '291630', '1773454', 'TAMBUN', 1, 'V', NULL, '2026-07-04 14:18:04', '2026-07-09 11:25:36'),
(28, 'OMAN', '2026-07-06', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '291626', '1773435', 'TAMBUN', 1, 'V', NULL, '2026-07-04 14:18:39', '2026-07-09 11:25:56'),
(29, 'OMAN', '2026-07-06', 'NEW CARRY 05-PU FD AC PS 2026', 'WHITE', '291645', '1773533', 'TAMBUN', 1, 'V', NULL, '2026-07-04 14:19:20', '2026-07-09 11:26:04'),
(30, 'OMAN', '2026-07-07', 'NEW CARRY 05-PU FD 2026', 'WHITE', '291850', '1773641', 'TAMBUN', 1, 'V', NULL, '2026-07-06 14:19:49', '2026-07-09 11:26:21'),
(31, 'OMAN', '2026-07-07', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '291644', '1773534', 'TAMBUN', 1, 'V', NULL, '2026-07-06 14:20:24', '2026-07-09 11:26:12'),
(32, 'OMAN', '2026-07-07', 'FRONX GL MT 2025', 'MET.MAGMA GRAY 2', '102343', '1703946', 'TAMBUN', 4, 'V', '10:15:00', '2026-07-06 14:21:17', '2026-07-09 11:39:40'),
(33, 'IDRIS', '2026-07-07', 'S-PRESSO 02 AT-2026', 'GRANITE GRAY', '595602', '960095', 'TAMBUN', 4, 'V', '11:00:00', '2026-07-06 14:22:22', '2026-07-09 11:41:03'),
(34, 'IDRIS', '2026-07-07', 'NEW CARRY 05-PU FD 2026', 'WHITE', '291745', '1773431', 'TAMBUN', 1, 'V', NULL, '2026-07-06 14:23:00', '2026-07-09 11:26:30'),
(35, 'IDRIS', '2026-07-07', 'NEW CARRY 05-PU FD 2026', 'WHITE', '291795', '1773685', 'TAMBUN', 1, 'V', NULL, '2026-07-06 14:23:28', '2026-07-09 11:26:43'),
(36, 'ASEP', '2026-07-07', 'S-PRESSO 02 AT-2026', 'WHITE', '601551', '978921', 'TAMBUN', 3, 'V', '17:17:00', '2026-07-06 14:24:14', '2026-07-10 09:28:51'),
(37, 'ASEP', '2026-07-07', 'NEW CARRY 05-PU FD AC PS 2026', 'WHITE', '291243', '1772945', 'TAMBUN', 3, 'V', '22:25:00', '2026-07-06 14:24:54', '2026-07-10 09:26:03'),
(38, 'ASEP', '2026-07-08', 'FRONX HYBRID SGX 2TONE AT 2025', 'ICE GRAYISH BLUE', '112439', '1091575', 'CIKARANG', 4, 'V', '14:15:00', '2026-07-07 14:22:07', '2026-07-09 11:42:12'),
(39, 'ASEP', '2026-07-08', 'NEW XL-7	03 KURO EDITION AT HYBRID 2TONE 2026', 'DUMMY.SAVANA IVORY 2', '103078', '1767000', 'CIKARANG', 3, 'V', '22:10:00', '2026-07-07 14:23:00', '2026-07-10 09:18:31'),
(40, 'IDRIS', '2026-07-08', 'NEW CARRY 05-PU FD AC PS 2026', 'WHITE', '291876', '1773616', 'TAMBUN', 1, 'V', NULL, '2026-07-07 14:23:53', '2026-07-09 11:27:55'),
(41, 'IDRIS', '2026-07-08', 'NEW CARRY 05-PU FD AC PS 2026', 'REAL BLACK', '291417', '1773182', 'TAMBUN', 1, 'V', NULL, '2026-07-07 14:24:35', '2026-07-09 11:28:03'),
(42, 'OMAN', '2026-07-08', 'NEW CARRY 05-PU FD AC PS 2026', 'WHITE', '291812', '1773622', 'TAMBUN', 1, 'V', NULL, '2026-07-07 14:25:31', '2026-07-09 11:27:00'),
(43, 'OMAN', '2026-07-08', 'NEW CARRY 05-PU FD AC PS 2026', 'WHITE', '291818', '1773726', 'TAMBUN', 1, 'V', NULL, '2026-07-07 14:26:04', '2026-07-09 11:27:07'),
(44, 'OMAN', '2026-07-08', 'NEW CARRY 05-PU FD AC PS 2026', 'WHITE', '290951', '1772446', 'TAMBUN', 1, 'V', NULL, '2026-07-07 14:26:56', '2026-07-09 11:27:46'),
(45, 'ASEP', '2026-07-09', 'FRONX HYBRID SGX AT', 'SAVANA IVORY', '109346', '1088979', 'CIKARANG', 4, 'V', '17:15:00', '2026-07-08 15:11:44', '2026-07-10 08:50:14'),
(46, 'ASEP', '2026-07-09', 'FRONX HYBRID GX AT', 'COOL BLACK MET', '112607', '1094859', 'CIKARANG', 3, 'V', '16:53:00', '2026-07-08 15:12:26', '2026-07-13 08:34:30'),
(47, 'OMAN', '2026-07-09', 'NEW XL-7 03 KURO EDITION AT HYBRID 2TONE 2026', 'DUMMY.SAVANA IVORY 2', '103076', '1766603', 'CIKARANG', 1, 'V', NULL, '2026-07-08 15:16:10', '2026-07-11 10:12:18'),
(48, 'OMAN', '2026-07-09', 'FRONX HYBRID SGX 2TONE AT 2025', 'ICE GRAYISH BLUE', '112561', '1094843', 'CIKARANG', 1, 'V', NULL, '2026-07-08 15:17:46', '2026-07-11 10:12:26'),
(49, 'IDRIS', '2026-07-09', 'NEW CARRY 05-PU FD AC PS 2026', 'GRAPHITE GREY METALLIC', '292953', '1775853', 'TAMBUN', 1, 'V', NULL, '2026-07-08 15:21:00', '2026-07-11 10:12:41'),
(50, 'IDRIS', '2026-07-09', 'NEW CARRY 05-PU FD AC PS 2026', 'SILKY SILVER METALIC', '292686', '1775211', 'TAMBUN', 1, 'V', NULL, '2026-07-08 15:22:24', '2026-07-11 10:12:50'),
(51, 'IDRIS', '2026-07-09', 'NEW CARRY 05-PU FD AC PS 2026', 'REAL BLACK', '293079', '1775781', 'TAMBUN', 1, 'V', NULL, '2026-07-08 15:23:11', '2026-07-11 10:12:57'),
(53, 'IDRIS', '2026-07-10', 'NEW CARRY 05-PU FD AC PS 2026', 'WHITE', '292895', '1775279', 'TAMBUN', 1, 'V', NULL, '2026-07-09 14:31:20', '2026-07-11 10:14:17'),
(54, 'IDRIS', '2026-07-10', 'NEW CARRY 05-PU FD AC PS 2026', 'WHITE', '292898', '1775323', 'TAMBUN', 1, 'V', NULL, '2026-07-09 14:32:10', '2026-07-11 10:14:10'),
(55, 'IDRIS', '2026-07-10', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '291259', '1772702', 'TAMBUN', 1, 'V', NULL, '2026-07-09 14:32:49', '2026-07-13 11:54:25'),
(56, 'OMAN', '2026-07-10', 'NEW CARRY 05-PU FD AC PS 2026', 'REAL BLACK', '292991', '1775640', 'TAMBUN', 1, 'V', NULL, '2026-07-09 14:33:56', '2026-07-13 11:54:15'),
(57, 'OMAN', '2026-07-10', 'NEW CARRY 05-PU FD 2026', 'SILKY SILVER METALIC', '293033', '1775662', 'TAMBUN', 1, 'V', NULL, '2026-07-09 14:35:35', '2026-07-11 10:13:54'),
(58, 'OMAN', '2026-07-10', 'NEW CARRY 05-PU FD 2026', 'WHITE', '290406', '1771719', 'TAMBUN', 1, 'V', NULL, '2026-07-09 14:38:13', '2026-07-11 10:14:02'),
(59, 'ASEP', '2026-07-10', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '291458', '1773217', 'TAMBUN', 4, 'V', '13:30:00', '2026-07-09 14:43:20', '2026-07-11 08:45:26'),
(60, 'ASEP', '2026-07-10', 'NEW CARRY 05-PU FD 2026', 'WHITE', '290361', '1771525', 'TAMBUN', 3, 'V', '17:15:00', '2026-07-09 14:44:01', '2026-07-11 08:34:19'),
(61, 'IDRIS', '2026-07-11', 'ANTAR UNIT TEST DRIVE PU CIANJUR UNTUK KIR', 'REAL BLACK', 'B 9856 KAR', '-', 'CIAWI', 4, 'V', '10:30:00', '2026-07-11 10:16:02', '2026-07-14 08:54:53'),
(62, 'OMAN', '2026-07-11', 'FRONX GL AT 2026', 'MET.MAGMA GRAY 2', '100801', NULL, 'CIAWI', 4, 'V', '10:30:00', '2026-07-11 10:17:01', '2026-07-14 08:54:35'),
(63, 'IDRIS', '2026-07-13', 'NEW CARRY 05-PU FD AC PS 2026', 'GRAPHITE GREY METALLIC', '293480', '1776551', 'TAMBUN', 1, 'V', NULL, '2026-07-13 09:46:26', '2026-07-15 11:22:44'),
(64, 'IDRIS', '2026-07-13', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '292220', '1774267', 'TAMBUN', 1, 'V', NULL, '2026-07-13 09:47:12', '2026-07-15 11:22:49'),
(65, 'IDRIS', '2026-07-13', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '290850', '1772322', 'TAMBUN', 1, 'V', NULL, '2026-07-13 09:47:46', '2026-07-15 11:22:55'),
(66, 'OMAN', '2026-07-13', 'NEW CARRY 05-PU FD AC PS 2026', 'REAL BLACK', '293424', '1776206', 'TAMBUN', 1, 'V', NULL, '2026-07-13 09:48:57', '2026-07-15 11:22:33'),
(67, 'OMAN', '2026-07-13', 'NEW CARRY 05-PU FD AC PS 2026', 'REAL BLACK', '293442', '1776429', 'TAMBUN', 1, 'V', NULL, '2026-07-13 09:49:37', '2026-07-15 11:22:39'),
(68, 'IDRIS', '2026-07-14', 'NEW CARRY 05-PU WD AC PS 2026', 'GRAPHITE GREY METALLIC', '293522', '1776805', 'TAMBUN', 1, 'V', NULL, '2026-07-13 14:19:46', '2026-07-15 11:23:05'),
(69, 'IDRIS', '2026-07-14', 'NEW CARRY 05-PU FD 2026', 'SILKY SILVER METALIC', '292850', '1775387', 'TAMBUN', 1, 'V', NULL, '2026-07-13 14:20:28', '2026-07-15 11:23:46'),
(70, 'IDRIS', '2026-07-14', 'NEW CARRY 05-PU FD 2026', 'SILKY SILVER METALIC', '292873', '1775437', 'TAMBUN', 1, 'V', NULL, '2026-07-13 14:20:58', '2026-07-16 10:28:40'),
(71, 'OMAN', '2026-07-14', 'KIR UNIT TD PU CIANJUR', 'REAL BLACK', 'B 9856 KAR', '-', 'JATIASIH', 1, 'V', NULL, '2026-07-13 14:21:49', '2026-07-15 11:23:59'),
(72, 'OMAN', '2026-07-14', 'NEW CARRY 05-PU FD 2026', 'WHITE', '290553', '1771958', 'TAMBUN', 1, 'V', NULL, '2026-07-13 14:22:31', '2026-07-15 11:23:17'),
(73, 'OMAN', '2026-07-14', 'NEW CARRY 05-PU FD 2026', 'WHITE', '290595', '1772002', 'TAMBUN', 1, 'V', NULL, '2026-07-13 14:23:05', '2026-07-16 10:35:18'),
(74, 'OMAN', '2026-07-15', 'NEW CARRY 05-PU WD AC PS 2026', 'REAL BLACK', '290801', '1772353', 'TAMBUN', 1, 'V', NULL, '2026-07-15 11:15:44', '2026-07-16 10:36:01'),
(75, 'OMAN', '2026-07-15', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '291987', '1774566', 'TAMBUN', 1, 'V', NULL, '2026-07-15 11:16:24', '2026-07-21 10:30:04'),
(76, 'IDRIS', '2026-07-15', 'NEW CARRY 05-PU WD 2026', 'REAL BLACK', '291414', '1772938', 'TAMBUN', 1, 'V', NULL, '2026-07-15 11:17:13', '2026-07-16 10:36:14'),
(77, 'IDRIS', '2026-07-15', 'NEW CARRY 05-PU FD AC PS 2026', 'REAL BLACK', '293435', '1776491', 'TAMBUN', 1, 'V', NULL, '2026-07-15 11:17:45', '2026-07-16 10:27:14'),
(78, 'ASEP', '2026-07-15', 'NEW XL-7 03 KURO EDITION AT HYBRID 2TONE 2026', 'WHITE + BLACK TOP', '103329', '1768889', 'CIAWI', 3, 'V', '19:30:00', '2026-07-15 11:18:55', '2026-07-24 09:21:33'),
(79, 'OMAN', '2026-07-16', 'NEW CARRY 05-PU FD AC PS 2026', 'REAL BLACK', '293935', '1777450', 'TAMBUN', 1, 'V', NULL, '2026-07-16 10:22:08', '2026-07-21 10:30:42'),
(80, 'OMAN', '2026-07-16', 'NEW CARRY 05-PU FD AC PS 2026', 'REAL BLACK', '291909', '1773758', 'TAMBUN', 1, 'V', NULL, '2026-07-16 10:22:40', '2026-07-21 10:30:56'),
(81, 'IDRIS', '2026-07-16', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '292660', '1774973', 'TAMBUN', 1, 'V', NULL, '2026-07-16 10:24:32', '2026-07-21 10:31:04'),
(82, 'IDRIS', '2026-07-16', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '292700', '1775057', 'TAMBUN', 1, 'V', NULL, '2026-07-16 10:25:13', '2026-07-21 10:31:10'),
(83, 'IDRIS', '2026-07-20', 'FRONX HYBRID GX MT', 'SAVANA IVORY', '104430', '1102459', 'CIKARANG', 1, 'V', NULL, '2026-07-18 13:54:32', '2026-07-21 10:31:22'),
(84, 'IDRIS', '2026-07-20', 'XL7 KURO AT HYBRID 2026', 'COOL BLACK MET', '101819', '1757547', 'CIAWI', 4, 'V', '10:30:00', '2026-07-18 13:55:59', '2026-07-21 09:09:37'),
(85, 'OMAN', '2026-07-20', 'NEW CARRY 05-PU FD AC PS 2026', 'GRAPHITE GREY METALLIC', '294267', '1778189', 'TAMBUN', 1, 'V', NULL, '2026-07-18 13:56:47', '2026-07-21 10:31:17'),
(86, 'OMAN', '2026-07-21', 'FRONX GL AT 2026', 'SNOW WHITE', '100911', '1772491', 'CIKARANG', 1, 'V', NULL, '2026-07-21 10:32:07', '2026-07-22 13:59:26'),
(87, 'IDRIS', '2026-07-21', 'FRONX GL AT 2026', 'MET.MAGMA GRAY 2', '101052', '1774808', 'CIKARANG', 1, 'V', NULL, '2026-07-21 10:32:46', '2026-08-20 11:39:48'),
(88, 'IDRIS', '2026-07-21', 'FRONX HYBRID SGX 2TONE AT 2025', 'WHITE + BLACK TOP', '111441', '1092801', 'CIAWI', 4, 'V', '10:30:00', '2026-07-21 10:34:18', '2026-07-29 09:14:51'),
(89, 'IDRIS', '2026-07-21', 'AMBIL DAN ANTAR MAKANAN ANJING', 'ACC PAK JOHNY', '-', '-', 'CIAWI- TENJOLAYA- PLUIT', 1, NULL, NULL, '2026-07-21 11:42:45', '2026-07-21 11:42:45'),
(90, 'ASEP', '2026-07-23', 'NEW XL-7 03 ALPHA MT HYBRID 2TONE 2026', 'DUMMY.SAVANA IVORY 2', '102579', '1762724', 'CIAWI', 3, 'V', '18:38:00', '2026-07-22 13:59:16', '2026-07-24 09:19:21'),
(91, 'IDRIS', '2026-07-23', 'ANTAR BAN KE JATIASIH', '-', '-', '-', 'CIAWI', 4, 'V', '09:15:00', '2026-07-23 13:53:40', '2026-07-29 09:15:13'),
(92, 'ASEP', '2026-07-25', 'S-PRESSO 02 AT-2026', 'WHITE', '601551', '978921', 'CINERE', 1, 'V', NULL, '2026-07-25 10:50:33', '2026-08-04 10:20:30'),
(93, 'OMAN', '2026-07-27', 'NEW CARRY 05-PU FD 2026', 'WHITE', '292613', '1774830', 'TAMBUN', 1, 'V', NULL, '2026-07-25 11:23:33', '2026-08-04 10:20:37'),
(94, 'IDRIS', '2026-07-27', 'NEW CARRY 05-PU FD 2026', 'WHITE', '292624', '1774879', 'TAMBUN', 1, 'V', NULL, '2026-07-25 11:24:41', '2026-08-04 10:20:44'),
(95, 'OMAN', '2026-07-28', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '293481', '1776503', 'TAMBUN', 1, 'V', NULL, '2026-07-28 11:14:01', '2026-08-04 10:21:19'),
(96, 'OMAN', '2026-07-28', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '293485', '293485', 'TAMBUN', 1, 'V', NULL, '2026-07-28 11:14:31', '2026-08-04 10:21:08'),
(97, 'OMAN', '2026-07-28', 'NEW CARRY 05-PU FD 2026', 'WHITE', '293418', '1776430', 'TAMBUN', 1, 'V', NULL, '2026-07-28 11:15:01', '2026-08-04 10:20:54'),
(98, 'IDRIS', '2026-07-28', 'NEW CARRY 05-PU FD 2026', 'SILKY SILVER METALIC', '294597', '294597', 'TAMBUN', 1, 'V', NULL, '2026-07-28 11:15:44', '2026-08-04 10:21:40'),
(99, 'IDRIS', '2026-07-28', 'NEW CARRY 05-PU FD AC PS 2026', 'WHITE', '294146', '1777969', 'TAMBUN', 1, 'V', NULL, '2026-07-28 11:18:28', '2026-08-04 10:21:32'),
(100, 'IDRIS', '2026-07-28', 'NEW CARRY 05-PU FD AC PS 2026', 'WHITE', '294242', '1778055', 'TAMBUN', 1, 'V', NULL, '2026-07-28 11:19:11', '2026-08-04 10:21:25'),
(101, 'IDRIS', '2026-07-29', 'FRONX HYBRID SGX 2TONE AT 2025', 'ICE GRAYISH BLUE', '112439', '1091575', 'JATIASIH', 1, 'V', NULL, '2026-07-29 14:55:48', '2026-08-04 10:21:59'),
(102, 'IDRIS', '2026-07-29', 'NEW CARRY 05-PU FD AC PS 2026', 'REAL BLACK', '295234', '1779908', 'TAMBUN', 1, 'V', NULL, '2026-07-29 14:56:40', '2026-08-04 10:21:49'),
(103, 'OMAN', '2026-07-29', 'ANTAR ACCOUNTING AUDIT', 'DCM', '-', '-', 'CIAWI', 2, NULL, NULL, '2026-07-29 14:57:27', '2026-07-29 14:57:27'),
(104, 'IDRIS', '2026-07-31', 'XL7 BETA AT 2026', 'MET.MAGMA GRAY 2', '104080', '1777507', 'CIKARANG', 1, 'V', NULL, '2026-07-29 14:58:31', '2026-08-04 10:22:46'),
(105, 'OMAN', '2026-07-30', 'NEW CARRY 05-PU FD AC PS 2026', 'REAL BLACK', '292991', '1775640', 'CIAWI', 4, 'V', '10:15:00', '2026-07-29 14:59:11', '2026-08-02 15:21:39'),
(106, 'OMAN', '2026-07-30', 'APV GL AB MT', 'SILKY SILVER METALIC', '400607', '-', 'TAMBUN', 1, 'V', NULL, '2026-07-30 11:25:24', '2026-08-04 10:22:08'),
(107, 'OMAN', '2026-07-31', 'XL7 NEW BETA MT MC 2026', 'SNOW WHITE', '103921', '1776917', 'CIKARANG', 1, 'V', NULL, '2026-07-30 15:31:07', '2026-08-04 10:22:27'),
(108, 'OMAN', '2026-07-31', 'XL7 NEW ZETA AT MC 2026', 'SNOW WHITE', '102026', '1776857', 'CIKARANG', 1, 'V', NULL, '2026-07-30 15:32:13', '2026-08-04 10:22:22'),
(109, 'ASEP', '2026-07-31', 'XL7 NEW ALPHA AT HYBIRD 2TONE  MC 2026', 'MET.SAVANNA IVORY 2 + MARBLE BLACK', '103953', '1777442', 'CIKARANG', 4, 'V', '19:00:00', '2026-07-30 15:44:24', '2026-08-02 15:20:56'),
(110, 'ASEP', '2026-07-31', 'XL7 NEW ALPHA AT HYBIRD 2TONE  MC 2026', 'PRIME.ICE GRAYISH BLUE 2 + MARBLE BLACK', '103943', '1777048', 'CIKARANG', 3, 'V', '20:10:00', '2026-07-30 15:48:29', '2026-08-03 13:42:09'),
(111, 'IDRIS', '2026-07-30', 'ANTAR PA JOHNY', '-', '-', '-', 'PLUIT', 1, NULL, NULL, '2026-07-30 15:49:17', '2026-07-30 15:49:17'),
(112, 'IDRIS', '2026-07-31', 'XL7 NEW ALPHA AT HYBIRD 2TONE  MC 2026', 'MET.SAVANNA IVORY 2 + MARBLE BLACK', '103952', '1777412', 'CIKARANG', 1, 'V', NULL, '2026-07-31 11:29:55', '2026-08-04 10:22:40'),
(113, 'IDRIS', '2026-07-31', 'XL7 NEW ZETA AT MC 2026', 'SNOW WHITE', '102120', '1778039', 'CIKARANG', 1, 'V', NULL, '2026-07-31 11:30:52', '2026-08-04 10:22:34'),
(114, 'OMAN', '2026-07-31', 'NEW XL-7 NEW ALPHA AT HYBIRD 2TONE  MC 2026', 'PRIME.ICE GRAYISH BLUE 2 + MARBLE BLACK', '103938', '1777020', 'CIKARANG', 1, 'V', NULL, '2026-07-31 13:32:23', '2026-08-04 10:22:16'),
(115, 'IDRIS', '2026-08-03', 'XL7 NEW BETA AT MC 2026', 'SNOW WHITE', '104475', '1779417', 'CIKARANG', 4, 'V', '17:30:00', '2026-08-01 13:30:25', '2026-08-05 10:03:31'),
(116, 'IDRIS', '2026-08-03', 'XL7 NEW ZETA AT MC 2026', 'MARBLE BLACK', '102040', '1777426', 'CIKARANG', 1, 'V', NULL, '2026-08-01 13:31:08', '2026-08-05 13:45:54'),
(117, 'IDRIS', '2026-08-03', 'XL7 NEW ZETA AT MC 2026', 'MET.MAGMA GRAY 2', '102069', '1777594', 'CIKARANG', 1, NULL, NULL, '2026-08-01 13:32:15', '2026-08-01 13:32:15'),
(118, 'OMAN', '2026-08-03', 'XL7 NEW ZETA MT MC 2026', 'MARBEL BLACK', '102009', '1776748', 'CIKARANG', 4, 'V', '17:35:00', '2026-08-01 13:33:51', '2026-08-05 10:03:54'),
(119, 'OMAN', '2026-08-03', 'XL7 NEW BETA AT MC 2026', 'MARBEL BLACK', '103735', '1775111', 'CIKARANG', 1, 'V', NULL, '2026-08-01 13:34:47', '2026-08-04 10:22:59'),
(120, 'OMAN', '2026-08-03', 'XL7 NEW ZETA MT MC 2026', 'SNOW WHITE', '102178', '1778875', 'CIKARANG', 1, 'V', NULL, '2026-08-01 13:35:37', '2026-08-05 13:45:41'),
(121, 'ASEP', '2026-08-03', 'XL7 03 BETA AT HYBRID 2026', 'SNOW WHITE', '103101', '1767189', 'JATIASIH', 3, NULL, NULL, '2026-08-01 13:45:18', '2026-08-01 13:45:18'),
(122, 'ASEP', '2026-08-03', 'APV FE GX AB MT', 'WHITE', '400526', '454079', 'TAMBUN', 3, 'V', '17:30:00', '2026-08-01 13:47:06', '2026-08-05 15:23:37'),
(123, 'ASEP', '2026-08-04', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '294144', '1777897', 'TAMBUN', 3, 'V', '19:08:00', '2026-08-03 17:15:09', '2026-08-05 15:22:35'),
(124, 'ASEP', '2026-08-04', 'NEW CARRY 05-PU FD AC PS 2026', 'WHITE', '295399', '1780104', 'TAMBUN', 3, 'V', '15:05:00', '2026-08-03 17:15:38', '2026-08-05 15:23:02'),
(125, 'IDRIS', '2026-08-04', 'NEW CARRY 05-PU FD 2026', 'SILKY SILVER METALIC', '295677', '1780738', 'TAMBUN', 1, 'V', NULL, '2026-08-03 17:16:08', '2026-08-05 13:47:01'),
(126, 'IDRIS', '2026-08-04', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '294194', '1777862', 'TAMBUN', 1, 'V', NULL, '2026-08-03 17:16:35', '2026-08-05 13:46:50'),
(127, 'OMAN', '2026-08-04', 'FRONX HYBRID SGX AT 2025', 'SNOW WHITE', '109209', '1087606', 'CIKARANG', 1, 'V', NULL, '2026-08-03 17:17:27', '2026-08-05 13:46:24'),
(128, 'OMAN', '2026-08-04', 'XL7 NEW ZETA AT MC 2026', 'MET.MAGMA GRAY 2', '102243', '1779497', 'CIKARANG', 1, 'V', NULL, '2026-08-03 17:17:59', '2026-08-05 13:46:13'),
(129, 'IDRIS', '2026-08-04', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '294176', '-', 'TAMBUN', 1, 'V', NULL, '2026-08-04 11:56:31', '2026-08-05 13:46:43'),
(130, 'IDRIS', '2026-08-05', 'ANTAR JEMPUT PA JOHNY', '-', '-', '-', 'CIAWI-PLUIT', 1, NULL, NULL, '2026-08-05 10:06:38', '2026-08-05 10:06:38'),
(131, 'OMAN', '2026-08-05', 'FRONX HYBRID SGX 2TONE AT 2025', 'ICE GRAYISH BLUE', '112442', '1092123', 'CIKARANG', 4, 'V', '16:10:00', '2026-08-05 10:12:07', '2026-08-08 12:43:50'),
(132, 'OMAN', '2026-08-05', 'NEW XL-7 NEW ALPHA AT HYBIRD 2TONE  MC 2026', 'PRL.SNOW WHITE 4 + MARBLE BLACK', '103702', '1775098', 'CIKARANG', 1, 'V', NULL, '2026-08-05 10:19:04', '2026-08-07 13:45:21'),
(133, 'ASEP', '2026-08-05', 'FRONX HYBRID SGX AT', 'SNOW WHITE', '108771', '1087322', 'CIKARANG', 4, 'V', '17:15:00', '2026-08-05 10:29:20', '2026-08-08 12:42:22'),
(134, 'ASEP', '2026-08-05', 'NEW XL-7 NEW ZETA AT MC 2026', 'SNOW WHITE', '101993', '1776710', 'CIKARANG', 3, 'V', '17:00:00', '2026-08-05 10:30:17', '2026-08-12 14:54:27'),
(135, 'OMAN', '2026-08-05', 'NEW XL-7	03 ALPHA AT HYBRID 2TONE 2026', 'DUMMY.SAVANA IVORY 2', '100135', '1739354', 'JATIASIH', 1, 'V', NULL, '2026-08-05 10:31:09', '2026-08-07 13:45:15'),
(136, 'OMAN', '2026-08-06', 'NEW CARRY 05-PU WD AC PS 2026', 'REAL BLACK', '292859', '1775847', 'TAMBUN', 4, 'V', '09:45:00', '2026-08-05 14:13:05', '2026-08-08 12:42:57'),
(137, 'OMAN', '2026-08-06', 'APV	FE GE PS DEL.VAN MT 2026 (BLINDVAN)', 'WHITE', '400859', '454977', 'TAMBUN', 1, 'V', NULL, '2026-08-05 14:14:46', '2026-08-07 13:46:04'),
(138, 'OMAN', '2026-08-06', 'NEW CARRY 05-PU FD AC PS 2026', 'WHITE', '295466', '1780307', 'TAMBUN', 1, 'V', NULL, '2026-08-05 14:15:30', '2026-08-07 13:45:54'),
(139, 'OMAN', '2026-08-07', 'NEW CARRY 05-PU FD AC PS 2026', 'WHITE', '295478', '1780186', 'TAMBUN', 1, 'V', NULL, '2026-08-07 13:41:49', '2026-08-18 16:13:52'),
(140, 'OMAN', '2026-08-07', 'NEW CARRY 05-PU FD AC PS 2026', 'WHITE', '295448', '1780219', 'TAMBUN', 1, 'V', NULL, '2026-08-07 13:42:20', '2026-08-18 16:13:34'),
(141, 'OMAN', '2026-08-07', 'NEW CARRY 05-PU FD AC PS 2026', 'WHITE', '295535', '1780462', 'TAMBUN', 1, 'V', NULL, '2026-08-07 13:42:42', '2026-08-11 13:44:48'),
(142, 'IDRIS', '2026-08-07', 'NEW CARRY 05-PU WD 2026', 'REAL BLACK', '292765', '1775162', 'TAMBUN', 1, 'V', NULL, '2026-08-07 13:43:39', '2026-08-18 16:14:18'),
(143, 'IDRIS', '2026-08-07', 'NEW CARRY 05-PU WD AC PS 2026', 'WHITE', '292731', '1774969', 'TAMBUN', 1, 'V', NULL, '2026-08-07 13:44:11', '2026-08-18 16:14:11'),
(144, 'IDRIS', '2026-08-07', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '294204', '1778064', 'TAMBUN', 1, 'V', NULL, '2026-08-07 13:44:46', '2026-08-18 16:14:03'),
(145, 'IDRIS', '2026-08-08', 'ANTAR JEMPU PA JOHNY', '-', '-', '-', 'CIAW-PLUIT', 1, NULL, NULL, '2026-08-08 14:38:07', '2026-08-08 14:38:36'),
(146, 'OMAN', '2026-08-08', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '294320', '1778151', 'TAMBUN', 1, 'V', NULL, '2026-08-08 14:39:34', '2026-08-18 16:14:35'),
(147, 'OMAN', '2026-08-08', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '294375', '1778258', 'TAMBUN', 1, 'V', NULL, '2026-08-08 14:40:08', '2026-08-18 16:14:27'),
(148, 'IDRIS', '2026-08-10', 'FRONX HYBRID SGX AT', 'SAVANA IVORY', '109823', '1090280', 'CIKARANG', 4, 'V', '11:15:00', '2026-08-08 14:41:02', '2026-08-11 10:15:11'),
(149, 'IDRIS', '2026-08-10', 'NEW XL-7 NEW BETA MT MC 2026', 'SNOW WHITE', '104242', '1778158', 'CIKARANG', 1, 'V', NULL, '2026-08-08 14:41:48', '2026-08-18 16:15:02'),
(150, 'OMAN', '2026-08-10', 'XL7 NEW ALPHA AT MC 2026', 'MARBLE BLACK', 'DB631622', '-', 'CIKARANG', 4, 'V', '17:30:00', '2026-08-08 14:43:05', '2026-08-11 10:18:07'),
(151, 'OMAN', '2026-08-10', 'FRONX HYBRID SGX AT', 'SAVANA IVORY', '113242', '1094059', 'CIKARANG', 1, 'V', NULL, '2026-08-08 14:43:47', '2026-08-18 16:14:43'),
(152, 'IDRIS', '2026-08-11', 'ANTAR JEMPU PA JOHNY', '-', '-', '-', 'CIAWI PLUIT', 1, NULL, NULL, '2026-08-11 13:41:59', '2026-08-11 13:41:59'),
(153, 'OMAN', '2026-08-11', 'FRONX HYBRID SGX AT', 'COOL BLACK MET', '110366', '1090929', 'CIKARANG', 1, 'V', NULL, '2026-08-11 13:42:45', '2026-08-18 16:14:53'),
(154, 'OMAN', '2026-08-11', 'NEW XL-7	NEW ALPHA AT HYBRID MC 2026', 'MARBLE BLACK', '104656', '1779801', 'CIKARANG', 1, 'V', NULL, '2026-08-11 13:43:40', '2026-08-18 16:13:42'),
(155, 'IDRIS', '2026-08-12', 'ANTAR JEMPUT PA JOHNY', '-', '-', '-', 'CIAWI PLUIT', 1, NULL, NULL, '2026-08-12 13:33:49', '2026-08-12 13:33:49'),
(156, 'OMAN', '2026-08-12', 'XL7 NEW ALPHA AT HYBIRD MC 2026', 'MARBLE BLACK', '104687', '1780051', 'CIKARANG', 4, 'V', NULL, '2026-08-12 13:35:32', '2026-08-18 16:15:49'),
(157, 'OMAN', '2026-08-12', 'FRONX HYBRID SGX 2TONE AT 2025', 'ICE GRAYISH BLUE', '113406', '1094210', 'CIKARANG', 1, 'V', NULL, '2026-08-12 13:36:24', '2026-08-18 16:15:41'),
(158, 'ASEP', '2026-08-13', 'NEW CARRY 05-PU WD AC PS 2026', 'REAL BLACK', '293873', '1777344', 'TAMBUN', 4, 'V', '10:30:00', '2026-08-13 13:20:22', '2026-08-18 17:05:13'),
(159, 'ASEP', '2026-08-13', 'JIMNY 5DOORS AT 2TONE 2025', 'SLD.KINETIC YELLOW', '225740', '-', 'TAMBUN', 4, 'V', '15:00:00', '2026-08-13 13:21:28', '2026-08-18 17:01:50'),
(160, 'OMAN', '2026-08-13', 'NEW CARRY 05-PU FD 2026', 'SILKY SILVER METALIC', '296935', '1783104', 'TAMBUN', 1, 'V', NULL, '2026-08-13 13:22:30', '2026-08-18 16:16:08'),
(161, 'OMAN', '2026-08-13', 'NEW CARRY 05-PU FD AC PS 2026', 'GRAPHITE GREY METALLIC', '296990', '1782148', 'TAMBUN', 1, 'V', NULL, '2026-08-13 13:23:07', '2026-08-18 16:16:00'),
(162, 'IDRIS', '2026-08-13', 'FRONX HYBRID SGX 2TONE AT 2025', 'ICE GRAYISH BLUE', '113523', '-', 'CIKARANG', 1, 'V', NULL, '2026-08-13 13:25:51', '2026-08-18 16:16:45'),
(163, 'IDRIS', '2026-08-13', 'JIMNY 5DOORS AT 2TONE 2025', 'MET.CIFFON IVORY', '220283', '4446785', 'SBAM', 1, 'V', NULL, '2026-08-13 13:29:42', '2026-08-18 16:16:16'),
(164, 'IDRIS', '2026-08-13', 'XL7 NEW ZETA AT MC 2026', 'MET.MAGMA GRAY 2', '102069', '-', 'CIAWI', 4, 'V', '10:30:00', '2026-08-13 13:31:16', '2026-08-18 17:03:17'),
(165, 'OMAN', '2026-08-14', 'NEW CARRY 05-PU FD AC PS 2026', 'REAL BLACK', '297238', '1783532', 'TAMBUN', 1, 'V', NULL, '2026-08-18 15:56:46', '2026-08-18 16:16:55'),
(166, 'IDRIS', '2026-08-14', 'NEW CARRY 05-PU FD 2026', 'WHITE', '297232', '1783539', 'TAMBUN', 1, 'V', NULL, '2026-08-18 15:57:26', '2026-08-18 16:17:13'),
(167, 'IDRIS', '2026-08-14', 'NEW CARRY 05-PU FD 2026', 'SILKY SILVER METALIC', '297232', '1783539', 'TAMBUN', 1, 'V', NULL, '2026-08-18 15:58:03', '2026-08-18 16:17:03'),
(168, 'ASEP', '2026-08-14', 'FRONX HYBRID GX AT', 'COOL BLACK MET', '112607', '1094859', 'CINERE', 1, 'V', NULL, '2026-08-18 16:07:16', '2026-08-18 16:17:20'),
(169, 'OMAN', '2026-08-18', 'NEW CARRY 05-PU FD AC PS 2026', 'GRAPHITE GREY METALLIC', '297485', '1783950', 'TAMBUN', 1, NULL, NULL, '2026-08-18 16:08:12', '2026-08-18 16:08:12'),
(170, 'OMAN', '2026-08-18', 'NEW CARRY 05-PU FD 2026', 'WHITE', '297503', '1783992', 'TAMBUN', 1, NULL, NULL, '2026-08-18 16:08:58', '2026-08-18 16:08:58'),
(171, 'OMAN', '2026-08-18', 'NEW CARRY 05-PU FD 2026', 'SILKY SILVER METALIC', '297370', '1783822', 'TAMBUN', 1, NULL, NULL, '2026-08-18 16:09:34', '2026-08-18 16:09:34'),
(172, 'IDRIS', '2026-08-18', 'NEW CARRY 05-PU FD 2026', 'SILKY SILVER METALIC', '297390', '1783826', 'TAMBUN', 1, NULL, NULL, '2026-08-18 16:10:41', '2026-08-18 16:10:41'),
(173, 'IDRIS', '2026-08-18', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '294827', '1778996', 'TAMBUN', 1, NULL, NULL, '2026-08-18 16:11:16', '2026-08-18 16:11:16'),
(174, 'IDRIS', '2026-08-18', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '294883', '1779114', 'TAMBUN', 1, NULL, NULL, '2026-08-18 16:11:46', '2026-08-18 16:11:46'),
(175, 'ASEP', '2026-08-18', 'NEW XL-7 03 ALPHA AT HYBRID 2TONE 2026', 'DUMMY.SAVANA IVORY 2', '102587', '1762909', 'CINERE', 1, NULL, NULL, '2026-08-18 16:12:31', '2026-08-18 16:12:31'),
(176, 'ASEP', '2026-08-15', 'NEW CARRY 05-PU FD AC PS 2026', 'REAL BLACK', '286311', '1764951', 'CINERE', 1, 'V', NULL, '2026-08-18 16:13:20', '2026-08-18 16:17:28'),
(177, 'OMAN', '2026-08-19', 'NEW XL-7 NEW ALPHA AT HYBIRD 2TONE  MC 2026', 'MET.SAVANNA IVORY 2 + MARBLE BLACK', '104770', '1780474', 'CIKARANG', 1, NULL, NULL, '2026-08-19 14:32:53', '2026-08-19 14:32:53'),
(178, 'OMAN', '2026-08-19', 'FRONX HYBIRD SGX AT 2TONE 2026', 'WHITE + BLACK TOP', '101144', '1096194', 'CIKARANG', 1, NULL, NULL, '2026-08-19 14:33:37', '2026-08-19 14:33:37'),
(179, 'IDRIS', '2026-08-19', 'NEW CARRY 05-PU FD 2026', 'WHITE', '296735', '1784105', 'TAMBUN', 1, NULL, NULL, '2026-08-19 14:34:18', '2026-08-19 14:34:18'),
(180, 'IDRIS', '2026-08-19', 'NEW CARRY 05-PU WD AC PS 2026', 'SILKY SILVER METALIC', '296855', '1783093', 'TAMBUN', 1, NULL, NULL, '2026-08-19 14:34:59', '2026-08-19 14:34:59'),
(181, 'ASEP', '2026-08-19', 'FRONX HYBRID SGX AT', 'SAVANA IVORY', '113242', '1094059', 'CIAWI', 3, NULL, NULL, '2026-08-19 14:35:47', '2026-08-19 14:35:47'),
(182, 'OMAN', '2026-08-20', 'XL7 NEW ALPHA AT HYBIRD 2TONE  MC 2026', 'PRIME.ICE GRAYISH BLUE 2 + MARBLE BLACK', '104184', '1778255', 'CIKARANG', 1, NULL, NULL, '2026-08-20 11:19:49', '2026-08-20 11:19:49'),
(183, 'OMAN', '2026-08-20', 'XL7 NEW ALPHA AT HYBIRD 2TONE  MC 2026', 'MET.SAVANNA IVORY 2 + MARBLE BLACK', '104019', '1777407', 'CIKARANG', 1, NULL, NULL, '2026-08-20 11:21:00', '2026-08-20 11:21:00'),
(184, 'IDRIS', '2026-08-20', 'XL7 NEW ZETA AT MC 2026', 'MARBLE BLACK', '102253', '1779482', 'CIKARANG', 1, NULL, NULL, '2026-08-20 11:21:40', '2026-08-20 11:21:40'),
(185, 'IDRIS', '2026-08-20', 'XL7 NEW ZETA AT MC 2026', 'SNOW WHITE', '102429', '1780503', 'CIKARANG', 1, NULL, NULL, '2026-08-20 11:22:16', '2026-08-20 11:22:16'),
(186, 'OMAN', '2026-08-20', 'JIMNY 5DOORS AT 2TONE 2025', 'SLD.KINETIC YELLOW', '225048', '4451676', 'CIAWI', 3, NULL, NULL, '2026-08-20 15:22:51', '2026-08-20 15:22:51'),
(187, 'ASEP', '2026-08-21', 'APV FE GX AB MT', 'PEARL WHITE METALLIC', '400506', '454199', 'TAMBUN', 3, NULL, NULL, '2026-08-20 16:38:30', '2026-08-20 16:38:30'),
(188, 'OMAN', '2026-08-21', 'FRONX HYBRID SGX 2TONE AT 2025', 'ICE GRAYISH BLUE', '113054', '1093980', 'CIKARANG', 1, NULL, NULL, '2026-08-20 16:39:14', '2026-08-20 16:39:14'),
(189, 'OMAN', '2026-08-21', 'FRONX HYBRID SGX 2TONE AT 2025', 'ICE GRAYISH BLUE', '112956', '1093872', 'CIKARANG', 1, NULL, NULL, '2026-08-20 16:39:57', '2026-08-20 16:39:57'),
(190, 'IDRIS', '2026-08-21', 'XL7 NEW ZETA MT MC 2026', 'SNOW WHITE', '102493', '1780992', 'CIKARANG', 1, NULL, NULL, '2026-08-20 16:40:42', '2026-08-20 16:40:42'),
(191, 'OMAN', '2026-08-24', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '297091', '1783272', 'TAMBUN', 1, NULL, NULL, '2026-08-22 12:00:07', '2026-08-22 12:00:07'),
(192, 'OMAN', '2026-08-24', 'NEW CARRY 05-PU FD 2026', 'REAL BLACK', '297088', '1783233', 'TAMBUN', 1, NULL, NULL, '2026-08-22 12:00:44', '2026-08-22 12:00:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `cabang` varchar(255) NOT NULL,
  `sumber_id` varchar(255) DEFAULT NULL,
  `unit_id` varchar(255) DEFAULT NULL,
  `status_id` varchar(255) DEFAULT NULL,
  `respon_id` varchar(255) DEFAULT NULL,
  `spv_id` varchar(255) DEFAULT NULL,
  `sales_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `update_1` text DEFAULT NULL,
  `update_2` text DEFAULT NULL,
  `update_3` text DEFAULT NULL,
  `bukti_screenshot` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_02_071338_create_target_do_units_table', 1),
(5, '2026_02_02_071358_create_target_salesforces_table', 1),
(6, '2026_02_02_071413_create_target_inquiries_table', 1),
(7, '2026_02_02_071431_create_target_do_by_soi_table', 1),
(8, '2026_02_02_080510_create_actual_do_by_type_table', 1),
(9, '2026_02_02_080638_create_actual_spk_by_type_table', 1),
(10, '2026_02_02_081934_create_actual_inquary_by_type_table', 1),
(11, '2026_02_02_082055_create_actual_source_inquary_table', 1),
(12, '2026_02_02_082533_create_actual_salesforces_table', 1),
(13, '2026_02_02_082632_create_actual_do_salesforces_table', 1),
(14, '2026_02_02_084007_create_sales_by_leasing_table', 1),
(15, '2026_02_03_040841_create_aktual_aplikasi_in_table', 1),
(16, '2026_02_03_040857_create_aktual_po_table', 1),
(17, '2026_02_03_040905_create_aktual_reject_table', 1),
(18, '2026_02_03_042037_create_actual_source_do_inquary_table', 1),
(19, '2026_02_03_082710_create_evaluasi_wiraniagas_table', 1),
(20, '2026_02_03_091851_create_summaries_table', 1),
(21, '2026_02_04_021051_create_summary_actions_table', 1),
(22, '2026_02_09_022414_create_plan_activities_table', 1),
(23, '2026_02_09_022415_create_actual_activities_table', 1),
(24, '2026_02_11_025159_create_dashboards_table', 1),
(25, '2026_05_21_000000_create_piutangs_table', 1),
(26, '2026_05_21_000001_create_sessions_table', 1),
(27, '2026_05_26_071701_add_branch_to_users_table', 1),
(28, '2026_05_28_000000_add_is_admin_to_users_table', 1),
(29, '2026_06_02_000000_add_payment_stage_columns_to_piutangs_table', 1),
(30, '2026_06_02_065337_add_nama_asuransi_to_piutangs_table', 1),
(31, '2026_06_05_000000_create_asuransis_table', 1),
(32, '2026_06_05_000001_create_perusahaan_table', 1),
(33, '2026_06_10_000001_create_units_table', 1),
(34, '2026_06_10_000002_create_warnas_table', 1),
(35, '2026_06_10_000003_create_varians_table', 1),
(36, '2026_06_10_000004_create_gudangs_table', 1),
(37, '2026_06_10_000005_create_cabangs_table', 1),
(38, '2026_06_10_000006_create_in_units_table', 1),
(39, '2026_06_13_000000_create_stocks_table', 1),
(40, '2026_06_19_053052_add_is_admin_stock_to_users_table', 1),
(41, '2026_06_26_133544_add_softdeletes_to_varians_table', 1),
(42, '2026_06_26_133958_add_fields_to_in_units_table', 1),
(43, '2026_06_26_144807_add_varian_to_stocks_table', 1),
(44, '2026_06_27_101702_add_unit_and_varian_to_warnas_table', 1),
(45, '2026_07_01_120000_fill_timestamps_for_existing_in_units', 1),
(46, '2026_07_02_000001_add_foreign_keys_to_in_units_table', 1),
(47, '2026_07_03_000001_add_softdeletes_to_gudangs_table', 1),
(48, '2026_07_04_000001_add_softdeletes_to_cabangs_table', 1),
(49, '2026_07_05_000001_update_in_units_table_new_fields', 1),
(50, '2026_07_06_000000_add_timestamps_to_in_units_table', 1),
(51, '2026_07_24_082141_create_pm_mst_plan_sales_table', 1),
(52, '2026_08_03_000000_add_nama_mobil_warna_lokasi_to_stocks_table', 1),
(53, '2026_08_03_000001_add_role_and_cabang_to_users_table', 1),
(54, '2026_08_14_000001_update_evaluasi_and_activity_tables', 1),
(55, '2026_08_15_100132_create_leads_table', 2),
(56, '2026_08_15_104118_create_unit_leads_table', 2),
(57, '2026_08_15_104827_create_sumber_leads_table', 2),
(58, '2026_08_15_105659_create_budget_leads_table', 2),
(59, '2026_08_15_110219_create_status_leads_table', 2),
(60, '2026_08_15_111324_create_respon_leads_table', 2),
(61, '2026_08_15_114221_add_details_to_leads_table', 2),
(62, '2026_08_15_123400_create_sales_leads_table', 2),
(63, '2026_08_15_123400_create_spv_leads_table', 2),
(64, '2026_08_15_123401_create_adm_leads_table', 2),
(65, '2026_08_19_222231_create_service_acs_table', 3),
(66, '2026_08_19_223651_create_post_check_acs_table', 3),
(67, '2026_08_19_230335_create_pre_check_acs_table', 3),
(68, '2026_08_20_100653_change_foto_kendaraan_to_json_on_post_check_acs_table', 3),
(69, '2026_08_21_110433_add_no_spk_to_ac_tables', 4),
(70, '2026_08_21_101715_create_teknisis_table', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `overdue` int(11) NOT NULL DEFAULT 28,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `perusahaan`
--

INSERT INTO `perusahaan` (`id`, `nama`, `deskripsi`, `overdue`, `created_at`, `updated_at`) VALUES
(2, 'PT GUDANG GARAM', NULL, 28, '2026-06-06 09:43:36', '2026-06-06 09:43:36'),
(3, 'PT CSM  CORFORATAMA', NULL, 42, '2026-06-06 09:43:43', '2026-06-08 02:48:32'),
(4, 'PT. SURYA SUDECO', NULL, 42, '2026-06-08 02:15:14', '2026-06-08 02:48:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `piutangs`
--

CREATE TABLE `piutangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch` varchar(255) NOT NULL,
  `tipe_konsumen` varchar(255) DEFAULT NULL,
  `perusahaan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_konsumen` varchar(255) DEFAULT NULL,
  `nama_asuransi` varchar(255) DEFAULT NULL,
  `tgl_bukti` date DEFAULT NULL,
  `no_bukti` varchar(255) DEFAULT NULL,
  `saldo_awal` decimal(20,2) NOT NULL DEFAULT 0.00,
  `debet` decimal(20,2) NOT NULL DEFAULT 0.00,
  `kredit` decimal(20,2) NOT NULL DEFAULT 0.00,
  `kredit_2` decimal(20,2) NOT NULL DEFAULT 0.00,
  `kredit_3` decimal(20,2) NOT NULL DEFAULT 0.00,
  `tgl_bukti_rek` date DEFAULT NULL,
  `no_bukti_rek` varchar(255) DEFAULT NULL,
  `saldo_akhir` decimal(20,2) NOT NULL DEFAULT 0.00,
  `keterangan` varchar(255) DEFAULT NULL,
  `tgl_bukti_rek_2` date DEFAULT NULL,
  `no_bukti_rek_2` varchar(255) DEFAULT NULL,
  `keterangan_2` varchar(255) DEFAULT NULL,
  `tgl_bukti_rek_3` date DEFAULT NULL,
  `no_bukti_rek_3` varchar(255) DEFAULT NULL,
  `keterangan_3` varchar(255) DEFAULT NULL,
  `no_polisi` varchar(255) DEFAULT NULL,
  `no_polis` varchar(255) DEFAULT NULL,
  `spk_type` varchar(255) DEFAULT NULL,
  `no_spk` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `piutangs`
--

INSERT INTO `piutangs` (`id`, `branch`, `tipe_konsumen`, `perusahaan_id`, `nama_konsumen`, `nama_asuransi`, `tgl_bukti`, `no_bukti`, `saldo_awal`, `debet`, `kredit`, `kredit_2`, `kredit_3`, `tgl_bukti_rek`, `no_bukti_rek`, `saldo_akhir`, `keterangan`, `tgl_bukti_rek_2`, `no_bukti_rek_2`, `keterangan_2`, `tgl_bukti_rek_3`, `no_bukti_rek_3`, `keterangan_3`, `no_polisi`, `no_polis`, `spk_type`, `no_spk`, `created_at`, `updated_at`) VALUES
(1, 'bp', 'reguler', NULL, 'FAJAR AMRI, SE QQ NURUL FAHMA AMALIA', NULL, '2026-08-12', 'IC05/26/000228', 3056940.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 3056940.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2104SOR', NULL, 'REGULER', 'PK05/26/000412', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(2, 'bp', 'reguler', NULL, 'DAYAT QQ ABDURAHMAN', NULL, '2026-08-12', 'IC05/26/000229', 1643540.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1643540.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F1566FNO', NULL, 'REGULER', 'PK05/26/000411', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(3, 'bp', 'reguler', NULL, 'AHSAN JUANESCHAR', 'PAN PACIFIC INSURANCE', '2026-08-10', 'IA05/26/000176', 3566430.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 3566430.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1190VZM', NULL, 'ASURANSI', 'PK05/26/000409', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(4, 'bp', 'reguler', NULL, 'SUKIYAT', NULL, '2026-08-10', 'IC05/26/000227', 1499610.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1499610.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1754KKB', NULL, 'REGULER', 'PK05/26/000408', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(5, 'bp', 'perusahaan', NULL, 'PT. TELTO TELEMATIS INDONESIA', NULL, '2026-08-08', 'IC05/26/000223', 532800.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 532800.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2079KIG', NULL, 'REGULER', 'PK05/26/000407', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(6, 'bp', 'reguler', NULL, 'WIYAH BINTI WIRA', 'PAN PACIFIC INSURANCE', '2026-08-08', 'IA05/26/000174', 899100.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 899100.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2913FOX', NULL, 'ASURANSI', 'PK05/26/000406', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(7, 'bp', 'reguler', NULL, 'WAHYU BUDIYONO', NULL, '2026-08-07', 'IC05/26/000226', 2283982.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2283982.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1206DOJ', NULL, 'REGULER', 'PK05/26/000405', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(8, 'bp', 'reguler', NULL, 'FIQIH AULIA ADHA', 'KSK INSURANCE', '2026-08-07', 'IA05/26/000175', 5634360.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 5634360.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1086KDO', NULL, 'ASURANSI', 'PK05/26/000404', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(9, 'bp', 'reguler', NULL, 'SUGIANTO', NULL, '2026-08-07', 'IC05/26/000218', 4300275.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 4300275.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2428KKD', NULL, 'REGULER', 'PK05/26/000403', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(10, 'bp', 'reguler', NULL, 'ASIH WIANTI', NULL, '2026-08-07', 'IC05/26/000219', 249750.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 249750.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2879KMN', NULL, 'REGULER', 'PK05/26/000402', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(11, 'bp', 'reguler', NULL, 'HERWINDO SYAHPUTRA', NULL, '2026-08-05', 'IC05/26/000221', 552780.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 552780.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1070KJO', NULL, 'REGULER', 'PK05/26/000400', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(12, 'bp', 'reguler', NULL, 'HERWINDO SYAHPUTRA', NULL, '2026-08-05', 'IC05/26/000220', 300000.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 300000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A1417CG', NULL, 'REGULER', 'PK05/26/000399', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(13, 'bp', 'reguler', NULL, 'CHANDRA SIDIK', NULL, '2026-08-05', 'IC05/26/000224', 707625.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 707625.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1642ERZ', NULL, 'REGULER', 'PK05/26/000397', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(14, 'bp', 'reguler', NULL, 'CHANDRA SIDIK', NULL, '2026-08-05', 'IC05/26/000222', 555722.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 555722.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2319BYB', NULL, 'REGULER', 'PK05/26/000396', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(15, 'bp', 'reguler', NULL, 'DEVI ULFIA AMALIA', NULL, '2026-08-04', 'IC05/26/000225', 3098905.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 3098905.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2313KRY', NULL, 'REGULER', 'PK05/26/000395', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(16, 'bp', 'reguler', NULL, 'YUZVIRA NASRI', NULL, '2026-07-31', 'IC05/26/000217', 500000.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 500000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'BG8432DP', NULL, 'REGULER', 'PK05/26/000394', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(17, 'bp', 'perusahaan', NULL, 'PT INDOCITRA LOGISTICS EXPRESS', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-07-31', 'IA05/26/000168', 1816433.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1816433.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2384KRL', NULL, 'ASURANSI', 'PK05/26/000393', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(18, 'bp', 'reguler', NULL, 'HAIDY IRZAD WICAKSONO', NULL, '2026-07-31', 'IC05/26/000211', 181850.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 181850.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2611KOU', NULL, 'REGULER', 'PK05/26/000392', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(19, 'bp', 'reguler', NULL, 'MUHAMAD FAHRI ABDILLAH QQ REGINA REZKY PUTRI', NULL, '2026-07-30', 'IC05/26/000205', 400000.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 400000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1238RYJ', NULL, 'REGULER', 'PK05/26/000391', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(20, 'bp', 'reguler', NULL, 'MUHAMAD FAHRI ABDILLAH QQ REGINA REZKY PUTRI', 'BCA INSURANCE', '2026-07-30', 'IA05/26/000163', 4343726.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 4343726.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1238RYJ', NULL, 'ASURANSI', 'PK05/26/000390', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(21, 'bp', 'reguler', NULL, 'MUMUNG QQ DEVI ADRIANI', NULL, '2026-07-29', 'IC05/26/000209', 2284063.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2284063.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1077WIW', NULL, 'REGULER', 'PK05/26/000388', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(22, 'bp', 'reguler', NULL, 'AUDREY JOANNA R P QQ I PUTU DRAKAR CHRISTIAWAN', 'PAN PACIFIC INSURANCE', '2026-07-29', 'IA05/26/000154', 1226550.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1226550.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1375TCQ', NULL, 'ASURANSI', 'PK05/26/000387', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(23, 'bp', 'reguler', NULL, 'BALFOUR BOBBY RICHTER', 'ZURICH INSURANCE', '2026-07-28', 'IA05/26/000172', 5838776.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 5838776.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2263FOT', NULL, 'ASURANSI', 'PK05/26/000384', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(24, 'bp', 'perusahaan', NULL, 'PT DUTA CENDANA ADIMANDIRI', NULL, '2026-07-28', 'IC05/26/000207', 300000.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 300000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2142KIP', NULL, 'REGULER', 'PK05/26/000383', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(25, 'bp', 'perusahaan', NULL, 'PT. DUTA CENDANA ADIMANDIRI - JATIASIH', NULL, '2026-07-28', 'IC05/26/000206', 300000.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 300000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2331KRS', NULL, 'REGULER', 'PK05/26/000382', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(26, 'bp', 'reguler', NULL, 'ROHADI', 'PAN PACIFIC INSURANCE', '2026-07-27', 'IA05/26/000170', 5197910.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 5197910.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2119KIV', NULL, 'ASURANSI', 'PK05/26/000380', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(27, 'bp', 'reguler', NULL, 'OMEGA TRINUGRAHA', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-07-24', 'IA05/26/000156', 9297199.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 9297199.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2046KRH', NULL, 'ASURANSI', 'PK05/26/000378', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(28, 'bp', 'reguler', NULL, 'ARDA ALVIN PANDU EKAPUTRA', 'PAN PACIFIC INSURANCE', '2026-07-24', 'IA05/26/000155', 5973154.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 5973154.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F1828FCG', NULL, 'ASURANSI', 'PK05/26/000377', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(29, 'bp', 'reguler', NULL, 'ICHLAS AFRIANSYAH AFIF QQ M. FAISAL ROFEI, SE, MBA', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-07-20', 'IA05/26/000151', 1823895.00, 0.00, 400000.00, 0.00, 0.00, '2026-08-04', 'BT05/26/000321', 1423895.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2123KIV', NULL, 'ASURANSI', 'PK05/26/000372', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(30, 'bp', 'perusahaan', NULL, 'CV LA BELLA WOOD QQ LAILA NUR ILMI', 'BCA INSURANCE', '2026-07-17', 'IA05/26/000157', 3817158.00, 0.00, 300000.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000312', 3517158.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1044DYD', NULL, 'ASURANSI', 'PK05/26/000370', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(31, 'bp', 'reguler', NULL, 'KARINA ROSELIN, SE', 'BCA INSURANCE', '2026-07-16', 'IA05/26/000173', 1709450.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1709450.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2410KHA', NULL, 'ASURANSI', 'PK05/26/000368', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(32, 'bp', 'reguler', NULL, 'PT ELNUSA SENTRA BAJATAMA QQ KAISARIA NASUTION, S.H', 'PAN PACIFIC INSURANCE', '2026-07-15', 'IA05/26/000167', 6264174.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 6264174.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1660PDK', NULL, 'ASURANSI', 'PK05/26/000366', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(33, 'bp', 'reguler', NULL, 'RONAL LEFOLENSA SIMANJUNTAK, SH QQ HELENA MARIANI BUTAR BUTAR', 'SINARMAS INSURANCE', '2026-07-15', 'IA05/26/000159', 8481569.00, 0.00, 300000.00, 0.00, 0.00, '2026-08-04', 'BT05/26/000320', 8181569.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2916KHA', NULL, 'ASURANSI', 'PK05/26/000364', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(34, 'bp', 'reguler', NULL, 'DR. RONA QURROTUL AINA ROSIDIN', 'RAKSA PRATIKARA INSURANCE', '2026-07-14', 'IA05/26/000149', 2387357.00, 0.00, 600000.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000308', 1787357.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2428KHD', NULL, 'ASURANSI', 'PK05/26/000362', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(35, 'bp', 'reguler', NULL, 'MARIA JUTENSA TRIADE', 'KOREAN BANK (KB) INSURANCE', '2026-07-14', 'IA05/26/000165', 5994000.00, 0.00, 600000.00, 0.00, 0.00, '2026-08-03', 'KT05/26/000144', 5394000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1575RZR', NULL, 'ASURANSI', 'PK05/26/000361', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(36, 'bp', 'reguler', NULL, 'OKI WIJAYANTO', 'PAN PACIFIC INSURANCE', '2026-07-14', 'IA05/26/000148', 2282324.00, 0.00, 300000.00, 0.00, 0.00, '2026-08-04', 'BT05/26/000321', 1982324.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2578KHC', NULL, 'ASURANSI', 'PK05/26/000360', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(37, 'bp', 'reguler', NULL, 'DONI RAMDONI', 'BCA INSURANCE', '2026-07-13', 'IA05/26/000171', 6664178.00, 0.00, 600000.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000315', 6064178.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1618EYS', NULL, 'ASURANSI', 'PK05/26/000356', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(38, 'bp', 'reguler', NULL, 'EMANUEL SUKARNO.BE QQ ELISABETH PURI HANDAYANI', 'SINARMAS INSURANCE', '2026-07-13', 'IA05/26/000162', 2605790.00, 0.00, 300000.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000315', 2305790.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2757KRS', NULL, 'ASURANSI', 'PK05/26/000354', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(39, 'bp', 'reguler', NULL, 'TRI HANDOKO TJAHYADI', 'ASURANSI UMUM MONEEINSURE', '2026-07-09', 'IA05/26/000147', 3323419.00, 0.00, 300000.00, 0.00, 0.00, '2026-08-06', 'KT05/26/000151', 3023419.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1082ROF', NULL, 'ASURANSI', 'PK05/26/000348', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(40, 'bp', 'reguler', NULL, 'WAHYUDIN', NULL, '2026-07-09', 'IC05/26/000215', 1462425.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1462425.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1186JUN', NULL, 'REGULER', 'PK05/26/000346', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(41, 'bp', 'reguler', NULL, 'LEMIN SUHARTONO', NULL, '2026-07-09', 'IC05/26/000212', 17546379.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 17546379.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2423SFK', NULL, 'REGULER', 'PK05/26/000344', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(42, 'bp', 'perusahaan', NULL, 'MARKUS SENOLINGGI', 'CAKRAWALA PROTEKSI INDONESIA INSURANCE', '2026-07-08', 'IA05/26/000150', 7557334.00, 0.00, 600000.00, 0.00, 0.00, '2026-08-03', 'KT05/26/000144', 6957334.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2796KIQ', NULL, 'ASURANSI', 'PK05/26/000343', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(43, 'bp', 'reguler', NULL, 'AKMAL NAOVAL', 'OONA INSURANCE', '2026-07-08', 'IA05/26/000161', 1406592.00, 0.00, 300000.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000306', 1106592.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'DK1351JO', NULL, 'ASURANSI', 'PK05/26/000342', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(44, 'bp', 'perusahaan', NULL, 'PT HECTOR ARTHI FISIO', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-07-07', 'IA05/26/000146', 1398834.00, 0.00, 300000.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000307', 1098834.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1411DOI', NULL, 'ASURANSI', 'PK05/26/000339', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(45, 'bp', 'reguler', NULL, 'RIO ADAM QQ BAYU ADAM', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-07-06', 'IA05/26/000158', 15854787.00, 0.00, 1200000.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000309', 14654787.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2279KIW', NULL, 'ASURANSI', 'PK05/26/000337', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(46, 'bp', 'reguler', NULL, 'BUDI SETIAWAN', 'RAKSA PRATIKARA INSURANCE', '2026-07-04', 'IA05/26/000153', 3570352.00, 0.00, 600000.00, 0.00, 0.00, '2026-08-03', 'KT05/26/000144', 2970352.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1662EIG', NULL, 'ASURANSI', 'PK05/26/000334', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(47, 'bp', 'perusahaan', NULL, 'PT MULTI DIMENSI CONSULTANT', 'BCA INSURANCE', '2026-07-02', 'IA05/26/000152', 4670325.00, 0.00, 600000.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000310', 4070325.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1634DOE', NULL, 'ASURANSI', 'PK05/26/000331', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(48, 'bp', 'reguler', NULL, 'GIFTY ASRINI SE', 'ZURICH INSURANCE', '2026-07-01', 'IA05/26/000169', 3732045.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 3732045.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2769KHA', NULL, 'ASURANSI', 'PK05/26/000329', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(49, 'bp', 'perusahaan', NULL, 'PT INDOCITRA LOGISTICS EXPRESS', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-06-30', 'IA05/26/000144', 2981460.00, 0.00, 900000.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000302', 2081460.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2384KRL', NULL, 'ASURANSI', 'PK05/26/000321', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(50, 'bp', 'reguler', NULL, 'SUKMAYONO QQ PT. FLUINDO TECHNOLOGY INDONESIA', 'MEGA INSURANCE', '2026-06-29', 'IA05/26/000145', 13426560.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 13426560.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1784VOQ', NULL, 'ASURANSI', 'PK05/26/000320', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(51, 'bp', 'reguler', NULL, 'JOHNY JANUS', 'BCA INSURANCE', '2026-06-29', 'IA05/26/000164', 3504303.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 3504303.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2487KHC', NULL, 'ASURANSI', 'PK05/26/000319', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(52, 'bp', 'reguler', NULL, 'HAIRUL FAJAR', NULL, '2026-06-29', 'IC05/26/000178', 300000.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 300000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2072JUL', NULL, 'REGULER', 'PK05/26/000318', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(53, 'bp', 'reguler', NULL, 'ADITYA YUDISTIRA QQ RADIKA ANDIANI', 'KSK INSURANCE', '2026-06-27', 'IA05/26/000166', 11624055.00, 0.00, 2100000.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000302', 9524055.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1880FCG', NULL, 'ASURANSI', 'PK05/26/000313', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(54, 'bp', 'reguler', NULL, 'FITRIA DEWI ASTARI', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-06-27', 'IA05/26/000141', 2184580.00, 0.00, 300000.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000297', 1884580.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1859EIG', NULL, 'ASURANSI', 'PK05/26/000311', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(55, 'bp', 'reguler', NULL, 'DR.IR.EDDY SUPRIYONO,M.SC', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-06-26', 'IA05/26/000142', 11138180.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 11138180.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F1323FCF', NULL, 'ASURANSI', 'PK05/26/000309', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(56, 'bp', 'reguler', NULL, 'IR. JULI EDI SEBAYANG QQ YEMIMA RAHMANI SEBAYANG', 'BCA INSURANCE', '2026-06-23', 'IA05/26/000132', 896325.00, 0.00, 880175.00, 0.00, 0.00, '2026-08-01', 'KT05/26/000141', 16150.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2628KRO', NULL, 'ASURANSI', 'PK05/26/000305', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(57, 'bp', 'reguler', NULL, 'ANDIKA MAULANA', 'CAKRAWALA PROTEKSI INDONESIA INSURANCE', '2026-06-22', 'IA05/26/000137', 2417830.00, 0.00, 300000.00, 0.00, 0.00, '2026-07-15', 'KT05/26/000141', 2117830.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2593KIG', NULL, 'ASURANSI', 'PK05/26/000304', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(58, 'bp', 'reguler', NULL, 'DIAN TRI PRATIWI', 'SINARMAS INSURANCE', '2026-06-22', 'IA05/26/000135', 1453829.00, 0.00, 1432770.00, 0.00, 0.00, '2026-08-01', 'KT05/26/000129', 21059.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2713KHB', NULL, 'ASURANSI', 'PK05/26/000302', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(59, 'bp', 'reguler', NULL, 'INDRA PURNAMA QQ FAUZIA RAHMIYATI YAZID', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-06-22', 'IA05/26/000139', 418914.00, 0.00, 300000.00, 0.00, 0.00, '2026-07-03', 'KT05/26/000129', 118914.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1246ROI', NULL, 'ASURANSI', 'PK05/26/000301', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(60, 'bp', 'reguler', NULL, 'RAHMAT RANGGONANG ANWAR', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-06-22', 'IA05/26/000129', 849150.00, 0.00, 300000.00, 0.00, 0.00, '2026-07-22', 'BT05/26/000289', 549150.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2575KRZ', NULL, 'ASURANSI', 'PK05/26/000299', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(61, 'bp', 'reguler', NULL, 'RAHMAT RANGGONANG ANWAR', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-06-22', 'IA05/26/000128', 4616456.00, 0.00, 4557714.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000311', 58742.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2575KRZ', NULL, 'ASURANSI', 'PK05/26/000298', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(62, 'bp', 'reguler', NULL, 'MUHAMAD ARI MUKTI', NULL, '2026-06-20', 'II05/26/000020', 396270.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 396270.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B198MTG', NULL, 'INTERNAL', 'PK05/26/000296', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(63, 'bp', 'reguler', NULL, 'WINANTO', 'BCA INSURANCE', '2026-06-20', 'IA05/26/000126', 5321340.00, 0.00, 5225460.00, 0.00, 0.00, '2026-08-01', 'KT05/26/000140', 95880.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1784PAK', NULL, 'ASURANSI', 'PK05/26/000295', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(64, 'bp', 'reguler', NULL, 'INDRA PURNAMA QQ FAUZIA RAHMIYATI YAZID', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-06-19', 'IA05/26/000131', 905760.00, 0.00, 300000.00, 0.00, 0.00, '2026-07-03', 'KT05/26/000129', 605760.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1246ROI', NULL, 'ASURANSI', 'PK05/26/000293', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(65, 'bp', 'reguler', NULL, 'MUHAMMAD HAFIDZ HASAN', 'OONA INSURANCE', '2026-06-19', 'IA05/26/000125', 905760.00, 0.00, 300000.00, 0.00, 0.00, '2026-07-07', 'BT05/26/000280', 605760.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1611NZJ', NULL, 'ASURANSI', 'PK05/26/000290', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(66, 'bp', 'reguler', NULL, 'ALEXANDER SABAR QQ SATRIANY PARERUNG', 'OONA INSURANCE', '2026-06-17', 'IC05/26/000173', 300000.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 300000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1902DYA', NULL, 'REGULER', 'PK05/26/000288', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(67, 'bp', 'reguler', NULL, 'IGNATIUS WILSON S. GUNAWAN QQ PT. ARISTA RENTALINDO C.', 'RAKSA PRATIKARA INSURANCE', '2026-06-15', 'IA05/26/000123', 1792650.00, 0.00, 1760350.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000297', 32300.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1501TNV', NULL, 'ASURANSI', 'PK05/26/000287', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(68, 'bp', 'reguler', NULL, 'ROY CHUDDIN MUKHLIS', 'ASTRA BUANA INSURANCE', '2026-06-13', 'IA05/26/000124', 800551.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 800551.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F1848FBG', NULL, 'ASURANSI', 'PK05/26/000283', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(69, 'bp', 'reguler', NULL, 'DJOKO SUTRISNO', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-06-13', 'IA05/26/000130', 4515198.00, 0.00, 600000.00, 0.00, 0.00, '2026-07-07', 'BT05/26/000281', 3915198.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1857ABU', NULL, 'ASURANSI', 'PK05/26/000282', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(70, 'bp', 'reguler', NULL, 'IRFAN MAKMUR QQ GITA AYU ROSALINDA RATU SAPUTRI', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-06-12', 'IA05/26/000143', 3142404.00, 0.00, 900000.00, 0.00, 0.00, '2026-07-07', 'BT05/26/000272', 2242404.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2367KIV', NULL, 'ASURANSI', 'PK05/26/000281', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(71, 'bp', 'reguler', NULL, 'WARDI', 'SINARMAS INSURANCE', '2026-06-11', 'IA05/26/000127', 1012320.00, 0.00, 994080.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000306', 18240.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2504KRY', NULL, 'ASURANSI', 'PK05/26/000280', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(72, 'bp', 'reguler', NULL, 'ALFI FATMAYANI QQ SOAN PRADIPTA', 'RELIANCE INDONESIA INSURACE', '2026-06-11', 'IA05/26/000134', 2660670.00, 0.00, 2612730.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000314', 47940.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1629FAM', NULL, 'ASURANSI', 'PK05/26/000277', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(73, 'bp', 'reguler', NULL, 'OMEGA TRINUGRAHA', NULL, '2026-06-10', 'IC05/26/000182', 26137676.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 26137676.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S1181WQ', NULL, 'REGULER', 'PK05/26/000276', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(74, 'bp', 'reguler', NULL, 'ALEXANDER SABAR QQ SATRIANY PARERUNG', 'OONA INSURANCE', '2026-06-10', 'IA05/26/000136', 2042400.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2042400.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1902DYA', NULL, 'ASURANSI', 'PK05/26/000275', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(75, 'bp', 'reguler', NULL, 'KARTIKA ARI DEWANTI', 'KSK INSURANCE', '2026-06-10', 'IA05/26/000160', 7546646.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 7546646.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2109KOW', NULL, 'ASURANSI', 'PK05/26/000274', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(76, 'bp', 'reguler', NULL, 'SUGIANTO', NULL, '2026-06-06', 'IC05/26/000180', 5142075.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 5142075.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2428KKD', NULL, 'REGULER', 'PK05/26/000272', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(77, 'bp', 'reguler', NULL, 'DAVID DWI CAHYA', 'MEGA INSURANCE', '2026-06-06', 'IA05/26/000133', 4072704.00, 0.00, 600000.00, 0.00, 0.00, '2026-07-06', 'BT05/26/000264', 3472704.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2078FKU', NULL, 'ASURANSI', 'PK05/26/000271', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(78, 'bp', 'reguler', NULL, 'PT. ESTA PRIMA INVESTAMA', 'RAKSA PRATIKARA INSURANCE', '2026-05-30', 'IA05/26/000120', 1792650.00, 0.00, 1460350.00, 0.00, 0.00, '2026-07-06', 'BT05/26/000269', 332300.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1714YU', NULL, 'ASURANSI', 'PK05/26/000266', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(79, 'bp', 'reguler', NULL, 'ABI NELLY ZERUYA PASARIBU', NULL, '2026-05-30', 'IC05/26/000153', 2020900.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2020900.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'BP1976KA', NULL, 'REGULER', 'PK05/26/000265', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(80, 'bp', 'perusahaan', NULL, 'PT DUTA CENDANA ADIMANDIRI', NULL, '2026-05-26', 'II05/26/000017', 559440.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 559440.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2756KZY', NULL, 'INTERNAL', 'PK05/26/000262', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(81, 'bp', 'reguler', NULL, 'ANDI JOHANIS', 'ASTRA BUANA INSURANCE', '2026-05-26', 'IA05/26/000138', 11353375.00, 0.00, 2400000.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000316', 8953375.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2365KFA', NULL, 'ASURANSI', 'PK05/26/000259', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(82, 'bp', 'reguler', NULL, 'TATI ROHAYATI', NULL, '2026-05-25', 'IC05/26/000141', 1422540.00, 0.00, 1000000.00, 0.00, 0.00, '2026-06-03', 'KT05/26/000118', 422540.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2034KHC', NULL, 'REGULER', 'PK05/26/000258', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(83, 'bp', 'reguler', NULL, 'ANDRY LESMANA OKTAVIAN', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-05-21', 'IA05/26/000118', 4218985.00, 0.00, 4199513.00, 0.00, 0.00, '2026-08-01', 'KT05/26/000121', 19472.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2680KHA', NULL, 'ASURANSI', 'PK05/26/000256', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(84, 'bp', 'reguler', NULL, 'AULIA PARDAMEAN ARITONANG', NULL, '2026-05-18', 'IC05/26/000216', 995350.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 995350.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2384KYM', NULL, 'REGULER', 'PK05/26/000248', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(85, 'bp', 'reguler', NULL, 'DANAR RAHADIANTO', 'ASURANSI UMUM MONEEINSURE', '2026-05-18', 'IA05/26/000113', 3568400.00, 0.00, 3516890.00, 0.00, 0.00, '2026-07-08', 'BT05/26/000284', 51510.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2243KOH', NULL, 'ASURANSI', 'PK05/26/000244', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(86, 'bp', 'reguler', NULL, 'RADHWA ASMARANI NUR IBRAHIM', 'ASURANSI UMUM MONEEINSURE', '2026-05-15', 'IA05/26/000112', 3403055.00, 0.00, 3360540.00, 0.00, 0.00, '2026-07-08', 'KT05/26/000121', 42515.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2532KRV', NULL, 'ASURANSI', 'PK05/26/000240', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(87, 'bp', 'reguler', NULL, 'HERU', 'ASURANSI SUNDAY', '2026-05-07', 'IA05/26/000114', 5737570.00, 0.00, 5684730.00, 0.00, 0.00, '2026-07-22', 'KT05/26/000121', 52840.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2928KZK', NULL, 'ASURANSI', 'PK05/26/000235', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(88, 'bp', 'perusahaan', NULL, 'PT DUTA CENDANA ADIMANDIRI', 'PAN PACIFIC INSURANCE', '2026-05-07', 'IA05/26/000121', 6184251.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 6184251.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B8JNY', NULL, 'ASURANSI', 'PK05/26/000234', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(89, 'bp', 'reguler', NULL, 'CHRISTY', 'PAN PACIFIC INSURANCE', '2026-05-05', 'IA05/26/000100', 2728602.00, 0.00, 300000.00, 0.00, 0.00, '2026-05-22', 'BT05/26/000213', 2428602.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2626BEN', NULL, 'ASURANSI', 'PK05/26/000232', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(90, 'bp', 'reguler', NULL, 'ARIF TRI HANDOKO', 'PAN PACIFIC INSURANCE', '2026-05-05', 'IA05/26/000117', 4885110.00, 0.00, 900000.00, 0.00, 0.00, '2026-06-03', 'KT05/26/000118', 3985110.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1002HNI', NULL, 'ASURANSI', 'PK05/26/000231', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(91, 'bp', 'reguler', NULL, 'AMRULLAH HASAN', 'MPM INSURANCE', '2026-04-28', 'IA05/26/000096', 5621054.00, 0.00, 5520245.00, 0.00, 0.00, '2026-06-19', 'BT05/26/000246', 100809.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2178KRQ', NULL, 'ASURANSI', 'PK05/26/000224', '2026-08-19 12:29:03', '2026-08-19 12:29:08'),
(92, 'bp', 'reguler', NULL, 'IWAN SIHOTANG', 'ASURANSI UMUM MONEEINSURE', '2026-04-25', 'IC05/26/000111', 4500495.00, 0.00, 4419405.00, 0.00, 0.00, '2026-07-07', 'KT05/26/000104', 81090.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1806PZ', NULL, 'REGULER', 'PK05/26/000218', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(93, 'bp', 'reguler', NULL, 'WAHID HIMAWAN', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-04-24', 'IA05/26/000102', 3932065.00, 0.00, 3868733.00, 0.00, 0.00, '2026-07-22', 'KT05/26/000102', 63332.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2419KRQ', NULL, 'ASURANSI', 'PK05/26/000217', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(94, 'bp', 'reguler', NULL, 'VERONICA KASTILANI', NULL, '2026-04-23', 'II05/26/000013', 1488843.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1488843.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1477ZKT', NULL, 'INTERNAL', 'PK05/26/000215', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(95, 'bp', 'reguler', NULL, 'AYU PISANI', 'OONA INSURANCE', '2026-04-23', 'IA05/26/000081', 4193609.00, 0.00, 300000.00, 0.00, 0.00, '2026-05-06', 'BT05/26/000208', 3893609.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2297KIQ', NULL, 'ASURANSI', 'PK05/26/000214', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(96, 'bp', 'reguler', NULL, 'PT. MITRA TEKNO GLOBAL QQ ANDHIKA SARAH T', 'BCA INSURANCE', '2026-04-23', 'IC05/26/000124', 3503608.00, 0.00, 3470764.00, 0.00, 0.00, '2026-07-31', 'KT05/26/000102', 32844.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2123PIP', NULL, 'REGULER', 'PK05/26/000213', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(97, 'bp', 'reguler', NULL, 'MEIRISYA', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-04-22', 'IA05/26/000104', 8582708.00, 0.00, 8461665.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000298', 121043.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1500EIC', NULL, 'ASURANSI', 'PK05/26/000212', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(98, 'bp', 'reguler', NULL, 'RD MUHAMAD LUCKY', 'PT ASURANSI MAXIMUS GRAHA PERSADA', '2026-04-21', 'IA05/26/000098', 20051847.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 20051847.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F1165FBU', NULL, 'ASURANSI', 'PK05/26/000211', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(99, 'bp', 'reguler', NULL, 'PT BPR DPM KREDIT MANDIRI', 'HARTA AMAN PRATAMA', '2026-04-20', 'IA05/26/000089', 24963257.00, 0.00, 24732481.00, 0.00, 0.00, '2026-05-22', 'BT05/26/000229', 230776.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1708ZG', NULL, 'ASURANSI', 'PK05/26/000210', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(100, 'bp', 'perusahaan', NULL, 'PT. DUTA CENDANA ADIMANDIRI', 'PAN PACIFIC INSURANCE', '2026-04-20', 'IA05/26/000077', 6173584.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 6173584.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2319KIP', NULL, 'ASURANSI', 'PK05/26/000207', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(101, 'bp', 'reguler', NULL, 'MUHAMMAD IQBAL AR RAZY SUWARDI', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-04-18', 'IA05/26/000076', 7783457.00, 0.00, 7183457.00, 0.00, 0.00, '2026-08-03', 'KT05/26/000143', 600000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1891DYM', NULL, 'ASURANSI', 'PK05/26/000206', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(102, 'bp', 'reguler', NULL, 'SALSABILLA ARMELIA PUTRI', 'CAKRAWALA PROTEKSI INDONESIA INSURANCE', '2026-04-18', 'IA05/26/000068', 1379175.00, 0.00, 1354325.00, 0.00, 0.00, '2026-05-22', 'BT05/26/000227', 24850.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2506KRP', NULL, 'ASURANSI', 'PK05/26/000204', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(103, 'bp', 'reguler', NULL, 'HJ. ASNI SUTARNO', 'ASURANSI UMUM MONEEINSURE', '2026-04-18', 'IA05/26/000069', 1211454.00, 0.00, 1189626.00, 0.00, 0.00, '2026-07-07', 'KT05/26/000087', 21828.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1710TJT', NULL, 'ASURANSI', 'PK05/26/000203', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(104, 'bp', 'reguler', NULL, 'RONAL LEFOLENSA SIMANJUNTAK, SH QQ HELENA MARIANI BUTAR BUTAR', 'SINARMAS INSURANCE', '2026-04-17', 'IA05/26/000080', 1784025.00, 0.00, 1767825.00, 0.00, 0.00, '2026-07-06', 'BT05/26/000265', 16200.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2916KHA', NULL, 'ASURANSI', 'PK05/26/000202', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(105, 'bp', 'reguler', NULL, 'ZAINUDDIN M ALI', 'PAN PACIFIC INSURANCE', '2026-04-15', 'IA05/26/000073', 4129866.00, 0.00, 4055454.00, 0.00, 0.00, '2026-08-01', 'KT05/26/000097', 74412.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2974KRK', NULL, 'ASURANSI', 'PK05/26/000197', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(106, 'bp', 'perusahaan', NULL, 'PT INDOSIAR VISUAL MANDIRI', 'KSK INSURANCE', '2026-04-11', 'IA05/26/000115', 6905795.00, 0.00, 6845855.00, 0.00, 0.00, '2026-07-22', 'BT05/26/000288', 59940.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1895HZD', NULL, 'ASURANSI', 'PK05/26/000192', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(107, 'bp', 'reguler', NULL, 'TUTUT WIDYASTUTI', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-04-11', 'IA05/26/000072', 3460104.00, 0.00, 3438276.00, 0.00, 0.00, '2026-07-07', 'KT05/26/000087', 21828.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2717KRG', NULL, 'ASURANSI', 'PK05/26/000190', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(108, 'bp', 'perusahaan', NULL, 'PT INDOSIAR VISUAL MANDIRI', 'KSK INSURANCE', '2026-04-09', 'IA05/26/000140', 3026970.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 3026970.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1895HZD', NULL, 'ASURANSI', 'PK05/26/000186', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(109, 'bp', 'reguler', NULL, 'DEA AL ZHAHRA QQ UMI WIDYAYANTI', 'BCA INSURANCE', '2026-04-08', 'IA05/26/000097', 3937920.00, 0.00, 3884472.00, 0.00, 0.00, '2026-07-31', 'BT05/26/000292', 53448.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2937KRQ', NULL, 'ASURANSI', 'PK05/26/000183', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(110, 'bp', 'reguler', NULL, 'QALBI RABIULRIFQO HANDOYO', 'PAN PACIFIC INSURANCE', '2026-03-31', 'IA05/26/000078', 2319739.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2319739.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2288KRR', NULL, 'ASURANSI', 'PK05/26/000177', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(111, 'bp', 'reguler', NULL, 'SAFITRI', NULL, '2026-03-31', 'IC05/26/000093', 355200.00, 0.00, 354800.00, 0.00, 0.00, '2026-04-20', 'BT05/26/000175', 400.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1037KOP', NULL, 'REGULER', 'PK05/26/000174', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(112, 'bp', 'reguler', NULL, 'MUHAMMAD HAFIDZ HASAN', 'OONA INSURANCE', '2026-03-31', 'IA05/26/000064', 852480.00, 0.00, 849408.00, 0.00, 0.00, '2026-05-22', 'BT05/26/000223', 3072.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1611NZJ', NULL, 'ASURANSI', 'PK05/26/000173', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(113, 'bp', 'reguler', NULL, 'DINTA JUNITA QQ ACEP SURAMA', 'PAN PACIFIC INSURANCE', '2026-03-13', 'IA05/26/000060', 5922072.00, 0.00, 900000.00, 0.00, 0.00, '2026-04-28', 'KT05/26/000087', 5022072.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2939FOA', NULL, 'ASURANSI', 'PK05/26/000154', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(114, 'bp', 'reguler', NULL, 'RISNA', NULL, '2026-03-13', 'IC05/26/000078', 1388610.00, 0.00, 1383610.00, 0.00, 0.00, '2026-03-26', 'BT05/26/000129', 5000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'A1195NA', NULL, 'REGULER', 'PK05/26/000152', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(115, 'bp', 'reguler', NULL, 'KARINA ROSELIN, SE', 'BCA INSURANCE', '2026-03-13', 'IA05/26/000079', 1005569.00, 0.00, 998768.00, 0.00, 0.00, '2026-06-19', 'BT05/26/000255', 6801.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2410KHA', NULL, 'ASURANSI', 'PK05/26/000151', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(116, 'bp', 'reguler', NULL, 'ANGELINE', 'ASURANSI SUNDAY', '2026-03-13', 'IA05/26/000055', 2235762.00, 0.00, 2195478.00, 0.00, 0.00, '2026-05-22', 'KT05/26/000064', 40284.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1041CZT', NULL, 'ASURANSI', 'PK05/26/000150', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(117, 'bp', 'reguler', NULL, 'ENCE SALYA SETIADI', 'CAKRAWALA PROTEKSI INDONESIA INSURANCE', '2026-03-13', 'IA05/26/000054', 4224355.00, 0.00, 4148241.00, 0.00, 0.00, '2026-05-22', 'BT05/26/000212', 76114.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2365FON', NULL, 'ASURANSI', 'PK05/26/000148', '2026-08-19 12:29:03', '2026-08-19 12:29:09'),
(118, 'bp', 'perusahaan', NULL, 'PT. DUTA CENDANA ADIMANDIRI - JATIASIH', 'PAN PACIFIC INSURANCE', '2026-03-12', 'IA05/26/000056', 9919735.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 9919735.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2655KRP', NULL, 'ASURANSI', 'PK05/26/000144', '2026-08-19 12:29:03', '2026-08-19 12:29:03'),
(119, 'bp', 'reguler', NULL, 'AGUS BASRI L', 'ASTRA BUANA INSURANCE', '2026-03-12', 'IA05/26/000108', 12039185.00, 0.00, 1800000.00, 0.00, 0.00, '2026-06-19', 'BT05/26/000244', 10239185.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1250CMY', NULL, 'ASURANSI', 'PK05/26/000143', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(120, 'bp', 'reguler', NULL, 'ARI RAHMAT FIRDAUS', 'OONA INSURANCE', '2026-03-11', 'IA05/26/000085', 1193472.00, 0.00, 889171.00, 0.00, 0.00, '2026-07-07', 'BT05/26/000279', 304301.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2004KRY', NULL, 'ASURANSI', 'PK05/26/000141', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(121, 'bp', 'reguler', NULL, 'WAHID HIMAWAN', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-03-11', 'IA05/26/000090', 39721408.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 39721408.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2419KRQ', NULL, 'ASURANSI', 'PK05/26/000138', '2026-08-19 12:29:04', '2026-08-19 12:29:04'),
(122, 'bp', 'reguler', NULL, 'YUZVIRA NASRI', NULL, '2026-03-11', 'IC05/26/000092', 14918400.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 14918400.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'BG1TE', NULL, 'REGULER', 'PK05/26/000136', '2026-08-19 12:29:04', '2026-08-19 12:29:04'),
(123, 'bp', 'reguler', NULL, 'DAMERIA MANURUNG QQ ROBERT NAPITUPULU', 'OONA INSURANCE', '2026-03-09', 'IA05/26/000050', 3608832.00, 0.00, 3543808.00, 0.00, 0.00, '2026-04-27', 'BT05/26/000185', 65024.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1714KNS', NULL, 'ASURANSI', 'PK05/26/000134', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(124, 'bp', 'reguler', NULL, 'OFAN NAOFAL', 'CAKRAWALA PROTEKSI INDONESIA INSURANCE', '2026-03-05', 'IA05/26/000057', 5460506.00, 0.00, 5432523.00, 0.00, 0.00, '2026-05-22', 'BT05/26/000222', 27983.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1643DYA', NULL, 'ASURANSI', 'PK05/26/000126', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(125, 'bp', 'reguler', NULL, 'ARY MULIANSYAH', 'MPM INSURANCE', '2026-03-02', 'IA05/26/000049', 2066265.00, 0.00, 2029035.00, 0.00, 0.00, '2026-07-06', 'BT05/26/000258', 37230.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2409KRQ', NULL, 'ASURANSI', 'PK05/26/000122', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(126, 'bp', 'reguler', NULL, 'YUDHI PRASETYA', 'ZURICH INSURANCE', '2026-02-26', 'IA05/26/000106', 13412372.00, 0.00, 12512372.00, 0.00, 0.00, '2026-08-03', 'KT05/26/000143', 900000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1996ROZ', NULL, 'ASURANSI', 'PK05/26/000118', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(127, 'bp', 'reguler', NULL, 'PATRICK QQ YOVITA DESIANI, S.SI', 'RAKSA PRATIKARA INSURANCE', '2026-02-26', 'IA05/26/000082', 7178377.00, 0.00, 6171022.00, 0.00, 0.00, '2026-06-19', 'BT05/26/000250', 1007355.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2672SII', NULL, 'ASURANSI', 'PK05/26/000117', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(128, 'bp', 'reguler', NULL, 'YUZVIRA NASRI', NULL, '2026-02-25', 'IC05/26/000054', 14918400.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 14918400.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'BG8432DP', NULL, 'REGULER', 'PK05/26/000114', '2026-08-19 12:29:04', '2026-08-19 12:29:04'),
(129, 'bp', 'reguler', NULL, 'YODA ANGGARA', 'ZURICH INSURANCE', '2026-02-24', 'IA05/26/000110', 7662276.00, 0.00, 7546187.00, 0.00, 0.00, '2026-07-22', 'BT05/26/000287', 116089.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1795FCA', NULL, 'ASURANSI', 'PK05/26/000109', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(130, 'bp', 'reguler', NULL, 'CLARA MIA MARGARETHA T', 'BCA INSURANCE', '2026-02-24', 'IA05/26/000094', 3697439.00, 0.00, 2739298.00, 0.00, 0.00, '2026-07-07', 'BT05/26/000275', 958141.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2294PII', NULL, 'ASURANSI', 'PK05/26/000108', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(131, 'bp', 'reguler', NULL, 'AGUS SUSANTO / KAMELIA', NULL, '2026-02-20', 'II05/26/000007', 113220.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 113220.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F1175LA ', NULL, 'INTERNAL', 'PK05/26/000104', '2026-08-19 12:29:04', '2026-08-19 12:29:04'),
(132, 'bp', 'reguler', NULL, 'ADE REZKI SPADANA', 'SOMPO INSURANCE INDONESIA INSURANCE', '2026-02-13', 'IA05/26/000026', 1391904.00, 0.00, 1370392.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000306', 21512.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2233FOS', NULL, 'ASURANSI', 'PK05/26/000101', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(133, 'bp', 'reguler', NULL, 'H.ABDUL RAZAK', 'MEGA INSURANCE', '2026-02-13', 'IA05/26/000093', 3155354.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 3155354.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1046KJT', NULL, 'ASURANSI', 'PK05/26/000100', '2026-08-19 12:29:04', '2026-08-19 12:29:04'),
(134, 'bp', 'reguler', NULL, 'CHANDRA SIDIK', NULL, '2026-02-13', 'IC05/26/000049', 909090.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 909090.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F1383MV', NULL, 'REGULER', 'PK05/26/000099', '2026-08-19 12:29:04', '2026-08-19 12:29:04'),
(135, 'bp', 'reguler', NULL, 'PT ANMAKA UTAMA GROUP', 'BCA INSURANCE', '2026-02-13', 'IA05/26/000047', 1301655.00, 0.00, 1263705.00, 0.00, 0.00, '2026-07-06', 'BT05/26/000259', 37950.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2448KOH', NULL, 'ASURANSI', 'PK05/26/000097', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(136, 'bp', 'reguler', NULL, 'FRANS', 'BCA INSURANCE', '2026-02-12', 'IA05/26/000095', 3664374.00, 0.00, 3025614.00, 0.00, 0.00, '2026-07-07', 'BT05/26/000274', 638760.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1375FBU', NULL, 'ASURANSI', 'PK05/26/000095', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(137, 'bp', 'reguler', NULL, 'ETHA SITI AISYAH HASINAH', 'BCA INSURANCE', '2026-02-12', 'IA05/26/000043', 2075700.00, 0.00, 2038300.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000307', 37400.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1282EIB', NULL, 'ASURANSI', 'PK05/26/000094', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(138, 'bp', 'reguler', NULL, 'MAX SUNGKAR QQ DITO CAHYO ARGIATAMA', 'ASTRA BUANA INSURANCE', '2026-02-11', 'IA05/26/000048', 1093751.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1093751.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1674WZJ', NULL, 'ASURANSI', 'PK05/26/000090', '2026-08-19 12:29:04', '2026-08-19 12:29:04'),
(139, 'bp', 'reguler', NULL, 'FARLY RACHMATYA PUTRA', 'PAN PACIFIC INSURANCE', '2026-02-06', 'IA05/26/000062', 36759751.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 36759751.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F1610ACA', NULL, 'ASURANSI', 'PK05/26/000086', '2026-08-19 12:29:04', '2026-08-19 12:29:04'),
(140, 'bp', 'reguler', NULL, 'JODDY CHRISTYAWAN QQ TYSAN DEBORA ANGELINE SIHOMBING', 'BCA INSURANCE', '2026-02-05', 'IA05/26/000051', 7293311.00, 0.00, 7192943.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000305', 100368.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2706KRN', NULL, 'ASURANSI', 'PK05/26/000085', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(141, 'bp', 'reguler', NULL, 'R. ACHMAD CHAIDIR W QQ SYAMSURIZAL', 'TAP INSURANCE / PT ASURANSI UNTUK SEMUA ( TAP )', '2026-02-05', 'IA05/26/000044', 1761700.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1761700.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1536DFK', NULL, 'ASURANSI', 'PK05/26/000084', '2026-08-19 12:29:04', '2026-08-19 12:29:04'),
(142, 'bp', 'reguler', NULL, 'AHMAD RUSYDI/SURATNO', 'MEGA INSURANCE', '2026-02-04', 'IA05/26/000119', 16070410.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 16070410.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1774ERV', NULL, 'ASURANSI', 'PK05/26/000083', '2026-08-19 12:29:04', '2026-08-19 12:29:04'),
(143, 'bp', 'reguler', NULL, 'PT. ESTA PRIMA INVESTAMA', 'RAKSA PRATIKARA INSURANCE', '2026-02-03', 'IA05/26/000028', 7642350.00, 0.00, 6304650.00, 0.00, 0.00, '2026-06-02', 'BT05/26/000234', 1337700.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2STA', NULL, 'ASURANSI', 'PK05/26/000080', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(144, 'bp', 'reguler', NULL, 'PT TANIKARYA MULTI SARANA', 'TAP INSURANCE / PT ASURANSI UNTUK SEMUA ( TAP )', '2026-01-27', 'IA05/26/000101', 3208580.00, 0.00, 400000.00, 0.00, 0.00, '2026-05-21', 'KT05/26/000102', 2808580.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2652SIE', NULL, 'ASURANSI', 'PK05/26/000064', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(145, 'bp', 'reguler', NULL, 'PT. ESTA PRIMA INVESTAMA', 'RAKSA PRATIKARA INSURANCE', '2026-01-23', 'IA05/26/000018', 4151400.00, 0.00, 2876600.00, 0.00, 0.00, '2026-02-22', 'BT05/26/000093', 1274800.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1713YU', NULL, 'ASURANSI', 'PK05/26/000058', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(146, 'bp', 'reguler', NULL, 'SUPRIADI QQ PUTTY RAHMAWATI, SE', 'PAN PACIFIC INSURANCE', '2026-01-22', 'IA05/26/000013', 1692639.00, 0.00, 1392639.00, 0.00, 0.00, '2026-08-03', 'KT05/26/000143', 300000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'A1580CI', NULL, 'ASURANSI', 'PK05/26/000056', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(147, 'bp', 'reguler', NULL, 'DANILAST', 'ZURICH INSURANCE', '2026-01-19', 'IA05/26/000029', 7732555.00, 0.00, 7432555.00, 0.00, 0.00, '2026-08-03', 'KT05/26/000143', 300000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1997HZA', NULL, 'ASURANSI', 'PK05/26/000049', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(148, 'bp', 'perusahaan', NULL, 'BEN CONSULTING', 'MPM INSURANCE', '2026-01-15', 'IA05/26/000011', 8135144.00, 0.00, 8034607.00, 0.00, 0.00, '2026-03-17', 'BT05/26/000121', 100537.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1590DYD', NULL, 'ASURANSI', 'PK05/26/000044', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(149, 'bp', 'reguler', NULL, 'SOERYA NINGTIYAS ARIDANIK QQ FLAVIO ZAVIERA', 'BCA INSURANCE', '2026-01-15', 'IA05/26/000074', 1217115.00, 0.00, 880185.00, 0.00, 0.00, '2026-07-07', 'BT05/26/000276', 336930.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1239TNW', NULL, 'ASURANSI', 'PK05/26/000043', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(150, 'bp', 'reguler', NULL, 'PT. ITOCHU INDONESIA', 'TOKIO MARINE INSURANCE', '2026-01-12', 'IA05/26/000006', 2111475.00, 0.00, 2089375.00, 0.00, 0.00, '2026-02-15', 'BT05/26/000065', 22100.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2313PZY', NULL, 'ASURANSI', 'PK05/26/000030', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(151, 'bp', 'perusahaan', NULL, 'ARISTA ELEKTRIKA INDONESIA', NULL, '2026-01-09', 'IC05/26/000014', 707070.00, 0.00, 697370.00, 0.00, 0.00, '2026-03-26', 'BT05/26/000147', 9700.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1272UDV', NULL, 'REGULER', 'PK05/26/000026', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(152, 'bp', 'reguler', NULL, 'MUHAMAD DENNY SAPUTRA', 'MEGA INSURANCE', '2026-01-09', 'IA05/26/000037', 32544031.00, 0.00, 1500000.00, 0.00, 0.00, '2026-04-20', 'BT05/26/000170', 31044031.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'BE1377FG', NULL, 'ASURANSI', 'PK05/26/000025', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(153, 'bp', 'reguler', NULL, 'RADYOKO HERU RAHBANU', 'BCA INSURANCE', '2026-01-08', 'IA05/26/000086', 1368075.00, 0.00, 1043425.00, 0.00, 0.00, '2026-06-19', 'BT05/26/000248', 324650.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2912KRC', NULL, 'ASURANSI', 'PK05/26/000021', '2026-08-19 12:29:04', '2026-08-19 12:29:09');
INSERT INTO `piutangs` (`id`, `branch`, `tipe_konsumen`, `perusahaan_id`, `nama_konsumen`, `nama_asuransi`, `tgl_bukti`, `no_bukti`, `saldo_awal`, `debet`, `kredit`, `kredit_2`, `kredit_3`, `tgl_bukti_rek`, `no_bukti_rek`, `saldo_akhir`, `keterangan`, `tgl_bukti_rek_2`, `no_bukti_rek_2`, `keterangan_2`, `tgl_bukti_rek_3`, `no_bukti_rek_3`, `keterangan_3`, `no_polisi`, `no_polis`, `spk_type`, `no_spk`, `created_at`, `updated_at`) VALUES
(154, 'bp', 'reguler', NULL, 'ISMAR RASOKI HASIBUAN', 'MEGA INSURANCE', '2026-01-07', 'IA05/26/000038', 10568306.00, 0.00, 10481085.00, 0.00, 0.00, '2026-06-02', 'BT05/26/000236', 87221.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1949WIT', NULL, 'ASURANSI', 'PK05/26/000019', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(155, 'bp', 'reguler', NULL, 'PT. MITRA TEKNO GLOBAL QQ ANDHIKA SARAH T', 'BCA INSURANCE', '2026-01-06', 'IA05/26/000052', 32674939.00, 0.00, 32521089.00, 0.00, 0.00, '2026-05-22', 'BT05/26/000225', 153850.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2123PIP', NULL, 'ASURANSI', 'PK05/26/000012', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(156, 'bp', 'reguler', NULL, 'CV. ARSI LABORA UTAMA', 'CAKRAWALA PROTEKSI INDONESIA INSURANCE', '2026-01-05', 'IA05/26/000002', 4691138.00, 0.00, 4391138.00, 0.00, 0.00, '2026-05-21', 'KT05/26/000101', 300000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2090KRP', NULL, 'ASURANSI', 'PK05/26/000011', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(157, 'bp', 'reguler', NULL, 'IR. JULI EDI SEBAYANG QQ YEMIMA RAHMANI SEBAYANG', 'BCA INSURANCE', '2026-01-05', 'IA05/26/000046', 2122875.00, 0.00, 1784625.00, 0.00, 0.00, '2026-07-07', 'BT05/26/000271', 338250.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2628KRO', NULL, 'ASURANSI', 'PK05/26/000010', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(158, 'bp', 'reguler', NULL, 'YUDI MAHENDRA S. SOS', 'ZURICH INSURANCE', '2026-01-03', 'IA05/26/000019', 4329000.00, 0.00, 3729000.00, 0.00, 0.00, '2026-06-04', 'KT05/26/000125', 600000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2819KZL', NULL, 'ASURANSI', 'PK05/26/000003', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(159, 'bp', 'perusahaan', NULL, 'PT. SUMBER BARU ANEKA MOBIL', NULL, '2025-12-30', 'IC05/25/000355', 754800.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 754800.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1567PDL', NULL, 'REGULER', 'PK05/25/001112', '2026-08-19 12:29:04', '2026-08-19 12:29:04'),
(160, 'bp', 'reguler', NULL, 'PT. ESTA PRIMA INVESTAMA', 'RAKSA PRATIKARA INSURANCE', '2025-12-26', 'IA05/26/000017', 7908750.00, 0.00, 5966250.00, 0.00, 0.00, '2026-02-22', 'BT05/26/000093', 1942500.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1712ZB', NULL, 'ASURANSI', 'PK05/25/001108', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(161, 'bp', 'reguler', NULL, 'PT. ESTA MULTI USAHA', 'RAKSA PRATIKARA INSURANCE', '2025-12-24', 'IA05/26/000016', 2736150.00, 0.00, 2686850.00, 0.00, 0.00, '2026-04-08', 'KT05/26/000071', 49300.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1816ZC', NULL, 'ASURANSI', 'PK05/25/001101', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(162, 'bp', 'reguler', NULL, 'MUHAMMAD IKHSAN MOKOAGOW', 'BCA INSURANCE', '2025-12-19', 'IA05/26/000122', 16903049.00, 0.00, 16523677.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000307', 379372.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1056HZH', NULL, 'ASURANSI', 'PK05/25/001096', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(163, 'bp', 'reguler', NULL, 'YOHANES KRISTIANTO,ST', 'KSK INSURANCE', '2025-12-17', 'IA05/26/000027', 8058094.00, 0.00, 7074322.00, 0.00, 0.00, '2026-07-06', 'BT05/26/000268', 983772.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1554FBL', NULL, 'ASURANSI', 'PK05/25/001094', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(164, 'bp', 'reguler', NULL, 'JOHANES APRIL CANDRA', 'MSIG INSURANCE', '2025-12-17', 'IA05/25/000283', 2009655.00, 0.00, 1973445.00, 0.00, 0.00, '2026-01-26', 'BT05/26/000017', 36210.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B132TYR', NULL, 'ASURANSI', 'PK05/25/001093', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(165, 'bp', 'reguler', NULL, 'ISKANDAR', 'ZURICH INSURANCE', '2025-12-16', 'IA05/26/000040', 1858140.00, 0.00, 1258140.00, 0.00, 0.00, '2026-06-04', 'KT05/26/000125', 600000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1283FCA', NULL, 'ASURANSI', 'PK05/25/001092', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(166, 'bp', 'reguler', NULL, 'MARIO EZRA PALENEWEN', 'SINARMAS INSURANCE', '2025-12-16', 'IA05/25/000297', 6197796.00, 0.00, 6086124.00, 0.00, 0.00, '2026-02-15', 'BT05/26/000064', 111672.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1929RZQ', NULL, 'ASURANSI', 'PK05/25/001091', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(167, 'bp', 'perusahaan', NULL, 'PT. SUMBER BARU ANEKA MOBIL', NULL, '2025-12-11', 'IC05/25/000340', 726735.00, 0.00, 716365.00, 0.00, 0.00, '2026-02-03', 'BT05/26/000052', 10370.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1776DZZ', NULL, 'REGULER', 'PK05/25/001082', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(168, 'bp', 'reguler', NULL, 'ANTONIUS EKO ANDRIYANTO', 'OONA INSURANCE', '2025-12-09', 'IA05/25/000295', 5677980.00, 0.00, 5632220.00, 0.00, 0.00, '2026-02-19', 'BT05/26/000082', 45760.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2160PKW', NULL, 'ASURANSI', 'PK05/25/001075', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(169, 'bp', 'reguler', NULL, 'BRILLIAN DWI HARIYANTO QQ PT ARISTA RENTALINDO CEMERLANG', 'OONA INSURANCE', '2025-12-08', 'IC05/26/000147', 1287600.00, 0.00, 687600.00, 0.00, 0.00, '2026-06-23', 'KT05/26/000133', 600000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1363TDO', NULL, 'REGULER', 'PK05/25/001071', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(170, 'bp', 'perusahaan', NULL, 'PT. SUMBER BARU ANEKA MOBIL', NULL, '2025-12-02', 'IC05/26/000053', 4720672.00, 0.00, 4600000.00, 0.00, 0.00, '2026-04-30', 'KT05/26/000092', 120672.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1567PDL', NULL, 'REGULER', 'PK05/25/001066', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(171, 'bp', 'reguler', NULL, 'YUNUS PURWONO QQ YOGI PRASTYO', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-11-29', 'IA05/26/000116', 1983084.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1983084.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2258KRD', NULL, 'ASURANSI', 'PK05/25/001058', '2026-08-19 12:29:04', '2026-08-19 12:29:04'),
(172, 'bp', 'reguler', NULL, 'DEAN YULINDRA AFFANDI QQ NOFIKHA HANIM NASUTION', 'BCA INSURANCE', '2025-11-28', 'IC05/26/000123', 4680900.00, 0.00, 4318000.00, 0.00, 0.00, '2026-07-31', 'BT05/26/000291', 362900.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2444SJL', NULL, 'REGULER', 'PK05/25/001055', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(173, 'bp', 'reguler', NULL, 'ACHMAD BENYAMIN DANIEL QQ MUH ALIEF FAISAL A.', 'BCA INSURANCE', '2025-11-27', 'IA05/25/000277', 1368075.00, 0.00, 1343425.00, 0.00, 0.00, '2026-01-09', 'BT05/26/000006', 24650.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2070KZP', NULL, 'ASURANSI', 'PK05/25/001052', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(174, 'bp', 'reguler', NULL, 'AGRA BARI PETRANTO QQ WIDYA APRILINA', 'BCA INSURANCE', '2025-11-26', 'IA05/25/000273', 1112940.00, 0.00, 1094240.00, 0.00, 0.00, '2026-01-09', 'BT05/26/000007', 18700.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1557DOB', NULL, 'ASURANSI', 'PK05/25/001045', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(175, 'bp', 'reguler', NULL, 'GATOT SOETIKNO QQ AZKA KANAHAYA GATA', 'OONA INSURANCE', '2025-11-25', 'IC05/26/000145', 1021200.00, 0.00, 421200.00, 0.00, 0.00, '2026-06-23', 'KT05/26/000133', 600000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2010PIO', NULL, 'REGULER', 'PK05/25/001039', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(176, 'bp', 'reguler', NULL, 'JOHANES APRIL CANDRA', NULL, '2025-11-25', 'IC05/25/000322', 3434340.00, 0.00, 1934340.00, 0.00, 0.00, '2026-04-20', 'BT05/26/000174', 1500000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1207HFZ', NULL, 'REGULER', 'PK05/25/001034', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(177, 'bp', 'reguler', NULL, 'ARY MULIANSYAH', 'MPM INSURANCE', '2025-11-25', 'IA05/25/000271', 2230434.00, 0.00, 2190246.00, 0.00, 0.00, '2026-01-26', 'KT05/25/000142', 40188.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2409KRQ', NULL, 'ASURANSI', 'PK05/25/001032', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(178, 'bp', 'reguler', NULL, 'YUNI KARSINA', 'ASTRA BUANA INSURANCE', '2025-11-24', 'IC05/26/000050', 786300.00, 0.00, 486300.00, 0.00, 0.00, '2026-08-03', 'KT05/26/000143', 300000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1828VZK', NULL, 'REGULER', 'PK05/25/001029', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(179, 'bp', 'reguler', NULL, 'INDRIANI', 'KSK INSURANCE', '2025-11-20', 'IA05/25/000284', 5533302.00, 0.00, 4933302.00, 0.00, 0.00, '2026-03-31', 'KT05/26/000053', 600000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1285FBX', NULL, 'ASURANSI', 'PK05/25/001021', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(180, 'bp', 'reguler', NULL, 'ROHADI', 'CAKRAWALA PROTEKSI INDONESIA INSURANCE', '2025-11-20', 'IA05/25/000272', 13763259.00, 0.00, 13667653.00, 0.00, 0.00, '2026-05-21', 'KT05/26/000101', 95606.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2119KIV', NULL, 'ASURANSI', 'PK05/25/001020', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(181, 'bp', 'reguler', NULL, 'PT. PIM PHARMACEUTICALS QQ HENDRA EKA SETIYAWAN', 'TOKIO MARINE INSURANCE', '2025-11-14', 'IA05/25/000267', 7104555.00, 0.00, 6976545.00, 0.00, 0.00, '2026-01-09', 'BT05/26/000002', 128010.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'W1040VA', NULL, 'ASURANSI', 'PK05/25/001012', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(182, 'bp', 'reguler', NULL, 'PT. PIM PHARMACEUTICALS QQ HENDRA EKA SETIYAWAN', 'TOKIO MARINE INSURANCE', '2025-11-12', 'IA05/25/000266', 6708285.00, 0.00, 6587415.00, 0.00, 0.00, '2026-01-09', 'KT05/25/000150', 120870.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'W1040VA', NULL, 'ASURANSI', 'PK05/25/001010', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(183, 'bp', 'reguler', NULL, 'OMEGA TRINUGRAHA', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-11-12', 'IA05/26/000103', 5105239.00, 0.00, 4805239.00, 0.00, 0.00, '2026-08-03', 'KT05/26/000143', 300000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2046KRH', NULL, 'ASURANSI', 'PK05/25/001009', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(184, 'bp', 'reguler', NULL, 'DIAN SALMI', 'MPM INSURANCE', '2025-11-11', 'IA05/25/000289', 4301183.00, 0.00, 4269496.00, 0.00, 0.00, '2026-02-19', 'KT05/26/000017', 31687.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2303KRF', NULL, 'ASURANSI', 'PK05/25/001003', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(185, 'bp', 'reguler', NULL, 'YOKI SUPRAYOGI', 'PT BADAN ASURANSI CANDI UTAMA', '2025-11-05', 'IA05/25/000254', 2344140.00, 0.00, 2302571.00, 0.00, 0.00, '2026-04-20', 'BT05/26/000169', 41569.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2667PIJ', NULL, 'ASURANSI', 'PK05/25/000994', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(186, 'bp', 'reguler', NULL, 'ARDIAN NOVEDIANSYAH', 'PAN PACIFIC INSURANCE', '2025-11-04', 'IA05/25/000253', 1660560.00, 0.00, 1630640.00, 0.00, 0.00, '2025-12-27', 'KT05/25/000123', 29920.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1429SDW', NULL, 'ASURANSI', 'PK05/25/000991', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(187, 'bp', 'perusahaan', NULL, 'PT. MEKANIKA DIGITAL PRATAMA', 'MEGA INSURANCE', '2025-10-30', 'IA05/26/000039', 13575724.00, 0.00, 13170425.00, 0.00, 0.00, '2026-04-27', 'BT05/26/000187', 405299.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2200KYL', NULL, 'ASURANSI', 'PK05/25/000980', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(188, 'bp', 'perusahaan', NULL, 'TJANDRA BUANA', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-10-29', 'IA05/26/000065', 15438701.00, 0.00, 900000.00, 0.00, 0.00, '2026-04-01', 'BT05/26/000160', 14538701.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B9413BVT', NULL, 'ASURANSI', 'PK05/25/000978', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(189, 'bp', 'reguler', NULL, 'GIANTI PRADIPTA', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-10-29', 'IA05/25/000238', 7642350.00, 0.00, 7504650.00, 0.00, 0.00, '2025-12-11', 'BT05/25/000670', 137700.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1834DZZ', NULL, 'ASURANSI', 'PK05/25/000977', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(190, 'bp', 'reguler', NULL, 'DIANA EKO WATI QQ SUWARNO', 'KOREAN BANK (KB) INSURANCE', '2025-10-28', 'IA05/25/000275', 24213396.00, 0.00, 24023147.00, 0.00, 0.00, '2026-01-09', 'BT05/26/000009', 190249.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1272ZKZ', NULL, 'ASURANSI', 'PK05/25/000976', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(191, 'bp', 'reguler', NULL, 'ABDUL KHAMID', 'PT ASURANSI MAXIMUS GRAHA PERSADA', '2025-10-28', 'IA05/25/000252', 3269017.00, 0.00, 3224305.00, 0.00, 0.00, '2026-02-03', 'BT05/26/000044', 44712.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2393KIV', NULL, 'ASURANSI', 'PK05/25/000975', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(192, 'bp', 'reguler', NULL, 'VINTA MARITO', 'MPM INSURANCE', '2025-10-27', 'IA05/25/000262', 36662129.00, 0.00, 36409169.00, 0.00, 0.00, '2026-01-14', 'KT05/25/000142', 252960.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2472KZJ', NULL, 'ASURANSI', 'PK05/25/000973', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(193, 'bp', 'reguler', NULL, 'GANANG FERMANA', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-10-25', 'IA05/25/000237', 2411010.00, 0.00, 2384490.00, 0.00, 0.00, '2025-12-17', 'KT05/25/000113', 26520.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1732RZQ', NULL, 'ASURANSI', 'PK05/25/000970', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(194, 'bp', 'reguler', NULL, 'SUSANA', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-10-25', 'IA05/25/000232', 5423235.00, 0.00, 5370365.00, 0.00, 0.00, '2025-12-11', 'BT05/25/000667', 52870.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1655HOK', NULL, 'ASURANSI', 'PK05/25/000968', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(195, 'bp', 'reguler', NULL, 'DINDA RADITYA', 'OONA INSURANCE', '2025-10-24', 'IA05/26/000091', 5994000.00, 0.00, 5672400.00, 0.00, 0.00, '2026-07-07', 'BT05/26/000278', 321600.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B18DXI', NULL, 'ASURANSI', 'PK05/25/000964', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(196, 'bp', 'reguler', NULL, 'PT. ITOCHU INDONESIA', 'TOKIO MARINE INSURANCE', '2025-10-24', 'IA05/25/000223', 1811520.00, 0.00, 1778880.00, 0.00, 0.00, '2025-12-03', 'BT05/25/000643', 32640.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2313PZY', NULL, 'ASURANSI', 'PK05/25/000963', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(197, 'bp', 'reguler', NULL, 'MELIA', 'OONA INSURANCE', '2025-10-22', 'IA05/25/000222', 799200.00, 0.00, 784800.00, 0.00, 0.00, '2025-12-17', 'BT05/25/000696', 14400.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1767FCE', NULL, 'ASURANSI', 'PK05/25/000960', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(198, 'bp', 'reguler', NULL, 'YANUARTI ARIF WIJAYA', 'SINARMAS INSURANCE', '2025-10-20', 'IA05/25/000225', 3596400.00, 0.00, 3531600.00, 0.00, 0.00, '2025-12-02', 'KT05/25/000113', 64800.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1349FBX', NULL, 'ASURANSI', 'PK05/25/000958', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(199, 'bp', 'reguler', NULL, 'DIAN ETNAWATI KANSIL', 'TOKIO MARINE INSURANCE', '2025-10-16', 'IA05/25/000265', 3595858.00, 0.00, 3551420.00, 0.00, 0.00, '2026-01-09', 'BT05/26/000003', 44438.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1493EZA', NULL, 'ASURANSI', 'PK05/25/000953', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(200, 'bp', 'reguler', NULL, 'DANAR RAHADIANTO', 'ASURANSI UMUM SEAINSURE', '2025-10-14', 'IA05/25/000244', 14605720.00, 0.00, 14370178.00, 0.00, 0.00, '2026-02-19', 'BT05/26/000083', 235542.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2243KOH', NULL, 'ASURANSI', 'PK05/25/000949', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(201, 'bp', 'reguler', NULL, 'ARIF TRI HANDOKO', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-10-13', 'IA05/25/000227', 2660670.00, 0.00, 2612730.00, 0.00, 0.00, '2025-12-17', 'BT05/25/000671', 47940.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'BP1287QC', NULL, 'ASURANSI', 'PK05/25/000946', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(202, 'bp', 'reguler', NULL, 'MARIYATI', 'KSK INSURANCE', '2025-10-13', 'IA05/25/000226', 3872124.00, 0.00, 3802356.00, 0.00, 0.00, '2025-12-11', 'BT05/25/000669', 69768.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2207KRL', NULL, 'ASURANSI', 'PK05/25/000945', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(203, 'bp', 'reguler', NULL, 'HARDONO SETIYO SAMBODO', 'PAN PACIFIC INSURANCE', '2025-10-06', 'IA05/25/000220', 2762568.00, 0.00, 2712792.00, 0.00, 0.00, '2025-12-03', 'KT05/25/000109', 49776.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1604RZT', NULL, 'ASURANSI', 'PK05/25/000934', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(204, 'bp', 'perusahaan', NULL, 'PT DUTA CENDANA ADIMANDIRI', 'PAN PACIFIC INSURANCE', '2025-10-06', 'IA05/25/000236', 1749249.00, 0.00, 1717731.00, 0.00, 0.00, '2026-03-06', 'KT05/26/000045', 31518.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1267KNP', NULL, 'ASURANSI', 'PK05/25/000932', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(205, 'bp', 'reguler', NULL, 'DIAN CHRISTY DYESTIANA', NULL, '2025-09-30', 'II05/25/000049', 2434230.00, 0.00, 2391099.00, 0.00, 0.00, '2025-12-03', 'KT05/25/000140', 43131.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1406WYT', NULL, 'INTERNAL', 'PK05/25/000926', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(206, 'bp', 'reguler', NULL, 'IRWANTO SIMARMATA QQ DITYA PUTRI PURNOMO', 'OONA INSURANCE', '2025-09-29', 'IA05/25/000250', 2727768.00, 0.00, 2723223.00, 0.00, 0.00, '2026-01-19', 'KT05/25/000126', 4545.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2765KRH', NULL, 'ASURANSI', 'PK05/25/000921', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(207, 'bp', 'reguler', NULL, 'HADI SULAIMAN', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-09-26', 'IA05/25/000234', 8000337.00, 0.00, 7892714.00, 0.00, 0.00, '2026-02-02', 'KT05/26/000012', 107623.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1411FBW', NULL, 'ASURANSI', 'PK05/25/000916', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(208, 'bp', 'reguler', NULL, 'DWI HASTA YANUAR PERWIRA', 'INTRA ASIA INSURANCE', '2025-09-25', 'IA05/25/000246', 39121892.00, 0.00, 39075183.00, 0.00, 0.00, '2026-03-04', 'KT05/25/000121', 46709.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2683KMX', NULL, 'ASURANSI', 'PK05/25/000912', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(209, 'bp', 'reguler', NULL, 'YANUARTI QQ SAEFUL GANI AFFANDI', 'MEGA INSURANCE', '2025-09-24', 'IA05/26/000092', 5487669.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 5487669.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'D1260ALT', NULL, 'ASURANSI', 'PK05/25/000909', '2026-08-19 12:29:04', '2026-08-19 12:29:04'),
(210, 'bp', 'reguler', NULL, 'INKOPPABRI QQ ANTOK PLATINI', 'OONA INSURANCE', '2025-09-24', 'IA05/25/000217', 8348940.00, 0.00, 8321484.00, 0.00, 0.00, '2026-02-03', 'KT05/25/000113', 27456.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2943BYJ', NULL, 'ASURANSI', 'PK05/25/000907', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(211, 'bp', 'perusahaan', NULL, 'PT. DUTA CENDANA ADIMANDIRI - JATIASIH', 'PAN PACIFIC INSURANCE', '2025-09-20', 'IA05/25/000215', 15422394.00, 0.00, 15176154.00, 0.00, 0.00, '2025-12-27', 'KT05/25/000129', 246240.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2709KZV', NULL, 'ASURANSI', 'PK05/25/000900', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(212, 'bp', 'perusahaan', NULL, 'PT. DUTA CENDANA ADIMANDIRI - HOLDING', 'PAN PACIFIC INSURANCE', '2025-09-17', 'IA05/25/000204', 4061514.00, 0.00, 3995634.00, 0.00, 0.00, '2025-11-17', 'KT05/25/000129', 65880.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2055KOT', NULL, 'ASURANSI', 'PK05/25/000897', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(213, 'bp', 'reguler', NULL, 'LUCKY SYAH PUTRA', 'MSIG INSURANCE', '2025-09-17', 'IA05/25/000201', 6806631.00, 0.00, 6708969.00, 0.00, 0.00, '2025-11-04', 'KT05/25/000108', 97662.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1336DOF', NULL, 'ASURANSI', 'PK05/25/000896', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(214, 'bp', 'perusahaan', NULL, 'INDAH ARYUNI PUSPITASARI', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-09-17', 'IA05/25/000198', 770139.00, 0.00, 765141.00, 0.00, 0.00, '2025-11-20', 'BT05/25/000622', 4998.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1109ZOF', NULL, 'ASURANSI', 'PK05/25/000894', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(215, 'bp', 'perusahaan', NULL, 'PT. DUTA CENDANA ADIMANDIRI - JATIASIH', 'PAN PACIFIC INSURANCE', '2025-09-16', 'IA05/25/000203', 8172678.00, 0.00, 8041804.00, 0.00, 0.00, '2025-11-17', 'KT05/25/000129', 130874.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2031KOT', NULL, 'ASURANSI', 'PK05/25/000893', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(216, 'bp', 'reguler', NULL, 'RAFAEL FALCON PERDANA QQ THOMSON SIHOMBING', 'PT BADAN ASURANSI CANDI UTAMA', '2025-09-15', 'IA05/25/000210', 6286943.00, 0.00, 6207190.00, 0.00, 0.00, '2025-11-20', 'BT05/25/000623', 79753.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2500KRI', NULL, 'ASURANSI', 'PK05/25/000887', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(217, 'bp', 'reguler', NULL, 'MUHAMMAD ASRORI', 'MEGA INSURANCE', '2025-09-13', 'IA05/25/000249', 6618429.00, 0.00, 6529870.00, 0.00, 0.00, '2026-04-08', 'KT05/26/000070', 88559.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1676EZY', NULL, 'ASURANSI', 'PK05/25/000884', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(218, 'bp', 'reguler', NULL, 'DR. DESTHI MINARISTY', 'PAN PACIFIC INSURANCE', '2025-09-11', 'IA05/25/000197', 4813171.00, 0.00, 4726447.00, 0.00, 0.00, '2025-11-04', 'BT05/25/000572', 86724.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2787KRJ', NULL, 'ASURANSI', 'PK05/25/000879', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(219, 'bp', 'reguler', NULL, 'HERU', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-09-11', 'IA05/25/000212', 7867369.00, 0.00, 7787309.00, 0.00, 0.00, '2025-11-18', 'KT05/25/000130', 80060.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2928KZK', NULL, 'ASURANSI', 'PK05/25/000878', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(220, 'bp', 'perusahaan', NULL, 'PT DUTA CENDANA MOBILINDO', 'PAN PACIFIC INSURANCE', '2025-09-11', 'IA05/25/000202', 2604060.00, 0.00, 2557140.00, 0.00, 0.00, '2025-11-05', 'KT05/25/000114', 46920.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2832UYE', NULL, 'ASURANSI', 'PK05/25/000875', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(221, 'bp', 'reguler', NULL, 'ARIF TRI HANDOKO', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-09-10', 'IA05/25/000199', 3623040.00, 0.00, 3557760.00, 0.00, 0.00, '2025-11-04', 'KT05/25/000108', 65280.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'BP1287QC', NULL, 'ASURANSI', 'PK05/25/000873', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(222, 'bp', 'perusahaan', NULL, 'PT. SUMBER BARU ANEKA MOBIL', NULL, '2025-09-08', 'IC05/25/000242', 1998000.00, 0.00, 1962000.00, 0.00, 0.00, '2025-11-17', 'KT05/25/000127', 36000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2533WFE', NULL, 'REGULER', 'PK05/25/000868', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(223, 'bp', 'reguler', NULL, 'PT OTS INTERNASIONAL QQ LISTIAWAN TRIKUSUMO', 'PAN PACIFIC INSURANCE', '2025-08-28', 'IA05/25/000179', 569430.00, 0.00, 559170.00, 0.00, 0.00, '2025-12-03', 'KT05/25/000121', 10260.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1257SDT', NULL, 'ASURANSI', 'PK05/25/000853', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(224, 'bp', 'reguler', NULL, 'HERU SETIAWAN', 'PAN PACIFIC INSURANCE', '2025-08-25', 'IA05/25/000205', 2045299.00, 0.00, 2028799.00, 0.00, 0.00, '2025-11-04', 'BT05/25/000590', 16500.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2836KZP', NULL, 'ASURANSI', 'PK05/25/000849', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(225, 'bp', 'reguler', NULL, 'INDRI ELISABETH', 'OONA INSURANCE', '2025-08-23', 'IA05/26/000083', 3367050.00, 0.00, 3358255.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000306', 8795.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2809KZQ', NULL, 'ASURANSI', 'PK05/25/000845', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(226, 'bp', 'perusahaan', NULL, 'KEVIN ARTHUR', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-08-18', 'IA05/25/000178', 2695699.00, 0.00, 2653378.00, 0.00, 0.00, '2025-10-01', 'BT05/25/000521', 42321.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2490KRF', NULL, 'ASURANSI', 'PK05/25/000838', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(227, 'bp', 'reguler', NULL, 'ARIF TRI HANDOKO', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-08-13', 'IA05/25/000208', 4337775.00, 0.00, 4314825.00, 0.00, 0.00, '2025-11-20', 'KT05/25/000130', 22950.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'BP1287QC', NULL, 'ASURANSI', 'PK05/25/000833', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(228, 'bp', 'reguler', NULL, 'DEDY PERMANDI, SE, MMDS.', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-08-13', 'IA05/25/000180', 4222584.00, 0.00, 3887813.00, 0.00, 0.00, '2025-10-01', 'BT05/25/000521', 334771.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2280KRQ', NULL, 'ASURANSI', 'PK05/25/000831', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(229, 'bp', 'reguler', NULL, 'YATMININGSIH', 'OONA INSURANCE', '2025-08-13', 'IA05/26/000084', 21818635.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 21818635.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B8678SIH', NULL, 'ASURANSI', 'PK05/25/000830', '2026-08-19 12:29:04', '2026-08-19 12:29:04'),
(230, 'bp', 'reguler', NULL, 'MAULANA DIO PRATAMAYUDHA', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-08-09', 'IA05/25/000181', 11861144.00, 0.00, 11647430.00, 0.00, 0.00, '2025-10-17', 'BT05/25/000543', 213714.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1033KMD', NULL, 'ASURANSI', 'PK05/25/000825', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(231, 'bp', 'reguler', NULL, 'MARIYATI', 'KSK INSURANCE', '2025-08-07', 'IA05/25/000176', 2840690.00, 0.00, 2789506.00, 0.00, 0.00, '2025-10-18', 'BT05/25/000554', 51184.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2207KRL', NULL, 'ASURANSI', 'PK05/25/000819', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(232, 'bp', 'reguler', NULL, 'HENDRI SAPUTRA', 'PT BADAN ASURANSI CANDI UTAMA', '2025-07-25', 'IA05/25/000163', 2483681.00, 0.00, 2446863.00, 0.00, 0.00, '2025-09-21', 'BT05/25/000489', 36818.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1278FCC', NULL, 'ASURANSI', 'PK05/25/000797', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(233, 'bp', 'reguler', NULL, 'MARTHA HAPSARI QQ STEVEN YANSEN', 'KSK INSURANCE', '2025-07-25', 'IA05/25/000159', 7060050.00, 0.00, 6938550.00, 0.00, 0.00, '2025-10-18', 'BT05/25/000553', 121500.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1873ROK', NULL, 'ASURANSI', 'PK05/25/000795', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(234, 'bp', 'perusahaan', NULL, 'WIDYOWATI SURYANINGTIYAS', 'BCA INSURANCE', '2025-07-19', 'IA05/25/000170', 5139570.00, 0.00, 4539570.00, 0.00, 0.00, '2025-12-04', 'KT05/25/000143', 600000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1803ZOB', NULL, 'ASURANSI', 'PK05/25/000788', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(235, 'bp', 'reguler', NULL, 'NASYWA LOUDY RESMANA', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-07-19', 'IA05/25/000151', 849150.00, 0.00, 833850.00, 0.00, 0.00, '2025-11-13', 'KT05/25/000126', 15300.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2061KRJ', NULL, 'ASURANSI', 'PK05/25/000785', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(236, 'bp', 'reguler', NULL, 'PT. ITOCHU INDONESIA', 'TOKIO MARINE INSURANCE', '2025-07-15', 'IA05/25/000193', 50354522.00, 0.00, 49957490.00, 0.00, 0.00, '2025-11-17', 'BT05/25/000605', 397032.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2313PZY', NULL, 'ASURANSI', 'PK05/25/000772', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(237, 'bp', 'reguler', NULL, 'MONICA LEONA CHRISANTYA', 'KSK INSURANCE', '2025-07-10', 'IA05/25/000148', 7578130.00, 0.00, 7441587.00, 0.00, 0.00, '2025-09-14', 'BT05/25/000476', 136543.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1114ROL', NULL, 'ASURANSI', 'PK05/25/000761', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(238, 'bp', 'perusahaan', NULL, 'PT. SUMBER BARU ANEKA MOBIL', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-06-25', 'IA05/25/000136', 5700654.00, 0.00, 5658426.00, 0.00, 0.00, '2025-11-04', 'BT05/25/000561', 42228.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1734DOX', NULL, 'ASURANSI', 'PK05/25/000733', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(239, 'bp', 'reguler', NULL, 'WIDYA TRI RAHMAWATI', 'PT ASURANSI MAXIMUS GRAHA PERSADA', '2025-06-24', 'IA05/25/000131', 10660917.00, 0.00, 10551442.00, 0.00, 0.00, '2025-09-14', 'BT05/25/000470', 109475.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2679KRH', NULL, 'ASURANSI', 'PK05/25/000728', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(240, 'bp', 'reguler', NULL, 'TANIA WAHYUNI', NULL, '2025-06-20', 'IC05/25/000152', 720000.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 720000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1646RZA', NULL, 'REGULER', 'PK05/25/000722', '2026-08-19 12:29:04', '2026-08-19 12:29:04'),
(241, 'bp', 'reguler', NULL, 'TRANDY TOPA ULI SILABAN', NULL, '2025-05-31', 'IC05/25/000136', 500000.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 500000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2075KRG', NULL, 'REGULER', 'PK05/25/000682', '2026-08-19 12:29:04', '2026-08-19 12:29:04'),
(242, 'bp', 'reguler', NULL, 'BILARDO LEO QQ RISKA FITRIANI', 'BCA INSURANCE', '2025-05-30', 'IA05/26/000107', 7177993.00, 0.00, 6527843.00, 0.00, 0.00, '2026-07-31', 'BT05/26/000290', 650150.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1907RZV', NULL, 'ASURANSI', 'PK05/25/000669', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(243, 'bp', 'reguler', NULL, 'TANISA KARIMA', 'OONA INSURANCE', '2025-05-30', 'IA05/25/000219', 6420690.00, 0.00, 6360210.00, 0.00, 0.00, '2026-02-22', 'KT05/25/000130', 60480.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2997KRL', NULL, 'ASURANSI', 'PK05/25/000666', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(244, 'bp', 'reguler', NULL, 'MUHAMMAD MUNIR RIFAI', NULL, '2025-05-24', 'IC05/25/000122', 849150.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 849150.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2483KKX', NULL, 'REGULER', 'PK05/25/000656', '2026-08-19 12:29:04', '2026-08-19 12:29:04'),
(245, 'bp', 'reguler', NULL, 'ZISCA ANGGITA PRAMESWARI', NULL, '2025-05-16', 'IC05/25/000131', 982499.00, 0.00, 482499.00, 0.00, 0.00, '2026-04-04', 'KT05/26/000064', 500000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1998ZKZ', NULL, 'REGULER', 'PK05/25/000648', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(246, 'bp', 'reguler', NULL, 'ANTONIUS EKO ANDRIYANTO', 'OONA INSURANCE', '2025-05-15', 'IC05/25/000263', 2819400.00, 0.00, 2768600.00, 0.00, 0.00, '2025-11-18', 'KT05/25/000130', 50800.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2160PKW', NULL, 'REGULER', 'PK05/25/000645', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(247, 'bp', 'reguler', NULL, 'M. DZIKRI FALAH', 'CAKRAWALA PROTEKSI INDONESIA INSURANCE', '2025-05-14', 'IA05/25/000097', 874125.00, 0.00, 574125.00, 0.00, 0.00, '2026-05-21', 'KT05/26/000101', 300000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2707PII', NULL, 'ASURANSI', 'PK05/25/000642', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(248, 'bp', 'reguler', NULL, 'DEA OKTA LASANDI', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-04-30', 'IA05/25/000091', 5717610.00, 0.00, 5614590.00, 0.00, 0.00, '2025-12-18', 'KT05/25/000081', 103020.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2734UYJ', NULL, 'ASURANSI', 'PK05/25/000624', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(249, 'bp', 'perusahaan', NULL, 'PT. DUTA CENDANA ADIMANDIRI - HOLDING', 'PAN PACIFIC INSURANCE', '2025-04-29', 'IA05/25/000188', 4312795.00, 0.00, 4247995.00, 0.00, 0.00, '2026-03-31', 'KT05/26/000054', 64800.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1844ZFQ', NULL, 'ASURANSI', 'PK05/25/000617', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(250, 'bp', 'reguler', NULL, 'HERMANTO', 'CAKRAWALA PROTEKSI INDONESIA INSURANCE', '2025-04-28', 'IA05/25/000108', 5713419.00, 0.00, 5413419.00, 0.00, 0.00, '2026-05-21', 'KT05/26/000101', 300000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1197RZK', NULL, 'ASURANSI', 'PK05/25/000608', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(251, 'bp', 'perusahaan', NULL, 'PT. DUTA CENDANA ADIMANDIRI', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-04-25', 'IA05/25/000139', 3540798.00, 0.00, 3498478.00, 0.00, 0.00, '2025-12-11', 'KT05/25/000147', 42320.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2684KIO', NULL, 'ASURANSI', 'PK05/25/000599', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(252, 'bp', 'reguler', NULL, 'RAHAYU PURWANINGSIH', 'KSK INSURANCE', '2025-04-23', 'IA05/25/000111', 1261148.00, 0.00, 1244272.00, 0.00, 0.00, '2025-11-05', 'KT05/25/000112', 16876.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2773KRM', NULL, 'ASURANSI', 'PK05/25/000591', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(253, 'bp', 'reguler', NULL, 'ZISCA ANGGITA PRAMESWARI', 'ASTRA BUANA INSURANCE', '2025-04-17', 'IA05/26/000111', 4399963.00, 0.00, 4096364.00, 0.00, 0.00, '2026-08-01', 'BT05/26/000314', 303599.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1998ZKZ', NULL, 'ASURANSI', 'PK05/25/000586', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(254, 'bp', 'reguler', NULL, 'RADEN AJENG AMIERA', 'MPM INSURANCE', '2025-04-10', 'IA05/25/000081', 15182561.00, 0.00, 15083019.00, 0.00, 0.00, '2025-06-25', 'BT05/25/000303', 99542.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2172SRW', NULL, 'ASURANSI', 'PK05/25/000579', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(255, 'bp', 'reguler', NULL, 'MUHAMAD FAUDZAN', 'SINARMAS INSURANCE', '2025-04-07', 'IA05/25/000196', 443556.00, 0.00, 435564.00, 0.00, 0.00, '2025-11-18', 'KT05/25/000130', 7992.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1352DZJ', NULL, 'ASURANSI', 'PK05/25/000568', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(256, 'bp', 'perusahaan', NULL, 'PT. NAWASENA SINERGI GEMILANG', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-03-21', 'IA05/25/000088', 15878548.00, 0.00, 15820671.00, 0.00, 0.00, '2025-11-19', 'KT05/25/000131', 57877.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'T1887BY', NULL, 'ASURANSI', 'PK05/25/000546', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(257, 'bp', 'reguler', NULL, 'YUNUS PURWONO QQ YOGI PRASTYO', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-03-19', 'IA05/25/000075', 1360014.00, 0.00, 1339183.00, 0.00, 0.00, '2025-12-11', 'BT05/25/000661', 20831.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2258KRD', NULL, 'ASURANSI', 'PK05/25/000540', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(258, 'bp', 'reguler', NULL, 'OMEGA TRINUGRAHA', 'SINARMAS INSURANCE', '2025-03-10', 'IA05/25/000194', 6962064.00, 0.00, 6863795.00, 0.00, 0.00, '2025-11-18', 'KT05/25/000130', 98269.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2046KRH', NULL, 'ASURANSI', 'PK05/25/000514', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(259, 'bp', 'reguler', NULL, 'TAMIMIAH A`INI QQ TAUFIK H ABDULLAH', 'SINARMAS INSURANCE', '2025-03-05', 'IA05/25/000206', 4576530.00, 0.00, 4539713.00, 0.00, 0.00, '2026-04-08', 'KT05/26/000068', 36817.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1031DZQ', NULL, 'ASURANSI', 'PK05/25/000505', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(260, 'bp', 'reguler', NULL, 'YUDHI IBRAHIM', 'PT ASURANSI MAXIMUS GRAHA PERSADA', '2025-02-19', 'IA05/25/000049', 3806965.00, 0.00, 3749628.00, 0.00, 0.00, '2025-10-17', 'KT05/25/000081', 57337.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2729KIZ', NULL, 'ASURANSI', 'PK05/25/000476', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(261, 'bp', 'perusahaan', NULL, 'PT. SUMBER BARU ANEKA MOBIL', 'TOTAL LOS ONLY ( TLO ) INSURANCE', '2025-02-14', 'IC05/25/000033', 1318680.00, 0.00, 1294920.00, 0.00, 0.00, '2025-11-20', 'BT05/25/000621', 23760.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1007DOC', NULL, 'REGULER', 'PK05/25/000473', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(262, 'bp', 'reguler', NULL, 'SAPTO SAMBODO', 'MPM INSURANCE', '2025-02-12', 'IA05/25/000055', 2264400.00, 0.00, 2223600.00, 0.00, 0.00, '2025-11-04', 'KT05/25/000081', 40800.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2524KRB', NULL, 'ASURANSI', 'PK05/25/000468', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(263, 'bp', 'reguler', NULL, 'IMAN KURNIADI', 'PAN PACIFIC INSURANCE', '2025-02-10', 'IA05/25/000032', 1018980.00, 0.00, 1000620.00, 0.00, 0.00, '2026-01-14', 'KT05/26/000002', 18360.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1774WIA', NULL, 'ASURANSI', 'PK05/25/000462', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(264, 'bp', 'reguler', NULL, 'NADIA RAHMAD TRISNAWATI', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-01-21', 'IA05/25/000006', 1076740.00, 0.00, 1058458.00, 0.00, 0.00, '2025-04-25', 'KT05/25/000033', 18282.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2851KIZ', NULL, 'ASURANSI', 'PK05/25/000438', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(265, 'bp', 'reguler', NULL, 'HARIS FIKRI JUNANTO', 'SOMPO INSURANCE INDONESIA INSURANCE', '2025-01-21', 'IA05/25/000007', 3354945.00, 0.00, 3306155.00, 0.00, 0.00, '2025-11-17', 'BT05/25/000611', 48790.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2070UYG', NULL, 'ASURANSI', 'PK05/25/000437', '2026-08-19 12:29:04', '2026-08-19 12:29:09'),
(266, 'cinere', 'reguler', NULL, 'INDRA KHARISMA', NULL, '2026-08-19', 'IC03/26/002716', 3839918.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 3839918.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B9522SBI', NULL, 'REGULER', 'PK03/26/003274', '2026-08-19 12:29:28', '2026-08-19 12:29:28'),
(267, 'cinere', 'reguler', NULL, 'BAGUS', NULL, '2026-08-19', 'IC03/26/002715', 2782487.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2782487.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B9218ZUT', NULL, 'REGULER', 'PK03/26/003273', '2026-08-19 12:29:28', '2026-08-19 12:29:28'),
(268, 'cinere', 'reguler', NULL, 'BETRIYANTO', NULL, '2026-08-19', 'IC03/26/002713', 440000.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 440000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B9445KAY', NULL, 'REGULER', 'PK03/26/003271', '2026-08-19 12:29:28', '2026-08-19 12:29:28'),
(269, 'cinere', 'reguler', NULL, 'BAMBANG SOEDJOKO', NULL, '2026-08-19', 'IC03/26/002712', 730000.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 730000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1970ZFH', NULL, 'REGULER', 'PK03/26/003270', '2026-08-19 12:29:28', '2026-08-19 12:29:28'),
(270, 'cinere', 'reguler', NULL, 'DRS SOEBEKTI/IBU LIS / SIDHARTA', NULL, '2026-08-19', 'IC03/26/002714', 2059760.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2059760.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2604SOT', NULL, 'REGULER', 'PK03/26/003269', '2026-08-19 12:29:28', '2026-08-19 12:29:28'),
(271, 'cinere', 'reguler', NULL, 'HALIMAN USMAN', NULL, '2026-08-18', 'IC03/26/002711', 2258999.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2258999.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2252SIC', NULL, 'REGULER', 'PK03/26/003267', '2026-08-19 12:29:28', '2026-08-19 12:29:28'),
(272, 'cinere', 'reguler', NULL, 'KOHARUDIN', NULL, '2026-08-18', 'IC03/26/002703', 213675.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 213675.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2499EVK', NULL, 'REGULER', 'PK03/26/003264', '2026-08-19 12:29:28', '2026-08-19 12:29:28'),
(273, 'cinere', 'reguler', NULL, 'BARITO RAYMONDO S', NULL, '2026-08-18', 'IC03/26/002706', 730000.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 730000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1379ZOA', NULL, 'REGULER', 'PK03/26/003263', '2026-08-19 12:29:28', '2026-08-19 12:29:28'),
(274, 'cinere', 'reguler', NULL, 'AJENG MARTIA SAPUTRI', NULL, '2026-08-18', 'IC03/26/002707', 2284432.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2284432.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A1401VQA', NULL, 'REGULER', 'PK03/26/003262', '2026-08-19 12:29:28', '2026-08-19 12:29:28'),
(275, 'cinere', 'reguler', NULL, 'KUNTADI', NULL, '2026-08-18', 'IC03/26/002704', 1954855.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1954855.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1281ZOF', NULL, 'REGULER', 'PK03/26/003259', '2026-08-19 12:29:28', '2026-08-19 12:29:28'),
(276, 'cinere', 'reguler', NULL, 'MOCH RIZKI SUBARKAH', NULL, '2026-08-18', 'IC03/26/002710', 422300.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 422300.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1457KYP', NULL, 'REGULER', 'PK03/26/003256', '2026-08-19 12:29:28', '2026-08-19 12:29:28'),
(277, 'cinere', 'reguler', NULL, 'PT SURYA SUDECO', NULL, '2026-07-14', 'IC03/26/002338', 1018457.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1018457.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1732DOO', NULL, 'REGULER', 'PK03/26/002794', '2026-08-19 12:29:28', '2026-08-19 12:29:28'),
(278, 'cinere', 'reguler', NULL, 'ANISA ASTUTI', NULL, '2026-04-30', 'IC03/26/001449', 1332000.00, 0.00, 1308000.00, 0.00, 0.00, '2026-05-09', 'KT03/26/000128', 24000.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1427ZKP', NULL, 'REGULER', 'PK03/26/001747', '2026-08-19 12:29:28', '2026-08-19 12:29:29'),
(279, 'cinere', 'reguler', NULL, 'PT SURYA SUDECO', NULL, '2026-04-07', 'IC03/26/001223', 1394153.00, 0.00, 1387608.00, 0.00, 0.00, '2026-06-05', 'BT03/26/000784', 6545.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B9142SCM', NULL, 'REGULER', 'PK03/26/001407', '2026-08-19 12:29:28', '2026-08-19 12:29:29'),
(280, 'cinere', 'perusahaan', NULL, 'PT. SURYA SUDECO', NULL, '2026-02-23', 'IC03/26/000725', 259463.00, 0.00, 254788.00, 0.00, 0.00, '2026-05-12', 'BT03/26/000673', 4675.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B9151SCN', NULL, 'REGULER', 'PK03/26/000750', '2026-08-19 12:29:28', '2026-08-19 12:29:29'),
(281, 'cinere', 'reguler', NULL, 'PT SURYA SUDECO', NULL, '2026-02-13', 'IC03/26/000507', 295787.00, 0.00, 290457.00, 0.00, 0.00, '2026-04-28', 'BT03/26/000606', 5330.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B9142SCM', NULL, 'REGULER', 'PK03/26/000603', '2026-08-19 12:29:28', '2026-08-19 12:29:29'),
(282, 'cinere', 'reguler', NULL, 'PT SURYA SUDECO', NULL, '2026-02-07', 'IC03/26/000498', 236895.00, 0.00, 236045.00, 0.00, 0.00, '2026-05-12', 'BT03/26/000673', 850.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1528DZS', NULL, 'REGULER', 'PK03/26/000529', '2026-08-19 12:29:28', '2026-08-19 12:29:29'),
(283, 'ciawi', 'reguler', NULL, 'AOM GANDI', NULL, '2026-08-19', 'IC01/26/002761', 350000.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 350000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8412HV', NULL, 'REGULER', 'PK01/26/003859', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(284, 'ciawi', 'reguler', NULL, 'IYAS QQ MAHARANI MYSERA', NULL, '2026-08-19', 'IC01/26/002760', 350000.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 350000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8035HV', NULL, 'REGULER', 'PK01/26/003858', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(285, 'ciawi', 'reguler', NULL, 'CANDRA RITONGA', NULL, '2026-08-19', 'IC01/26/002765', 1656692.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1656692.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2931TOL', NULL, 'REGULER', 'PK01/26/003857', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(286, 'ciawi', 'reguler', NULL, 'EDDY KASDIONO', NULL, '2026-08-19', 'IC01/26/002766', 1869049.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1869049.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F1575DG', NULL, 'REGULER', 'PK01/26/003856', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(287, 'ciawi', 'reguler', NULL, 'RENDY SETIADI PUTRA', NULL, '2026-08-19', 'IC01/26/002754', 579200.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 579200.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F1282ABE', NULL, 'REGULER', 'PK01/26/003855', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(288, 'ciawi', 'reguler', NULL, 'IVANA NURUL SETIA / IRIN', NULL, '2026-08-19', 'IC01/26/002755', 2694929.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2694929.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8891HU', NULL, 'REGULER', 'PK01/26/003854', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(289, 'ciawi', 'reguler', NULL, 'BADRU', NULL, '2026-08-19', 'IC01/26/002764', 1966601.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1966601.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2595TRR', NULL, 'REGULER', 'PK01/26/003852', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(290, 'ciawi', 'reguler', NULL, 'AGUS GUNAWAN', NULL, '2026-08-19', 'IC01/26/002759', 350000.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 350000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8524HS', NULL, 'REGULER', 'PK01/26/003847', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(291, 'ciawi', 'perusahaan', NULL, 'PEMERINTAH KOTA BOGOR', NULL, '2026-08-19', 'IC01/26/002753', 4924125.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 4924125.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F1337B', NULL, 'REGULER', 'PK01/26/003846', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(292, 'ciawi', 'reguler', NULL, 'PT LANDTARA AKSES INDO', NULL, '2026-08-19', 'IC01/26/002748', 616826.00, 0.00, 1.00, 0.00, 0.00, '2026-08-19', 'KT01/26/000528', 616825.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B9558TVC', NULL, 'REGULER', 'PK01/26/003843', '2026-08-20 02:04:56', '2026-08-20 02:04:58'),
(293, 'ciawi', 'reguler', NULL, 'MUCHTAR', NULL, '2026-08-19', 'IC01/26/002750', 4440589.00, 0.00, 89.00, 0.00, 0.00, '2026-08-19', 'KT01/26/000528', 4440500.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1125ABZ', NULL, 'REGULER', 'PK01/26/003842', '2026-08-20 02:04:56', '2026-08-20 02:04:58'),
(294, 'ciawi', 'reguler', NULL, 'YUDHI KRISNA', NULL, '2026-08-19', 'IC01/26/002749', 2516246.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2516246.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F1821ABC', NULL, 'REGULER', 'PK01/26/003840', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(295, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-08-15', 'IC01/26/002758', 2336196.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2336196.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8264HQ', NULL, 'REGULER', 'PK01/26/003815', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(296, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-08-15', 'IC01/26/002757', 2108449.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2108449.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8217HQ', NULL, 'REGULER', 'PK01/26/003804', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(297, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-08-15', 'IC01/26/002756', 3988214.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 3988214.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8212HQ', NULL, 'REGULER', 'PK01/26/003803', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(298, 'ciawi', 'perusahaan', NULL, 'PEMERINTAH KOTA BOGOR', NULL, '2026-08-13', 'IC01/26/002717', 2893364.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2893364.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F1450B', NULL, 'REGULER', 'PK01/26/003768', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(299, 'ciawi', 'perusahaan', NULL, 'PT MULIA COLLIMAN INTERNATIONAL', NULL, '2026-08-12', 'IC01/26/002705', 11631600.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 11631600.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'WARA WIRI 2', NULL, 'REGULER', 'PK01/26/003757', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(300, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-08-08', 'IC01/26/002683', 6929596.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 6929596.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8220HQ', NULL, 'REGULER', 'PK01/26/003705', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(301, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-08-08', 'IC01/26/002692', 1238827.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1238827.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8262HQ', NULL, 'REGULER', 'PK01/26/003704', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(302, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-08-08', 'IC01/26/002693', 1518321.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1518321.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8213HQ', NULL, 'REGULER', 'PK01/26/003697', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(303, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-08-05', 'IC01/26/002643', 936563.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 936563.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8216HQ', NULL, 'REGULER', 'PK01/26/003657', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(304, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-08-04', 'IC01/26/002625', 936563.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 936563.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8731HP', NULL, 'REGULER', 'PK01/26/003640', '2026-08-20 02:04:56', '2026-08-20 02:04:56');
INSERT INTO `piutangs` (`id`, `branch`, `tipe_konsumen`, `perusahaan_id`, `nama_konsumen`, `nama_asuransi`, `tgl_bukti`, `no_bukti`, `saldo_awal`, `debet`, `kredit`, `kredit_2`, `kredit_3`, `tgl_bukti_rek`, `no_bukti_rek`, `saldo_akhir`, `keterangan`, `tgl_bukti_rek_2`, `no_bukti_rek_2`, `keterangan_2`, `tgl_bukti_rek_3`, `no_bukti_rek_3`, `keterangan_3`, `no_polisi`, `no_polis`, `spk_type`, `no_spk`, `created_at`, `updated_at`) VALUES
(305, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-08-03', 'IC01/26/002623', 936563.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 936563.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8949SW', NULL, 'REGULER', 'PK01/26/003619', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(306, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-08-01', 'IC01/26/002610', 2920972.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2920972.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8252HM', NULL, 'REGULER', 'PK01/26/003612', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(307, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-08-01', 'IC01/26/002608', 3210883.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 3210883.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8222HQ', NULL, 'REGULER', 'PK01/26/003611', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(308, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-08-01', 'IC01/26/002609', 4293813.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 4293813.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8737HP', NULL, 'REGULER', 'PK01/26/003601', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(309, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-08-01', 'IC01/26/002601', 1458957.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1458957.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8184HS', NULL, 'REGULER', 'PK01/26/003598', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(310, 'ciawi', 'reguler', NULL, 'PT CSM CORPORATAMA/STENLI', NULL, '2026-07-29', 'IC01/26/002575', 984533.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 984533.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2269TIT', NULL, 'REGULER', 'PK01/26/003562', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(311, 'ciawi', 'reguler', NULL, 'PT CSM CORPORATAMA', NULL, '2026-07-27', 'IC01/26/002547', 699030.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 699030.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2664TRU', NULL, 'REGULER', 'PK01/26/003526', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(312, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-07-25', 'IC01/26/002540', 2577035.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2577035.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8503HM', NULL, 'REGULER', 'PK01/26/003511', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(313, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-07-25', 'IC01/26/002542', 1733682.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1733682.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'D8051FN', NULL, 'REGULER', 'PK01/26/003499', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(314, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-07-25', 'IC01/26/002541', 2079020.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2079020.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8735HP', NULL, 'REGULER', 'PK01/26/003498', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(315, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-07-25', 'IC01/26/002546', 1571097.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1571097.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'D8241FN', NULL, 'REGULER', 'PK01/26/003493', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(316, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-07-25', 'IC01/26/002544', 2064800.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2064800.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8258HQ', NULL, 'REGULER', 'PK01/26/003491', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(317, 'ciawi', 'perusahaan', NULL, 'RS PARU  DR M GOENAWAN  P', NULL, '2026-07-24', 'IC01/26/002508', 672345.00, 0.00, 668745.00, 0.00, 0.00, '2026-08-15', 'BT01/26/001517', 3600.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F9901FB', NULL, 'REGULER', 'PK01/26/003480', '2026-08-20 02:04:56', '2026-08-20 02:04:58'),
(318, 'ciawi', 'reguler', NULL, 'PT CSM CORPORATAMA', NULL, '2026-07-21', 'IC01/26/002476', 2179057.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2179057.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2804TRU', NULL, 'REGULER', 'PK01/26/003441', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(319, 'ciawi', 'reguler', NULL, 'PT CSM CORPORATAMA', NULL, '2026-07-20', 'IC01/26/002469', 2735124.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2735124.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2782TRU', NULL, 'REGULER', 'PK01/26/003419', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(320, 'ciawi', 'reguler', NULL, 'PT CSM CORPORATAMA', NULL, '2026-07-20', 'IC01/26/002468', 3833911.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 3833911.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2500TRU', NULL, 'REGULER', 'PK01/26/003413', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(321, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-07-18', 'IC01/26/002482', 1125493.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1125493.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8732HP', NULL, 'REGULER', 'PK01/26/003398', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(322, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-07-18', 'IC01/26/002481', 1735130.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1735130.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8506HM', NULL, 'REGULER', 'PK01/26/003396', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(323, 'ciawi', 'reguler', NULL, 'PT CSM CORPORATAMA', NULL, '2026-07-18', 'IC01/26/002462', 647213.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 647213.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'D1104AKJ', NULL, 'REGULER', 'PK01/26/003392', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(324, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-07-18', 'IC01/26/002478', 2758746.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2758746.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8219HQ', NULL, 'REGULER', 'PK01/26/003380', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(325, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-07-18', 'IC01/26/002473', 2310725.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2310725.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8256HQ', NULL, 'REGULER', 'PK01/26/003375', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(326, 'ciawi', 'perusahaan', NULL, 'PT SURYA MEDISTRINDO / ANDRI', NULL, '2026-07-15', 'IC01/26/002480', 3016371.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 3016371.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8249HM', NULL, 'REGULER', 'PK01/26/003336', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(327, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-07-11', 'IC01/26/002417', 2265951.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2265951.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F8265HQ', NULL, 'REGULER', 'PK01/26/003282', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(328, 'ciawi', 'reguler', NULL, 'PT CSM CORPORATAMA', NULL, '2026-07-10', 'IC01/26/002551', 1890923.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1890923.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2350TRV', NULL, 'REGULER', 'PK01/26/003270', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(329, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-07-04', 'IC01/26/002286', 2062550.00, 0.00, 2038264.00, 0.00, 0.00, '2026-08-01', 'BT01/26/001431', 24286.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8259HM', NULL, 'REGULER', 'PK01/26/003157', '2026-08-20 02:04:56', '2026-08-20 02:04:58'),
(330, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-07-04', 'IC01/26/002287', 2875699.00, 0.00, 2851413.00, 0.00, 0.00, '2026-08-01', 'BT01/26/001431', 24286.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8223HQ', NULL, 'REGULER', 'PK01/26/003156', '2026-08-20 02:04:56', '2026-08-20 02:04:58'),
(331, 'ciawi', 'reguler', NULL, 'PT SURYA UTAMA DIAN  NUSA', NULL, '2026-07-03', 'IC01/26/002283', 1629765.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1629765.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B2687PIA', NULL, 'REGULER', 'PK01/26/003144', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(332, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-06-29', 'IC01/26/002225', 4475925.00, 0.00, 4451175.00, 0.00, 0.00, '2026-08-01', 'BT01/26/001431', 24750.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8257HM', NULL, 'REGULER', 'PK01/26/003078', '2026-08-20 02:04:56', '2026-08-20 02:04:58'),
(333, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-06-27', 'IC01/26/002208', 3479417.00, 0.00, 3448101.00, 0.00, 0.00, '2026-08-01', 'BT01/26/001431', 31316.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8507HM', NULL, 'REGULER', 'PK01/26/003026', '2026-08-20 02:04:56', '2026-08-20 02:04:58'),
(334, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-06-27', 'IC01/26/002188', 4386364.00, 0.00, 4348712.00, 0.00, 0.00, '2026-08-01', 'BT01/26/001431', 37652.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8256HM', NULL, 'REGULER', 'PK01/26/003024', '2026-08-20 02:04:56', '2026-08-20 02:04:58'),
(335, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-06-27', 'IC01/26/002183', 3261207.00, 0.00, 3227020.00, 0.00, 0.00, '2026-08-01', 'BT01/26/001431', 34187.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8263HQ', NULL, 'REGULER', 'PK01/26/003023', '2026-08-20 02:04:56', '2026-08-20 02:04:58'),
(336, 'ciawi', 'perusahaan', NULL, 'PT.OBITRANS INDONESIA', NULL, '2026-06-24', 'IC01/26/002132', 2805678.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2805678.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DK1702FBY', NULL, 'REGULER', 'PK01/26/002968', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(337, 'ciawi', 'reguler', NULL, 'PT CSM CORPORATAMA/STENLI', NULL, '2026-06-23', 'IC01/26/002119', 137363.00, 0.00, 134888.00, 0.00, 0.00, '2026-08-15', 'BT01/26/001525', 2475.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2269TIT', NULL, 'REGULER', 'PK01/26/002948', '2026-08-20 02:04:56', '2026-08-20 02:04:58'),
(338, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-06-20', 'IC01/26/002107', 3167990.00, 0.00, 3135288.00, 0.00, 0.00, '2026-08-01', 'BT01/26/001431', 32702.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8224OS', NULL, 'REGULER', 'PK01/26/002909', '2026-08-20 02:04:56', '2026-08-20 02:04:58'),
(339, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-06-20', 'IC01/26/002086', 2315983.00, 0.00, 2286746.00, 0.00, 0.00, '2026-07-15', 'BT01/26/001330', 29237.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8266HQ', NULL, 'REGULER', 'PK01/26/002905', '2026-08-20 02:04:56', '2026-08-20 02:04:58'),
(340, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-06-20', 'IC01/26/002085', 2053857.00, 0.00, 2029570.00, 0.00, 0.00, '2026-07-15', 'BT01/26/001330', 24287.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8259HQ', NULL, 'REGULER', 'PK01/26/002901', '2026-08-20 02:04:56', '2026-08-20 02:04:58'),
(341, 'ciawi', 'reguler', NULL, 'PT CSM CORPORATAMA', NULL, '2026-06-18', 'IC01/26/002066', 3493711.00, 0.00, 3422431.00, 0.00, 0.00, '2026-08-01', 'BT01/26/001443', 71280.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2664TRU', NULL, 'REGULER', 'PK01/26/002874', '2026-08-20 02:04:56', '2026-08-20 02:04:58'),
(342, 'ciawi', 'perusahaan', NULL, 'PT MUARA SAKTI UTAMA', NULL, '2026-06-18', 'IC01/26/002060', 2333311.00, 0.00, 2320661.00, 0.00, 0.00, '2026-06-19', 'BT01/26/001212', 12650.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1791FAC', NULL, 'REGULER', 'PK01/26/002873', '2026-08-20 02:04:56', '2026-08-20 02:04:58'),
(343, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-06-13', 'IC01/26/002019', 2811388.00, 0.00, 2783141.00, 0.00, 0.00, '2026-07-15', 'BT01/26/001330', 28247.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8248HM', NULL, 'REGULER', 'PK01/26/002797', '2026-08-20 02:04:56', '2026-08-20 02:04:58'),
(344, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-06-13', 'IC01/26/002020', 2183952.00, 0.00, 2158675.00, 0.00, 0.00, '2026-07-15', 'BT01/26/001330', 25277.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8214HQ', NULL, 'REGULER', 'PK01/26/002796', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(345, 'ciawi', 'perusahaan', NULL, 'PT MULIA COLLIMAN INTERNATIONAL', NULL, '2026-06-12', 'IC01/26/002137', 2635830.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 2635830.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'WARA WIRI 2', NULL, 'REGULER', 'PK01/26/002779', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(346, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-06-06', 'IC01/26/001949', 2641152.00, 0.00, 2615875.00, 0.00, 0.00, '2026-07-15', 'BT01/26/001330', 25277.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8255HM', NULL, 'REGULER', 'PK01/26/002674', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(347, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-06-06', 'IC01/26/001928', 2473843.00, 0.00, 2446586.00, 0.00, 0.00, '2026-07-15', 'BT01/26/001330', 27257.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8509HM', NULL, 'REGULER', 'PK01/26/002673', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(348, 'ciawi', 'perusahaan', NULL, 'PT MUARA SAKTI UTAMA', NULL, '2026-06-05', 'IC01/26/001911', 1947489.00, 0.00, 1938793.00, 0.00, 0.00, '2026-06-05', 'BT01/26/001128', 8696.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1013RC', NULL, 'REGULER', 'PK01/26/002657', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(349, 'ciawi', 'perusahaan', NULL, 'PT MULIA COLLIMAN INTERNATIONAL', NULL, '2026-05-30', 'IC01/26/002138', 3055383.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 3055383.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'WARA WIRI 1', NULL, 'REGULER', 'PK01/26/002540', '2026-08-20 02:04:56', '2026-08-20 02:04:56'),
(350, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-30', 'IC01/26/001846', 3043362.00, 0.00, 3010165.00, 0.00, 0.00, '2026-06-30', 'BT01/26/001267', 33197.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8948SW', NULL, 'REGULER', 'PK01/26/002526', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(351, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-30', 'IC01/26/001844', 2225675.00, 0.00, 2196438.00, 0.00, 0.00, '2026-06-30', 'BT01/26/001267', 29237.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8504HM', NULL, 'REGULER', 'PK01/26/002523', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(352, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-30', 'IC01/26/001845', 2359980.00, 0.00, 2340571.00, 0.00, 0.00, '2026-06-30', 'BT01/26/001267', 19409.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'Z8710KK', NULL, 'REGULER', 'PK01/26/002515', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(353, 'ciawi', 'reguler', NULL, 'PT CSM CORPORATAMA', NULL, '2026-05-29', 'IC01/26/001833', 2666567.00, 0.00, 2636372.00, 0.00, 0.00, '2026-07-16', 'BT01/26/001357', 30195.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2146TIW', NULL, 'REGULER', 'PK01/26/002499', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(354, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-23', 'IC01/26/001787', 1957655.00, 0.00, 1934358.00, 0.00, 0.00, '2026-06-30', 'BT01/26/001267', 23297.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8211HQ', NULL, 'REGULER', 'PK01/26/002439', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(355, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-23', 'IC01/26/001785', 2864849.00, 0.00, 2838582.00, 0.00, 0.00, '2026-06-30', 'BT01/26/001267', 26267.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8736HP', NULL, 'REGULER', 'PK01/26/002431', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(356, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-23', 'IC01/26/001784', 2033561.00, 0.00, 2010264.00, 0.00, 0.00, '2026-06-30', 'BT01/26/001267', 23297.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8733HP', NULL, 'REGULER', 'PK01/26/002429', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(357, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-23', 'IC01/26/001786', 4491372.00, 0.00, 4460155.00, 0.00, 0.00, '2026-06-30', 'BT01/26/001267', 31217.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8223OS', NULL, 'REGULER', 'PK01/26/002425', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(358, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-19', 'IC01/26/001722', 936563.00, 0.00, 934088.00, 0.00, 0.00, '2026-06-19', 'BT01/26/001203', 2475.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8217HQ', NULL, 'REGULER', 'PK01/26/002364', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(359, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-16', 'IC01/26/001710', 3283824.00, 0.00, 3255343.00, 0.00, 0.00, '2026-06-19', 'BT01/26/001203', 28481.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8508HM', NULL, 'REGULER', 'PK01/26/002329', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(360, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-16', 'IC01/26/001709', 2430230.00, 0.00, 2400993.00, 0.00, 0.00, '2026-06-19', 'BT01/26/001203', 29237.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8262HQ', NULL, 'REGULER', 'PK01/26/002324', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(361, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-15', 'IC01/26/001693', 936563.00, 0.00, 934088.00, 0.00, 0.00, '2026-06-06', 'BT01/26/001128', 2475.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8224OS', NULL, 'REGULER', 'PK01/26/002310', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(362, 'ciawi', 'reguler', NULL, 'PT CSM CORPORATAMA / PAK ADE', NULL, '2026-05-13', 'IC01/26/001690', 1414282.00, 0.00, 1405867.00, 0.00, 0.00, '2026-08-01', 'BT01/26/001443', 8415.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2693TRP', NULL, 'REGULER', 'PK01/26/002283', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(363, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-09', 'IC01/26/001632', 3167494.00, 0.00, 3135782.00, 0.00, 0.00, '2026-06-06', 'BT01/26/001128', 31712.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'D8688FN', NULL, 'REGULER', 'PK01/26/002234', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(364, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-09', 'IC01/26/001631', 2035996.00, 0.00, 2011709.00, 0.00, 0.00, '2026-06-06', 'BT01/26/001128', 24287.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8267HQ', NULL, 'REGULER', 'PK01/26/002232', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(365, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-09', 'IC01/26/001630', 3674689.00, 0.00, 3641987.00, 0.00, 0.00, '2026-06-06', 'BT01/26/001128', 32702.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8257HQ', NULL, 'REGULER', 'PK01/26/002228', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(366, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-09', 'IC01/26/001629', 1603615.00, 0.00, 1589156.00, 0.00, 0.00, '2026-06-06', 'BT01/26/001128', 14459.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'D8051FN', NULL, 'REGULER', 'PK01/26/002226', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(367, 'ciawi', 'reguler', NULL, 'PT CSM CORPORATAMA', NULL, '2026-05-08', 'IC01/26/001718', 106144.00, 0.00, 104907.00, 0.00, 0.00, '2026-07-11', 'BT01/26/001338', 1237.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1513ROR', NULL, 'REGULER', 'PK01/26/002218', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(368, 'ciawi', 'reguler', NULL, 'PT CSM CORPORATAMA/STENLI', NULL, '2026-05-08', 'IC01/26/001616', 2225592.00, 0.00, 2163088.00, 0.00, 0.00, '2026-07-11', 'BT01/26/001338', 62504.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B2269TIT', NULL, 'REGULER', 'PK01/26/002217', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(369, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-07', 'IC01/26/001627', 274725.00, 0.00, 269775.00, 0.00, 0.00, '2026-06-06', 'BT01/26/001128', 4950.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'W8207PC', NULL, 'REGULER', 'PK01/26/002208', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(370, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-04', 'IC01/26/001573', 1285875.00, 0.00, 1277625.00, 0.00, 0.00, '2026-06-06', 'BT01/26/001128', 8250.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8254HM', NULL, 'REGULER', 'PK01/26/002152', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(371, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-02', 'IC01/26/001560', 2340226.00, 0.00, 2317289.00, 0.00, 0.00, '2026-06-06', 'BT01/26/001128', 22937.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8217HQ', NULL, 'REGULER', 'PK01/26/002120', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(372, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-02', 'IC01/26/001561', 3102423.00, 0.00, 3073049.00, 0.00, 0.00, '2026-06-06', 'BT01/26/001128', 29374.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8218HQ', NULL, 'REGULER', 'PK01/26/002119', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(373, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-02', 'IC01/26/001563', 2572203.00, 0.00, 2546060.00, 0.00, 0.00, '2026-06-06', 'BT01/26/001128', 26143.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8221HQ', NULL, 'REGULER', 'PK01/26/002117', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(374, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-02', 'IC01/26/001559', 2058717.00, 0.00, 2042710.00, 0.00, 0.00, '2026-06-06', 'BT01/26/001128', 16007.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8261HQ', NULL, 'REGULER', 'PK01/26/002115', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(375, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-02', 'IC01/26/001564', 2155062.00, 0.00, 2128165.00, 0.00, 0.00, '2026-06-06', 'BT01/26/001128', 26897.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8258HQ', NULL, 'REGULER', 'PK01/26/002108', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(376, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-05-02', 'IC01/26/001562', 2005888.00, 0.00, 1990439.00, 0.00, 0.00, '2026-06-06', 'BT01/26/001128', 15449.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'D8054FN', NULL, 'REGULER', 'PK01/26/002107', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(377, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-04-25', 'IC01/26/001475', 882562.00, 0.00, 880087.00, 0.00, 0.00, '2026-05-21', 'BT01/26/001036', 2475.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8220HQ', NULL, 'REGULER', 'PK01/26/002011', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(378, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-04-25', 'IC01/26/001471', 2120188.00, 0.00, 2104739.00, 0.00, 0.00, '2026-05-21', 'BT01/26/001036', 15449.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'D8241FN', NULL, 'REGULER', 'PK01/26/002007', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(379, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-04-25', 'IC01/26/001481', 2939906.00, 0.00, 2915619.00, 0.00, 0.00, '2026-05-21', 'BT01/26/001036', 24287.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8250HM', NULL, 'REGULER', 'PK01/26/002006', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(380, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-04-25', 'IC01/26/001482', 1908717.00, 0.00, 1891126.00, 0.00, 0.00, '2026-05-21', 'BT01/26/001036', 17591.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8252HM', NULL, 'REGULER', 'PK01/26/002005', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(381, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-04-25', 'IC01/26/001477', 1860560.00, 0.00, 1841016.00, 0.00, 0.00, '2026-05-21', 'BT01/26/001036', 19544.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8184HS', NULL, 'REGULER', 'PK01/26/001996', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(382, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-04-25', 'IC01/26/001483', 2274986.00, 0.00, 2246739.00, 0.00, 0.00, '2026-05-21', 'BT01/26/001036', 28247.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8260HQ', NULL, 'REGULER', 'PK01/26/001995', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(383, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-04-18', 'IC01/26/001403', 2235125.00, 0.00, 2205888.00, 0.00, 0.00, '2026-05-20', 'BT01/26/001027', 29237.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8216HQ', NULL, 'REGULER', 'PK01/26/001891', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(384, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-04-18', 'IC01/26/001402', 2431554.00, 0.00, 2405548.00, 0.00, 0.00, '2026-05-20', 'BT01/26/001027', 26006.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8213HQ', NULL, 'REGULER', 'PK01/26/001879', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(385, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-04-18', 'IC01/26/001404', 2734666.00, 0.00, 2710863.00, 0.00, 0.00, '2026-05-20', 'BT01/26/001027', 23803.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8517HN', NULL, 'REGULER', 'PK01/26/001875', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(386, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-04-18', 'IC01/26/001382', 3811818.00, 0.00, 3783337.00, 0.00, 0.00, '2026-05-20', 'BT01/26/001027', 28481.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8732HP', NULL, 'REGULER', 'PK01/26/001871', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(387, 'ciawi', 'reguler', NULL, 'PT ANTA TIRTA KIRANA', NULL, '2026-04-15', 'IC01/26/001340', 3665569.00, 0.00, 3646759.00, 0.00, 0.00, '2026-04-16', 'BT01/26/000787', 18810.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B1683BRK', NULL, 'REGULER', 'PK01/26/001821', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(388, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-04-11', 'IC01/26/001317', 2211536.00, 0.00, 2196087.00, 0.00, 0.00, '2026-06-03', 'BT01/26/001082', 15449.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'Z8714KK', NULL, 'REGULER', 'PK01/26/001781', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(389, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-04-11', 'IC01/26/001316', 2154833.00, 0.00, 2139384.00, 0.00, 0.00, '2026-06-03', 'BT01/26/001082', 15449.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'D8053FN', NULL, 'REGULER', 'PK01/26/001780', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(390, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-04-11', 'IC01/26/001323', 2087074.00, 0.00, 2064137.00, 0.00, 0.00, '2026-05-18', 'BT01/26/001004', 22937.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8258HM', NULL, 'REGULER', 'PK01/26/001777', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(391, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-04-11', 'IC01/26/001310', 2776066.00, 0.00, 2752263.00, 0.00, 0.00, '2026-05-06', 'BT01/26/000926', 23803.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8222HQ', NULL, 'REGULER', 'PK01/26/001776', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(392, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-04-11', 'IC01/26/001318', 1459911.00, 0.00, 1443904.00, 0.00, 0.00, '2026-05-18', 'BT01/26/001004', 16007.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8219HQ', NULL, 'REGULER', 'PK01/26/001764', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(393, 'ciawi', 'perusahaan', NULL, 'PT MULIA COLLIMAN INTERNATIONAL', NULL, '2026-04-09', 'IC01/26/001284', 901259.00, 0.00, 877499.00, 0.00, 0.00, '2026-05-25', 'BT01/26/001049', 23760.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'GEULIS 6 CH', NULL, 'REGULER', 'PK01/26/001739', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(394, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-04-04', 'IC01/26/001311', 547806.00, 0.00, 542361.00, 0.00, 0.00, '2026-05-06', 'BT01/26/000926', 5445.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8256HM', NULL, 'REGULER', 'PK01/26/001655', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(395, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-04-04', 'IC01/26/001309', 3020308.00, 0.00, 3002488.00, 0.00, 0.00, '2026-05-06', 'BT01/26/000926', 17820.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'W8207PC', NULL, 'REGULER', 'PK01/26/001654', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(396, 'ciawi', 'perusahaan', NULL, 'PT SURYA MADISTRINDO', NULL, '2026-03-28', 'IC01/26/001324', 2445950.00, 0.00, 2421663.00, 0.00, 0.00, '2026-05-18', 'BT01/26/001004', 24287.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8253OS', NULL, 'REGULER', 'PK01/26/001543', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(397, 'ciawi', 'reguler', NULL, 'PT CSM CORPORATAMA', NULL, '2026-03-12', 'IC01/26/000919', 219780.00, 0.00, 215820.00, 0.00, 0.00, '2026-05-12', 'BT01/26/000962', 3960.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1634AAY', NULL, 'REGULER', 'PK01/26/001252', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(398, 'ciawi', 'perusahaan', NULL, 'PT ELANG PERDANA TYRE INDUSTRY', NULL, '2026-03-09', 'IC01/26/001306', 2328345.00, 0.00, 2314485.00, 0.00, 0.00, '2026-05-07', 'BT01/26/000941', 13860.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1582KV', NULL, 'REGULER', 'PK01/26/001161', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(399, 'ciawi', 'reguler', NULL, 'PT SURYA BOGA ANDRAWINA', NULL, '2026-03-07', 'IC01/26/000800', 2867208.00, 0.00, 2835959.00, 0.00, 0.00, '2026-03-10', 'BT01/26/000568', 31249.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B9549UCV', NULL, 'REGULER', 'PK01/26/001134', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(400, 'ciawi', 'perusahaan', NULL, 'PT MUARA SAKTI UTAMA', NULL, '2026-02-13', 'IC01/26/000514', 4249335.00, 0.00, 4237293.00, 0.00, 0.00, '2026-02-28', 'BT01/26/000458', 12042.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1791FAC', NULL, 'REGULER', 'PK01/26/000729', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(401, 'ciawi', 'perusahaan', NULL, 'PT MUARA SAKTI UTAMA', NULL, '2026-01-29', 'IC01/26/000312', 2306390.00, 0.00, 2298965.00, 0.00, 0.00, '2026-02-09', 'BT01/26/000228', 7425.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1013RC', NULL, 'REGULER', 'PK01/26/000445', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(402, 'ciawi', 'perusahaan', NULL, 'PT ELANG PERDANA TYRE INDUSTRY', NULL, '2026-01-21', 'IC01/26/000230', 2091498.00, 0.00, 2075821.00, 0.00, 0.00, '2026-02-23', 'BT01/26/000340', 15677.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1896KX', NULL, 'REGULER', 'PK01/26/000308', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(403, 'ciawi', 'perusahaan', NULL, 'PT MULIA COLLIMAN INTERNATIONAL', NULL, '2026-01-19', 'IC01/26/000198', 1736021.00, 0.00, 1722228.00, 0.00, 0.00, '2026-03-11', 'BT01/26/000571', 13793.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'B9273NO', NULL, 'REGULER', 'PK01/26/000274', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(404, 'ciawi', 'reguler', NULL, 'PT CSM CORPORATAMA', NULL, '2025-11-27', 'IC01/26/000619', 452316.00, 0.00, 3960.00, 0.00, 0.00, '2026-07-22', 'KT01/26/000472', 448356.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F1621AAY', NULL, 'REGULER', 'PK01/25/005199', '2026-08-20 02:04:56', '2026-08-20 02:04:59'),
(405, 'ciawi', 'reguler', NULL, 'FAJRULY', NULL, '2025-03-22', 'IC01/25/000799', 491547.00, 0.00, 491547.00, 0.00, 0.00, '2025-03-28', 'BT01/25/000519', 0.00, 'Pelunasan DMS', NULL, NULL, NULL, NULL, NULL, NULL, 'F8309BC', NULL, 'REGULER', 'PK01/25/001248', '2026-08-20 02:04:56', '2026-08-20 02:04:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `plan_activities`
--

CREATE TABLE `plan_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cabang` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jenis_activity` enum('Offline','Online') NOT NULL,
  `activity` enum('D_MARKETING','EXHIBITION','MOVING_EXHIBITION','SHOWROOM_EVENT','GROUP_PRESENTATION','EVENT_TEST_DRIVE','OPEN_TABLE','CETAK_FLYER') NOT NULL,
  `platform_lokasi` varchar(255) NOT NULL,
  `jenis_unit` enum('Commercial','Passenger') NOT NULL,
  `type_unit` enum('CARRY_PU','CARRY_BOX','CARRY_BV','CARRY_MOKO','CARRY_AMBULANCE','CARRY_TOWING','APV_MB','APV_AMBULANCE','ERTIGA','ERTIGA_HYBRID','XL7','XL7_HYBRID','S_PRESSO','IGNIS','e_VITARA','GRAND_VITARA','JIMNY','FRONX') NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `pic` varchar(255) NOT NULL,
  `jml_sales_shift` varchar(255) NOT NULL,
  `target_p` int(11) NOT NULL DEFAULT 0,
  `target_hp` int(11) NOT NULL DEFAULT 0,
  `target_spk` int(11) NOT NULL DEFAULT 0,
  `actual_p` int(11) NOT NULL DEFAULT 0,
  `actual_hp` int(11) NOT NULL DEFAULT 0,
  `actual_spk` int(11) NOT NULL DEFAULT 0,
  `actual_do` int(11) NOT NULL DEFAULT 0,
  `total_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `cost_p` decimal(15,2) NOT NULL DEFAULT 0.00,
  `cost_spk` decimal(15,2) NOT NULL DEFAULT 0.00,
  `cost_do` decimal(15,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pmmstplansales`
--

CREATE TABLE `pmmstplansales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `CompanyCode` varchar(15) DEFAULT NULL,
  `BranchCode` varchar(15) DEFAULT NULL,
  `SpvEmployeeID` varchar(50) DEFAULT NULL,
  `SourceCode` varchar(50) DEFAULT NULL,
  `DetailCode` varchar(50) DEFAULT NULL,
  `DetailName` varchar(100) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL,
  `Month` int(11) DEFAULT NULL,
  `SourceName` varchar(50) NOT NULL DEFAULT 'BySalesman',
  `DO_Week1` int(11) NOT NULL DEFAULT 0,
  `SPK_Week1` int(11) NOT NULL DEFAULT 0,
  `INQ_Week1` int(11) NOT NULL DEFAULT 0,
  `DO_Week2` int(11) NOT NULL DEFAULT 0,
  `SPK_Week2` int(11) NOT NULL DEFAULT 0,
  `INQ_Week2` int(11) NOT NULL DEFAULT 0,
  `DO_Week3` int(11) NOT NULL DEFAULT 0,
  `SPK_Week3` int(11) NOT NULL DEFAULT 0,
  `INQ_Week3` int(11) NOT NULL DEFAULT 0,
  `DO_Week4` int(11) NOT NULL DEFAULT 0,
  `SPK_Week4` int(11) NOT NULL DEFAULT 0,
  `INQ_Week4` int(11) NOT NULL DEFAULT 0,
  `DO_Week5` int(11) NOT NULL DEFAULT 0,
  `SPK_Week5` int(11) NOT NULL DEFAULT 0,
  `INQ_Week5` int(11) NOT NULL DEFAULT 0,
  `CreatedBy` varchar(50) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `UpdatedBy` varchar(50) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `post_check_acs`
--

CREATE TABLE `post_check_acs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis_pemeriksaan` varchar(255) DEFAULT NULL,
  `no_spk` varchar(255) DEFAULT NULL,
  `no_polisi` varchar(255) DEFAULT NULL,
  `cabang` varchar(255) DEFAULT NULL,
  `teknisi` varchar(255) DEFAULT NULL,
  `sa` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `tipe_kendaraan` varchar(255) DEFAULT NULL,
  `pre_high_pressure` varchar(255) DEFAULT NULL,
  `pre_low_pressure` varchar(255) DEFAULT NULL,
  `pre_suhu_outlet` varchar(255) DEFAULT NULL,
  `pre_wind_speed` varchar(255) DEFAULT NULL,
  `post_high_pressure` varchar(255) DEFAULT NULL,
  `post_low_pressure` varchar(255) DEFAULT NULL,
  `post_suhu_outlet` varchar(255) DEFAULT NULL,
  `post_wind_speed` varchar(255) DEFAULT NULL,
  `catatan_tambahan` text DEFAULT NULL,
  `perawatan` varchar(255) DEFAULT NULL,
  `penggantian` varchar(255) DEFAULT NULL,
  `status_approve` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `foto_kendaraan` longtext DEFAULT NULL,
  `keterangan_foto` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `post_check_acs`
--

INSERT INTO `post_check_acs` (`id`, `jenis_pemeriksaan`, `no_spk`, `no_polisi`, `cabang`, `teknisi`, `sa`, `tanggal`, `tipe_kendaraan`, `pre_high_pressure`, `pre_low_pressure`, `pre_suhu_outlet`, `pre_wind_speed`, `post_high_pressure`, `post_low_pressure`, `post_suhu_outlet`, `post_wind_speed`, `catatan_tambahan`, `perawatan`, `penggantian`, `status_approve`, `created_at`, `updated_at`, `foto_kendaraan`, `keterangan_foto`) VALUES
(3, 'POST CHECK', 'PK01/26/003890', 'D1050UBZ', 'CIAWI', 'BUDI SANTOSO', 'NANA SOPIANA', '2026-08-21', 'FRONX', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'BELUM DIPROSES', '2026-08-21 15:57:47', '2026-08-21 15:57:47', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pre_check_acs`
--

CREATE TABLE `pre_check_acs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis_pemeriksaan` varchar(255) DEFAULT NULL,
  `no_spk` varchar(255) DEFAULT NULL,
  `no_polisi` varchar(255) DEFAULT NULL,
  `cabang` varchar(255) DEFAULT NULL,
  `teknisi` varchar(255) DEFAULT NULL,
  `sa` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `tipe_kendaraan` varchar(255) DEFAULT NULL,
  `high_pressure` varchar(255) DEFAULT NULL,
  `low_pressure` varchar(255) DEFAULT NULL,
  `suhu_outlet` varchar(255) DEFAULT NULL,
  `wind_speed` varchar(255) DEFAULT NULL,
  `pemeriksaan_tambahan` text DEFAULT NULL,
  `rekomendasi_perawatan` varchar(255) DEFAULT NULL,
  `estimasi_penggantian_part` varchar(255) DEFAULT NULL,
  `foto_kendaraan` varchar(255) DEFAULT NULL,
  `keterangan_foto` varchar(255) DEFAULT NULL,
  `status_approve` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `respon_leads`
--

CREATE TABLE `respon_leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_respon` varchar(255) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sales_leads`
--

CREATE TABLE `sales_leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `service_acs`
--

CREATE TABLE `service_acs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cabang` varchar(255) NOT NULL,
  `periode` date NOT NULL,
  `unit_entry_bulan` int(11) NOT NULL DEFAULT 0,
  `unit_entry_hari_ini` int(11) NOT NULL DEFAULT 0,
  `unit_entry_target` int(11) NOT NULL DEFAULT 0,
  `unit_spooring_bulan` int(11) NOT NULL DEFAULT 0,
  `unit_spooring_hari_ini` int(11) NOT NULL DEFAULT 0,
  `unit_spooring_target` int(11) NOT NULL DEFAULT 0,
  `unit_ac_bulan` int(11) NOT NULL DEFAULT 0,
  `unit_ac_hari_ini` int(11) NOT NULL DEFAULT 0,
  `unit_ac_target` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('6ySbMw3w2ZfDIYmSH3zbpUtpl0Ju6OL2Zqc19TCD', 1287, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOWVJalRPWDMyMmJCczRva2ViaHNZR3lFVFdTS0NqOWlZOHp3VGFIcCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEyODc7fQ==', 1787371151),
('ITsgDaUX0cJWY9AFkExWL2b2qR2l2LtSY6aPY1EO', 1287, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoicmhxUmdaWHNyR2F0OFlac2VrNzhGSlN0ZzBDbWlUcXFnVXJjWGNaTiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEyODc7fQ==', 1787328983),
('udFB0UN87ekq0SX1dl7AMZWO0ujBPy5DpVLju3Al', 1287, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMmNNTE81SzQ2MFUyMTU0Q3c5cGF1QUJtZzRjdUxSSjdub1pCNDU1MiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEyODc7fQ==', 1787387943);

-- --------------------------------------------------------

--
-- Struktur dari tabel `spv_leads`
--

CREATE TABLE `spv_leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_leads`
--

CREATE TABLE `status_leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_status` varchar(255) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_do` varchar(255) DEFAULT NULL,
  `tanggal_do` date DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `varian_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gudang_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cabang_id` bigint(20) UNSIGNED DEFAULT NULL,
  `warna_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kode_mobil` varchar(255) DEFAULT NULL,
  `nama_mobil` varchar(255) DEFAULT NULL,
  `warna` varchar(255) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `chassis_code` varchar(255) DEFAULT NULL,
  `norangka` varchar(255) DEFAULT NULL,
  `enginecode` varchar(255) DEFAULT NULL,
  `nomesin` varchar(255) DEFAULT NULL,
  `faktur` varchar(255) DEFAULT NULL,
  `bln_naik_faktur` varchar(255) DEFAULT NULL,
  `harga` bigint(20) DEFAULT NULL,
  `kpt_kf` bigint(20) DEFAULT NULL,
  `acs2` bigint(20) DEFAULT NULL,
  `subsidi` bigint(20) DEFAULT NULL,
  `hpp` bigint(20) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `estimasi_unit_masuk_gudang_dca` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `lain_lain` varchar(255) DEFAULT NULL,
  `penjualan` varchar(255) DEFAULT NULL,
  `tanggal_matching_do` varchar(255) DEFAULT NULL,
  `cabang` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `varian` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `stocks`
--

INSERT INTO `stocks` (`id`, `no_do`, `tanggal_do`, `unit_id`, `varian_id`, `gudang_id`, `cabang_id`, `warna_id`, `kode_mobil`, `nama_mobil`, `warna`, `tahun`, `chassis_code`, `norangka`, `enginecode`, `nomesin`, `faktur`, `bln_naik_faktur`, `harga`, `kpt_kf`, `acs2`, `subsidi`, `hpp`, `lokasi`, `estimasi_unit_masuk_gudang_dca`, `status`, `lain_lain`, `penjualan`, `tanggal_matching_do`, `cabang`, `keterangan`, `unit`, `created_at`, `updated_at`, `varian`) VALUES
(4, 'DB571672', '2025-10-24', NULL, NULL, NULL, NULL, NULL, 'XL7415F.34GSMTS', 'NEW XL-7', 'RISING ORANGE PEARL/METALLIC PERM. COOL BLACK', 2025, 'MHYANC32SSJ', '105765', 'K15BT', '1703215', 'SUDAH NAIK HO', 'JUNI 2026', 252580000, 1656815, NULL, 10700000, 243536815, 'CINERE', NULL, 'free', NULL, 'ERNI', '2026-07-24 00:00:00', 'CINERE', 'DISPLAY CINERE', NULL, '2026-06-29 11:40:14', '2026-07-29 14:51:28', '03 ALPHA AT HYBRID 2TONE'),
(5, 'DB576503', '2025-11-18', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00SXATS', 'FRONX', 'COOL BLACK MET', 2025, 'MHYMWDB3SSJ', '109818', 'K15C-', '1090075', 'SUDAH NAIK CINERE', 'MEI 2026', 270050000, 1351037, NULL, 5700000, 265701037, 'Cinere', NULL, 'sold', NULL, 'WINDHA MAULINNA [0063374]', '2026-06-27', 'Cinere', NULL, NULL, '2026-06-29 11:48:38', '2026-07-01 15:11:26', 'SGX AT'),
(6, 'DB581822', '2025-12-11', NULL, NULL, NULL, NULL, NULL, 'XL7415F.24GXMTS', 'NEW XL-7', 'SNOW WHITE', 2025, 'MHYANC32SSJ', '105070', 'K15BT', '1689572', NULL, NULL, 231980000, 1656815, NULL, 10700000, 222936815, 'Cinere', NULL, 'sold', NULL, 'PT SURYA CITRA TELEVISI [005792', '2026-06-23', 'Cinere', NULL, NULL, '2026-06-29 12:05:25', '2026-07-02 11:19:35', '03 BETA MT HYBRID'),
(7, 'DB587657', '2025-12-31', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00SXATS', 'FRONX', 'COOL BLACK MET', 2025, 'MHYMWDB3SSJ', '111644', 'K15C-', '1092186', NULL, NULL, 270050000, 1351037, NULL, 5700000, 265701037, 'JATIASIH', NULL, 'sold', NULL, 'ERIE NASIBU QQ AULYA AYU ERINA [0063999]', '2026-07-22 00:00:00', 'JATIASIH', NULL, NULL, '2026-06-29 12:08:37', '2026-07-29 10:00:07', 'HYBRID SGX AT'),
(8, 'DB587658', '2025-12-31', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00SXATS', 'FRONX', 'COOL BLACK MET', 2025, 'MHYMWDB3SSJ', '111818', 'K15C-', '1093261', NULL, NULL, 270050000, 1351037, NULL, 5700000, 265701037, 'JATIASIH', NULL, 'sold', NULL, 'SUGENG SANTOSO [0063990]', '2026-07-21 00:00:00', 'JATIASIH', NULL, NULL, '2026-06-29 12:11:38', '2026-07-22 11:44:41', 'HYBRID SGX AT'),
(9, 'DB587660', '2025-12-31', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00SXATS', 'FRONX', 'COOL BLACK MET', 2025, 'MHYMWDB3SSJ', '111807', 'K15C-', '1092578', NULL, NULL, 270050000, 1351037, NULL, 5700000, 265701037, 'Cinere', NULL, 'sold', NULL, 'ADITYA FAREZA [0063519]', '2026-06-08', 'Cinere', NULL, NULL, '2026-06-29 14:20:29', '2026-06-29 14:20:29', 'HYBRID SGX AT'),
(10, 'DB591055', '2026-01-26', NULL, NULL, NULL, NULL, NULL, 'XL7415F.34GSATS', 'NEW XL-7', 'WHITE + BLACK TOP', 2025, 'MHYANC32SSJ', '109553', 'K15BT', '1736459', NULL, NULL, 258840000, 1656815, NULL, 10700000, 249796815, 'Jatiasih', NULL, 'sold', NULL, 'JUWITA FATMA SARI [0062456]', '2026-06-13', 'Jatiasih', NULL, NULL, '2026-06-29 14:22:54', '2026-06-29 14:22:54', '03 ALPHA AT HYBRID 2TONE'),
(11, 'DB599424', '2026-02-20', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '275992', 'K15BT', '1746998', 'SUDAH NAIK HO', '20-FEB-26', 123690000, NULL, NULL, 10700000, 112990000, 'Jatiasih', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-29 14:25:48', '2026-06-29 14:25:48', '05-PU FD 2026'),
(12, 'DB601630', '2026-02-27', NULL, NULL, NULL, NULL, NULL, 'PQ5FX00002GXATS', 'GRAND-VITARA', 'PRL.MIDNIGHT BLACK', 2025, 'MA3TYKL1SST', '106176', 'K15CN', '7817393', NULL, NULL, 347430000, 1665000, NULL, 20700000, 328395000, 'Cinere', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-29 14:28:38', '2026-06-29 14:28:38', 'MC GX AT 2025'),
(13, 'DB602514', '2026-03-04', NULL, NULL, NULL, NULL, NULL, 'XL7415F.34GSATT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '100135', 'K15BT', '1739354', 'SUDAH NAIK HO', 'JUNI 2026', 259550000, 1656815, NULL, 10700000, 250506815, 'CIANJUR', NULL, 'sold', NULL, 'NURRAHMAT [0064174]', '2026-08-08 00:00:00', 'CIANJUR', NULL, NULL, '2026-06-29 14:32:03', '2026-08-10 09:41:54', '03 ALPHA AT HYBRID 2TONE 2026'),
(14, 'DB603261', '2026-03-06', NULL, NULL, NULL, NULL, NULL, 'XL7415F.24GSMTT', 'NEW XL-7', 'COOL BLACK MET', 2026, 'MHYANC32STJ', '100863', 'K15BT', '1748756', NULL, NULL, 248300000, NULL, NULL, 10700000, 237600000, 'Cianjur', NULL, 'sold', NULL, 'RISTININGSIH [0062986]', '2026-06-10', 'Cianjur', NULL, NULL, '2026-06-29 14:34:31', '2026-06-29 14:34:31', '03 ALPHA MT HYBRID 2026'),
(15, 'DB603895', '2026-03-11', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00GLATS', 'FRONX', 'COOL BLACK MET', 2025, 'MHYMWDA3SSJ', '102841', 'K15BT', '1715736', NULL, NULL, 227600000, 1351037, NULL, 10700000, 218251037, 'CIAWI', NULL, 'matching', NULL, 'DWI', '2026-08-21 00:00:00', 'CIAWI', NULL, NULL, '2026-06-29 14:42:02', '2026-08-21 13:50:35', 'GL AT'),
(16, 'DB603896', '2026-03-11', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00GLATS', 'FRONX', 'COOL BLACK MET', 2025, 'MHYMWDA3SSJ', '102880', 'K15BT', '1716588', NULL, NULL, 227600000, 1351037, NULL, 10700000, 218251037, 'Cianjur', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-29 14:59:38', '2026-06-29 14:59:38', 'GL AT'),
(17, 'DB588611 (BIT)', '2026-03-27', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00GXATS', 'FRONX', 'COOL BLACK MET', 2025, 'MHYMWDB3SSJ', '107860', 'K15C-', '1087232', NULL, NULL, 246340000, 1351037, 1000000, 5000000, 243691037, 'Ciawi', NULL, 'sold', NULL, 'MOHAMAD RIZAL [0063502]', '2026-06-13', 'Ciawi', NULL, NULL, '2026-06-29 15:07:52', '2026-07-01 16:29:57', 'HYBRID GX AT'),
(18, 'DB606074', '2026-03-30', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '279587', 'K15BT', '1753624', 'SUDAH NAIK HO', '31-MAR-26', 123690000, NULL, NULL, 10700000, 112990000, 'Ciawi', NULL, 'free', NULL, NULL, NULL, 'HO', NULL, NULL, '2026-06-29 15:13:57', '2026-06-29 15:13:57', '05-PU FD 2026'),
(19, 'DB606257', '2026-03-30', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '280004', 'K15BT', '1753960', NULL, NULL, 123690000, NULL, NULL, 10700000, 112990000, 'Cianjur', NULL, 'sold', NULL, 'BUNYAMIN BN ABDULLAH [0063511]', '2026-06-17', 'Cianjur', NULL, NULL, '2026-06-29 15:19:34', '2026-06-29 15:19:34', '05-PU FD 2026'),
(20, 'DB606803', '2026-04-06', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '280297', 'K15BT', '1754764', NULL, NULL, 123690000, NULL, NULL, 10700000, 112990000, 'Cianjur', NULL, 'sold', NULL, 'SRI  MARYATI [0063521]', '2026-06-09', 'Cianjur', NULL, NULL, '2026-06-29 15:21:34', '2026-06-29 15:21:34', '05-PU FD 2026'),
(21, 'DB606845', '2026-04-07', NULL, NULL, NULL, NULL, NULL, 'XL7415F.44HBATT', 'NEW XL-7', 'COOL BLACK MET', 2026, 'MHYANC32STJ', '101368', 'K15BT', '1754547', NULL, NULL, 262470000, 1656815, NULL, 9700000, 254426815, 'Cianjur', NULL, 'sold', NULL, 'HERLIAWAN HERWANDI [0063334]', '2026-06-04', 'Cianjur', NULL, NULL, '2026-06-29 15:25:46', '2026-06-29 15:26:39', '03 KURO EDITION AT HYBRID 2026'),
(22, 'DB607651', '2026-04-09', NULL, NULL, NULL, NULL, NULL, 'XL7415F.34GSATT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '101270', 'K15BT', '1752739', NULL, NULL, 259550000, 1656815, NULL, 10700000, 250506815, 'Cianjur', NULL, 'sold', NULL, 'ITA PERMATASARI [0063206]', '2026-06-23', 'Cianjur', NULL, NULL, '2026-06-29 15:28:47', '2026-06-29 15:28:47', '03 ALPHA AT HYBRID 2TONE 2026'),
(23, 'DB608887', '2026-04-14', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '281619', 'K15BT', '1756871', NULL, NULL, 123690000, NULL, NULL, 10700000, 112990000, 'Cianjur', NULL, 'sold', NULL, 'ENDANG [0062388]', '2026-06-06', 'Cianjur', NULL, NULL, '2026-06-29 15:31:03', '2026-06-29 15:31:03', '05-PU FD 2026'),
(24, 'DB610127', '2026-04-21', NULL, NULL, NULL, NULL, NULL, 'AEV415W.46WDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '282960', 'K15BT', '1758736', NULL, NULL, 131070000, NULL, NULL, 10700000, 120370000, 'Cianjur', NULL, 'free', NULL, 'PAMERAN PASAR INDUK CIANJUR', NULL, 'Cianjur', NULL, NULL, '2026-06-29 15:33:21', '2026-06-29 15:34:01', '05-PU WD AC PS 2026'),
(25, 'DB611154', '2026-04-24', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '283265', 'K15BT', '1759416', NULL, NULL, 130220000, NULL, NULL, 10700000, 119520000, 'Cianjur', NULL, 'sold', NULL, 'TEDI SUTANDI [0063460]', '2026-06-04', 'Cianjur', NULL, NULL, '2026-06-29 15:36:50', '2026-06-29 15:37:31', '05-PU FD AC PS 2026'),
(26, 'DB611195', '2026-04-24', NULL, NULL, NULL, NULL, NULL, 'XL7415F.44HBATT', 'NEW XL-7', 'COOL BLACK MET', 2026, 'MHYANC32STJ', '101819', 'K15BT', '1757547', NULL, NULL, 262470000, 1656815, NULL, 9700000, 254426815, 'JATIASIH', NULL, 'sold', NULL, 'ARIF RAKHMAN [0063904]', '2026-07-20 00:00:00', 'JATIASIH', NULL, NULL, '2026-06-29 15:39:29', '2026-07-21 10:42:53', '03 KURO EDITION AT HYBRID 2026'),
(27, 'DB613301', '2026-04-30', NULL, NULL, NULL, NULL, NULL, 'AEV415C.36CHMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '284120', 'K15BT', '1760692', NULL, NULL, 109460000, NULL, NULL, 5700000, 103760000, 'Cianjur', 'KAROSERI ANGKOT', 'sold', NULL, 'MUHAMAD RIDWAN YULIANDI [0036193]', '2026-06-18', 'Cianjur', NULL, NULL, '2026-06-29 15:41:36', '2026-06-29 15:46:04', '05-CH-PASSENGER 2026'),
(28, 'DB614074', '2026-05-09', NULL, NULL, NULL, NULL, NULL, 'AEV415C.46CHMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '285190', 'K15BT', '1761000', 'SUDAH NAIK CIAWI', 'MEI 2026', 116990000, NULL, NULL, 5700000, 111290000, 'Ciawi', 'KAROSERI MINI BUS', 'sold', NULL, 'NURHAYATI [0062887]', '2026-06-29', 'Ciawi', NULL, NULL, '2026-06-29 15:45:38', '2026-07-01 15:15:24', '05-CH AC PS-PASSENGER 2026'),
(29, 'DB615047', '2026-05-13', NULL, NULL, NULL, NULL, NULL, 'A3L415FM10GLATT', 'FRONX', 'MET.MAGMA GRAY 2', 2026, 'MHYMWDA3STJ', '100394', 'K15BT', '1764062', NULL, NULL, 229300000, 1351037, NULL, 11700000, 218951037, 'Jatiasih', NULL, 'sold', NULL, 'IR DANI KUSWARDANI QQ RANI FEBRIUTAMI [0063485]', '2026-06-06', 'Jatiasih', NULL, NULL, '2026-06-29 15:48:58', '2026-07-02 11:22:24', 'GL AT 2026'),
(30, 'DB615792', '2026-05-18', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '286311', 'K15BT', '1764951', 'SUDAH NAIK CINERE', 'MEI 2026', 130360000, NULL, NULL, 10700000, 119660000, 'CIANJUR', NULL, 'sold', NULL, 'DAMAN, A.MD [0064348]', '2026-08-19 00:00:00', 'CIANJUR', NULL, NULL, '2026-06-29 15:53:01', '2026-08-20 08:34:08', '05-PU FD AC PS 2026'),
(31, 'DB615842', '2026-05-18', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'GRAPHITE GREY METALLIC', 2026, 'MHYHDC61TTJ', '286079', 'K15BT', '1764537', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Ciawi', NULL, 'sold', NULL, 'MISNAN BT.NASIN [0031449]', '2026-06-19', 'Ciawi', NULL, NULL, '2026-06-29 15:56:46', '2026-07-01 16:33:40', '05-PU FD AC PS 2026'),
(32, 'DB616316', '2026-05-19', NULL, NULL, NULL, NULL, NULL, 'XL7415F.34GSATT', 'NEW XL-7', 'WHITE + BLACK TOP', 2026, 'MHYANC32STJ', '102677', 'K15BT', '1763469', NULL, NULL, 260000000, 1656815, NULL, 10700000, 250956815, 'Jatiasih', NULL, 'sold', NULL, 'PT RIKSA MITRA PERKASA [0063666', '2026-06-23', 'Jatiasih', NULL, NULL, '2026-06-29 15:59:27', '2026-06-29 15:59:27', '03 ALPHA AT HYBRID 2TONE 2026'),
(33, 'DB616234', '2026-05-19', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '286068', 'K15BT', '1764340', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'Cianjur', NULL, 'sold', NULL, 'DEN RIFAL ARDIAN [0063555]', '2026-06-18', 'Cianjur', NULL, NULL, '2026-06-29 16:01:43', '2026-06-29 16:01:43', '05-PU FD 2026'),
(34, 'DB616236', '2026-05-19', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '286290', 'K15BT', '1764887', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'Ciawi', NULL, 'sold', NULL, 'GEGE VILLA QQ CV.BERKAT ABADI GLOBAL [0038463]', '2026-06-05', 'Ciawi', NULL, NULL, '2026-06-29 16:13:02', '2026-07-01 16:56:50', '05-PU FD 2026'),
(35, 'DB616237', '2026-05-19', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '286308', 'K15BT', '1764931', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'Cianjur', NULL, 'sold', NULL, 'IRPAN ANDRIANSYAH [0060187]', '2026-06-05', 'Cianjur', NULL, NULL, '2026-06-29 16:15:45', '2026-06-29 16:15:45', '05-PU FD 2026'),
(36, 'DB616243', '2026-05-19', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '286100', 'K15BT', '1764377', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'Cianjur', NULL, 'sold', NULL, 'AWA USMAN WAKUN [0063591]', '2026-06-15', 'Cianjur', NULL, NULL, '2026-06-29 16:17:28', '2026-06-29 16:17:28', '05-PU FD 2026'),
(37, 'DB616244', '2026-05-19', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '286175', 'K15BT', '1764705', 'SUDAH NAIK CIANJUR', 'MEI 2026', 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'WANDI SETIAWAN [0064151]', '2026-07-31 00:00:00', 'CIANJUR', NULL, NULL, '2026-06-29 16:19:52', '2026-07-31 13:56:11', '05-PU FD 2026'),
(38, 'DB616245', '2026-05-19', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '285915', 'K15BT', '1764144', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'Cianjur', NULL, 'sold', NULL, 'AGUS GUNDARA [0046634]', '2026-06-09', 'Cianjur', NULL, NULL, '2026-06-30 08:52:35', '2026-06-30 08:52:35', '05-PU FD 2026'),
(39, 'DB616252', '2026-05-19', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '286600', 'K15BT', '1765533', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIAWI', NULL, 'sold', NULL, 'RISMAN SOLEHUDIN QQ PT MALIKA JAYA TRUSS [0059103]', '2026-07-16 00:00:00', 'CIAWI', NULL, NULL, '2026-06-30 08:54:31', '2026-07-17 08:24:58', '05-PU FD AC PS 2026'),
(40, 'DB616254', '2026-05-19', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '286604', 'K15BT', '1765528', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Cianjur', NULL, 'sold', NULL, 'ASEP YADIN APANDI [0063512]', '2026-06-08', 'Cianjur', NULL, NULL, '2026-06-30 08:57:15', '2026-06-30 08:57:15', '05-PU FD AC PS 2026'),
(41, 'DB616700', '2026-05-20', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '286866', 'K15BT', '1765993', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'Cianjur', NULL, 'sold', NULL, 'HJ SUHERA [0063562]', '2026-06-19', 'Cianjur', NULL, NULL, '2026-06-30 08:59:00', '2026-06-30 08:59:00', '05-PU FD 2026'),
(42, 'DB616702', '2026-05-20', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '286781', 'K15BT', '1765784', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'Cianjur', NULL, 'sold', NULL, 'ASEP SUPRIATNA [0063451]', '2026-06-19', 'Cianjur', NULL, NULL, '2026-06-30 09:01:07', '2026-06-30 09:01:07', '05-PU FD 2026'),
(43, 'DB616703', '2026-05-20', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '286805', 'K15BT', '1765781', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'Ciawi', NULL, 'sold', NULL, 'MUHAMMAD GIGIH WIJAYA [0058000]', '2026-06-08', 'Ciawi', NULL, NULL, '2026-06-30 09:20:11', '2026-07-01 16:56:28', '05-PU FD 2026'),
(44, 'DB616704', '2026-05-20', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '286706', 'K15BT', '1765607', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'Cianjur', NULL, 'sold', NULL, 'JAELANI SIDIK [0031159]', '2026-06-23', 'Cianjur', NULL, NULL, '2026-06-30 09:22:05', '2026-06-30 09:22:05', '05-PU FD 2026'),
(45, 'DB616705', '2026-05-20', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '286854', 'K15BT', '1765904', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIANJUR', NULL, 'sold', NULL, 'FAHMY YUZA PRATAMA [0063520]', '2026-07-04 00:00:00', 'CIANJUR', NULL, NULL, '2026-06-30 09:24:33', '2026-07-13 16:26:51', '05-PU FD AC PS 2026'),
(46, 'DB616706', '2026-05-20', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '286838', 'K15BT', '1765982', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Ciawi', NULL, 'sold', NULL, 'H.YUSAN PRIYATNA [0063501]', '2026-06-06', 'Ciawi', NULL, NULL, '2026-06-30 09:29:27', '2026-06-30 09:29:27', '05-PU FD AC PS 2026'),
(47, 'DB616707', '2026-05-20', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '286858', 'K15BT', '1766042', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIANJUR', NULL, 'sold', NULL, 'ASEP ABDURAHMAN [0063887]', '2026-07-20 00:00:00', 'CIANJUR', NULL, NULL, '2026-06-30 09:39:16', '2026-07-21 10:37:31', '05-PU FD AC PS 2026'),
(48, 'DB616708', NULL, NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '286872', 'K15BT', '1766046', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, NULL, NULL, 'sold', NULL, 'KOPERASI KONSUMEN SUMBER ALAM [0063761]', '2026-06-27 00:00:00', NULL, NULL, NULL, '2026-06-30 09:40:45', '2026-07-04 11:00:17', '05-PU FD AC PS 2026'),
(49, 'DB616709', '2026-05-20', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '286863', 'K15BT', '1766055', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Cinere', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-30 09:42:23', '2026-06-30 09:42:23', '05-PU FD AC PS 2026'),
(50, 'DB616688', '2026-05-20', NULL, NULL, NULL, NULL, NULL, 'XL7415F.54HBATT', 'NEW XL-7', 'WHITE + BLACK TOP', 2026, 'MHYANC32STJ', '102563', 'K15BT', '1762824', NULL, NULL, 264940000, 1656815, NULL, 9700000, 256896815, 'Ciawi', NULL, 'sold', NULL, 'RONI HANDOYO [0063446]', '2026-06-13', 'Ciawi', NULL, NULL, '2026-06-30 09:46:30', '2026-07-01 16:54:44', '03 KURO EDITION AT HYBRID 2TONE 2026'),
(51, 'DB616690', '2026-05-20', NULL, NULL, NULL, NULL, NULL, 'XL7415F.54HBATT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '102839', 'K15BT', '1764783', NULL, NULL, 264940000, 1656815, NULL, 9700000, 256896815, 'Cianjur', NULL, 'sold', NULL, 'SRI NURHAYATI [0042761]', '2026-06-08', 'Cianjur', NULL, NULL, '2026-06-30 09:49:14', '2026-06-30 09:49:14', '03 KURO EDITION AT HYBRID 2TONE 2026'),
(52, 'DB616743', '2026-05-20', NULL, NULL, NULL, NULL, NULL, 'XL7415F.34GSATT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '102777', 'K15BT', '1764415', NULL, NULL, 260000000, 1656815, NULL, 10700000, 250956815, 'Ciawi', NULL, 'sold', NULL, 'FARAH FAHRIYATUN MUFIDAH [0063629]', '2026-06-17', 'Ciawi', NULL, NULL, '2026-06-30 09:52:59', '2026-07-01 16:54:07', '03 ALPHA AT HYBRID 2TONE 2026'),
(53, 'DB616795', '2026-05-20', NULL, NULL, NULL, NULL, NULL, 'PQ5FX00012GXATS', 'GRAND-VITARA', 'PRL.ARCTIC WHITE/PRL.MIDNIGHT BLACK', 2025, 'MA3TYKL1SST', '106401', 'K15CN', '7839448', NULL, NULL, 350330000, 1665000, NULL, 20700000, 331295000, 'Ciawi', NULL, 'sold', NULL, 'HUDRI QQ NURHAYATI [0052248]', '2026-06-09', 'Ciawi', NULL, NULL, '2026-06-30 09:58:01', '2026-07-01 16:32:42', 'MC GX AT 2TONE'),
(54, 'DB616952', '2026-05-21', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'GRAPHITE GREY METALLIC', 2026, 'MHYHDC61TTJ', '287048', 'K15BT', '1765575', NULL, NULL, 130360000, 1656815, NULL, 10700000, 121316815, 'Cianjur', NULL, 'sold', NULL, 'JAPAR MUBAROK [0063475]', '2026-06-05', 'Cianjur', NULL, NULL, '2026-06-30 10:08:23', '2026-06-30 10:08:23', '05-PU FD AC PS 2026'),
(55, 'DB617099', '2026-05-21', NULL, NULL, NULL, NULL, NULL, 'XL7415F.34GSMTT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '102781', 'K15BT', '1764372', 'SUDAH NAIK CIAWI', 'MEI 2026', 250780000, 1656815, NULL, 10700000, 241736815, 'Ciawi', NULL, 'sold', NULL, 'MOCH ALDI KURNIAWAN [0063393]', '2026-06-22', 'Ciawi', NULL, NULL, '2026-06-30 10:13:23', '2026-07-01 16:32:14', '03 ALPHA MT HYBRID 2TONE 2026'),
(56, 'DB617100', '2026-05-21', NULL, NULL, NULL, NULL, NULL, 'XL7415F.34GSMTT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '102804', 'K15BT', '1764466', 'SUDAH NAIK CINERE', 'MEI 2026', 250780000, 1656815, NULL, 10700000, 241736815, 'Cianjur', NULL, 'sold', NULL, 'ROHMATULOH [0063438]', '2026-06-25', 'Cianjur', NULL, NULL, '2026-06-30 10:16:23', '2026-07-01 15:18:02', '03 ALPHA MT HYBRID 2TONE 2026'),
(57, 'DB617101', NULL, NULL, NULL, NULL, NULL, NULL, 'XL7415F.34GSMTT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '102579', 'K15BT', '1762724', 'SUDAH NAIK CINERE', 'MEI 2026', 250780000, 1656815, NULL, 10700000, 241736815, NULL, NULL, 'sold', NULL, 'PT DARYA VARIA LABORATORIA TBK [0061132]', '2026-06-29 00:00:00', 'CINERE', NULL, NULL, '2026-06-30 10:25:07', '2026-07-04 10:59:19', '03 ALPHA MT HYBRID 2TONE 2026'),
(58, 'DB617122', '2026-05-21', NULL, NULL, NULL, NULL, NULL, 'A3L415FM10GLATT', 'FRONX', 'MET.MAGMA GRAY 2', 2026, 'MHYMWDA3STJ', '100425', 'K15BT', '1765789', NULL, NULL, 229300000, 1351037, NULL, 11700000, 218951037, 'Ciawi', NULL, 'sold', NULL, 'TATI NURHARTATI [0037001]', '2026-06-22', 'Ciawi', NULL, NULL, '2026-06-30 10:29:43', '2026-07-01 16:31:52', 'GL AT 2026'),
(59, 'DB617689', '2026-05-25', NULL, NULL, NULL, NULL, NULL, 'PQ5FX00002GXATS', 'GRAND-VITARA', 'PRL.MIDNIGHT BLACK', 2025, 'MA3TYKL1SST', '106171', 'K15CN', '7811257', NULL, NULL, 347430000, 1665000, NULL, 20700000, 328395000, 'Jatiasih', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-30 10:35:16', '2026-06-30 10:35:16', 'MC GX AT 2025'),
(60, 'DB617978', '2026-05-26', NULL, NULL, NULL, NULL, NULL, 'XL7415F.24GXATT', 'NEW XL-7', 'SNOW WHITE', 2026, 'MHYANC32STJ', '103053', 'K15BT', '1766696', 'SUDAH NAIK HO', 'JUNI 2026', 247460000, 1656815, NULL, 10700000, 238416815, 'Ciawi', NULL, 'free', NULL, NULL, NULL, 'HO', NULL, NULL, '2026-06-30 10:37:27', '2026-07-02 11:50:35', '03 BETA AT HYBRID 2026'),
(61, 'DB617979', '2026-05-26', NULL, NULL, NULL, NULL, NULL, 'XL7415F.24GXATT', 'NEW XL-7', 'SNOW WHITE', 2026, 'MHYANC32STJ', '103101', 'K15BT', '1767189', NULL, NULL, 247460000, 1656815, NULL, 10700000, 238416815, 'CINERE', NULL, 'sold', NULL, 'AGUS LUTFI SAPUTRA QQ ROHMIYATI [0064074]', '2026-07-31 00:00:00', 'CINERE', NULL, NULL, '2026-06-30 10:42:31', '2026-08-04 10:30:38', '03 BETA AT HYBRID 2026'),
(62, 'DB617981', '2026-05-26', NULL, NULL, NULL, NULL, NULL, 'AEV415W.46WDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '287629', 'K15BT', '1767472', NULL, NULL, 131210000, NULL, NULL, 10700000, 120510000, 'Cianjur', NULL, 'sold', NULL, 'ANTHONY HERMAWAN [0062291]', '2026-06-12', 'Cianjur', NULL, NULL, '2026-06-30 10:58:07', '2026-07-02 11:23:39', '05-PU WD AC PS 2026'),
(63, 'DB528186', '2025-01-30', NULL, NULL, NULL, NULL, NULL, 'BU4FL0000001ATR', 'S-PRESSO', 'WHITE', 2024, 'MA3RFL61SRA', '525148', 'K10CNC', '692020', 'SUDAH NAIK', 'JAN-26', 148700000, NULL, NULL, 5700000, 143000000, 'Jatiasih', NULL, 'free', NULL, NULL, NULL, NULL, 'BANJIR', NULL, '2026-06-30 11:11:44', '2026-06-30 11:11:44', '02 AT'),
(64, 'DB617982', '2026-05-26', NULL, NULL, NULL, NULL, NULL, 'AEV415W.46WDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '287758', 'K15BT', '1767624', NULL, NULL, 131210000, NULL, NULL, 10700000, 120510000, 'Ciawi', NULL, 'sold', NULL, 'BUDIYANTO [0063582]', '2026-06-13', 'Ciawi', NULL, NULL, '2026-06-30 14:46:02', '2026-07-01 16:31:13', '05-PU WD AC PS 2026'),
(65, 'DB617984', '2026-05-26', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '287624', 'K15BT', '1767489', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Cianjur', NULL, 'sold', NULL, 'LUKMAN [0063549]', '2026-06-10', 'Cianjur', NULL, NULL, '2026-06-30 14:47:59', '2026-06-30 14:47:59', '05-PU FD AC PS 2026'),
(66, 'DB618141', '2026-05-26', NULL, NULL, NULL, NULL, NULL, 'ARK415FM05GLATT', 'ALL NEW ERTIGA', 'SNOW WHITE', 2026, 'MHYANC22STJ', '101292', 'K15BT', '1763493', NULL, NULL, 215590000, 1549815, NULL, 10700000, 206439815, 'Ciawi', NULL, 'sold', NULL, 'ANDIKA WIRYAWARDHANA [0063482]', '2026-06-08', 'Ciawi', NULL, NULL, '2026-06-30 14:51:05', '2026-07-01 16:30:41', '05 GL AT'),
(67, 'DB618525', '2026-05-28', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '287925', 'K15BT', '1766753', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Ciawi', NULL, 'sold', NULL, 'WINI NURFRIDAYUNI SURYANA,S.SI [0061478]', '2026-06-18', 'Ciawi', NULL, NULL, '2026-06-30 14:53:19', '2026-07-01 16:29:31', '05-PU FD AC PS 2026'),
(68, 'DB618484', '2026-05-28', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00GLMTS', 'FRONX', 'SNOW WHITE', 2025, 'MHYMWDA3SSJ', '100741', 'K15BT', '1696284', NULL, NULL, 219100000, 1151037, NULL, 10700000, 209551037, 'Cinere', NULL, 'sold', NULL, 'BETAMIA PERMATA [0063443]', '2026-06-05', 'Cinere', NULL, NULL, '2026-06-30 14:56:28', '2026-06-30 14:56:28', 'GL MT'),
(69, 'DB618486', '2026-05-28', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '288203', 'K15BT', '1768351', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Cianjur', NULL, 'sold', NULL, 'HERLAN MAULANA [0063571]', '2026-06-13', 'Cianjur', NULL, NULL, '2026-06-30 15:00:56', '2026-06-30 15:00:56', '05-PU FD AC PS 2026'),
(70, 'DB618487', '2026-05-28', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '288055', 'K15BT', '1768065', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CINERE', NULL, 'sold', NULL, 'SUNARSIH [0063960]', '2026-07-15 00:00:00', 'CINERE', NULL, NULL, '2026-06-30 15:07:49', '2026-07-16 08:31:16', '05-PU FD AC PS 2026'),
(71, 'DB618807', '2026-05-29', NULL, NULL, NULL, NULL, NULL, 'AEV415W.46WDMTT', 'NEW CARRY', 'GRAPHITE GREY METALLIC', 2026, 'MHYHDC61TTJ', '288127', 'K15BT', '1767932', NULL, NULL, 131210000, NULL, NULL, 10700000, 120510000, 'Jatiasih', NULL, 'sold', NULL, 'MUHAMMAD FEBRIRIYANTO [0063641]', '2026-06-18', 'Jatiasih', NULL, NULL, '2026-06-30 15:09:27', '2026-06-30 15:09:27', '05-PU WD AC PS 2026'),
(72, 'DB618843', '2026-05-29', NULL, NULL, NULL, NULL, NULL, '6N415VX00012ATS', 'JIMNY', 'MET.CHIFFON IVORY 2/PRL.BLUISH 4', 2025, 'MA3JJC74WS0', '223844', 'K15BN', '4450646', NULL, NULL, 393420000, 4104891, NULL, 5700000, 391824891, 'Ciawi', NULL, 'sold', NULL, 'AZIS MUHAEMIN [0063406]', '2026-06-06', 'Ciawi', NULL, NULL, '2026-06-30 15:12:56', '2026-07-01 16:28:51', '5 DOORS 2TONE AT 2025'),
(73, 'DB618993', '2026-05-29', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '288134', 'K15BT', '1768186', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'SANTI DEWI [0063823]', '2026-07-09 00:00:00', 'CIANJUR', NULL, NULL, '2026-06-30 15:15:51', '2026-07-10 13:46:33', '05-PU FD 2026'),
(74, 'DB619023', '2026-05-29', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '288311', 'K15BT', '1768488', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Cianjur', NULL, 'sold', NULL, 'YADI [0063560]', '2026-06-15', 'Cianjur', NULL, NULL, '2026-06-30 15:17:32', '2026-06-30 15:17:32', '05-PU FD AC PS 2026'),
(75, 'DB619024', '2026-05-29', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'GRAPHITE GREY METALLIC', 2026, 'MHYHDC61TTJ', '287915', 'K15BT', '1768616', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Cianjur', NULL, 'sold', NULL, 'EDI SUHAEDI [0063455]', '2026-06-08', 'Cianjur', NULL, NULL, '2026-06-30 15:19:41', '2026-06-30 15:19:41', '05-PU FD AC PS 2026'),
(76, 'DB619025', '2026-05-29', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'GRAPHITE GREY METALLIC', 2026, 'MHYHDC61TTJ', '288286', 'K15BT', '1768361', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Cianjur', NULL, 'sold', NULL, 'ANWAR SOLEHUDIN [0063563]', '2026-06-12', 'Cianjur', NULL, NULL, '2026-06-30 15:22:34', '2026-06-30 15:22:34', '05-PU FD AC PS 2026'),
(77, 'DB619316', '2026-05-30', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00SXATS', 'FRONX', 'SAVANA IVORY', 2025, 'MHYMWDB3SSJ', '108987', 'K15C-', '1087773', NULL, NULL, 278980000, 1351037, NULL, 10700000, 269631037, 'Ciawi', NULL, 'sold', NULL, 'CV MAWAR CIPTA MANDIRI [0063187]', '2026-06-06', 'Ciawi', NULL, NULL, '2026-06-30 15:24:23', '2026-07-01 16:02:52', 'HYBRID SGX AT'),
(78, 'DB619317', '2026-05-30', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00SXATS', 'FRONX', 'SNOW WHITE', 2025, 'MHYMWDB3SSJ', '108039', 'K15C-', '1088148', NULL, NULL, 278980000, 1351037, NULL, 10700000, 269631037, 'Cianjur', NULL, 'sold', NULL, 'RENI PRIHATINI, SP [0063689]', '2026-06-30', 'Cianjur', NULL, NULL, '2026-06-30 15:26:29', '2026-07-01 15:21:03', 'HYBRID SGX AT'),
(79, 'DB620001', '2026-06-05', NULL, NULL, NULL, NULL, NULL, 'XL7415F.24GLATT', 'NEW XL-7', 'SNOW WHITE', 2026, 'MHYANC22STJ', '101503', 'K15BT', '1768357', NULL, NULL, 223670000, 1656815, NULL, 10700000, 214626815, 'Cianjur', NULL, 'sold', NULL, 'MOCHAMAD OHAL FALAQ [0063209]', '2026-06-08', 'Cianjur', NULL, NULL, '2026-06-30 15:30:09', '2026-06-30 15:30:52', '03 ZETA AT 2026'),
(80, 'DB620002', '2026-06-05', NULL, NULL, NULL, NULL, NULL, 'XL7415F.24GLATT', 'NEW XL-7', 'MET.MAGMA GRAY 2', 2026, 'MHYANC22STJ', '101519', 'K15BT', '1768443', NULL, NULL, 223670000, 1656815, NULL, 10700000, 214626815, 'Ciawi', NULL, 'sold', NULL, 'AGUS RUSMIYANTO [0063449]', '2026-06-22', 'Ciawi', NULL, NULL, '2026-06-30 15:32:33', '2026-07-01 16:02:25', '03 ZETA AT 2026'),
(81, 'DB619913', '2026-06-05', NULL, NULL, NULL, NULL, NULL, 'A3L415FM10GLATT', 'FRONX', 'SNOW WHITE', 2026, 'MHYMWDA3STJ', '100533', 'K15BT', '1768354', NULL, NULL, 229300000, 1351037, NULL, 11700000, 218951037, 'Ciawi', NULL, 'sold', NULL, 'ISMI LAILA [0063389]', '2026-06-09', 'Ciawi', NULL, NULL, '2026-06-30 15:34:53', '2026-07-01 16:01:28', '05 GL AT'),
(83, 'DB620309', '2026-06-08', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '288953', 'K15BT', '1769655', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Cianjur', NULL, 'sold', NULL, 'DEDE YUSUP [0063448]', '2026-06-25', 'Cianjur', NULL, NULL, '2026-06-30 15:39:53', '2026-07-01 15:22:15', '05-PU FD AC PS 2026'),
(84, 'DB620485', '2026-06-08', NULL, NULL, NULL, NULL, NULL, 'GC415V.M71BVMTT', 'APV', 'WHITE', 2026, 'MHYGDN41VTJ', '400623', 'G15AID', '454401', NULL, NULL, 134220000, NULL, NULL, 700000, 133520000, 'Cianjur', NULL, 'sold', NULL, 'DEDE YUSUP [0059441]', '2026-06-09', 'Cianjur', NULL, NULL, '2026-06-30 15:46:21', '2026-06-30 15:46:21', 'FE GE PS DEL.VAN MT (BLINDVAN)'),
(85, 'DB620650', '2026-06-10', NULL, NULL, NULL, NULL, NULL, '6N415VX00011ATS', 'JIMNY', 'SLD JUNGLE GREEN 2', 2025, 'MA3JJC74WS0', '224976', 'K15BN', '4451598', NULL, NULL, 390640000, 4104891, NULL, 5700000, 389044891, 'Ciawi', NULL, 'sold', NULL, 'JULIA CHATRIN MAHARANI DJAHAR [0063452]', '2026-06-11', 'Ciawi', NULL, NULL, '2026-06-30 15:48:08', '2026-07-01 16:00:21', '5 DOORS AT 2025'),
(86, 'DB620651', '2026-06-10', NULL, NULL, NULL, NULL, NULL, '6N415VX00012ATS', 'JIMNY', 'SLD.KINETIC YELLOW 2/PRL.BLUISH BLACK 4', 2025, 'MA3JJC74WS0', '219623', 'K15BN', '4445704', NULL, NULL, 393420000, 4104891, NULL, 5700000, 391824891, 'Cinere', NULL, 'sold', NULL, 'PT MAHARDIKA DAMAI SEJAHTERA [0063590]', '2026-06-13', 'Cinere', NULL, NULL, '2026-06-30 16:10:17', '2026-06-30 16:10:17', '5 DOORS 2TONE AT 2025'),
(87, 'DB620652', '2026-06-10', NULL, NULL, NULL, NULL, NULL, '6N415VX00012ATS', 'JIMNY', 'MET.CHIFFON IVORY2/PRL.BLUISH 4', 2025, 'MA3JJC74WS0', '220323', 'K15BN', '4446879', NULL, NULL, 393420000, 4104891, NULL, 5700000, 391824891, 'JATIASIH', NULL, 'sold', NULL, 'EDY HERIYANTO [0064281]', '2026-08-12 00:00:00', 'JATIASIH', NULL, NULL, '2026-06-30 16:13:02', '2026-08-13 10:53:54', '5 DOORS 2TONE AT 2025'),
(88, 'DB620653', '2026-06-10', NULL, NULL, NULL, NULL, NULL, '6N415VX00012ATS', 'JIMNY', 'MET.CHIFFON IVORY 2/PRL.BLUISH 4', 2025, 'MA3JJC74WS0', '220185', 'K15BN', '4446666', NULL, NULL, 393420000, 4104891, NULL, 5700000, 391824891, 'Cinere', NULL, 'sold', NULL, 'LINDA GUSVANA [0063243]', '2026-06-15', 'Ciawi', NULL, NULL, '2026-07-01 09:18:43', '2026-07-01 09:18:43', '5 DOORS 2TONE AT 2025'),
(89, 'DB620875', '2026-06-10', NULL, NULL, NULL, NULL, NULL, 'XL7415F.24GLATT', 'NEW XL-7', 'SNOW WHITE', 2026, 'MHYANC22STJ', '101629', 'K15BT', '1770358', NULL, NULL, 223670000, 1656815, NULL, 10700000, 214626815, 'Cinere', NULL, 'sold', NULL, 'ALBERT TUMEWU [0063259]', '2026-06-11', 'Cinere', NULL, NULL, '2026-07-01 09:20:36', '2026-07-01 09:20:36', '03 ZETA AT 2026'),
(90, 'DB620899', '2026-06-10', NULL, NULL, NULL, NULL, NULL, 'XL7415F.24GXATT', 'NEW XL-7', 'SNOW WHITE', 2026, 'MHYANC32STJ', '103348', 'K15BT', '1768946', NULL, NULL, 247460000, 1656815, NULL, 10700000, 238416815, 'CIPANAS', NULL, 'free', NULL, NULL, NULL, NULL, 'DISLPAY CIANJUR', NULL, '2026-07-01 09:22:32', '2026-07-17 10:38:30', '03 BETA AT HYBRID 2026'),
(91, 'DB620900', '2026-06-10', NULL, NULL, NULL, NULL, NULL, 'XL7415F.34GSATT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '102576', 'K15BT', '1762866', NULL, NULL, 260000000, 1656815, NULL, 10700000, 250956815, 'Ciawi', NULL, 'sold', NULL, 'ITA PUSPITASARI [0063648]', '2026-06-23', 'Ciawi', NULL, NULL, '2026-07-01 09:24:40', '2026-07-01 09:24:40', '03 ALPHA AT HYBRID 2TONE'),
(92, 'DB620901', '2026-06-10', NULL, NULL, NULL, NULL, NULL, 'XL7415F.34GSATT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '102585', 'K15BT', '1762901', 'SUDAH NAIK HO', 'JUNI 2026', 260000000, 1656815, NULL, 10700000, 250956815, 'JATIASIH', NULL, 'sold', NULL, 'ELISA JUITA SE [0064192]', '2026-08-04 00:00:00', 'CINERE', NULL, NULL, '2026-07-01 09:26:18', '2026-08-05 09:58:29', '03 ALPHA AT HYBRID 2TONE 2026'),
(93, 'DB620902', '2026-06-10', NULL, NULL, NULL, NULL, NULL, 'XL7415F.34GSATT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '102587', 'K15BT', '1762909', NULL, NULL, 260000000, 1656815, NULL, 10700000, 250956815, 'CIAWI', NULL, 'sold', NULL, 'DINI KARTIKA [0029663]', '2026-08-20 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 09:28:09', '2026-08-21 08:31:45', '03 ALPHA AT HYBRID 2TONE 2026'),
(94, 'DB620903', '2026-06-10', NULL, NULL, NULL, NULL, NULL, 'XL7415F.34GSATT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '102617', 'K15BT', '1763100', NULL, NULL, 260000000, 1656815, NULL, 10700000, 250956815, 'JATIASIH', NULL, 'sold', NULL, 'FAHRIYADIN LA HINDI, SE [0063914]', '2026-07-16 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-01 09:29:32', '2026-08-01 10:46:55', '03 ALPHA AT HYBRID 2TONE 2026'),
(95, 'DB620904', NULL, NULL, NULL, NULL, NULL, NULL, 'XL7415F.44HBATT', 'NEW XL-7', 'COOL BLACK MET', 2026, 'MHYANC32STJ', '103316', 'K15BT', '1768675', NULL, NULL, 263040000, 1656815, NULL, 9700000, 254996815, NULL, NULL, 'sold', NULL, 'ARYA PARAMESWARA VARMA [0062956]', '2026-06-29 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-01 09:30:57', '2026-07-04 10:59:48', '03 KURO EDITION AT HYBRID 2026'),
(96, 'DB620905', '2026-06-10', NULL, NULL, NULL, NULL, NULL, 'XL7415F.54HBATT', 'NEW XL-7', 'WHITE + BLACK TOP', 2026, 'MHYANC32STJ', '103329', 'K15BT', '1768889', NULL, NULL, 264940000, 1656815, NULL, 9700000, 256896815, 'CINERE', NULL, 'sold', NULL, 'PT DARYA VARIA LABORATORIA TBK', '2026-07-06 00:00:00', 'CINERE', NULL, NULL, '2026-07-01 09:32:47', '2026-07-17 08:39:08', '03 KURO EDITION AT HYBRID 2TONE 2026'),
(97, 'DB620898', '2026-06-10', NULL, NULL, NULL, NULL, NULL, 'XL7415F.24GLMTT', 'NEW XL-7', 'SNOW WHITE', 2026, 'MHYANC22STJ', '101530', 'K15BT', '1768826', NULL, NULL, 214520000, 1656815, NULL, 10700000, 205476815, 'Ciawi', NULL, 'sold', NULL, 'HADMUR [0063225]', '2026-06-11', 'Ciawi', NULL, NULL, '2026-07-01 09:35:03', '2026-07-01 09:35:03', '03 ZETA AT 2026'),
(98, 'DB621104', '2026-06-10', NULL, NULL, NULL, NULL, NULL, 'XL7415F.24GXATT', 'NEW XL-7', 'SNOW WHITE', 2026, 'MHYANC32STJ', '103365', 'K15BT', '1769900', NULL, NULL, 247460000, 1656815, NULL, 10700000, 238416815, 'CIAWI', NULL, 'sold', NULL, 'MUHAMAD SAEFUL HADI QQ RINA RUSMIATI [0063833]', '2026-08-07 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 09:37:21', '2026-08-08 09:08:34', '03 BETA AT HYBRID 2026'),
(99, 'DB621106', '2026-06-10', NULL, NULL, NULL, NULL, NULL, 'XL7415F.34GSATT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '102699', 'K15BT', '1763678', NULL, NULL, 260000000, 1656815, NULL, 10700000, 250956815, 'CIAWI', NULL, 'sold', NULL, 'HENI KARMILA [0064165]', '2026-07-31 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 09:39:15', '2026-07-31 22:16:32', '03 ALPHA AT HYBRID 2TONE 2026'),
(100, 'DB621176', '2026-06-10', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '289700', 'K15BT', '1770615', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIAWI', NULL, 'sold', NULL, 'ADI SUTARDI [0063877]', '2026-07-09 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 09:40:57', '2026-07-10 10:26:34', '05-PU FD AC PS 2026'),
(101, 'DB621177', '2026-06-10', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '289546', 'K15BT', '1770672', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Cianjur', NULL, 'sold', NULL, 'YUSUP ENJANG [0046667]', '2026-06-22', 'Cianjur', NULL, NULL, '2026-07-01 09:43:07', '2026-07-01 09:43:07', '05-PU FD AC PS 2026'),
(102, 'DB621178', '2026-06-10', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'GRAPHITE GREY METALLIC', 2026, 'MHYHDC61TTJ', '289031', 'K15BT', '1770751', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Cianjur', NULL, 'sold', NULL, 'DAVID SURJAYA [0063595]', '2026-06-13', 'Cianjur', NULL, NULL, '2026-07-01 09:46:14', '2026-07-01 09:46:14', '05-PU FD AC PS 2026'),
(103, 'DB621179', '2026-06-10', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '287829', 'K15BT', '1767532', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'Cianjur', NULL, 'sold', NULL, 'GINA HASANAH [0063729]', '2026-06-26', 'Cianjur', NULL, NULL, '2026-07-01 09:49:24', '2026-07-01 15:25:09', '05-PU FD 2026'),
(104, 'DB621180', '2026-06-10', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '287786', 'K15BT', '1767526', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'RIFKI TAUFIKUROHMAN [0063850]', '2026-07-11 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-01 09:50:40', '2026-07-13 09:31:22', '05-PU FD 2026'),
(105, 'DB621181', '2026-06-10', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '288851', 'K15BT', '1769334', '123840.000', NULL, NULL, NULL, NULL, 10700000, -10700000, 'Cianjur', NULL, 'sold', NULL, 'KOTI HERMAWAN [0063660]', '2026-06-25', 'Cianjur', NULL, NULL, '2026-07-01 09:53:30', '2026-07-01 15:26:32', '05-PU FD 2026'),
(106, 'DB621182', '2026-06-10', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '288863', 'K15BT', '1769304', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'Ciawi', NULL, 'sold', NULL, 'MURNI ASIH [0063581]', '2026-06-29', 'Ciawi', NULL, NULL, '2026-07-01 09:57:02', '2026-07-01 15:28:04', '05-PU FD 2026'),
(107, 'DB621436', '2026-06-11', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '289909', 'K15BT', '1770886', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Jatiasih', NULL, 'sold', NULL, 'SURYADI QQ MUHAMMAD IRFAN [0063274]', '2026-06-25', 'Jatiasih', NULL, NULL, '2026-07-01 09:59:21', '2026-07-01 15:29:05', '05-PU FD AC PS 2026'),
(108, 'DB621437', '2026-06-11', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '289891', 'K15BT', '1770838', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Ciawi', NULL, 'sold', NULL, 'AMAN SASMITA QQ DERRY BADRUSSALAM [0034258]', '2026-06-23', 'Jatiasih', NULL, NULL, '2026-07-01 10:02:47', '2026-07-01 10:02:47', '05-PU FD AC PS 2026'),
(109, 'DB621605', '2026-06-12', NULL, NULL, NULL, NULL, NULL, 'XL7415F.24GXATT', 'NEW XL-7', 'COOL BLACK MET', 2026, 'MHYANC32STJ', '103063', 'K15BT', '1767059', NULL, NULL, 247460000, 1656815, NULL, 10700000, 238416815, 'CIAWI', NULL, 'sold', NULL, 'UCEP MUTAKIN [0063993]', '2026-07-18 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 10:04:39', '2026-07-20 08:27:56', '03 BETA AT HYBRID 2026'),
(110, 'DB621606', '2026-06-12', NULL, NULL, NULL, NULL, NULL, 'XL7415F.24GXATT', 'NEW XL-7', 'MET.MAGMA GRAY 2', 2026, 'MHYANC32STJ', '103387', 'K15BT', '1770446', NULL, NULL, 247460000, 1656815, NULL, 10700000, 238416815, 'CIAWI', NULL, 'sold', NULL, 'PT TRIADHIPA PRIMA SARANA [0063865]', '2026-07-23 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 10:06:57', '2026-07-24 10:12:24', '03 BETA AT HYBRID 2026'),
(111, 'DB621772', '2026-06-12', NULL, NULL, NULL, NULL, NULL, 'ARK415FM05GLATT', 'ALL NEW ERTIGA', 'MARBEL BLACK', 2026, 'MHYANC22STJ', '101613', 'K15BT', '1769507', NULL, NULL, 215590000, 1549815, NULL, 10700000, 206439815, 'Ciawi', NULL, 'sold', NULL, 'PT BRINGIN SRIKANDI FUTURA [0063126]', '2026-06-18', 'Ciawi', NULL, NULL, '2026-07-01 10:08:52', '2026-07-01 10:09:19', '05 GL AT'),
(112, 'DB621787', '2026-06-12', NULL, NULL, NULL, NULL, NULL, 'A3L415FM01SXATS', 'FRONX', 'ICE GRAYISH BLUE', 2025, 'MHYMWDB3SSJ', '108206', 'K15C-', '1087128', NULL, NULL, 280880000, 1351037, NULL, 6700000, 275531037, 'Cianjur', NULL, 'sold', NULL, 'ALDI HAN [0063743]', '2026-06-27', 'Cianjur', NULL, NULL, '2026-07-01 10:12:30', '2026-07-01 15:32:06', 'HYBRID SGX 2TONE AT 2025'),
(113, 'DB621788', '2026-06-12', NULL, NULL, NULL, NULL, NULL, 'A3L415FM01SXATS', 'FRONX', 'ICE GRAYISH BLUE', 2025, 'MHYMWDB3SSJ', '108254', 'K15C-', '1087090', NULL, NULL, 280880000, 1351037, NULL, 6700000, 275531037, 'Cianjur', NULL, 'sold', NULL, 'MOCHAMAD WIRA ALAMSYAH [0063692]', '2026-06-30', 'Cianjur', NULL, NULL, '2026-07-01 10:14:19', '2026-07-01 15:34:20', 'HYBRID SGX 2TONE AT 2025'),
(114, 'DB621789', '2026-06-12', NULL, NULL, NULL, NULL, NULL, 'A3L415FM10GLATT', 'FRONX', 'SNOW WHITE', 2026, 'MHYMWDA3STJ', '100730', 'K15BT', '1771105', NULL, NULL, 229300000, 1351037, NULL, 11700000, 218951037, 'JATIASIH', NULL, 'sold', NULL, 'MARIO ALESSANDRO PANJAITAN [0063806]', '2026-06-30', 'JATIASIH', NULL, NULL, '2026-07-01 10:16:03', '2026-07-17 10:28:31', 'GL AT 2026'),
(115, 'DB621790', '2026-06-12', NULL, NULL, NULL, NULL, NULL, 'A3L415FM10GLATT', 'FRONX', 'COOL BLACK MET', 2026, 'MHYMWDA3STJ', '100692', 'K15BT', '1770674', NULL, NULL, 229300000, 1351037, NULL, 11700000, 218951037, 'JATIASIH', NULL, 'sold', NULL, 'TIUR MAIDA SIMANGUNSONG [0034573]', '2026-08-06 00:00:00', 'CIAWI', 'DELIVERY DI JATIASIH', NULL, '2026-07-01 10:17:43', '2026-08-07 09:28:05', 'GL AT 2026'),
(116, 'DB621937', '2026-06-15', NULL, NULL, NULL, NULL, NULL, 'ARK415FM05GLATT', 'ALL NEW ERTIGA', 'MET.MAGMA GRAY 2', 2026, 'MHYANC22STJ', '101626', 'K15BT', '1769495', NULL, NULL, 215590000, 1549815, NULL, 10700000, 206439815, 'Cianjur', NULL, 'sold', NULL, 'ZAHI MOHAMMAD AL MUSSALAM [0063782]', '2026-06-30', 'Cianjur', NULL, NULL, '2026-07-01 10:19:21', '2026-07-01 15:43:18', '05 GL AT'),
(117, 'DB621987', '2026-06-15', NULL, NULL, NULL, NULL, NULL, 'XL7415F.24GXATT', 'NEW XL-7', 'MET.MAGMA GRAY 2', 2026, 'MHYANC32STJ', '103401', 'K15BT', '1770827', NULL, NULL, 247460000, 1656815, NULL, 10700000, 238416815, 'Cinere', NULL, 'sold', NULL, 'PT MANDIRI REKSA TRANSINDO [0061516]', '2026-06-29', 'Cinere', NULL, NULL, '2026-07-01 10:20:56', '2026-07-01 15:44:40', '03 BETA AT HYBRID 2026'),
(118, 'DB622109', '2026-06-15', NULL, NULL, NULL, NULL, NULL, 'A3L415FM01SXATS', 'FRONX', 'WHITE + BLACK TOP', 2025, 'MHYMWDB3SSJ', '111437', 'K15C-', '1092057', NULL, NULL, 280880000, 1351037, NULL, 6700000, 275531037, 'Cianjur', NULL, 'sold', NULL, 'HERDI SUPRIATMAN [0063698]', '2026-06-26', 'Cianjur', NULL, NULL, '2026-07-01 10:23:08', '2026-07-01 15:45:20', 'HYBRID SGX 2TONE AT 2025'),
(119, 'DB622276', '2026-06-17', NULL, NULL, NULL, NULL, NULL, 'AEV415W.46WDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '289886', 'K15BT', '1770854', NULL, NULL, 131210000, NULL, NULL, 10700000, 120510000, 'Jatiasih', NULL, 'sold', NULL, 'MUHAMMAD VARREL ABIDILLAH [0063622]', '2026-06-18', 'Jatiasih', NULL, NULL, '2026-07-01 10:24:53', '2026-07-01 16:49:53', '05-PU WD AC PS 2026'),
(120, 'DB622442', '2026-06-17', NULL, NULL, NULL, NULL, NULL, 'A3L415FM01SXATS', 'FRONX', 'WHITE + BLACK TOP', 2025, 'MHYMWDB3SSJ', '111412', 'K15C-', '1091619', NULL, NULL, 280880000, 1351037, NULL, 6700000, 275531037, 'JATIASIH', NULL, 'sold', NULL, 'HAYU ARININGTYAS PUTRI [0063930]', '2026-07-13 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-01 10:26:46', '2026-07-13 16:28:06', 'HYBRID SGX 2TONE AT 2025'),
(121, 'DB622443', '2026-06-17', NULL, NULL, NULL, NULL, NULL, 'A3L415FM01SXATS', 'FRONX', 'WHITE + BLACK TOP', 2025, 'MHYMWDB3SSJ', '111441', 'K15C-', '1092801', NULL, NULL, 280880000, 1351037, NULL, 6700000, 275531037, 'JATIASIH', NULL, 'sold', NULL, 'ALMANDA JEANYFER PONTOH [0064027]', '2026-07-20 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-01 10:37:55', '2026-07-21 10:43:19', 'HYBRID SGX 2TONE AT 2025'),
(122, 'DB622291', '2026-06-17', NULL, NULL, NULL, NULL, NULL, '6N415VX00012ATS', 'JIMNY', 'SLD.KINETIC YELLOW 2/PRL.BLUISH BLACK 4', 2025, 'MA3JJC74WS0', '225048', 'K15BN', '4451676', NULL, NULL, 393420000, 4104891, NULL, 5700000, 391824891, 'CINERE', NULL, 'matching', NULL, NULL, '2026-08-20 00:00:00', 'CINERE', NULL, NULL, '2026-07-01 10:39:54', '2026-08-21 11:20:48', '5 DOORS 2TONE AT 2025'),
(123, 'DB622292', '2026-06-17', NULL, NULL, NULL, NULL, NULL, '6N415VX00012ATS', 'JIMNY', 'MET.CHIFFON IVORY 2/PRL.BLUISH 4', 2025, 'MA3JJC74WS0', '220162', 'K15BN', '4446589', NULL, NULL, 393420000, 4104891, NULL, 5700000, 391824891, 'CINERE', NULL, 'sold', NULL, 'PT EMRAN GHANIM ASAHI [0064289]', '2026-08-15 00:00:00', 'CINERE', NULL, NULL, '2026-07-01 10:41:28', '2026-08-18 10:21:39', '5 DOORS 2TONE AT 2025'),
(124, 'DB622288', '2026-06-17', NULL, NULL, NULL, NULL, NULL, '6N415VX00011ATS', 'JIMNY', 'SLD JUNGLE GREEN 2', 2025, 'MA3JJC74WS0', '226080', 'K15BN', '4452486', NULL, NULL, 390640000, 4104891, NULL, 5700000, 389044891, 'CIAWI', NULL, 'sold', NULL, 'ERWAN YULIANTO [0064189]', '2026-08-05 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-01 10:43:03', '2026-08-06 13:38:15', '5 DOORS AT 2025'),
(125, 'DB622281', '2026-06-17', NULL, NULL, NULL, NULL, NULL, 'GC415V.M71BVMTT', 'APV', 'WHITE', 2026, 'MHYGDN41VTJ', '400679', 'G15AID', '454644', NULL, NULL, 134220000, NULL, NULL, 700000, 133520000, 'Cianjur', NULL, 'sold', NULL, 'RISMANUDIN [0063439]', '2026-06-18', 'Cianjur', NULL, NULL, '2026-07-01 10:45:31', '2026-07-01 10:45:31', 'FE GE PS DEL.VAN MT 2026 (BLINDVAN)'),
(126, 'DB622572', '2026-06-18', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '290642', 'K15BT', '1772054', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Cianjur', NULL, 'sold', NULL, 'DAYAT [0063764]', '2026-06-27', 'Cianjur', NULL, NULL, '2026-07-01 10:46:56', '2026-07-01 15:46:37', '05-PU FD AC PS 2026'),
(127, 'DB622573', '2026-06-18', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '290613', 'K15BT', '1771995', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Ciawi', NULL, 'sold', NULL, 'YATI SUTINI [0063745]', '2026-06-29', 'Ciawi', NULL, NULL, '2026-07-01 10:48:25', '2026-07-01 15:47:23', '05-PU FD AC PS 2026'),
(128, 'DB622574', '2026-06-18', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '290627', 'K15BT', '1772039', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Ciawi', NULL, 'sold', NULL, 'FITRIYADI [0063805]', '2026-06-30', 'Ciawi', NULL, NULL, '2026-07-01 10:50:05', '2026-07-01 15:48:43', '05-PU FD AC PS 2026'),
(129, 'DB622567', '2026-06-18', NULL, NULL, NULL, NULL, NULL, 'AEV415W.46WDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '289093', 'K15BT', '1769597', NULL, NULL, 131210000, NULL, NULL, 10700000, 120510000, 'CIAWI', NULL, 'sold', NULL, 'SULAEMAN [0064061]', '2026-07-31 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 11:00:06', '2026-07-31 13:55:17', '05-PU WD AC PS 2026'),
(130, 'DB622568', '2026-06-18', NULL, NULL, NULL, NULL, NULL, 'AEV415W.46WDMTT', 'NEW CARRY', 'GRAPHITE GREY METALLIC', 2026, 'MHYHDC61TTJ', '290365', 'K15BT', '1771539', NULL, NULL, 131210000, NULL, NULL, 10700000, 120510000, 'Cinere', NULL, 'sold', NULL, 'SUPRIYANTO [0063728]', '2026-06-25', 'Cinere', NULL, NULL, '2026-07-01 11:01:47', '2026-07-01 15:51:30', '05-PU WD AC PS 2026'),
(131, 'DB622561', '2026-06-18', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '288402', 'K15BT', '1768607', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'sold', NULL, 'U.MISBAHUDIN [0063870]', '2026-07-15 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 11:04:04', '2026-07-16 08:29:09', '05-PU FD 2026'),
(132, 'DB622562', '2026-06-18', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '288420', 'K15BT', '1768649', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIPANAS', NULL, 'sold', NULL, 'YENI NURHAYANTI, AM. KEB [0063537]', '2026-08-10 00:00:00', 'CIPANAS', NULL, NULL, '2026-07-01 11:09:07', '2026-08-11 08:51:01', '05-PU FD 2026');
INSERT INTO `stocks` (`id`, `no_do`, `tanggal_do`, `unit_id`, `varian_id`, `gudang_id`, `cabang_id`, `warna_id`, `kode_mobil`, `nama_mobil`, `warna`, `tahun`, `chassis_code`, `norangka`, `enginecode`, `nomesin`, `faktur`, `bln_naik_faktur`, `harga`, `kpt_kf`, `acs2`, `subsidi`, `hpp`, `lokasi`, `estimasi_unit_masuk_gudang_dca`, `status`, `lain_lain`, `penjualan`, `tanggal_matching_do`, `cabang`, `keterangan`, `unit`, `created_at`, `updated_at`, `varian`) VALUES
(133, 'DB622563', '2026-06-18', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '289719', 'K15BT', '1770637', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'DENI MULYANA [0058634]', '2026-07-07 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-01 11:13:26', '2026-07-08 08:37:19', '05-PU FD 2026'),
(135, 'DB622565', '2026-06-18', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '289699', 'K15BT', '1770519', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'Jatiasih', NULL, 'sold', NULL, 'EDI ARYADI QQ KANAYA AULIA DESTIANI [0063748]', '2026-06-29', 'Jatiasih', NULL, NULL, '2026-07-01 11:25:19', '2026-07-01 11:25:19', '05-PU FD 2026'),
(136, 'DB622566', '2026-06-18', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '289600', 'K15BT', '1770558', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'Ciawi', NULL, 'sold', NULL, 'PT HIJRAH INSAN KARIMA [0063802]', '2026-06-30', 'Jatiasih', NULL, NULL, '2026-07-01 11:46:50', '2026-07-01 15:54:14', '05-PU FD 2026'),
(137, 'DB622603', '2026-06-18', NULL, NULL, NULL, NULL, NULL, 'XL7415F.24GXATT', 'NEW XL-7', 'MET.MAGMA GRAY 2', 2026, 'MHYANC32STJ', '103416', 'K15BT', '1771129', NULL, NULL, 247460000, 1656815, NULL, 10700000, 238416815, 'CIAWI', NULL, 'free', NULL, 'HENI', '2026-08-12 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 11:48:19', '2026-08-15 11:54:09', '03 BETA AT HYBRID 2026'),
(138, 'DB622798', '2026-06-20', NULL, NULL, NULL, NULL, NULL, 'PQ5FX00012GXATS', 'GRAND-VITARA', 'PRL.ARCTIC WHITE/PRL.MIDNIGHT BLACK', 2025, 'MA3TYKL1SST', '106068', 'K15CN', '7811014', NULL, NULL, 350330000, 1665000, NULL, 20700000, 331295000, NULL, NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 11:49:49', '2026-08-07 11:29:25', 'MC 2TONE GX AT 2025'),
(139, 'DB622874', '2026-06-22', NULL, NULL, NULL, NULL, NULL, 'XL7415F.54HBATT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '102738', 'K15BT', '1764258', 'SUDAH NAIK HO', 'JUNI 2026', 264940000, 1656815, NULL, 9700000, 256896815, 'CIAWI', NULL, 'sold', NULL, 'CAHYADI PUTRA [0064246]', '2026-08-20 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-01 11:51:32', '2026-08-21 08:33:37', '03 KURO EDITION AT HYBRID 2TONE 2026'),
(140, 'DB622875', '2026-06-22', NULL, NULL, NULL, NULL, NULL, 'XL7415F.54HBATT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '102740', 'K15BT', '1764261', NULL, NULL, 264940000, 1656815, NULL, 9700000, 256896815, 'CIANJUR', NULL, 'sold', NULL, 'MAMAT NURDIANSAH [0059804]', '2026-07-29 00:00:00', 'CIANJUR', 'DISPLAY CIPANAS', NULL, '2026-07-01 11:52:52', '2026-07-29 13:02:40', '03 KURO EDITION AT HYBRID 2TONE 2026'),
(141, 'DB622997', '2026-06-23', NULL, NULL, NULL, NULL, NULL, 'BU4FL0000001ATT', 'S-PRESSO', 'GRANITE GRAY', 2026, 'MA3RFL61STA', '602154', 'K10CNC', '980512', NULL, NULL, 150150000, 1337961, NULL, 5700000, 145787961, 'Jatiasih', NULL, 'sold', NULL, 'UMI AMALIA [0063392]', '2026-06-24', 'Jatiasih', NULL, NULL, '2026-07-01 11:54:41', '2026-07-01 11:55:32', '02 AT-2026'),
(143, 'DB623000', '2026-06-23', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00GLMTS', 'FRONX', 'COOL BLACK MET', 2025, 'MHYMWDA3SSJ', '101575', 'K15BT', '1700090', NULL, NULL, 219100000, 1351037, NULL, 10700000, 209751037, 'Ciawi', NULL, 'sold', NULL, 'RESA DWI SAPUTRA [0063681]', '2026-06-29', 'Ciawi', NULL, NULL, '2026-07-01 11:59:09', '2026-07-01 15:55:06', 'GL MT'),
(144, 'DB623208', '2026-06-24', NULL, NULL, NULL, NULL, NULL, 'GC415V.M71BVMTT', 'APV', 'WHITE', 2026, 'MHYGDN41VTJ', '400612', 'G15AID', '454397', NULL, NULL, 134220000, NULL, NULL, 700000, 133520000, 'Jatiasih', NULL, 'sold', NULL, 'AHMAD WIDODO [0063087]', '2026-06-25', 'Jatiasih', NULL, NULL, '2026-07-01 12:00:28', '2026-07-01 15:55:37', 'FE GE PS DEL.VAN MT 2026 (BLINDVAN)'),
(145, 'DB623396', '2026-06-24', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00GXMTT', 'FRONX', 'COOL BLACK MET', 2026, 'MHYMWDB3STJ', '100607', 'K15C-', '1091481', NULL, NULL, 239970000, 1351037, NULL, 6700000, 234621037, 'JATIASIH', NULL, 'free', NULL, NULL, '2026-06-29', NULL, 'PAMERAN TIPTOP JATIASIH', NULL, '2026-07-01 12:02:55', '2026-07-17 08:40:40', 'HYBRID GX MT 2026'),
(146, 'DB623444', '2026-06-24', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'GRAPHITE GREY METALLIC', 2026, 'MHYHDC61TTJ', '290732', 'K15BT', '1772206', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Ciawi', NULL, 'sold', NULL, 'MISNAN BT.NASIN [0031449]', '2026-06-29', 'Ciawi', NULL, NULL, '2026-07-01 12:04:43', '2026-07-01 15:57:11', '05-PU FD AC PS 2026'),
(147, 'DB623454', '2026-06-24', NULL, NULL, NULL, NULL, NULL, 'XL7415F.24GXATT', 'NEW XL-7', 'MET.MAGMA GRAY 2', 2026, 'MHYANC32STJ', '103426', 'K15BT', '1771447', NULL, NULL, 247460000, 1656815, NULL, 10700000, 238416815, 'Cinere', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 12:06:10', '2026-07-02 11:31:49', '03 BETA AT HYBRID 2026'),
(148, 'DB623465', '2026-06-24', NULL, NULL, NULL, NULL, NULL, 'XL7415F.34GSATT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '102735', 'K15BT', '1764177', NULL, NULL, 260000000, 1656815, NULL, 10700000, 250956815, 'JATIASIH', NULL, 'sold', NULL, 'PT WIBON KREASI MANDIRI [0063824]', '2026-07-13 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-01 12:07:51', '2026-07-13 16:28:30', '03 ALPHA AT HYBRID 2TONE 2026'),
(150, 'DB623556', '2026-06-25', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '291645', 'K15BT', '1773533', 'SUDAH NAIK HO', 'JUNI 2026', 130360000, NULL, NULL, 10700000, 119660000, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 13:07:35', '2026-07-06 14:25:58', '05-PU FD AC PS 2026'),
(151, 'DB623557', '2026-06-25', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '291618', 'K15BT', '1773458', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIAWI', NULL, 'sold', NULL, 'DEVI RUSDI [0063853]', '2026-07-06 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 13:09:20', '2026-07-07 11:29:09', '05-PU FD AC PS 2026'),
(152, 'DB623558', '2026-06-25', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '291593', 'K15BT', '1773139', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIAWI', NULL, 'sold', NULL, 'HENDRA [0037615]', '2026-07-14 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 13:10:48', '2026-07-15 08:36:04', '05-PU FD AC PS 2026'),
(153, 'DB623562', '2026-06-25', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '291745', 'K15BT', '1773431', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'sold', NULL, 'CV.DAVIENA ALAM CIBODAS [0063983]', '2026-07-21 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 13:12:16', '2026-07-21 10:36:33', '05-PU FD 2026'),
(154, 'DB623563', '2026-06-25', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '291795', 'K15BT', '1773685', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'sold', NULL, 'CV.DAVIENA ALAM CIBODAS [0063983]', '2026-07-21 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 13:13:59', '2026-07-21 10:36:10', '05-PU FD 2026'),
(155, 'DB623564', '2026-06-25', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '291850', 'K15BT', '1773641', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'sold', NULL, 'CV.DAVIENA ALAM CIBODAS [0063983]', '2026-07-21 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 13:24:32', '2026-07-21 10:36:57', '05-PU FD 2026'),
(156, 'DB623565', '2026-06-25', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '291816', 'K15BT', '1773645', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'Ciawi', NULL, 'sold', NULL, 'FACHQRI RAMBA FIRGANDARA [0063804]', '2026-06-30', 'Ciawi', NULL, NULL, '2026-07-01 13:25:58', '2026-07-02 11:33:46', '05-PU FD 2026'),
(157, 'DB623566', '2026-06-25', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '290181', 'K15BT', '1771241', 'SUDAH NAIK HO', 'JUNI 2026', 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 13:27:08', '2026-07-02 13:49:26', '05-PU FD 2026'),
(158, 'DB623567', '2026-06-25', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '290160', 'K15BT', '1771200', 'SUDAH NAIK HO', 'JUNI 2026', 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'MOCHAMAD YUSUF [0064164]', '2026-07-31 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-01 13:28:14', '2026-08-01 10:05:25', '05-PU FD 2026'),
(159, 'DB623570', '2026-06-25', NULL, NULL, NULL, NULL, NULL, 'AEV415W.46WDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '289697', 'K15BT', '1770913', NULL, NULL, 131210000, NULL, NULL, 10700000, 120510000, 'Ciawi', NULL, 'sold', NULL, 'RUDI SIGIT [0063667]', '2026-06-29', 'Ciawi', NULL, NULL, '2026-07-01 13:34:13', '2026-07-01 13:34:13', '05-PU WD AC PS 2026'),
(160, 'DB623571', '2026-06-25', NULL, NULL, NULL, NULL, NULL, 'AEV415W.36WDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '291377', 'K15BT', '1773011', NULL, NULL, 124590000, NULL, NULL, 10700000, 113890000, 'Jatiasih', NULL, 'sold', NULL, 'NUR YANI [0063381]', '2026-06-30', 'Jatiasih', NULL, NULL, '2026-07-01 13:35:45', '2026-07-02 11:34:47', '05-PU WD 2026'),
(161, 'DB623706', '2026-06-25', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00GXATS', 'FRONX', 'COOL BLACK MET', 2025, 'MHYMWDB3SSJ', '112189', 'K15C-', '1093300', NULL, NULL, 225190000, 1351037, NULL, 6700000, 219841037, 'Cinere', NULL, 'sold', NULL, 'PURBANINGRUM SASMITA [0063727]', '2026-06-30', 'Cinere', NULL, NULL, '2026-07-01 13:38:01', '2026-07-02 11:35:07', 'HYBRID GX AT'),
(162, 'DB623916', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'A3L415FM01SXATS', 'FRONX', 'ICE GRAYISH BLUE', 2025, 'MHYMWDB3SSJ', '112439', 'K15C-', '1091575', NULL, NULL, 280880000, 1351037, NULL, 6700000, 275531037, 'CIAWI', NULL, 'sold', NULL, 'RIFQI PRATAMA [0064124]', '2026-07-29 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 13:40:15', '2026-07-29 13:02:08', 'HYBRID SGX 2TONE AT 2025'),
(163, 'DB623917', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'A3L415FM01SXATS', 'FRONX', 'ICE GRAYISH BLUE', 2025, 'MHYMWDB3SSJ', '112561', 'K15C-', '1094843', NULL, NULL, 280880000, 1351037, NULL, 6700000, 275531037, 'CIAWI', NULL, 'sold', NULL, 'IR.YOSEP ILHAM KUDRAT QQ MUHAMM', '2026-07-16 00:00:00', 'JATIASIH', 'PROSES DO DICIAWI', NULL, '2026-07-01 13:41:32', '2026-07-16 15:29:23', 'HYBRID SGX 2TONE AT 2025'),
(164, 'DB623921', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'BU4FL0000001ATT', 'S-PRESSO', 'SOLID FIRE RED', 2026, 'MA3RFL61STA', '601087', 'K10CNC', '977698', NULL, NULL, 150150000, 1093350, NULL, 5700000, 145543350, 'Ciawi', NULL, 'sold', NULL, 'HASYA AMILA [0063632]', '2026-06-29', 'Ciawi', NULL, NULL, '2026-07-01 13:43:23', '2026-07-01 13:43:49', '02 AT-2026'),
(165, 'DB623922', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'BU4FL0000001ATT', 'S-PRESSO', 'SOLID FIRE RED', 2026, 'MA3RFL61STA', '600652', 'K10CNC', '976553', NULL, NULL, 150150000, 1093350, NULL, 5700000, 145543350, 'Ciawi', NULL, 'sold', NULL, 'DIAN MAHARGIANTO [0063559]', '2026-06-29', 'Ciawi', NULL, NULL, '2026-07-01 13:45:05', '2026-07-01 13:45:05', '02 AT-2026'),
(166, 'DB623923', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'BU4FL0000001ATT', 'S-PRESSO', 'GRANITE GRAY METALLIC', 2026, 'MA3RFL61STA', '602319', 'K10CNC', '980898', NULL, NULL, 150150000, 1093350, NULL, 5700000, 145543350, 'CIAWI', NULL, 'sold', NULL, 'DWI ROYANI [0064205]', '2026-08-05 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 13:47:23', '2026-08-06 13:37:29', '02 AT-2026'),
(167, 'DB624130', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '291635', 'K15BT', '1773451', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'MILA HANDAYANI [0063855]', '2026-07-07 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-01 14:29:01', '2026-07-08 08:36:35', '05-PU FD 2026'),
(168, 'DB624131', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '291630', 'K15BT', '1773454', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'SUPRIATNA [0063826]', '2026-07-08 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-01 14:30:30', '2026-07-09 10:02:59', '05-PU FD 2026'),
(169, 'DB624132', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '291626', 'K15BT', '1773435', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'sold', NULL, 'NIA KURNIATI [0063786]', '2026-07-08 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 14:31:31', '2026-07-09 10:02:24', '05-PU FD 2026'),
(170, 'DB624133', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '291644', 'K15BT', '1773534', 'SUDAH NAIK', NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'sold', NULL, 'YOGA MAOLANA [0063544]', '2026-07-31 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 14:32:37', '2026-07-31 20:45:01', '05-PU FD 2026'),
(171, 'DB624157', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '291812', 'K15BT', '1773622', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIPANAS', NULL, 'sold', NULL, 'SARIPUDIN [0064013]', '2026-07-22 00:00:00', 'CIPANAS', NULL, NULL, '2026-07-01 14:33:49', '2026-07-23 10:09:51', '05-PU FD AC PS 2026'),
(172, 'DB624158', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '291818', 'K15BT', '1773726', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIPANAS', NULL, 'sold', NULL, 'MUHAMAD FAZRY FEBRIAN [0064083]', '2026-07-28 00:00:00', 'CIPANAS', NULL, NULL, '2026-07-01 14:34:47', '2026-07-29 10:04:58', '05-PU FD AC PS 2026'),
(173, 'DB624159', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '291876', 'K15BT', '1773616', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIANJUR', NULL, 'sold', NULL, 'CECEP SAYUTI [0064031]', '2026-07-20 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-01 14:35:53', '2026-07-21 10:38:33', '05-PU FD AC PS 2026'),
(174, 'DB624160', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '291417', 'K15BT', '1773182', 'SUDAH NAIK CIAWI', 'JULI 2026', 130360000, NULL, NULL, 10700000, 119660000, 'CIAWI', NULL, 'sold', NULL, 'LIA ROSANA [0063715]', '2026-08-11 00:00:00', 'CIAWI', NULL, NULL, '2026-07-01 14:36:57', '2026-08-12 08:44:46', '05-PU FD AC PS 2026'),
(175, 'DB624161', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'GRAPHITE GREY METALLIC', 2026, 'MHYHDC61TTJ', '291851', 'K15BT', '1773836', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Ciawi', NULL, 'sold', NULL, 'EDIN SISWANTO [0063643]', '2026-06-30', 'Ciawi', NULL, NULL, '2026-07-01 14:38:20', '2026-07-02 11:35:36', '05-PU FD AC PS 2026'),
(176, 'DB624162', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'GRAPHITE GREY METALLIC', 2026, 'MHYHDC61TTJ', '291302', 'K15BT', '1773019', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'Cianjur', NULL, 'sold', NULL, 'NANANG [0063680]', '2026-06-30', 'Cianjur', NULL, NULL, '2026-07-01 14:39:40', '2026-07-02 11:35:49', '05-PU FD AC PS 2026'),
(177, 'DB624353', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'XL7415F.54HBATT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '103078', 'K15BT', '1767000', NULL, NULL, 264940000, 1656815, NULL, 9700000, 256896815, 'CINERE', NULL, 'sold', NULL, 'ANDRETO TRI GUNARDI QQ PT TROPAZ SECURITY [0064072]', '2026-07-31 00:00:00', 'CINERE', NULL, NULL, '2026-07-01 14:40:54', '2026-07-31 16:59:12', '03 KURO EDITION AT HYBRID 2TONE 2026'),
(178, 'DB624354', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'XL7415F.54HBATT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '103076', 'K15BT', '1766603', NULL, NULL, 264940000, 1656815, NULL, 9700000, 256896815, 'CIANJUR', NULL, 'sold', NULL, 'HERLAN MAULANA [0063936]', '2026-07-31 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-01 14:42:30', '2026-07-31 20:45:30', '03 KURO EDITION AT HYBRID 2TONE 2026'),
(179, 'DB624394', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '290951', 'K15BT', '1772446', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIANJUR', NULL, 'sold', NULL, 'AHMAD JAMALUDIN [0058236]', '2026-07-31 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-01 14:43:55', '2026-08-01 10:06:52', '05-PU FD AC PS 2026'),
(180, 'DB624395', '2026-06-29', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '291243', 'K15BT', '1772945', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CINERE', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 14:45:00', '2026-07-07 14:02:13', '05-PU FD AC PS 2026'),
(183, 'DB625006', '2026-06-30', NULL, NULL, NULL, NULL, NULL, 'GC415V.M71BVMTT', 'APV', 'WHITE', 2026, 'MHYGDN41VTJ', '400671', 'G15AID', '454602', NULL, NULL, 134220000, NULL, NULL, 700000, 133520000, 'Tambun', NULL, 'sold', NULL, 'RISMANUDIN [0063439]', '2026-06-30', 'Cianjur', NULL, NULL, '2026-07-01 14:49:03', '2026-07-01 14:49:03', 'FE GE PS DEL.VAN MT 2026 (BLINDVAN)'),
(184, 'DB625239', '2026-06-30', NULL, NULL, NULL, NULL, NULL, 'BU4FL0000001ATT', 'S-PRESSO', 'WHITE', 2026, 'MA3RFL61STA', '600243', 'K10CNC', '975299', NULL, NULL, 150150000, 1337961, NULL, 5700000, 145787961, 'Cinere', NULL, 'sold', NULL, 'MEDDY ASYFIANDY [0063690]', '2026-06-30', 'Cinere', NULL, NULL, '2026-07-01 14:54:39', '2026-07-02 11:36:31', '02 AT-2026'),
(185, 'DB625240', '2026-06-30', NULL, NULL, NULL, NULL, NULL, 'BU4FL0000001ATT', 'S-PRESSO', 'WHITE', 2026, 'MA3RFL61STA', '600195', 'K10CNC', '975145', NULL, NULL, 150150000, 1337961, NULL, 5700000, 145787961, 'Tambun', NULL, 'sold', NULL, 'FITRI MAR`ATUS SHOLIHAH [0063484]', '2026-06-30', 'Jatiasih', NULL, NULL, '2026-07-01 14:55:59', '2026-07-01 14:55:59', '02 AT-2026'),
(186, 'DB625270', '2026-06-30', NULL, NULL, NULL, NULL, NULL, 'BU4FL0000001ATT', 'S-PRESSO', 'WHITE', 2025, 'MA3RFL61STA', '601551', 'K10CNC', '978921', NULL, NULL, 150150000, 1337961, NULL, 5700000, 145787961, 'CIANJUR', NULL, 'sold', NULL, 'YAYAN HIDAYAT [0056430]', '2026-07-24 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-01 14:57:16', '2026-07-28 10:37:26', '02 AT-2026'),
(187, 'DB625241', '2026-06-30', NULL, NULL, NULL, NULL, NULL, 'BU4FL0000001ATT', 'S-PRESSO', 'GRANITE GRAY', 2026, 'MA3RFL61STA', '595602', 'K10CNC', '960095', NULL, NULL, 150150000, 1337961, NULL, 5700000, 145787961, 'JATIASIH', NULL, 'sold', NULL, 'M.WIRABADSHA SAMUDRA MAJREEHA M', '2026-07-07 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-01 14:58:24', '2026-07-08 08:38:00', '02 AT-2026'),
(188, 'DB625238', '2026-06-30', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00GLMTS', 'FRONX', 'MET.MAGMA GRAY 2', 2025, 'MHYMWDA3SSJ', '102343', 'K15BT', '1703946', NULL, NULL, 219100000, 1351037, NULL, 10700000, 209751037, 'JATIASIH', NULL, 'sold', NULL, 'SENDMY POULA WINERUNGAN, SE.AK [0064213]', '2026-08-06 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-01 14:59:43', '2026-08-07 09:29:03', 'GL MT'),
(189, 'DB625242', '2026-06-30', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00GXATS', 'FRONX', 'COOL BLACK MET', 2025, 'MHYMWDB3SSJ', '112607', 'K15C-', '1094859', NULL, NULL, 255190000, 1351037, NULL, 6700000, 249841037, 'CIANJUR', NULL, 'sold', NULL, 'WINDA NENGSIH [0064024]', '2026-08-18 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-01 15:00:57', '2026-08-19 10:03:47', 'HYBRID GX AT'),
(190, 'DB625243', '2026-06-30', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00SXATS', 'FRONX', 'SAVANA IVORY', 2025, 'MHYMWDB3SSJ', '109346', 'K15C-', '1088979', NULL, NULL, 278980000, 1351037, NULL, 10700000, 269631037, 'JATIASIH', NULL, 'sold', NULL, 'PRATTY MONTREANA UTAMI [0064028]', '2026-07-27 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-01 15:02:40', '2026-07-28 10:38:00', 'HYBRID SGX AT'),
(191, 'DB625269', '2026-06-30', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00GXATS', 'FRONX', 'MET.MAGMA GRAY 2', 2025, 'MHYMWDB3SSJ', '112971', 'K15C-', '1093794', NULL, NULL, 255190000, 1351037, NULL, 6700000, 249841037, 'Cikarang', NULL, 'sold', NULL, 'AGUNG RIZKI FRIANTO [0063737]', '2026-06-30', 'Jatiasih', NULL, NULL, '2026-07-01 15:04:07', '2026-07-01 15:04:07', 'HYBRID GX AT'),
(200, 'DB623555', '2026-06-25', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '291581', 'K15BT', '1773555', 'SUDAH NAIK HO', 'JUNI 2026', 130360000, NULL, NULL, 10700000, 119660000, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-04 11:22:37', '2026-07-09 11:37:06', '05-PU FD AC PS 2026'),
(201, 'DB622564', '2026-06-18', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '289756', 'K15BT', '1770745', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'DINI MEGAWATI [0063847]', '2026-07-04 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-04 11:25:24', '2026-07-06 10:16:12', '05-PU FD 2026'),
(202, 'DB624997', '2026-06-30', NULL, NULL, NULL, NULL, NULL, 'GC415V.M71BVMTT', 'APV', 'WHITE', 2026, 'MHYGDN41VTJ', '400755', 'G15AID', '454727', NULL, NULL, 134220000, NULL, NULL, 700000, 133520000, 'CIANJUR', NULL, 'free', NULL, NULL, '2026-07-04 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-04 11:29:18', '2026-07-07 13:52:15', 'FE GE PS DEL.VAN MT 2026 (BLINDVAN)'),
(203, 'DB622999', '2026-06-23', NULL, NULL, NULL, NULL, NULL, 'A3L415FM10GLATT', 'FRONX', 'MET.MAGMA GRAY 2', 2026, 'MHYMWDA3STJ', '100801', 'K15BT', '1771999', NULL, NULL, 229300000, 1351037, NULL, 11700000, 218951037, 'JATIASIH', NULL, 'sold', NULL, 'YAD RIVANDY TAMHER QQ ANI SULFANI [0063898]', '2026-07-09 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-04 11:36:24', '2026-07-13 09:54:42', 'GL AT 2026'),
(207, 'DB620308', '2026-06-08', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '289036', 'K15BT', '1769592', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIANJUR', NULL, 'sold', NULL, 'NASRUL HOERUL ALAM [0063830]', '2026-07-03 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-04 11:53:44', '2026-07-04 11:57:59', '05-PU FD AC PS 2026'),
(208, 'DB625029', '2026-06-30', NULL, NULL, NULL, NULL, NULL, 'XL7415F.34GSMTT', 'NEW XL-7', 'DUMMY.SAVANA IVORY 2', 2026, 'MHYANC32STJ', '103340', 'K15BT', '1768805', NULL, NULL, 250780000, 1656815, NULL, 10700000, 241736815, 'CINERE', NULL, 'sold', NULL, 'PT DARYA VARIA LABORATORIA TBK [0061132]', '2026-07-03 00:00:00', 'CINERE', NULL, NULL, '2026-07-04 11:56:55', '2026-07-04 11:58:24', '03 ALPHA MT HYBRID 2TONE 2026'),
(209, 'DB626186', '2026-07-07', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '293079', 'K15BT', '1775781', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-08 10:27:05', '2026-07-08 10:27:05', '05-PU FD 2026'),
(211, 'DB626088', '2026-07-07', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '292895', 'K15BT', '1775279', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIANJUR', NULL, 'sold', NULL, 'UJANG ZENAL MUTAQIN [0064243]', '2026-08-10 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-08 10:30:07', '2026-08-11 08:50:02', '05-PU FD AC PS 2026'),
(212, 'DB626186', '2026-07-07', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '293079', 'K15BT', '1775781', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIANJUR', NULL, 'sold', NULL, 'ALI NURDIN [0064014]', '2026-07-29 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-08 10:32:04', '2026-07-30 11:32:32', '05-PU FD AC PS 2026'),
(213, 'DB626089', '2026-07-07', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '292898', 'K15BT', '1775323', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIANJUR', NULL, 'sold', NULL, 'RIYO SUMPENA [0064267]', '2026-08-13 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-08 10:33:15', '2026-08-14 10:57:20', '05-PU FD AC PS 2026'),
(214, 'DB626090', '2026-07-07', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '292991', 'K15BT', '1775640', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'JATIASIH', NULL, 'sold', NULL, 'BAGUS MUKARRABIN QQ ASBATUL MAMI [0064135]', '2026-07-29 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-08 10:35:14', '2026-07-30 11:33:02', '05-PU FD AC PS 2026'),
(215, 'DB626180', '2026-07-07', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '292686', 'K15BT', '1775211', NULL, NULL, 130360000, NULL, NULL, NULL, 130360000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-08 10:36:25', '2026-07-08 10:36:25', '05-PU FD AC PS 2026'),
(216, 'DB626180', '2026-07-07', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '292686', 'K15BT', '1775211', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIAWI', NULL, 'sold', NULL, 'JONEL NADEAK [0064328]', '2026-08-13 00:00:00', 'CIAWI', NULL, NULL, '2026-07-08 10:37:49', '2026-08-14 10:55:29', '05-PU FD AC PS 2026'),
(217, 'DB626181', '2026-07-07', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'GRAPHITE GREY METALLIC', 2026, 'MHYHDC61TTJ', '292953', 'K15BT', '1775853', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIANJUR', NULL, 'sold', NULL, 'H DIN DIN SETIAWAN [0063759]', '2026-07-09 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-08 10:38:56', '2026-07-10 10:30:54', '05-PU FD AC PS 2026'),
(218, 'DB626083', '2026-07-07', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '293033', 'K15BT', '1775662', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'DIDIN [0064037]', '2026-07-21 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-08 10:40:51', '2026-07-22 11:44:09', '05-PU FD 2026'),
(219, 'DB626084', '2026-07-07', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '290361', 'K15BT', '1771525', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CINERE', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-08 10:42:04', '2026-07-11 09:17:30', '05-PU FD 2026'),
(220, 'DB626085', '2026-07-07', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '290406', 'K15BT', '1771719', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'sold', NULL, 'CV.DAVIENA ALAM CIBODAS [0063983]', '2026-07-21 00:00:00', 'CIAWI', NULL, NULL, '2026-07-08 10:43:13', '2026-07-22 11:43:39', '05-PU FD 2026'),
(221, 'DB626086', '2026-07-07', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '291259', 'K15BT', '1772702', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'DIAN HADIANTI [0063938]', '2026-07-13 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-08 10:45:08', '2026-07-15 11:25:22', '05-PU FD 2026'),
(222, 'DB626087', '2026-07-07', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '291458', 'K15BT', '1773217', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'JATIASIH', NULL, 'free', NULL, NULL, '2026-08-13 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-08 10:46:32', '2026-08-18 08:33:14', '05-PU FD 2026'),
(223, 'DB626539', '2026-07-10', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '293442', 'K15BT', '1776429', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIAWI', NULL, 'sold', NULL, 'YOSEP HIDAYAT [0064175]', '2026-08-11 00:00:00', 'CIAWI', NULL, NULL, '2026-07-11 09:52:21', '2026-08-12 08:44:06', '05-PU FD AC PS 2026'),
(224, 'DB626540', '2026-07-10', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '293424', 'K15BT', '1776206', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIANJUR', NULL, 'sold', NULL, 'DADANG RUSTANDI [0064212]', '2026-08-03 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-11 09:53:20', '2026-08-06 13:38:35', '05-PU FD AC PS 2026'),
(225, 'DB626529', '2026-07-10', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '290553', 'K15BT', '1771958', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'EKA DUMYATI [0063674]', '2026-07-31 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-11 09:55:59', '2026-08-03 09:38:17', '05-PU FD 2026'),
(226, 'DB626530', '2026-07-10', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '290595', 'K15BT', '1772002', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'sold', NULL, 'ANDRI SUHAEMI [0064220]', '2026-08-11 00:00:00', 'CIAWI', NULL, NULL, '2026-07-11 09:56:54', '2026-08-12 08:42:56', '05-PU FD 2026'),
(227, 'DB626531', '2026-07-10', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '292850', 'K15BT', '1775387', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'ROHMAT WITULAR [0064023]', '2026-07-20 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-11 09:58:11', '2026-07-21 10:38:04', '05-PU FD 2026'),
(228, 'DB626532', '2026-07-10', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '292873', 'K15BT', '1775437', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'EDI ABDUL HAYI [0060258]', '2026-07-22 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-11 09:58:58', '2026-07-23 10:08:17', '05-PU FD 2026'),
(229, 'DB626533', '2026-07-10', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '290850', 'K15BT', '1772322', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIPANAS', NULL, 'sold', NULL, 'SUHERMAN [0063965]', '2026-07-22 00:00:00', 'CIPANAS', NULL, NULL, '2026-07-11 10:00:12', '2026-07-23 10:09:26', '05-PU FD 2026'),
(230, 'DB626534', '2026-07-10', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '292220', 'K15BT', '1774267', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'ACHMAD SYAPEI [0064001]', '2026-07-23 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-11 10:02:27', '2026-07-24 10:13:18', '05-PU FD 2026'),
(231, 'DB626528', '2026-07-10', NULL, NULL, NULL, NULL, NULL, 'AEV415W.36WDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '291414', 'K15BT', '1772938', NULL, NULL, 124590000, NULL, NULL, 10700000, 113890000, 'CIAWI', NULL, 'free', NULL, 'UKI', '2026-08-11 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-11 10:05:25', '2026-08-14 14:03:23', '05-PU WD 2026'),
(232, 'DB626541', '2026-07-10', NULL, NULL, NULL, NULL, NULL, 'AEV415W.46WDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '290801', 'K15BT', '1772353', NULL, NULL, 131210000, NULL, NULL, 10700000, 120510000, 'CIAWI', NULL, 'sold', NULL, 'AZAN NASRY [0064187]', '2026-08-15 00:00:00', 'CIAWI', NULL, NULL, '2026-07-11 10:06:38', '2026-08-18 10:12:55', '05-PU WD AC PS 2026'),
(233, 'DB626542', '2026-07-10', NULL, NULL, NULL, NULL, NULL, 'AEV415W.46WDMTT', 'NEW CARRY', 'GRAPHITE GREY METALLIC', 2026, 'MHYHDC61TTJ', '293522', 'K15BT', '1776805', NULL, NULL, 131210000, NULL, NULL, 10700000, 120510000, 'CIANJUR', NULL, 'sold', NULL, 'MULYANA RAMADAN [0063881]', '2026-07-16 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-11 10:07:40', '2026-07-16 15:28:11', '05-PU WD AC PS 2026'),
(234, 'DB626571', '2026-07-10', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'GRAPHITE GREY METALLIC', 2026, 'MHYHDC61TTJ', '293480', 'K15BT', '1776551', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIANJUR', NULL, 'sold', NULL, 'JAMALUDIN [0053516]', '2026-07-13 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-11 10:08:36', '2026-07-15 11:24:58', '05-PU FD AC PS 2026'),
(235, 'DB626736', '2026-07-13', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '291987', 'K15BT', '1774566', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'TIA MUTIARA [0064056]', '2026-07-23 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-15 10:11:36', '2026-07-24 10:13:45', '05-PU FD 2026'),
(236, 'DB626735', '2026-07-13', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '293435', 'K15BT', '1776491', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIPANAS', NULL, 'sold', NULL, 'APID [0064257]', '2026-08-08 00:00:00', 'CIPANAS', NULL, NULL, '2026-07-15 10:14:22', '2026-08-10 09:42:25', '05-PU FD AC PS 2026'),
(237, 'DB627192', '2026-07-15', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '293935', 'K15BT', '1777450', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIAWI', NULL, 'free', NULL, NULL, '2026-08-19 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-16 10:17:25', '2026-08-22 11:50:00', '05-PU FD AC PS 2026'),
(238, 'DB627193', '2026-07-15', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '291909', 'K15BT', '1773758', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIAWI', NULL, 'sold', NULL, 'PUPU PUDOLI [0063634]', '2026-08-19 00:00:00', 'CIAWI', NULL, NULL, '2026-07-16 10:18:30', '2026-08-20 08:30:48', '05-PU FD AC PS 2026'),
(239, 'DB627194', '2026-07-15', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '292660', 'K15BT', '1774973', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'NANIH [0042637]', '2026-07-28 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-16 10:19:43', '2026-07-30 11:24:15', '05-PU FD 2026'),
(240, 'DB627195', '2026-07-15', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '292700', 'K15BT', '1775057', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'NURHAYATI [0064137]', '2026-07-28 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-16 10:20:51', '2026-07-30 11:24:04', '05-PU FD 2026'),
(241, 'DB627366', '2026-07-16', NULL, NULL, NULL, NULL, NULL, 'A3L415FM10GXMTT', 'FRONX', 'SAVANA IVORY', 2026, 'MHYMWDB3STJ', '104430', 'K15C-', '1102459', NULL, NULL, 239970000, 1351037, NULL, 6700000, 234621037, 'CIAWI', NULL, 'free', NULL, NULL, '2026-07-23 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-17 13:46:56', '2026-07-26 14:38:04', 'HYBRID GX MT 2026'),
(242, 'DB627425', '2026-07-17', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'GRAPHITE GREY METALLIC', 2026, 'MHYHDC61TTJ', '294267', 'K15BT', '1778189', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIAWI', NULL, 'sold', NULL, 'CECEP [0063963]', '2026-07-18 00:00:00', 'CIAWI', NULL, NULL, '2026-07-18 09:14:11', '2026-07-20 13:53:17', '05-PU FD AC PS 2026'),
(243, 'DB627654', '2026-07-20', NULL, NULL, NULL, NULL, NULL, 'A3L415FM10GLATT', 'FRONX', 'SNOW WHITE', 2026, 'MHYMWDA3STJ', '100911', 'K15BT', '1772491', NULL, NULL, 229300000, 1351037, NULL, 6700000, 223951037, 'CIAWI', NULL, 'free', NULL, NULL, '2026-07-25 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-21 10:22:05', '2026-07-28 13:19:29', 'GL AT 2026'),
(244, 'DB627655', '2026-07-20', NULL, NULL, NULL, NULL, NULL, 'A3L415FM10GLATT', 'FRONX', 'MET.MAGMA GRAY 2', 2026, 'MHYMWDA3STJ', '101052', 'K15BT', '1774808', NULL, NULL, 229300000, 1351037, NULL, 6700000, 223951037, 'CIAWI', NULL, 'sold', NULL, 'ADITIA FUJI HARYANTI AZI [0064051]', '2026-07-23 00:00:00', 'CIAWI', NULL, NULL, '2026-07-21 10:24:09', '2026-07-24 10:12:51', 'GL AT 2026'),
(245, 'DB628124', '2026-07-22', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00SXATS', 'FRONX', 'SAVANA IVORY', 2025, 'MHYMWDB3SSJ', '109654', 'K15C-', '1089659', NULL, NULL, 278980000, 1351037, NULL, 10700000, 269631037, 'CIAWI', NULL, 'sold', NULL, 'NIDYA HARYATI [0064047]', '2026-07-27 00:00:00', 'CIAWI', NULL, NULL, '2026-07-23 09:43:19', '2026-07-28 10:36:57', 'HYBRID SGX AT'),
(246, 'DB628435', '2026-07-24', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '292613', 'K15BT', '1774830', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'MINTARSIH [0064200]', '2026-08-10 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-25 09:56:07', '2026-08-11 08:57:15', '05-PU FD 2026'),
(247, 'DB628436', '2026-07-24', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '292624', 'K15BT', '1774879', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'EDDY MULYADI [0064292]', '2026-08-11 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-25 09:57:55', '2026-08-12 13:48:46', '05-PU FD 2026'),
(248, 'DB628763', '2026-07-27', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '294146', 'K15BT', '1777969', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIPANAS', NULL, 'free', NULL, NULL, '2026-08-12 00:00:00', 'CIPANAS', 'DISPLAY CIPANAS', NULL, '2026-07-28 10:57:48', '2026-08-18 08:33:14', '05-PU FD AC PS 2026'),
(249, 'DB628764', '2026-07-27', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '294242', 'K15BT', '1778055', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIANJUR', NULL, 'sold', NULL, 'YAYU YULIAWATI [0064384]', '2026-08-19 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-28 10:59:05', '2026-08-20 08:33:16', '05-PU FD AC PS 2026'),
(250, 'DB628765', '2026-07-27', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '295234', 'K15BT', '1779908', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIAWI', NULL, 'sold', NULL, 'EMMY RIYANTI [0064239]', '2026-08-12 00:00:00', 'CIAWI', NULL, NULL, '2026-07-28 11:01:48', '2026-08-13 10:53:04', '05-PU FD AC PS 2026'),
(251, 'DB628766', '2026-07-27', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '293418', 'K15BT', '1776430', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-28 11:02:58', '2026-07-30 11:23:39', '05-PU FD 2026'),
(252, 'DB628767', '2026-07-27', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '293481', 'K15BT', '1776503', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'DADAN SUHENDAR [0064163]', '2026-07-31 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-28 11:04:05', '2026-08-01 10:08:58', '05-PU FD 2026'),
(253, 'DB628768', '2026-07-27', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-28 11:04:39', '2026-07-28 11:04:39', '05-PU FD 2026'),
(254, 'DB628768', '2026-07-27', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '293485', 'K15BT', '1776409', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'sold', NULL, 'ABDULLOH [0064126]', '2026-07-31 00:00:00', 'CIAWI', NULL, NULL, '2026-07-28 11:05:54', '2026-07-31 22:56:50', '05-PU FD 2026'),
(255, 'DB628796', '2026-07-27', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '294597', 'K15BT', '1778839', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'MELLY MARYANIE YULIANA [0044310]', '2026-07-28 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-28 11:07:05', '2026-07-29 10:03:52', '05-PU FD 2026'),
(256, 'DB629100', '2026-07-28', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GXATT', 'NEW XL-7', 'MET.MAGMA GRAY 2', 2026, 'MHYANC32STJ', '104080', 'K15BT', '1777507', NULL, NULL, 225820000, 2017565, NULL, 10700000, 217137565, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, 'TEST DRIVE MAU DI JUAL', NULL, '2026-07-29 09:54:59', '2026-08-11 10:37:02', 'NEW BETA AT MC 2026'),
(257, 'DB629569', '2026-07-29', NULL, NULL, NULL, NULL, NULL, 'GC415V.M71GLMTT', 'APV', 'SILKY SILVER METALIC', 2026, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-30 10:22:54', '2026-07-30 10:22:54', 'FE GL AB MT'),
(258, 'DB629569', '2026-07-29', NULL, NULL, NULL, NULL, NULL, 'GC415V.M71GLMTT', 'APV', 'SILKY SILVER METALIC', 2026, 'MHYGDN42VTJ', '400607', 'G15AID', '454457', NULL, NULL, 180830000, 2017565, NULL, 700000, 182147565, 'CIAWI', NULL, 'sold', NULL, 'BAHAR MAKARIM QQ YAYASAN AL ITTIHAD RAWABANGO CIANJUR [0064129]', '2026-07-31 00:00:00', 'CIAWI', NULL, NULL, '2026-07-30 10:24:37', '2026-07-31 13:55:38', 'FE GL AB MT'),
(259, 'DB629702', '2026-07-29', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GLATT', 'NEW XL-7', 'MARBLE BLACK', 2026, 'MHYANC22STJ', '102040', 'K15BT', '1777426', NULL, NULL, 232030000, 2017565, NULL, 10700000, 223347565, 'CIPANAS', NULL, 'free', NULL, NULL, NULL, NULL, 'DISPLAY CIPANAS', NULL, '2026-07-30 10:38:20', '2026-08-13 10:58:16', 'NEW ZETA AT MC 2026'),
(260, 'DB629703', '2026-07-29', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GLATT', 'NEW XL-7', 'SNOW WHITE', 2026, 'MHYANC22STJ', '101993', 'K15BT', '1776710', NULL, NULL, 232030000, 2017565, NULL, 10700000, 223347565, 'CINERE', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-30 10:41:15', '2026-08-07 13:39:00', 'NEW ZETA AT MC 2026'),
(261, 'DB629704', '2026-07-29', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GLATT', 'NEW XL-7', 'SNOW WHITE', 2026, 'MHYANC22STJ', '102026', 'K15BT', '1776857', NULL, NULL, 232030000, 2017565, NULL, 10700000, 223347565, 'CIAWI', NULL, 'free', NULL, 'HENI', '2026-08-05 00:00:00', 'CIAWI', NULL, NULL, '2026-07-30 10:43:19', '2026-08-08 13:54:04', 'NEW ZETA AT MC 2026'),
(262, 'DB629705', '2026-07-29', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GLATT', 'NEW XL-7', 'SNOW WHITE', 2026, 'MHYANC22STJ', '102120', 'K15BT', '1778039', NULL, NULL, 232030000, 2017565, NULL, 10700000, 223347565, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, 'PAMERAN SUPERINDO BOGOR', NULL, '2026-07-30 10:55:51', '2026-08-01 10:03:49', 'NEW ZETA AT MC 2026'),
(263, 'DB629706', '2026-07-29', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GLATT', 'NEW XL-7', 'MET.MAGMA GRAY 2', 2026, 'MHYANC22STJ', '102069', 'K15BT', '1777594', NULL, NULL, 232030000, 2017565, NULL, 10700000, 223347565, 'JATIASIH', NULL, 'sold', NULL, 'R.TONY HARYONO, SE [0064282]', '2026-08-13 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-30 10:57:29', '2026-08-14 10:56:04', 'NEW ZETA AT MC 2026'),
(264, 'DB629707', '2026-07-29', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GLATT', 'NEW XL-7', 'MET.MAGMA GRAY 2', 2026, 'MHYANC22STJ', '102243', 'K15BT', '1779497', NULL, NULL, 232030000, 2017565, NULL, 10700000, 223347565, 'CIAWI', NULL, 'free', NULL, 'AZIZ', '2026-08-19 00:00:00', 'CIAWI', NULL, NULL, '2026-07-30 10:59:19', '2026-08-22 11:50:00', 'NEW ZETA AT MC 2026'),
(265, 'DB629708', '2026-07-29', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GLMTT', 'NEW XL-7', 'MARBLE BLACK', 2026, 'MHYANC22STJ', '102009', 'K15BT', '1776748', NULL, NULL, 222880000, 2017565, NULL, 10700000, 214197565, 'JATIASIH', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-30 11:04:52', '2026-08-12 08:58:35', 'NEW ZETA MT MC 2026'),
(266, 'DB629709', '2026-07-29', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GLMTT', 'NEW XL-7', 'SNOW WHITE', 2026, 'MHYANC22STJ', '102178', 'K15BT', '1778875', NULL, NULL, 222880000, 2017565, NULL, 10700000, 214197565, 'CIAWI', NULL, 'sold', NULL, 'MUHAMMAD ENCEP [0064303]', '2026-08-12 00:00:00', 'CIAWI', NULL, NULL, '2026-07-30 11:07:27', '2026-08-13 10:52:16', 'NEW ZETA MT MC 2026'),
(267, 'DB629746', '2026-07-29', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GXATT', 'NEW XL-7', 'MARBLE BLACK', 2026, 'MHYANC32STJ', '103735', 'K15BT', '1775111', NULL, NULL, 255820000, 2017565, NULL, 10700000, 247137565, 'CIANJUR', NULL, 'free', NULL, NULL, NULL, NULL, 'PAMERAN NAKO CIANJUR', NULL, '2026-07-30 11:09:50', '2026-08-12 08:58:14', 'NEW BETA AT MC 2026'),
(268, 'DB629747', '2026-07-29', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GXATT', 'NEW XL-7', 'SNOW WHITE', 2026, 'MHYANC32STJ', '104475', 'K15BT', '1779417', NULL, NULL, 255820000, 2017565, NULL, 10700000, 247137565, 'JATIASIH', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-30 11:14:37', '2026-08-04 10:31:16', 'NEW BETA AT MC 2026'),
(269, 'DB629748', '2026-07-29', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GXMTT', 'NEW XL-7', 'SNOW WHITE', 2026, 'MHYANC32STJ', '103921', 'K15BT', '1776917', NULL, NULL, 246790000, 2017565, NULL, 10700000, 238107565, 'CIANJUR', NULL, 'sold', NULL, 'TATI MASTUROH SPD [0064004]', '2026-08-04 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-30 11:15:57', '2026-08-05 09:44:41', 'NEW BETA MT MC 2026'),
(270, 'DB629932', '2026-07-30', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00SXATS', 'FRONX', 'SAVANA IVORY', 2025, 'MHYMWDB3SSJ', '109823', 'K15C-', '1090280', NULL, NULL, 278980000, 1351037, NULL, 10700000, 269631037, 'JATIASIH', NULL, 'free', NULL, NULL, NULL, NULL, 'DISPLAY JATIASIH', NULL, '2026-07-31 09:58:03', '2026-08-19 13:53:55', 'HYBRID SGX AT'),
(271, 'DB629933', '2026-07-30', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00SXATS', 'FRONX', 'SNOW WHITE', 2025, 'MHYMWDB3SSJ', '108771', 'K15C-', '1087322', NULL, NULL, 278980000, 1351037, NULL, 10700000, 269631037, 'JATIASIH', NULL, 'free', NULL, NULL, '2026-08-15 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-31 09:59:54', '2026-08-18 10:12:55', 'HYBRID SGX AT'),
(272, 'DB629934', '2026-07-30', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00SXATS', 'FRONX', 'SNOW WHITE', 2025, 'MHYMWDB3SSJ', '109209', 'K15C-', '1087606', NULL, NULL, 278980000, 1351037, NULL, 10700000, 269631037, 'CIANJUR', NULL, 'free', NULL, NULL, NULL, NULL, 'DISPLAY CIANJUR', NULL, '2026-07-31 10:01:52', '2026-08-21 11:21:03', 'HYBRID SGX AT'),
(273, 'DB629943', '2026-07-30', NULL, NULL, NULL, NULL, NULL, 'XL7415F.35GSATT', 'NEW XL-7', 'PRIME.ICE GRAYISH BLUE 2 + MARBLE BLACK', 2026, 'MHYANC32STJ', '103938', 'K15BT', '1777020', NULL, NULL, 271770000, 2017565, NULL, 10700000, 263087565, 'CIAWI', NULL, 'sold', NULL, 'PT DUTA CENDANA ADIMANDIRI [0058784]', '2026-08-15 00:00:00', 'CIAWI', 'TEST DRIVE CIAWI', NULL, '2026-07-31 10:08:58', '2026-08-18 10:35:47', 'NEW ALPHA AT HYBIRD 2TONE  MC 2026'),
(274, 'DB629944', '2026-07-30', NULL, NULL, NULL, NULL, NULL, 'XL7415F.35GSATT', 'NEW XL-7', 'PRIME.ICE GRAYISH BLUE 2 + MARBLE BLACK', 2026, 'MHYANC32STJ', '103943', 'K15BT', '1777048', NULL, NULL, 271770000, 2017565, NULL, 10700000, 263087565, 'CINERE', NULL, 'sold', NULL, 'PT. DUTA CENDANA ADIMANDIRI - JATIASIH [641940104]', '2026-08-20 00:00:00', 'CINERE', 'TEST DRIVE CINERE - JATIASIH', NULL, '2026-07-31 10:10:28', '2026-08-21 08:32:55', 'NEW ALPHA AT HYBIRD 2TONE  MC 2026'),
(275, 'DB629945', '2026-07-30', NULL, NULL, NULL, NULL, NULL, 'XL7415F.35GSATT', 'NEW XL-7', 'MET.SAVANNA IVORY 2 + MARBLE BLACK', 2026, 'MHYANC32STJ', '103952', 'K15BT', '1777412', NULL, NULL, 271770000, 2017565, NULL, 10700000, 263087565, 'CIAWI', NULL, 'sold', NULL, 'PT. DUTA CENDANA ADIMANDIRI - JATIASIH [641940104]', '2026-08-14 00:00:00', 'CIANJUR', 'TEST DRIVE', NULL, '2026-07-31 10:11:56', '2026-08-15 10:18:58', 'NEW ALPHA AT HYBIRD 2TONE  MC 2026'),
(276, 'DB629946', '2026-07-30', NULL, NULL, NULL, NULL, NULL, 'XL7415F.35GSATT', 'NEW XL-7', 'MET.SAVANNA IVORY 2 + MARBLE BLACK', 2026, 'MHYANC32STJ', '103953', 'K15BT', '1777442', NULL, NULL, 271770000, 2017565, NULL, 10700000, 263087565, 'JATIASIH', NULL, 'free', NULL, NULL, NULL, NULL, 'TEST DRIVE MAU DI JUAL', NULL, '2026-07-31 10:13:43', '2026-08-11 10:37:22', 'NEW ALPHA AT HYBIRD 2TONE  MC 2026'),
(277, 'DB630280', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GXMTT', 'NEW XL-7', 'SNOW WHITE', 2026, NULL, '104242', 'K15BT', '1778158', NULL, NULL, 246790000, 2017565, NULL, 10700000, 238107565, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 13:44:07', '2026-08-11 08:55:31', 'NEW BETA MT MC 2026'),
(278, 'DB630421', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '294194', 'K15BT', '1777862', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIPANAS', NULL, 'sold', NULL, 'KARTINI [0064309]', '2026-08-12 00:00:00', 'CIPANAS', NULL, NULL, '2026-07-31 20:01:28', '2026-08-13 10:54:31', '05-PU FD 2026'),
(279, 'DB630422', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '294144', 'K15BT', '1777897', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CINERE', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 20:04:09', '2026-08-04 15:07:45', '05-PU FD 2026');
INSERT INTO `stocks` (`id`, `no_do`, `tanggal_do`, `unit_id`, `varian_id`, `gudang_id`, `cabang_id`, `warna_id`, `kode_mobil`, `nama_mobil`, `warna`, `tahun`, `chassis_code`, `norangka`, `enginecode`, `nomesin`, `faktur`, `bln_naik_faktur`, `harga`, `kpt_kf`, `acs2`, `subsidi`, `hpp`, `lokasi`, `estimasi_unit_masuk_gudang_dca`, `status`, `lain_lain`, `penjualan`, `tanggal_matching_do`, `cabang`, `keterangan`, `unit`, `created_at`, `updated_at`, `varian`) VALUES
(280, 'DB630423', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '295399', 'K15BT', '1780104', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CINERE', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 20:05:20', '2026-08-04 15:08:02', '05-PU FD AC PS 2026'),
(281, 'DB630424', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '295466', 'K15BT', '1780307', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIANJUR', NULL, 'matching', NULL, 'ADE IRWAN', '2026-08-15 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-31 20:06:25', '2026-08-20 14:56:09', '05-PU FD AC PS 2026'),
(282, 'DB630425', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '295478', 'K15BT', '1780186', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIANJUR', NULL, 'matching', NULL, NULL, '2026-08-21 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-31 20:07:44', '2026-08-22 10:50:19', '05-PU FD AC PS 2026'),
(283, 'DB630426', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '295448', 'K15BT', '1780219', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 20:08:46', '2026-08-10 08:42:01', '05-PU FD AC PS 2026'),
(284, 'DB630677', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '295535', 'K15BT', '1780462', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 20:10:35', '2026-08-10 08:42:31', '05-PU FD AC PS 2026'),
(285, 'DB630678', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'AEV415W.36WDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '292765', 'K15BT', '1775162', NULL, NULL, 124590000, NULL, NULL, 10700000, 113890000, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 20:12:27', '2026-08-08 08:57:33', '05-PU WD 2026'),
(286, 'DB630684', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'AEV415W.46WDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '292731', 'K15BT', '1774969', NULL, NULL, 131210000, NULL, NULL, 10700000, 120510000, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 20:14:16', '2026-08-10 08:42:44', '05-PU WD AC PS 2026'),
(287, 'DB630685', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'AEV415W.46WDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '292859', 'K15BT', '1775847', NULL, NULL, 131210000, NULL, NULL, 10700000, 120510000, 'JATIASIH', NULL, 'sold', NULL, 'IRWAN NABABAN [0064315]', '2026-08-13 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-31 20:20:48', '2026-08-14 10:56:30', '05-PU WD AC PS 2026'),
(288, 'DB630697', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'GC415V.M71BVMTT', 'APV', 'WHITE', 2026, 'MHYGDN41VTJ', '400859', 'G15AID', '454977', NULL, NULL, 134220000, NULL, NULL, 700000, 133520000, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 20:22:51', '2026-08-07 09:24:51', 'FE GE PS DEL.VAN MT 2026 (BLINDVAN)'),
(289, 'DB630698', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'GC415V.M71GXMTT', 'APV', 'WHITE', 2026, 'MHYGDN42VTJ', '400526', 'G15AID', '454079', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'CINERE', NULL, 'sold', NULL, 'KECAMATAN CIMANGGIS KOTA DEPOK QQ MASHURY [0064162]', '2026-07-31 00:00:00', 'CINERE', NULL, NULL, '2026-07-31 20:24:40', '2026-08-04 10:30:59', 'FE GX AB MT'),
(290, 'DB630418', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '295677', 'K15BT', '1780738', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'WAHYU [0064208]', '2026-08-05 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-31 20:25:53', '2026-08-06 13:40:42', '05-PU FD 2026'),
(291, 'DB630494', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '294176', 'K15BT', '1777987', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'sold', NULL, 'PT SERBA USAHA [0024888]', '2026-08-13 00:00:00', 'CIANJUR', NULL, NULL, '2026-07-31 20:41:38', '2026-08-14 10:57:50', '05-PU FD 2026'),
(292, 'DB630495', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '294204', 'K15BT', '1778064', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'sold', NULL, 'M.FIRDAUS FAISOL [0064172]', '2026-08-19 00:00:00', 'CIAWI', NULL, NULL, '2026-07-31 20:42:38', '2026-08-20 08:31:30', '05-PU FD 2026'),
(293, 'DB630696', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00SXATS', 'FRONX', 'SAVANA IVORY', 2025, 'MHYMWDB3SSJ', '113242', 'K15C-', '1094059', NULL, NULL, 278980000, 1351037, NULL, 10700000, 269631037, 'CINERE', NULL, 'free', NULL, NULL, NULL, NULL, 'DISPLAY CINERE', NULL, '2026-07-31 22:06:40', '2026-08-20 14:55:43', 'HYBRID SGX AT'),
(294, 'DB630708', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'XL7415F.35GSATT', 'NEW XL-7', 'PRL.SNOW WHITE 4 + MARBLE BLACK', 2026, 'MHYANC32STJ', '103702', 'K15BT', '1775098', NULL, NULL, 271770000, 2017565, NULL, 10700000, 263087565, 'CIANJUR', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 22:12:44', '2026-08-14 10:26:19', 'NEW ALPHA AT HYBIRD 2TONE  MC 2026'),
(295, 'DB630699', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00SXATS', 'FRONX', 'COOL BLACK MET', 2025, 'MHYMWDB3SSJ', '110366', 'K15C-', '1090929', NULL, NULL, 278980000, 1351037, NULL, 6700000, 273631037, 'CIAWI', NULL, 'matching', NULL, 'HENI', '2026-08-20 00:00:00', 'CIAWI', 'DISPLAY CIAWI', NULL, '2026-07-31 22:39:25', '2026-08-20 13:32:18', 'HYBRID SGX AT'),
(296, 'DB630709', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '294320', 'K15BT', '1778151', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIPANAS', NULL, 'matching', NULL, NULL, '2026-08-21 00:00:00', 'CIPANAS', 'DISPLAY CIPANAS', NULL, '2026-07-31 22:40:46', '2026-08-22 10:50:02', '05-PU FD 2026'),
(297, 'DB630710', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '294375', 'K15BT', '1778258', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 22:41:52', '2026-08-10 08:42:14', '05-PU FD 2026'),
(298, 'DB630714', '2026-07-31', NULL, NULL, NULL, NULL, NULL, 'A3L415FM01SXATS', 'FRONX', 'ICE GRAYISH BLUE', 2025, 'MHYMWDB3SSJ', '112442', 'K15C-', '1092123', NULL, NULL, 280880000, 1351037, NULL, 6700000, 275531037, 'JATIASIH', NULL, 'sold', NULL, 'MAULANA MUHAMMAD RAYYAN [0064326]', '2026-08-18 00:00:00', 'JATIASIH', NULL, NULL, '2026-07-31 22:43:20', '2026-08-19 10:04:07', 'HYBRID SGX 2TONE AT 2025'),
(299, 'DB631622', '2026-08-07', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GSATT', 'NEW XL-7', 'MARBLE BLACK', 2026, 'MHYANC32STJ', '104205', 'K15BT', '1778132', NULL, NULL, 269870000, 2017565, NULL, 10700000, 261187565, 'JATIASIH', NULL, 'sold', NULL, 'CV EKSELENSI SEJAHTERA AMANAH [0064225]', '2026-08-12 00:00:00', 'CINERE', NULL, NULL, '2026-08-08 09:05:21', '2026-08-13 10:53:33', 'NEW ALPHA AT HYBRID MC 2026'),
(300, 'DB631790', '2026-08-10', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GSATT', 'NEW XL-7', 'MARBLE BLACK', 2026, 'MHYANC32STJ', '104656', 'K15BT', '1779801', NULL, NULL, 269870000, 2017565, NULL, 10700000, 261187565, 'CIAWI', NULL, 'sold', NULL, 'QORINA ASTIN [0064173]', '2026-08-12 00:00:00', 'CIAWI', NULL, NULL, '2026-08-11 10:15:41', '2026-08-13 10:52:38', 'NEW ALPHA AT HYBRID MC 2026'),
(301, 'DB631791', '2026-08-10', NULL, NULL, NULL, NULL, NULL, '6N415VX00012ATS', 'JIMNY', 'SLD. KINETIC YELLOW/PRL.BLUISH BLACK 3', 2025, 'MA3JJC74WS0', '225740', 'K15BN', '4452325', NULL, NULL, 393420000, 4104891, NULL, 5700000, 391824891, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-11 10:19:04', '2026-08-11 10:19:04', '5 DOORS 2TONE AT 2025'),
(302, 'DB631791', '2026-08-10', NULL, NULL, NULL, NULL, NULL, '6N415VX00012ATS', 'JIMNY', 'SLD. KINETIC YELLOW/PRL.BLUISH BLACK 3', 2025, 'MA3JJC74WS0', '225740', 'K15BN', '4452325', NULL, NULL, 393420000, 4104891, NULL, 5700000, 391824891, 'JATIASIH', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-11 10:20:53', '2026-08-19 14:39:57', '5 DOORS 2TONE AT 2025'),
(303, 'DB632229', '2026-08-11', NULL, NULL, NULL, NULL, NULL, 'A3L415FM01SXATS', 'FRONX', 'ICE GRAYISH BLUE', 2025, 'MHYMWDB3SSJ', '113406', 'K15C-', '1094210', NULL, NULL, 280880000, 1351037, NULL, 6700000, 275531037, 'CIAWI', NULL, 'free', NULL, NULL, '2026-08-19 00:00:00', 'CIAWI', NULL, NULL, '2026-08-12 08:53:55', '2026-08-22 09:58:16', 'HYBRID SGX 2TONE AT 2025'),
(304, 'DB632230', '2026-08-11', NULL, NULL, NULL, NULL, NULL, 'A3L415FM01SXATS', 'FRONX', 'ICE GRAYISH BLUE', 2025, 'MHYMWDB3SSJ', '113523', 'K15C-', '1095777', NULL, NULL, 280880000, 1351037, NULL, 6700000, 275531037, 'CIAWI', NULL, 'sold', NULL, 'UJANG HAMBALI,SE [0064393]', '2026-08-20 00:00:00', 'CIAWI', NULL, NULL, '2026-08-12 08:55:16', '2026-08-21 08:32:07', 'HYBRID SGX 2TONE AT 2025'),
(305, 'DB632242', '2026-08-11', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GSATT', 'NEW XL-7', 'MARBLE BLACK', 2026, 'MHYANC32STJ', '104687', 'K15BT', '1780051', NULL, NULL, 269870000, 2017565, NULL, 10700000, 261187565, 'JATIASIH', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-12 08:57:04', '2026-08-13 13:40:23', 'NEW ALPHA AT HYBRID MC 2026'),
(306, 'DB632295', '2026-08-12', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'GRAPHITE GREY METALLIC', 2026, 'MHYHDC61TTJ', '296990', 'K15BT', '1782148', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIANJUR', NULL, 'sold', NULL, 'SANSAN NURHASANAH [0063912]', '2026-08-14 00:00:00', 'CIANJUR', NULL, NULL, '2026-08-13 10:18:49', '2026-08-15 10:14:06', '05-PU FD AC PS 2026'),
(307, 'DB632296', '2026-08-12', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '296935', 'K15BT', '1783104', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIANJUR', NULL, 'free', NULL, NULL, '2026-08-13 00:00:00', 'CIANJUR', NULL, NULL, '2026-08-13 10:20:20', '2026-08-18 10:28:38', '05-PU FD 2026'),
(308, 'DB632477', '2026-08-13', NULL, NULL, NULL, NULL, NULL, 'AEV415W.46WDMTT', 'NEW CARRY', 'REAL BLACK', 2025, 'MHYHDC61TTJ', '293873', 'K15BT', '1777344', NULL, NULL, 131120000, NULL, NULL, 10700000, 120420000, 'JATIASIH', NULL, 'sold', NULL, 'SEPTYANIE ELVIONITA SIMANUNGKALIT [0064198]', '2026-08-14 00:00:00', 'JATIASIH', NULL, NULL, '2026-08-13 10:22:37', '2026-08-19 14:39:34', '05-PU WD AC PS 2026'),
(309, 'SBAM DB619731', '2026-08-13', NULL, NULL, NULL, NULL, NULL, '6N415VX00012ATS', 'JIMNY', 'MET.CHIFFON IVORY 2/PRL.BLUISH 4', 2025, 'MA3JJC74WS0', '220283', 'K15BN', '4446785', NULL, NULL, 395420000, 4104891, NULL, 35700000, 363824891, 'CIANJUR', NULL, 'sold', NULL, 'MERFY IRAWAN [0064265]', '2026-08-15 00:00:00', 'CIANJUR', 'UNIT DARI SBAM', NULL, '2026-08-13 10:51:10', '2026-08-19 09:49:20', '5 DOORS 2TONE AT 2025'),
(310, 'DB632572', '2026-08-13', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '297238', 'K15BT', '1783532', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIAWI', NULL, 'sold', NULL, 'BURHAN [0064390]', '2026-08-19 00:00:00', 'CIAWI', NULL, NULL, '2026-08-14 10:44:57', '2026-08-20 08:31:10', '05-PU FD AC PS 2026'),
(311, 'DB632566', '2026-08-13', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '297232', 'K15BT', '1783539', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-14 10:47:14', '2026-08-15 10:21:40', '05-PU FD 2026'),
(312, 'DB632567', '2026-08-13', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '297126', 'K15BT', '1783347', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'matching', NULL, NULL, '2026-08-22 00:00:00', 'CIAWI', NULL, NULL, '2026-08-14 10:48:30', '2026-08-22 09:09:25', '05-PU FD 2026'),
(313, 'DB633013', '2026-08-14', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '297503', 'K15BT', '1783992', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-15 09:50:08', '2026-08-19 09:48:29', '05-PU FD 2026'),
(314, 'DB633014', '2026-08-14', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', NULL, 2026, 'MHYHDC61TTJ', NULL, 'K15BT', NULL, NULL, NULL, 123, NULL, NULL, NULL, 123, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-15 09:50:53', '2026-08-15 09:50:53', '05-PU FD 2026'),
(315, 'DB633014', '2026-08-14', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '297370', 'K15BT', '1783822', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-15 09:51:53', '2026-08-19 14:38:23', '05-PU FD 2026'),
(316, 'DB633015', '2026-08-14', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '297390', 'K15BT', '1783826', NULL, NULL, 123839998, NULL, NULL, 10700000, 113139998, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-15 09:52:52', '2026-08-19 09:48:12', '05-PU FD 2026'),
(317, 'DB633016', '2026-08-14', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '294827', 'K15BT', '1778996', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-15 09:53:33', '2026-08-19 14:37:15', '05-PU FD 2026'),
(318, 'DB633017', '2026-08-14', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '294883', 'K15BT', '1779114', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-15 10:03:31', '2026-08-19 14:37:28', '05-PU FD 2026'),
(319, 'DB633018', '2026-08-14', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'GRAPHITE GREY METALLIC', 2026, 'MHYHDC61TTJ', '297485', 'K15BT', '1783950', NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'CIPANAS', NULL, 'sold', NULL, 'LUSI SUPRIYATIN [0064171]', '2026-08-20 00:00:00', 'CIPANAS', NULL, NULL, '2026-08-15 10:06:30', '2026-08-21 08:34:49', '05-PU FD AC PS 2026'),
(320, 'DB633170', '2026-08-18', NULL, NULL, NULL, NULL, NULL, 'AEV415W.46WDMTT', 'NEW CARRY', 'SILKY SILVER METALIC', 2026, 'MHYHDC61TTJ', '296855', 'K15BT', '1783093', NULL, NULL, 131210000, NULL, NULL, 10700000, 120510000, 'TAMBUN', NULL, 'matching', NULL, NULL, '2026-08-22 00:00:00', 'CINERE', NULL, NULL, '2026-08-19 10:17:20', '2026-08-22 11:51:54', '05-PU WD AC PS 2026'),
(321, 'DB633171', '2026-08-18', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', '296735', 'K15BT', '1784105', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'TAMBUN', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-19 10:18:57', '2026-08-19 14:41:46', '05-PU FD 2026'),
(322, 'DB633172', '2026-08-18', NULL, NULL, NULL, NULL, NULL, 'XL7415F.35GSATT', 'NEW XL-7', 'MET.SAVANNA IVORY 2 + MARBLE BLACK', 2026, 'MHYANC32STJ', '104770', 'K15BT', '1780474', NULL, NULL, 271770000, 2017564, NULL, 10700000, 263087564, 'CIANJUR', NULL, 'sold', NULL, 'YENI MULYANI [0064361]', '2026-08-19 00:00:00', 'CIANJUR', NULL, NULL, '2026-08-19 10:20:52', '2026-08-20 11:31:47', 'NEW ALPHA AT HYBIRD 2TONE  MC 2026'),
(323, 'DB633263', '2026-08-18', NULL, NULL, NULL, NULL, NULL, 'A3L415FM01SXATT', 'FRONX', 'WHITE + BLACK TOP', 2026, 'MHYMWDB3STJ', '101144', 'K15C-', '1096194', NULL, NULL, 281900000, 1351037, NULL, 700000, 282551037, 'CIAWI', NULL, 'matching', NULL, NULL, '2026-08-19 00:00:00', 'CIANJUR', NULL, NULL, '2026-08-19 10:32:35', '2026-08-21 11:20:08', 'HYBIRD SGX AT 2TONE 2026'),
(324, 'DB633356', '2026-08-19', NULL, NULL, NULL, NULL, NULL, 'GC415V.M71GXMTT', 'APV', 'PEARL WHITE METALLIC', 2026, 'MHYGDN42VTJ', '400506', 'G15AID', '454199', NULL, NULL, 194240000, NULL, NULL, 700000, 193540000, 'TAMBUN', NULL, 'matching', NULL, 'IRFAN', '2026-08-20 00:00:00', 'CINERE', NULL, NULL, '2026-08-20 10:38:48', '2026-08-20 10:38:48', 'FE GX AB MT'),
(325, 'DB633422', '2026-08-19', NULL, NULL, NULL, NULL, NULL, 'XL7415F.35GSATT', 'NEW XL-7', 'PRIME.ICE GRAYISH BLUE 2 + MARBLE BLACK', 2026, 'MHYANC32STJ', '104184', 'K15BT', '1778255', NULL, NULL, 271770000, 2017565, NULL, 10700000, 263087565, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-20 10:38:49', '2026-08-21 11:19:51', 'NEW ALPHA AT HYBIRD 2TONE  MC 2026'),
(326, 'DB633423', '2026-08-19', NULL, NULL, NULL, NULL, NULL, 'XL7415F.35GSATT', 'NEW XL-7', 'MET.SAVANNA IVORY 2 + MARBLE BLACK', 2026, 'MHYANC32STJ', '104019', 'K15BT', '1777407', NULL, NULL, 271770000, 2017565, NULL, 10700000, 263087565, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-20 10:45:03', '2026-08-21 11:20:28', 'NEW ALPHA AT HYBIRD 2TONE  MC 2026'),
(327, 'DB633424', '2026-08-19', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GLATT', 'NEW XL-7', 'MARBLE BLACK', 2026, 'MHYANC22STJ', '102253', 'K15BT', '1779482', NULL, NULL, 232030000, 2017565, NULL, 10700000, 223347565, 'CIKARANG', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-20 10:47:40', '2026-08-20 10:47:40', 'NEW ZETA AT MC 2026'),
(328, 'DB633425', '2026-08-19', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GLATT', 'NEW XL-7', 'SNOW WHITE', 2026, 'MHYANC22STJ', '102429', '102429', '1780503', NULL, NULL, 232030000, 2017565, NULL, 10700000, 223347565, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-20 10:48:56', '2026-08-22 10:49:31', 'NEW ZETA AT MC 2026'),
(329, 'DB633399', '2026-08-19', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GLMTT', 'NEW XL-7', 'SNOW WHITE', 2026, 'MHYANC22STJ', '102493', 'K15BT', '1780992', NULL, NULL, 222880000, 2017565, NULL, 10700000, 214197565, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-20 10:50:27', '2026-08-22 10:48:16', 'NEW ZETA MT MC 2026'),
(330, 'DB633401', '2026-08-19', NULL, NULL, NULL, NULL, NULL, 'A3L415FM01SXATS', 'FRONX', 'ICE GRAYISH BLUE', 2025, 'MHYMWDB3SSJ', '113054', 'K15C-', '1093980', NULL, NULL, 280880000, 1351037, NULL, 6700000, 275531037, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-20 10:50:29', '2026-08-22 10:49:15', 'HYBRID SGX 2TONE AT 2025'),
(331, 'DB633402', '2026-08-19', NULL, NULL, NULL, NULL, NULL, 'A3L415FM01SXATS', 'FRONX', 'ICE GRAYISH BLUE', 2025, 'MHYMWDB3SSJ', '112956', 'K15C-', '1093872', NULL, NULL, 280880000, 1351037, NULL, 6700000, 275531037, 'CIAWI', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-20 10:54:15', '2026-08-22 10:48:58', 'HYBRID SGX 2TONE AT 2025'),
(332, 'DB633652', '2026-08-20', NULL, NULL, NULL, NULL, NULL, 'XL7415F.25GLMTT', 'NEW XL-7', 'MET.MAGMA GRAY 2', 2026, 'MHYANC22STJ', '102441', 'K15BT', '1780455', NULL, NULL, 222880000, 2017565, NULL, 10700000, 214197565, 'CIKARANG', NULL, 'matching', NULL, NULL, '2026-08-21 00:00:00', 'CIAWI', NULL, NULL, '2026-08-21 08:44:06', '2026-08-21 08:44:06', 'NEW ZETA MT MC 2026'),
(333, 'DB633653', '2026-08-20', NULL, NULL, NULL, NULL, NULL, 'XL7415F.35GSATT', 'NEW XL-7', 'PRL.SNOW WHITE 4 + MARBLE BLACK', 2026, 'MHYANC32STJ', '103983', 'K15BT', '1777410', NULL, NULL, 271770000, 2017565, NULL, 10700000, 263087565, 'CIKARANG', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-21 08:46:21', '2026-08-21 08:46:21', 'NEW ALPHA AT HYBIRD 2TONE  MC 2026'),
(334, 'DB633820', '2026-08-21', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '297091', 'K15BT', '1783272', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'TAMBUN', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-22 09:57:04', '2026-08-22 09:57:04', '05-PU FD 2026'),
(335, 'DB633821', '2026-08-21', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '297088', 'K15BT', '1783233', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'TAMBUN', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-22 09:58:15', '2026-08-22 09:58:15', '05-PU FD 2026'),
(336, 'DB633822', '2026-08-21', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '297015', 'K15BT', '1783285', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'TAMBUN', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-22 09:59:20', '2026-08-22 09:59:20', '05-PU FD 2026'),
(337, 'DB633823', '2026-08-21', NULL, NULL, NULL, NULL, NULL, 'AEV415P.36FDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', '297111', 'K15BT', '1783277', NULL, NULL, 123840000, NULL, NULL, 10700000, 113140000, 'TAMBUN', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-22 10:01:51', '2026-08-22 10:01:51', '05-PU FD 2026'),
(338, 'DB633824', '2026-08-21', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', NULL, 'K15BT', NULL, NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'TAMBUN', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-22 10:02:53', '2026-08-22 10:02:53', '05-PU FD AC PS 2026'),
(339, 'DB633825', '2026-08-21', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', NULL, 'K15BT', NULL, NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'TAMBUN', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-22 10:16:53', '2026-08-22 10:16:53', '05-PU FD AC PS 2026'),
(340, 'DB633826', '2026-08-21', NULL, NULL, NULL, NULL, NULL, 'AEV415P.46FDMTT', 'NEW CARRY', 'WHITE', 2026, 'MHYHDC61TTJ', NULL, 'K15BT', NULL, NULL, NULL, 130360000, NULL, NULL, 10700000, 119660000, 'TAMBUN', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-22 10:17:54', '2026-08-22 10:17:54', '05-PU FD AC PS 2026'),
(341, 'DB633828', '2026-08-21', NULL, NULL, NULL, NULL, NULL, 'AEV415W.46WDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', NULL, 'K15BT', NULL, NULL, NULL, 131210000, NULL, NULL, 10700000, 120510000, 'TAMBUN', NULL, 'matching', NULL, NULL, '2026-08-22 00:00:00', 'CINERE', NULL, NULL, '2026-08-22 10:19:16', '2026-08-22 10:19:39', '05-PU WD AC PS 2026'),
(342, 'DB633829', '2026-08-21', NULL, NULL, NULL, NULL, NULL, 'AEV415W.46WDMTT', 'NEW CARRY', 'REAL BLACK', 2026, 'MHYHDC61TTJ', NULL, 'K15BT', NULL, NULL, NULL, 131120000, NULL, NULL, 10700000, 120420000, 'TAMBUN', NULL, 'matching', NULL, NULL, '2026-08-22 00:00:00', 'CINERE', NULL, NULL, '2026-08-22 10:20:54', '2026-08-22 11:50:00', '05-PU WD AC PS 2026'),
(343, 'DB633831', '2026-08-21', NULL, NULL, NULL, NULL, NULL, 'A3L415FM00GXATT', 'FRONX', 'SNOW WHITE', 2026, NULL, NULL, NULL, NULL, NULL, NULL, 256220000, 1351037, NULL, 6700000, 250871037, 'CIKARANG', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-22 10:29:07', '2026-08-22 10:29:07', 'HYBIRD GX AT 2026'),
(344, 'DB633830', '2026-08-21', NULL, NULL, NULL, NULL, NULL, 'A3L415FM10GXATT', 'FRONX', 'MET.MAGMA GRAY 2', 2026, NULL, NULL, NULL, NULL, NULL, NULL, 256220000, 13510, NULL, NULL, 256233510, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-22 10:31:06', '2026-08-22 10:31:06', 'HYBIRD GX AT 2026'),
(345, 'DB633830', '2026-08-21', NULL, NULL, NULL, NULL, NULL, 'A3L415FM10GXATT', 'FRONX', 'MET.MAGMA GRAY 2', 2026, NULL, NULL, NULL, NULL, NULL, NULL, 256220000, 1351037, NULL, 6700000, 250871037, 'CIKARANG', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-22 10:32:24', '2026-08-22 10:32:24', 'HYBIRD GX AT 2026'),
(346, 'DB633968', '2026-08-21', NULL, NULL, NULL, NULL, NULL, 'A3L415FM12SXATT', 'FRONX', 'COOL BLACK MET', 2026, NULL, NULL, NULL, NULL, NULL, NULL, 282390000, 1351037, NULL, 700000, 283041037, 'CIKARANG', NULL, 'free', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-22 10:36:16', '2026-08-22 10:36:16', 'HYBRID SGX AT KURO 2026');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sumber_leads`
--

CREATE TABLE `sumber_leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_sumber` varchar(255) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `summaries`
--

CREATE TABLE `summaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `operasional` varchar(255) NOT NULL,
  `plan_perbaikan` text DEFAULT NULL,
  `aktual_perbaikan` text DEFAULT NULL,
  `do_dont` enum('X','V') DEFAULT NULL,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `summary_actions`
--

CREATE TABLE `summary_actions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `operasional` varchar(255) NOT NULL,
  `kondisi_yang_ada` text DEFAULT NULL,
  `action_perbaikan` text DEFAULT NULL,
  `do_dont` enum('X','V') DEFAULT NULL,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `target_do_by_soi`
--

CREATE TABLE `target_do_by_soi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `source_inquiry` enum('Call In (dari Iklan)','Canvasing','Data Base','Digital Hyperlocal','Digital Non Hyperlocal','Exhibition','Media Digital','Media Elektronik','Mediator','Referensi','Referensi Customer','Showroom Activity','Showroom Walk-in','Website Dealer') DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `jan` int(11) NOT NULL DEFAULT 0,
  `feb` int(11) NOT NULL DEFAULT 0,
  `mar` int(11) NOT NULL DEFAULT 0,
  `apr` int(11) NOT NULL DEFAULT 0,
  `mei` int(11) NOT NULL DEFAULT 0,
  `jun` int(11) NOT NULL DEFAULT 0,
  `jul` int(11) NOT NULL DEFAULT 0,
  `agu` int(11) NOT NULL DEFAULT 0,
  `sep` int(11) NOT NULL DEFAULT 0,
  `okt` int(11) NOT NULL DEFAULT 0,
  `nov` int(11) NOT NULL DEFAULT 0,
  `des` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `target_do_units`
--

CREATE TABLE `target_do_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis_unit` enum('Commercial','Passenger') NOT NULL,
  `type_unit` enum('NEW CARRY','APV BLIND VAN','ERTIGA','XL7','SPRESO','IGNIS','e-VITARA','GRAND VITARA','JIMNY 3D','JIMNY 5D','FRONX','BALENO') NOT NULL,
  `tahun` year(4) DEFAULT NULL,
  `jan` int(11) NOT NULL DEFAULT 0,
  `feb` int(11) NOT NULL DEFAULT 0,
  `mar` int(11) NOT NULL DEFAULT 0,
  `apr` int(11) NOT NULL DEFAULT 0,
  `mei` int(11) NOT NULL DEFAULT 0,
  `jun` int(11) NOT NULL DEFAULT 0,
  `jul` int(11) NOT NULL DEFAULT 0,
  `agu` int(11) NOT NULL DEFAULT 0,
  `sep` int(11) NOT NULL DEFAULT 0,
  `okt` int(11) NOT NULL DEFAULT 0,
  `nov` int(11) NOT NULL DEFAULT 0,
  `des` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `target_inquiries`
--

CREATE TABLE `target_inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `source_inquiry` enum('Call In (dari Iklan)','Canvasing','Data Base','Digital Hyperlocal','Digital Non Hyperlocal','Exhibition','Media Digital','Media Elektronik','Mediator','Referensi','Referensi Customer','Showroom Activity','Showroom Walk-in','Website Dealer') DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `jan` int(11) NOT NULL DEFAULT 0,
  `feb` int(11) NOT NULL DEFAULT 0,
  `mar` int(11) NOT NULL DEFAULT 0,
  `apr` int(11) NOT NULL DEFAULT 0,
  `mei` int(11) NOT NULL DEFAULT 0,
  `jun` int(11) NOT NULL DEFAULT 0,
  `jul` int(11) NOT NULL DEFAULT 0,
  `agu` int(11) NOT NULL DEFAULT 0,
  `sep` int(11) NOT NULL DEFAULT 0,
  `okt` int(11) NOT NULL DEFAULT 0,
  `nov` int(11) NOT NULL DEFAULT 0,
  `des` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `target_salesforces`
--

CREATE TABLE `target_salesforces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grading` enum('Freelance','Trainee','Silver','Gold','Platinum') DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `jan` int(11) NOT NULL DEFAULT 0,
  `feb` int(11) NOT NULL DEFAULT 0,
  `mar` int(11) NOT NULL DEFAULT 0,
  `apr` int(11) NOT NULL DEFAULT 0,
  `mei` int(11) NOT NULL DEFAULT 0,
  `jun` int(11) NOT NULL DEFAULT 0,
  `jul` int(11) NOT NULL DEFAULT 0,
  `agu` int(11) NOT NULL DEFAULT 0,
  `sep` int(11) NOT NULL DEFAULT 0,
  `okt` int(11) NOT NULL DEFAULT 0,
  `nov` int(11) NOT NULL DEFAULT 0,
  `des` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `teknisis`
--

CREATE TABLE `teknisis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `teknisis`
--

INSERT INTO `teknisis` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'BUDI SANTOSO', '2026-08-21 06:23:18', '2026-08-21 06:23:18'),
(2, 'TONO SUDIRO', '2026-08-21 15:06:20', '2026-08-21 15:06:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `units`
--

INSERT INTO `units` (`id`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
(2, 'NEW CARRY', NULL, '2026-06-29 11:02:55', '2026-06-29 11:03:36'),
(3, 'APV', NULL, '2026-06-29 11:03:46', '2026-06-29 11:03:46'),
(4, 'NEW XL-7', NULL, '2026-06-29 11:03:55', '2026-06-29 11:07:08'),
(5, 'FRONX', NULL, '2026-06-29 11:04:05', '2026-06-29 11:04:05'),
(6, 'JIMNY', NULL, '2026-06-29 11:04:12', '2026-06-29 11:11:29'),
(7, 'GRAND-VITARA', NULL, '2026-06-29 11:04:23', '2026-06-29 11:04:23'),
(8, 'S-PRESSO', NULL, '2026-06-29 11:04:34', '2026-06-29 11:04:34'),
(9, 'ALL NEW ERTIGA', NULL, '2026-06-29 11:04:49', '2026-06-30 14:49:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `unit_leads`
--

CREATE TABLE `unit_leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_unit` varchar(255) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `is_admin_stock` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `cabang` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `branch`, `is_admin`, `is_admin_stock`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `cabang`) VALUES
(1, 'Admin', 'admin@admin.com', 'admin', 1, 0, NULL, '$2y$12$CAp4UkS5QA4gzMghxcctVux0JyL5sr68lGCAQKe.PIctfwRQSnGk.', NULL, '2026-08-18 11:42:09', '2026-08-18 11:42:09', NULL, NULL),
(2, 'Admin Stock', 'adminstock@admin.com', 'stock', 0, 1, NULL, '$2y$12$anxbtdETw9GAfYarW513J.HBPQZWVuywBUe7Cd3smmFQK9xUAObWm', NULL, '2026-08-18 11:42:10', '2026-08-18 11:42:11', NULL, NULL),
(3, 'In Unit Jatiasih', 'inunit.jatiasih@suzuki.com', 'inunit_jatiasih', 0, 1, NULL, '$2y$12$XOvvvs9ws2FQ2hZxsoQ9uuiZ2xyEPGitpqrGANti5TFOGvCLlwWGG', NULL, '2026-08-18 11:42:10', '2026-08-18 11:42:10', NULL, NULL),
(4, 'In Unit Cinere', 'inunit.cinere@suzuki.com', 'inunit_cinere', 0, 1, NULL, '$2y$12$IydKwVUE46/m5omTaXDhPuk/qQH2/xDzoP1ScaEDcWfxzsapz7JCu', NULL, '2026-08-18 11:42:10', '2026-08-18 11:42:10', NULL, NULL),
(5, 'Admin AR Stock', 'AdminArStock@gmail.com', 'admin', 1, 1, NULL, '$2y$12$N8EuVqtS5ra5ALffCgOiw.DN1ejijZYI6t6qNBJ2LxiuRFG/bztj2', NULL, '2026-08-18 11:42:11', '2026-08-18 11:42:11', NULL, NULL),
(6, 'Ciawi', 'admsvc.cwi.dca@gmail.com', 'ciawi', 0, 0, NULL, '$2y$12$gfwSYh17Y9.7vMDwR6oXsOF8jcBxcVzrO6EJS.4dNPhMem94xU0RO', NULL, '2026-08-18 11:42:11', '2026-08-18 11:42:11', NULL, NULL),
(7, 'Cianjur', 'admsvc.cjr.dca@gmail.com', 'cianjur', 0, 0, NULL, '$2y$12$JjMa.8FPLOyk9GcltplFlu1De6FUzy/Lzj7KSEAvbHAoXVgR1C8LS', NULL, '2026-08-18 11:42:12', '2026-08-18 11:42:12', NULL, NULL),
(8, 'Cinere', 'admsvc.cnr.dca@gmail.com', 'cinere', 0, 0, NULL, '$2y$12$7bveSNnEQhA7o18Qfo2P4OOFUAaSLqb8ONv4y1hFvyfVNC8iAG7qS', NULL, '2026-08-18 11:42:12', '2026-08-18 11:42:12', NULL, NULL),
(9, 'Jatiasih', 'admsvc.jts.dca@gmail.com', 'jatiasih', 0, 0, NULL, '$2y$12$WwrJcR15XOkjhW/JRI5ySOYhvvU.y6HBlnBgmQTO.t928WFHIWy5e', NULL, '2026-08-18 11:42:13', '2026-08-18 11:42:13', NULL, NULL),
(10, 'BP', 'admbp.dcajts@gmail.com', 'bp', 0, 0, NULL, '$2y$12$EI5FFV48.2dP4saBX6knvO1JrlNvI3stalbUX6wmxlIyzJ7oG44Q2', NULL, '2026-08-18 11:42:13', '2026-08-18 11:42:13', NULL, NULL),
(11, 'Irfan Kurniawan', '11228', 'cinere', 0, 0, NULL, '$2y$12$kuP5Y3/rZ1vfLfkAIrrEFOi/YD5TlMirZsCjpOEVrMWO4hADH8XJG', NULL, '2026-08-19 09:26:22', '2026-08-20 02:31:17', 'bm_sh', 'cinere'),
(12, 'EDI SUMARDI', '13985', 'cipanas', 0, 0, NULL, '$2y$12$dIcdI8Q07GqeL862yNGRZuOXgWhBXcX.uERjaYpkjq/Qw74nCnx1a', NULL, '2026-08-19 09:26:22', '2026-08-20 02:31:18', 'bm_sh', 'cipanas'),
(13, 'FATONAH HASTA', '16452', 'jatiasih', 0, 0, NULL, '$2y$12$p3vhc4oFRi7ngcH0seiUu.O2KvQb815oH4u3n5rwJsO8M0BchKLUq', NULL, '2026-08-19 09:26:23', '2026-08-20 02:31:19', NULL, 'jatiasih'),
(14, 'HENI PUJI ASTUTI', '16469', 'ciawi', 0, 0, NULL, '$2y$12$Hi4dY6HdH0KkSHfZ8HCtzeh93b6ZJAO1gFRaSCCmjMg1WrvK/EPIe', NULL, '2026-08-19 09:26:23', '2026-08-20 02:31:20', NULL, 'ciawi'),
(15, 'GUSTIAN ANTON . S', '16491', 'ciawi', 0, 0, NULL, '$2y$12$Nvl.j9gsAmzg.Eit6lQQp.DeE7AAo8S2dqtu97iUbweoSsjEyX3FK', NULL, '2026-08-19 09:26:23', '2026-08-20 02:31:21', NULL, 'ciawi'),
(16, 'YUDHI KURNIAWAN', '22241', 'cianjur', 0, 0, NULL, '$2y$12$NaitMFEVIRocnXKwIXM02.nTBTKKQQOKzu1MkH3Enul.iunC36afO', NULL, '2026-08-19 09:26:24', '2026-08-20 02:31:26', NULL, 'cianjur'),
(17, 'ROSSE ROSMIATY', '25175', 'cianjur', 0, 0, NULL, '$2y$12$/KHTYVx8t8zTFr43wwewwumXhQIPpQXg1v3yI4JtsXoubXYpjzWdu', NULL, '2026-08-19 09:26:24', '2026-08-20 02:31:26', NULL, 'cianjur'),
(18, 'Dede sugianto', '27526', 'jatiasih', 0, 0, NULL, '$2y$12$fkJ2P/cKdJsmmJ9.TiTiyu5E2H4vJC6rL7hjzfu36qfPXe/RvTRxW', NULL, '2026-08-19 09:26:24', '2026-08-20 02:31:28', NULL, 'jatiasih'),
(19, 'HENDRIX SANTOSA', '29467', 'cianjur', 0, 0, NULL, '$2y$12$qysDFv.kVd1B0qp/QtHWmeipg9IA11wwKVGnBEaoJq4DNXElbCf2a', NULL, '2026-08-19 09:26:24', '2026-08-20 02:31:31', 'bm_sh', 'cianjur'),
(20, 'ADE RIDWAN', '33068', 'cianjur', 0, 0, NULL, '$2y$12$8Xwl2TVil0L1ZPn72CxIK.mui6IqWzYynqWTBMQW73AEBuobRvMSS', NULL, '2026-08-19 09:26:25', '2026-08-20 02:31:36', 'bm_sh', 'cianjur'),
(21, 'IQBAL AULIA RAHMAN', '34120', 'cianjur', 0, 0, NULL, '$2y$12$dvtBrWxcteHNUBPPo7cA2.Qls4bXB.24DL6dnhX3wCIBlDIPdfscC', NULL, '2026-08-19 09:26:25', '2026-08-20 02:31:37', 'bm_sh', 'cianjur'),
(22, 'ROPIK ARROHMAN', '3439', 'ciawi', 0, 0, NULL, '$2y$12$dD0TwJSXvgtbvO0qEgnGmuK0K4RTPJMDjSEGYQS9.g1oROXNXVrFG', NULL, '2026-08-19 09:26:25', '2026-08-20 02:31:38', 'bm_sh', 'ciawi'),
(23, 'ZULKARNAEN', '34595', 'ciawi', 0, 0, NULL, '$2y$12$r.4kxUm5wZOiCJK2fhsHeecYbRNokCkEFhZcfeB/jzUC4//u87f6q', NULL, '2026-08-19 09:26:26', '2026-08-20 02:31:39', NULL, 'ciawi'),
(24, 'REDDY SUWANTO', '3533', 'ciawi', 0, 0, NULL, '$2y$12$QfF4vLE.mfV8GboJ5rbJFOoV70rMu76eLOGVJwPp71njS4oyFbhAK', NULL, '2026-08-19 09:26:26', '2026-08-20 02:31:40', 'bm_sh', 'ciawi'),
(25, 'Januar Rahdiansyah', '37112', 'ciawi', 0, 0, NULL, '$2y$12$7WIYPNyiSUsdHWEpU4Z04OdbQoiAx5jKQwcKkqJQkHXW.GbgT31N.', NULL, '2026-08-19 09:26:26', '2026-08-20 02:31:44', NULL, 'ciawi'),
(26, 'DEDI RUSWANDI', '40284', 'cianjur', 0, 0, NULL, '$2y$12$6jYtXxib5YmSk8EJ0QMBcuki.NHae4X1LK1fLUeM6r6E3duaEzROO', NULL, '2026-08-19 09:26:27', '2026-08-20 02:31:57', NULL, 'cianjur'),
(27, 'Arik Samsudin', '40629', 'ciawi', 0, 0, NULL, '$2y$12$9xle/IPfCE3UCXJPP4dXved2BNmQiVrJ/lDqnUwVTvLVFcxrVdnKC', NULL, '2026-08-19 09:26:27', '2026-08-20 02:31:57', NULL, 'ciawi'),
(28, 'RONALD NOVEMBRI W', '41691', 'ciawi', 0, 0, NULL, '$2y$12$O/QAb8B0WoQXsC/irdY4zeegtQNZnnhY/4CKfKHzSGQ1j8ZbccSi2', NULL, '2026-08-19 09:26:27', '2026-08-20 02:32:02', 'bm_sh', 'ciawi'),
(29, 'Taufik Ali Akbar', '42298', 'cianjur', 0, 0, NULL, '$2y$12$X5V771/ckDgDvvvoX7NV7OlnpNOAdDy6GIH0Q0DThfZEqbek8nxnO', NULL, '2026-08-19 09:26:27', '2026-08-20 02:32:05', 'bm_sh', 'cianjur'),
(30, 'MUHAMMAD NAUFAL SHOFI', '43618', NULL, 0, 0, NULL, '$2y$12$NHg1EyUcqgcRSuCwHTXa..ptZtB9U.X3SK6bS/.OpOBLZB7ruwtmq', NULL, '2026-08-19 09:26:28', '2026-08-20 02:32:24', NULL, NULL),
(31, 'Mulyati', '46200', 'cinere', 0, 0, NULL, '$2y$12$UoGK4FQYPDHveqXJN/7h9O13oRKy54Zd7DS6wvQSml5kFdwbBT2cS', NULL, '2026-08-19 09:26:28', '2026-08-20 02:32:54', NULL, 'cinere'),
(32, 'Abdi Pribadi', '46280', 'jatiasih', 0, 0, NULL, '$2y$12$Iv7DiL5wBVW81tZ58llb8OyotDoMHaaJ0xZtbK9GJUiugFUumJTjW', NULL, '2026-08-19 09:26:28', '2026-08-20 02:33:06', NULL, 'jatiasih'),
(33, 'RANDI RUSANDI', '47888', 'cianjur', 0, 0, NULL, '$2y$12$Z8/NHn28/gUwqLk5UJscm.LwAesCasnRNlagz1Sh/jI5KiNjsH0eW', NULL, '2026-08-19 09:26:29', '2026-08-20 02:33:12', NULL, 'cianjur'),
(34, 'ANDRE PRASETYO WINOTO', '49746', 'cipanas', 0, 0, NULL, '$2y$12$/Dj/y6F9CkyBYsSw5.W.teM5XvEgyrI/PwA2Eucx.eKOOx9cWXRki', NULL, '2026-08-19 09:26:29', '2026-08-20 02:33:24', NULL, 'cipanas'),
(35, 'Rima mulyati', '50160', 'ciawi', 0, 0, NULL, '$2y$12$kH8Vq1hgOd2JoRX85fft7.ZJHUjmJbQS6I7HRkrmU/EBZ1h4.M7Q.', NULL, '2026-08-19 09:26:29', '2026-08-20 02:33:29', NULL, 'ciawi'),
(36, 'ASEP BUDIMAN', '51750', 'cinere', 0, 0, NULL, '$2y$12$d7C9QGIGLDFCaR1de7B4/.2xtSM94QeDcgdDHjxyE/6SWFY792LOm', NULL, '2026-08-19 09:26:30', '2026-08-20 02:33:35', NULL, 'cinere'),
(37, 'HENNARDY DERMAWAN', '52186', 'ciawi', 0, 0, NULL, '$2y$12$8CIR7eFUrXQZIshKlI1C4ecmPnIqRFNBUmM0eSLqJGoeuqJoMv80W', NULL, '2026-08-19 09:26:30', '2026-08-20 02:33:41', 'bm_sh', 'ciawi'),
(38, 'DIAN KHAERUN NISA', '54003', 'ciawi', 0, 0, NULL, '$2y$12$XO/GdoXesSIsehNpPxzMAelLsaz2td0vhfvIL8xD3drv.yAqvrjl2', NULL, '2026-08-19 09:26:30', '2026-08-20 02:33:54', NULL, 'ciawi'),
(39, 'ILMAN KAHFI', '55267', 'cinere', 0, 0, NULL, '$2y$12$5dDjpOGEH2/EnICUsZUDHetm.axCws9dAavMjCzuYxZRkII2a7DTa', NULL, '2026-08-19 09:26:31', '2026-08-20 02:34:02', 'bm_sh', 'cinere'),
(40, 'RYAN D SAPUTRA', '57440', 'ciawi', 0, 0, NULL, '$2y$12$ReTINqEIVvJFbqdGXuSCN.jDckfQX4JkbXIFJPjFMMSmJ0jNRZZDS', NULL, '2026-08-19 09:26:31', '2026-08-20 02:34:35', 'bm_sh', 'ciawi'),
(41, 'Irfan ardiansyah', '58080', 'cianjur', 0, 0, NULL, '$2y$12$1974HptKkP35VSXFKZJAz.VpOXQueQmAJdOaBQtPxDCOt2T4.VHH2', NULL, '2026-08-19 09:26:31', '2026-08-20 02:34:39', NULL, 'cianjur'),
(42, 'Agung Widya Subhiyanto', '59242', 'ciawi', 0, 0, NULL, '$2y$12$.c3/AjXNIXyBZTNqi4KyvetijnHBOegwyCGnzV../CRwzY5meedue', NULL, '2026-08-19 09:26:31', '2026-08-20 02:34:51', NULL, 'ciawi'),
(43, 'ARMAN MANIAR BAKTIESTA', '59689', 'cianjur', 0, 0, NULL, '$2y$12$uOKDGOMewR.SRZNCVrp/oOlXgmx0EP8CwK3yNX6EMFrgjZqc5sOea', NULL, '2026-08-19 09:26:32', '2026-08-20 02:35:13', NULL, 'cianjur'),
(44, 'MELI LEDIAWATI', '6138', 'cianjur', 0, 0, NULL, '$2y$12$Bq.bCi4s7nPPRJFl9uAl1u/L09sTEL7OH8V7i3YdmdAKGKEaAMpxO', NULL, '2026-08-19 09:26:32', '2026-08-20 02:35:34', NULL, 'cianjur'),
(45, 'Soan pradipta', '61590', 'jatiasih', 0, 0, NULL, '$2y$12$yLPtPv579B9nSo5aXyQAJuFHO3gkEZCi0znvmxc5XaSIlUjvxnEKu', NULL, '2026-08-19 09:26:32', '2026-08-20 02:35:34', 'bm_sh', 'jatiasih'),
(46, 'Sigit Budi Santoso', '62014', 'jatiasih', 0, 0, NULL, '$2y$12$OCo0B4oCFSqFtNLOZF0rie4Y.UhXx9/EfYUf689/rhfjjYpUtRgMm', NULL, '2026-08-19 09:26:32', '2026-08-20 02:35:39', NULL, 'jatiasih'),
(47, 'KRISNA ANGGARA', '63422', 'ciawi', 0, 0, NULL, '$2y$12$PPj124P76Ti1EwwvVhu3x.ItXDghJTb4PHa7htqLDOiPdS0DaUmve', NULL, '2026-08-19 09:26:33', '2026-08-20 02:36:06', NULL, 'ciawi'),
(48, 'Pran Yudi Setiawan', '64671', 'jatiasih', 0, 0, NULL, '$2y$12$F.HrnTxOFB4khqw3SpZsHeoIST5yrVhibIYlOYM5y4o9skW.vo.ua', NULL, '2026-08-19 09:26:33', '2026-08-20 02:36:43', 'bm_sh', 'jatiasih'),
(49, 'Andi Suhendi', '65005', 'ciawi', 0, 0, NULL, '$2y$12$UdaQcdEpuSq00DZva2jBFeODnn6dGzNy0Vb3AcOhhXutpiq2BmPAi', NULL, '2026-08-19 09:26:33', '2026-08-20 02:36:49', NULL, 'ciawi'),
(50, 'Gladys Caren Valentine Setiawati', '66570', 'cinere', 0, 0, NULL, '$2y$12$M6okii0GR7JNXKaYfhBBrucFEXWyVhoNt02ZdT//8IQZwI2PoUraK', NULL, '2026-08-19 09:26:34', '2026-08-20 02:37:19', NULL, 'cinere'),
(51, 'Rizki Munawar Salim', '66650', 'cianjur', 0, 0, NULL, '$2y$12$QqRn/Za/z0Tjn9wGcWDmt.FjqDGGUPxv9NSGJZPmQKnxXop26tJZ2', NULL, '2026-08-19 09:26:34', '2026-08-20 02:37:20', NULL, 'cianjur'),
(52, 'Mimin', '66789', 'ciawi', 0, 0, NULL, '$2y$12$7BQGUfiqfMoTIrtKHB30luHP46SKqGdlx3flF4O7u1dnH0tl4M7Wy', NULL, '2026-08-19 09:26:34', '2026-08-20 02:37:21', NULL, 'ciawi'),
(53, 'Subagja', '68138', 'cinere', 0, 0, NULL, '$2y$12$9icTJE4OdjwQuPEleqN.x.g8bs8cEDevXXIKmhbU9xx3CYvWM.TVS', NULL, '2026-08-19 09:26:34', '2026-08-20 02:37:36', 'bm_sh', 'cinere'),
(54, 'Teguh perwira negara', '68256', 'ciawi', 0, 0, NULL, '$2y$12$y2hhnnE4BEF3TsOvO2aSSObc5DSg6rAxVrEklpPAUjW.bETswYfXC', NULL, '2026-08-19 09:26:35', '2026-08-20 02:37:38', NULL, 'ciawi'),
(55, 'Mohammad Sopian Edi', '68291', 'cinere', 0, 0, NULL, '$2y$12$YuKGQRkPCJS8irgNl5QUs.mxF/wO4qyq3Q75teYNo5R.p42La4bVa', NULL, '2026-08-19 09:26:35', '2026-08-20 02:37:40', NULL, 'cinere'),
(56, 'M.Pahrul Azis', '68348', 'ciawi', 0, 0, NULL, '$2y$12$0PPi3CspPwR0zh6TjEgqpODcgxEpbZDQjhnM8HsBKImgfqExRw8GG', NULL, '2026-08-19 09:26:35', '2026-08-20 02:37:43', NULL, 'ciawi'),
(57, 'ANGGARINI AMITHAWARDHANI', '68614', 'cianjur', 0, 0, NULL, '$2y$12$443aZcA8S.Yck1uynpsC.e3uCTGgf4dGdZLu.qwcpu/0n2PyeNgP2', NULL, '2026-08-19 09:26:36', '2026-08-20 02:37:56', 'bm_sh', 'cianjur'),
(58, 'Hamdan', '69089', 'cianjur', 0, 0, NULL, '$2y$12$bYmPE2Kpyv2u8YNhIXLx6OCYqqYf9fms2QZ3GAoanf1yc5extyOwe', NULL, '2026-08-19 09:26:36', '2026-08-20 02:38:09', NULL, 'cianjur'),
(59, 'Fadya Juliana Suhendar', '69223', 'cianjur', 0, 0, NULL, '$2y$12$posrbPyAqkw1LT114opHtOgixsO9bHDJQAaZhcwypDzS2MLTM7OBm', NULL, '2026-08-19 09:26:36', '2026-08-20 02:38:16', NULL, 'cianjur'),
(60, 'WIDYA HERYANI', '69565', 'ciawi', 0, 0, NULL, '$2y$12$SEigKqn.1unlu98CgVuObOpOVsrrmM0t6kK8UEz87pHE74OjoJc5u', NULL, '2026-08-19 09:26:36', '2026-08-20 02:38:25', NULL, 'ciawi'),
(61, 'Laela alvi yani', '69762', 'cianjur', 0, 0, NULL, '$2y$12$mnT3SMj3YqPET2GiWwizYO5pMCLixlUx0uO3bwm6JRWyYFtRPKFlG', NULL, '2026-08-19 09:26:37', '2026-08-20 02:38:42', NULL, 'cianjur'),
(62, 'Siti Nur Asyiah Zamil', '70888', 'cianjur', 0, 0, NULL, '$2y$12$krRgi.7DqbUrmHRYEOxs2emvemhvRfsengfQ009xvxBfp4z1hTfri', NULL, '2026-08-19 09:26:37', '2026-08-20 02:38:55', NULL, 'cianjur'),
(63, 'Afni Yolanda', '71652', 'jatiasih', 0, 0, NULL, '$2y$12$eUAOQZ2dIUyWExtHQj3UHeCnXd8zolWjbXEE2I5pHGKk4O9kAG8/S', NULL, '2026-08-19 09:26:37', '2026-08-20 02:39:00', NULL, 'jatiasih'),
(64, 'WIJI AGUSTINI', '72481', 'ciawi', 0, 0, NULL, '$2y$12$3v/4MLR8lBlsO9t6ulPbqOxqLqLzSX/UT4SVHNCpL9XNV0jHZwBx6', NULL, '2026-08-19 09:26:38', '2026-08-20 02:39:05', NULL, 'ciawi'),
(65, 'Dewi Ratnawati', '72484', 'cianjur', 0, 0, NULL, '$2y$12$Y47p0oPCYyFfdCxRmP7Iwe6Hrk4qYcsXJYa7DGMQWYB8QCINwKpMa', NULL, '2026-08-19 09:26:38', '2026-08-20 02:39:06', NULL, 'cianjur'),
(66, 'MISWAN SYARIFUDIN, S.Sos', '72658', 'cianjur', 0, 0, NULL, '$2y$12$AuIBh2090dFRIwhKBCj82esc/Kb43cgliYehpNTPAu1OBa5XmoE/m', NULL, '2026-08-19 09:26:38', '2026-08-20 02:39:07', NULL, 'cianjur'),
(67, 'RATIH PUSPASARI', '72795', 'cinere', 0, 0, NULL, '$2y$12$w4hh7MFbHRr/RrNYlntk7uOUyL8yXt/ODSEVZ9XpsJQevnRxu1xwC', NULL, '2026-08-19 09:26:38', '2026-08-20 02:39:10', NULL, 'cinere'),
(68, 'SYAHRUL RAMADHAN', '72844', 'jatiasih', 0, 0, NULL, '$2y$12$Doq5Y1SJdMtfP3tqTJoaluc0nN5cq0GCmIhbLhKSJh9wiK5s/cAzC', NULL, '2026-08-19 09:26:39', '2026-08-20 02:39:12', NULL, 'jatiasih'),
(69, 'AHMAD INDRA RAHAYU', '72905', 'ciawi', 0, 0, NULL, '$2y$12$b9vZ1Fdq/aE.Ct1Y6Nw6v.Ncx/HhwNVITcMeoV4vPKuz1/HSoiVbG', NULL, '2026-08-19 09:26:39', '2026-08-20 02:39:13', NULL, 'ciawi'),
(70, 'A.Baedowi', '73206', 'ciawi', 0, 0, NULL, '$2y$12$6MZXi6f3xy0aRI3YaSgGbe4fAL/oq1v0oU7baeRqNHJknRtOOGZrO', NULL, '2026-08-19 09:26:39', '2026-08-20 02:39:15', NULL, 'ciawi'),
(71, 'Husen', '73359', 'cianjur', 0, 0, NULL, '$2y$12$b.rOmRsCynZ1ZYvO.zjS0OnVj0vh.MFiUlG2fR4aL.O0QzepEZDo2', NULL, '2026-08-19 09:26:40', '2026-08-20 02:39:18', NULL, 'cianjur'),
(72, 'NENI MEIYONA', '73834', 'jatiasih', 0, 0, NULL, '$2y$12$5sY.uqAd3FOXZ7YxUQYWPeVWPHEztRy46MEcNv0o/.VXg.pNlv4JK', NULL, '2026-08-19 09:26:40', '2026-08-20 02:39:22', NULL, 'jatiasih'),
(73, 'Haikal Reksa', '74059', 'ciawi', 0, 0, NULL, '$2y$12$cLEKc.DbnMnuuIesMFvRouOkxnSAk/kO8REtVQ1Cjgcpa2mB3rh7a', NULL, '2026-08-19 09:26:40', '2026-08-20 02:39:24', NULL, 'ciawi'),
(74, 'Abdul Majid', '74449', 'cianjur', 0, 0, NULL, '$2y$12$OQMr0Md9qfdqEktRKu424uJ/Kr15fi1rV86DNJlxB6UVvzo4tqBii', NULL, '2026-08-19 09:26:40', '2026-08-20 02:39:26', NULL, 'cianjur'),
(75, 'HELFIANA', '74802', 'cipanas', 0, 0, NULL, '$2y$12$OX4unTRx8Oe4vCBSFLXEKOyu1QZzwAq4mAEE9CZBoxgmY5wAiSjo6', NULL, '2026-08-19 09:26:41', '2026-08-20 02:39:28', NULL, 'cipanas'),
(76, 'KHILDA', '74810', 'cinere', 0, 0, NULL, '$2y$12$LLCB5f8Ngs8Vz9WIDkFXUuxj2.xN90QJjISXmjw31hFk5Gf2lKqDO', NULL, '2026-08-19 09:26:41', '2026-08-20 02:39:31', NULL, 'cinere'),
(77, 'DEA SAFITRI', '74829', 'jatiasih', 0, 0, NULL, '$2y$12$5BG2ed1gcFK077W8B1sWc.plt5X.k6Lke7e/Ygi989On2RuihGvY6', NULL, '2026-08-19 09:26:41', '2026-08-20 02:36:02', NULL, 'jatiasih'),
(78, 'M RIDFIAN SYAHPUTRA', '75137', 'ciawi', 0, 0, NULL, '$2y$12$uxFZHUCTx.3kmBwJHdy5buEYsCNK1gWbY8Rp47pxmH/b523PzV7Xi', NULL, '2026-08-19 09:26:42', '2026-08-20 02:36:06', NULL, 'ciawi'),
(79, 'Saskia Irdina Ristianti', '75143', 'jatiasih', 0, 0, NULL, '$2y$12$rO5dZ9DsGIwXQp1ygoumFOR6lp7HfZCIBAIJp.jRE0KQ4Tacpnmqq', NULL, '2026-08-19 09:26:42', '2026-08-20 02:36:07', NULL, 'jatiasih'),
(80, 'Mayani', '75639', 'cinere', 0, 0, NULL, '$2y$12$pk5lYpGcmJ0BY9aA1PWINepmWhqszly7u.lMcGBpyvhJ9430u3Xiu', NULL, '2026-08-19 09:26:42', '2026-08-20 02:36:11', NULL, 'cinere'),
(81, 'Adrian Mahendra J', '76090', 'jatiasih', 0, 0, NULL, '$2y$12$B2V.nFBQimYzBrrPDNtWMOoOeugtiNSUE16wRIftp6Cnq8X0rK2p6', NULL, '2026-08-19 09:26:43', '2026-08-20 02:36:29', NULL, 'jatiasih'),
(82, 'JOHN EDUWARD SIMATUPANG', '76134', 'jatiasih', 0, 0, NULL, '$2y$12$pZxL2PUDYeXBuiwVuQ6DeedRVkONgWmVtBUjIfzQ0MFCGfwwHMDei', NULL, '2026-08-19 09:26:43', '2026-08-20 02:36:30', 'bm_sh', 'jatiasih'),
(83, 'Febrian Naufal Adli', '76339', 'jatiasih', 0, 0, NULL, '$2y$12$ALCRBxv9YqsRF0VPCX7lEew6XO4YBLdnmbebB9oBqentLA9MtQUTq', NULL, '2026-08-19 09:26:43', '2026-08-20 02:36:31', NULL, 'jatiasih'),
(84, 'SELLY LISNAWATI', '76374', 'cianjur', 0, 0, NULL, '$2y$12$kIZoYXwk3AquHNALinRigehPYZBkzQKDy11Q7jp2nm6Nb4lHDZ/IW', NULL, '2026-08-19 09:26:43', '2026-08-20 02:36:32', NULL, 'cianjur'),
(85, 'HELMI NAULANA', '76375', 'cianjur', 0, 0, NULL, '$2y$12$g8SAu/OFZF1PI1PyoYoUgu7GIcQksk49ADf4TML4voXKOavesJ/2G', NULL, '2026-08-19 09:26:44', '2026-08-20 02:36:32', NULL, 'cianjur'),
(86, 'Sevilla Fidelya Rahman', '76457', 'cinere', 0, 0, NULL, '$2y$12$Up/HrUC4GX7tju1Qsg.YVe3wDF0JXPyPSRcNHJMeuMoI8ui8Hd4xW', NULL, '2026-08-19 09:26:44', '2026-08-20 02:36:33', NULL, 'cinere'),
(87, 'Adis Afendi', '76633', 'jatiasih', 0, 0, NULL, '$2y$12$rw20pdsWBP3IrWLMbQFh9.5EFx.ybvDKYKqATocCIpMKAZXeoGFSe', NULL, '2026-08-19 09:26:44', '2026-08-20 02:36:34', NULL, 'jatiasih'),
(88, 'ALFIN GHIFARI HALDI', '76634', 'cipanas', 0, 0, NULL, '$2y$12$JCiPL5KWwnV5ToBGIfDXterKEthSGu320635YAOrur6RYMInkhrGC', NULL, '2026-08-19 09:26:44', '2026-08-20 02:36:36', NULL, 'cipanas'),
(89, 'I Gusti Made Uki adiyana', '77051', 'jatiasih', 0, 0, NULL, '$2y$12$9khKkPaz3A.hDBh0w.Suq.5X9kjRHsO9guV3JpWc2kach4a2RBiua', NULL, '2026-08-19 09:26:45', '2026-08-20 02:36:40', 'bm_sh', 'jatiasih'),
(90, 'Nurtina Pasaribu,A,Md,Kom', '77055', 'jatiasih', 0, 0, NULL, '$2y$12$YnTEXqwdj758SgENrs3QzupT2y1gWOt69hZg619xzq2so7QmU8AAO', NULL, '2026-08-19 09:26:45', '2026-08-20 02:36:41', NULL, 'jatiasih'),
(91, 'Siti Sarah', '77056', 'jatiasih', 0, 0, NULL, '$2y$12$epFIp9X..UJ37vLbrEmx9.zkaiSFp2Sj6ez4tRNtNhhtpkxV9Yntu', NULL, '2026-08-19 09:26:45', '2026-08-20 02:36:41', NULL, 'jatiasih'),
(92, 'Amanda Chantique', '77105', 'jatiasih', 0, 0, NULL, '$2y$12$Q8XXXCWBcB2exwr8tUIKRelHGFoDi3bjxOm8a1izlQo6d7KuVs7Ym', NULL, '2026-08-19 09:26:46', '2026-08-20 02:36:41', NULL, 'jatiasih'),
(93, 'KAYLA YASA', '77412', 'cinere', 0, 0, NULL, '$2y$12$j5Zcelu0TSwN4jhKxo0Np.zJrpju2jnEkNaK4LMQipV803injUlJe', NULL, '2026-08-19 09:26:46', '2026-08-20 02:36:42', NULL, 'cinere'),
(94, 'BERY TRI AUGUSTA', '77413', 'ciawi', 0, 0, NULL, '$2y$12$HCMSgNd.w.rlN7qVrawjoeHlonKm5l2mO9uJLdBXZVm2qQOcupSMG', NULL, '2026-08-19 09:26:46', '2026-08-20 02:36:42', NULL, 'ciawi'),
(95, 'BAGUS PUSPA KUSUMA', '77415', 'ciawi', 0, 0, NULL, '$2y$12$va9mCTlF6ug2hcSiIOngOe0zOyCuwDj7eX7IgegQptBdicvJs1Fj.', NULL, '2026-08-19 09:26:47', '2026-08-20 02:36:43', NULL, 'ciawi'),
(96, 'Nurcahyo Listyanto', '77417', 'jatiasih', 0, 0, NULL, '$2y$12$JU.IAGnRc4dBzHqXU72El.nSJt5OwoMKgihLSb2zmzCm.LngCBH2y', NULL, '2026-08-19 09:26:47', '2026-08-20 02:36:44', NULL, 'jatiasih'),
(97, 'FAHMI S NUGRAHA', '77419', 'cipanas', 0, 0, NULL, '$2y$12$gemeBGWkqRXE1Ct3HEj72.khgdTze/LkhvvLxZfUCic6GRXfRXakS', NULL, '2026-08-19 09:26:47', '2026-08-20 02:36:44', NULL, 'cipanas'),
(98, 'SULTAN SOLAHUDIN', '77424', 'ciawi', 0, 0, NULL, '$2y$12$VvUSu0tBco2.areVX//ah.FGMTC2w5eFY6VtGRvnl7M8nCaBFWUf2', NULL, '2026-08-19 09:26:47', '2026-08-20 02:36:45', NULL, 'ciawi'),
(99, 'TITIEN KURNIA SARI', '77745', 'jatiasih', 0, 0, NULL, '$2y$12$bl9ibBxuEtevDfaDudYJMebN2p2E/vqENMtjg12Doaffnj6cW29L6', NULL, '2026-08-19 09:26:48', '2026-08-20 02:36:46', NULL, 'jatiasih'),
(100, 'M JANUAR R LUBIS', '77746', 'ciawi', 0, 0, NULL, '$2y$12$279Z9RPig7XRu.djjYrMUuAxQK57gBWqOBzL4kZb0ZMteqJPJekNi', NULL, '2026-08-19 09:26:48', '2026-08-20 02:36:46', NULL, 'ciawi'),
(101, 'DEVIA CHOERUNNISA', '77747', 'jatiasih', 0, 0, NULL, '$2y$12$m9JTeJ4B60nY3ClDUDpfHumHLrCEEAENZjwqrrpWEPPohacLTOIli', NULL, '2026-08-19 09:26:48', '2026-08-20 02:36:47', NULL, 'jatiasih'),
(102, 'JAROT HADIARTO', '77748', 'jatiasih', 0, 0, NULL, '$2y$12$zfDhKyGN3E/qI0/51Y6ZreT8SGm/UITLF.c41dxdb8cZ4yPE5Z1Ma', NULL, '2026-08-19 09:26:49', '2026-08-20 02:36:47', NULL, 'jatiasih'),
(103, 'Gatot', '77760', 'jatiasih', 0, 0, NULL, '$2y$12$Rh7HSuIPRZBjNzu/GM321ei8s1iO0NGZVtSkhrHDeHxRfoTb.IkLq', NULL, '2026-08-19 09:26:49', '2026-08-20 02:36:48', 'bm_sh', 'jatiasih'),
(104, 'Friderick Bochman Tobing', '77761', 'jatiasih', 0, 0, NULL, '$2y$12$bNWt7OafEDmnD1wvtpj1LefR9W01Yt.DUxON0IuMnwvGmyljfFjfm', NULL, '2026-08-19 09:26:49', '2026-08-20 02:36:48', NULL, 'jatiasih'),
(105, 'Fadli Apriyadin', '77762', 'jatiasih', 0, 0, NULL, '$2y$12$uZkLhzLRnfzULcy8q6xHee5dZdxGARao2wVjfxLLBcuQKv8sPcfpC', NULL, '2026-08-19 09:26:49', '2026-08-20 02:36:49', NULL, 'jatiasih'),
(106, 'Susilowati', '77763', 'jatiasih', 0, 0, NULL, '$2y$12$A6PK1LEr1wy0CEm5FiG1m.0TBA3xurB4h1wU2uh.l8ZWO8.cW/EvC', NULL, '2026-08-19 09:26:50', '2026-08-20 02:36:49', NULL, 'jatiasih'),
(107, 'C. Aero Susetyo Adi', '77764', 'jatiasih', 0, 0, NULL, '$2y$12$tS2wDc84jYMT1X00Ye50lurhkv4gz5pQIJgIBdiNhDHUD4erLWiVS', NULL, '2026-08-19 09:26:50', '2026-08-20 02:36:49', NULL, 'jatiasih'),
(108, 'Muhamad safta satria nugraha', '77897', 'cianjur', 0, 0, NULL, '$2y$12$5vRtQj6ZIN0SaHL1SQIotuwgKuaMV7wBLrLy6619d9GdPVM.vK4PO', NULL, '2026-08-19 09:26:50', '2026-08-20 02:36:50', NULL, 'cianjur'),
(109, 'Sanda Melisa', '77898', 'jatiasih', 0, 0, NULL, '$2y$12$nn5tsnrRR89zKUgeeg/3Xu7cFkThJ6cYVC95hgi8vVDcOQYUfjRci', NULL, '2026-08-19 09:26:51', '2026-08-20 02:36:50', NULL, 'jatiasih'),
(110, 'Irfan Ar Razzaq', '77899', 'jatiasih', 0, 0, NULL, '$2y$12$6/PrhOUeYcypj24ONIPGZ.QBMCinOelmoKs9Y8vDhQnej0sFiN28y', NULL, '2026-08-19 09:26:51', '2026-08-20 02:36:51', NULL, 'jatiasih'),
(111, 'Andrian Alfi Rahman', '77901', 'cianjur', 0, 0, NULL, '$2y$12$KH8P1i2tl9C0Fw0WIvA7POQFIgto9FzbdTzwzbapBhu5gMz21FxuK', NULL, '2026-08-19 09:26:51', '2026-08-20 02:36:51', NULL, 'cianjur'),
(112, 'Mohamad Ade Saepudin', '77903', 'cianjur', 0, 0, NULL, '$2y$12$CueKr6quhOqqQhRIJgnomu5/KG8QVbFFGbVbPQA0BiaSRDIHyJ6pq', NULL, '2026-08-19 09:26:51', '2026-08-20 02:36:52', NULL, 'cianjur'),
(113, 'Firman Nugraha', '77904', 'cianjur', 0, 0, NULL, '$2y$12$ibaXAk/NuybKVA.d3f2tD.FQNZECqMWjPvL4l04o/7jRwjeBjrsvW', NULL, '2026-08-19 09:26:52', '2026-08-20 02:36:52', NULL, 'cianjur'),
(114, 'Abdullah', '77981', 'cinere', 0, 0, NULL, '$2y$12$7opZ0iQ5GY2BEWp8Xmc.8.l9n4kZg3.0ryqf4OUuPZeN/DXHZo99e', NULL, '2026-08-19 09:26:52', '2026-08-20 02:36:52', NULL, 'cinere'),
(115, 'Sita Agus Salamah', '77982', 'jatiasih', 0, 0, NULL, '$2y$12$BZr5Njjb2Ud26zPaGaqNf.xVkhO7HdZDlSzlmwr5Fk8kcDEt/P2gm', NULL, '2026-08-19 09:26:52', '2026-08-20 02:36:53', NULL, 'jatiasih'),
(116, 'Adi Adrian SE', '78118', 'cinere', 0, 0, NULL, '$2y$12$zVgtv/1ZKmfVhBJkhG1sMuBVQ3gXZCuLtdYvqAsCGgYd7oQpx7uHW', NULL, '2026-08-19 09:26:52', '2026-08-20 02:36:53', 'bm_sh', 'cinere'),
(117, 'Haekal Baikhati Natsir', '78119', 'cinere', 0, 0, NULL, '$2y$12$luplRGAdqypiY7YvrlJzHOm8SSMtslkAm8U6gfse7mtvBquqZXCqy', NULL, '2026-08-19 09:26:53', '2026-08-20 02:36:53', NULL, 'cinere'),
(118, 'Feri iswandie', '78120', 'cinere', 0, 0, NULL, '$2y$12$5XvYoFRccbUQuUkEGyb7/.6a4GT7aphkh1a73fbC.T4tnDCIlm0Su', NULL, '2026-08-19 09:26:53', '2026-08-20 02:36:54', NULL, 'cinere'),
(119, 'Rina Anggraini', '78125', 'cinere', 0, 0, NULL, '$2y$12$2ODRV1A0D/MzQ6BJ6/s9VeyWon.vTO7uC3ey9Ge66yJGCfyfTk8cm', NULL, '2026-08-19 09:26:53', '2026-08-20 02:36:54', NULL, 'cinere'),
(120, 'REZA MUCHAMAD AKBAR', '78126', 'ciawi', 0, 0, NULL, '$2y$12$tUTODlmR/hsmNKMngWpxdeH3mZo1Ik7VdwgyQoRVTcdnuICkd.xi6', NULL, '2026-08-19 09:26:54', '2026-08-20 02:36:55', NULL, 'ciawi'),
(121, 'I GD ARIF FRIYANTO', '78127', 'cipanas', 0, 0, NULL, '$2y$12$z7jIEeLF/82d.O6ooGw6Q.yP3evWU5cgA982ouCF.pg2z5GxwNtQ6', NULL, '2026-08-19 09:26:54', '2026-08-20 02:36:55', NULL, 'cipanas'),
(122, 'ASEP SUHAEMI', '78128', 'cipanas', 0, 0, NULL, '$2y$12$P4ubVMNODFvTwc/QnsvK.eb/y.KNdtKmYrbkbinAQEE9U7HRAzFD6', NULL, '2026-08-19 09:26:54', '2026-08-20 02:36:55', NULL, 'cipanas'),
(123, 'DICKY WAHYUDI', '78133', 'cipanas', 0, 0, NULL, '$2y$12$ENpr8x/1O7t6M/QSo8aBLecmhc02g9aNIoO8CymTr2m6xZhpEF1ie', NULL, '2026-08-19 09:26:54', '2026-08-20 02:36:56', NULL, 'cipanas'),
(124, 'Suganda Chandra', 'chandra', 'bp', 0, 0, NULL, '$2y$12$m0ET9HUcR2cmHlm7UPfv7.NGh/uf17lC.WeA0lyYN7ckVWfduGimu', NULL, '2026-08-19 09:26:55', '2026-08-20 02:36:59', NULL, 'bp'),
(125, 'BUDI TANUJAYA', 'cjr-adh', 'cianjur', 0, 0, NULL, '$2y$12$yI.DcTAawzb4zPoCXTjh6eCdoF19yyS1EvRV9zs6QZpjmr5jpgSVG', NULL, '2026-08-19 09:26:55', '2026-08-19 09:26:55', 'adh', 'cianjur'),
(126, 'ACHMAD ILYAS', 'dcabksadh', 'jatiasih', 0, 0, NULL, '$2y$12$wH.Nn2O2TK6rhPDK6KIcHOxvKdOyli3JGgEX1ZWodp9t3Jd9kGk3G', NULL, '2026-08-19 09:26:55', '2026-08-20 02:37:03', 'adh', 'jatiasih'),
(127, 'REGI FATHUROHMAN', 'dcabkssa1bp', 'bp', 0, 0, NULL, '$2y$12$GrR4IJX3pvXvck2TR0pz8ei6KYaGPQWjQZlM2A0lDci3RXk5VFhOO', NULL, '2026-08-19 09:26:55', '2026-08-19 09:26:55', NULL, 'bp'),
(128, 'KHAERUL DENIS BRIANTO', 'dcabkssa2', 'jatiasih', 0, 0, NULL, '$2y$12$G9nZrh.c/OWgQjie/ulaMeXPWYRQ/j5PLhsjrJiB95yM1sPq9avty', NULL, '2026-08-19 09:26:56', '2026-08-20 02:37:07', NULL, 'jatiasih'),
(129, 'HARVIT', 'dcabkssa2bp', 'bp', 0, 0, NULL, '$2y$12$CDk/gxaHf2R3UqS0T1KP6eKKgFMP9lY3gIv.xuvMLXCJW4hpDtF9K', NULL, '2026-08-19 09:26:56', '2026-08-20 02:37:07', NULL, 'bp'),
(130, 'SUWARDI JANDELA', 'dcabkssprt', 'jatiasih', 0, 0, NULL, '$2y$12$bSWiE3k3fNw2sKptpPOWDumXEAcIQDjBdTv0JPmClH/N7ADbNdoc6', NULL, '2026-08-19 09:26:56', '2026-08-20 02:37:11', NULL, 'jatiasih'),
(131, 'RANI SULISTIANI', 'dcabkssro', 'jatiasih', 0, 0, NULL, '$2y$12$wropC4ikk.R2bOumhbjIhOIpY3utF2x3uB.eqd49Awq2QGFsvoJMK', NULL, '2026-08-19 09:26:57', '2026-08-20 02:37:11', NULL, 'jatiasih'),
(132, 'EUIS ASIAH', 'dcacjradmunit', 'cianjur', 0, 0, NULL, '$2y$12$344GiPAk0mjmjec3ny4w8e4aIyKh3VpUEbGCcmnQ4yMO3ty8rvNmO', NULL, '2026-08-19 09:26:57', '2026-08-20 02:37:14', NULL, 'cianjur'),
(133, 'Agustina Wulandari', 'dcacjrsadm', 'cianjur', 0, 0, NULL, '$2y$12$gBdDIr9uF1QZj/RtRNcazOczZviGQ9cQv3nUC5hnBUO/PnR94.8TK', NULL, '2026-08-19 09:26:57', '2026-08-20 02:37:17', NULL, 'cianjur'),
(134, 'GANDA MULYADI', 'dcacjrsm', 'cianjur', 0, 0, NULL, '$2y$12$YeaBOvA8QB7LGn27LdxXre0VbFxYRMcRWnBFpchduXGz5vfX9yln.', NULL, '2026-08-19 09:26:57', '2026-08-20 02:37:18', NULL, 'cianjur'),
(135, 'Erin Apriliani', 'dcacjrsro', 'cianjur', 0, 0, NULL, '$2y$12$7VQSiwLepiepMC/8YWu41u5NWEWaUiNq5om.6VbmaTxPVkiuF7S66', NULL, '2026-08-19 09:26:58', '2026-08-20 02:37:19', NULL, 'cianjur'),
(136, 'TANAYA CAHAYA PANDINI', 'dcacjrsro2', 'cianjur', 0, 0, NULL, '$2y$12$ifWyp1kfslPDScVufs8IM.xGRAHffSJf0LC.WyL2BtriDnvNkFBkS', NULL, '2026-08-19 09:26:58', '2026-08-20 02:37:19', NULL, 'cianjur'),
(137, 'GUGUN', 'dcacnradh', 'cinere', 0, 0, NULL, '$2y$12$JJOAQaPKBPL6H.VpScjw4erf5v7FybTP/4Pq88QyqbIgMSA/1dEKO', NULL, '2026-08-19 09:26:58', '2026-08-20 02:37:20', 'adh', 'cinere'),
(138, 'SRI NOPIA LESTARI', 'dcacnrsadm', 'cinere', 0, 0, NULL, '$2y$12$uqDPpY.qJce.T0mP2qDkze94PH1OF2I.4m090hkzWjiEJgt0dhyVa', NULL, '2026-08-19 09:26:59', '2026-08-20 02:37:25', NULL, 'cinere'),
(139, 'Kusdiyantoro ST', 'dcacnrsm', 'cinere', 0, 0, NULL, '$2y$12$l8B4CbiNFd4yTuNBckmruO1ZF7GP..8topCwVeLs7NGvUmGDSBc7y', NULL, '2026-08-19 09:26:59', '2026-08-19 14:22:23', NULL, 'cinere'),
(140, 'LIONITA PERMATA PUTRI', 'dcacnrsro', 'cinere', 0, 0, NULL, '$2y$12$le583sWS4UvKvQc.gvTuTOl7LoMSjWv65vzKwCkbLdsW7MLA.0Az2', NULL, '2026-08-19 09:26:59', '2026-08-19 14:22:24', NULL, 'cinere'),
(141, 'EDI SUMARDI X', 'dcacpsshbm', 'cipanas', 0, 0, NULL, '$2y$12$A0SA8Xdan2pBIxlO4wozDOJovtJ1PnNhShLLTpuFXQmrTEtoKBnue', NULL, '2026-08-19 09:27:00', '2026-08-19 14:22:25', 'bm_sh', 'cipanas'),
(142, 'Ooy Ogiawati', 'dcacwiadmunit', 'ciawi', 0, 0, NULL, '$2y$12$zOwDJEAQ4rD.80RMDk2x3Of4LpYukwcO3Hu8alW17YkX5cTkOHXCe', NULL, '2026-08-19 09:27:00', '2026-08-19 14:22:26', NULL, 'ciawi'),
(143, 'FOREMAN', 'dcacwifm', 'ciawi', 0, 0, NULL, '$2y$12$vKrhny6Q8Xn4x45eV9EhEeWuP0a587f8VRuwOnPjWp.HIpRurFn5.', NULL, '2026-08-19 09:27:00', '2026-08-19 14:22:26', NULL, 'ciawi'),
(144, 'Nana Sopiana', 'dcacwisa4', 'ciawi', 0, 0, NULL, '$2y$12$DK71vWLXzfr2qQKfPgIIm.jJVF1KQzFbF5f13gU5xHzprNM3Yedp2', NULL, '2026-08-19 09:27:01', '2026-08-19 14:22:28', NULL, 'ciawi'),
(145, 'PEPEN SUPENDI', 'dcacwisadm', 'ciawi', 0, 0, NULL, '$2y$12$Y0mh7H9KMEdv4eCHswpAl.TWw2V.g77WrjFGSKEzjApza1EwhR/kC', NULL, '2026-08-19 09:27:01', '2026-08-19 14:22:28', NULL, 'ciawi'),
(146, 'HERI SETIAWAN', 'dcacwism', 'ciawi', 0, 0, NULL, '$2y$12$iP6fKJWkV0tLceiKpqUIuuW9XxPdrkvI3rYmH1NzEcleyAf/Ltt0y', NULL, '2026-08-19 09:27:01', '2026-08-19 14:22:29', NULL, 'ciawi'),
(147, 'Meta Kartika', 'dcacwisro', 'ciawi', 0, 0, NULL, '$2y$12$jjt6KNtaE87DxgjWxaATleyVeDrvwcziqHyzM5bSOvuDzH4dp4V4S', NULL, '2026-08-19 09:27:02', '2026-08-19 14:22:31', NULL, 'ciawi'),
(148, 'ASTI MAYASARI', 'dcacwisro1', 'ciawi', 0, 0, NULL, '$2y$12$o3teFO/40qpCrN/hu8ad.ev5mwcVGeYQRdYgy9dELcZJtMVghybUG', NULL, '2026-08-19 09:27:02', '2026-08-19 14:22:31', NULL, 'ciawi'),
(149, 'Paulus Prihartono', 'dcagmpp', 'cinere', 1, 1, NULL, '$2y$12$fZxBLNDAiEKRJlTAVbyRSOKvwAkA09CDrQbuDpmy0fcwbf7f5ZBB6', NULL, '2026-08-19 09:27:02', '2026-08-19 14:22:32', 'om', 'cinere'),
(150, 'LIANA RESPATI', 'dcahoacctspv', 'ciawi', 0, 0, NULL, '$2y$12$DNJ5HBxoddZBBJ/RAowEnukOPWol5j3EYVK8hhhGWwzfro5VpRo9C', NULL, '2026-08-19 09:27:02', '2026-08-19 14:22:33', NULL, 'ciawi'),
(151, 'Meisa Almas', 'meisa', 'ciawi', 0, 0, NULL, '$2y$12$meH7ycIFU2Ntkp7AtcaDk.gsihWw69TBLQ1oIyrmcKrbLXt.whn5.', NULL, '2026-08-19 09:27:03', '2026-08-19 14:22:44', NULL, 'ciawi'),
(152, 'VINCENT WILLIAM', 'vincent', 'ciawi', 0, 0, NULL, '$2y$12$xsOGrSBx/6oK6upUpP/ytOObEmdm88xds1Oys1GXxV1e1uiJwQ06m', NULL, '2026-08-19 09:27:03', '2026-08-19 14:22:48', NULL, 'ciawi'),
(153, 'Elga', '001604002', NULL, 0, 0, NULL, '$2y$12$vDVaDqseS.Nb/VlvnS/M/uycR8XO9iff7qXsxBf0EXtGPQSX5s0VK', NULL, '2026-08-19 14:13:36', '2026-08-20 02:31:17', NULL, NULL),
(154, 'HERMAWAN', '12984', 'cianjur', 0, 0, NULL, '$2y$12$M5FJUnAS7VhHn76Gn5Q8F.C.lXMLD0kPIattgx5Qf7wcChKm0Nmki', NULL, '2026-08-19 14:13:37', '2026-08-20 02:31:17', NULL, 'cianjur'),
(155, 'Novandre Budi Sulistya', '13472', 'jatiasih', 0, 0, NULL, '$2y$12$pnpWCT.EybqANGyjP3kX2OHPpABW4wgY41BdCFkCN8.hRSAAPckBe', NULL, '2026-08-19 14:13:37', '2026-08-20 02:31:18', NULL, 'jatiasih'),
(156, 'RUBBY SAPUTRA', '15253', 'cianjur', 0, 0, NULL, '$2y$12$4MI.8URXELNDVVYimrX4ke/akJ7/grJjaAGOyo/F8TxUY5IC7mbWu', NULL, '2026-08-19 14:13:38', '2026-08-20 02:31:18', 'bm_sh', 'cianjur'),
(157, 'RUBBY SAPUTRA', '15253x', 'cianjur', 0, 0, NULL, '$2y$12$PVC9uOFEqUdpRMcp4N6a6eOFMJ3p37IGfjvcV6Ap3ifUBEwpJybGu', NULL, '2026-08-19 14:13:38', '2026-08-20 02:31:19', 'bm_sh', 'cianjur'),
(158, 'YAYAN RIBUDIANTO', '16430', 'cianjur', 0, 0, NULL, '$2y$12$hPiAcW8N9npe1932R.Q5XO6Cx77xyY41UzLc8Nsq84SO..ilIOlJG', NULL, '2026-08-19 14:13:39', '2026-08-20 02:31:19', NULL, 'cianjur'),
(159, 'MUTIARA SOBARIAH', '16462', 'cianjur', 0, 0, NULL, '$2y$12$FzHCdgDcxuAHYutwsAcdjOc3fOUN4Ip0zpQDXRFlN4Xv/TWNSbmnK', NULL, '2026-08-19 14:13:39', '2026-08-20 02:31:20', NULL, 'cianjur'),
(160, 'DEDI SOBANDI', '16480', 'cianjur', 0, 0, NULL, '$2y$12$Wdq6ukTFvkcPb5zfrC5FJOGzPJSCPyXxfXGAzaqjg2sCXiOTZvz2q', NULL, '2026-08-19 14:13:40', '2026-08-20 02:31:21', NULL, 'cianjur'),
(161, 'RUSLAN EFFENDI', '16509', 'ciawi', 0, 0, NULL, '$2y$12$Xb896A83N6aSOY/9kQcQwumAbDAOQu/2p0FgYJVyN9Rude3Y8niRy', NULL, '2026-08-19 14:13:40', '2026-08-20 02:31:21', NULL, 'ciawi'),
(162, 'DADANG SUGIARWAN', '16519', 'cianjur', 0, 0, NULL, '$2y$12$4Sre3BLxTqqBipQbu4PwEumHPzxjXIiwV.o9h3l5k9.P.lBMNnaEW', NULL, '2026-08-19 14:13:41', '2026-08-20 02:31:22', NULL, 'cianjur'),
(163, 'YULIUS SUPARDI', '16520', 'cianjur', 0, 0, NULL, '$2y$12$P3xJGcqyUvz2EKgLZmd1JOWxIgglK4xT0O5CKhUunI.Pb/vm5/vSi', NULL, '2026-08-19 14:13:41', '2026-08-20 02:31:22', 'bm_sh', 'cianjur'),
(164, 'PUSPITA ANGGRAINI', '18084', 'jatiasih', 0, 0, NULL, '$2y$12$eV9Hphcj6QDfuzmK3oBqFu.hULuzekyvNX7oPzR733HDLXFxFEZXa', NULL, '2026-08-19 14:13:41', '2026-08-20 02:31:22', NULL, 'jatiasih'),
(165, 'Susan Meirina', '18447', 'jatiasih', 0, 0, NULL, '$2y$12$xHiauOX67LfwijMWE/aL8.1mdIeE.Kfgp2vD6D6b21H1ie644oiQ2', NULL, '2026-08-19 14:13:41', '2026-08-20 02:31:23', NULL, 'jatiasih'),
(166, 'Yenni Efrianti', '19625', 'cinere', 0, 0, NULL, '$2y$12$ydGTpQnGalC0mqPtVb96GOtwC3LXcj5DZnRJXF1QC/e3I.aTDakfq', NULL, '2026-08-19 14:13:42', '2026-08-20 02:31:23', NULL, 'cinere'),
(167, 'ADE KURNIA ALAM PUTRA', '20281', 'cinere', 0, 0, NULL, '$2y$12$WB4nsQH3jzaOEyhlXBxPFuoP9P8Q8aRF4QhJr4MJwsdH3QhUkodKW', NULL, '2026-08-19 14:13:42', '2026-08-20 02:31:24', NULL, 'cinere'),
(168, 'Hapsari Retno Wulandari', '20677', 'jatiasih', 0, 0, NULL, '$2y$12$hxHiuDzFSQjuY/HS9Hh7xerx7xGICsbUydlAgLox4BIU8SCrF5t/i', NULL, '2026-08-19 14:13:42', '2026-08-20 02:31:24', NULL, 'jatiasih'),
(169, 'MOHAMAD DAMANHURI', '20743', 'ciawi', 0, 0, NULL, '$2y$12$hV53PGwkglm85Dg/6tuYq.68nk8KNI.CdvlwIB3n6HJgece/INRT2', NULL, '2026-08-19 14:13:43', '2026-08-20 02:31:25', NULL, 'ciawi'),
(170, 'suryo Sukmono', '20788', 'ciawi', 0, 0, NULL, '$2y$12$JGVpHCkku/8uGspwr9M2yujCBw4hboMi.K0k8vrWYVqH0cfN6pFsm', NULL, '2026-08-19 14:13:43', '2026-08-20 02:31:25', NULL, 'ciawi'),
(171, 'ABDUL ROASID', '2197', 'cinere', 0, 0, NULL, '$2y$12$iwEqYVTGfEwMizCDo.AJu.s6c/2/zdzEVERBd9K2y60U2e.BoRBS2', NULL, '2026-08-19 14:13:43', '2026-08-20 02:31:25', NULL, 'cinere'),
(172, 'Fikri', '25176', 'cianjur', 0, 0, NULL, '$2y$12$BkwrtgAbx5gPaz16aTurGuo//D.OZdQu9YHO68WxCcx5ejIuEdBJa', NULL, '2026-08-19 14:13:44', '2026-08-20 02:31:27', NULL, 'cianjur'),
(173, 'Agus Sugianto', '26290', 'jatiasih', 0, 0, NULL, '$2y$12$ad6OmZDHTXYuJC5pNH33EOx6jV2jLNGsrQLeCocbThqeqFQkkJDUW', NULL, '2026-08-19 14:13:44', '2026-08-20 02:31:27', NULL, 'jatiasih'),
(174, 'Hasbullah Hakim', '27250', 'cianjur', 0, 0, NULL, '$2y$12$bxJWDGsn8bsBfkx7Xn.eleDoFhkgNq4jV/3y3Q8xXFBALp3xPmEnK', NULL, '2026-08-19 14:13:45', '2026-08-20 02:31:28', 'bm_sh', 'cianjur'),
(175, 'SAID NUR ICHSAN', '27776', 'cinere', 0, 0, NULL, '$2y$12$tKMAWNIf37n5FI7Qb1SJeO29tXDARQJ50tGhHJM203KWDVDUwK1TG', NULL, '2026-08-19 14:13:45', '2026-08-20 02:31:29', 'bm_sh', 'cinere'),
(176, 'DEDI JUNAEDI', '27791', 'cinere', 0, 0, NULL, '$2y$12$bNWsBR923qp8pw00BpmtB.s9so2hj1ekD7JTlDj33Vd2yVJtNdTu.', NULL, '2026-08-19 14:13:45', '2026-08-20 02:31:29', NULL, 'cinere'),
(177, 'ILMAN KAHFI', '27792', 'cinere', 0, 0, NULL, '$2y$12$CHQiP6csSBlD.CGs0AVY8OOqB1V.z7uhYOnSCtyOhTJZqj9IX06tS', NULL, '2026-08-19 14:13:46', '2026-08-20 02:37:05', 'bm_sh', 'cinere'),
(178, 'Nadiya jayanti', '28234', 'cinere', 0, 0, NULL, '$2y$12$LIgEhAzFoSfX8/dfwMlxweB7T.m.P29ZDPMjAXNJoOZpvKQ2QhG3C', NULL, '2026-08-19 14:13:46', '2026-08-20 02:31:30', NULL, 'cinere'),
(179, 'SALEH MADANI', '29315', 'cianjur', 0, 0, NULL, '$2y$12$hUJwbsCGT7Z00K5jgozYKe3Yn4Od7fAh6gYwCidK1V5mM7wsNeF2q', NULL, '2026-08-19 14:13:46', '2026-08-20 02:31:30', 'bm_sh', 'cianjur'),
(180, 'CECEP SOBANA', '29728', 'cianjur', 0, 0, NULL, '$2y$12$/ca/iNrZVAiddje3/90t/e9rLMIFGLO92LU7P3yAlwSTxJUjMeQ/e', NULL, '2026-08-19 14:13:47', '2026-08-20 02:31:31', NULL, 'cianjur'),
(181, 'Eddy Sudianto', '29912', 'jatiasih', 0, 0, NULL, '$2y$12$wXjwaMzdViuOsTIoWheAlucr/2hqUSicnRr3y8G1CQ24GddovTTVS', NULL, '2026-08-19 14:13:47', '2026-08-20 02:31:32', NULL, 'jatiasih'),
(182, 'FIKRI', '29914', 'cianjur', 0, 0, NULL, '$2y$12$.t4dJY2AB7Y7i8dLL0cmXunuJApC1hAPLMbtS/V9RLKgQ5cU0dKsW', NULL, '2026-08-19 14:13:47', '2026-08-20 02:31:32', NULL, 'cianjur'),
(183, 'ANDI SUHENDI', '30236', 'ciawi', 0, 0, NULL, '$2y$12$2Ao2HdULHleKYqai0NURSedzD0gN8DTEh4UZ.yECYjDYBBPFYCXM2', NULL, '2026-08-19 14:13:48', '2026-08-20 02:31:33', NULL, 'ciawi'),
(184, 'LANY APRILIYANI ANGEL TINAM BUNAN', '31560', 'cinere', 0, 0, NULL, '$2y$12$sKExhh/tdFIuLZcteACC6uf0tRAjX5u8/HISkkPh5J2DmCn2ImkOa', NULL, '2026-08-19 14:13:48', '2026-08-20 02:31:34', 'bm_sh', 'cinere'),
(185, 'SUTRIONO', '32538', 'cianjur', 0, 0, NULL, '$2y$12$BINIn/z5MrxBjsytKRnrF.YNrG7gCfnjRYU9/Rmk8vAMPiqxaimP2', NULL, '2026-08-19 14:13:48', '2026-08-20 02:31:34', NULL, 'cianjur'),
(186, 'DENDEN TAUFIK HIDAYAT', '32681', 'cianjur', 0, 0, NULL, '$2y$12$UuZ1wh4mE4TLrGIhbyoXaO/nx0iJVLog9kc5FDcHC.AGV2/0GbDQG', NULL, '2026-08-19 14:13:49', '2026-08-20 02:31:34', NULL, 'cianjur'),
(187, 'MOHAMAD SULTHON', '32684', 'cianjur', 0, 0, NULL, '$2y$12$yUfOpZAePXTnOzZwr.efh.bkesYYGsXZBj6ZWap55OMYajGpOdkSm', NULL, '2026-08-19 14:13:49', '2026-08-20 02:31:35', NULL, 'cianjur'),
(188, 'PERISCA CAROLINE', '33025', 'jatiasih', 0, 0, NULL, '$2y$12$UXNv24eW6V2N7yFc6iKzcOpPdd8nUSJKNSm.f2vTmJ6wnD.DRLaEK', NULL, '2026-08-19 14:13:49', '2026-08-20 02:31:35', NULL, 'jatiasih'),
(189, 'Ganis Ruswandi', '34119', 'cianjur', 0, 0, NULL, '$2y$12$zkRHR6C6ccSTN/lrlZ4.ReBDCEw91SfH5ewzqG.rUcuhwI2WEineq', NULL, '2026-08-19 14:13:50', '2026-08-20 02:31:37', NULL, 'cianjur'),
(190, 'AYAT HERMAWAN', '34130', 'jatiasih', 0, 0, NULL, '$2y$12$q1po97/0sni2SUEBGNBj9e2cLxEnmqT4CGIkOtdR50ekYhKgTX4Gq', NULL, '2026-08-19 14:13:50', '2026-08-20 02:31:38', NULL, 'jatiasih'),
(191, 'HENDRIK SETIAWAN', '35295', 'cianjur', 0, 0, NULL, '$2y$12$1xcTWGcwVgXiC0WuS.p7hu/eF6jWsF6zflBbR4jjbDITqFnqJddaC', NULL, '2026-08-19 14:13:51', '2026-08-20 02:31:39', NULL, 'cianjur'),
(192, 'IRVAN SAPUTRA', '35302', 'cianjur', 0, 0, NULL, '$2y$12$ohRvdQy6AP86dU2/b6it9.DMCc2VqUKzfhzanXYt78wyaU629/rP.', NULL, '2026-08-19 14:13:51', '2026-08-20 02:31:40', NULL, 'cianjur'),
(193, 'BADRUDIN', '35502', 'cianjur', 0, 0, NULL, '$2y$12$Jw4kOGQkCHkWpH9ZUeLWYO6T4RVlxluvoEmq5aRhKzfMI1zvbKVgC', NULL, '2026-08-19 14:13:52', '2026-08-20 02:31:41', NULL, 'cianjur'),
(194, 'MAYANG SITI ANINGSIH', '35547', 'ciawi', 0, 0, NULL, '$2y$12$YUIOIYDffSnYNZo4xc2/1OxpZ39Nwh5u0B8mvuw9ZmoxMC0DJl.lm', NULL, '2026-08-19 14:13:52', '2026-08-20 02:31:41', NULL, 'ciawi'),
(195, 'JENI ABDULLAH', '35589', 'ciawi', 0, 0, NULL, '$2y$12$78fvLaHosXydXSJI1lWAsehZgeVPa/4FrrPVJ2izYCXBWw.YX9r8q', NULL, '2026-08-19 14:13:52', '2026-08-20 02:31:42', NULL, 'ciawi'),
(196, 'RANI HANDAYANI', '35684', 'ciawi', 0, 0, NULL, '$2y$12$y1mzMrarn0FGgxbWh5X8n.Q2QFArO28TvuVnGGPGXxMui6PrI0G5a', NULL, '2026-08-19 14:13:53', '2026-08-20 02:31:42', NULL, 'ciawi'),
(197, 'RYAN WINATA DIREDJA', '36187', 'ciawi', 0, 0, NULL, '$2y$12$BUhjzRVnpeTx3JOa.DxXkuHxcoW2/aQ.DJ7jKyUn4J/uNd2VXwHnu', NULL, '2026-08-19 14:13:53', '2026-08-20 02:31:43', NULL, 'ciawi'),
(198, 'MITA LASITA APRILIANI', '36518', 'cianjur', 0, 0, NULL, '$2y$12$1jCCnSbOH6fQzfm1bCVLcO1uGe.pORlVwhNTWX3lnCc5k0SMAfZTO', NULL, '2026-08-19 14:13:53', '2026-08-20 02:31:44', NULL, 'cianjur'),
(199, 'Isak Jakaria', '37529', 'jatiasih', 0, 0, NULL, '$2y$12$gGiNLYh32NgOOMJVoc5ZQefDjpE.ipdbk17mf2CgmLBLTw/Toy7rW', NULL, '2026-08-19 14:13:54', '2026-08-20 02:31:45', NULL, 'jatiasih'),
(200, 'IRVAN ZAENAL MUTAQIN', '37581', 'cianjur', 0, 0, NULL, '$2y$12$k2bbi8hqsHO/1Ckv2Lr.ueFBsrPqf.T/JPw8uz7L0pUQF04zndUEy', NULL, '2026-08-19 14:13:54', '2026-08-20 02:31:45', NULL, 'cianjur'),
(201, 'BUDIMAN', '37611', 'ciawi', 0, 0, NULL, '$2y$12$ghlXF1rkrC79fZwK9Ilx2.J0id7nKuvJlLXfBfeAge/XgzmgFXAmu', NULL, '2026-08-19 14:13:54', '2026-08-20 02:31:46', NULL, 'ciawi'),
(202, 'SURFA IDAM', '37612', 'ciawi', 0, 0, NULL, '$2y$12$UPIn1rfDagz4B8JEioUNXuC6Dn5DOHIDZmvguGmMAO.PwvoL/2bFq', NULL, '2026-08-19 14:13:55', '2026-08-20 02:31:46', NULL, 'ciawi'),
(203, 'CHRIS ARCHY', '37862', 'ciawi', 0, 0, NULL, '$2y$12$PnYpQTWYeb4/nRUSPhEYo.D8MrS9931wHs8J368s1BJzFmtX7ywDK', NULL, '2026-08-19 14:13:55', '2026-08-20 02:31:47', 'bm_sh', 'ciawi'),
(204, 'UJANG SOLAH', '37864', 'cianjur', 0, 0, NULL, '$2y$12$OT2lqVG3WI.jjntXLFxLqeFlq4AJks4ImEQhC3AxnJKl4M6p5fmH.', NULL, '2026-08-19 14:13:55', '2026-08-20 02:31:47', NULL, 'cianjur'),
(205, 'ASEP SUGANDI', '37865', 'cianjur', 0, 0, NULL, '$2y$12$IfUYLfVMlinYJjBw5hksyOXaxsm5WxB/qIvz8h58zIu6tZA9/I62i', NULL, '2026-08-19 14:13:55', '2026-08-20 02:31:48', NULL, 'cianjur'),
(206, 'ASEP FIRMANSYAH', '37866', 'cianjur', 0, 0, NULL, '$2y$12$OwZaDz5nVdmjUhIfXwhtduvV8HCC40Pty.sLHNaNwXXliJBVkz/eq', NULL, '2026-08-19 14:13:56', '2026-08-20 02:31:48', NULL, 'cianjur'),
(207, 'LULUK LUKMANURHAKIM', '37869', 'cianjur', 0, 0, NULL, '$2y$12$tm2xKOeJLYev/8YLtOAeH.EnX3LFBFCuKzQ32.kY99c0dYI5uNTdW', NULL, '2026-08-19 14:13:56', '2026-08-20 02:31:49', NULL, 'cianjur'),
(208, 'DONY SUGARA', '37875', 'ciawi', 0, 0, NULL, '$2y$12$H06en9H1kiP1jfBvqHsVyeY8a2lyKAI8JRBGo835xV6FtuCBHvq9i', NULL, '2026-08-19 14:13:56', '2026-08-20 02:31:49', NULL, 'ciawi'),
(209, 'LINDA YUNI FAROS', '37877', 'ciawi', 0, 0, NULL, '$2y$12$J3ub5nQEQYoplwSAbnQgyeUqyTFZUMTvBYfqMFnt28IyH/rrwDeke', NULL, '2026-08-19 14:13:57', '2026-08-20 02:31:50', NULL, 'ciawi'),
(210, 'IMAN SURIADI TARIGAN', '38019', 'ciawi', 0, 0, NULL, '$2y$12$90OYax7IvCnO1YlSY6aNpe3jf2cdDSRuyAugsPEUtN94cTQJo5NiO', NULL, '2026-08-19 14:13:57', '2026-08-20 02:31:50', NULL, 'ciawi'),
(211, 'DINAR ANGGRAENI', '38041', 'ciawi', 0, 0, NULL, '$2y$12$.YIHo.Uq/nhojHnxEV9Q6uap/yF0BrajGMMe4UC0PBItv4Y8z/EOi', NULL, '2026-08-19 14:13:57', '2026-08-20 02:31:51', NULL, 'ciawi'),
(212, 'MOCHAMAD RAMDHANI', '38192', 'cinere', 0, 0, NULL, '$2y$12$/DfRmBcGJKwp4JIkm97vM.otEmPTGXCi4DXp9rTYWAQ8r7h0AbrRy', NULL, '2026-08-19 14:13:58', '2026-08-20 02:31:52', NULL, 'cinere'),
(213, 'SITI AZTIRA', '38651', 'jatiasih', 0, 0, NULL, '$2y$12$.2y4Hkh0l95N6/eKZPMBPeWXxD4px0Q2hGb6I48.NXszsHnIP2Wty', NULL, '2026-08-19 14:13:58', '2026-08-20 02:31:52', 'bm_sh', 'jatiasih'),
(214, 'MURRY SUBHAN', '38687', 'cianjur', 0, 0, NULL, '$2y$12$PC6bqdhNAfP5IuB0ik6.9e4hOqmYiGXqb.NHlGRy27FrbwfxISKGC', NULL, '2026-08-19 14:13:58', '2026-08-20 02:31:52', 'bm_sh', 'cianjur'),
(215, 'SRI RAHAYU', '38690', 'cipanas', 0, 0, NULL, '$2y$12$TnTQjIFDcVw.FN9sdU.TwOrmTqHgEaNsvNVnwZVUNYlWdYKlqCOse', NULL, '2026-08-19 14:13:58', '2026-08-20 02:31:53', NULL, 'cipanas'),
(216, 'GANIS RUSWANDI', '38692', 'cianjur', 0, 0, NULL, '$2y$12$752NeOMPTBnp6QwhjtKrluy.UJY8jj5ah33noWOcEkZ9mCxq6cIBW', NULL, '2026-08-19 14:13:59', '2026-08-20 02:31:53', NULL, 'cianjur'),
(217, 'SAEPUL AMRI', '38715', 'cianjur', 0, 0, NULL, '$2y$12$ocUN7l/1z0Sz2bKas4UC.eLJay43BanxCKg2Sp3vMeWH5ApHZj7l.', NULL, '2026-08-19 14:13:59', '2026-08-20 02:31:54', NULL, 'cianjur'),
(218, 'EDWIN MELANSYAH', '38861', 'ciawi', 0, 0, NULL, '$2y$12$wL9g808YxmnvvVHqM9DD7OaCHIZhHk9LTWPYPCoKs3ThP8OA27KfO', NULL, '2026-08-19 14:13:59', '2026-08-20 02:31:54', NULL, 'ciawi'),
(219, 'BAHRUL ULUM', '39121', 'jatiasih', 0, 0, NULL, '$2y$12$1rhDwz2LWQEJctqDr.H7OOVqTio./V/nezRv9.2JTJvgcqS8Zh0XO', NULL, '2026-08-19 14:13:59', '2026-08-20 02:31:55', NULL, 'jatiasih'),
(220, 'MUHAMAD DAHLAN', '39415', 'ciawi', 0, 0, NULL, '$2y$12$Rx0FP6AvXddZKDRPemo1kupeSVPEE5WPy8gAuHJRcmM0FQqNQcNnq', NULL, '2026-08-19 14:14:00', '2026-08-20 02:31:55', NULL, 'ciawi'),
(221, 'FEMIA JULIAWATI', '39856', 'ciawi', 0, 0, NULL, '$2y$12$dg/gJXgLq312IaTzYrzm3Old/enprrWLbh5PyoGMVxSRWoRPhNF6e', NULL, '2026-08-19 14:14:00', '2026-08-20 02:31:56', NULL, 'ciawi'),
(222, 'ENDANG TARNADI', '39857', 'ciawi', 0, 0, NULL, '$2y$12$elVLzog5HStRUbPJBKfRD.XvX2vXELB/oobzN/Zfrm7IqMbE/0tRq', NULL, '2026-08-19 14:14:00', '2026-08-20 02:31:56', NULL, 'ciawi'),
(223, 'AWALUDIN', '40661', 'cinere', 0, 0, NULL, '$2y$12$Qn1GM6dR/hSLqjqibJLcsuvtuFXwZ9CHAPCGgXR5dkcBrLlwSz2zC', NULL, '2026-08-19 14:14:01', '2026-08-20 02:31:58', NULL, 'cinere'),
(224, 'CUT FACHRIANA MEUTIA ULFA', '40663', 'jatiasih', 0, 0, NULL, '$2y$12$2MwAAbr0oGUmfotlc7JTsO9oCtMLg.LPPcoiyPjxsRv2Fn6pHjlmu', NULL, '2026-08-19 14:14:01', '2026-08-20 02:31:58', NULL, 'jatiasih'),
(225, 'Deden', '41091', 'cianjur', 0, 0, NULL, '$2y$12$N6/QPbOwv3DA/U16/iZoKukJZEXSrYsQMznUydCz8RXnYzHEcpZky', NULL, '2026-08-19 14:14:02', '2026-08-20 02:31:59', NULL, 'cianjur'),
(226, 'MULYAWARMAN', '41142', 'cinere', 0, 0, NULL, '$2y$12$jNd0L3RvGm81kBq68dik8u56AO9xQFr6la1LHSoM4TCnUbQphY51e', NULL, '2026-08-19 14:14:02', '2026-08-20 02:31:59', 'bm_sh', 'cinere'),
(227, 'RANGGA ADITYA RIMBAWAN', '41570', 'jatiasih', 0, 0, NULL, '$2y$12$h9WBgnM/iXb7rtZhXAZYSeuIckfY/xBbu1PusqyKsB8LGVep9tady', NULL, '2026-08-19 14:14:02', '2026-08-20 02:31:59', 'bm_sh', 'jatiasih'),
(228, 'DEVRI MALIK', '41656', 'ciawi', 0, 0, NULL, '$2y$12$cjsctJWcrcm9JjqipYMwH.3fHMc7D7d5Z6BzKt2Npi6C8tq080mri', NULL, '2026-08-19 14:14:03', '2026-08-20 02:32:00', NULL, 'ciawi'),
(229, 'WAHYU HERDIANSYAH', '41657', 'ciawi', 0, 0, NULL, '$2y$12$qcAogmQL7NwUv3AtiXLDKeMxVONrHW0TJRC7uR59flFQfGhGLgpjy', NULL, '2026-08-19 14:14:03', '2026-08-20 02:32:00', NULL, 'ciawi'),
(230, 'DEVI MAULANA SAPUTRA', '41658', 'ciawi', 0, 0, NULL, '$2y$12$z7zjZUWppUX4fGMXz.lbIubZlKL51c8UI.mh/0/aafjTemfmnIjYG', NULL, '2026-08-19 14:14:03', '2026-08-20 02:32:00', NULL, 'ciawi'),
(231, 'SUANIH', '41659', 'ciawi', 0, 0, NULL, '$2y$12$3NEmuO9xlHkEW51l0d5xUuws3ry2b7Ptb5OeC7R7v0YXy3l832dFW', NULL, '2026-08-19 14:14:03', '2026-08-20 02:32:01', NULL, 'ciawi'),
(232, 'DIPPU HUTAGALUNG', '41686', 'cinere', 0, 0, NULL, '$2y$12$oIlg1PaaeBLjooAuRJE7PeTN4.x.cObkeTiPwskV8emX6rs3eGNue', NULL, '2026-08-19 14:14:04', '2026-08-20 02:32:01', 'bm_sh', 'cinere'),
(233, 'TOLHAS PALMARUM', '41689', 'cinere', 0, 0, NULL, '$2y$12$yDosQ7M400L/b6II21rkn.KcQBJ56xpvrcsURRAdTx9Hk8cYnAJKm', NULL, '2026-08-19 14:14:04', '2026-08-20 02:32:02', NULL, 'cinere'),
(234, 'YUDHIT KRISTANTO HADI S', '41690', 'cinere', 0, 0, NULL, '$2y$12$tgB60IHcvQ7jkTjyc7KHse8toiXXTpUPoKyY0Tsd4U.Cx/4h3Pz3e', NULL, '2026-08-19 14:14:04', '2026-08-20 02:32:02', NULL, 'cinere'),
(235, 'AGUNG SAPARUDIN', '41692', 'cinere', 0, 0, NULL, '$2y$12$fd60QiyTZJxBFGdZCKM.ae7Qt12lfB2GCv4IROh4J6bSFDz3Jed42', NULL, '2026-08-19 14:14:05', '2026-08-20 02:32:03', NULL, 'cinere'),
(236, 'MOHAMAD ARIEF CADER', '41693', 'cinere', 0, 0, NULL, '$2y$12$6TP8xr7i3SXWHQeJ4AcKP.l1M9RzobS757/Pfr153iM/7sGozI84a', NULL, '2026-08-19 14:14:05', '2026-08-20 02:32:03', NULL, 'cinere'),
(237, 'AGUS SETIA', '41695', 'cinere', 0, 0, NULL, '$2y$12$UnoMJ3hgJcZQRX9oWXIKeuF0zve97qPJp18i7amLISujyX4EM/XeG', NULL, '2026-08-19 14:14:05', '2026-08-20 02:32:03', NULL, 'cinere'),
(238, 'MOCHAMMAD IQBAL', '41696', 'cinere', 0, 0, NULL, '$2y$12$Ij9BWL6KOEBshGA1rwVbUer5b6DwuzS5BkRaXZEUecqfTVZK7X9dm', NULL, '2026-08-19 14:14:06', '2026-08-20 02:32:04', NULL, 'cinere'),
(239, 'YUDHI NUGRAHA DIHROSIN', '41855', 'cipanas', 0, 0, NULL, '$2y$12$/a/c7n87xGlkUcr1Ke/l4.Fef5mt5EiA0u/rV1v9S467OJ9REYyNG', NULL, '2026-08-19 14:14:06', '2026-08-20 02:32:04', NULL, 'cipanas'),
(240, 'ANDI HALGAN', '42349', 'cinere', 0, 0, NULL, '$2y$12$/y3seCbhT21jlwhHzrJx/eoltnNlRnduaz6VQRWs4l9xeUP6ny.sK', NULL, '2026-08-19 14:14:07', '2026-08-20 02:32:05', 'bm_sh', 'cinere'),
(241, 'TONI FIRMANSYAH MENDROFA', '42350', 'jatiasih', 0, 0, NULL, '$2y$12$qVlNA5MtJ.dIuSM.c06PL.WaigXFKWKLEyAsw/dWfRqg3aYS0np4a', NULL, '2026-08-19 14:14:07', '2026-08-20 02:32:05', 'bm_sh', 'jatiasih'),
(242, 'WELLY GYBSON', '42351', 'ciawi', 0, 0, NULL, '$2y$12$Fqd6Prx3IzXpBYOZ81XOY.1ZwWZ.5nQ8kdK5lbrxmzIO8wY8M0Dzy', NULL, '2026-08-19 14:14:07', '2026-08-20 02:32:06', NULL, 'ciawi'),
(243, 'MUHAMMAD FAJAR RIFQI', '42352', 'cianjur', 0, 0, NULL, '$2y$12$oAC20Zl5O41pfp6C67nK0emSa6B4Wg2KgXSe.6rdSIrIl697S54.O', NULL, '2026-08-19 14:14:07', '2026-08-20 02:32:06', NULL, 'cianjur'),
(244, 'LALANG ABDULAH', '42353', 'cianjur', 0, 0, NULL, '$2y$12$FFEz2VdsL4qrd2p2Q3wIouzJMiSpi.Zywbh/LWMMUwlTW4/LyuagK', NULL, '2026-08-19 14:14:08', '2026-08-20 02:32:06', NULL, 'cianjur'),
(245, 'RAHADIAN NUGRAHA', '42354', 'cianjur', 0, 0, NULL, '$2y$12$KSvj0x49GWK2uaKqpRkGiOeNVis9qP6DBqneJN6VF2g0EEGe4LjsW', NULL, '2026-08-19 14:14:08', '2026-08-20 02:32:07', NULL, 'cianjur'),
(246, 'RISKY AGUNG FRATAMA', '42355', 'cianjur', 0, 0, NULL, '$2y$12$Q/5NVEESlF37uBalPsPCB.MLCnZb.goR5Un0FsIABXvVJEiLhAPj2', NULL, '2026-08-19 14:14:08', '2026-08-20 02:32:07', NULL, 'cianjur'),
(247, 'HERU SAPUTRA', '42356', 'cianjur', 0, 0, NULL, '$2y$12$pMHTbbIcCStC0H4i4uOuY.YO4KYiZW1..xukwHBIgAd64Nlc6W1Z.', NULL, '2026-08-19 14:14:08', '2026-08-20 02:32:08', NULL, 'cianjur'),
(248, 'FAISAL PUNGKI SETIADI', '42357', 'cianjur', 0, 0, NULL, '$2y$12$LNBpduaQIXhIePEWYoaVNOyL1LGEZ15Vy2TjqO/T2pOSck80jKBFK', NULL, '2026-08-19 14:14:09', '2026-08-20 02:32:08', NULL, 'cianjur'),
(249, 'FENTI LESTARI', '42358', 'cianjur', 0, 0, NULL, '$2y$12$mEWZVKCLGpo4BXqDOSm4m.ZMONHroDZG0S.SNZJj6JTJW4hvEm1WK', NULL, '2026-08-19 14:14:09', '2026-08-20 02:32:08', NULL, 'cianjur'),
(250, 'PONCO NUGROHO', '42359', 'cinere', 0, 0, NULL, '$2y$12$MkLltOYhusFaiVbaMEFByeC5OQX4nyuihcGV5mN1SIPTPEEi.rbCy', NULL, '2026-08-19 14:14:09', '2026-08-20 02:32:09', NULL, 'cinere'),
(251, 'ZULROSA APRILYA', '42360', 'cinere', 0, 0, NULL, '$2y$12$R6jIygpJPKFK2ZkI4Y6xM.sHCaHTGkGa4sqCby8fT2gxI3fMvrZEa', NULL, '2026-08-19 14:14:10', '2026-08-20 02:32:09', NULL, 'cinere'),
(252, 'KHUSNUL KHOTIM', '42361', 'cinere', 0, 0, NULL, '$2y$12$BBrOq4avQoPR3Pdmec5KEuEmkIoQLpxip.pxRQ8T2ni6dbm/Cooea', NULL, '2026-08-19 14:14:10', '2026-08-20 02:32:09', NULL, 'cinere'),
(253, 'FIRMAN NUGRAHA', '42390', 'cianjur', 0, 0, NULL, '$2y$12$Atbeb5xe1rGNykDsXYyjqe6kGfPdm0EuxN8sfae8sFKCQ56cHGq8y', NULL, '2026-08-19 14:14:10', '2026-08-20 02:32:10', NULL, 'cianjur'),
(254, 'REKSA DHARMA WIWARHA', '42471', 'jatiasih', 0, 0, NULL, '$2y$12$exojvA/XfUguyapoIjvNNOQU6k61RtXHcblKUSi.1ujDO.PfJ7xeu', NULL, '2026-08-19 14:14:11', '2026-08-20 02:32:10', NULL, 'jatiasih'),
(255, 'NOVA CLINTONIWATY', '42472', 'jatiasih', 0, 0, NULL, '$2y$12$/yDKl7YDTP1XT28KDXuDluF.Iq8TRArNpgwjUVkd8iBn/utF0cXhS', NULL, '2026-08-19 14:14:11', '2026-08-20 02:32:10', NULL, 'jatiasih'),
(256, 'INDIYAH PUTRI RATNASARI', '42473', 'jatiasih', 0, 0, NULL, '$2y$12$UKzyhar2CqIwoA.M8OPOGezoBKzkb.02Z8GqJ8JILRbO9Qti20aom', NULL, '2026-08-19 14:14:11', '2026-08-20 02:32:11', NULL, 'jatiasih'),
(257, 'FERDIANSYAH', '42474', 'jatiasih', 0, 0, NULL, '$2y$12$23OgypKgY0kEnImy1rUQJO0O5tEDkHlkmToxvFpze7of8JNQMgFmi', NULL, '2026-08-19 14:14:11', '2026-08-20 02:32:11', NULL, 'jatiasih'),
(258, 'TAUFAN MAULANA ALAMSYAH', '42475', 'jatiasih', 0, 0, NULL, '$2y$12$Agw2YkKklWHgEyWYqU4cB.Q8FjVl7PL4JhmVvbSRF/KiVCbRFVGKq', NULL, '2026-08-19 14:14:12', '2026-08-20 02:32:12', NULL, 'jatiasih'),
(259, 'ISA MASELA', '42476', 'jatiasih', 0, 0, NULL, '$2y$12$tH94bYRp6ts3GDNTYfUml.vbMPiJcOB2LayaHnt1aogotQUlx4ugS', NULL, '2026-08-19 14:14:12', '2026-08-20 02:32:12', NULL, 'jatiasih'),
(260, 'KANIA PUTRIZEN SYAHNADIRA', '42477', 'jatiasih', 0, 0, NULL, '$2y$12$uDukUHR5GiLrnbT2m.Rpy.gHfSvLvAuz28AGXXC4GJrXPmy6Ta9AO', NULL, '2026-08-19 14:14:12', '2026-08-20 02:32:12', NULL, 'jatiasih'),
(261, 'YULI YULIANTI', '42478', 'cinere', 0, 0, NULL, '$2y$12$KTemlAbAKIHpZAMyY9C5Ten7dCKIqECZmp2lagcfnyGvCPKSEgrGa', NULL, '2026-08-19 14:14:13', '2026-08-20 02:32:13', NULL, 'cinere'),
(262, 'SUHENDRA NOPIANSYAH', '42479', 'cinere', 0, 0, NULL, '$2y$12$1RIZQjpfDjEuwcaYIr5ZIONCVcs5kPnwglPAqy4E28tKRZMq0bKUq', NULL, '2026-08-19 14:14:13', '2026-08-20 02:32:13', NULL, 'cinere'),
(263, 'AHMAD DHANI FADILLAH', '42480', 'cinere', 0, 0, NULL, '$2y$12$.XQVnPeEs0qt9ATxUyar4eSLsB0REj1IVTTADEi6hBGqp8Uhy3Z8C', NULL, '2026-08-19 14:14:13', '2026-08-20 02:32:13', NULL, 'cinere'),
(264, 'CHANDRA SAPTO YULIANTO', '42481', 'cinere', 0, 0, NULL, '$2y$12$ii7pxS/XHINS.lPm63b7yuOljR22zaxpXqIEA1DuGSUVa3oo/1.TG', NULL, '2026-08-19 14:14:13', '2026-08-20 02:32:14', NULL, 'cinere');
INSERT INTO `users` (`id`, `name`, `email`, `branch`, `is_admin`, `is_admin_stock`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `cabang`) VALUES
(265, 'NOVAN DWI HADIWIBOWO', '42482', 'cinere', 0, 0, NULL, '$2y$12$Jxf0T/4/kXJ93M.J/YTPc.DPf3cg35kbch30XPAPJyGBO.BjWxyOC', NULL, '2026-08-19 14:14:14', '2026-08-20 02:32:14', NULL, 'cinere'),
(266, 'ACEP FITRIADI', '42483', 'cinere', 0, 0, NULL, '$2y$12$4t1DUBNwV8L1EJNt7r3Fs.vjm7m52YyMsLconXmVYSTFm76rx/onm', NULL, '2026-08-19 14:14:14', '2026-08-20 02:32:14', NULL, 'cinere'),
(267, 'DIKI MAULIDIANSYAH', '42484', 'cinere', 0, 0, NULL, '$2y$12$C0l1yharGwaEibGcamodzuDX5wSQ6IkXkOFuMCwzRcRHeztUpEKDO', NULL, '2026-08-19 14:14:14', '2026-08-20 02:32:15', NULL, 'cinere'),
(268, 'CITRA NURDIANSARI', '42577', 'jatiasih', 0, 0, NULL, '$2y$12$9rZjJK3yCtHcASZBkFfmf.U.oZ6gHDehTR0wFn7kAYSdXLNhcGiTi', NULL, '2026-08-19 14:14:14', '2026-08-20 02:32:15', NULL, 'jatiasih'),
(269, 'DEDEN HENDRAWAN', '42891', 'ciawi', 0, 0, NULL, '$2y$12$z/roA0NqiOhb6t5RTj11buCEh0WeVbaQ3fUGsyhEACPEIhZ.Y7BfG', NULL, '2026-08-19 14:14:15', '2026-08-20 02:32:16', NULL, 'ciawi'),
(270, 'BADRIAL AKBAR', '42892', 'ciawi', 0, 0, NULL, '$2y$12$1fFxoIxNGb3iDhhpNj.dpOHEiD9XNCCNCmBdDod71clMHlONjyvj.', NULL, '2026-08-19 14:14:15', '2026-08-20 02:32:16', NULL, 'ciawi'),
(271, 'VITA MONICA', '42893', 'ciawi', 0, 0, NULL, '$2y$12$/DUtU253Ahgj9cy89QlsserFErWoVNilIKb/TESCP0XoCwaXSMZAi', NULL, '2026-08-19 14:14:15', '2026-08-20 02:32:16', NULL, 'ciawi'),
(272, 'AULIA PANCA', '42894', 'ciawi', 0, 0, NULL, '$2y$12$xkalNsMH3Sc5wiGb63XwaeDmS2tBp/yFjTJH62YourRgCw0tZhrk.', NULL, '2026-08-19 14:14:16', '2026-08-20 02:32:17', NULL, 'ciawi'),
(273, 'SOBUR BURHANUDIN', '42905', 'ciawi', 0, 0, NULL, '$2y$12$gNGcjo7Pluujle4kOjfMHeUkZxo/jN7gZr5.LOTx2GQyPAeA7E5YW', NULL, '2026-08-19 14:14:16', '2026-08-20 02:32:17', NULL, 'ciawi'),
(274, 'HOLIK ABDUL AZIS', '42906', 'ciawi', 0, 0, NULL, '$2y$12$VzhpA5U57CGVuZo76TqtleAf6l/h4.weJ4E0Fy7uqkzxVeU6w.elm', NULL, '2026-08-19 14:14:16', '2026-08-20 02:32:17', NULL, 'ciawi'),
(275, 'AHMAD SAEPULLOH', '42907', 'ciawi', 0, 0, NULL, '$2y$12$lWkhSIS7sAPkF5shuco1E..8cujU57arPHWUcg30koIu9serW8ljG', NULL, '2026-08-19 14:14:16', '2026-08-20 02:32:18', NULL, 'ciawi'),
(276, 'SEPTIAN PAHLEVI', '42909', 'jatiasih', 0, 0, NULL, '$2y$12$boLeP6CKPDXNew849qwjrumrlIA5eQirb7bkbcrf2c7ea4kYIGks2', NULL, '2026-08-19 14:14:17', '2026-08-20 02:32:18', NULL, 'jatiasih'),
(277, 'BAYU SEPTIAJI', '42910', 'jatiasih', 0, 0, NULL, '$2y$12$s6UPd7DQ3zj/udpQK.eOgOzZiexBEg7sc8Af3d3b53aPGAATzhtf6', NULL, '2026-08-19 14:14:17', '2026-08-20 02:32:18', NULL, 'jatiasih'),
(278, 'ANGGRA PRAJA UTAMA', '42917', 'jatiasih', 0, 0, NULL, '$2y$12$5BiKws.E2R2kpfRg7tqQEecLjuHogllyDBIcJkzTETakPBgAlc0Y.', NULL, '2026-08-19 14:14:17', '2026-08-20 02:32:19', NULL, 'jatiasih'),
(279, 'IQBAL BAYU PUTRA', '42918', 'jatiasih', 0, 0, NULL, '$2y$12$VSyKxl1mINKsOfW7ryLjPOJIN25JhC5iWI/ZdEPm9Rgl93rycjuFK', NULL, '2026-08-19 14:14:18', '2026-08-20 02:32:19', NULL, 'jatiasih'),
(280, 'RENDIANSYAH', '42919', 'jatiasih', 0, 0, NULL, '$2y$12$bgn4Oe5AGLAWsrE1gCVpw.1qHl5hzI1JM0bRZvo1fXV0J8.zISarq', NULL, '2026-08-19 14:14:18', '2026-08-20 02:32:19', NULL, 'jatiasih'),
(281, 'MUHAMMAD NURDIN ALAMSYAH', '42920', 'jatiasih', 0, 0, NULL, '$2y$12$kDDcJVcquW18AC1eKDg57.a1GERtY2CrHhrOV5HYZoz9CmKG6Mx4O', NULL, '2026-08-19 14:14:18', '2026-08-20 02:32:20', NULL, 'jatiasih'),
(282, 'ASEP BUDIMAN', '42925', 'ciawi', 0, 0, NULL, '$2y$12$v4S3bzyWN/Qo7RCb7T1xXOShm1lxcjDYzy4bkil3WJrlO2frv.Kkm', NULL, '2026-08-19 14:14:18', '2026-08-20 02:32:20', NULL, 'ciawi'),
(283, 'ALI', '42926', 'ciawi', 0, 0, NULL, '$2y$12$wZn2zv/3WJYb6XvfobFoP.1O4XGxJh1Ismra336Xi1GmZHJaQ/9Pa', NULL, '2026-08-19 14:14:19', '2026-08-20 02:32:21', NULL, 'ciawi'),
(284, 'MUHAMAD AKMAL L.', '42927', 'ciawi', 0, 0, NULL, '$2y$12$yBADa4uWmz1VoeZe64hew.wj1fAadInfDCRkcj08MdPiAj5aM7BC6', NULL, '2026-08-19 14:14:19', '2026-08-20 02:32:21', NULL, 'ciawi'),
(285, 'MAMAN SULAEMAN', '42943', 'ciawi', 0, 0, NULL, '$2y$12$Jgv4Pai5nWovIKLNLMYP5uLTks.JnugjdNKP26YvnLh8POa8UTB0u', NULL, '2026-08-19 14:14:19', '2026-08-20 02:32:21', NULL, 'ciawi'),
(286, 'SYAMSUL BACHTIAR', '42944', 'ciawi', 0, 0, NULL, '$2y$12$ViJtoqFJg2MG.8630yJkMuCtbOU.N9u9EgWIyeHI8MqZY9HBqSgk6', NULL, '2026-08-19 14:14:20', '2026-08-20 02:32:22', NULL, 'ciawi'),
(287, 'GUGUN ABDUS SAFARI, SH', '43087', 'cianjur', 0, 0, NULL, '$2y$12$QT.rLk4LqZNnrm0UsUeJpuIYRR/Q3p12S2sPvQYNclwJHnjTPsiPa', NULL, '2026-08-19 14:14:20', '2026-08-20 02:32:22', NULL, 'cianjur'),
(288, 'ENDANG MU\'MIN', '43088', 'cianjur', 0, 0, NULL, '$2y$12$Rk6O.QfJWNsdX9TA4UZC1eR6KMu7wmwpjNk5t6BTw5ZKhN1Igv002', NULL, '2026-08-19 14:14:20', '2026-08-20 02:32:22', NULL, 'cianjur'),
(289, 'ALI RUDY', '43470', 'ciawi', 0, 0, NULL, '$2y$12$xYd96F7WSKyf0CsSIjCPQek7QX7Ty9lbdzNe/qmpPKgMq0gNgd95W', NULL, '2026-08-19 14:14:20', '2026-08-20 02:32:23', NULL, 'ciawi'),
(290, 'SUCI JAYANTI', '43480', 'ciawi', 0, 0, NULL, '$2y$12$cUCg1Hj4Mk.6TiNkYosQZupqT/55PRAwTkj9QlEHVYvQAloo4aOv.', NULL, '2026-08-19 14:14:20', '2026-08-20 02:32:23', NULL, 'ciawi'),
(291, 'ACHMAD DAHLAN', '43604', 'ciawi', 0, 0, NULL, '$2y$12$5RXxJCvr.lxXVlXMVd41Q.1WzV1VCoJyubSO8BA9ET4MMYXXB5CDa', NULL, '2026-08-19 14:14:21', '2026-08-20 02:32:23', NULL, 'ciawi'),
(292, 'HUSLAN RASYID', '43605', 'ciawi', 0, 0, NULL, '$2y$12$YrOiLPaHAIZBDygjqeYgq..ccdinyJhUzMOqCV2kKvwJMHwZmoeyG', NULL, '2026-08-19 14:14:21', '2026-08-20 02:32:24', NULL, 'ciawi'),
(293, 'NURHASANAH', '43869', 'ciawi', 0, 0, NULL, '$2y$12$f.Ohmoc.50idlpAgcO/CSOsCckQ4ow3nDYfOawQgVw6I3PS14QIbu', NULL, '2026-08-19 14:14:22', '2026-08-20 02:32:25', 'bm_sh', 'ciawi'),
(294, 'ALFAN FAUZAN', '43880', 'ciawi', 0, 0, NULL, '$2y$12$l1m7mK/vtUTVeOI2DylCwONOs2HQe8omzYFNFfKLx8N61/6kOeWnW', NULL, '2026-08-19 14:14:22', '2026-08-20 02:32:25', NULL, 'ciawi'),
(295, 'YOKI INDRA PRAYOGA', '43883', 'ciawi', 0, 0, NULL, '$2y$12$9kyd9RXKz4vyr.N/fDzDuuFNPNfCeoVjD61L2UAM868y8z9LorMmy', NULL, '2026-08-19 14:14:22', '2026-08-20 02:32:25', NULL, 'ciawi'),
(296, 'Trisning ajeung kamila', '43884', 'ciawi', 0, 0, NULL, '$2y$12$EBFAoNCAQgRMjTAQdyXO0.AMFMXzh1aC4Vl0Kdhi.w5QUJWXhTb.K', NULL, '2026-08-19 14:14:22', '2026-08-20 02:32:26', NULL, 'ciawi'),
(297, 'AGUS SETIA NEGARA', '43885', 'ciawi', 0, 0, NULL, '$2y$12$tlOycLuKQjsnj9BiFsORrOg.9iBQ.84pj0pnl0Nh3HcpvNbrHusbe', NULL, '2026-08-19 14:14:23', '2026-08-20 02:32:26', NULL, 'ciawi'),
(298, 'ARIF PRIATNA', '43894', 'ciawi', 0, 0, NULL, '$2y$12$zAy74sSqu0tGvxQdvmnNReMiw7G6qGGkZZH58UMufjPyXKltFDH5K', NULL, '2026-08-19 14:14:23', '2026-08-20 02:32:26', NULL, 'ciawi'),
(299, 'R.RENDY FATLAND', '43895', 'ciawi', 0, 0, NULL, '$2y$12$1przi1.PYeNYpDc3Oz73Ne.BWHYNSTvZjqTvuwEFvBvFfw5lhTf/y', NULL, '2026-08-19 14:14:23', '2026-08-20 02:32:27', NULL, 'ciawi'),
(300, 'JEREMIA NUGRAHA PANJAITAN', '43897', 'cinere', 0, 0, NULL, '$2y$12$9DVYrnTSnXx7wQTroPdxjeHBiHRZt1CTPUlTEBh0AqrdGKa24gJg.', NULL, '2026-08-19 14:14:23', '2026-08-20 02:32:27', NULL, 'cinere'),
(301, 'LILIAN ESTI WINDIANINGRUM', '43898', 'cinere', 0, 0, NULL, '$2y$12$kpu64UG7qDoB43tPKwb4ueS5SV4yjOHS4rk5DA12/nMhPUmTWz.DW', NULL, '2026-08-19 14:14:24', '2026-08-20 02:32:27', 'bm_sh', 'cinere'),
(302, 'AGUNG PRASETYO', '43899', 'cinere', 0, 0, NULL, '$2y$12$VHvKBgQfhIDq7LGcYCrzAeJXqsX2YpS04hV2.l2U3Yg4G0t0x2Rie', NULL, '2026-08-19 14:14:24', '2026-08-20 02:32:28', NULL, 'cinere'),
(303, 'ALFIN NURCAHYO', '43900', 'cinere', 0, 0, NULL, '$2y$12$LNPsWyO6zxOhJK2CiQDzY.hkNy5700zHUXlbrdekkeB8DU5xEhQ8K', NULL, '2026-08-19 14:14:24', '2026-08-20 02:32:28', NULL, 'cinere'),
(304, 'HAIRIL KAHFI', '43901', 'cinere', 0, 0, NULL, '$2y$12$Gr2bDd4/0mViLu5ZNPd10eMNKiiklb6aVHrNjuPMjccX3Mmfq2yA2', NULL, '2026-08-19 14:14:25', '2026-08-20 02:32:28', NULL, 'cinere'),
(305, 'HENDRA NOFRIANSYAH', '43902', 'jatiasih', 0, 0, NULL, '$2y$12$BETjwfq1PXy8pf4qKvsoBugVPi.knFF.DyCQ8z1CHauIjUDjs49U6', NULL, '2026-08-19 14:14:25', '2026-08-20 02:32:29', NULL, 'jatiasih'),
(306, 'MIMA SITI MULYANAH', '43903', 'jatiasih', 0, 0, NULL, '$2y$12$Pjbpi39jE/PQ3H8jVrZniOvAUvH.khUEIFiQFmxdDFtVKz9lIRypa', NULL, '2026-08-19 14:14:25', '2026-08-20 02:32:29', NULL, 'jatiasih'),
(307, 'TITA NIKITA HUTASOIT', '43904', 'jatiasih', 0, 0, NULL, '$2y$12$zx9wosjfVWAODRIMQkOxbO6RdPJtCYMVetsZgdlCz4Y2pcgVXTcYe', NULL, '2026-08-19 14:14:25', '2026-08-20 02:32:30', NULL, 'jatiasih'),
(308, 'DIANA AYU RATNA SARI', '43905', 'jatiasih', 0, 0, NULL, '$2y$12$BP/V7LVcSXaTFoNBg7CqJOrdF2OuJ7D0s2/thwIo0rhtk.aHJxqNe', NULL, '2026-08-19 14:14:26', '2026-08-20 02:32:30', NULL, 'jatiasih'),
(309, 'DEWI YULIANTI', '43906', 'jatiasih', 0, 0, NULL, '$2y$12$pCDcBQ7hlosGZncw.XIIJuDIMmarsJx6BKnu8.W2Miu3hQT05UVCe', NULL, '2026-08-19 14:14:26', '2026-08-20 02:32:30', NULL, 'jatiasih'),
(310, 'NUR LELASARI', '43909', 'jatiasih', 0, 0, NULL, '$2y$12$dNfRvbiMMgIPMiAIhqKnseEbKVhoPWmw6DFKyHreDF0dQ7Ktl1WtC', NULL, '2026-08-19 14:14:26', '2026-08-20 02:32:31', NULL, 'jatiasih'),
(311, 'OKI ABRIANSYAH', '43910', 'jatiasih', 0, 0, NULL, '$2y$12$vTb./C8rpTGZlxXQY.9zpu81aYJ1bHSt.R8fp6PvCk29yfE/RYw5y', NULL, '2026-08-19 14:14:26', '2026-08-20 02:32:31', NULL, 'jatiasih'),
(312, 'M. TAUFIK', '43911', 'jatiasih', 0, 0, NULL, '$2y$12$powuOc4GkiXp5NK.lfhIDesCl9J0o5BxdQAnnO0StaSlSLWSG5ime', NULL, '2026-08-19 14:14:27', '2026-08-20 02:32:31', NULL, 'jatiasih'),
(313, 'MIYARSO HARIYAWAN', '43912', 'jatiasih', 0, 0, NULL, '$2y$12$lfqCoFx44ZxhC/2bX7iwI.A0d82htvfcJis3IQd/80w6vHsooKm4S', NULL, '2026-08-19 14:14:27', '2026-08-20 02:32:32', NULL, 'jatiasih'),
(314, 'T. CUT M BURHANI AKSHA', '43913', 'jatiasih', 0, 0, NULL, '$2y$12$nVILgyUbYESr6I5wpEuQnOG9kfaHcszOa.Jn8Y2Bqa0VV5cgzqedq', NULL, '2026-08-19 14:14:27', '2026-08-20 02:32:32', NULL, 'jatiasih'),
(315, 'MICHAEL DIDI PRIYADI', '43914', 'jatiasih', 0, 0, NULL, '$2y$12$pt3vdJ75cO9..1027jUCGeYMWAuTa2TH779T5/g7qFJW3nKJlFuJi', NULL, '2026-08-19 14:14:28', '2026-08-20 02:32:32', NULL, 'jatiasih'),
(316, 'ALBERT', '43916', 'ciawi', 0, 0, NULL, '$2y$12$6L97FI5iepxYxWFCdg27rOccPcYXxmIb4nRWAt/rGcogWBRhbzzYC', NULL, '2026-08-19 14:14:28', '2026-08-20 02:32:33', NULL, 'ciawi'),
(317, 'RIZKI AULIA FAHMI', '43917', 'ciawi', 0, 0, NULL, '$2y$12$/EXmXBxJpgEnYE2mNgqidOM9eslWTkPmDgud8frw1B9bZQOuz6YHS', NULL, '2026-08-19 14:14:28', '2026-08-20 02:32:33', NULL, 'ciawi'),
(318, 'FIRMAN WIJAYA KUSUMA', '44176', 'cinere', 0, 0, NULL, '$2y$12$jgkQDCGfxaEdNq8wXqeIYenrd18nSlacuSOsmqsndW4tkk62TRrE2', NULL, '2026-08-19 14:14:28', '2026-08-20 02:32:33', NULL, 'cinere'),
(319, 'ADE NURLAILA ZAHRA', '44177', 'cinere', 0, 0, NULL, '$2y$12$UqHDGZyIIjHE2H5lSGGtOu7rf085AuAhvTmdsTTtWteenEGfckoje', NULL, '2026-08-19 14:14:29', '2026-08-20 02:32:34', NULL, 'cinere'),
(320, 'DEDE ISKANDAR', '44429', 'cinere', 0, 0, NULL, '$2y$12$yGE6OZmQukzbQxjH5JhPZO6mv0ivZDUKVoqgYMkRSifyq/yUe6QXm', NULL, '2026-08-19 14:14:29', '2026-08-20 02:32:34', NULL, 'cinere'),
(321, 'Maman Djailani', '44543', 'cianjur', 0, 0, NULL, '$2y$12$BXWy1RmA6CV2uFH9Cmo0oewRtD8LznAgPj8sNk2Jc9V2xKOf8RgFC', NULL, '2026-08-19 14:14:29', '2026-08-20 02:32:35', 'bm_sh', 'cianjur'),
(322, 'Mikha Rapali', '44544', 'cianjur', 0, 0, NULL, '$2y$12$lx.rm8qFkUHbrQ/ut06lZ./6f4oMqKOuxb3jwm9shNrMIUpH8ctJy', NULL, '2026-08-19 14:14:30', '2026-08-20 02:32:35', NULL, 'cianjur'),
(323, 'Muhammad Faizal Al hazmi', '44545', 'cianjur', 0, 0, NULL, '$2y$12$8Y0LhGCxjBbO7gc0Pq8S6.0mvaoekZp9koL/1zzskGO5oW8CHY6cy', NULL, '2026-08-19 14:14:30', '2026-08-20 02:32:35', NULL, 'cianjur'),
(324, 'Joni Legawa', '44546', 'cianjur', 0, 0, NULL, '$2y$12$0WxS017mJX4OeaHv/ZCg9OTH8cKfLKM3zunuJ5Nj4hUf.fq0FLce6', NULL, '2026-08-19 14:14:30', '2026-08-20 02:32:36', NULL, 'cianjur'),
(325, 'Rian Febrianto', '44548', 'cianjur', 0, 0, NULL, '$2y$12$Lw2souYCG6REoaYUOnk5iuFz5ewtElaLlbtd6FOrerkvUVQA7OzUu', NULL, '2026-08-19 14:14:30', '2026-08-20 02:32:36', NULL, 'cianjur'),
(326, 'Yudha Satria Lubis', '44549', 'cianjur', 0, 0, NULL, '$2y$12$BwLpJPf2BtEAmN8C9./J5egBfIYDTKO/82rrbPz80Q547xlh25lmm', NULL, '2026-08-19 14:14:31', '2026-08-20 02:32:36', NULL, 'cianjur'),
(327, 'Putri dewana', '44550', 'cianjur', 0, 0, NULL, '$2y$12$uJaq5PlGEAENzW1K4cX61.9BTbmOX5y.WIWkY2kld9V.4VhHzuCyG', NULL, '2026-08-19 14:14:31', '2026-08-20 02:32:37', NULL, 'cianjur'),
(328, 'AGUNG SURIZA', '44551', 'cinere', 0, 0, NULL, '$2y$12$/8MXAypwwSW0vl4xkjLfle52j4yD01k8fMfSj2GPDk.2wjSRkyqKS', NULL, '2026-08-19 14:14:31', '2026-08-20 02:32:37', NULL, 'cinere'),
(329, 'DONY BUDI SETIAWAIN', '44561', 'jatiasih', 0, 0, NULL, '$2y$12$xCPby1UvkrZEFs.jOiTeiuoJKwwPXKg5XSdPtTJKEuYXpL9p8mV7a', NULL, '2026-08-19 14:14:31', '2026-08-20 02:32:37', NULL, 'jatiasih'),
(330, 'YUDA CANDRA NUGRAHA', '44562', 'jatiasih', 0, 0, NULL, '$2y$12$qNSc6wjoOpqG0YgXZhqn/.K0Da9GaYecpAB6o6epgaetCqJPMCgXC', NULL, '2026-08-19 14:14:32', '2026-08-20 02:32:38', NULL, 'jatiasih'),
(331, 'DIMAS ADIFA', '44704', 'jatiasih', 0, 0, NULL, '$2y$12$P0VRfXi8TebNH9C6mO5gk.4ntCuLDliWcOZevP/y5dsaAcLiNb4zi', NULL, '2026-08-19 14:14:32', '2026-08-20 02:32:38', NULL, 'jatiasih'),
(332, 'MELKI SEDEK ALFA SANDICH', '44717', 'ciawi', 0, 0, NULL, '$2y$12$Q6XmfPA.hwx58yxkR9G2W.tB6kNIEMqI13WwDSHb10tantFClBpv6', NULL, '2026-08-19 14:14:32', '2026-08-20 02:32:38', NULL, 'ciawi'),
(333, 'CHANDRA BUDIMAN', '44718', 'ciawi', 0, 0, NULL, '$2y$12$rE/6ZpewsNdVHhcuaFUA7ezz1gcPjQpC030Ocv4w87aYxv/LsD2rC', NULL, '2026-08-19 14:14:33', '2026-08-20 02:32:39', NULL, 'ciawi'),
(334, 'HADE WIBAWA', '44719', 'cianjur', 0, 0, NULL, '$2y$12$cQB2deS6LCNj9El/BFmdV.X5qAcykuScz.cgRBmbJbUGRsOtYL0za', NULL, '2026-08-19 14:14:33', '2026-08-20 02:32:39', 'bm_sh', 'cianjur'),
(335, 'YUDHI KAMAJAYA LD', '44722', 'cianjur', 0, 0, NULL, '$2y$12$hQUYGlvEi6Xvr/gvg.qCWOmyMo5Tqunvps1WC4OEVy/2bG5ekZAla', NULL, '2026-08-19 14:14:33', '2026-08-20 02:32:40', NULL, 'cianjur'),
(336, 'IDA PERMATASARI', '44723', 'cianjur', 0, 0, NULL, '$2y$12$vlJ/q.cjzEciJrHdsuwpMeL3M2JNCbFCOqQjxWU31vDcUmlwG3HqS', NULL, '2026-08-19 14:14:34', '2026-08-20 02:32:40', NULL, 'cianjur'),
(337, 'TRI BAKHTI SAMPOERNA', '44724', 'cianjur', 0, 0, NULL, '$2y$12$/hpgieLWPrGtPP6k3l9AceDeB4GxOzeWreM1Cve8iihnsCDcLT79G', NULL, '2026-08-19 14:14:34', '2026-08-20 02:32:40', NULL, 'cianjur'),
(338, 'INDRA SUSILA', '44725', 'cianjur', 0, 0, NULL, '$2y$12$pmOhlfcrqIpXrEkgzgGpDuGBG/n8rgOg9xBbxiMb/5oOM9IkkzhBa', NULL, '2026-08-19 14:14:34', '2026-08-20 02:32:41', NULL, 'cianjur'),
(339, 'MUHAMAD SYARIFUDIN', '44790', 'ciawi', 0, 0, NULL, '$2y$12$INf6/x/jq5wgxtUjzhZExe82skevIwVKEjHPObfiVgKeuW9aavhVG', NULL, '2026-08-19 14:14:34', '2026-08-20 02:32:41', NULL, 'ciawi'),
(340, 'ADJI ALFI SYAKHRI', '44815', 'cinere', 0, 0, NULL, '$2y$12$2U.IJb5/1Rw.Zqv65VIw6ePbDswy.azzpV3p3Fiq/ZVeAG1WGrZEq', NULL, '2026-08-19 14:14:35', '2026-08-20 02:32:41', NULL, 'cinere'),
(341, 'RIGSON HERIANTO LUMBAN GAOL', '45224', 'jatiasih', 0, 0, NULL, '$2y$12$mQBN4QsDzRuCEnNOBjSPTup5mQBQcz.Dxil84Yal9dMAXBKRUvCHq', NULL, '2026-08-19 14:14:35', '2026-08-20 02:32:42', NULL, 'jatiasih'),
(342, 'INDRA HIDAYAT', '45426', 'cinere', 0, 0, NULL, '$2y$12$rBPNjkL93/k5L0aPH42I6.NYPN.NTHix4kgmwH7e.EYp0dw4Q7i0i', NULL, '2026-08-19 14:14:35', '2026-08-20 02:32:42', 'bm_sh', 'cinere'),
(343, 'JENAL LUDIN', '45427', 'cinere', 0, 0, NULL, '$2y$12$P712inrj71rdzgiTwocp3Ov4zBe.eAj3zh4LEl.VBFS9t9XATm2Ma', NULL, '2026-08-19 14:14:35', '2026-08-20 02:32:42', NULL, 'cinere'),
(344, 'ERNA NURAINI', '45428', 'cinere', 0, 0, NULL, '$2y$12$CwBRHPyJHch7z3ChAYa7IeFsOk/0qflt01O/BLOx6yOh/hKVRS31S', NULL, '2026-08-19 14:14:36', '2026-08-20 02:32:43', NULL, 'cinere'),
(345, 'ARIF HIDAYAT', '45430', 'cinere', 0, 0, NULL, '$2y$12$xvl9ILyk11nzDZgFVQBxWuu2euaisExJnV./pMzC54H9aIhkqNg4e', NULL, '2026-08-19 14:14:36', '2026-08-20 02:32:43', NULL, 'cinere'),
(346, 'YULIA AYU KURNIAWATI', '45433', 'cinere', 0, 0, NULL, '$2y$12$7zP1fHGs.U6cqho8C9ZUVup2uKpyjY7cQ9fjErqG6vVoiN65zpN12', NULL, '2026-08-19 14:14:36', '2026-08-20 02:32:43', NULL, 'cinere'),
(347, 'CHARIYANA', '45435', 'cinere', 0, 0, NULL, '$2y$12$KDryOUGOB96oTWWa6DAvS.u3Gi4mh37JJO3uzD4Q1EByzCtAQSwvW', NULL, '2026-08-19 14:14:37', '2026-08-20 02:32:44', NULL, 'cinere'),
(348, 'IRMAN HAMZAH', '45598', 'ciawi', 0, 0, NULL, '$2y$12$jdXQ25RuAIiypGZMFAin1.9MKGykwq3pqm12.fdMdk6rLx3dpWQyS', NULL, '2026-08-19 14:14:37', '2026-08-20 02:32:44', NULL, 'ciawi'),
(349, 'RUDI RAMDAN', '45599', 'cianjur', 0, 0, NULL, '$2y$12$hh6g7/Vo5HhlrQmpsELjIex/QJVaoH1Pfq7ZWeol7AgUVnL4Erqg2', NULL, '2026-08-19 14:14:37', '2026-08-20 02:32:45', NULL, 'cianjur'),
(350, 'DEDI SOPIAN', '45600', 'cianjur', 0, 0, NULL, '$2y$12$Qa5FoobrZwUzyS/bEEP7L.Gyxk7IXl3VyFPS9VbNUSMzxe62Bb/pO', NULL, '2026-08-19 14:14:37', '2026-08-20 02:32:45', NULL, 'cianjur'),
(351, 'RONALDO', '45601', 'jatiasih', 0, 0, NULL, '$2y$12$86iXlrXZcBKvcCiJrYB59.4KQzPYPXPoC7gnAYM8Rqaz4B1KJ9tOi', NULL, '2026-08-19 14:14:38', '2026-08-20 02:32:45', NULL, 'jatiasih'),
(352, 'WAN MUSA', '45603', 'jatiasih', 0, 0, NULL, '$2y$12$EdZoDDxFtHMggAL5bcuaB.0zh8mP.sPTMZGJIKGbWql5EPUoG/F0O', NULL, '2026-08-19 14:14:38', '2026-08-20 02:32:46', NULL, 'jatiasih'),
(353, 'MOHAMMAD ALI MAKI', '45605', 'jatiasih', 0, 0, NULL, '$2y$12$bnblzhi10BMJs9k1sUv5keV/9Du7GBPK4ACr7cUUmSeJahsQb7BDG', NULL, '2026-08-19 14:14:38', '2026-08-20 02:32:46', NULL, 'jatiasih'),
(354, 'JAELANI SIDIK', '45607', 'jatiasih', 0, 0, NULL, '$2y$12$gQax1GyNdtZqWjwF6NtvsOnJ7oDI0Qju1PRXbu3zUuKWG3B7/asza', NULL, '2026-08-19 14:14:39', '2026-08-20 02:32:46', NULL, 'jatiasih'),
(355, 'ADRIN PUTRA', '45608', 'jatiasih', 0, 0, NULL, '$2y$12$RyvFUJado7.BkOw36XHPmOyJFjeBBxO5.ZsASdQKkxPvh5OqiNGoC', NULL, '2026-08-19 14:14:39', '2026-08-20 02:32:47', NULL, 'jatiasih'),
(356, 'LIDIYANTI SUNARYA', '45628', 'cinere', 0, 0, NULL, '$2y$12$dF117DGcHOGh5L3rE3WgB.m04QcnuUAzXpsAffn3gR4AbRQuubgZa', NULL, '2026-08-19 14:14:39', '2026-08-20 02:32:47', NULL, 'cinere'),
(357, 'RIA LEO VITA', '45655', 'ciawi', 0, 0, NULL, '$2y$12$upwPbjiDRQKj4EbQfk1/mO6EyJZuYSDbNqTJl6ARteySN0wuTiX/K', NULL, '2026-08-19 14:14:39', '2026-08-20 02:32:47', NULL, 'ciawi'),
(358, 'KEMAS ISMET ZUELLY', '45728', 'jatiasih', 0, 0, NULL, '$2y$12$rqazhaGMfB9gB.S0pvXDf.N22bo28S/3JGEoxA2gyybw7QJZ5BEyq', NULL, '2026-08-19 14:14:40', '2026-08-20 02:32:48', NULL, 'jatiasih'),
(359, 'SIGIT ADY WIBOWO', '45943', 'jatiasih', 0, 0, NULL, '$2y$12$JZflbdmZsEXyQW6c3NXMcevD1cCou8Um8aL.t4B2y9iSKlrlxaklK', NULL, '2026-08-19 14:14:40', '2026-08-20 02:32:48', NULL, 'jatiasih'),
(360, 'HAFIDZ USMAN', '45945', 'cinere', 0, 0, NULL, '$2y$12$Ux8ZlRasQLCBTwv3iqwzR.eGO6aZ2wQA.ko6LvERGS.o95FSuQU8G', NULL, '2026-08-19 14:14:40', '2026-08-20 02:32:49', NULL, 'cinere'),
(361, 'Edi Supriyanta Sembiring', '45951', 'cinere', 0, 0, NULL, '$2y$12$trgM2h4fJdtOrnJxEmykq.jlYgtl6wr5N0wvMD6DsRmsWCOcqYPli', NULL, '2026-08-19 14:14:41', '2026-08-20 02:32:49', 'bm_sh', 'cinere'),
(362, 'DHANI FITRAH', '45966', 'jatiasih', 0, 0, NULL, '$2y$12$K68wy9SDyHA/zyWMEooK5.9qlPoawtU3xuSUX/5pXsLU65skz0G8W', NULL, '2026-08-19 14:14:41', '2026-08-20 02:32:49', NULL, 'jatiasih'),
(363, 'DIAN SEPTI', '45967', 'jatiasih', 0, 0, NULL, '$2y$12$4fpXoycxCHl4rNE/cMvaheR7qYZZm29ldsSR6cP7bOJcOSei/wzQ6', NULL, '2026-08-19 14:14:41', '2026-08-20 02:32:50', NULL, 'jatiasih'),
(364, 'LUKMAN DEWANTORO', '46045', 'cinere', 0, 0, NULL, '$2y$12$u18LfduN3skE6LGmotLkm.ruCxh/xbdVAYuEcLq74M4b.4jPTGegm', NULL, '2026-08-19 14:14:41', '2026-08-20 02:32:50', NULL, 'cinere'),
(365, 'ALVIAN APRILIAN SETIANTO', '46052', 'cinere', 0, 0, NULL, '$2y$12$ge2/ALdaoJvDd2yHhP3tJuRf1AdomNiimmZDAVq8HDh/D6lR1TonG', NULL, '2026-08-19 14:14:42', '2026-08-20 02:32:50', NULL, 'cinere'),
(366, 'ROBERT ENDO', '46064', 'jatiasih', 0, 0, NULL, '$2y$12$YVzY0z2glAmObKqTAXfoiu5UV0Mi8oNAAwVGKfOqv8B1RMvCA7g3O', NULL, '2026-08-19 14:14:42', '2026-08-20 02:32:51', NULL, 'jatiasih'),
(367, 'MUCHAMAD ABDAN SYAKURO', '46065', 'jatiasih', 0, 0, NULL, '$2y$12$VkkYucAIGOWMFAYsGJXkCexzSZRyGXRAHfriM/rt35tz0m5606lKa', NULL, '2026-08-19 14:14:42', '2026-08-20 02:32:51', NULL, 'jatiasih'),
(368, 'RIDWAN EKA PERDANA', '46066', 'jatiasih', 0, 0, NULL, '$2y$12$7hxlmOeaCT1mOUAobnlFp.6e4oTEdaNvErs0KiyZcgBVS.qFt3KMW', NULL, '2026-08-19 14:14:42', '2026-08-20 02:32:52', NULL, 'jatiasih'),
(369, 'GALIH HARIYANTO', '46067', 'jatiasih', 0, 0, NULL, '$2y$12$DhwEWmdVn2N/dnTRl/E7IelR9pnyCtAAuPcLBzI2VzfLVmlRsdbEu', NULL, '2026-08-19 14:14:43', '2026-08-20 02:32:52', NULL, 'jatiasih'),
(370, 'MOH TRI RAHARJO', '46068', 'jatiasih', 0, 0, NULL, '$2y$12$vf4IsPUZA2DMmMqPgg1Wfu/BFS9yTtjjC0A8hQ5gudt51CQXX7OGm', NULL, '2026-08-19 14:14:43', '2026-08-20 02:32:52', NULL, 'jatiasih'),
(371, 'ASWINDA NUR PRASETYA', '46190', 'cinere', 0, 0, NULL, '$2y$12$3RTQZzogCjlgdQIFP9TzZ.mH4nWThTB4fqr8rlQXtJxXrlnEKe2Ii', NULL, '2026-08-19 14:14:43', '2026-08-20 02:32:53', 'bm_sh', 'cinere'),
(372, 'NICO ALEXANDER', '46191', 'cinere', 0, 0, NULL, '$2y$12$SoYTI4HfGfPbNivlc6cTFeen0tQoeUa5cZQZvEfITd9RyJSFAQk0u', NULL, '2026-08-19 14:14:44', '2026-08-20 02:32:53', NULL, 'cinere'),
(373, 'MARLIA', '46192', 'cinere', 0, 0, NULL, '$2y$12$JBoKBwu9M6U.jb5PxCUXvOXGX3mqYNXU2ZHJO1ATB4v0wJhfvdHSW', NULL, '2026-08-19 14:14:44', '2026-08-20 02:32:53', NULL, 'cinere'),
(374, 'ALAN BAGUS WIJAYA', '46217', 'cianjur', 0, 0, NULL, '$2y$12$EMpTTAC9mBjSlYTfQziiCe86YK2iFNmscdQuce90gzuksLlqURWNS', NULL, '2026-08-19 14:14:44', '2026-08-20 02:32:54', NULL, 'cianjur'),
(375, 'RIZKY PAHLAWAN', '46218', 'cianjur', 0, 0, NULL, '$2y$12$2h4ownhPPnxBgUIN4etXdupnD0/rALGmdkQQdhjd/sQw76czV5uQa', NULL, '2026-08-19 14:14:45', '2026-08-20 02:32:54', NULL, 'cianjur'),
(376, 'RANI HERLINA', '46226', 'cianjur', 0, 0, NULL, '$2y$12$WrVNJFNst.IJ2zqpuFBHjOdnixFUe.NTA7czCKS.XKgaG59caYCoK', NULL, '2026-08-19 14:14:45', '2026-08-20 02:32:55', NULL, 'cianjur'),
(377, 'IWAN RIDWAN', '46227', 'cianjur', 0, 0, NULL, '$2y$12$oygcigd3KwoV3702hgQyO.YvB1cTpU.c04MvoFjGBiW02bG2Bq/am', NULL, '2026-08-19 14:14:45', '2026-08-20 02:32:55', NULL, 'cianjur'),
(378, 'FAISAL', '46228', 'cianjur', 0, 0, NULL, '$2y$12$UEmOvmkmvyrN6rEFy2Mej.QyGl4K8./BD/Qlp6q0TspfZBt/GWdnG', NULL, '2026-08-19 14:14:45', '2026-08-20 02:32:55', NULL, 'cianjur'),
(379, 'FUTI HATI', '46233', 'cinere', 0, 0, NULL, '$2y$12$NEdbU4JdgudIQLNqm6.3pOIS3ICFlx4K8NVOoPiaFv/0qbn46OS0m', NULL, '2026-08-19 14:14:46', '2026-08-20 02:32:56', NULL, 'cinere'),
(380, 'CICI NURHAYATI', '46234', 'cinere', 0, 0, NULL, '$2y$12$yCUsjceADv5/T1K7oNgwveKQbX65d28muTWnpIIuBHJqE8V8KCnSq', NULL, '2026-08-19 14:14:46', '2026-08-20 02:32:56', NULL, 'cinere'),
(381, 'FUJI NURUL INTAN', '46235', 'cinere', 0, 0, NULL, '$2y$12$09folgsD1YNdEUmev6DvO.sjlwat6CRxsMiRz7vUqk4UsVA9HGQGW', NULL, '2026-08-19 14:14:46', '2026-08-20 02:32:57', NULL, 'cinere'),
(382, 'EFA SEPTIANA', '46236', 'cinere', 0, 0, NULL, '$2y$12$sWLGXFR9cGpYTDMX7HfqfuVyF5x14JeGKqOl.VVMj/D9Sc.2bpl86', NULL, '2026-08-19 14:14:47', '2026-08-20 02:32:57', NULL, 'cinere'),
(383, 'LISTIA MARLIANA', '46237', 'cinere', 0, 0, NULL, '$2y$12$N7Adu50yQ.hZNnI25nE3feoaY35N5Y9wxixQAD9WW8JAmEXAcEs7i', NULL, '2026-08-19 14:14:47', '2026-08-20 02:32:57', NULL, 'cinere'),
(384, 'AGUNG BUDIONO', '46238', 'cinere', 0, 0, NULL, '$2y$12$w0F/rbEX6SoThkNMadKRL.12mODmyl2Oag/JIXOy.cOul4yx8T6O.', NULL, '2026-08-19 14:14:47', '2026-08-20 02:32:58', NULL, 'cinere'),
(385, 'HESTI SEPTIANTI', '46239', 'cinere', 0, 0, NULL, '$2y$12$CZI.e9oC.rwUkQbpnbcpF.lSJXB431ehyyFTi7Ga9.Aq1nEEdHE5W', NULL, '2026-08-19 14:14:47', '2026-08-20 02:32:58', NULL, 'cinere'),
(386, 'ABDUL FALAH DARAJAT', '46240', 'cinere', 0, 0, NULL, '$2y$12$AibYat0Yzke/PpfC8E/R/eWOrMqsCuMP8hEnwX.1Qgm4xZtwoJdJy', NULL, '2026-08-19 14:14:48', '2026-08-20 02:32:58', 'bm_sh', 'cinere'),
(387, 'GUNTUR PRASETIYO PRAYOGO', '46241', 'cinere', 0, 0, NULL, '$2y$12$6ldxheLYYkqkpZ0jDRvTEe/mdQ7tNU3HlPHfAa/i8JYIZPtSDXc9C', NULL, '2026-08-19 14:14:48', '2026-08-20 02:32:59', NULL, 'cinere'),
(388, 'MOCHAMAD REZA', '46242', 'cinere', 0, 0, NULL, '$2y$12$QUZXDRunJOQebcEgCOKDE.D40Nzsn8gR.LjUsaq7GT/ty2AKxDm52', NULL, '2026-08-19 14:14:48', '2026-08-20 02:32:59', NULL, 'cinere'),
(389, 'MUHAMMAD MAHBUB ABDULLAH', '46246', 'cinere', 0, 0, NULL, '$2y$12$gxDpjLbq8nbRS.3v2HVTg.tuuWNLCNEa2DTs1nN8XnP5fPYLJwaEu', NULL, '2026-08-19 14:14:49', '2026-08-20 02:33:00', NULL, 'cinere'),
(390, 'MUHAMAD DHANA RIZKY', '46247', 'cinere', 0, 0, NULL, '$2y$12$UknifA3ytO6X2an9yi8Rt.3gKTsheSc2RGEP9Q9KrqI3tDyT5qB5.', NULL, '2026-08-19 14:14:49', '2026-08-20 02:33:00', NULL, 'cinere'),
(391, 'REYHAND REYNALDI', '46248', 'cinere', 0, 0, NULL, '$2y$12$Ky9aeu0wTiT80pOcoxuuY.X7y/Fd55hrPQ.RARigPbYMsR01ZcF/.', NULL, '2026-08-19 14:14:49', '2026-08-20 02:33:00', NULL, 'cinere'),
(392, 'RIVABY SAPUTRI', '46249', 'cinere', 0, 0, NULL, '$2y$12$PwgqYFrVEOgYSsGNHwfu3e3C.ygVy4NrzWiT9e3MlZPjfYly8sA7W', NULL, '2026-08-19 14:14:49', '2026-08-20 02:33:01', NULL, 'cinere'),
(393, 'Erno Vita Maulana', '46250', 'ciawi', 0, 0, NULL, '$2y$12$69q.gIFGaHgFGkkEuoF3r.5/eV3Fz0NLPaHL/bKdSxC0BtNbB3RhG', NULL, '2026-08-19 14:14:50', '2026-08-20 02:33:01', NULL, 'ciawi'),
(394, 'Anggi Yusuf', '46251', 'ciawi', 0, 0, NULL, '$2y$12$8rYBvYx6QbKQROmHbjAtkOOYM2Q5nv3KB7pFLfNqs/h9WTEE6f9Xe', NULL, '2026-08-19 14:14:50', '2026-08-20 02:33:01', NULL, 'ciawi'),
(395, 'Ebi Resbiana', '46252', 'ciawi', 0, 0, NULL, '$2y$12$2zdyJXmgfMwMWiUuBoY1YuCQbhqvgbXR.v9LKpG/gnmt1TE1cFsKu', NULL, '2026-08-19 14:14:50', '2026-08-20 02:33:02', NULL, 'ciawi'),
(396, 'Dani Yusuf Nurdiansyah', '46253', 'cianjur', 0, 0, NULL, '$2y$12$u5dy2VgTd2cju/OV3t25y.ub2ryneJEplISMCkOO0wRl8JM8WWJwG', NULL, '2026-08-19 14:14:51', '2026-08-20 02:33:02', NULL, 'cianjur'),
(397, 'Yulia', '46254', 'cianjur', 0, 0, NULL, '$2y$12$WuXUj8bzi.d.7kL7gHvpL.aqSDOPJWxx2Xn88Vp7pTo2YL2omaWwC', NULL, '2026-08-19 14:14:51', '2026-08-20 02:33:03', NULL, 'cianjur'),
(398, 'Handi yuliandi', '46256', 'cianjur', 0, 0, NULL, '$2y$12$/cLEdCE9hMj1rvLrvd9FV.qZYXBB.tYosmlc4Feb0DJrer1ar7Lr2', NULL, '2026-08-19 14:14:51', '2026-08-20 02:33:03', NULL, 'cianjur'),
(399, 'FAUZI NUR ROCHMAN', '46274', 'jatiasih', 0, 0, NULL, '$2y$12$tZdp.kS7Y7PYzkGn5x4aAO71OStXWMxZ/S4H4ZDY6Fq/UbIJ7Gfaq', NULL, '2026-08-19 14:14:51', '2026-08-20 02:33:03', NULL, 'jatiasih'),
(400, 'CHRISTIAN ANDIKA MAMESAH', '46275', 'jatiasih', 0, 0, NULL, '$2y$12$ABIt84mp8emUzjSbs72pReasjUviSRDk0xeEtWkWLTVRZjZWLfXEe', NULL, '2026-08-19 14:14:52', '2026-08-20 02:33:04', NULL, 'jatiasih'),
(401, 'ULAN DARI', '46276', 'jatiasih', 0, 0, NULL, '$2y$12$mI0YaTmts5MqVH77NPtDO.vP9k.Lj6z4WGlEgSnjVRIRHglz4dVVi', NULL, '2026-08-19 14:14:52', '2026-08-20 02:33:04', NULL, 'jatiasih'),
(402, 'FARAH AGHNI AULIYANA', '46277', 'jatiasih', 0, 0, NULL, '$2y$12$zjJtLnI3YBRILFILRXmeae/vE0OpcnuZGiaPH2sNpJsBCgMu9TkmW', NULL, '2026-08-19 14:14:52', '2026-08-20 02:33:05', NULL, 'jatiasih'),
(403, 'NURHAYATI', '46278', 'jatiasih', 0, 0, NULL, '$2y$12$rg0Jz3F76zorGPbB7KVcMuuYQHCZ2rt2sl0NPqo0IE69NvCkVzjIG', NULL, '2026-08-19 14:14:52', '2026-08-20 02:33:05', NULL, 'jatiasih'),
(404, 'GUNAWAN TEGA SAGARA', '46279', 'jatiasih', 0, 0, NULL, '$2y$12$LChiMDJUIrjBI7O7XwmK4.tU2D.4kyzKPOFYxOWROMYS94CftSE3y', NULL, '2026-08-19 14:14:53', '2026-08-20 02:33:05', NULL, 'jatiasih'),
(405, 'RONI BUDIARTA', '46281', 'jatiasih', 0, 0, NULL, '$2y$12$qqeXcwl4VsLRZgCUqKfIBO4uKnocSLuNRgpeXazaN8IqICbUGxccG', NULL, '2026-08-19 14:14:53', '2026-08-20 02:33:06', NULL, 'jatiasih'),
(406, 'HAMDANI AGUSTRIANA', '46283', 'ciawi', 0, 0, NULL, '$2y$12$BoCYgFtiIjmjUJav6rXhLOLypRl.h15damErDHfDzr9Yz.Uv6bWE6', NULL, '2026-08-19 14:14:54', '2026-08-20 02:33:06', NULL, 'ciawi'),
(407, 'SITI WAHYUNI', '46284', 'ciawi', 0, 0, NULL, '$2y$12$dfNQho/7WhlSp9ziDvrbH.7lvi4V8LRel5zWdyiR984fWYe2mZATe', NULL, '2026-08-19 14:14:54', '2026-08-20 02:33:07', NULL, 'ciawi'),
(408, 'EKO YULIADI', '46302', 'ciawi', 0, 0, NULL, '$2y$12$T66YYQjIzfDcQqyg2IgVH.FUQZPxqt60RIxhipfyFEv0lcibTvCdS', NULL, '2026-08-19 14:14:54', '2026-08-20 02:33:07', NULL, 'ciawi'),
(409, 'DICKY ABDUL AZIZ', '46305', 'cianjur', 0, 0, NULL, '$2y$12$0nPLBw55J0yCicCGfA9y..05i6QePSI0/NoL9ZgJiA/zmQnKgupDa', NULL, '2026-08-19 14:14:54', '2026-08-20 02:33:07', NULL, 'cianjur'),
(410, 'DEDE RACHMAN', '46306', 'cianjur', 0, 0, NULL, '$2y$12$pa1X6AaTM0dk4dAp/V/rYum9qTSWJbmJjsJ9BXkuvFVwKBqzTQTkW', NULL, '2026-08-19 14:14:55', '2026-08-20 02:33:08', NULL, 'cianjur'),
(411, 'MUHAMAD RAMDAN', '46309', 'cianjur', 0, 0, NULL, '$2y$12$xZKHE2aHJfFvz4Rpi0Gmg.ijzCseOARZjEnzxosIUsZAJlOyeCogS', NULL, '2026-08-19 14:14:55', '2026-08-20 02:33:08', NULL, 'cianjur'),
(412, 'DENDI JAMES NELSEN YORGA', '46310', 'cianjur', 0, 0, NULL, '$2y$12$IzXmf9RuKz2rwbqf2bYz/utZ7OXn7CpjXc18mJq9d8W7DuMwXkMTO', NULL, '2026-08-19 14:14:55', '2026-08-20 02:33:08', NULL, 'cianjur'),
(413, 'PUTRI JULIA AGUSTIN', '46468', 'cinere', 0, 0, NULL, '$2y$12$aaz8GQAa4YJ89r1xdPokDuvzUTS0onsrWXOzv5PGlTnCzyMXmV0DG', NULL, '2026-08-19 14:14:55', '2026-08-20 02:33:09', NULL, 'cinere'),
(414, 'DEDE ARIS FADILLAH', '46469', 'cinere', 0, 0, NULL, '$2y$12$bWiMRyPYKsYX9fyNZu7.5O/mB/AApbqmlPj4qGSXlqAefPEL76NBO', NULL, '2026-08-19 14:14:56', '2026-08-20 02:33:09', NULL, 'cinere'),
(415, 'PUJI SUGIARTO', '47562', 'jatiasih', 0, 0, NULL, '$2y$12$LPw.YKWwTFWizIXGkSGvbOH6wyRHtj4tl6GcfkzRAHxX1905EvEt6', NULL, '2026-08-19 14:14:56', '2026-08-20 02:33:10', NULL, 'jatiasih'),
(416, 'ALI MASKURI', '47563', 'jatiasih', 0, 0, NULL, '$2y$12$sHBuUcFsjOtqR40aDlrpdujcTHUd0hPZrcfwNYT7kSOlAeEpUiAG6', NULL, '2026-08-19 14:14:56', '2026-08-20 02:33:10', NULL, 'jatiasih'),
(417, 'ROMINTON GABARIAL HUTAGALUNG, AMD', '47564', 'jatiasih', 0, 0, NULL, '$2y$12$UewEEkuxp/xqN3ayBC3mhOhJphpj2ZgcHYcFqXeqfTkN3deF1pVI.', NULL, '2026-08-19 14:14:57', '2026-08-20 02:33:10', NULL, 'jatiasih'),
(418, 'DICKY MAULINA', '47565', 'jatiasih', 0, 0, NULL, '$2y$12$0xZtyAEWAWeMqQ5YNZ7IM.Pb6cxbvNyHZTpr46VTFFxnI0JrbfXZK', NULL, '2026-08-19 14:14:57', '2026-08-20 02:33:11', NULL, 'jatiasih'),
(419, 'KUSOMO TRI PAMUNGKAS', '47567', 'jatiasih', 0, 0, NULL, '$2y$12$H5OVlhsBjiDG9SOTTF384elhMY3KUWQoWhWjumthgIzmkW.eQERqG', NULL, '2026-08-19 14:14:57', '2026-08-20 02:33:11', NULL, 'jatiasih'),
(420, 'HERI PRASETYO', '47568', 'jatiasih', 0, 0, NULL, '$2y$12$.HkfjXfPANglSnv8jS6v4uwGU7jo9Zq23bjL.r.VVUXN3IKTWDsui', NULL, '2026-08-19 14:14:57', '2026-08-20 02:33:11', NULL, 'jatiasih'),
(421, 'SUHENDRO', '47573', 'cinere', 0, 0, NULL, '$2y$12$LH/jTUX51W5PsLLk4wgkf.q7InfubX7C6FGmdZNS5ukfSvSC30jmq', NULL, '2026-08-19 14:14:58', '2026-08-20 02:33:12', 'bm_sh', 'cinere'),
(422, 'DEDE ISKANDAR', '47606', 'cinere', 0, 0, NULL, '$2y$12$ZzM9DCi7wQYgWddgUB5EEuxSQtQmUMu1nd3ScEVAgBU0PIEUiqk3q', NULL, '2026-08-19 14:14:58', '2026-08-20 02:33:12', NULL, 'cinere'),
(423, 'AWAL LUTHAN', '47973', 'cianjur', 0, 0, NULL, '$2y$12$Rw4gAx7PBtvhF8LkDMuLtOkUGFzpdl59Xukglt8WRz5d3kkvUL/r2', NULL, '2026-08-19 14:14:59', '2026-08-20 02:33:13', 'bm_sh', 'cianjur'),
(424, 'INTAN LESTARI', '47986', 'cianjur', 0, 0, NULL, '$2y$12$eFX/vDc.UbpJNcK2OXCn7.ss0CUbprmidPJVAaY03kGlaihqfDwd2', NULL, '2026-08-19 14:14:59', '2026-08-20 02:33:13', NULL, 'cianjur'),
(425, 'R. EGA FALAH PRAYOGA', '47987', 'cianjur', 0, 0, NULL, '$2y$12$rDzue5zySlLn6invltdGzOEp5SVfnM9nqaZuvwCSyGSYSTqT0Qm3C', NULL, '2026-08-19 14:14:59', '2026-08-20 02:33:14', NULL, 'cianjur'),
(426, 'FIZAI ZELI SUSILAWAN', '47988', 'cianjur', 0, 0, NULL, '$2y$12$Zt1v4zxJS4hJdxeD9epTzOJlDR3phkWvJH1IyitYfl4Il4GmyzKOW', NULL, '2026-08-19 14:14:59', '2026-08-20 02:33:14', NULL, 'cianjur'),
(427, 'ARYA RANGGA WULUNG', '47989', 'cianjur', 0, 0, NULL, '$2y$12$EzZFtGVJi2AUQXaooq5T4e0IfklX3E/pm4Yg2yCf6.2ESWokkLDz6', NULL, '2026-08-19 14:15:00', '2026-08-20 02:33:14', NULL, 'cianjur'),
(428, 'Deny', '47996', 'ciawi', 0, 0, NULL, '$2y$12$0oVdcOygyMN7Wu4O17fjmO6IXk2gc2J7fmHqs.OYXHIsYM28qZfqa', NULL, '2026-08-19 14:15:00', '2026-08-20 02:33:15', NULL, 'ciawi'),
(429, 'GALIH KURNIAWAN', '48086', 'jatiasih', 0, 0, NULL, '$2y$12$hLFcxfsXNfGp9Iw9CvPE1eohl6lS2M/5IIvnlT/RQ8Dka/Tzo7mD6', NULL, '2026-08-19 14:15:00', '2026-08-20 02:33:15', NULL, 'jatiasih'),
(430, 'YEHU WIDODO', '48087', 'jatiasih', 0, 0, NULL, '$2y$12$kS7h3gMf.5MPCt9ykBWyS.OF24LkUyMxol3OS8QeIGgnoo1LN/htO', NULL, '2026-08-19 14:15:01', '2026-08-20 02:33:15', NULL, 'jatiasih'),
(431, 'FIKI HAPIPA', '48090', 'cinere', 0, 0, NULL, '$2y$12$O5irn4gU8pkDGA9Uy.Z1Uuj4VnMRDFeaa8ELUP8skCgZ2Xfrzvgta', NULL, '2026-08-19 14:15:01', '2026-08-20 02:33:16', NULL, 'cinere'),
(432, 'SITI SUSILAWATI', '48464', 'cianjur', 0, 0, NULL, '$2y$12$6ydHLLljZT7B0xiyjs36BOHF/UfSzWs500mHV2bx6OkqBtCME.vN.', NULL, '2026-08-19 14:15:01', '2026-08-20 02:33:16', NULL, 'cianjur'),
(433, 'LUKMAN ASHARI', '48467', 'cianjur', 0, 0, NULL, '$2y$12$W4Foz.Nme9/OE7fWBAlj4u2zjTaZY4nEJEJE4BfwVUi6x1HBVG6im', NULL, '2026-08-19 14:15:01', '2026-08-20 02:33:16', NULL, 'cianjur'),
(434, 'WAHYU MAESUL', '48469', 'cianjur', 0, 0, NULL, '$2y$12$RvxpmphrIp9vuPARF8Uu4Oq9.VJbHLNUTXj2vXiZ5xlVufOzJTKaq', NULL, '2026-08-19 14:15:02', '2026-08-20 02:33:17', NULL, 'cianjur'),
(435, 'YOPI CHANDRA GINTING', '48774', 'jatiasih', 0, 0, NULL, '$2y$12$0BqIUQmpoD3HxlHHCCR53uuKBNGEE4THloQUfJAvU7Ef5vdARbjYy', NULL, '2026-08-19 14:15:02', '2026-08-20 02:33:17', NULL, 'jatiasih'),
(436, 'ARIF MUJIANTO', '48775', 'jatiasih', 0, 0, NULL, '$2y$12$.Z90T7P7gLfUnGagy.mevezmCVqfeZ6lrFTH2FqxRYL4zpvjQSmxS', NULL, '2026-08-19 14:15:02', '2026-08-20 02:33:17', NULL, 'jatiasih'),
(437, 'DIANA CHARLES PURWADI', '48776', 'jatiasih', 0, 0, NULL, '$2y$12$TZj21R1uD9Xn8Z6cCS3M3OWWkJ81mhcbqnwrypqhlQ4TTwjT5m.X.', NULL, '2026-08-19 14:18:05', '2026-08-20 02:33:18', NULL, 'jatiasih'),
(438, 'SIDIK WASKITO', '48779', 'jatiasih', 0, 0, NULL, '$2y$12$js8sSVkx9TFKs3rjYL5VcuUOKg0Slxxf8uB2CTGrLTRLN3UQFVNgq', NULL, '2026-08-19 14:18:06', '2026-08-20 02:33:18', NULL, 'jatiasih'),
(439, 'ANGGI MUHAMMAD SAMSUDIN', '48812', 'cianjur', 0, 0, NULL, '$2y$12$7JdBterZkaT7rsI/lwezaew1wgGcsNHsjhT3V6Y013FYzpd3kuMzm', NULL, '2026-08-19 14:18:06', '2026-08-20 02:33:19', NULL, 'cianjur'),
(440, 'SANTI NOVIANTI', '48813', 'cianjur', 0, 0, NULL, '$2y$12$3nvjVsfCBwCUk5VsGQL8BOMjTvpCdtfudHyUyhE/AG9d8jUE4f3fi', NULL, '2026-08-19 14:18:06', '2026-08-20 02:33:19', NULL, 'cianjur'),
(441, 'NENTI SUNENTI', '48814', 'cianjur', 0, 0, NULL, '$2y$12$BzkoF0LyptSxlVZ94kkK6.p5A/MvIc5exFYduUCaHR1mJ3mwBJ.cG', NULL, '2026-08-19 14:18:06', '2026-08-20 02:33:19', NULL, 'cianjur'),
(442, 'MUHAMMAD FAUZI', '48824', 'cinere', 0, 0, NULL, '$2y$12$YrG4r1.l8Vowr16piFIbGuoMpdaifL0sT0C5fdJu.iWQ6cL05jdx.', NULL, '2026-08-19 14:18:07', '2026-08-20 02:33:20', NULL, 'cinere'),
(443, 'RIZKI UBAIDILLAH', '48876', 'ciawi', 0, 0, NULL, '$2y$12$mQrcUxtBSTTaEoP4AU04Z.YzrVmU8N32FjK3jK1cye0C9mRJkdtOu', NULL, '2026-08-19 14:18:07', '2026-08-20 02:33:20', NULL, 'ciawi'),
(444, 'SANTOSA RAHARDIN', '48877', 'ciawi', 0, 0, NULL, '$2y$12$.IA/PkscZYAszyk1QBVQtu8liwIjDA.KjeDPT3OUV79xxfGMtTFCu', NULL, '2026-08-19 14:18:07', '2026-08-20 02:33:20', NULL, 'ciawi'),
(445, 'Teddy Sutanto, SH', '49203', 'ciawi', 0, 0, NULL, '$2y$12$Q70KnCpw1kGME3KHspOCVuCHD43XKV9zs5GolX2zFIcN.JUFM9gZW', NULL, '2026-08-19 14:18:08', '2026-08-20 02:33:21', NULL, 'ciawi'),
(446, 'Dedi Setiadi', '49206', 'ciawi', 0, 0, NULL, '$2y$12$2MaMUKyYbkeEPIO/Snclj.rafJ88x7j10tIpIrPj2SRVMkPH5/7LS', NULL, '2026-08-19 14:18:08', '2026-08-20 02:33:21', NULL, 'ciawi'),
(447, 'Sem Charles Purwadi', '49207', 'ciawi', 0, 0, NULL, '$2y$12$FcuFqJN1jN8n9FeNAqs36uQFZuo8vkEU.sfERB7ytAHROwMNx4OIi', NULL, '2026-08-19 14:18:08', '2026-08-20 02:33:21', NULL, 'ciawi'),
(448, 'Achmad Faisal Taruna', '49210', 'ciawi', 0, 0, NULL, '$2y$12$ot9QHJ/ZxWaaMaRnax6oeeW2rozHf1cO0NyIbcfHcOFlx45KLJ16i', NULL, '2026-08-19 14:18:08', '2026-08-20 02:33:22', NULL, 'ciawi'),
(449, 'DIAR RAHMAT SE', '49248', 'ciawi', 0, 0, NULL, '$2y$12$W8n3Z.6WppukuqANYBrVR.TrYZK5LewDiO8yLcFt5Dhej0voQb8dm', NULL, '2026-08-19 14:18:09', '2026-08-20 02:33:22', NULL, 'ciawi'),
(450, 'SANDHIKA ANUGRAH', '49249', 'ciawi', 0, 0, NULL, '$2y$12$aAPFKJLNIbtNFVHjFWIRL.ifmZWg0o47lUHSUzORfMD4r5eKqZTlu', NULL, '2026-08-19 14:18:09', '2026-08-20 02:33:22', NULL, 'ciawi'),
(451, 'TIRTA MASLOMAN', '49250', 'jatiasih', 0, 0, NULL, '$2y$12$cpeo39VCG6Gv.MhWshGb3eTklhME9RinxCAV6E2BsgDZ65yoPo/SK', NULL, '2026-08-19 14:18:09', '2026-08-20 02:33:23', NULL, 'jatiasih'),
(452, 'ADITYA OCTORA', '49251', 'jatiasih', 0, 0, NULL, '$2y$12$yCiUr3Ks1JZxnqwW5PrOoeGiTPLBnpuiWETTXPsWCRcicL3eox6xK', NULL, '2026-08-19 14:18:10', '2026-08-20 02:33:23', NULL, 'jatiasih'),
(453, 'BEBALAZI ZENDRATO', '49634', 'cinere', 0, 0, NULL, '$2y$12$6NNaoMsZe5S8GNWFVQbjS.9godg2sYjL5ePXlAUAzU2AQ/8GFvtam', NULL, '2026-08-19 14:18:10', '2026-08-20 02:33:24', NULL, 'cinere'),
(454, 'M. FIO ANTOMI', '49798', 'cinere', 0, 0, NULL, '$2y$12$pWa2wsmcdOfaoGyS7/cXm.K21WIqp4z8blHuLKY9Mp9ld.eP7NVEu', NULL, '2026-08-19 14:18:10', '2026-08-20 02:33:24', NULL, 'cinere'),
(455, 'YUDHI KURNIAWAN', '49799', 'cinere', 0, 0, NULL, '$2y$12$9LULzW7JbOsmB7Cnl8pufumZ1AW0nQNPoJASz5w3bDDcFYigFg1CW', NULL, '2026-08-19 14:18:11', '2026-08-20 02:33:25', NULL, 'cinere'),
(456, 'NOVRIZAL BATUBARA', '49800', 'cinere', 0, 0, NULL, '$2y$12$4EWjfbCYovV5dR.qOJwnhOqo9D/.o5lRklReMV88qBXoLaFGz/vVG', NULL, '2026-08-19 14:18:11', '2026-08-20 02:33:25', NULL, 'cinere'),
(457, 'ANDI PRAKOSO', '49801', 'cinere', 0, 0, NULL, '$2y$12$nMwtj7crF0H5ipjIynmrle82DYWnrsWEa/FL3nMlIV7HtYLV9cZW6', NULL, '2026-08-19 14:18:11', '2026-08-20 02:33:25', NULL, 'cinere'),
(458, 'Yohanes Budi H.B. Tumangken', '49802', 'cinere', 0, 0, NULL, '$2y$12$AOkPzHLWPhe9PSkoV.W.O.n.MojA8sjw/qj4KAjWr4LN8usL9lUUS', NULL, '2026-08-19 14:18:12', '2026-08-20 02:33:26', NULL, 'cinere'),
(459, 'SITI AMINAH', '49803', 'jatiasih', 0, 0, NULL, '$2y$12$hvdVINWcn1XDVWYHsfSKKeWjkfCXgcYqegklX6l28LaGukwHINsbi', NULL, '2026-08-19 14:18:12', '2026-08-20 02:33:26', NULL, 'jatiasih'),
(460, 'DEDI MAULANA', '49921', 'ciawi', 0, 0, NULL, '$2y$12$KW4oBFW6E6yWFt65J/CTNeqjyuz3u.Z86kYXmVIIdt1w7h8acYk3m', NULL, '2026-08-19 14:18:12', '2026-08-20 02:33:26', NULL, 'ciawi'),
(461, 'ARIA BHARATA, S.E', '50148', 'cipanas', 0, 0, NULL, '$2y$12$X/Tz.JgS4S7ZbvQ4ZW4nturMyeoNCz4/dx1a3TRYKUR9iWyOIvSB.', NULL, '2026-08-19 14:18:12', '2026-08-20 02:33:27', 'bm_sh', 'cipanas'),
(462, 'SUGIYATNO', '50149', 'jatiasih', 0, 0, NULL, '$2y$12$ek3RAcgmwbbGb7GBATbHMudUkNgR/HG1kZLIDhGlxqry6xSdEM2yy', NULL, '2026-08-19 14:18:13', '2026-08-20 02:33:27', NULL, 'jatiasih'),
(463, 'DIMAS EKA PUTRA', '50150', 'jatiasih', 0, 0, NULL, '$2y$12$9CWKY2zmLVwbKze5hvonr.7cOMmQTpwnmpGQB9ms.9gEmadPcBFqO', NULL, '2026-08-19 14:18:13', '2026-08-20 02:33:27', NULL, 'jatiasih'),
(464, 'RIZKI AWALUDIN', '50151', 'ciawi', 0, 0, NULL, '$2y$12$xigwKaAMN5vHDLFnttVcVesmNaZ6zIqc.bW5bpHm8aNwVakkCxSXK', NULL, '2026-08-19 14:18:13', '2026-08-20 02:33:28', NULL, 'ciawi'),
(465, 'HILDA UTAMI FIRDAUS', '50152', 'ciawi', 0, 0, NULL, '$2y$12$g5R27J8M8lC94NczUECcRe9hs1y9RxreFTzgSdQTZ9CV1jVcMtvTS', NULL, '2026-08-19 14:18:14', '2026-08-20 02:33:28', NULL, 'ciawi'),
(466, 'WAWAN PRASETYO', '50154', 'ciawi', 0, 0, NULL, '$2y$12$3A1nFCNFxGWITH8lT6.Ft.Ne8lVlw.JS2Jx1bIai05RyJ2zxD1.EK', NULL, '2026-08-19 14:18:14', '2026-08-20 02:33:29', NULL, 'ciawi'),
(467, 'WENO AULIA', '50313', 'ciawi', 0, 0, NULL, '$2y$12$25ko4TRz0zRZdJunTg9ZVehh8jvmsViDd4b2DWQDui1k7qqcBJsSu', NULL, '2026-08-19 14:18:14', '2026-08-20 02:33:29', NULL, 'ciawi'),
(468, 'JARKASIH', '50314', 'ciawi', 0, 0, NULL, '$2y$12$srmePiIi5JsqxPxdZ8V7POffzbkKLmDq15TOW2//LejSIyRhUZ3QO', NULL, '2026-08-19 14:18:15', '2026-08-20 02:33:30', NULL, 'ciawi'),
(469, 'R. Nurma Aspiasari', '50712', 'ciawi', 0, 0, NULL, '$2y$12$mnD9A7P8qN2WIZ3rHYf83u/AlZoVyK.WBHfFIgl7v9s.6MmV906ju', NULL, '2026-08-19 14:18:15', '2026-08-20 02:33:30', NULL, 'ciawi'),
(470, 'SUWARSA MADHANI', '50716', 'ciawi', 0, 0, NULL, '$2y$12$ZWkLidvV2kILdcInoWp0weZf0li4hRIE9aAwHmtF.UDD3K7Cd/nKO', NULL, '2026-08-19 14:18:15', '2026-08-20 02:33:30', NULL, 'ciawi'),
(471, 'NURDIN', '50717', 'ciawi', 0, 0, NULL, '$2y$12$B.4s0v9aE5.aCWGpD8SgLOWlpVPPwmFXZznY/Zg8c5VfksrPgNR6q', NULL, '2026-08-19 14:18:16', '2026-08-20 02:33:31', NULL, 'ciawi'),
(472, 'Ilham Heru Maulana', '50823', 'ciawi', 0, 0, NULL, '$2y$12$hFU6.fvzHYAWxAtcpeuXAOnIdyFMnNhsgCJ/T3t.RQAup2MYt66iO', NULL, '2026-08-19 14:18:16', '2026-08-20 02:33:31', NULL, 'ciawi'),
(473, 'MUHAMAD RUSLAN', '50909', 'cianjur', 0, 0, NULL, '$2y$12$IfNg4jmhXdA/AxzlSDp6.edEORj/Xqx1oFcAuDiaKdZn4KVAGvhPS', NULL, '2026-08-19 14:18:16', '2026-08-20 02:33:31', NULL, 'cianjur'),
(474, 'DEVI MULYANA', '50916', 'cianjur', 0, 0, NULL, '$2y$12$M6y5Ma6159V79faheA9ci.cBXNcPIJwCuyT8XzWWwsjgb3JsAZTH2', NULL, '2026-08-19 14:18:16', '2026-08-20 02:33:32', NULL, 'cianjur'),
(475, 'ARI SUPRIANTO', '50939', 'ciawi', 0, 0, NULL, '$2y$12$s/bd11s18yFa.0khqsJ4ieJ5J4IH6LhGXdk46mStsiDm.kXUKd3EG', NULL, '2026-08-19 14:18:17', '2026-08-20 02:33:32', NULL, 'ciawi'),
(476, 'HILMAN ZIHNI SEPTIAN', '50998', 'ciawi', 0, 0, NULL, '$2y$12$.ArMdzzluTXjCEKNCPZ2AOuCkiGAS82pqlOOK9ns3.IO4bG79Plku', NULL, '2026-08-19 14:18:17', '2026-08-20 02:33:32', NULL, 'ciawi'),
(477, 'YUDHA SATRIA PERMANA', '50999', 'ciawi', 0, 0, NULL, '$2y$12$yTbznIhLa4VPqmoQKj8QOu1gEhX0VVya9oMJQA4evH9SXJ6n5g5je', NULL, '2026-08-19 14:18:17', '2026-08-20 02:33:33', NULL, 'ciawi'),
(478, 'R ZULYANDRI', '51042', 'jatiasih', 0, 0, NULL, '$2y$12$Ut.PyOu2OEZOkKaTEco89eUJqVYV0PGRLmx138sOvTc5/u0Cf.ueG', NULL, '2026-08-19 14:18:17', '2026-08-20 02:33:33', NULL, 'jatiasih'),
(479, 'ERWIN ZULKARNAEN', '51043', 'jatiasih', 0, 0, NULL, '$2y$12$yMqeSaMwuF5/WjevXrjp0.QrfoXFf3fQcT3WGiW/t9Jw49RTGC0pe', NULL, '2026-08-19 14:18:18', '2026-08-20 02:33:34', NULL, 'jatiasih'),
(480, 'RAVI AKBAR', '51044', 'jatiasih', 0, 0, NULL, '$2y$12$QpO.LvOojD6Uz4wu3TNkH.CPI4s94zD47Djeaahjd0yBLXB7707.q', NULL, '2026-08-19 14:18:18', '2026-08-20 02:33:34', NULL, 'jatiasih'),
(481, 'DWI MELYYANAH PUTRI', '51046', 'jatiasih', 0, 0, NULL, '$2y$12$fFCIvVS59Cx8VhBrTzy9H.L8X95gjbAcUmEu9xh749W2jgWxBQbeu', NULL, '2026-08-19 14:18:18', '2026-08-20 02:33:34', NULL, 'jatiasih'),
(482, 'Angga  Dwi Saputra', '51086', 'ciawi', 0, 0, NULL, '$2y$12$bv5LJH3/Hb12BKthDE0HRe9DfMXNr3Tn.XhvBwt2NfDjMfXEgmbDW', NULL, '2026-08-19 14:18:19', '2026-08-20 02:33:35', NULL, 'ciawi'),
(483, 'ENDANG NAJMUDIN', '51749', 'cianjur', 0, 0, NULL, '$2y$12$35t0eVb5hh/Hee2RvDFyHe79OAVTQ4EumY9xohiCAVpcaT0qAthee', NULL, '2026-08-19 14:18:19', '2026-08-20 02:33:35', NULL, 'cianjur'),
(484, 'DIAR RAHMAT', '51955', 'ciawi', 0, 0, NULL, '$2y$12$rWY7J/AvZ3./dGfArzd/TOf6XreKqwiDvv3yaqUULGFv/uZaoA0O6', NULL, '2026-08-19 14:18:19', '2026-08-20 02:33:36', NULL, 'ciawi'),
(485, 'MUHAMMAD SYAHWANI', '51956', 'ciawi', 0, 0, NULL, '$2y$12$xM1LWU02QeKmUjmBpZVLSOPVqjM7PYfiu.9D6TwNQE166wz.xrFNS', NULL, '2026-08-19 14:18:20', '2026-08-20 02:33:36', NULL, 'ciawi'),
(486, 'MUHAMAD IDRIS', '51957', 'ciawi', 0, 0, NULL, '$2y$12$JRE2c2cvTrkdw.OUXM8Pq.f9zU8kliq6ACV4ewXrf2ag6z.gM1wli', NULL, '2026-08-19 14:18:20', '2026-08-20 02:33:37', NULL, 'ciawi'),
(487, 'RIKI APRIATNA', '51958', 'ciawi', 0, 0, NULL, '$2y$12$45jYCfMUvsBeEgyFNzzYR.ACt1iHxMtT3VjPDUxtQRLALZRUPG/M2', NULL, '2026-08-19 14:18:20', '2026-08-20 02:33:38', NULL, 'ciawi'),
(488, 'MUSLIM', '51973', 'cinere', 0, 0, NULL, '$2y$12$LUOwEszUEZ08lDo5TkWef.FLqpuM/7n39Y/YXtb2obLa0U6fqs1/q', NULL, '2026-08-19 14:18:21', '2026-08-20 02:33:38', NULL, 'cinere'),
(489, 'ALDO YOGASMARA', '52064', 'cianjur', 0, 0, NULL, '$2y$12$sSr.KOWZgvoXy/str5F9XORRraQL/Du4iNaEen8xH7KMR.OLzv7xC', NULL, '2026-08-19 14:18:21', '2026-08-20 02:33:39', NULL, 'cianjur'),
(490, 'MUHTAR PARIDZ KAMIL', '52069', 'cianjur', 0, 0, NULL, '$2y$12$1eGkrc46PwPx2RSztMfKneyNpUEXbzfJuuO0vBiJV378a5pIB0HC.', NULL, '2026-08-19 14:18:21', '2026-08-20 02:33:39', NULL, 'cianjur'),
(491, 'DEDY SURATMAN', '52185', 'ciawi', 0, 0, NULL, '$2y$12$S83J.ah/jtewMgA94e42G.Wf47mcrHk8H0qVQtzb.rdXO3fcZEsE.', NULL, '2026-08-19 14:18:21', '2026-08-20 02:33:40', NULL, 'ciawi'),
(492, 'BONI DONO NUGROHO', '52189', 'cinere', 0, 0, NULL, '$2y$12$5bJf5zcW8Kurx1ZQlYy5..pkhCHkZ9lMTEQs6E3oaMJwDwlPx4Ocq', NULL, '2026-08-19 14:18:22', '2026-08-20 02:33:42', NULL, 'cinere'),
(493, 'ARIFIN', '52287', 'cinere', 0, 0, NULL, '$2y$12$cQoGrGUEJfJAO9fZPn.n0OOynpSr94Y2gSRlSoouaFGqX8CeKVF5u', NULL, '2026-08-19 14:18:22', '2026-08-20 02:33:42', 'bm_sh', 'cinere'),
(494, 'ARIO SEPTO SATRIO', '52288', 'cinere', 0, 0, NULL, '$2y$12$uY9epmIYdD/E8ruazA5S/ekCL79u0E/X8CNaEJBl5Mfu0eNFgjTCe', NULL, '2026-08-19 14:18:22', '2026-08-20 02:33:43', NULL, 'cinere'),
(495, 'Syarifatul Alawiyah', '52330', 'cinere', 0, 0, NULL, '$2y$12$tdC95bwpPYAyQ7ZRdrb3n.YU0YxaQ/M/g5qPx0u1T2T37.xUzyuWK', NULL, '2026-08-19 14:18:23', '2026-08-20 02:33:44', NULL, 'cinere'),
(496, 'LIANOV', '52501', 'jatiasih', 0, 0, NULL, '$2y$12$wJI0Wd.o3nI9CMSc5yJv5e.UxJNFh/oCKhZzXlom7n726V06y3hbC', NULL, '2026-08-19 14:18:23', '2026-08-20 02:33:45', NULL, 'jatiasih'),
(497, 'Amelia lestari', '52520', 'cinere', 0, 0, NULL, '$2y$12$nGJkf.hrOsij0I/.FSnJPeUxHeNPMygY7SAdSoo3CkImilzbSpECi', NULL, '2026-08-19 14:18:23', '2026-08-20 02:33:45', NULL, 'cinere'),
(498, 'DEA DELIANA HADI KUSUMAH', '52570', 'jatiasih', 0, 0, NULL, '$2y$12$CRDUUTKk2yvEx778LJPYo.B/ZGZMDgvNQPJkE6b8ptTRsJM0LWwJC', NULL, '2026-08-19 14:18:24', '2026-08-20 02:33:46', NULL, 'jatiasih'),
(499, 'DIMAS ARYA ALPONSO', '52571', 'jatiasih', 0, 0, NULL, '$2y$12$/v4URTCQEj2IJ0esX1ST0e9.auKLo0Of.d6vWnmUGrKTvF2GdLPLu', NULL, '2026-08-19 14:18:24', '2026-08-20 02:33:46', NULL, 'jatiasih'),
(500, 'NOVITA SARI', '52572', 'jatiasih', 0, 0, NULL, '$2y$12$3759q7reu6fxzFzoqiPJpu6UMsMPmsCdDP39LFjrkQgQwq77ZllVG', NULL, '2026-08-19 14:18:24', '2026-08-20 02:33:47', NULL, 'jatiasih'),
(501, 'Amelia Jei Nagaria', '52630', 'ciawi', 0, 0, NULL, '$2y$12$XNIzMu/sUDXz/ZbD4mOfWeg0P4m7jGLasE1n5A2X6YXMHtvkkFdv.', NULL, '2026-08-19 14:18:24', '2026-08-20 02:33:47', NULL, 'ciawi'),
(502, 'Mutia Wulandari', '53100', 'ciawi', 0, 0, NULL, '$2y$12$DG9fG1YdHPSg3aguaVdGZevx2QYDOSF7lMgfOgNO6gVHXx1ikCpWq', NULL, '2026-08-19 14:18:25', '2026-08-20 02:33:48', 'bm_sh', 'ciawi'),
(503, 'RUPIKA ENDAH', '53236', 'ciawi', 0, 0, NULL, '$2y$12$PeMIk8kiYo3PhVCM7lcMreeTHQ51S1hKXU4ny2r6lAYTupHMpEuyG', NULL, '2026-08-19 14:18:25', '2026-08-20 02:33:48', NULL, 'ciawi'),
(504, 'Marjoni, SE', '53248', 'cinere', 0, 0, NULL, '$2y$12$C0XygKYI1viVfd7m65NhVuJmpAiT1Cj4ap.RR3S.dIeKsiyUk.3cm', NULL, '2026-08-19 14:18:25', '2026-08-20 02:33:48', 'bm_sh', 'cinere'),
(505, 'MEVIY PERMANASARI', '53523', 'cinere', 0, 0, NULL, '$2y$12$Lk9HVC3Go9KV.mMJ8qkede4CVEMLbZg2dxXvMbBpZP8hBZLzIdsG.', NULL, '2026-08-19 14:18:26', '2026-08-20 02:33:48', NULL, 'cinere'),
(506, 'Agus setiawan', '53533', 'cinere', 0, 0, NULL, '$2y$12$n6AGDUPdh.s3iEYWSJgErOnCVG.4ruW4DY.gfOVJjeo7NkHSqrEKC', NULL, '2026-08-19 14:18:26', '2026-08-20 02:33:49', NULL, 'cinere'),
(507, 'WASIS SUPRIATNO', '53792', 'cianjur', 0, 0, NULL, '$2y$12$WvtdPdpz19O3.2RMDfJAN.BVJaGNUhCbQUlui059LHI/8.Bt3s1zi', NULL, '2026-08-19 14:18:26', '2026-08-20 02:33:49', NULL, 'cianjur'),
(508, 'MESA SOPIAN', '53793', 'cianjur', 0, 0, NULL, '$2y$12$Gbc2JjAbpOVzys0MvhV7JOhNHR00ASU/CCTNfeE9Ir/w5JIrW.6UK', NULL, '2026-08-19 14:18:26', '2026-08-20 02:33:49', NULL, 'cianjur'),
(509, 'IRPAN MAULANA NURMUIZ', '53794', 'cianjur', 0, 0, NULL, '$2y$12$EcHkIrnDmS1NawSyL8h.EeOzuZi72JHIP.MSdogiR9sRRx2.ph61.', NULL, '2026-08-19 14:18:27', '2026-08-20 02:33:50', NULL, 'cianjur'),
(510, 'SANDI SOPIAN', '53795', 'cianjur', 0, 0, NULL, '$2y$12$LXNQ0JsSQ39QpTzFTh2T9.i7ljdp5SECDgN52JDDa.QDdGwoViVGW', NULL, '2026-08-19 14:18:27', '2026-08-20 02:33:51', NULL, 'cianjur'),
(511, 'AGUS SULANTIYO', '53843', 'cinere', 0, 0, NULL, '$2y$12$Hl4Rgpyh5JMbRAtlOdi8hOnCXMASQV6PDexV1Ye6LzFqSJx4MPMR6', NULL, '2026-08-19 14:18:27', '2026-08-20 02:33:51', 'bm_sh', 'cinere'),
(512, 'ARWATI', '53847', 'cinere', 0, 0, NULL, '$2y$12$4KyRzWUVjwx..h7tTbOw3eGxRGzatVmwRzyE55GaUsH3lEffl4L1m', NULL, '2026-08-19 14:18:28', '2026-08-20 02:33:52', NULL, 'cinere'),
(513, 'Dedy Sugiarto', '53848', 'cinere', 0, 0, NULL, '$2y$12$MmZA3HPNCupHrnqgawinvOrm3unLpHOiAPiXzi3GpkGg7Aeq06RPy', NULL, '2026-08-19 14:18:28', '2026-08-20 02:33:52', NULL, 'cinere'),
(514, 'Nur zaman ali', '53850', 'cinere', 0, 0, NULL, '$2y$12$vJohFJs93MUtfI3V6O4NAuI3BNW0Lre5hcJwzjgoAVfVVKo/dFiea', NULL, '2026-08-19 14:18:28', '2026-08-20 02:33:53', NULL, 'cinere'),
(515, 'Mukti sumantri', '53854', 'ciawi', 0, 0, NULL, '$2y$12$mpv1.cn/SSIteJhZ7uHZs.kKjClILtVksn7n65AdX7TN7wuPxWRoK', NULL, '2026-08-19 14:18:28', '2026-08-20 02:33:53', NULL, 'ciawi'),
(516, 'Mutia zahra lubis', '53857', 'ciawi', 0, 0, NULL, '$2y$12$9jPjfDqhNvc7arrtt6C8d.aM.Q7xr3kJELR8fTqcO3P4qLVniqJi.', NULL, '2026-08-19 14:18:29', '2026-08-20 02:33:54', NULL, 'ciawi'),
(517, 'ZULFIKRAN', '54155', 'ciawi', 0, 0, NULL, '$2y$12$zVbgibhOBQ6E0KcJkpm8BeKEvs5rbL8NPQ0gj6z6NyJrqribhqmqi', NULL, '2026-08-19 14:18:29', '2026-08-20 02:33:55', NULL, 'ciawi'),
(518, 'SUCI JAYANTI', '54179', 'ciawi', 0, 0, NULL, '$2y$12$p8LfBCmbBeFspB2vWEcOPOwf2KAOyLBPI70m7mDgDj7Whl6l349du', NULL, '2026-08-19 14:18:30', '2026-08-20 02:33:56', NULL, 'ciawi'),
(519, 'Budy susandy putra', '54460', 'cinere', 0, 0, NULL, '$2y$12$aQdPq.0CCIjYcSRIvo5TR.4EVbmj1zaiBO1shtccuWyroqyiEADIS', NULL, '2026-08-19 14:18:30', '2026-08-20 02:33:56', NULL, 'cinere'),
(520, 'Obet Priyatno SE', '54531', 'jatiasih', 0, 0, NULL, '$2y$12$bTeNACTOS2Jslvapnv3cPuRmS6Haxnv/bFMZjidn2qNNrdPsxVjQ2', NULL, '2026-08-19 14:18:30', '2026-08-20 02:33:57', NULL, 'jatiasih'),
(521, 'SALAHUDIN AL AYUB', '54817', 'ciawi', 0, 0, NULL, '$2y$12$5/2G61RjTNXCX6APy3lbzO6YgVOHSA8t2yqoHgo/WF0xJGWHjS1s.', NULL, '2026-08-19 14:18:30', '2026-08-20 02:33:58', NULL, 'ciawi'),
(522, 'YENI AGUSTINA', '54818', 'ciawi', 0, 0, NULL, '$2y$12$D7j/Oo0q7AyUQeTi4yt7hOtRm8yGy4bbvW88G73.6rSnVymbPU8g.', NULL, '2026-08-19 14:18:31', '2026-08-20 02:33:59', NULL, 'ciawi'),
(523, 'SUPRIYATNA', '54975', 'jatiasih', 0, 0, NULL, '$2y$12$xott1AbCuIe1Bf.Dcfqz0uktrjPjowlgXF7W/r1co7xv1b0E0tzv.', NULL, '2026-08-19 14:18:31', '2026-08-20 02:33:59', NULL, 'jatiasih'),
(524, 'RINA KURNIAWATI', '55258', 'cinere', 0, 0, NULL, '$2y$12$XVzDOe6EIy/SUFukAbxgTOSWkPpahtXWiRacwi91/nbbV3ffLZttm', NULL, '2026-08-19 14:18:31', '2026-08-20 02:34:00', NULL, 'cinere'),
(525, 'YUNIARTI', '55264', 'cinere', 0, 0, NULL, '$2y$12$9IQtQ5eq57D26iv3fXYgUuKPxHIAl0Gqp7.Iw1RZy7TfbHivxC8cK', NULL, '2026-08-19 14:18:31', '2026-08-20 02:34:00', NULL, 'cinere'),
(526, 'YUSELA SARI JANUARI', '55265', 'cinere', 0, 0, NULL, '$2y$12$T1Fwl2RNDpAoiyNIgYUvwO6CPPqSDXI68D4CSFnkBQIStMTkmeJpi', NULL, '2026-08-19 14:18:32', '2026-08-20 02:34:01', NULL, 'cinere'),
(527, 'AISYAH UMAR', '55266', 'cinere', 0, 0, NULL, '$2y$12$s8bRD6kRgQRLqOYHTdQOxeiLCtPDnk1vnXhTQa99iY9i1zjYo0nny', NULL, '2026-08-19 14:18:32', '2026-08-20 02:34:01', NULL, 'cinere'),
(528, 'GUSTI REYNALDI', '55268', 'cinere', 0, 0, NULL, '$2y$12$z3BuIBQsjCCnavRkZ1YC1uphOYo.FBEsYemRCjmUum.JPrcU1SPTy', NULL, '2026-08-19 14:18:33', '2026-08-20 02:34:02', NULL, 'cinere'),
(529, 'SULTAN', '55269', 'cinere', 0, 0, NULL, '$2y$12$s69rNwFvHHqPUJVL0KoRh.8T35dEQXJ18Ku0Xkplc0YQxmBRPHose', NULL, '2026-08-19 14:18:33', '2026-08-20 02:34:02', NULL, 'cinere');
INSERT INTO `users` (`id`, `name`, `email`, `branch`, `is_admin`, `is_admin_stock`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `cabang`) VALUES
(530, 'ANWAR SADILI', '55296', 'ciawi', 0, 0, NULL, '$2y$12$sFoxZbaeig3CsTh6nWa.we2V3tEPgr8ycOsmZulgNlFliyGo9mTGS', NULL, '2026-08-19 14:18:33', '2026-08-20 02:34:03', NULL, 'ciawi'),
(531, 'Untung Nurwanda', '55711', 'jatiasih', 0, 0, NULL, '$2y$12$RVFp./bnrc2S7GbvTVjX7.SgWt/neAuyqQLMEDH7d.Sm6775kbb7K', NULL, '2026-08-19 14:18:33', '2026-08-20 02:34:03', NULL, 'jatiasih'),
(532, 'RAHMAYANTI', '55905', 'cinere', 0, 0, NULL, '$2y$12$pmzEqjgEYvlAAiYh0jfYQuxVTr7tWVUhgSIxrHC/rz8nIFRsJNFYK', NULL, '2026-08-19 14:18:34', '2026-08-20 02:34:04', NULL, 'cinere'),
(533, 'Yehezkiel Saputra', '56155', 'ciawi', 0, 0, NULL, '$2y$12$RB/N6k8WyPa4MikwiPlWaOwNQ1lY6c.BI5OxI60D/.PPo9PvCcdPi', NULL, '2026-08-19 14:18:34', '2026-08-20 02:34:04', NULL, 'ciawi'),
(534, 'Ferri Firmansyah', '56156', 'ciawi', 0, 0, NULL, '$2y$12$WZ/GnfHOA7RXWtgPDalunOwMFsxR8SnmQgpbx1PF//jR7nSXMZp5W', NULL, '2026-08-19 14:18:34', '2026-08-20 02:34:05', NULL, 'ciawi'),
(535, 'M. FAHMI SHODIQ', '56169', 'cinere', 0, 0, NULL, '$2y$12$A9tOZ1qYhXYeQQN9BozS1u7ElN1dmpCAQvlxkUlmHtXen/2tSpL7.', NULL, '2026-08-19 14:18:35', '2026-08-20 02:34:05', NULL, 'cinere'),
(536, 'NINA AGUSTINA', '56170', 'cinere', 0, 0, NULL, '$2y$12$laKI0Ob3FsJ06/rKiUJ7aec9AmhkdVr6Xy0Oz4iJ8ouQtLy2IQzFW', NULL, '2026-08-19 14:18:35', '2026-08-20 02:34:05', NULL, 'cinere'),
(537, 'OKTAVIANI DWI ASTUTI', '56171', 'cinere', 0, 0, NULL, '$2y$12$dAzqcgbC6kB9YksXgfmZH.j7Sex/n3vu.aFx14ltawIJZNQjm9qc2', NULL, '2026-08-19 14:18:35', '2026-08-20 02:34:06', NULL, 'cinere'),
(538, 'PUTI INTAN', '56172', 'cinere', 0, 0, NULL, '$2y$12$y/A77b7Hdu/IHC/8qmRxi.dbOpGOTT470cV2UmasiSe3gfXPSPEu6', NULL, '2026-08-19 14:18:35', '2026-08-20 02:34:06', NULL, 'cinere'),
(539, 'BUDI NOVIAN', '56173', 'cinere', 0, 0, NULL, '$2y$12$7A.AUT1uIzuv8n.g2GAxne5RH.Vmhf6XkFo.UXAoaxmW6xZSwZ0qm', NULL, '2026-08-19 14:18:36', '2026-08-20 02:34:07', NULL, 'cinere'),
(540, 'EVAN FEBRIANDA, SE', '56192', 'jatiasih', 0, 0, NULL, '$2y$12$pCkmswT3uVPEaH9TtFIxzOyM5I8i14p.e7EHrdccmt1zcF4YKNU3y', NULL, '2026-08-19 14:18:36', '2026-08-20 02:34:07', NULL, 'jatiasih'),
(541, 'RAHMAN HAKIM', '56193', 'ciawi', 0, 0, NULL, '$2y$12$vqCKo0zcVUkstSqt5mPxvea82tuStLAZAnYvbAHt2mi28LELbl8Ue', NULL, '2026-08-19 14:18:36', '2026-08-20 02:34:08', NULL, 'ciawi'),
(542, 'DODI KURNIAWAN', '56194', 'ciawi', 0, 0, NULL, '$2y$12$a7dmOHNXgKRQU.pwrdxxCOfCr8RZxKPraTveEkrbcCOXFWmS0HqzG', NULL, '2026-08-19 14:18:37', '2026-08-20 02:34:08', NULL, 'ciawi'),
(543, 'OKY MARYANSAH', '56195', 'ciawi', 0, 0, NULL, '$2y$12$N1PY/3/.28/NsZrd98w85egvk2RvBI14DVG3O1gRJrSu3NEM20IlC', NULL, '2026-08-19 14:18:37', '2026-08-20 02:34:09', NULL, 'ciawi'),
(544, 'DAMAR KALBU ADI', '56196', 'jatiasih', 0, 0, NULL, '$2y$12$3FbKytXTPkzbhe/XQSespOBquxah7ZnmO1CUkcXSBJnb/7/MIuAle', NULL, '2026-08-19 14:18:37', '2026-08-20 02:34:10', NULL, 'jatiasih'),
(545, 'RIDWAN FIKRI', '56197', 'jatiasih', 0, 0, NULL, '$2y$12$MqHyP/LoXA10AXxEXUvAYOvw51fIeum.XoIuPnGwpUmNl3uNcXwJq', NULL, '2026-08-19 14:18:37', '2026-08-20 02:34:10', NULL, 'jatiasih'),
(546, 'DINA MELIANA', '56198', 'jatiasih', 0, 0, NULL, '$2y$12$DxjWm4uRdj2bFT5/cjLxbuyYbvZLkh3rlsEufJQ6BrY9rn/.5b0xO', NULL, '2026-08-19 14:18:38', '2026-08-20 02:34:11', NULL, 'jatiasih'),
(547, 'TRIA NURMALA SARI', '56201', 'jatiasih', 0, 0, NULL, '$2y$12$A9GgQ79oQqS5vvNGQkFCyecjD1TySFpqCNoHypxRog7TOf7VDi9t6', NULL, '2026-08-19 14:18:38', '2026-08-20 02:34:12', NULL, 'jatiasih'),
(548, 'Teguh Prayitno', '56203', 'cianjur', 0, 0, NULL, '$2y$12$tH5TMHWoqDAJbFyINTrXb.y0RFfs7T2NjHhiEjLB8r5CVUUXf66sK', NULL, '2026-08-19 14:18:38', '2026-08-20 02:34:12', NULL, 'cianjur'),
(549, 'Aria Agustian', '56204', 'cianjur', 0, 0, NULL, '$2y$12$k3cPMMtbg8ta1xPSnSZB4.Ju9qQZlwMLp2f8fU43IO1xrgF40KV0e', NULL, '2026-08-19 14:18:38', '2026-08-20 02:34:12', NULL, 'cianjur'),
(550, 'Nurhadi Saputra', '56205', 'cipanas', 0, 0, NULL, '$2y$12$fscZuG7DKT3MDLw9rNnVe.y0xQSL6MWndyIFeZQPx4ppqO7UBa65.', NULL, '2026-08-19 14:18:39', '2026-08-20 02:34:13', NULL, 'cipanas'),
(551, 'shintya stifany R', '56206', 'cianjur', 0, 0, NULL, '$2y$12$BleAap0GMzzd8W3JOBdQPO2cx0Ueb00wTCvnNLECldmc2sfK8OgI.', NULL, '2026-08-19 14:18:39', '2026-08-20 02:34:13', NULL, 'cianjur'),
(552, 'Luluk Lukmanurhakim', '56207', 'cianjur', 0, 0, NULL, '$2y$12$vNObik9oPzurq0YvIDzmv.M06xW70/HCYO9hxZVdYnGtZpGx/icDC', NULL, '2026-08-19 14:18:39', '2026-08-20 02:34:14', NULL, 'cianjur'),
(553, 'muh bilal sanubari', '56208', 'cianjur', 0, 0, NULL, '$2y$12$dV//0Nn.p1evADoTbEhzMe/sNC3CngX7yi2K4MTstCMPAbES7yAci', NULL, '2026-08-19 14:18:40', '2026-08-20 02:34:14', NULL, 'cianjur'),
(554, 'MUHAMAD LUTFHI APRIANDI', '56209', 'cianjur', 0, 0, NULL, '$2y$12$1XvwWMhSxHfDukGQBQrfNe/DwmFqcHaLAkMRrWy5ZE5OAYN76p4hS', NULL, '2026-08-19 14:18:40', '2026-08-20 02:34:15', NULL, 'cianjur'),
(555, 'MUHAMAD RANGGA PRATAMA', '56210', 'cianjur', 0, 0, NULL, '$2y$12$38sTAA.umSfRVB08oaXTleqI1t47SLzlNiE5Zvfg/ti0QiZdegm1O', NULL, '2026-08-19 14:18:40', '2026-08-20 02:34:16', NULL, 'cianjur'),
(556, 'MELISA JELITA', '56211', 'cianjur', 0, 0, NULL, '$2y$12$z1nHEANw1yVrUCMGwF1PXu7ND0s1pP0ivZd.VKlZdJ3EzfHPxnRW.', NULL, '2026-08-19 14:18:40', '2026-08-20 02:34:16', NULL, 'cianjur'),
(557, 'ARIB WIBOWO GUNAWAN', '56212', 'cianjur', 0, 0, NULL, '$2y$12$jB29N9b5v92GD3SXIlO4muUMB0hOKUJi3r.D9KEuIsrWbgYFy2mo6', NULL, '2026-08-19 14:18:41', '2026-08-20 02:34:17', NULL, 'cianjur'),
(558, 'R SINTA HAYATI NURMEILASARI', '56213', 'cianjur', 0, 0, NULL, '$2y$12$KECbp4aguAfabTCrj8fRzuU7e2mEPc/g3JKRKnJDDM79fGFZ1j25u', NULL, '2026-08-19 14:18:41', '2026-08-20 02:34:18', NULL, 'cianjur'),
(559, 'SANDY KURNIA', '56214', 'cianjur', 0, 0, NULL, '$2y$12$tZblALJKUDKBoCfJvVkUOelBYQFrewqVLuzadX7zNLsLgr0ZtA89O', NULL, '2026-08-19 14:18:41', '2026-08-20 02:34:18', NULL, 'cianjur'),
(560, 'MOH RIZAL AJI MEGANTARA', '56215', 'cianjur', 0, 0, NULL, '$2y$12$D.HKkma2LHyT7PiSObI8.OeD5AgguT.N3kBReDo5e8yvS6zuHIb2C', NULL, '2026-08-19 14:18:42', '2026-08-20 02:34:19', NULL, 'cianjur'),
(561, 'FARIDA PERMATASARI', '56216', 'cianjur', 0, 0, NULL, '$2y$12$CwnGDsQFDcKaoCBTaUiDbu/gvOaSojOIYDXlf8tzSvkzFIkZwRK3G', NULL, '2026-08-19 14:18:42', '2026-08-20 02:34:20', NULL, 'cianjur'),
(562, 'IRMAN HAMZAH', '56222', 'ciawi', 0, 0, NULL, '$2y$12$KDl11E51IG738qE0OzcGducABsTASPt62fEM.u.rWpfpYVrXZuzsC', NULL, '2026-08-19 14:18:42', '2026-08-20 02:34:20', NULL, 'ciawi'),
(563, 'EGI SETIAWAN', '56245', 'ciawi', 0, 0, NULL, '$2y$12$qNg8xnJ4BPBrfsoEf1XmZu374Zny/o3n3fTmgjbvD1yObu.1plRRe', NULL, '2026-08-19 14:18:42', '2026-08-20 02:34:21', NULL, 'ciawi'),
(564, 'INDRA MAHENDRA', '56246', 'ciawi', 0, 0, NULL, '$2y$12$sUF5AY/C.vkOJyF/wQ73n.HxuKYY7Nge6aQMf8mB2ylenKSJd0hDi', NULL, '2026-08-19 14:18:43', '2026-08-20 02:34:21', NULL, 'ciawi'),
(565, 'NINA SEPRINA', '56247', 'ciawi', 0, 0, NULL, '$2y$12$GwFS9dmLR/BLFM3F0X45xOv6HNP1BDo5GQoRhG10Uw7RvfJpBurI2', NULL, '2026-08-19 14:18:43', '2026-08-20 02:34:22', NULL, 'ciawi'),
(566, 'Aida hafijah', '56374', 'cinere', 0, 0, NULL, '$2y$12$U2zGCejOv7q0oEpSsmcXQuqB5QIA0KrBLmHyiAuyveU.nbWdftOg.', NULL, '2026-08-19 14:18:43', '2026-08-20 02:34:22', NULL, 'cinere'),
(567, 'Agus Sutisna', '56492', 'cinere', 0, 0, NULL, '$2y$12$EtDTfDh57IPWKDSjH3TbaevCHPcsCOvNJSZcfk/fyKxSyCVeWkedu', NULL, '2026-08-19 14:18:43', '2026-08-20 02:34:23', NULL, 'cinere'),
(568, 'MANSYUR ABDUL SYUKUR', '56515', 'ciawi', 0, 0, NULL, '$2y$12$fiJnCfXDo2DSxZyEV46q1uHg0EBY4A0qcZcAz2POA.MWbVMZa5w1W', NULL, '2026-08-19 14:18:44', '2026-08-20 02:34:23', NULL, 'ciawi'),
(569, 'Eleventus', '56641', 'jatiasih', 0, 0, NULL, '$2y$12$pfzy4HyftNWUU.lF49xr7u5wHksA2TiOoLPKhgj9pnt7NPqTWa5wy', NULL, '2026-08-19 14:18:44', '2026-08-20 02:34:23', 'bm_sh', 'jatiasih'),
(570, 'RAHMAT HIDAYAT', '56648', 'jatiasih', 0, 0, NULL, '$2y$12$bB6fEbNeR1jhGfOglwKDOeIWpSBXN/sCXZi13uOXRYqaobioHz19u', NULL, '2026-08-19 14:18:44', '2026-08-20 02:34:24', NULL, 'jatiasih'),
(571, 'Fajri rezza', '56801', 'cinere', 0, 0, NULL, '$2y$12$Luu5Ne8iWfIE0wVwAe8cp.mE0rXCLZVVmkHrMQwUr9ehJMWC4EZ/u', NULL, '2026-08-19 14:18:45', '2026-08-20 02:34:24', NULL, 'cinere'),
(572, 'Bambang Hermanto', '57348', 'cinere', 0, 0, NULL, '$2y$12$ZvKWdyMps3AFLuRNdVXtJudGQf.AuI19gZ1AiGXnD4qH2Kc///mVO', NULL, '2026-08-19 14:18:45', '2026-08-20 02:34:25', 'bm_sh', 'cinere'),
(573, 'Rizky Cramer', '57349', 'cinere', 0, 0, NULL, '$2y$12$HZw0kll5HyWRiyKMnyA1U.JkhSIluwu5i.ddIkMn.pQsrdZQPPVWW', NULL, '2026-08-19 14:18:45', '2026-08-20 02:34:26', 'bm_sh', 'cinere'),
(574, 'Nopian Effendi', '57350', 'cinere', 0, 0, NULL, '$2y$12$PLwFgPq2IRiE8oakkevhX.dW1ULDJsNw1KEmlccvRUMRhZBQKDluC', NULL, '2026-08-19 14:18:45', '2026-08-20 02:34:26', 'bm_sh', 'cinere'),
(575, 'Radite Dimas Ario Putro', '57351', 'cinere', 0, 0, NULL, '$2y$12$awa/eIgiWUihGxstMCkj5eb8BBpNrtmNWlAEf/VTodMI1tEfVpkMq', NULL, '2026-08-19 14:18:46', '2026-08-20 02:34:27', NULL, 'cinere'),
(576, 'Doni Fajar Husain', '57352', 'cinere', 0, 0, NULL, '$2y$12$6K3zrqwf2nhvO0PvK5ceQumQKnxm4zJQAEQ1cLtmVeL5UXDZsWejG', NULL, '2026-08-19 14:18:46', '2026-08-20 02:34:27', NULL, 'cinere'),
(577, 'Rubisaniagist nuva', '57381', 'cinere', 0, 0, NULL, '$2y$12$hZFcKpk2yUlnBpv6RO0TqeLJHHMPdpsEAOUmb.GizmKGp/iZwD8Sy', NULL, '2026-08-19 14:18:46', '2026-08-20 02:34:28', NULL, 'cinere'),
(578, 'Rifan Rendika Sanusi', '57382', 'cinere', 0, 0, NULL, '$2y$12$3iUUkvsDBnJgoC2o6RE/Xu7NqG.SF1j0gs5ZQbyCt3F/3fiSTSHU.', NULL, '2026-08-19 14:18:46', '2026-08-20 02:34:28', NULL, 'cinere'),
(579, 'edward jenar', '57383', 'cinere', 0, 0, NULL, '$2y$12$zgZFrWyI.Zz0x3al1b4x6.EXZOAimcSun5AQk3U1oBKT0DEWpc8U.', NULL, '2026-08-19 14:18:47', '2026-08-20 02:34:29', NULL, 'cinere'),
(580, 'Rizki Nurhayati', '57384', 'cinere', 0, 0, NULL, '$2y$12$osOKjoqQOpJV7CzlB4aqHe4AefL/dpKUAq0X84DPgXtcKuopIG3uW', NULL, '2026-08-19 14:18:47', '2026-08-20 02:34:29', NULL, 'cinere'),
(581, 'MOHAMMAD EGIE SYAH RESTU', '57385', 'cinere', 0, 0, NULL, '$2y$12$FIEfCjkZRDA6vkYnwJ4xquN.IDFHRQ3ZzNz0M8NK16kaF23S88SVm', NULL, '2026-08-19 14:18:47', '2026-08-20 02:34:30', NULL, 'cinere'),
(582, 'Marfian Rezki Kurniawan', '57386', 'cinere', 0, 0, NULL, '$2y$12$n21nXXC8Z5It9Zjz3oKJsupElVonCnPlSOXXYDkKr2VzgSoRLugiK', NULL, '2026-08-19 14:18:48', '2026-08-20 02:34:30', NULL, 'cinere'),
(583, 'Ramdhani Kurniawan', '57387', 'cinere', 0, 0, NULL, '$2y$12$We/vXEDXd43Uu2xdJMAIhOukeQV5/UlpDuU.y5RxhBggLoSmfLV/S', NULL, '2026-08-19 14:18:48', '2026-08-20 02:34:31', NULL, 'cinere'),
(584, 'Boyke Arif Santoso', '57388', 'cinere', 0, 0, NULL, '$2y$12$.E3pVjZvHcB872emRae7GOaIubE7MPLYW96mnCfpt5.qLRwa6Zpe.', NULL, '2026-08-19 14:18:48', '2026-08-20 02:34:31', NULL, 'cinere'),
(585, 'Maria Ulfah', '57389', 'cinere', 0, 0, NULL, '$2y$12$YgHLo8B5RQYBLumX.3wKz.tceGjNniM3Saxygm/Pj/ScuH92ymJDG', NULL, '2026-08-19 14:18:48', '2026-08-20 02:34:32', NULL, 'cinere'),
(586, 'Mujianto', '57390', 'cinere', 0, 0, NULL, '$2y$12$A3V/M4NEEl0N1zheCRvuTeJEw2.whVFhCbLAfUHHtHnaJXXXpKHAy', NULL, '2026-08-19 14:18:49', '2026-08-20 02:34:32', NULL, 'cinere'),
(587, 'Dini Prihatini', '57391', 'cinere', 0, 0, NULL, '$2y$12$k0X8hOQG9WKYthIa2kdvmO0ePDyAAtJu3QkdaIOaFFwETn832XCxq', NULL, '2026-08-19 14:18:49', '2026-08-20 02:34:33', NULL, 'cinere'),
(588, 'Sautan Hutahaean', '57392', 'cinere', 0, 0, NULL, '$2y$12$vPOmWKLhobwdHYgsN9Q1COhN66KE45TBc5tahebTrrIgNj/qw9k9m', NULL, '2026-08-19 14:18:49', '2026-08-20 02:34:33', NULL, 'cinere'),
(589, 'YOPI ANGGARA SHOLIHAT', '57400', 'cinere', 0, 0, NULL, '$2y$12$2VDrklGydm3rFnD5340JSO/9G3NBwIzuX.zEIKk.P113wYOh6wVFe', NULL, '2026-08-19 14:18:49', '2026-08-20 02:34:33', NULL, 'cinere'),
(590, 'ANGGA DARTANTO', '57439', 'ciawi', 0, 0, NULL, '$2y$12$V3wBIrSnVJNpcl0edJrcKeeek72O4OtrmjSrJ3McCx.f/Wn.L7WyC', NULL, '2026-08-19 14:18:50', '2026-08-20 02:34:34', NULL, 'ciawi'),
(591, 'Safrizal', '57551', 'ciawi', 0, 0, NULL, '$2y$12$644ms3SnnGOcwcZo0bw4JeKQRy2DBDPXpL8tT11lobOI7JlftPc/y', NULL, '2026-08-19 14:18:50', '2026-08-20 02:34:36', NULL, 'ciawi'),
(592, 'teguh prayitno', '57761', 'cianjur', 0, 0, NULL, '$2y$12$5q.FyYArVvzcwvaE/6NBQO6bgMnA0T3mYX28Hd1MO.BgZnBZZWkY.', NULL, '2026-08-19 14:18:51', '2026-08-20 02:34:36', NULL, 'cianjur'),
(593, 'DHEA ANJAR PRATIWI', '57779', 'cinere', 0, 0, NULL, '$2y$12$Jelt7uOzVLLxFfvbOEMvx.eyX5heQA0eMV4Usdv41Km0LXDpXkEN6', NULL, '2026-08-19 14:18:51', '2026-08-20 02:34:37', NULL, 'cinere'),
(594, 'Muhammad Ikram Nursyaban', '57788', 'cinere', 0, 0, NULL, '$2y$12$xzVvIitf5/EkH1oycyt83uD9byHTJcnsLoaAuyV17AZL8g3zQUKz6', NULL, '2026-08-19 14:18:51', '2026-08-20 02:34:38', NULL, 'cinere'),
(595, 'Puti Intan Cahya', '57791', 'cinere', 0, 0, NULL, '$2y$12$/Rh/ctLT0QnTAL3dJUljvehgVGxsW4LTJlucCfwcIE.xiRW4vpzNm', NULL, '2026-08-19 14:18:51', '2026-08-20 02:34:39', NULL, 'cinere'),
(596, 'Mohammad arfath afzalurrahman', '58584', 'cinere', 0, 0, NULL, '$2y$12$oz10EGoGf7zJt87b5O4r..ZSPR/G6sfODj5WXSTzlklXE0YQ7xktC', NULL, '2026-08-19 14:18:52', '2026-08-20 02:34:40', NULL, 'cinere'),
(597, 'Irvan achmad satria', '58590', 'cinere', 0, 0, NULL, '$2y$12$ZDIb/fZdAKiWFjLsr5FW..RZHMGs8rD5N1qOjoIPAlskzMcPgQ6gW', NULL, '2026-08-19 14:18:52', '2026-08-20 02:34:41', NULL, 'cinere'),
(598, 'Dharmawan', '58591', 'cinere', 0, 0, NULL, '$2y$12$Pm.gvFcfVa2ev/2GWgdQruX8T8KdTVUugpX.lfEpTwZFohZN8iDE.', NULL, '2026-08-19 14:18:53', '2026-08-20 02:34:41', NULL, 'cinere'),
(599, 'Muhamad Rizki', '58592', 'cinere', 0, 0, NULL, '$2y$12$KngRyz2CRz8UORqO9zfrkOnEhxTCNpJR5u3adS4Foe6PkDPium4wC', NULL, '2026-08-19 14:18:53', '2026-08-20 02:34:42', NULL, 'cinere'),
(600, 'ROBI BINUR', '58593', 'cinere', 0, 0, NULL, '$2y$12$3pXA1nUTEXaqWLV2C5OOB.0VblSTbEMOfSf0O484zDiA6XqsLiXRq', NULL, '2026-08-19 14:18:53', '2026-08-20 02:34:42', NULL, 'cinere'),
(601, 'Hadi Rochman', '58594', 'cinere', 0, 0, NULL, '$2y$12$uXGmF33ZHaAgqMFD7rHKQ.wSMIu5h0cmR209Vufxw1hiIbCRA2tdi', NULL, '2026-08-19 14:18:53', '2026-08-20 02:34:43', NULL, 'cinere'),
(602, 'Muhamaddin', '58595', 'cinere', 0, 0, NULL, '$2y$12$zO/.ZYIHCmTTgtNSfqyCIeeSgEk6OkiXaIWvyy12397947hvT9iX.', NULL, '2026-08-19 14:18:54', '2026-08-20 02:34:43', NULL, 'cinere'),
(603, 'Eka Catur Purnama', '58596', 'cinere', 0, 0, NULL, '$2y$12$KTsgEUUJasXszBmRDqhhHeE/TX7JnytE.zTyGa7adQ3l8CACwuopS', NULL, '2026-08-19 14:18:54', '2026-08-20 02:34:43', NULL, 'cinere'),
(604, 'Bagas bambang riyadi', '58597', 'cinere', 0, 0, NULL, '$2y$12$/pCJILtIgFv32hW67yTrR./.GkiFn3wuqqKqKwrAiEqCqVVq2ugpS', NULL, '2026-08-19 14:18:54', '2026-08-20 02:34:44', NULL, 'cinere'),
(605, 'Gusti fanditya hermawan', '58599', 'cinere', 0, 0, NULL, '$2y$12$O8EyQ3No3y4ERycowhQ1quj3vHzvWJ72yf.Rl0tSYWB2NU4YR7d.O', NULL, '2026-08-19 14:18:54', '2026-08-20 02:34:45', NULL, 'cinere'),
(606, 'Mohammad arfath afzalurrahman', '58626', 'cinere', 0, 0, NULL, '$2y$12$tysVOzoi4ZH81Hzd9/6RIOnQp5BDXslQXOaoPFQ6qPrLGh5x84B7G', NULL, '2026-08-19 14:18:55', '2026-08-20 02:34:45', NULL, 'cinere'),
(607, 'Rendy S.Pd.I', '58627', 'ciawi', 0, 0, NULL, '$2y$12$xcgwaNvaipqIlgeF4XQ2sOaBEZArSI3TdAdRHVbCEVeDoOJkbmJ5q', NULL, '2026-08-19 14:18:55', '2026-08-20 02:34:46', 'bm_sh', 'ciawi'),
(608, 'Evan suryapranata', '58629', 'ciawi', 0, 0, NULL, '$2y$12$R5mQY/PYiIMCEV1k38GovO.C0oKyj3NOYEEnVQ/Uo9YzGCM1./7OO', NULL, '2026-08-19 14:18:55', '2026-08-20 02:34:47', NULL, 'ciawi'),
(609, 'Iskandar Hidayat', '58735', 'ciawi', 0, 0, NULL, '$2y$12$.3XVh63ljbcLEEjpWrvPr.GujYkawxLW03GTs9unX/RLIXzoyTeMG', NULL, '2026-08-19 14:18:56', '2026-08-20 02:34:47', NULL, 'ciawi'),
(610, 'Ricky Fisonika', '58736', 'ciawi', 0, 0, NULL, '$2y$12$Z8jciSSTxV5nr2mY5UApQe3evl1EEaTLY9b9jCnvDs9s8gjKBUTcS', NULL, '2026-08-19 14:18:56', '2026-08-20 02:34:48', NULL, 'ciawi'),
(611, 'Hersi Ridola Putra', '58739', 'ciawi', 0, 0, NULL, '$2y$12$qZEbEU3GQENp1/.7Y19kzOWNn/R.aqOv7ro16rueCdcmv8DtQ5kpy', NULL, '2026-08-19 14:18:56', '2026-08-20 02:34:49', NULL, 'ciawi'),
(612, 'Ramlie Budiman', '59203', 'cinere', 0, 0, NULL, '$2y$12$230nR7.jRyBDidzhtdMZKeQt9JT3OCm9ZmLqb.iJMeEtNikmYEhfW', NULL, '2026-08-19 14:18:56', '2026-08-20 02:34:49', 'bm_sh', 'cinere'),
(613, 'May Margareth', '59241', 'ciawi', 0, 0, NULL, '$2y$12$4SuesMPcw93Bq6EAKa5VFuhri4V.FJsBdeG6NDx4P9A/wsPJJaDE.', NULL, '2026-08-19 14:18:57', '2026-08-20 02:34:50', 'bm_sh', 'ciawi'),
(614, 'Adam Zatnika', '59243', 'ciawi', 0, 0, NULL, '$2y$12$qwPrwA2wGsQt1MzrgLA64.0hGsnR.7pWrwFHYDtcWaj6gLDsoMRqe', NULL, '2026-08-19 14:18:57', '2026-08-20 02:34:51', NULL, 'ciawi'),
(615, 'Lucky Ekaputra', '59290', 'cianjur', 0, 0, NULL, '$2y$12$craBn95Dx.//HX0GHA8ys.VIn6qiN.9XlReTNBn3XQISI1qvKbbz6', NULL, '2026-08-19 14:18:58', '2026-08-20 02:34:52', 'bm_sh', 'cianjur'),
(616, 'M RIKI MUSLIM', '59291', 'cianjur', 0, 0, NULL, '$2y$12$Wu0lGfb.ArmvresGFxP8yOQ9fb9liA79t/8v954dKlLYDT0CVNO5q', NULL, '2026-08-19 14:18:58', '2026-08-20 02:34:52', NULL, 'cianjur'),
(617, 'MUHAMAD DAHLAN', '59297', 'ciawi', 0, 0, NULL, '$2y$12$L08ARSX.bqCzGhOFUVLmOe6VJHuicaAdbeLCvXQKoafC8TnGvZWpu', NULL, '2026-08-19 14:18:58', '2026-08-20 02:34:53', NULL, 'ciawi'),
(618, 'DENNY CHANDRA', '59343', 'ciawi', 0, 0, NULL, '$2y$12$CMzd1YwpbEWIW0uKLtrNru3C6Uu2H4cv3KvfE8e3.Ko6iwslGhcIG', NULL, '2026-08-19 14:18:58', '2026-08-20 02:34:54', NULL, 'ciawi'),
(619, 'RIYAN ALFIANSYAH', '59344', 'ciawi', 0, 0, NULL, '$2y$12$pWX5LUECa7lOW5knRrZ4/u4.F3tOfrpFS.ywOgM8J.vQzthe.l3M.', NULL, '2026-08-19 14:18:59', '2026-08-20 02:34:54', NULL, 'ciawi'),
(620, 'LIANA', '59361', 'ciawi', 0, 0, NULL, '$2y$12$CojHHgu2XE.lkpDhFaxvGeWVNH9tKCXwRbGgp6pqEDAZbzkD4Bpfy', NULL, '2026-08-19 14:18:59', '2026-08-20 02:34:55', NULL, 'ciawi'),
(621, 'Ummi Hani', '59367', 'ciawi', 0, 0, NULL, '$2y$12$0x6aP3VNHwbtnIxkhcIKkOsyHc2Lp8rski1XIBgNMoEnNm22oVS56', NULL, '2026-08-19 14:18:59', '2026-08-20 02:34:55', NULL, 'ciawi'),
(622, 'ANGGA SETIAWAN', '59368', 'ciawi', 0, 0, NULL, '$2y$12$KOuw45sczVwpkvP42.yOU.7K8XJxEKm6Sa4yfh5MT7suwszjxIs5q', NULL, '2026-08-19 14:18:59', '2026-08-20 02:34:56', NULL, 'ciawi'),
(623, 'RULLY ALFIANA', '59371', 'ciawi', 0, 0, NULL, '$2y$12$IhlO.9Ktf8iNSfSZS0beB.f7h3kfYTFDPlRJ6SVYJA75.Oz0hdybq', NULL, '2026-08-19 14:19:00', '2026-08-20 02:34:57', NULL, 'ciawi'),
(624, 'FEBRINA ANGELLINE K', '59372', 'ciawi', 0, 0, NULL, '$2y$12$p39XqAFrDHyNOjPYQM/AO.Q7IOEvsYaCbxlA5lbgK22wX3OWr.aoG', NULL, '2026-08-19 14:19:00', '2026-08-20 02:34:57', NULL, 'ciawi'),
(625, 'SYAHRUDIN', '59373', 'ciawi', 0, 0, NULL, '$2y$12$ipXoGQAXt4vOwWIrov.Ehuw3yX7uZEq04dab2ebJMYiuB/Hiymozi', NULL, '2026-08-19 14:19:00', '2026-08-20 02:34:58', NULL, 'ciawi'),
(626, 'RAMCES PANJAITAN', '59374', 'ciawi', 0, 0, NULL, '$2y$12$zAizR3Kz1CvNCRi6WZh8ouOXLY9V6SErjA4zf09DS09FCF86Jq2aG', NULL, '2026-08-19 14:19:01', '2026-08-20 02:34:58', NULL, 'ciawi'),
(627, 'Dedi Sopiyan', '59423', 'cianjur', 0, 0, NULL, '$2y$12$njqWc7RtSjZcLXOnLMD0fe1mywF74rbQBApxGtOYFkVRkcGUMsaWu', NULL, '2026-08-19 14:19:01', '2026-08-20 02:34:59', 'bm_sh', 'cianjur'),
(628, 'Mirna Nuraniyati', '59424', 'cianjur', 0, 0, NULL, '$2y$12$BRxGag0M6hpSQ5.mmXWBzOioRLVmWijHooZJ9II3dYsYg2rdbjjZO', NULL, '2026-08-19 14:19:01', '2026-08-20 02:34:59', NULL, 'cianjur'),
(629, 'HENDRA', '59425', 'cianjur', 0, 0, NULL, '$2y$12$JQxwQHcqMEoy3QsvC2tgz.FeFaLYSCuaCxIYmkAIfEyty2LdYvzCG', NULL, '2026-08-19 14:19:01', '2026-08-20 02:35:00', NULL, 'cianjur'),
(630, 'IWAN KURNIAWAN', '59426', 'cianjur', 0, 0, NULL, '$2y$12$xlc8nUG/nM6/nQ8gTbL//OewPxtWgG3GRdPe5C/tKXDu8POMHuSca', NULL, '2026-08-19 14:19:02', '2026-08-20 02:35:00', NULL, 'cianjur'),
(631, 'RIDHO WIDIANSYAH', '59427', 'cianjur', 0, 0, NULL, '$2y$12$JZk/9aJ4MWSYZGFp24nh9eA.u3NES.uqi4gbW070DQ3GKPwQROBd.', NULL, '2026-08-19 14:19:02', '2026-08-20 02:35:01', NULL, 'cianjur'),
(632, 'Ferry Ferdiansyah Gumelar', '59428', 'cianjur', 0, 0, NULL, '$2y$12$vxUKdl8MWRNtqiIVCiFUJ.npfwRTDJoYqgBkyi.ddTH1paemi/.eK', NULL, '2026-08-19 14:19:02', '2026-08-20 02:35:01', NULL, 'cianjur'),
(633, 'ASEP MUNAWAR', '59491', 'cianjur', 0, 0, NULL, '$2y$12$E/PxeZbJrQRZ0Ol/h94kx.t66hIAanHXy07/0T/ES0WGkm3dtDZ6i', NULL, '2026-08-19 14:19:02', '2026-08-20 02:35:02', NULL, 'cianjur'),
(634, 'I Gede Ngurah Wisnu Jayandika', '59492', 'cianjur', 0, 0, NULL, '$2y$12$4A3DCw81tf7ihwiX45zDBu0SdEWoEZtPrpeK/DeilZpjG2QG/Ifx2', NULL, '2026-08-19 14:19:03', '2026-08-20 02:35:02', NULL, 'cianjur'),
(635, 'Galih Dwi Warsono', '59493', 'cianjur', 0, 0, NULL, '$2y$12$H11cxtWk4NaENihX09nTNOifnrD8pP9jNjXAH5eXzafKF0mAQ6njS', NULL, '2026-08-19 14:19:03', '2026-08-20 02:35:03', NULL, 'cianjur'),
(636, 'RIZKY RIANA RAMDAN', '59494', 'cianjur', 0, 0, NULL, '$2y$12$j/wlqxfgPw2JqDRP0fAxx.PTdni/N/9ORrbfuNWtwRa/scWYBwJq.', NULL, '2026-08-19 14:19:03', '2026-08-20 02:35:03', NULL, 'cianjur'),
(637, 'R Ricky Laxmana', '59495', 'cianjur', 0, 0, NULL, '$2y$12$WaidRW8sXReXVGdvyUhW8.aqbfOhIoI6ucrLOwS8j5zUwSEtxqXmG', NULL, '2026-08-19 14:19:04', '2026-08-20 02:35:04', NULL, 'cianjur'),
(638, 'Ayu Rizkiyanti', '59496', 'cianjur', 0, 0, NULL, '$2y$12$gec9czP52UAE8iRf9Dg2JeWEkivm/KNxxNGRPkUYCUTBCxOznmgY.', NULL, '2026-08-19 14:19:04', '2026-08-20 02:35:05', NULL, 'cianjur'),
(639, 'Siti Laela nurani', '59497', 'cianjur', 0, 0, NULL, '$2y$12$JDE2xAKskqHvMVFi70NBDup1upUvr.n5TcFbyrHI7aEDQ.1.9xHde', NULL, '2026-08-19 14:19:04', '2026-08-20 02:35:06', NULL, 'cianjur'),
(640, 'Vicky Putri Septiani', '59498', 'cianjur', 0, 0, NULL, '$2y$12$4OQWpDFgDMT57Hbkx.z7ZeHCFZBnF1Ttgz7ah1kV4/ubxGVwb/b0C', NULL, '2026-08-19 14:19:04', '2026-08-20 02:35:07', NULL, 'cianjur'),
(641, 'DIENAR ARDIANSYAH', '59499', 'cipanas', 0, 0, NULL, '$2y$12$StPBevSL5MMb51r/N/aSYOXFtD6FnPH/kzA58HjBW4LrgpHQhnaHu', NULL, '2026-08-19 14:19:05', '2026-08-20 02:35:07', NULL, 'cipanas'),
(642, 'SUTRISNO', '59500', 'cianjur', 0, 0, NULL, '$2y$12$rnQEuMhBDk/vUek1tA0nF.wIthcIsPtSS1seo0ay2nX2WrGdMT2ly', NULL, '2026-08-19 14:19:05', '2026-08-20 02:35:08', NULL, 'cianjur'),
(643, 'Iyang setiawan', '59501', 'cianjur', 0, 0, NULL, '$2y$12$uo8On5wF2JqI28MvsTxBNeoSec4GumiD70brCW6SoKaPWjeG4XP3m', NULL, '2026-08-19 14:19:05', '2026-08-20 02:35:08', NULL, 'cianjur'),
(644, 'Deni Purnama', '59502', 'cianjur', 0, 0, NULL, '$2y$12$U7QYEHkzZzRRZJgK.YQk6emNhq7wiC/5zPvvuerZ/NS.dMMTuyPP.', NULL, '2026-08-19 14:19:05', '2026-08-20 02:35:09', NULL, 'cianjur'),
(645, 'Aa Hendiyana', '59519', 'cianjur', 0, 0, NULL, '$2y$12$yirlY/g9lJc1aN61MJ89UeaszxYHx9CTF6RncqdYGczcPDFjezDZu', NULL, '2026-08-19 14:19:06', '2026-08-20 02:35:10', NULL, 'cianjur'),
(646, 'AJI MUHAMAD FAISAL', '59520', 'cianjur', 0, 0, NULL, '$2y$12$lSBzvjfpQQYROa01hTS/cen51r73A0DEZsnIJv0XL8lQ0FGYNheie', NULL, '2026-08-19 14:19:06', '2026-08-20 02:35:10', NULL, 'cianjur'),
(647, 'Kiki Hardi', '59521', 'ciawi', 0, 0, NULL, '$2y$12$rgE5ZjjCPHkZcNo.XqjE3erlg2mxZfRFx36/kc9OFccx68pDsJn2G', NULL, '2026-08-19 14:19:06', '2026-08-20 02:35:11', NULL, 'ciawi'),
(648, 'Dwi Nuryani', '59522', 'ciawi', 0, 0, NULL, '$2y$12$tu3934Ze6zjBq9p/l2IYfeu8QI3F4UsH3hjCXiBE4upYS377Hx6Rm', NULL, '2026-08-19 14:19:07', '2026-08-20 02:35:12', NULL, 'ciawi'),
(649, 'Aldie Pramana', '59523', 'ciawi', 0, 0, NULL, '$2y$12$rD1d2svfLufCgzZ8SAd8/ewkDOZaumkD8RzhlX6D101x5nHSpwb1S', NULL, '2026-08-19 14:19:07', '2026-08-20 02:35:12', NULL, 'ciawi'),
(650, 'Elisabeth', '59804', 'ciawi', 0, 0, NULL, '$2y$12$1PH2M.rK3UtUN.Pte1LynOMLL7T4kkrVH28cTI17j9PEALtbtHiE.', NULL, '2026-08-19 14:19:07', '2026-08-20 02:35:14', NULL, 'ciawi'),
(651, 'HERIMAN', '59896', 'jatiasih', 0, 0, NULL, '$2y$12$dVUhukxFEhQhnR4b3PBJJ.1UtoBiq4Um3VumT86uaSMMVFPCHbNEq', NULL, '2026-08-19 14:19:08', '2026-08-20 02:35:14', NULL, 'jatiasih'),
(652, 'EKA SUGANDA', '59897', 'jatiasih', 0, 0, NULL, '$2y$12$qolfm51w7orirEH.YX23Au2VNTUNQnPTBL3Zg6mH8rHJTXdKsD8my', NULL, '2026-08-19 14:19:08', '2026-08-20 02:35:15', NULL, 'jatiasih'),
(653, 'Rani Anggraeni', '59898', 'cianjur', 0, 0, NULL, '$2y$12$2z3WzVBomoABQ0D.k7LJv.jubn6hHURlV51gV.eyUJFfieF55nSty', NULL, '2026-08-19 14:19:08', '2026-08-20 02:35:16', NULL, 'cianjur'),
(654, 'Aziz mursal', '59899', 'cianjur', 0, 0, NULL, '$2y$12$7ZZtibJIJjFaH1fB5nH1Ve3FQAHhy.h8iXuifQyQW0NFnMK.3JAZa', NULL, '2026-08-19 14:19:09', '2026-08-20 02:35:16', NULL, 'cianjur'),
(655, 'Badarudin Syafaat', '59940', 'ciawi', 0, 0, NULL, '$2y$12$VJfHhEECUmH8ABBxUlmDw.JiVdLSg0xtCndCjv8QJcJQvYmlw8emi', NULL, '2026-08-19 14:19:09', '2026-08-20 02:35:17', NULL, 'ciawi'),
(656, 'Mohammad Haikal Se', '59979', 'cinere', 0, 0, NULL, '$2y$12$qtauYAdnARhz5PLDN99r/O9D61ns82oiudkapDFuskS07.0sWGAxy', NULL, '2026-08-19 14:19:09', '2026-08-20 02:35:17', NULL, 'cinere'),
(657, 'NOVIAN SUCIPTO ADI', '60053', 'cinere', 0, 0, NULL, '$2y$12$qfsPoZYiXiKO7Xp73qr2N.a/QWg4zHX4dGw7XRlj1EybGmDAYRQQq', NULL, '2026-08-19 14:19:09', '2026-08-20 02:35:18', NULL, 'cinere'),
(658, 'Adrian Hildansyah', '60054', 'cinere', 0, 0, NULL, '$2y$12$nnQ/7jxl9Nw0297lQdiKaeuHhgaAGP3gUYzA/kPLV.k2QdEH/DZ4e', NULL, '2026-08-19 14:19:10', '2026-08-20 02:35:19', NULL, 'cinere'),
(659, 'Achmad Hidayat', '60294', 'cinere', 0, 0, NULL, '$2y$12$cGogO5HGhJ9RZEeVlp3nj.Y/iiUG0lxvRNU8rduSl/r.0WPYTuV3G', NULL, '2026-08-19 14:19:10', '2026-08-20 02:35:20', NULL, 'cinere'),
(660, 'Ashok Mitra', '60295', 'cinere', 0, 0, NULL, '$2y$12$EqZCOEZ1ERQ/pZj6.TtTQuneaWPwY0ySvpqHS9FHUDlcnzDiBg9yW', NULL, '2026-08-19 14:19:10', '2026-08-20 02:35:20', NULL, 'cinere'),
(661, 'Budi Suryana', '60411', 'cianjur', 0, 0, NULL, '$2y$12$8RS.RmG7n8zcjLQ7nxAgCOwF3itkyLuZrH52ziu1LKnIuaKLLlEIO', NULL, '2026-08-19 14:19:10', '2026-08-20 02:35:21', NULL, 'cianjur'),
(662, 'Nurhadi Saputra', '60412', 'cipanas', 0, 0, NULL, '$2y$12$.LBLUI50qcUWwpyNu9OlFOW9MO287YMFCtzlZ20uF5uoYEiT0t7Gi', NULL, '2026-08-19 14:19:11', '2026-08-20 02:35:22', NULL, 'cipanas'),
(663, 'Mimit Arianto', '60413', 'cianjur', 0, 0, NULL, '$2y$12$rFlbei9gTWA8GE.Ug5e/DO546kZFGtibjrJjDLnT2j2S75Uj/f5ua', NULL, '2026-08-19 14:19:11', '2026-08-20 02:35:22', NULL, 'cianjur'),
(664, 'Abdul Akmar', '60414', 'ciawi', 0, 0, NULL, '$2y$12$OO97WRe3unjLCjjXdb5BCeFWUkFXpj5VZM/hrEuEHTBRJs5jlY9jq', NULL, '2026-08-19 14:19:11', '2026-08-20 02:35:23', NULL, 'ciawi'),
(665, 'Ripan Munandar', '60446', 'ciawi', 0, 0, NULL, '$2y$12$dW7THJmaukyZt8cfcmzT0OJXAAtaXfHnRNCpTZj5A78Gche5KahbK', NULL, '2026-08-19 14:19:12', '2026-08-20 02:35:24', NULL, 'ciawi'),
(666, 'Angga Taufik Hidayat', '60447', 'ciawi', 0, 0, NULL, '$2y$12$EkD6kzrBtoneoDRhQjoQkODCE/9w9T4mh.3vayUQeEH1YGjNq6xCG', NULL, '2026-08-19 14:19:12', '2026-08-20 02:35:24', NULL, 'ciawi'),
(667, 'Rajali', '60448', 'ciawi', 0, 0, NULL, '$2y$12$AwESR2qSNmGebKchMIuNWu2IH0ROCdVQ/MGkghpGswS/Aqs35qKam', NULL, '2026-08-19 14:19:12', '2026-08-20 02:35:25', NULL, 'ciawi'),
(668, 'AGUS SULAEMAN', '60488', 'ciawi', 0, 0, NULL, '$2y$12$d.O3jrw8kRZm.oDqu2K.zuhgVcICiglhL8asdHd2FRgNSbfNax9K6', NULL, '2026-08-19 14:19:12', '2026-08-20 02:35:26', NULL, 'ciawi'),
(669, 'Amelia Alviani', '60497', 'cinere', 0, 0, NULL, '$2y$12$BCcI.QHJb1BurajeR3eLSO/YSadEXJzRRP7/M8LMWx1triIqdlKo.', NULL, '2026-08-19 14:19:13', '2026-08-20 02:35:27', NULL, 'cinere'),
(670, 'Kiki Rapi Sujadiawan', '60498', 'cianjur', 0, 0, NULL, '$2y$12$zi9Ywt8zoey/k3IlMBB00Oo3XXypRUps8rRNVOzkgZmOvuDer5um6', NULL, '2026-08-19 14:19:13', '2026-08-20 02:35:27', NULL, 'cianjur'),
(671, 'Gilang Maulida Muhammad', '60500', 'cianjur', 0, 0, NULL, '$2y$12$FffQJkMu8ORa/sUFC.Fh..udqCzytuX3oXfAnHW9NB1jmas8565SS', NULL, '2026-08-19 14:19:13', '2026-08-20 02:35:28', NULL, 'cianjur'),
(672, 'Deny Kushendar', '60501', 'cianjur', 0, 0, NULL, '$2y$12$4BJ5es17CGoeJYfwM2VcieXlbYdd2cYRdzmQLzYC7rZ.tvhl6Sd3m', NULL, '2026-08-19 14:19:13', '2026-08-20 02:35:28', NULL, 'cianjur'),
(673, 'TONI HILMAWAN', '60502', 'ciawi', 0, 0, NULL, '$2y$12$O/CSd/0ZRieC9tGQW/B0Euea1G6apPTR1SKjjLwMGs97Z3xRcjM5y', NULL, '2026-08-19 14:19:14', '2026-08-20 02:35:29', NULL, 'ciawi'),
(674, 'Andro Octavianus', '60613', 'cinere', 0, 0, NULL, '$2y$12$srBhDMBs0lMVYPT.0DjnpOn6S7uH3ipFdmoRYnCxHuOUg0xNV7Sze', NULL, '2026-08-19 14:19:14', '2026-08-20 02:35:30', 'bm_sh', 'cinere'),
(675, 'FAJAR SHODIK', '60755', 'jatiasih', 0, 0, NULL, '$2y$12$Xdlyy2qIocRXufvVpaZM8u/x2KXtnjs/4ul0FEbIzQPGjAsfbU6FC', NULL, '2026-08-19 14:19:14', '2026-08-20 02:35:31', NULL, 'jatiasih'),
(676, 'HERDIYANA SODIKIN', '60833', 'cianjur', 0, 0, NULL, '$2y$12$X.PXgSAUXJMCtyYuJNQ8MuoGq1DVJknnlCfdUEmKXBGiIv2Bkny3G', NULL, '2026-08-19 14:19:15', '2026-08-20 02:35:31', NULL, 'cianjur'),
(677, 'LAISAH SEPTIANI', '60995', 'jatiasih', 0, 0, NULL, '$2y$12$RjizvfB7OHczVmLrBfjF3uX9EKYsC7tUAq9UgiVK24ggwLMR/1Hga', NULL, '2026-08-19 14:19:15', '2026-08-20 02:35:31', NULL, 'jatiasih'),
(678, 'PRAYOGA PURNAMA PUTRA', '60996', 'jatiasih', 0, 0, NULL, '$2y$12$P2kx5dEEnI7bJkTtgwxoQe8kwOJ5PeISE1YD.TMXgnPTFf3IkaVW6', NULL, '2026-08-19 14:19:15', '2026-08-20 02:35:32', NULL, 'jatiasih'),
(679, 'DEDI SAMSUDIN', '60997', 'jatiasih', 0, 0, NULL, '$2y$12$oSWPdM3t21bxhhRdkDVz..oTLJP6cLrAL40ESu.1WmA50eTh04VG2', NULL, '2026-08-19 14:19:15', '2026-08-20 02:35:32', NULL, 'jatiasih'),
(680, 'Muhamad Sirojudin Abu Paraj', '60998', 'ciawi', 0, 0, NULL, '$2y$12$Gfzy01MiYAo.CCKDT3n5cOA684bLgpDuUb2oJm.YBwRIG0n8PbePe', NULL, '2026-08-19 14:19:16', '2026-08-20 02:35:32', NULL, 'ciawi'),
(681, 'Adis Saputri', '60999', 'ciawi', 0, 0, NULL, '$2y$12$3JnvqEd0ELFu94fvfs00juX3/xrSIHa9OCwBBBT4C54USYo5c9dyO', NULL, '2026-08-19 14:19:16', '2026-08-20 02:35:33', NULL, 'ciawi'),
(682, 'Ari Azhari Ismail', '61000', 'ciawi', 0, 0, NULL, '$2y$12$V1NvJsNnH43cgyZQELAJMeeQUhJ1vVId4TQiD.QoZZxk3bX51WN/y', NULL, '2026-08-19 14:19:16', '2026-08-20 02:35:33', NULL, 'ciawi'),
(683, 'Arida Guritno', '61601', 'cinere', 0, 0, NULL, '$2y$12$qAXB43MEJQFWOJxNKnUBg.I9v2H6Ubn3yDSKn3IyPMd/vypZEGY5K', NULL, '2026-08-19 14:19:17', '2026-08-20 02:35:34', 'bm_sh', 'cinere'),
(684, 'Galih Ginanjar', '61602', 'cinere', 0, 0, NULL, '$2y$12$KM5rF0OYXCXOvkPac5.Vre48TZkOB3vUdcCzcYoY5EqgILNEMKuCS', NULL, '2026-08-19 14:19:17', '2026-08-20 02:35:35', NULL, 'cinere'),
(685, 'Muhammad Egy Aditya', '61603', 'cinere', 0, 0, NULL, '$2y$12$1d4HnT.edVz6ABiayc068.pqtMLV/IF0xFddwbkYmDWIbeu9us9Sy', NULL, '2026-08-19 14:19:18', '2026-08-20 02:35:35', NULL, 'cinere'),
(686, 'Iwan kurniawan', '61673', 'cinere', 0, 0, NULL, '$2y$12$8OOmXPXo7A9JbfInJ18z4ONuPHS7AM71jExBNjOWTIOFSi54cMiyC', NULL, '2026-08-19 14:19:18', '2026-08-20 02:35:35', NULL, 'cinere'),
(687, 'Muhamad Adrian Anand', '61795', 'ciawi', 0, 0, NULL, '$2y$12$BaZ8Pi9HqK38vuBFqTgiQO.Fv0svhmqLy37y4iVl4Q37VuhCBRJ.a', NULL, '2026-08-19 14:19:18', '2026-08-20 02:35:36', NULL, 'ciawi'),
(688, 'Gustiansyah', '61796', 'ciawi', 0, 0, NULL, '$2y$12$qyeZopARpn/.20E3h5fI9e8ZwSFEdRLR4MtH/HHIHdIsqSyPYtGVe', NULL, '2026-08-19 14:19:18', '2026-08-20 02:35:36', NULL, 'ciawi'),
(689, 'Muhamad yoga pirdaus', '61797', 'ciawi', 0, 0, NULL, '$2y$12$cv77UfhOZiOhKAleHfDKqOjNviLRtxquK/dxQVJN129IOzHhhtKjS', NULL, '2026-08-19 14:19:19', '2026-08-20 02:35:37', NULL, 'ciawi'),
(690, 'Alan Wari Maulana', '61798', 'ciawi', 0, 0, NULL, '$2y$12$AgJzb1TTWGex1fkGF9a1WeMXd847fwaNFYYQV2c7TwJG77o8Dz1Ii', NULL, '2026-08-19 14:19:19', '2026-08-20 02:35:37', NULL, 'ciawi'),
(691, 'Danang Pratono', '61799', 'cinere', 0, 0, NULL, '$2y$12$blMQuxajXL4qTN1RcAW/t.3./JHlSiKS77fpSylX7erl9w2Y5OJYq', NULL, '2026-08-19 14:19:19', '2026-08-20 02:35:37', NULL, 'cinere'),
(692, 'DONI IRAWAN SEPTA', '61800', 'ciawi', 0, 0, NULL, '$2y$12$CwnPsbTY8xjCNH0xQKhzBO/akQ48UUpJpQ82brNqWJrIQuBglqK5W', NULL, '2026-08-19 14:19:19', '2026-08-20 02:35:38', NULL, 'ciawi'),
(693, 'Septian Permana', '61801', 'ciawi', 0, 0, NULL, '$2y$12$JJ7Tx2CDdegaEBJ7RYCry.1IL3tncVf416EEXGp3SVfQS6n17SepW', NULL, '2026-08-19 14:19:20', '2026-08-20 02:35:38', NULL, 'ciawi'),
(694, 'Bina Jaya Putra', '61890', 'cinere', 0, 0, NULL, '$2y$12$bnatvJ4ULyaPJolmY7EtyOTKbp3kyJT/KJ3brzK0wZWVTF38wvc.K', NULL, '2026-08-19 14:19:20', '2026-08-20 02:35:39', NULL, 'cinere'),
(695, 'Aldo Syahputra Cahayadi', '61891', 'ciawi', 0, 0, NULL, '$2y$12$8BQ1xlfxUDfArCj.6wXtZ.YJ0xt0XGremGL65AylnJ./hzANzT9CS', NULL, '2026-08-19 14:19:20', '2026-08-20 02:35:39', NULL, 'ciawi'),
(696, 'Yongki Indrasrianto', '62065', 'ciawi', 0, 0, NULL, '$2y$12$CWVwAD4n/siOdHTYcdasoOYDzxCK6vxhZGTRvuLcqdTqTfyfjWUIy', NULL, '2026-08-19 14:19:21', '2026-08-20 02:35:40', NULL, 'ciawi'),
(697, 'Dini Wahyuni', '62066', 'ciawi', 0, 0, NULL, '$2y$12$5ddHWODGvnsWH08ORGi3QOpBMamla4yIq7/2GwB5jBav4HreFC8eu', NULL, '2026-08-19 14:19:21', '2026-08-20 02:35:40', NULL, 'ciawi'),
(698, 'Munna Apriani', '62067', 'cinere', 0, 0, NULL, '$2y$12$kR2L1OIsvY9GO.fHvCHXMOcV/FxzAVlqHeIBp7svbpTWaDyPce.A6', NULL, '2026-08-19 14:19:21', '2026-08-20 02:35:41', NULL, 'cinere'),
(699, 'DANIE FEBRIANSYAH T, ST', '62116', 'jatiasih', 0, 0, NULL, '$2y$12$U8SnvAAgbOOh1XX1ZlNj1e.3bMeBj3bvyOMEyHKn86WxNdg6Llpc6', NULL, '2026-08-19 14:19:22', '2026-08-20 02:35:41', 'bm_sh', 'jatiasih'),
(700, 'MUHAMAD RIZKY', '62117', 'jatiasih', 0, 0, NULL, '$2y$12$SHeD08vCn7TDxKXq9TzwVeCdAe.aIpr1mnljyQ6ks7OenDvwZ204G', NULL, '2026-08-19 14:19:22', '2026-08-20 02:35:41', NULL, 'jatiasih'),
(701, 'ANGGRAH', '62118', 'jatiasih', 0, 0, NULL, '$2y$12$1VRg19ZKAVjfBQJZw/NKiuLyq6mV0UVkA7NZxfSWcJvv6nEqcYnKO', NULL, '2026-08-19 14:19:22', '2026-08-20 02:35:42', NULL, 'jatiasih'),
(702, 'ALFREDO AQUINO JOSEPH T', '62119', 'jatiasih', 0, 0, NULL, '$2y$12$bn7C.bcw//cgTBpZLAJjKuTb1B/whEom3LpsTJlZbwHnbu3EInj4W', NULL, '2026-08-19 14:19:23', '2026-08-20 02:35:42', NULL, 'jatiasih'),
(703, 'GERITZ TRESNA PUTRA AGAN', '62120', 'jatiasih', 0, 0, NULL, '$2y$12$xbYavYaDoSlbrDLW9OIwIuTgHCoVRhQne4onblRLh3VGme1FNtpD2', NULL, '2026-08-19 14:19:23', '2026-08-20 02:35:43', NULL, 'jatiasih'),
(704, 'HAFSHAH KAMILA', '62121', 'jatiasih', 0, 0, NULL, '$2y$12$pJ1iFCIj7PH6EMrbVtU7auli5UYXFayRB2in3TSZmF/3fqqumiVIm', NULL, '2026-08-19 14:19:23', '2026-08-20 02:35:43', NULL, 'jatiasih'),
(705, 'HERI SINDI WIJAYA', '62137', 'jatiasih', 0, 0, NULL, '$2y$12$p7rgoNZxY0YmPezSIaDq6OyHlF/QLDZTC1aAO1dXYvp.xxGyt6UY2', NULL, '2026-08-19 14:19:23', '2026-08-20 02:35:44', NULL, 'jatiasih'),
(706, 'VIVI SETIYOWATI', '62138', 'jatiasih', 0, 0, NULL, '$2y$12$8Uj/t9jhljzYShdm.n9Oi.W1bfuwZ/M8PL59cWK1BzIUYir0sEwNy', NULL, '2026-08-19 14:19:24', '2026-08-20 02:35:44', NULL, 'jatiasih'),
(707, 'NURDIN', '62152', 'ciawi', 0, 0, NULL, '$2y$12$Co2suMCTvzwv5sRASLXtUeuvD.A2bcwBxLC.w68jUonQYkibzsQCW', NULL, '2026-08-19 14:19:24', '2026-08-20 02:35:45', NULL, 'ciawi'),
(708, 'MOCH IMRON', '62154', 'ciawi', 0, 0, NULL, '$2y$12$d1Tn8kULy2tCZz9UbknbEelsQHjApxL9VGgVvRKUlLVB3mLzGixN6', NULL, '2026-08-19 14:19:24', '2026-08-20 02:35:45', NULL, 'ciawi'),
(709, 'Muhammad Ramji Fahmi', '62290', 'jatiasih', 0, 0, NULL, '$2y$12$t/3ygx5jfho14yYFkYeSk.886ocAoMZ7MGDn.vTSu7TyrYTEAMbpu', NULL, '2026-08-19 14:19:24', '2026-08-20 02:35:46', NULL, 'jatiasih'),
(710, 'Verasari Noviyanti', '62344', 'cinere', 0, 0, NULL, '$2y$12$EdMbU/Jdn7JwdijvmDTW8.UlLTHxL6cwyjPWkS3Luzknf8O4kUVxS', NULL, '2026-08-19 14:19:25', '2026-08-20 02:35:46', NULL, 'cinere'),
(711, 'ERIK MUNANDAR', '62498', 'ciawi', 0, 0, NULL, '$2y$12$qwKNF9mNijG5UiLhnS06q.BwN1toP5F1Q2TzoW/yqDpfnHglDv6Ei', NULL, '2026-08-19 14:19:25', '2026-08-20 02:35:47', NULL, 'ciawi'),
(712, 'GALUH TOPANDY', '62527', 'jatiasih', 0, 0, NULL, '$2y$12$/CsaxLeckFaWdoDym8Uwle19ZPDdblQdfRN622j40332K0KfC/ynm', NULL, '2026-08-19 14:19:25', '2026-08-20 02:35:47', NULL, 'jatiasih'),
(713, 'RIFAN HADI SUKMANA', '62618', 'jatiasih', 0, 0, NULL, '$2y$12$lbRTql5iShiap7gqAJ9npOzIadRzJyvEXMUtU5jr4nlYMJqSFyXt6', NULL, '2026-08-19 14:19:26', '2026-08-20 02:35:48', NULL, 'jatiasih'),
(714, 'MAULANA ZIKRI', '62619', 'jatiasih', 0, 0, NULL, '$2y$12$tX7zYZ1X0ES/rXkt.R1YzuyLssVMDibQQo6/.sfjRonv/pfZpWvmy', NULL, '2026-08-19 14:19:26', '2026-08-20 02:35:48', NULL, 'jatiasih'),
(715, 'Fanny Oktaviani Benyamin', '62624', 'ciawi', 0, 0, NULL, '$2y$12$KfEKz14FbkleEgOou9ciVu4oTyixGfN30Rq3LrY3/wEdmY7.dxEf2', NULL, '2026-08-19 14:19:26', '2026-08-20 02:35:49', NULL, 'ciawi'),
(716, 'Jimmy Sasube', '62626', 'ciawi', 0, 0, NULL, '$2y$12$qQPevsHo7fZA/eY4URUscegdSZAw1pNhgfaULfXn2Y59.eJVFixt2', NULL, '2026-08-19 14:19:26', '2026-08-20 02:35:49', NULL, 'ciawi'),
(717, 'Wahyu Salfindo', '62627', 'ciawi', 0, 0, NULL, '$2y$12$Xrqxxv8R5k3V5UEdQe7nkOekO.iBUPcFaaDDLz/KXM8U.3IbCFeZe', NULL, '2026-08-19 14:19:27', '2026-08-20 02:35:50', NULL, 'ciawi'),
(718, 'Tanjung Firmansyah', '62628', 'ciawi', 0, 0, NULL, '$2y$12$SDr.iqnsU/gC2K0KOHVuFu1Z68AZZDmK6ri/zst2tyUK/OK3kt0DK', NULL, '2026-08-19 14:19:27', '2026-08-20 02:35:50', NULL, 'ciawi'),
(719, 'Yulia Mardiana', '62646', 'ciawi', 0, 0, NULL, '$2y$12$9Lq6namXPl7oqvemoqtuBeL2aScJ7bhbAH6TLB.ryVXGCb7VKSX4u', NULL, '2026-08-19 14:19:27', '2026-08-20 02:35:51', NULL, 'ciawi'),
(720, 'BENNY KURNIAWAN', '62652', 'ciawi', 0, 0, NULL, '$2y$12$seXrUiREewwZVLlGYqMuFOvNXBdoy3ma/uVeWnZeaz40C.qyinmgK', NULL, '2026-08-19 14:19:28', '2026-08-20 02:35:51', NULL, 'ciawi'),
(721, 'TAUFIK HIDAYAT', '62690', 'ciawi', 0, 0, NULL, '$2y$12$zELhxJcrOKGtnaUSZF/fKOvo65KyXqTviQkZiQIWcz8FMIoa.76By', NULL, '2026-08-19 14:19:28', '2026-08-20 02:35:51', NULL, 'ciawi'),
(722, 'IKA KARTIKA', '62691', 'ciawi', 0, 0, NULL, '$2y$12$k8xzFyxWOpX5GRk5QHL9PuDrZUXtP5aB2JUwLYKtQYbV1raCEq22G', NULL, '2026-08-19 14:19:28', '2026-08-20 02:35:52', NULL, 'ciawi'),
(723, 'Zainal Abidin', '62692', 'cinere', 0, 0, NULL, '$2y$12$29fA.51bLaug4loL0nT0NeLirYC0LgiygW4BmzLrE5wiUP6G9k7zG', NULL, '2026-08-19 14:19:28', '2026-08-20 02:35:52', NULL, 'cinere'),
(724, 'Rizki Maulana', '62693', 'cinere', 0, 0, NULL, '$2y$12$neaF4KFkS2b5Rot5RNcfi.dlkuEfrWNIq.NRDpchJRyIERYGj0fgC', NULL, '2026-08-19 14:19:29', '2026-08-20 02:35:53', NULL, 'cinere'),
(725, 'Rudi', '62716', 'cianjur', 0, 0, NULL, '$2y$12$8TYZzmRt4PNaumoZN3.Ie.oN/9ug7vfwQMzK0EfyMjsLPueY/IPIi', NULL, '2026-08-19 14:19:29', '2026-08-20 02:35:53', NULL, 'cianjur'),
(726, 'Asep Nurhabibi', '62718', 'cianjur', 0, 0, NULL, '$2y$12$O4Sg7r8Kg3JN4k6GAjRINOkHVJ3HpO4My/edaHWV1ATnz9Js3D5fW', NULL, '2026-08-19 14:19:29', '2026-08-20 02:35:54', NULL, 'cianjur'),
(727, 'Yuni Siti Nurmilah', '62828', 'cianjur', 0, 0, NULL, '$2y$12$DFRwbwXKTxD0JfFBfxvzXuwJXxOr09hokI8/XjPeTRtlACOF6iyyu', NULL, '2026-08-19 14:19:29', '2026-08-20 02:35:54', NULL, 'cianjur'),
(728, 'RIZKI ARDIANSYAH', '63049', 'ciawi', 0, 0, NULL, '$2y$12$aJk6Rsa5pvietmFurxmjYOfwcaXeVgoD.FoLLQplWQ/eKMVMsze0q', NULL, '2026-08-19 14:19:30', '2026-08-20 02:35:55', NULL, 'ciawi'),
(729, 'TARYANA', '63050', 'ciawi', 0, 0, NULL, '$2y$12$3tUc2C/c/56xY5DZEEDGYupGrYvLrU9WgTeeI1fyNvV5/8EOuUuX6', NULL, '2026-08-19 14:19:30', '2026-08-20 02:35:55', NULL, 'ciawi'),
(730, 'Rangga Adhiguna Nugraha', '63052', 'cianjur', 0, 0, NULL, '$2y$12$bnsAaT9FryxcmoVzObIjCuv8/sAgQhL/6PjqH3HIOn42Qp73Bo3jC', NULL, '2026-08-19 14:19:30', '2026-08-20 02:35:56', NULL, 'cianjur'),
(731, 'JAMIL MUROD', '63089', 'cinere', 0, 0, NULL, '$2y$12$Heb.0Wl23BZKOKL1wlnSyeZGKckXKsgGgBVNUKl2Ndj.WXPcRu9I6', NULL, '2026-08-19 14:19:31', '2026-08-20 02:35:56', NULL, 'cinere'),
(732, 'RICKY NURMANSYAH', '63090', 'cinere', 0, 0, NULL, '$2y$12$tZ6.j8HWR.1l.9ULMwXSTuhnBQcERHOzS0Qrn.9/X4CZn0CX4ywv2', NULL, '2026-08-19 14:19:31', '2026-08-20 02:35:57', NULL, 'cinere'),
(733, 'Rizki Maulana', '63091', 'cinere', 0, 0, NULL, '$2y$12$Kp318KDGz/TrImOQUhRrduc./ZBXiNMQCEtSQFDaIhM8MkyAmR.H2', NULL, '2026-08-19 14:19:31', '2026-08-20 02:35:57', NULL, 'cinere'),
(734, 'Thoriq Nasrullah', '63093', 'cinere', 0, 0, NULL, '$2y$12$sNzeiLqWzyRlQ7cHmhnbX.hq94sROL.s5mBYKs0KDjq/tD7qGcApC', NULL, '2026-08-19 14:19:31', '2026-08-20 02:35:58', NULL, 'cinere'),
(735, 'Andi Pratama', '63094', 'cinere', 0, 0, NULL, '$2y$12$RIcFINt8ElO9kX.jvDYC1.M1khZ44fepcEH95ZghhkfJiWEl2ceTi', NULL, '2026-08-19 14:19:32', '2026-08-20 02:35:58', NULL, 'cinere'),
(736, 'Zaky Nur Fauzan', '63095', 'cinere', 0, 0, NULL, '$2y$12$A4ILoYpP86im5NOSW8TMp.eY6.hoR9EbzW/51R8YhjIDdefmCNMMy', NULL, '2026-08-19 14:19:32', '2026-08-20 02:35:59', NULL, 'cinere'),
(737, 'Nugraha Jaya Permana', '63169', 'cianjur', 0, 0, NULL, '$2y$12$G4GSpQM.J1HuG6Wo4VHLCeXx2FPx8KRauL9kIr/.T6CQrhk1A.Nbm', NULL, '2026-08-19 14:19:32', '2026-08-20 02:36:00', NULL, 'cianjur'),
(738, 'Dimas Suryaman', '63171', 'ciawi', 0, 0, NULL, '$2y$12$dRLUL/se1.u9OYkvvZoaHu.fVFM8whZdXN6CH9y0aI9KjepgiVNJ2', NULL, '2026-08-19 14:19:32', '2026-08-20 02:36:01', NULL, 'ciawi'),
(739, 'Yudi Ruswandi', '63175', 'ciawi', 0, 0, NULL, '$2y$12$lV1t76GjP8Qh6peYV58G3.zSVLh9DYv0dVhlxLCewHuc6JMuihJbi', NULL, '2026-08-19 14:19:33', '2026-08-20 02:36:01', NULL, 'ciawi'),
(740, 'PRASETYANTO TAKA NUHAMARA, SE', '63176', 'jatiasih', 0, 0, NULL, '$2y$12$kFM0abh5jbLNjmOtPWOdSOJF29V9g2R0RfSP8MHIgXa2KR/SnIRr2', NULL, '2026-08-19 14:19:33', '2026-08-20 02:36:02', NULL, 'jatiasih'),
(741, 'Alnov Prakoso Putra', '63186', 'cinere', 0, 0, NULL, '$2y$12$E4ufOZ5jeXYrDwR1nVble.mLPL89yFbvVPfvj/A9QYmFZeAcX5zka', NULL, '2026-08-19 14:19:33', '2026-08-20 02:36:02', NULL, 'cinere'),
(742, 'Putri Winarni', '63219', 'ciawi', 0, 0, NULL, '$2y$12$UVLXpWDzBsb0mmqvQ0/ThOyR6S1vkG6t3r1rJmC/H8UD6abpJvPGm', NULL, '2026-08-19 14:19:34', '2026-08-20 02:36:03', NULL, 'ciawi'),
(743, 'Esti Setianingsih', '63280', 'cinere', 0, 0, NULL, '$2y$12$0EaiHFHdjt6mqt2V9MV6L.zdFQpebhehaDwRHw3PPD82dlEK8mXFu', NULL, '2026-08-19 14:19:34', '2026-08-20 02:36:03', NULL, 'cinere'),
(744, 'RIKA ARIYANTI', '6335', 'ciawi', 0, 0, NULL, '$2y$12$YcnQIC8xiUsdUePt40tSnu/eVY4e7AFCczOBdz8Lrb3iqxd1f8Hsu', NULL, '2026-08-19 14:19:34', '2026-08-20 02:36:04', NULL, 'ciawi'),
(745, 'Mochmad Reva Izma Sembara', '63371', 'cianjur', 0, 0, NULL, '$2y$12$3XQaiCKOtbwr5trYFBv5YefG5AwFdACrSyLn3IzJpBcVd5egL9U4S', NULL, '2026-08-19 14:19:34', '2026-08-20 02:36:04', NULL, 'cianjur'),
(746, 'Susilawati', '63372', 'cianjur', 0, 0, NULL, '$2y$12$sblWEMhaKj6VUN5PtmcvVudymXWMjZwa8ip9YY52QZOfSRPqraTh2', NULL, '2026-08-19 14:19:35', '2026-08-20 02:36:05', NULL, 'cianjur'),
(747, 'PIYAH', '63584', 'jatiasih', 0, 0, NULL, '$2y$12$wEaMsvhMnTYh6CFqL.uAoeozFcsogOOqMxsWy47JPUXUWv6mSsFze', NULL, '2026-08-19 14:19:35', '2026-08-20 02:36:07', NULL, 'jatiasih'),
(748, 'MUHAMMAD NIKO YUDHA', '63585', 'jatiasih', 0, 0, NULL, '$2y$12$e17HFdCMT5DmegX/S6OyEuUo2kuiU5yDDr3SWAJiiQ6D.lPfoSJky', NULL, '2026-08-19 14:19:36', '2026-08-20 02:36:07', NULL, 'jatiasih'),
(749, 'HERMAWAN SUTIAWAN', '63588', 'jatiasih', 0, 0, NULL, '$2y$12$Gg8shSUu.9sQkeoQ3W.Rye4vV07Ud/KMdcQuICo/SHnR.lQTs92Ui', NULL, '2026-08-19 14:19:36', '2026-08-20 02:36:08', NULL, 'jatiasih'),
(750, 'MICHAEL EPENDI', '63589', 'jatiasih', 0, 0, NULL, '$2y$12$hcHmAxIAW9T.4o2P0CRYFuiCgIxz2MHpb3xEKDD94kOnmVL7wkEWG', NULL, '2026-08-19 14:19:36', '2026-08-20 02:36:08', NULL, 'jatiasih'),
(751, 'ELIZABETH SRIDEWI', '63590', 'jatiasih', 0, 0, NULL, '$2y$12$BpuCj6ysMRbnTdLYDry5Me.v73aTgX3nV7FV927jz/vlH2OsvkN2K', NULL, '2026-08-19 14:19:36', '2026-08-20 02:36:09', NULL, 'jatiasih'),
(752, 'Roni Mardhani', '63591', 'jatiasih', 0, 0, NULL, '$2y$12$1GNUZIIjplJIHv4rmDzeBuiF7PGJhUF1uJx77xbDMlTotKrfSK/Xe', NULL, '2026-08-19 14:19:37', '2026-08-20 02:36:09', NULL, 'jatiasih'),
(753, 'Atika Nur Azizah', '63592', 'jatiasih', 0, 0, NULL, '$2y$12$agaRnXIHe3/YkAhwppmEdOXzmtvUDHCB.nR0ejIJmfn2IQae6XRFm', NULL, '2026-08-19 14:19:37', '2026-08-20 02:36:10', NULL, 'jatiasih'),
(754, 'ISWANTO', '63593', 'jatiasih', 0, 0, NULL, '$2y$12$DWvLZGavYgQZ4T9sxZ7hb.M5Y/Gv91ZW.kVwQ6DoxXbFKtxBYktl.', NULL, '2026-08-19 14:19:37', '2026-08-20 02:36:11', NULL, 'jatiasih'),
(755, 'Siti Aisyah', '63594', 'jatiasih', 0, 0, NULL, '$2y$12$qzWQd0SgNOFRnuyWl8kQ4ejuHGMTLSjkC8a9LBp..EexyXn7A1xfO', NULL, '2026-08-19 14:19:37', '2026-08-20 02:36:12', NULL, 'jatiasih'),
(756, 'niko hermawan', '63595', 'jatiasih', 0, 0, NULL, '$2y$12$ZkKNr62Tft44OFS03iQNCO22X0B8pnE10ycQytRPkjb/I/n/YrEVe', NULL, '2026-08-19 14:19:38', '2026-08-20 02:36:12', NULL, 'jatiasih'),
(757, 'Ichsan Fachrurozi', '63598', 'jatiasih', 0, 0, NULL, '$2y$12$Z8o1E7mzIvBPeTgcCe11l.P1hzyj2Pd8flDUWpB2kfl5CwRiSjj0i', NULL, '2026-08-19 14:19:38', '2026-08-20 02:36:13', NULL, 'jatiasih'),
(758, 'Mutmaina', '63599', 'jatiasih', 0, 0, NULL, '$2y$12$oSt0RPEk3Jn3aaVvJ/CUdeIHxsH.ERVEVVthfjJEK5li2gDzMQHvK', NULL, '2026-08-19 14:19:38', '2026-08-20 02:36:14', NULL, 'jatiasih'),
(759, 'Feri Fadli', '63600', 'jatiasih', 0, 0, NULL, '$2y$12$CLhCqG0x8iAiwIaYs05CGuULBEvJsDKsHR3m3.KYRMWFH.9afULuO', NULL, '2026-08-19 14:19:39', '2026-08-20 02:36:15', NULL, 'jatiasih'),
(760, 'Bintang Muda', '63601', 'jatiasih', 0, 0, NULL, '$2y$12$7icxKQasC0X6Z2bQka/KZ.1P6VLkT.i1rVFGqzF4uV/TnINjam.5G', NULL, '2026-08-19 14:19:39', '2026-08-20 02:36:15', NULL, 'jatiasih'),
(761, 'Bella Franciska', '63602', 'jatiasih', 0, 0, NULL, '$2y$12$tVJShy.p9L.bPKklMphYju9pal7nHxMTronmTu2v.YjBguWZLF1wa', NULL, '2026-08-19 14:19:39', '2026-08-20 02:36:16', NULL, 'jatiasih'),
(762, 'Nixon Turnip', '63603', 'jatiasih', 0, 0, NULL, '$2y$12$OQ9Xl7CT.rNfjOgdp6X/Ju3UoNVN4VwFW1k9vx8t0QHksb1qETJg6', NULL, '2026-08-19 14:19:39', '2026-08-20 02:36:16', NULL, 'jatiasih'),
(763, 'imam fauzi', '63604', 'jatiasih', 0, 0, NULL, '$2y$12$9i4v7JKqXcwI30NLSK0D/emlGeedwghltM6wKdIRU3.i1hPdxe45a', NULL, '2026-08-19 14:19:40', '2026-08-20 02:36:17', NULL, 'jatiasih'),
(764, 'Siti Nurohmah', '63605', 'jatiasih', 0, 0, NULL, '$2y$12$e2..B/xlOyZ3vlUYTri.leh9zCgEXoe.5kCngKEol9nVf2/rInJJy', NULL, '2026-08-19 14:19:40', '2026-08-20 02:36:17', NULL, 'jatiasih'),
(765, 'Aurinda Setyanyngrum', '63606', 'jatiasih', 0, 0, NULL, '$2y$12$DWYlFDKKFAatEsSQCkFB3u8aFhVaQmVQZLdjsfT2xN6y2kId7aqwS', NULL, '2026-08-19 14:19:40', '2026-08-20 02:36:18', NULL, 'jatiasih'),
(766, 'Muhammad Naufal Arrafi', '63607', 'jatiasih', 0, 0, NULL, '$2y$12$PIa6zqgpt1uY2iDNAuXa7euaPrEgYDRjM26Z3E84QYARU.Ne7MvsW', NULL, '2026-08-19 14:19:40', '2026-08-20 02:36:18', NULL, 'jatiasih'),
(767, 'Nur Syaliyah', '63608', 'jatiasih', 0, 0, NULL, '$2y$12$nKwEoM7RvO21sLXIIo9C0O4WfeoCMhu0i3bs0ARf05JwJHQFTrAHK', NULL, '2026-08-19 14:19:41', '2026-08-20 02:36:19', NULL, 'jatiasih'),
(768, 'mylani kartika putri', '63609', 'jatiasih', 0, 0, NULL, '$2y$12$bnxWgmFGm0x.Qupqfc34Muhv8X4EIUCX7m0KRF7i69shcGog8cLoi', NULL, '2026-08-19 14:19:41', '2026-08-20 02:36:19', NULL, 'jatiasih'),
(769, 'Gatot Budi Setio', '63610', 'jatiasih', 0, 0, NULL, '$2y$12$v5FCiOK9gdyPObVmemqBpOCMnWGnLRhY2yKyWwESjNGUATQcriyxO', NULL, '2026-08-19 14:19:41', '2026-08-20 02:36:20', NULL, 'jatiasih'),
(770, 'Alfan Hamdi', '63611', 'jatiasih', 0, 0, NULL, '$2y$12$H.t9vPOWWXEWZT49cy8e..SeqX6wVMTvxf62o/qN0Wc1yjZ0JIDU2', NULL, '2026-08-19 14:19:42', '2026-08-20 02:36:20', NULL, 'jatiasih'),
(771, 'Haris Rusdiyat', '63612', 'jatiasih', 0, 0, NULL, '$2y$12$ikI1RGTg56cO/O31qhuhV.f8U1YPMYbScQK3bYkGQ6v7qzaJo7BH6', NULL, '2026-08-19 14:19:42', '2026-08-20 02:36:21', NULL, 'jatiasih'),
(772, 'Asis Budiyono', '63613', 'jatiasih', 0, 0, NULL, '$2y$12$O8hHqG9qVMp6PVFToVsYW.M.WvflyBXMkQ2XHyfrD71I0HccrdYQC', NULL, '2026-08-19 14:19:42', '2026-08-20 02:36:21', NULL, 'jatiasih'),
(773, 'Muhammad Zidan', '63614', 'cinere', 0, 0, NULL, '$2y$12$HJu9zPF3nQkXrJfbGO4JB.EabvD5brRJtU1m.ySh35fZshFlfML7G', NULL, '2026-08-19 14:19:42', '2026-08-20 02:36:21', NULL, 'cinere'),
(774, 'Sandi Stanza', '63615', 'cinere', 0, 0, NULL, '$2y$12$oiXdnKCYQmEUX6bOIFnRt.3qhyBe56wjsrOuMThERztgWTSOHYwrO', NULL, '2026-08-19 14:19:43', '2026-08-20 02:36:22', NULL, 'cinere'),
(775, 'Yusril Fajar Setiawan', '63616', 'cinere', 0, 0, NULL, '$2y$12$Z9AN/jqbw9eaUcVBC4bCV.TQN4A3767x92hT8GxfnUNSH9TcW7qvW', NULL, '2026-08-19 14:19:43', '2026-08-20 02:36:23', NULL, 'cinere'),
(776, 'Ujang Junaidi', '63617', 'cinere', 0, 0, NULL, '$2y$12$9vs/27Go7AvO0Z7NW8ukDuUnyPIX/cNjFC.5uBTt9OJDnYUGZ.Mrq', NULL, '2026-08-19 14:19:43', '2026-08-20 02:36:23', NULL, 'cinere'),
(777, 'Fentage Prasetya', '63618', 'cinere', 0, 0, NULL, '$2y$12$RqjG4pMRIeBijjWrrBI0MuU/pogxDVsP8VihTFAiscpHLFA9jlCze', NULL, '2026-08-19 14:19:44', '2026-08-20 02:36:24', NULL, 'cinere'),
(778, 'Monica Husada', '63619', 'cinere', 0, 0, NULL, '$2y$12$T4z/ePapT2.3cMQHJ5szg./.c.41V.5BKMzwlLhW8zp0VJEnIyG5i', NULL, '2026-08-19 14:19:44', '2026-08-20 02:36:25', NULL, 'cinere'),
(779, 'Anggraini Tasya', '63620', 'cinere', 0, 0, NULL, '$2y$12$498n.4CjLHij2OtoWU9vQezaYwfvwiLb66N5JQJc7BOKbnNwgXlMO', NULL, '2026-08-19 14:19:44', '2026-08-20 02:36:26', NULL, 'cinere'),
(780, 'Dimas Ageng J', '63621', 'ciawi', 0, 0, NULL, '$2y$12$4kj20Zu1j2e7vlHS8N22BegYC7jFWg3cr7IAJdZG3NEcFhN97cro6', NULL, '2026-08-19 14:19:44', '2026-08-20 02:36:26', NULL, 'ciawi'),
(781, 'Budi Irawan', '63622', 'cianjur', 0, 0, NULL, '$2y$12$.f9NtlsvAzQoAQgC4Uerd.gNzN4LcIfDzfjxT7twV/Q55y9P6ZKfu', NULL, '2026-08-19 14:19:45', '2026-08-20 02:36:27', NULL, 'cianjur'),
(782, 'Eka Linjana Saputra', '63623', 'cianjur', 0, 0, NULL, '$2y$12$DAwKQMcFaFPUyBMX0Ocla.t38j9ZJQrqwPC688PjRD5VcQSTRVT1y', NULL, '2026-08-19 14:19:45', '2026-08-20 02:36:28', NULL, 'cianjur'),
(783, 'Hadi', '63624', 'jatiasih', 0, 0, NULL, '$2y$12$smGrR5vjys28.u6Yx0w9TegbHoUEA738jo.Idmb7BVxYzSWdDU19C', NULL, '2026-08-19 14:19:45', '2026-08-20 02:36:28', NULL, 'jatiasih'),
(784, 'Fahmi Lengga Pahlevi', '63625', 'cianjur', 0, 0, NULL, '$2y$12$wxl0WjYn/U9NDMJH2gU05eKfwtsTm4FnBvhlioNeUgRmYJC1UJ1lK', NULL, '2026-08-19 14:19:45', '2026-08-20 02:36:29', NULL, 'cianjur'),
(785, 'Faizal Shahri', '63626', 'cianjur', 0, 0, NULL, '$2y$12$BhSetSuSmpV6TVqPEU1eEOfPtGmyPXWJ3xR1ajKItyp/NaFjTerYq', NULL, '2026-08-19 14:19:46', '2026-08-20 02:36:29', NULL, 'cianjur'),
(786, 'Vickry Teguh Abdulah Tarigan', '63627', 'cianjur', 0, 0, NULL, '$2y$12$HrnoaInf31ZhuZIXcsoPguJNolUrvVazypRDhG8yXOdEOEVowsE8m', NULL, '2026-08-19 14:19:46', '2026-08-20 02:36:30', NULL, 'cianjur'),
(787, 'Yulianingsih', '63628', 'cianjur', 0, 0, NULL, '$2y$12$Zk8IEFrIZ7QCnj/nndYfW..fiIeZNla7ScNAiWg/sRvYbh/MUG3Aa', NULL, '2026-08-19 14:19:46', '2026-08-20 02:36:30', NULL, 'cianjur'),
(788, 'Muhammad Achviana', '63629', 'cianjur', 0, 0, NULL, '$2y$12$s3O/bCYcD2L9EPqROqazzeWcueP93rn3IjU3dEywCOibiwThSEEuK', NULL, '2026-08-19 14:19:47', '2026-08-20 02:36:31', NULL, 'cianjur'),
(789, 'Ade Sofyan', '63630', 'cianjur', 0, 0, NULL, '$2y$12$wepw8jW5WEG3jRENGQMEtOzpyjLyqGJvoQWP53pNmjruTYbRKWow2', NULL, '2026-08-19 14:19:47', '2026-08-20 02:36:31', NULL, 'cianjur'),
(790, 'Ulfah Faridah', '63631', 'cianjur', 0, 0, NULL, '$2y$12$mJ3n2focwODmtD8Nvd9m.Ou6r2ZUcpNynwqmXi.Swl6AooT/jWUZ6', NULL, '2026-08-19 14:19:47', '2026-08-20 02:36:31', NULL, 'cianjur'),
(791, 'Muhamad Chandra Wiguna', '63632', 'cianjur', 0, 0, NULL, '$2y$12$aCOLakutWKWKtbsXYspwl.9mqoLKiM7GBg3J5D9fsKLBO5O143Jtq', NULL, '2026-08-19 14:19:47', '2026-08-20 02:36:32', NULL, 'cianjur'),
(792, 'Dede Pendi', '63633', 'cianjur', 0, 0, NULL, '$2y$12$zgRPX0htpa0nWk6ZdHs1HubakQtXjdr1uS9NNExWMN0vJdzwOBfem', NULL, '2026-08-19 14:19:48', '2026-08-20 02:36:32', NULL, 'cianjur'),
(793, 'Kevin Matheus', '63634', 'cinere', 0, 0, NULL, '$2y$12$qkJ8Z/VWJgWM0eZ.Aoo76O5qWp8neB9N9ahAxUuZ7HYQdzH19BNlO', NULL, '2026-08-19 14:19:48', '2026-08-20 02:36:33', NULL, 'cinere'),
(794, 'August Rinaldi', '63635', 'cinere', 0, 0, NULL, '$2y$12$F5xz8e3vfS4iISnboEKp/eiwQB6Sl2Jwlsrm6xlpBbktJYLlYPu/S', NULL, '2026-08-19 14:19:48', '2026-08-20 02:36:33', NULL, 'cinere');
INSERT INTO `users` (`id`, `name`, `email`, `branch`, `is_admin`, `is_admin_stock`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `cabang`) VALUES
(795, 'Yusron Rizky', '63636', 'ciawi', 0, 0, NULL, '$2y$12$iHgkVN0QxxEiAscZAlq/rO02L1JD1MhjFByAba/T6HaXm7pVmweZi', NULL, '2026-08-19 14:19:48', '2026-08-20 02:36:34', NULL, 'ciawi'),
(796, 'M Adi Setyo', '63637', 'ciawi', 0, 0, NULL, '$2y$12$fhiLa8LkglZgCciFJj2fN.7zlIAEhzi6xKK6kHn5yY5CXo3HZyKlK', NULL, '2026-08-19 14:19:49', '2026-08-20 02:36:34', NULL, 'ciawi'),
(797, 'Irsan Walidin', '63638', 'ciawi', 0, 0, NULL, '$2y$12$g.OXyNU5GNMBg1FdTt9SZuQWZO3GAUm5hCqcbrqSZunXbBL4/hifq', NULL, '2026-08-19 14:19:49', '2026-08-20 02:36:36', NULL, 'ciawi'),
(798, 'Ian Elman', '63639', 'ciawi', 0, 0, NULL, '$2y$12$Tnku1Nzu8vz83b4wgWd2tuC0eSM3LmD73eVCB9Ev56O8HMfGO0xh6', NULL, '2026-08-19 14:19:49', '2026-08-20 02:36:36', NULL, 'ciawi'),
(799, 'Luki Tri Budianto', '63843', 'ciawi', 0, 0, NULL, '$2y$12$rdcUgRBymxzXfzmtxAAdF.gy4vnbVh8ZEop9P6H/.svHltpZQdsKS', NULL, '2026-08-19 14:19:50', '2026-08-20 02:36:37', NULL, 'ciawi'),
(800, 'Fahrizal Islami', '63844', 'ciawi', 0, 0, NULL, '$2y$12$XNU9tmR7EltaRbCzs1vqs.tBBbE9oyLgnf628BVBnczidVkQQqfCO', NULL, '2026-08-19 14:19:50', '2026-08-20 02:36:37', NULL, 'ciawi'),
(801, 'Tuti Ariyani', '63845', 'ciawi', 0, 0, NULL, '$2y$12$HZI1qBolBcrDsoBeFpVtoemwTuGcfArkqcNxWrgeN.r1COGWECbLu', NULL, '2026-08-19 14:19:50', '2026-08-20 02:36:38', NULL, 'ciawi'),
(802, 'EMI IRMALASARI AGUSTINA', '64057', 'jatiasih', 0, 0, NULL, '$2y$12$ygYr5qFoRzEQZzq3gudxYubZplp9BJkefqECOfwFxIMymIrOeiqNq', NULL, '2026-08-19 14:19:50', '2026-08-20 02:36:38', NULL, 'jatiasih'),
(803, 'Suci Julaeha', '64058', 'jatiasih', 0, 0, NULL, '$2y$12$J3vGr9I6r9yArKWSmCeqnuR1LdcTpgqBUBswAi76HMkIxkXB9olju', NULL, '2026-08-19 14:19:51', '2026-08-20 02:36:38', NULL, 'jatiasih'),
(804, 'Reza Febby Haditya', '64171', 'cianjur', 0, 0, NULL, '$2y$12$OKtVrDEJt.pDjSFb6hExuucNMbG6C392zEmuq61cejyjcA3gY1FQa', NULL, '2026-08-19 14:19:51', '2026-08-20 02:36:39', NULL, 'cianjur'),
(805, 'NURJAMAN', '64172', 'cianjur', 0, 0, NULL, '$2y$12$EJdnfFL0E6TkTv.XXGn0KOzRq8pQ9xd9sQ38Pjc52Zj/ha6H4wqsC', NULL, '2026-08-19 14:19:51', '2026-08-20 02:36:39', NULL, 'cianjur'),
(806, 'SAPUTRI HERYAN SEPTIANA', '64173', 'cianjur', 0, 0, NULL, '$2y$12$onf7.9ykZSn3EdWiQDyWcOeEw2oGjZHnQh1GufTvM2NTfCluKVrby', NULL, '2026-08-19 14:19:52', '2026-08-20 02:36:40', NULL, 'cianjur'),
(807, '641940102-ITS', '641940102-its', 'cianjur', 0, 0, NULL, '$2y$12$ClmhEUITRJoRT6NaEpDiLejmT0Fb09EKwf2xgTgVptyPz2J1fdcpO', NULL, '2026-08-19 14:19:52', '2026-08-20 02:36:40', NULL, 'cianjur'),
(808, 'Uni Fadila', '64386', 'cinere', 0, 0, NULL, '$2y$12$kQYmN7xIzVnoT4fQ/3Wg2.VFhM4xtkv.2e9ExPPeciDQrQ5ihS2ji', NULL, '2026-08-19 14:19:52', '2026-08-20 02:36:41', NULL, 'cinere'),
(809, 'M ROCKY ROBERTINO', '64557', 'ciawi', 0, 0, NULL, '$2y$12$5S2548HXyuQ.ASP1ImcZJ..0080U70Ob3oWYiQ4MTKSI6/PZQX/0e', NULL, '2026-08-19 14:19:52', '2026-08-20 02:36:41', NULL, 'ciawi'),
(810, 'SITI IMA ROHIMAH', '64558', 'cianjur', 0, 0, NULL, '$2y$12$mKX9yrwA9HNYSbKg628h9e7rakIFk7hythP/osU3dyles6j1yJdwS', NULL, '2026-08-19 14:19:53', '2026-08-20 02:36:42', NULL, 'cianjur'),
(811, 'Fadlan Nakwil Maskhuri', '64646', 'cinere', 0, 0, NULL, '$2y$12$cUwkclw6/jf6rY1caKij2eWVaE.4DwztTmm8AG9HpgsVNdG1HZ4WC', NULL, '2026-08-19 14:19:53', '2026-08-20 02:36:43', NULL, 'cinere'),
(812, 'ILHAM FIRMANSYAH', '64672', 'cianjur', 0, 0, NULL, '$2y$12$1sJV2TsQIudw7AH92RN/3eAxBoQlwoS.bHPjebJycHpcgYQfYzPUC', NULL, '2026-08-19 14:19:54', '2026-08-20 02:36:44', NULL, 'cianjur'),
(813, 'Maolana Risyaldi', '64673', 'cinere', 0, 0, NULL, '$2y$12$anlAYc6GskEoU1m4FNf8UOlf3HiUzWDHPXDOcYRkHjVm7oCx.fLv6', NULL, '2026-08-19 14:19:54', '2026-08-20 02:36:44', NULL, 'cinere'),
(814, 'RESA NADIA', '64707', 'cianjur', 0, 0, NULL, '$2y$12$ZG0DjAAPlcRr2abWk0W1POgi4ZMAsqAPcs8l4OHdMffZJgfGB1nMi', NULL, '2026-08-19 14:19:54', '2026-08-20 02:36:45', NULL, 'cianjur'),
(815, 'GERRY FITRA SOERYA GANDHARA', '64708', 'cianjur', 0, 0, NULL, '$2y$12$eA2.2IT08eFTKzfxkDXZ1eGBSLq3E9KaorMW3GGY6n4DRnrwv2NPK', NULL, '2026-08-19 14:19:54', '2026-08-20 02:36:45', NULL, 'cianjur'),
(816, 'WAHYUDIN', '64710', 'ciawi', 0, 0, NULL, '$2y$12$bp9Mba0ZrTPFdAiAvicUjeWpN58qw78X8DMvZ0OeVWOg.O3M6OVQO', NULL, '2026-08-19 14:19:55', '2026-08-20 02:36:46', NULL, 'ciawi'),
(817, 'Arpian Prasetio', '64745', 'ciawi', 0, 0, NULL, '$2y$12$EFeBn0zXSauWbobFQWZq7OBDZp..Vg0fB2H7foSR0bmmcQrudPH66', NULL, '2026-08-19 14:19:55', '2026-08-20 02:36:47', NULL, 'ciawi'),
(818, 'Alfi Kamal', '64746', 'ciawi', 0, 0, NULL, '$2y$12$jmZxAghq6fw78TdUvup96O9KZGdiwSxwnvrO8bS4L5WtdnTlfFbIS', NULL, '2026-08-19 14:19:55', '2026-08-20 02:36:47', NULL, 'ciawi'),
(819, 'ANISA APRILIA', '64749', 'cianjur', 0, 0, NULL, '$2y$12$gfnOC8aOEni0h/aa9oqIG.LhFAib0YuEES4/vi4pID5b9NSgEIItG', NULL, '2026-08-19 14:19:56', '2026-08-20 02:36:48', NULL, 'cianjur'),
(820, 'Wahyu Salfindo', '64976', 'ciawi', 0, 0, NULL, '$2y$12$dQBiLqxbKwOmzXLxfx9ZQuy4AQxvuGAsxwIDayk1B1FFmzuMSxErK', NULL, '2026-08-19 14:19:56', '2026-08-20 02:36:48', NULL, 'ciawi'),
(821, 'Khalis Anzhari Yusran', '64991', 'jatiasih', 0, 0, NULL, '$2y$12$14itd0Bwgf4DrJyHigdpReJGJELMzrqwD45loDP0cA0EFFRsAYrXK', NULL, '2026-08-19 14:19:56', '2026-08-20 02:36:48', NULL, 'jatiasih'),
(822, 'Yudha Satria Permana', '65004', 'ciawi', 0, 0, NULL, '$2y$12$IS1xU.sQW4E3pQ6js3.WYOPlqe7HlhERjmAc8MlXUgeEQsKRxth7O', NULL, '2026-08-19 14:19:56', '2026-08-20 02:36:49', NULL, 'ciawi'),
(823, 'Deka Nurdiansyah', '65030', 'ciawi', 0, 0, NULL, '$2y$12$WTKLeVAPRaN1IGvmqER7Le3YKzDqyBQMxYjdbrDeNWnAqrxBH8XNm', NULL, '2026-08-19 14:19:57', '2026-08-20 02:36:50', NULL, 'ciawi'),
(824, 'ANGGI HANDRIAN', '65031', 'ciawi', 0, 0, NULL, '$2y$12$.rsIXg6qxV.FTdA8GfpHkO5GXX8gNjRJjCEKfsnLzYe4A8cKo9g4.', NULL, '2026-08-19 14:19:57', '2026-08-20 02:36:50', NULL, 'ciawi'),
(825, 'Muhamad Syafta Yanggi', '65056', 'ciawi', 0, 0, NULL, '$2y$12$MWjAStbhBV958oFslxjhX.sUgLpSfdIcHr7TvmANdxS24COOBNMDy', NULL, '2026-08-19 14:19:58', '2026-08-20 02:36:51', NULL, 'ciawi'),
(826, 'Ade Maulana', '65057', 'cinere', 0, 0, NULL, '$2y$12$qonsP3gt0xK86Kdz8Y0axuS2qtXBVchI1VbZkKcOJILXBtQ8.ezJ2', NULL, '2026-08-19 14:19:58', '2026-08-20 02:36:51', NULL, 'cinere'),
(827, 'Ridwan Ramadan', '65117', 'cianjur', 0, 0, NULL, '$2y$12$lT9VQ8DtjJUKk8bKqvJAYOsq0D8SGaEA7w1HZR4eAwJtq9NjubBaS', NULL, '2026-08-19 14:19:58', '2026-08-20 02:36:52', NULL, 'cianjur'),
(828, 'IRAWAN', '65222', 'ciawi', 0, 0, NULL, '$2y$12$NMVXFfbmb3EvQVGM5jUCq.WDcq8Ps/xg1w0PZ7KzaOgMRdG/lqeXC', NULL, '2026-08-19 14:19:58', '2026-08-20 02:36:53', NULL, 'ciawi'),
(829, 'RIANTO HIDAYAT', '65224', 'ciawi', 0, 0, NULL, '$2y$12$WPzMa40Der4llDU2sI0VluLOqu.uDOJ5CWLh2XrH0wCj2hAaQ4YQi', NULL, '2026-08-19 14:19:59', '2026-08-20 02:36:53', NULL, 'ciawi'),
(830, 'Deny febrianto', '65297', 'cinere', 0, 0, NULL, '$2y$12$bT3FV31oJ5jDYc4parP1ZeqSdoD1qghFtUmxfPoyNLHKBwqfy/EI.', NULL, '2026-08-19 14:19:59', '2026-08-20 02:36:54', NULL, 'cinere'),
(831, 'Muhammad Malik Ismail', '65298', 'cianjur', 0, 0, NULL, '$2y$12$7c9DiaavOTR7E/s5TJo23e2bChD4PRi36YuVSz6/zbSw544aolbcK', NULL, '2026-08-19 14:19:59', '2026-08-20 02:36:55', NULL, 'cianjur'),
(832, 'Rizal Tulaar', '65466', 'ciawi', 0, 0, NULL, '$2y$12$5D.LqCUNsbKkkpI0xG4d/O2p7TzgTiccCzkzjGkfi2tXkt0Qrjd/a', NULL, '2026-08-19 14:20:00', '2026-08-20 02:36:56', NULL, 'ciawi'),
(833, 'Rachman Septiana', '65476', 'ciawi', 0, 0, NULL, '$2y$12$LYURVZZoJxhVohzlP3YfdudMSaweC4Ma5ypXQUnZV/FuJn5xbOcb.', NULL, '2026-08-19 14:20:00', '2026-08-20 02:36:56', NULL, 'ciawi'),
(834, 'Yudhi hertanto', '65483', 'cinere', 0, 0, NULL, '$2y$12$PH0PIYTeUS1JKqgpnauX..ofC.5j5AEaw6HS7ksU2czEarWEb9Bo.', NULL, '2026-08-19 14:20:01', '2026-08-20 02:36:57', NULL, 'cinere'),
(835, 'Tiara syahputri', '65484', 'cinere', 0, 0, NULL, '$2y$12$PEDlHeQ4m97ODmVO5OqtnOgso19USaoKI9LTlh6vSly3vwrdatgUy', NULL, '2026-08-19 14:20:01', '2026-08-20 02:36:58', NULL, 'cinere'),
(836, 'Kamal ibrahim', '65488', 'cinere', 0, 0, NULL, '$2y$12$9GMQT.Xixd3UZlF2hTwz4.oR07862XqSDuZfVr6pw4FRosJ8ulMgK', NULL, '2026-08-19 14:20:01', '2026-08-20 02:36:58', NULL, 'cinere'),
(837, 'Khaira pradhana putri', '65493', 'cinere', 0, 0, NULL, '$2y$12$w.1MyyCGcWMQKdM48uD1T.bA4zuRf8ZHebz5zNKZNGuEZGZZfYuYi', NULL, '2026-08-19 14:20:02', '2026-08-20 02:36:59', NULL, 'cinere'),
(838, 'Sabhrina jalianti', '65494', 'cinere', 0, 0, NULL, '$2y$12$qH0J1ol228cAAcXzMNNZBOj4AGWicx7nr3B4ScjbgUMAC1qZdAJpu', NULL, '2026-08-19 14:20:02', '2026-08-20 02:37:00', NULL, 'cinere'),
(839, 'Febri hartanto', '65498', 'cinere', 0, 0, NULL, '$2y$12$KyMFa/vMNOi5SP3/t7ntGeFJPONDnjAvyFxq90iVZcKxqd/kWgvYS', NULL, '2026-08-19 14:20:03', '2026-08-20 02:37:00', NULL, 'cinere'),
(840, 'Tomi syahroni', '65504', 'cinere', 0, 0, NULL, '$2y$12$P5tFNom29TZ71TCFV3e9gOG8V5s/DjsROGvnSRLT9u0YBRKSrQZP.', NULL, '2026-08-19 14:20:03', '2026-08-20 02:37:01', NULL, 'cinere'),
(841, 'HENDRA IRAWAN', '65564', 'jatiasih', 0, 0, NULL, '$2y$12$eUA3iFHNGvNg6AASanyuOOyD7PMbPTqtSNQDjY6Y0FPFRgEBREXo2', NULL, '2026-08-19 14:20:04', '2026-08-20 02:37:01', NULL, 'jatiasih'),
(842, 'NUKE INDAH SARI', '65565', 'jatiasih', 0, 0, NULL, '$2y$12$7/zZlceHDZeMRbTXvW/hl.uwMwekLrdJ1P35rLMleRHw2N07WOYWu', NULL, '2026-08-19 14:20:04', '2026-08-20 02:37:02', NULL, 'jatiasih'),
(843, 'BERLIN KHARISMA TORANG MANIK, S.M', '65575', 'jatiasih', 0, 0, NULL, '$2y$12$N4cqHAF1V.j8md5bV6Owb.Eqgy4c6p8jZZhWMM0Won/MqfKroFnSu', NULL, '2026-08-19 14:20:05', '2026-08-20 02:37:02', NULL, 'jatiasih'),
(844, 'MARIA INGGRID TIA PARDEDE', '65611', 'jatiasih', 0, 0, NULL, '$2y$12$13gb9FBdEMWfkvqwWcQZCeUldipWwYx3gxTHdti8MsDU4E1U8hgCe', NULL, '2026-08-19 14:20:05', '2026-08-20 02:37:03', NULL, 'jatiasih'),
(845, 'M REZA PAHLEVIE', '65619', 'cianjur', 0, 0, NULL, '$2y$12$0iCUgt3dDLPm3nQ8oAIfI.yxCddSbEUjy2ha8Wyrof4xSUGEv8mRS', NULL, '2026-08-19 14:20:05', '2026-08-20 02:37:03', NULL, 'cianjur'),
(846, 'ANDRI FELANI', '65621', 'cianjur', 0, 0, NULL, '$2y$12$QC8nR6o7N1nd3MkF3.HZbO4XD0K45W8qywTB5Zae0pftQh6tlV.wy', NULL, '2026-08-19 14:20:06', '2026-08-20 02:37:04', NULL, 'cianjur'),
(847, 'EMIN SUHEMIN', '65622', 'cianjur', 0, 0, NULL, '$2y$12$X9Qijeh9VIhk1/0meMImneyBJa6Q64ABtsRB3Bqud6AXt2xCiHdcq', NULL, '2026-08-19 14:20:06', '2026-08-20 02:37:04', NULL, 'cianjur'),
(848, 'ERASMUS RIO ANSARA', '65623', 'cipanas', 0, 0, NULL, '$2y$12$9bAK9UkrR4/mUbKE50zJyuYNmUkaoPpdQW2T.YPQUaJmL3VUbQBei', NULL, '2026-08-19 14:20:07', '2026-08-20 02:37:05', NULL, 'cipanas'),
(849, 'RIYAN ALFIANSYAH', '65624', 'cianjur', 0, 0, NULL, '$2y$12$S21YVxvJAlD0hhl5Gf.byOqaZcMtBXtrZ4L96WlPDVJ.ysNvQvtcm', NULL, '2026-08-19 14:20:07', '2026-08-20 02:37:05', NULL, 'cianjur'),
(850, 'BUDI ALPAHDIN', '65625', 'cianjur', 0, 0, NULL, '$2y$12$9ytQ1WnARmRVeESCdDAMje4SZq5DjGP..1GT4oPAJU27RBpzry1a2', NULL, '2026-08-19 14:20:08', '2026-08-20 02:37:05', NULL, 'cianjur'),
(851, 'Farida arianti', '65626', 'jatiasih', 0, 0, NULL, '$2y$12$SeyQsxthPDujJFMxv6YZsuSI02l8dTIQyJnrwVRjuh2/viBcpIOLO', NULL, '2026-08-19 14:20:08', '2026-08-20 02:37:06', NULL, 'jatiasih'),
(852, 'Kurnia sari', '65627', 'jatiasih', 0, 0, NULL, '$2y$12$6z59EgQwHODFJ9ixWYHPhubynQoV7Ju.9LMDUAk6C9juFzRQQ/9Oy', NULL, '2026-08-19 14:20:08', '2026-08-20 02:37:06', NULL, 'jatiasih'),
(853, 'REYDI MULLYA PUTRA PRATAMA', '65628', 'cianjur', 0, 0, NULL, '$2y$12$EeMY4jq.POmgL1njpGw3QuUGopkbKjWOJHIUnBqwJoIKMZ5sy32Au', NULL, '2026-08-19 14:20:09', '2026-08-20 02:37:07', NULL, 'cianjur'),
(854, 'Avanza afriansyah', '65629', 'jatiasih', 0, 0, NULL, '$2y$12$.LRTyjXElovOnq.lfQ4FAOvR7rP50lM5vYP6YHfX9NDCLodXYKESu', NULL, '2026-08-19 14:20:09', '2026-08-20 02:37:08', NULL, 'jatiasih'),
(855, 'Sandi Aditia R', '65635', 'ciawi', 0, 0, NULL, '$2y$12$6ctGpNwZVYvcGtDD.iMsIeHaALtVQG7r9ypI7rAmynDcmuuQL8mKq', NULL, '2026-08-19 14:20:09', '2026-08-20 02:37:08', NULL, 'ciawi'),
(856, 'Riski Yanaro', '65636', 'ciawi', 0, 0, NULL, '$2y$12$vDqH3qoDWxZzCXovgO/qgOVdej1gR2vJDyUb85nNRxcNNTbGmb/Ly', NULL, '2026-08-19 14:20:10', '2026-08-20 02:37:09', NULL, 'ciawi'),
(857, 'EKI SAPTAGIA', '65637', 'cianjur', 0, 0, NULL, '$2y$12$o/iuQbbnhAvg8JRtfOCEh.tLrCyQ6yqKLiB9IYr79p4NfKJ392kje', NULL, '2026-08-19 14:20:10', '2026-08-20 02:37:10', NULL, 'cianjur'),
(858, 'UMI SYAFANGAH', '65698', 'jatiasih', 0, 0, NULL, '$2y$12$boIqmtRk18PO1/9.vx6v/enzF89W6MvhL5NHoU2aQk3whjIbkcGku', NULL, '2026-08-19 14:20:11', '2026-08-20 02:37:10', NULL, 'jatiasih'),
(859, 'NENENG EKAWATI', '65840', 'ciawi', 0, 0, NULL, '$2y$12$FyovMZcPgNlL.bzi/imbV.fIsjgO/ThklVIRted32sPsACajYN34G', NULL, '2026-08-19 14:20:11', '2026-08-20 02:37:11', NULL, 'ciawi'),
(860, 'DIAR CAHYOUTOMO', '65932', NULL, 0, 0, NULL, '$2y$12$D.j05v1dAEL9b3O7vSgU8.k4PSebdCh1h/j7hKm9xo8T9o8dF5fZy', NULL, '2026-08-19 14:20:11', '2026-08-20 02:37:11', NULL, NULL),
(861, 'Shilvana Tri Ananda Dewi', '65953', 'cinere', 0, 0, NULL, '$2y$12$z9OKVnKyhmRtO1xqbBbh5OjG86Dt3v2ns1WiEtBQQHYKPskB4YxDO', NULL, '2026-08-19 14:20:12', '2026-08-20 02:37:12', NULL, 'cinere'),
(862, 'Robiar dinata', '66095', 'cinere', 0, 0, NULL, '$2y$12$yEuVWM.vXb56Ib6f7zO7KePmjpwYowQbaHebahwDZC1ZCEYvXwsHi', NULL, '2026-08-19 14:20:12', '2026-08-20 02:37:12', NULL, 'cinere'),
(863, 'Eva susanti', '66096', 'cinere', 0, 0, NULL, '$2y$12$loz7T6/3N3w8cwm6m2RAC.D0CBaNEnf847xLk2JeoywJP5GzJJFki', NULL, '2026-08-19 14:20:12', '2026-08-20 02:37:13', NULL, 'cinere'),
(864, 'Dede Ruslan', '66099', 'ciawi', 0, 0, NULL, '$2y$12$0kGGj/gYgvL1B/GgneQ6OemTaXCcU2Stx/HmnNR7dQviv7GBIjyIq', NULL, '2026-08-19 14:20:13', '2026-08-20 02:37:13', NULL, 'ciawi'),
(865, 'Anton', '66100', 'ciawi', 0, 0, NULL, '$2y$12$7M/u9bc5jW0PGFCTV0Fi5eQYVDFHFib8wPo4J9YOl.b7j/fcHE3pK', NULL, '2026-08-19 14:20:13', '2026-08-20 02:37:14', NULL, 'ciawi'),
(866, 'Rexi cristianto', '66101', 'ciawi', 0, 0, NULL, '$2y$12$2J1S.sRWL69pCCDBVHXFRe8XhaPuE4iC/Atb7KpfY.CieRUF4UQ6m', NULL, '2026-08-19 14:20:13', '2026-08-20 02:37:14', NULL, 'ciawi'),
(867, 'ACHMAD  SYAFE`I', '66168', 'cinere', 0, 0, NULL, '$2y$12$chCHfcSo1PwWSBldEcMfJO4FA8uzAViCzMkqBIa7r47.dzVcVYM2.', NULL, '2026-08-19 14:20:14', '2026-08-20 02:37:15', NULL, 'cinere'),
(868, 'ERLANGGA SURYAANDHARA, SE', '66186', 'jatiasih', 0, 0, NULL, '$2y$12$32ECgYDy4JgG.Jrz2A5keufFs4Y5SgUwg6kHEITGfr/DT.3sMIK6K', NULL, '2026-08-19 14:20:14', '2026-08-20 02:37:15', NULL, 'jatiasih'),
(869, 'SUTRISNO', '66187', 'jatiasih', 0, 0, NULL, '$2y$12$t/jbxLo73AZk796WK/B5GO7pnDWK63QdIjFF7xTZZqyho/LZc5np6', NULL, '2026-08-19 14:20:14', '2026-08-20 02:37:16', NULL, 'jatiasih'),
(870, 'DADAN NURJAYA', '66200', 'cianjur', 0, 0, NULL, '$2y$12$MERfMYTjz4psID5y9f3dG.wkVATH63xoHRsdLFTA4hJfo3Aa9CMMW', NULL, '2026-08-19 14:20:15', '2026-08-20 02:37:16', NULL, 'cianjur'),
(871, 'SOLIHIN', '66271', 'cianjur', 0, 0, NULL, '$2y$12$ggSzGgLECCEfnSVCuO8/EObxh0LfSrpVL8fP8r9j76COhyt/iJiXS', NULL, '2026-08-19 14:20:15', '2026-08-20 02:37:16', NULL, 'cianjur'),
(872, 'Ricky erwansyah', '66343', 'jatiasih', 0, 0, NULL, '$2y$12$FgaB2d5A5FPQrwibsuoto.d5nYdbOayok3NTr3AUAnEAyanUmAOMS', NULL, '2026-08-19 14:20:16', '2026-08-20 02:37:17', NULL, 'jatiasih'),
(873, 'Diana Oktaviani', '66344', 'jatiasih', 0, 0, NULL, '$2y$12$ojIpIiTHUH.kYWI5Pq6aredE6M6Wfr/sUH24JFXqXl1daR.H0MC/K', NULL, '2026-08-19 14:20:16', '2026-08-20 02:37:17', NULL, 'jatiasih'),
(874, 'ILHAM AGUNG RIYADI', '66360', 'jatiasih', 0, 0, NULL, '$2y$12$Pcv3tAD3j1Ic8Alps/9LVumDZzB7OoyyMmp5IaKc6KKC7vJIJq7Ja', NULL, '2026-08-19 14:20:16', '2026-08-20 02:37:18', NULL, 'jatiasih'),
(875, 'AGUS ARWAN SETIYAKUSUMAH', '66533', 'jatiasih', 0, 0, NULL, '$2y$12$9SAIUzV/dUi9v/6WaN6VEOg3abg8tcWIdZfWPh3vYi6uIw7iPQsyW', NULL, '2026-08-19 14:20:17', '2026-08-20 02:37:18', 'bm_sh', 'jatiasih'),
(876, 'M Rizki Kurniadi', '66573', 'cinere', 0, 0, NULL, '$2y$12$QNPSdbLZPevkgSX3lMDVJuShIXW4F4wW2.IjPX3JWHPAG6FhUePLG', NULL, '2026-08-19 14:20:17', '2026-08-20 02:37:19', NULL, 'cinere'),
(877, 'ASEP HARI BUDIMAN', '66651', 'cianjur', 0, 0, NULL, '$2y$12$BcoBhsLQ.RVIPWy0.baeIOLC9XWB6k20u6VnOOnFMrMvx9hD1bIu.', NULL, '2026-08-19 14:20:18', '2026-08-20 02:37:20', NULL, 'cianjur'),
(878, 'Amanda Laelia', '66771', 'ciawi', 0, 0, NULL, '$2y$12$al51BIZyOaUOJeKPEPFsAO5u.sEVzuthdohLq8hlh0DxFmZc8daLS', NULL, '2026-08-19 14:20:18', '2026-08-20 02:37:21', NULL, 'ciawi'),
(879, 'Chanviro Yanuar Christy', '66861', 'ciawi', 0, 0, NULL, '$2y$12$RYxvOwrqmnjMsT.FOWUNcOSpnHvWTnRSzlQBBGlcElck314vvoAC.', NULL, '2026-08-19 14:20:19', '2026-08-20 02:37:22', NULL, 'ciawi'),
(880, 'RINZANI ADLERINA', '66973', 'jatiasih', 0, 0, NULL, '$2y$12$V0dAzu8V6TqFytJK2vfuH.CYNelzmRSEvqZbINzey1yzqXzdVdsgm', NULL, '2026-08-19 14:20:19', '2026-08-20 02:37:22', NULL, 'jatiasih'),
(881, 'Muhamad Linggar Gesara Nurdin', '66974', 'ciawi', 0, 0, NULL, '$2y$12$.b0bLKw7r/4WVMuyuruE2uF2oCFaM7qXPj2gcd/ZDapABOIGWJW3K', NULL, '2026-08-19 14:20:20', '2026-08-20 02:37:23', NULL, 'ciawi'),
(882, 'RECNA AGUSTINA', '66984', 'jatiasih', 0, 0, NULL, '$2y$12$az/KiINn0KX.X7wH3ECvoeeiJrT6iu8BaPFHDt7MjLjTiGyY143wm', NULL, '2026-08-19 14:20:20', '2026-08-20 02:37:23', NULL, 'jatiasih'),
(883, 'Andrean Yoseph', '67204', 'cinere', 0, 0, NULL, '$2y$12$NPJAD2q.DNwMiytvhsTre.YW1k0ELSRtuvclLObGaBwhTnZMoH58y', NULL, '2026-08-19 14:20:21', '2026-08-20 02:37:24', NULL, 'cinere'),
(884, 'RIO BAGUS SEPTIADI', '67230', 'cinere', 0, 0, NULL, '$2y$12$0WMpRYlJ3ZDjjlhd6quOU.8TNBcV7aXw7z2I8PG5H6765AsvvHz8i', NULL, '2026-08-19 14:20:21', '2026-08-20 02:37:24', 'bm_sh', 'cinere'),
(885, 'ADITYA MUHAMAD FAZRIN', '67374', 'jatiasih', 0, 0, NULL, '$2y$12$yoKdC2wmVfbvd88B6LVYNuur3rRnlYr2wG9yIXhWPh.HFas05nBWK', NULL, '2026-08-19 14:20:21', '2026-08-20 02:37:25', NULL, 'jatiasih'),
(886, 'MUHAMMAD SHUBHY SUPARDAN', '67376', 'jatiasih', 0, 0, NULL, '$2y$12$/EWnrlgid8Z8YpMgYPrqnexvmjsIStPtZwrtK8fJBBbmwa/1CRe/K', NULL, '2026-08-19 14:20:22', '2026-08-20 02:37:26', NULL, 'jatiasih'),
(887, 'Muhammad Andri Jatnika', '67377', 'jatiasih', 0, 0, NULL, '$2y$12$b1dDmS6OYyFFTme0cPQwlOy9AvVPKTXH6sGOG1/l/iG.imXvYtva.', NULL, '2026-08-19 14:20:22', '2026-08-20 02:37:26', NULL, 'jatiasih'),
(888, 'Risma Arta Novia', '67378', 'jatiasih', 0, 0, NULL, '$2y$12$RMVZZ.4hMaBjrBNBQ22de.impXKygp/6cKFZ2zPuT27qEBCuedZwW', NULL, '2026-08-19 14:20:22', '2026-08-20 02:37:26', NULL, 'jatiasih'),
(889, 'Friska Yuzelia', '67475', 'cinere', 0, 0, NULL, '$2y$12$vzLC6xgK3SdVSZCuAibl3O/3I7OJebXgIbLOJt9GzXS1JjvJdPrNy', NULL, '2026-08-19 14:20:23', '2026-08-20 02:37:27', NULL, 'cinere'),
(890, 'Gatot Teguh Arifyanto', '67476', 'cinere', 0, 0, NULL, '$2y$12$MmPFqvteeg.C8Ca.6PBvFuXP.Rdb8WSsXH/VwJ3A23sd57G5e7ZCC', NULL, '2026-08-19 14:20:23', '2026-08-20 02:37:27', NULL, 'cinere'),
(891, 'Nabila', '67477', 'cinere', 0, 0, NULL, '$2y$12$QvogXNFSWOJ61jKMeW0pG.C/g6AsagXZdI/ZN.lIIUi4pUkGRy0Ie', NULL, '2026-08-19 14:20:23', '2026-08-20 02:37:28', NULL, 'cinere'),
(892, 'Perdy Permana', '67478', 'cinere', 0, 0, NULL, '$2y$12$Iq8T3gL936qGGSmzkUg5Se0OHMCMpUQZGpYD6TJwPIpGaZ2r32T1K', NULL, '2026-08-19 14:20:24', '2026-08-20 02:37:28', NULL, 'cinere'),
(893, 'Heru Maulana Yusup', '67479', 'cianjur', 0, 0, NULL, '$2y$12$9LzFtrnQimGSrBvafxVcxuSq8SdOpCORfEvsItYIhPA.mp27pACju', NULL, '2026-08-19 14:20:24', '2026-08-20 02:37:29', NULL, 'cianjur'),
(894, 'Mohamad Sulthon', '67480', 'cipanas', 0, 0, NULL, '$2y$12$xOY.xAIL/V2f9/Y0hdHkN.zUrHE9Zf34H14hI0ONaQU3B19/1qINq', NULL, '2026-08-19 14:20:24', '2026-08-20 02:37:29', NULL, 'cipanas'),
(895, 'Rizky Fanzuri', '67558', 'ciawi', 0, 0, NULL, '$2y$12$Eci9qY1rdkAhdWM96c30ZeyopXnE3xhzkzkkd0OgJaHq6NloTrwzq', NULL, '2026-08-19 14:20:25', '2026-08-20 02:37:30', NULL, 'ciawi'),
(896, 'KARINA PURWANTI', '67559', 'ciawi', 0, 0, NULL, '$2y$12$o31A18mgVqBlqU.bVzQmiej.dxhEJHFJcDg/U.h/06HXqP8u6Mr2e', NULL, '2026-08-19 14:20:25', '2026-08-20 02:37:30', NULL, 'ciawi'),
(897, 'Nadya Savila Putri', '67560', 'ciawi', 0, 0, NULL, '$2y$12$jDMQsATFg6Q0fsueHbPN0.Gxddn3eTF21brpWWVcD5pyZ.IMP4FJa', NULL, '2026-08-19 14:20:26', '2026-08-20 02:37:31', NULL, 'ciawi'),
(898, 'Wasis Suprianto', '67640', 'cianjur', 0, 0, NULL, '$2y$12$n1LgHMrj5ATLAyaic9jN3OFtBQ5vI/jSA2uWgirADLkglOmsAoaZu', NULL, '2026-08-19 14:20:26', '2026-08-20 02:37:32', NULL, 'cianjur'),
(899, 'Aldhie Aulia Rachman', '67662', 'ciawi', 0, 0, NULL, '$2y$12$Y/.V6pQISRNPsDVlld//negYcBdo7lLcjDPZs5hVbecaFrH8JEPtK', NULL, '2026-08-19 14:20:26', '2026-08-20 02:37:33', NULL, 'ciawi'),
(900, 'MUHAMMAD FAHMI', '67735', 'cinere', 0, 0, NULL, '$2y$12$DJfxOe780vMcp4QQWLw3ledDtpRLcVmsrisEJJLP6KNHD0rfp7uBi', NULL, '2026-08-19 14:20:27', '2026-08-20 02:37:33', NULL, 'cinere'),
(901, 'EDHY DAHONO SUKARNO', '67885', 'jatiasih', 0, 0, NULL, '$2y$12$n2mMAYjw3SWkW6b/xvNhxuKvbPN1nZvRKoV8tuXUx4qteL3I8GO2y', NULL, '2026-08-19 14:20:27', '2026-08-20 02:37:34', NULL, 'jatiasih'),
(902, 'Wiwin Adriana', '67886', 'jatiasih', 0, 0, NULL, '$2y$12$WhPifEWxOFqo3s8z3B87QebH3IUbk0ic58MxuShZrjywrxIXaT2Ei', NULL, '2026-08-19 14:20:28', '2026-08-20 02:37:34', NULL, 'jatiasih'),
(903, 'Ugo Prasetyo', '67887', 'jatiasih', 0, 0, NULL, '$2y$12$bjbgCdRIMrPv5QAXmQN/q.yAGlpxWxLmO45MsntZeYQz/wFRJYZYi', NULL, '2026-08-19 14:20:28', '2026-08-20 02:37:35', NULL, 'jatiasih'),
(904, 'Hendra Saputra', '67888', 'jatiasih', 0, 0, NULL, '$2y$12$2czcLVRGlYL4HW9KncAMnOoNJGDyJIbAiadQuhJKEx4.49UaUuHse', NULL, '2026-08-19 14:20:28', '2026-08-20 02:37:35', NULL, 'jatiasih'),
(905, 'SURYA WIBISANA', '68252', 'jatiasih', 0, 0, NULL, '$2y$12$95Xxvdrtb3uY7MfnGbrqZexXAXfQ4K1iyipLRiZZFriW2wUjxdAWy', NULL, '2026-08-19 14:20:29', '2026-08-20 02:37:36', NULL, 'jatiasih'),
(906, 'Betha Rangga Shuroyudho', '68254', 'jatiasih', 0, 0, NULL, '$2y$12$0Xywekbb5Qmq01q5NAhFxem41eq0lvSN39Si7O6dP4J/jB.h4wIpm', NULL, '2026-08-19 14:20:29', '2026-08-20 02:37:36', NULL, 'jatiasih'),
(907, 'Hendri Suharto', '68255', 'ciawi', 0, 0, NULL, '$2y$12$sfA8yczIJUekfLYVRIpFb.6GHhvGrnb2b7gQUowBnkZlrhaptczeC', NULL, '2026-08-19 14:20:30', '2026-08-20 02:37:37', NULL, 'ciawi'),
(908, 'Rahayu', '68257', 'ciawi', 0, 0, NULL, '$2y$12$gcHEuHcsBAtomhYA8yy4tubS.NYviyJ1nB3vYS4qq/CcMWfgAgwam', NULL, '2026-08-19 14:20:30', '2026-08-20 02:37:39', NULL, 'ciawi'),
(909, 'Abdul Rosid', '68290', 'cinere', 0, 0, NULL, '$2y$12$lcl/rojxpB09in46DyULtOTSr.GuNgsxON4B0QReLrlEKmnfg0jhO', NULL, '2026-08-19 14:20:31', '2026-08-20 02:37:39', NULL, 'cinere'),
(910, 'Rizky Yora Ardiansyah', '68302', 'cianjur', 0, 0, NULL, '$2y$12$ogsobp.pSzqPZOLSa119iuz0a16Uru5Rrc.VbTiqXiuieapBsgjMa', NULL, '2026-08-19 14:20:32', '2026-08-20 02:37:41', 'bm_sh', 'cianjur'),
(911, 'Sri Wulandari', '68304', 'ciawi', 0, 0, NULL, '$2y$12$PROH6ijTp.UUm1TNEUqb2.7Svyy0dtP9WwrkmWFLjarEhir2gTDse', NULL, '2026-08-19 14:20:32', '2026-08-20 02:37:41', NULL, 'ciawi'),
(912, 'Yudi Faisal', '68347', 'ciawi', 0, 0, NULL, '$2y$12$vdtUyVAc3rCajp7qPHyv4eqNFbOCJOsMxhLAin5PiG7nG3o9ApVUC', NULL, '2026-08-19 14:20:32', '2026-08-20 02:37:43', NULL, 'ciawi'),
(913, 'Manda Heryanto', '68562', 'cinere', 0, 0, NULL, '$2y$12$jGg1AVPDC/3g4ovLJsa0T.Mu6HIHDeaqmQlizt9ts7D1PNXRrwewW', NULL, '2026-08-19 14:20:32', '2026-08-20 02:37:44', 'bm_sh', 'cinere'),
(914, 'Gunawan Ramadhan', '68563', 'cinere', 0, 0, NULL, '$2y$12$lq/xTTuRYu1ppJP0rsilCudCCz5yTjwCNOWkPXrjDyuXiAu0zs8n2', NULL, '2026-08-19 14:20:33', '2026-08-20 02:37:46', NULL, 'cinere'),
(915, 'Muhammad Octavia Asfalani', '68565', 'cinere', 0, 0, NULL, '$2y$12$RwVKtRx5WwvNGtzB2joJ5e3x9x3mdMsj6sdh5LP9kq6wasChmz0b.', NULL, '2026-08-19 14:20:33', '2026-08-20 02:37:47', NULL, 'cinere'),
(916, 'KHUFRANA PUSPITA DEWI', '68567', 'jatiasih', 0, 0, NULL, '$2y$12$4yt6.WbU/NW5fZna8PpVUu7sXdXKdYH2ADAUOCxE9YVwR1f9OQwl.', NULL, '2026-08-19 14:20:33', '2026-08-20 02:37:47', NULL, 'jatiasih'),
(917, 'PUTRI ANGGRAENI WIBOWO', '68570', 'jatiasih', 0, 0, NULL, '$2y$12$0RhWmqoUwPn9ccdV.yDHfOJ/XdGhP6q2Q.rmuvGXE9yVJq2WMgyNa', NULL, '2026-08-19 14:20:33', '2026-08-20 02:37:48', NULL, 'jatiasih'),
(918, 'M Luqman Fahmi', '68571', 'jatiasih', 0, 0, NULL, '$2y$12$C1lAttbbO3GU9W2eiKS1Ce9lZhFt/xUnr650lA4Es5HZrEKsst0pa', NULL, '2026-08-19 14:20:34', '2026-08-20 02:37:49', NULL, 'jatiasih'),
(919, 'MARSYANDA DIVYANA', '68573', 'jatiasih', 0, 0, NULL, '$2y$12$sWLORo1irsy.pMxWzUGcCOU4BcfPEJvooPhrkhSywoHMN2l4SHyZ6', NULL, '2026-08-19 14:20:34', '2026-08-20 02:37:49', NULL, 'jatiasih'),
(920, 'SITI SALMA RESKINA', '68574', 'jatiasih', 0, 0, NULL, '$2y$12$MnfMzPLPxSp/qbHnasOBTuRKZvcv9J2hFwh7l7OhmSkO7F5k3YJXG', NULL, '2026-08-19 14:20:34', '2026-08-20 02:37:50', NULL, 'jatiasih'),
(921, 'OSAMA SOFYAN JUNAIDI', '68575', 'jatiasih', 0, 0, NULL, '$2y$12$OsDB46iF/9slAMUpFl4RV.diAuour98IW1kW4QpV6nweXs8lge4AW', NULL, '2026-08-19 14:20:34', '2026-08-20 02:37:51', NULL, 'jatiasih'),
(922, 'DEDI SUPRAYITNO', '68576', 'jatiasih', 0, 0, NULL, '$2y$12$KHjcyDo3AW/M4xOqVSgH8.N1NHf8SDA4hQi/.trhQTsUmt7dAPvDu', NULL, '2026-08-19 14:20:35', '2026-08-20 02:37:51', NULL, 'jatiasih'),
(923, 'NOVIA ROSANTI', '68578', 'ciawi', 0, 0, NULL, '$2y$12$jLJhCblaeX9iIlwRXrz1EOV3rqSQNUiVs/3y0mgD/y/Eod7t4PQtS', NULL, '2026-08-19 14:20:35', '2026-08-20 02:37:52', NULL, 'ciawi'),
(924, 'SAYADI', '68582', 'jatiasih', 0, 0, NULL, '$2y$12$FuHVXeIVyrHKovrRpg526umWvHXjJOvqK6VSIzHDOHHh7xGOu/hAu', NULL, '2026-08-19 14:20:35', '2026-08-20 02:37:53', NULL, 'jatiasih'),
(925, 'Rahmat', '68601', 'cinere', 0, 0, NULL, '$2y$12$fS0Dhq91ijeS.53yl0ckEOwA1oevIXQ3HjuSo5fVovJ6VTX0BCrl2', NULL, '2026-08-19 14:20:35', '2026-08-20 02:37:53', 'bm_sh', 'cinere'),
(926, 'ILHAM SOBIRIN', '68602', 'cinere', 0, 0, NULL, '$2y$12$bO0rkWLEyOj/DOi5vDvbaufeUFkhwHNgdmc8RxakWUVHAulVj9bjm', NULL, '2026-08-19 14:20:36', '2026-08-20 02:37:54', NULL, 'cinere'),
(927, 'MUHAMMAD RAMANDANI', '68603', 'cinere', 0, 0, NULL, '$2y$12$BdsKgQiuVLw.RfHUzjcUyuyOzvJmHeneVXhkPGOh0sckeHxOALGFq', NULL, '2026-08-19 14:20:36', '2026-08-20 02:37:55', NULL, 'cinere'),
(928, 'FADILAH RIYANTI', '68625', 'cinere', 0, 0, NULL, '$2y$12$SaXwikJMSu.Y9ZbIKMGh.uxL7V1tO5GW4Lq4LVKJxdCNmPhWAjshi', NULL, '2026-08-19 14:20:37', '2026-08-20 02:37:57', NULL, 'cinere'),
(929, 'Yuwono', '68629', 'cinere', 0, 0, NULL, '$2y$12$IVzmaABN55znM06DjPzS9e43repGsBZzS6nCZEFE3fqziHvuXYabC', NULL, '2026-08-19 14:20:37', '2026-08-20 02:37:58', NULL, 'cinere'),
(930, 'Fazlur rahman almuthi', '68631', 'cinere', 0, 0, NULL, '$2y$12$DRivtTK1.9Zt38Umyh9vVeAjR9cyKHrlvzg6FEhNsxvhVJ35if1e6', NULL, '2026-08-19 14:20:37', '2026-08-20 02:37:59', NULL, 'cinere'),
(931, 'ANDRE ALVINO PANJAITAN', '68675', 'jatiasih', 0, 0, NULL, '$2y$12$O24pO6tTsgEWycCzZNd1r.ottE6Xet0m1quQ25F5e5Guq/P235F.i', NULL, '2026-08-19 14:20:38', '2026-08-20 02:38:00', NULL, 'jatiasih'),
(932, 'EKA KOMALA', '69083', 'ciawi', 0, 0, NULL, '$2y$12$8JYSql/FxmzvDiuiY7X45uRR3Lemi8vt3uQ5/EByFMVcF/G5UMu6W', NULL, '2026-08-19 14:20:38', '2026-08-20 02:38:01', NULL, 'ciawi'),
(933, 'Ade Oktavian', '69084', 'jatiasih', 0, 0, NULL, '$2y$12$zLkudX7zRa.zgGrDkP5VseUlG8kGXv3tMHX2CZefhHFb4OUvLUFoG', NULL, '2026-08-19 14:20:38', '2026-08-20 02:38:03', NULL, 'jatiasih'),
(934, 'IDA MUHAROMAH', '69085', 'ciawi', 0, 0, NULL, '$2y$12$okwlI4y1rYiSLnNrN81Lfe9sLSDF.hFUieiOTMkMPuYWtyPOdEVYm', NULL, '2026-08-19 14:20:39', '2026-08-20 02:38:04', NULL, 'ciawi'),
(935, 'Yuli Suratiningsih', '69086', 'jatiasih', 0, 0, NULL, '$2y$12$jtZNN/lMZt920usxuKN1Au0kYyLUHFmNyg4NrGiJRALf/ktmaX2Tq', NULL, '2026-08-19 14:20:39', '2026-08-20 02:38:05', NULL, 'jatiasih'),
(936, 'AMAR ROYHAN', '69087', 'ciawi', 0, 0, NULL, '$2y$12$qoPWaZEsla7EPz7y7TbBWeISwhCsMpsBkxs6pI3PA/cSwya8dlSUy', NULL, '2026-08-19 14:20:39', '2026-08-20 02:38:06', NULL, 'ciawi'),
(937, 'Perbu Sukma Alamsyah', '69088', 'ciawi', 0, 0, NULL, '$2y$12$DJJ4gwrnWTCdpl3jYFbPk.xIlU4SqxOTXjtvZgstuKXb8IqwOn9Ee', NULL, '2026-08-19 14:20:39', '2026-08-20 02:38:07', NULL, 'ciawi'),
(938, 'Ferra claudia', '69090', 'jatiasih', 0, 0, NULL, '$2y$12$HBsCD3V8xXa.E8e0kUotAufOGaqZ.Ee.lDFUdg5HVBT6sdqIw7v6u', NULL, '2026-08-19 14:20:40', '2026-08-20 02:38:11', NULL, 'jatiasih'),
(939, 'OKEU OKTA HERWANA', '69134', 'cianjur', 0, 0, NULL, '$2y$12$LeshZXBqN.TEq5QQC.gvNuRniX8xWFpaIbFJdjkvqRqOUKYX4vhRO', NULL, '2026-08-19 14:20:40', '2026-08-20 02:38:12', NULL, 'cianjur'),
(940, 'ERWIN SUHENDI', '69135', 'jatiasih', 0, 0, NULL, '$2y$12$sozbYe/RHn.APQCChJfsKuzs9epoBl2muPjUT5HFc3oOpm5oK5FJW', NULL, '2026-08-19 14:20:41', '2026-08-20 02:38:13', NULL, 'jatiasih'),
(941, 'Tedy Safrudin', '69222', 'cianjur', 0, 0, NULL, '$2y$12$/z33th8XCbRnS8Fkc2cPnerZntPnO0SlFvquhzu1cN6yZKG..sqx.', NULL, '2026-08-19 14:20:41', '2026-08-20 02:38:14', 'bm_sh', 'cianjur'),
(942, 'Benny susanto gunawan', '69224', 'cianjur', 0, 0, NULL, '$2y$12$AVhYS7ijYiFI8HzICgv55OwkPFNbUSj5wIY1lVleoz.IvnQBTZYAi', NULL, '2026-08-19 14:20:41', '2026-08-20 02:38:17', NULL, 'cianjur'),
(943, 'MAULANA RIZQI PRATAMA', '69225', 'cinere', 0, 0, NULL, '$2y$12$hgnpWjNEMbnc9jcPQkJiS.LbRrHxOSHq5c/KX6MA///VsZrGUCoGy', NULL, '2026-08-19 14:20:42', '2026-08-20 02:38:18', NULL, 'cinere'),
(944, 'Agus tiyan nur saputro', '69232', 'cianjur', 0, 0, NULL, '$2y$12$LY06ljo024ltAXkadbhCs.f00vafzZMEyKEFRpIA.MEbGQqYrHRJa', NULL, '2026-08-19 14:20:42', '2026-08-20 02:38:19', NULL, 'cianjur'),
(945, 'Agung Nugraha', '69256', 'cianjur', 0, 0, NULL, '$2y$12$K5Syz7RUmW511anfA90T6.lbI/6m6gHdFeB2m88fOMEsuEIqHRkkG', NULL, '2026-08-19 14:20:42', '2026-08-20 02:38:20', NULL, 'cianjur'),
(946, 'Mochamad Rizal Wibisana', '69259', 'cianjur', 0, 0, NULL, '$2y$12$1IEztjmIXwJlbp7nuEuVMu.Or1rXYkUsQ1gpr.OEpqrYKbcCDezq2', NULL, '2026-08-19 14:20:43', '2026-08-20 02:38:21', NULL, 'cianjur'),
(947, 'DEDI SARIFUDIN', '69260', 'cianjur', 0, 0, NULL, '$2y$12$x7PJAMK53Lzn2Jv.y.vtMen9IcQ7CwctKM0A4kzjpbOmELRI7oEQ.', NULL, '2026-08-19 14:20:43', '2026-08-20 02:38:22', NULL, 'cianjur'),
(948, 'Fauzi septianto', '69261', 'cianjur', 0, 0, NULL, '$2y$12$29QoWtaBVaWf.OwUvGG7suKImwKbthP8GozvgixEseC7NcJKrWz0m', NULL, '2026-08-19 14:20:43', '2026-08-20 02:38:24', NULL, 'cianjur'),
(949, 'Rizki Ikhwan', '69669', 'jatiasih', 0, 0, NULL, '$2y$12$VwpTVpjpiVQBJJ0VjHjyJOHyKrK1z6Z/pIZLhahZ/a9ZANgdwQigy', NULL, '2026-08-19 14:20:44', '2026-08-20 02:38:26', NULL, 'jatiasih'),
(950, 'Guntur Susanto Putra', '69671', 'jatiasih', 0, 0, NULL, '$2y$12$/sevQABkKnbtTNjGnlF.rOkme1VCG8QI2taOOCw/Qnwwn5VaRg3UG', NULL, '2026-08-19 14:20:44', '2026-08-20 02:38:27', NULL, 'jatiasih'),
(951, 'Febri Yansyah', '69673', 'jatiasih', 0, 0, NULL, '$2y$12$qj0jiSzpN.E9TzMczi/7Du39rxmlDDgRBQmY9GPa1BbfkgU/M2v5W', NULL, '2026-08-19 14:20:44', '2026-08-20 02:38:28', NULL, 'jatiasih'),
(952, 'ARIEF PRASEPTYO', '69692', 'cinere', 0, 0, NULL, '$2y$12$RXOsp3YATXDc9JCMNOs6xeplInZjFHjCCOuoC/rq./EymNoUJJ6qe', NULL, '2026-08-19 14:20:45', '2026-08-20 02:38:29', NULL, 'cinere'),
(953, 'Nazma agistina', '69693', 'ciawi', 0, 0, NULL, '$2y$12$wFMC86NDislTQ53kPYFLfelFaMsnH2kX0BPHOhjBPQ6rMROAKiFy.', NULL, '2026-08-19 14:20:45', '2026-08-20 02:38:30', NULL, 'ciawi'),
(954, 'Resty Ria Andriany', '69694', 'ciawi', 0, 0, NULL, '$2y$12$oXx3Uj7x2T/Brilg1zzbiOrtK6G4qlF81qnnramhbxcJWfF131SwC', NULL, '2026-08-19 14:20:45', '2026-08-20 02:38:32', NULL, 'ciawi'),
(955, 'Rien Astriyan Afianti', '69695', 'ciawi', 0, 0, NULL, '$2y$12$nwMnaO8K360Sb8NXxkSjpO5.cyTWBnD6S/vO.iEUbOzZMytIUWsvy', NULL, '2026-08-19 14:20:45', '2026-08-20 02:38:33', NULL, 'ciawi'),
(956, 'SITI NADIA', '69711', 'cipanas', 0, 0, NULL, '$2y$12$zwFTF2eK7SCMaXPCyEAcf.hRSSBMowYwNiYWelM5LFdrYkfPiTElq', NULL, '2026-08-19 14:20:46', '2026-08-20 02:38:34', NULL, 'cipanas'),
(957, 'ALDILA RAHMAN', '69712', 'cipanas', 0, 0, NULL, '$2y$12$KIBn37SOsex3zM3lubQH9u7K5akXfOM255YLt4YG7PgmpfWr7nE8C', NULL, '2026-08-19 14:20:46', '2026-08-20 02:38:35', NULL, 'cipanas'),
(958, 'Rival Rinaldi', '69713', 'cianjur', 0, 0, NULL, '$2y$12$aT6PFS3dvR3O1VRDdLDz4OEykC7rrvXMYZk.eg8Z/2jnhGaYAKjFe', NULL, '2026-08-19 14:20:46', '2026-08-20 02:38:36', NULL, 'cianjur'),
(959, 'MUHAMMAD ILHAM NUR CITRA', '69739', 'cinere', 0, 0, NULL, '$2y$12$Gz7hZrC1DxglNwG/a6fvnelwBjMU0tnZquRpuGDuUBtZIxJdee9W6', NULL, '2026-08-19 14:20:47', '2026-08-20 02:38:37', NULL, 'cinere'),
(960, 'JOSHIE PHIRA FITRIA', '69740', 'cinere', 0, 0, NULL, '$2y$12$0c5bpOCqwFWE0oDTPglacOviNKvZtPlDKICfyjcVqG3tWLDtJnOWK', NULL, '2026-08-19 14:20:47', '2026-08-20 02:38:38', NULL, 'cinere'),
(961, 'Frilangga Nuersyamsi hr', '69760', 'cianjur', 0, 0, NULL, '$2y$12$EnyAP/K2MMSNweqtxnuv.OZ2idI.L/5NDl3mzghRLq3x.ZTuE2iDu', NULL, '2026-08-19 14:20:47', '2026-08-20 02:38:39', NULL, 'cianjur'),
(962, 'Yanti susanti', '69761', 'cianjur', 0, 0, NULL, '$2y$12$V.hyVO8HUy9RkLvNeNGLG.EFZNduCI1pUpN15ahYpwbFWyvU.Xw6m', NULL, '2026-08-19 14:20:47', '2026-08-20 02:38:40', NULL, 'cianjur'),
(963, 'Suratman Dermawan', '70028', 'cinere', 0, 0, NULL, '$2y$12$SNMxYiejRlp9DSrY5gfNIeBhVL2gP1LzQlaLZtvBJIc4CC61VymaC', NULL, '2026-08-19 14:20:48', '2026-08-20 02:38:44', NULL, 'cinere'),
(964, 'Rd. SURYA ADI PUTRA', '70079', 'cipanas', 0, 0, NULL, '$2y$12$i9SDkeHZgDe7tEQZPQe66.1dnVhrgU1eluY6qQa7JfjMoZnKYIM0S', NULL, '2026-08-19 14:20:48', '2026-08-20 02:38:44', NULL, 'cipanas'),
(965, 'Hendra purnama', '70080', 'cinere', 0, 0, NULL, '$2y$12$oA9CEbn7dD5/I/fp2I3Qbu29eTxUmxMoguDlptw3nQI6HaofSgvIq', NULL, '2026-08-19 14:20:49', '2026-08-20 02:38:45', NULL, 'cinere'),
(966, 'Reka Bayu Aji', '70081', 'cinere', 0, 0, NULL, '$2y$12$PcDZKcQlgTLIjzEhQAOc1e7f3pSXPHaMGlg8LRs2t3strfkFVcgue', NULL, '2026-08-19 14:20:49', '2026-08-20 02:38:45', NULL, 'cinere'),
(967, 'Fitria nurlayli', '70082', 'cinere', 0, 0, NULL, '$2y$12$.8Hf9ySEFHS3FQeW5o2YRedaM/1XRpizY0U6j2WxHS2tfKpXAVIgK', NULL, '2026-08-19 14:20:49', '2026-08-20 02:38:46', NULL, 'cinere'),
(968, 'Alvindo Yudoyono', '70083', 'jatiasih', 0, 0, NULL, '$2y$12$IUhX9bK3PMA3mzyhwO.hHO0qLUqag.3xrfHBR4DFfofiGcqlH/HQy', NULL, '2026-08-19 14:20:49', '2026-08-20 02:38:46', NULL, 'jatiasih'),
(969, 'Muhammad Arie Bastian', '70084', 'jatiasih', 0, 0, NULL, '$2y$12$hRkVfPqTj5r.CuRIvPJJmeB2pEJiO8nOFay4WG0aaSYwStnXaanym', NULL, '2026-08-19 14:20:50', '2026-08-20 02:38:46', NULL, 'jatiasih'),
(970, 'Sonia Nadira', '70471', 'cinere', 0, 0, NULL, '$2y$12$IIfbNzXHPpNydqNqJzh.zOgAlzAJ1UlMYhYISXAb2VhuH4UJCHUwG', NULL, '2026-08-19 14:20:50', '2026-08-20 02:38:47', NULL, 'cinere'),
(971, 'Prayogo Wicaksono', '70472', 'cinere', 0, 0, NULL, '$2y$12$W1DnF43VtbREtmXMIiBCRuO/z7NN1jeajlU30We1zALJsljMRwxxW', NULL, '2026-08-19 14:20:50', '2026-08-20 02:38:47', NULL, 'cinere'),
(972, 'Rizqi Fajar Perdaba', '70576', 'jatiasih', 0, 0, NULL, '$2y$12$pGLscseHCTEEjgUZ1ZBLz.whnwYKrYXdjLvqRndCTZLqx9pKUZtG2', NULL, '2026-08-19 14:20:51', '2026-08-20 02:38:47', NULL, 'jatiasih'),
(973, 'Afri Handrianus Maryono ,SE', '70578', 'cianjur', 0, 0, NULL, '$2y$12$zCcswkGS1w5izAKIEvAxqejequBJX1h7kcChqkKiq75iUTazLdic.', NULL, '2026-08-19 14:20:51', '2026-08-20 02:38:48', 'bm_sh', 'cianjur'),
(974, 'SUBHAN PERMANA HIDAYAT', '70587', 'cinere', 0, 0, NULL, '$2y$12$mt/W9rKUJrLhPaSx9bn1..PHlUfP9cg0LgeOXAGElFPvy4HuWgl/i', NULL, '2026-08-19 14:20:51', '2026-08-20 02:38:48', NULL, 'cinere'),
(975, 'Ricko Dwi Wahyudi', '70588', 'cinere', 0, 0, NULL, '$2y$12$wvMmqHmzUe6FpCL0tvtFn.cmNQaFxqIv15J361ENksVBWLfr9i/6S', NULL, '2026-08-19 14:20:51', '2026-08-20 02:38:49', NULL, 'cinere'),
(976, 'Rismawati', '70589', 'cianjur', 0, 0, NULL, '$2y$12$T4c05d0PsXiwhjcaHWDRPuibStbrKdPtFGwIWZ4XxdyE6p2TToISK', NULL, '2026-08-19 14:20:52', '2026-08-20 02:38:49', NULL, 'cianjur'),
(977, 'Nurdiyanti', '70677', 'cinere', 0, 0, NULL, '$2y$12$L.QN47ZUgU30IqqqfD5oO.lxrJe/1zFKMStUNApsdntySGzuVnogO', NULL, '2026-08-19 14:20:52', '2026-08-20 02:38:49', NULL, 'cinere'),
(978, 'DEVRI PRIHANTO', '70774', 'jatiasih', 0, 0, NULL, '$2y$12$UWKFzYzxXSQMmCEdlV4Y/.DSUolcJOTPiPoBkUJLgeawLsCdLESIO', NULL, '2026-08-19 14:20:52', '2026-08-20 02:38:50', NULL, 'jatiasih'),
(979, 'ISKANDAR ZULKARNAEN', '70784', 'jatiasih', 0, 0, NULL, '$2y$12$NC9f6IlGe55aB.WV9Jk.sOFginJSpB.Sft5Wp8.IA7khxS3c8u38u', NULL, '2026-08-19 14:20:53', '2026-08-20 02:38:50', NULL, 'jatiasih'),
(980, 'Aldio Pangestu', '70786', 'jatiasih', 0, 0, NULL, '$2y$12$o5MCOfs6JGtRU/Lje2Xhiuxd9H.mG4pn2WVKeUPVYbcZZr3hpzWYW', NULL, '2026-08-19 14:20:53', '2026-08-20 02:38:51', NULL, 'jatiasih'),
(981, 'Yusi Yulastri', '70791', 'cianjur', 0, 0, NULL, '$2y$12$L5qef0KjkInqCKzdEkZ3Qur6VuEhzMt2JK6zS7wbfMXM2nDH27e.K', NULL, '2026-08-19 14:20:53', '2026-08-20 02:38:51', NULL, 'cianjur'),
(982, 'SELAMET PAMUJIYONO', '70829', 'ciawi', 0, 0, NULL, '$2y$12$P//UhqXF5RCWEuZKhucvjuT9WEiRJ56960x9Tde.nXj9g3HPLinJG', NULL, '2026-08-19 14:20:53', '2026-08-20 02:38:52', NULL, 'ciawi'),
(983, 'SITI NURUL HOPIPAH', '70830', 'ciawi', 0, 0, NULL, '$2y$12$jvrr.KWUxWdAdU7NAXExO.aKC2W7aQb70wlyC75pqC13hncs55nWe', NULL, '2026-08-19 14:20:54', '2026-08-20 02:38:52', NULL, 'ciawi'),
(984, 'DAFA SAKHA WAHYU RAMADHAN', '70831', 'ciawi', 0, 0, NULL, '$2y$12$NFpyQxNQNeW9GI2v3KfvFeSVcAjx.0OmX73BtqBoAfMX9IbFlrASy', NULL, '2026-08-19 14:20:54', '2026-08-20 02:38:52', NULL, 'ciawi'),
(985, 'ERIK ERTANTO', '70832', 'cipanas', 0, 0, NULL, '$2y$12$Nn5XSX3r2xVFKfq.zOdVOOX/MrhKfdvicJnpaywMIB5jrHG9HUe5O', NULL, '2026-08-19 14:20:54', '2026-08-20 02:38:53', NULL, 'cipanas'),
(986, 'YADI MULYADI', '70833', 'cipanas', 0, 0, NULL, '$2y$12$7nf7duzuq16XndfTEPLm3.ZzZimMhY6n5IdjxS6TvAgLhtl.OriFC', NULL, '2026-08-19 14:20:55', '2026-08-20 02:38:53', NULL, 'cipanas'),
(987, 'Mutia aliya ginanjar', '70834', 'cianjur', 0, 0, NULL, '$2y$12$JhxRjISpAgcJWAXoHK8HiuxOaheRikRnwKEqa4BidjLz2Db1VXKl2', NULL, '2026-08-19 14:20:55', '2026-08-20 02:38:53', NULL, 'cianjur'),
(988, 'LIVIA AMANDA', '70874', 'jatiasih', 0, 0, NULL, '$2y$12$pIRaQyJm1HsKAdkg1k1zmeO9qesm3PpV4290fVMddVii91/eTafJq', NULL, '2026-08-19 14:20:55', '2026-08-20 02:38:54', NULL, 'jatiasih'),
(989, 'Cevi Anwar', '70875', 'cianjur', 0, 0, NULL, '$2y$12$eY2/cvpaRqgrYFzA6VmO1.16YgkYL62CsxPr8ipydHPDe.hG29v0W', NULL, '2026-08-19 14:20:55', '2026-08-20 02:38:54', NULL, 'cianjur'),
(990, 'Taufik Hidayat', '70876', 'cianjur', 0, 0, NULL, '$2y$12$DBig8Kx/8uo6J9a.0qJ2ku5KOJVyaVnTuXBZJ0IoblK0dzihOJIlu', NULL, '2026-08-19 14:20:56', '2026-08-20 02:38:55', NULL, 'cianjur'),
(991, 'Mohammad Yusuf', '70893', 'cinere', 0, 0, NULL, '$2y$12$Z1xW2rtrvIlg.ms/K.5bsekEF4ZwDp4Ksk6DqKDJsG5/Awo4ajzzC', NULL, '2026-08-19 14:20:56', '2026-08-20 02:38:55', NULL, 'cinere'),
(992, 'R Ginanjar BR', '71229', 'ciawi', 0, 0, NULL, '$2y$12$F8E4zN83x2a/vbmqSkYT5eDA6lZpe8cEMT2t94yb.tF.6Ez8xWIbS', NULL, '2026-08-19 14:20:57', '2026-08-20 02:38:56', NULL, 'ciawi'),
(993, 'Ade Rochmat', '71230', 'ciawi', 0, 0, NULL, '$2y$12$WnYD/uDb8ZAzgiop3681IOUMoFl9NIZTmeuTgUFYXDcKqwMJlPO2S', NULL, '2026-08-19 14:20:57', '2026-08-20 02:38:56', NULL, 'ciawi'),
(994, 'TRESNA KUSUMAWATI', '71231', 'ciawi', 0, 0, NULL, '$2y$12$jgwzYfml3daIR5euqyDHL.2XsYjpiEDqLhfayjp2Ivh/x/IIUvcie', NULL, '2026-08-19 14:20:57', '2026-08-20 02:38:56', NULL, 'ciawi'),
(995, 'Fawwaz Jundullah', '71264', 'cinere', 0, 0, NULL, '$2y$12$Yh5nzgw80zfYgRUqxw6aqeD/Aq7dyGPvxBwOdfYQlde9WP.F1mAWK', NULL, '2026-08-19 14:20:57', '2026-08-20 02:38:57', NULL, 'cinere'),
(996, 'Mokhamad nur cholis', '71266', 'cinere', 0, 0, NULL, '$2y$12$kFOEBI0LtDFhuwv4te/lXeJ0h3Pd.lj.GL1GthtxwjexIRskrl31C', NULL, '2026-08-19 14:20:58', '2026-08-20 02:38:57', NULL, 'cinere'),
(997, 'Yusuf adhitya', '71267', 'cinere', 0, 0, NULL, '$2y$12$I.YNWR.cM7C6lbhCzicIK.nM4Cmu9ylTXZ2xjr4GqsEEq4AxJs1h.', NULL, '2026-08-19 14:20:58', '2026-08-20 02:38:58', NULL, 'cinere'),
(998, 'SRI WINDA NINGSIH', '71268', 'cinere', 0, 0, NULL, '$2y$12$pehnQVudbv3coT7DFJYEgOfjz4V6ojC0tvUUVKS75KUtE3BSCQ.vK', NULL, '2026-08-19 14:20:58', '2026-08-20 02:38:58', NULL, 'cinere'),
(999, 'Chairul Anwar', '71269', 'cianjur', 0, 0, NULL, '$2y$12$/NuvKkrPKlpGOUs9e4SILetgr94STvD1/GZ/NHjCrbSkGe.6dZnsC', NULL, '2026-08-19 14:20:58', '2026-08-20 02:38:58', NULL, 'cianjur'),
(1000, 'ARI ARDIAN', '71270', 'cianjur', 0, 0, NULL, '$2y$12$1V/vSrP0pudr7apH0yTniOXx2d7bmcnMpkUo7CMHa1y6lnJsoEfje', NULL, '2026-08-19 14:20:59', '2026-08-20 02:38:59', NULL, 'cianjur'),
(1001, 'RAI DWI RAHMAT', '71271', 'cipanas', 0, 0, NULL, '$2y$12$Qz6oRksOM.Wfac5ouiofTOXqpg7qgLXDtlsIvo2M4M0xXF4GtJjqO', NULL, '2026-08-19 14:20:59', '2026-08-20 02:38:59', NULL, 'cipanas'),
(1002, 'EKA HARDIANSYAH', '71326', 'cinere', 0, 0, NULL, '$2y$12$mvPHaEn8Ik2H2VVSzibsHOvI9IYcE5NH.f9J/tUZAMOIKF94qo4uO', NULL, '2026-08-19 14:20:59', '2026-08-20 02:39:00', NULL, 'cinere'),
(1003, 'PARJIONO', '71370', 'cinere', 0, 0, NULL, '$2y$12$Uh6aJknBGLNaDYTU1xH4y.Xkalla7KVfFe.NpLItOG8kESwbQZ2XO', NULL, '2026-08-19 14:21:00', '2026-08-20 02:39:00', 'bm_sh', 'cinere'),
(1004, 'Jhonatan Saut Ferjunixon', '71867', 'jatiasih', 0, 0, NULL, '$2y$12$8xhCQg.zxrN08TJPM5GiLeYH2R4xQ279CbmNzAyiXRd4VIp/SpSPi', NULL, '2026-08-19 14:21:00', '2026-08-20 02:39:01', NULL, 'jatiasih'),
(1005, 'Delfina Dermawani Yasin', '71904', 'ciawi', 0, 0, NULL, '$2y$12$R3xXuyUy.6SsqCHt5VbwIeRBfL1RccRA0wkgdufAkmiQ3/ZslfO8O', NULL, '2026-08-19 14:21:00', '2026-08-20 02:39:01', NULL, 'ciawi'),
(1006, 'Siti cherenda priyatina', '71905', 'ciawi', 0, 0, NULL, '$2y$12$XTMbzhixbgI4DPYd4C4i0uza4uP68r7M9m3azt6pCP4rUO/jtFSh2', NULL, '2026-08-19 14:21:01', '2026-08-20 02:39:02', NULL, 'ciawi'),
(1007, 'Aliyanto', '71907', 'ciawi', 0, 0, NULL, '$2y$12$w2lum05xX5slX6.fKb5BIu89Rre43Xxe8ULVQdhjaGf0x7Mn7JJLi', NULL, '2026-08-19 14:21:01', '2026-08-20 02:39:02', NULL, 'ciawi'),
(1008, 'Ryan abdul rivai', '71909', 'ciawi', 0, 0, NULL, '$2y$12$oko91AoZnVh8jh9oWbJ6RennK5Av.o.TTs3SHow744xIySYZmXbL2', NULL, '2026-08-19 14:21:01', '2026-08-20 02:39:02', NULL, 'ciawi'),
(1009, 'Andhika pangestu heriyana', '71919', 'ciawi', 0, 0, NULL, '$2y$12$EKIwc4N1HyyIXveYLzCnEuStJr3faPVg0GUj9/sKtOCREIRFE6TYW', NULL, '2026-08-19 14:21:02', '2026-08-20 02:39:03', NULL, 'ciawi'),
(1010, 'RISALA', '71920', 'cinere', 0, 0, NULL, '$2y$12$h3fCu/lId9WT8PBDcUv7aOlwr/zVST8Gx.xZiD6WWpcESqezwrOqS', NULL, '2026-08-19 14:21:02', '2026-08-20 02:39:03', NULL, 'cinere'),
(1011, 'YUUN YUESI DEBORA L', '72336', 'cinere', 0, 0, NULL, '$2y$12$iJveE0aLNkWxVJB9pUOfrebw1yC5.CE2zDF2X3TynHTeJp1/GU9wi', NULL, '2026-08-19 14:21:02', '2026-08-20 02:39:04', NULL, 'cinere'),
(1012, 'RANO VIKO S KOMP', '72337', 'cinere', 0, 0, NULL, '$2y$12$EhYjffuYmeWVHVqwxyAIM.u8BDhiQj7BERQ4MoEAfQsXpMLeLr2l.', NULL, '2026-08-19 14:21:02', '2026-08-20 02:39:04', NULL, 'cinere'),
(1013, 'ANDRIAS SUKMA TANTULAR', '72338', 'cinere', 0, 0, NULL, '$2y$12$sxSBP25.lSyLSGkibFAzDu/Lx/hqtC8ZZ89npklzrnP5xX5oScFvS', NULL, '2026-08-19 14:21:03', '2026-08-20 02:39:04', NULL, 'cinere'),
(1014, 'HARTINI', '72339', 'cinere', 0, 0, NULL, '$2y$12$B6w7BuJqxoCC4hhLbAMmc.jRnOi89ZjSm./LF8rnFaKsL/trSF1du', NULL, '2026-08-19 14:21:03', '2026-08-20 02:39:05', NULL, 'cinere'),
(1015, 'SITI AMELIA', '72482', 'ciawi', 0, 0, NULL, '$2y$12$rGXskPCBxrfTBIXcBxg6qOU3oD.knNHgAfF4BssBfvcv7/x0vR53G', NULL, '2026-08-19 14:21:03', '2026-08-20 02:39:06', NULL, 'ciawi'),
(1016, 'Muhamad Cepi Maulana', '72483', 'cianjur', 0, 0, NULL, '$2y$12$OFIyIOlS8L01wAPqaJ8Gd.1nZ3MrTaUNBDLTwZjvj4zkeMa/7gF6u', NULL, '2026-08-19 14:21:04', '2026-08-20 02:39:06', NULL, 'cianjur'),
(1017, 'AGUNG TRI KURNIAWAN', '72657', 'cianjur', 0, 0, NULL, '$2y$12$Zsl8vCR9luCR1309TD2xyuiNtKvzfTiG49UnL47x0fEwjD.ALvx8e', NULL, '2026-08-19 14:21:04', '2026-08-20 02:39:07', NULL, 'cianjur'),
(1018, 'JIMI SETIAWAN', '72659', 'cianjur', 0, 0, NULL, '$2y$12$T99Vvv653W2JofiCN0bzauQrPaCJ/1siog.v0jQSUwQG5YGhL5//q', NULL, '2026-08-19 14:21:05', '2026-08-20 02:39:07', NULL, 'cianjur'),
(1019, 'LIA YULISTIANA DEWI', '72660', 'ciawi', 0, 0, NULL, '$2y$12$meb5bOxbWO/OmO7n1MBC3.UCWjnvYmAZ7jKwRtN1.HS9LeS8OYTQS', NULL, '2026-08-19 14:21:05', '2026-08-20 02:39:08', NULL, 'ciawi'),
(1020, 'HIKMAH NURHAYA', '72662', 'ciawi', 0, 0, NULL, '$2y$12$0b1D7Z5OroIBubMx8MuTDOHf7aCl3vZFIFCfsTSFMs6iIVoAUo4wC', NULL, '2026-08-19 14:21:05', '2026-08-20 02:39:08', NULL, 'ciawi'),
(1021, 'OCKY SUKMA ALDILAWIJAYA, ST', '72663', 'cipanas', 0, 0, NULL, '$2y$12$CzTHRp5PGPLfo/hk0.5NyuiXV5Hcs9EwkNxj8HUVGGSI2YZC17D2O', NULL, '2026-08-19 14:21:06', '2026-08-20 02:39:09', NULL, 'cipanas'),
(1022, 'GARA SANTANA', '72664', 'cipanas', 0, 0, NULL, '$2y$12$7iV7f3Z5pCUk9NGnEFVn5.SquQZpgtpworCqV1BrNz/665y2c7uvy', NULL, '2026-08-19 14:21:06', '2026-08-20 02:39:09', NULL, 'cipanas'),
(1023, 'REYHAN ZAMZAMI RUSLAN', '72665', 'jatiasih', 0, 0, NULL, '$2y$12$Z.TvH4vyMvfBWPMuNSaB3e74jHkenhMPUrAaTDNIjFIwPMs1QfGUK', NULL, '2026-08-19 14:21:06', '2026-08-20 02:39:09', NULL, 'jatiasih'),
(1024, 'SANTI SEPTIANI', '72796', 'ciawi', 0, 0, NULL, '$2y$12$lxgKtynguaMYwfSGAtR.guXMACJyq1cOhml27p5k4zHdrYucCXOh6', NULL, '2026-08-19 14:21:07', '2026-08-20 02:39:10', NULL, 'ciawi'),
(1025, 'WILDAN PURNAMA DZUHRI KUSUMAH', '72797', 'cianjur', 0, 0, NULL, '$2y$12$1vMMDSYyuoKW754Kynq80e8w4sz4VRzzSnmDtKS7CssBPrOESmC9u', NULL, '2026-08-19 14:21:07', '2026-08-20 02:39:11', NULL, 'cianjur'),
(1026, 'Ai Komalasari', '72798', 'cianjur', 0, 0, NULL, '$2y$12$PdMbJ2Bn.SGzgM0qqeUTIOLKPs05kzamvSiLK0s9Bk5p6XGsfPGUq', NULL, '2026-08-19 14:21:07', '2026-08-20 02:39:11', NULL, 'cianjur'),
(1027, 'MUHAMAD AL GHIFARI', '72799', 'cinere', 0, 0, NULL, '$2y$12$f/23KVkthVKIUpwGh2GU7etJH4qDO2gv1DUgFYB76r2J6toIZS/6y', NULL, '2026-08-19 14:21:08', '2026-08-20 02:39:11', NULL, 'cinere'),
(1028, 'DIDIT FIRMANSYAH', '72845', 'jatiasih', 0, 0, NULL, '$2y$12$ps7xFgzEv8GbqzrUjdBx1easM7SjqqfLWCID6IWiPdVmt23FPCBuO', NULL, '2026-08-19 14:21:08', '2026-08-20 02:39:12', NULL, 'jatiasih'),
(1029, 'MEGA WATI', '73201', 'ciawi', 0, 0, NULL, '$2y$12$W5ave8N4KeBQJdPzPY/DoeKXF/.1C9Exl4jDr1TapG4P/e3nwhau6', NULL, '2026-08-19 14:21:09', '2026-08-20 02:39:13', NULL, 'ciawi'),
(1030, 'ONGKI RINALDI', '73202', 'ciawi', 0, 0, NULL, '$2y$12$LGH1BIbT1ybViFF3YOesJuNRC.JpW3ZIvQYQaIlk5Gw4Cu9uI/l7q', NULL, '2026-08-19 14:21:09', '2026-08-20 02:39:13', NULL, 'ciawi'),
(1031, 'RIZKI MUHAMAD', '73203', 'ciawi', 0, 0, NULL, '$2y$12$YkCQpaT4JdlGrHKGUc/.reRohzJ8HOWcgZb7YgVSNiDkiXFHun7xS', NULL, '2026-08-19 14:21:09', '2026-08-20 02:39:14', NULL, 'ciawi'),
(1032, 'Catur zaini putro', '73204', 'ciawi', 0, 0, NULL, '$2y$12$QEIl1Z1bqE4xoHzn1X9MPe/vhkNhePsB/oGcbYWA5NTDsMM4CtSGG', NULL, '2026-08-19 14:21:09', '2026-08-20 02:39:14', NULL, 'ciawi'),
(1033, 'Arshindi Pratami', '73214', 'cipanas', 0, 0, NULL, '$2y$12$sfsja2yXrweoq4UCssvoVuwfG/qqfxhdhG1T19Mue/sAvG6ZUUOxu', NULL, '2026-08-19 14:21:10', '2026-08-20 02:39:15', NULL, 'cipanas'),
(1034, 'Usep Samsul Falah', '73215', 'cipanas', 0, 0, NULL, '$2y$12$8zQt3kW5VbuGgGluLK/WPezDWD.kHovqZGNKjPOxPgWunIEj.rgEi', NULL, '2026-08-19 14:21:10', '2026-08-20 02:39:15', NULL, 'cipanas'),
(1035, 'WISNU ISLAMI AKBAR', '73218', 'cipanas', 0, 0, NULL, '$2y$12$ylU9S9r/RIO6cB8avAs4QeWHltYLyi8JcmaPZ017i8j6V3VRx4OMa', NULL, '2026-08-19 14:21:11', '2026-08-20 02:39:16', NULL, 'cipanas'),
(1036, 'RANY MARDIYANTI', '73219', 'ciawi', 0, 0, NULL, '$2y$12$RXnk//NHehbl8/Qm0k6iwOhu./9nK8YQ2Gcgng8DPBXBT02e494Xi', NULL, '2026-08-19 14:21:11', '2026-08-20 02:39:16', NULL, 'ciawi'),
(1037, 'RICHARD VERCELLI TAN', '73220', 'ciawi', 0, 0, NULL, '$2y$12$S05/ybIuRi40zT7wb05BvehgmVPw1sYOclT6RbYtSeUwsSIfiNZbS', NULL, '2026-08-19 14:21:11', '2026-08-20 02:39:17', NULL, 'ciawi'),
(1038, 'Agustinus Harya Wiwaha', '73225', 'cinere', 0, 0, NULL, '$2y$12$93sphz7UeUBCCClI0QPGVuDoBEhXX3F4On9fbI6hYJuAsHtVGZWrK', NULL, '2026-08-19 14:21:11', '2026-08-20 02:39:17', NULL, 'cinere'),
(1039, 'Johanes Jabez Parlindungan Lumunon', '73228', 'cianjur', 0, 0, NULL, '$2y$12$GHFN5hDGkVZ2Lnqv9E33Se1OqvLeWd./KDZJb9JyQgIGmSKmGMphq', NULL, '2026-08-19 14:21:12', '2026-08-20 02:39:17', NULL, 'cianjur'),
(1040, 'Gusnina rahayu', '73361', 'cianjur', 0, 0, NULL, '$2y$12$9UfISHclKhGZtX7EhV8ILOJ7SVMs5g2vq1qBNe43BES9AVOUUkGAW', NULL, '2026-08-19 14:21:12', '2026-08-20 02:39:18', NULL, 'cianjur'),
(1041, 'AHMAD IKBALUDIN', '73748', 'ciawi', 0, 0, NULL, '$2y$12$VdTJvin14OKNBRjE0NhE6u4sRt8ILQyMPTWEjb1s9ehaNc96S3cWq', NULL, '2026-08-19 14:21:13', '2026-08-20 02:39:19', NULL, 'ciawi'),
(1042, 'Temmy Widjanarko', '73749', 'cinere', 0, 0, NULL, '$2y$12$I4bxsRZJwad2DS4aM/M8I.NE3JvGsLlVX9iidS2/c0VAful2BZhIK', NULL, '2026-08-19 14:21:13', '2026-08-20 02:39:19', NULL, 'cinere'),
(1043, 'ERNAWATI', '73750', 'ciawi', 0, 0, NULL, '$2y$12$TdyDuv4WyQiWzN/1hPpE9e1OyzhPWdejNf.7o.GZkAMh14dz1dO/W', NULL, '2026-08-19 14:21:13', '2026-08-20 02:39:19', NULL, 'ciawi'),
(1044, 'RATU ZAHRA ARIFIN', '73751', 'cinere', 0, 0, NULL, '$2y$12$zz1wjS37vqcSpin7fzlmPu3kNwDDg5uVIk3TX/G1FWb9IidYXsIJ6', NULL, '2026-08-19 14:21:13', '2026-08-20 02:39:20', NULL, 'cinere'),
(1045, 'LA ODE ZOE TUMADA', '73752', 'cinere', 0, 0, NULL, '$2y$12$DETiOtUhqDt58ac4/uff4.RfyWpkEotQlOZRZcebJXTEcAs/UcZV6', NULL, '2026-08-19 14:21:14', '2026-08-20 02:39:20', NULL, 'cinere'),
(1046, 'M IRWANDI', '73830', 'jatiasih', 0, 0, NULL, '$2y$12$N96sF0Vx076iUgnmNi2uYu1EQLSJctdHUWN13yxu4ypC.LRcbxr52', NULL, '2026-08-19 14:21:14', '2026-08-20 02:39:20', 'bm_sh', 'jatiasih'),
(1047, 'AXEL PUTRA RAMADHAN', '73831', 'jatiasih', 0, 0, NULL, '$2y$12$C.LaNRQ905lqAw0vu8pVP./IMG.A2n0gS2h39Gj4QQ08PuRQgkBUO', NULL, '2026-08-19 14:21:14', '2026-08-20 02:39:21', NULL, 'jatiasih'),
(1048, 'HENDRIANA', '73832', 'jatiasih', 0, 0, NULL, '$2y$12$jeDSiV.nYW8cS4hrvwM/LOWH.UHDoP3CqMhSqr8Ql1RtJWrCO/W9i', NULL, '2026-08-19 14:21:14', '2026-08-20 02:39:21', NULL, 'jatiasih'),
(1049, 'ENDANG SUHARI', '73833', 'jatiasih', 0, 0, NULL, '$2y$12$qz4wG7tJNCxrEsrjfpOs9OLChsfk1Jk5wEWxu0t6xdw5sG7k9UtZy', NULL, '2026-08-19 14:21:15', '2026-08-20 02:39:22', NULL, 'jatiasih'),
(1050, 'ROHANA ANTA SARI', '73835', 'jatiasih', 0, 0, NULL, '$2y$12$lxbFGRfDrln28/sq6TQiJObmPgi6KeMFg7VhTErzQeSaQKeAUoeg6', NULL, '2026-08-19 14:21:15', '2026-08-20 02:39:22', NULL, 'jatiasih'),
(1051, 'HENI SUSANTI', '73836', 'jatiasih', 0, 0, NULL, '$2y$12$/1SNOnQlsy4ZZIsdsZa8O.ynTIzyptWH8ypBR3Nt6v/E93bTURgfu', NULL, '2026-08-19 14:21:16', '2026-08-20 02:39:23', NULL, 'jatiasih'),
(1052, 'WIDAD WAFI', '73837', 'cinere', 0, 0, NULL, '$2y$12$rpvLKyfkgG42H6fgeoT.3eVpjKbVnkRErl3dXdBKBBx.3ybtdYhNe', NULL, '2026-08-19 14:21:16', '2026-08-20 02:39:23', NULL, 'cinere'),
(1053, 'ISAWALA AMINARTI', '74057', 'ciawi', 0, 0, NULL, '$2y$12$Lbfl7BcobX6SPskWM5Ng4eM.e.7YRXQmdR82NI7BmBbCB8k2MinHC', NULL, '2026-08-19 14:21:16', '2026-08-20 02:39:24', NULL, 'ciawi'),
(1054, 'NURUSYIFA AYU PRAMUDHITA', '74060', 'jatiasih', 0, 0, NULL, '$2y$12$e0DQNlei.IeyWAez6x5jOeWvATwyRa4I4coB3MdZcWqws9erkAxna', NULL, '2026-08-19 14:21:17', '2026-08-20 02:39:24', NULL, 'jatiasih'),
(1055, 'Mubdi Hariyanto', '74092', 'cinere', 0, 0, NULL, '$2y$12$AYFk8/BgGMgu8H0gUpoRGuSLkXLxynkZ8WwNuPPOUOksTLQ3LUh5q', NULL, '2026-08-19 14:21:17', '2026-08-20 02:39:25', NULL, 'cinere'),
(1056, 'Titin suryaningrum', '74093', 'cinere', 0, 0, NULL, '$2y$12$en7sNr8kH5YYSMrf3kipiuIPD/qU1vjo7wMeOgBkk88MYH8zWPWxO', NULL, '2026-08-19 14:21:17', '2026-08-20 02:39:25', NULL, 'cinere'),
(1057, 'Silvia Maharani', '74448', 'cipanas', 0, 0, NULL, '$2y$12$rnDGV/IQ1BKUrFmm.LPv9.XoQAAMw1CNdnugZdV/dIkOyCMOA9mEq', NULL, '2026-08-19 14:21:17', '2026-08-20 02:39:26', NULL, 'cipanas');
INSERT INTO `users` (`id`, `name`, `email`, `branch`, `is_admin`, `is_admin_stock`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `cabang`) VALUES
(1058, 'Dimas Dwi Prastio', '74453', 'cipanas', 0, 0, NULL, '$2y$12$RUcnCjsSWG6nAiMwVrvP2elB1p22aoN9QbpdZYXkIwuLInaWSDfb2', NULL, '2026-08-19 14:21:18', '2026-08-20 02:39:26', NULL, 'cipanas'),
(1059, 'IMAS RAFIZA YANTI', '74464', 'jatiasih', 0, 0, NULL, '$2y$12$u.cgiulprh5K7sNQFgyqIOhbJVcRqpV7B9a3e09yLSyvqDgTfv5ku', NULL, '2026-08-19 14:21:18', '2026-08-20 02:39:27', NULL, 'jatiasih'),
(1060, 'ADINDA RAHAYU', '74465', 'jatiasih', 0, 0, NULL, '$2y$12$TIy/jFXXrrlO1KC6lmd/guZDz1y3./1UoetcWbWbfs08HYn0EHkee', NULL, '2026-08-19 14:21:19', '2026-08-20 02:39:27', NULL, 'jatiasih'),
(1061, 'DARUL ARAHMAN', '74467', 'jatiasih', 0, 0, NULL, '$2y$12$FGipH5ESAvKy5CEgGCzWGeC2/sMRbSckHUGxmjl7VtoyYy7Vz/Pwy', NULL, '2026-08-19 14:21:19', '2026-08-20 02:39:28', NULL, 'jatiasih'),
(1062, 'Siti Muharomah', '74582', 'cipanas', 0, 0, NULL, '$2y$12$uUxMyxo0lrWDv/AITA9U/.HszoE.G5MBGTBKwsAll.W/uAovBwslS', NULL, '2026-08-19 14:21:19', '2026-08-20 02:39:28', NULL, 'cipanas'),
(1063, 'MOHAMMAD RAFI ARDI KUSUMO', '74806', 'cianjur', 0, 0, NULL, '$2y$12$bos1uCoqRJAPtUJ5gxAiqOrPYbxiKEkKhSSOHxazqPLFLdi1TGt4.', NULL, '2026-08-19 14:21:20', '2026-08-20 02:39:29', NULL, 'cianjur'),
(1064, 'RAHMAT FAUZI', '74807', 'cianjur', 0, 0, NULL, '$2y$12$k/g6ZfZog7xcOn6uYqmDBueUUgIixiLBIsjF09o6TxFiPAz3HdCCW', NULL, '2026-08-19 14:21:20', '2026-08-20 02:39:29', NULL, 'cianjur'),
(1065, 'LUSIANA', '74808', 'cianjur', 0, 0, NULL, '$2y$12$CyIWi7NBwfxfIai3kVIPn.wtZ/zWfls6Wm2QWbZkOUqCGTanYIe0C', NULL, '2026-08-19 14:21:20', '2026-08-20 02:39:30', NULL, 'cianjur'),
(1066, 'NANDAR SUDARMAN', '74809', 'cianjur', 0, 0, NULL, '$2y$12$3maWXWX2s8QgTsDvR2rI1OAiOmrPqqhdIJu1FqbgAhuF.VQOh7cWC', NULL, '2026-08-19 14:21:21', '2026-08-20 02:39:30', NULL, 'cianjur'),
(1067, 'Alfi Syahril', '74814', 'jatiasih', 0, 0, NULL, '$2y$12$3s9NUCJyRrqtabOfN/MVD.U9XUFZ.XTID/96qag/kXHYGpc/Q.dvu', NULL, '2026-08-19 14:21:21', '2026-08-20 02:39:31', NULL, 'jatiasih'),
(1068, 'ARIQ ATHALLAH HIDAYAT', '74816', 'ciawi', 0, 0, NULL, '$2y$12$Wgr9H7SpOGUGmqEMPgLF5e4EaPYu9qIS0OxSae5WbzpnD5Kx0Ocvu', NULL, '2026-08-19 14:21:21', '2026-08-20 02:39:31', NULL, 'ciawi'),
(1069, 'CAHYA UTAMI', '74817', 'ciawi', 0, 0, NULL, '$2y$12$mbaxtj8De9ueyJoWpKpoSuGXDG0I1KReaHOyg4zc/mbVXLKysulZq', NULL, '2026-08-19 14:21:22', '2026-08-20 02:39:32', NULL, 'ciawi'),
(1070, 'ARIE APRIYANTO', '74818', 'ciawi', 0, 0, NULL, '$2y$12$Oxm8Qvv/2HRCgjSYaU8G.uU2UUk6H2dmfKZbS.Rnhf8bNU2LLdDe2', NULL, '2026-08-19 14:21:22', '2026-08-20 02:39:32', NULL, 'ciawi'),
(1071, 'NABILAH KARAMINA', '74819', 'ciawi', 0, 0, NULL, '$2y$12$Y/jjRLWGV8ccUd/s56ohr.hATj5ZNP26OEgnSboapnJEVjsSRhNJG', NULL, '2026-08-19 14:21:22', '2026-08-20 02:39:33', NULL, 'ciawi'),
(1072, 'Muthia Azzahra', '74820', 'jatiasih', 0, 0, NULL, '$2y$12$1vZyCI/3td/tqleFMElk4.zJ2XDq3nAgrzm7DnAeHWYJrxiWcgklm', NULL, '2026-08-19 14:21:23', '2026-08-20 02:39:33', NULL, 'jatiasih'),
(1073, 'MUHAMAD NOVAN TOYALIS', '74821', 'cianjur', 0, 0, NULL, '$2y$12$G1Rsp5PJqTOCd9QkmU/H8uBA1gvy41kIYkC/rbWNHTr47b.jE7WSS', NULL, '2026-08-19 14:21:23', '2026-08-20 02:39:33', NULL, 'cianjur'),
(1074, 'FABIO ALIF KRISTIANDIKA', '74824', 'jatiasih', 0, 0, NULL, '$2y$12$XW28fmCsCH9enLCYP/xvne/ebVmIpQ9FsC22rAL6cmyqggsyJoYj.', NULL, '2026-08-19 14:21:23', '2026-08-20 02:39:34', NULL, 'jatiasih'),
(1075, 'NABIL VIRZALDO YULMAN', '74825', 'jatiasih', 0, 0, NULL, '$2y$12$GcyRG9dcBhaHGtSHD10GCehkvX.2DUFJMbkZexRwWuChUwNE.S3hC', NULL, '2026-08-19 14:21:23', '2026-08-20 02:39:34', NULL, 'jatiasih'),
(1076, 'MUHAMMAD ZIDAN', '74826', 'jatiasih', 0, 0, NULL, '$2y$12$YuUtdW/y6CXX5.ifZho3mObzrdA4w5OeMKuHlLvEVP4iWWEoJbueW', NULL, '2026-08-19 14:21:24', '2026-08-20 02:39:34', NULL, 'jatiasih'),
(1077, 'BASTIAN WIDANDI CALVINIGO S', '74827', 'jatiasih', 0, 0, NULL, '$2y$12$BsU48QMZ35KJXYch0jcYy.SM/NWcOv4scS09HNro9XpYXCY7KBuaO', NULL, '2026-08-19 14:21:24', '2026-08-20 02:39:34', NULL, 'jatiasih'),
(1078, 'SITA TRIANANDA ANGGRAINI', '74830', 'jatiasih', 0, 0, NULL, '$2y$12$xSYFPi7/Px5D5R/L4I8mc.PB.1rXO/00bhghs1yK4.hWKKpwjuqmG', NULL, '2026-08-19 14:21:24', '2026-08-20 02:36:02', NULL, 'jatiasih'),
(1079, 'ANDERIANSAH WIJAKSONO', '74882', 'jatiasih', 0, 0, NULL, '$2y$12$A6./7ll7T2AqwrK7xWlXiOGQ5a0dUszREYG9oZoPSt8k7q86OFsjK', NULL, '2026-08-19 14:21:25', '2026-08-20 02:36:03', NULL, 'jatiasih'),
(1080, 'SUCI ANGGI PRATAMI', '74884', 'jatiasih', 0, 0, NULL, '$2y$12$NCfLkoBqaeib84ktHjoRpePovJsw9JKdTFzJtJZrJZ/fWqWgqmN9.', NULL, '2026-08-19 14:21:25', '2026-08-20 02:36:03', NULL, 'jatiasih'),
(1081, 'Zulfa Nazwa Raditasya', '74886', 'jatiasih', 0, 0, NULL, '$2y$12$Mrwq3G.FvEO5vYJnGm6W0ue0Puyc1JXb6vfhDyET37IGWje87TzVu', NULL, '2026-08-19 14:21:25', '2026-08-20 02:36:04', NULL, 'jatiasih'),
(1082, 'Vani Nabila', '74887', 'jatiasih', 0, 0, NULL, '$2y$12$PpA7y/NUf6dx2/HYt0gIvOaKllAvP1ubkDZWKokb6K9XgI3io/I6m', NULL, '2026-08-19 14:21:26', '2026-08-20 02:36:05', NULL, 'jatiasih'),
(1083, 'ALYA POETRI NABILLA', '74890', 'jatiasih', 0, 0, NULL, '$2y$12$QyFuY5gPgKA5wqXXEm/BCufnOJluCaHPOk4oH7uGMFlEvK1MdlYo2', NULL, '2026-08-19 14:21:26', '2026-08-20 02:36:05', NULL, 'jatiasih'),
(1084, 'Galang Persanta Kusuma', '75142', 'jatiasih', 0, 0, NULL, '$2y$12$z76bF6jg4ayEp0rGFq2WC.nW/u160jECWjwdrNQ2C2T91xve8Zb66', NULL, '2026-08-19 14:21:26', '2026-08-20 02:36:06', NULL, 'jatiasih'),
(1085, 'SAFIRAH NUR OCTAVIANI', '75204', 'ciawi', 0, 0, NULL, '$2y$12$dUFyYcQvaUkGhgCgjxDYg.t5P4a6uo./YQXkJt4TG5kDeDGs9IOAa', NULL, '2026-08-19 14:21:27', '2026-08-20 02:36:07', NULL, 'ciawi'),
(1086, 'CHIKA AUDRINA', '75205', 'ciawi', 0, 0, NULL, '$2y$12$Rw3egxm7UGI1J/07wCZiFOL31l3stkZMWF4hTBxw5NwNUetKj0EZy', NULL, '2026-08-19 14:21:27', '2026-08-20 02:36:08', NULL, 'ciawi'),
(1087, 'HENDRI SAPARI', '75206', 'ciawi', 0, 0, NULL, '$2y$12$Nih3hsOSFPGAZDvdwM5ojOEAmxvzGVYxKOJXc69w/rALcUrrGRBh6', NULL, '2026-08-19 14:21:28', '2026-08-20 02:36:08', NULL, 'ciawi'),
(1088, 'Ferdiansyah Maino', '75253', 'jatiasih', 0, 0, NULL, '$2y$12$tPt0GcLASJnyGN01jGWUneoYEnb4yXL8MY8f/WOoh8s3a/Pk6vS82', NULL, '2026-08-19 14:21:28', '2026-08-20 02:36:08', NULL, 'jatiasih'),
(1089, 'Rio Setiano', '75254', 'jatiasih', 0, 0, NULL, '$2y$12$SCAKawR2Iw3XPHkx9dBHe.EpN1IwRC2MmXDSkWEuWhOgZb6edNiyO', NULL, '2026-08-19 14:21:28', '2026-08-20 02:36:09', NULL, 'jatiasih'),
(1090, 'Rizqiya Rahcma Fadhillah', '75261', 'jatiasih', 0, 0, NULL, '$2y$12$jm.JHlmlna1jtXKiVoLXFeRR7gKjhI0NrJH4fM0k4u4H9ZGcJkj.a', NULL, '2026-08-19 14:21:28', '2026-08-20 02:36:09', NULL, 'jatiasih'),
(1091, 'HENDRIK HASOLOAN', '75262', 'jatiasih', 0, 0, NULL, '$2y$12$G7YqUC.znu9ZFrfMzYuSi.JUMVfkJPEwBO6MV6vWvYD6J.uyC9fJm', NULL, '2026-08-19 14:21:29', '2026-08-20 02:36:10', NULL, 'jatiasih'),
(1092, 'MUHAMMAD FATHAN HASBUR RAHMAN', '75633', 'jatiasih', 0, 0, NULL, '$2y$12$K8aLO4foRHRHDonHEtmAIeEMLFriaeb./0hbqWdGX//AuHhswt5r6', NULL, '2026-08-19 14:21:29', '2026-08-20 02:36:10', NULL, 'jatiasih'),
(1093, 'NABILAH SALWA KHALISHAH', '75634', 'jatiasih', 0, 0, NULL, '$2y$12$c/39Jdbncut0gl.vPlVyLuk97JcH6Ms9jBXaGOIFMfwnCPYzVLuEC', NULL, '2026-08-19 14:21:29', '2026-08-20 02:36:10', NULL, 'jatiasih'),
(1094, 'Muhamad Rafli Eka Saputra', '75640', 'cinere', 0, 0, NULL, '$2y$12$N2oZf5o9N8enLA.iVuhxWetCucbWreNJhKbPTVYVHtB0lbs1uKD1.', NULL, '2026-08-19 14:21:30', '2026-08-20 02:36:11', NULL, 'cinere'),
(1095, 'Herman Waruwu', '75641', 'cinere', 0, 0, NULL, '$2y$12$VWnqJJ3ZmKCAKwJnMifKN.FPtkL1VwEJNYiZn47Ks2peD5XCxzfG2', NULL, '2026-08-19 14:21:30', '2026-08-20 02:36:11', NULL, 'cinere'),
(1096, 'Indra Gunawan Prihantoro', '75642', 'cinere', 0, 0, NULL, '$2y$12$2dpM7un61EIaiYo7kP2i0eewZNFU1fb8IsrhqMlwIuzc0JIb6dYU2', NULL, '2026-08-19 14:21:30', '2026-08-20 02:36:12', NULL, 'cinere'),
(1097, 'Aldi Saputra', '75648', 'cinere', 0, 0, NULL, '$2y$12$EWAnKULeQ3IxRiM5lu0biO1Qrh3xTC7WA2va4Z6n18PPzCikMEcii', NULL, '2026-08-19 14:21:31', '2026-08-20 02:36:12', NULL, 'cinere'),
(1098, 'Taufiqurahman', '75649', 'cinere', 0, 0, NULL, '$2y$12$LPN7vyxX8r4/fxDe2eJ9nuN5WGCpHjVAEgrbLjTafNnGiveiNfnne', NULL, '2026-08-19 14:21:31', '2026-08-20 02:36:13', NULL, 'cinere'),
(1099, 'ALFIAN', '75650', 'cinere', 0, 0, NULL, '$2y$12$jE7X1F7sT8wUdNTDYG6VeO.SQUAM82p/jIwW3WDWvLghFdyjerkMm', NULL, '2026-08-19 14:21:31', '2026-08-20 02:36:13', NULL, 'cinere'),
(1100, 'Evandra Parmato Intan', '75651', 'cinere', 0, 0, NULL, '$2y$12$/ZHsqsFLmtdd6XPElEhFTeMPF5Zcv7Z/Jjs90P8Es3HgxDgoRKrJe', NULL, '2026-08-19 14:21:32', '2026-08-20 02:36:13', NULL, 'cinere'),
(1101, 'DESSY NURHAYATI', '75652', 'cinere', 0, 0, NULL, '$2y$12$DQagC3qBqy986s9JZZt5k.29h2nQ10sxXefL.VIHy4gSN1u6ROTyS', NULL, '2026-08-19 14:21:32', '2026-08-20 02:36:14', NULL, 'cinere'),
(1102, 'Angellica Bengan Lemaking', '75654', 'cinere', 0, 0, NULL, '$2y$12$LLytsKiA0VDdGoPwWxbzA.6neRcTF20u4QhtrfyueZj8./GB3rx9G', NULL, '2026-08-19 14:21:32', '2026-08-20 02:36:14', NULL, 'cinere'),
(1103, 'MUHAMMAD RAFI FADHILAH', '75663', 'jatiasih', 0, 0, NULL, '$2y$12$aQa.iw//sjnL2sgr/siXmOYFFVRzp3hVSpTmeMksChf80Sn4ln6ka', NULL, '2026-08-19 14:21:32', '2026-08-20 02:36:14', NULL, 'jatiasih'),
(1104, 'Ahmad Purwadi', '75664', 'ciawi', 0, 0, NULL, '$2y$12$JAhFvWRvZQ/F3/1XE5zVpuBvbNgc/ESNLVC.3661KP5Cm1JfGa6j.', NULL, '2026-08-19 14:21:33', '2026-08-20 02:36:15', NULL, 'ciawi'),
(1105, 'Ade Taufik iskandar', '75665', 'cianjur', 0, 0, NULL, '$2y$12$uj8bG6ErGq4h3zkyEVvw/.rR40Vi3xLGVSiex3ndG5MRO057VW0YG', NULL, '2026-08-19 14:21:33', '2026-08-20 02:36:15', NULL, 'cianjur'),
(1106, 'BUNAYA KHAMSAH HISYAM', '75683', 'cinere', 0, 0, NULL, '$2y$12$bAUtxOJTeOOE6aWltCfv3.O.wStXeqNwezhsvFddOMPnH2mqD.Rlu', NULL, '2026-08-19 14:21:33', '2026-08-20 02:36:15', NULL, 'cinere'),
(1107, 'JOVANKA ASYER VALIANT TIMBULENG', '75825', 'ciawi', 0, 0, NULL, '$2y$12$WkSk3VFTPJ662Bz/x8ZikOp5SQEw2Yg3ePeBw7Ewm.k5WoTQ4Pvhi', NULL, '2026-08-19 14:21:34', '2026-08-20 02:36:16', NULL, 'ciawi'),
(1108, 'BIANCA ENDRIZKYAN', '75827', 'ciawi', 0, 0, NULL, '$2y$12$hMt1Exzxq4CyB8hzjEuFp.OjmpfQtZ6mVzSCemXozNVNhV16zBTLi', NULL, '2026-08-19 14:21:34', '2026-08-20 02:36:16', NULL, 'ciawi'),
(1109, 'DEWI FATIMAH', '75828', 'ciawi', 0, 0, NULL, '$2y$12$KxMDLb0n486jXDYngOkjdulP0iaJsNHZg3ylOwvOy77b1Lmstk5CS', NULL, '2026-08-19 14:21:34', '2026-08-20 02:36:17', NULL, 'ciawi'),
(1110, 'M MUGI MARJUKI', '75830', 'ciawi', 0, 0, NULL, '$2y$12$CU/tJP.gV5NItrjL4BL7QOXwmHEtUe7O2CF7ZgBpjt8XH.PjFKN8S', NULL, '2026-08-19 14:21:34', '2026-08-20 02:36:17', NULL, 'ciawi'),
(1111, 'Syarip Destian Firmansyah', '75832', 'jatiasih', 0, 0, NULL, '$2y$12$NMR4e2c1Ds5hs5vMAezQAeKYmE0Ry4SYTbHCLwwgs5poUYGpodXva', NULL, '2026-08-19 14:21:35', '2026-08-20 02:36:17', NULL, 'jatiasih'),
(1112, 'Rajib Kumar', '75833', 'jatiasih', 0, 0, NULL, '$2y$12$nt8onoGdY3QBOykak4Svoec6co0gK5YYv4hI3Jt3n1HZ8crQT07pW', NULL, '2026-08-19 14:21:35', '2026-08-20 02:36:18', NULL, 'jatiasih'),
(1113, 'annisa risya maulana', '75834', 'cinere', 0, 0, NULL, '$2y$12$hhvo5QA4CHPf74560pceV.2KBCBXcMPqej9Ki7WoSujDv5Vknw3Iq', NULL, '2026-08-19 14:21:35', '2026-08-20 02:36:18', NULL, 'cinere'),
(1114, 'SILVYA LAROSA SIHOMBING', '75835', 'jatiasih', 0, 0, NULL, '$2y$12$2O7de6n3mRgsE07EftJYVuX1xzZbuGVSIv2W9.k/Y/DlRkyz85Y5.', NULL, '2026-08-19 14:21:35', '2026-08-20 02:36:19', NULL, 'jatiasih'),
(1115, 'RAYNALDI RAMADAN', '75836', 'cianjur', 0, 0, NULL, '$2y$12$hTnfEO.xoarE6CAx1HDhfu6KnE6kErpASS/9RQzFaQ2XBKQXfCEue', NULL, '2026-08-19 14:21:36', '2026-08-20 02:36:19', NULL, 'cianjur'),
(1116, 'AGIS FACHRI ADZIKRI', '75837', 'cianjur', 0, 0, NULL, '$2y$12$2EO.NlzR/c3.ELKBWHqq.uxJ/L/8/afHi4g4p4p.iWo4DnfDm4.AG', NULL, '2026-08-19 14:21:36', '2026-08-20 02:36:19', NULL, 'cianjur'),
(1117, 'Syahla Yulinar Rahma', '75838', 'cipanas', 0, 0, NULL, '$2y$12$ez2snsJwWMhHdcVM/EZz2ed7l72pxCeG4SvsKEA7r2JzolGPN1ROu', NULL, '2026-08-19 14:21:36', '2026-08-20 02:36:20', NULL, 'cipanas'),
(1118, 'Indra Koswara', '75839', 'cianjur', 0, 0, NULL, '$2y$12$uvljfjZKU7z4a3P2wFbr5eXzKG2Vcjq7FmWqPz341m.lkRIDxlsjK', NULL, '2026-08-19 14:21:37', '2026-08-20 02:36:20', NULL, 'cianjur'),
(1119, 'Ridwan hidayat', '75879', 'cianjur', 0, 0, NULL, '$2y$12$cgdLeUxTzvo4.6g4Ni/CjezkzUjNJX3RLuF42Ee1kChnMwyLREsLe', NULL, '2026-08-19 14:21:37', '2026-08-20 02:36:21', NULL, 'cianjur'),
(1120, 'RIFQI PUTRA PRADANA', '75880', 'ciawi', 0, 0, NULL, '$2y$12$W09CGWhOxTFa2coP.BFSm.XmsiyVU6JiesS9a2ajHhycep.TbhjMG', NULL, '2026-08-19 14:21:37', '2026-08-20 02:36:21', NULL, 'ciawi'),
(1121, 'MUHAMMAD FAIZ FATHUR RAHMAN', '75887', 'jatiasih', 0, 0, NULL, '$2y$12$LF2v.rCd0fB/g3Rr6hXMluxRWigyLyTj2zOt041HXLVF2421OnH66', NULL, '2026-08-19 14:21:37', '2026-08-20 02:36:21', NULL, 'jatiasih'),
(1122, 'RAIHAN ARRAFI', '75888', 'jatiasih', 0, 0, NULL, '$2y$12$TrW0H7cK7lpm1mLPZwgDLe.5zu6F3B8948nogjYqv/Str5lyMNIPC', NULL, '2026-08-19 14:21:38', '2026-08-20 02:36:22', NULL, 'jatiasih'),
(1123, 'MUHAMMAD HARRIS PRATAMA', '75889', 'jatiasih', 0, 0, NULL, '$2y$12$fh.Qj6o9ypgIAAzLMQwx4uhCDEKRqqx0n1.YjkTHww1VT1YBk.7AC', NULL, '2026-08-19 14:21:38', '2026-08-20 02:36:22', NULL, 'jatiasih'),
(1124, 'SANTI ROSANTI', '75890', 'jatiasih', 0, 0, NULL, '$2y$12$irCxA9CgiRCpVStq7fqriuUOFTknFJXPbjrDXg0WDeANVJN6aguz2', NULL, '2026-08-19 14:21:38', '2026-08-20 02:36:22', NULL, 'jatiasih'),
(1125, 'Adi Purwadi', '75912', 'jatiasih', 0, 0, NULL, '$2y$12$uRxp0fLyqKE1Jap.OxEyS.68TK/tN5xVHHDBG6dHG9kNCIeej.wI6', NULL, '2026-08-19 14:21:39', '2026-08-20 02:36:23', 'bm_sh', 'jatiasih'),
(1126, 'SITI AGMIFA', '75913', 'jatiasih', 0, 0, NULL, '$2y$12$6UdDULc9ldYTrfbVGoZKg.rFo2PYIO4Vkt/isqlEu.PZ9xbsAglh.', NULL, '2026-08-19 14:21:39', '2026-08-20 02:36:23', NULL, 'jatiasih'),
(1127, 'MUHAMMAD DAHLAN, S.E', '75914', 'jatiasih', 0, 0, NULL, '$2y$12$Ve9uzQBEMnGYuNQg5EhVzOlhMB7C455.V4CzADnD0scdguhuHActi', NULL, '2026-08-19 14:21:39', '2026-08-20 02:36:24', NULL, 'jatiasih'),
(1128, 'ADI RIZQI AULIA', '75915', 'jatiasih', 0, 0, NULL, '$2y$12$5mZkOpUUfkQ40x8aBO.oYONSNzkwqjO6SymBIZ2IjznIvjyxb8wOK', NULL, '2026-08-19 14:21:39', '2026-08-20 02:36:24', NULL, 'jatiasih'),
(1129, 'MUHAMMAD BRAMANTYO ARSAND', '75916', 'jatiasih', 0, 0, NULL, '$2y$12$1QuYNMdB9RtwTedjjoG6pufBrf6HcPPQmZr9z6wGZn1x/XA4uyKxe', NULL, '2026-08-19 14:21:40', '2026-08-20 02:36:24', NULL, 'jatiasih'),
(1130, 'SULAIMAN APRIRUSMAN', '75917', 'jatiasih', 0, 0, NULL, '$2y$12$1JQFcOW4rHiS4J4.LCs7U.H7RQrIElQ6otU91hixd4x1RulAQTOdS', NULL, '2026-08-19 14:21:40', '2026-08-20 02:36:25', NULL, 'jatiasih'),
(1131, 'RAISSA RAMADHANI RUSMANA', '75918', 'jatiasih', 0, 0, NULL, '$2y$12$sM8UfMUi4mYf/bCo3/SZ4uJDBlk6MPQ.v3VfM45KoIGL7shePQ9xa', NULL, '2026-08-19 14:21:40', '2026-08-20 02:36:25', NULL, 'jatiasih'),
(1132, 'CICIH ERI YANI', '75919', 'jatiasih', 0, 0, NULL, '$2y$12$G0qhL/suFfQUzt5tKxJfdevSbYx3rywzzUvCMLCJpG68zZPFvV1Lu', NULL, '2026-08-19 14:21:41', '2026-08-20 02:36:25', NULL, 'jatiasih'),
(1133, 'MOHAMMAD RAIHAN NOVRIALTA', '75920', 'jatiasih', 0, 0, NULL, '$2y$12$8bXsVtxv2ge8PpgerwOAoO/eOJ9b/ZX4dx96lPwYfL2LHfVONiDQ6', NULL, '2026-08-19 14:21:41', '2026-08-20 02:36:26', NULL, 'jatiasih'),
(1134, 'MUHAMAD DEHYA FARABI', '75921', 'jatiasih', 0, 0, NULL, '$2y$12$bnZPgjn34/6W1g8cHZXRUuy1t/1cNdpUjSgG1Qi17cX5cBnUT7jOy', NULL, '2026-08-19 14:21:41', '2026-08-20 02:36:26', NULL, 'jatiasih'),
(1135, 'MUHAMMAD RIZKY ALIFIANT', '75922', 'jatiasih', 0, 0, NULL, '$2y$12$lDYZQUs06TDjqx9HWoluSeTeCJIIsNC616146S1/RqxZrAEATKq9q', NULL, '2026-08-19 14:21:41', '2026-08-20 02:36:26', NULL, 'jatiasih'),
(1136, 'MONARD DEKA PERMANA SULTAN', '76038', 'jatiasih', 0, 0, NULL, '$2y$12$t6TWMLmui8bxbX.xZoJ1c.lr0C.etT.fOjx35qvkFCuK8IRa6su2.', NULL, '2026-08-19 14:21:42', '2026-08-20 02:36:27', NULL, 'jatiasih'),
(1137, 'FERO SENTANU', '76039', 'cinere', 0, 0, NULL, '$2y$12$BogfiFwdHQRChDTnH2pgzuB0.xIIxU7ximpxtYd1wUgV8i.hNugEi', NULL, '2026-08-19 14:21:42', '2026-08-20 02:36:27', NULL, 'cinere'),
(1138, 'Anastasya Khoerul Umah', '76087', 'jatiasih', 0, 0, NULL, '$2y$12$ltRlX0ftKGcLiGyHDDEa/OuaCHqKrbMd5ttLQqeVE6rzG6CZoluIG', NULL, '2026-08-19 14:21:42', '2026-08-20 02:36:28', NULL, 'jatiasih'),
(1139, 'Adira nanda permata', '76088', 'jatiasih', 0, 0, NULL, '$2y$12$2U0WbqgBLKqf0HJ.kpv8ROI6hdIw0Uu5fAbSlO/CgGxnKJSKfDuEe', NULL, '2026-08-19 14:21:43', '2026-08-20 02:36:28', NULL, 'jatiasih'),
(1140, 'Dede lisdayanti', '76089', 'jatiasih', 0, 0, NULL, '$2y$12$40IXgsdEW/0CkXrOJ0Uf8OJ8ugJAIPKZdFI0.Qq1G6JmALM4Yvwz.', NULL, '2026-08-19 14:21:43', '2026-08-20 02:36:28', NULL, 'jatiasih'),
(1141, 'Dea Ananda', '76091', 'jatiasih', 0, 0, NULL, '$2y$12$Q8GQfbhrkup5Gmc8ti3aP..jMTCJ2vGTO/UkPaU27KD4aAFz1vpzC', NULL, '2026-08-19 14:21:43', '2026-08-20 02:36:29', NULL, 'jatiasih'),
(1142, 'alika denia ramadhani', '76093', 'jatiasih', 0, 0, NULL, '$2y$12$YwCi4r1v4rZLxsrjLJuWDum6rvS0HUdT0evdqQcxZZjdotxdfzeYa', NULL, '2026-08-19 14:21:44', '2026-08-20 02:36:29', NULL, 'jatiasih'),
(1143, 'Dina amelia puspita sari', '76095', 'jatiasih', 0, 0, NULL, '$2y$12$ppTTjD/F4UwvkFoXOqwKXOi9wMacCzzEfJoe64saii/I/glVQ4K7C', NULL, '2026-08-19 14:21:44', '2026-08-20 02:36:30', NULL, 'jatiasih'),
(1144, 'M ARYA RIZQI PRATAMA', '76337', 'cianjur', 0, 0, NULL, '$2y$12$g6DThIrZMOgZVaCqufTQhepw2E72cXmA82VaoPhimVt3F6a9vARgW', NULL, '2026-08-19 14:21:44', '2026-08-20 02:36:31', NULL, 'cianjur'),
(1145, 'M. SAMSA NUR RAMDHANY', '76338', 'cianjur', 0, 0, NULL, '$2y$12$tRQdpsTPw7gIWmABPEUQG.seagY9TUOKZX6M76I14Z5w4NxAU.lQ6', NULL, '2026-08-19 14:21:45', '2026-08-20 02:36:31', NULL, 'cianjur'),
(1146, 'Bram Septian Rinaldi', '76458', 'cinere', 0, 0, NULL, '$2y$12$vhE30l3wSIZ3D/tVEKFKku03.P5IynNVK82AryJNd6PLdCthxF2Nq', NULL, '2026-08-19 14:21:46', '2026-08-20 02:36:33', NULL, 'cinere'),
(1147, 'Iwan kustiawan', '76465', 'cinere', 0, 0, NULL, '$2y$12$rqCysnsLDC/KpLg5sb0S5.5OzaGwQphMJ3/1gy0Rev3bjtt0iFdCm', NULL, '2026-08-19 14:21:47', '2026-08-20 02:36:34', NULL, 'cinere'),
(1148, 'ARIEF WICAKSONO', '76859', 'jatiasih', 0, 0, NULL, '$2y$12$bdAzvqH8jBK3LotOLwolAeFVWANPCsvquXI62iihTa0YqD7nZlC9G', NULL, '2026-08-19 14:21:47', '2026-08-20 02:36:36', NULL, 'jatiasih'),
(1149, 'M TAUFIQ DINANSYAH', '76860', 'jatiasih', 0, 0, NULL, '$2y$12$UdNUIWStGK8xwihkXDdomuRH62exg1N/tU0so1Wj0J.hJJ/KNEkR2', NULL, '2026-08-19 14:21:48', '2026-08-20 02:36:37', NULL, 'jatiasih'),
(1150, 'MUHAMMAD FIRNANDY HAYSAN', '76861', 'jatiasih', 0, 0, NULL, '$2y$12$lum3Fme1ZAZYS0Lgm45uqOU/.ia6C9C6mYU69lNrSJeYC2Gj1wQPi', NULL, '2026-08-19 14:21:48', '2026-08-20 02:36:37', NULL, 'jatiasih'),
(1151, 'SATRIO TEGAR PAMUNGKAS', '76862', 'jatiasih', 0, 0, NULL, '$2y$12$a.kxZDJsavSunBYeVFrlsOTmVWTdkAyb8g8/O8Dmn.zQUPttjqqQW', NULL, '2026-08-19 14:21:48', '2026-08-20 02:36:38', NULL, 'jatiasih'),
(1152, 'SILMA YUTIA KHAERUNISA', '76879', 'jatiasih', 0, 0, NULL, '$2y$12$Ve9HQiw276N5kczJ2M9Q/eizilh1QvmSG73tnolB/P.4zsGWC0ZRm', NULL, '2026-08-19 14:21:48', '2026-08-20 02:36:38', NULL, 'jatiasih'),
(1153, 'HILMAN SOLIHIN', '76880', 'cianjur', 0, 0, NULL, '$2y$12$Bd8IafngBAbJpEf8REs8qe1BTeSpEyDHW7OjTM1FoHWosRgtIyI9y', NULL, '2026-08-19 14:21:49', '2026-08-20 02:36:38', NULL, 'cianjur'),
(1154, 'Andrian Pratama', '76883', 'cinere', 0, 0, NULL, '$2y$12$VallHq3wT5kd3jJHNvDGAOSeivWjAeu/kkqkFhs2QuJUfdaXvelry', NULL, '2026-08-19 14:21:49', '2026-08-20 02:36:39', NULL, 'cinere'),
(1155, 'Adven Immanuel', '76884', 'cinere', 0, 0, NULL, '$2y$12$B3jfn2sb4FqDZKsyC5Cbh.LTv8MrQTSiI1B5Bo38WY6ydzy5rKeR.', NULL, '2026-08-19 14:21:49', '2026-08-20 02:36:39', NULL, 'cinere'),
(1156, 'Andytta Mappa Saile', '76886', 'cinere', 0, 0, NULL, '$2y$12$7W3dD4fsrwaAFEFvm00e1.hkyH0u9zUAaqJi1uVCCla6F81TD6GSW', NULL, '2026-08-19 14:21:49', '2026-08-20 02:36:40', NULL, 'cinere'),
(1157, 'Rizky Setyadi', '77052', 'jatiasih', 0, 0, NULL, '$2y$12$Ma7ONyxK1gVBqtoibzrIHubui1GPG9XjyZ/eK1X3yAhW2qbrQuLZ.', NULL, '2026-08-19 14:21:50', '2026-08-20 02:36:40', NULL, 'jatiasih'),
(1158, 'Anggi Syawaludin', '77107', 'ciawi', 0, 0, NULL, '$2y$12$FQmSlQYEdrnQI3BU.kHcC.USpwR4qseU9xBT6AgdGweBH7LI0.B5e', NULL, '2026-08-19 14:21:51', '2026-08-20 02:36:42', NULL, 'ciawi'),
(1159, 'NOVI YULIANTI', '77416', 'cinere', 0, 0, NULL, '$2y$12$uQb94rURXklXXrN.dxgwUOg5tk0DkuXe4MsDG81PfM/D8oqBFjy72', NULL, '2026-08-19 14:21:52', '2026-08-20 02:36:43', NULL, 'cinere'),
(1160, 'Dony Budi Setiawan', '77418', 'jatiasih', 0, 0, NULL, '$2y$12$BIpDQr81quYGBrBQ/FqD5uUa70I2Lwfjd15dOyXMDEiJUBBs/xh1y', NULL, '2026-08-19 14:21:53', '2026-08-20 02:36:44', NULL, 'jatiasih'),
(1161, 'FOERQON ALIYYUN HAKIM', '77423', 'cipanas', 0, 0, NULL, '$2y$12$sWdIMwf0CELFQSGz5bgiT.EA.BWZyLUykKxZ1ol9VzFN3SgOoe6VW', NULL, '2026-08-19 14:21:53', '2026-08-20 02:36:45', NULL, 'cipanas'),
(1162, 'IKHSAN MUARDIANSYAH', '77749', 'cipanas', 0, 0, NULL, '$2y$12$Ugjng6iWbed9c8vxjGLEV.txf5japIIkyVdqKCc5vqGpivthVZfFK', NULL, '2026-08-19 14:21:55', '2026-08-20 02:36:47', NULL, 'cipanas'),
(1163, 'Haris Sopiandi', '77900', 'cianjur', 0, 0, NULL, '$2y$12$8tKgazvpVvqf88EY.D3vNObBTLfUYj7XqX7WSLNgSEnfR.lp0HnB.', NULL, '2026-08-19 14:21:57', '2026-08-20 02:36:51', 'bm_sh', 'cianjur'),
(1164, 'Rainaldi Sandes', '9886', 'ciawi', 0, 0, NULL, '$2y$12$jixXFjy67RCtsq.1yZEMIe/mNxl7mKmkWz5r45B0ZmkHJkWzO08rC', NULL, '2026-08-19 14:22:01', '2026-08-20 02:36:56', 'bm_sh', 'ciawi'),
(1165, '72657', 'agung tri kurniawan', 'cianjur', 0, 0, NULL, '$2y$12$6d3wk3E8rJt0PBvaAqpemeHi8UUaBQ0yDXRtzTo8rY9r2oMe77uk6', NULL, '2026-08-19 14:22:02', '2026-08-20 02:36:56', NULL, 'cianjur'),
(1166, 'Alifya Adinda Zikra', 'alifyait', 'cinere', 0, 0, NULL, '$2y$12$nQVYu5d3ANVfQFbdz7gK7.RFMIEV5l.42Xaokt27fXUAmulmIryMO', NULL, '2026-08-19 14:22:02', '2026-08-20 02:36:57', NULL, 'cinere'),
(1167, 'Sri Hartatik', 'am', 'cinere', 0, 0, NULL, '$2y$12$NKbPUCrNUdCDGNo7vRw/B.Th90P/Cq7WV97TTt50n9kRlGbVhi03O', NULL, '2026-08-19 14:22:02', '2026-08-20 02:36:57', NULL, 'cinere'),
(1168, 'antariksa', 'ant', 'cianjur', 0, 0, NULL, '$2y$12$PJkgbsU8NNh3OXUuZ59XFuljpG2nWYwM/0uIn70xLwr7vNVczeJ9W', NULL, '2026-08-19 14:22:02', '2026-08-20 02:36:57', NULL, 'cianjur'),
(1169, 'Rismawati', 'audit1', 'jatiasih', 0, 0, NULL, '$2y$12$4TaUOoeu2tvIAcFCu16MP.A3U2mhz939M4ENhabG/W5EUl8NjYj5W', NULL, '2026-08-19 14:22:03', '2026-08-20 02:36:58', NULL, 'jatiasih'),
(1170, 'syarifudin', 'bks-cnrsa1', 'cinere', 0, 0, NULL, '$2y$12$rY3PCz6dD8h6E1Y8qjy3m.anKS6SgzwxOsOEjatgtezeJoiA94rNW', NULL, '2026-08-19 14:22:03', '2026-08-20 02:36:58', NULL, 'cinere'),
(1171, 'bry', 'bry', NULL, 0, 0, NULL, '$2y$12$3tWvYysP6IkvwB3wCQsyr..d6Fpy2PpAjBwVWG4WXltPmEbNgaE76', NULL, '2026-08-19 14:22:03', '2026-08-20 02:36:59', NULL, NULL),
(1172, 'DENNY SUGANDA', 'cjr-denny', 'cianjur', 0, 0, NULL, '$2y$12$eNgiL6x6DvzKy6xo3noXceSfevCoBocCJSNZR7YyJ.2LxAXU7sQGC', NULL, '2026-08-19 14:22:04', '2026-08-20 02:37:00', NULL, 'cianjur'),
(1173, 'BUDI TANUJAYA', 'cps-adh', 'cipanas', 0, 0, NULL, '$2y$12$PpiFGT5ygcURPG6IZ2oU1uZRsm5KUuht6ZSSixjA30z373V3A4/.S', NULL, '2026-08-19 14:22:04', '2026-08-20 02:37:00', NULL, 'cipanas'),
(1174, 'Asih', 'cs-bekasi', 'jatiasih', 0, 0, NULL, '$2y$12$Xxv5ISQUc0DcWdXYXhTQCOuYUEkv1kUwox9mLqluciISJolwloSXS', NULL, '2026-08-19 14:22:04', '2026-08-20 02:37:01', NULL, 'jatiasih'),
(1175, 'ANASTASIA', 'cs-ciawi', 'ciawi', 0, 0, NULL, '$2y$12$WrP19B0ZfvaKPRloz8oZseCaYBLYLEvSA4m1s0snXlyWEK7OzTRDC', NULL, '2026-08-19 14:22:05', '2026-08-20 02:37:01', NULL, 'ciawi'),
(1176, 'Nurul Rahma', 'cs-cjr', 'cianjur', 0, 0, NULL, '$2y$12$6.Q0Fw1AOCZvPKnXd9r14eRnErG5MsZUqp.OO2d2YUk7wIbCTtOGm', NULL, '2026-08-19 14:22:05', '2026-08-20 02:37:02', NULL, 'cianjur'),
(1177, 'Nurul Rahmah', 'cs-cps', 'cipanas', 0, 0, NULL, '$2y$12$ynj2a5kSeIP0t1.iLt5oP.zQ2g8ZVk7CvjCj.5.Zu0rK9qZ0JIKqy', NULL, '2026-08-19 14:22:05', '2026-08-20 02:37:02', NULL, 'cipanas'),
(1178, 'YETI ROSTIKA', 'dca00faktur', 'cianjur', 0, 0, NULL, '$2y$12$sPWpBE.DN1GTPXV3VMcrmOmG8WMsZzr/eOyGTkRtvVeFsHjqr1yL6', NULL, '2026-08-19 14:22:05', '2026-08-20 02:37:03', NULL, 'cianjur'),
(1179, 'Ahmad Ilyas', 'dcabksadhbp', 'bp', 0, 0, NULL, '$2y$12$3ojQ5ON0tvevv31bSPwxGO8ds7slh.N4Iz5.HXvTpk7mzqa20ZMiy', NULL, '2026-08-19 14:22:06', '2026-08-20 02:37:03', NULL, 'bp'),
(1180, 'OGGY SUPPORT FOR JATIASIH', 'dcabksadm2', 'jatiasih', 0, 0, NULL, '$2y$12$pg6mE5sdWG0llxNPKkhIyuxh2z5Y27LO.QcukLkYaJbYETs5NAMe2', NULL, '2026-08-19 14:22:06', '2026-08-20 02:37:04', NULL, 'jatiasih'),
(1181, 'DCABKSADMUNIT', 'dcabksadmunit', 'jatiasih', 0, 0, NULL, '$2y$12$m/V2r8UIAXLDR3S7xy.es.liAZ8LxMlbxUYj6.FJVJp8kSJ5xBU.S', NULL, '2026-08-19 14:22:07', '2026-08-20 02:37:04', NULL, 'jatiasih'),
(1182, 'ARYA', 'dcabksbm', 'jatiasih', 0, 0, NULL, '$2y$12$FY.EJLQ0imYE52pHI/ANPeWDMUgQKkSmEhajBsHRWXInFvUYMQRya', NULL, '2026-08-19 14:22:07', '2026-08-20 02:37:04', 'bm_sh', 'jatiasih'),
(1183, 'DCABKSCRO', 'dcabkscro', 'jatiasih', 0, 0, NULL, '$2y$12$CJ3WA7Akj7Lj.fhcuAuXceGB2SWzDuDGa2av.9f7Y1fZ5cutEqwmW', NULL, '2026-08-19 14:22:07', '2026-08-20 02:37:05', NULL, 'jatiasih'),
(1184, 'DCABKSFAKTUR', 'dcabksfaktur', NULL, 0, 0, NULL, '$2y$12$MPwduPqfBWjTpf6EO6pVF.TjVK60a0ahyZZApfvkkSI8j0q1yP8Gi', NULL, '2026-08-19 14:22:07', '2026-08-20 02:37:05', NULL, NULL),
(1185, 'ERIN', 'dcabkskasir', 'jatiasih', 0, 0, NULL, '$2y$12$V./2lFtdRoEezYc1CIuX5.QvYglazJEIVA3IZrQb.yqi34oEMbpje', NULL, '2026-08-19 14:22:08', '2026-08-20 02:37:06', NULL, 'jatiasih'),
(1186, 'ERIN', 'dcabkskasirbp', 'bp', 0, 0, NULL, '$2y$12$aW33DfhrpI5MU0FFDAWsNu9qX5W90.UvhPSTsvov98EEVaIe6j0zK', NULL, '2026-08-19 14:22:08', '2026-08-20 02:37:06', NULL, 'bp'),
(1187, 'ASIH WIANTI', 'dcabkssa1', 'jatiasih', 0, 0, NULL, '$2y$12$8qNMMpbwpVJGRFO1eyyXlOtHX92wTaWq29VyZseYT48mMQQ0z/Qyq', NULL, '2026-08-19 14:22:08', '2026-08-20 02:37:07', NULL, 'jatiasih'),
(1188, 'SRI NOPIA LESTARI', 'dcabkssadm', 'jatiasih', 0, 0, NULL, '$2y$12$uYDoqjXj75rNzATY3W9sSu/llf6R7NA6qQmeVma0fS/EPFhaA/js2', NULL, '2026-08-19 14:22:09', '2026-08-20 02:37:08', NULL, 'jatiasih'),
(1189, 'SRI NOPIA LESTARI', 'dcabkssadmbp', 'bp', 0, 0, NULL, '$2y$12$xmADQ.IexbGJlvZ9f9w62u0Ke1z0W4aZvwLkNj5/xqefZtmi83RaO', NULL, '2026-08-19 14:22:09', '2026-08-20 02:37:08', NULL, 'bp'),
(1190, 'SA BEKASI', 'dcabkssasc1', 'ciawi', 0, 0, NULL, '$2y$12$yi95E5UW0JWzah3TM85caOmenAKZOOF/TZbwAOnFQi0fcOL0SrGxK', NULL, '2026-08-19 14:22:10', '2026-08-20 02:37:08', NULL, 'ciawi'),
(1191, 'ARIA BHARATA, S.E X', 'dcabksshbm', 'cipanas', 0, 0, NULL, '$2y$12$JtfdptJSkX15DRnjgaoeouXFtkfkzIYLTcE04AHnr7sac62JSIX.G', NULL, '2026-08-19 14:22:10', '2026-08-20 02:37:09', 'bm_sh', 'cipanas'),
(1192, 'HERI SETIAWAN', 'dcabkssm', 'jatiasih', 0, 0, NULL, '$2y$12$Re4TAw7hfXhzXGY/fgHCkORtA1yrIyb59UDwjMwsaWrywDGGe6f6K', NULL, '2026-08-19 14:22:10', '2026-08-20 02:37:09', NULL, 'jatiasih'),
(1193, 'SUBHAN', 'dcabkssmbp', 'bp', 0, 0, NULL, '$2y$12$nl2FEh3XZRXCzBZNrVGA1Oo6XZn1/.pGIUYkaDR9orMBchAkcFMcC', NULL, '2026-08-19 14:22:10', '2026-08-20 02:37:10', NULL, 'bp'),
(1194, 'HARDI SUCIPTO', 'dcabksspart1', 'jatiasih', 0, 0, NULL, '$2y$12$RyzTITbAAzf/jDgPjB8jz.pS/IV3TMKMmROlpihKVeFK9n9ICYHge', NULL, '2026-08-19 14:22:11', '2026-08-20 02:37:10', NULL, 'jatiasih'),
(1195, 'DCABKSSPART2', 'dcabksspart2', 'jatiasih', 0, 0, NULL, '$2y$12$KcbNs4gQKERxACoGfYctK.G0Urz6cKpMKIM0fXd1lyCGWTSqxSLwS', NULL, '2026-08-19 14:22:11', '2026-08-20 02:37:10', NULL, 'jatiasih'),
(1196, 'SUWARDI JANDELA', 'dcabkssprtbp', 'bp', 0, 0, NULL, '$2y$12$yPKC0iZuNGUfsn/yXygFf.Hv1lM3VCkG6QJZtb1i52anudO4zt7L.', NULL, '2026-08-19 14:22:12', '2026-08-20 02:37:11', NULL, 'bp'),
(1197, 'IVA AMANDA SARASWATI', 'dcabkssro2', 'jatiasih', 0, 0, NULL, '$2y$12$ik/uNDJVuBHu.fX98v1.CuonPLiwFZKMe/okeKPhKNGaYdqnFnv5m', NULL, '2026-08-19 14:22:12', '2026-08-20 02:37:12', NULL, 'jatiasih'),
(1198, 'RONALD NOVEMBRI W', 'dcabmrnw', 'ciawi', 0, 0, NULL, '$2y$12$Uu24iP2NrpiL7hYB8ZFiPuHjbe5CPNR/D/HruKEfonbnOky8m6OcW', NULL, '2026-08-19 14:22:12', '2026-08-20 02:37:12', NULL, 'ciawi'),
(1199, 'RUBBY SAPUTRA', 'dcabmrs', 'cianjur', 0, 0, NULL, '$2y$12$eKw6btVozuXbaIIaqV1ZWuua6i7AK0tz0wrA5vlfn68k0OzIewweC', NULL, '2026-08-19 14:22:13', '2026-08-20 02:37:13', NULL, 'cianjur'),
(1200, 'SITI AISYAH (ICHA)', 'dcabmsa', 'jatiasih', 0, 0, NULL, '$2y$12$8HkhcRoiNYKsoju3UsFI1eL6S4vxUswGKN25O9KZ7ykWDpp9NWrj.', NULL, '2026-08-19 14:22:13', '2026-08-20 02:37:13', 'bm_sh', 'jatiasih'),
(1201, 'SERVIS PROGRESS BP', 'dcabpps', 'bp', 0, 0, NULL, '$2y$12$WrlZUdqEOUZ5dwJ6V3j5g.XKu8hejisZ6fO7BBs2GWueuXJbF.cDe', NULL, '2026-08-19 14:22:13', '2026-08-20 02:37:13', NULL, 'bp'),
(1202, 'BUDI TANUJAYA', 'dcacjradh', 'cianjur', 0, 0, NULL, '$2y$12$EIqGfpxuiMH9UBbZJYfNeO04zneGkSKhlQ475rPJP8OWxXsRSweRu', NULL, '2026-08-19 14:22:14', '2026-08-20 02:37:14', NULL, 'cianjur'),
(1203, 'DCACJRFAKTUR', 'dcacjrfaktur', NULL, 0, 0, NULL, '$2y$12$u9B1JS8w03TyHatkkdUeEOnEwYSV1tfZ2i.3TCsc.8dK7CMfFoobi', NULL, '2026-08-19 14:22:14', '2026-08-20 02:37:15', NULL, NULL),
(1204, 'FOREMAN', 'dcacjrfm', 'cianjur', 0, 0, NULL, '$2y$12$fSgrx5/QdB74TvwzYviJ8OYgxVCs8eglVleSdVPal3u3B1Q5fjAJW', NULL, '2026-08-19 14:22:15', '2026-08-20 02:37:15', NULL, 'cianjur'),
(1205, 'KASIR', 'dcacjrkasir', 'cianjur', 0, 0, NULL, '$2y$12$BU32O0y41oAMKszfQ5virOcZzB/7o5eqklQUjM7jlwa3bG7Oo1xo.', NULL, '2026-08-19 14:22:15', '2026-08-20 02:37:16', NULL, 'cianjur'),
(1206, 'DCACJRSA1', 'dcacjrsa1', 'cianjur', 0, 0, NULL, '$2y$12$VadjtjEdpRxUx5f1b/Zvy.O9b419pqxxqTdpQ0EwcDEvEgVBk8U/O', NULL, '2026-08-19 14:22:15', '2026-08-20 02:37:16', NULL, 'cianjur'),
(1207, 'DCACJRSA2', 'dcacjrsa2', 'cianjur', 0, 0, NULL, '$2y$12$Ce7FoKwyZFBg69aU/Vgpp.TEfN9kLuytTdpYFi/qG0IVTkNhUbBw2', NULL, '2026-08-19 14:22:15', '2026-08-20 02:37:16', NULL, 'cianjur'),
(1208, 'DCACJRSA3', 'dcacjrsa3', 'cianjur', 0, 0, NULL, '$2y$12$KVgj7hiGzUhnriKdTLYbB.lpndEjWqIEchPkYbJ5ZFuMLEwjmf6A2', NULL, '2026-08-19 14:22:16', '2026-08-20 02:37:17', NULL, 'cianjur'),
(1209, 'DCACJRSPART1', 'dcacjrspart1', 'cianjur', 0, 0, NULL, '$2y$12$yZOnPd47UtC0MAPNSpcgO.mnqZ7umSTXExOrFW8oHbJL.MQFQkUay', NULL, '2026-08-19 14:22:17', '2026-08-20 02:37:18', NULL, 'cianjur'),
(1210, 'DCACJRSPART2', 'dcacjrspart2', 'cianjur', 0, 0, NULL, '$2y$12$hsHv6ju/mEJkn4fiY57Xt.BjJcpKclHU5QEmuYM/T551ZXME./4bO', NULL, '2026-08-19 14:22:17', '2026-08-20 02:37:18', NULL, 'cianjur'),
(1211, 'SERVICE PROGRESS', 'dcacjrsrvprg', 'cianjur', 0, 0, NULL, '$2y$12$76PKj3e4PG2mzXEiEnC4VeUm0fXzH9lAEsktE5MwMtaVvoRgh40YW', NULL, '2026-08-19 14:22:18', '2026-08-20 02:37:19', NULL, 'cianjur'),
(1212, 'SARI UNTUK CABANG CIANJUR', 'dcacjrtax', 'cianjur', 0, 0, NULL, '$2y$12$vDWayq82zhp/wbF8QQv5.Ofrve5hM4bHOXdZp11983VUEFLCNGQ7C', NULL, '2026-08-19 14:22:18', '2026-08-20 02:37:20', NULL, 'cianjur'),
(1213, 'OGGY SUPPORT FOR CINERE', 'dcacnradm2', 'cinere', 0, 0, NULL, '$2y$12$7nYNHKWIYWHGTALR/9FFlOwsvH0DTF7d474GJoZ89D3thdoWigFJS', NULL, '2026-08-19 14:22:19', '2026-08-20 02:37:21', NULL, 'cinere'),
(1214, 'DCACNRADMUNIT', 'dcacnradmunit', 'cinere', 0, 0, NULL, '$2y$12$JfxKosopif051Q/HjDJYletz4Tkxiq94s.Gc9yZ1cnK9lh7nFAnOm', NULL, '2026-08-19 14:22:19', '2026-08-20 02:37:21', NULL, 'cinere'),
(1215, 'RAMLI', 'dcacnrbm', 'cinere', 0, 0, NULL, '$2y$12$df9QAk8/RaN8.TNqCMfuJODvf11Nu1XCW2c9RMgg7pI4LS6QiMFl6', NULL, '2026-08-19 14:22:19', '2026-08-20 02:37:21', 'bm_sh', 'cinere'),
(1216, 'ADINDA', 'dcacnrcro', 'cinere', 0, 0, NULL, '$2y$12$OZxNnrbIuPWA2qYvmc9EveeY2G1F4tJEbRV0bUSRQoMbVQ.Y7mxTu', NULL, '2026-08-19 14:22:19', '2026-08-20 02:37:22', NULL, 'cinere'),
(1217, 'REINHA', 'dcacnrfaktur', NULL, 0, 0, NULL, '$2y$12$Jam.ZqLLFMYHHL8JpeBc7ehOuN2XxtARMG/hNuG.CuSysOgi2sCCm', NULL, '2026-08-19 14:22:20', '2026-08-20 02:37:22', NULL, NULL),
(1218, 'Vicky', 'dcacnrfm', 'cinere', 0, 0, NULL, '$2y$12$rOBKve7agRYPxOw702xJO.967YQHSW7u9fnEEkZynl/OAAstZaDrC', NULL, '2026-08-19 14:22:20', '2026-08-20 02:37:22', NULL, 'cinere'),
(1219, 'DCACNRKASIR', 'dcacnrkasir', 'cinere', 0, 0, NULL, '$2y$12$LQ/qJ1Oe85G1LLdGZe.gQOOzWVOkbGDEpYK5xpPqQe33XogaQS4my', NULL, '2026-08-19 14:22:20', '2026-08-20 02:37:23', NULL, 'cinere'),
(1220, 'Servise Progress DCA Cinere', 'dcacnrps', 'cinere', 0, 0, NULL, '$2y$12$eekEHAx7llc59aSx.JObreGPxJGDBzjTFm4g1lYN2kVgoiyzR1kbW', NULL, '2026-08-19 14:22:21', '2026-08-20 02:37:23', NULL, 'cinere'),
(1221, 'ENDANG', 'dcacnrsa1', 'cinere', 0, 0, NULL, '$2y$12$U0RUSnOGRQPtKH0EKDzEt.OqXSlnZqG/yZdQx6A4.sXx9HXCgO9bC', NULL, '2026-08-19 14:22:21', '2026-08-20 02:37:23', NULL, 'cinere'),
(1222, 'KHAIRUL', 'dcacnrsa2', 'cinere', 0, 0, NULL, '$2y$12$vHe.gv1mXeWu7u1owwO.8uaDWOJTPdC0Awrp5aKT38hDufoCqvA6C', NULL, '2026-08-19 14:22:21', '2026-08-20 02:37:24', NULL, 'cinere'),
(1223, 'ALIMAN HAKIM', 'dcacnrsa3', 'cinere', 0, 0, NULL, '$2y$12$mIFd9eoSVLrF/lfvHGZ/le6ldvdKLLqZGhlGJJwTHwRgd6dvkyO7K', NULL, '2026-08-19 14:22:21', '2026-08-20 02:37:24', NULL, 'cinere'),
(1224, 'ALIMAN HAKIM', 'dcacnrsa4', 'cinere', 0, 0, NULL, '$2y$12$kFtIEQPCgI9puAnAt5yziO8cTQIbG0Dj1HiOvUmE80lqGzF.ushKK', NULL, '2026-08-19 14:22:22', '2026-08-20 02:37:25', NULL, 'cinere'),
(1225, 'ELISON', 'dcacnrsh1', 'cinere', 0, 0, NULL, '$2y$12$XDz1QwsT7S3DdOVD7varTO22ZGNlVjtmL76bD9U1Mg1dpJwZP46fy', NULL, '2026-08-19 14:22:22', '2026-08-20 02:37:25', 'bm_sh', 'cinere'),
(1226, 'IVA AMANDA SARASWATI', 'dcacnrso2', 'cinere', 0, 0, NULL, '$2y$12$weuIqQjKkYys0Vez/JtUlOtYVjKfJ3KPSviZAOGMBv0QBL/u2jHAC', NULL, '2026-08-19 14:22:23', '2026-08-19 14:22:23', NULL, 'cinere'),
(1227, 'DCACNRSPART1', 'dcacnrspart1', 'cinere', 0, 0, NULL, '$2y$12$Dc0ahOW75bXeSqacAtRhLeLedAesttSGGNA/hEzxYUHJTNdjTp8Hy', NULL, '2026-08-19 14:22:23', '2026-08-19 14:22:23', NULL, 'cinere'),
(1228, 'DCACNRSPART2', 'dcacnrspart2', 'cinere', 0, 0, NULL, '$2y$12$MKDwsSLWJ87WPb1tLcdlSO3Of8t1nzOYMc8XfsXD6LLLAncj98miC', NULL, '2026-08-19 14:22:23', '2026-08-19 14:22:23', NULL, 'cinere'),
(1229, 'IVA AMANDA SARASWATI', 'dcacnrsro2', 'cinere', 0, 0, NULL, '$2y$12$MFsUlQ0g4skLeM2oZExcFu6fJf9S9/I126riErPnMSvSiS9oItoNq', NULL, '2026-08-19 14:22:24', '2026-08-19 14:22:24', NULL, 'cinere'),
(1230, 'SARI UNTUK CABANG CINERE', 'dcacnrtax', 'jatiasih', 0, 0, NULL, '$2y$12$VTQJSMZeBUsQKZppfFTnzOtFqtttTCuPOUN.RPPGwpy/liwu1smcC', NULL, '2026-08-19 14:22:24', '2026-08-19 14:22:24', NULL, 'jatiasih'),
(1231, 'BUDI TANUJAYA', 'dcacpsadh', 'cipanas', 0, 0, NULL, '$2y$12$jvJBEgRdfLjQNbUK0/aUgeeu8oUukv9xGWDv0gmiJu1m3cS77PWkK', NULL, '2026-08-19 14:22:25', '2026-08-19 14:22:25', NULL, 'cipanas'),
(1232, 'HENDRIX X', 'dcacpsbm', 'cipanas', 0, 0, NULL, '$2y$12$yWvSDejQ36.UR53bbR5DweKohRWiCUWZRLRu/sQiXqN4yLkIBn.3K', NULL, '2026-08-19 14:22:25', '2026-08-19 14:22:25', 'bm_sh', 'cipanas'),
(1233, 'EDDY', 'dcacwiadh', 'ciawi', 0, 0, NULL, '$2y$12$mh3mC6fW6NJ5NeMT.yNUt.2ZNNbxSLBnA41bYM1/feSIyCHJUk8ui', NULL, '2026-08-19 14:22:25', '2026-08-19 14:22:25', 'adh', 'ciawi'),
(1234, 'Oggy', 'dcacwifaktur', NULL, 0, 0, NULL, '$2y$12$pIKpYC/rsS6qEGvJP2cJB.awmjweG3IQIxMBEE7DGKtGtC0B/L.kC', NULL, '2026-08-19 14:22:26', '2026-08-19 14:22:26', NULL, NULL),
(1235, 'ERICK', 'dcacwikasir', 'ciawi', 0, 0, NULL, '$2y$12$AVmhJ7ZBOV/LrITYN9UNiuMq95.M1nszU/t2VCGOA97xCKjUfPbVK', NULL, '2026-08-19 14:22:27', '2026-08-19 14:22:27', NULL, 'ciawi'),
(1236, 'Progress service ciawi', 'dcacwips', 'ciawi', 0, 0, NULL, '$2y$12$RDJPzkPA.23S8QeMrUq4k.99il3a56YHPRhGUFjF/6A6SQm7wVzhi', NULL, '2026-08-19 14:22:27', '2026-08-19 14:22:27', NULL, 'ciawi'),
(1237, 'RAHMAT', 'dcacwisa1', 'ciawi', 0, 0, NULL, '$2y$12$gzRQAHnf93CLZhTqmBaxT.CSsMpCow79M3SPT.H8jMvIhwSpJyv4K', NULL, '2026-08-19 14:22:27', '2026-08-19 14:22:27', NULL, 'ciawi'),
(1238, 'ASEP', 'dcacwisa2', 'ciawi', 0, 0, NULL, '$2y$12$0pagJmBYw/nPWNwmZJ2glOZ7YZzkcPtB70WqAxLuYl6.F.HlpHmHG', NULL, '2026-08-19 14:22:27', '2026-08-19 14:22:27', NULL, 'ciawi'),
(1239, 'RAHMAT', 'dcacwisa3', 'ciawi', 0, 0, NULL, '$2y$12$llUaDsNulgCHYXb5hfIdF.xapvpJqoqrNyIGURLib2QSijCWOt9xG', NULL, '2026-08-19 14:22:28', '2026-08-19 14:22:28', NULL, 'ciawi'),
(1240, 'SHANDY', 'dcacwisasc1', 'ciawi', 0, 0, NULL, '$2y$12$E3jOFokPRpAGokLG23cGue1oaamaJoPV1P0rltnicH7VDKEI2z4.G', NULL, '2026-08-19 14:22:29', '2026-08-19 14:22:29', NULL, 'ciawi'),
(1241, 'SERVICE POINT PUNCAK', 'dcacwiservicepoint', 'ciawi', 0, 0, NULL, '$2y$12$ue1eB7kJ9XwnT57xkLceUeV4DTCQRUn1y/PvLme0izRoeCQN3cszm', NULL, '2026-08-19 14:22:29', '2026-08-19 14:22:29', NULL, 'ciawi'),
(1242, 'Sriyanto', 'dcacwismits', 'ciawi', 0, 0, NULL, '$2y$12$PzvhU9I.hBHdkR5u2NSgfeLeu2bNv6SeBwO4x5De7Ut2YnzzVkX9e', NULL, '2026-08-19 14:22:30', '2026-08-19 14:22:30', NULL, 'ciawi'),
(1243, 'SERVICE POINT 1', 'dcacwisp1', 'ciawi', 0, 0, NULL, '$2y$12$hojaUkiEjOLoQs2.Vfw9T.461Y7EghFf5.0awpcGbwc0uOxcBvbpq', NULL, '2026-08-19 14:22:30', '2026-08-19 14:22:30', NULL, 'ciawi'),
(1244, 'DCACWISPART1', 'dcacwispart1', 'ciawi', 0, 0, NULL, '$2y$12$XfDxplQKBuuVPsP.EAhKZOjRjYZmRZS5CNblfPfY6BvPnRF.mCTw2', NULL, '2026-08-19 14:22:30', '2026-08-19 14:22:30', NULL, 'ciawi'),
(1245, 'DCACWISPART2', 'dcacwispart2', 'ciawi', 0, 0, NULL, '$2y$12$YJ3PCfc5bMJMf1WkbCLXyeBF7TJUK47y9Xj5d1daBxdBwwrmuSO3q', NULL, '2026-08-19 14:22:31', '2026-08-19 14:22:31', NULL, 'ciawi'),
(1246, 'SARI UNTUK CABANG CIAWI', 'dcacwitax', 'ciawi', 0, 0, NULL, '$2y$12$v0U6rDbP.K/iQNsd99824.lcZ9K6HQ9vm.7/XmSgRSdQrtvUoX/62', NULL, '2026-08-19 14:22:31', '2026-08-19 14:22:31', NULL, 'ciawi'),
(1247, 'DIREKSI', 'dcadireksi', NULL, 0, 0, NULL, '$2y$12$wP093Sm8g/0C25/olT1eWelOEX7q6PMwss1UAFi778A6NrpCHZG7G', NULL, '2026-08-19 14:22:32', '2026-08-19 14:22:32', NULL, NULL),
(1248, 'OPAY HADI PRAYITNO', 'dcafmbp', 'bp', 0, 0, NULL, '$2y$12$clAJ4a29x5kfLZBKZOZ/Se6y.tT/8xHmbQ4zEiCzIKGUxcDpKKlTa', NULL, '2026-08-19 14:22:32', '2026-08-19 14:22:32', NULL, 'bp'),
(1249, 'DEA NUR FITRIANI', 'dcahoacct1', 'cinere', 0, 0, NULL, '$2y$12$AAoxKBfKN.x1WJrKDu3wcufEjr8K3oLzm.Lhzv2jBO3lwXPaGvcl.', NULL, '2026-08-19 14:22:33', '2026-08-19 14:22:33', NULL, 'cinere'),
(1250, 'METHI', 'dcahoacct2', 'ciawi', 0, 0, NULL, '$2y$12$SvU01pkHQ6aLLyNEL3IVEei7LJhSHjfOHpzRVLj829aglXP5vpwT6', NULL, '2026-08-19 14:22:33', '2026-08-19 14:22:33', NULL, 'ciawi'),
(1251, 'SRI MANI HANDAYANI', 'dcahoacct3', 'bp', 0, 0, NULL, '$2y$12$RzorDFyU6pKgCcZkpPHSquYRIItbYOFK9.cVnc1X7obiD7oQW8NtO', NULL, '2026-08-19 14:22:33', '2026-08-19 14:22:33', NULL, 'bp'),
(1252, 'ANDRI', 'dcahoadmunit', NULL, 0, 0, NULL, '$2y$12$.PAFioRVHMuQKcWz6dKLHupCqpFRRaSdQ3su6IJo8Vk9YKjArj0Xq', NULL, '2026-08-19 14:22:34', '2026-08-19 14:22:34', NULL, NULL),
(1253, 'TAX BP', 'dcahobptax', 'bp', 0, 0, NULL, '$2y$12$WB4Au/3Lz9HOp2D8iG9Ul.ftF9yc1xJl3ZzfU1Ee79qshy7XqDbqa', NULL, '2026-08-19 14:22:34', '2026-08-19 14:22:34', NULL, 'bp'),
(1254, 'ASTI - CUSTOMER CARE EKSEKUTIF', 'dcahocce', 'ciawi', 0, 0, NULL, '$2y$12$MwX6WqkaHN0eYQgy6J6P3.NR207oreUZkWHAp9JO4aJ5nKjVTl2te', NULL, '2026-08-19 14:22:34', '2026-08-19 14:22:34', NULL, 'ciawi'),
(1255, 'NOUVAL SOPI', 'dcahoccm', 'jatiasih', 0, 0, NULL, '$2y$12$tPTQ52Oh.REfyz5O5f9tN.D.M.QzGkwUgr/lpwfY0BEdmPTxAvezO', NULL, '2026-08-19 14:22:35', '2026-08-19 14:22:35', NULL, 'jatiasih'),
(1256, 'EVI', 'dcahocro', 'ciawi', 0, 0, NULL, '$2y$12$jqCMyYHPJGBKdKZHtyPfB.EIASdKPGjNT1EvWmAlWYpUbHlgzhE5.', NULL, '2026-08-19 14:22:35', '2026-08-19 14:22:35', NULL, 'ciawi'),
(1257, 'YETI ROSTIKA', 'dcahofaktur', 'jatiasih', 0, 0, NULL, '$2y$12$hAMC2QCDWsXVAE81O8RNTuXAt/ZPNmqV7AwCPoe4m9F8osXnrh2qa', NULL, '2026-08-19 14:22:35', '2026-08-19 14:22:35', NULL, 'jatiasih'),
(1258, 'Siti Noer Shafira Salsabila', 'dcahofinadm', NULL, 0, 0, NULL, '$2y$12$BnxOycZ50zWsagdzcOKwnu9DGqhWMBbD69I6yE7uCbGT9L7XfPNmO', NULL, '2026-08-19 14:22:35', '2026-08-19 14:22:35', NULL, NULL),
(1259, 'Mariana', 'dcahofinspv', 'jatiasih', 0, 0, NULL, '$2y$12$WRr5vNFRgC.i93Vr3T8zGe28bOlvYqHAFpMropBdg.STf8OquX89i', NULL, '2026-08-19 14:22:36', '2026-08-19 14:22:36', NULL, 'jatiasih'),
(1260, 'SUTINI ATMAJA', 'dcahoinsurance', NULL, 0, 0, NULL, '$2y$12$n8B3u3m.s0sD9bUiFvoWOeatRX6Tnf2y6.5Udiq7009vRdDwtAF/m', NULL, '2026-08-19 14:22:36', '2026-08-19 14:22:36', NULL, NULL),
(1261, 'NOUVAL', 'dcahomsspv', 'ciawi', 0, 0, NULL, '$2y$12$WAjmQQgC.UTiSPIfdj4Ud.ulGWHoYmyU48OryzS2KNslTlXnar.N2', NULL, '2026-08-19 14:22:36', '2026-08-19 14:22:36', NULL, 'ciawi'),
(1262, 'MUHAMMAD NOUFAL SHOFI', 'dcahosfm', 'ciawi', 0, 0, NULL, '$2y$12$CYvT4hCUjH3uDmbQLySHQex9Q/BMJwohmpkFwF3WlCwlPTNZ9vw3a', NULL, '2026-08-19 14:22:37', '2026-08-19 14:22:37', NULL, 'ciawi'),
(1263, 'ASTI', 'dcahosro', 'cianjur', 0, 0, NULL, '$2y$12$YeORD00VQbld47fJTve3lueBXsTvdhIF3KAyN1ExtJOKtCu299geS', NULL, '2026-08-19 14:22:37', '2026-08-19 14:22:37', NULL, 'cianjur'),
(1264, 'SARI WULAN', 'dcahotax', NULL, 0, 0, NULL, '$2y$12$qK3kOrF7PtZ/C.SPbF7Nsu4wB/F1lvNJ/t8AD5xv79tOJ8RCjgthq', NULL, '2026-08-19 14:22:37', '2026-08-19 14:22:37', NULL, NULL),
(1265, 'TEGUH PRIHATMAN', 'dcahotaxspv', 'cipanas', 0, 0, NULL, '$2y$12$PdKhXM6ELntQc0RGm9UPiOcp9liQbg2O4iAcSmVFsNk8gkOk1cSTy', NULL, '2026-08-19 14:22:37', '2026-08-19 14:22:37', NULL, 'cipanas'),
(1266, 'tes', 'dcahotes', 'jatiasih', 0, 0, NULL, '$2y$12$7Mexnm0tnqGe6.6fqN8QSehTumor/xcZb20YUbTr5mKtnPoM9FtUu', NULL, '2026-08-19 14:22:38', '2026-08-19 14:22:38', NULL, 'jatiasih'),
(1267, 'NOUVAL', 'dcahotft', NULL, 0, 0, NULL, '$2y$12$aPABnynDYSv04LrcyrHEdu/CXiUUPV19Ij0jzgqP6D9nkzM6jFWF.', NULL, '2026-08-19 14:22:38', '2026-08-19 14:22:38', NULL, NULL),
(1268, 'LIKA NURHAYATI', 'dcahounit', NULL, 0, 0, NULL, '$2y$12$dgvxg2ju37FRlRnf/H4kQu35PGk.n83SAk3gFhuPY/NXRW9QfGBdm', NULL, '2026-08-19 14:22:38', '2026-08-19 14:22:38', 'ho_unit', NULL),
(1269, 'ADE', 'dcajtsbm', 'jatiasih', 0, 0, NULL, '$2y$12$FMTyNhBUK3iLUIzXOpclxe3W7O1F08N7WkZjdPky9DGrLNLAqIMKi', NULL, '2026-08-19 14:22:39', '2026-08-19 14:22:39', NULL, 'jatiasih'),
(1270, 'SERVICE PROGRESS JATIASIH', 'dcajtsps', 'jatiasih', 0, 0, NULL, '$2y$12$jFHz7uTg.7CldW.CBu.u5.bepGpP/mXDZR.L9hgZ8mbTSHB72OmNi', NULL, '2026-08-19 14:22:39', '2026-08-19 14:22:39', NULL, 'jatiasih'),
(1271, 'services progress', 'dcajtspsbp', 'bp', 0, 0, NULL, '$2y$12$6oxqNnrbyVVuRMZ.L9.n/.6VMFBtq4wwx.P7sxQVIS4XzZpVlSoXe', NULL, '2026-08-19 14:22:39', '2026-08-19 14:22:39', NULL, 'bp'),
(1272, 'WINALISTIO', 'dcajtssm', 'jatiasih', 0, 0, NULL, '$2y$12$mb/Zl1T3e8He8iTmNvdM1O0LrlLUpnKky1pILHyVd1s/9HiAZVP2a', NULL, '2026-08-19 14:22:39', '2026-08-19 14:22:39', NULL, 'jatiasih'),
(1273, 'SERVIS PROGRESS BP', 'dcapsbp', 'bp', 0, 0, NULL, '$2y$12$b6XshOFsAb.5AzskxMiLDeV83/83m3JMIw4PYzVSNuEO2RCeU4LsW', NULL, '2026-08-19 14:22:40', '2026-08-19 14:22:40', NULL, 'bp'),
(1274, 'Ramlie Budiman', 'dcashcnr01', 'cinere', 0, 0, NULL, '$2y$12$uI4K3Vjhk.oh99CpgusQ..BN/x2DSigS4YcOnVIqQ5s2YLHvX2.aK', NULL, '2026-08-19 14:22:40', '2026-08-19 14:22:40', 'bm_sh', 'cinere'),
(1275, 'Heri Setiawan', 'dcasr', 'cinere', 0, 0, NULL, '$2y$12$H0gh6pyvhCdhskQUch7juugRKNQSUdxePY7L/qPjFaBYkxoVDKgwK', NULL, '2026-08-19 14:22:40', '2026-08-19 14:22:40', NULL, 'cinere'),
(1276, 'Enatasha', 'enatasha', NULL, 0, 0, NULL, '$2y$12$z1/SfaUVEhCSPoAPNrWISONbiaLsgluziMc/xG5Vhr7f9ASGW2oTC', NULL, '2026-08-19 14:22:41', '2026-08-19 14:22:41', NULL, NULL),
(1277, 'FAD', 'fad', NULL, 0, 0, NULL, '$2y$12$MQ9pNR/X/djywBwh/STjLey1SwYQMHqdCm28dAAXDLFLcW6mVKiYy', NULL, '2026-08-19 14:22:41', '2026-08-19 14:22:41', NULL, NULL),
(1278, 'FINEKE', 'fineke', 'cinere', 0, 0, NULL, '$2y$12$sWBlkUhA5D5hqEyXf2qyTOvWDGMGhGN.k9RofMs.IGKQFGVcJedTC', NULL, '2026-08-19 14:22:41', '2026-08-19 14:22:41', NULL, 'cinere'),
(1279, 'Dont Delete', 'ga', NULL, 0, 0, NULL, '$2y$12$NCNLH5hBDdXMv24QvKTyEuqVb12f4y0Yk5NxIMR4a98pbik.rGq9C', NULL, '2026-08-19 14:22:42', '2026-08-19 14:22:42', NULL, NULL),
(1280, 'Heru Wijaya', 'heru', NULL, 0, 0, NULL, '$2y$12$J.3.iE2XzZNIV1FewjviN.SFCubMFF1Bk6o3cYsYkgicuFI2vdiRq', NULL, '2026-08-19 14:22:42', '2026-08-19 14:22:42', NULL, NULL),
(1281, 'Heru Wijaya', 'heruit', 'jatiasih', 1, 1, NULL, '$2y$12$8G/S9sDTpgZ63sqR926A7uMRcA28PpF5PHwxzMgVIMojorLNhinWm', NULL, '2026-08-19 14:22:42', '2026-08-20 03:45:02', 'om', 'jatiasih'),
(1282, 'HRD', 'hrd', 'jatiasih', 0, 0, NULL, '$2y$12$ZQpNgchN.XaCldON0CrYcuGqm4aWDOZ5fBp00XoK3wIplBJMeB1LC', NULL, '2026-08-19 14:22:42', '2026-08-19 14:22:42', NULL, 'jatiasih'),
(1283, 'IRFAN RIFAI', 'hrga', NULL, 0, 0, NULL, '$2y$12$C3X1nv5JUCAnc0sPJm4SaeAMWg4RFOaEcqu0uIKYPoh3Pyigmetpy', NULL, '2026-08-19 14:22:43', '2026-08-19 14:22:43', NULL, NULL),
(1284, 'HENDRA', 'it', 'ciawi', 0, 0, NULL, '$2y$12$rS2tbAGKo5.cpitIE1VXzOoPpwkiPjHAHM6vpZMOUivs.kH8KO17W', NULL, '2026-08-19 14:22:43', '2026-08-19 14:22:43', NULL, 'ciawi'),
(1285, 'T. Hendra', 'it2', 'cianjur', 0, 0, NULL, '$2y$12$.Vuy/WLQC1uTI1fIoDsEe.THiJqGAPcJLv3jTnjUVYKrfaz2oLxbe', NULL, '2026-08-19 14:22:43', '2026-08-19 14:22:43', NULL, 'cianjur'),
(1286, 'it', 'itits', NULL, 0, 0, NULL, '$2y$12$cqiCqueizdqOP7sx6dCu2O4LdfE7WDsHXxa75XU2.KrPeuliLavCy', NULL, '2026-08-19 14:22:44', '2026-08-19 14:22:44', NULL, NULL),
(1287, 'Mumtaz', 'mumtazit', 'jatiasih', 1, 1, NULL, '$2y$12$4wRsq8rLs7Q4HIyETpEUaOV4lkT5eV32Miwzo.Cmmp2AB18k1dzAO', NULL, '2026-08-19 14:22:44', '2026-08-20 03:45:02', 'om', 'jatiasih'),
(1288, 'YUDI IT SUZUKI', 'ndil', 'ciawi', 0, 0, NULL, '$2y$12$EZiRqvZkJSrYHurD25ZUQuWIqYkhZUI3S5/NIthIR0b5b77gstbzS', NULL, '2026-08-19 14:22:44', '2026-08-19 14:22:44', NULL, 'ciawi'),
(1289, 'Service Progress Jatiasih', 'qwerty', 'jatiasih', 0, 0, NULL, '$2y$12$BEqulJsVQNJAUVPVfaIgrumdnXUsd0ifuu5Z8ZCwSPU7KKnZDfGku', NULL, '2026-08-19 14:22:45', '2026-08-19 14:22:45', NULL, 'jatiasih'),
(1290, 'Rizky', 'rizkyit', 'ciawi', 1, 1, NULL, '$2y$12$GfpnsTk18Hzt3HsuWI4jhO6../.8Zi8IPqiQpg77McBvzAFVimMS2', NULL, '2026-08-19 14:22:45', '2026-08-20 03:45:02', 'om', 'ciawi'),
(1291, 'ROMMY RALVIANSYAH', 'romy', NULL, 0, 0, NULL, '$2y$12$13hut3S/1O9Cmim0MxhPKe6Fe3Ick.V08OfPr3veg/zzogN4sCEyO', NULL, '2026-08-19 14:22:45', '2026-08-19 14:22:45', NULL, NULL),
(1292, 'sa', 'sa', 'cianjur', 0, 0, NULL, '$2y$12$M918NIeNVDpCwcVUn6JM/.xL1b9fA4B3gaYUzz6DvNcAUX/XAsrf6', NULL, '2026-08-19 14:22:46', '2026-08-19 14:22:46', NULL, 'cianjur'),
(1293, 'RAHMAT HIDAYAT', 'saa00671', 'ciawi', 0, 0, NULL, '$2y$12$UqU9Kw.HHML6Ft5HSYAAs.GSIA3VTB8f01XVQAlSJbpfRCIO.g8HC', NULL, '2026-08-19 14:22:46', '2026-08-19 14:22:46', NULL, 'ciawi'),
(1294, 'Sri Hartatik', 'srihartatik', NULL, 0, 0, NULL, '$2y$12$e13Ex4PEZYNdYqD06rCbhu3ILOvuYIjqBpTx1MoxpGQ44VGhq/SlO', NULL, '2026-08-19 14:22:46', '2026-08-19 14:22:46', NULL, NULL),
(1295, 'IT Suzuki', 'szk-devi', 'cianjur', 0, 0, NULL, '$2y$12$TqMPhARXiL1kV.7q63DEqut96UkpJ5iW.XQ2Fw4q5No3KFJDdiomK', NULL, '2026-08-19 14:22:46', '2026-08-19 14:22:46', NULL, 'cianjur'),
(1296, 'IT Suzuki', 'szk-osen', NULL, 0, 0, NULL, '$2y$12$un2WAd0K1E7qGKaaaLkFcOouZG6/jfHrBOsYedJ7DUku3vYc9416W', NULL, '2026-08-19 14:22:47', '2026-08-19 14:22:47', NULL, NULL),
(1297, 'IT Suzuki', 'szk-yohana', 'bp', 0, 0, NULL, '$2y$12$lwq9b7iudw5hjw2Md057Z.1aQVk48IeyVitBuzgGVF2BpioJTOY6.', NULL, '2026-08-19 14:22:47', '2026-08-19 14:22:47', NULL, 'bp'),
(1298, 'IT Suzuki', 'szk-yudi', 'jatiasih', 0, 0, NULL, '$2y$12$vnOAA3CqXy1a6oM464slMO11o2MWVg2oWwheXI8GKdS7tleBHjKEa', NULL, '2026-08-19 14:22:47', '2026-08-19 14:22:47', NULL, 'jatiasih'),
(1299, 'TEGUH ARIEP NUGRAHA', 'teguhho', 'bp', 0, 0, NULL, '$2y$12$YH/Umxi1WesIg2K3Ej1dJOJ49BK61hFnC46eLKrxQPt.rSMeHEGf2', NULL, '2026-08-19 14:22:47', '2026-08-19 14:22:47', NULL, 'bp'),
(1300, 'TEST', 'test', NULL, 0, 0, NULL, '$2y$12$6w7sslUDzdkVVS8WPpj5u.bxtHi2T9aznoiYnjhGsY.zLZswaMIiu', NULL, '2026-08-19 14:22:48', '2026-08-19 14:22:48', NULL, NULL),
(1301, 'tq', 'tq', NULL, 0, 0, NULL, '$2y$12$BgMLqfYrBnVui3qsQQkuheIE.KM2wO2wceImDi.u5gL1cITrE4c1a', NULL, '2026-08-19 14:22:48', '2026-08-19 14:22:48', NULL, NULL),
(1302, 'Wahyu Aribowo', 'wahyuari', NULL, 0, 0, NULL, '$2y$12$1oyYOalOeyKfmyiK9aYLh.JBpoVvQQ9w.y/VmBpom9i791zu98gkS', NULL, '2026-08-19 14:22:49', '2026-08-19 14:22:49', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `varians`
--

CREATE TABLE `varians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `varians`
--

INSERT INTO `varians` (`id`, `nama`, `deskripsi`, `unit_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'E', NULL, NULL, '2026-06-29 10:44:12', '2026-06-29 11:00:45', '2026-06-29 11:00:45'),
(2, 'PU FD', NULL, 2, '2026-06-29 11:03:26', '2026-06-29 11:03:26', NULL),
(3, 'PU FD AC PS', NULL, 2, '2026-06-29 11:05:12', '2026-06-29 11:05:12', NULL),
(4, 'PU WD', NULL, 2, '2026-06-29 11:05:23', '2026-06-29 11:05:23', NULL),
(5, 'PU WD PS', NULL, 2, '2026-06-29 11:05:35', '2026-06-29 11:05:35', NULL),
(6, 'FE GL AB MT', NULL, 3, '2026-06-29 11:05:51', '2026-06-29 11:05:51', NULL),
(7, 'FE GE PS AB MT', NULL, 3, '2026-06-29 11:06:05', '2026-06-29 11:06:05', NULL),
(8, 'FE GX AB MT', NULL, 3, '2026-06-29 11:06:15', '2026-06-29 11:06:15', NULL),
(9, 'FE GE PS DEL.VAN MT (BLINDVAN)', NULL, 3, '2026-06-29 11:06:31', '2026-06-29 11:06:31', NULL),
(10, 'ZETA AT', NULL, 4, '2026-06-29 11:06:56', '2026-06-29 11:06:56', NULL),
(11, 'BETA AT', NULL, 4, '2026-06-29 11:07:26', '2026-06-29 11:07:26', NULL),
(12, 'ALPHA AT HYBRID 2TONE', NULL, 4, '2026-06-29 11:07:39', '2026-06-29 11:07:39', NULL),
(13, 'ALPHA AT HYBRID', NULL, 4, '2026-06-29 11:07:57', '2026-06-29 11:07:57', NULL),
(14, 'ALPHA MT HYBRID 2TONE', NULL, 4, '2026-06-29 11:08:10', '2026-06-29 11:08:10', NULL),
(15, 'ALPHA MT HYBRID', NULL, 4, '2026-06-29 11:08:22', '2026-06-29 11:08:22', NULL),
(16, 'KURO EDITION AT HYBRID', NULL, 4, '2026-06-29 11:08:34', '2026-06-29 11:08:34', NULL),
(17, 'SGX AT', NULL, 5, '2026-06-29 11:08:49', '2026-06-29 11:08:49', NULL),
(18, 'SGX AT 2TONE', NULL, 5, '2026-06-29 11:09:03', '2026-06-29 11:09:03', NULL),
(19, 'GL MT', NULL, 5, '2026-06-29 11:09:15', '2026-06-29 11:09:15', NULL),
(20, 'GL AT', NULL, 5, '2026-06-29 11:09:28', '2026-06-29 11:09:28', NULL),
(21, 'GX MT', NULL, 5, '2026-06-29 11:09:42', '2026-06-29 11:09:42', NULL),
(22, 'GX AT', NULL, 5, '2026-06-29 11:09:56', '2026-06-29 11:09:56', NULL),
(23, 'MC GX AT', NULL, 7, '2026-06-29 11:10:09', '2026-06-29 11:10:09', NULL),
(24, 'MC GX AT 2TONE', NULL, 7, '2026-06-29 11:10:29', '2026-06-29 11:10:29', NULL),
(25, 'AT', NULL, 8, '2026-06-29 11:10:46', '2026-06-29 11:10:46', NULL),
(26, 'MT', NULL, 8, '2026-06-29 11:10:59', '2026-06-29 11:10:59', NULL),
(27, '3D AT', NULL, 6, '2026-06-29 11:11:13', '2026-06-29 11:11:13', NULL),
(28, '3D AT 2TONE', NULL, 6, '2026-06-29 11:11:52', '2026-06-29 11:11:52', NULL),
(29, '5D AT', NULL, 6, '2026-06-29 11:12:08', '2026-06-29 11:12:08', NULL),
(30, '5D AT 2TONE', NULL, 6, '2026-06-29 11:12:21', '2026-06-29 11:12:21', NULL),
(31, '03 BETA MT HYBRID', NULL, 4, '2026-06-29 11:50:51', '2026-06-29 11:50:51', NULL),
(32, 'HYBRID SGX AT', NULL, 5, '2026-06-29 11:51:10', '2026-06-29 11:51:10', NULL),
(33, '03 ALPHA AT HYBRID 2TONE', NULL, 4, '2026-06-29 11:51:26', '2026-06-29 11:51:26', NULL),
(34, '02 AT', NULL, 8, '2026-06-29 11:51:40', '2026-06-29 11:51:40', NULL),
(35, 'HYBRID SGX AT', NULL, 5, '2026-06-29 11:51:59', '2026-06-29 11:51:59', NULL),
(36, '05-PU FD 2026', NULL, 2, '2026-06-29 11:52:21', '2026-06-29 11:52:21', NULL),
(37, 'MC GX AT 2025', NULL, 7, '2026-06-29 11:52:35', '2026-06-29 11:52:35', NULL),
(38, '03 ALPHA AT HYBRID 2TONE 2026', NULL, 4, '2026-06-29 11:53:00', '2026-06-29 11:53:00', NULL),
(39, '03 ALPHA MT HYBRID 2026', NULL, 4, '2026-06-29 11:53:15', '2026-06-29 11:53:15', NULL),
(40, 'HYBRID GX AT', NULL, 5, '2026-06-29 11:53:53', '2026-06-29 11:53:53', NULL),
(41, '03 BETA MT HYBRID', NULL, 4, '2026-06-29 12:05:55', '2026-06-29 12:05:55', NULL),
(42, '03 KURO EDITION AT HYBRID 2026', NULL, 4, '2026-06-29 15:26:15', '2026-06-29 15:26:15', NULL),
(43, '05-PU WD AC PS 2026', NULL, 2, '2026-06-29 15:33:40', '2026-06-29 15:33:40', NULL),
(44, '05-PU FD AC PS 2026', NULL, 2, '2026-06-29 15:37:09', '2026-06-29 15:37:09', NULL),
(45, '05-CH-PASSENGER 2026', NULL, 2, '2026-06-29 15:42:02', '2026-06-29 15:42:02', NULL),
(46, '05-CH AC PS-PASSENGER 2026', NULL, 2, '2026-06-29 15:42:19', '2026-06-29 15:42:19', NULL),
(47, 'GL AT 2026', NULL, 5, '2026-06-29 15:50:26', '2026-06-29 15:50:26', NULL),
(48, '03 KURO EDITION AT HYBRID 2TONE 2026', NULL, 4, '2026-06-30 09:46:54', '2026-06-30 09:46:54', NULL),
(49, '03 ALPHA MT HYBRID 2TONE 2026', NULL, 4, '2026-06-30 10:22:37', '2026-06-30 10:22:37', NULL),
(50, '03 BETA AT HYBRID 2026', NULL, 4, '2026-06-30 10:37:50', '2026-06-30 10:37:50', NULL),
(51, '05 GL AT', NULL, 9, '2026-06-30 14:51:30', '2026-06-30 14:51:30', NULL),
(52, '5 DOORS 2TONE AT 2025', NULL, 6, '2026-06-30 15:13:21', '2026-06-30 15:13:21', NULL),
(53, '03 ZETA AT 2026', NULL, 4, '2026-06-30 15:30:32', '2026-06-30 15:30:32', NULL),
(54, '03 ZETA AT 2026', NULL, 4, '2026-06-30 15:30:33', '2026-06-30 15:30:33', NULL),
(55, '5 DOORS AT 2025', NULL, 6, '2026-06-30 15:48:32', '2026-06-30 15:48:32', NULL),
(56, '03 ZETA MT 2026', NULL, 4, '2026-07-01 09:35:28', '2026-07-01 09:35:28', NULL),
(57, 'HYBRID SGX 2TONE AT 2025', NULL, 5, '2026-07-01 10:10:51', '2026-07-01 10:10:51', NULL),
(58, 'FE GE PS DEL.VAN MT 2026 (BLINDVAN)', NULL, 3, '2026-07-01 10:43:59', '2026-07-01 10:43:59', NULL),
(59, 'MC 2TONE GX AT 2025', NULL, 7, '2026-07-01 11:50:03', '2026-07-01 11:50:03', NULL),
(60, '02 AT-2026', NULL, 8, '2026-07-01 11:55:20', '2026-07-01 11:55:20', NULL),
(61, 'HYBRID GX MT 2026', NULL, 5, '2026-07-01 12:03:12', '2026-07-01 12:03:12', NULL),
(62, '05-PU WD 2026', NULL, 2, '2026-07-01 13:36:06', '2026-07-01 13:36:06', NULL),
(63, 'NEW ZETA AT MC 2026', NULL, 4, '2026-07-30 10:27:55', '2026-07-30 10:27:55', NULL),
(64, 'NEW ZETA MT MC 2026', NULL, 4, '2026-07-30 10:28:11', '2026-07-30 10:28:11', NULL),
(65, 'NEW BETA MT MC 2026', NULL, 4, '2026-07-30 10:28:25', '2026-07-30 10:28:25', NULL),
(66, 'NEW BETA AT MC 2026', NULL, 4, '2026-07-30 10:28:43', '2026-07-30 10:28:43', NULL),
(67, 'NEW ALPHA AT HYBIRD 2TONE  MC 2026', NULL, 4, '2026-07-31 10:04:11', '2026-07-31 10:05:03', NULL),
(68, 'NEW ALPHA AT HYBRID MC 2026', NULL, 4, '2026-08-08 09:03:59', '2026-08-08 09:03:59', NULL),
(69, 'HYBIRD SGX AT 2TONE 2026', NULL, 5, '2026-08-19 10:29:25', '2026-08-19 10:29:25', NULL),
(70, 'HYBIRD GX AT 2026', NULL, 5, '2026-08-22 10:26:08', '2026-08-22 10:26:08', NULL),
(71, 'HYBRID SGX AT KURO 2026', NULL, 5, '2026-08-22 10:34:24', '2026-08-22 10:34:24', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `warnas`
--

CREATE TABLE `warnas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `warnas`
--

INSERT INTO `warnas` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(2, 'WHITE', '2026-06-29 11:14:50', '2026-06-29 11:14:50'),
(3, 'REAL BLACK', '2026-06-29 11:15:04', '2026-06-29 11:15:04'),
(4, 'SILKY SILVER METALIC', '2026-06-29 11:15:15', '2026-06-29 11:15:15'),
(5, 'GRAPHITE GREY METALLIC', '2026-06-29 11:15:26', '2026-06-29 11:15:26'),
(6, 'COOL BLACK MET', '2026-06-29 11:15:37', '2026-06-29 11:15:37'),
(7, 'SNOW WHITE', '2026-06-29 11:15:53', '2026-06-29 11:15:53'),
(8, 'MET.MAGMA GRAY 2', '2026-06-29 11:16:04', '2026-06-29 11:16:04'),
(9, 'WHITE + BLACK TOP', '2026-06-29 11:16:21', '2026-06-29 11:16:21'),
(10, 'DUMMY.SAVANA IVORY 2', '2026-06-29 11:16:32', '2026-06-29 11:16:32'),
(11, 'RISING ORANGE PEARL METALLIC', '2026-06-29 11:16:42', '2026-06-29 11:16:42'),
(12, 'ICE GRAYISH BLUE', '2026-06-29 11:17:10', '2026-06-29 11:17:10'),
(13, 'SAVANA IVORY', '2026-06-29 11:17:38', '2026-06-29 11:17:38'),
(14, 'PRL.MIDNIGHT BLACK', '2026-06-29 11:17:52', '2026-06-29 11:17:52'),
(15, 'PEARL CAVE BLACK', '2026-06-29 11:18:02', '2026-06-29 11:18:02'),
(16, 'PRL.ARCTIC WHITE/PRL.MIDNIGHT BLACK', '2026-06-29 11:18:10', '2026-06-29 11:18:10'),
(17, 'PRME SPLENDID SILVER/PRL.MIDNIGHT BLACK', '2026-06-29 11:18:19', '2026-06-29 11:18:19'),
(18, 'BLUEISH BLACK PEARL 3', '2026-06-29 11:18:36', '2026-06-29 11:18:36'),
(19, 'SLD.MEDIUM GRAY', '2026-06-29 11:18:43', '2026-06-29 11:18:43'),
(20, 'SLD.JUNGLE GREEN', '2026-06-29 11:19:00', '2026-06-29 11:19:00'),
(21, 'MET.CHIFFON IVORY/PRL.BLUISH BLACK 3', '2026-06-29 11:19:10', '2026-06-29 11:19:10'),
(22, 'MET.BRISK BLUE/PRL.BLUISH BLACK 3', '2026-06-29 11:19:17', '2026-06-29 11:19:17'),
(23, 'SLD. KINETIC YELLOW/PRL.BLUISH BLACK 3', '2026-06-29 11:19:23', '2026-06-29 11:19:23'),
(24, 'SLD JUNGLE GREEN 2', '2026-06-29 11:19:34', '2026-06-29 11:19:34'),
(25, 'PRL.BLUISH BLACK 4', '2026-06-29 11:20:08', '2026-06-29 11:20:08'),
(26, 'GRANITE GRAY METALLIC', '2026-06-29 11:20:21', '2026-06-29 11:20:21'),
(27, 'SLD.KINETIC YELLOW 2/PRL.BLUISH BLACK 4', '2026-06-29 11:20:28', '2026-06-29 11:20:28'),
(28, 'MET.CHIFFON IVORY 2/PRL.BLUISH 4', '2026-06-29 11:20:38', '2026-06-29 11:20:38'),
(29, 'MET.SIZZLING RED/PRL BLUISH BLACK 4', '2026-06-29 11:20:51', '2026-06-29 11:20:51'),
(30, 'RISING ORANGE PEARL/METALLIC PERM. COOL BLACK', '2026-06-29 12:02:29', '2026-06-29 12:02:29'),
(31, 'MET.CHIFFON IVORY2/PRL.BLUISH 4', '2026-06-30 16:13:20', '2026-06-30 16:13:20'),
(33, 'GRANITE GRAY', '2026-07-01 11:54:58', '2026-07-01 11:54:58'),
(34, 'SOLID FIRE RED', '2026-07-01 13:43:32', '2026-07-01 13:43:32'),
(35, 'MARBLE BLACK', '2026-07-30 10:29:06', '2026-07-30 10:29:06'),
(36, 'MET.SAVANNA IVORY 2 + MARBLE BLACK', '2026-07-31 10:06:15', '2026-07-31 10:06:15'),
(37, 'PRIME.ICE GRAYISH BLUE 2 + MARBLE BLACK', '2026-07-31 10:06:46', '2026-07-31 10:06:46'),
(38, 'PRL.SNOW WHITE 4 + MARBLE BLACK', '2026-07-31 22:08:48', '2026-07-31 22:08:48'),
(39, 'PEARL WHITE METALLIC', '2026-08-20 10:35:58', '2026-08-20 10:35:58');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `actual_activities`
--
ALTER TABLE `actual_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `actual_do_by_type`
--
ALTER TABLE `actual_do_by_type`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `actual_do_salesforces`
--
ALTER TABLE `actual_do_salesforces`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `actual_inquary_by_type`
--
ALTER TABLE `actual_inquary_by_type`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `actual_salesforces`
--
ALTER TABLE `actual_salesforces`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `actual_sales_by_leasing`
--
ALTER TABLE `actual_sales_by_leasing`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `actual_source_do_inquary`
--
ALTER TABLE `actual_source_do_inquary`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `actual_source_inquary`
--
ALTER TABLE `actual_source_inquary`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `actual_spk_by_type`
--
ALTER TABLE `actual_spk_by_type`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `adm_leads`
--
ALTER TABLE `adm_leads`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `aktual_aplikasi_in`
--
ALTER TABLE `aktual_aplikasi_in`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `aktual_po`
--
ALTER TABLE `aktual_po`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `aktual_reject`
--
ALTER TABLE `aktual_reject`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `asuransis`
--
ALTER TABLE `asuransis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `budget_leads`
--
ALTER TABLE `budget_leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `budget_leads_sumber_id_foreign` (`sumber_id`);

--
-- Indeks untuk tabel `cabangs`
--
ALTER TABLE `cabangs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `dashboards`
--
ALTER TABLE `dashboards`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `evaluasi_wiraniaga`
--
ALTER TABLE `evaluasi_wiraniaga`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `gudangs`
--
ALTER TABLE `gudangs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `in_units`
--
ALTER TABLE `in_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `in_units_cabang_id_foreign` (`cabang_id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `piutangs`
--
ALTER TABLE `piutangs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `plan_activities`
--
ALTER TABLE `plan_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pmmstplansales`
--
ALTER TABLE `pmmstplansales`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `post_check_acs`
--
ALTER TABLE `post_check_acs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pre_check_acs`
--
ALTER TABLE `pre_check_acs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `respon_leads`
--
ALTER TABLE `respon_leads`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sales_leads`
--
ALTER TABLE `sales_leads`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `service_acs`
--
ALTER TABLE `service_acs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `spv_leads`
--
ALTER TABLE `spv_leads`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `status_leads`
--
ALTER TABLE `status_leads`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_unit_id_foreign` (`unit_id`),
  ADD KEY `stocks_varian_id_foreign` (`varian_id`),
  ADD KEY `stocks_gudang_id_foreign` (`gudang_id`),
  ADD KEY `stocks_cabang_id_foreign` (`cabang_id`),
  ADD KEY `stocks_warna_id_foreign` (`warna_id`);

--
-- Indeks untuk tabel `sumber_leads`
--
ALTER TABLE `sumber_leads`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `summaries`
--
ALTER TABLE `summaries`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `summary_actions`
--
ALTER TABLE `summary_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `target_do_by_soi`
--
ALTER TABLE `target_do_by_soi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `target_do_units`
--
ALTER TABLE `target_do_units`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `target_inquiries`
--
ALTER TABLE `target_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `target_salesforces`
--
ALTER TABLE `target_salesforces`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `teknisis`
--
ALTER TABLE `teknisis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `unit_leads`
--
ALTER TABLE `unit_leads`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `varians`
--
ALTER TABLE `varians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `varians_unit_id_foreign` (`unit_id`);

--
-- Indeks untuk tabel `warnas`
--
ALTER TABLE `warnas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `actual_activities`
--
ALTER TABLE `actual_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `actual_do_by_type`
--
ALTER TABLE `actual_do_by_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `actual_do_salesforces`
--
ALTER TABLE `actual_do_salesforces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `actual_inquary_by_type`
--
ALTER TABLE `actual_inquary_by_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `actual_salesforces`
--
ALTER TABLE `actual_salesforces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `actual_sales_by_leasing`
--
ALTER TABLE `actual_sales_by_leasing`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `actual_source_do_inquary`
--
ALTER TABLE `actual_source_do_inquary`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `actual_source_inquary`
--
ALTER TABLE `actual_source_inquary`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `actual_spk_by_type`
--
ALTER TABLE `actual_spk_by_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `adm_leads`
--
ALTER TABLE `adm_leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `aktual_aplikasi_in`
--
ALTER TABLE `aktual_aplikasi_in`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `aktual_po`
--
ALTER TABLE `aktual_po`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `aktual_reject`
--
ALTER TABLE `aktual_reject`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `asuransis`
--
ALTER TABLE `asuransis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT untuk tabel `budget_leads`
--
ALTER TABLE `budget_leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `cabangs`
--
ALTER TABLE `cabangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `dashboards`
--
ALTER TABLE `dashboards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `evaluasi_wiraniaga`
--
ALTER TABLE `evaluasi_wiraniaga`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gudangs`
--
ALTER TABLE `gudangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `in_units`
--
ALTER TABLE `in_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `piutangs`
--
ALTER TABLE `piutangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=406;

--
-- AUTO_INCREMENT untuk tabel `plan_activities`
--
ALTER TABLE `plan_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pmmstplansales`
--
ALTER TABLE `pmmstplansales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `post_check_acs`
--
ALTER TABLE `post_check_acs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pre_check_acs`
--
ALTER TABLE `pre_check_acs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `respon_leads`
--
ALTER TABLE `respon_leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sales_leads`
--
ALTER TABLE `sales_leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `service_acs`
--
ALTER TABLE `service_acs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `spv_leads`
--
ALTER TABLE `spv_leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `status_leads`
--
ALTER TABLE `status_leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=347;

--
-- AUTO_INCREMENT untuk tabel `sumber_leads`
--
ALTER TABLE `sumber_leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `summaries`
--
ALTER TABLE `summaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `summary_actions`
--
ALTER TABLE `summary_actions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `target_do_by_soi`
--
ALTER TABLE `target_do_by_soi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `target_do_units`
--
ALTER TABLE `target_do_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `target_inquiries`
--
ALTER TABLE `target_inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `target_salesforces`
--
ALTER TABLE `target_salesforces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `teknisis`
--
ALTER TABLE `teknisis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `unit_leads`
--
ALTER TABLE `unit_leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1303;

--
-- AUTO_INCREMENT untuk tabel `varians`
--
ALTER TABLE `varians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT untuk tabel `warnas`
--
ALTER TABLE `warnas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `budget_leads`
--
ALTER TABLE `budget_leads`
  ADD CONSTRAINT `budget_leads_sumber_id_foreign` FOREIGN KEY (`sumber_id`) REFERENCES `sumber_leads` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `in_units`
--
ALTER TABLE `in_units`
  ADD CONSTRAINT `in_units_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabangs` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabangs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stocks_gudang_id_foreign` FOREIGN KEY (`gudang_id`) REFERENCES `gudangs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stocks_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stocks_varian_id_foreign` FOREIGN KEY (`varian_id`) REFERENCES `varians` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stocks_warna_id_foreign` FOREIGN KEY (`warna_id`) REFERENCES `warnas` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `varians`
--
ALTER TABLE `varians`
  ADD CONSTRAINT `varians_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
