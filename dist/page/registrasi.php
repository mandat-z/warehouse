<?php 
include 'C:\xampp\htdocs\warehouse\dist\includes\header.php';
include '../../config/cek_login.php';
include '../../config/koneksi.php';
include 'C:\xampp\htdocs\warehouse\dist\includes\navbar.php';
include 'C:\xampp\htdocs\warehouse\dist\includes\sidebar.php';  

// Proses simpan data registrasi
$pesan = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $username     = mysqli_real_escape_string($conn, $_POST['username']);
    $password     = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role         = mysqli_real_escape_string($conn, $_POST['role']);

    // Cek username sudah ada atau belum
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = '<div class="alert alert-danger">Username sudah terdaftar!</div>';
    } else {
        $sql = "INSERT INTO users (nama_lengkap, username, password, role) VALUES ('$nama_lengkap', '$username', '$password', '$role')";
        if (mysqli_query($conn, $sql)) {
            $pesan = '<div class="alert alert-success">Registrasi berhasil!</div>';
        } else {
            $pesan = '<div class="alert alert-danger">Registrasi gagal: '.mysqli_error($conn).'</div>';
        }
    }
}
?>

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Registrasi Akun Baru</h4>
            <?php if ($pesan) echo $pesan; ?>
            <form method="POST" class="forms-sample">
              <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
              </div>
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role" required>
                  <option value="">Pilih Role</option>
                  <option value="admin">Admin</option>
                  <option value="staff">Staff</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary me-2">Registrasi</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include 'C:\xampp\htdocs\warehouse\dist\includes\footer.php'; ?>
</div>