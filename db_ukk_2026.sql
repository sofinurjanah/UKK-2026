-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Sep 2026 pada 07.27
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

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
(1, 'NIP20260001', 'Guru 01', 'guru01@ukk2026.test', 1, 1, '2026-01-01 01:00:00', '2026-01-01 01:00:00'),
(2, 'NIP20260002', 'Guru 02', 'guru02@ukk2026.test', 1, 2, '2026-02-02 01:00:00', '2026-02-02 01:00:00'),
(3, 'NIP20260003', 'Guru 03', 'guru03@ukk2026.test', 1, 3, '2026-03-03 01:00:00', '2026-03-03 01:00:00'),
(4, 'NIP20260004', 'Guru 04', 'guru04@ukk2026.test', 1, 4, '2026-04-04 01:00:00', '2026-04-04 01:00:00'),
(5, 'NIP20260005', 'Guru 05', 'guru05@ukk2026.test', 1, 5, '2026-05-05 01:00:00', '2026-05-05 01:00:00'),
(6, 'NIP20260006', 'Guru 06', 'guru06@ukk2026.test', 1, 6, '2026-06-06 01:00:00', '2026-06-06 01:00:00'),
(7, 'NIP20260007', 'Guru 07', 'guru07@ukk2026.test', 1, 7, '2026-07-07 01:00:00', '2026-07-07 01:00:00'),
(8, 'NIP20260008', 'Guru 08', 'guru08@ukk2026.test', 1, 8, '2026-08-08 01:00:00', '2026-08-08 01:00:00'),
(9, 'NIP20260009', 'Guru 09', 'guru09@ukk2026.test', 1, 9, '2026-09-09 01:00:00', '2026-09-09 01:00:00'),
(10, 'NIP20260010', 'Guru 10', 'guru10@ukk2026.test', 1, 10, '2026-10-10 01:00:00', '2026-10-10 01:00:00'),
(11, 'NIP20260011', 'Guru 11', 'guru11@ukk2026.test', 1, 11, '2026-11-11 01:00:00', '2026-11-11 01:00:00'),
(12, 'NIP20260012', 'Guru 12', 'guru12@ukk2026.test', 1, 12, '2026-12-12 01:00:00', '2026-12-12 01:00:00'),
(13, 'NIP20260013', 'Guru 13', 'guru13@ukk2026.test', 1, 13, '2026-01-13 01:00:00', '2026-01-13 01:00:00'),
(14, 'NIP20260014', 'Guru 14', 'guru14@ukk2026.test', 1, 14, '2026-02-14 01:00:00', '2026-02-14 01:00:00'),
(15, 'NIP20260015', 'Guru 15', 'guru15@ukk2026.test', 1, 15, '2026-03-15 01:00:00', '2026-03-15 01:00:00'),
(16, 'NIP20260016', 'Guru 16', 'guru16@ukk2026.test', 1, 16, '2026-04-16 01:00:00', '2026-04-16 01:00:00'),
(17, 'NIP20260017', 'Guru 17', 'guru17@ukk2026.test', 1, 17, '2026-05-17 01:00:00', '2026-05-17 01:00:00'),
(18, 'NIP20260018', 'Guru 18', 'guru18@ukk2026.test', 1, 18, '2026-06-18 01:00:00', '2026-06-18 01:00:00'),
(19, 'NIP20260019', 'Guru 19', 'guru19@ukk2026.test', 1, 19, '2026-07-19 01:00:00', '2026-07-19 01:00:00'),
(20, 'NIP20260020', 'Guru 20', 'guru20@ukk2026.test', 1, 20, '2026-08-20 01:00:00', '2026-08-20 01:00:00'),
(21, 'NIP20260021', 'Guru 21', 'guru21@ukk2026.test', 1, 21, '2026-09-21 01:00:00', '2026-09-21 01:00:00'),
(22, 'NIP20260022', 'Guru 22', 'guru22@ukk2026.test', 1, 22, '2026-10-22 01:00:00', '2026-10-22 01:00:00'),
(23, 'NIP20260023', 'Guru 23', 'guru23@ukk2026.test', 1, 23, '2026-11-23 01:00:00', '2026-11-23 01:00:00'),
(24, 'NIP20260024', 'Guru 24', 'guru24@ukk2026.test', 1, 24, '2026-12-24 01:00:00', '2026-12-24 01:00:00'),
(25, 'NIP20260025', 'Guru 25', 'guru25@ukk2026.test', 1, 25, '2026-01-25 01:00:00', '2026-01-25 01:00:00'),
(26, 'NIP20260026', 'Guru 26', 'guru26@ukk2026.test', 1, 26, '2026-02-26 01:00:00', '2026-02-26 01:00:00'),
(27, 'NIP20260027', 'Guru 27', 'guru27@ukk2026.test', 1, 27, '2026-03-27 01:00:00', '2026-03-27 01:00:00'),
(28, 'NIP20260028', 'Guru 28', 'guru28@ukk2026.test', 1, 28, '2026-04-28 01:00:00', '2026-04-28 01:00:00'),
(29, 'NIP20260029', 'Guru 29', 'guru29@ukk2026.test', 1, 29, '2026-05-01 01:00:00', '2026-05-01 01:00:00'),
(30, 'NIP20260030', 'Guru 30', 'guru30@ukk2026.test', 1, 30, '2026-06-02 01:00:00', '2026-06-02 01:00:00'),
(31, 'NIP20260031', 'Guru 31', 'guru31@ukk2026.test', 1, 31, '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(32, 'NIP20260032', 'Guru 32', 'guru32@ukk2026.test', 1, 32, '2026-08-04 01:00:00', '2026-08-04 01:00:00'),
(33, 'NIP20260033', 'Guru 33', 'guru33@ukk2026.test', 1, 33, '2026-09-05 01:00:00', '2026-09-05 01:00:00'),
(34, 'NIP20260034', 'Guru 34', 'guru34@ukk2026.test', 1, 34, '2026-10-06 01:00:00', '2026-10-06 01:00:00'),
(35, 'NIP20260035', 'Guru 35', 'guru35@ukk2026.test', 1, 35, '2026-11-07 01:00:00', '2026-11-07 01:00:00'),
(36, 'NIP20260036', 'Guru 36', 'guru36@ukk2026.test', 1, 36, '2026-12-08 01:00:00', '2026-12-08 01:00:00'),
(37, 'NIP20260037', 'Guru 37', 'guru37@ukk2026.test', 1, 37, '2026-01-09 01:00:00', '2026-01-09 01:00:00'),
(38, 'NIP20260038', 'Guru 38', 'guru38@ukk2026.test', 1, 38, '2026-02-10 01:00:00', '2026-02-10 01:00:00'),
(39, 'NIP20260039', 'Guru 39', 'guru39@ukk2026.test', 1, 39, '2026-03-11 01:00:00', '2026-03-11 01:00:00'),
(40, 'NIP20260040', 'Guru 40', 'guru40@ukk2026.test', 1, 40, '2026-04-12 01:00:00', '2026-04-12 01:00:00'),
(41, 'NIP20260041', 'Guru 41', 'guru41@ukk2026.test', 1, 41, '2026-05-13 01:00:00', '2026-05-13 01:00:00'),
(42, 'NIP20260042', 'Guru 42', 'guru42@ukk2026.test', 1, 42, '2026-06-14 01:00:00', '2026-06-14 01:00:00'),
(43, 'NIP20260043', 'Guru 43', 'guru43@ukk2026.test', 1, 43, '2026-07-15 01:00:00', '2026-07-15 01:00:00'),
(44, 'NIP20260044', 'Guru 44', 'guru44@ukk2026.test', 1, 44, '2026-08-16 01:00:00', '2026-08-16 01:00:00'),
(45, 'NIP20260045', 'Guru 45', 'guru45@ukk2026.test', 1, 45, '2026-09-17 01:00:00', '2026-09-17 01:00:00'),
(46, 'NIP20260046', 'Guru 46', 'guru46@ukk2026.test', 1, 46, '2026-10-18 01:00:00', '2026-10-18 01:00:00'),
(47, 'NIP20260047', 'Guru 47', 'guru47@ukk2026.test', 1, 47, '2026-11-19 01:00:00', '2026-11-19 01:00:00'),
(48, 'NIP20260048', 'Guru 48', 'guru48@ukk2026.test', 1, 48, '2026-12-20 01:00:00', '2026-12-20 01:00:00'),
(49, 'NIP20260049', 'Guru 49', 'guru49@ukk2026.test', 1, 49, '2026-01-21 01:00:00', '2026-01-21 01:00:00'),
(50, 'NIP20260050', 'Guru 50', 'guru50@ukk2026.test', 1, 50, '2026-02-22 01:00:00', '2026-02-22 01:00:00');

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
(50, 50, 5, 10, '1981-07-01', '1982-06-30', 1, '2026-01-22 01:00:00', '2026-01-22 01:00:00');

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
(1, 1, 'PLG001', 'Terlambat 01', 1, 'Deskripsi pelanggaran 01', 1, '2026-01-01 01:00:00', '2026-01-01 01:00:00'),
(2, 2, 'PLG002', 'Tidak memakai atribut lengkap 02', 2, 'Deskripsi pelanggaran 02', 1, '2026-02-02 01:00:00', '2026-02-02 01:00:00'),
(3, 3, 'PLG003', 'Tidak hadir tanpa keterangan 03', 3, 'Deskripsi pelanggaran 03', 1, '2026-03-03 01:00:00', '2026-03-03 01:00:00'),
(4, 4, 'PLG004', 'Rambut tidak sesuai aturan 04', 4, 'Deskripsi pelanggaran 04', 1, '2026-04-04 01:00:00', '2026-04-04 01:00:00'),
(5, 5, 'PLG005', 'Tidak mengerjakan tugas 05', 5, 'Deskripsi pelanggaran 05', 1, '2026-05-05 01:00:00', '2026-05-05 01:00:00'),
(6, 6, 'PLG006', 'Terlambat 06', 1, 'Deskripsi pelanggaran 06', 1, '2026-06-06 01:00:00', '2026-06-06 01:00:00'),
(7, 7, 'PLG007', 'Tidak memakai atribut lengkap 07', 2, 'Deskripsi pelanggaran 07', 1, '2026-07-07 01:00:00', '2026-07-07 01:00:00'),
(8, 8, 'PLG008', 'Tidak hadir tanpa keterangan 08', 3, 'Deskripsi pelanggaran 08', 1, '2026-08-08 01:00:00', '2026-08-08 01:00:00'),
(9, 9, 'PLG009', 'Rambut tidak sesuai aturan 09', 4, 'Deskripsi pelanggaran 09', 1, '2026-09-09 01:00:00', '2026-09-09 01:00:00'),
(10, 10, 'PLG010', 'Tidak mengerjakan tugas 10', 5, 'Deskripsi pelanggaran 10', 1, '2026-10-10 01:00:00', '2026-10-10 01:00:00'),
(11, 11, 'PLG011', 'Terlambat 11', 1, 'Deskripsi pelanggaran 11', 1, '2026-11-11 01:00:00', '2026-11-11 01:00:00'),
(12, 12, 'PLG012', 'Tidak memakai atribut lengkap 12', 2, 'Deskripsi pelanggaran 12', 1, '2026-12-12 01:00:00', '2026-12-12 01:00:00'),
(13, 13, 'PLG013', 'Tidak hadir tanpa keterangan 13', 3, 'Deskripsi pelanggaran 13', 1, '2026-01-13 01:00:00', '2026-01-13 01:00:00'),
(14, 14, 'PLG014', 'Rambut tidak sesuai aturan 14', 4, 'Deskripsi pelanggaran 14', 1, '2026-02-14 01:00:00', '2026-02-14 01:00:00'),
(15, 15, 'PLG015', 'Tidak mengerjakan tugas 15', 5, 'Deskripsi pelanggaran 15', 1, '2026-03-15 01:00:00', '2026-03-15 01:00:00'),
(16, 16, 'PLG016', 'Terlambat 16', 1, 'Deskripsi pelanggaran 16', 1, '2026-04-16 01:00:00', '2026-04-16 01:00:00'),
(17, 17, 'PLG017', 'Tidak memakai atribut lengkap 17', 2, 'Deskripsi pelanggaran 17', 1, '2026-05-17 01:00:00', '2026-05-17 01:00:00'),
(18, 18, 'PLG018', 'Tidak hadir tanpa keterangan 18', 3, 'Deskripsi pelanggaran 18', 1, '2026-06-18 01:00:00', '2026-06-18 01:00:00'),
(19, 19, 'PLG019', 'Rambut tidak sesuai aturan 19', 4, 'Deskripsi pelanggaran 19', 1, '2026-07-19 01:00:00', '2026-07-19 01:00:00'),
(20, 20, 'PLG020', 'Tidak mengerjakan tugas 20', 5, 'Deskripsi pelanggaran 20', 1, '2026-08-20 01:00:00', '2026-08-20 01:00:00'),
(21, 21, 'PLG021', 'Terlambat 21', 1, 'Deskripsi pelanggaran 21', 1, '2026-09-21 01:00:00', '2026-09-21 01:00:00'),
(22, 22, 'PLG022', 'Tidak memakai atribut lengkap 22', 2, 'Deskripsi pelanggaran 22', 1, '2026-10-22 01:00:00', '2026-10-22 01:00:00'),
(23, 23, 'PLG023', 'Tidak hadir tanpa keterangan 23', 3, 'Deskripsi pelanggaran 23', 1, '2026-11-23 01:00:00', '2026-11-23 01:00:00'),
(24, 24, 'PLG024', 'Rambut tidak sesuai aturan 24', 4, 'Deskripsi pelanggaran 24', 1, '2026-12-24 01:00:00', '2026-12-24 01:00:00'),
(25, 25, 'PLG025', 'Tidak mengerjakan tugas 25', 5, 'Deskripsi pelanggaran 25', 1, '2026-01-25 01:00:00', '2026-01-25 01:00:00'),
(26, 26, 'PLG026', 'Terlambat 26', 1, 'Deskripsi pelanggaran 26', 1, '2026-02-26 01:00:00', '2026-02-26 01:00:00'),
(27, 27, 'PLG027', 'Tidak memakai atribut lengkap 27', 2, 'Deskripsi pelanggaran 27', 1, '2026-03-27 01:00:00', '2026-03-27 01:00:00'),
(28, 28, 'PLG028', 'Tidak hadir tanpa keterangan 28', 3, 'Deskripsi pelanggaran 28', 1, '2026-04-28 01:00:00', '2026-04-28 01:00:00'),
(29, 29, 'PLG029', 'Rambut tidak sesuai aturan 29', 4, 'Deskripsi pelanggaran 29', 1, '2026-05-01 01:00:00', '2026-05-01 01:00:00'),
(30, 30, 'PLG030', 'Tidak mengerjakan tugas 30', 5, 'Deskripsi pelanggaran 30', 1, '2026-06-02 01:00:00', '2026-06-02 01:00:00'),
(31, 31, 'PLG031', 'Terlambat 31', 1, 'Deskripsi pelanggaran 31', 1, '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(32, 32, 'PLG032', 'Tidak memakai atribut lengkap 32', 2, 'Deskripsi pelanggaran 32', 1, '2026-08-04 01:00:00', '2026-08-04 01:00:00'),
(33, 33, 'PLG033', 'Tidak hadir tanpa keterangan 33', 3, 'Deskripsi pelanggaran 33', 1, '2026-09-05 01:00:00', '2026-09-05 01:00:00'),
(34, 34, 'PLG034', 'Rambut tidak sesuai aturan 34', 4, 'Deskripsi pelanggaran 34', 1, '2026-10-06 01:00:00', '2026-10-06 01:00:00'),
(35, 35, 'PLG035', 'Tidak mengerjakan tugas 35', 5, 'Deskripsi pelanggaran 35', 1, '2026-11-07 01:00:00', '2026-11-07 01:00:00'),
(36, 36, 'PLG036', 'Terlambat 36', 1, 'Deskripsi pelanggaran 36', 1, '2026-12-08 01:00:00', '2026-12-08 01:00:00'),
(37, 37, 'PLG037', 'Tidak memakai atribut lengkap 37', 2, 'Deskripsi pelanggaran 37', 1, '2026-01-09 01:00:00', '2026-01-09 01:00:00'),
(38, 38, 'PLG038', 'Tidak hadir tanpa keterangan 38', 3, 'Deskripsi pelanggaran 38', 1, '2026-02-10 01:00:00', '2026-02-10 01:00:00'),
(39, 39, 'PLG039', 'Rambut tidak sesuai aturan 39', 4, 'Deskripsi pelanggaran 39', 1, '2026-03-11 01:00:00', '2026-03-11 01:00:00'),
(40, 40, 'PLG040', 'Tidak mengerjakan tugas 40', 5, 'Deskripsi pelanggaran 40', 1, '2026-04-12 01:00:00', '2026-04-12 01:00:00'),
(41, 41, 'PLG041', 'Terlambat 41', 1, 'Deskripsi pelanggaran 41', 1, '2026-05-13 01:00:00', '2026-05-13 01:00:00'),
(42, 42, 'PLG042', 'Tidak memakai atribut lengkap 42', 2, 'Deskripsi pelanggaran 42', 1, '2026-06-14 01:00:00', '2026-06-14 01:00:00'),
(43, 43, 'PLG043', 'Tidak hadir tanpa keterangan 43', 3, 'Deskripsi pelanggaran 43', 1, '2026-07-15 01:00:00', '2026-07-15 01:00:00'),
(44, 44, 'PLG044', 'Rambut tidak sesuai aturan 44', 4, 'Deskripsi pelanggaran 44', 1, '2026-08-16 01:00:00', '2026-08-16 01:00:00'),
(45, 45, 'PLG045', 'Tidak mengerjakan tugas 45', 5, 'Deskripsi pelanggaran 45', 1, '2026-09-17 01:00:00', '2026-09-17 01:00:00'),
(46, 46, 'PLG046', 'Terlambat 46', 1, 'Deskripsi pelanggaran 46', 1, '2026-10-18 01:00:00', '2026-10-18 01:00:00'),
(47, 47, 'PLG047', 'Tidak memakai atribut lengkap 47', 2, 'Deskripsi pelanggaran 47', 1, '2026-11-19 01:00:00', '2026-11-19 01:00:00'),
(48, 48, 'PLG048', 'Tidak hadir tanpa keterangan 48', 3, 'Deskripsi pelanggaran 48', 1, '2026-12-20 01:00:00', '2026-12-20 01:00:00'),
(49, 49, 'PLG049', 'Rambut tidak sesuai aturan 49', 4, 'Deskripsi pelanggaran 49', 1, '2026-01-21 01:00:00', '2026-01-21 01:00:00'),
(50, 50, 'PLG050', 'Tidak mengerjakan tugas 50', 5, 'Deskripsi pelanggaran 50', 1, '2026-02-22 01:00:00', '2026-02-22 01:00:00');

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
(1, 'Kedisiplinan 1', 'Kategori pelanggaran 01', 1, '2026-01-01 01:00:00', '2026-01-01 01:00:00'),
(2, 'Kerapihan 1', 'Kategori pelanggaran 02', 1, '2026-02-02 01:00:00', '2026-02-02 01:00:00'),
(3, 'Kehadiran 1', 'Kategori pelanggaran 03', 1, '2026-03-03 01:00:00', '2026-03-03 01:00:00'),
(4, 'Sikap 1', 'Kategori pelanggaran 04', 1, '2026-04-04 01:00:00', '2026-04-04 01:00:00'),
(5, 'Akademik 1', 'Kategori pelanggaran 05', 1, '2026-05-05 01:00:00', '2026-05-05 01:00:00'),
(6, 'Kedisiplinan 2', 'Kategori pelanggaran 06', 1, '2026-06-06 01:00:00', '2026-06-06 01:00:00'),
(7, 'Kerapihan 2', 'Kategori pelanggaran 07', 1, '2026-07-07 01:00:00', '2026-07-07 01:00:00'),
(8, 'Kehadiran 2', 'Kategori pelanggaran 08', 1, '2026-08-08 01:00:00', '2026-08-08 01:00:00'),
(9, 'Sikap 2', 'Kategori pelanggaran 09', 1, '2026-09-09 01:00:00', '2026-09-09 01:00:00'),
(10, 'Akademik 2', 'Kategori pelanggaran 10', 1, '2026-10-10 01:00:00', '2026-10-10 01:00:00'),
(11, 'Kedisiplinan 3', 'Kategori pelanggaran 11', 1, '2026-11-11 01:00:00', '2026-11-11 01:00:00'),
(12, 'Kerapihan 3', 'Kategori pelanggaran 12', 1, '2026-12-12 01:00:00', '2026-12-12 01:00:00'),
(13, 'Kehadiran 3', 'Kategori pelanggaran 13', 1, '2026-01-13 01:00:00', '2026-01-13 01:00:00'),
(14, 'Sikap 3', 'Kategori pelanggaran 14', 1, '2026-02-14 01:00:00', '2026-02-14 01:00:00'),
(15, 'Akademik 3', 'Kategori pelanggaran 15', 1, '2026-03-15 01:00:00', '2026-03-15 01:00:00'),
(16, 'Kedisiplinan 4', 'Kategori pelanggaran 16', 1, '2026-04-16 01:00:00', '2026-04-16 01:00:00'),
(17, 'Kerapihan 4', 'Kategori pelanggaran 17', 1, '2026-05-17 01:00:00', '2026-05-17 01:00:00'),
(18, 'Kehadiran 4', 'Kategori pelanggaran 18', 1, '2026-06-18 01:00:00', '2026-06-18 01:00:00'),
(19, 'Sikap 4', 'Kategori pelanggaran 19', 1, '2026-07-19 01:00:00', '2026-07-19 01:00:00'),
(20, 'Akademik 4', 'Kategori pelanggaran 20', 1, '2026-08-20 01:00:00', '2026-08-20 01:00:00'),
(21, 'Kedisiplinan 5', 'Kategori pelanggaran 21', 1, '2026-09-21 01:00:00', '2026-09-21 01:00:00'),
(22, 'Kerapihan 5', 'Kategori pelanggaran 22', 1, '2026-10-22 01:00:00', '2026-10-22 01:00:00'),
(23, 'Kehadiran 5', 'Kategori pelanggaran 23', 1, '2026-11-23 01:00:00', '2026-11-23 01:00:00'),
(24, 'Sikap 5', 'Kategori pelanggaran 24', 1, '2026-12-24 01:00:00', '2026-12-24 01:00:00'),
(25, 'Akademik 5', 'Kategori pelanggaran 25', 1, '2026-01-25 01:00:00', '2026-01-25 01:00:00'),
(26, 'Kedisiplinan 6', 'Kategori pelanggaran 26', 1, '2026-02-26 01:00:00', '2026-02-26 01:00:00'),
(27, 'Kerapihan 6', 'Kategori pelanggaran 27', 1, '2026-03-27 01:00:00', '2026-03-27 01:00:00'),
(28, 'Kehadiran 6', 'Kategori pelanggaran 28', 1, '2026-04-28 01:00:00', '2026-04-28 01:00:00'),
(29, 'Sikap 6', 'Kategori pelanggaran 29', 1, '2026-05-01 01:00:00', '2026-05-01 01:00:00'),
(30, 'Akademik 6', 'Kategori pelanggaran 30', 1, '2026-06-02 01:00:00', '2026-06-02 01:00:00'),
(31, 'Kedisiplinan 7', 'Kategori pelanggaran 31', 1, '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(32, 'Kerapihan 7', 'Kategori pelanggaran 32', 1, '2026-08-04 01:00:00', '2026-08-04 01:00:00'),
(33, 'Kehadiran 7', 'Kategori pelanggaran 33', 1, '2026-09-05 01:00:00', '2026-09-05 01:00:00'),
(34, 'Sikap 7', 'Kategori pelanggaran 34', 1, '2026-10-06 01:00:00', '2026-10-06 01:00:00'),
(35, 'Akademik 7', 'Kategori pelanggaran 35', 1, '2026-11-07 01:00:00', '2026-11-07 01:00:00'),
(36, 'Kedisiplinan 8', 'Kategori pelanggaran 36', 1, '2026-12-08 01:00:00', '2026-12-08 01:00:00'),
(37, 'Kerapihan 8', 'Kategori pelanggaran 37', 1, '2026-01-09 01:00:00', '2026-01-09 01:00:00'),
(38, 'Kehadiran 8', 'Kategori pelanggaran 38', 1, '2026-02-10 01:00:00', '2026-02-10 01:00:00'),
(39, 'Sikap 8', 'Kategori pelanggaran 39', 1, '2026-03-11 01:00:00', '2026-03-11 01:00:00'),
(40, 'Akademik 8', 'Kategori pelanggaran 40', 1, '2026-04-12 01:00:00', '2026-04-12 01:00:00'),
(41, 'Kedisiplinan 9', 'Kategori pelanggaran 41', 1, '2026-05-13 01:00:00', '2026-05-13 01:00:00'),
(42, 'Kerapihan 9', 'Kategori pelanggaran 42', 1, '2026-06-14 01:00:00', '2026-06-14 01:00:00'),
(43, 'Kehadiran 9', 'Kategori pelanggaran 43', 1, '2026-07-15 01:00:00', '2026-07-15 01:00:00'),
(44, 'Sikap 9', 'Kategori pelanggaran 44', 1, '2026-08-16 01:00:00', '2026-08-16 01:00:00'),
(45, 'Akademik 9', 'Kategori pelanggaran 45', 1, '2026-09-17 01:00:00', '2026-09-17 01:00:00'),
(46, 'Kedisiplinan 10', 'Kategori pelanggaran 46', 1, '2026-10-18 01:00:00', '2026-10-18 01:00:00'),
(47, 'Kerapihan 10', 'Kategori pelanggaran 47', 1, '2026-11-19 01:00:00', '2026-11-19 01:00:00'),
(48, 'Kehadiran 10', 'Kategori pelanggaran 48', 1, '2026-12-20 01:00:00', '2026-12-20 01:00:00'),
(49, 'Sikap 10', 'Kategori pelanggaran 49', 1, '2026-01-21 01:00:00', '2026-01-21 01:00:00'),
(50, 'Akademik 10', 'Kategori pelanggaran 50', 1, '2026-02-22 01:00:00', '2026-02-22 01:00:00');

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
(1, 1, 1, 'Andi Saputra 01', 1, 'X RPL 1', 1, 'Terlambat 01', 1, 1, 'Guru 01', '2026-01-01', 'Kejadian pelanggaran 01', 1, 'Tindakan 01', 'Teguran', '2026-01-01 02:00:00', '2026-01-01 02:00:00'),
(2, 1, 2, 'Budi Saputra 02', 2, 'XI TKJ 2', 2, 'Tidak memakai atribut lengkap 02', 2, 2, 'Guru 02', '2026-02-02', 'Kejadian pelanggaran 02', 2, 'Tindakan 02', 'Pembinaan', '2026-02-02 02:00:00', '2026-02-02 02:00:00'),
(3, 1, 3, 'Citra Saputra 03', 3, 'XII DKV 3', 3, 'Tidak hadir tanpa keterangan 03', 3, 3, 'Guru 03', '2026-03-03', 'Kejadian pelanggaran 03', 3, 'Tindakan 03', 'Selesai', '2026-03-03 02:00:00', '2026-03-03 02:00:00'),
(4, 1, 4, 'Dina Saputra 04', 4, 'X AKL 4', 4, 'Rambut tidak sesuai aturan 04', 4, 4, 'Guru 04', '2026-04-04', 'Kejadian pelanggaran 04', 4, 'Tindakan 04', 'Dipantau', '2026-04-04 02:00:00', '2026-04-04 02:00:00'),
(5, 1, 5, 'Eka Saputra 05', 5, 'XI MPLB 5', 5, 'Tidak mengerjakan tugas 05', 5, 5, 'Guru 05', '2026-05-05', 'Kejadian pelanggaran 05', 5, 'Tindakan 05', 'Ditindaklanjuti', '2026-05-05 02:00:00', '2026-05-05 02:00:00'),
(6, 1, 6, 'Fajar Saputra 06', 6, 'XII RPL 6', 6, 'Terlambat 06', 6, 6, 'Guru 06', '2026-06-06', 'Kejadian pelanggaran 06', 1, 'Tindakan 06', 'Teguran', '2026-06-06 02:00:00', '2026-06-06 02:00:00'),
(7, 1, 7, 'Gita Saputra 07', 7, 'X TKJ 7', 7, 'Tidak memakai atribut lengkap 07', 7, 7, 'Guru 07', '2026-07-07', 'Kejadian pelanggaran 07', 2, 'Tindakan 07', 'Pembinaan', '2026-07-07 02:00:00', '2026-07-07 02:00:00'),
(8, 1, 8, 'Hana Saputra 08', 8, 'XI DKV 8', 8, 'Tidak hadir tanpa keterangan 08', 8, 8, 'Guru 08', '2026-08-08', 'Kejadian pelanggaran 08', 3, 'Tindakan 08', 'Selesai', '2026-08-08 02:00:00', '2026-08-08 02:00:00'),
(9, 1, 9, 'Indra Saputra 09', 9, 'XII AKL 9', 9, 'Rambut tidak sesuai aturan 09', 9, 9, 'Guru 09', '2026-09-09', 'Kejadian pelanggaran 09', 4, 'Tindakan 09', 'Dipantau', '2026-09-09 02:00:00', '2026-09-09 02:00:00'),
(10, 1, 10, 'Joko Saputra 10', 10, 'X MPLB 10', 10, 'Tidak mengerjakan tugas 10', 10, 10, 'Guru 10', '2026-10-10', 'Kejadian pelanggaran 10', 5, 'Tindakan 10', 'Ditindaklanjuti', '2026-10-10 02:00:00', '2026-10-10 02:00:00'),
(11, 2, 11, 'Andi Pratama 11', 1, 'X RPL 1', 11, 'Terlambat 11', 11, 11, 'Guru 11', '2026-11-11', 'Kejadian pelanggaran 11', 1, 'Tindakan 11', 'Teguran', '2026-11-11 02:00:00', '2026-11-11 02:00:00'),
(12, 2, 12, 'Budi Pratama 12', 2, 'XI TKJ 2', 12, 'Tidak memakai atribut lengkap 12', 12, 12, 'Guru 12', '2026-12-12', 'Kejadian pelanggaran 12', 2, 'Tindakan 12', 'Pembinaan', '2026-12-12 02:00:00', '2026-12-12 02:00:00'),
(13, 2, 13, 'Citra Pratama 13', 3, 'XII DKV 3', 13, 'Tidak hadir tanpa keterangan 13', 13, 13, 'Guru 13', '2026-01-13', 'Kejadian pelanggaran 13', 3, 'Tindakan 13', 'Selesai', '2026-01-13 02:00:00', '2026-01-13 02:00:00'),
(14, 2, 14, 'Dina Pratama 14', 4, 'X AKL 4', 14, 'Rambut tidak sesuai aturan 14', 14, 14, 'Guru 14', '2026-02-14', 'Kejadian pelanggaran 14', 4, 'Tindakan 14', 'Dipantau', '2026-02-14 02:00:00', '2026-02-14 02:00:00'),
(15, 2, 15, 'Eka Pratama 15', 5, 'XI MPLB 5', 15, 'Tidak mengerjakan tugas 15', 15, 15, 'Guru 15', '2026-03-15', 'Kejadian pelanggaran 15', 5, 'Tindakan 15', 'Ditindaklanjuti', '2026-03-15 02:00:00', '2026-03-15 02:00:00'),
(16, 2, 16, 'Fajar Pratama 16', 6, 'XII RPL 6', 16, 'Terlambat 16', 16, 16, 'Guru 16', '2026-04-16', 'Kejadian pelanggaran 16', 1, 'Tindakan 16', 'Teguran', '2026-04-16 02:00:00', '2026-04-16 02:00:00'),
(17, 2, 17, 'Gita Pratama 17', 7, 'X TKJ 7', 17, 'Tidak memakai atribut lengkap 17', 17, 17, 'Guru 17', '2026-05-17', 'Kejadian pelanggaran 17', 2, 'Tindakan 17', 'Pembinaan', '2026-05-17 02:00:00', '2026-05-17 02:00:00'),
(18, 2, 18, 'Hana Pratama 18', 8, 'XI DKV 8', 18, 'Tidak hadir tanpa keterangan 18', 18, 18, 'Guru 18', '2026-06-18', 'Kejadian pelanggaran 18', 3, 'Tindakan 18', 'Selesai', '2026-06-18 02:00:00', '2026-06-18 02:00:00'),
(19, 2, 19, 'Indra Pratama 19', 9, 'XII AKL 9', 19, 'Rambut tidak sesuai aturan 19', 19, 19, 'Guru 19', '2026-07-19', 'Kejadian pelanggaran 19', 4, 'Tindakan 19', 'Dipantau', '2026-07-19 02:00:00', '2026-07-19 02:00:00'),
(20, 2, 20, 'Joko Pratama 20', 10, 'X MPLB 10', 20, 'Tidak mengerjakan tugas 20', 20, 20, 'Guru 20', '2026-08-20', 'Kejadian pelanggaran 20', 5, 'Tindakan 20', 'Ditindaklanjuti', '2026-08-20 02:00:00', '2026-08-20 02:00:00'),
(21, 3, 21, 'Andi Lestari 21', 1, 'X RPL 1', 21, 'Terlambat 21', 21, 21, 'Guru 21', '2026-09-21', 'Kejadian pelanggaran 21', 1, 'Tindakan 21', 'Teguran', '2026-09-21 02:00:00', '2026-09-21 02:00:00'),
(22, 3, 22, 'Budi Lestari 22', 2, 'XI TKJ 2', 22, 'Tidak memakai atribut lengkap 22', 22, 22, 'Guru 22', '2026-10-22', 'Kejadian pelanggaran 22', 2, 'Tindakan 22', 'Pembinaan', '2026-10-22 02:00:00', '2026-10-22 02:00:00'),
(23, 3, 23, 'Citra Lestari 23', 3, 'XII DKV 3', 23, 'Tidak hadir tanpa keterangan 23', 23, 23, 'Guru 23', '2026-11-23', 'Kejadian pelanggaran 23', 3, 'Tindakan 23', 'Selesai', '2026-11-23 02:00:00', '2026-11-23 02:00:00'),
(24, 3, 24, 'Dina Lestari 24', 4, 'X AKL 4', 24, 'Rambut tidak sesuai aturan 24', 24, 24, 'Guru 24', '2026-12-24', 'Kejadian pelanggaran 24', 4, 'Tindakan 24', 'Dipantau', '2026-12-24 02:00:00', '2026-12-24 02:00:00'),
(25, 3, 25, 'Eka Lestari 25', 5, 'XI MPLB 5', 25, 'Tidak mengerjakan tugas 25', 25, 25, 'Guru 25', '2026-01-25', 'Kejadian pelanggaran 25', 5, 'Tindakan 25', 'Ditindaklanjuti', '2026-01-25 02:00:00', '2026-01-25 02:00:00'),
(26, 3, 26, 'Fajar Lestari 26', 6, 'XII RPL 6', 26, 'Terlambat 26', 26, 26, 'Guru 26', '2026-02-26', 'Kejadian pelanggaran 26', 1, 'Tindakan 26', 'Teguran', '2026-02-26 02:00:00', '2026-02-26 02:00:00'),
(27, 3, 27, 'Gita Lestari 27', 7, 'X TKJ 7', 27, 'Tidak memakai atribut lengkap 27', 27, 27, 'Guru 27', '2026-03-27', 'Kejadian pelanggaran 27', 2, 'Tindakan 27', 'Pembinaan', '2026-03-27 02:00:00', '2026-03-27 02:00:00'),
(28, 3, 28, 'Hana Lestari 28', 8, 'XI DKV 8', 28, 'Tidak hadir tanpa keterangan 28', 28, 28, 'Guru 28', '2026-04-28', 'Kejadian pelanggaran 28', 3, 'Tindakan 28', 'Selesai', '2026-04-28 02:00:00', '2026-04-28 02:00:00'),
(29, 3, 29, 'Indra Lestari 29', 9, 'XII AKL 9', 29, 'Rambut tidak sesuai aturan 29', 29, 29, 'Guru 29', '2026-05-01', 'Kejadian pelanggaran 29', 4, 'Tindakan 29', 'Dipantau', '2026-05-01 02:00:00', '2026-05-01 02:00:00'),
(30, 3, 30, 'Joko Lestari 30', 10, 'X MPLB 10', 30, 'Tidak mengerjakan tugas 30', 30, 30, 'Guru 30', '2026-06-02', 'Kejadian pelanggaran 30', 5, 'Tindakan 30', 'Ditindaklanjuti', '2026-06-02 02:00:00', '2026-06-02 02:00:00'),
(31, 4, 31, 'Andi Permata 31', 1, 'X RPL 1', 31, 'Terlambat 31', 31, 31, 'Guru 31', '2026-07-03', 'Kejadian pelanggaran 31', 1, 'Tindakan 31', 'Teguran', '2026-07-03 02:00:00', '2026-07-03 02:00:00'),
(32, 4, 32, 'Budi Permata 32', 2, 'XI TKJ 2', 32, 'Tidak memakai atribut lengkap 32', 32, 32, 'Guru 32', '2026-08-04', 'Kejadian pelanggaran 32', 2, 'Tindakan 32', 'Pembinaan', '2026-08-04 02:00:00', '2026-08-04 02:00:00'),
(33, 4, 33, 'Citra Permata 33', 3, 'XII DKV 3', 33, 'Tidak hadir tanpa keterangan 33', 33, 33, 'Guru 33', '2026-09-05', 'Kejadian pelanggaran 33', 3, 'Tindakan 33', 'Selesai', '2026-09-05 02:00:00', '2026-09-05 02:00:00'),
(34, 4, 34, 'Dina Permata 34', 4, 'X AKL 4', 34, 'Rambut tidak sesuai aturan 34', 34, 34, 'Guru 34', '2026-10-06', 'Kejadian pelanggaran 34', 4, 'Tindakan 34', 'Dipantau', '2026-10-06 02:00:00', '2026-10-06 02:00:00'),
(35, 4, 35, 'Eka Permata 35', 5, 'XI MPLB 5', 35, 'Tidak mengerjakan tugas 35', 35, 35, 'Guru 35', '2026-11-07', 'Kejadian pelanggaran 35', 5, 'Tindakan 35', 'Ditindaklanjuti', '2026-11-07 02:00:00', '2026-11-07 02:00:00'),
(36, 4, 36, 'Fajar Permata 36', 6, 'XII RPL 6', 36, 'Terlambat 36', 36, 36, 'Guru 36', '2026-12-08', 'Kejadian pelanggaran 36', 1, 'Tindakan 36', 'Teguran', '2026-12-08 02:00:00', '2026-12-08 02:00:00'),
(37, 4, 37, 'Gita Permata 37', 7, 'X TKJ 7', 37, 'Tidak memakai atribut lengkap 37', 37, 37, 'Guru 37', '2026-01-09', 'Kejadian pelanggaran 37', 2, 'Tindakan 37', 'Pembinaan', '2026-01-09 02:00:00', '2026-01-09 02:00:00'),
(38, 4, 38, 'Hana Permata 38', 8, 'XI DKV 8', 38, 'Tidak hadir tanpa keterangan 38', 38, 38, 'Guru 38', '2026-02-10', 'Kejadian pelanggaran 38', 3, 'Tindakan 38', 'Selesai', '2026-02-10 02:00:00', '2026-02-10 02:00:00'),
(39, 4, 39, 'Indra Permata 39', 9, 'XII AKL 9', 39, 'Rambut tidak sesuai aturan 39', 39, 39, 'Guru 39', '2026-03-11', 'Kejadian pelanggaran 39', 4, 'Tindakan 39', 'Dipantau', '2026-03-11 02:00:00', '2026-03-11 02:00:00'),
(40, 4, 40, 'Joko Permata 40', 10, 'X MPLB 10', 40, 'Tidak mengerjakan tugas 40', 40, 40, 'Guru 40', '2026-04-12', 'Kejadian pelanggaran 40', 5, 'Tindakan 40', 'Ditindaklanjuti', '2026-04-12 02:00:00', '2026-04-12 02:00:00'),
(41, 5, 41, 'Andi Nugraha 41', 1, 'X RPL 1', 41, 'Terlambat 41', 41, 41, 'Guru 41', '2026-05-13', 'Kejadian pelanggaran 41', 1, 'Tindakan 41', 'Teguran', '2026-05-13 02:00:00', '2026-05-13 02:00:00'),
(42, 5, 42, 'Budi Nugraha 42', 2, 'XI TKJ 2', 42, 'Tidak memakai atribut lengkap 42', 42, 42, 'Guru 42', '2026-06-14', 'Kejadian pelanggaran 42', 2, 'Tindakan 42', 'Pembinaan', '2026-06-14 02:00:00', '2026-06-14 02:00:00'),
(43, 5, 43, 'Citra Nugraha 43', 3, 'XII DKV 3', 43, 'Tidak hadir tanpa keterangan 43', 43, 43, 'Guru 43', '2026-07-15', 'Kejadian pelanggaran 43', 3, 'Tindakan 43', 'Selesai', '2026-07-15 02:00:00', '2026-07-15 02:00:00'),
(44, 5, 44, 'Dina Nugraha 44', 4, 'X AKL 4', 44, 'Rambut tidak sesuai aturan 44', 44, 44, 'Guru 44', '2026-08-16', 'Kejadian pelanggaran 44', 4, 'Tindakan 44', 'Dipantau', '2026-08-16 02:00:00', '2026-08-16 02:00:00'),
(45, 5, 45, 'Eka Nugraha 45', 5, 'XI MPLB 5', 45, 'Tidak mengerjakan tugas 45', 45, 45, 'Guru 45', '2026-09-17', 'Kejadian pelanggaran 45', 5, 'Tindakan 45', 'Ditindaklanjuti', '2026-09-17 02:00:00', '2026-09-17 02:00:00'),
(46, 5, 46, 'Fajar Nugraha 46', 6, 'XII RPL 6', 46, 'Terlambat 46', 46, 46, 'Guru 46', '2026-10-18', 'Kejadian pelanggaran 46', 1, 'Tindakan 46', 'Teguran', '2026-10-18 02:00:00', '2026-10-18 02:00:00'),
(47, 5, 47, 'Gita Nugraha 47', 7, 'X TKJ 7', 47, 'Tidak memakai atribut lengkap 47', 47, 47, 'Guru 47', '2026-11-19', 'Kejadian pelanggaran 47', 2, 'Tindakan 47', 'Pembinaan', '2026-11-19 02:00:00', '2026-11-19 02:00:00'),
(48, 5, 48, 'Hana Nugraha 48', 8, 'XI DKV 8', 48, 'Tidak hadir tanpa keterangan 48', 48, 48, 'Guru 48', '2026-12-20', 'Kejadian pelanggaran 48', 3, 'Tindakan 48', 'Selesai', '2026-12-20 02:00:00', '2026-12-20 02:00:00'),
(49, 5, 49, 'Indra Nugraha 49', 9, 'XII AKL 9', 49, 'Rambut tidak sesuai aturan 49', 49, 49, 'Guru 49', '2026-01-21', 'Kejadian pelanggaran 49', 4, 'Tindakan 49', 'Dipantau', '2026-01-21 02:00:00', '2026-01-21 02:00:00'),
(50, 5, 50, 'Joko Nugraha 50', 10, 'X MPLB 10', 50, 'Tidak mengerjakan tugas 50', 50, 50, 'Guru 50', '2026-02-22', 'Kejadian pelanggaran 50', 5, 'Tindakan 50', 'Ditindaklanjuti', '2026-02-22 02:00:00', '2026-02-22 02:00:00');

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
(1, 'NIS0001', '0000000001', 'Andi Saputra 01', 'L', '2010-01-15', 'Jl. Pendidikan No. 1, Tasikmalaya', 1, '2026-01-01 01:00:00', '2026-01-01 01:00:00'),
(2, 'NIS0002', '0000000002', 'Budi Saputra 02', 'P', '2010-02-20', 'Jl. Pendidikan No. 2, Tasikmalaya', 1, '2026-02-02 01:00:00', '2026-02-02 01:00:00'),
(3, 'NIS0003', '0000000003', 'Citra Saputra 03', 'L', '2010-03-12', 'Jl. Pendidikan No. 3, Tasikmalaya', 1, '2026-03-03 01:00:00', '2026-03-03 01:00:00'),
(4, 'NIS0004', '0000000004', 'Dina Saputra 04', 'P', '2010-04-25', 'Jl. Pendidikan No. 4, Tasikmalaya', 1, '2026-04-04 01:00:00', '2026-04-04 01:00:00'),
(5, 'NIS0005', '0000000005', 'Eka Saputra 05', 'L', '2010-05-18', 'Jl. Pendidikan No. 5, Tasikmalaya', 1, '2026-05-05 01:00:00', '2026-05-05 01:00:00'),
(6, 'NIS0006', '0000000006', 'Fajar Saputra 06', 'P', '2010-06-07', 'Jl. Pendidikan No. 6, Tasikmalaya', 1, '2026-06-06 01:00:00', '2026-06-06 01:00:00'),
(7, 'NIS0007', '0000000007', 'Gita Saputra 07', 'L', '2010-07-22', 'Jl. Pendidikan No. 7, Tasikmalaya', 1, '2026-07-07 01:00:00', '2026-07-07 01:00:00'),
(8, 'NIS0008', '0000000008', 'Hana Saputra 08', 'P', '2010-08-14', 'Jl. Pendidikan No. 8, Tasikmalaya', 1, '2026-08-08 01:00:00', '2026-08-08 01:00:00'),
(9, 'NIS0009', '0000000009', 'Indra Saputra 09', 'L', '2010-09-30', 'Jl. Pendidikan No. 9, Tasikmalaya', 1, '2026-09-09 01:00:00', '2026-09-09 01:00:00'),
(10, 'NIS0010', '0000000010', 'Joko Saputra 10', 'P', '2010-10-11', 'Jl. Pendidikan No. 10, Tasikmalaya', 1, '2026-10-10 01:00:00', '2026-10-10 01:00:00'),
(11, 'NIS0011', '0000000011', 'Andi Pratama 11', 'L', '2010-11-05', 'Jl. Pendidikan No. 11, Tasikmalaya', 1, '2026-11-11 01:00:00', '2026-11-11 01:00:00'),
(12, 'NIS0012', '0000000012', 'Budi Pratama 12', 'P', '2010-12-19', 'Jl. Pendidikan No. 12, Tasikmalaya', 1, '2026-12-12 01:00:00', '2026-12-12 01:00:00'),
(13, 'NIS0013', '0000000013', 'Citra Pratama 13', 'L', '2011-01-08', 'Jl. Pendidikan No. 13, Tasikmalaya', 1, '2026-01-13 01:00:00', '2026-01-13 01:00:00'),
(14, 'NIS0014', '0000000014', 'Dina Pratama 14', 'P', '2011-02-17', 'Jl. Pendidikan No. 14, Tasikmalaya', 1, '2026-02-14 01:00:00', '2026-02-14 01:00:00'),
(15, 'NIS0015', '0000000015', 'Eka Pratama 15', 'L', '2011-03-29', 'Jl. Pendidikan No. 15, Tasikmalaya', 1, '2026-03-15 01:00:00', '2026-03-15 01:00:00'),
(16, 'NIS0016', '0000000016', 'Fajar Pratama 16', 'P', '2011-04-13', 'Jl. Pendidikan No. 16, Tasikmalaya', 1, '2026-04-16 01:00:00', '2026-04-16 01:00:00'),
(17, 'NIS0017', '0000000017', 'Gita Pratama 17', 'L', '2011-05-21', 'Jl. Pendidikan No. 17, Tasikmalaya', 1, '2026-05-17 01:00:00', '2026-05-17 01:00:00'),
(18, 'NIS0018', '0000000018', 'Hana Pratama 18', 'P', '2011-06-09', 'Jl. Pendidikan No. 18, Tasikmalaya', 1, '2026-06-18 01:00:00', '2026-06-18 01:00:00'),
(19, 'NIS0019', '0000000019', 'Indra Pratama 19', 'L', '2011-07-27', 'Jl. Pendidikan No. 19, Tasikmalaya', 1, '2026-07-19 01:00:00', '2026-07-19 01:00:00'),
(20, 'NIS0020', '0000000020', 'Joko Pratama 20', 'P', '2011-08-16', 'Jl. Pendidikan No. 20, Tasikmalaya', 1, '2026-08-20 01:00:00', '2026-08-20 01:00:00'),
(21, 'NIS0021', '0000000021', 'Andi Lestari 21', 'L', '2011-09-04', 'Jl. Pendidikan No. 21, Tasikmalaya', 1, '2026-09-21 01:00:00', '2026-09-21 01:00:00'),
(22, 'NIS0022', '0000000022', 'Budi Lestari 22', 'P', '2011-10-23', 'Jl. Pendidikan No. 22, Tasikmalaya', 1, '2026-10-22 01:00:00', '2026-10-22 01:00:00'),
(23, 'NIS0023', '0000000023', 'Citra Lestari 23', 'L', '2011-11-14', 'Jl. Pendidikan No. 23, Tasikmalaya', 1, '2026-11-23 01:00:00', '2026-11-23 01:00:00'),
(24, 'NIS0024', '0000000024', 'Dina Lestari 24', 'P', '2011-12-02', 'Jl. Pendidikan No. 24, Tasikmalaya', 1, '2026-12-24 01:00:00', '2026-12-24 01:00:00'),
(25, 'NIS0025', '0000000025', 'Eka Lestari 25', 'L', '2010-01-28', 'Jl. Pendidikan No. 25, Tasikmalaya', 1, '2026-01-25 01:00:00', '2026-01-25 01:00:00'),
(26, 'NIS0026', '0000000026', 'Fajar Lestari 26', 'P', '2010-02-11', 'Jl. Pendidikan No. 26, Tasikmalaya', 1, '2026-02-26 01:00:00', '2026-02-26 01:00:00'),
(27, 'NIS0027', '0000000027', 'Gita Lestari 27', 'L', '2010-03-24', 'Jl. Pendidikan No. 27, Tasikmalaya', 1, '2026-03-27 01:00:00', '2026-03-27 01:00:00'),
(28, 'NIS0028', '0000000028', 'Hana Lestari 28', 'P', '2010-04-09', 'Jl. Pendidikan No. 28, Tasikmalaya', 1, '2026-04-28 01:00:00', '2026-04-28 01:00:00'),
(29, 'NIS0029', '0000000029', 'Indra Lestari 29', 'L', '2010-05-30', 'Jl. Pendidikan No. 29, Tasikmalaya', 1, '2026-05-01 01:00:00', '2026-05-01 01:00:00'),
(30, 'NIS0030', '0000000030', 'Joko Lestari 30', 'P', '2010-06-18', 'Jl. Pendidikan No. 30, Tasikmalaya', 1, '2026-06-02 01:00:00', '2026-06-02 01:00:00'),
(31, 'NIS0031', '0000000031', 'Andi Permata 31', 'L', '2010-07-06', 'Jl. Pendidikan No. 31, Tasikmalaya', 1, '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(32, 'NIS0032', '0000000032', 'Budi Permata 32', 'P', '2010-08-26', 'Jl. Pendidikan No. 32, Tasikmalaya', 1, '2026-08-04 01:00:00', '2026-08-04 01:00:00'),
(33, 'NIS0033', '0000000033', 'Citra Permata 33', 'L', '2010-09-15', 'Jl. Pendidikan No. 33, Tasikmalaya', 1, '2026-09-05 01:00:00', '2026-09-05 01:00:00'),
(34, 'NIS0034', '0000000034', 'Dina Permata 34', 'P', '2010-10-29', 'Jl. Pendidikan No. 34, Tasikmalaya', 1, '2026-10-06 01:00:00', '2026-10-06 01:00:00'),
(35, 'NIS0035', '0000000035', 'Eka Permata 35', 'L', '2010-11-18', 'Jl. Pendidikan No. 35, Tasikmalaya', 1, '2026-11-07 01:00:00', '2026-11-07 01:00:00'),
(36, 'NIS0036', '0000000036', 'Fajar Permata 36', 'P', '2010-12-07', 'Jl. Pendidikan No. 36, Tasikmalaya', 1, '2026-12-08 01:00:00', '2026-12-08 01:00:00'),
(37, 'NIS0037', '0000000037', 'Gita Permata 37', 'L', '2011-01-25', 'Jl. Pendidikan No. 37, Tasikmalaya', 1, '2026-01-09 01:00:00', '2026-01-09 01:00:00'),
(38, 'NIS0038', '0000000038', 'Hana Permata 38', 'P', '2011-02-08', 'Jl. Pendidikan No. 38, Tasikmalaya', 1, '2026-02-10 01:00:00', '2026-02-10 01:00:00'),
(39, 'NIS0039', '0000000039', 'Indra Permata 39', 'L', '2011-03-19', 'Jl. Pendidikan No. 39, Tasikmalaya', 1, '2026-03-11 01:00:00', '2026-03-11 01:00:00'),
(40, 'NIS0040', '0000000040', 'Joko Permata 40', 'P', '2011-04-28', 'Jl. Pendidikan No. 40, Tasikmalaya', 1, '2026-04-12 01:00:00', '2026-04-12 01:00:00'),
(41, 'NIS0041', '0000000041', 'Andi Nugraha 41', 'L', '2011-05-16', 'Jl. Pendidikan No. 41, Tasikmalaya', 1, '2026-05-13 01:00:00', '2026-05-13 01:00:00'),
(42, 'NIS0042', '0000000042', 'Budi Nugraha 42', 'P', '2011-06-24', 'Jl. Pendidikan No. 42, Tasikmalaya', 1, '2026-06-14 01:00:00', '2026-06-14 01:00:00'),
(43, 'NIS0043', '0000000043', 'Citra Nugraha 43', 'L', '2011-07-12', 'Jl. Pendidikan No. 43, Tasikmalaya', 1, '2026-07-15 01:00:00', '2026-07-15 01:00:00'),
(44, 'NIS0044', '0000000044', 'Dina Nugraha 44', 'P', '2011-08-31', 'Jl. Pendidikan No. 44, Tasikmalaya', 1, '2026-08-16 01:00:00', '2026-08-16 01:00:00'),
(45, 'NIS0045', '0000000045', 'Eka Nugraha 45', 'L', '2011-09-20', 'Jl. Pendidikan No. 45, Tasikmalaya', 1, '2026-09-17 01:00:00', '2026-09-17 01:00:00'),
(46, 'NIS0046', '0000000046', 'Fajar Nugraha 46', 'P', '2011-10-10', 'Jl. Pendidikan No. 46, Tasikmalaya', 1, '2026-10-18 01:00:00', '2026-10-18 01:00:00'),
(47, 'NIS0047', '0000000047', 'Gita Nugraha 47', 'L', '2011-11-27', 'Jl. Pendidikan No. 47, Tasikmalaya', 1, '2026-11-19 01:00:00', '2026-11-19 01:00:00'),
(48, 'NIS0048', '0000000048', 'Hana Nugraha 48', 'P', '2011-12-15', 'Jl. Pendidikan No. 48, Tasikmalaya', 1, '2026-12-20 01:00:00', '2026-12-20 01:00:00'),
(49, 'NIS0049', '0000000049', 'Indra Nugraha 49', 'L', '2010-03-05', 'Jl. Pendidikan No. 49, Tasikmalaya', 1, '2026-01-21 01:00:00', '2026-01-21 01:00:00'),
(50, 'NIS0050', '0000000050', 'Joko Nugraha 50', 'P', '2010-04-17', 'Jl. Pendidikan No. 50, Tasikmalaya', 1, '2026-02-22 01:00:00', '2026-02-22 01:00:00');

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
(1, 'User 01', 'user01@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token01', 'admin', '2026-01-01 01:00:00', '2026-01-01 01:00:00'),
(2, 'User 02', 'user02@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token02', 'guru', '2026-02-02 01:00:00', '2026-02-02 01:00:00'),
(3, 'User 03', 'user03@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token03', 'staff', '2026-03-03 01:00:00', '2026-03-03 01:00:00'),
(4, 'User 04', 'user04@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token04', 'admin', '2026-04-04 01:00:00', '2026-04-04 01:00:00'),
(5, 'User 05', 'user05@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token05', 'guru', '2026-05-05 01:00:00', '2026-05-05 01:00:00'),
(6, 'User 06', 'user06@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token06', 'staff', '2026-06-06 01:00:00', '2026-06-06 01:00:00'),
(7, 'User 07', 'user07@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token07', 'admin', '2026-07-07 01:00:00', '2026-07-07 01:00:00'),
(8, 'User 08', 'user08@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token08', 'guru', '2026-08-08 01:00:00', '2026-08-08 01:00:00'),
(9, 'User 09', 'user09@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token09', 'staff', '2026-09-09 01:00:00', '2026-09-09 01:00:00'),
(10, 'User 10', 'user10@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token10', 'admin', '2026-10-10 01:00:00', '2026-10-10 01:00:00'),
(11, 'User 11', 'user11@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token11', 'guru', '2026-11-11 01:00:00', '2026-11-11 01:00:00'),
(12, 'User 12', 'user12@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token12', 'staff', '2026-12-12 01:00:00', '2026-12-12 01:00:00'),
(13, 'User 13', 'user13@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token13', 'admin', '2026-01-13 01:00:00', '2026-01-13 01:00:00'),
(14, 'User 14', 'user14@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token14', 'guru', '2026-02-14 01:00:00', '2026-02-14 01:00:00'),
(15, 'User 15', 'user15@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token15', 'staff', '2026-03-15 01:00:00', '2026-03-15 01:00:00'),
(16, 'User 16', 'user16@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token16', 'admin', '2026-04-16 01:00:00', '2026-04-16 01:00:00'),
(17, 'User 17', 'user17@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token17', 'guru', '2026-05-17 01:00:00', '2026-05-17 01:00:00'),
(18, 'User 18', 'user18@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token18', 'staff', '2026-06-18 01:00:00', '2026-06-18 01:00:00'),
(19, 'User 19', 'user19@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token19', 'admin', '2026-07-19 01:00:00', '2026-07-19 01:00:00'),
(20, 'User 20', 'user20@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token20', 'guru', '2026-08-20 01:00:00', '2026-08-20 01:00:00'),
(21, 'User 21', 'user21@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token21', 'staff', '2026-09-21 01:00:00', '2026-09-21 01:00:00'),
(22, 'User 22', 'user22@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token22', 'admin', '2026-10-22 01:00:00', '2026-10-22 01:00:00'),
(23, 'User 23', 'user23@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token23', 'guru', '2026-11-23 01:00:00', '2026-11-23 01:00:00'),
(24, 'User 24', 'user24@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token24', 'staff', '2026-12-24 01:00:00', '2026-12-24 01:00:00'),
(25, 'User 25', 'user25@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token25', 'admin', '2026-01-25 01:00:00', '2026-01-25 01:00:00'),
(26, 'User 26', 'user26@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token26', 'guru', '2026-02-26 01:00:00', '2026-02-26 01:00:00'),
(27, 'User 27', 'user27@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token27', 'staff', '2026-03-27 01:00:00', '2026-03-27 01:00:00'),
(28, 'User 28', 'user28@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token28', 'admin', '2026-04-28 01:00:00', '2026-04-28 01:00:00'),
(29, 'User 29', 'user29@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token29', 'guru', '2026-05-01 01:00:00', '2026-05-01 01:00:00'),
(30, 'User 30', 'user30@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token30', 'staff', '2026-06-02 01:00:00', '2026-06-02 01:00:00'),
(31, 'User 31', 'user31@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token31', 'admin', '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(32, 'User 32', 'user32@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token32', 'guru', '2026-08-04 01:00:00', '2026-08-04 01:00:00'),
(33, 'User 33', 'user33@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token33', 'staff', '2026-09-05 01:00:00', '2026-09-05 01:00:00'),
(34, 'User 34', 'user34@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token34', 'admin', '2026-10-06 01:00:00', '2026-10-06 01:00:00'),
(35, 'User 35', 'user35@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token35', 'guru', '2026-11-07 01:00:00', '2026-11-07 01:00:00'),
(36, 'User 36', 'user36@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token36', 'staff', '2026-12-08 01:00:00', '2026-12-08 01:00:00'),
(37, 'User 37', 'user37@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token37', 'admin', '2026-01-09 01:00:00', '2026-01-09 01:00:00'),
(38, 'User 38', 'user38@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token38', 'guru', '2026-02-10 01:00:00', '2026-02-10 01:00:00'),
(39, 'User 39', 'user39@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token39', 'staff', '2026-03-11 01:00:00', '2026-03-11 01:00:00'),
(40, 'User 40', 'user40@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token40', 'admin', '2026-04-12 01:00:00', '2026-04-12 01:00:00'),
(41, 'User 41', 'user41@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token41', 'guru', '2026-05-13 01:00:00', '2026-05-13 01:00:00'),
(42, 'User 42', 'user42@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token42', 'staff', '2026-06-14 01:00:00', '2026-06-14 01:00:00'),
(43, 'User 43', 'user43@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token43', 'admin', '2026-07-15 01:00:00', '2026-07-15 01:00:00'),
(44, 'User 44', 'user44@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token44', 'guru', '2026-08-16 01:00:00', '2026-08-16 01:00:00'),
(45, 'User 45', 'user45@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token45', 'staff', '2026-09-17 01:00:00', '2026-09-17 01:00:00'),
(46, 'User 46', 'user46@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token46', 'admin', '2026-10-18 01:00:00', '2026-10-18 01:00:00'),
(47, 'User 47', 'user47@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token47', 'guru', '2026-11-19 01:00:00', '2026-11-19 01:00:00'),
(48, 'User 48', 'user48@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token48', 'staff', '2026-12-20 01:00:00', '2026-12-20 01:00:00'),
(49, 'User 49', 'user49@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token49', 'admin', '2026-01-21 01:00:00', '2026-01-21 01:00:00'),
(50, 'User 50', 'user50@ukk2026.test', '2026-09-23 02:30:15', '$2y$12$EHNOkz05vUfEmXcl5ndTpet/k/v.g8PpuRe61tVUYe73UVXpvMe06', 'token50', 'guru', '2026-02-22 01:00:00', '2026-02-22 01:00:00');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `t_kelas`
--
ALTER TABLE `t_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `t_siswa`
--
ALTER TABLE `t_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
