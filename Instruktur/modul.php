<?php
session_start();
include '../koneksi.php';


if (empty($_SESSION['EMAIL'])) {
  header("Location: ../login.php");
}

$queryLm = mysqli_query($koneksi, "SELECT * FROM learning_moduls");
$Lm = mysqli_fetch_all($queryLm, MYSQLI_ASSOC);

$instructor = mysqli_query($koneksi, "SELECT i.*,u.name FROM instructors i LEFT JOIN users u ON i.user_id = u.id");
$rowIns = mysqli_fetch_all($instructor, MYSQLI_ASSOC);


if (isset($_GET['idDel'])) {
  $id = $_GET['idDel'];

  $del = mysqli_query($koneksi, "DELETE FROM learning_moduls WHERE id = $id");
  if ($del) {
    header("Location: modul.php?delete=berhasil");
  }
}



?>
<!DOCTYPE html>
<html lang="en">

<?php include '../inc/head.php'; ?>

<body>

  <!-- ======= Header ======= -->
  <?php include "../inc/header.php"; ?>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <?php include "../instruktur/inc/sidebar.php"; ?>
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
              <h5 class="card-title">Data Module</h5>
              <div class="table table-responsive">
                <div align="right" class="mb-3 mt-3">
                  <a class="btn btn-primary mb-2" href="add-module.php">CREATE MODULE</a>
                </div>
                <table class="table table-bordered">
                  <tr>
                    <th>No</th>
                    <th>Instruktur</th>
                    <th>Name</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>File</th>
                    <th>Actions</th>
                  </tr>
                  <?php
                  $no = 1;
                  foreach ($Lm as $lms) {
                    ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= $lms['instructor_id'] ?></td>
                      <td><?= $lms['name'] ?></td>
                      <td><?= $lms['description'] ?></td>
                      <td><?= $lms['is_active'] ?></td>
                      <td><a href="edit-module.php" class="btn btn-primary btn-sm">Add File</i></a></td>
                      <td>
                        <a href="add-module.php?Edit=<?php echo $lms['id'] ?>" class="btn btn-success btn-sm"><i
                            class="bi bi-pencil-fill"></i></a>
                        <a onclick="return confirm ('Yakin ingin menghapus?')"
                          href="modul.php?idDel=<?php echo $lms['id'] ?>" class="btn btn-danger btn-sm"><i
                            class="bi bi-trash"></i></a>
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

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

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