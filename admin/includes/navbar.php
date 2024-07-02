<?php
require 'db_conn.php';
?>
<!-- Sidebar -->
<ul class="navbar-nav bg-info sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin.php">
    <div class="sidebar-brand-icon mb-1 mr-1">
        <i class="fas fa-medkit"></i>
    </div>
    <div class="sidebar-brand-text text-white">
        mothercare
        <br>
        <!-- <sup>Construction</sup> -->
       
    </div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="admin.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Main Menu 
</div>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseinventory"
        aria-expanded="true" aria-controls="collapseinventory">
        <i class="fas fa-fw fa-user-md"></i> 
        <span>Doctors</span>
    </a>
    <div id="collapseinventory" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Options:</h6>
            <a class="collapse-item" href="doctors.php">Manage Doctors</a>
            <a class="collapse-item" href="specialities.php">Doctor Specialitization</a>
        </div>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsepatients"
        aria-expanded="true" aria-controls="collapsepatients">
        <i class="fas fa-fw fa-user-md"></i> 
        <span>Patients</span>
    </a>
    <div id="collapsepatients" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Options:</h6>
            <a class="collapse-item" href="pregnant_patient.php">Pregnant Patients</a>
            <a class="collapse-item" href="patients.php">Manage Users</a>
        </div>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link" href="appointments.php">
        <i class="fas fa-fw fa-stethoscope"></i>
        <span>Appointments</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="medical_records.php">
        <i class="fas fa-fw fa-book"></i>
        <span>Medical records</span></a>
</li>
<div class="sidebar-heading">
    Others
</div>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports"
        aria-expanded="true" aria-controls="collapseReports">
        <i class="fas fa-fw fa-list-alt"></i> 
        <span>Reports</span>
    </a>
    <div id="collapseReports" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Options:</h6>
            <a class="collapse-item" href="patient_report.php">List of Patients</a>
            <a class="collapse-item" href="doctor_report.php">List of Doctors</a>
            <a class="collapse-item" href="pr_report.php">Pregnancy Records</a>
            <a class="collapse-item" href="mr_report.php">Medical Records</a>
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

</li>

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>


</ul>
<!-- End of Sidebar -->

<!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-arrow-up fa-1x"></i>
    </a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-info" href="../index.html">Logout</a>
                </div>
            </div>
        </div>
    </div>  

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column" >

<!-- Main Content -->
<div id="content">
    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-gray-200 topbar mb-4 static-top shadow  text-white">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars text-info"></i>
        </button>

  
        <!-- Topbar Search -->
        <form
            class="d-none d-sm-inline-block form-inline mr-auto ml-md-2 my-2 my-md-0 w-25 navbar-search">
            <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" id="search" onchange= "openPage()"
                 placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
               
                 <script>
                    function openPage(){
                        var x = document.getElementById("search").value;

                        if (x === "tools"){
                            window.open("tools.php");
                        }
                        if (x === "employee"){
                            window.open("employees.php");
                        }
                        if (x === "equipments"){
                            window.open("equipments.php");
                        }
                    }
                </script>
               
                    <div class="input-group-append">
                    <button class="btn btn-info" type="button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw text-gray-600"></i>
                </a>
                <!-- Dropdown - Search -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                    aria-labelledby="searchDropdown">
                    <form class="form-inline mr-auto w-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small"
                                placeholder="Search for..." aria-label="Search"
                                aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-info" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>





            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

    <span class="mr-1 mt-2 d-none d-lg-inline text-info small text-uppercase">
        <?php
            require 'db_conn.php';
            $user_name = mysqli_real_escape_string($conn, $_SESSION['user_name']); // sanitize the input
            $sql = "SELECT firstname, lastname, middlename, image FROM admins WHERE user_name = ?";
            $stmt = mysqli_prepare($conn, $sql); // prepare the statement
            mysqli_stmt_bind_param($stmt, "s", $user_name); // bind the parameter
            mysqli_stmt_execute($stmt); // execute the statement
            $result = mysqli_stmt_get_result($stmt); // get the result set
            if (mysqli_num_rows($result) > 0) { // use a loop to iterate over the result set
                $row = mysqli_fetch_assoc($result);
                echo $row['firstname'] . ' ' . $row['middlename'] . '. ' . $row['lastname'];
            } else {
                echo "User not found";
            }
        ?>
    </span>
    <?php
        if (isset($row['image']) && !empty($row['image'])) {
            $profile_picture = "uploads/" . $row['image'];
        } else {
            $profile_picture = "img/admin.png";
        }
    ?>
    <img src="<?= $profile_picture ?>" alt="Profile Picture" class="img-profile rounded-circle">
</a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="profile.php">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile 
                    </a>
                    <!-- <a class="dropdown-item" href="#">
                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                        Settings
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        Activity Log
                    </a> -->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>

                    
                </div>
            </li>

        </ul>

    </nav>
    <!-- End of Topbar -->


    