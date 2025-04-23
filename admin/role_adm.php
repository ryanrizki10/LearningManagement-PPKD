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

$role = mysqli_query($koneksi, "SELECT * FROM roles");
$rows = mysqli_fetch_all($role, MYSQLI_ASSOC);

$userRole = mysqli_query($koneksi, "SELECT * FROM user_role");
$rowURoles = mysqli_fetch_all($userRole, MYSQLI_ASSOC);

$user = mysqli_query($koneksi, "SELECT * FROM users");
$rowUsers = mysqli_fetch_all($user, MYSQLI_ASSOC);



if (isset($_GET['idDel'])) {

    $id = $_GET['idDel'];


    $del = mysqli_query($koneksi, "DELETE FROM roles WHERE id = $id");
    if ($del) {
        header("Location: role.php");
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
    <?php include "../admin/inc/sidebar.php"; ?>
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

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Role Data</h3>
                    </div>
                    <div class="card-body">
                        <div align="right" class="mb-3 mt-3">
                            <a href="edit-role.php" class="btn btn-primary">Create</a>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $row['name'] ?></td>
                                        <td><?php echo $row['is_active'] ?></td>
                                        <td>

                                            <a href="edit-user.php?Edit=<?php echo $row['id'] ?>"
                                                class="btn btn-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                            <a onclick="return confirm ('Yakin ingin menghapus?')"
                                                href="role.php?idDel=<?php echo $row['id'] ?>"
                                                class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>

    </main>

    <!-- ======= Footer ======= -->
    <?= include '../inc/footer.php'; ?>


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