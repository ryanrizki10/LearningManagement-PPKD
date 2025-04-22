<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
    
    <aside id="sidebar" class="sidebar">
    
        <ul class="sidebar-nav" id="sidebar-nav">
    
            <li class="nav-item">
                <a class="nav-link collapsed" href="../admin/dashboard.php">
                    <i class="bi bi-grid"></i>
                    <span class="judul">Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->
    
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span class="judul">Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="../admin/user.php">
                            <i class=" bi bi-circle"></i><span>User</span>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/major.php">
                            <i class="bi bi-circle"></i><span>Jurusan</span>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/role.php">
                            <i class="bi bi-circle"></i><span>Role</span>
                        </a>
                    </li>
                    <li>
                        <a href="instruktur.php">
                            <i class="bi bi-circle"></i><span>Instruktur</span>
                        </a>
                    </li>
                    <li>
                        <a href="siswa.php">
                            <i class="bi bi-circle"></i><span>Siswa</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Components Nav -->
    
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-journal-text"></i><span class="judul">Manajemen Modul</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="modul.php">
                            <i class="bi bi-circle"></i><span>Module</span>
                        </a>
                    </li>
                    <li>
                        <a href="modul-detail.php">
                            <i class="bi bi-circle"></i><span>Module Details</span>
                        </a>
                    </li>
                    <li>
                        <a href="modul-siswa.php">
                            <i class="bi bi-circle"></i><span>Module Siswa</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Forms Nav -->
        </ul>
    </aside><!-- End Sidebar-->
</body>
</html>

<style>
    #sidebar {
        background-color: darkblue; /* Set the background color to dark blue */
        color: white; /* Set the text color to white */
    }

    #sidebar a {
        color: white; /* Ensure links are also white */
        text-decoration: none; /* Optional: Remove underline from links */
    }

    #sidebar a:hover {
        color: lightblue; /* Optional: Change link color on hover for better visibility */
    }

    #sidebar i {
        color: black; /* Ensure icons are white */
    }

    #sidebar .judul {
        color: black;

    }

    #sidebar span {
        color: white; /* Ensure spans are white */
    }

</style>
