<?php
require_once "../koneksi.php";
session_start();


if (empty($_SESSION['EMAIL'])) {
  header("Location: ../login.php");
}

//jika button simpan di klik
if (isset($_POST['save'])) {
  // var_dump($_POST);
  // die();
  $learning_modul_id = $_POST['learning_modul_id'];
  $file_name = $_POST['file_name'];
  $referance_link = $_POST['reference_link'];
  $file = $_FILES['file'];

  
  
  if ($file['error'] == 0) {
    $fileName = uniqid() . "_" . basename($file['name']);
    $filePath = "../assets/uploads/" . $fileName;
    move_uploaded_file($file['tmp_name'], $filePath);
    
    $insert = mysqli_query($koneksi, "INSERT INTO learning_modul_details (`learning_modul_id`, `file_name`, `reference_link`, `file`) VALUES ('$learning_modul_id', '$file_name', '$referance_link', '$fileName')");
    if ($insert) {
      header("Location: modul-detail.php?berhasil=disimpan");
    }
    
  }
}

if (isset($_GET['Edit'])) {
  $id = $_GET['Edit'];
  
  $qEdit = mysqli_query($koneksi, "SELECT * FROM learning_modul_details WHERE id = $id");
  $rowUpdate = mysqli_fetch_assoc($qEdit); 
}

if (isset($_POST['edit'])) {

  $id = $_GET['Edit'];
  $learning_modul_id = $_POST['learning_modul_id'];
  $file_name = $_POST['file_name'];
  $referance_link = $_POST['reference_link'];
  $file = $_FILES['file'];
  
  $fillQupdate = '';
  if ($file['error'] == 0) {
    $fileName = uniqid() . "_" . basename($file['name']);
    $filePath = "../assets/uploads/" . $fileName;
    if (move_uploaded_file($file['tmp_name'], $filePath)){
      $cekFile = mysqli_query($koneksi, "SELECT file FROM learning_modul_details WHERE id =$id");
      $fileLama = mysqli_fetch_assoc($cekFile);
      if ($fileLama && file_exists("../assets/uploads/" . $fileLama['file'])) {
        unlink("../assets/uploads/" . $fileLama['file']);
      }
      $fillQupdate = "file='$fileName',";
    }else {
      echo "EDIT GAGAL";
    }
  }
  
  $qUpdate = mysqli_query($koneksi, "UPDATE learning_modul_details SET $fillQupdate learning_modul_id='$learning_modul_id', file_name='$file_name', reference_link='$referance_link', file='$file'  WHERE id = $id");
  if ($qUpdate){
    header("Location: modul-detail.php?update=berhasil");
  }
}

$queryLm = mysqli_query($koneksi, "SELECT * FROM learning_moduls");
$Lm = mysqli_fetch_all($queryLm, MYSQLI_ASSOC);



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
                        <label for="">Learning Module Name</label>
                      </div>
                      <div class="col-sm-8">
                        <select id="learning_modul_id" class="form-control" name="learning_modul_id">
                          <option value="0" hidden>choose learning module</option>
                          <?php foreach ($Lm as $lms) { ?>
                            <option value="<?php echo $lms['id']?>"><?php echo $lms['name']?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>

                    <div class="mb-3 row">
                      <div class="col-sm-4">
                        <label for="">File Name</label>
                      </div>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="file_name" placeholder="Input your module name" required value="<?php echo isset($_GET['Edit']) ? $rowUpdate['file_name'] : '' ?>">
                      </div>
                    </div>

                    <div class="mb-3 row">
                      <div class="col-sm-4">
                        <label for="">File Module</label>
                      </div>
                      <div class="col-sm-8">
                        <input type="file" class="form-control" name="file" value="<?php echo isset($_GET['Edit']) ? $rowUpdate['file'] : '' ?>">
                      </div>
                    </div>

                    <div class="mb-3 row">
                      <div class="col-sm-4">
                        <label for="">Reference Link Module</label>
                      </div>
                      <div class="col-sm-8">
                        <input type="link" class="form-control" name="reference_link" placeholder="ex:https://www.github.com" value="<?php echo isset($_GET['Edit']) ? $rowUpdate['reference_link'] : '' ?>">
                      </div>
                    </div>
                  </div>

                </div>

                <div class="row mb-3">
                  <button class="btn btn-primary " type="submit" name="<?php echo isset($_GET['Edit']) ? 'edit' : 'save' ?>">Save</button>
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