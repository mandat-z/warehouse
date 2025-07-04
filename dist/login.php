<?php
session_start();
include '../config/koneksi.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // Cek user di database
  $sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
  $result = mysqli_query($conn, $sql);
  $user = mysqli_fetch_assoc($result);

  if ($user && password_verify($password, $user['password'])) {
    // Login sukses, simpan session
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
    $_SESSION['role'] = $user['role'];
    header("Location: index.php");
    exit;
  } else {
    $error = "Username atau password salah!";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Warehouse Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="
    house/dist/assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="/warehouse/dist/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="/warehouse/dist/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/warehouse/dist/assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/warehouse/dist/assets/vendors/mdi/css/materialdesignicons.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/warehouse/dist/assets/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="/warehouse/dist/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <div class="brand-logo">
                  <img src="\warehouse\dist\assets\images\logowh.png" alt="logo">
                </div>
                <h4>Hello! let's get started</h4>
                <h6 class="font-weight-light">Sign in to continue.</h6>
                <?php if ($error): ?>
                  <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form class="pt-3" method="POST" action="">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" name="username" placeholder="Username" required>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" required>
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center"> 
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="/warehouse/dist/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/warehouse/dist/assets/js/off-canvas.js"></script>
    <script src="/warehouse/dist/assets/js/template.js"></script>
    <script src="/warehouse/dist/assets/js/settings.js"></script>
    <script src="/warehouse/dist/assets/js/todolist.js"></script>
    <!-- endinject -->
  </body>
</html>