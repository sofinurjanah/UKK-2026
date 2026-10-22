-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Okt 2026 pada 06.14
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
-- Database: `db_ukk_2026`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_guru`
--

CREATE TABLE `t_guru` (
  `id` int(11) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `email` varchar(150) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_guru`
--

INSERT INTO `t_guru` (`id`, `nip`, `nama`, `email`, `status_aktif`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'NIP20260001', 'Guru Matematika', 'guru01@ukk2026.test', 1, 1, '2026-01-01 01:00:00', '2026-01-01 01:00:00'),
(2, 'NIP20260002', 'Guru Bahasa Indonesia', 'guru02@ukk2026.test', 1, 2, '2026-02-02 01:00:00', '2026-02-02 01:00:00'),
(3, 'NIP20260003', 'Guru Bahasa Inggris', 'guru03@ukk2026.test', 1, 3, '2026-03-03 01:00:00', '2026-03-03 01:00:00'),
(4, 'NIP20260004', 'Guru Pendidikan Pancasila', 'guru04@ukk2026.test', 1, 4, '2026-04-04 01:00:00', '2026-04-04 01:00:00'),
(5, 'NIP20260005', 'Guru Pendidikan Agama', 'guru05@ukk2026.test', 1, 5, '2026-05-05 01:00:00', '2026-05-05 01:00:00'),
(6, 'NIP20260006', 'Guru PJOK', 'guru06@ukk2026.test', 1, 6, '2026-06-06 01:00:00', '2026-06-06 01:00:00'),
(7, 'NIP20260007', 'Guru Sejarah', 'guru07@ukk2026.test', 1, 7, '2026-07-07 01:00:00', '2026-07-07 01:00:00'),
(8, 'NIP20260008', 'Guru Seni Budaya', 'guru08@ukk2026.test', 1, 8, '2026-08-08 01:00:00', '2026-08-08 01:00:00'),
(9, 'NIP20260009', 'Guru Informatika', 'guru09@ukk2026.test', 1, 9, '2026-09-09 01:00:00', '2026-09-09 01:00:00'),
(10, 'NIP20260010', 'Guru BK', 'guru10@ukk2026.test', 1, 10, '2026-10-10 01:00:00', '2026-10-10 01:00:00'),
(11, 'NIP20260011', 'Guru Produktif RPL', 'guru11@ukk2026.test', 1, 11, '2026-11-11 01:00:00', '2026-11-11 01:00:00'),
(12, 'NIP20260012', 'Guru Pemrograman Web', 'guru12@ukk2026.test', 1, 12, '2026-12-12 01:00:00', '2026-12-12 01:00:00'),
(13, 'NIP20260013', 'Guru Basis Data', 'guru13@ukk2026.test', 1, 13, '2026-01-13 01:00:00', '2026-01-13 01:00:00'),
(14, 'NIP20260014', 'Guru Pemrograman Dasar', 'guru14@ukk2026.test', 1, 14, '2026-02-14 01:00:00', '2026-02-14 01:00:00'),
(15, 'NIP20260015', 'Guru Jaringan Komputer', 'guru15@ukk2026.test', 1, 15, '2026-03-15 01:00:00', '2026-03-15 01:00:00'),
(16, 'NIP20260016', 'Guru Produktif TKJ', 'guru16@ukk2026.test', 1, 16, '2026-04-16 01:00:00', '2026-04-16 01:00:00'),
(17, 'NIP20260017', 'Guru Administrasi Jaringan', 'guru17@ukk2026.test', 1, 17, '2026-05-17 01:00:00', '2026-05-17 01:00:00'),
(18, 'NIP20260018', 'Guru Sistem Komputer', 'guru18@ukk2026.test', 1, 18, '2026-06-18 01:00:00', '2026-06-18 01:00:00'),
(19, 'NIP20260019', 'Guru Desain Grafis', 'guru19@ukk2026.test', 1, 19, '2026-07-19 01:00:00', '2026-07-19 01:00:00'),
(20, 'NIP20260020', 'Guru Produktif DKV', 'guru20@ukk2026.test', 1, 20, '2026-08-20 01:00:00', '2026-08-20 01:00:00'),
(21, 'NIP20260021', 'Guru Fotografi', 'guru21@ukk2026.test', 1, 21, '2026-09-21 01:00:00', '2026-09-21 01:00:00'),
(22, 'NIP20260022', 'Guru Desain Komunikasi Visual', 'guru22@ukk2026.test', 1, 22, '2026-10-22 01:00:00', '2026-10-22 01:00:00'),
(23, 'NIP20260023', 'Guru Akuntansi Dasar', 'guru23@ukk2026.test', 1, 23, '2026-11-23 01:00:00', '2026-11-23 01:00:00'),
(24, 'NIP20260024', 'Guru Produktif AKL', 'guru24@ukk2026.test', 1, 24, '2026-12-24 01:00:00', '2026-12-24 01:00:00'),
(25, 'NIP20260025', 'Guru Perpajakan', 'guru25@ukk2026.test', 1, 25, '2026-01-25 01:00:00', '2026-01-25 01:00:00'),
(26, 'NIP20260026', 'Guru Komputer Akuntansi', 'guru26@ukk2026.test', 1, 26, '2026-02-26 01:00:00', '2026-02-26 01:00:00'),
(27, 'NIP20260027', 'Guru Produktif MPLB', 'guru27@ukk2026.test', 1, 27, '2026-03-27 01:00:00', '2026-03-27 01:00:00'),
(28, 'NIP20260028', 'Guru Administrasi Umum', 'guru28@ukk2026.test', 1, 28, '2026-04-28 01:00:00', '2026-04-28 01:00:00'),
(29, 'NIP20260029', 'Guru Korespondensi', 'guru29@ukk2026.test', 1, 29, '2026-05-01 01:00:00', '2026-05-01 01:00:00'),
(30, 'NIP20260030', 'Guru Kearsipan', 'guru30@ukk2026.test', 1, 30, '2026-06-02 01:00:00', '2026-06-02 01:00:00'),
(31, 'NIP20260031', 'Guru Ekonomi', 'guru31@ukk2026.test', 1, 31, '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(32, 'NIP20260032', 'Guru Bahasa Sunda', 'guru32@ukk2026.test', 1, 32, '2026-08-04 01:00:00', '2026-08-04 01:00:00'),
(33, 'NIP20260033', 'Guru Pendidikan Kewarganegaraa', 'guru33@ukk2026.test', 1, 33, '2026-09-05 01:00:00', '2026-09-05 01:00:00'),
(34, 'NIP20260034', 'Guru Projek Kreatif', 'guru34@ukk2026.test', 1, 34, '2026-10-06 01:00:00', '2026-10-06 01:00:00'),
(35, 'NIP20260035', 'Guru Kewirausahaan', 'guru35@ukk2026.test', 1, 35, '2026-11-07 01:00:00', '2026-11-07 01:00:00'),
(36, 'NIP20260036', 'Guru Simulasi Digital', 'guru36@ukk2026.test', 1, 36, '2026-12-08 01:00:00', '2026-12-08 01:00:00'),
(37, 'NIP20260037', 'Guru Matematika Terapan', 'guru37@ukk2026.test', 1, 37, '2026-01-09 01:00:00', '2026-01-09 01:00:00'),
(38, 'NIP20260038', 'Guru Bahasa Inggris Kejuruan', 'guru38@ukk2026.test', 1, 38, '2026-02-10 01:00:00', '2026-02-10 01:00:00'),
(39, 'NIP20260039', 'Guru Produk Kreatif RPL', 'guru39@ukk2026.test', 1, 39, '2026-03-11 01:00:00', '2026-03-11 01:00:00'),
(40, 'NIP20260040', 'Guru Produk Kreatif TKJ', 'guru40@ukk2026.test', 1, 40, '2026-04-12 01:00:00', '2026-04-12 01:00:00'),
(41, 'NIP20260041', 'Guru Produk Kreatif DKV', 'guru41@ukk2026.test', 1, 41, '2026-05-13 01:00:00', '2026-05-13 01:00:00'),
(42, 'NIP20260042', 'Guru Praktik Akuntansi', 'guru42@ukk2026.test', 1, 42, '2026-06-14 01:00:00', '2026-06-14 01:00:00'),
(43, 'NIP20260043', 'Guru Praktik Perkantoran', 'guru43@ukk2026.test', 1, 43, '2026-07-15 01:00:00', '2026-07-15 01:00:00'),
(44, 'NIP20260044', 'Guru Teknologi Informasi', 'guru44@ukk2026.test', 1, 44, '2026-08-16 01:00:00', '2026-08-16 01:00:00'),
(45, 'NIP20260045', 'Guru Keamanan Jaringan', 'guru45@ukk2026.test', 1, 45, '2026-09-17 01:00:00', '2026-09-17 01:00:00'),
(46, 'NIP20260046', 'Guru Ilustrasi Digital', 'guru46@ukk2026.test', 1, 46, '2026-10-18 01:00:00', '2026-10-18 01:00:00'),
(47, 'NIP20260047', 'Guru Pengolahan Data', 'guru47@ukk2026.test', 1, 47, '2026-11-19 01:00:00', '2026-11-19 01:00:00'),
(48, 'NIP20260048', 'Guru Administrasi Pajak', 'guru48@ukk2026.test', 1, 48, '2026-12-20 01:00:00', '2026-12-20 01:00:00'),
(49, 'NIP20260049', 'Guru Komunikasi Bisnis', 'guru49@ukk2026.test', 1, 49, '2026-01-21 01:00:00', '2026-01-21 01:00:00'),
(50, 'NIP20260050', 'Guru Muatan Lokal', 'guru50@ukk2026.test', 1, 50, '2026-02-22 01:00:00', '2026-02-22 01:00:00'),
(52, 'NIP20260051', 'Guru Ilmu Pengetahuan Alam', 'guru51@ukk2026.test', 1, 52, '2026-10-22 00:45:15', '2026-10-22 00:45:15'),
(53, '47856745', 'Guru Matematika', 'gasfa7ye@gmail.com', 1, 53, '2026-10-22 01:00:17', '2026-10-22 01:00:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kelas`
--

CREATE TABLE `t_kelas` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tingkat` varchar(20) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_kelas`
--

INSERT INTO `t_kelas` (`id`, `nama`, `tingkat`, `jurusan`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'X RPL 1', 'X', 'RPL', 1, '2026-01-01 01:00:00', '2026-01-01 01:00:00'),
(2, 'XI TKJ 1', 'XI', 'TKJ', 1, '2026-02-02 01:00:00', '2026-02-02 01:00:00'),
(3, 'XII DKV 1', 'XII', 'DKV', 1, '2026-03-03 01:00:00', '2026-03-03 01:00:00'),
(4, 'X AKL 1', 'X', 'AKL', 1, '2026-04-04 01:00:00', '2026-04-04 01:00:00'),
(5, 'XI MPLB 1', 'XI', 'MPLB', 1, '2026-05-05 01:00:00', '2026-05-05 01:00:00'),
(6, 'XII RPL 1', 'XII', 'RPL', 1, '2026-06-06 01:00:00', '2026-06-06 01:00:00'),
(7, 'X TKJ 1', 'X', 'TKJ', 1, '2026-07-07 01:00:00', '2026-07-07 01:00:00'),
(8, 'XI DKV 1', 'XI', 'DKV', 1, '2026-08-08 01:00:00', '2026-08-08 01:00:00'),
(9, 'XII AKL 1', 'XII', 'AKL', 1, '2026-09-09 01:00:00', '2026-09-09 01:00:00'),
(10, 'X MPLB 1', 'X', 'MPLB', 1, '2026-10-10 01:00:00', '2026-10-10 01:00:00'),
(11, 'XI RPL 1', 'XI', 'RPL', 1, '2026-11-11 01:00:00', '2026-11-11 01:00:00'),
(12, 'XII TKJ 1', 'XII', 'TKJ', 1, '2026-12-12 01:00:00', '2026-12-12 01:00:00'),
(13, 'X DKV 1', 'X', 'DKV', 1, '2026-01-13 01:00:00', '2026-01-13 01:00:00'),
(14, 'XI AKL 1', 'XI', 'AKL', 1, '2026-02-14 01:00:00', '2026-02-14 01:00:00'),
(15, 'XII MPLB 1', 'XII', 'MPLB', 1, '2026-03-15 01:00:00', '2026-03-15 01:00:00'),
(16, 'X RPL 2', 'X', 'RPL', 1, '2026-04-16 01:00:00', '2026-04-16 01:00:00'),
(17, 'XI TKJ 2', 'XI', 'TKJ', 1, '2026-05-17 01:00:00', '2026-05-17 01:00:00'),
(18, 'XII DKV 2', 'XII', 'DKV', 1, '2026-06-18 01:00:00', '2026-06-18 01:00:00'),
(19, 'X AKL 2', 'X', 'AKL', 1, '2026-07-19 01:00:00', '2026-07-19 01:00:00'),
(20, 'XI MPLB 2', 'XI', 'MPLB', 1, '2026-08-20 01:00:00', '2026-08-20 01:00:00'),
(21, 'XII RPL 2', 'XII', 'RPL', 1, '2026-09-21 01:00:00', '2026-09-21 01:00:00'),
(22, 'X TKJ 2', 'X', 'TKJ', 1, '2026-10-22 01:00:00', '2026-10-22 01:00:00'),
(23, 'XI DKV 2', 'XI', 'DKV', 1, '2026-11-23 01:00:00', '2026-11-23 01:00:00'),
(24, 'XII AKL 2', 'XII', 'AKL', 1, '2026-12-24 01:00:00', '2026-12-24 01:00:00'),
(25, 'X MPLB 2', 'X', 'MPLB', 1, '2026-01-25 01:00:00', '2026-01-25 01:00:00'),
(26, 'XI RPL 2', 'XI', 'RPL', 1, '2026-02-26 01:00:00', '2026-02-26 01:00:00'),
(27, 'XII TKJ 2', 'XII', 'TKJ', 1, '2026-03-27 01:00:00', '2026-03-27 01:00:00'),
(28, 'X DKV 2', 'X', 'DKV', 1, '2026-04-28 01:00:00', '2026-04-28 01:00:00'),
(29, 'XI AKL 2', 'XI', 'AKL', 1, '2026-05-01 01:00:00', '2026-05-01 01:00:00'),
(30, 'XII MPLB 2', 'XII', 'MPLB', 1, '2026-06-02 01:00:00', '2026-06-02 01:00:00'),
(31, 'X RPL 3', 'X', 'RPL', 1, '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(32, 'XI TKJ 3', 'XI', 'TKJ', 1, '2026-08-04 01:00:00', '2026-08-04 01:00:00'),
(33, 'XII DKV 3', 'XII', 'DKV', 1, '2026-09-05 01:00:00', '2026-09-05 01:00:00'),
(34, 'X AKL 3', 'X', 'AKL', 1, '2026-10-06 01:00:00', '2026-10-06 01:00:00'),
(35, 'XI MPLB 3', 'XI', 'MPLB', 1, '2026-11-07 01:00:00', '2026-11-07 01:00:00'),
(36, 'XII RPL 3', 'XII', 'RPL', 1, '2026-12-08 01:00:00', '2026-12-08 01:00:00'),
(37, 'X TKJ 3', 'X', 'TKJ', 1, '2026-01-09 01:00:00', '2026-01-09 01:00:00'),
(38, 'XI DKV 3', 'XI', 'DKV', 1, '2026-02-10 01:00:00', '2026-02-10 01:00:00'),
(39, 'XII AKL 3', 'XII', 'AKL', 1, '2026-03-11 01:00:00', '2026-03-11 01:00:00'),
(40, 'X MPLB 3', 'X', 'MPLB', 1, '2026-04-12 01:00:00', '2026-04-12 01:00:00'),
(41, 'XI RPL 3', 'XI', 'RPL', 1, '2026-05-13 01:00:00', '2026-05-13 01:00:00'),
(42, 'XII TKJ 3', 'XII', 'TKJ', 1, '2026-06-14 01:00:00', '2026-06-14 01:00:00'),
(43, 'X DKV 3', 'X', 'DKV', 1, '2026-07-15 01:00:00', '2026-07-15 01:00:00'),
(44, 'XI AKL 3', 'XI', 'AKL', 1, '2026-08-16 01:00:00', '2026-08-16 01:00:00'),
(45, 'XII MPLB 3', 'XII', 'MPLB', 1, '2026-09-17 01:00:00', '2026-09-17 01:00:00'),
(46, 'X RPL 4', 'X', 'RPL', 1, '2026-10-18 01:00:00', '2026-10-18 01:00:00'),
(47, 'XI TKJ 4', 'XI', 'TKJ', 1, '2026-11-19 01:00:00', '2026-11-19 01:00:00'),
(48, 'XII DKV 4', 'XII', 'DKV', 1, '2026-12-20 01:00:00', '2026-12-20 01:00:00'),
(49, 'X AKL 4', 'X', 'AKL', 1, '2026-01-21 01:00:00', '2026-01-21 01:00:00'),
(50, 'XI MPLB 4', 'XI', 'MPLB', 1, '2026-02-22 01:00:00', '2026-02-22 01:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kelas_siswa`
--

CREATE TABLE `t_kelas_siswa` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_kelas_siswa`
--

INSERT INTO `t_kelas_siswa` (`id`, `siswa_id`, `tahun_ajaran_id`, `kelas_id`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '1977-07-01', '1978-06-30', 1, '2026-01-01 01:00:00', '2026-01-01 01:00:00'),
(2, 2, 1, 2, '1977-07-01', '1978-06-30', 1, '2026-01-02 01:00:00', '2026-01-02 01:00:00'),
(3, 3, 1, 3, '1977-07-01', '1978-06-30', 1, '2026-01-03 01:00:00', '2026-01-03 01:00:00'),
(4, 4, 1, 4, '1977-07-01', '1978-06-30', 1, '2026-01-04 01:00:00', '2026-01-04 01:00:00'),
(5, 5, 1, 5, '1977-07-01', '1978-06-30', 1, '2026-01-05 01:00:00', '2026-01-05 01:00:00'),
(6, 6, 1, 6, '1977-07-01', '1978-06-30', 1, '2026-01-06 01:00:00', '2026-01-06 01:00:00'),
(7, 7, 1, 7, '1977-07-01', '1978-06-30', 1, '2026-01-07 01:00:00', '2026-01-07 01:00:00'),
(8, 8, 1, 8, '1977-07-01', '1978-06-30', 1, '2026-01-08 01:00:00', '2026-01-08 01:00:00'),
(9, 9, 1, 9, '1977-07-01', '1978-06-30', 1, '2026-01-09 01:00:00', '2026-01-09 01:00:00'),
(10, 10, 1, 10, '1977-07-01', '1978-06-30', 1, '2026-01-10 01:00:00', '2026-01-10 01:00:00'),
(11, 11, 2, 1, '1978-07-01', '1979-06-30', 1, '2026-01-11 01:00:00', '2026-01-11 01:00:00'),
(12, 12, 2, 2, '1978-07-01', '1979-06-30', 1, '2026-01-12 01:00:00', '2026-01-12 01:00:00'),
(13, 13, 2, 3, '1978-07-01', '1979-06-30', 1, '2026-01-13 01:00:00', '2026-01-13 01:00:00'),
(14, 14, 2, 4, '1978-07-01', '1979-06-30', 1, '2026-01-14 01:00:00', '2026-01-14 01:00:00'),
(15, 15, 2, 5, '1978-07-01', '1979-06-30', 1, '2026-01-15 01:00:00', '2026-01-15 01:00:00'),
(16, 16, 2, 6, '1978-07-01', '1979-06-30', 1, '2026-01-16 01:00:00', '2026-01-16 01:00:00'),
(17, 17, 2, 7, '1978-07-01', '1979-06-30', 1, '2026-01-17 01:00:00', '2026-01-17 01:00:00'),
(18, 18, 2, 8, '1978-07-01', '1979-06-30', 1, '2026-01-18 01:00:00', '2026-01-18 01:00:00'),
(19, 19, 2, 9, '1978-07-01', '1979-06-30', 1, '2026-01-19 01:00:00', '2026-01-19 01:00:00'),
(20, 20, 2, 10, '1978-07-01', '1979-06-30', 1, '2026-01-20 01:00:00', '2026-01-20 01:00:00'),
(21, 21, 3, 1, '1979-07-01', '1980-06-30', 1, '2026-01-21 01:00:00', '2026-01-21 01:00:00'),
(22, 22, 3, 2, '1979-07-01', '1980-06-30', 1, '2026-01-22 01:00:00', '2026-01-22 01:00:00'),
(23, 23, 3, 3, '1979-07-01', '1980-06-30', 1, '2026-01-23 01:00:00', '2026-01-23 01:00:00'),
(24, 24, 3, 4, '1979-07-01', '1980-06-30', 1, '2026-01-24 01:00:00', '2026-01-24 01:00:00'),
(25, 25, 3, 5, '1979-07-01', '1980-06-30', 1, '2026-01-25 01:00:00', '2026-01-25 01:00:00'),
(26, 26, 3, 6, '1979-07-01', '1980-06-30', 1, '2026-01-26 01:00:00', '2026-01-26 01:00:00'),
(27, 27, 3, 7, '1979-07-01', '1980-06-30', 1, '2026-01-27 01:00:00', '2026-01-27 01:00:00'),
(28, 28, 3, 8, '1979-07-01', '1980-06-30', 1, '2026-01-28 01:00:00', '2026-01-28 01:00:00'),
(29, 29, 3, 9, '1979-07-01', '1980-06-30', 1, '2026-01-01 01:00:00', '2026-01-01 01:00:00'),
(30, 30, 3, 10, '1979-07-01', '1980-06-30', 1, '2026-01-02 01:00:00', '2026-01-02 01:00:00'),
(31, 31, 4, 1, '1980-07-01', '1981-06-30', 1, '2026-01-03 01:00:00', '2026-01-03 01:00:00'),
(32, 32, 4, 2, '1980-07-01', '1981-06-30', 1, '2026-01-04 01:00:00', '2026-01-04 01:00:00'),
(33, 33, 4, 3, '1980-07-01', '1981-06-30', 1, '2026-01-05 01:00:00', '2026-01-05 01:00:00'),
(34, 34, 4, 4, '1980-07-01', '1981-06-30', 1, '2026-01-06 01:00:00', '2026-01-06 01:00:00'),
(35, 35, 4, 5, '1980-07-01', '1981-06-30', 1, '2026-01-07 01:00:00', '2026-01-07 01:00:00'),
(36, 36, 4, 6, '1980-07-01', '1981-06-30', 1, '2026-01-08 01:00:00', '2026-01-08 01:00:00'),
(37, 37, 4, 7, '1980-07-01', '1981-06-30', 1, '2026-01-09 01:00:00', '2026-01-09 01:00:00'),
(38, 38, 4, 8, '1980-07-01', '1981-06-30', 1, '2026-01-10 01:00:00', '2026-01-10 01:00:00'),
(39, 39, 4, 9, '1980-07-01', '1981-06-30', 1, '2026-01-11 01:00:00', '2026-01-11 01:00:00'),
(40, 40, 4, 10, '1980-07-01', '1981-06-30', 1, '2026-01-12 01:00:00', '2026-01-12 01:00:00'),
(41, 41, 5, 1, '1981-07-01', '1982-06-30', 1, '2026-01-13 01:00:00', '2026-01-13 01:00:00'),
(42, 42, 5, 2, '1981-07-01', '1982-06-30', 1, '2026-01-14 01:00:00', '2026-01-14 01:00:00'),
(43, 43, 5, 3, '1981-07-01', '1982-06-30', 1, '2026-01-15 01:00:00', '2026-01-15 01:00:00'),
(44, 44, 5, 4, '1981-07-01', '1982-06-30', 1, '2026-01-16 01:00:00', '2026-01-16 01:00:00'),
(45, 45, 5, 5, '1981-07-01', '1982-06-30', 1, '2026-01-17 01:00:00', '2026-01-17 01:00:00'),
(46, 46, 5, 6, '1981-07-01', '1982-06-30', 1, '2026-01-18 01:00:00', '2026-01-18 01:00:00'),
(47, 47, 5, 7, '1981-07-01', '1982-06-30', 1, '2026-01-19 01:00:00', '2026-01-19 01:00:00'),
(48, 48, 5, 8, '1981-07-01', '1982-06-30', 1, '2026-01-20 01:00:00', '2026-01-20 01:00:00'),
(49, 49, 5, 9, '1981-07-01', '1982-06-30', 1, '2026-01-21 01:00:00', '2026-01-21 01:00:00'),
(50, 50, 5, 10, '1981-07-01', '1982-06-30', 1, '2026-01-22 01:00:00', '2026-01-22 01:00:00'),
(51, 52, 50, 21, '2024-07-01', '2027-05-01', 1, '2026-10-01 00:46:58', '2026-10-01 00:46:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pelanggaran`
--

CREATE TABLE `t_pelanggaran` (
  `id` int(11) NOT NULL,
  `pelanggaran_kategori_id` int(11) NOT NULL,
  `kode` varchar(30) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `poin` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_pelanggaran`
--

INSERT INTO `t_pelanggaran` (`id`, `pelanggaran_kategori_id`, `kode`, `nama`, `poin`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 'PLG001', 'Terlambat Masuk Sekolah', 1, 'Siswa datang melewati waktu masuk sekolah yang telah ditentukan.', 1, '2026-01-01 01:00:00', '2026-10-21 02:22:21'),
(2, 2, 'PLG002', 'Tidak Memakai Seragam Sesuai Aturan', 2, 'Siswa mengenakan seragam yang tidak sesuai dengan ketentuan sekolah.', 1, '2026-02-02 01:00:00', '2026-10-21 02:22:21'),
(3, 3, 'PLG003', 'Tidak Hadir Tanpa Keterangan', 3, 'Siswa tidak hadir di sekolah tanpa keterangan yang sah.', 1, '2026-03-03 01:00:00', '2026-10-21 02:22:21'),
(4, 4, 'PLG004', 'Rambut Tidak Sesuai Aturan', 4, 'Penampilan rambut siswa tidak sesuai dengan tata tertib sekolah.', 1, '2026-04-04 01:00:00', '2026-10-21 02:22:21'),
(5, 5, 'PLG005', 'Tidak Mengerjakan Tugas', 5, 'Siswa tidak mengerjakan tugas yang diberikan oleh guru.', 1, '2026-05-05 01:00:00', '2026-10-21 02:22:21'),
(6, 6, 'PLG006', 'Keluar Kelas Tanpa Izin', 1, 'Siswa meninggalkan ruang kelas tanpa izin dari guru.', 1, '2026-06-06 01:00:00', '2026-10-21 02:22:21'),
(7, 7, 'PLG007', 'Tidak Memakai Atribut Sekolah', 2, 'Siswa tidak menggunakan atribut sekolah yang diwajibkan.', 1, '2026-07-07 01:00:00', '2026-10-21 02:22:21'),
(8, 8, 'PLG008', 'Terlambat Masuk Kelas', 3, 'Siswa terlambat memasuki ruang kelas setelah pelajaran dimulai.', 1, '2026-08-08 01:00:00', '2026-10-21 02:22:21'),
(9, 9, 'PLG009', 'Memakai Sepatu Tidak Sesuai Aturan', 4, 'Siswa memakai sepatu yang tidak sesuai dengan ketentuan sekolah.', 1, '2026-09-09 01:00:00', '2026-10-21 02:22:21'),
(10, 10, 'PLG010', 'Menyontek Saat Ujian', 5, 'Siswa melakukan tindakan menyontek selama pelaksanaan ujian.', 1, '2026-10-10 01:00:00', '2026-10-21 02:22:21'),
(11, 11, 'PLG011', 'Membolos Saat Jam Pelajaran', 1, 'Siswa meninggalkan pelajaran tanpa izin atau alasan yang dapat diterima.', 1, '2026-11-11 01:00:00', '2026-10-21 02:22:21'),
(12, 12, 'PLG012', 'Tidak Mengikuti Upacara', 2, 'Siswa tidak mengikuti upacara tanpa keterangan yang jelas.', 1, '2026-12-12 01:00:00', '2026-10-21 02:22:21'),
(13, 13, 'PLG013', 'Tidak Membawa Perlengkapan Belajar', 3, 'Siswa tidak membawa alat atau perlengkapan belajar yang diperlukan.', 1, '2026-01-13 01:00:00', '2026-10-21 02:22:21'),
(14, 14, 'PLG014', 'Membuang Sampah Sembarangan', 4, 'Siswa membuang sampah tidak pada tempat yang disediakan.', 1, '2026-02-14 01:00:00', '2026-10-21 02:22:21'),
(15, 15, 'PLG015', 'Berkelahi dengan Teman', 5, 'Siswa terlibat perkelahian dengan siswa lain.', 1, '2026-03-15 01:00:00', '2026-10-21 02:22:21'),
(16, 16, 'PLG016', 'Berkata Tidak Sopan', 1, 'Siswa menggunakan perkataan yang tidak sopan di lingkungan sekolah.', 1, '2026-04-16 01:00:00', '2026-10-21 02:22:21'),
(17, 17, 'PLG017', 'Mengganggu Teman Saat Belajar', 2, 'Siswa mengganggu teman sehingga kegiatan belajar terganggu.', 1, '2026-05-17 01:00:00', '2026-10-21 02:22:21'),
(18, 18, 'PLG018', 'Tidak Melaksanakan Piket Kelas', 3, 'Siswa tidak menjalankan tugas piket kelas sesuai jadwal.', 1, '2026-06-18 01:00:00', '2026-10-21 02:22:21'),
(19, 19, 'PLG019', 'Merusak Fasilitas Sekolah', 4, 'Siswa merusak atau menggunakan fasilitas sekolah secara tidak semestinya.', 1, '2026-07-19 01:00:00', '2026-10-21 02:22:21'),
(20, 20, 'PLG020', 'Tidak Mengumpulkan Tugas', 5, 'Siswa tidak menyerahkan tugas sesuai batas waktu yang ditentukan.', 1, '2026-08-20 01:00:00', '2026-10-21 02:22:21'),
(21, 21, 'PLG021', 'Menggunakan HP Saat Pelajaran', 1, 'Siswa menggunakan telepon genggam tanpa izin saat pembelajaran.', 1, '2026-09-21 01:00:00', '2026-10-21 02:22:21'),
(22, 22, 'PLG022', 'Tidur Saat Pelajaran', 2, 'Siswa tidur saat kegiatan belajar mengajar berlangsung.', 1, '2026-10-22 01:00:00', '2026-10-21 02:22:21'),
(23, 23, 'PLG023', 'Tidak Mengikuti Kegiatan Sekolah', 3, 'Siswa tidak mengikuti kegiatan resmi sekolah tanpa alasan yang sah.', 1, '2026-11-23 01:00:00', '2026-10-21 02:22:21'),
(24, 24, 'PLG024', 'Memakai Seragam Tidak Rapi', 4, 'Siswa mengenakan seragam yang tidak rapi atau tidak sesuai ketentuan.', 1, '2026-12-24 01:00:00', '2026-10-21 02:22:21'),
(25, 25, 'PLG025', 'Meninggalkan Sekolah Tanpa Izin', 5, 'Siswa meninggalkan lingkungan sekolah tanpa izin dari pihak berwenang.', 1, '2026-01-25 01:00:00', '2026-10-21 02:22:21'),
(26, 26, 'PLG026', 'Tidak Membawa Buku Pelajaran', 1, 'Siswa tidak membawa buku yang diperlukan untuk mengikuti pelajaran.', 1, '2026-02-26 01:00:00', '2026-10-21 02:22:21'),
(27, 27, 'PLG027', 'Mencontek Pekerjaan Teman', 2, 'Siswa menyalin jawaban atau pekerjaan milik siswa lain.', 1, '2026-03-27 01:00:00', '2026-10-21 02:22:21'),
(28, 28, 'PLG028', 'Tidak Mematuhi Tata Tertib', 3, 'Siswa melakukan tindakan yang bertentangan dengan tata tertib sekolah.', 1, '2026-04-28 01:00:00', '2026-10-21 02:22:21'),
(29, 29, 'PLG029', 'Membuat Keributan di Kelas', 4, 'Siswa membuat keributan yang mengganggu proses pembelajaran.', 1, '2026-05-01 01:00:00', '2026-10-21 02:22:21'),
(30, 30, 'PLG030', 'Tidak Menghormati Guru', 5, 'Siswa menunjukkan perilaku yang tidak menghormati guru.', 1, '2026-06-02 01:00:00', '2026-10-21 02:22:21'),
(31, 31, 'PLG031', 'Terlambat Kembali dari Istirahat', 1, 'Siswa terlambat kembali ke kelas setelah waktu istirahat berakhir.', 1, '2026-07-03 01:00:00', '2026-10-21 02:22:21'),
(32, 32, 'PLG032', 'Tidak Memakai Ikat Pinggang', 2, 'Siswa tidak menggunakan ikat pinggang sesuai ketentuan seragam.', 1, '2026-08-04 01:00:00', '2026-10-21 02:22:21'),
(33, 33, 'PLG033', 'Memakai Aksesori Terlarang', 3, 'Siswa memakai aksesori yang tidak diperbolehkan oleh sekolah.', 1, '2026-09-05 01:00:00', '2026-10-21 02:22:21'),
(34, 34, 'PLG034', 'Mencoret Meja atau Dinding', 4, 'Siswa mencoret meja, kursi, dinding, atau fasilitas sekolah lainnya.', 1, '2026-10-06 01:00:00', '2026-10-21 02:22:21'),
(35, 35, 'PLG035', 'Tidak Menjaga Kebersihan Kelas', 5, 'Siswa tidak menjaga kebersihan ruang kelas dan lingkungan sekitarnya.', 1, '2026-11-07 01:00:00', '2026-10-21 02:22:21'),
(36, 36, 'PLG036', 'Tidak Membawa Kartu Pelajar', 1, 'Siswa tidak membawa kartu pelajar saat diwajibkan.', 1, '2026-12-08 01:00:00', '2026-10-21 02:22:21'),
(37, 37, 'PLG037', 'Tidak Mengikuti Pelajaran Praktik', 2, 'Siswa tidak mengikuti kegiatan praktik tanpa alasan yang sah.', 1, '2026-01-09 01:00:00', '2026-10-21 02:22:21'),
(38, 38, 'PLG038', 'Tidak Memakai Perlengkapan Praktik', 3, 'Siswa tidak menggunakan perlengkapan keselamatan atau praktik yang diwajibkan.', 1, '2026-02-10 01:00:00', '2026-10-21 02:22:21'),
(39, 39, 'PLG039', 'Menyalahgunakan Fasilitas Laboratorium', 4, 'Siswa menggunakan fasilitas laboratorium tidak sesuai prosedur.', 1, '2026-03-11 01:00:00', '2026-10-21 02:22:21'),
(40, 40, 'PLG040', 'Tidak Mematuhi Aturan Perpustakaan', 5, 'Siswa tidak mematuhi ketentuan penggunaan perpustakaan.', 1, '2026-04-12 01:00:00', '2026-10-21 02:22:21'),
(41, 41, 'PLG041', 'Berisik Saat Kegiatan Belajar', 1, 'Siswa berbicara atau membuat suara gaduh saat pembelajaran berlangsung.', 1, '2026-05-13 01:00:00', '2026-10-21 02:22:21'),
(42, 42, 'PLG042', 'Tidak Mengikuti Kerja Bakti', 2, 'Siswa tidak mengikuti kegiatan kerja bakti yang telah dijadwalkan.', 1, '2026-06-14 01:00:00', '2026-10-21 02:22:21'),
(43, 43, 'PLG043', 'Memalsukan Tanda Tangan', 3, 'Siswa memalsukan tanda tangan pada dokumen sekolah.', 1, '2026-07-15 01:00:00', '2026-10-21 02:22:21'),
(44, 44, 'PLG044', 'Membawa Barang yang Dilarang', 4, 'Siswa membawa barang yang dilarang oleh peraturan sekolah.', 1, '2026-08-16 01:00:00', '2026-10-21 02:22:21'),
(45, 45, 'PLG045', 'Mengambil Barang Milik Teman', 5, 'Siswa mengambil barang milik orang lain tanpa izin.', 1, '2026-09-17 01:00:00', '2026-10-21 02:22:21'),
(46, 46, 'PLG046', 'Tidak Mengikuti Ujian Tanpa Alasan', 1, 'Siswa tidak mengikuti ujian tanpa keterangan yang dapat diterima.', 1, '2026-10-18 01:00:00', '2026-10-21 02:22:21'),
(47, 47, 'PLG047', 'Tidak Menyelesaikan Tugas Kelompok', 2, 'Siswa tidak menjalankan bagian tugas kelompok yang menjadi tanggung jawabnya.', 1, '2026-11-19 01:00:00', '2026-10-21 02:22:21'),
(48, 48, 'PLG048', 'Menggunakan Seragam Olahraga Tidak Sesuai', 3, 'Siswa memakai seragam olahraga yang tidak sesuai ketentuan.', 1, '2026-12-20 01:00:00', '2026-10-21 02:22:21'),
(49, 49, 'PLG049', 'Tidak Menjaga Ketertiban Sekolah', 4, 'Siswa melakukan tindakan yang mengganggu ketertiban lingkungan sekolah.', 1, '2026-01-21 01:00:00', '2026-10-21 02:22:21'),
(50, 50, 'PLG050', 'Mengulangi Pelanggaran yang Sama', 5, 'Siswa kembali melakukan pelanggaran yang sebelumnya telah dicatat.', 1, '2026-02-22 01:00:00', '2026-10-21 02:22:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pelanggaran_kategori`
--

CREATE TABLE `t_pelanggaran_kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_pelanggaran_kategori`
--

INSERT INTO `t_pelanggaran_kategori` (`id`, `nama`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Kedisiplinan Waktu', 'Kategori untuk pelanggaran terkait ketepatan waktu datang dan mengikuti kegiatan sekolah.', 1, '2026-01-01 01:00:00', '2026-10-21 02:25:07'),
(2, 'Seragam dan Atribut', 'Kategori untuk ketidakpatuhan terhadap ketentuan seragam dan atribut sekolah.', 1, '2026-02-02 01:00:00', '2026-10-21 02:25:07'),
(3, 'Kehadiran Siswa', 'Kategori untuk ketidakhadiran atau ketidakpatuhan terhadap aturan kehadiran.', 1, '2026-03-03 01:00:00', '2026-10-21 02:25:07'),
(4, 'Etika dan Sikap', 'Kategori untuk perilaku dan sikap yang tidak sesuai dengan tata tertib.', 1, '2026-04-04 01:00:00', '2026-10-21 02:25:07'),
(5, 'Akademik', 'Kategori untuk pelanggaran kewajiban dan aturan akademik.', 1, '2026-05-05 01:00:00', '2026-10-21 02:25:07'),
(6, 'Ketertiban Kelas', 'Kategori untuk tindakan yang mengganggu ketertiban selama pembelajaran.', 1, '2026-06-06 01:00:00', '2026-10-21 02:25:07'),
(7, 'Kerapian Diri', 'Kategori untuk penampilan diri yang tidak sesuai aturan sekolah.', 1, '2026-07-07 01:00:00', '2026-10-21 02:25:07'),
(8, 'Kebersihan Lingkungan', 'Kategori untuk tindakan yang mengganggu kebersihan lingkungan sekolah.', 1, '2026-08-08 01:00:00', '2026-10-21 02:25:07'),
(9, 'Tanggung Jawab', 'Kategori untuk kelalaian dalam menjalankan kewajiban sebagai siswa.', 1, '2026-09-09 01:00:00', '2026-10-21 02:25:07'),
(10, 'Kejujuran', 'Kategori untuk tindakan tidak jujur dalam kegiatan sekolah.', 1, '2026-10-10 01:00:00', '2026-10-21 02:25:07'),
(11, 'Penggunaan Teknologi', 'Kategori untuk penggunaan perangkat teknologi yang melanggar aturan.', 1, '2026-11-11 01:00:00', '2026-10-21 02:25:07'),
(12, 'Perizinan Siswa', 'Kategori untuk pelanggaran prosedur izin keluar atau meninggalkan sekolah.', 1, '2026-12-12 01:00:00', '2026-10-21 02:25:07'),
(13, 'Kegiatan Sekolah', 'Kategori untuk ketidakpatuhan terhadap aturan kegiatan sekolah.', 1, '2026-01-13 01:00:00', '2026-10-21 02:25:07'),
(14, 'Perilaku Sosial', 'Kategori untuk perilaku yang merugikan atau mengganggu orang lain.', 1, '2026-02-14 01:00:00', '2026-10-21 02:25:07'),
(15, 'Penghormatan Guru', 'Kategori untuk perilaku yang tidak menghormati guru dan tenaga kependidikan.', 1, '2026-03-15 01:00:00', '2026-10-21 02:25:07'),
(16, 'Kedisiplinan Belajar', 'Kategori untuk ketidakdisiplinan selama proses belajar.', 1, '2026-04-16 01:00:00', '2026-10-21 02:25:07'),
(17, 'Kelengkapan Belajar', 'Kategori untuk tidak membawa perlengkapan belajar yang diwajibkan.', 1, '2026-05-17 01:00:00', '2026-10-21 02:25:07'),
(18, 'Tata Tertib Sekolah', 'Kategori untuk pelanggaran terhadap peraturan sekolah.', 1, '2026-06-18 01:00:00', '2026-10-21 02:25:07'),
(19, 'Keamanan Sekolah', 'Kategori untuk tindakan yang membahayakan keamanan lingkungan sekolah.', 1, '2026-07-19 01:00:00', '2026-10-21 02:25:07'),
(20, 'Pemeliharaan Fasilitas', 'Kategori untuk tindakan yang merusak atau tidak menjaga fasilitas sekolah.', 1, '2026-08-20 01:00:00', '2026-10-21 02:25:07'),
(21, 'Ketertiban Ujian', 'Kategori untuk pelanggaran tata tertib selama pelaksanaan ujian.', 1, '2026-09-21 01:00:00', '2026-10-21 02:25:07'),
(22, 'Kejujuran Akademik', 'Kategori untuk tindakan menyontek atau melakukan kecurangan akademik.', 1, '2026-10-22 01:00:00', '2026-10-21 02:25:07'),
(23, 'Kegiatan Upacara', 'Kategori untuk ketidakpatuhan saat upacara dan kegiatan resmi sekolah.', 1, '2026-11-23 01:00:00', '2026-10-21 02:25:07'),
(24, 'Kegiatan Piket', 'Kategori untuk tidak menjalankan tugas piket sesuai jadwal.', 1, '2026-12-24 01:00:00', '2026-10-21 02:25:07'),
(25, 'Kegiatan Kerja Bakti', 'Kategori untuk ketidakpatuhan dalam kegiatan kebersihan bersama.', 1, '2026-01-25 01:00:00', '2026-10-21 02:25:07'),
(26, 'Kedisiplinan Praktik', 'Kategori untuk pelanggaran aturan pembelajaran praktik kejuruan.', 1, '2026-02-26 01:00:00', '2026-10-21 02:25:07'),
(27, 'Keselamatan Praktik', 'Kategori untuk tidak mematuhi prosedur keselamatan saat praktik.', 1, '2026-03-27 01:00:00', '2026-10-21 02:25:07'),
(28, 'Penggunaan Laboratorium', 'Kategori untuk penggunaan laboratorium yang tidak sesuai prosedur.', 1, '2026-04-28 01:00:00', '2026-10-21 02:25:07'),
(29, 'Penggunaan Perpustakaan', 'Kategori untuk pelanggaran aturan penggunaan perpustakaan.', 1, '2026-05-01 01:00:00', '2026-10-21 02:25:07'),
(30, 'Kerapian Seragam', 'Kategori untuk penggunaan seragam yang tidak rapi atau tidak sesuai ketentuan.', 1, '2026-06-02 01:00:00', '2026-10-21 02:25:07'),
(31, 'Atribut Sekolah', 'Kategori untuk ketidaklengkapan atribut yang diwajibkan sekolah.', 1, '2026-07-03 01:00:00', '2026-10-21 02:25:07'),
(32, 'Komunikasi Sopan', 'Kategori untuk penggunaan bahasa atau komunikasi yang tidak sopan.', 1, '2026-08-04 01:00:00', '2026-10-21 02:25:07'),
(33, 'Pergaulan Siswa', 'Kategori untuk perilaku pergaulan yang melanggar tata tertib.', 1, '2026-09-05 01:00:00', '2026-10-21 02:25:07'),
(34, 'Pencegahan Perundungan', 'Kategori untuk perilaku perundungan atau tindakan merendahkan orang lain.', 1, '2026-10-06 01:00:00', '2026-10-21 02:25:07'),
(35, 'Pengelolaan Sampah', 'Kategori untuk tindakan membuang sampah sembarangan atau mengotori lingkungan.', 1, '2026-11-07 01:00:00', '2026-10-21 02:25:07'),
(36, 'Ketertiban Istirahat', 'Kategori untuk ketidakdisiplinan saat waktu istirahat.', 1, '2026-12-08 01:00:00', '2026-10-21 02:25:07'),
(37, 'Ketepatan Mengumpulkan Tugas', 'Kategori untuk kelalaian mengumpulkan tugas sesuai tenggat waktu.', 1, '2026-01-09 01:00:00', '2026-10-21 02:25:07'),
(38, 'Partisipasi Pembelajaran', 'Kategori untuk tidak mengikuti pembelajaran tanpa alasan yang sah.', 1, '2026-02-10 01:00:00', '2026-10-21 02:25:07'),
(39, 'Tanggung Jawab Kelompok', 'Kategori untuk tidak menjalankan tanggung jawab dalam tugas kelompok.', 1, '2026-03-11 01:00:00', '2026-10-21 02:25:07'),
(40, 'Kegiatan Ekstrakurikuler', 'Kategori untuk pelanggaran aturan kegiatan ekstrakurikuler.', 1, '2026-04-12 01:00:00', '2026-10-21 02:25:07'),
(41, 'Penggunaan Barang Pribadi', 'Kategori untuk penggunaan barang pribadi yang mengganggu pembelajaran.', 1, '2026-05-13 01:00:00', '2026-10-21 02:25:07'),
(42, 'Larangan Membawa Barang', 'Kategori untuk membawa barang yang dilarang oleh sekolah.', 1, '2026-06-14 01:00:00', '2026-10-21 02:25:07'),
(43, 'Keamanan Barang', 'Kategori untuk tindakan mengambil atau mengganggu barang milik orang lain.', 1, '2026-07-15 01:00:00', '2026-10-21 02:25:07'),
(44, 'Kejujuran Administrasi', 'Kategori untuk pemalsuan atau ketidakjujuran dalam dokumen administrasi.', 1, '2026-08-16 01:00:00', '2026-10-21 02:25:07'),
(45, 'Kepatuhan Perizinan', 'Kategori untuk ketidakpatuhan terhadap prosedur perizinan.', 1, '2026-09-17 01:00:00', '2026-10-21 02:25:07'),
(46, 'Ketertiban Lingkungan', 'Kategori untuk tindakan yang mengganggu ketertiban lingkungan sekolah.', 1, '2026-10-18 01:00:00', '2026-10-21 02:25:07'),
(47, 'Kedisiplinan Administrasi', 'Kategori untuk kelalaian dalam memenuhi ketentuan administrasi sekolah.', 1, '2026-11-19 01:00:00', '2026-10-21 02:25:07'),
(48, 'Etika Digital', 'Kategori untuk penggunaan teknologi digital yang tidak sesuai aturan.', 1, '2026-12-20 01:00:00', '2026-10-21 02:25:07'),
(49, 'Kepedulian Sosial', 'Kategori untuk perilaku yang tidak menunjukkan kepedulian terhadap warga sekolah.', 1, '2026-01-21 01:00:00', '2026-10-21 02:25:07'),
(50, 'Pelanggaran Berulang', 'Kategori untuk pelanggaran yang dilakukan kembali setelah pelanggaran sebelumnya dicatat.', 1, '2026-02-22 01:00:00', '2026-10-21 02:25:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pelanggaran_siswa`
--

CREATE TABLE `t_pelanggaran_siswa` (
  `id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `nama_siswa` varchar(150) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `pelanggaran_id` int(11) NOT NULL,
  `nama_pelanggaran` varchar(150) NOT NULL,
  `pelanggaran_kategori_id` int(11) NOT NULL,
  `guru_id` int(11) NOT NULL,
  `nama_guru` varchar(150) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text NOT NULL,
  `poin` int(11) NOT NULL,
  `tindakan` text NOT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_pelanggaran_siswa`
--

INSERT INTO `t_pelanggaran_siswa` (`id`, `tahun_ajaran_id`, `siswa_id`, `nama_siswa`, `kelas_id`, `nama_kelas`, `pelanggaran_id`, `nama_pelanggaran`, `pelanggaran_kategori_id`, `guru_id`, `nama_guru`, `tanggal`, `keterangan`, `poin`, `tindakan`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Andi Saputra ', 1, 'X RPL 1', 1, 'Terlambat Masuk Sekolah', 1, 1, 'Guru Matematika', '2026-01-01', 'Kejadian pelanggaran 01', 1, 'Tindakan 01', 'Teguran', '2026-01-01 02:00:00', '2026-10-21 02:26:56'),
(2, 1, 2, 'Budi Saputra ', 2, 'XI TKJ 1', 2, 'Tidak Memakai Seragam Sesuai Aturan', 2, 2, 'Guru Bahasa Indonesia', '2026-02-02', 'Kejadian pelanggaran 02', 2, 'Tindakan 02', 'Pembinaan', '2026-02-02 02:00:00', '2026-10-21 02:26:56'),
(3, 1, 3, 'Citra Saputra ', 3, 'XII DKV 1', 3, 'Tidak Hadir Tanpa Keterangan', 3, 3, 'Guru Bahasa Inggris', '2026-03-03', 'Kejadian pelanggaran 03', 3, 'Tindakan 03', 'Selesai', '2026-03-03 02:00:00', '2026-10-21 02:26:56'),
(4, 1, 4, 'Dina Saputra ', 4, 'X AKL 1', 4, 'Rambut Tidak Sesuai Aturan', 4, 4, 'Guru Pendidikan Pancasila', '2026-04-04', 'Kejadian pelanggaran 04', 4, 'Tindakan 04', 'Dipantau', '2026-04-04 02:00:00', '2026-10-21 02:26:56'),
(5, 1, 5, 'Eka Saputra ', 5, 'XI MPLB 1', 5, 'Tidak Mengerjakan Tugas', 5, 5, 'Guru Pendidikan Agama', '2026-05-05', 'Kejadian pelanggaran 05', 5, 'Tindakan 05', 'Ditindaklanjuti', '2026-05-05 02:00:00', '2026-10-21 02:26:56'),
(6, 1, 6, 'Fajar Saputra ', 6, 'XII RPL 1', 6, 'Keluar Kelas Tanpa Izin', 6, 6, 'Guru PJOK', '2026-06-06', 'Kejadian pelanggaran 06', 1, 'Tindakan 06', 'Teguran', '2026-06-06 02:00:00', '2026-10-21 02:26:56'),
(7, 1, 7, 'Gita Saputra', 7, 'X TKJ 1', 7, 'Tidak Memakai Atribut Sekolah', 7, 7, 'Guru Sejarah', '2026-07-07', 'Kejadian pelanggaran 07', 2, 'Tindakan 07', 'Pembinaan', '2026-07-07 02:00:00', '2026-10-21 02:26:56'),
(8, 1, 8, 'Hana Saputra ', 8, 'XI DKV 1', 8, 'Terlambat Masuk Kelas', 8, 8, 'Guru Seni Budaya', '2026-08-08', 'Kejadian pelanggaran 08', 3, 'Tindakan 08', 'Selesai', '2026-08-08 02:00:00', '2026-10-21 02:26:56'),
(9, 1, 9, 'Indra Saputra ', 9, 'XII AKL 1', 9, 'Memakai Sepatu Tidak Sesuai Aturan', 9, 9, 'Guru Informatika', '2026-09-09', 'Kejadian pelanggaran 09', 4, 'Tindakan 09', 'Dipantau', '2026-09-09 02:00:00', '2026-10-21 02:26:56'),
(10, 1, 10, 'Joko Saputra ', 10, 'X MPLB 1', 10, 'Menyontek Saat Ujian', 10, 10, 'Guru BK', '2026-10-10', 'Kejadian pelanggaran 10', 5, 'Tindakan 10', 'Ditindaklanjuti', '2026-10-10 02:00:00', '2026-10-21 02:26:56'),
(11, 2, 11, 'Andi Pratama ', 1, 'X RPL 1', 11, 'Membolos Saat Jam Pelajaran', 11, 11, 'Guru Produktif RPL', '2026-11-11', 'Kejadian pelanggaran 11', 1, 'Tindakan 11', 'Teguran', '2026-11-11 02:00:00', '2026-10-21 02:26:56'),
(12, 2, 12, 'Budi Pratama ', 2, 'XI TKJ 1', 12, 'Tidak Mengikuti Upacara', 12, 12, 'Guru Pemrograman Web', '2026-12-12', 'Kejadian pelanggaran 12', 2, 'Tindakan 12', 'Pembinaan', '2026-12-12 02:00:00', '2026-10-21 02:26:56'),
(13, 2, 13, 'Citra Pratama ', 3, 'XII DKV 1', 13, 'Tidak Membawa Perlengkapan Belajar', 13, 13, 'Guru Basis Data', '2026-01-13', 'Kejadian pelanggaran 13', 3, 'Tindakan 13', 'Selesai', '2026-01-13 02:00:00', '2026-10-21 02:26:56'),
(14, 2, 14, 'Dina Pratama ', 4, 'X AKL 1', 14, 'Membuang Sampah Sembarangan', 14, 14, 'Guru Pemrograman Dasar', '2026-02-14', 'Kejadian pelanggaran 14', 4, 'Tindakan 14', 'Dipantau', '2026-02-14 02:00:00', '2026-10-21 02:26:56'),
(15, 2, 15, 'Eka Pratama ', 5, 'XI MPLB 1', 15, 'Berkelahi dengan Teman', 15, 15, 'Guru Jaringan Komputer', '2026-03-15', 'Kejadian pelanggaran 15', 5, 'Tindakan 15', 'Ditindaklanjuti', '2026-03-15 02:00:00', '2026-10-21 02:26:56'),
(16, 2, 16, 'Fajar Pratama ', 6, 'XII RPL 1', 16, 'Berkata Tidak Sopan', 16, 16, 'Guru Produktif TKJ', '2026-04-16', 'Kejadian pelanggaran 16', 1, 'Tindakan 16', 'Teguran', '2026-04-16 02:00:00', '2026-10-21 02:26:56'),
(17, 2, 17, 'Gita Pratama ', 7, 'X TKJ 1', 17, 'Mengganggu Teman Saat Belajar', 17, 17, 'Guru Administrasi Jaringan', '2026-05-17', 'Kejadian pelanggaran 17', 2, 'Tindakan 17', 'Pembinaan', '2026-05-17 02:00:00', '2026-10-21 02:26:56'),
(18, 2, 18, 'Hana Pratama ', 8, 'XI DKV 1', 18, 'Tidak Melaksanakan Piket Kelas', 18, 18, 'Guru Sistem Komputer', '2026-06-18', 'Kejadian pelanggaran 18', 3, 'Tindakan 18', 'Selesai', '2026-06-18 02:00:00', '2026-10-21 02:26:56'),
(19, 2, 19, 'Indra Pratama ', 9, 'XII AKL 1', 19, 'Merusak Fasilitas Sekolah', 19, 19, 'Guru Desain Grafis', '2026-07-19', 'Kejadian pelanggaran 19', 4, 'Tindakan 19', 'Dipantau', '2026-07-19 02:00:00', '2026-10-21 02:26:56'),
(20, 2, 20, 'Joko Pratama ', 10, 'X MPLB 1', 20, 'Tidak Mengumpulkan Tugas', 20, 20, 'Guru Produktif DKV', '2026-08-20', 'Kejadian pelanggaran 20', 5, 'Tindakan 20', 'Ditindaklanjuti', '2026-08-20 02:00:00', '2026-10-21 02:26:56'),
(21, 3, 21, 'Andi Lestari ', 1, 'X RPL 1', 21, 'Menggunakan HP Saat Pelajaran', 21, 21, 'Guru Fotografi', '2026-09-21', 'Kejadian pelanggaran 21', 1, 'Tindakan 21', 'Teguran', '2026-09-21 02:00:00', '2026-10-21 02:26:56'),
(22, 3, 22, 'Budi Lestari ', 2, 'XI TKJ 1', 22, 'Tidur Saat Pelajaran', 22, 22, 'Guru Desain Komunikasi Visual', '2026-10-22', 'Kejadian pelanggaran 22', 2, 'Tindakan 22', 'Pembinaan', '2026-10-22 02:00:00', '2026-10-21 02:26:56'),
(23, 3, 23, 'Citra Lestari ', 3, 'XII DKV 1', 23, 'Tidak Mengikuti Kegiatan Sekolah', 23, 23, 'Guru Akuntansi Dasar', '2026-11-23', 'Kejadian pelanggaran 23', 3, 'Tindakan 23', 'Selesai', '2026-11-23 02:00:00', '2026-10-21 02:26:56'),
(24, 3, 24, 'Dina Lestari ', 4, 'X AKL 1', 24, 'Memakai Seragam Tidak Rapi', 24, 24, 'Guru Produktif AKL', '2026-12-24', 'Kejadian pelanggaran 24', 4, 'Tindakan 24', 'Dipantau', '2026-12-24 02:00:00', '2026-10-21 02:26:56'),
(25, 3, 25, 'Eka Lestari ', 5, 'XI MPLB 1', 25, 'Meninggalkan Sekolah Tanpa Izin', 25, 25, 'Guru Perpajakan', '2026-01-25', 'Kejadian pelanggaran 25', 5, 'Tindakan 25', 'Ditindaklanjuti', '2026-01-25 02:00:00', '2026-10-21 02:26:56'),
(26, 3, 26, 'Fajar Lestari ', 6, 'XII RPL 1', 26, 'Tidak Membawa Buku Pelajaran', 26, 26, 'Guru Komputer Akuntansi', '2026-02-26', 'Kejadian pelanggaran 26', 1, 'Tindakan 26', 'Teguran', '2026-02-26 02:00:00', '2026-10-21 02:26:56'),
(27, 3, 27, 'Gita Lestari ', 7, 'X TKJ 1', 27, 'Mencontek Pekerjaan Teman', 27, 27, 'Guru Produktif MPLB', '2026-03-27', 'Kejadian pelanggaran 27', 2, 'Tindakan 27', 'Pembinaan', '2026-03-27 02:00:00', '2026-10-21 02:26:56'),
(28, 3, 28, 'Hana Lestari ', 8, 'XI DKV 1', 28, 'Tidak Mematuhi Tata Tertib', 28, 28, 'Guru Administrasi Umum', '2026-04-28', 'Kejadian pelanggaran 28', 3, 'Tindakan 28', 'Selesai', '2026-04-28 02:00:00', '2026-10-21 02:26:56'),
(29, 3, 29, 'Indra Lestari ', 9, 'XII AKL 1', 29, 'Membuat Keributan di Kelas', 29, 29, 'Guru Korespondensi', '2026-05-01', 'Kejadian pelanggaran 29', 4, 'Tindakan 29', 'Dipantau', '2026-05-01 02:00:00', '2026-10-21 02:26:56'),
(30, 3, 30, 'Joko Lestari ', 10, 'X MPLB 1', 30, 'Tidak Menghormati Guru', 30, 30, 'Guru Kearsipan', '2026-06-02', 'Kejadian pelanggaran 30', 5, 'Tindakan 30', 'Ditindaklanjuti', '2026-06-02 02:00:00', '2026-10-21 02:26:56'),
(31, 4, 31, 'Andi Permata ', 1, 'X RPL 1', 31, 'Terlambat Kembali dari Istirahat', 31, 31, 'Guru Ekonomi', '2026-07-03', 'Kejadian pelanggaran 31', 1, 'Tindakan 31', 'Teguran', '2026-07-03 02:00:00', '2026-10-21 02:26:56'),
(32, 4, 32, 'Budi Permata ', 2, 'XI TKJ 1', 32, 'Tidak Memakai Ikat Pinggang', 32, 32, 'Guru Bahasa Sunda', '2026-08-04', 'Kejadian pelanggaran 32', 2, 'Tindakan 32', 'Pembinaan', '2026-08-04 02:00:00', '2026-10-21 02:26:56'),
(33, 4, 33, 'Citra Permata ', 3, 'XII DKV 1', 33, 'Memakai Aksesori Terlarang', 33, 33, 'Guru Pendidikan Kewarganegaraa', '2026-09-05', 'Kejadian pelanggaran 33', 3, 'Tindakan 33', 'Selesai', '2026-09-05 02:00:00', '2026-10-21 02:26:56'),
(34, 4, 34, 'Dina Permata ', 4, 'X AKL 1', 34, 'Mencoret Meja atau Dinding', 34, 34, 'Guru Projek Kreatif', '2026-10-06', 'Kejadian pelanggaran 34', 4, 'Tindakan 34', 'Dipantau', '2026-10-06 02:00:00', '2026-10-21 02:26:56'),
(35, 4, 35, 'Eka Permata ', 5, 'XI MPLB 1', 35, 'Tidak Menjaga Kebersihan Kelas', 35, 35, 'Guru Kewirausahaan', '2026-11-07', 'Kejadian pelanggaran 35', 5, 'Tindakan 35', 'Ditindaklanjuti', '2026-11-07 02:00:00', '2026-10-21 02:26:56'),
(36, 4, 36, 'Fajar Permata ', 6, 'XII RPL 1', 36, 'Tidak Membawa Kartu Pelajar', 36, 36, 'Guru Simulasi Digital', '2026-12-08', 'Kejadian pelanggaran 36', 1, 'Tindakan 36', 'Teguran', '2026-12-08 02:00:00', '2026-10-21 02:26:56'),
(37, 4, 37, 'Gita Permata ', 7, 'X TKJ 1', 37, 'Tidak Mengikuti Pelajaran Praktik', 37, 37, 'Guru Matematika Terapan', '2026-01-09', 'Kejadian pelanggaran 37', 2, 'Tindakan 37', 'Pembinaan', '2026-01-09 02:00:00', '2026-10-21 02:26:56'),
(38, 4, 38, 'Hana Permata ', 8, 'XI DKV 1', 38, 'Tidak Memakai Perlengkapan Praktik', 38, 38, 'Guru Bahasa Inggris Kejuruan', '2026-02-10', 'Kejadian pelanggaran 38', 3, 'Tindakan 38', 'Selesai', '2026-02-10 02:00:00', '2026-10-21 02:26:56'),
(39, 4, 39, 'Indra Permata ', 9, 'XII AKL 1', 39, 'Menyalahgunakan Fasilitas Laboratorium', 39, 39, 'Guru Produk Kreatif RPL', '2026-03-11', 'Kejadian pelanggaran 39', 4, 'Tindakan 39', 'Dipantau', '2026-03-11 02:00:00', '2026-10-21 02:26:56'),
(40, 4, 40, 'Joko Permata ', 10, 'X MPLB 1', 40, 'Tidak Mematuhi Aturan Perpustakaan', 40, 40, 'Guru Produk Kreatif TKJ', '2026-04-12', 'Kejadian pelanggaran 40', 5, 'Tindakan 40', 'Ditindaklanjuti', '2026-04-12 02:00:00', '2026-10-21 02:26:56'),
(41, 5, 41, 'Andi Nugraha ', 1, 'X RPL 1', 41, 'Berisik Saat Kegiatan Belajar', 41, 41, 'Guru Produk Kreatif DKV', '2026-05-13', 'Kejadian pelanggaran 41', 1, 'Tindakan 41', 'Teguran', '2026-05-13 02:00:00', '2026-10-21 02:26:56'),
(42, 5, 42, 'Budi Nugraha ', 2, 'XI TKJ 1', 42, 'Tidak Mengikuti Kerja Bakti', 42, 42, 'Guru Praktik Akuntansi', '2026-06-14', 'Kejadian pelanggaran 42', 2, 'Tindakan 42', 'Pembinaan', '2026-06-14 02:00:00', '2026-10-21 02:26:56'),
(43, 5, 43, 'Citra Nugraha ', 3, 'XII DKV 1', 43, 'Memalsukan Tanda Tangan', 43, 43, 'Guru Praktik Perkantoran', '2026-07-15', 'Kejadian pelanggaran 43', 3, 'Tindakan 43', 'Selesai', '2026-07-15 02:00:00', '2026-10-21 02:26:56'),
(44, 5, 44, 'Dina Nugraha ', 4, 'X AKL 1', 44, 'Membawa Barang yang Dilarang', 44, 44, 'Guru Teknologi Informasi', '2026-08-16', 'Kejadian pelanggaran 44', 4, 'Tindakan 44', 'Dipantau', '2026-08-16 02:00:00', '2026-10-21 02:26:56'),
(45, 5, 45, 'Eka Nugraha ', 5, 'XI MPLB 1', 45, 'Mengambil Barang Milik Teman', 45, 45, 'Guru Keamanan Jaringan', '2026-09-17', 'Kejadian pelanggaran 45', 5, 'Tindakan 45', 'Ditindaklanjuti', '2026-09-17 02:00:00', '2026-10-21 02:26:56'),
(46, 5, 46, 'Fajar Nugraha ', 6, 'XII RPL 1', 46, 'Tidak Mengikuti Ujian Tanpa Alasan', 46, 46, 'Guru Ilustrasi Digital', '2026-10-18', 'Kejadian pelanggaran 46', 1, 'Tindakan 46', 'Teguran', '2026-10-18 02:00:00', '2026-10-21 02:26:56'),
(47, 5, 47, 'Gita Nugraha ', 7, 'X TKJ 1', 47, 'Tidak Menyelesaikan Tugas Kelompok', 47, 47, 'Guru Pengolahan Data', '2026-11-19', 'Kejadian pelanggaran 47', 2, 'Tindakan 47', 'Pembinaan', '2026-11-19 02:00:00', '2026-10-21 02:26:56'),
(48, 5, 48, 'Hana Nugraha ', 8, 'XI DKV 1', 48, 'Menggunakan Seragam Olahraga Tidak Sesuai', 48, 48, 'Guru Administrasi Pajak', '2026-12-20', 'Kejadian pelanggaran 48', 3, 'Tindakan 48', 'Selesai', '2026-12-20 02:00:00', '2026-10-21 02:26:56'),
(49, 5, 49, 'Indra Nugraha ', 9, 'XII AKL 1', 49, 'Tidak Menjaga Ketertiban Sekolah', 49, 49, 'Guru Komunikasi Bisnis', '2026-01-21', 'Kejadian pelanggaran 49', 4, 'Tindakan 49', 'Dipantau', '2026-01-21 02:00:00', '2026-10-21 02:26:56'),
(50, 5, 50, 'Joko Nugraha ', 10, 'X MPLB 1', 50, 'Mengulangi Pelanggaran yang Sama', 50, 50, 'Guru Muatan Lokal', '2026-02-22', 'Kejadian pelanggaran 50', 5, 'Tindakan 50', 'Ditindaklanjuti', '2026-02-22 02:00:00', '2026-10-21 02:26:56'),
(51, 3, 21, 'Andi Lestari ', 1, 'X RPL 1', 16, 'Berkata Tidak Sopan', 16, 52, 'Guru Ilmu Pengetahuan Alam', '2026-10-13', '', 1, '', 'Selesai', '2026-10-22 04:00:19', '2026-10-22 04:00:19'),
(52, 1, 10, 'Joko Saputra ', 10, 'X MPLB 1', 15, 'Berkelahi dengan Teman', 15, 52, 'Guru Ilmu Pengetahuan Alam', '2026-10-22', '', 5, '', 'Pembinaan', '2026-10-22 04:03:45', '2026-10-22 04:03:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_siswa`
--

CREATE TABLE `t_siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(30) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `jenis_kelamin` char(1) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_siswa`
--

INSERT INTO `t_siswa` (`id`, `nis`, `nisn`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'NIS0001', '0000000001', 'Andi Saputra ', 'L', '2010-01-15', 'Jl. Pendidikan No. 1, Tasikmalaya', 1, '2026-01-01 01:00:00', '2026-01-01 01:00:00'),
(2, 'NIS0002', '0000000002', 'Budi Saputra ', 'P', '2010-02-20', 'Jl. Pendidikan No. 2, Tasikmalaya', 1, '2026-02-02 01:00:00', '2026-02-02 01:00:00'),
(3, 'NIS0003', '0000000003', 'Citra Saputra ', 'L', '2010-03-12', 'Jl. Pendidikan No. 3, Tasikmalaya', 1, '2026-03-03 01:00:00', '2026-03-03 01:00:00'),
(4, 'NIS0004', '0000000004', 'Dina Saputra ', 'P', '2010-04-25', 'Jl. Pendidikan No. 4, Tasikmalaya', 1, '2026-04-04 01:00:00', '2026-04-04 01:00:00'),
(5, 'NIS0005', '0000000005', 'Eka Saputra ', 'L', '2010-05-18', 'Jl. Pendidikan No. 5, Tasikmalaya', 1, '2026-05-05 01:00:00', '2026-05-05 01:00:00'),
(6, 'NIS0006', '0000000006', 'Fajar Saputra ', 'P', '2010-06-07', 'Jl. Pendidikan No. 6, Tasikmalaya', 1, '2026-06-06 01:00:00', '2026-06-06 01:00:00'),
(7, 'NIS0007', '0000000007', 'Gita Saputra', 'L', '2010-07-22', 'Jl. Pendidikan No. 7, Tasikmalaya', 1, '2026-07-07 01:00:00', '2026-07-07 01:00:00'),
(8, 'NIS0008', '0000000008', 'Hana Saputra ', 'P', '2010-08-14', 'Jl. Pendidikan No. 8, Tasikmalaya', 1, '2026-08-08 01:00:00', '2026-08-08 01:00:00'),
(9, 'NIS0009', '0000000009', 'Indra Saputra ', 'L', '2010-09-30', 'Jl. Pendidikan No. 9, Tasikmalaya', 1, '2026-09-09 01:00:00', '2026-09-09 01:00:00'),
(10, 'NIS0010', '0000000010', 'Joko Saputra ', 'P', '2010-10-11', 'Jl. Pendidikan No. 10, Tasikmalaya', 1, '2026-10-10 01:00:00', '2026-10-10 01:00:00'),
(11, 'NIS0011', '0000000011', 'Andi Pratama ', 'L', '2010-11-05', 'Jl. Pendidikan No. 11, Tasikmalaya', 1, '2026-11-11 01:00:00', '2026-11-11 01:00:00'),
(12, 'NIS0012', '0000000012', 'Budi Pratama ', 'P', '2010-12-19', 'Jl. Pendidikan No. 12, Tasikmalaya', 1, '2026-12-12 01:00:00', '2026-12-12 01:00:00'),
(13, 'NIS0013', '0000000013', 'Citra Pratama ', 'L', '2011-01-08', 'Jl. Pendidikan No. 13, Tasikmalaya', 1, '2026-01-13 01:00:00', '2026-01-13 01:00:00'),
(14, 'NIS0014', '0000000014', 'Dina Pratama ', 'P', '2011-02-17', 'Jl. Pendidikan No. 14, Tasikmalaya', 1, '2026-02-14 01:00:00', '2026-02-14 01:00:00'),
(15, 'NIS0015', '0000000015', 'Eka Pratama ', 'L', '2011-03-29', 'Jl. Pendidikan No. 15, Tasikmalaya', 1, '2026-03-15 01:00:00', '2026-03-15 01:00:00'),
(16, 'NIS0016', '0000000016', 'Fajar Pratama ', 'P', '2011-04-13', 'Jl. Pendidikan No. 16, Tasikmalaya', 1, '2026-04-16 01:00:00', '2026-04-16 01:00:00'),
(17, 'NIS0017', '0000000017', 'Gita Pratama ', 'L', '2011-05-21', 'Jl. Pendidikan No. 17, Tasikmalaya', 1, '2026-05-17 01:00:00', '2026-05-17 01:00:00'),
(18, 'NIS0018', '0000000018', 'Hana Pratama ', 'P', '2011-06-09', 'Jl. Pendidikan No. 18, Tasikmalaya', 1, '2026-06-18 01:00:00', '2026-06-18 01:00:00'),
(19, 'NIS0019', '0000000019', 'Indra Pratama ', 'L', '2011-07-27', 'Jl. Pendidikan No. 19, Tasikmalaya', 1, '2026-07-19 01:00:00', '2026-07-19 01:00:00'),
(20, 'NIS0020', '0000000020', 'Joko Pratama ', 'P', '2011-08-16', 'Jl. Pendidikan No. 20, Tasikmalaya', 1, '2026-08-20 01:00:00', '2026-08-20 01:00:00'),
(21, 'NIS0021', '0000000021', 'Andi Lestari ', 'L', '2011-09-04', 'Jl. Pendidikan No. 21, Tasikmalaya', 1, '2026-09-21 01:00:00', '0000-00-00 00:00:00'),
(22, 'NIS0022', '0000000022', 'Budi Lestari ', 'P', '2011-10-23', 'Jl. Pendidikan No. 22, Tasikmalaya', 1, '2026-10-22 01:00:00', '2026-10-22 01:00:00'),
(23, 'NIS0023', '0000000023', 'Citra Lestari ', 'L', '2011-11-14', 'Jl. Pendidikan No. 23, Tasikmalaya', 1, '2026-11-23 01:00:00', '2026-11-23 01:00:00'),
(24, 'NIS0024', '0000000024', 'Dina Lestari ', 'P', '2011-12-02', 'Jl. Pendidikan No. 24, Tasikmalaya', 1, '2026-12-24 01:00:00', '2026-12-24 01:00:00'),
(25, 'NIS0025', '0000000025', 'Eka Lestari ', 'L', '2010-01-28', 'Jl. Pendidikan No. 25, Tasikmalaya', 1, '2026-01-25 01:00:00', '2026-01-25 01:00:00'),
(26, 'NIS0026', '0000000026', 'Fajar Lestari ', 'P', '2010-02-11', 'Jl. Pendidikan No. 26, Tasikmalaya', 1, '2026-02-26 01:00:00', '2026-02-26 01:00:00'),
(27, 'NIS0027', '0000000027', 'Gita Lestari ', 'L', '2010-03-24', 'Jl. Pendidikan No. 27, Tasikmalaya', 1, '2026-03-27 01:00:00', '2026-03-27 01:00:00'),
(28, 'NIS0028', '0000000028', 'Hana Lestari ', 'P', '2010-04-09', 'Jl. Pendidikan No. 28, Tasikmalaya', 1, '2026-04-28 01:00:00', '2026-04-28 01:00:00'),
(29, 'NIS0029', '0000000029', 'Indra Lestari ', 'L', '2010-05-30', 'Jl. Pendidikan No. 29, Tasikmalaya', 1, '2026-05-01 01:00:00', '2026-05-01 01:00:00'),
(30, 'NIS0030', '0000000030', 'Joko Lestari ', 'P', '2010-06-18', 'Jl. Pendidikan No. 30, Tasikmalaya', 1, '2026-06-02 01:00:00', '2026-06-02 01:00:00'),
(31, 'NIS0031', '0000000031', 'Andi Permata ', 'L', '2010-07-06', 'Jl. Pendidikan No. 31, Tasikmalaya', 1, '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(32, 'NIS0032', '0000000032', 'Budi Permata ', 'P', '2010-08-26', 'Jl. Pendidikan No. 32, Tasikmalaya', 1, '2026-08-04 01:00:00', '2026-08-04 01:00:00'),
(33, 'NIS0033', '0000000033', 'Citra Permata ', 'L', '2010-09-15', 'Jl. Pendidikan No. 33, Tasikmalaya', 1, '2026-09-05 01:00:00', '2026-09-05 01:00:00'),
(34, 'NIS0034', '0000000034', 'Dina Permata ', 'P', '2010-10-29', 'Jl. Pendidikan No. 34, Tasikmalaya', 1, '2026-10-06 01:00:00', '2026-10-06 01:00:00'),
(35, 'NIS0035', '0000000035', 'Eka Permata ', 'L', '2010-11-18', 'Jl. Pendidikan No. 35, Tasikmalaya', 1, '2026-11-07 01:00:00', '2026-11-07 01:00:00'),
(36, 'NIS0036', '0000000036', 'Fajar Permata ', 'P', '2010-12-07', 'Jl. Pendidikan No. 36, Tasikmalaya', 1, '2026-12-08 01:00:00', '2026-12-08 01:00:00'),
(37, 'NIS0037', '0000000037', 'Gita Permata ', 'L', '2011-01-25', 'Jl. Pendidikan No. 37, Tasikmalaya', 1, '2026-01-09 01:00:00', '2026-01-09 01:00:00'),
(38, 'NIS0038', '0000000038', 'Hana Permata ', 'P', '2011-02-08', 'Jl. Pendidikan No. 38, Tasikmalaya', 1, '2026-02-10 01:00:00', '2026-02-10 01:00:00'),
(39, 'NIS0039', '0000000039', 'Indra Permata ', 'L', '2011-03-19', 'Jl. Pendidikan No. 39, Tasikmalaya', 1, '2026-03-11 01:00:00', '2026-03-11 01:00:00'),
(40, 'NIS0040', '0000000040', 'Joko Permata ', 'P', '2011-04-28', 'Jl. Pendidikan No. 40, Tasikmalaya', 1, '2026-04-12 01:00:00', '2026-04-12 01:00:00'),
(41, 'NIS0041', '0000000041', 'Andi Nugraha ', 'L', '2011-05-16', 'Jl. Pendidikan No. 41, Tasikmalaya', 1, '2026-05-13 01:00:00', '2026-05-13 01:00:00'),
(42, 'NIS0042', '0000000042', 'Budi Nugraha ', 'P', '2011-06-24', 'Jl. Pendidikan No. 42, Tasikmalaya', 1, '2026-06-14 01:00:00', '2026-06-14 01:00:00'),
(43, 'NIS0043', '0000000043', 'Citra Nugraha ', 'L', '2011-07-12', 'Jl. Pendidikan No. 43, Tasikmalaya', 1, '2026-07-15 01:00:00', '2026-07-15 01:00:00'),
(44, 'NIS0044', '0000000044', 'Dina Nugraha ', 'P', '2011-08-31', 'Jl. Pendidikan No. 44, Tasikmalaya', 1, '2026-08-16 01:00:00', '2026-08-16 01:00:00'),
(45, 'NIS0045', '0000000045', 'Eka Nugraha ', 'L', '2011-09-20', 'Jl. Pendidikan No. 45, Tasikmalaya', 1, '2026-09-17 01:00:00', '2026-09-17 01:00:00'),
(46, 'NIS0046', '0000000046', 'Fajar Nugraha ', 'P', '2011-10-10', 'Jl. Pendidikan No. 46, Tasikmalaya', 1, '2026-10-18 01:00:00', '2026-10-18 01:00:00'),
(47, 'NIS0047', '0000000047', 'Gita Nugraha ', 'L', '2011-11-27', 'Jl. Pendidikan No. 47, Tasikmalaya', 1, '2026-11-19 01:00:00', '2026-11-19 01:00:00'),
(48, 'NIS0048', '0000000048', 'Hana Nugraha ', 'P', '2011-12-15', 'Jl. Pendidikan No. 48, Tasikmalaya', 1, '2026-12-20 01:00:00', '2026-12-20 01:00:00'),
(49, 'NIS0049', '0000000049', 'Indra Nugraha ', 'L', '2010-03-05', 'Jl. Pendidikan No. 49, Tasikmalaya', 1, '2026-01-21 01:00:00', '2026-01-21 01:00:00'),
(50, 'NIS0050', '0000000050', 'Joko Nugraha ', 'P', '2010-04-17', 'Jl. Pendidikan No. 50, Tasikmalaya', 1, '2026-02-22 01:00:00', '2026-02-22 01:00:00'),
(52, 'NIS0051', '0000000051', 'Sofi Nurjanah', 'P', '2009-01-23', 'Jl. Cibogo, Tasikmalaya', 1, '2026-10-01 00:35:57', '2026-10-01 00:35:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_tahun_ajaran`
--

CREATE TABLE `t_tahun_ajaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_tahun_ajaran`
--

INSERT INTO `t_tahun_ajaran` (`id`, `nama`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '1977/1978', '1977-07-01', '1978-06-30', 0, '2026-01-01 01:00:00', '2026-01-01 01:00:00'),
(2, '1978/1979', '1978-07-01', '1979-06-30', 0, '2026-02-02 01:00:00', '2026-02-02 01:00:00'),
(3, '1979/1980', '1979-07-01', '1980-06-30', 0, '2026-03-03 01:00:00', '2026-03-03 01:00:00'),
(4, '1980/1981', '1980-07-01', '1981-06-30', 0, '2026-04-04 01:00:00', '2026-04-04 01:00:00'),
(5, '1981/1982', '1981-07-01', '1982-06-30', 0, '2026-05-05 01:00:00', '2026-05-05 01:00:00'),
(6, '1982/1983', '1982-07-01', '1983-06-30', 0, '2026-06-06 01:00:00', '2026-06-06 01:00:00'),
(7, '1983/1984', '1983-07-01', '1984-06-30', 0, '2026-07-07 01:00:00', '2026-07-07 01:00:00'),
(8, '1984/1985', '1984-07-01', '1985-06-30', 0, '2026-08-08 01:00:00', '2026-08-08 01:00:00'),
(9, '1985/1986', '1985-07-01', '1986-06-30', 0, '2026-09-09 01:00:00', '2026-09-09 01:00:00'),
(10, '1986/1987', '1986-07-01', '1987-06-30', 0, '2026-10-10 01:00:00', '2026-10-10 01:00:00'),
(11, '1987/1988', '1987-07-01', '1988-06-30', 0, '2026-11-11 01:00:00', '2026-11-11 01:00:00'),
(12, '1988/1989', '1988-07-01', '1989-06-30', 0, '2026-12-12 01:00:00', '2026-12-12 01:00:00'),
(13, '1989/1990', '1989-07-01', '1990-06-30', 0, '2026-01-13 01:00:00', '2026-01-13 01:00:00'),
(14, '1990/1991', '1990-07-01', '1991-06-30', 0, '2026-02-14 01:00:00', '2026-02-14 01:00:00'),
(15, '1991/1992', '1991-07-01', '1992-06-30', 0, '2026-03-15 01:00:00', '2026-03-15 01:00:00'),
(16, '1992/1993', '1992-07-01', '1993-06-30', 0, '2026-04-16 01:00:00', '2026-04-16 01:00:00'),
(17, '1993/1994', '1993-07-01', '1994-06-30', 0, '2026-05-17 01:00:00', '2026-05-17 01:00:00'),
(18, '1994/1995', '1994-07-01', '1995-06-30', 0, '2026-06-18 01:00:00', '2026-06-18 01:00:00'),
(19, '1995/1996', '1995-07-01', '1996-06-30', 0, '2026-07-19 01:00:00', '2026-07-19 01:00:00'),
(20, '1996/1997', '1996-07-01', '1997-06-30', 0, '2026-08-20 01:00:00', '2026-08-20 01:00:00'),
(21, '1997/1998', '1997-07-01', '1998-06-30', 0, '2026-09-21 01:00:00', '2026-09-21 01:00:00'),
(22, '1998/1999', '1998-07-01', '1999-06-30', 0, '2026-10-22 01:00:00', '2026-10-22 01:00:00'),
(23, '1999/2000', '1999-07-01', '2000-06-30', 0, '2026-11-23 01:00:00', '2026-11-23 01:00:00'),
(24, '2000/2001', '2000-07-01', '2001-06-30', 0, '2026-12-24 01:00:00', '2026-12-24 01:00:00'),
(25, '2001/2002', '2001-07-01', '2002-06-30', 0, '2026-01-25 01:00:00', '2026-01-25 01:00:00'),
(26, '2002/2003', '2002-07-01', '2003-06-30', 0, '2026-02-26 01:00:00', '2026-02-26 01:00:00'),
(27, '2003/2004', '2003-07-01', '2004-06-30', 0, '2026-03-27 01:00:00', '2026-03-27 01:00:00'),
(28, '2004/2005', '2004-07-01', '2005-06-30', 0, '2026-04-28 01:00:00', '2026-04-28 01:00:00'),
(29, '2005/2006', '2005-07-01', '2006-06-30', 0, '2026-05-01 01:00:00', '2026-05-01 01:00:00'),
(30, '2006/2007', '2006-07-01', '2007-06-30', 0, '2026-06-02 01:00:00', '2026-06-02 01:00:00'),
(31, '2007/2008', '2007-07-01', '2008-06-30', 0, '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(32, '2008/2009', '2008-07-01', '2009-06-30', 0, '2026-08-04 01:00:00', '2026-08-04 01:00:00'),
(33, '2009/2010', '2009-07-01', '2010-06-30', 0, '2026-09-05 01:00:00', '2026-09-05 01:00:00'),
(34, '2010/2011', '2010-07-01', '2011-06-30', 0, '2026-10-06 01:00:00', '2026-10-06 01:00:00'),
(35, '2011/2012', '2011-07-01', '2012-06-30', 0, '2026-11-07 01:00:00', '2026-11-07 01:00:00'),
(36, '2012/2013', '2012-07-01', '2013-06-30', 0, '2026-12-08 01:00:00', '2026-12-08 01:00:00'),
(37, '2013/2014', '2013-07-01', '2014-06-30', 0, '2026-01-09 01:00:00', '2026-01-09 01:00:00'),
(38, '2014/2015', '2014-07-01', '2015-06-30', 0, '2026-02-10 01:00:00', '2026-02-10 01:00:00'),
(39, '2015/2016', '2015-07-01', '2016-06-30', 0, '2026-03-11 01:00:00', '2026-03-11 01:00:00'),
(40, '2016/2017', '2016-07-01', '2017-06-30', 0, '2026-04-12 01:00:00', '2026-04-12 01:00:00'),
(41, '2017/2018', '2017-07-01', '2018-06-30', 0, '2026-05-13 01:00:00', '2026-05-13 01:00:00'),
(42, '2018/2019', '2018-07-01', '2019-06-30', 0, '2026-06-14 01:00:00', '2026-06-14 01:00:00'),
(43, '2019/2020', '2019-07-01', '2020-06-30', 0, '2026-07-15 01:00:00', '2026-07-15 01:00:00'),
(44, '2020/2021', '2020-07-01', '2021-06-30', 0, '2026-08-16 01:00:00', '2026-08-16 01:00:00'),
(45, '2021/2022', '2021-07-01', '2022-06-30', 0, '2026-09-17 01:00:00', '2026-09-17 01:00:00'),
(46, '2022/2023', '2022-07-01', '2023-06-30', 0, '2026-10-18 01:00:00', '2026-10-18 01:00:00'),
(47, '2023/2024', '2023-07-01', '2024-06-30', 0, '2026-11-19 01:00:00', '2026-11-19 01:00:00'),
(48, '2024/2025', '2024-07-01', '2025-06-30', 0, '2026-12-20 01:00:00', '2026-12-20 01:00:00'),
(49, '2025/2026', '2025-07-01', '2026-06-30', 0, '2026-01-21 01:00:00', '2026-01-21 01:00:00'),
(50, '2026/2027', '2026-07-01', '2027-06-30', 1, '2026-02-22 01:00:00', '2026-02-22 01:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_user`
--

CREATE TABLE `t_user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) NOT NULL,
  `role` varchar(225) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_user`
--

INSERT INTO `t_user` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'user01@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token01', 'admin', '2026-01-01 01:00:00', '2026-01-01 01:00:00'),
(2, 'Guru', 'user02@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token02', 'guru', '2026-02-02 01:00:00', '2026-02-02 01:00:00'),
(3, 'User 03', 'user03@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token03', 'admin', '2026-03-03 01:00:00', '2026-03-03 01:00:00'),
(4, 'User 04', 'user04@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token04', 'admin', '2026-04-04 01:00:00', '2026-04-04 01:00:00'),
(5, 'User 05', 'user05@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token05', 'guru', '2026-05-05 01:00:00', '2026-05-05 01:00:00'),
(6, 'User 06', 'user06@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token06', 'guru', '2026-06-06 01:00:00', '2026-06-06 01:00:00'),
(7, 'User 07', 'user07@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token07', 'admin', '2026-07-07 01:00:00', '2026-07-07 01:00:00'),
(8, 'User 08', 'user08@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token08', 'guru', '2026-08-08 01:00:00', '2026-08-08 01:00:00'),
(9, 'User 09', 'user09@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token09', 'admin', '2026-09-09 01:00:00', '2026-09-09 01:00:00'),
(10, 'User 10', 'user10@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token10', 'admin', '2026-10-10 01:00:00', '2026-10-10 01:00:00'),
(11, 'User 11', 'user11@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token11', 'guru', '2026-11-11 01:00:00', '2026-11-11 01:00:00'),
(12, 'User 12', 'user12@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token12', 'guru', '2026-12-12 01:00:00', '2026-12-12 01:00:00'),
(13, 'User 13', 'user13@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token13', 'admin', '2026-01-13 01:00:00', '2026-01-13 01:00:00'),
(14, 'User 14', 'user14@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token14', 'guru', '2026-02-14 01:00:00', '2026-02-14 01:00:00'),
(15, 'User 15', 'user15@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token15', 'admin', '2026-03-15 01:00:00', '2026-03-15 01:00:00'),
(16, 'User 16', 'user16@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token16', 'admin', '2026-04-16 01:00:00', '2026-04-16 01:00:00'),
(17, 'User 17', 'user17@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token17', 'guru', '2026-05-17 01:00:00', '2026-05-17 01:00:00'),
(18, 'User 18', 'user18@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token18', 'guru', '2026-06-18 01:00:00', '2026-06-18 01:00:00'),
(19, 'User 19', 'user19@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token19', 'admin', '2026-07-19 01:00:00', '2026-07-19 01:00:00'),
(20, 'User 20', 'user20@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token20', 'guru', '2026-08-20 01:00:00', '2026-08-20 01:00:00'),
(21, 'User 21', 'user21@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token21', 'admin', '2026-09-21 01:00:00', '2026-09-21 01:00:00'),
(22, 'User 22', 'user22@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token22', 'admin', '2026-10-22 01:00:00', '2026-10-22 01:00:00'),
(23, 'User 23', 'user23@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token23', 'guru', '2026-11-23 01:00:00', '2026-11-23 01:00:00'),
(24, 'User 24', 'user24@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token24', 'guru', '2026-12-24 01:00:00', '2026-12-24 01:00:00'),
(25, 'User 25', 'user25@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token25', 'admin', '2026-01-25 01:00:00', '2026-01-25 01:00:00'),
(26, 'User 26', 'user26@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token26', 'guru', '2026-02-26 01:00:00', '2026-02-26 01:00:00'),
(27, 'User 27', 'user27@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token27', 'admin', '2026-03-27 01:00:00', '2026-03-27 01:00:00'),
(28, 'User 28', 'user28@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token28', 'admin', '2026-04-28 01:00:00', '2026-04-28 01:00:00'),
(29, 'User 29', 'user29@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token29', 'guru', '2026-05-01 01:00:00', '2026-05-01 01:00:00'),
(30, 'User 30', 'user30@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token30', 'guru', '2026-06-02 01:00:00', '2026-06-02 01:00:00'),
(31, 'User 31', 'user31@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token31', 'admin', '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(32, 'User 32', 'user32@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token32', 'guru', '2026-08-04 01:00:00', '2026-08-04 01:00:00'),
(33, 'User 33', 'user33@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token33', 'admin', '2026-09-05 01:00:00', '2026-09-05 01:00:00'),
(34, 'User 34', 'user34@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token34', 'admin', '2026-10-06 01:00:00', '2026-10-06 01:00:00'),
(35, 'User 35', 'user35@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token35', 'guru', '2026-11-07 01:00:00', '2026-11-07 01:00:00'),
(36, 'User 36', 'user36@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token36', 'guru', '2026-12-08 01:00:00', '2026-12-08 01:00:00'),
(37, 'User 37', 'user37@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token37', 'admin', '2026-01-09 01:00:00', '2026-01-09 01:00:00'),
(38, 'User 38', 'user38@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token38', 'guru', '2026-02-10 01:00:00', '2026-02-10 01:00:00'),
(39, 'User 39', 'user39@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token39', 'admin', '2026-03-11 01:00:00', '2026-03-11 01:00:00'),
(40, 'User 40', 'user40@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token40', 'admin', '2026-04-12 01:00:00', '2026-04-12 01:00:00'),
(41, 'User 41', 'user41@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token41', 'guru', '2026-05-13 01:00:00', '2026-05-13 01:00:00'),
(42, 'User 42', 'user42@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token42', 'guru', '2026-06-14 01:00:00', '2026-06-14 01:00:00'),
(43, 'User 43', 'user43@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token43', 'admin', '2026-07-15 01:00:00', '2026-07-15 01:00:00'),
(44, 'User 44', 'user44@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token44', 'guru', '2026-08-16 01:00:00', '2026-08-16 01:00:00'),
(45, 'User 45', 'user45@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token45', 'admin', '2026-09-17 01:00:00', '2026-09-17 01:00:00'),
(46, 'User 46', 'user46@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token46', 'admin', '2026-10-18 01:00:00', '2026-10-18 01:00:00'),
(47, 'User 47', 'user47@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token47', 'guru', '2026-11-19 01:00:00', '2026-11-19 01:00:00'),
(48, 'User 48', 'user48@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token48', 'guru', '2026-12-20 01:00:00', '2026-12-20 01:00:00'),
(49, 'User 49', 'user49@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token49', 'admin', '2026-01-21 01:00:00', '2026-01-21 01:00:00'),
(50, 'User 50', 'user50@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token50', 'guru', '2026-02-22 01:00:00', '2026-02-22 01:00:00'),
(51, 'User 51', 'user51@ukk2026.test', '2026-10-01 00:40:27', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token 51', 'admin', '2026-10-01 00:40:27', '2026-10-01 00:40:27'),
(52, 'Guru Ilmu Pengetahuan Alam', 'guru51@ukk2026.test', '2026-10-22 00:45:15', '$2y$10$saeso1kT9WppL33kd9CsZOTQTgVEljVxQQ5YZx1wF/5c3.9FviATq', '', 'guru', '2026-10-22 00:45:15', '2026-10-22 00:45:15'),
(53, 'Guru Matematika', 'gasfa7ye@gmail.com', '2026-10-22 01:00:17', '$2y$10$Ac26YDkrGwpXSDk2Hh3qN.Gx2Pg0pL07368.Lm7i653e2XtAMtfHy', '', 'guru', '2026-10-22 01:00:17', '2026-10-22 01:00:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_wali_kelas`
--

CREATE TABLE `t_wali_kelas` (
  `id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `guru_id` int(11) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_wali_kelas`
--

INSERT INTO `t_wali_kelas` (`id`, `tahun_ajaran_id`, `kelas_id`, `guru_id`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '1977-07-01', '1978-06-30', 1, '2026-01-01 01:00:00', '2026-01-01 01:00:00'),
(2, 1, 2, 2, '1977-07-01', '1978-06-30', 1, '2026-02-02 01:00:00', '2026-02-02 01:00:00'),
(3, 1, 3, 3, '1977-07-01', '1978-06-30', 1, '2026-03-03 01:00:00', '2026-03-03 01:00:00'),
(4, 1, 4, 4, '1977-07-01', '1978-06-30', 1, '2026-04-04 01:00:00', '2026-04-04 01:00:00'),
(5, 1, 5, 5, '1977-07-01', '1978-06-30', 1, '2026-05-05 01:00:00', '2026-05-05 01:00:00'),
(6, 1, 6, 6, '1977-07-01', '1978-06-30', 1, '2026-06-06 01:00:00', '2026-06-06 01:00:00'),
(7, 1, 7, 7, '1977-07-01', '1978-06-30', 1, '2026-07-07 01:00:00', '2026-07-07 01:00:00'),
(8, 1, 8, 8, '1977-07-01', '1978-06-30', 1, '2026-08-08 01:00:00', '2026-08-08 01:00:00'),
(9, 1, 9, 9, '1977-07-01', '1978-06-30', 1, '2026-09-09 01:00:00', '2026-09-09 01:00:00'),
(10, 1, 10, 10, '1977-07-01', '1978-06-30', 1, '2026-10-10 01:00:00', '2026-10-10 01:00:00'),
(11, 2, 1, 11, '1978-07-01', '1979-06-30', 1, '2026-11-11 01:00:00', '2026-11-11 01:00:00'),
(12, 2, 2, 12, '1978-07-01', '1979-06-30', 1, '2026-12-12 01:00:00', '2026-12-12 01:00:00'),
(13, 2, 3, 13, '1978-07-01', '1979-06-30', 1, '2026-01-13 01:00:00', '2026-01-13 01:00:00'),
(14, 2, 4, 14, '1978-07-01', '1979-06-30', 1, '2026-02-14 01:00:00', '2026-02-14 01:00:00'),
(15, 2, 5, 15, '1978-07-01', '1979-06-30', 1, '2026-03-15 01:00:00', '2026-03-15 01:00:00'),
(16, 2, 6, 16, '1978-07-01', '1979-06-30', 1, '2026-04-16 01:00:00', '2026-04-16 01:00:00'),
(17, 2, 7, 17, '1978-07-01', '1979-06-30', 1, '2026-05-17 01:00:00', '2026-05-17 01:00:00'),
(18, 2, 8, 18, '1978-07-01', '1979-06-30', 1, '2026-06-18 01:00:00', '2026-06-18 01:00:00'),
(19, 2, 9, 19, '1978-07-01', '1979-06-30', 1, '2026-07-19 01:00:00', '2026-07-19 01:00:00'),
(20, 2, 10, 20, '1978-07-01', '1979-06-30', 1, '2026-08-20 01:00:00', '2026-08-20 01:00:00'),
(21, 3, 1, 21, '1979-07-01', '1980-06-30', 1, '2026-09-21 01:00:00', '2026-09-21 01:00:00'),
(22, 3, 2, 22, '1979-07-01', '1980-06-30', 1, '2026-10-22 01:00:00', '2026-10-22 01:00:00'),
(23, 3, 3, 23, '1979-07-01', '1980-06-30', 1, '2026-11-23 01:00:00', '2026-11-23 01:00:00'),
(24, 3, 4, 24, '1979-07-01', '1980-06-30', 1, '2026-12-24 01:00:00', '2026-12-24 01:00:00'),
(25, 3, 5, 25, '1979-07-01', '1980-06-30', 1, '2026-01-25 01:00:00', '2026-01-25 01:00:00'),
(26, 3, 6, 26, '1979-07-01', '1980-06-30', 1, '2026-02-26 01:00:00', '2026-02-26 01:00:00'),
(27, 3, 7, 27, '1979-07-01', '1980-06-30', 1, '2026-03-27 01:00:00', '2026-03-27 01:00:00'),
(28, 3, 8, 28, '1979-07-01', '1980-06-30', 1, '2026-04-28 01:00:00', '2026-04-28 01:00:00'),
(29, 3, 9, 29, '1979-07-01', '1980-06-30', 1, '2026-05-01 01:00:00', '2026-05-01 01:00:00'),
(30, 3, 10, 30, '1979-07-01', '1980-06-30', 1, '2026-06-02 01:00:00', '2026-06-02 01:00:00'),
(31, 4, 1, 31, '1980-07-01', '1981-06-30', 1, '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(32, 4, 2, 32, '1980-07-01', '1981-06-30', 1, '2026-08-04 01:00:00', '2026-08-04 01:00:00'),
(33, 4, 3, 33, '1980-07-01', '1981-06-30', 1, '2026-09-05 01:00:00', '2026-09-05 01:00:00'),
(34, 4, 4, 34, '1980-07-01', '1981-06-30', 1, '2026-10-06 01:00:00', '2026-10-06 01:00:00'),
(35, 4, 5, 35, '1980-07-01', '1981-06-30', 1, '2026-11-07 01:00:00', '2026-11-07 01:00:00'),
(36, 4, 6, 36, '1980-07-01', '1981-06-30', 1, '2026-12-08 01:00:00', '2026-12-08 01:00:00'),
(37, 4, 7, 37, '1980-07-01', '1981-06-30', 1, '2026-01-09 01:00:00', '2026-01-09 01:00:00'),
(38, 4, 8, 38, '1980-07-01', '1981-06-30', 1, '2026-02-10 01:00:00', '2026-02-10 01:00:00'),
(39, 4, 9, 39, '1980-07-01', '1981-06-30', 1, '2026-03-11 01:00:00', '2026-03-11 01:00:00'),
(40, 4, 10, 40, '1980-07-01', '1981-06-30', 1, '2026-04-12 01:00:00', '2026-04-12 01:00:00'),
(41, 5, 1, 41, '1981-07-01', '1982-06-30', 1, '2026-05-13 01:00:00', '2026-05-13 01:00:00'),
(42, 5, 2, 42, '1981-07-01', '1982-06-30', 1, '2026-06-14 01:00:00', '2026-06-14 01:00:00'),
(43, 5, 3, 43, '1981-07-01', '1982-06-30', 1, '2026-07-15 01:00:00', '2026-07-15 01:00:00'),
(44, 5, 4, 44, '1981-07-01', '1982-06-30', 1, '2026-08-16 01:00:00', '2026-08-16 01:00:00'),
(45, 5, 5, 45, '1981-07-01', '1982-06-30', 1, '2026-09-17 01:00:00', '2026-09-17 01:00:00'),
(46, 5, 6, 46, '1981-07-01', '1982-06-30', 1, '2026-10-18 01:00:00', '2026-10-18 01:00:00'),
(47, 5, 7, 47, '1981-07-01', '1982-06-30', 1, '2026-11-19 01:00:00', '2026-11-19 01:00:00'),
(48, 5, 8, 48, '1981-07-01', '1982-06-30', 1, '2026-12-20 01:00:00', '2026-12-20 01:00:00'),
(49, 5, 9, 49, '1981-07-01', '1982-06-30', 1, '2026-01-21 01:00:00', '2026-01-21 01:00:00'),
(50, 5, 10, 50, '1981-07-01', '1982-06-30', 1, '2026-02-22 01:00:00', '2026-02-22 01:00:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_guru`
--
ALTER TABLE `t_guru`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_kelas`
--
ALTER TABLE `t_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indeks untuk tabel `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggaran_kategori_id` (`pelanggaran_kategori_id`);

--
-- Indeks untuk tabel `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `pelanggaran_id` (`pelanggaran_id`),
  ADD KEY `pelanggaran_kategori_id` (`pelanggaran_kategori_id`),
  ADD KEY `guru_id` (`guru_id`);

--
-- Indeks untuk tabel `t_siswa`
--
ALTER TABLE `t_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `db_ukk_2026` (`tahun_ajaran_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `guru_id` (`guru_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_guru`
--
ALTER TABLE `t_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `t_kelas`
--
ALTER TABLE `t_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `t_siswa`
--
ALTER TABLE `t_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  ADD CONSTRAINT `t_kelas_siswa_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `t_siswa` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_kelas_siswa_ibfk_2` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_kelas_siswa_ibfk_3` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  ADD CONSTRAINT `t_pelanggaran_kategori_ibfk_1` FOREIGN KEY (`id`) REFERENCES `t_pelanggaran` (`pelanggaran_kategori_id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_1` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `t_siswa` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_3` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_4` FOREIGN KEY (`pelanggaran_id`) REFERENCES `t_pelanggaran` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_5` FOREIGN KEY (`pelanggaran_kategori_id`) REFERENCES `t_pelanggaran_kategori` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_6` FOREIGN KEY (`guru_id`) REFERENCES `t_guru` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  ADD CONSTRAINT `db_ukk_2026` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`),
  ADD CONSTRAINT `t_wali_kelas_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`),
  ADD CONSTRAINT `t_wali_kelas_ibfk_2` FOREIGN KEY (`guru_id`) REFERENCES `t_guru` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
