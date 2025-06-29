<?php
require '../../fpdf/fpdf.php';
include '../../config/koneksi.php';

$jenis = isset($_GET['jenis']) ? $_GET['jenis'] : '';
$barang = isset($_GET['barang']) ? $_GET['barang'] : '';

$where = [];
if (!empty($jenis)) {
  $where[] = "jenis = '$jenis'";
}
if (!empty($barang)) {
  $barang = mysqli_real_escape_string($conn, $barang);
  $where[] = "(nama_barang LIKE '%$barang%' OR kode_barang LIKE '%$barang%')";
}
$where_sql = '';
if ($where) {
  $where_sql = 'WHERE ' . implode(' AND ', $where);
}

$query = "
SELECT * FROM (
  SELECT 
    b.kode_barang, b.nama_barang, b.kategori, bm.jumlah, b.satuan, bm.tanggal, b.lokasi_rak, 
    'Masuk' AS jenis, bm.petugas, bm.keterangan
  FROM barang_masuk bm
  JOIN data_barang b ON bm.id_barang = b.id_barang
  UNION ALL
  SELECT 
    b.kode_barang, b.nama_barang, b.kategori, bk.jumlah, b.satuan, bk.tanggal, b.lokasi_rak, 
    'Keluar' AS jenis, bk.petugas, bk.keterangan
  FROM barang_keluar bk
  JOIN data_barang b ON bk.id_barang = b.id_barang
) AS laporan
$where_sql
ORDER BY tanggal DESC
";
$result = mysqli_query($conn, $query);

// Mulai PDF
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Laporan Data Barang Masuk & Keluar', 0, 1, 'C');
$pdf->Ln(2);

// Header tabel
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(230,230,230);
$pdf->Cell(25, 8, 'Kode', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Nama Barang', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Kategori', 1, 0, 'C', true);
$pdf->Cell(18, 8, 'Jumlah', 1, 0, 'C', true);
$pdf->Cell(18, 8, 'Satuan', 1, 0, 'C', true);
$pdf->Cell(28, 8, 'Tanggal', 1, 0, 'C', true);
$pdf->Cell(28, 8, 'Lokasi Rak', 1, 0, 'C', true);
$pdf->Cell(18, 8, 'Jenis', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Petugas', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Keterangan', 1, 1, 'C', true);

// Data tabel
$pdf->SetFont('Arial', '', 9);
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(25, 7, $row['kode_barang'], 1);
    $pdf->Cell(40, 7, $row['nama_barang'], 1);
    $pdf->Cell(25, 7, $row['kategori'], 1);
    $pdf->Cell(18, 7, $row['jumlah'], 1);
    $pdf->Cell(18, 7, $row['satuan'], 1);
    $pdf->Cell(28, 7, $row['tanggal'], 1);
    $pdf->Cell(28, 7, $row['lokasi_rak'], 1);
    $pdf->Cell(18, 7, $row['jenis'], 1);
    $pdf->Cell(25, 7, $row['petugas'], 1);
    $pdf->Cell(40, 7, $row['keterangan'], 1, 1);
}

// Buat nama file dinamis
$filename = 'Laporan-Barang';
if ($jenis) $filename .= '-' . $jenis;
if ($barang) $filename .= '-' . preg_replace('/[^a-zA-Z0-9]/', '_', $barang);
$filename .= '.pdf';

$pdf->Output('D', $filename);
exit;
?>