<?php
session_start();
include '../koneksi.php';


if (empty($_SESSION['EMAIL'])) {
  header("Location: ../login.php");
}
$queryLmd = mysqli_query($koneksi, "SELECT  l.*,u.name FROM learning_modul_details l
LEFT JOIN
    learning_moduls u ON l.learning_modul_id = u.id");
$Lmd = mysqli_fetch_all($queryLmd, MYSQLI_ASSOC);



if (isset($_GET['idDel'])) {
  $id = $_GET['idDel'];

  $del = mysqli_query($koneksi, "DELETE FROM learning_modul_details WHERE id = $id");
  if ($del) {
    header("Location: modul-detail.php?delete=berhasil");
  }
}



?>
<!DOCTYPE html>
<html lang="en">

<?php include '../inc/head.php'; ?>

<body>

  <!-- ======= Header ======= -->
  <?php  include "../inc/header.php"; ?>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <?php  include "../inc/sidebar.php"; ?>
  <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Admin</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Admin</a></li>
          <li class="breadcrumb-item">Pages</li>
          <li class="breadcrumb-item active">Blank</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Detail Module</h5>
              <div class="table table-responsive">
                <table class="table table-bordered">
                  <tr>
                    <th>No</th>
                    <th>Learning Module Name</th>
                    <th>File Name Module</th>
                    <th>File</th>
                    <th>Reference Link</th>
                    <th>Actions</th>
                  </tr>
                  <?php
                  $no = 1;
                  foreach ($Lmd as $lmdt) {
                  ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= $lmdt['name'] ?></td>
                      <td><?= $lmdt['file_name'] ?></td>
                      <td><a href="../assets/uploads/<?= $lmdt['file'] ?>" target="_blank">Lihat PDF</a></td>
                      <td><?= $lmdt['reference_link'] ?></td>
                      <td><a href="print.php" class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a>
                      <a href="edit-module.php?Edit=<?php echo $lmdt['id'] ?>" class="btn btn-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
                      <a onclick="return confirm ('Yakin ingin menghapus?')" href="modul-detail.php?idDel=<?php echo $lmdt['id'] ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                      </td>
                    </tr>
                  <?php
                  } ?>
                </table>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?= include '../inc/footer.php'; ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>