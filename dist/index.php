<?php
include '../config/koneksi.php';
include '../config/cek_login.php';
include 'C:\xampp\htdocs\warehouse\dist\includes\header.php';
include 'C:\xampp\htdocs\warehouse\dist\includes\navbar.php';
include 'C:\xampp\htdocs\warehouse\dist\includes\sidebar.php';


// Welcome
$nama_lengkap = isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : 'User';

// Total stok barang (otomatis)
$qstok = mysqli_query($conn, "SELECT SUM(
    (SELECT IFNULL(SUM(jumlah),0) FROM barang_masuk WHERE id_barang=db.id_barang) -
    (SELECT IFNULL(SUM(jumlah),0) FROM barang_keluar WHERE id_barang=db.id_barang)
) as total_stok FROM data_barang db");
$total_stok = mysqli_fetch_assoc($qstok)['total_stok'] ?? 0;

// Jumlah jenis barang
$qjenis = mysqli_query($conn, "SELECT COUNT(*) as jenis FROM data_barang");
$jenis_barang = mysqli_fetch_assoc($qjenis)['jenis'] ?? 0;

// Barang masuk hari ini
$today = date('Y-m-d');
$qmasuk = mysqli_query($conn, "SELECT SUM(jumlah) as masuk_hari_ini FROM barang_masuk WHERE tanggal='$today'");
$masuk_hari_ini = mysqli_fetch_assoc($qmasuk)['masuk_hari_ini'] ?? 0;

// Barang keluar hari ini
$qkeluar = mysqli_query($conn, "SELECT SUM(jumlah) as keluar_hari_ini FROM barang_keluar WHERE tanggal='$today'");
$keluar_hari_ini = mysqli_fetch_assoc($qkeluar)['keluar_hari_ini'] ?? 0;

// Data chart aktivitas bulanan (barang masuk & keluar per bulan)
$chart_labels = [];
$chart_masuk = [];
$chart_keluar = [];
for ($i = 1; $i <= 12; $i++) {
    $bulan = str_pad($i, 2, '0', STR_PAD_LEFT);
    $label = date('M', mktime(0,0,0,$i,1));
    $chart_labels[] = $label;

    $qbm = mysqli_query($conn, "SELECT IFNULL(SUM(jumlah),0) as total FROM barang_masuk WHERE DATE_FORMAT(tanggal, '%m')='$bulan' AND DATE_FORMAT(tanggal, '%Y')=YEAR(CURDATE())");
    $chart_masuk[] = mysqli_fetch_assoc($qbm)['total'];

    $qbk = mysqli_query($conn, "SELECT IFNULL(SUM(jumlah),0) as total FROM barang_keluar WHERE DATE_FORMAT(tanggal, '%m')='$bulan' AND DATE_FORMAT(tanggal, '%Y')=YEAR(CURDATE())");
    $chart_keluar[] = mysqli_fetch_assoc($qbk)['total'];
}
?>

<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="row">
          <div class="col-12 col-xl-8 mb-4 mb-xl-0">
            <h2 class="fw-bold" style="font-size:2.2rem; letter-spacing:1px;">
              <span class="text-primary">Welcome</span>
              <span class="ms-2" style="color:#222;">
                <?php echo htmlspecialchars($nama_lengkap); ?>
              </span>
              !
            </h2>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Kiri: Card-card statistik -->
      <div class="col-lg-6 grid-margin stretch-card">
        <div class="row">
          <div class="col-md-6 mb-4 stretch-card transparent">
            <div class="card card-tale">
              <div class="card-body d-flex align-items-center">
                <div class="me-3">
                  <i data-feather="box" class="bg-primary text-white rounded-circle p-2" style="width:36px;height:36px;"></i>
                </div>
                <div>
                  <p class="mb-1 fw-bold" style="font-size: 1.1rem;">Total Stok Barang</p>
                  <p class="fs-30 mb-0 fw-bold"><?php echo $total_stok; ?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-4 stretch-card transparent">
            <div class="card card-dark-blue">
              <div class="card-body d-flex align-items-center">
                <div class="me-3">
                  <i data-feather="layers" class="bg-info text-white rounded-circle p-2" style="width:36px;height:36px;"></i>
                </div>
                <div>
                  <p class="mb-1 fw-bold" style="font-size: 1.1rem;">Jumlah Jenis Barang</p>
                  <p class="fs-30 mb-0 fw-bold"><?php echo $jenis_barang; ?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-4 stretch-card transparent">
            <div class="card card-light-blue">
              <div class="card-body d-flex align-items-center">
                <div class="me-3">
                  <i data-feather="arrow-down-circle" class="bg-success text-white rounded-circle p-2" style="width:36px;height:36px;"></i>
                </div>
                <div>
                  <p class="mb-1 fw-bold" style="font-size: 1.1rem;">Barang Masuk Hari Ini</p>
                  <p class="fs-30 mb-0 fw-bold"><?php echo $masuk_hari_ini; ?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-4 stretch-card transparent">
            <div class="card card-light-danger">
              <div class="card-body d-flex align-items-center">
                <div class="me-3">
                  <i data-feather="arrow-up-circle" class="bg-danger text-white rounded-circle p-2" style="width:36px;height:36px;"></i>
                </div>
                <div>
                  <p class="mb-1 fw-bold" style="font-size: 1.1rem;">Barang Keluar Hari Ini</p>
                  <p class="fs-30 mb-0 fw-bold"><?php echo $keluar_hari_ini; ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Kanan: Line Chart -->
      <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Aktivitas Barang Bulanan</h4>
            <canvas id="lineChart"></canvas>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->

<?php include 'C:\xampp\htdocs\warehouse\dist\includes\footer.php'; ?>


