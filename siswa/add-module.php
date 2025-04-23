<?php
require_once "../koneksi.php";
session_start();


if (empty($_SESSION['EMAIL'])) {
  header("Location: ../login.php");
}

//jika button simpan di klik
if (isset($_POST['save'])) {
  $instructor_id = $_POST['instructor_id'];
  $name = $_POST['name'];
  $description = $_POST['description'];
  $status = $_POST['is_active'];

  $insert = mysqli_query($koneksi, "INSERT INTO learning_moduls (`instructor_id`, `name`, `description`, `is_active`) VALUES ('$instructor_id', '$name', '$description',  '$status')");
  if ($insert) {
    header("Location: modul.php?simpan=berhasil");
  }
    
  
}

if (isset($_GET['Edit'])) {
  $id = $_GET['Edit'];
  
  $qEdit = mysqli_query($koneksi, "SELECT * FROM learning_moduls WHERE id = $id");
  $rowUpdate = mysqli_fetch_assoc($qEdit); 
}

if (isset($_POST['edit'])) {
  $id = $_GET['Edit'];
  $instructor_id = $_POST['instructor_id'];
  $name = $_POST['name'];
  $description = $_POST['description'];
  $status = $_POST['is_active'];
  
    
  $qUpdate = mysqli_query($koneksi, "UPDATE learning_moduls SET instructor_id='$instructor_id', name='$name', description='$description', is_active='$status'  WHERE id = $id");
  if ($qUpdate){
    header("Location: modul.php?edit=berhasil");
  }
}

$queryInstructors = mysqli_query($koneksi, "SELECT i.*,u.name FROM instructors i
LEFT JOIN
    users u ON i.user_id = u.id");
$instructors = mysqli_fetch_all($queryInstructors, MYSQLI_ASSOC);

$user = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");
$rowUsers = mysqli_fetch_all($user, MYSQLI_ASSOC);




?>
<!DOCTYPE html>
<html lang="en">

<?php include '../inc/head.php'; ?>

<body>

  <!-- ======= Header ======= -->
  <?php  include "../inc/header.php"; ?>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <?php include "../siswa/inc/sidebar.php"; ?>
  <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Admin Page</h1>
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
              <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit ' : 'Create New ' .' '?>Module</h5>
              <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="mb-3 row">
                      <div class="col-sm-4">
                        <label for="">Instruktur</label>
                      </div>
                      <div class="col-sm-8">
                      <select id="instructor_id" class="form-control" name="instructor_id">
                        <option value="0" hidden>Choose Instruktur</option>
                        <?php foreach ($instructors as $instructor) { ?>
                          <option value="<?php echo $instructor['id']?>"><?php echo $instructor['name']?></option>
                        <?php } ?>
                      </select>
                      </div>
                    </div>

                                     

                    <div class="mb-3 row">
                      <div class="col-sm-4">
                        <label for="">Name</label>
                      </div>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="name" placeholder="Input your module name" required value="<?php echo isset($_GET['Edit']) ? $rowUpdate['name'] : '' ?>">
                      </div>
                    </div>

                    <div class="mb-3 row">
                      <div class="col-sm-4">
                        <label for="">Description Module</label>
                      </div>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="description" placeholder=""  value="<?php echo isset($_GET['Edit']) ? $rowUpdate['description'] : '' ?>">
                      </div>
                    </div>

                    <div class="mb-3 row">
                      <div class="col-sm-4">
                        <label for="">Status</label>
                      </div>
                      <div class="col-sm-8">
                      <select name="is_active" id="" >
                          <option value="" hidden>Choose</option>
                          <option value="1">Active</option>
                          <option value="0">Non Active</option>
                        </select>
                      </div>
                    </div>

                  </div>

                </div>

                <div class="row mb-3">
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