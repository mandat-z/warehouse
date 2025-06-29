-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Jun 2025 pada 14.54
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
-- Database: `db_warehouse`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_keluar` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `petugas` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_keluar`, `id_barang`, `jumlah`, `tanggal`, `petugas`, `keterangan`) VALUES
(1, 11, 5, '2025-06-15', 'Amanda Aura', 'Pemakaian tgl 15/06/2025'),
(2, 1, 30, '2025-06-12', 'Amanda Aura', 'Terjual di event xx'),
(3, 4, 50, '2025-05-29', 'Jung Yunho', 'update 29/05/2025'),
(4, 2, 40, '2025-06-12', 'Jung Yunho', 'terjual di shp'),
(5, 3, 70, '2025-06-13', 'Amanda Aura', 'terkirim ke migi shop'),
(6, 6, 5, '2025-06-15', 'Amanda Aura', 'sudah terpakai untuk produksi'),
(7, 10, 120, '2025-06-15', 'Amanda Aura', 'sudah ke produksi'),
(8, 7, 100, '2025-06-15', 'Amanda Aura', 'sudah terpakai packing'),
(9, 8, 20, '2025-06-17', 'Amanda Aura', 'sudah terpakai buat packing'),
(10, 8, 60, '2025-06-18', 'Amanda Aura', 'buat packing');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_masuk` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `petugas` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_masuk`, `id_barang`, `jumlah`, `tanggal`, `petugas`, `keterangan`) VALUES
(1, 1, 150, '2025-06-08', 'Amanda Aura', 'Belum dibordir'),
(2, 2, 100, '2025-06-09', 'Amanda Aura', '-'),
(3, 3, 50, '2025-06-11', 'Amanda Aura', 'Sudah dipack plastik'),
(4, 11, 10, '2025-06-15', 'Amanda Aura', '-'),
(5, 3, 200, '2025-05-16', 'Jung Yunho', ''),
(6, 4, 100, '2025-04-01', 'Jung Yunho', 'Buat kantor'),
(7, 6, 10, '2025-06-15', 'Amanda Aura', 'dari vendor xx'),
(8, 10, 300, '2025-06-01', 'Amanda Aura', ''),
(9, 12, 80, '2025-01-15', 'Amanda Aura', 'putih'),
(10, 5, 30, '2025-06-14', 'Jung Yunho', 'dari vendor yx'),
(11, 9, 60, '2025-06-12', 'Jung Yunho', ''),
(12, 7, 200, '2025-02-10', 'Jung Yunho', 'ukuran sedang'),
(13, 8, 300, '2025-06-13', 'Amanda Aura', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_barang`
--

CREATE TABLE `data_barang` (
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(20) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `lokasi_rak` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_barang`
--

INSERT INTO `data_barang` (`id_barang`, `kode_barang`, `nama_barang`, `kategori`, `satuan`, `stok`, `lokasi_rak`) VALUES
(1, 'MRC003', 'Plushie', 'Merchandise', 'pcs', 200, 'B23'),
(2, 'MRC001', 'Keychain', 'Merchandise', 'pcs', 60, 'A12'),
(3, 'MRC002', 'Baju Sablon', 'Merchandise', 'pcs', 700, 'B23'),
(4, 'ATK001', 'Pulpen', 'ATK', 'pcs', 500, 'Z20'),
(5, 'SPL005', 'Kain Flanel', 'Bahan Baku', 'meter', 0, 'C14'),
(6, 'SPL012', 'Busa', 'Bahan Baku', 'kg', 0, 'L16'),
(7, 'PCK001', 'Kardus', 'Bahan Packing', 'pcs', 0, 'D17'),
(8, 'PCK005', 'Bubble Wrap', 'Bahan Packing', 'meter', 70, 'D27'),
(9, 'SPL007', 'Benang', 'Bahan Baku', 'pcs', 0, 'E19'),
(10, 'SPL008', 'Gantungan ', 'Bahan Baku', 'pcs', 10, 'E29'),
(11, 'ATK003', 'Kertas HVS', 'ATK', 'rim', 10, 'B34'),
(12, 'MRC021', 'Bantal', 'Merchandise', 'pcs', 0, 'G13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` enum('admin','staff') DEFAULT 'staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama_lengkap`, `role`) VALUES
(1, 'admin', '$2y$10$KIX7N0Mo2bwkswXtTzN/uOQjY8nOJZ0q6mrYzvG4e2Srsj6WvUzB2', 'Administrator', 'admin'),
(2, 'staff1', '$2y$10$JzG/.K5vN2GmGZ9hK2jBvOxJ6gkI7v1Q0Bh/fIhk3R7cdgJ/FzE2C', 'Staff Gudang', 'staff'),
(3, 'manda', '$2y$10$q93pItoy2FBqRP/6.zYYq.YCr1Bij79sXiRFyRsYU1htThUpsCkze', 'amanda', 'admin'),
(4, 'mingi', '$2y$10$NyqCpNsan99gt2LQZvWP3u0jyp5unoInwQzQAHic7qLopY9XoOC1G', 'song mingi', 'staff'),
(5, 'Admin1', '$2y$10$VY1KQPgSIsHR0oOGgiV/7OtqtKV.Gk5vOtpK4ku5JmH/g8mA5/7nq', 'Amanda Aura', 'admin'),
(6, 'Staff2', '$2y$10$r1ZTONij/mSrEO0a2lZzjO40FJnTeoz9YJRuvYg2MpalDhS8kyCCq', 'Jung Yunho', 'staff');

-- pw untuk Admin1: 123
-- pw untuk Staff2: 123
--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_keluar`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_masuk`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `data_barang`
--
ALTER TABLE `data_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `data_barang`
--
ALTER TABLE `data_barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `data_barang` (`id_barang`);

--
-- Ketidakleluasaan untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `data_barang` (`id_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
