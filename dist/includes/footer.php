<!-- partial:partials/_footer.html -->
          <footer class="footer">
  <div class="d-sm-flex justify-content-center justify-content-sm-between">
    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023. </span>
  </div>
</footer>
<script src="/warehouse/dist/assets/vendors/chart.js/chart.umd.js"></script>
<script>
  
  // Chart.js
  var ctx = document.getElementById('lineChart').getContext('2d');
  var lineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?php echo json_encode($chart_labels); ?>,
      datasets: [
        {
          label: 'Barang Masuk',
          data: <?php echo json_encode($chart_masuk); ?>,
          borderColor: 'rgba(54, 162, 235, 1)',
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          tension: 0.4,
          fill: true
        },
        {
          label: 'Barang Keluar',
          data: <?php echo json_encode($chart_keluar); ?>,
          borderColor: 'rgba(255, 99, 132, 1)',
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          tension: 0.4,
          fill: true
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: true }
      },
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
  feather.replace();
</script>
</body>
</html>
 <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="/warehouse/dist/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->

    <!-- Plugin js for this page -->
    <script src="/warehouse/dist/assets/vendors/chart.js/chart.umd.js"></script>
    <script src="/warehouse/dist/assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <!-- <script src="/warehouse/dist/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script> -->
    <script src="/warehouse/dist/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
    <script src="/warehouse/dist/assets/js/dataTables.select.min.js"></script>
    <!-- End plugin js for this page -->

    <!-- inject:js -->
    <script src="/warehouse/dist/assets/js/off-canvas.js"></script>
    <script src="/warehouse/dist/assets/js/template.js"></script>
    <script src="/warehouse/dist/assets/js/settings.js"></script>
    <script src="/warehouse/dist/assets/js/todolist.js"></script>
    <!-- endinject -->

    <!-- Custom js for this page-->
    <script src="/warehouse/dist/assets/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="/warehouse/dist/assets/js/dashboard.js"></script>
    <!-- <script src="/warehouse/dist/assets/js/Chart.roundedBarCharts.js"></script> -->
    <!-- End custom js for this page-->

    <!-- Feather Icons -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace();
    </script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Modal Edit Data Barang
  var modalEditBarang = document.getElementById('modalEditData');
  if (modalEditBarang) {
    modalEditBarang.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      document.getElementById('edit_id_barang').value = button.getAttribute('data-id');
      document.getElementById('edit_kode_barang').value = button.getAttribute('data-kode');
      document.getElementById('edit_nama_barang').value = button.getAttribute('data-nama');
      document.getElementById('edit_kategori').value = button.getAttribute('data-kategori');
      document.getElementById('edit_satuan').value = button.getAttribute('data-satuan');
      document.getElementById('edit_lokasi_rak').value = button.getAttribute('data-lokasi');
    });
  }

  // Modal Edit Barang Masuk (jika ada)
  var modalEditMasuk = document.getElementById('modalEditMasuk');
  if (modalEditMasuk) {
    modalEditMasuk.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      document.getElementById('edit_id_masuk').value = button.getAttribute('data-id');
      document.getElementById('edit_id_barang').value = button.getAttribute('data-barang');
      document.getElementById('edit_jumlah').value = button.getAttribute('data-jumlah');
      document.getElementById('edit_tanggal').value = button.getAttribute('data-tanggal');
      document.getElementById('edit_keterangan').value = button.getAttribute('data-keterangan');
    });
  }

  // Modal Edit Barang Keluar (jika ada)
  var modalEditKeluar = document.getElementById('modalEditKeluar');
  if (modalEditKeluar) {
    modalEditKeluar.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      document.getElementById('edit_id_keluar').value = button.getAttribute('data-id');
      document.getElementById('edit_id_barang').value = button.getAttribute('data-barang');
      document.getElementById('edit_jumlah').value = button.getAttribute('data-jumlah');
      document.getElementById('edit_tanggal').value = button.getAttribute('data-tanggal');
      document.getElementById('edit_keterangan').value = button.getAttribute('data-keterangan');
    });
  }

  <?php if (isset($_GET['gagal_hapus'])): ?>
  var gagalModal = new bootstrap.Modal(document.getElementById('modalGagalHapus'));
  gagalModal.show();
<?php endif; ?>
});
</script>
