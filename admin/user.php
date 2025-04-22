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

$user = mysqli_query($koneksi, "SELECT 
    u.id AS user_id,
    u.name AS user_name,
    u.id,
    u.email,
    u.password,
    u.is_active,
    r.name AS role_name

    FROM users AS u
    LEFT JOIN 
        user_role AS ur ON u.id = ur.user_id
    LEFT JOIN
        roles AS r ON ur.role_id = r.id
    ORDER BY 
        u.id DESC");

$rows = mysqli_fetch_all($user, MYSQLI_ASSOC);



// Query untuk mengambil semua roles tetap diperlukan jika anda membutuhkannya untuk keperluan lain di halaman ini

$role = mysqli_query($koneksi, "SELECT * FROM roles");
$rowRoles = mysqli_fetch_all($role, MYSQLI_ASSOC);


if (isset($_GET['idDel'])) {

    $id = $_GET['idDel'];


    $del = mysqli_query($koneksi, "DELETE FROM users WHERE id = $id");
    if ($del) {
        header("Location: user.php");
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

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Data User</h3>
                    </div>
                    <div class="card-body">
                        <div align="right" class="mb-3 mt-3">
                            <a href="edit-user.php" class="btn btn-primary">Create New User</a>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Role</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $row['role_name'] ?></td>
                                        <td><?php echo $row['user_name'] ?></td>
                                        <td><?php echo $row['email'] ?></td>
                                        <td><?php echo $row['password'] ?></td>
                                        <td><?php echo $row['is_active'] ?></td>
                                        <td>
                                            <a href="add-roleUser.php" class="btn btn-primary btn-sm">Add Role</a>
                                            <a href="edit-user.php?Edit=<?php echo $row['id'] ?>"
                                                class="btn btn-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                            <a onclick="return confirm ('Yakin ingin menghapus?')"
                                                href="user.php?idDel=<?php echo $row['id'] ?>"
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