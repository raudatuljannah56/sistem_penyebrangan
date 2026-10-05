-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 05, 2026 at 12:43 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_penyebrangan`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-c1dfd96eea8cc2b62785275bca38ac261256e278', 'i:1;', 1790825381),
('laravel-cache-c1dfd96eea8cc2b62785275bca38ac261256e278:timer', 'i:1790825381;', 1790825381);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dermagas`
--

CREATE TABLE `dermagas` (
  `id_dermaga` bigint UNSIGNED NOT NULL,
  `nama_dermaga` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dermagas`
--

INSERT INTO `dermagas` (`id_dermaga`, `nama_dermaga`, `lokasi`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Pelabuhan Banjar Raya', NULL, NULL, 'aktif', '2026-09-01 18:10:06', '2026-09-01 18:10:06'),
(2, 'Pelabuhan Alalak', NULL, NULL, 'aktif', '2026-09-01 18:10:07', '2026-09-01 18:10:07'),
(3, 'Pelabuhan Ujung Murung', NULL, NULL, 'aktif', '2026-09-01 18:10:07', '2026-09-01 18:10:07'),
(4, 'Pelabuhan Pasar Baru', NULL, NULL, 'aktif', '2026-09-01 18:10:07', '2026-09-01 18:10:07'),
(5, 'Pelabuhan Pasar Lima', NULL, NULL, 'aktif', '2026-09-01 18:10:07', '2026-09-01 18:10:07'),
(6, 'Banjari', NULL, NULL, 'aktif', '2026-09-29 04:14:19', '2026-09-29 04:14:37');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `attempts` smallint UNSIGNED NOT NULL,
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
-- Table structure for table `lokets`
--

CREATE TABLE `lokets` (
  `id_loket` bigint UNSIGNED NOT NULL,
  `id_dermaga` bigint UNSIGNED NOT NULL,
  `nama_loket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_loket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lokets`
--

INSERT INTO `lokets` (`id_loket`, `id_dermaga`, `nama_loket`, `kode_loket`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Loket 1 ', 'BR-L1', 'aktif', '2026-09-01 18:17:32', '2026-09-24 06:44:05'),
(2, 1, 'Loket 2 ', 'BR-L2', 'aktif', '2026-09-01 18:17:37', '2026-09-09 04:50:51'),
(3, 2, 'Alalak', 'AL', 'aktif', '2026-09-14 15:20:22', '2026-09-14 15:25:00'),
(6, 3, 'Ujung Murung', 'UM', 'aktif', '2026-09-14 15:20:22', '2026-09-14 15:26:50'),
(7, 4, 'Pasar Baru', 'PB', 'aktif', '2026-09-14 15:20:23', '2026-09-14 15:26:36'),
(8, 5, 'Pasar Lima', 'PL', 'aktif', '2026-09-14 15:20:24', '2026-09-14 15:27:03');

-- --------------------------------------------------------

--
-- Table structure for table `loket_tarifs`
--

CREATE TABLE `loket_tarifs` (
  `id` bigint UNSIGNED NOT NULL,
  `id_loket` bigint UNSIGNED NOT NULL,
  `id_tarif` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loket_tarifs`
--

INSERT INTO `loket_tarifs` (`id`, `id_loket`, `id_tarif`, `created_at`, `updated_at`) VALUES
(2, 1, 5, NULL, NULL),
(3, 1, 1, NULL, NULL),
(5, 2, 1, NULL, NULL),
(6, 2, 2, NULL, NULL),
(7, 2, 3, NULL, NULL),
(8, 2, 4, NULL, NULL),
(9, 2, 5, NULL, NULL),
(10, 2, 7, NULL, NULL),
(11, 2, 8, NULL, NULL),
(12, 3, 1, NULL, NULL),
(13, 3, 5, NULL, NULL),
(14, 3, 7, NULL, NULL),
(15, 7, 9, NULL, NULL);

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
(4, '2026_08_24_015109_create_dermagas_table', 1),
(5, '2026_08_24_015214_create_lokets_table', 1),
(6, '2026_08_24_015223_create_tarifs_table', 1),
(7, '2026_08_24_015235_create_shifts_table', 1),
(8, '2026_08_24_015243_create_pelayanans_table', 1),
(9, '2026_08_24_015250_create_transaksis_table', 1),
(10, '2026_08_24_015256_create_pembayaran_qris_table', 1),
(11, '2026_08_31_044307_alter_status_on_transaksis_table', 1),
(12, '2026_09_04_104126_create_nomor_dokumen_laporans_table', 2),
(13, '2026_09_04_104607_add_fields_to_nomor_dokumen_laporans_table', 3),
(14, '2026_09_08_110854_add_status_to_shifts_table', 4),
(15, '2026_09_14_104401_create_loket_tarifs_table', 5),
(17, '2026_09_22_113046_add_is_logged_in_to_users_table', 6),
(18, '2026_09_29_114307_add_profile_fields_to_users_table', 7),
(19, '2026_09_29_120555_add_foto_to_users_table', 8),
(20, '2026_10_01_102350_add_foto_to_tarifs_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `nomor_dokumen_laporans`
--

CREATE TABLE `nomor_dokumen_laporans` (
  `id` bigint UNSIGNED NOT NULL,
  `tanggal_laporan` date NOT NULL,
  `nomor_terakhir` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nomor_dokumen_laporans`
--

INSERT INTO `nomor_dokumen_laporans` (`id`, `tanggal_laporan`, `nomor_terakhir`, `created_at`, `updated_at`) VALUES
(1, '2026-09-02', 2, '2026-09-04 04:00:22', '2026-09-07 02:38:41'),
(2, '2026-09-07', 11, '2026-09-07 02:46:51', '2026-09-07 06:18:34'),
(3, '2026-09-10', 3, '2026-09-10 08:34:26', '2026-09-10 08:37:14');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelayanans`
--

CREATE TABLE `pelayanans` (
  `id_pelayanan` bigint UNSIGNED NOT NULL,
  `nama_pelayanan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelayanans`
--

INSERT INTO `pelayanans` (`id_pelayanan`, `nama_pelayanan`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Penyeberangan', 'Pelayanan penyeberangan penumpang dan kendaraan', 'aktif', '2026-09-01 19:41:13', '2026-09-01 19:41:13');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_qris`
--

CREATE TABLE `pembayaran_qris` (
  `id_pembayaran_qris` bigint UNSIGNED NOT NULL,
  `id_transaksi` bigint UNSIGNED NOT NULL,
  `referensi_qris` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pembayaran` datetime NOT NULL,
  `status` enum('pending','berhasil','gagal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayaran_qris`
--

INSERT INTO `pembayaran_qris` (`id_pembayaran_qris`, `id_transaksi`, `referensi_qris`, `tanggal_pembayaran`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'QRIS-20260903110926-UW1Z2Z', '2026-09-03 11:09:26', 'pending', '2026-09-03 04:09:26', '2026-09-03 04:09:26'),
(2, 7, 'QRIS-20260909111852-1339C9', '2026-09-09 11:18:52', 'pending', '2026-09-09 04:18:52', '2026-09-09 04:18:52'),
(3, 9, 'QRIS-20260914224722-1ECE70', '2026-09-14 22:47:22', 'pending', '2026-09-14 15:47:22', '2026-09-14 15:47:22'),
(4, 11, 'QRIS-20260928101307-34C6AC', '2026-09-28 10:13:08', 'pending', '2026-09-28 03:13:08', '2026-09-28 03:13:08');

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
('wKilehPMcKqqkPleJvT9BxYlt941gzJ0NBRvfqfd', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:157.0) Gecko/20100101 Firefox/157.0', 'eyJfdG9rZW4iOiJPb0pkbXlBT2tkb2oxR1hDQWtzUzBBdEJiQ0VFbUdScTF5UzdkODBnIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Npc3RlbV9wZW55ZWJyYW5nYW4udGVzdFwvYWRtaW4iLCJyb3V0ZSI6ImZpbGFtZW50LmFkbWluLnBhZ2VzLmRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjo2LCJwYXNzd29yZF9oYXNoX3dlYiI6ImZmYWZkOWNiMTZkOGQ3ZjhjNmFkNDA3OTBlNGI4YWFiNjMzMDU0ZGIwNDFkMjk2NTczYTRlNWQ0NGZjZjIyOTQifQ==', 1790910365);

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id_shift` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_loket` bigint UNSIGNED NOT NULL,
  `nama_shift` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `status` enum('belum_mulai','berlangsung','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum_mulai',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`id_shift`, `id_user`, `id_loket`, `nama_shift`, `jam_mulai`, `jam_selesai`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Shift 1', '07:00:00', '15:00:00', 'berlangsung', '2026-09-01 18:44:14', '2026-09-28 02:25:56'),
(2, 2, 1, 'Shift 2', '15:00:00', '23:00:00', 'belum_mulai', '2026-09-01 18:44:25', '2026-09-16 02:45:42'),
(3, 3, 1, 'Shift 3', '23:00:00', '07:00:00', 'belum_mulai', '2026-09-01 18:44:33', '2026-09-09 07:35:57'),
(4, 4, 2, 'Shift 1', '07:00:00', '15:00:00', 'belum_mulai', '2026-09-01 18:44:42', '2026-09-23 02:35:02'),
(5, 5, 2, 'Shift 2', '15:00:00', '22:00:00', 'belum_mulai', '2026-09-01 18:44:53', '2026-09-16 02:45:42'),
(6, 7, 3, 'Alalak shift 1', '07:00:00', '15:00:00', 'berlangsung', '2026-09-14 15:33:24', '2026-09-28 07:33:30'),
(7, 8, 3, 'Alalak shift 2', '15:00:00', '23:00:00', 'belum_mulai', '2026-09-14 15:33:25', '2026-09-16 02:45:42'),
(8, 9, 3, 'Alalak shift 3', '23:00:00', '07:00:00', 'belum_mulai', '2026-09-14 15:33:42', '2026-09-14 15:33:42'),
(9, 10, 6, 'Ujungmurung', '07:00:00', '23:00:00', 'belum_mulai', '2026-09-14 15:42:22', '2026-09-22 05:30:54'),
(10, 11, 7, 'Pelabuhan Pasar Baru', '07:00:00', '16:00:00', 'belum_mulai', '2026-09-14 15:42:22', '2026-09-22 05:30:54'),
(11, 12, 8, 'Pelabuhan Pasar Lima', '07:00:00', '23:00:00', 'belum_mulai', '2026-09-14 15:42:22', '2026-09-16 02:45:50');

-- --------------------------------------------------------

--
-- Table structure for table `tarifs`
--

CREATE TABLE `tarifs` (
  `id_tarif` bigint UNSIGNED NOT NULL,
  `nama_tarif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('penumpang','kendaraan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tarifs`
--

INSERT INTO `tarifs` (`id_tarif`, `nama_tarif`, `kategori`, `harga`, `foto`, `status`, `created_at`, `updated_at`) VALUES
(1, 'RODA 2', 'kendaraan', 2000.00, 'tarif/01M3TQTB049HBTQ3VW6HSTQWE8.png', 'aktif', '2026-09-01 19:24:24', '2026-10-01 04:23:36'),
(2, 'RODA 3', 'kendaraan', 3000.00, 'tarif/01M3TQV6N9JKH8HBV1RG0HMRX8.png', 'aktif', '2026-09-01 19:24:24', '2026-10-01 04:24:04'),
(3, 'RODA 4', 'kendaraan', 5000.00, 'tarif/01M3TQVY4T1PHANZGQB50F51WY.png', 'aktif', '2026-09-01 19:24:24', '2026-10-01 04:24:28'),
(4, 'RODA 6 ATAU LEBIH', 'kendaraan', 7000.00, 'tarif/01M3TQWYTSZY60CGR5PQ7XZQRE.png', 'aktif', '2026-09-01 19:24:24', '2026-10-01 04:25:02'),
(5, 'JALAN KAKI', 'penumpang', 1000.00, 'tarif/01M3TQXVS4CCVMCNDW0YR8GXAD.png', 'aktif', '2026-09-01 19:24:24', '2026-10-01 04:25:31'),
(7, 'PENUMPANG KAPAL PER ORANG', 'penumpang', 1000.00, 'tarif/01M3TQZ7YQRPA1AVVVMB8QQWBR.png', 'aktif', '2026-09-01 19:30:59', '2026-10-01 04:26:17'),
(8, 'BONGKAR MUAT PER 1 TON', 'penumpang', 5000.00, NULL, 'aktif', '2026-09-01 19:30:59', '2026-10-01 04:26:54'),
(9, 'KELOTOK BARANG', 'kendaraan', 5000.00, 'tarif/01M3TR16KA11GP0013053WNBRB.png', 'aktif', '2026-09-16 02:36:57', '2026-10-01 04:27:21'),
(10, 'KELOTOK PENUMPANG', 'penumpang', 5000.00, 'tarif/01M3TR2K1DWFJN1NX4GCNSGA88.png', 'nonaktif', '2026-09-16 02:36:57', '2026-10-01 04:28:06'),
(11, 'Speed Boat 85–200 PK', 'kendaraan', 5000.00, 'tarif/01M3TR3R7KV951ZP3TNA0PXZF3.png', 'nonaktif', '2026-09-16 02:36:57', '2026-10-01 04:28:44'),
(12, 'Motor Getek <20 GT', 'kendaraan', 5000.00, NULL, 'nonaktif', '2026-09-16 02:36:57', '2026-09-16 02:36:57'),
(13, 'Truk Air/Bus Air 20–50 GT', 'kendaraan', 8000.00, NULL, 'nonaktif', '2026-09-16 02:36:57', '2026-09-16 02:36:57'),
(14, 'Truk Air/Bus Air 50–100 GT', 'kendaraan', 10000.00, NULL, 'nonaktif', '2026-09-16 02:36:57', '2026-09-16 02:36:57'),
(15, 'Truk Air/Bus Air <100 GT', 'kendaraan', 30000.00, NULL, 'nonaktif', '2026-09-16 02:36:57', '2026-09-16 02:41:17');

-- --------------------------------------------------------

--
-- Table structure for table `transaksis`
--

CREATE TABLE `transaksis` (
  `id_transaksi` bigint UNSIGNED NOT NULL,
  `kode_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_shift` bigint UNSIGNED NOT NULL,
  `id_pelayanan` bigint UNSIGNED NOT NULL,
  `id_tarif` bigint UNSIGNED NOT NULL,
  `jumlah` int UNSIGNED NOT NULL DEFAULT '1',
  `harga` decimal(12,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `metode_pembayaran` enum('tunai','qris') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','berhasil','dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `tanggal_transaksi` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksis`
--

INSERT INTO `transaksis` (`id_transaksi`, `kode_transaksi`, `id_shift`, `id_pelayanan`, `id_tarif`, `jumlah`, `harga`, `total`, `metode_pembayaran`, `status`, `tanggal_transaksi`, `created_at`, `updated_at`) VALUES
(1, 'TRX-20260902024633-U4O74', 1, 1, 5, 1, 1000.00, 1000.00, 'tunai', 'berhasil', '2026-09-02 02:46:33', '2026-09-01 19:46:33', '2026-09-01 19:46:33'),
(2, 'TRX-20260902024654-WNBO8', 1, 1, 8, 1, 5000.00, 5000.00, 'tunai', 'berhasil', '2026-09-02 02:46:54', '2026-09-01 19:46:54', '2026-09-01 19:46:54'),
(3, 'TRX-20260902115402-OYEOM', 1, 1, 2, 1, 3000.00, 3000.00, 'tunai', 'berhasil', '2026-09-02 11:54:02', '2026-09-02 04:54:02', '2026-09-02 04:54:02'),
(4, 'TRX-20260903110926-Z8XQJ', 1, 1, 1, 2, 2000.00, 4000.00, 'qris', 'pending', '2026-09-03 11:09:26', '2026-09-03 04:09:26', '2026-09-03 04:09:26'),
(5, 'TRX-PBR260907-001', 1, 1, 1, 1, 2000.00, 2000.00, 'tunai', 'berhasil', '2026-09-07 13:05:47', '2026-09-07 06:05:47', '2026-09-07 06:05:47'),
(6, 'TRX-PBR260909-001', 1, 1, 5, 4, 1000.00, 4000.00, 'tunai', 'berhasil', '2026-09-09 11:18:31', '2026-09-09 04:18:31', '2026-09-09 04:18:31'),
(7, 'TRX-PBR260909-002', 1, 1, 1, 1, 2000.00, 2000.00, 'qris', 'pending', '2026-09-09 11:18:52', '2026-09-09 04:18:52', '2026-09-09 04:18:52'),
(8, 'TRX-PBR260909-003', 4, 1, 3, 1, 5000.00, 5000.00, 'tunai', 'berhasil', '2026-09-09 14:49:18', '2026-09-09 07:49:18', '2026-09-09 07:49:18'),
(9, 'TRX-PAL260914-001', 6, 1, 1, 1, 2000.00, 2000.00, 'qris', 'pending', '2026-09-14 22:47:22', '2026-09-14 15:47:22', '2026-09-14 15:47:22'),
(10, 'TRX-PBR260928-001', 1, 1, 1, 2, 2000.00, 4000.00, 'tunai', 'berhasil', '2026-09-28 10:11:27', '2026-09-28 03:11:27', '2026-09-28 03:11:27'),
(11, 'TRX-PBR260928-002', 1, 1, 5, 1, 1000.00, 1000.00, 'qris', 'pending', '2026-09-28 10:13:07', '2026-09-28 03:13:07', '2026-09-28 03:13:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','petugas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'petugas',
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `is_logged_in` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `nama`, `no_telepon`, `alamat`, `email`, `foto`, `password`, `role`, `status`, `is_logged_in`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'banjarrayaloket1a', 'Banjarraya Loket 1 Shift 1', NULL, NULL, NULL, 'profile/FgqzLogHqXrUrzsUSYQs8IKXkNKunfDuTNgx83Sx.jpg', '$2y$12$PnOkSEuE5QpTHhXrzrV.v.fZNJSev17TkqPFx119h0IQT/lHmL7rG', 'petugas', 'aktif', 1, NULL, '2026-09-01 18:42:31', '2026-10-01 02:49:18'),
(2, 'banjarrayaloket1b', 'Banjarraya Loket 1 Shift 2', NULL, NULL, NULL, NULL, '$2y$12$PFC4YXJrmH6ESXnXQSoZW.qzu4iURrwn8rLhQSC9RDcrEQVlVSx0K', 'petugas', 'aktif', 0, NULL, '2026-09-01 18:42:48', '2026-09-03 02:47:54'),
(3, 'banjarrayaloket1c', 'Banjarraya Loket 1 Shift 3', NULL, NULL, NULL, NULL, '$2y$12$tY2/qgRxQ2qPynI70kQTC.IoIJkfL/flzuUKxGYzolc2X4iE8tnji', 'petugas', 'aktif', 0, NULL, '2026-09-01 18:43:00', '2026-09-03 02:47:54'),
(4, 'banjarrayaloket2a', 'Banjarraya Loket 2 Shift 1', NULL, NULL, NULL, NULL, '$2y$12$bLu3VaXGMvmkMiqTOPhGlOp.V0SDxsEyDxoeC0hdp566zEoauPQEy', 'petugas', 'aktif', 0, NULL, '2026-09-01 18:43:10', '2026-09-03 02:47:54'),
(5, 'banjarrayaloket2b', 'Banjarraya Loket 2 Shift 2', NULL, NULL, NULL, NULL, '$2y$12$3ZsfUMPTso78pJrIPz65y.jTcGX/8yL2s6A4WZD5F/DrwDItfn21i', 'petugas', 'aktif', 0, NULL, '2026-09-01 18:43:18', '2026-09-03 02:47:54'),
(6, 'adminloket', 'Admin', NULL, 'Banjarraya, Banjarmasin Barat, Kalimantan Selatan njaodjkhjbnm, ajosaslkakqjwdiwdjewf, sadmjduowdlejwfdvl;jvnnv', NULL, 'profile/sh3dl3yyVUhlOpQ51Pin2zVB5K6RSYKeNUti5GHE.jpg', '$2y$12$MMt1aVbGfCdqyy8pkwWHO.fB0hWb.xQuOp1SkUJTZfdLxKclWfvIS', 'admin', 'aktif', 0, NULL, '2026-09-01 18:46:38', '2026-10-01 01:41:01'),
(7, 'alalak1a', 'Alalak shift 1', NULL, NULL, NULL, NULL, '$2y$12$dCDAcLHwJWlkvFSBKi6pA.FQhMyU.fKUZhHDOvMkkDuollUF19fxG', 'petugas', 'aktif', 1, NULL, '2026-09-14 14:30:58', '2026-09-28 07:33:30'),
(8, 'alalak1b', 'Alalak shift 2', NULL, NULL, NULL, NULL, '$2y$12$GIN8p5ktzo33HIRqUiF6IOq7hBu/27mdJy.nfAACny3EUXkqjaJLq', 'petugas', 'aktif', 0, NULL, '2026-09-14 14:30:59', '2026-09-14 14:38:27'),
(9, 'alalak1c', 'Alalak shift 3', NULL, NULL, NULL, NULL, '$2y$12$xmG/Z7PBaMFak3/uwX3yxeQcenGL0Ku3WXG09ef5HMPJ4q9PXInym', 'petugas', 'aktif', 0, NULL, '2026-09-14 14:30:59', '2026-09-14 14:39:11'),
(10, 'Ujungmurung', 'Ujungmurung', NULL, NULL, NULL, NULL, '$2y$12$htofj/4N8L93kdIwOhWgi.enDYq/c/UMfgP86DaxOy9CN8w3ujCdK', 'petugas', 'aktif', 0, NULL, '2026-09-14 14:30:59', '2026-09-14 14:39:34'),
(11, 'Pasarbaru', 'Pelabuhan Pasar Baru', NULL, NULL, NULL, NULL, '$2y$12$cB9znhyqO3OjoeMky/MhzOQJrggpCLPf3Qcmcd1vt7ZbMY8vwAJn2', 'petugas', 'aktif', 0, NULL, '2026-09-14 14:31:00', '2026-09-14 14:40:04'),
(12, 'Pasarlima', 'Pelabuhan Pasar Lima', NULL, NULL, NULL, NULL, '$2y$12$Rr5K75mjgrYYehwhxUTx7OsKc2P8eVPGJk8tA0hc5KK58mI4wk8vW', 'petugas', 'aktif', 0, NULL, '2026-09-14 14:31:00', '2026-09-14 14:40:46');

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
-- Indexes for table `dermagas`
--
ALTER TABLE `dermagas`
  ADD PRIMARY KEY (`id_dermaga`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

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
-- Indexes for table `lokets`
--
ALTER TABLE `lokets`
  ADD PRIMARY KEY (`id_loket`),
  ADD UNIQUE KEY `lokets_kode_loket_unique` (`kode_loket`),
  ADD KEY `lokets_id_dermaga_foreign` (`id_dermaga`);

--
-- Indexes for table `loket_tarifs`
--
ALTER TABLE `loket_tarifs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `loket_tarifs_id_loket_id_tarif_unique` (`id_loket`,`id_tarif`),
  ADD KEY `loket_tarifs_id_tarif_foreign` (`id_tarif`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nomor_dokumen_laporans`
--
ALTER TABLE `nomor_dokumen_laporans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_dokumen_laporans_tanggal_laporan_unique` (`tanggal_laporan`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pelayanans`
--
ALTER TABLE `pelayanans`
  ADD PRIMARY KEY (`id_pelayanan`);

--
-- Indexes for table `pembayaran_qris`
--
ALTER TABLE `pembayaran_qris`
  ADD PRIMARY KEY (`id_pembayaran_qris`),
  ADD UNIQUE KEY `pembayaran_qris_id_transaksi_unique` (`id_transaksi`),
  ADD UNIQUE KEY `pembayaran_qris_referensi_qris_unique` (`referensi_qris`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id_shift`),
  ADD UNIQUE KEY `shifts_id_user_unique` (`id_user`),
  ADD KEY `shifts_id_loket_foreign` (`id_loket`);

--
-- Indexes for table `tarifs`
--
ALTER TABLE `tarifs`
  ADD PRIMARY KEY (`id_tarif`);

--
-- Indexes for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `transaksis_kode_transaksi_unique` (`kode_transaksi`),
  ADD KEY `transaksis_id_shift_foreign` (`id_shift`),
  ADD KEY `transaksis_id_pelayanan_foreign` (`id_pelayanan`),
  ADD KEY `transaksis_id_tarif_foreign` (`id_tarif`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dermagas`
--
ALTER TABLE `dermagas`
  MODIFY `id_dermaga` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- AUTO_INCREMENT for table `lokets`
--
ALTER TABLE `lokets`
  MODIFY `id_loket` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `loket_tarifs`
--
ALTER TABLE `loket_tarifs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `nomor_dokumen_laporans`
--
ALTER TABLE `nomor_dokumen_laporans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pelayanans`
--
ALTER TABLE `pelayanans`
  MODIFY `id_pelayanan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pembayaran_qris`
--
ALTER TABLE `pembayaran_qris`
  MODIFY `id_pembayaran_qris` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id_shift` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tarifs`
--
ALTER TABLE `tarifs`
  MODIFY `id_tarif` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id_transaksi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lokets`
--
ALTER TABLE `lokets`
  ADD CONSTRAINT `lokets_id_dermaga_foreign` FOREIGN KEY (`id_dermaga`) REFERENCES `dermagas` (`id_dermaga`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `loket_tarifs`
--
ALTER TABLE `loket_tarifs`
  ADD CONSTRAINT `loket_tarifs_id_loket_foreign` FOREIGN KEY (`id_loket`) REFERENCES `lokets` (`id_loket`) ON DELETE CASCADE,
  ADD CONSTRAINT `loket_tarifs_id_tarif_foreign` FOREIGN KEY (`id_tarif`) REFERENCES `tarifs` (`id_tarif`) ON DELETE CASCADE;

--
-- Constraints for table `pembayaran_qris`
--
ALTER TABLE `pembayaran_qris`
  ADD CONSTRAINT `pembayaran_qris_id_transaksi_foreign` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksis` (`id_transaksi`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `shifts`
--
ALTER TABLE `shifts`
  ADD CONSTRAINT `shifts_id_loket_foreign` FOREIGN KEY (`id_loket`) REFERENCES `lokets` (`id_loket`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `shifts_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD CONSTRAINT `transaksis_id_pelayanan_foreign` FOREIGN KEY (`id_pelayanan`) REFERENCES `pelayanans` (`id_pelayanan`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksis_id_shift_foreign` FOREIGN KEY (`id_shift`) REFERENCES `shifts` (`id_shift`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksis_id_tarif_foreign` FOREIGN KEY (`id_tarif`) REFERENCES `tarifs` (`id_tarif`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
