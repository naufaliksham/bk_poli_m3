-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Des 2023 pada 06.18
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bk_poliklinik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_poli`
--

CREATE TABLE `daftar_poli` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_pasien` int(11) UNSIGNED NOT NULL,
  `id_jadwal` int(11) UNSIGNED NOT NULL,
  `keluhan` text NOT NULL,
  `no_antrian` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_poli`
--

INSERT INTO `daftar_poli` (`id`, `id_pasien`, `id_jadwal`, `keluhan`, `no_antrian`) VALUES
(12, 3, 1, 'tester', 1),
(14, 3, 3, 'etest', 1),
(15, 3, 1, 'e2112d', 2),
(16, 4, 1, 'awfawfawaw', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_periksa`
--

CREATE TABLE `detail_periksa` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_periksa` int(11) UNSIGNED DEFAULT NULL,
  `id_obat` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `id_poli` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dokter`
--

INSERT INTO `dokter` (`id`, `nama`, `alamat`, `no_hp`, `id_poli`) VALUES
(2, 'Dokter Pati', 'Pati', '08123789456', 2),
(4, 'Dokter Semarang', 'Semarang', '08123456789', 1),
(5, 'Dokter Jepara', 'Jepara', '081651161621', 4),
(6, 'tes', 'testestestestes', '084956129619621', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_periksa`
--

CREATE TABLE `jadwal_periksa` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_dokter` int(11) UNSIGNED DEFAULT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal_periksa`
--

INSERT INTO `jadwal_periksa` (`id`, `id_dokter`, `hari`, `jam_mulai`, `jam_selesai`) VALUES
(1, 2, 'Senin', '06:30:00', '11:30:00'),
(3, 2, 'Selasa', '14:30:00', '16:30:00'),
(4, 5, 'Rabu', '14:30:00', '13:30:00'),
(5, 4, 'Senin', '12:30:00', '14:30:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_obat` varchar(50) NOT NULL,
  `kemasan` varchar(35) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`id`, `nama_obat`, `kemasan`, `harga`) VALUES
(4, 'Paracetamol', 'Saset', 2500),
(5, 'Flutamol', 'Kaleng', 3450);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_ktp` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `no_rm` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id`, `nama`, `alamat`, `no_ktp`, `no_hp`, `no_rm`) VALUES
(3, 'Pasien 1', 'Kudus', '891262156319532', '0489516165189', NULL),
(4, 'Pasien 2', 'Semarang', '1234567890123', '081951329519', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `periksa`
--

CREATE TABLE `periksa` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_daftar_poli` int(11) UNSIGNED NOT NULL,
  `tgl_periksa` datetime NOT NULL,
  `catatan` text NOT NULL,
  `biaya_periksa` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `poli`
--

CREATE TABLE `poli` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_poli` varchar(25) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `poli`
--

INSERT INTO `poli` (`id`, `nama_poli`, `keterangan`) VALUES
(1, 'Poliklinik Semarang', 'Poliklinik di lokasi Semarang tengah'),
(2, 'Poliklinik Pati', 'Poliklinik di lokasi Pati'),
(4, 'Poliklinik Jepara', 'Berlokasi di Jepara'),
(5, 'Poli tes', 'tesesssafad');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `nama_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `nama_role`) VALUES
(1, 'admin'),
(2, 'pasien'),
(3, 'dokter');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `idRole` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `created_at`, `updated_at`, `idRole`) VALUES
(11, 'Admin 2', 'admin2@gmail.com', '$2y$10$vL7TCD.KB5gRKY1iC6ADv.Wn1TN1.R.kGb92JNGCF5L7hspWXn88m', '2023-12-30 13:39:40', '2023-12-30 13:39:40', 1),
(12, 'Dokter Semarang', 'doktersemarang@gmail.com', '$2y$10$w1SCCBUn94ceQEHRTB.CEeTZkcSjxeoek.ll1d2UYch5S8FwWe.hS', '2023-12-30 13:48:11', '2023-12-30 13:48:11', 3),
(18, 'Pasien 1', 'pasien1@gmail.com', '$2y$10$tTjlh8FHeRaSQjxsTuaW0.fUwLbFYerlwMysO5TJKfmqflz4PuoyC', '2023-12-30 16:16:41', '2023-12-30 16:16:41', 2),
(19, 'Pasien 2', 'pasien2@gmail.com', '$2y$10$cL2OTbn8wHHe2pjFr0eU5u98Ued4oMw4eNBposVHrDbpVmCRU331u', '2023-12-30 22:12:20', '2023-12-30 22:12:20', 2);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_periksa` (`id_periksa`),
  ADD UNIQUE KEY `id_obat` (`id_obat`);

--
-- Indeks untuk tabel `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `periksa`
--
ALTER TABLE `periksa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_daftar_poli` (`id_daftar_poli`),
  ADD UNIQUE KEY `biaya_periksa` (`biaya_periksa`);

--
-- Indeks untuk tabel `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `idRole` (`idRole`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `daftar_poli`
--
ALTER TABLE `daftar_poli`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `detail_periksa`
--
ALTER TABLE `detail_periksa`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `periksa`
--
ALTER TABLE `periksa`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `poli`
--
ALTER TABLE `poli`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD CONSTRAINT `daftar_poli_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`),
  ADD CONSTRAINT `daftar_poli_ibfk_2` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_periksa` (`id`);

--
-- Ketidakleluasaan untuk tabel `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD CONSTRAINT `detail_periksa_ibfk_1` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`),
  ADD CONSTRAINT `detail_periksa_ibfk_2` FOREIGN KEY (`id_periksa`) REFERENCES `periksa` (`id`);

--
-- Ketidakleluasaan untuk tabel `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `dokter_ibfk_1` FOREIGN KEY (`id_poli`) REFERENCES `poli` (`id`);

--
-- Ketidakleluasaan untuk tabel `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD CONSTRAINT `jadwal_periksa_ibfk_1` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`);

--
-- Ketidakleluasaan untuk tabel `periksa`
--
ALTER TABLE `periksa`
  ADD CONSTRAINT `periksa_ibfk_1` FOREIGN KEY (`id_daftar_poli`) REFERENCES `daftar_poli` (`id`);

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `idRole` FOREIGN KEY (`idRole`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
