<?php

require_once "../koneksi.php";
session_start();

if (empty($_SESSION['EMAIL'])) {
    header("Location: ../login.php");
}

$role = mysqli_query($koneksi, "SELECT * FROM roles ORDER BY id DESC");
$rows = mysqli_fetch_all($role, MYSQLI_ASSOC);

$userRole = mysqli_query($koneksi, "SELECT * FROM user_role");
$rowURoles = mysqli_fetch_all($userRole, MYSQLI_ASSOC);

$user = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");
$rowUsers = mysqli_fetch_all($user, MYSQLI_ASSOC);



if (isset($_POST['save'])) {
    $name_user = $_POST['user_id'];
    $name_role = $_POST['role_id'];


    $insert = mysqli_query($koneksi, "INSERT INTO user_role (user_id, role_id) VALUES ('$name_user', '$name_role')");

    if ($insert) {
        header("Location: user.php");
    } else {
        header("Location: add-roleuser.php");
    }
}


$id = isset($_GET['edit']) ? $_GET['edit'] : '';

$queryEdit = mysqli_query($koneksi, "SELECT * FROM user_role WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

if (isset($_POST['edit'])) {
    $id = $_GET['Edit'];
    $name_user = $_POST['user_id'];
    $name_role = $_POST['role_id'];

    $qUpdate = mysqli_query($koneksi, "UPDATE user_role SET user_id='$name_user', role_id='$name_role' WHERE id = $id");
    if ($qUpdate) {
        header("Location: user.php?berhasil=edit");
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
    <?php include "../inc/sidebar.php"; ?>
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

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3><?php echo isset($_GET['edit']) ? 'Edit' : 'Create New' ?> Role User</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">

                            <div class="mb-3 row">
                                <div class="col-sm-2">
                                    <label for="">User</label>
                                </div>
                                <div class="col-sm-6">
                                    <select id="user_id" class="form-control" name="user_id">
                                        <option value="0" hidden>Choose User</option>
                                        <?php foreach ($rowUsers as $rowUser) { ?>
                                            <option value="<?php echo $rowUser['id'] ?>"><?php echo $rowUser['name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Role Name</label>
                                </div>
                                <div class="col-sm-6">
                                    <select id="roles" class="form-control" name="role_id">
                                        <option value="0" hidden>Choose Role</option>
                                        <?php foreach ($rows as $row) { ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col mb-3">
                                <button class="btn btn-primary" type="submit"
                                    name="<?php echo isset($_GET['Edit']) ? 'Edit' : 'save' ?>">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

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