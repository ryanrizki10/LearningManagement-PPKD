<?php
require_once "../koneksi.php";
session_start();


if (empty($_SESSION['EMAIL'])) {
  header("Location: ../login.php");
}

//jika button simpan di klik
if (isset($_POST['save'])) {
  $major_id = $_POST['majors_id'];
  $user_id = $_POST['user_id'];
  $gender = $_POST['gender'];
  $date_of_birth = $_POST['date_of_birth'];
  $place_of_birth = $_POST['place_of_birth'];
  $status = $_POST['is_active'];
  $photo = $_FILES['photo'];

  
  
  if ($photo['error'] == 0) {
    $fileName = uniqid() . "_" . basename($photo['name']);
    $filePath = "../assets/uploads/" . $fileName;
    move_uploaded_file($photo['tmp_name'], $filePath);
    
    $insert = mysqli_query($koneksi, "INSERT INTO students (`majors_id`, `user_id`, `gender`, `date_of_birth`, `place_of_birth`, `is_active`, `photo`) VALUES ('$major_id', '$user_id', '$gender', '$date_of_birth', '$place_of_birth', '$status', '$fileName')");
    if ($insert) {
      header("Location: siswa_adm.php?save=berhasil");
    }
    
  }
}

if (isset($_GET['Edit'])) {
  $id = $_GET['Edit'];
  
  $qEdit = mysqli_query($koneksi, "SELECT * FROM students WHERE id = $id");
  $rowUpdate = mysqli_fetch_assoc($qEdit); 
}

if (isset($_POST['edit'])) {
  $id = $_GET['Edit'];
  $major_id = $_POST['majors_id'];
  $user_id = $_POST['user_id'];
  $gender = $_POST['gender'];
  $date_of_birth = $_POST['date_of_birth'];
  $place_of_birth = $_POST['place_of_birth'];
  $status = $_POST['is_active'];
  $photo = $_FILES['photo'];
  
  $fillQupdate = '';
  if ($photo['error'] == 0) {
    $fileName = uniqid() . "_" . basename($photo['name']);
    $filePath = "../assets/uploads/" . $fileName;
    if (move_uploaded_file($photo['tmp_name'], $filePath)){
      $cekFoto = mysqli_query($koneksi, "SELECT photo FROM students WHERE id =$id");
      $fotoLama = mysqli_fetch_assoc($cekFoto);
      if ($fotoLama && file_exists("../assets/uploads/" . $fotoLama['photo'])) {
        unlink("../assets/uploads/" . $fotoLama['photo']);
      }
      $fillQupdate = "photo='$fileName',";
    }else {
      echo "EDIT GAGAL";
    }
  }
  
  $qUpdate = mysqli_query($koneksi, "UPDATE students SET $fillQupdate majors_id='$major_id', user_id='$user_id', gender='$gender', date_of_birth='$date_of_birth', place_of_birth='$place_of_birth', is_active='$status'  WHERE id = $id");
  if ($qUpdate){
    header("Location: siswa_adm.php?update=berhasil");
  }
}

$major = mysqli_query($koneksi, "SELECT * FROM majors ORDER BY id DESC");
$rowMajors = mysqli_fetch_all($major, MYSQLI_ASSOC);

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
  <?php include "../admin/inc/sidebar.php"; ?>
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
              <h5 class="card-title"><?php echo isset($_GET['Edit']) ? 'Edit ' : 'Create New ' .' '?>Siswa</h5>
              <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3 row">
                      <div class="col-sm-3">
                        <label for="">Major</label>
                      </div>
                      <div class="col-sm-6">
                        <select id="majors_id" class="form-control" name="majors_id">
                        <option value="0" hidden>Choose Major</option>
                        <?php foreach ($rowMajors as $rowMajor) { ?>
                          <option value="<?php echo $rowMajor['id']?>"><?php echo $rowMajor['name']?></option>
                        <?php } ?>
                        </select>
                      </div>
                    </div>

                    <div class="mb-3 row">
                      <div class="col-sm-3">
                        <label for="">User</label>
                      </div>
                      <div class="col-sm-6">
                        <select id="user_id" class="form-control" name="user_id">
                        <option value="0" hidden>Choose User</option>
                        <?php foreach ($rowUsers as $rowUser) { ?>
                          <option value="<?php echo $rowUser['id']?>"><?php echo $rowUser['name']?></option>
                        <?php } ?>
                        </select>
                      </div>
                    </div>                 

                    
                    <div class="mb-3 row">
                      <div class="col-sm-3">
                        <label for="">Gender</label>
                      </div>
                      <div class="col-sm-6">
                        <select name="" id="" >
                          <option value="" hidden>Choose</option>
                          <option value="<?php echo isset($_GET['Edit']) ? $rowUpdate['gender'] : '' ?>">Man</option>
                          <option value="0">Woman</option>
                        </select>
                      </div>
                    </div>

                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3 row">
                      <div class="col-sm-3">
                        <label for="">Date of Birth</label>
                      </div>
                      <div class="col-sm-6">
                        <input type="date" class="form-control" name="date_of_birth" required value="<?php echo isset($_GET['Edit']) ? $rowUpdate['date_of_birth'] : '' ?>">
                      </div>
                    </div>

                    <div class="mb-3 row">
                      <div class="col-sm-3">
                        <label for="">Place of Birth</label>
                      </div>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="place_of_birth" placeholder="Input your place of birth" required value="<?php echo isset($_GET['Edit']) ? $rowUpdate['place_of_birth'] : '' ?>">
                      </div>
                    </div>

                    <div class="mb-3 row">
                      <div class="col-sm-3">
                        <label for="">Foto</label>
                      </div>
                      <div class="col-sm-6">
                      <input type="file" class="form-control" name="photo">
                      </div>
                      <?php if (isset($_GET['Edit'])) {
                      ?>
                        <div class="mt-2">
                          <img width="190" src="../assets/uploads/<?= $rowUpdate['photo'] ?>" alt="">
                        </div>
                      <?php
                      }?>
                    </div>

                    <div class="mb-3 row">
                      <div class="col-sm-3">
                        <label for="">Status</label>
                      </div>
                      <div class="col-sm-6">
                      <select name="" id="" >
                          <option value="" hidden>Choose</option>
                          <option value="<?php echo isset($_GET['Edit']) ? $rowUpdate['is_active'] : '' ?>">Active</option>
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