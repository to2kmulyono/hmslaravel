-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 26, 2026 at 04:17 PM
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
-- Database: `db_hms_laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `antrian`
--

CREATE TABLE `antrian` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_jadwalpoliklinik` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_antrian` bigint DEFAULT NULL,
  `no_antrian` int NOT NULL,
  `nama_pasien` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jadwalpoliklinik_id` bigint UNSIGNED NOT NULL,
  `id_pasien` bigint UNSIGNED NOT NULL,
  `nama_dokter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokter_id` bigint UNSIGNED DEFAULT NULL,
  `poliklinik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penjamin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_bpjs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scan_kbpjs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scan_kasuransi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_berobat` date NOT NULL,
  `status` enum('menunggu','diproses','dilayani') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `waktu_selesai` timestamp NULL DEFAULT NULL,
  `waktu_mulai` timestamp NULL DEFAULT NULL,
  `tanggal_reservasi` date NOT NULL,
  `scan_surat_rujukan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `datapasien`
--

CREATE TABLE `datapasien` (
  `id` bigint UNSIGNED NOT NULL,
  `foto_pasien` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_pasien` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `scan_ktp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_kberobat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scan_kberobat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_kbpjs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scan_kbpjs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scan_kasuransi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_dokter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poliklinik_id` bigint UNSIGNED NOT NULL,
  `foto_dokter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `jadwalpoliklinik`
--

CREATE TABLE `jadwalpoliklinik` (
  `id` bigint UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokter_id` bigint UNSIGNED NOT NULL,
  `poliklinik_id` bigint UNSIGNED NOT NULL,
  `tanggal_praktek` date DEFAULT NULL,
  `hari` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `jumlah` int NOT NULL,
  `tipe_jadwal` enum('harian','mingguan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'harian',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `hari_dalam_minggu` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(1, '2014_10_12_000000_create_laravel_defaults', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2014_10_12_100000_create_password_resets_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2023_06_15_000001_mark_default_migrations_as_run', 1),
(7, '2025_03_04_064545_create_base_tables', 1),
(8, '2025_03_05_000000_create_jadwalpoliklinik_table', 1),
(9, '2025_03_08_080256_create_pendaftaran_and_antrian_tables', 1),
(10, '2025_03_12_210000_add_antrian_id_to_ratings_table', 1),
(11, '2025_03_20_000000_create_supporting_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` bigint UNSIGNED NOT NULL,
  `id_pasien` bigint UNSIGNED DEFAULT NULL,
  `jadwalpoliklinik_id` bigint UNSIGNED NOT NULL,
  `nama_pasien` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penjamin` enum('UMUM','BPJS','Asuransi') COLLATE utf8mb4_unicode_ci NOT NULL,
  `scan_surat_rujukan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poliklinik`
--

CREATE TABLE `poliklinik` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_poliklinik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint UNSIGNED NOT NULL,
  `dokter_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `antrian_id` bigint UNSIGNED DEFAULT NULL,
  `rating` decimal(3,1) NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_kunjungan`
--

CREATE TABLE `riwayat_kunjungan` (
  `id` bigint UNSIGNED NOT NULL,
  `antrian_id` bigint UNSIGNED DEFAULT NULL,
  `pasien_id` bigint UNSIGNED DEFAULT NULL,
  `dokter_id` bigint UNSIGNED DEFAULT NULL,
  `poliklinik_id` bigint UNSIGNED DEFAULT NULL,
  `kode_kunjungan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_antrian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pasien` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_dokter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poliklinik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `durasi_pelayanan` int DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dilayani',
  `penjamin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` enum('admin','petugas','pasien') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama_user`, `username`, `password`, `no_telepon`, `foto_user`, `roles`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@rumahsakit.com', '$2a$12$qFfmZZkS8EH9kw0hOU0euOyu7HDTKrrQkAcFhivkRWn2rCVkGDT22', '0812345678', NULL, 'admin', NULL, '2026-05-26 15:51:39', '2026-05-26 15:51:39'),
(2, 'Petugas Test', 'petugas@rumahsakit.com', '$2a$12$qFfmZZkS8EH9kw0hOU0euOyu7HDTKrrQkAcFhivkRWn2rCVkGDT22', '0812345679', '1779811757.png', 'petugas', NULL, '2026-05-26 15:51:40', '2026-05-26 16:09:17'),
(3, 'Pasien Test', 'pasien@rumahsakit.com', '$2a$12$qFfmZZkS8EH9kw0hOU0euOyu7HDTKrrQkAcFhivkRWn2rCVkGDT22', '0812345670', '1779812166.png', 'pasien', NULL, '2026-05-26 15:51:40', '2026-05-26 16:16:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `antrian`
--
ALTER TABLE `antrian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `antrian_kode_antrian_unique` (`kode_antrian`),
  ADD KEY `antrian_jadwalpoliklinik_id_foreign` (`jadwalpoliklinik_id`),
  ADD KEY `antrian_id_pasien_foreign` (`id_pasien`),
  ADD KEY `antrian_user_id_foreign` (`user_id`);

--
-- Indexes for table `datapasien`
--
ALTER TABLE `datapasien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `datapasien_no_kberobat_unique` (`no_kberobat`),
  ADD KEY `datapasien_user_id_foreign` (`user_id`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dokter_poliklinik_id_foreign` (`poliklinik_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jadwalpoliklinik`
--
ALTER TABLE `jadwalpoliklinik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jadwalpoliklinik_kode_unique` (`kode`),
  ADD KEY `jadwalpoliklinik_dokter_id_foreign` (`dokter_id`),
  ADD KEY `jadwalpoliklinik_poliklinik_id_foreign` (`poliklinik_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendaftaran_id_pasien_foreign` (`id_pasien`),
  ADD KEY `pendaftaran_jadwalpoliklinik_id_foreign` (`jadwalpoliklinik_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `poliklinik`
--
ALTER TABLE `poliklinik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `poliklinik_id_unique` (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ratings_dokter_id_user_id_unique` (`dokter_id`,`user_id`),
  ADD KEY `ratings_user_id_foreign` (`user_id`),
  ADD KEY `ratings_antrian_id_foreign` (`antrian_id`);

--
-- Indexes for table `riwayat_kunjungan`
--
ALTER TABLE `riwayat_kunjungan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `riwayat_kunjungan_kode_kunjungan_unique` (`kode_kunjungan`),
  ADD KEY `riwayat_kunjungan_antrian_id_foreign` (`antrian_id`),
  ADD KEY `riwayat_kunjungan_pasien_id_foreign` (`pasien_id`),
  ADD KEY `riwayat_kunjungan_dokter_id_foreign` (`dokter_id`),
  ADD KEY `riwayat_kunjungan_poliklinik_id_foreign` (`poliklinik_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_username_unique` (`username`);

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
-- AUTO_INCREMENT for table `antrian`
--
ALTER TABLE `antrian`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `datapasien`
--
ALTER TABLE `datapasien`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwalpoliklinik`
--
ALTER TABLE `jadwalpoliklinik`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poliklinik`
--
ALTER TABLE `poliklinik`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riwayat_kunjungan`
--
ALTER TABLE `riwayat_kunjungan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `antrian`
--
ALTER TABLE `antrian`
  ADD CONSTRAINT `antrian_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `datapasien` (`id`),
  ADD CONSTRAINT `antrian_jadwalpoliklinik_id_foreign` FOREIGN KEY (`jadwalpoliklinik_id`) REFERENCES `jadwalpoliklinik` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `antrian_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `datapasien`
--
ALTER TABLE `datapasien`
  ADD CONSTRAINT `datapasien_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `dokter_poliklinik_id_foreign` FOREIGN KEY (`poliklinik_id`) REFERENCES `poliklinik` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jadwalpoliklinik`
--
ALTER TABLE `jadwalpoliklinik`
  ADD CONSTRAINT `jadwalpoliklinik_dokter_id_foreign` FOREIGN KEY (`dokter_id`) REFERENCES `dokter` (`id`),
  ADD CONSTRAINT `jadwalpoliklinik_poliklinik_id_foreign` FOREIGN KEY (`poliklinik_id`) REFERENCES `poliklinik` (`id`);

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `datapasien` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftaran_jadwalpoliklinik_id_foreign` FOREIGN KEY (`jadwalpoliklinik_id`) REFERENCES `jadwalpoliklinik` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_antrian_id_foreign` FOREIGN KEY (`antrian_id`) REFERENCES `antrian` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ratings_dokter_id_foreign` FOREIGN KEY (`dokter_id`) REFERENCES `dokter` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `riwayat_kunjungan`
--
ALTER TABLE `riwayat_kunjungan`
  ADD CONSTRAINT `riwayat_kunjungan_antrian_id_foreign` FOREIGN KEY (`antrian_id`) REFERENCES `antrian` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `riwayat_kunjungan_dokter_id_foreign` FOREIGN KEY (`dokter_id`) REFERENCES `dokter` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `riwayat_kunjungan_pasien_id_foreign` FOREIGN KEY (`pasien_id`) REFERENCES `datapasien` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `riwayat_kunjungan_poliklinik_id_foreign` FOREIGN KEY (`poliklinik_id`) REFERENCES `poliklinik` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
