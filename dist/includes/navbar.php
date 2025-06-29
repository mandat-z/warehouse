<?php
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$nama_lengkap = isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : '';
?>
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <a class="navbar-brand brand-logo me-5" href="index.php"><img src="\warehouse\dist\assets\images\logowh.png" class="me-2" alt="logo" /></a>
    <a class="navbar-brand brand-logo-mini" href="index.php"><img src="\warehouse\dist\assets\images\logomini.png" alt="logo" /></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button class="navbar-toggler navbar-toggler align-self-center me-3" type="button" data-toggle="minimize">
      <span class="icon-menu"></span>
    </button>
    <!-- Search form start -->
    <form class="d-flex me-3" method="GET" action="/warehouse/dist/page/databarang.php" style="width: 300px;">
      <div class="input-group">
        <span class="input-group-text bg-white border-0 ps-3" style="border-radius: 50px 0 0 50px;">
          <i data-feather="search"></i>
        </span>
        <input type="text" class="form-control rounded-pill" name="search" placeholder="Cari data barang..." aria-label="search" style="border-radius: 0 50px 50px 0; height: 38px;">
      </div>
    </form>
    <!-- Search form end -->
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown" id="profileDropdown">
          <img src="/warehouse/dist/assets/images/faces/yuno.jpg" alt="profile" class="me-2" />
          <span class="d-none d-md-inline text-dark fw-bold"><?php echo ucfirst($role) . " - " . $nama_lengkap; ?></span>
        </a>
      </li>
    </ul>
  </div>
</nav>
