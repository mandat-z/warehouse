<?php
include '../../config/koneksi.php';
include '../../config/cek_login.php';

// Proses hapus data barang
if (isset($_GET['hapus']) && $_SESSION['role'] == 'admin') {
    $id_barang = mysqli_real_escape_string($conn, $_GET['hapus']);

    // Cek apakah barang masih dipakai di transaksi
    $cek_transaksi = mysqli_query($conn, "SELECT * FROM barang_masuk WHERE id_barang='$id_barang'");
    $cek_transaksi2 = mysqli_query($conn, "SELECT * FROM barang_keluar WHERE id_barang='$id_barang'");
    if (mysqli_num_rows($cek_transaksi) > 0 || mysqli_num_rows($cek_transaksi2) > 0) {
        // Jika masih dipakai, tampilkan modal gagal hapus
        header("Location: databarang.php?gagal_hapus=1");
exit;
    } else {
        // Jika tidak dipakai, hapus data barang
        mysqli_query($conn, "DELETE FROM data_barang WHERE id_barang='$id_barang'");
        echo "<script>window.location.href='databarang.php';</script>";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah']) && $_SESSION['role'] == 'admin') {
    $id_barang = mysqli_real_escape_string($conn, $_POST['id_barang']);
    $kode_barang = mysqli_real_escape_string($conn, $_POST['kode_barang']);
    $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $satuan = mysqli_real_escape_string($conn, $_POST['satuan']);
    $stok = mysqli_real_escape_string($conn, $_POST['stok']);
    $lokasi_rak = mysqli_real_escape_string($conn, $_POST['lokasi_rak']);

    $sql = "INSERT INTO data_barang (id_barang, kode_barang, nama_barang, kategori, satuan, stok, lokasi_rak)
            VALUES ('$id_barang', '$kode_barang', '$nama_barang', '$kategori', '$satuan', '$stok', '$lokasi_rak')";
    mysqli_query($conn, $sql);
    echo "<script>window.location.href=window.location.href;</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update']) && $_SESSION['role'] == 'admin') {
    $id_barang = mysqli_real_escape_string($conn, $_POST['edit_id_barang']);
    $kode_barang = mysqli_real_escape_string($conn, $_POST['edit_kode_barang']);
    $nama_barang = mysqli_real_escape_string($conn, $_POST['edit_nama_barang']);
    $kategori = mysqli_real_escape_string($conn, $_POST['edit_kategori']);
    $satuan = mysqli_real_escape_string($conn, $_POST['edit_satuan']);
    $lokasi_rak = mysqli_real_escape_string($conn, $_POST['edit_lokasi_rak']);

    $sql = "UPDATE data_barang SET 
              kode_barang='$kode_barang', 
              nama_barang='$nama_barang', 
              kategori='$kategori', 
              satuan='$satuan', 
              lokasi_rak='$lokasi_rak'
            WHERE id_barang='$id_barang'";
    mysqli_query($conn, $sql);
    echo "<script>window.location.href=window.location.href;</script>";
    exit;
}
?>
<?php include 'C:\xampp\htdocs\warehouse\dist\includes\header.php'; ?>
<?php include 'C:\xampp\htdocs\warehouse\dist\includes\navbar.php'; ?>
<?php include 'C:\xampp\htdocs\warehouse\dist\includes\sidebar.php'; ?>
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <?php if ($_SESSION['role'] == 'admin'): ?>
    <div class="d-flex justify-content-end mb-3">
      <button type="button" class="btn btn-primary btn-rounded btn-fw" data-bs-toggle="modal" data-bs-target="#modalTambahData">
        <i class="icon-circle-plus"></i> Tambah Data
      </button>
    </div>
    <?php endif; ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Data Barang</h4>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>ID Barang</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <th>Lokasi Rak</th>
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                    <th>Aksi</th>
                    <?php endif; ?>
                  </tr>
                </thead>
                <tbody>
<?php
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$sql = "SELECT * FROM data_barang";
if ($search != '') {
    $sql .= " WHERE kode_barang LIKE '%$search%' OR nama_barang LIKE '%$search%' OR kategori LIKE '%$search%'";
}
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $id_barang = $row['id_barang'];

    // Hitung total masuk
    $q_masuk = mysqli_query($conn, "SELECT SUM(jumlah) as total_masuk FROM barang_masuk WHERE id_barang='$id_barang'");
    $masuk = mysqli_fetch_assoc($q_masuk);
    $total_masuk = $masuk['total_masuk'] ?? 0;

    // Hitung total keluar
    $q_keluar = mysqli_query($conn, "SELECT SUM(jumlah) as total_keluar FROM barang_keluar WHERE id_barang='$id_barang'");
    $keluar = mysqli_fetch_assoc($q_keluar);
    $total_keluar = $keluar['total_keluar'] ?? 0;

    // Stok otomatis
    $stok_otomatis = $total_masuk - $total_keluar;

    echo "<tr>
        <td>{$row['id_barang']}</td>
        <td>{$row['kode_barang']}</td>
        <td>{$row['nama_barang']}</td>
        <td>{$row['kategori']}</td>
        <td>{$row['satuan']}</td>
        <td>{$stok_otomatis}</td>
        <td>{$row['lokasi_rak']}</td>";
    if ($_SESSION['role'] == 'admin') {
        echo "<td>
            <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditData'
              data-id='{$row['id_barang']}'
              data-kode='{$row['kode_barang']}'
              data-nama='{$row['nama_barang']}'
              data-kategori='{$row['kategori']}'
              data-satuan='{$row['satuan']}'
              data-lokasi='{$row['lokasi_rak']}'>Edit</button>
            <a href='databarang.php?hapus={$row['id_barang']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin hapus?')\">Hapus</a>
        </td>";
    }
    echo "</tr>";
}
?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Form Tambah Data -->
    <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTambahDataLabel">Tambah Data Barang</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="forms-sample" method="POST" action="">
              <div class="form-group">
                <label for="id_barang">ID Barang</label>
                <input type="text" class="form-control" name="id_barang" id="id_barang" placeholder="ID Barang" required>
              </div>
              <div class="form-group">
                <label for="kode_barang">Kode Barang</label>
                <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Kode Barang" required>
              </div>
              <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" required>
              </div>
              <div class="form-group">
                <label for="kategori">Kategori</label>
                <input type="text" class="form-control" name="kategori" id="kategori" placeholder="Kategori" required>
              </div>
              <div class="form-group">
                <label for="satuan">Satuan</label>
                <input type="text" class="form-control" name="satuan" id="satuan" placeholder="Satuan" required>
              </div>
              <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" class="form-control" name="stok" id="stok" placeholder="Stok" required>
              </div>
              <div class="form-group">
                <label for="lokasi_rak">Lokasi Rak</label>
                <input type="text" class="form-control" name="lokasi_rak" id="lokasi_rak" placeholder="Lokasi Rak" required>
              </div>
              <button type="submit" name="tambah" class="btn btn-primary me-2">Submit</button>
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Form Edit Data Barang -->
    <div class="modal fade" id="modalEditData" tabindex="-1" aria-labelledby="modalEditDataLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditDataLabel">Edit Data Barang</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="forms-sample" method="POST" action="">
              <input type="hidden" name="edit_id_barang" id="edit_id_barang">
              <div class="form-group">
                <label for="edit_kode_barang">Kode Barang</label>
                <input type="text" class="form-control" name="edit_kode_barang" id="edit_kode_barang" required>
              </div>
              <div class="form-group">
                <label for="edit_nama_barang">Nama Barang</label>
                <input type="text" class="form-control" name="edit_nama_barang" id="edit_nama_barang" required>
              </div>
              <div class="form-group">
                <label for="edit_kategori">Kategori</label>
                <input type="text" class="form-control" name="edit_kategori" id="edit_kategori" required>
              </div>
              <div class="form-group">
                <label for="edit_satuan">Satuan</label>
                <input type="text" class="form-control" name="edit_satuan" id="edit_satuan" required>
              </div>
              <div class="form-group">
                <label for="edit_lokasi_rak">Lokasi Rak</label>
                <input type="text" class="form-control" name="edit_lokasi_rak" id="edit_lokasi_rak" required>
              </div>
              <button type="submit" name="update" class="btn btn-primary me-2">Update</button>
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Gagal Hapus -->
    <div class="modal fade" id="modalGagalHapus" tabindex="-1" aria-labelledby="modalGagalHapusLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="modalGagalHapusLabel">Gagal Menghapus Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Data barang tidak bisa dihapus karena masih dipakai di transaksi barang masuk atau keluar.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
<?php include "C:/xampp/htdocs/warehouse/dist/includes/footer.php"; ?>
