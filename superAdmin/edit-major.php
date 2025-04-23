<?php
require_once "../koneksi.php";
session_start();


if (empty($_SESSION['EMAIL'])) {
  header("Location: ../login.php");
}

if (isset($_POST['save'])) {
  $name = $_POST['name'];
  $is_active = $_POST['is_active'];
  

  $insert = mysqli_query($koneksi, "INSERT INTO majors (name, is_active) VALUES ('$name', '$is_active')");

  if ($insert) {
    header("Location: major.php");
  } else {
    header("Location: edit-major.php");
  }
}

if (isset($_GET['Edit'])) {
  $id = $_GET['Edit'];

  $qEdit = mysqli_query($koneksi, "SELECT * FROM majors WHERE id = $id");
  $rowUpdate = mysqli_fetch_assoc($qEdit); 
}

if (isset($_POST['edit'])) {
  $id = $_GET['Edit'];
  $name = $_POST['name'];
  $is_active = $_POST['is_active'];

  $qUpdate = mysqli_query($koneksi, "UPDATE majors SET name='$name', is_active='$is_active' WHERE id = $id");
  if ($qUpdate){
    header("Location: major.php");
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
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
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
              <h5 class="card-title"><?php echo isset($_GET['Edit']) ? 'Edit ' : 'Create New' .' '?>MAJORS</h5>
              <form action="" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                  <div class="col-sm-2">
                    <label for="">Nama</label>
                  </div>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" value="<?php echo isset($_GET['Edit']) ? $rowUpdate['name'] : '' ?>" required>
                  </div>
                </div>
    

                <div class="row mb-3">
                  <div class="col-sm-2">
                    <label for="">Status</label>
                  </div>
                  <div class="col-sm-10">
                    <select name="" id="" >
                      <option value="" hidden>Choose</option>
                      <option value="1">Active</option>
                      <option value="0">Non Active</option>
                    </select>
                    
                  </div>               
                </div>
                


                <div class="col mb-3">
                  <button class="btn btn-primary" type="submit" name="<?php echo isset($_GET['Edit']) ? 'edit' : 'save' ?>">Save</button>
                </div>
                
              </form>
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