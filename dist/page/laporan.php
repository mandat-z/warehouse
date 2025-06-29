<?php
include '../../config/koneksi.php';
include '../../config/cek_login.php';
?>
<?php include 'C:\xampp\htdocs\warehouse\dist\includes\header.php'; ?>
<?php include 'C:\xampp\htdocs\warehouse\dist\includes\navbar.php'; ?>
<?php include 'C:\xampp\htdocs\warehouse\dist\includes\sidebar.php'; ?>
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="d-flex justify-content-end mb-3">
      <a href="export_laporan_pdf.php?jenis=<?php echo urlencode(isset($_GET['jenis']) ? $_GET['jenis'] : ''); ?>&barang=<?php echo urlencode(isset($_GET['barang']) ? $_GET['barang'] : ''); ?>" target="_blank" class="btn btn-danger btn-rounded btn-fw">
        <i class="icon-printer"></i> Export PDF
      </a>
    </div>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Laporan Data Barang Masuk & Keluar</h4>
            <form class="row g-2 mb-3" method="GET" action="">
              <div class="col-md-3">
                <select class="form-select form-select-sm" name="jenis">
                  <option value="">Semua Jenis</option>
                  <option value="Masuk" <?php if(isset($_GET['jenis']) && $_GET['jenis']=='Masuk') echo 'selected'; ?>>Barang Masuk</option>
                  <option value="Keluar" <?php if(isset($_GET['jenis']) && $_GET['jenis']=='Keluar') echo 'selected'; ?>>Barang Keluar</option>
                </select>
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control form-control-sm" name="barang" placeholder="Cari Nama/Kode Barang" value="<?php echo isset($_GET['barang']) ? htmlspecialchars($_GET['barang']) : ''; ?>">
              </div>
              <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="laporan.php" class="btn btn-secondary btn-sm">Reset</a>
              </div>
            </form>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Tanggal</th>
                    <th>Lokasi Rak</th>
                    <th>Jenis</th>
                    <th>Petugas</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $where = [];
                  if (!empty($_GET['jenis'])) {
                    $jenis = $_GET['jenis'] == 'Masuk' ? 'Masuk' : 'Keluar';
                    $where[] = "jenis = '$jenis'";
                  }
                  if (!empty($_GET['barang'])) {
                    $barang = mysqli_real_escape_string($conn, $_GET['barang']);
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
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['kode_barang']}</td>
                            <td>{$row['nama_barang']}</td>
                            <td>{$row['kategori']}</td>
                            <td>{$row['jumlah']}</td>
                            <td>{$row['satuan']}</td>
                            <td>{$row['tanggal']}</td>
                            <td>{$row['lokasi_rak']}</td>
                            <td><label class='badge badge-" . ($row['jenis'] == 'Masuk' ? 'info' : 'success') . "'>{$row['jenis']}</label></td>
                            <td>{$row['petugas']}</td>
                            <td>{$row['keterangan']}</td>
                          </tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php include "C:/xampp/htdocs/warehouse/dist/includes/footer.php"; ?>
