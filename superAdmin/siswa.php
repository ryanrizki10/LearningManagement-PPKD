<?php
/*

$query = mysqli_query($koneksi, "SELECT users.*, levels.level_name FROM users 
LEFT JOIN levels ON levels.id = users.id_level ORDER BY users.id DESC");
$rows  = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM users WHERE id = '$id'");
    header("location:?page=level&notif=success");
}
*/

require_once "../koneksi.php";
session_start();

if (empty($_SESSION['EMAIL'])) {
    header("Location: ../login.php");
}

$queryStudents = mysqli_query($koneksi, "SELECT
    s.id AS student_id,
    m.name AS majors_name,
    u.name AS user_name,
    s.id,
    s.gender,
    s.date_of_birth,
    s.place_of_birth,
    s.photo,
    s.is_active
FROM
    students s
LEFT JOIN
    majors m ON s.majors_id = m.id
LEFT JOIN
    users u ON s.user_id = u.id
ORDER BY
    s.id DESC");

$students = mysqli_fetch_all($queryStudents, MYSQLI_ASSOC);

$major = mysqli_query($koneksi, "SELECT * FROM majors");
$rowMajors = mysqli_fetch_all($major, MYSQLI_ASSOC);

$user = mysqli_query($koneksi, "SELECT * FROM users");
$rowUsers = mysqli_fetch_all($user, MYSQLI_ASSOC);







if (isset($_GET['idDel'])) {
    $id = $_GET['idDel'];


    $cekFOTO = mysqli_query($koneksi, "SELECT photo FROM students WHERE id = $id");
    $rowcekFoto = mysqli_fetch_assoc($cekFOTO);
    if ($rowcekFoto && file_exists("../assets/uploads/" . $fotoLama['photo'])) {
        unlink("../assets/uploads/" . $rowcekFoto['photo']);
        $delete = mysqli_query($koneksi, "DELETE FROM students WHERE id = $id");
        if ($delete) {
            header("Location: siswa.php?delete=berhasil");
        }
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
              <h5 class="card-title">Siswa</h5>
              <div class="table table-responsive">
                <a class="btn btn-primary mb-2" href="edit-siswa.php">CREATE</a>
                <table class="table table-bordered">
                  <tr>
                    <th>No</th>
                    <th>Major</th>
                    <th>User</th>
                    <th>Gender</th>
                    <th>Date of birth</th>
                    <th>Place of birth</th>
                    <th>Photo</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                  <?php
                  $no = 1;
                  foreach ($students as $student) {
                  ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= $student['majors_name'] ?></td>
                      <td><?= $student['user_name'] ?></td>
                      <td><?= $student['gender'] ?></td>
                      <td><?= $student['date_of_birth'] ?></td>
                      <td><?= $student['place_of_birth']?></td>
                      <td><img width="150" src="../assets/uploads/<?= $student['photo'] ?>" alt=""></td>
                      <td><?= $student['is_active'] ?></td>
                      <td><a href="edit-siswa.php?Edit=<?php echo $student['id'] ?>" class="btn btn-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
                      <a onclick="return confirm ('Yakin ingin menghapus?')" href="siswa.php?idDel=<?php echo $student['id'] ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
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