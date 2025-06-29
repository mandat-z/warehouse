<?php
include '../../config/koneksi.php';
include '../../config/cek_login.php';
?>
<?php
// Proses hapus barang masuk (admin saja)
if (isset($_GET['hapus']) && $_SESSION['role'] == 'admin') {
    $id_masuk = mysqli_real_escape_string($conn, $_GET['hapus']);
    mysqli_query($conn, "DELETE FROM barang_masuk WHERE id_masuk='$id_masuk'");
    echo "<script>window.location.href='barangmasuk.php';</script>";
    exit;
}

// Proses update barang masuk (admin & staff)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_masuk']) && in_array($_SESSION['role'], ['admin','staff'])) {
    $id_masuk   = mysqli_real_escape_string($conn, $_POST['edit_id_masuk']);
    $id_barang  = mysqli_real_escape_string($conn, $_POST['edit_id_barang']);
    $jumlah     = mysqli_real_escape_string($conn, $_POST['edit_jumlah']);
    $tanggal    = mysqli_real_escape_string($conn, $_POST['edit_tanggal']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['edit_keterangan']);

    $sql = "UPDATE barang_masuk SET id_barang='$id_barang', jumlah='$jumlah', tanggal='$tanggal', keterangan='$keterangan' WHERE id_masuk='$id_masuk'";
    mysqli_query($conn, $sql);
    echo "<script>window.location.href='barangmasuk.php';</script>";
    exit;
}

// Proses tambah barang masuk (admin & staff)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_masuk']) && isset($_POST['id_barang']) && isset($_POST['jumlah']) && isset($_POST['tanggal'])) {
    $id_masuk   = mysqli_real_escape_string($conn, $_POST['id_masuk']);
    $id_barang  = mysqli_real_escape_string($conn, $_POST['id_barang']);
    $jumlah     = mysqli_real_escape_string($conn, $_POST['jumlah']);
    $tanggal    = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $petugas    = mysqli_real_escape_string($conn, $_SESSION['nama_lengkap']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

    $sql = "INSERT INTO barang_masuk (id_masuk, id_barang, jumlah, tanggal, petugas, keterangan)
            VALUES ('$id_masuk', '$id_barang', '$jumlah', '$tanggal', '$petugas', '$keterangan')";
    mysqli_query($conn, $sql);
    echo "<script>window.location.href='barangmasuk.php';</script>";
    exit;
}
?>
<?php include 'C:\xampp\htdocs\warehouse\dist\includes\header.php'; ?>
<?php include 'C:\xampp\htdocs\warehouse\dist\includes\navbar.php'; ?>
<?php include 'C:\xampp\htdocs\warehouse\dist\includes\sidebar.php'; ?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="d-flex justify-content-end mb-3">
      <button type="button" class="btn btn-primary btn-rounded btn-fw" data-bs-toggle="modal" data-bs-target="#modalTambahData">
        <i class="icon-circle-plus"></i> Tambah Data
      </button>
    </div>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Barang Masuk</h4>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>ID Masuk</th>
                    <th>ID Barang</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Petugas</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = "SELECT * FROM barang_masuk ORDER BY id_masuk";
                  $result = mysqli_query($conn, $query);
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo "<tr>
                          <td>{$row['id_masuk']}</td>
                          <td>{$row['id_barang']}</td>
                          <td>{$row['jumlah']}</td>
                          <td>{$row['tanggal']}</td>
                          <td>{$row['petugas']}</td>
                          <td>{$row['keterangan']}</td>
                          <td>
                              <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditMasuk'
                                  data-id='{$row['id_masuk']}'
                                  data-barang='{$row['id_barang']}'
                                  data-jumlah='{$row['jumlah']}'
                                  data-tanggal='{$row['tanggal']}'
                                  data-keterangan='{$row['keterangan']}'
                              >Edit</button>
                              ";
                      // Hapus hanya untuk admin, edit untuk admin & staff
                      if ($_SESSION['role'] == 'admin') {
                          echo "<a href='barangmasuk.php?hapus={$row['id_masuk']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin hapus?')\">Hapus</a>";
                      }
                      echo "</td></tr>";
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
            <h5 class="modal-title" id="modalTambahDataLabel">Tambah Barang Masuk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="forms-sample" method="POST" action="">
              <div class="form-group">
                <label for="id_masuk">ID Masuk</label>
                <input type="text" class="form-control" id="id_masuk" name="id_masuk" required>
              </div>
              <div class="form-group">
                <label for="id_barang">ID Barang</label>
                <select class="form-control" id="id_barang" name="id_barang" required>
                  <option value="">Pilih Barang</option>
                  <?php
                  $qbarang = mysqli_query($conn, "SELECT * FROM data_barang");
                  while ($b = mysqli_fetch_assoc($qbarang)) {
                    echo "<option value='{$b['id_barang']}' data-kategori='{$b['kategori']}' data-satuan='{$b['satuan']}' data-lokasi='{$b['lokasi_rak']}'>{$b['kode_barang']} - {$b['nama_barang']}</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="kategori">Kategori</label>
                <input type="text" class="form-control" id="kategori" readonly>
              </div>
              <div class="form-group">
                <label for="satuan">Satuan</label>
                <input type="text" class="form-control" id="satuan" readonly>
              </div>
              <div class="form-group">
                <label for="lokasi_rak">Lokasi Rak</label>
                <input type="text" class="form-control" id="lokasi_rak" readonly>
              </div>
              <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah" required>
              </div>
              <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
              </div>
              <div class="form-group">
                <label for="petugas">Petugas</label>
                <input type="text" class="form-control" id="petugas" name="petugas" value="<?php echo $_SESSION['nama_lengkap']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="2"></textarea>
              </div>
              <button type="submit" class="btn btn-primary me-2">Submit</button>
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Edit Barang Masuk -->
    <div class="modal fade" id="modalEditMasuk" tabindex="-1" aria-labelledby="modalEditMasukLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditMasukLabel">Edit Barang Masuk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="forms-sample" method="POST" action="">
              <input type="hidden" name="edit_id_masuk" id="edit_id_masuk">
              <div class="form-group">
                <label for="edit_id_barang">ID Barang</label>
                <select class="form-control" id="edit_id_barang" name="edit_id_barang" required>
                  <option value="">Pilih Barang</option>
                  <?php
                  $qbarang = mysqli_query($conn, "SELECT * FROM data_barang");
                  while ($b = mysqli_fetch_assoc($qbarang)) {
                    echo "<option value='{$b['id_barang']}'>{$b['kode_barang']} - {$b['nama_barang']}</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="edit_jumlah">Jumlah</label>
                <input type="number" class="form-control" id="edit_jumlah" name="edit_jumlah" required>
              </div>
              <div class="form-group">
                <label for="edit_tanggal">Tanggal</label>
                <input type="date" class="form-control" id="edit_tanggal" name="edit_tanggal" required>
              </div>
              <div class="form-group">
                <label for="edit_keterangan">Keterangan</label>
                <textarea class="form-control" id="edit_keterangan" name="edit_keterangan"></textarea>
              </div>
              <button type="submit" name="update_masuk" class="btn btn-primary me-2">Update</button>
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script>
      document.getElementById('id_barang').addEventListener('change', function() {
        var selected = this.options[this.selectedIndex];
        document.getElementById('kategori').value = selected.getAttribute('data-kategori') || '';
        document.getElementById('satuan').value = selected.getAttribute('data-satuan') || '';
        document.getElementById('lokasi_rak').value = selected.getAttribute('data-lokasi') || '';
      });
    </script>
<?php include 'C:\xampp\htdocs\warehouse\dist\includes\footer.php'; ?>