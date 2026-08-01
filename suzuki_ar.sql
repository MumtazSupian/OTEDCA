-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3308
-- Generation Time: Jun 03, 2026 at 01:57 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `suzuki_ar`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_21_000000_create_piutangs_table', 1),
(5, '2026_05_21_000001_create_sessions_table', 1),
(6, '2026_05_26_071701_add_branch_to_users_table', 1),
(7, '2026_05_28_000000_add_is_admin_to_users_table', 2),
(8, '2026_06_02_000000_add_payment_stage_columns_to_piutangs_table', 3),
(9, '2026_06_02_065337_add_nama_asuransi_to_piutangs_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `piutangs`
--

CREATE TABLE `piutangs` (
  `id` bigint UNSIGNED NOT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_konsumen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_asuransi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_bukti` date DEFAULT NULL,
  `no_bukti` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saldo_awal` decimal(20,2) NOT NULL DEFAULT '0.00',
  `debet` decimal(20,2) NOT NULL DEFAULT '0.00',
  `kredit` decimal(20,2) NOT NULL DEFAULT '0.00',
  `tgl_bukti_rek` date DEFAULT NULL,
  `no_bukti_rek` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saldo_akhir` decimal(20,2) NOT NULL DEFAULT '0.00',
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_bukti_rek_2` date DEFAULT NULL,
  `no_bukti_rek_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_bukti_rek_3` date DEFAULT NULL,
  `no_bukti_rek_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_polisi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_polis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spk_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_spk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `piutangs`
--

INSERT INTO `piutangs` (`id`, `branch`, `nama_konsumen`, `nama_asuransi`, `tgl_bukti`, `no_bukti`, `saldo_awal`, `debet`, `kredit`, `tgl_bukti_rek`, `no_bukti_rek`, `saldo_akhir`, `keterangan`, `tgl_bukti_rek_2`, `no_bukti_rek_2`, `keterangan_2`, `tgl_bukti_rek_3`, `no_bukti_rek_3`, `keterangan_3`, `no_polisi`, `no_polis`, `spk_type`, `no_spk`, `created_at`, `updated_at`) VALUES
(1, 'cinere', 'ahmad', NULL, '2026-05-26', 'B12AHBIN23', '2100000.00', '0.00', '1200000.00', '2026-06-01', '1222311', '1000000.00', 'Anjay', NULL, NULL, NULL, NULL, NULL, NULL, 'B212AB', '00006789', 'REGULER', NULL, '2026-05-26 00:51:48', '2026-05-26 00:51:48'),
(2, 'bp', 'ahmad', NULL, '2026-05-12', 'B12AHBIN23', '2300000.00', '200000.00', '0.00', '2026-05-26', '1222311', '1100000.00', 'Anjay', NULL, NULL, NULL, NULL, NULL, NULL, 'B2123WE', '000067778', 'INTERNAL', NULL, '2026-05-26 02:18:12', '2026-05-26 02:18:12'),
(3, 'bp', 'iki', NULL, '2026-04-15', 'B12AHBIN23', '2100000.00', '200000.00', '120000.00', '2026-05-26', '1222311', '1000000.00', 'Anjay', NULL, NULL, NULL, NULL, NULL, NULL, 'B212AB', '00006789', 'ASURANSI', NULL, '2026-05-26 02:19:18', '2026-05-26 02:19:18'),
(4, 'bp', 'aki', NULL, '2026-05-05', 'B12AHBIN23', '2300000.00', '200000.00', '1200000.00', '2026-05-26', '1222311', '1100000.00', 'Anjay', NULL, NULL, NULL, NULL, NULL, NULL, 'B212AB', '000067778', 'REGULER', NULL, '2026-05-26 02:19:56', '2026-05-26 02:19:56'),
(5, 'bp', NULL, NULL, '2026-05-30', 'IA05/25/000014', '17850.00', '0.00', '0.00', NULL, NULL, '17850.00', 'BUPOT', NULL, NULL, NULL, NULL, NULL, NULL, 'NADIA RAHMAD', NULL, 'ASURANSI', 'PK05/25/000425', '2026-05-29 20:41:16', '2026-05-29 20:41:16');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1UeXO7J2fO6LMgGR60d1D9vMjy5xLVyuy4b8uz1t', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.122.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS0dQQ01QYjNoOVJPSk1aTTRpUG85UDBsbk9qRk92UVhZMXdkWURqViI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1780366611),
('1zizpioiXVVoIaAW0En0yvDNXjCGSfKy132XQaYU', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSkhoTXFvMnhYc1lNdmhKcHZjMmVJRTNPcXFHVU9SM0EyY2RqdTBibCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1780386879),
('2OUWgaxfAKxAyyekJhupkNvuwE7mgjxCQp7GGnAu', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRzZLaXVQSlRjWk5icWJ2a0RSRVl3OVpXVXgyTDBEOG5iNHhnSTc3dSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO047fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7fQ==', 1780025305),
('6H8hL1XdI7v8EluDD93sHDB7FK3mOrTPwM2dRr34', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.122.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib2x4T21TQUpjZWJBQ0dqTTlHeXZYM1VZQ3Fwa0FqeXpJREtQY2pnciI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1780366631),
('bFyY6I3DhPVzBAcSXJn3OqBD0MYf5L0g3VFooblG', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMWJobzk4MVVIZ3FqRFV2SElpR3daa2dMSTZjUlVjQVpaa01zbTZQRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO047fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7fQ==', 1779960479),
('bXjLkxvd3EYh0h9XEj3hfS9Hls39Fg2oadRPcXsL', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.122.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTnpCZEsxVWp0ZnhvOVU3WllMOXFzN3RkOWpqZEx0S0c5RUE1d1BnTSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYnAiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7fQ==', 1780112221),
('CkKbcuUgoqG9PeB2SwdFLEJXOYYXm41z3fs3bQjz', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVnltczZielo5Mnk3dDVrSmtJczg5RG05VURlOHl2NXl5ektFdUtLeiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9icCI7czo1OiJyb3V0ZSI7Tjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Nzt9', 1780371730),
('KoAp4Brw7pvTs0CiiWBNf3m9wJ7ucBGAsrsIDCUw', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMVJFeTVwcUl4OWZVNkREU3oxdnJwN0VlSEhFMHdRZkFLR3owdkNzUSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYnAiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7fQ==', 1780112477),
('NGTiV0xgclCyUruv3DGMaV5CVR0vFENCBZXWgxVY', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.122.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiY3lGenJwQWFuRDVTNW5FMllhZ3pES0hrSEtFODhsUWgxSkI2dUU4ciI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo2O30=', 1779958495),
('tBAPXBhXX2taOyX7GadWaAL2Pyr1EExTTj0PuHxv', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY3RwQm1VRUxSR1BxZzlLa0tlMUN1N1dZcWdES2djU3RBZEhEQldiUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9icCI7czo1OiJyb3V0ZSI7Tjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1779953565),
('WluP5N4Re7J6SN3tG6vZmFaNqHwW30k37WGcivl6', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.122.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMm1nZ1U1S0hvUmlrZWNUa1NISVhQWmsxZGY5ZXU5WWtBVUt1U0FPQiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo3O30=', 1780024526);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `branch`, `is_admin`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'BP User', 'bp@suzuki.com', 'bp', 0, NULL, '$2y$12$UfHcoCmV3.1pKlbRFpRZDu.xXdCkQ6d5Me24f0TAhmmnF2EUh4KPC', NULL, '2026-05-26 00:32:58', '2026-05-26 00:32:58'),
(2, 'CINERE User', 'cinere@suzuki.com', 'cinere', 0, NULL, '$2y$12$2BrXqW7.hvNAKQCMQKaWg.rdkEOzONvAdFfn.0KbOF6FcfAR2tT2q', 'h5dqrt9ohbNELBJbPdRBGXemKCR6Ay1pEcUWvsKapru5scyqEOWrBBSVfPYt', '2026-05-26 00:32:59', '2026-05-26 00:32:59'),
(3, 'JATIASIH User', 'jatiasih@suzuki.com', 'jatiasih', 0, NULL, '$2y$12$t2GQe5pz84chBJDsrWCR6.85oB9J5VtFJr.pA2OAMjqEfdGP4BeZa', NULL, '2026-05-26 00:32:59', '2026-05-26 00:32:59'),
(4, 'CIANJUR User', 'cianjur@suzuki.com', 'cianjur', 0, NULL, '$2y$12$9x8X0ZR7kZAxsAUwe9Zvre9R7hi/eKxI5g//hyXBbmfPEpJoQ9eNW', NULL, '2026-05-26 00:32:59', '2026-05-26 00:32:59'),
(5, 'CIAWI User', 'ciawi@suzuki.com', 'ciawi', 0, NULL, '$2y$12$gY2BKDUJ6DFXx3CAt47EnObxts4Lbu7wExNeMHiLlfypPNX6ynP9q', NULL, '2026-05-26 00:32:59', '2026-05-26 00:32:59'),
(6, 'Administrator', 'admin@example.com', 'admin', 1, NULL, '$2y$12$UUAc2cXD9VPqRxU9O.1tYOo69EkCs6P8BuIVamZvMGW4p7Tcaj9ja', NULL, '2026-05-28 01:54:20', '2026-05-28 01:57:46'),
(7, 'Administrator', 'admin@suzuki.com', 'admin', 1, NULL, '$2y$12$lyQBqUm/APHMMH7uYPJuTeYGufp5WOHqWrekCVo.Mxi.aac8bt1ri', NULL, '2026-05-28 02:13:02', '2026-05-28 02:13:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `piutangs`
--
ALTER TABLE `piutangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `piutangs`
--
ALTER TABLE `piutangs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
