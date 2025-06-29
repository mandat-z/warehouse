<!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="../index.php">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/warehouse/dist/page/databarang.php" aria-expanded="false" aria-controls="ui-basic">
        <i class="icon-box menu-icon"></i>
        <span class="menu-title">Data Barang</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/warehouse/dist/page/barangmasuk.php" aria-expanded="false" aria-controls="form-elements">
        <i class="icon-inbox menu-icon"></i>
        <span class="menu-title">Barang Masuk</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/warehouse/dist/page/barangkeluar.php" aria-expanded="false" aria-controls="charts">
        <i class="icon-outbox menu-icon"></i>
        <span class="menu-title">Barang Keluar</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/warehouse/dist/page/laporan.php" aria-expanded="false" aria-controls="tables">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Laporan</span>
      </a>
    </li>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
    <li class="nav-item">
      <a class="nav-link" href="/warehouse/dist/page/registrasi.php">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Registrasi Akun</span>
      </a>
    </li>
    <?php endif; ?>
    <li class="nav-item">
      <a class="nav-link" href="/warehouse/dist/logout.php">
        <i class="icon-power menu-icon"></i>
        <span class="menu-title">Logout</span>
      </a>
    </li>
    
  </ul>
</nav>