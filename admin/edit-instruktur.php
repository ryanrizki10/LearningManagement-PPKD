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
  $title = $_POST['title'];
  $gender = $_POST['gender'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];
  $status = $_POST['is_active'];
  $photo = $_FILES['photo'];

  
  
  if ($photo['error'] == 0) {
    $fileName = uniqid() . "_" . basename($photo['name']);
    $filePath = "../assets/uploads/" . $fileName;
    move_uploaded_file($photo['tmp_name'], $filePath);
    
    $insert = mysqli_query($koneksi, "INSERT INTO instructors (`majors_id`, `user_id`, `title`, `gender`, `address`, `phone`, `is_active`, `photo`) VALUES ('$major_id', '$user_id', '$title', '$gender', '$address', '$phone', '$status', '$fileName')");
    if ($insert) {
      header("Location: instruktur.php");
    }
    
  }
}

if (isset($_GET['Edit'])) {
  $id = $_GET['Edit'];
  
  $qEdit = mysqli_query($koneksi, "SELECT * FROM instructors WHERE id = $id");
  $rowUpdate = mysqli_fetch_assoc($qEdit); 
}

if (isset($_POST['edit'])) {
  $id = $_GET['Edit'];
  $major_id = $_POST['majors_id'];
  $user_id = $_POST['user_id'];
  $title = $_POST['title'];
  $gender = $_POST['gender'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];
  $status = $_POST['is_active'];
  $photo = $_FILES['photo'];
  
  $fillQupdate = '';
  if ($photo['error'] == 0) {
    $fileName = uniqid() . "_" . basename($photo['name']);
    $filePath = "../assets/uploads/" . $fileName;
    if (move_uploaded_file($photo['tmp_name'], $filePath)){
      $cekFoto = mysqli_query($koneksi, "SELECT photo FROM instructors WHERE id =$id");
      $fotoLama = mysqli_fetch_assoc($cekFoto);
      if ($fotoLama && file_exists("../assets/uploads/" . $fotoLama['photo'])) {
        unlink("../assets/uploads/" . $fotoLama['photo']);
      }
      $fillQupdate = "photo='$fileName',";
    }else {
      echo "EDIT GAGAL";
    }
  }
  
  $qUpdate = mysqli_query($koneksi, "UPDATE instructors SET $fillQupdate majors_id='$major_id', user_id='$user_id', title='$title', gender='$gender', address='$address', phone='$phone', is_active='$status'  WHERE id = $id");
  if ($qUpdate){
    header("Location: instruktur.php");
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
              <h5 class="card-title"><?php echo isset($_GET['Edit']) ? 'Edit ' : 'Create New ' .' '?>Instruktur</h5>
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
                        <label for="">Title</label>
                      </div>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="title" placeholder="Input your title (ex:S.Kom)" value="<?php echo isset($_GET['Edit']) ? $rowUpdate['title'] : '' ?>">
                      </div>
                    </div>

                    <div class="mb-3 row">
                      <div class="col-sm-3">
                        <label for="">Gender</label>
                      </div>
                      <div class="col-sm-6">
                        <select name="" id="" value="<?php echo isset($_GET['Edit']) ? $rowUpdate['gender'] : '' ?>">
                          <option value="" hidden>Choose</option>
                          <option value="1">Man</option>
                          <option value="0">Woman</option>
                        </select>
                      </div>
                    </div>

                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3 row">
                      <div class="col-sm-3">
                        <label for="">Address</label>
                      </div>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="address" placeholder="Input your address" value="<?php echo isset($_GET['Edit']) ? $rowUpdate['address'] : '' ?>">
                      </div>
                    </div>

                    <div class="mb-3 row">
                      <div class="col-sm-3">
                        <label for="">Phone</label>
                      </div>
                      <div class="col-sm-6">
                        <input type="number" class="form-control" name="phone" placeholder="Input your phone" value="<?php echo isset($_GET['Edit']) ? $rowUpdate['phone'] : '' ?>">
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
                        <select name="is_active" id="" value="<?php echo isset($_GET['Edit']) ? $rowUpdate['is_active'] : '' ?>">
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